<?php

use App\modelos\ModeloRecuperarContr;
//librería de correo
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ControladorRecuperarContr
{

    private $modelo;

    function __construct()
    {
        $this->modelo = new ModeloRecuperarContr();
    }


    public function mostrarRecuperarContr()
    {
        require_once "./src/vistas/vistaRecuperarContr/recuperarContr.php";
    }

    public function generarCodigo($idUsuario, $correoM)
    {
        // Generamos un codigoV de 8 caracteres
        $codigoV = random_int(100000, 999999);

        // Establecer la zona horaria a 'America/Caracas' para ajustar la hora correctamente
        date_default_timezone_set('America/Caracas');
        // Generar la fecha de expiración sumando 15 minutos a la hora actual
        $fechaExpiracion = date('Y-m-d H:i:s', strtotime('+1 minutes'));

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

            Por favor, ingrese este código en la aplicación para restablecer su contraseña. Tenga en cuenta que este código expira en 4 minutos.<br><br><br>


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
            $mail->Username = 'sistemajehovarafatrayectoiii@gmail.com';
            $mail->Password = 'zamcdjqyqnyklmrj';
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
            $mail->setFrom('sistemajehovarafatrayectoiii@gmail.com', 'Clínica JEHOVA RAFA');
            // destinatario. correo del usuario
            $mail->addAddress($correoM);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body = $mensaje; // Convertir saltos de línea a <br> para HTML

            // Enviar el correo
            $mail->send();

            $validarCorreo = true;

            // verifica si la sesión esta activa.
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            $_SESSION["codigo"] = $codigoV;
            $_SESSION["fechaExpiracion"] = $fechaExpiracion;
            $_SESSION["correoD"] = $correoM;

        } catch (Exception $e) {
            $validarCorreo = false;
            $mensajeError = "Error al enviar el correo: {$mail->ErrorInfo}";
        }

        return $validarCorreo;

    }

    public function verificarUC()
    {
        if (isset($_POST)) {
            $correoM = strtolower($_POST["cE"]);
            $res = $this->modelo->validarUC($_POST["usuario"], $correoM);
            // si el usuario y el correo es correcto, pasa lo siguiente de lo contrario retorna false
            if ($res) {


                $validarEC = $this->generarCodigo($res["id_usuario"], $correoM);
                if ($validarEC == false) {
                    echo json_encode("conexionFallida");

                } else {

                    // enviado con éxito
                    echo json_encode($res);
                }

            } else {

                echo json_encode($res);
            }

        }

    }

    public function verificarCodigo()
    {
        if (isset($_POST)) {

            // Establecer la zona horaria a 'America/Caracas' para ajustar la hora correctamente
            date_default_timezone_set('America/Caracas');
            // Generar la fecha y hora actual
            $fechaHoy = date('Y-m-d H:i:s');

            // verifica si la sesión esta activa.
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            if ($fechaHoy >= $_SESSION["fechaExpiracion"]) {
                // echo "se expiro el código";
                echo json_encode("CodExpiro");
            } else {

                if ($_POST["codigo"] == $_SESSION["codigo"] && $_POST["correo"] == $_SESSION["correoD"]) {

                    // $this->modelo->updatePassword($_POST["id_usuario"],$newPassword);

                    echo json_encode("exitoso");
                } else {
                    // codigoIncorrecto;
                    echo json_encode("codigoIncorrecto");
                }
            }


        }
    }

    public function cambiarC()
    {
        if (isset($_POST)) {
            // Generamos la contraseña encriptada de la contraseña ingresada
            $passwordEncrip = password_hash($_POST["passwordNew"], PASSWORD_BCRYPT);

            $this->modelo->updatePassword($_POST["id_usuario"], $passwordEncrip);
            // verifica si la sesión esta activa.
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            // Destruyen las variables de las sesión 
            session_unset();
            // Destruir la sesión
            session_destroy();

            echo json_encode("Actualizado");


        }

    }

}
