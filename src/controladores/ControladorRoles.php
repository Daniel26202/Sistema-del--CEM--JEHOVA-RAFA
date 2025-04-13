<?php

use \App\modelos\ModeloRoles;
use App\modelos\ModeloBitacora;

class ControladorRoles {

    private $modelo;
    private $bitacora;

    function __construct()
    {
        $this->modelo = new ModeloRoles;
        $this->bitacora = new ModeloBitacora; //bitacora
    }


    public function mostrar($parametro){
        $roles = $this->modelo->roles();
        require_once './src/vistas/vistaRoles/vistaRoles.php';
    }

    public function mostrarPermisos($id_rol, $modulo){
       $this->modelo->mostrarPermisos($id_rol, $modulo);
    }

    // in_array($palabra, $array);


    // public function mostrarPermisos($datos)
    // {
    //     $permisos = $this->modelo->rolesPermisos($datos[0]);
    //     echo json_encode($permisos);
    // }


    public function mostrarPermisosPorModulo($datos)
    {
        $permisos = $this->modelo->permisosModulo($datos[0]);
        echo json_encode($permisos);
    }

    public function permisosRol($datos){
        $permisos = $this->modelo->permisosRol($datos[0], $datos[1]);
        echo json_encode($permisos);
    }


    //guardar el rol

    public function guardarRol(){
        print_r($_POST);
        $this->modelo->insertar($_POST["nombre"], $_POST["descripcion"], $_POST["modulos"], $_POST["permisos"]);

        // guardar la bitacora
        $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "Roles", "Ha Insertado un nuevo rol");

        header("location: /Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar");
    }


    //modiicar rol
    public function modificarRol(){
        $this->modelo->editar($_POST["id_rol"],$_POST["nombre"], $_POST["descripcion"], $_POST["modulos"], $_POST["permisos"]);

        // guardar la bitacora
        $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "Roles", "Ha Modiicado un rol");

        header("location: /Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar");
    }

    //eliminar Rol
    public function eliminarRol()
    {
        $this->modelo->eliminar($_POST["id_rol"]);

        // guardar la bitacora
        $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "Roles", "Ha Eliminado un rol");
        header("location: /Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar");
    }
    

}