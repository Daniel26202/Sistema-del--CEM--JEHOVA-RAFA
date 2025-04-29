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

    // Método principal para gestionar las rutas
    public function gestionarRutas()
    {
        // Divide la URL en partes separadas por "/"
        $this->partes = explode("/", $this->url);

        // Obtiene el controlador de la primera parte de la URL (capitalizado)
        $this->controlador = ucfirst($this->partes[0] ?? "");

        // Obtiene el método de la segunda parte de la URL o usa "IniciarSesion" por defecto
        $metodo = $this->partes[1] ?? "IniciarSesion";

        // Inicializa el parámetro como una cadena vacía
        $parametro = "";

        // Asigna el nombre del módulo al controlador
        $modulo =  $this->controlador;

        // Si hay más partes en la URL, las concatena como parámetros
        if (isset($this->partes[2])) {
            for ($i = 2; $i < count($this->partes); $i++) {
                $parametro .= $this->partes[$i] . ",";
            }
            // Elimina la última coma y convierte los parámetros en un array
            $parametro = trim($parametro, ",");
            $parametro = explode(",", $parametro);
        }

        // Prepara el nombre del controlador con el prefijo "Controlador"
        $this->controlador = "Controlador" . $this->controlador;

        // Define la ruta del archivo del controlador
        $directorio = "src/controladores/" . $this->controlador . ".php";

        // Verifica si el archivo del controlador existe
        if (file_exists($directorio)) {
            // Incluye el archivo del controlador
            require_once $directorio;

            // Crea una instancia del controlador
            $instancia = new $this->controlador();

            // Verifica si el método existe en el controlador
            if (method_exists($instancia, $metodo)) {
                // Si el controlador es de inicio de sesión o recuperación de contraseña
                if (in_array($this->controlador, ["ControladorIniciarSesion", "ControladorRecuperarContr"])) {
                    // Llama al método con los parámetros
                    $instancia->$metodo($parametro ?? []);
                } else {
                    // Verifica si la sesión está activa
                    if (session_status() === PHP_SESSION_ACTIVE) {
                        // Si el controlador es Inicio o Perfil, llama al método directamente
                        if ($this->controlador == "ControladorInicio" || $this->controlador == "ControladorPerfil") {
                            $instancia->$metodo($parametro ?? []);
                        } else {
                            // Obtiene el permiso equivalente del método
                            $permiso = $this->equivalentes[$metodo] ?? $metodo;

                            // Verifica si el usuario tiene permiso para acceder
                            $permitido = $this->modelo->gestionarPermisos($_SESSION["id_rol"] ?? null, $permiso, $modulo);

                            // Si no tiene permiso, redirige a la página de error
                            if (!$permitido) {
                                echo "Error 404 ";
                                header("location:  /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/error");
                                exit;
                            } else {
                                // Si tiene permiso, llama al método con los parámetros
                                $instancia->$metodo($parametro ?? []);
                            }
                        }
                    } else {
                        // Si la sesión no está iniciada, muestra un mensaje
                        echo "Sesión no iniciada";
                    }
                }
            } else {
                // Si el método no existe, muestra un mensaje
                echo "NO EXISTE EL MÉTODO";
            }
        } else {
            // Si el controlador no existe, muestra un mensaje
            echo "NO EXISTE EL CONTROLADOR";
        }
    }
}
