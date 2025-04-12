<?php

use \App\modelos\ModeloRoles;

class ControladorRoles {

    private $modelo;

    function __construct()
    {
        $this->modelo = new ModeloRoles;
    }


    public function mostrar($parametro){
        $roles = $this->modelo->roles();
        require_once './src/vistas/vistaRoles/vistaRoles.php';
    }


    public function mostrarPermisos($datos)
    {
        $permisos = $this->modelo->rolesPermisos($datos[0]);
        echo json_encode($permisos);
    }


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
        header("location: /Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar");
    }
}