<?php  
namespace App\modelos;
use App\modelos\Db;

class ModeloPermisos extends Db{
	
	private $conexion;

	public function __construct(){
        parent::__construct();
        $this->conexion = $this; 
    }


    public function gestionarPermisos($id_rol, $permiso, $modulo)
    {
        $consulta = $this->conexion->prepare("SELECT * FROM permisos WHERE id_rol =:id_rol AND modulo =:modulo AND permisos LIKE :permisos limit 1");
        $buscar = "%$permiso%";
        $consulta->bindParam(":id_rol", $id_rol);
        $consulta->bindParam(":modulo", $modulo);
        $consulta->bindParam(":permisos", $buscar);
        $consulta->execute();

        while ($consulta->fetch()) {
            return 1;
        }

        return 0;
    }


}