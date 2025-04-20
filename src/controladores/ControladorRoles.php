<?php

use \App\modelos\ModeloRoles;
use App\modelos\ModeloBitacora;

class ControladorRoles
{

    private $modelo;
    private $bitacora;

    function __construct()
    {
        $this->modelo = new ModeloRoles;
        $this->bitacora = new ModeloBitacora; //bitacora
    }


    public function mostrar($parametro)
    {
        $roles = $this->modelo->roles();
        $modulos = require_once './src/vistas/vistaRoles/modal/listaModulos.php';
        require_once './src/vistas/vistaRoles/vistaRoles.php';
    }

    public function mostrarPermisos($id_rol, $modulo)
    {
        $this->modelo->mostrarPermisos($id_rol, $modulo);
    }


    //guardar el rol

    public function guardarRol()
    {
        //instacion el metodo de la validacion de el rol
        $validar = $this->modelo->validarRol($_POST["nombre"]);
        if ($validar) {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar/error");
        } else {
            $this->modelo->insertar($_POST["nombre"], $_POST["descripcion"], $_POST["modulos"], $_POST["permisos"]);

            // guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "Roles", "Ha Insertado un nuevo rol");

            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar/registro");
        }
    }


    //modiicar rol
    public function modificarRol($datos)
    {
        
        $nombre = $datos[0];
        //instacion el metodo de la validacion de el rol
        $validar = $this->modelo->validarRol($_POST["nombre"]);
        if ($nombre == $_POST["nombre"]) {

            $this->modelo->editar($_POST["id_rol"], $_POST["nombre"], $_POST["descripcion"], $_POST["modulos"], $_POST["permisos"]);

            // guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "Roles", "Ha Modiicado un rol");

            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar/editar");
        } else if ($nombre != $_POST["nombre"]) {
            if ($validar) {
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar/error");
            } else {
                $this->modelo->editar($_POST["id_rol"], $_POST["nombre"], $_POST["descripcion"], $_POST["modulos"], $_POST["permisos"]);

                // guardar la bitacora
                $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "Roles", "Ha Modiicado un rol");

                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar/editar");
            }
            
        } 
    }

    //eliminar Rol
    public function eliminarRol()
    {
        $this->modelo->eliminar($_POST["id_rol"]);

        // guardar la bitacora
        $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "Roles", "Ha Eliminado un rol");
        header("location: /Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar/eliminar");
    }
}
