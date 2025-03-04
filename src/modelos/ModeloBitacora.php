<?php 

namespace App\modelos;
use App\modelos\Db;

date_default_timezone_set("America/Caracas");

class ModeloBitacora extends Db{
	
	private $conexion;

	public function __construct(){
        // Llama al constructor de la clase padre para establecer la conexión
        parent::__construct();
        
        // Aquí puedes usar $this para acceder a la conexión

        $this->conexion = $this; // Guarda la instancia de la conexión
    }


    public function consultarBitacora(){
    	$consulta = $this->conexion->prepare("SELECT * FROM bitacora");
    	return ($consulta->execute()) ? $consulta->fetchAll() : false; 
    }


    public function insertarBitacora($id_usuario, $tabla, $actividad)
    {
        $fecha_hora = date('Y-m-d H:i:s');
    	$consulta = $this->conexion->prepare("INSERT INTO bitacora (id_usuario, tabla, actividad, fecha_hora) VALUES (:id_usuario, :tabla, :actividad, :fecha_hora) ");
    	$consulta->bindParam(":id_usuario", $id_usuario);
    	$consulta->bindParam(":tabla", $tabla);
    	$consulta->bindParam(":actividad", $actividad);
    	$consulta->bindParam(":fecha_hora", $fecha_hora);
    	$consulta->execute();

    }
}



 ?>