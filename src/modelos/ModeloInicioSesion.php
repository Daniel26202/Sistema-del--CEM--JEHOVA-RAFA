<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\config\Validations;

class ModeloInicioSesion extends ModelBase
{

	private $password, $usuario;

	public function __construct($dbSystem)
	{
		parent::__construct($dbSystem);
		parent::__construct($dbSystem);
	}

	public function validarIniciarSesion($data)
	{
		try {
			$sql = "SELECT p.nombre AS nombre_personal, p.apellido AS apellido_personal,u.id_usuario, r.id_rol, u.usuario, u.password, r.nombre AS rol FROM segurity.usuario u INNER JOIN segurity.rol r ON u.id_rol = r.id_rol INNER JOIN bd.personal p ON p.usuario = u.id_usuario WHERE u.usuario = :usuario AND u.estado = 'ACT'";

			$this->setSQL($sql);

			$listData = $this->search($data, false);


			if ($listData) {
				// Obtenemos el hash(el resultado de una función matemática(también se puede definir cómo, una huella digital)) de la contraseña almacenada
				$hashAlmacenado = $listData['password'];

				// Verificamos si la contraseña ingresada coincide con el hash(también llamada, huella digital)
				if (password_verify($this->getPassword(), $hashAlmacenado)) {
					return $listData;
				} else {
					// Contraseña incorrecta
					return false;
				}
			} else {
				// Usuario no encontrado o inactivo
				return false;
			}
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function getUsuario()
	{
		return $this->usuario;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function setUsuario($usuario)
	{
		$this->usuario = $usuario;
	}
}

