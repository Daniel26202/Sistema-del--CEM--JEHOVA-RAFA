<?php

namespace App\config;

// Importa el modelo de permisos
use App\modelos\ModeloPermisos;

class Rutas
{
    // Propiedades privadas de la clase
    private $url, $partes, $controlador, $modelo, $equivalentes;

    // Constructor de la clase
    public function __construct($url)
    {
        // Inicia la sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Asigna la URL proporcionada a la propiedad $url
        $this->url = $url;

        // Crea una instancia del modelo de permisos
        $this->modelo = new ModeloPermisos();

        // Carga el archivo de equivalencias y lo asigna a $equivalentes
        $this->equivalentes = require_once "./src/config/equivalencias.php";
    }

    //metodo utilizado para gestionar las rutas
    public function gestionarRutas()
    {
        // dividir la URL en partes separadas por "/"
        $this->partes = explode("/", $this->url);

        // se verifica si la URL contiene ".php"
        if (strpos($this->url, ".php") !== false) {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/error");
            exit;
        }
        // obtienemos el controlador de la primera parte del array $this->partes 
        $this->controlador = ucfirst($this->partes[0]);

        // obtienemos el metodo del controlador de la segunda parte del array $this->partes
        $metodo = $this->partes[1];

        //el parámetro se inicia  como una cadena vacía
        $parametro = "";

        // se asigna el nombre del controlador a la variable modulo
        $modulo =  $this->controlador;

        // si hay más partes en la url, las concatena como parámetros es decir todo lo que venga despues del metodo es un parametro
        if (isset($this->partes[2])) {
            for ($i = 2; $i < count($this->partes); $i++) {
                $parametro .= $this->partes[$i] . ",";
            }
            // aqui se elimina la última coma y convierte los parámetros en un array para menejarlos de una manera mas secilla 
            $parametro = trim($parametro, ",");
            $parametro = explode(",", $parametro);
        }

        // se prepara el nombre del controlador añadiendole  "Controlador" ejemplo ControladorInicio
        $this->controlador = "Controlador" . $this->controlador;

        // defimos la direccion del archivo del controlador
        $directorio = "src/controladores/" . $this->controlador . ".php";

        // verificacion si el archivo del controlador existe
        if (file_exists($directorio)) {
            // incluimos el archivo del controlador
            require_once $directorio;

            // se crea una instancia del controlador
            $instancia = new $this->controlador();

            // verifica si el método existe en el controlador llamado
            if (method_exists($instancia, $metodo)) {
                // si el controlador es de inicio de sesión o recuperación de contraseña
                if (in_array($this->controlador, ["ControladorIniciarSesion", "ControladorRecuperarContr"])) {
                    // llama al método con los parámetros ya que obviamente no se necesita permiso para el login o recuperacion de contraseña
                    $instancia->$metodo($parametro ?? []);
                } else {
                    //validacion de los permisos
                    // primero si la sesión está activa
                    if (session_status() === PHP_SESSION_ACTIVE) {
                        // si el controlador es incio o peril o bitacora, llama al método directamente y no aplica permisologia
                        if ($this->controlador == "ControladorInicio" || $this->controlador == "ControladorPerfil" || $this->controlador == "ControladorBitacora") {
                            $instancia->$metodo($parametro ?? []);
                        } else {
                            // obtenemos el permiso equivalente del método si no encuentra la equivalencia le pasa el noombre del metodo
                            $permiso = $this->equivalentes[$metodo] ?? $metodo;

                            // se verifica si el usuario tiene permiso para acceder gestionarPermisos este metodo el del modelo permisos
                            $permitido = $this->modelo->gestionarPermisos($_SESSION["id_rol"] ?? null, $permiso, $modulo);
                            // si no tiene permiso, redirige a la página de error :( 
                            if (!$permitido) {
                                echo "Error 404 ";
                                header("location:  /Sistema-del--CEM--JEHOVA-RAFA/Inicio/inicio");
                                exit;
                            } else {
                                // si lo tiene 
                                $instancia->$metodo($parametro ?? []);
                            }
                        }
                    } else {
                        // Si la sesión no está iniciada, muestra un mensaje
                        echo "Sesión no iniciada";
                    }
                }
            } else {  
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/error"); //lo mando a la pagina de error
            }
        } else {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/error"); //Si el controlador no wxiste lo llama
        }
    }
}
