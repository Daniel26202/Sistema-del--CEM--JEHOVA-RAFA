<?php
/**
 * Verifica el contrato de identificadores entre el navegador y el servidor.
 *
 * Error que previene: "Identificador inválido o manipulado."
 *   El navegador manda los ids en servicios[], doctores[], insumos[], id_cita,
 *   id_paciente, id_cliente, id_hospitalizacion, formasDePago[]. El controlador
 *   hace unhashId() de todos, así que cada endpoint que alimenta esos campos
 *   debe devolver el id HASHEADO (setHashKeys).
 *
 * El bug real: buscarPacientePorCita() aliasa el doctor como `id_doctor_c`
 * mientras setHashKeys() solo enumeraba `id_personal`, así que ese campo viajaba
 * crudo y unhashId() lanzaba al confirmar la factura.
 *
 * Ejecutar: /opt/lampp/bin/php tests/ids_test.php
 */

declare(strict_types=1);

$raiz = dirname(__DIR__) . '/';
require_once $raiz . 'vendor/autoload.php';
require_once $raiz . 'src/config/helpers.php';

$ctrl   = file_get_contents($raiz . 'src/controllers/ControllerFactura.php');
$modelo = file_get_contents($raiz . 'src/modelos/ModeloFactura.php');

$fallos = 0;
$pruebas = 0;

function check(bool $ok, string $mensaje, string $detalle = ''): void
{
    global $fallos, $pruebas;
    $pruebas++;
    if ($ok) {
        printf("  ok: %s\n", $mensaje);
    } else {
        $fallos++;
        printf("  FALLO: %s%s\n", $mensaje, $detalle ? " — $detalle" : '');
    }
}

/** Quita comentarios para poder parsear el código de verdad. */
function sinComentarios(string $codigo): string
{
    $codigo = preg_replace('#//[^\r\n]*#', '', $codigo);
    $codigo = preg_replace('#/\*.*?\*/#s', '', $codigo);
    return $codigo;
}

/** Claves de hashKeys dentro de una función del controlador. */
function hashKeysDe(string $ctrlSinComentarios, string $funcion): array
{
    $ini = strpos($ctrlSinComentarios, "function $funcion(");
    if ($ini === false) {
        return [];
    }
    $bloque = substr($ctrlSinComentarios, $ini, 3000);
    if (!preg_match('/setHashKeys\(\[(.*?)\]/s', $bloque, $m)) {
        return [];
    }
    return array_values(array_filter(array_map(
        static fn($k) => trim($k, " \t\n\r'\""),
        explode(',', $m[1])
    ), static fn($k) => $k !== ''));
}

$ctrlLimpio = sinComentarios($ctrl);

echo "\n=== Cada endpoint hashea los ids que el JS manda ===\n";

$esperado = [
    'mostrarServicios'      => ['id_servicioMedico', 'id_personal'],
    'mostrarPacienteConCita' => ['id_cita', 'id_paciente', 'id_servicioMedico', 'id_doctor_c'],
    'mostrarPaciente'       => ['id_paciente'],
    'mostrarCliente'        => ['id_cliente'],
    'mostrarMetodosDePago'  => ['id_pago'],
    'mostrarInsumos'        => ['id_insumo'],
    'datosHospitalizacion'  => ['id_hospitalizacion', 'id_paciente', 'id_doctor', 'id_entradaDeInsumo'],
];

foreach ($esperado as $funcion => $claves) {
    $reales = hashKeysDe($ctrlLimpio, $funcion);
    $faltan = array_diff($claves, $reales);

    check(
        empty($faltan),
        "$funcion(): hashea " . implode(', ', $claves),
        'faltan: ' . implode(', ', $faltan) . ' | tiene: ' . implode(', ', $reales)
    );
}

echo "\n=== El bug concreto: el doctor de la cita ===\n";
$clavesCita = hashKeysDe($ctrlLimpio, 'mostrarPacienteConCita');
check(in_array('id_doctor_c', $clavesCita, true),
    'id_doctor_c está hasheado (el alias del modelo)',
    'claves: ' . implode(', ', $clavesCita));

// La consulta debe seguir produciendo ese alias.
check(
    preg_match('/c\.doctor\s+as\s+id_doctor_c/i', $modelo) === 1,
    'buscarPacientePorCita() sigue devolviendo id_doctor_c'
);

echo "\n=== Todos los alias numéricos del modelo están cubiertos ===\n";
preg_match_all('/\bas\s+(id_\w+)/i', $modelo, $m);
$alias = array_unique($m[1]);

$cubiertos = [];
foreach (array_keys($esperado) as $fn) {
    foreach (hashKeysDe($ctrlLimpio, $fn) as $k) {
        $cubiertos[$k] = $fn;
    }
}
foreach ($alias as $a) {
    check(
        isset($cubiertos[$a]),
        "el alias '$a' se hashea en algún endpoint",
        'lo cubre: ' . ($cubiertos[$a] ?? 'NADIE')
    );
}

echo "\n=== unhashId() sigue rechazando lo que no es hash ===\n";
check(!esHashIdValido('25'), "un id crudo ('25') se rechaza");
check(!esHashIdValido(''), "un id vacío se rechaza");
check(!esHashIdValido('no-es-un-hash'), "texto arbitrario se rechaza");

$hash = hashId(42);
check(esHashIdValido($hash), "un hash real se acepta");
check(unhashId($hash) === 42, 'unhashId revierte hashId');

echo "\n=== El controlador avisa en vez de reventar ===\n";
check(
    substr_count($ctrl, 'catch (\Throwable $e)') >= 1,
    'guardarFactura captura los errores de identificador'
);

echo "\n=== Comprobacion final ===\n";
printf("\n%d pruebas, %d fallos\n", $pruebas, $fallos);
exit($fallos === 0 ? 0 : 1);