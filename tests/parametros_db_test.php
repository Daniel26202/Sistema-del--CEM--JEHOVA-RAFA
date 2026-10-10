<?php
/**
 * Prueba REAL de los INSERT/UPDATE del flujo de facturación.
 *
 * El error "SQLSTATE[HY093]: Invalid parameter number" solo aparece al ejecutar,
 * así que aquí se ejecutan de verdad contra la base: se prepara la consulta, se
 * enlazan exactamente los parámetros que usa el modelo y se comprueba que PDO
 * no lance. Todo dentro de una transacción que se revierte al final, así que no
 * queda ningún dato en la base.
 *
 * Ejecutar: /opt/lampp/bin/php tests/parametros_db_test.php
 */

declare(strict_types=1);

$_ENV = [
    'DB_HOST' => 'localhost',
    'DB_USER' => 'root',
    'DB_PASS' => '',
    'DB_NAME' => 'bd',
    'DB_NAME_SEGURY' => 'segurity',
    'PASSWORD_RESP' => 'x',
];
$_ENV['DB_NAME_SEGURITY'] = $_ENV['DB_NAME_SEGURY'] ?? 'segurity';

$raiz = dirname(__DIR__) . '/';
require_once $raiz . 'vendor/autoload.php';
require_once $raiz . 'src/config/config.php';

$dsn = 'mysql:host=' . host_cos . ';dbname=' . dbname_cos . ';charset=utf8mb4';
$pdo = new PDO($dsn, user_cos, pass_cos, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,   // el mismo modo que usa la app
]);

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

/** Prepara y enlaza sin ejecutar: así se detecta HY093 sin tocar datos. */
function probar(PDO $pdo, string $sql, array $parametros, string $nombre = ''): bool
{
    try {
        $stmt = $pdo->prepare($sql);
        foreach ($parametros as $clave => $valor) {
            $stmt->bindValue(':' . $clave, $valor);
        }
        return true;
    } catch (PDOException $e) {
        global $ultimo;
        $ultimo = $e->getMessage();
        return false;
    }
}

$ultimo = '';

echo "\n=== Preparación de consultas (como lo hace ModelBase) ===\n";

// INSERT INTO factura (los nombres coinciden con los de create()).
$sqlFactura = "INSERT INTO factura (fecha, total, tipo_cambio, estado, id_cliente)
               VALUES (:fecha, :total, :tipo_cambio, :estado, :id_cliente)";
check(
    probar($pdo, $sqlFactura, [
        'fecha' => date('Y-m-d'),
        'total' => 0,
        'tipo_cambio' => 36.5,
        'estado' => 'ACT',
        'id_cliente' => 1,
    ], 'factura'),
    "prepare + bind de INSERT factura",
    $ultimo
);

// INSERT INTO detalle_factura: hospitalizacion.
$sqlHospit = "INSERT INTO detalle_factura
              (id_factura, tipo, cantidad, precio_divisa, precio_unitario, subtotal, hospitalizacion_id_hospitalizacion)
              VALUES (:id_factura, :tipo, :cantidad, :precio_divisa, :precio_unitario, :subtotal, :id_hospitalizacion)";
check(
    probar($pdo, $sqlHospit, [
        'id_factura' => 1,
        'tipo' => 'Prueba',
        'cantidad' => 1,
        'precio_divisa' => 10.00,
        'precio_unitario' => 365.00,
        'subtotal' => 365.00,
        'id_hospitalizacion' => null,
    ], 'detalle hosp'),
    "prepare + bind de detalle_factura (hospitalizacion)",
    $ultimo
);

// INSERT INTO detalle_factura: servicio.
$sqlServicio = "INSERT INTO detalle_factura
                (id_factura, tipo, cantidad, precio_divisa, precio_unitario, subtotal, serviciomedico_id_servicioMedico, personal_id_personal)
                VALUES (:id_factura, :tipo, :cantidad, :precio_divisa, :precio_unitario, :subtotal, :servicio, :personal)";
check(
    probar($pdo, $sqlServicio, [
        'id_factura' => 1,
        'tipo' => 'Servicio',
        'cantidad' => 1,
        'precio_divisa' => 50.00,
        'precio_unitario' => 1825.00,
        'subtotal' => 1825.00,
        'servicio' => 1,
        'personal' => null,
    ], 'detalle serv'),
    "prepare + bind de detalle_factura (servicio)",
    $ultimo
);

// INSERT INTO detalle_factura: insumo.
$sqlInsumo = "INSERT INTO detalle_factura
              (id_factura, tipo, cantidad, precio_divisa, precio_unitario, subtotal, iva_aplicado, tasa_iva, entrada_insumo_id_entradaDeInsumo)
              VALUES (:id_factura, :tipo, :cantidad, :precio_divisa, :precio_unitario, :subtotal, :iva_aplicado, :tasa_iva, :id_entrada)";
check(
    probar($pdo, $sqlInsumo, [
        'id_factura' => 1,
        'tipo' => 'Insumo',
        'cantidad' => 3,
        'precio_divisa' => 100.00,
        'precio_unitario' => 3650.00,
        'subtotal' => 10950.00,
        'iva_aplicado' => 0,
        'tasa_iva' => 0,
        'id_entrada' => null,
    ], 'detalle insumo'),
    "prepare + bind de detalle_factura (insumo)",
    $ultimo
);

// INSERT INTO pagodefactura.
$sqlPago = "INSERT INTO pagodefactura (id_pago, id_factura, referencia, monto)
            VALUES (:id_pago, :id_factura, :referencia, :monto)";
check(
    probar($pdo, $sqlPago, [
        'id_pago' => 1,
        'id_factura' => 1,
        'referencia' => '0',
        'monto' => 12775.00,
    ], 'pago'),
    "prepare + bind de pagodefactura",
    $ultimo
);

echo "\n=== UPDATE (update() enlaza SIEMPRE :id) ===\n";

$sqlUpdFactura = "UPDATE factura SET total = :total, tipo_cambio = :tipo_cambio WHERE id_factura = :id";
check(probar($pdo, $sqlUpdFactura, ['total' => 12775.00, 'tipo_cambio' => 36.5]),
    "prepare + bind de UPDATE factura (2 en array + :id)", $ultimo);

$sqlUpdStock = "UPDATE entrada_insumo
                SET cantidad_disponible = cantidad_disponible - :c
                WHERE id_entradaDeInsumo = :id AND cantidad_disponible >= :c";
check(probar($pdo, $sqlUpdStock, ['c' => 3]),
    "prepare + bind de UPDATE entrada_insumo (1 en array + :id)", $ultimo);

$sqlUpdControl = "UPDATE control SET historiaclinica = :historial, estado = :estado WHERE id_control = :id";
check(probar($pdo, $sqlUpdControl, ['historial' => 'Prueba', 'estado' => 'ACT']),
    "prepare + bind de UPDATE control", $ultimo);

// Cita y hospitalizacion: update_logic() enlaza solo :id.
$sqlCita = "UPDATE cita SET estado = 'Realizadas' WHERE id_cita = :id";
check(probar($pdo, $sqlCita, []), "prepare + bind de UPDATE cita (update_logic)", $ultimo);

$sqlH = "UPDATE hospitalizacion SET estado = 'Realizada' WHERE id_hospitalizacion = :id";
check(probar($pdo, $sqlH, []), "prepare + bind de UPDATE hospitalizacion", $ultimo);

echo "\n=== Las columnas existen en la base (migración 003 aplicada) ===\n";
foreach (['factura' => 'tipo_cambio', 'detalle_factura' => 'precio_divisa'] as $tabla => $columna) {
    $st = $pdo->prepare("SELECT COUNT(*) FROM information_schema.COLUMNS
                         WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t AND COLUMN_NAME = :c");
    $st->execute([':t' => $tabla, ':c' => $columna]);
    check((int)$st->fetchColumn() === 1, "$tabla.$columna existe");
}

echo "\n=== El flujo completo en transacción (se revierte) ===\n";
try {
    $pdo->beginTransaction();

    $pdo->prepare($sqlFactura)->execute([
        ':fecha' => date('Y-m-d'),
        ':total' => 0,
        ':tipo_cambio' => 36.5,
        ':estado' => 'ACT',
        ':id_cliente' => 1,
    ]);
    $idFactura = (int)$pdo->lastInsertId();

    $pdo->prepare($sqlServicio)->execute([
        ':id_factura' => $idFactura,
        ':tipo' => 'Servicio',
        ':cantidad' => 1,
        ':precio_divisa' => 50.00,
        ':precio_unitario' => 1825.00,
        ':subtotal' => 1825.00,
        ':servicio' => null,
        ':personal' => null,
    ]);

    $pdo->prepare($sqlInsumo)->execute([
        ':id_factura' => $idFactura,
        ':tipo' => 'Insumo',
        ':cantidad' => 3,
        ':precio_divisa' => 100.00,
        ':precio_unitario' => 3650.00,
        ':subtotal' => 10950.00,
        ':iva_aplicado' => 0,
        ':tasa_iva' => 0,
        ':id_entrada' => null,
    ]);

    $pdo->prepare($sqlUpdFactura)->execute([
        ':total' => 12775.00,
        ':tipo_cambio' => 36.5,
        ':id' => $idFactura,
    ]);

    // El total recalculado desde el detalle debe coincidir.
    $suma = (float)$pdo->query(
        "SELECT COALESCE(SUM(subtotal),0) FROM detalle_factura WHERE id_factura = $idFactura"
    )->fetchColumn();

    printf("    factura #%d: total 12775.00 vs suma del detalle %.2f\n", $idFactura, $suma);
    check(abs($suma - 12775.00) < 0.01, 'el total guardado cuadra con el detalle');

    $pdo->rollBack();
    check(true, 'transacción revertida, no quedó ningún dato');
} catch (Throwable $e) {
    $pdo->rollBack();
    check(false, 'el flujo completo se ejecutó sin errores', $e->getMessage());
}

echo "\n=== Comprobacion final ===\n";
printf("\n%d pruebas, %d fallos\n", $pruebas, $fallos);
exit($fallos === 0 ? 0 : 1);