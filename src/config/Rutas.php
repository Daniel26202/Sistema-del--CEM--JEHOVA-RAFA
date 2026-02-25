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

        $this->equivalentes = require_once __DIR__ . "/../../src/config/equivalencias.php";
    }

    /* metodo que utilizamos para gestionar las rutas de todo nuestro sistema */
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

        $this->controlador = "Controller" . $this->controlador;

        $directorio = "src/controllers/" . $this->controlador . ".php";

        if (file_exists($directorio)) {
            require_once __DIR__ . "/../../" . $directorio;

            if (function_exists($metodo)) {
                if (in_array($this->controlador, ["ControllerIniciarSesion", "ControllerRecuperarContr"])) {

                    call_user_func($metodo, $parametro ?? []);
                } else {

                    /*  si el estatus de la session es activio validamos los permisos */
                    if (session_status() === PHP_SESSION_ACTIVE) {
                        if ($this->controlador == "ControllerInicio" || $this->controlador == "ControllerPerfil" || $this->controlador == "ControllerBitacora") {
                            call_user_func($metodo, $parametro ?? []);
                        } else {
                            if(empty($_SESSION['id_rol'])){
                                session_destroy();
                                header("location: /Sistema-del--CEM--JEHOVA-RAFA/");
                                return;
                            }
                            $permiso = $this->equivalentes[$metodo] ?? $metodo;

                            $this->modelo->setIdRol($_SESSION['id_rol']);
                            $this->modelo->setPermiso('%'.$permiso.'%');
                            $this->modelo->setModulo($modulo);
                            
                            $permitido = $this->modelo->gestionarPermisos();
                    
                            if (!$permitido) {
                                header("location:  /Sistema-del--CEM--JEHOVA-RAFA/Inicio/inicio/permiso");
                                exit;
                            } else {
                                call_user_func($metodo, $parametro ?? []);                   
                            }
                        }
                    } else {
                        
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
