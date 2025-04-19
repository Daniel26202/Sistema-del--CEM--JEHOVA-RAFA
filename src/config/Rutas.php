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

    public function gestionarRutas()
    {
        $this->partes = explode("/", $this->url);
        $this->controlador = ucfirst($this->partes[0] ?? "");
        $metodo = $this->partes[1] ?? "IniciarSesion";
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
                    if (session_status() === PHP_SESSION_ACTIVE) {
                        if ($this->controlador == "ControladorInicio") {
                            $instancia->$metodo($parametro ?? []);
                        } else {
                            
                            $permiso = $this->equivalentes[$metodo] ?? $metodo;
                            $permitido = $this->modelo->gestionarPermisos($_SESSION["id_rol"] ?? null, $permiso, $modulo);
                            if (!$permitido) {
                                echo "Error 404";
                                exit;
                            } else {
                                $instancia->$metodo($parametro ?? []);
                            }
                        }
                    } else {
                        echo "Sesión no iniciada";
                    }
                }
            } else {
                echo "NO EXISTE EL MÉTODO";
            }
        } else {
            echo "NO EXISTE EL CONTROLADOR";
        }
    }
}
