<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\config\Validations;

class ModeloInicioSesion extends ModelBase
{

	private $password, $usuario, $ip_usuario, $intentos_fallidos, $id_usuario;

	public function __construct($dbSystem = false)
	{
		parent::__construct($dbSystem);
	}


	public function validarUsuarioExistente(){
		try {
			$sql = "SELECT p.id_personal,p.nombre AS nombre_personal, p.apellido AS apellido_personal,u.id_usuario, r.id_rol, u.usuario, u.password, r.nombre AS rol FROM segurity.usuario u INNER JOIN segurity.rol r ON u.id_rol = r.id_rol INNER JOIN bd.personal p ON p.usuario = u.id_usuario WHERE u.usuario = :usuario AND u.estado = 'ACT'";

			$this->setSQL($sql);

			$data = [
				'usuario' => $this->getUsuario()
			];

			return $this->search($data, false);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function validarIniciarSesion()
	{
		try {
			$sql = "SELECT p.id_personal,p.nombre AS nombre_personal, p.apellido AS apellido_personal,u.id_usuario, r.id_rol, u.usuario, u.password, r.nombre AS rol FROM segurity.usuario u INNER JOIN segurity.rol r ON u.id_rol = r.id_rol INNER JOIN bd.personal p ON p.usuario = u.id_usuario WHERE u.usuario = :usuario AND u.estado = 'ACT'";

			$this->setSQL($sql);

			$data = [
				'usuario' => $this->getUsuario()
			];

			$listData = $this->search($data, false);


			if ($listData) {

				$hashAlmacenado = $listData['password'];


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


	public function verificacionUsuarioToken() {
		$data=[
			'id_usuario'=>$this->getIdUsuario()
		];

		$sql = 'SELECT usuario FROM usuario WHERE id_usuario =:id_usuario AND token_session is not NULL';

		$this->setSQL($sql);
		$listData = $this->search($data, false);
		return !empty($listData) ? 1 : 0;
	}
	

	public function getPassword()
	{
		return $this->password;
	}

	public function getUsuario()
	{
		return $this->usuario;
	}
	public function getIdUsuario()
	{
		return $this->id_usuario;
	}
	public function getIpUsuario()
	{
		return $this->ip_usuario;
	}
	public function getIntentosFallidos()
	{
		return $this->intentos_fallidos;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function setUsuario($usuario)
	{
		$this->usuario = $usuario;
	}

	public function setIpUsuario($ip_usuario)
	{
		$this->ip_usuario = $ip_usuario;
	}

	public function setIntentosFallidos($intentos_fallidos)
	{
		$this->intentos_fallidos = $intentos_fallidos;
	}

	public function setIdUsuario($id_usuario)
	{
		$this->id_usuario = $id_usuario;
	}
}
