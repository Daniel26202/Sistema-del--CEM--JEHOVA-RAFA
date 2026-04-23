<?php

namespace App\config;

use App\modelos\ModeloPermisos;
use App\config\ValidationIP;

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
        ///esta seccion es para validar el blacklist y el white list
        $validationIP = new ValidationIP();
        $validationIP->setIpUsuario($_SERVER['REMOTE_ADDR']);
        $validationIP->setIdUsuario((isset($_SESSION['id_usuario'])) ? $_SESSION['id_usuario'] : null);

        if ($validationIP->verificationIp()) {
            session_destroy();
            header('location: /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/mostrarIniciarSesion/bloqued');
            return;
        }///

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
        if (!file_exists($directorio)) {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/error");
            return;
        }

        require_once __DIR__ . "/../../" . $directorio;

        if (!function_exists($metodo)) {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/error");
        }
        if (in_array($this->controlador, ["ControllerIniciarSesion", "ControllerRecuperarContr"])) {
            call_user_func($metodo, $parametro ?? []);
            return;
        }
        /*  si el estatus de la session es activio validamos los permisos */
        if (!session_status() === PHP_SESSION_ACTIVE) {
            echo "Session no iniciada";
            return;
        }

        if ($this->controlador == "ControllerInicio" || $this->controlador == "ControllerPerfil" || $this->controlador == "ControllerBitacora" || $this->controlador == 'ControllerPermisos') {
            call_user_func($metodo, $parametro ?? []);
            return;
        }

        if (empty($_SESSION['id_rol'])) {
            session_destroy();
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/");
            return;
        }

        $permiso = $this->equivalentes[$metodo] ?? $metodo;
        $this->modelo->setIdRol($_SESSION['id_rol']);
        $this->modelo->setPermiso($permiso);
        $this->modelo->setModulo($modulo);

        $id_modulo = $this->modelo->returnIdModule();

        if (!$id_modulo) {
            header("location:  /Sistema-del--CEM--JEHOVA-RAFA/Inicio/inicio/permiso");
            exit;
        }

        $this->modelo->setIdModulo($id_modulo);

        $permitido = $this->modelo->gestionarPermisos();

        if (!$permitido) {
            header("location:  /Sistema-del--CEM--JEHOVA-RAFA/Inicio/inicio/permiso");
            exit;
        }

        call_user_func($metodo, $parametro ?? []);
        // echo ($_SERVER['REMOTE_ADDR']);
    }
}
