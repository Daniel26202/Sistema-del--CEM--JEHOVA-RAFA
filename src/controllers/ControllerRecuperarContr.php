<?php

use App\modelos\ModeloRecuperarContr;
//librería de correo
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function validarCsrfRecuperacion()
{
    $headers = function_exists('getallheaders') ? getallheaders() : [];
    $csrfToken = $headers['X-CSRF-Token']
        ?? $headers['x-csrf-token']
        ?? $_POST['csrf_token']
        ?? null;

    if (empty($_SESSION['recuperacion_csrf_token']) || empty($csrfToken) || !hash_equals($_SESSION['recuperacion_csrf_token'], $csrfToken)) {
        http_response_code(403);
        echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
        exit;
    }
}



// 		semaforo();

// 	 function semaforo()
// 	{
// 		// verifica si la sesión esta activa.
// 		if (session_status() !== PHP_SESSION_ACTIVE) {
// 			session_start();
// 		}
// 		if (!isset($_SESSION['semaforo_mant'])) {
// 			$_SESSION['semaforo_mant'] = 0;
// 		}
// 	}
// // verifica si la sesión esta activa.
// 		if (session_status() !== PHP_SESSION_ACTIVE) {
// 			session_start();
// 		}
// 		if ($_SESSION['semaforo_mant'] === 1) return;
// 		$_SESSION['semaforo_mant'] = 1;
// 		$_SESSION['semaforo_mant'] = 0;




function mostrarRecuperarContr($parametro)
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (empty($_SESSION['recuperacion_csrf_token'])) {
        $_SESSION['recuperacion_csrf_token'] = bin2hex(random_bytes(32));
    }

    require_once __DIR__ . "/../../src/vistas/vistaRecuperarContr/recuperarContr.php";
}

function generarCodigo($correoM, $idUsuario)
{
    // Generamos un código de seis dígitos con un generador criptográfico.
    $codigoV = random_int(100000, 999999);

    // CORREO
    $validarCorreo = false;
    $asunto = "Recuperación de Contraseña";
    $mensaje = "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <title>Recuperación de Contraseña</title>
        </head>
        <body>
            <p><br>Estimado/a usuario/a,<br><br><br>


            Su código de recuperación es: <strong>$codigoV</strong><br><br>

            Por favor, ingrese este código en la aplicación para restablecer su contraseña. Tenga en cuenta que este código expira en 5 minutos.<br><br><br>


            Si no solicitó este cambio, por favor ignore este correo.<br><br><br>


            Atentamente:<br>Clínica JEHOVA RAFA.</p>
        </body>
        </html>";



    // Crear una instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        // correo del sistema 
        $mail->Username = $_ENV["NameCorreoClinica"];
        $mail->Password = $_ENV["PasswordCorreoClinica"];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Opciones de SSL
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // para que acepte los caracteres especiales 
        $mail->CharSet = 'UTF-8';

        // Remitente
        $mail->setFrom($_ENV["NameCorreoClinica"], 'Clínica JEHOVA RAFA');
        // destinatario. correo del usuario
        $mail->addAddress($correoM);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $mensaje; // Convertir saltos de línea a <br> para HTML

        // Enviar el correo
        $mail->send();

        $validarCorreo = true;

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // El usuario objetivo y el código quedan vinculados al servidor.
        $_SESSION['recuperacion'] = [
            'id_usuario' => (int) $idUsuario,
            'correo' => strtolower($correoM),
            'codigo_hash' => password_hash((string) $codigoV, PASSWORD_BCRYPT),
            'expira_en' => time() + 300,
            'verificado' => false,
            'intentos' => 0,
        ];
    } catch (Exception $e) {
        $validarCorreo = "conexionFallida";
        $mensajeError = "Error al enviar el correo: {$mail->ErrorInfo}";
    }

    return $validarCorreo;
}
function reenviarCodigo()
{
    validarCsrfRecuperacion();

    $recuperacion = $_SESSION['recuperacion'] ?? null;
    if (empty($recuperacion['id_usuario']) || empty($recuperacion['correo'])) {
        http_response_code(403);
        echo json_encode(['ok' => false, 'error' => 'No existe una recuperación activa']);
        exit;
    }

    $validarEC = generarCodigo($recuperacion['correo'], $recuperacion['id_usuario']);
    if ($validarEC === "conexionFallida") {
        echo json_encode($validarEC);
    } else {
        echo json_encode(true);
    }
}

function verificarUC()
{
    validarCsrfRecuperacion();
    unset($_SESSION['recuperacion']);

    if (isset($_POST)) {
        $modelo = new ModeloRecuperarContr();
        $correoM = strtolower($_POST["correo"] ?? '');

        $modelo->setUsuario($_POST["usuario"] ?? '');
        $modelo->setCorreo($correoM);
        $res = $modelo->validarUC();
        // si el usuario y el correo es correcto, pasa lo siguiente de lo contrario retorna false
        if ($res) {

            $validarEC = generarCodigo($correoM, $res['id_usuario']);
            if ($validarEC === "conexionFallida") {
                echo json_encode($validarEC);
            } else if ($validarEC === true) {
                // No se devuelve el ID del usuario al navegador.
                echo json_encode(['ok' => true]);
            }
        } else {

            echo json_encode($res);
        }
    }
}

function verificarCodigo()
{
    validarCsrfRecuperacion();

    $recuperacion = $_SESSION['recuperacion'] ?? null;
    if (!$recuperacion || time() > $recuperacion['expira_en']) {
        unset($_SESSION['recuperacion']);
        echo json_encode("CodExpiro");
        exit;
    }

    if ($recuperacion['intentos'] >= 5) {
        echo json_encode("demasiadosIntentos");
        exit;
    }

    $codigo = trim((string) ($_POST['codigo'] ?? ''));
    $recuperacion['intentos']++;

    if (preg_match('/^\d{6}$/', $codigo) && password_verify($codigo, $recuperacion['codigo_hash'])) {
        $recuperacion['verificado'] = true;
        $_SESSION['recuperacion'] = $recuperacion;
        echo json_encode("exitoso");
    } else {
        $_SESSION['recuperacion'] = $recuperacion;
        echo json_encode("codigoIncorrecto");
    }
}

function cambiarC()
{
    validarCsrfRecuperacion();

    $recuperacion = $_SESSION['recuperacion'] ?? null;
    if (!$recuperacion || !$recuperacion['verificado'] || time() > $recuperacion['expira_en']) {
        http_response_code(403);
        echo json_encode("recuperacionInvalida");
        exit;
    }

    $password = (string) ($_POST['passwordNew'] ?? '');
    $passwordConfirmation = (string) ($_POST['passwordConf'] ?? '');
    $passwordValida = preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,12}$/', $password);

    if (!$passwordValida || !hash_equals($password, $passwordConfirmation)) {
        http_response_code(422);
        echo json_encode("passwordInvalida");
        exit;
    }

    $modelo = new ModeloRecuperarContr();
    $modelo->setPassword(password_hash($password, PASSWORD_BCRYPT));
    $modelo->setIdUsuario((string) $recuperacion['id_usuario']);

    if (!$modelo->updatePassword()) {
        http_response_code(500);
        echo json_encode("errorActualizando");
        exit;
    }

    // El código es de un solo uso y la sesión de recuperación se invalida.
    session_unset();
    session_destroy();

    echo json_encode("Actualizado");
}
