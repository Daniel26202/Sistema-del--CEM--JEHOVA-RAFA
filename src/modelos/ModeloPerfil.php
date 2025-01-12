<?php  
namespace App\modelos;
use App\modelos\Db;

class ModeloPerfil extends Db{
	
	private $conexion;

	public function __construct(){
        // Llama al constructor de la clase padre para establecer la conexión
        parent::__construct();
        
        // Aquí puedes usar $this para acceder a la conexión

        $this->conexion = $this; // Guarda la instancia de la conexión
    }
	public function seleccionarUsuario($usuario){
		$consulta = $this->conexion->prepare("SELECT * FROM usuario u INNER JOIN  personal p ON p.id_usuario = u.id_usuario  WHERE usuario =:usuario");
		
		$consulta->bindParam(":usuario", $usuario);
		return($consulta->execute()) ? $consulta->fetchAll() : false;
	}



	




}