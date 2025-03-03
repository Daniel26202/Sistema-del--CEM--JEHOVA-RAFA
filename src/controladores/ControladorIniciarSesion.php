<?php

use App\modelos\ModeloInicioSesion;

class ControladorIniciarSesion
{

    private $modelo;

    function __construct()
    {
        $this->modelo = new ModeloInicioSesion;
    }

    public function mostrarIniciarSesion()
    {
        require_once "./src/vistas/vistaIniciarSesion/iniciarSesion.php";
    }

    public function iniciarSesion()
    {

        if (isset($_POST['validar'])) {

            // Clave secreta proporcionada por Google reCAPTCHA.
            $claveSecreta = '6Le_rOgqAAAAAMEKli0Bp9zdh8i_haVpS008lTxc';
            // Este token está incluido automáticamente en los datos del formulario bajo el nombre 'g-recaptcha-response'.
            $token = $_POST['g-recaptcha-response'];
            // Esto puede ser útil para agregar una capa adicional de seguridad.(opcional).
            $ip = $_SERVER['REMOTE_ADDR'];
            // Aquí es donde enviarás la solicitud para validar el token generado en el cliente.
            $url = 'https://www.google.com/recaptcha/api/siteverify';

            // Incluyen la clave secreta, el token del cliente y la dirección IP del usuario.
            $datos = array(
                'secret' => $claveSecreta,
                // Clave secreta
                'response' => $token,
                // Token generado por el cliente
                'remoteip' => $ip // Dirección IP del usuario (opcional)
            );

            // Configuración de la solicitud HTTP mediante método POST.
            $options = array(
                'http' => array(
                    // Configura los encabezados para que la API sepa cómo procesar los datos.
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    // Define el método de la solicitud como POST.
                    'method' => 'POST',
                    // Codifica los datos como una cadena de consulta para enviarlos en el cuerpo de la solicitud.
                    'content' => http_build_query($datos)
                )
            );

            // Esto será utilizado para enviar la solicitud a la API de Google.
            $context = stream_context_create($options);
            // file_get_contents envía la solicitud HTTP y recibe la respuesta en formato JSON.
            $response = file_get_contents($url, false, $context);
            // Decodifica la respuesta JSON en un arreglo asociativo de PHP.
            $result = json_decode($response, true);

            // Verifica si la respuesta de la API indica éxito ('success' == true).
            if ($result['success']) {


                if ($_POST['usuario'] === '' or $_POST['password'] === '') {

                    header("location: ?c=ControladorIniciarSesion/mostrarIniciarSesion&campos");

                } else {

                    $validar = $this->modelo->validarIniciarSesion($_POST['usuario'], $_POST['password']);

                    if ($validar) {

                        session_start();
                        $_SESSION['usuario'] = $_POST['usuario'];
                        $_SESSION['rol'] = $validar['rol'];
                        $_SESSION['id_usuario'] = $validar['id_usuario'];

                        header("location: ?c=ControladorInicio/inicio");

                    } else {

                        header("location: ?c=ControladorIniciarSesion/mostrarIniciarSesion&mensaje");

                    }
                }



            } else {
                    header("location: ?c=ControladorIniciarSesion/mostrarIniciarSesion&captcha");
            }

        }
    }

}


?>