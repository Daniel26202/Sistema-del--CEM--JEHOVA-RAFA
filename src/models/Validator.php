<?php 

namespace App\models;

use App\models\interfaces\InterfaceValidator;

class Validator implements InterfaceValidator
{
	private $session;
	private $id_usuario;
	private $campos;
	
	public function validarSesion()
	{
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}
		if (empty($this->get_session()) && empty($this->get_id_usuario()) ) {
			throw new \Exception('No hay sesión activa o usuario no autenticado.');
		}
	}

	public function validarCamposObligatorios()
	{
		foreach ($this->get_campos() as $campo) {
			if (empty($campo)) {
				throw new \Exception('No se permiten campos vacíos.');
			}
		}
	}

	public function get_session()
	{
		return $this->session;
	}

	public function get_id_usuario()
	{
		return $this->id_usuario;
	}

	public function get_campos()
	{
		return $this->campos;
	}

	public function set_session($session)
	{
		$this->session = $session;
	}

	public function set_id_usuario($id_usuario)
	{
		$this->id_usuario = $id_usuario;
	}

	public function set_campos($campos)
	{
		$this->campos = $campos;
	}
}