<?php

namespace App\config;

use App\modelos\ModeloPermisos;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Rutas
{
    private $url, $partes, $controlador, $modelo, $equivalentes;
    private $rateLimit;

    public function __construct($url)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->rateLimit = new RateLimiter();
        $this->url = $url;
        $this->modelo = new ModeloPermisos();
        $this->equivalentes = require_once __DIR__ . "/../../src/config/equivalencias.php";
    }

    /* método que utilizamos para gestionar las rutas de todo nuestro sistema */
    public function gestionarRutas()
    {
        $file = false;
        $ip = $_SERVER['REMOTE_ADDR'];
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //validacion rate limit
        $this->rateLimit->setIP($ip);
        // $rateLimit->setEndpoind($metodo);
        // $rateLimit->setLimitePeticiones();

        // pero si la peticion es para un archivo
        $accept_files_extensions = ["css", "js", "png", "jpg", "jpeg", "gif", "svg", "ico"];
        if (in_array(pathinfo($this->url, PATHINFO_EXTENSION), $accept_files_extensions)) {
            $file = true;
        }
        
        else if ($this->rateLimit->evaluarLimiteDB()) {
            header("HTTP/1.1 429 Too Many Requests");
            // header("location: /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/error");
            die("Too Many Requests");
        }


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
            die("Directorio no encontrado");
        }

        require_once __DIR__ . "/../../" . $directorio;

        if (!function_exists($metodo)) {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/error");
            die("Método no encontrado");
        }

        if (in_array($this->controlador, ["ControllerIniciarSesion", "ControllerRecuperarContr"])) {
            call_user_func($metodo, $parametro ?? []);
            return;
        }

        // APP MÓVIL (INTERCEPTOR JWT)............................
        $headers = apache_request_headers();
        // Captura el header sin importar si viene como Authorization, authorization o por las variables globales de servidor
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? null;

        if (isset($authHeader)) {

            $token = str_replace('Bearer ', '', $authHeader);

            try {
                // rsa
                $secrtJWT = $_ENV['JWT_SECRET'];
                $datosToken = \Firebase\JWT\JWT::decode($token, new Key($secrtJWT, 'HS256'));

                $_SESSION['id_usuario'] = $datosToken->id_usuario;

                //  Asegurar mapeo correcto del ID de Rol desde el objeto JWT
                $_SESSION['id_rol']     = $datosToken->id_rol ?? ($datosToken->rol ?? null);

                call_user_func($metodo, $parametro ?? []);
                exit;
            } catch (\Exception $e) {
                if (ob_get_length()) ob_clean();
                header("Content-Type: application/json; charset=utf-8");
                http_response_code(401);
                echo json_encode([
                    'ok' => false,
                    'error' => 'Sesión móvil expirada o inválida. Por favor, vuelva a ingresar sus credenciales en la App.'
                ]);
                exit;
            }
        }
        // VISTAS WEB............. 
        // Corregida sintaxis de validación de sesión activa
        // if (session_status() !== PHP_SESSION_ACTIVE) {
        //     echo "Session no iniciada";
        //     return;
        // } Otra vez, esto esta en el construct, por Dios
        
        
        $sessionId = session_id();
        $this->rateLimit->setSessionId($sessionId);

        if (!$file && $this->rateLimit->evaluar_rate_limit_by_user()) {
            http_response_code(429);
            echo json_encode(['error' => 'Demasiadas peticiones. Por favor, intente ma tarde.']);
            exit;
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
            die("Módulo no encontrado");
        }

        $this->modelo->setIdModulo($id_modulo);

        $permitido = $this->modelo->gestionarPermisos();

        if (!$permitido) {
            header("location:  /Sistema-del--CEM--JEHOVA-RAFA/Inicio/inicio/permiso");
            die("Permiso denegado");
        }

        //  Ejecución final para peticiones web tradicionales
        call_user_func($metodo, $parametro ?? []);
    }
}



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);