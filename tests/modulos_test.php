<?php
/**
 * Suite de pruebas para los módulos de PROVEEDORES, ENTRADA e INSUMOS
 * (incluye verificación del INVENTARIO).
 *
 * Ejecuta la lógica real de los modelos contra la base de datos y valida la
 * coherencia del inventario (vista view_resumen_insumos vs. lotes reales).
 * Las pruebas de escritura limpian todo lo que crean: nunca deben quedar datos.
 *
 * Ejecutar: /opt/lampp/bin/php tests/modulos_test.php
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

use App\modelos\ModeloProveedores;
use App\modelos\ModeloEntrada;
use App\modelos\ModeloInsumo;

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

/** Ejecuta un cierre capturando excepciones: devuelve [valor, excepcion]. */
function callf(callable $fn): array
{
    try {
        return [$fn(), null];
    } catch (\Throwable $e) {
        return [null, $e];
    }
}
/** "valor" legible para el detalle de un fallo. */
function vshow($v, ?\Throwable $e): string
{
    if ($e !== null) {
        return 'excepción: ' . substr($e->getMessage(), 0, 140);
    }
    if (is_string($v)) {
        return substr($v, 0, 140);
    }
    return gettype($v);
}

$prov = $pdo->query("SELECT id_proveedor, rif FROM proveedor WHERE estado='ACT' ORDER BY id_proveedor LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$idProv = (int)($prov['id_proveedor'] ?? 0);
$insumo = $pdo->query("SELECT id_insumo FROM insumo WHERE estado='ACT' ORDER BY id_insumo LIMIT 1")->fetch(PDO::FETCH_ASSOC);

echo "\n══════════════════════════════════════════════════";
echo "\n MÓDULO PROVEEDORES";
echo "\n══════════════════════════════════════════════════\n";

$mp = new ModeloProveedores();

[$lista, $e] = callf(fn() => $mp->consultar(0, 10, '', 'id_proveedor', 'DESC'));
check(is_array($lista), 'consultar() devuelve un listado (sin búsqueda)', vshow($lista, $e));

[$busq, $e] = callf(fn() => $mp->consultar(0, 10, 'Juan', 'nombre', 'DESC'));
check(is_array($busq), 'consultar() con búsqueda por texto NO falla', vshow($busq, $e));

[$bc, $e] = callf(fn() => $mp->contarTotalProveedores('ACT', 'Juan'));
check($e === null && is_int($bc), 'contarTotalProveedores(ACT, buscar) no lanza excepción', vshow($bc, $e));

[$pap, $e] = callf(fn() => $mp->papeleraConsultar(0, 10, 'Juan', 'id_proveedor', 'DESC'));
check(is_array($pap), 'papeleraConsultar() con búsqueda NO falla', vshow($pap, $e));

[$act, $e] = callf(fn() => $mp->contarTotalProveedores('ACT'));
check($e === null && is_int($act), 'contarTotalProveedores(ACT) es entero', vshow($act, $e));

[$papb, $e] = callf(fn() => $mp->contarTotalProveedores('DES', 'Juan'));
check($e === null && is_int($papb), 'contarTotalProveedores(DES, buscar) no lanza', vshow($papb, $e));

// INSERT válido + Rif duplicado
$rifTest = 'V' . random_int(1000000, 9999999);
$idCreado = null;
[$r, $e] = callf(function () use ($mp, $rifTest) {
    $mp->setNombre('Proveedor Test');
    $mp->setRif($rifTest);
    $mp->setTelefono('04121338909');
    $mp->setEmail('prov.test@example.com');
    $mp->setDireccion('Direccion de prueba 123');
    return $mp->guardarEntrada(1);
});
check($e === null && is_array($r) && $r[0] === 'exito', 'guardarEntrada() inserta un proveedor válido', vshow($r, $e));
$idCreado = (int)$pdo->query("SELECT id_proveedor FROM proveedor WHERE rif = " . $pdo->quote($rifTest))->fetchColumn();
check($idCreado > 0, 'el proveedor quedó en la base');

[$rd, $e] = callf(function () use ($rifTest) {
    $m = new ModeloProveedores();
    $m->setNombre('Duplicado Rif');
    $m->setRif($rifTest);
    $m->setTelefono('04124466999');
    $m->setEmail('dup@example.com');
    $m->setDireccion('Otra direccion 456');
    return $m->guardarEntrada(1);
});
check(!($e === null && is_array($rd) && $rd[0] === 'exito'), 'rechaza un Rif duplicado', vshow($rd, $e));

// Validaciones de campos
[, $e] = callf(fn() => (new ModeloProveedores())->setTelefono('123'));
check($e !== null, 'rechaza teléfono inválido', $e ? '' : 'aceptó 123');
[, $e] = callf(fn() => (new ModeloProveedores())->setEmail('no-es-correo'));
check($e !== null, 'rechaza correo inválido', $e ? '' : 'aceptó texto sin @');
[, $e] = callf(fn() => (new ModeloProveedores())->setNombre('abc'));
check($e !== null, 'rechaza nombre sin mayúscula inicial');

// Editar + Rif duplicado por otro
if ($idCreado && $prov) {
    [$re, $e] = callf(function () use ($idCreado, $rifTest) {
        $m = new ModeloProveedores();
        $m->setIdProveedor($idCreado);
        $m->setNombre('Proveedor Editado');
        $m->setRif($rifTest);
        $m->setTelefono('04124466999');
        $m->setEmail('editado@example.com');
        $m->setDireccion('Direccion editada 789');
        $m->setRifRegistrado($rifTest);
        return $m->editarEntrada(1);
    });
    check($e === null && is_array($re) && $re[0] === 'exito', 'editarEntrada() modifica manteniendo el Rif', vshow($re, $e));

    [$rd2, $e] = callf(function () use ($idCreado, $prov) {
        $m = new ModeloProveedores();
        $m->setIdProveedor($idCreado);
        $m->setNombre('Proveedor Editado');
        $m->setRif($prov['rif']); // rif de otro proveedor
        $m->setTelefono('04124466999');
        $m->setEmail('editado2@example.com');
        $m->setDireccion('Direccion editada 789');
        $m->setRifRegistrado('');
        return $m->editarEntrada(1);
    });
    check(!($e === null && is_array($rd2) && $rd2[0] === 'exito'), 'rechaza cambiar a un Rif de otro proveedor', vshow($rd2, $e));
}

// Eliminación lógica + restablecer
if ($idCreado) {
    [$x, $e] = callf(function () use ($idCreado) {
        $m = new ModeloProveedores();
        $m->setIdProveedor($idCreado);
        return $m->deleteEntrada(1, 'DES');
    });
    check($e === null && is_array($x) && $x[0] === 'exito', 'deleteEntrada(DES) elimina lógicamente', vshow($x, $e));
    [$x, $e] = callf(function () use ($idCreado) {
        $m = new ModeloProveedores();
        $m->setIdProveedor($idCreado);
        return $m->deleteEntrada(1, 'ACT');
    });
    check($e === null && is_array($x) && $x[0] === 'exito', 'deleteEntrada(ACT) restablece', vshow($x, $e));
}
$pdo->prepare("DELETE FROM proveedor WHERE nombre IN ('Proveedor Test','Proveedor Editado','Duplicado Rif')")->execute();

echo "\n══════════════════════════════════════════════════";
echo "\n MÓDULO ENTRADA";
echo "\n══════════════════════════════════════════════════\n";

$me = new ModeloEntrada();

[$lent, $e] = callf(fn() => $me->todasLasEntradas(0, 10, '', 'id_entrada', 'DESC'));
check(is_array($lent), 'todasLasEntradas() devuelve listado', vshow($lent, $e));

[$bent, $e] = callf(fn() => $me->todasLasEntradas(0, 10, 'a', 'id_entrada', 'DESC'));
check(is_array($bent), 'todasLasEntradas() con búsqueda NO falla', vshow($bent, $e));

[$cent, $e] = callf(fn() => $me->contarTotalEntradas('ACT', 'a'));
check($e === null && is_int($cent), 'contarTotalEntradas(ACT, buscar) no lanza', vshow($cent, $e));

[$ofe, $e] = callf(fn() => $me->todasLasEntradas(0, 10, '', 'fechDeIngreso', 'ASC'));
check(is_array($ofe), 'todasLasEntradas() tolera la columna mal escrita fechDeIngreso', vshow($ofe, $e));

[$ofe2, $e] = callf(fn() => $me->todasLasEntradas(0, 10, '', 'fechaDeIngreso', 'ASC'));
check(is_array($ofe2), 'todasLasEntradas() ordena por fechaDeIngreso', vshow($ofe2, $e));

$ins = $me->insumos();
check(is_array($ins) && $ins !== [], 'insumos() (activos) devuelve datos');
$prvs = $me->selectProveedores();
check(is_array($prvs) && $prvs !== [], 'selectProveedores() devuelve datos');

[, $e] = callf(fn() => (new ModeloEntrada())->setPrecio('0.50'));
check($e === null, 'setPrecio(0.50) se acepta (precio < 1)', $e ? $e->getMessage() : 'rechazado');

// INSERT real vía procedure
if ($insumo && $idProv) {
    $lote = (string)random_int(100000, 999999);
    [$rg, $e] = callf(function () use ($insumo, $idProv, $lote) {
        $m = new ModeloEntrada();
        $m->setIdInsumo((int)$insumo['id_insumo']);
        $m->setLote($lote);
        $m->setIdProveedor($idProv);
        $m->setFechaDeIngreso(date('Y-m-d'));
        $m->setFechaDeVencimiento(date('Y-m-d', strtotime('+365 day')));
        $m->setCantidadDisponible(7);
        $m->setPrecio('12.50');
        return $m->guardarEntrada(1);
    });
    check($e === null && is_array($rg) && $rg[0] === 'exito', 'guardarEntrada() inserta (procedure insert_entrada)', vshow($rg, $e));

    // Localiza la fila por el lote único (AUTO_INCREMENT puede haberse adelantado por borrados previos).
    $idEnt = (int)$pdo->query("SELECT id_entrada FROM entrada WHERE numero_de_lote = " . $pdo->quote($lote))->fetchColumn();
    $row = $pdo->query("SELECT cantidad_entrante, cantidad_disponible FROM entrada_insumo WHERE id_entrada = $idEnt")->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        check((int)$row['cantidad_entrante'] === 7 && (int)$row['cantidad_disponible'] === 7, 'cantidad_entrante = cantidad_disponible = 7', json_encode($row));
    } else {
        check(false, 'se creó la fila entrada_insumo');
    }
    // Limpieza
    $pdo->prepare("DELETE FROM entrada_insumo WHERE id_entrada = ?")->execute([$idEnt]);
    $pdo->prepare("DELETE FROM entrada WHERE id_entrada = ?")->execute([$idEnt]);
}

echo "\n══════════════════════════════════════════════════";
echo "\n MÓDULO INSUMOS";
echo "\n══════════════════════════════════════════════════\n";

$mi = new ModeloInsumo();

[$li, $e] = callf(fn() => $mi->insumos());
check(is_array($li), 'insumos() devuelve el resumen', vshow($li, $e));

[$ven, $e] = callf(fn() => $mi->InsumosVencidos(0, 10, '', 'id_entrada', 'DESC'));
check(is_array($ven), 'InsumosVencidos() devuelve listado (sin búsqueda)', vshow($ven, $e));

[$vengb, $e] = callf(fn() => $mi->InsumosVencidos(0, 10, 'a', 'id_entrada', 'DESC'));
check(is_array($vengb), 'InsumosVencidos() con búsqueda NO falla', vshow($vengb, $e));

[$venc, $e] = callf(fn() => $mi->contarTotalInsumosVencidos('a'));
check($e === null && is_int($venc), 'contarTotalInsumosVencidos(buscar) no lanza', vshow($venc, $e));

[$venty, $e] = callf(fn() => $mi->InsumosVencidos(0, 10, '', 'fechDeIngreso', 'ASC'));
check(is_array($venty), 'InsumosVencidos() tolera orden por fechDeIngreso (typo)', vshow($venty, $e));

[$papI, $e] = callf(fn() => $mi->papelera(0, 10, '', 'id_insumo', 'DESC'));
check(is_array($papI), 'papelera() devuelve listado', vshow($papI, $e));

[$totI, $e] = callf(fn() => $mi->contarTotal('a'));
check($e === null && is_int($totI), 'contarTotal(buscar) no lanza', vshow($totI, $e));

[$rv, $e] = callf(fn() => $mi->vencerInsumos(1));
$roto = is_string($rv) && (stripos((string)$rv, 'inventario') !== false || stripos((string)$rv, 'exist') !== false || stripos((string)$rv, 'SQLSTATE') !== false || stripos((string)$rv, 'Base table or view') !== false);
check($e === null && !$roto, 'vencerInsumos() no ejecuta UPDATE sobre la tabla inexistente "inventario"', vshow($rv, $e));

echo "\n══════════════════════════════════════════════════";
echo "\n INVENTARIO (coherencia de stock)";
echo "\n══════════════════════════════════════════════════\n";

$desfase = (int)$pdo->query(
    "SELECT COUNT(*) FROM (
        SELECT i.id_insumo,
               COALESCE(SUM(CASE WHEN ei.fechaDeVencimiento > CURDATE() AND e.estado='ACT'
                                  THEN ei.cantidad_disponible ELSE 0 END),0) AS lotes
        FROM insumo i
        LEFT JOIN entrada_insumo ei ON ei.id_insumo = i.id_insumo
        LEFT JOIN entrada e ON e.id_entrada = ei.id_entrada
        WHERE i.estado='ACT'
        GROUP BY i.id_insumo
     ) x
     JOIN view_resumen_insumos v ON v.id_insumo = x.id_insumo
     WHERE v.disponible <> x.lotes"
)->fetchColumn();
check($desfase === 0, "el 'disponible' de la vista == suma de lotes vigentes ($desfase diferencias)");

$neg = (int)$pdo->query("SELECT COUNT(*) FROM entrada_insumo WHERE cantidad_disponible < 0")->fetchColumn();
check($neg === 0, "no hay lotes con cantidad_disponible negativa ($neg)");

if ($insumo) {
    $idIns = (int)$insumo['id_insumo'];
    try {
        $pdo->beginTransaction();
        $antesVista = (float)$pdo->query("SELECT COALESCE((SELECT disponible FROM view_resumen_insumos WHERE id_insumo = $idIns),0)")->fetchColumn();
        $antesLotes = (int)$pdo->query("SELECT COALESCE(SUM(ei.cantidad_disponible),0)
            FROM entrada_insumo ei JOIN entrada e ON e.id_entrada=ei.id_entrada
            WHERE ei.id_insumo=$idIns AND e.estado='ACT' AND ei.fechaDeVencimiento>CURDATE()")->fetchColumn();
        $pdo->prepare("UPDATE entrada SET estado='DES' WHERE id_entrada IN (SELECT id_entrada FROM entrada_insumo WHERE id_insumo=?)")->execute([$idIns]);
        $despuesVista = (float)$pdo->query("SELECT COALESCE((SELECT disponible FROM view_resumen_insumos WHERE id_insumo = $idIns),0)")->fetchColumn();
        check($antesVista === (float)$antesLotes, "antes: vista($antesVista) == lotes($antesLotes)");
        check($despuesVista === 0.0, "al desactivar las entradas el disponible en la vista baja a 0", "quedó $despuesVista");
        $pdo->rollBack();
        $back = (float)$pdo->query("SELECT COALESCE((SELECT disponible FROM view_resumen_insumos WHERE id_insumo = $idIns),0)")->fetchColumn();
        check($back === $antesVista, "tras rollback el stock vuelve a su valor", "antes=$antesVista ahora=$back");
    } catch (\Throwable $e) {
        $pdo->rollBack();
        check(false, 'inventario ↔ estado de entrada sin excepciones', $e->getMessage());
    }
}

$vencInfo = (int)$pdo->query(
    "SELECT COALESCE(SUM(ei.cantidad_disponible),0)
     FROM entrada_insumo ei JOIN entrada e ON e.id_entrada=ei.id_entrada
     WHERE ei.fechaDeVencimiento <= CURDATE() AND e.estado='ACT'"
)->fetchColumn();
printf("  info: %d unidades en lotes VENCIDOS (no vendibles, excluidos de la vista)\n", $vencInfo);

echo "\n══════════════════════════════════════════════════";
echo "\n Comprobacion final";
echo "\n══════════════════════════════════════════════════";
printf("\n%d pruebas, %d fallos\n", $pruebas, $fallos);
exit($fallos === 0 ? 0 : 1);
