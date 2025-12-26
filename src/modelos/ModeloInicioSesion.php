<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\config\Validations;

class ModeloInicioSesion extends ModelBase
{

	private $conexion, $password, $usuario;

	public function __construct($dbSystem)
	{
		parent::__construct($dbSystem);
	}

	public function validarIniciarSesion()
	{
		try {
			$data = [
				'password' => $this->getPassword(),
				'usuario' => $this->getUsuario(),
				'estado' => 'ACT'
			];

			$sql = "SELECT p.nombre AS nombre_personal, p.apellido AS apellido_personal,u.id_usuario, r.id_rol, u.usuario, u.password, r.nombre AS rol FROM segurity.usuario u INNER JOIN segurity.rol r ON u.id_rol = r.id_rol INNER JOIN bd.personal p ON p.usuario = u.id_usuario WHERE u.usuario = :usuario AND u.estado = 'ACT' ";
			$this->setSQL($sql);

			$resultado = $this->search($data, false);



			if ($resultado) {
				// Obtenemos el hash(el resultado de una función matemática(también se puede definir cómo, una huella digital)) de la contraseña almacenada

				// $hashAlmacenado = $resultado['password'];

				// Verificamos si la contraseña ingresada coincide con el hash(también llamada, huella digital)
				if (password_verify($data['password'], $resultado['password'])) {
					return ['exito', $data];
				}
			}
			// Contraseña incorrecta
			throw new \Exception("La contraseña o usuario incorrectos.");
		} catch (\Throwable $e) {
			return $e->getMessage();
		}
	}

	public function getPassword()
	{
		return $this->password;
	}
	public function setPassword($password)
	{
		if ($password == '') {
			throw new \Exception("Ups, falta la contraseña. Escríbela para avanzar.");
		}
		$this->password = $password;
	}
	public function getUsuario()
	{
		return $this->usuario;
	}
	public function setUsuario($usuario)
	{
		if ($usuario == '') {
			throw new \Exception("Ups, falta el usuario. Escríbelo para avanzar.");
		}
		$this->usuario = $usuario;
	}
}
