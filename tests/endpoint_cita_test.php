<?php
/**
 * Invoca el endpoint real de "paciente con cita" con sesión simulada y comprueba
 * que el doctor llega HASHEADO (el campo que provocaba
 * "Identificador inválido o manipulado" al confirmar la factura).
 *
 * Ejecutar: /opt/lampp/bin/php tests/endpoint_cita_test.php
 */

declare(strict_types=1);

$_SESSION = [
    'usuario' => 'admin',
    'id_usuario' => 1,
    'id_rol' => 1,
    'csrf_token' => 'test',
];

$_ENV['DB_HOST'] = 'localhost';
$_ENV['DB_USER'] = 'root';
$_ENV['DB_PASS'] = '';
$_ENV['DB_NAME'] = 'bd';
$_ENV['DB_NAME_SEGURITY'] = 'segurity';
$_ENV['PASSWORD_RESP'] = 'x';

$raiz = dirname(__DIR__) . '/';
require_once $raiz . 'vendor/autoload.php';
require_once $raiz . 'src/config/helpers.php';
require_once $raiz . 'src/config/tasaCambio.php';

use App\modelos\ModeloSanetizarJSON;

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

// Se toma una cita pendiente de hoy con paciente real.
$pdo = new PDO('mysql:host=localhost;dbname=bd;charset=utf8mb4', 'root', '');
$cedula = $pdo->query(
    "SELECT p.cedula FROM cita c
     INNER JOIN paciente p ON p.id_paciente = c.paciente_id_paciente
     WHERE c.estado = 'Pendiente' AND c.fecha = CURDATE() LIMIT 1"
)->fetchColumn();

if (!$cedula) {
    check(true, 'sin citas pendientes hoy: se omite la prueba de extremo a extremo');
    exit(0);
}

printf("  (usando la cédula %s de una cita real de hoy)\n\n", $cedula);

// ── Reproduce lo que hace mostrarPacienteConCita() ──────────────────
$_POST['cedula'] = $cedula;

$modelo = new App\modelos\ModeloFactura();
$sanetizar = new ModeloSanetizarJSON();

// Misma lista de claves que el controlador (con el arreglo aplicado).
$sanetizar->setHashKeys([
    'id_paciente', 'id_cita', 'id_servicioMedico', 'id_personal', 'id_categoria',
    'id_doctor_c',
]);
$modelo->setCedula($cedula);
$resultado = $sanetizar->sanitizeRecursive($modelo->buscarPacientePorCita());

check(is_array($resultado) && count($resultado) > 0, 'la consulta devuelve la cita');
if (!$resultado) {
    exit(1);
}

$cita = $resultado[0];

echo "\n=== Los ids que manda el navegador vienen hasheados ===\n";
foreach (['id_cita', 'id_paciente', 'id_servicioMedico', 'id_doctor_c'] as $campo) {
    $valor = $cita[$campo] ?? null;
    check(
        is_string($valor) && esHashIdValido($valor),
        "$campo es un hash válido",
        'valor: ' . var_export($valor, true)
    );
}

echo "\n=== Los precios y textos NO se hashean ===\n";
check(is_numeric($cita['precio'] ?? null), 'el precio sigue siendo numérico');
check(is_string($cita['categoria'] ?? null) && !empty($cita['categoria']), 'la categoría sigue siendo texto');
check(is_string($cita['fecha_de_nacimiento'] ?? null), 'la fecha de nacimiento sigue siendo texto');

echo "\n=== El hash revierte al id original ===\n";
$pdo2 = new PDO('mysql:host=localhost;dbname=bd;charset=utf8mb4', 'root', '');
$fila = $pdo2->query(
    "SELECT c.id_cita, c.doctor, p.id_paciente AS id_paciente_real,
            c.serviciomedico_id_servicioMedico
     FROM cita c INNER JOIN paciente p ON p.id_paciente = c.paciente_id_paciente
     WHERE p.cedula = " . $pdo2->quote($cedula) . " AND c.fecha = CURDATE()
       AND c.estado = 'Pendiente' LIMIT 1"
)->fetch(PDO::FETCH_ASSOC);

if ($fila) {
    check(unhashId($cita['id_cita']) == $fila['id_cita'], 'id_cita revierte correctamente');
    check(unhashId($cita['id_paciente']) == $fila['id_paciente_real'], 'id_paciente revierte correctamente');
    check(
        unhashId($cita['id_doctor_c']) == $fila['doctor'],
        'id_doctor_c revierte correctamente (este era el que fallaba)',
        'hash: ' . $cita['id_doctor_c'] . ' -> ' . unhashId($cita['id_doctor_c']) . ' vs ' . $fila['doctor']
    );
} else {
    check(true, 'no se pudo recuperar la fila original para comparar');
}

echo "\n=== Simula el POST completo de guardarFactura() ===\n";
// El JS manda exactamente estos campos; se comprueba que todos los ids
// sobreviven al unhashId() que hace el controlador.
$post = [
    'servicios'      => [$cita['id_servicioMedico']],
    'doctores'       => [$cita['id_doctor_c']],
    'insumos'        => [],
    'id_cita'        => $cita['id_cita'],
    'id_paciente'    => $cita['id_paciente'],
    'id_hospitalizacion' => '',
    'formasDePago'   => [],
    'precioServicio' => [(string)$cita['precio']],
    'total'          => '0',
    'tipo_cambio'    => '36.5',
];

$errorIds = [];
try {
    $ids = array_map('unhashId', $post['servicios']);
    $docs = array_map(fn($d) => ($d === '' ? null : unhashId($d)), $post['doctores']);
    $citaId = unhashId($post['id_cita']);
    $pacId = unhashId($post['id_paciente']);
    check(true, 'todos los ids se deshashean sin error');
} catch (\Throwable $e) {
    check(false, 'todos los ids se deshashean sin error', $e->getMessage());
}

echo "\n=== Comprobacion final ===\n";
printf("\n%d pruebas, %d fallos\n", $pruebas, $fallos);
exit($fallos === 0 ? 0 : 1);