<?php

namespace App\modelos;
use App\modelos\Db;

class ModeloInicioSesion extends Db
{

	private $conexion;

	public function __construct(){
        // Llama al constructor de la clase padre para establecer la conexión
        parent::__construct();
        
        // Aquí puedes usar $this para acceder a la conexión

        $this->conexion = $this; // Guarda la instancia de la conexión
    }

	public function validarIniciarSesion($usuario, $password)
	{
		$sql = "SELECT u.id_usuario, r.id_rol, u.usuario, u.password, r.nombre AS rol FROM usuario u INNER JOIN rol r  ON u.id_rol = r.id_rol WHERE u.usuario=:usuario AND u.password=:password AND u.estado = 'ACT' ";
		$consulta = $this->conexion->prepare($sql);
		$consulta->bindParam(':usuario', $usuario);
		$consulta->bindParam(':password', $password);

		$consulta->execute();

		return $consulta->fetch();
	}
}