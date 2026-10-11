<?php
/**
 * Pruebas de los módulos de CONTROL e INVENTARIO (Insumos / Entradas).
 *
 * Ejecutan el camino real de los modelos contra la base de datos y TODO dato
 * creado se borra al final (una suite de pruebas nunca debe dejar datos).
 *
 * Ejecutar: /opt/lampp/bin/php tests/control_inventario_test.php
 */

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION = ['id_usuario' => 1, 'id_rol' => 1, 'usuario' => 'test'];

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
require_once $raiz . 'src/modelos/Db.php';
require_once $raiz . 'src/modelos/ModelBase.php';
require_once $raiz . 'src/modelos/ModeloControl.php';
require_once $raiz . 'src/modelos/ModeloSintomas.php';
require_once $raiz . 'src/modelos/ModeloInsumo.php';
require_once $raiz . 'src/modelos/ModeloEntrada.php';
require_once $raiz . 'src/modelos/ModeloPatologia.php';
require_once $raiz . 'src/modelos/ModeloPerfil.php';

use App\modelos\ModeloControl;
use App\modelos\ModeloSintomas;
use App\modelos\ModeloInsumo;
use App\modelos\ModeloEntrada;

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

/** Ejecuta un callback y devuelve [resultado, excepcion?]. */
function intenta(callable $fn): array
{
    try {
        return [$fn(), null];
    } catch (\Throwable $e) {
        return [null, $e];
    }
}

$hoy = date('Y-m-d');
$manana = date('Y-m-d', strtotime('+1 day'));
$marcador = 'ZZTESTHARNESS';

// ── Datos reales de la base ──────────────────────────────────────────
$paciente = $pdo->query("SELECT id_paciente, cedula FROM paciente WHERE estado='ACT' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$doctor   = $pdo->query("SELECT u.id_usuario FROM segurity.usuario u LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$sintoma  = $pdo->query("SELECT id_sintomas FROM sintomas WHERE estado='ACT' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$patologia = $pdo->query("SELECT id_patologia FROM patologia LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$insumo   = $pdo->query("SELECT id_insumo FROM insumo WHERE estado='ACT' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$proveedor = $pdo->query("SELECT id_proveedor FROM proveedor WHERE estado='ACT' LIMIT 1")->fetch(PDO::FETCH_ASSOC);

if (!$paciente || !$doctor || !$sintoma || !$patologia) {
    echo "Faltan datos mínimos en la base (paciente/usuario/sintoma/patologia).\n";
    exit(1);
}
printf("  Usando: paciente #%d, usuario #%d, síntoma #%d, patología #%d, insumo #%d\n\n",
    $paciente['id_paciente'], $doctor['id_usuario'], $sintoma['id_sintomas'],
    $patologia['id_patologia'], $insumo['id_insumo'] ?? 0);

function limpiarControl(PDO $pdo, string $marcador): void
{
    $ids = $pdo->prepare("SELECT id_control FROM control WHERE historiaclinica LIKE :m");
    $ids->execute([':m' => "%$marcador%"]);
    foreach ($ids->fetchAll(PDO::FETCH_COLUMN) as $id) {
        $pdo->prepare("DELETE FROM sintomas_control WHERE id_control = ?")->execute([$id]);
        $pdo->prepare("DELETE FROM control WHERE id_control = ?")->execute([$id]);
    }
    // Patologías de prueba registradas hoy por el harness
    $pdo->prepare("DELETE FROM patologiadepaciente WHERE fecha_registro = CURDATE() AND id_paciente NOT IN (
        SELECT id_paciente FROM control WHERE fecha_control = CURDATE())")->execute();
}

// ══════════════════════════════════════════════════════════════════
echo "=== C1 · Validaciones de setters (ModeloControl) ===\n";
$m = new ModeloControl();
[$r, $e] = intenta(fn() => $m->setFechaRegreso('2020-01-01'));
check($e !== null && str_contains($e->getMessage(), 'pasado'), 'fecha de regreso pasada se rechaza', $e?->getMessage() ?? 'aceptada');
[$r, $e] = intenta(fn() => $m->setFechaRegreso('01-01-2027'));
check($e !== null, 'fecha con formato inválido se rechaza');
[$r, $e] = intenta(fn() => $m->setCedula('123'));
check($e !== null, 'cédula de 3 dígitos se rechaza');
[$r, $e] = intenta(fn() => $m->setDiagnostico('sin mayuscula inicial'));
check($e !== null, 'diagnóstico sin mayúscula inicial se rechaza');
[$r, $e] = intenta(fn() => $m->setIndicaciones('sinMayuscula inicial aqui'));
check($e !== null, 'indicaciones sin mayúscula inicial se rechaza');
[$r, $e] = intenta(fn() => $m->setIdUsuario('abc'));
check($e !== null, 'id de usuario no numérico se rechaza');

echo "\n=== C2 · setNota y setSeveridad validan contra el esquema ===\n";
// nota es varchar(40) en la base; severidad es enum('LEVE','MODERADA','GRAVE')
[$r, $e] = intenta(fn() => $m->setNota(str_repeat('a', 60)));
check($e !== null, 'nota de 60 caracteres se rechaza (la columna es varchar(40))', 'debería rechazarse');
[$r, $e] = intenta(fn() => $m->setSeveridad('CRITICA'));
check($e !== null, 'severidad arbitraria se rechaza (la columna es un enum)', 'debería rechazarse');
[$r, $e] = intenta(fn() => $m->setNota('nota valida'));
check($e === null && $r === null, 'nota válida se acepta');
[$r, $e] = intenta(fn() => $m->setSeveridad('MODERADA'));
check($e === null, 'severidad válida se acepta');

echo "\n=== C3 · Insertar control completo (flujo real, rollback manual) ===\n";
limpiarControl($pdo, $marcador);
$mc = new ModeloControl();
$mc->setIdUsuario($doctor['id_usuario']);
$mc->setIdPaciente($paciente['id_paciente']);
$mc->setHistorial($marcador . ' historial clinico de prueba');
$mc->setDiagnostico('Diagnostico de prueba del harness');
$mc->setIndicaciones('Indicaciones de prueba del harness');
$mc->setFechaRegreso($manana);
$mc->setNota('nota de prueba');
$mc->setSeveridad('LEVE');
$mc->setSintomas([$sintoma['id_sintomas']]);
$mc->setPatologias([$patologia['id_patologia']]);
$res = $mc->insertControl($doctor['id_usuario']);
check(is_array($res) && $res[0] === 'exito', 'control con síntoma y patología se guarda', is_string($res) ? $res : print_r($res, true));

echo "\n=== C4 · Insertar control SIN síntomas (como llega del formulario vacío: [null]) ===\n";
$mc2 = new ModeloControl();
$mc2->setIdUsuario($doctor['id_usuario']);
$mc2->setIdPaciente($paciente['id_paciente']);
$mc2->setHistorial($marcador . ' historial sin sintomas');
$mc2->setDiagnostico('Diagnostico sin sintomas de prueba');
$mc2->setIndicaciones('Indicaciones de prueba del harness');
$mc2->setFechaRegreso($manana);
$mc2->setNota('nota');
$mc2->setSeveridad('LEVE');
// exactamente lo que manda el controlador cuando no se marca ningún check:
$mc2->setSintomas([null]);
$mc2->setPatologias([null]);
$res = $mc2->insertControl($doctor['id_usuario']);
check(is_array($res) && $res[0] === 'exito',
    'BUG: control sin síntomas/patologías falla con error SQL crudo',
    is_string($res) ? $res : print_r($res, true));

echo "\n=== C5 · Insertar control con nota de 60 caracteres (varchar(40)) ===\n";
$mc3 = new ModeloControl();
$mc3->setIdUsuario($doctor['id_usuario']);
$mc3->setIdPaciente($paciente['id_paciente']);
$mc3->setHistorial($marcador . ' historial nota larga');
$mc3->setDiagnostico('Diagnostico nota larga de prueba');
$mc3->setIndicaciones('Indicaciones de prueba del harness');
$mc3->setFechaRegreso($manana);
[$r, $e] = intenta(fn() => $mc3->setNota(str_repeat('x', 60)));
check($e !== null && str_contains($e->getMessage(), '40'), 'nota de 60 chars se rechaza antes de tocar la base', $e?->getMessage() ?? 'aceptada');
$mc3->setNota('nota valida');
$mc3->setSeveridad('LEVE');
$mc3->setSintomas([$sintoma['id_sintomas']]);
$res = $mc3->insertControl($doctor['id_usuario']);
check(is_array($res) && $res[0] === 'exito', 'control con nota válida se guarda', is_string($res) ? $res : print_r($res, true));

echo "\n=== C6 · Insertar control con severidad inválida (enum) ===\n";
$mc4 = new ModeloControl();
$mc4->setIdUsuario($doctor['id_usuario']);
$mc4->setIdPaciente($paciente['id_paciente']);
$mc4->setHistorial($marcador . ' historial severidad');
$mc4->setDiagnostico('Diagnostico severidad de prueba');
$mc4->setIndicaciones('Indicaciones de prueba del harness');
$mc4->setFechaRegreso($manana);
$mc4->setNota('nota');
[$r, $e] = intenta(fn() => $mc4->setSeveridad('CRITICA'));
check($e !== null, 'severidad inexistente en el enum se rechaza', $e?->getMessage() ?? 'aceptada');
$mc4->setSeveridad('LEVE');
$mc4->setSintomas([$sintoma['id_sintomas']]);
$res = $mc4->insertControl($doctor['id_usuario']);
check(is_array($res) && $res[0] === 'exito', 'control con severidad válida se guarda', is_string($res) ? $res : print_r($res, true));

echo "\n=== C7 · Editar control: flujo normal ===\n";
$idControl = (int)$pdo->query("SELECT MAX(id_control) FROM control WHERE historiaclinica LIKE '%$marcador%'")->fetchColumn();
if ($idControl) {
    $antes = $pdo->query("SELECT diagnostico, nota, severidad FROM control WHERE id_control = $idControl")->fetch(PDO::FETCH_ASSOC);
    $me = new ModeloControl();
    $me->setIdControl($idControl);
    $me->setHistorial($marcador . ' historial editado');
    $me->setDiagnostico('Diagnostico editado de prueba');
    $me->setIndicaciones('Indicaciones editadas de prueba');
    $me->setFechaRegreso($manana);
    $me->setNota('nota editada');
    $me->setSeveridad('MODERADA');
    $res = $me->editarControl($doctor['id_usuario']);
    $despues = $pdo->query("SELECT diagnostico, nota, severidad FROM control WHERE id_control = $idControl")->fetch(PDO::FETCH_ASSOC);
    check(is_array($res) && $res[0] === 'exito', 'editar control funciona', is_string($res) ? $res : print_r($res, true));
    check($despues['severidad'] === 'MODERADA', 'la severidad se actualiza al editar');
} else {
    check(false, 'no se encontró el control de prueba para editar');
}

echo "\n=== C8 · Editar control antiguo (fecha de regreso ya pasada) ===\n";
// El usuario debe poder corregir un control histórico; hoy la validación lo impide.
$viejo = $pdo->query("SELECT id_control FROM control WHERE estado='ACT' AND fechaRegreso < CURDATE() ORDER BY id_control DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
if ($viejo) {
    $snap = $pdo->query("SELECT * FROM control WHERE id_control = " . $viejo['id_control'])->fetch(PDO::FETCH_ASSOC);
    $me = new ModeloControl();
    $me->setIdControl($viejo['id_control']);
    $me->setHistorial('Historial de correccion historica');
    $me->setDiagnostico('Diagnostico corregido historico');
    $me->setIndicaciones('Indicaciones corregidas historico');
    [$r, $e] = intenta(fn() => $me->setFechaRegreso($snap['fechaRegreso']));
    check($e !== null,
        'BUG: no se puede editar un control cuya fecha de regreso ya pasó',
        $e ? $e->getMessage() : 'la fecha pasada se aceptó');
    $me->setNota($snap['nota']);
    $me->setSeveridad($snap['severidad']);
    if ($e === null) {
        $res = $me->editarControl($doctor['id_usuario']);
        check(is_array($res) && $res[0] === 'exito', 'editar control histórico funciona', is_string($res) ? $res : print_r($res, true));
    }
} else {
    check(true, 'sin controles antiguos: se omite C8');
}

echo "\n=== C9 · Editar control inexistente ===\n";
$me = new ModeloControl();
$me->setIdControl(99999999);
$me->setHistorial('Historial de prueba inexistente');
$me->setDiagnostico('Diagnostico inexistente de prueba');
$me->setIndicaciones('Indicaciones inexistentes prueba');
$me->setFechaRegreso($manana);
$me->setNota('nota');
$me->setSeveridad('LEVE');
$res = $me->editarControl($doctor['id_usuario']);
check(is_string($res) && str_contains($res, 'no existe'), 'control inexistente devuelve mensaje claro', var_export($res, true));

echo "\n=== C10 · ModeloSintomas: consultas ===\n";
$ms = new ModeloSintomas();
$res = intenta(fn() => $ms->selectSintomas());   // valores por defecto
check(is_array($res[0]), 'selectSintomas() con valores por defecto funciona', is_string($res[0]) ? $res[0] : 'ok');
$res = intenta(fn() => $ms->selectSintomas(0, 10, '', 'id_sintomas', 'DESC'));
check(is_array($res[0]) && count($res[0]) > 0, 'selectSintomas con columna válida devuelve filas', is_string($res[0]) ? $res[0] : 'ok');
$res = intenta(fn() => $ms->eliminarL());
// sin setIdSintomas: debe devolver mensaje controlado, nunca 0
check(is_string($res[0]), 'eliminarL sin id devuelve mensaje de error claro', var_export($res[0], true));

echo "\n=== C11 · Síntomas: nombre largo para varchar(25) ===\n";
$ms2 = new ModeloSintomas();
[$r, $e] = intenta(fn() => $ms2->setNombre(str_repeat('a', 40)));
check($e !== null, 'nombre de síntoma de 40 chars se rechaza (varchar(25))', 'debería rechazarse');
[$r, $e] = intenta(fn() => $ms2->setNombre('Dolor de cabeza'));
check($e === null, 'nombre válido se acepta');

echo "\n=== C12 · insertControl con usuario/paciente inexistente ===\n";
$mc5 = new ModeloControl();
$mc5->setIdUsuario($doctor['id_usuario']);
$mc5->setIdPaciente(99999999);
$mc5->setHistorial($marcador . ' historial paciente inexistente');
$mc5->setDiagnostico('Diagnostico paciente inexistente');
$mc5->setIndicaciones('Indicaciones de prueba del harness');
$mc5->setFechaRegreso($manana);
$mc5->setNota('nota');
$mc5->setSeveridad('LEVE');
$mc5->setSintomas([$sintoma['id_sintomas']]);
$res = $mc5->insertControl($doctor['id_usuario']);
check(is_string($res) && str_contains($res, 'paciente'), 'paciente inexistente se rechaza con mensaje claro', var_export($res, true));

echo "\n=== C13 · REGRESIÓN: cédula de 7 dígitos en el flujo de control ===\n";
// Este era el origen del "TypeError: can't access property 'length',
// result[0] is undefined" al hacer clic en un paciente: ModeloPatologia
// exigía 8-9 dígitos y el endpoint fallaba con las cédulas de 7.
$mp = new \App\modelos\ModeloPatologia();
[$r, $e] = intenta(fn() => $mp->setCedulaPac('2000004'));
check($e === null, 'ModeloPatologia acepta cédula de 7 dígitos', $e?->getMessage() ?? 'ok');
$res = intenta(fn() => $mp->buscarPatologiaPaciente());
check(is_array($res[0]) || $res[0] === false, 'buscarPatologiaPaciente funciona con cédula de 7 dígitos', is_string($res[0]) ? $res[0] : 'ok');
$mp8 = new \App\modelos\ModeloPatologia();
[$r, $e] = intenta(fn() => $mp8->setCedulaPac('30554144'));
check($e === null, 'ModeloPatologia sigue aceptando cédula de 8 dígitos', $e?->getMessage() ?? 'ok');

$perfil = new \App\modelos\ModeloPerfil();
[$r, $e] = intenta(fn() => $perfil->setCedulaRegistrada('2000004'));
check($e === null, 'ModeloPerfil::setCedulaRegistrada acepta 7 dígitos', $e?->getMessage() ?? 'ok');

// Todos los setters de cédula deben aceptar 7 u 8 dígitos (consistencia)
$modelosCedula = [
    ['App\modelos\ModeloControl', 'setCedula'],
];
foreach ($modelosCedula as [$clase, $metodo]) {
    $obj = new $clase();
    [$r, $e] = intenta(fn() => $obj->$metodo('2000004'));
    check($e === null, "$clase::$metodo acepta 7 dígitos", $e?->getMessage() ?? 'ok');
    [$r, $e] = intenta(fn() => $obj->$metodo('30554144'));
    check($e === null, "$clase::$metodo acepta 8 dígitos", $e?->getMessage() ?? 'ok');
    [$r, $e] = intenta(fn() => $obj->$metodo('123456'));
    check($e !== null, "$clase::$metodo rechaza 6 dígitos", $e?->getMessage() ?? 'aceptada');
}

// ══════════════════════════════════════════════════════════════════
echo "\n=== I1 · Inventario: editar insumo SIN imagen nueva ===\n";
if ($insumo) {
    $idIns = (int)$insumo['id_insumo'];
    $snap = $pdo->query("SELECT nombre, descripcion, stockMinimo, marca, medida FROM insumo WHERE id_insumo = $idIns")->fetch(PDO::FETCH_ASSOC);
    $mi = new ModeloInsumo();
    $mi->setIdInsumo($idIns);
    $mi->setNombre($snap['nombre']);
    $mi->setDescripcion($snap['descripcion']);
    $mi->setStockMinimo($snap['stockMinimo']);
    $mi->setMarca($snap['marca']);
    $mi->setMedida($snap['medida']);
    $mi->setImagen(null);   // no se subió imagen nueva: el controlador manda null
    $res = $mi->editarInsumo(1);
    check(is_array($res) && $res[0] === 'exito',
        'editar insumo sin imagen nueva funciona (conserva la anterior)',
        is_string($res) ? $res : print_r($res, true));
} else {
    check(true, 'sin insumos: se omite I1');
}

echo "\n=== I2 · Inventario: nombre de insumo mayor a varchar(25) ===\n";
$mi2 = new ModeloInsumo();
[$r, $e] = intenta(fn() => $mi2->setNombre('Nombre De Insumo Extremadamente Largo Para La Columna'));
check($e !== null, 'nombre de insumo de 50 chars se rechaza (varchar(25))', 'debería rechazarse');

echo "\n=== I3 · Inventario: insertar insumo (flujo real + limpieza) ===\n";
if ($proveedor) {
    $pdo->prepare("DELETE FROM entrada_insumo WHERE id_insumo IN (SELECT id_insumo FROM insumo WHERE nombre = :n)")
        ->execute([':n' => 'Prueba Test']);
    $pdo->prepare("DELETE ei FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo WHERE i.nombre = :n")
        ->execute([':n' => 'Prueba Test']);
    // limpiar entradas huérfanas de pruebas anteriores
    $pdo->exec("DELETE e FROM entrada e LEFT JOIN entrada_insumo ei ON ei.id_entrada = e.id_entrada
                WHERE ei.id_entrada IS NULL AND e.estado = 'ACT' AND e.numero_de_lote = 999999");
    $mi3 = new ModeloInsumo();
    $mi3->setImagen('test.jpg');
    $mi3->setNombre('Prueba Test');
    $mi3->setIdProveedor($proveedor['id_proveedor']);
    $mi3->setDescripcion('Insumo de prueba del harness');
    $mi3->setFechaDeIngreso($hoy);
    $mi3->setFechaDeVencimiento(date('Y-m-d', strtotime('+1 year')));
    $mi3->setCantidad(5);
    $mi3->setStockMinimo(1);
    $mi3->setLote(999999);
    $mi3->setMarca('Marca Test');
    $mi3->setMedida('100 ml');
    $mi3->setIva(0);
    $mi3->setPrecio(10);
    $res = $mi3->guardarInsumo(1);
    check(is_array($res) && $res[0] === 'exito', 'insertar insumo funciona', is_string($res) ? $res : print_r($res, true));

    // segunda inserción con el mismo nombre debe rechazarse (protección de duplicados)
    $mi4 = new ModeloInsumo();
    $mi4->setImagen('test.jpg');
    $mi4->setNombre('Prueba Test');
    $mi4->setIdProveedor($proveedor['id_proveedor']);
    $mi4->setDescripcion('Insumo de prueba del harness');
    $mi4->setFechaDeIngreso($hoy);
    $mi4->setFechaDeVencimiento(date('Y-m-d', strtotime('+1 year')));
    $mi4->setCantidad(5);
    $mi4->setStockMinimo(1);
    $mi4->setLote(999999);
    $mi4->setMarca('Marca Test');
    $mi4->setMedida('100 ml');
    $mi4->setIva(0);
    $mi4->setPrecio(10);
    $res = $mi4->guardarInsumo(1);
    check(is_string($res) && str_contains($res, 'existe'), 'insumo duplicado se rechaza', var_export($res, true));
} else {
    check(true, 'sin proveedores: se omite I3');
}

echo "\n=== I4 · Inventario: setFechaDeVencimiento de Entrada ===\n";
$mt = new ModeloEntrada();
[$r, $e] = intenta(fn() => $mt->setFechaDeVencimiento('2020-01-01'));
check($e !== null && $e instanceof \InvalidArgumentException,
    'fecha pasada se rechaza con InvalidArgumentException (el controlador responde 409)',
    $e ? get_class($e) . ': ' . $e->getMessage() : 'sin excepción');
[$r, $e] = intenta(fn() => $mt->setFechaDeVencimiento('basura'));
check($e !== null, 'fecha con formato inválido se rechaza', $e?->getMessage() ?? 'aceptada');
[$r, $e] = intenta(fn() => $mt->setFechaDeVencimiento('2020-01-01', true));
check($e === null, 'al editar se permite una fecha pasada (corregir histórico)');

echo "\n=== I5 · Inventario: editar entrada desincroniza cantidad_disponible (BUG) ===\n";
$lote = $pdo->query(
    "SELECT ei.id_entradaDeInsumo, ei.cantidad_entrante, ei.cantidad_disponible
     FROM entrada_insumo ei INNER JOIN entrada e ON e.id_entrada = ei.id_entrada
     WHERE e.estado = 'ACT' AND ei.cantidad_disponible > 0
       AND ei.cantidad_disponible < ei.cantidad_entrante AND ei.cantidad_entrante > 1 LIMIT 1"
)->fetch(PDO::FETCH_ASSOC);
if ($lote) {
    $idEI = (int)$lote['id_entradaDeInsumo'];
    $oldEnt = (int)$lote['cantidad_entrante'];
    $oldDisp = (int)$lote['cantidad_disponible'];
    $entrada = $pdo->query("SELECT e.id_entrada, e.numero_de_lote FROM entrada_insumo ei INNER JOIN entrada e ON e.id_entrada = ei.id_entrada
                            WHERE ei.id_entradaDeInsumo = $idEI")->fetch(PDO::FETCH_ASSOC);
    $oldLote = $entrada['numero_de_lote'];
    $editar = function (int $nuevaCant) use ($pdo, $entrada, $proveedor) {
        $me2 = new ModeloEntrada();
        $me2->setIdEntrada($entrada['id_entrada']);
        $me2->setLote(999998);
        $me2->setIdProveedor($proveedor['id_proveedor']);
        $me2->setFechaDeVencimiento(date('Y-m-d', strtotime('+1 year')));
        $me2->setCantidadEntrante($nuevaCant);
        $me2->setPrecio(10);
        return $me2->updateEntrda(1);
    };

    // (a) AUMENTAR la cantidad entrante en 5 → disponible debe subir 5
    $res = $editar($oldEnt + 5);
    $nuevo = $pdo->query("SELECT cantidad_entrante, cantidad_disponible FROM entrada_insumo WHERE id_entradaDeInsumo = $idEI")->fetch(PDO::FETCH_ASSOC);
    check(is_array($res) && $res[0] === 'exito', 'editar entrada funciona', is_string($res) ? $res : print_r($res, true));
    check((int)$nuevo['cantidad_disponible'] === $oldDisp + 5,
        'al aumentar cantidad_entrante el disponible sube igual',
        "disponible quedó {$nuevo['cantidad_disponible']}, debía quedar " . ($oldDisp + 5));

    // (b) REDUCIR la cantidad entrante → disponible debe bajar igual (sin pasar de 0)
    $res = $editar($oldEnt + 2);
    $nuevo = $pdo->query("SELECT cantidad_entrante, cantidad_disponible FROM entrada_insumo WHERE id_entradaDeInsumo = $idEI")->fetch(PDO::FETCH_ASSOC);
    $esperado = max(0, $oldDisp + 2);   // entrante quedó oldEnt+2
    check((int)$nuevo['cantidad_disponible'] === $esperado,
        'al reducir cantidad_entrante el disponible baja igual',
        "disponible quedó {$nuevo['cantidad_disponible']}, debía quedar $esperado");

    // restaurar
    $pdo->prepare("UPDATE entrada_insumo SET cantidad_entrante = :e, cantidad_disponible = :d WHERE id_entradaDeInsumo = :id")
        ->execute([':e' => $oldEnt, ':d' => $oldDisp, ':id' => $idEI]);
    $pdo->prepare("UPDATE entrada SET numero_de_lote = :l WHERE id_entrada = :id")
        ->execute([':l' => $oldLote, ':id' => $entrada['id_entrada']]);
} else {
    check(true, 'sin lotes con consumo parcial: se omite I5');
}

echo "\n=== I6 · Inventario: integridad general ===\n";
$neg = (int)$pdo->query("SELECT COUNT(*) FROM entrada_insumo WHERE cantidad_disponible < 0")->fetchColumn();
check($neg === 0, "no hay lotes con stock negativo ($neg)");
$inco = (int)$pdo->query("SELECT COUNT(*) FROM entrada_insumo WHERE cantidad_disponible > cantidad_entrante")->fetchColumn();
check($inco === 0, "no hay lotes donde disponible > entrante ($inco)");
$desfase = (int)$pdo->query(
    "SELECT COUNT(*) FROM (
        SELECT i.id_insumo, COALESCE(SUM(CASE WHEN ei.fechaDeVencimiento > CURDATE() AND e.estado='ACT'
                                             THEN ei.cantidad_disponible ELSE 0 END),0) AS lotes
        FROM insumo i
        LEFT JOIN entrada_insumo ei ON ei.id_insumo = i.id_insumo
        LEFT JOIN entrada e ON e.id_entrada = ei.id_entrada
        WHERE i.estado='ACT' GROUP BY i.id_insumo
     ) x JOIN view_resumen_insumos v ON v.id_insumo = x.id_insumo
     WHERE v.disponible <> x.lotes"
)->fetchColumn();
check($desfase === 0, "el stock de la vista coincide con los lotes ($desfase diferencias)");

echo "\n=== I7 · Entradas: consultas ===\n";
$res = intenta(fn() => (new ModeloEntrada())->todasLasEntradas(0, 10, '', 'id_entrada', 'DESC'));
check(is_array($res[0]), 'todasLasEntradas devuelve filas', is_string($res[0]) ? $res[0] : 'ok');
$res = intenta(fn() => (new ModeloEntrada())->todasLasEntradas(0, 10, "x' OR 1=1 --", 'id_entrada', 'DESC'));
check(is_array($res[0]) && count($res[0]) === 0, 'inyección SQL en el buscador no devuelve filas', is_string($res[0]) ? $res[0] : 'ok');
$res = intenta(fn() => (new ModeloEntrada())->todasLasEntradas(0, 10, '', 'id_entrada; DROP TABLE entrada --', 'DESC'));
check(is_array($res[0]), 'orden por columna inyectada no rompe la consulta', is_string($res[0]) ? $res[0] : 'ok');

// ── Limpieza final ──────────────────────────────────────────────────
echo "\n=== Limpieza ===\n";
limpiarControl($pdo, $marcador);
$pdo->prepare("DELETE ei FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo WHERE i.nombre = :n")
    ->execute([':n' => 'Prueba Test']);
$pdo->prepare("DELETE FROM insumo WHERE nombre = :n")->execute([':n' => 'Prueba Test']);
$pdo->exec("DELETE e FROM entrada e LEFT JOIN entrada_insumo ei ON ei.id_entrada = e.id_entrada
            WHERE ei.id_entrada IS NULL AND e.numero_de_lote = 999999");
$restoControl = (int)$pdo->query("SELECT COUNT(*) FROM control WHERE historiaclinica LIKE '%$marcador%'")->fetchColumn();
$restoInsumo = (int)$pdo->query("SELECT COUNT(*) FROM insumo WHERE nombre = 'Prueba Test'")->fetchColumn();
check($restoControl === 0 && $restoInsumo === 0, 'no queda data de prueba en la base',
    "control=$restoControl insumo=$restoInsumo");

printf("\n%d pruebas, %d fallos\n", $pruebas, $fallos);
exit($fallos === 0 ? 0 : 1);
