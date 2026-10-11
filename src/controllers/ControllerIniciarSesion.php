<?php

use App\modelos\ModeloInicioSesion;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloUsuarios;
use App\config\Cifrado;

// use Firebase\JWT\JWT;
// require_once __DIR__ . "/../config/config.php";

function mostrarIniciarSesion($parametro)
{
    $ayuda = "btnayudaIniciarSesion";
    require_once __DIR__ . "/../../src/vistas/vistaIniciarSesion/iniciarSesion.php";
}

// ──────────────────────────────────────────────────────────────
// SERVIDOR WEBSOCKET (Ratchet)
// Se arranca en segundo plano desde el inicio de sesión para que las
// notificaciones de "citas próximas" funcionen igual en Linux y en Windows.
// ──────────────────────────────────────────────────────────────

/**
 * Configuración del servidor WebSocket.
 * Se puede cambiar sin tocar el código con WS_HOST y WS_PORT en el .env.
 *
 * @return array{host: string, puerto: int}
 */
function websocketConfiguracion(): array
{
    $host = $_ENV['WS_HOST'] ?? getenv('WS_HOST');
    if (!is_string($host) || trim($host) === '') {
        $host = '127.0.0.1';
    }

    $puerto = $_ENV['WS_PORT'] ?? getenv('WS_PORT');
    if (!is_numeric($puerto) || (int) $puerto <= 0) {
        $puerto = 8080;
    }

    return ['host' => trim($host), 'puerto' => (int) $puerto];
}

/**
 * Indica si hay un servidor escuchando en host:puerto.
 */
function websocketEstaActivo(string $host, int $puerto, float $timeout = 0.5): bool
{
    $errno = 0;
    $errstr = '';

    $socket = @fsockopen($host, $puerto, $errno, $errstr, $timeout);

    if (is_resource($socket)) {
        fclose($socket);
        return true;
    }

    return false;
}

/**
 * Localiza el ejecutable de PHP (CLI) para lanzar el servidor.
 *
 * Antes sólo se probaba "C:\xampp" y "D:\xampp", por lo que en un Windows con
 * XAMPP en otra unidad, o con Laragon/WampServer, el servidor no arrancaba.
 */
function websocketBinarioPhp(): ?string
{
    $esWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    $candidatos = [];

    // El propio binario con el que corre PHP. Ojo: bajo Apache/mod_php
    // PHP_BINARY apunta al servidor web (httpd.exe), de ahí el filtro por nombre.
    $actual = defined('PHP_BINARY') ? PHP_BINARY : '';
    if (is_string($actual) && $actual !== '' && stripos(basename($actual), 'php') !== false && is_file($actual)) {
        $candidatos[] = $actual;
    }

    // Directorio de instalación que declara PHP (en XAMPP/LAMPP es /opt/lampp/bin).
    if (defined('PHP_BINDIR') && is_dir(PHP_BINDIR)) {
        $candidatos[] = rtrim(PHP_BINDIR, '/\\') . ($esWindows ? '\\php.exe' : '/php');
    }

    if ($esWindows) {
        // XAMPP puede estar en cualquier unidad; se recorren las habituales y
        // también los caminos de otros stacks usados en Windows.
        foreach (['C', 'D', 'E', 'F'] as $unidad) {
            $candidatos[] = $unidad . ':\\xampp\\php\\php.exe';
        }
        $candidatos[] = 'C:\\laragon\\bin\\php\\php.exe';
        $candidatos[] = 'C:\\wamp64\\bin\\php\\php.exe';
        $candidatos[] = 'C:\\php\\php.exe';
    } else {
        $candidatos[] = '/opt/lampp/bin/php';   // XAMPP/LAMPP en Linux
        $candidatos[] = '/usr/local/bin/php';
        $candidatos[] = '/usr/bin/php';
        $candidatos[] = '/bin/php';
    }

    foreach ($candidatos as $candidato) {
        if ($candidato !== '' && is_file($candidato) && is_executable($candidato)) {
            return $candidato;
        }
    }

    // Último recurso: buscarlo en el PATH del sistema.
    if (function_exists('exec')) {
        $salida = [];
        $codigo = 0;
        @exec($esWindows ? 'where php' : 'command -v php', $salida, $codigo);

        foreach ((array) $salida as $linea) {
            $linea = trim((string) $linea);
            if ($linea !== '' && is_file($linea)) {
                return $linea;
            }
        }
    }

    return null;
}

/**
 * Pone una ruta entre comillas para que funcione aunque contenga espacios
 * ("C:\xampp\htdocs\Mi Sistema\webSocket.php").
 */
function websocketEntreComillas(string $valor): string
{
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        return '"' . $valor . '"';
    }

    return escapeshellarg($valor);
}

/**
 * Lanza el servidor WebSocket en segundo plano, desvinculado del proceso de
 * Apache, y devuelve true si la orden se ejecutó.
 */
function websocketLanzarServidor(string $php, string $script): bool
{
    $phpArg = websocketEntreComillas($php);
    $scriptArg = websocketEntreComillas($script);

    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        // start /B  -> sin ventana nueva y sin bloquear la respuesta
        // > NUL 2>&1 -> se descarta la salida (si se llena el búfer de un pipe
        //               que nadie lee, el servidor se queda colgado).
        $comando = 'start "" /B ' . $phpArg . ' ' . $scriptArg . ' > NUL 2>&1';

        // WScript.Shell es lo más fiable cuando Apache corre como servicio:
        // devuelve el control de inmediato y deja el proceso vivo.
        if (class_exists('COM')) {
            try {
                $shell = new COM('WScript.Shell');
                $shell->Run('cmd /C ' . $comando, 0, false);
                return true;
            } catch (\Throwable $e) {
                error_log('JEHOVA-RAFA WebSocket: fallo al lanzar con COM (' . $e->getMessage() . ').');
            }
        }

        if (function_exists('popen')) {
            $proceso = @popen($comando, 'r');
            if (is_resource($proceso)) {
                pclose($proceso);
                return true;
            }
            error_log('JEHOVA-RAFA WebSocket: popen() no pudo ejecutar el comando en Windows.');
        }

        return false;
    }

    // Linux: setsid crea una sesión nueva para que el servidor no muera cuando
    // termina la petición de Apache (ni al reiniciar el worker).
    $prefijo = (is_executable('/usr/bin/setsid') || is_executable('/bin/setsid')) ? 'setsid ' : '';
    $comando = $prefijo . $phpArg . ' ' . $scriptArg . ' > /dev/null 2>&1 &';

    if (function_exists('exec')) {
        @exec($comando, $salida, $codigo);
        return true;
    }

    if (function_exists('proc_open')) {
        $proceso = @proc_open($comando, [1 => ['file', '/dev/null', 'w'], 2 => ['file', '/dev/null', 'w']], $pipes);
        if (is_resource($proceso)) {
            proc_close($proceso);
            return true;
        }
    }

    return false;
}

/**
 * Espera hasta $intentos décimas de segundo a que el puerto se abra.
 */
function websocketEsperarPuerto(string $host, int $puerto, int $intentos): void
{
    for ($i = 0; $i < $intentos; $i++) {
        usleep(100000);

        if (websocketEstaActivo($host, $puerto)) {
            return;
        }
    }
}

/**
 * Arranca el servidor WebSocket si no está levantado todavía.
 * Es segura de llamar en cada inicio de sesión y funciona en Linux y Windows.
 */
function iniciarServidorWebSocket(): void
{
    $config = websocketConfiguracion();
    $host = $config['host'];
    $puerto = $config['puerto'];

    // Ya está corriendo: no hay que hacer nada.
    if (websocketEstaActivo($host, $puerto)) {
        return;
    }

    $script = realpath(__DIR__ . '/../../webSocket.php');
    if ($script === false || !is_file($script)) {
        error_log('JEHOVA-RAFA WebSocket: no se encontró webSocket.php en la raíz del proyecto.');
        return;
    }

    $php = websocketBinarioPhp();
    if ($php === null) {
        error_log('JEHOVA-RAFA WebSocket: no se encontró el ejecutable de PHP (php / php.exe) para lanzar el servidor.');
        return;
    }

    // Candado en el directorio temporal del sistema (a diferencia de la carpeta
    // del proyecto, sí es escribible por el usuario con el que corre Apache).
    // Evita que varios inicios de sesión simultáneos lancen varios servidores
    // sobre el mismo puerto.
    $rutaCandado = rtrim(sys_get_temp_dir(), '/\\') . DIRECTORY_SEPARATOR . 'cem_jehova_rafa_websocket.lock';
    $candado = @fopen($rutaCandado, 'c+');
    $bloqueado = is_resource($candado) && @flock($candado, LOCK_EX | LOCK_NB);

    try {
        // Mientras esperábamos el candado otro proceso pudo levantarlo.
        if (websocketEstaActivo($host, $puerto)) {
            return;
        }

        // Otro inicio de sesión tiene el candado, es decir, está arrancando el
        // servidor: solo esperamos a que abra el puerto.
        if (is_resource($candado) && !$bloqueado) {
            websocketEsperarPuerto($host, $puerto, 15);
            return;
        }

        if (websocketLanzarServidor($php, $script)) {
            // Espera máxima de 1 s a que abra el puerto, saliendo antes en
            // cuanto responde (antes se esperaba 0.5 s a ciegas).
            websocketEsperarPuerto($host, $puerto, 10);
        } else {
            error_log('JEHOVA-RAFA WebSocket: no se pudo lanzar el servidor con ' . $php . '.');
        }
    } finally {
        if ($bloqueado) {
            @flock($candado, LOCK_UN);
        }

        if (is_resource($candado)) {
            fclose($candado);
        }
    }
}

// iniciar sesión 

function iniciarSesion()
{
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }
    // Obtenemos la IP del que intenta entrar
    $ipCliente = $_SERVER['REMOTE_ADDR'];



    //  Esto es hacerlo po segunda vez, pero ya esta en el index
    // RATE LIMIT estricto para login: 5 intentos por minuto por IP
    // $rateLimit = new RateLimiter();
    // $rateLimit->setIP($ipCliente);
    // $rateLimit->setEndpoind('iniciarSesion');
    // $rateLimit->setLimitePeticiones(20);


    // if ($rateLimit->checkRateLimitByIP()) {
    //     http_response_code(429);
    //     header('Content-Type: application/json; charset=utf-8');
    //     echo json_encode(['ok' => false, 'error' => 'Demasiados intentos. Espere un momento antes de volver a intentarlo.']);
    //     exit;
    // }

    $modelo = new ModeloInicioSesion();
    $bitacora = new ModeloBitacora();
    $usuario = new ModeloUsuarios();

    $modelo->setIpUsuario($ipCliente);



    // if (isset($_POST)) {
    //     // Clave secreta proporcionada por Google.
    //     $claveSecreta = $_ENV['RECAPTCHA_SECRET'];
    //     // Este token está incluido automáticamente en los datos del formulario bajo el nombre 'g-recaptcha-response'.
    //     $token = $_POST['g-recaptcha-response'];
    //     // capa seguridad(opcional).
    //     $ip = $_SERVER['REMOTE_ADDR'];
    //     // Aqui es donde se enviara la solicitud para validar el token generado en el cliente.
    //     $url = 'https://www.google.com/recaptcha/api/siteverify';
    //     if (isset($_POST)) {

    //         // guardamos los datos en un array.
    //         $datos = array(
    //             'secret' => $claveSecreta,
    //             'response' => $token,
    //             // IP del usuario.
    //             'remoteip' => $ip
    //         );

    //         // Configuración de la solicitud HTTP mediante método POST.
    //         $options = array(
    //             'http' => array(
    //                 'header' => "Content-type: application/x-www-form-urlencoded\r\n",
    //                 'method' => 'POST',
    //                 // Codifica los datos como una cadena de consulta para enviarlos en el cuerpo de la solicitud.
    //                 'content' => http_build_query($datos)
    //             )
    //         );

    //         // enviar la solicitud a la API de Google.
    //         $contexto = stream_context_create($options);
    //         // envía la solicitud HTTP y recibe la respuesta en formato JSON.
    //         $respuesta = file_get_contents($url, false, $contexto);
    //         // Decodifica la respuesta JSON en un arreglo asociativo de PHP.
    //         $result = json_decode($respuesta, true);

    //         if ($result['success']) {

    if ($_POST['username'] === '' or $_POST['password'] === '') {
        http_response_code(409);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => false, 'error' => 'Campos vacíos']);
        exit;
    }

    $modelo->setUsuario($_POST['username']);
    $modelo->setPassword($_POST['password']);



    $data = [
        "usuario" => $modelo->getUsuario()
    ];
    $validarUsuarioExistente = $modelo->validarUsuarioExistente($data);
    $validar = $modelo->validarIniciarSesion($data);

    // 3. Configurar datos para el registro de auditoría
    $modelo->setIpUsuario($ipCliente);
    $modelo->setIdUsuario($validarUsuarioExistente != false ? $validarUsuarioExistente['id_usuario'] : null);

    if ($validar) {
        // regenerar ID de sesión (previene Session Fixation)
        session_regenerate_id(true);
        $modelo->setIntentosFallidos(0);


        //Hrllofor my computer yes after 

        //token random for session for bloqued my system clicnic

        //crear token aleatorio para la session
        $token_session = bin2hex(random_bytes(16));

        //actualizar el token del usuario
        $usuario->setIdUsuario($validar['id_usuario']);
        $usuario->setTokenInicioSesion($token_session);
        $usuario->actualizarTokenInicioSesion();

        // Inicializar variables de sesión
        $_SESSION['usuario'] = $_POST['username'];
        $_SESSION['rol'] = $validar['rol'] ?? null;
        $_SESSION['id_rol'] = $validar['id_rol'] ?? null;
        $_SESSION['id_usuario'] = $validar['id_usuario'] ?? null;
        $_SESSION['id_personal'] = $validar['id_personal'] ?? null;
        $_SESSION['nombre'] = $validar['nombre_personal'] ?? null;
        $_SESSION['apellido'] = $validar['apellido_personal'] ?? null;
        $_SESSION['token_session'] = $token_session ?? null;

        // token csrf
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_token_time'] = time();

        $bitacora->setId_usuario($validar['id_usuario']);
        $bitacora->setActividad("Ha iniciado una session");
        $bitacora->setTabla("inicio sesion");

        $bitacora->insertarBitacora();

        // Arranca el servidor de WebSocket si no está levantado (Linux/Windows)
        iniciarServidorWebSocket();

        echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
    } else {


        http_response_code(409);
        echo json_encode(['ok' => false, 'error' =>'Los datos son incorrectos']);
        exit;
    }
}
//         } else {
//             header("location: /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/mostrarIniciarSesion/captcha");
//         }
//     }
// }





//Metodo para mostrar la vista de la pagina de error ç
function error()
{
    require_once __DIR__ . "/../../src/vistas/vistaIniciarSesion/vistaError.php";
}




function iniciarSesionMovilApk()
{
    $modelo = new ModeloInicioSesion();
    $bitacora = new ModeloBitacora();

    // Llegim el JSON en cru enviat per la App / Thunder Client
    $jsonContenido = file_get_contents('php://input');
    $payloadCifrado = json_decode($jsonContenido, true);
    $datosInput = Cifrado::descifrarPeticion($payloadCifrado);

    $userParam = $datosInput['username'] ?? '';
    $passParam = $datosInput['password'] ?? '';

    // Validació de camps buits
    if ($userParam === '' || $passParam === '') {
        http_response_code(409);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(Cifrado::cifrarRespuesta(['ok' => false, 'error' => 'Camps buits']));
        exit;
    }

    // $ipCliente = $_SERVER['REMOTE_ADDR'];
    // $modelo->setIpUsuario($ipCliente);

    $modelo->setUsuario($userParam);
    $modelo->setPassword($passParam);

    $data = [
        "usuario" => $modelo->getUsuario()
    ];

    $validar = $modelo->validarIniciarSesion($data);

    if ($validar) {

        $secretJWT = $_ENV['JWT_SECRET'];

        $payload = [
            'iss'        => $_ENV['url_sistema_web'],
            'iat'        => time(),
            'exp'        => time() + (60 * 60 * 36), //36 horas
            'id_usuario' => $validar['id_usuario'],
            'id_rol'     => $validar['id_rol'],
            'usuario'    => $userParam,
            'rol'        => $validar['rol'] ?? null,
            'id_personal' => $validar['id_personal'] ?? null,
            'nombre'     => $validar['nombre_personal'] ?? null,
            'apellido'   => $validar['apellido_personal'] ?? null
        ];

        $jwt = \Firebase\JWT\JWT::encode($payload, $secretJWT, 'HS256');

        $bitacora->setId_usuario($validar['id_usuario']);
        $bitacora->setActividad("Ha iniciado sesión desde la aplicación móvil");
        $bitacora->setTabla("inicio sesion");
        $bitacora->insertarBitacora($validar['id_usuario']);

        $respuesta = [
            'ok'      => true,
            'message' => 'Autenticación móvil exitosa.',
            'token'   => $jwt,
            'usuario' => [
                'nombre'   => $validar['nombre_personal'],
                'apellido' => $validar['apellido_personal'],
                'rol'      => $validar['rol']
            ]
        ];

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(Cifrado::cifrarRespuesta($respuesta));
        exit;
    } else {
        // En cas de fallada, sumem un intent erroni a la base de dades

        http_response_code(409);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(Cifrado::cifrarRespuesta(['ok' => false, 'error' => 'Usuario o contraseña incorrectas']));
        exit;
    }
}
