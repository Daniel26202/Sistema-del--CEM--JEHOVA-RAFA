<?php

namespace App\models;

use App\models\ModelBase;
use App\models\interfaces\InterfaceConnection;
use App\models\interfaces\InterfaceValidator;
use App\models\TraitCreate;
use App\models\TraitUpdate;

class ModeloProveedores extends ModelBase
{

	private $idProveedor, $nombre, $rif, $telefono, $email, $direccion;
	private $validator;
	use TraitCreate, TraitUpdate;

	public function __construct(InterfaceConnection $conn, InterfaceValidator $vali)
	{
		parent::__construct($conn);
		$this->validator = $vali;
	}

	// ── READ ────────────────────────────────────────────────
	public function consultar($estado = 'ACT', $start = 0, $limit = 10, $search = '', $ordenColumn = 'id_proveedor', $ordenDir = 'DESC')
	{
		$coditions = [
			'condiciones' => ['estado' => $estado],
			'conectores' => [''],
			'operadores' => ['=']
		];
		$this->set_tables(["proveedor"]);
		$this->set_colums(['id_proveedor', 'nombre', 'rif', 'telefono', 'direccion', 'email AS correo']);

		$this->set_search($search);
		$this->set_start($start);
		$this->set_limit($limit);
		$this->set_orden_dir($ordenDir);
		$this->set_orden_column($ordenColumn);
		$this->set_condicion_aditional($coditions);

		return $this->pagination();
	}



	// ── PRIVADOS─────────────────────────────────────────


	public function validarRif()
	{
		$coditions = [
			'condiciones' => ['rif' => $this->getRif(), 'id_proveedor' => $this->getIdProveedor()],
			'conectores' => ['AND'],
			'operadores' => ['=', '!=']
		];
		$this->set_tables(["proveedor"]);
		$this->set_colums(['id_proveedor']);
		$this->set_condicion_aditional($coditions);
		$listData = $this->read(false);
		return !empty($listData) ? 1 : 0;
	}

	public function get_all() {
		return [
			'nombre'=>$this->getNombre(),
			'rif'=>$this->getRif(),
			'telefono'=>$this->getTelefono(),
			'email'=>$this->getEmail(),
			'direccion'=>$this->getDireccion(),
			'estado'=>'ACT'
		];
	}

	public function getIdProveedor()
	{
		return $this->idProveedor;
	}
	public function getNombre()
	{
		return $this->nombre;
	}
	public function getRif()
	{
		return $this->rif;
	}
	public function getTelefono()
	{
		return $this->telefono;
	}
	public function getEmail()
	{
		return $this->email;
	}

	public function getDireccion()
	{
		return $this->direccion;
	}




	public function setIdProveedor($idProveedor)
	{
		if (!preg_match("/^[0-9]+$/", $idProveedor)) {
			throw new \InvalidArgumentException("El ID del proveedor debe ser un número entero positivo.");
		}

		if ((int)$idProveedor <= 0) {
			throw new \InvalidArgumentException("El ID del proveedor debe ser mayor que cero.");
		}

		$this->idProveedor = (int)$idProveedor;
	}

	public function setNombre($nombre)
	{
		if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}(\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,})*$/", $nombre)) {
			throw new \InvalidArgumentException("El nombre debe iniciar con mayúscula, tener al menos 3 letras y puede incluir un segundo nombre separado por un espacio.");
		}
		$this->nombre = $nombre;
	}

	public function setRif($rif)
	{
		$this->rif = $rif;
	}


	public function setTelefono($telefono)
	{
		if (!preg_match("/^(0?)(412|422|414|416|424|426|212|24[1-9]|25[1-9])\d{7}$/", $telefono)) {
			throw new \InvalidArgumentException("El teléfono debe comenzar con un código válido y contener solo números.");
		}
		$this->telefono = $telefono;
	}

	public function setEmail($email)
	{
		if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $email)) {
			throw new \InvalidArgumentException("El correo debe estar bien escrito.");
		}
		$this->email = $email;
	}

	public function setDireccion($direccion)
	{
		if (!preg_match("/^([A-Za-z0-9\s\.,#-]{8,})$/", $direccion)) {
			throw new \InvalidArgumentException("La dirección debe estar completa y detallada.");
		}
		$this->direccion = $direccion;
	}
}
