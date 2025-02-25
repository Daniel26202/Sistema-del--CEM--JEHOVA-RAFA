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

    public function verificarUC()
    {
        if (isset($_POST)) {
            $correoM = strtolower($_POST["cE"]);
            $res = $this->modelo->validarUC($_POST["usuario"], $correoM);
            // si el usuario y el correo es correcto, pasa lo siguiente de lo contrario retorna false
            if ($res) {
                // Generamos un codigoV de 8 caracteres
                $codigoV = random_int(100000, 999999);

                // Establecer la zona horaria a 'America/Caracas' para ajustar la hora correctamente
                date_default_timezone_set('America/Caracas');
                // Generar la fecha de expiración sumando 15 minutos a la hora actual
                $fechaExpiracion = date('Y-m-d H:i:s', strtotime('+15 minutes'));

                // Agregamos los datos de recuperación de contraseña
                $this->modelo->insertDatosRC($res["id_usuario"], $codigoV, $fechaExpiracion);

                // CORREO
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
                    
                    Por favor, ingrese este código en la aplicación para restablecer su contraseña. Tenga en cuenta que este código expira en 15 minutos.<br><br><br>


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
                    $mail->Username = 'innova304050@gmail.com';
                    $mail->Password = 'gxmvlxeeqofivmxt';
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
                    $mail->setFrom('innova304050@gmail.com', 'Clínica JEHOVA RAFA');
                    // destinatario. correo del usuario
                    $mail->addAddress($correoM);

                    // Contenido del correo
                    $mail->isHTML(true);
                    $mail->Subject = $asunto;
                    $mail->Body = $mensaje; // Convertir saltos de línea a <br> para HTML

                    // Enviar el correo
                    $mail->send();

                } catch (Exception $e) {
                    echo "Error al enviar el correo: {$mail->ErrorInfo}";
                }

            }

            echo json_encode($res);
        }



        ///////////////////////////////////////////////////////////////////////
        // print_r($_POST);


        // me aseguro de que no hayan salidas previas
        // ob_start();
        // // establece el tipo de contenido a JSON
        // header('Content-Type: application/json');
        // $datosF = isset($_POST) ? $_POST : "";
        // // validar que los campos no esten vacíos
        // if (empty($datosF)) {
        //     $respuesta = [
        //         'estado' => 'error',
        //         'mensaje' => 'campos vacío',
        //     ];
        // } else {
        //     $respuesta = [
        //         'estado' => 'success',
        //         'mensaje' => 'formulario procesado correctamente',
        //         'datos' => [
        //             $datosF
        //         ]
        //     ];

        // }
        // // Limpiar cualquier salida previa 
        // ob_end_clean();

    }

    public function verificarCodigo()
    {
        if (isset($_POST)) {

            // Establecer la zona horaria a 'America/Caracas' para ajustar la hora correctamente
            date_default_timezone_set('America/Caracas');
            // Generar la fecha y hora actual
            $fechaHoy = date('Y-m-d H:i:s');

            $fechaDesbloqueo = date('Y-m-d H:i:s', strtotime('+30 minutes'));

            $res = $this->modelo->validarC(1, $_POST["codigo"], $fechaHoy, $fechaDesbloqueo);

            echo json_encode($res);

        }
    }

    // public function cambiarC()
    // {
    //     print_r($_POST);
    //     if (isset($_POST)) {

    //         $ps = $_POST['ps'];
    //         // coloco todas las letras en mayúsculas
    //         $PS = strtoupper($ps);
    //         $valor = $this->modelo->validar($_POST['usuario'], $PS, $_POST['rs']);

    //         if ($valor == 1) {
    //             $this->modelo->update($_POST['usuario'], $_POST['ps'], $_POST['rs'], $_POST['password']);
    //             header("location: ?c=ControladorRecuperarContr/mostrarRecuperarContr&exitoso");
    //         } else {
    //             header("location: ?c=ControladorRecuperarContr/mostrarRecuperarContr&error");
    //         }
    //     }

    // }

}
