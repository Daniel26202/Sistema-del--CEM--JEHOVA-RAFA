<?php

namespace App\models;

use App\models\ModelBase;
use App\models\interfaces\InterfaceConnection;
use App\models\TraitCreate;
use App\models\TraitUpdate;


class ModeloPermisos extends ModelBase
{

    private $id_rol, $permiso, $modulo, $permisos, $modulos, $id_modulo;
    use TraitCreate, TraitUpdate;

    public function __construct(InterfaceConnection $conn)
    {
        parent::__construct($conn);
    }


    public function gestionarPermisos()
    {
        $alias = [
            'pr',
            'p'
        ];
        $unions = [
            'p.id_permiso=pr.id_permiso'
        ];
        $coditions = [
            'condiciones' => ['pr.id_rol' => $this->getIdRol(), 'pr.id_modulo' => $this->getIdModulo(), 'p.permisos' => $this->getPermiso()],
            'conectores' => ['AND', 'AND'],
            'operadores' => ['=', '=', '=']
        ];
        $this->set_tables(["permisos_de_rol", "permisos"]);
        $this->set_colums(['id_permiso']);
        $this->set_condicion_aditional($coditions);
        $this->set_alias($alias);
        $this->set_union($unions);
        $listData = $this->read(false);
        return !empty($listData) ? 1 : 0;
    }

    public function returnIdModule()
    {
        $coditions = [
            'condiciones' => ['nombre' => $this->getModulo(), 'estado' => 'ACT'],
            'conectores' => ['AND'],
            'operadores' => ['=', '=']
        ];
        $this->set_tables(["modulos"]);
        $this->set_colums(['id_modulo']);
        $this->set_condicion_aditional($coditions);
        $listData = $this->read(false);
        return !empty($listData) ?  $listData['id_modulo'] : 0;
    }

    public function returnModules()
    {
        $coditions = [
            'condiciones' => ['estado' => 'ACT'],
            'conectores' => [],
            'operadores' => ['=']
        ];
        $this->set_tables(["modulos"]);
        $this->set_colums(['id_modulo,nombre']);
        $this->set_condicion_aditional($coditions);
        return $this->read();
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
