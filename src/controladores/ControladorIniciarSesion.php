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

        }
    }

}


?>