<?php

use App\modelos\ModeloInicioSesion;
use App\modelos\ModeloBitacora;

function mostrarIniciarSesion($parametro)
{
    $ayuda = "btnayudaIniciarSesion";
    require_once __DIR__ . "/../../src/vistas/vistaIniciarSesion/iniciarSesion.php";
}

// iniciar sesión 
function logIn($parametro)
{

    $modelo = new ModeloInicioSesion(true);
    $bitacora = new ModeloBitacora(true);
}

function iniciarSesion()
{
    $modelo = new ModeloInicioSesion(false);
    $bitacora = new ModeloBitacora(false);



    // if (isset($_POST)) {
    //     // Clave secreta proporcionada por Google.
    //     $claveSecreta = '6Le_rOgqAAAAAMEKli0Bp9zdh8i_haVpS008lTxc';
    //     // Este token está incluido automáticamente en los datos del formulario bajo el nombre 'g-recaptcha-response'.
    //     $token = $_POST['g-recaptcha-response'];
    //     // Esto es para agregar una capa adicional de seguridad.(opcional).
    //     $ip = $_SERVER['REMOTE_ADDR'];
    //     // Aquí es donde se enviara la solicitud para validar el token generado en el cliente.
    //     $url = 'https://www.google.com/recaptcha/api/siteverify';
    //     if (isset($_POST)) {
    //         // Clave secreta proporcionada por Google.
    //         $claveSecreta = '6Le_rOgqAAAAAMEKli0Bp9zdh8i_haVpS008lTxc';
    //         // Este token está incluido automáticamente en los datos del formulario bajo el nombre 'g-recaptcha-response'.
    //         $token = $_POST['g-recaptcha-response'];
    //         // Esto es para agregar una capa adicional de seguridad.(opcional).
    //         $ip = $_SERVER['REMOTE_ADDR'];
    //         // Aquí es donde se enviara la solicitud para validar el token generado en el cliente.
    //         $url = 'https://www.google.com/recaptcha/api/siteverify';

    //         // guardamos los datos en un array.
    //         $datos = array(
    //             'secret' => $claveSecreta,
    //             'response' => $token,
    //             // Dirección IP del usuario.
    //             'remoteip' => $ip
    //         );

    //         // Configuración de la solicitud HTTP mediante método POST.
    //         $options = array(
    //             'http' => array(
    //                 // Configura los encabezados para que la API sepa cómo procesar los datos.
    //                 'header' => "Content-type: application/x-www-form-urlencoded\r\n",
    //                 // definimos el método de la solicitud como POST.
    //                 'method' => 'POST',
    //                 // Codifica los datos como una cadena de consulta para enviarlos en el cuerpo de la solicitud.
    //                 'content' => http_build_query($datos)
    //             )
    //         );

    //         // Esto será utilizado para enviar la solicitud a la API de Google.
    //         $contexto = stream_context_create($options);
    //         // file_get_contents envía la solicitud HTTP y recibe la respuesta en formato JSON.
    //         $respuesta = file_get_contents($url, false, $contexto);
    //         // Decodifica la respuesta JSON en un arreglo asociativo de PHP.
    //         $result = json_decode($respuesta, true);

    //         // Verifica si la respuesta de la API indica éxito ('success' == true).
    //         if ($result['success']) {


    // if ($_POST['usuario'] === '' or $_POST['password'] === '') {

    //     header("location: /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/mostrarIniciarSesion/campos");
    // } else {
    $modelo->setUsuario($_POST['username']);
    $modelo->setPassword($_POST['password']);



    $data = [
        "usuario" => $modelo->getUsuario()
    ];

    $validar = $modelo->validarIniciarSesion($data);




    if ($validar) {
        // Asegurarse de iniciar sesión antes de usar $_SESSION para evitar warnings que rompan el JSON
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $session_inciada_por_usuario = isset($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";

        // Si ya existe una sesión activa para el usuario devolvemos conflicto
        if ($session_inciada_por_usuario) {
            http_response_code(409);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['ok' => false, 'error' => 'session_active']);
            exit;
        }

        // Inicializar variables de sesión
        $_SESSION['usuario'] = $_POST['username'];
        $_SESSION['rol'] = $validar['rol'] ?? null;
        $_SESSION['id_rol'] = $validar['id_rol'] ?? null;
        $_SESSION['id_usuario'] = $validar['id_usuario'] ?? null;
        $_SESSION['id_personal'] = $validar['id_personal'] ?? null;
        $_SESSION['nombre'] = $validar['nombre_personal'] ?? null;
        $_SESSION['apellido'] = $validar['apellido_personal'] ?? null;
        $bitacora->setId_usuario($_SESSION['id_usuario']);
        $bitacora->setActividad("Ha iniciado una session");
        $bitacora->setTabla("inicio sesion");

        $bitacora->insertarBitacora();

        // ============================================================
        // LÓGICA WEBSOCKET MULTIPLATAFORMA (WINDOWS / LINUX)
        // ============================================================
        $host = '127.0.0.1';
        $puerto = 8080;

        // 1. Verificamos si el socket ya está escuchando (timeout rápido de 1s)
        $socket_activo = @fsockopen($host, $puerto, $errno, $errstr, 1);

        if (!$socket_activo) {
            // 2. Construcción de ruta robusta usando realpath
            $ruta_base = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "webSocket.php";
            $ruta_real = realpath($ruta_base);

            if ($ruta_real && file_exists($ruta_real)) {

                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    // 1. Buscamos el ejecutable de PHP de forma manual y segura
                    $php_exe = "C:\\xampp\\php\\php.exe";

                    if (!file_exists($php_exe)) {
                        // Si no está en C, probamos en D (común en instalaciones personalizadas)
                        $php_exe = "D:\\xampp\\php\\php.exe";
                    }
                    // 2. Ejecución Directa sin 'start' para evitar que se abra en VS Code
                    // Usamos 'popen' con 'w' y mandamos la salida a NUL
                    // Esto lo lanza en segundo plano real sin abrir ventanas ni editores
                    if (file_exists($php_exe)) {
                        pclose(popen("start /B \"\" \"$php_exe\" \"$ruta_real\" > NUL 2>&1", "r"));
                    } else {
                        error_log("JEHOVA-RAFA: No se encontró php.exe en las rutas de XAMPP.");
                    }
                } else {
                    // Linux se mantiene igual, ya que 'php' en consola no abre editores
                    exec("php \"$ruta_real\" > /dev/null 2>&1 &");
                }

                // 3. Pausa estratégica para permitir el "Handshake" inicial del proceso
                usleep(500000); // 0.5 segundos
            } else {
                error_log("JEHOVA-RAFA Error: No se encontró webSocket.php en: " . ($ruta_real ?: $ruta_base));
            }
        } else {
            // Si ya existe, cerramos la conexión de prueba
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
// }

//Metodo para mostrar la vista de la pagina de error ç
function error()
{
    require_once __DIR__ . "/../../src/vistas/vistaIniciarSesion/vistaError.php";
}
