<?php

namespace App\modelos;

use App\modelos\Db;

class ModeloRoles extends Db
{

    private $conexion;

    public function __construct()
    {
        $this->conexion = $this->connectionSegurity();
    }



    //consultar los roles disponibles
    public function roles()
    {
        try {
            $consulta = $this->conexion->prepare("SELECT * FROM rol WHERE estado ='ACT' ");
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }


    //Consultar el permiso
    public function mostrarPermisos($id_rol, $modulo)
    {
        try {
            $consulta = $this->conexion->prepare("SELECT modulo,permisos FROM permisos WHERE id_rol =:id_rol AND modulo =:modulo ");
            $consulta->bindParam(":id_rol", $id_rol);
            $consulta->bindParam(":modulo", $modulo);
            $permisos = ($consulta->execute()) ? $consulta->fetch() : false;
            return $permisos;
        } catch (\Exception $e) {
            return 0;
        }
    }




    //Insertar  Rol

    public function insertar($nombre, $descripcion, $modulo, $permisos)
    {
        try {
            $this->conexion->beginTransaction();
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
                $permiso = isset($_POST[$grupoDelPermiso]) ? implode(",", $_POST[$grupoDelPermiso]) : '';

                $consultaPermiso = $this->conexion->prepare("INSERT INTO permisos (idpermisos, id_rol, permisos, modulo) VALUES (NULL, :id_rol, :permisos, :modulo)");
                $consultaPermiso->bindParam(":id_rol", $id_rol);
                $consultaPermiso->bindParam(":permisos", $permiso);
                $consultaPermiso->bindParam(":modulo", $modulo);
                $consultaPermiso->execute();
            }

            $consulta = $this->conexion->prepare("SELECT * from rol where id_rol=:id_rol");
            $consulta->bindParam(":id_rol", $id_rol);
            $consulta->execute();
            $data = ($consulta->execute()) ? $consulta->fetch() : false;

            $this->conexion->commit();
            return ["exito", $data];


        } catch (\Exception $e) {
            $this->conexion->rollBack();
            return 0;
        }
    }


    //modificar Rol
    public function editar($id_rol, $nombre, $descripcion, $modulo, $permisos)
    {
        try {
            $this->conexion->beginTransaction();


            $validar = $this->conexion->prepare("SELECT * from rol where id_rol=:id_rol");
            $validar->bindParam(":id_rol", $id_rol);
            $validar->execute();
            if ($validar->rowCount() <= 0) {
                throw new \Exception("Fallo");
            }

            //Editar Rol
            $consulta = $this->conexion->prepare("UPDATE rol SET  nombre =:nombre, descripción =:descripcion WHERE id_rol = :id_rol");
            $consulta->bindParam(":nombre", $nombre);
            $consulta->bindParam(":descripcion", $descripcion);
            $consulta->bindParam(":id_rol", $id_rol);
            $consulta->execute();



            //Recorro los modulos enviados por el formulario
            foreach ($modulo as $index => $modulo) {
                //La variable grupoDelPermiso guardar el nombre del grupo de permiso
                $grupoDelPermiso = $permisos[$index];

                //Uno el array de permisos en una cadena de texto separado por "," 
                $permiso = isset($_POST[$grupoDelPermiso]) ? implode(",", $_POST[$grupoDelPermiso]) : '';

                $consultaPermiso = $this->conexion->prepare("UPDATE  permisos SET   permisos =:permisos WHERE modulo =:modulo AND id_rol =:id_rol");
                $consultaPermiso->bindParam(":id_rol", $id_rol);
                $consultaPermiso->bindParam(":permisos", $permiso);
                $consultaPermiso->bindParam(":modulo", $modulo);
                $consultaPermiso->execute();
            }
            $this->conexion->commit();
            return "exito";
        } catch (\Exception $e) {
            $this->conexion->rollBack();
            return 0;
        }
    }


    //eliminar Rol

    public function eliminar($id_rol)
    {
        try {
            $validar = $this->conexion->prepare("SELECT * from rol where id_rol=:id_rol");
            $validar->bindParam(":id_rol", $id_rol);
            $validar->execute();
            if ($validar->rowCount() <= 0) {
                throw new \Exception("Fallo");
            }

            //Eliminar Rol
            $consulta = $this->conexion->prepare("UPDATE rol SET  estado ='DES' WHERE id_rol = :id_rol");
            $consulta->bindParam(":id_rol", $id_rol);
            $consulta->execute();
            return "exito";
        } catch (\Exception $e) {
            return 0;
        }
    }


    //metodo para validar que no se registren dos roles con el mismo nombre
    public function validarRol($nombre)
    {
        try {
            $consulta = $this->conexion->prepare("SELECT * FROM rol WHERE nombre =:nombre");
            $consulta->bindParam(":nombre", $nombre);
            $consulta->execute();
            while ($consulta->fetch()) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return 0;
        }
    }
}
