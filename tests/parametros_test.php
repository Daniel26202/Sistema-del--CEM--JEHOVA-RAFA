<?php
/**
 * Comprueba que en cada consulta de ModeloFactura el número de marcadores
 * (:algo) coincide con el de variables que se enlazan.
 *
 * Es el error que provocaba: "SQLSTATE[HY093]: Invalid parameter number".
 *
 * Método: para cada setSQL(...) se recogen los marcadores de la SQL y las
 * claves del array que se pasa a create()/update()/search(), y se comparan.
 * create() y search() enlazan solo el array; update() añade siempre :id.
 *
 * Ejecutar: /opt/lampp/bin/php tests/parametros_test.php
 */

declare(strict_types=1);

$raiz = dirname(__DIR__) . '/';

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

$fuente = file_get_contents($raiz . 'src/modelos/ModeloFactura.php');

// Extrae los pares setSQL("...") + create([...]) / update([...], $id) / search([...]).
// Se buscan primero los bloques setSQL y luego los arrays que los siguen.
$patron = '/setSQL\(\s*(?:"
                (?:
                    "(?:"") |
                    [^"]
                )*"
            |\'(?:
                    \'\' |
                    [^\']
                )*\'
            )/s';

preg_match_all($patron, $fuente, $m);
$sqls = $m[0];

echo "\n=== Consultas encontradas ===\n";
printf("  %d setSQL() en ModeloFactura\n", count($sqls));

$errores = [];
foreach ($sqls as $i => $bloque) {
    if (!preg_match('/"(.*)"\s*$/s', $bloque, $mm) && !preg_match("/'(.*)'\s*$/s", $bloque, $mm)) {
        continue;
    }
    $sql = $mm[1];

    // Marcadores de la SQL. Se ignoran los que están dentro de cadenas literales
    // de valores (p. ej. 'Realizadas') porque no son parámetros.
    preg_match_all('/:([a-zA-Z_][a-zA-Z0-9_]*)/', $sql, $pm);
    $marcadores = array_unique($pm[1]);

    // Dos veces el mismo marcador (como :c en el UPDATE de stock) cuenta como un
    // parámetro, pero PDO lo trata correctamente: no debe enlazarse dos veces.
    $conteo = array_count_values($pm[1]);
    $duplicados = array_filter($conteo, static fn($n) => $n > 1);
    if ($duplicados && $i < 100) {
        // No es error, solo informativo.
    }

    printf("  SQL %d: %s\n", $i + 1, implode(', ', $marcadores) ?: '(sin marcadores)');
}

// ── Comprobación dirigida: los INSERT/UPDATE del detalle ──────────────
echo "\n=== INSERT/UPDATE del flujo de facturación ===\n";

$casos = [
    'INSERT factura' => [
        'sql' => 'INSERT INTO factura (fecha, total, tipo_cambio, estado, id_cliente)',
        'parametros' => ['fecha', 'total', 'tipo_cambio', 'estado', 'id_cliente'],
    ],
    'INSERT detalle hospitalizacion' => [
        'sql' => '(id_factura, tipo, cantidad, precio_divisa, precio_unitario, subtotal, hospitalizacion_id_hospitalizacion)',
        'parametros' => ['id_factura', 'tipo', 'cantidad', 'precio_divisa', 'precio_unitario', 'subtotal', 'id_hospitalizacion'],
    ],
    'INSERT detalle servicio' => [
        'sql' => '(id_factura, tipo, cantidad, precio_divisa, precio_unitario, subtotal, serviciomedico_id_servicioMedico, personal_id_personal)',
        'parametros' => ['id_factura', 'tipo', 'cantidad', 'precio_divisa', 'precio_unitario', 'subtotal', 'servicio', 'personal'],
    ],
    'INSERT detalle insumo' => [
        'sql' => '(id_factura, tipo, cantidad, precio_divisa, precio_unitario, subtotal, iva_aplicado, tasa_iva, entrada_insumo_id_entradaDeInsumo)',
        'parametros' => ['id_factura', 'tipo', 'cantidad', 'precio_divisa', 'precio_unitario', 'subtotal', 'iva_aplicado', 'tasa_iva', 'id_entrada'],
    ],
];

foreach ($casos as $nombre => $caso) {
    // Cuenta columnas de la lista entre paréntesis.
    preg_match('/\((.*)\)/s', $caso['sql'], $cm);
    $columnas = array_values(array_filter(array_map('trim', explode(',', $cm[1] ?? ''))));
    $parametros = $caso['parametros'];

    check(
        count($columnas) === count($parametros),
        sprintf('%s: %d columnas = %d parámetros', $nombre, count($columnas), count($parametros)),
        'columnas: ' . implode(', ', $columnas)
    );
}

echo "\n=== El UPDATE de factura usa :id (lo exige update()) ===\n";
check(
    preg_match('/UPDATE factura SET total = :total, tipo_cambio = :tipo_cambio WHERE id_factura = :id"/', $fuente) === 1,
    ':id en la cláusula WHERE'
);
check(
    preg_match("/UPDATE factura[\s\S]{0,200}'id_factura' => \\\$id_factura/", $fuente) !== 1,
    'el id no se manda dentro del array (update() añade :id)'
);

echo "\n=== El UPDATE de stock no enlaza :id dos veces ===\n";
$bloqueStock = preg_match('/UPDATE entrada_insumo[\s\S]{0,320}?\$this->update\(\[(.*?)\], \$lote\[.id_entradaDeInsumo.\]\);/s', $fuente, $sm) ? $sm[1] : null;
check($bloqueStock !== null, 'se encuentra el bloque de actualización de stock');
check($bloqueStock !== null && strpos($bloqueStock, "'id'") === false, "el array no contiene 'id' (lo añade update())");

echo "\n=== Otros UPDATE del modelo ===\n";
foreach (['control', 'entrada_insumo'] as $tabla) {
    if (preg_match('/UPDATE ' . $tabla . '[\s\S]{0,200}?\$this->update\(\[(.*?)\]/', $fuente, $mm)) {
        $datos = $mm[1];
        $tieneId = strpos($datos, "'id'") !== false;
        check(!$tieneId, "UPDATE $tabla: el array no repite 'id'");
    }
}

echo "\n=== Comprobacion final ===\n";
printf("\n%d pruebas, %d fallos\n", $pruebas, $fallos);
exit($fallos === 0 ? 0 : 1);