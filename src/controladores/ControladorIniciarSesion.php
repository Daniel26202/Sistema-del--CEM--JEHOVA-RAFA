<?php

use App\modelos\ModeloInicioSesion;
use App\modelos\ModeloBitacora;

class ControladorIniciarSesion
{

    private $modelo;
    private $bitacora;

    function __construct()
    {
        $this->modelo = new ModeloInicioSesion;
        $this->bitacora = new ModeloBitacora();
    }

    public function mostrarIniciarSesion($parametro)
    {
        require_once "./src/vistas/vistaIniciarSesion/iniciarSesion.php";
    }

    public function iniciarSesion()
    {


            // Clave secreta proporcionada por Google.
            $claveSecreta = '6Le_rOgqAAAAAMEKli0Bp9zdh8i_haVpS008lTxc';
            // Este token está incluido automáticamente en los datos del formulario bajo el nombre 'g-recaptcha-response'.
            $token = $_POST['g-recaptcha-response'];
            // Esto es para agregar una capa adicional de seguridad.(opcional).
            $ip = $_SERVER['REMOTE_ADDR'];
            // Aquí es donde se enviara la solicitud para validar el token generado en el cliente.
            $url = 'https://www.google.com/recaptcha/api/siteverify';

            // guardamos los datos en un array.
            $datos = array(
                'secret' => $claveSecreta,
                'response' => $token,
                // Dirección IP del usuario.
                'remoteip' => $ip
            );

            // Configuración de la solicitud HTTP mediante método POST.
            $options = array(
                'http' => array(
                    // Configura los encabezados para que la API sepa cómo procesar los datos.
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    // definimos el método de la solicitud como POST.
                    'method' => 'POST',
                    // Codifica los datos como una cadena de consulta para enviarlos en el cuerpo de la solicitud.
                    'content' => http_build_query($datos)
                )
            );

            // Esto será utilizado para enviar la solicitud a la API de Google.
            $contexto = stream_context_create($options);
            // file_get_contents envía la solicitud HTTP y recibe la respuesta en formato JSON.
            $respuesta = file_get_contents($url, false, $contexto);
            // Decodifica la respuesta JSON en un arreglo asociativo de PHP.
            $result = json_decode($respuesta, true);

            // Verifica si la respuesta de la API indica éxito ('success' == true).
            if ($result['success']) {


                if ($_POST['usuario'] === '' or $_POST['password'] === '') {

                    header("location: /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/mostrarIniciarSesion/campos");

                } else {

                    $validar = $this->modelo->validarIniciarSesion($_POST['usuario'], $_POST['password']);

                    if ($validar) {

                        session_start();
                        $_SESSION['usuario'] = $_POST['usuario'];
                        $_SESSION['rol'] = $validar['rol'];
                        $_SESSION['id_usuario'] = $validar['id_usuario'];
                        $_SESSION['nombre'] = $validar['nombre_personal'];
                        $_SESSION['apellido'] = $validar['apellido_personal'];

                        $this->bitacora->insertarBitacora($_SESSION['id_usuario'],"inicio sesion","Ha iniciado una session");

                        header("location: /Sistema-del--CEM--JEHOVA-RAFA/Inicio/inicio");

                    } else {

                        header("location: /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/mostrarIniciarSesion/mensaje");

                    }
                }



            } else {
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/mostrarIniciarSesion/captcha");
            }

        }
    }




?>