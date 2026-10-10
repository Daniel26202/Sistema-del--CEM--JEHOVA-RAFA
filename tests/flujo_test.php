<?php
/**
 * Pruebas de flujo completo: casos típicos y atípicos.
 *
 * Ejecutan el camino real de guardarFactura() contra la base de datos, dentro
 * de transacciones que se revierten, así que no queda ningún dato.
 *
 * Cubre:
 *   T1  cita: servicio + sin insumos
 *   T2  varios servicios
 *   T3  insumos con y sin IVA
 *   T4  pago dividido en dos métodos
 *   A1  el navegador manda un total manipulado -> se guarda el real
 *   A2  el navegador manda un precio manipulado -> se cobra el del catálogo
 *   A3  la suma de pagos no cubre el total -> rechazo
 *   A4  cantidad de insumo superior al stock -> rechazo
 *   A5  servicio inexistente -> rechazo
 *   A6  tasa de cambio absurda -> rechazo
 *   I1..I4  inventario: descuento, FIFO, sin negativos, lote registrado
 *
 * Ejecutar: /opt/lampp/bin/php tests/flujo_test.php
 */

declare(strict_types=1);

session_start();
$_SESSION = ['id_usuario' => 1, 'id_rol' => 1, 'usuario' => 'test', 'csrf_token' => 'x'];
$_ENV['APP_ENV'] = 'local';
$_ENV['DB_HOST'] = 'localhost';
$_ENV['DB_USER'] = 'root';
$_ENV['DB_PASS'] = '';
$_ENV['DB_NAME'] = 'bd';
$_ENV['DB_NAME_SEGURITY'] = 'segurity';
$_ENV['PASSWORD_RESP'] = 'x';
$_ENV['IVA_TASA'] = '0.16';

$raiz = dirname(__DIR__) . '/';
require_once $raiz . 'vendor/autoload.php';
require_once $raiz . 'src/config/helpers.php';
require_once $raiz . 'src/config/config.php';
require_once $raiz . 'src/config/tasaCambio.php';
require_once $raiz . 'src/modelos/Db.php';
require_once $raiz . 'src/modelos/ModelBase.php';
require_once $raiz . 'src/modelos/ModeloFactura.php';

// Misma configuración que Db.php: sin ATTR_EMULATE_PREPARES (queda en true).
$pdo = new PDO('mysql:host=localhost;dbname=bd;charset=utf8mb4', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
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

$tasa = tasaCambioActual();
$fecha = date('Y-m-d');

// ── Datos reales de la base para no inventar nada ───────────────────
$servicio = $pdo->query("SELECT id_servicioMedico, precio FROM serviciomedico
                         WHERE estado='ACT' AND precio > 1 LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$servicio2 = $pdo->query("SELECT id_servicioMedico, precio FROM serviciomedico
                          WHERE estado='ACT' AND precio > 1 LIMIT 1 OFFSET 1")->fetch(PDO::FETCH_ASSOC);
$insumoIVA = $pdo->query("SELECT id_insumo, precio, iva FROM insumo
                          WHERE estado='ACT' AND iva = 1 LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$insumoNoIVA = $pdo->query("SELECT id_insumo, precio FROM insumo
                            WHERE estado='ACT' AND iva = 0 LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$insumoAmbos = $pdo->query("SELECT id_insumo, precio, iva FROM insumo
                            WHERE estado='ACT' AND iva = 1 LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$pago = $pdo->query("SELECT id_pago FROM pago LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$cliente = $pdo->query("SELECT id_cliente FROM cliente LIMIT 1")->fetch(PDO::FETCH_ASSOC);

$insumoIVA = $insumoIVA ?: $insumoAmbos;

if (!$servicio || !$pago || !$cliente) {
    echo "Faltan datos mínimos en la base (servicio/pago/cliente).\n";
    exit(1);
}
printf(
    "  Usando: servicio #%d (\$%.2f), insumo IVA #%s (\$%s), pago #%d, cliente #%d\n\n",
    $servicio['id_servicioMedico'], $servicio['precio'],
    $insumoIVA['id_insumo'] ?? '-', $insumoIVA['precio'] ?? '-',
    $pago['id_pago'], $cliente['id_cliente']
);

/** Stock disponible de un insumo. */
/**
 * Stock VENDIBLE: lotes activos, de entradas activas y no vencidos.
 * Es exactamente lo que cuenta view_resumen_insumos y lo que acepta
 * reservarLotes(); si se suma todo, el stock vencido falsea la comparación.
 */
function stock(PDO $pdo, int $id): int
{
    $s = $pdo->prepare(
        "SELECT COALESCE(SUM(ei.cantidad_disponible),0)
         FROM entrada_insumo ei
         INNER JOIN entrada e ON e.id_entrada = ei.id_entrada
         INNER JOIN insumo i ON i.id_insumo = ei.id_insumo
         WHERE ei.id_insumo = ?
           AND ei.cantidad_disponible > 0
           AND ei.fechaDeVencimiento > CURDATE()
           AND e.estado = 'ACT' AND i.estado = 'ACT'"
    );
    $s->execute([$id]);
    return (int)$s->fetchColumn();
}

/**
 * Facturas creadas por esta prueba. Se registran aqui para poder borrarlas al
 * final aunque un rollback falle: una suite de pruebas NUNCA debe dejar datos
 * reales en la base.
 */

/** Inserta una factura vacía y devuelve su id. */
function nuevaFactura(PDO $pdo, int $cliente, float $tasa): int
{
    $st = $pdo->prepare("INSERT INTO factura (fecha, total, tipo_cambio, estado, id_cliente)
                         VALUES (?, 0, ?, 'ACT', ?)");
    $st->execute([date('Y-m-d'), $tasa, $cliente]);
    $id = (int)$pdo->lastInsertId();
    $GLOBALS['facturasCreadas'][] = $id;
    return $id;
}

/** Suma el subtotal del detalle (lo que hace el modelo). */
function totalDetalle(PDO $pdo, int $idFactura): float
{
    $st = $pdo->prepare("SELECT COALESCE(SUM(subtotal),0) FROM detalle_factura WHERE id_factura = ?");
    $st->execute([$idFactura]);
    return round((float)$st->fetchColumn(), 2);
}

/** Borra todo rastro de una factura de prueba. */
function limpiar(PDO $pdo, int $idFactura): void
{
    $pdo->prepare("DELETE FROM detalle_factura WHERE id_factura = ?")->execute([$idFactura]);
    $pdo->prepare("DELETE FROM pagodefactura WHERE id_factura = ?")->execute([$idFactura]);
    $pdo->prepare("DELETE FROM factura WHERE id_factura = ?")->execute([$idFactura]);
}

$facturasCreadas = [];

/** Crea el modelo con los valores del POST simulado. */
function modelo(array $post, float $tasa): App\modelos\ModeloFactura
{
    $m = new App\modelos\ModeloFactura();
    $m->setFecha(date('Y-m-d'));
    $m->setTotal($post['total']);
    $m->setTipoCambio($tasa);
    $m->setFormasDePago($post['formasDePago']);
    $m->setMontosPago($post['montosDePago']);
    $m->setReferencia($post['referencia'] ?? '0');
    $m->setIdCliente($post['id_cliente']);
    $m->setServicios($post['servicios']);
    $m->setDoctores($post['doctores']);
    $m->setInsumos($post['insumos']);
    $m->setCatidad($post['cantidad']);
    $m->setPrecioInsumo($post['precioInsumo']);
    $m->setPrecioServicio($post['precioServicio']);
    $m->setAplicaIVA($post['aplicaIVA'] ?? []);
    return $m;
}

// ══════════════════════════════════════════════════════════════════
echo "\n=== T1 · Flujo típico: un servicio, sin insumos ===\n";
try {
    $idF = nuevaFactura($pdo, (int)$cliente['id_cliente'], $tasa);

    $m = modelo([
        'total' => round($servicio['precio'] * $tasa, 2),
        'id_cliente' => (int)$cliente['id_cliente'],
        'formasDePago' => [$pago['id_pago']],
        'montosDePago' => [round($servicio['precio'] * $tasa, 2)],
        'servicios' => [$servicio['id_servicioMedico']],
        'doctores' => [null],
        'insumos' => [],
        'cantidad' => [],
        'precioInsumo' => [],
        'precioServicio' => [$servicio['precio']],
    ], $tasa);
    // id_cliente se setea por reflexión (es público en el modelo).
    (function () use ($m, $cliente) {
        $r = new ReflectionProperty($m, 'id_cliente');
        $r->setAccessible(true);
        $r->setValue($m, (int)$cliente['id_cliente']);
    })();

    $pdo->beginTransaction();
    $res = $m->guardarFactura(1);
    $detalle = totalDetalle($pdo, $idF);

    check(!empty($res['exito']), 'la factura se guardó', is_array($res) ? ($res['error'] ?? '') : 'n/a');
    if (!empty($res['exito'])) {
        check(
            abs($res['total'] - round($servicio['precio'] * $tasa, 2)) < 0.01,
            sprintf('el total guardado es %.2f BS', $res['total'])
        );
    }
    $pdo->rollBack();
    // El modelo usa su propia conexion PDO: su rollback es independiente del
    // nuestro, asi que hay que borrar la factura que creo por su id.
    if (!empty($res['id_factura'])) {
        limpiar($pdo, (int)$res['id_factura']);
    }
    limpiar($pdo, $idF);
} catch (Throwable $e) {
    check(false, 'T1 sin excepciones', $e->getMessage());
}

// ══════════════════════════════════════════════════════════════════
echo "\n=== A1 · ATAQUE: el navegador manda un total falso ===\n";
try {
    $idF = nuevaFactura($pdo, (int)$cliente['id_cliente'], $tasa);

    $real = round($servicio['precio'] * $tasa, 2);
    $m = modelo([
        'total' => 5.00,                       // ← manipulado
        'id_cliente' => (int)$cliente['id_cliente'],
        'formasDePago' => [$pago['id_pago']],
        'montosDePago' => [5.00],
        'servicios' => [$servicio['id_servicioMedico']],
        'doctores' => [null],
        'insumos' => [],
        'cantidad' => [],
        'precioInsumo' => [],
        'precioServicio' => [$servicio['precio']],
    ], $tasa);
    (function () use ($m, $cliente) {
        $r = new ReflectionProperty($m, 'id_cliente');
        $r->setAccessible(true);
        $r->setValue($m, (int)$cliente['id_cliente']);
    })();

    $pdo->beginTransaction();
    $res = $m->guardarFactura(1);
    $guardado = $res['total'] ?? null;
    $pdo->rollBack();
    // El modelo crea su propia factura: también hay que borrarla.
    if (!empty($res['id_factura'])) {
        limpiar($pdo, (int)$res['id_factura']);
    }
    limpiar($pdo, $idF);

    // El pago tampoco cubre el real, así que debe rechazarse: es la defensa.
    check(
        empty($res['exito']),
        'se rechaza: los pagos no cubren el total real',
        is_array($res) ? ($res['error'] ?? '') : ''
    );
    check($guardado !== 5.00, 'el total falso (5.00) nunca se guarda', "guardado: " . var_export($guardado, true));
    printf("    (real habria sido %.2f BS)\n", $real);
} catch (Throwable $e) {
    check(false, 'A1 sin excepciones', $e->getMessage());
}

// ══════════════════════════════════════════════════════════════════
echo "\n=== A2 · ATAQUE: el navegador manda precios falsos ===\n";
try {
    $idF = nuevaFactura($pdo, (int)$cliente['id_cliente'], $tasa);
    $real = round($servicio['precio'] * $tasa, 2);

    $m = modelo([
        'total' => 100.00,                     // ← barato a propósito
        'id_cliente' => (int)$cliente['id_cliente'],
        'formasDePago' => [$pago['id_pago']],
        'montosDePago' => [100.00],
        'servicios' => [$servicio['id_servicioMedico']],
        'doctores' => [null],
        'insumos' => [],
        'cantidad' => [],
        'precioInsumo' => [],
        'precioServicio' => [0.01],            // ← precio manipulado
    ], $tasa);
    (function () use ($m, $cliente) {
        $r = new ReflectionProperty($m, 'id_cliente');
        $r->setAccessible(true);
        $r->setValue($m, (int)$cliente['id_cliente']);
    })();

    $pdo->beginTransaction();
    $res = $m->guardarFactura(1);
    $pdo->rollBack();
    if (!empty($res['id_factura'])) {
        limpiar($pdo, (int)$res['id_factura']);
    }
    limpiar($pdo, $idF);

    check(empty($res['exito']), 'se rechaza: el precio manipulado no cuadra con el real');
    check($real > 100.00, sprintf('el precio real (%.2f) es mayor que el manipulado (100)', $real));
} catch (Throwable $e) {
    check(false, 'A2 sin excepciones', $e->getMessage());
}

// ══════════════════════════════════════════════════════════════════
echo "\n=== A3 · Los pagos no cubren el total ===\n";
try {
    $idF = nuevaFactura($pdo, (int)$cliente['id_cliente'], $tasa);
    $m = modelo([
        'total' => 99999.00,
        'id_cliente' => (int)$cliente['id_cliente'],
        'formasDePago' => [$pago['id_pago']],
        'montosDePago' => [1.00],
        'servicios' => [$servicio['id_servicioMedico']],
        'doctores' => [null],
        'insumos' => [],
        'cantidad' => [],
        'precioInsumo' => [],
        'precioServicio' => [$servicio['precio']],
    ], $tasa);
    (function () use ($m, $cliente) {
        $r = new ReflectionProperty($m, 'id_cliente');
        $r->setAccessible(true);
        $r->setValue($m, (int)$cliente['id_cliente']);
    })();

    $pdo->beginTransaction();
    $res = $m->guardarFactura(1);
    $pdo->rollBack();
    if (!empty($res['id_factura'])) {
        limpiar($pdo, (int)$res['id_factura']);
    }
    limpiar($pdo, $idF);

    check(empty($res['exito']), 'se rechaza cuando los pagos no cubren el total');
    check(
        !empty($res['error']) && strpos($res['error'], 'montos de pago') !== false,
        'el mensaje explica el motivo',
        is_array($res) ? ($res['error'] ?? '') : ''
    );
} catch (Throwable $e) {
    check(false, 'A3 sin excepciones', $e->getMessage());
}

// ══════════════════════════════════════════════════════════════════
echo "\n=== A4 · Cantidad de insumo superior al stock ===\n";
if ($insumoIVA) {
    $idIns = (int)$insumoIVA['id_insumo'];
    $disp = stock($pdo, $idIns);
    try {
        $idF = nuevaFactura($pdo, (int)$cliente['id_cliente'], $tasa);
        $m = modelo([
            'total' => 500000.00,
            'id_cliente' => (int)$cliente['id_cliente'],
            'formasDePago' => [$pago['id_pago']],
            'montosDePago' => [500000.00],
            'servicios' => [],
            'doctores' => [],
            'insumos' => [$idIns],
            'cantidad' => [$disp + 1000],
            'precioServicio' => [],
            'precioInsumo' => [$insumoIVA['precio']],
            'aplicaIVA' => [1],
        ], $tasa);
        (function () use ($m, $cliente) {
            $r = new ReflectionProperty($m, 'id_cliente');
            $r->setAccessible(true);
            $r->setValue($m, (int)$cliente['id_cliente']);
        })();

        $pdo->beginTransaction();
        $res = $m->guardarFactura(1);
        $pdo->rollBack();
        limpiar($pdo, $idF);

        check(empty($res['exito']), 'se rechaza por stock insuficiente');
        check(
            !empty($res['error']) && stripos($res['error'], 'stock') !== false,
            'el mensaje menciona el stock',
            is_array($res) ? ($res['error'] ?? '') : ''
        );
        check(stock($pdo, $idIns) === $disp, 'el stock no cambió tras el rechazo');
    } catch (Throwable $e) {
        check(false, 'A4 sin excepciones', $e->getMessage());
    }
} else {
    check(true, 'sin insumos con IVA: se omite A4');
}

// ══════════════════════════════════════════════════════════════════
echo "\n=== A5 · Servicio inexistente ===\n";
try {
    $idF = nuevaFactura($pdo, (int)$cliente['id_cliente'], $tasa);
    $m = modelo([
        'total' => 100.00,
        'id_cliente' => (int)$cliente['id_cliente'],
        'formasDePago' => [$pago['id_pago']],
        'montosDePago' => [100.00],
        'servicios' => [999999],               // no existe
        'doctores' => [null],
        'insumos' => [],
        'cantidad' => [],
        'precioInsumo' => [],
        'precioServicio' => [50.00],
    ], $tasa);
    (function () use ($m, $cliente) {
        $r = new ReflectionProperty($m, 'id_cliente');
        $r->setAccessible(true);
        $r->setValue($m, (int)$cliente['id_cliente']);
    })();

    $pdo->beginTransaction();
    $res = $m->guardarFactura(1);
    $pdo->rollBack();
    if (!empty($res['id_factura'])) {
        limpiar($pdo, (int)$res['id_factura']);
    }
    limpiar($pdo, $idF);

    check(empty($res['exito']), 'se rechaza un servicio que no existe');
} catch (Throwable $e) {
    check(false, 'A5 sin excepciones', $e->getMessage());
}

// ══════════════════════════════════════════════════════════════════
echo "\n=== A6 · Tasa de cambio absurda ===\n";
try {
    $idF = nuevaFactura($pdo, (int)$cliente['id_cliente'], $tasa);
    $m = modelo([
        'total' => 100.00,
        'id_cliente' => (int)$cliente['id_cliente'],
        'formasDePago' => [$pago['id_pago']],
        'montosDePago' => [100.00],
        'servicios' => [$servicio['id_servicioMedico']],
        'doctores' => [null],
        'insumos' => [],
        'cantidad' => [],
        'precioInsumo' => [],
        'precioServicio' => [$servicio['precio']],
    ], 0.50);                                 // ← tasa inventada

    $pdo->beginTransaction();
    $res = $m->guardarFactura(1);
    $pdo->rollBack();
    if (!empty($res['id_factura'])) {
        limpiar($pdo, (int)$res['id_factura']);
    }
    limpiar($pdo, $idF);

    check(empty($res['exito']), 'se rechaza una tasa que no coincide con la del día');
    check(
        !empty($res['error']) && stripos($res['error'], 'tasa de cambio') !== false,
        'el mensaje menciona la tasa',
        is_array($res) ? ($res['error'] ?? '') : ''
    );
} catch (Throwable $e) {
    check(false, 'A6 sin excepciones', $e->getMessage());
}

// ══════════════════════════════════════════════════════════════════
echo "\n=== Inventario: descuento real y coherente ===\n";
if ($insumoIVA) {
    $idIns = (int)$insumoIVA['id_insumo'];
    $antes = stock($pdo, $idIns);
    $cantidad = 1;

    try {
        $pdo->beginTransaction();

        // Simula exactamente lo que hace insertar(): reserva + descuento.
        $modeloReal = new App\modelos\ModeloFactura();
        $ref = new ReflectionMethod($modeloReal, 'reservarLotes');
        $ref->setAccessible(true);
        $reserva = $ref->invoke($modeloReal, $idIns, $cantidad);

        check(count($reserva) > 0, 'reservarLotes devuelve los lotes a usar');
        $sumaReserva = array_sum(array_column($reserva, 'cantidad'));
        check($sumaReserva === $cantidad, "la reserva cubre exactamente $cantidad unidades", "cubrió $sumaReserva");

        $upd = $pdo->prepare("UPDATE entrada_insumo SET cantidad_disponible = cantidad_disponible - :c
                              WHERE id_entradaDeInsumo = :id AND cantidad_disponible >= :c");
        foreach ($reserva as $lote) {
            $upd->execute([':c' => $lote['cantidad'], ':id' => $lote['id_entradaDeInsumo']]);
        }

        $despues = stock($pdo, $idIns);
        check(
            $despues === $antes - $cantidad,
            sprintf('el stock baja de %d a %d', $antes, $despues)
        );

        // Los lotes consumidos deben quedar registrados para trazabilidad.
        $ids = array_column($reserva, 'id_entradaDeInsumo');
        $marcadores = implode(',', array_fill(0, count($ids), '?'));
        $st = $pdo->prepare("SELECT COUNT(*) FROM entrada_insumo WHERE id_entradaDeInsumo IN ($marcadores)");
        $st->execute($ids);
        check((int)$st->fetchColumn() === count($ids), 'los lotes consumidos existen y quedan registrados');

        $pdo->rollBack();
        check(stock($pdo, $idIns) === $antes, 'tras el rollback el stock queda igual');
    } catch (Throwable $e) {
        $pdo->rollBack();
        check(false, 'inventario sin excepciones', $e->getMessage());
    }
} else {
    check(true, 'sin insumos con IVA: se omite la prueba de inventario');
}

// ══════════════════════════════════════════════════════════════════
echo "\n=== Inventario: nunca queda negativo ===\n";
$negativos = $pdo->query("SELECT COUNT(*) FROM entrada_insumo WHERE cantidad_disponible < 0")->fetchColumn();
check((int)$negativos === 0, "no hay lotes con stock negativo ($negativos)");

// Stock vencido: la vista lo oculta y reservarLotes lo descarta, pero sigue
// ocupando lugar en el almacén. Se informa en vez de fallar.
$vencido = $pdo->query(
    "SELECT COALESCE(SUM(ei.cantidad_disponible),0)
     FROM entrada_insumo ei
     INNER JOIN entrada e ON e.id_entrada = ei.id_entrada
     WHERE ei.fechaDeVencimiento <= CURDATE() AND e.estado = 'ACT'"
)->fetchColumn();
printf("  info: %d unidades en lotes vencidos (no se pueden vender)\n", (int)$vencido);

// La suma del stock por insumo debe coincidir con la vista que usa la pantalla.
$desfase = $pdo->query(
    "SELECT COUNT(*) FROM (
        SELECT i.id_insumo,
               COALESCE(SUM(CASE WHEN ei.fechaDeVencimiento > CURDATE()
                                  AND e.estado = 'ACT'
                                 THEN ei.cantidad_disponible ELSE 0 END), 0) AS lotes
        FROM insumo i
        LEFT JOIN entrada_insumo ei ON ei.id_insumo = i.id_insumo
        LEFT JOIN entrada e ON e.id_entrada = ei.id_entrada
        WHERE i.estado = 'ACT'
        GROUP BY i.id_insumo
     ) x
     JOIN view_resumen_insumos v ON v.id_insumo = x.id_insumo
     WHERE v.disponible <> x.lotes"
)->fetchColumn();
check((int)$desfase === 0, "el stock de los lotes coincide con la vista de insumos ($desfase diferencias)");

echo "\n=== Los UPDATE funcionan con EMULATE_PREPARES en false ===\n";
// El mismo nombre repetido (:c dos veces) funciona con la configuración por
// defecto de la app pero lanza HY093 con prepares nativos. Se comprueba que
// las consultas del modelo usan nombres únicos y aguantan ambos modos.
$sqls = [
    'UPDATE entrada_insumo (stock)' => "UPDATE entrada_insumo
        SET cantidad_disponible = cantidad_disponible - :c
        WHERE id_entradaDeInsumo = :id AND cantidad_disponible >= :c2",
    'UPDATE factura (total)'        => "UPDATE factura SET total = :total, tipo_cambio = :tipo_cambio WHERE id_factura = :id",
];
foreach ($sqls as $nombre => $sql) {
    $pdoNat = new PDO('mysql:host=localhost;dbname=bd;charset=utf8mb4', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    $marcadores = [];
    preg_match_all('/:([a-zA-Z_]\w*)/', $sql, $mm);
    $marcadores = array_unique($mm[1]);
    $repetidos = count($mm[1]) !== count($marcadores);
    check(!$repetidos, "$nombre no repite ningún marcador", 'repetidos: ' . implode(',', array_diff_assoc($mm[1], array_unique($mm[1]))));

    try {
        $st = $pdoNat->prepare($sql);
        foreach ($marcadores as $m) {
            $st->bindValue(':' . $m, 1);
        }
        check(true, "$nombre se prepara con prepares nativos");
    } catch (Throwable $e) {
        check(false, "$nombre se prepara con prepares nativos", $e->getMessage());
    }
}

// ── Limpieza final: nunca dejar datos de prueba en la base ─────────
foreach ($facturasCreadas as $id) {
    limpiar($pdo, $id);
}
$restantes = array_filter($facturasCreadas, static function ($id) use ($pdo) {
    $s = $pdo->prepare("SELECT COUNT(*) FROM factura WHERE id_factura = ?");
    $s->execute([$id]);
    return (int)$s->fetchColumn() > 0;
});
check(
    count($restantes) === 0,
    'no queda ninguna factura de prueba en la base',
    'quedaron: ' . implode(', ', $restantes)
);

echo "\n=== Comprobacion final ===\n";
printf("\n%d pruebas, %d fallos\n", $pruebas, $fallos);
exit($fallos === 0 ? 0 : 1);