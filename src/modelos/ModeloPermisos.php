<?php

namespace App\modelos;

use App\modelos\ModelBase;

class ModeloPermisos extends ModelBase
{

    private $id_rol, $permiso, $modulo, $permisos, $modulos, $id_modulo;

    public function __construct($dbSystem = false)
    {
        parent::__construct($dbSystem);
    }


    public function gestionarPermisos()
    {
        $data = [
            'id_rol' => $this->getIdRol(),
            'id_modulo' => $this->getIdModulo(),
            'permiso' => $this->getPermiso()
        ];
        $sql = "SELECT * FROM permisos_de_rol  pr INNER JOIN permisos p ON p.id_permiso=pr.id_permiso WHERE pr.id_rol =:id_rol AND pr.id_modulo =:id_modulo AND p.permisos = :permiso";
        $this->setSQL($sql);
        $listData = $this->search($data, false);
        return !empty($listData) ? 1 : 0;
    }

    public function returnIdModule()
    {
        $data = [
            'nombre' => $this->getModulo()
        ];
        $sql = "SELECT id_modulo FROM modulos where nombre =:nombre AND estado = 'ACT' ";
        $this->setSQL($sql);
        $listData = $this->search($data, false);
        return !empty($listData) ?  $listData['id_modulo'] : 0;
    }

    public function returnModules()
    {
        try {
            $sql = "SELECT * FROM modulos where estado = 'ACT' ";
            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function registrarModulo()
    {
        try {
            $data = [
                'nombre' => $this->getModulo(),
                'estado' => 'ACT'
            ];


            $sql = "INSERT INTO modulos (nombre, estado) VALUES (:nombre, :estado)";
            $this->setSQL($sql);
            $this->create($data);

            return ["exito", $data];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function delete_modulo()
    {
        try {

            $data = [
                'id_modulo' => $this->getIdModulo()
            ];

            $sql = "SELECT * from modulos where id_modulo=:id_modulo";
            $this->setSQL($sql);

            $validar  = $this->search($data, false);

            if ($validar == []) {
                throw new \Exception("El id del modulo no existe");
            }

            $sql = "UPDATE modulos SET estado = 'DES' WHERE id_modulo =:id";
            $this->setSQL($sql);

            $this->update_logic($data['id_modulo']);
            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function getIdRol()
    {

        return $this->id_rol;
    }
    public function getIdModulo()
    {

        return $this->id_modulo;
    }

    public function getModulo()
    {
        return $this->modulo;
    }
    public function getPermiso()
    {
        return $this->permiso;
    }

    public function getPermisos()
    {
        return $this->permisos;
    }

    public function getModulos()
    {
        return $this->modulos;
    }

    public function setIdRol($id_rol)
    {
        if (!preg_match("/^[0-9]+$/", $id_rol)) {
            throw new \InvalidArgumentException("El ID del rol debe ser un número entero positivo.");
        }

        if ((int)$id_rol <= 0) {
            throw new \InvalidArgumentException("El ID del rol debe ser mayor que cero.");
        }

        $this->id_rol = $id_rol;
    }

    public function setIdModulo($id_modulo)
    {
        if (!preg_match("/^[0-9]+$/", $id_modulo)) {
            throw new \InvalidArgumentException("El ID del modulo debe ser un número entero positivo.");
        }

        if ((int)$id_modulo <= 0) {
            throw new \InvalidArgumentException("El ID del modulo debe ser mayor que cero.");
        }

        $this->id_modulo = $id_modulo;
    }

    public function setModulo($modulo)
    {
        $this->modulo = $modulo;
    }

    public function setPermiso($permiso)
    {
        if (!in_array($permiso, ['consultar', 'guardar', 'editar', 'eliminar'])) {
            throw new \InvalidArgumentException("El permiso no es valido.");
        }

        $this->permiso = $permiso;
    }

    public function setPermisos($permisos)
    {
        if (!is_array($permisos)) {
            throw new \InvalidArgumentException("El permisos no es valido.");
        }

        $this->permisos = $permisos;
    }

    public function setModulos($modulos)
    {
        if (is_array($modulos)) {
            throw new \InvalidArgumentException("Los modulos no es valido.");
        }

        $this->modulos = $modulos;
    }
}
