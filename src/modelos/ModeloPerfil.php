<?php  
namespace App\modelos;
use App\modelos\Db;

class ModeloPerfil extends Db{
	
	private $conexion;

	public function __construct()
	{
		$this->conexion = $this->connectionSegurity();
	}
	public function seleccionarUsuario($usuario){
		$consulta = $this->conexion->prepare("SELECT *,u.usuario as user FROM segurity.usuario u INNER JOIN  bd.personal p ON p.usuario = u.id_usuario  WHERE u.usuario =:usuario");
		
		$consulta->bindParam(":usuario", $usuario);
		return($consulta->execute()) ? $consulta->fetchAll() : false;
	}

	public function update($id_usuario,  $cedula, $nombre, $apellido, $telefono, $usuario,$correo)
	{
		try {
			// UPDATE paciente SET id_cedula=,cedula=],nombre=,apellido=,telefono=,direccion=,fn= WHERE 1
			$consulta = $this->conexion->prepare("UPDATE bd.personal SET cedula=:cedula,nombre=:nombre,apellido=:apellido,telefono=:telefono WHERE usuario = :id_usuario");
			$consulta->bindParam(":id_usuario", $id_usuario);
			$consulta->bindParam(":cedula", $cedula);
			$consulta->bindParam(":nombre", $nombre);
			$consulta->bindParam(":apellido", $apellido);
			$consulta->bindParam(":telefono", $telefono);
			$consulta->execute();


			$consulta2 = $this->conexion->prepare("UPDATE segurity.usuario SET usuario=:usuario, correo =:correo WHERE id_usuario = :id_usuario");
			$consulta2->bindParam(":id_usuario", $id_usuario);
			$consulta2->bindParam(":usuario", $usuario);
			$consulta2->bindParam(":correo", $correo);
			$consulta2->execute();

			return "exito";
		} catch (\Exception $e) {
			return 0;
		}
	}



	




}