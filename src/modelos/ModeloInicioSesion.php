<?php

namespace App\modelos;

use App\modelos\Db;

class ModeloInicioSesion extends Db
{

	private $conexion;

	public function __construct()
	{
		$this->conexion = $this->connectionSegurity();
	}

	public function validarIniciarSesion($usuario, $password)
	{

		$consulta = $this->conexion->prepare("SELECT p.nombre AS nombre_personal, p.apellido AS apellido_personal,u.id_usuario, r.id_rol, u.usuario, u.password, r.nombre AS rol FROM segurity.usuario u INNER JOIN segurity.rol r ON u.id_rol = r.id_rol INNER JOIN bd.personal p ON p.usuario = u.id_usuario WHERE u.usuario = :usuario AND u.estado = 'ACT' ");

		$consulta->bindParam(':usuario', $usuario);
		$consulta->execute();

		$resultado = $consulta->fetch();

		if ($resultado) {
			// Obtenemos el hash(el resultado de una función matemática(también se puede definir cómo, una huella digital)) de la contraseña almacenada
			$hashAlmacenado = $resultado['password'];

			// Verificamos si la contraseña ingresada coincide con el hash(también llamada, huella digital)
			if (password_verify($password, $hashAlmacenado)) {
				return $resultado;

			} else {
				// Contraseña incorrecta
				return false;
			}
		} else {
			// Usuario no encontrado o inactivo
			return false;
		}

	}
}