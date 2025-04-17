<?php

namespace App\config;
use App\modelos\ModeloPermisos;



class Rutas
{

    private $url, $partes, $controlador, $modelo, $equivalentes;


    public function __construct($url)
    {
        $this->url = $url;
        $this->modelo = new ModeloPermisos();
        $this->equivalentes = require_once "./src/config/equivalencias.php";
    }



    public function gestionarRutas()
    {
        $this->partes = explode("/", $this->url);
        $this->controlador = ucfirst($this->partes['0']);
        $metodo = isset($this->partes['1']) ? $this->partes['1'] : "IniciarSesion";
        $parametro = "";
        $modulo = $this->controlador;

        //si partes en la posicion 2 existe es por que se enviaron parametros
        if (isset($this->partes[2])) {
            for ($i = 2; $i < count($this->partes); $i++) {
                $parametro .= $this->partes[$i] . ",";
            }
            //trim en php es para quitar el ultimo caracter en este caso es para quitar la ultima "," del parametro
            $parametro = trim($parametro, ",");

            $parametro = explode(",", $parametro);

        }

        $this->controlador = "Controlador" . $this->controlador;

        $directorio = "src/controladores/" . $this->controlador . ".php";

        if (file_exists($directorio)) {
            require_once $directorio;

            $instancia = new $this->controlador();

            if (method_exists($instancia, $metodo)) {



                //gestion de los permisos
                $instancia->$metodo($parametro);

                // if (session_status() == PHP_SESSION_ACTIVE) {
                //     echo "session activa";
                //     $permiso = (isset($this->equivalentes[$metodo])) ? $this->equivalentes[$metodo] : $metodo;
                //     $permitido = $this->modelo->gestionarPermisos($_SESSION["id_rol"], $permiso, $modulo);
                //     echo $permitido;
                //     if (!$permitido) {
                //         echo "Error 404";
                        
                //         //$instancia->$metodo($parametro);
                //     } 
                    
                // }

                

            } else
                echo "NO EXISTE EL METODO";


        } else
            echo "NO EXISTE EL CONTROLADOR";


    }


}
