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
    public function rolesPermisos()
    {
        $consulta = $this->conexion->prepare("SELECT *  FROM permisos  GROUP  BY  modulo");
        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }


    //Consultar los permisos segun el modulo especifico
    public function permisosModulo($modulo)
    {
        $consulta = $this->conexion->prepare("SELECT * FROM rol r INNER JOIN rol_has_permisos rp ON rp.rol_id_rol = r.id_rol INNER JOIN permisos p ON p.idpermisos = rp.permisos_idpermisos WHERE p.modulo =:modulo ");
        $consulta->bindParam(":modulo", $modulo);
        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }


    //mostrar los permisos que tiene cada rol en especifico
    public function permisosRol($id_permiso,$id_rol)
    {
        $consulta = $this->conexion->prepare("SELECT *  FROM permisos p INNER JOIN  rol_has_permisos rp ON p.idpermisos = rp.permisos_idpermisos INNER JOIN rol r ON r.id_rol = rp.rol_id_rol WHERE p.idpermisos =:id_permiso AND r.id_rol =:id_rol");
        $consulta->bindParam(":id_permiso", $id_permiso);
        $consulta->bindParam(":id_rol", $id_rol);
        return ($consulta->execute()) ? $consulta->fetch() : false;
    }



}