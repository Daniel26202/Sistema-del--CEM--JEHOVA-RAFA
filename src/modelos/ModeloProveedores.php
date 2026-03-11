<?php

namespace App\modelos;

use App\modelos\ModelBase;

class ModeloProveedores extends ModelBase
{

	private $idProveedor, $nombre, $rif, $rif_registrado, $telefono, $email, $direccion;
	public function __construct($dbSystem = true)
	{
		parent::__construct($dbSystem);
	}


	public function consultar()
	{
		try {
			$sql = "SELECT * FROM proveedor WHERE estado='ACT' ";
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function papeleraConsultar()
	{
		try {
			$sql = "SELECT * FROM proveedor WHERE estado='DES' ";
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function agregar()
	{
		try {
			$data = [
				'nombre' => $this->getNombre(),
				'rif' => $this->getRif(),
				'telefono' => $this->getTelefono(),
				'email' => $this->getEmail(),
				'direccion' => $this->getDireccion(),
				'estado' => 'ACT'
			];

			if ($this->validarRif(['rif' => $this->getRif()])) {
				throw new \Exception("El rif ya existe en el sistema.");
			}

			$sql = "INSERT INTO proveedor(nombre, rif, telefono, email, direccion, estado) VALUES (:nombre, :rif, :telefono, :email, :direccion, :estado);";

			$this->setSQL($sql);
			$this->create($data);
			return ["exito", $data];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	// eliminación logica
	public function delte()
	{
		try {
			$data = [
				'id_proveedor' => $this->getIdProveedor()
			];

			$sql = "SELECT * from proveedor where id_proveedor=:id_proveedor";
			$this->setSQL($sql);

			$validar  = $this->search($data, false);

			if ($validar == []) {
				throw new \Exception("El id del proveedor no existe");
			}

			$sql = "UPDATE proveedor SET estado = 'DES' WHERE id_proveedor =:id";
			$this->setSQL($sql);

			$this->update_logic($data['id_proveedor']);
			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function restablecerProveedor()
	{
		try {
			$data = [
				'id_proveedor' => $this->getIdProveedor()
			];

			$sql = "SELECT * from proveedor where id_proveedor=:id_proveedor";
			$this->setSQL($sql);

			$validar  = $this->search($data, false);

			if ($validar == []) {
				throw new \Exception("El id del proveedor no existe");
			}

			$sql = "UPDATE proveedor SET estado = 'ACT' WHERE id_proveedor =:id";
			$this->setSQL($sql);

			$this->update_logic($data['id_proveedor']);
			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function editar()
	{
		try {
			$this->beginTransaction();

			$data1 = [
				'nombre' => $this->getNombre(),
				'rif' => $this->getRif(),
				'telefono' => $this->getTelefono(),
				'email' => $this->getEmail(),
				'direccion' => $this->getDireccion()
			];

			$data2 = [
				'id_proveedor' => $this->getIdProveedor(),
			];


			$sql = "SELECT * from proveedor where id_proveedor=:id_proveedor";
			$this->setSQL($sql);

			$validar  = $this->search($data2, false);

			if ($validar == []) {
				throw new \Exception("El id del proveedor no existe");
			}

			$rif = $this->validarRif(['rif' => $this->getRif()], true);


			if ($this->getRifRegistrado() == $rif) {
				$sql = "UPDATE proveedor SET nombre =:nombre, rif =:rif, telefono =:telefono, email=:email, direccion=:direccion WHERE id_proveedor = :id";

				$this->setSQL($sql);
				$this->update($data1, $this->getIdProveedor());
			} else {
				// Validación de cédula duplicada
				if ($this->validarRif(['rif' => $this->getRif()])) {
					throw new \Exception("El Rif ya está registrado.");
				} else {
					$sql = "UPDATE proveedor SET nombre =:nombre, rif =:rif, telefono =:telefono, email=:email, direccion=:direccion WHERE id_proveedor = :id";

					$this->setSQL($sql);
					$this->update($data1, $this->getIdProveedor());
				}
			}
			$this->commit();
			return ["exito"];
		} catch (\Exception $e) {
			$this->rollBack();
			return $e->getMessage();
		}
	}

	private function validarRif($data, $returnRif = false)
	{
		try {
			$sql = "SELECT * FROM proveedor WHERE rif =:rif";
			$this->setSQL($sql);
			$listData = $this->search($data, false);

			if ($returnRif) {
				return !empty($listData) ? $listData['rif'] : 0;
			} else {
				return !empty($listData) ? 1 : 0;
			}
		} catch (\Exception $e) {
			return 0;
		}
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
	public function getRifRegistrado()
	{
		return $this->rif_registrado;
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
		if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/", $nombre)) {
			throw new \InvalidArgumentException("El Nombre debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres");
		}
		$this->nombre = $nombre;
	}


	public function setRif($rif)
	{
		$this->rif = $rif;
	}

	public function setRifRegistrado($rif)
	{
		$this->rif_registrado = $rif;
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
