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
}