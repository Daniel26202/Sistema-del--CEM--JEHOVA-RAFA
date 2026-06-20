<?php

use App\modelos\ModeloInicioSesion;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloUsuarios;
// use Firebase\JWT\JWT;
// require_once __DIR__ . "/../config/config.php";

function mostrarIniciarSesion($parametro)
{
    $ayuda = "btnayudaIniciarSesion";
    require_once __DIR__ . "/../../src/vistas/vistaIniciarSesion/iniciarSesion.php";
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
        $bitacora->setId_usuario($validar['id_usuario']);
        $bitacora->setActividad("Ha iniciado una session");
        $bitacora->setTabla("inicio sesion");

        $bitacora->insertarBitacora();
        //websoket
        $host = '127.0.0.1';
        $puerto = 8080;

        $socket_activo = @fsockopen($host, $puerto, $errno, $errstr, 1);

        if (!$socket_activo) {

            $ruta_base = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "webSocket.php";
            $ruta_real = realpath($ruta_base);

            if ($ruta_real && file_exists($ruta_real)) {

                //para windows
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {

                    $php_exe = "C:\\xampp\\php\\php.exe";

                    if (!file_exists($php_exe)) {

                        $php_exe = "D:\\xampp\\php\\php.exe";
                    }

                    if (file_exists($php_exe)) {
                        pclose(popen("start /B \"\" \"$php_exe\" \"$ruta_real\" > NUL 2>&1", "r"));
                    } else {
                        error_log("JEHOVA-RAFA: No se encontró php.exe en las rutas de XAMPP.");
                    }
                } else {
                    //para linux
                    exec("php \"$ruta_real\" > /dev/null 2>&1 &");
                }

                usleep(500000); // 0.5 segundos
            } else {
                error_log("JEHOVA-RAFA Error: No se encontró webSocket.php en: " . ($ruta_real ?: $ruta_base));
            }
        } else {

            fclose($socket_activo);
        }

        echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
    } else {


        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $validar]);
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





function iniciarSesionMovil()
{
    $modelo = new ModeloInicioSesion();
    $bitacora = new ModeloBitacora();

    // Llegim el JSON en cru enviat per la App / Thunder Client
    $jsonContenido = file_get_contents('php://input');
    $datosInput = json_decode($jsonContenido, true);

    $userParam = $datosInput['username'] ?? '';
    $passParam = $datosInput['password'] ?? '';

    // Validació de camps buits
    if ($userParam === '' || $passParam === '') {
        http_response_code(409);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => false, 'error' => 'Camps buits']);
        exit;
    }

    $ipCliente = $_SERVER['REMOTE_ADDR'];
    $modelo->setIpUsuario($ipCliente);



    $modelo->setUsuario($userParam);
    $modelo->setPassword($passParam);

    $data = [
        "usuario" => $modelo->getUsuario()
    ];

    $validarUsuarioExistente = $modelo->validarUsuarioExistente($data);
    $validar = $modelo->validarIniciarSesion($data);

    $modelo->setIdUsuario($validarUsuarioExistente != false ? $validarUsuarioExistente['id_usuario'] : null);

    if ($validar) {
        $modelo->setIdUsuario($validar['id_usuario']);


        // Sigue directo al JWT
        $clavePrivada = file_get_contents(__DIR__ . '/../../src/config/keys/private.key');

        $payload = [
            'iss'        => $_ENV['url_sistema_web'],
            'iat'        => time(),
            'exp'        => time() + (60 * 60 * 36),
            'id_usuario' => $validar['id_usuario'],
            'id_rol'     => $validar['id_rol'],
            'usuario'    => $userParam,
            'rol'        => $validar['rol'] ?? null,
            'id_personal' => $validar['id_personal'] ?? null,
            'nombre'     => $validar['nombre_personal'] ?? null,
            'apellido'   => $validar['apellido_personal'] ?? null
        ];

        $jwt = \Firebase\JWT\JWT::encode($payload, $clavePrivada, 'RS256');

        $bitacora->setId_usuario($validar['id_usuario']);
        $bitacora->setActividad("Ha iniciado sesión desde la aplicación móvil");
        $bitacora->setTabla("inicio sesion");
        $bitacora->insertarBitacora($validar['id_usuario']);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'ok'      => true,
            'message' => 'Autenticación móvil exitosa.',
            'token'   => $jwt,
            'usuario' => [
                'nombre'   => $validar['nombre_personal'],
                'apellido' => $validar['apellido_personal'],
                'rol'      => $validar['rol']
            ]
        ]);
        exit;
    } else {
        // En cas de fallada, sumem un intent erroni a la base de dades

        http_response_code(409);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => false, 'error' => 'Usuario o contraseña incorrectas']);
        exit;
    }
}
