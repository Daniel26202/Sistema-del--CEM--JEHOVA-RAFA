<?php
/**
 * Dispatcher de pruebas a nivel CONTROLADOR (proceso independiente por caso,
 * porque incluir dos controladores en el mismo proceso colisiona por nombres
 * de función: eliminar(), editar(), papelera()...).
 *
 * Uso: /opt/lampp/bin/php tests/modulos_controller_test.php <caso> [extra]
 * Imprime SOLO el JSON del endpoint por stdout; mensajes de estado por stderr.
 */

$caso = $argv[1] ?? '';
$extra = $argv[2] ?? '';

session_start();
$_SESSION = ['id_usuario' => 1, 'id_rol' => 1, 'usuario' => 'test', 'csrf_token' => 'tok3n'];
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

$CS = 'src/controllers/';

switch ($caso) {

    // ── PROVEEDORES ────────────────────────────────────────
    case 'prov_search':
    case 'prov_papelera_search':
        $_GET = [
            'draw' => 1, 'start' => 0, 'length' => 10,
            'search' => ['value' => 'Juan'],
            'order' => [['column' => 0, 'dir' => 'asc']],
        ];
        require_once $raiz . $CS . 'ControllerProveedores.php';
        if ($caso === 'prov_search') proveedoresAjax();
        else proveedoresPapeleraAjax();
        break;

    case 'prov_csrf':   // insertar sin token -> 403
        $_POST = ['nombre' => 'X', 'rif' => 'V1', 'telefono' => '04121338909', 'correo' => 'a@a.com', 'direccion' => 'Dir 123'];
        require_once $raiz . $CS . 'ControllerProveedores.php';
        insertar();
        break;

    case 'prov_create': // creación real vía controlador (con CSRF)
        $_POST = [
            'csrf_token' => $_SESSION['csrf_token'],
            'nombre' => 'Proveedor Ctrl',
            'rif' => 'V' . $extra,
            'telefono' => '04121338909',
            'correo' => 'ctrl@example.com',
            'direccion' => 'Direccion controlador 123',
        ];
        require_once $raiz . $CS . 'ControllerProveedores.php';
        insertar();
        break;

    // ── ENTRADA ─────────────────────────────────────────────
    case 'ent_search':
        $_GET = [
            'draw' => 1, 'start' => 0, 'length' => 10,
            'search' => ['value' => 'a'],
            'order' => [['column' => 2, 'dir' => 'asc']],   // col 2 = Fecha De Ingreso (antes typo fechDeIngreso)
        ];
        require_once $raiz . $CS . 'ControllerEntrada.php';
        entradasAjax();
        break;

    case 'ent_papelera':
        $_GET = ['draw' => 1, 'start' => 0, 'length' => 10, 'search' => ['value' => 'a'], 'order' => [['column' => 0, 'dir' => 'asc']]];
        require_once $raiz . $CS . 'ControllerEntrada.php';
        entradasPapeleraAjax();
        break;

    case 'ent_csrf':
        $_POST = ['id_insumo' => 'x', 'proveedor' => 'y', 'lote' => '1', 'fechaDeVencimiento' => '2030-01-01', 'cantidad' => '5', 'precioD' => '10,00'];
        require_once $raiz . $CS . 'ControllerEntrada.php';
        guardar();
        break;

    case 'ent_create':
        $pdo = new PDO('mysql:host=localhost;dbname=bd;charset=utf8mb4', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $ins = $pdo->query("SELECT id_insumo FROM insumo WHERE estado='ACT' LIMIT 1")->fetchColumn();
        $prov = $pdo->query("SELECT id_proveedor FROM proveedor WHERE estado='ACT' LIMIT 1")->fetchColumn();
        $_POST = [
            'csrf_token' => $_SESSION['csrf_token'],
            'id_insumo' => hashId((int)$ins),
            'proveedor' => hashId((int)$prov),
            'lote' => (string)$extra,
            'fechaDeVencimiento' => date('Y-m-d', strtotime('+200 day')),
            'cantidad' => '5',
            'precioD' => '10,00',
        ];
        require_once $raiz . $CS . 'ControllerEntrada.php';
        guardar();
        break;

    // ── INSUMOS ─────────────────────────────────────────────
    case 'ins_list':
        $_GET = ['draw' => 1, 'start' => 0, 'length' => 10, 'search' => ['value' => ''], 'order' => [['column' => 0, 'dir' => 'asc']]];
        require_once $raiz . $CS . 'ControllerInsumos.php';
        insumosAjax();
        break;

    case 'ins_venc_search':
        // antes rompía por ei.fechaDeIngreso / ei.cantidad_entrada y por el orden fechDeIngreso
        $_GET = ['draw' => 1, 'start' => 0, 'length' => 10, 'search' => ['value' => 'a'], 'order' => [['column' => 2, 'dir' => 'asc']]];
        require_once $raiz . $CS . 'ControllerInsumos.php';
        vencidos();
        break;

    case 'ins_pap_search':
        $_GET = ['draw' => 1, 'start' => 0, 'length' => 10, 'search' => ['value' => 'a'], 'order' => [['column' => 0, 'dir' => 'asc']]];
        require_once $raiz . $CS . 'ControllerInsumos.php';
        papeleraInsumosAjax();
        break;

    case 'ins_retornar':
        $_GET = ['x' => 1];
        require_once $raiz . $CS . 'ControllerInsumos.php';
        retornarLasEntradas();
        break;

    case 'ins_info':
        $pdo = new PDO('mysql:host=localhost;dbname=bd;charset=utf8mb4', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $ins = $pdo->query("SELECT id_insumo FROM insumo WHERE estado='ACT' ORDER BY id_insumo LIMIT 1")->fetchColumn();
        require_once $raiz . $CS . 'ControllerInsumos.php';
        info([hashId((int)$ins)]);
        break;

    case 'ins_csrf':
        $_POST = ['nombre' => 'X', 'proveedor' => 'y', 'descripcion' => 'd', 'fechaDeVencimiento' => '2030-01-01', 'cantidad' => '5', 'stockMinimo' => '1', 'lote' => '9', 'marca' => 'm', 'medida' => '5 ml', 'precioD' => '10,00'];
        require_once $raiz . $CS . 'ControllerInsumos.php';
        guardarInsumo();
        break;

    case 'ins_validarImg':
        // Prueba unitaria de validarImagen() sin necesidad de subida real.
        require_once $raiz . $CS . 'ControllerInsumos.php';
        $m = new App\modelos\ModeloInsumo();
        $res = ['ok' => true];
        // extensión no permitida
        try { $m->validarImagen(['error' => UPLOAD_ERR_OK, 'name' => 'x.php', 'size' => 100, 'tmp_name' => '/dev/null']); $res['ext'] = 'aceptado'; }
        catch (\InvalidArgumentException $e) { $res['ext'] = 'rechazado'; }
        // nombre jpg pero no es imagen real (archivo de texto con extensión .jpg)
        try {
            $fake = tempnam(sys_get_temp_dir(), 'noimg'); file_put_contents($fake, 'no soy imagen');
            $m->validarImagen(['error' => UPLOAD_ERR_OK, 'name' => 'x.jpg', 'size' => filesize($fake), 'tmp_name' => $fake]);
            $res['mime'] = 'aceptado'; unlink($fake);
        } catch (\InvalidArgumentException $e) { $res['mime'] = 'rechazado'; }
        // PNG real (generado por base64) con nombre .jpg -> debe aceptarse
        try {
            $tmp = tempnam(sys_get_temp_dir(), 'img') . '.png';
            file_put_contents($tmp, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg=='));
            $m->validarImagen(['error' => UPLOAD_ERR_OK, 'name' => 'ok.jpg', 'size' => filesize($tmp), 'tmp_name' => $tmp]);
            $res['png'] = 'aceptado'; unlink($tmp);
        } catch (\InvalidArgumentException $e) { $res['png'] = 'rechazado'; }
        echo json_encode($res);
        break;

    default:
        fwrite(STDERR, "caso desconocido: $caso\n");
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'caso desconocido']);
}
