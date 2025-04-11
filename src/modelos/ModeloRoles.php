<?php

namespace App\modelos;
use App\modelos\Db;

class ModeloRoles extends Db{

    private $conexion;

    public function __construct()
    {
        // Llama al constructor de la clase padre para establecer la conexión
        parent::__construct();

        // Aquí puedes usar $this para acceder a la conexión

        $this->conexion = $this; // Guarda la instancia de la conexión
    }



    //consultar los roles disponibles
    public function roles()
    {
        $consulta = $this->conexion->prepare("SELECT * FROM rol WHERE estado ='ACT' ");
        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }


    //Consultar los permisos segun el id_rol
    public function rolesPermisos($id_rol)
    {
        $consulta = $this->conexion->prepare("SELECT * FROM rol r INNER JOIN rol_has_permisos rp ON rp.rol_id_rol = r.id_rol INNER JOIN permisos p ON p.idpermisos = rp.permisos_idpermisos WHERE r.id_rol =:id_rol GROUP BY modulo ");
        $consulta->bindParam(":id_rol", $id_rol);
        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }


    //Consultar los permisos segun el modulo especifico
    public function permisosModulo($modulo)
    {
        $consulta = $this->conexion->prepare("SELECT * FROM rol r INNER JOIN rol_has_permisos rp ON rp.rol_id_rol = r.id_rol INNER JOIN permisos p ON p.idpermisos = rp.permisos_idpermisos WHERE p.modulo =:modulo ");
        $consulta->bindParam(":modulo", $modulo);
        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }



}