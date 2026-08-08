<?php

namespace App\models;

use App\models\ModelBase;
use App\models\interfaces\InterfaceConnection;


class ModeloInicioSesion extends ModelBase
{

	private $password, $usuario, $ip_usuario, $intentos_fallidos, $id_usuario;

	public function __construct(InterfaceConnection $conn)
	{
		parent::__construct($conn);

		$this->set_tables(["segurity.usuario","segurity.rol","bd.personal"]);
		$this->set_alias(['u','r','p']);
		$this->set_union(['u.id_rol = r.id_rol', 'p.usuario = u.id_usuario']);
		$this->set_colums(['p.id_personal','p.nombre AS nombre_personal','p.apellido AS apellido_personal','u.id_usuario','r.id_rol','u.usuario','u.password','r.nombre AS rol']);
	}

	public function validarUsuarioExistente(){
		try {
			$condicion = [
	            'condiciones'=>['u.estado'=>'ACT','u.usuario'=> $this->getUsuario()],
	            'conectores'=>['AND'],
	            'operadores'=>['=','=']
        	];
			$this->set_condicion_aditional($condicion);
			return $this->read(false);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function validarIniciarSesion()
	{
		try {
			$condicion = [
	            'condiciones'=>['u.estado'=>'ACT','u.usuario'=> $this->getUsuario()],
	            'conectores'=>['AND'],
	            'operadores'=>['=','=']
        	];
			$this->set_condicion_aditional($condicion);
			$data_user = $this->read(false);
			if ($data_user) {
				$hashAlmacenado = $data_user['password'];

				if (password_verify($this->getPassword(), $hashAlmacenado)) {
					return $data_user;
				} 
				// Contraseña incorrecta
				return false;
			} 
			// Usuario no encontrado o inactivo
			return false;
			
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	// public function verificacionUsuarioToken() {
	// 	$data=[
	// 		'id_usuario'=>$this->getIdUsuario()
	// 	];

	// 	$sql = 'SELECT usuario FROM usuario WHERE id_usuario =:id_usuario AND token_session is not NULL';

	// 	$this->setSQL($sql);
	// 	$listData = $this->search($data, false);
	// 	return !empty($listData) ? 1 : 0;
	// }
	

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
