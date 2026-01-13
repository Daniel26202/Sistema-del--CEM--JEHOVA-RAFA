<?php  
namespace App\modelos;
use App\modelos\ModelBase;

class ModeloPermisos extends ModelBase{
	
	private $id_rol, $permiso, $modulo;

    public function __construct($dbSystem=false)
    {
       parent::__construct($dbSystem);
    }


    public function gestionarPermisos()
    {
        $data=[
            'id_rol'=>$this->getIdRol(),
            'modulo'=>$this->getModulo(),
            'permiso'=>$this->getPermiso()
        ];
        $sql= "SELECT * FROM permisos WHERE id_rol =:id_rol AND modulo =:modulo AND permisos LIKE :permiso limit 1";
        $this->setSQL($sql);
        $listData = $this->search($data, false);
        return !empty($listData) ? 1 : 0;
    }

    public function getIdRol(){

        return $this->id_rol;
    }
    public function getModulo()
    {
        return $this->modulo;
    }
    public function getPermiso()
    {
        return $this->permiso;
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

    public function setModulo($modulo)
    {
        $this->modulo = $modulo;
    }

    public function setPermiso($permiso)
    {
        if (!$permiso == 'consultar' || !$permiso == 'guardar' || !$permiso == 'editar' || !$permiso == 'eliminar') {
            throw new \InvalidArgumentException("El permiso no es valido.");
        }

        $this->permiso=$permiso;
    }


}