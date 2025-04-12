<?php

namespace App\modelos;

use App\modelos\Db;

class ModeloRoles extends Db
{

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
        $consulta = $this->conexion->prepare("SELECT * FROM permisos WHERE id_rol =:id_rol");
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


    //mostrar los permisos que tiene cada rol en especifico
    public function permisosRol($id_permiso, $id_rol)
    {
        $consulta = $this->conexion->prepare("SELECT *  FROM permisos p INNER JOIN  rol_has_permisos rp ON p.idpermisos = rp.permisos_idpermisos INNER JOIN rol r ON r.id_rol = rp.rol_id_rol WHERE p.idpermisos =:id_permiso AND r.id_rol =:id_rol");
        $consulta->bindParam(":id_permiso", $id_permiso);
        $consulta->bindParam(":id_rol", $id_rol);
        return ($consulta->execute()) ? $consulta->fetch() : false;
    }


    //Insertar  Rol

    public function insertar($nombre, $descripcion, $modulo, $permisos)
    {

        //Insertar Rol
        $consulta = $this->conexion->prepare("INSERT INTO rol (id_rol, nombre, estado, descripción) VALUES (NULL, :nombre, 'ACT', :descripcion)");
        $consulta->bindParam(":nombre", $nombre);
        $consulta->bindParam(":descripcion", $descripcion);
        $consulta->execute();

        //Me retorna el id del rol
        $id_rol = $this->conexion->lastInsertId();

        //Recorro los modulos enviados por el formulario
        foreach ($modulo as $index => $modulo) {
            //La variable grupoDelPermiso guardar el nombre del grupo de permiso
            $grupoDelPermiso = $permisos[$index];

            //Uno el array de permisos en una cadena de texto separado por "," 
            $permiso = implode(",", $_POST[$grupoDelPermiso]);

            $consultaPermiso = $this->conexion->prepare("INSERT INTO permisos (idpermisos, id_rol, permisos, modulo) VALUES (NULL, :id_rol, :permisos, :modulo)");
            $consultaPermiso->bindParam(":id_rol", $id_rol);
            $consultaPermiso->bindParam(":permisos", $permiso);
            $consultaPermiso->bindParam(":modulo", $modulo);
            $consultaPermiso->execute();
        }
    }
}
