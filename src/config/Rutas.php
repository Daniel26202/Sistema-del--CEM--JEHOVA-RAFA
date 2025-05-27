<?php
namespace App\config;
use App\modelos\ModeloPermisos;

class Rutas
{
    private $url, $partes, $controlador, $modelo, $equivalentes;

    public function __construct($url)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->url = $url;
        $this->modelo = new ModeloPermisos();
        $this->equivalentes = require_once "./src/config/equivalencias.php";
    }

    /* metodo utilizado para gestionar las rutas de todo nuestro sistema */
    public function gestionarRutas()
    {
        $this->partes = explode("/", $this->url);
        if (strpos($this->url, ".php") !== false) {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/error");
            exit;
        }

        $this->controlador = ucfirst($this->partes[0]);

        $metodo = $this->partes[1];

        $parametro = "";

        $modulo =  $this->controlador;

        if (isset($this->partes[2])) {
            for ($i = 2; $i < count($this->partes); $i++) {
                $parametro .= $this->partes[$i] . ",";
            }
            $parametro = trim($parametro, ",");
            $parametro = explode(",", $parametro);
        }

        $this->controlador = "Controlador" . $this->controlador;

        $directorio = "src/controladores/" . $this->controlador . ".php";

        if (file_exists($directorio)) {
            require_once $directorio;
            $instancia = new $this->controlador();

            if (method_exists($instancia, $metodo)) {
                if (in_array($this->controlador, ["ControladorIniciarSesion", "ControladorRecuperarContr"])) {
                    $instancia->$metodo($parametro ?? []);
                } else {

                   /*  si el estatus de la session es activio validamos los permisos */
                    if (session_status() === PHP_SESSION_ACTIVE) {
                        if ($this->controlador == "ControladorInicio" || $this->controlador == "ControladorPerfil" || $this->controlador == "ControladorBitacora") {
                            $instancia->$metodo($parametro ?? []);
                        } else {
                            // obtenemos el permiso equivalente del método si no encuentra la equivalencia le pasa el noombre del metodo "Cabe destacar que la equivalencias la sacamos de un array grande de otro achivo llamado equivalencias.php"
                            $permiso = $this->equivalentes[$metodo] ?? $metodo;

                            /* verifica con el metodo gestionarPermisos si tiene permiso de ir a ese modulo */
                            $permitido = $this->modelo->gestionarPermisos($_SESSION["id_rol"] ?? null, $permiso, $modulo);
                            if (!$permitido) {
                                echo "Error 404 ";
                                header("location:  /Sistema-del--CEM--JEHOVA-RAFA/Inicio/inicio");
                                exit;
                            } else {
                                 /* si lo tiene */
                                $instancia->$metodo($parametro ?? []);
                            }
                        }
                    } else {
                        /* Si la sesión no está iniciada, muestra un mensaje */
                        echo "Sesión no iniciada";
                    }
                }
            } else {  
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/error"); 
            }
        } else {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/error");
        }
    }
}