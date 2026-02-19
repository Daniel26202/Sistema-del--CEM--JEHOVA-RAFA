<?php

namespace App\modelos;

use App\modelos\ModeloInsumo;
use App\modelos\ModeloBase;

class ModeloEntrada extends ModelBase
{

	private $fechaDeVencimiento, $fechaDeIngreso, $precio, $cantidadDisponible, $idEntrada, $cantidadEntrante, $idProveedor, $lote, $idInsumo;

	public function __construct($dbSystem = true)
	{
		parent::__construct($dbSystem);
	}

	private function returnObjetModel()
	{
		return [
			"modeloInsumos" => new ModeloInsumo(),
			"modeloProveedores" => new ModeloProveedores(),
		];
	}

	public function selectProveedores()
	{
		try {
			$sql = "SELECT * FROM proveedor WHERE estado ='ACT' ";
			$this->setSQL($sql);
			$consulta = $this->read();
			return ($consulta) ? $consulta : false;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function todasLasEntradas()
	{
		try {
			//se cambio para que muestre las entradas act y que no estan vencidas
			$consulta = " SELECT ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad_entrante AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE  e.estado = 'ACT' AND i.estado = 'ACT' AND ei.fechaDeVencimiento > CURRENT_DATE ORDER BY ei.fechaDeVencimiento ";
			$this->setSQL($consulta);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function insumosEntrada()
	{
		try {
			$sql = " SELECT ei.id_entradaDeInsumo,i.*,e.*,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE i.id_insumo=:id_insumo AND e.estado = 'ACT' AND i.estado = 'ACT' ORDER BY e.fechaDeIngreso";
			$this->setSQL($sql);
			$consulta = $this->search(["id_insumo" => $this->returnObjetModel()['modeloInsumos']->getIdInsumo()]);

			return ($consulta) ? $consulta : false;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function insertarEntrada()
	{
		try {
			// $this->conexion->beginTransaction();

			$data = [
				'lote' => $this->getLote(),
				'id_proveedor' => $this->getIdProveedor(),
				'fechaDeIngreso' => $this->getFechaDeIngreso(),
				'id_insumo' => $this->getIdInsumo(),
				'fechaDeVencimiento' => $this->getFechaDeVencimiento(),
				'precio' => $this->getPrecio(),
				'cantidad_disponible' => $this->getCantidadDisponible(),
			];

			$sql = "call insert_entrada(:id_insumo, :id_proveedor, :fechaDeIngreso, :fechaDeVencimiento, :precio, :cantidad_disponible, :lote)";
			$this->setSQL($sql);
			
			$this->storedProcedure($data, false, true);

			// $sql = "SELECT * from entrada where id_entrada=:id_entrada";
			// $this->setSQL($sql);
			// $consulta = $this->search(["id_entrada" => $id], false);

			// $this->conexion->commit();

			return ["exito",$data];
		} catch (\Exception $e) {
			// $this->conexion->rollBack();
			return $e->getMessage();
		}
	}

	public function eliminar()
	{
		try {
			// $this->conexion->beginTransaction();

			$sql = "SELECT * from entrada where id_entrada=:id_entrada";
			$this->setSQL($sql);
			$validar = $this->search(["id_entrada" => $this->getIdEntrada()], false);
			if ($validar == []) {
				throw new \Exception("Fallo");
			}

			$sql = "UPDATE entrada SET estado='DES' WHERE id_entrada =:id";
			$this->setSQL($sql);
			$this->update_logic($this->getIdEntrada());

			// $this->conexion->commit();
			return ["exito"];
		} catch (\Exception $e) {
			// $this->conexion->rollBack();
			return $e->getMessage();
		}
	}


	public function actualizarEntrada()
	{
		try {
			// $this->conexion->beginTransaction();

			$sql = "SELECT * from entrada where id_entrada=:id_entrada";
			$this->setSQL($sql);
			$validar = $this->search(["id_entrada" => $this->getIdEntrada()]);
			if ($validar == []) {
				throw new \Exception("Fallo");
			}

			$sql = "UPDATE entrada_insumo SET fechaDeVencimiento=:fechaDeVencimiento,  precio=:precio,cantidad_entrante=:cantidad_entrante WHERE id_entrada=:id";
			$this->setSQL($sql);
			$data = [
				'fechaDeVencimiento' => $this->getFechaDeVencimiento(),
				'cantidad_entrante' => $this->getCantidadEntrante(),
				'precio' => $this->getPrecio(),
			];
			$this->update($data, $this->getIdEntrada());

			$sql = "UPDATE entrada SET numero_de_lote=:lote WHERE id_entrada=:id";
			$this->setSQL($sql);
			$data = ['lote' => $this->getLote()];
			$this->update($data, $this->getIdEntrada());

			// $this->conexion->commit();
			return ["exito"];
		} catch (\Exception $e) {
			// $this->conexion->rollBack();
			return $e->getMessage();
		}
	}


	//insumos
	public function insumos()
	{
		try {
			$sql = "SELECT * FROM insumo WHERE estado = 'ACT' ";
			$this->setSQL($sql);
			$consulta = $this->read();
			return ($consulta) ? $consulta : false;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function seleccionarDesactivos()
	{
		try {
			$sql = " SELECT ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad_disponible AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE  e.estado = 'DES'  ORDER BY ei.fechaDeVencimiento ";
			$this->setSQL($sql);
			$consulta = $this->read();
			return ($consulta) ? $consulta : false;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function restablecerEntrada()
	{
		try {
			$sql = "SELECT * from entrada where id_entrada=:id_entrada";
			$this->setSQL($sql);
			$validar=$this->search(["id_entrada" => $this->getIdEntrada()]);
			if ($validar == []) {
				throw new \Exception("Fallo");
			}
			$sql = "UPDATE entrada SET estado='ACT' WHERE id_entrada =:id";
			$this->setSQL($sql);
			$this->update([], $this->getIdEntrada());
			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	// setter
	public function setFechaDeVencimiento($fechaDeVencimiento)
	{
		$fecha = date("Y-m-d");

		if ($fecha > $fechaDeVencimiento) {
			throw new \Exception("La fecha no puede ser del pasado.");
		}

		$this->fechaDeVencimiento = $fechaDeVencimiento;
	}

	public function setFechaDeIngreso($fechaDeIngreso)
	{
		$d = new \DateTime($fechaDeIngreso);
		$hoy = new \DateTime();
		if ($d > $hoy) {
			throw new \InvalidArgumentException("La fecha no puede ser futura");
		}
		$this->fechaDeIngreso = $fechaDeIngreso;
	}

	public function setPrecio($precio)
	{
		if (!preg_match('/^\d+([.,]\d+)?$/', $precio)) {
			throw new \InvalidArgumentException('no es válido.');
		}
		if ((int)$precio <= 0) {
			throw new \InvalidArgumentException('El precio debe ser mayor que cero.');
		}
		$this->precio = $precio;
	}

	public function setCantidadDisponible($cantidad)
	{

		if (!preg_match('/^[0-9]+$/', $cantidad)) {
			throw new \InvalidArgumentException('La cantidad no es válida.');
		}
		if ((int)$cantidad <= 0) {
			throw new \InvalidArgumentException('La cantidad debe ser mayor que cero.');
		}
		$this->cantidadDisponible = $cantidad;
	}

	public function setCantidadEntrante($cantidadEntrante)
	{

		if (!preg_match('/^[0-9]+$/', $cantidadEntrante)) {
			throw new \InvalidArgumentException('La cantidad no es válida.');
		}
		if ((int)$cantidadEntrante <= 0) {
			throw new \InvalidArgumentException('La cantidad debe ser mayor que cero.');
		}
		$this->cantidadEntrante = $cantidadEntrante;
	}

	public function setIdEntrada($idEntrada)
	{

		if (!preg_match('/^[0-9]+$/', $idEntrada)) {
			throw new \InvalidArgumentException('El ID no es válido.');
		}
		if ((int)$idEntrada <= 0) {
			throw new \InvalidArgumentException('El ID debe ser mayor que cero.');
		}
		$this->idEntrada = $idEntrada;
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

	public function setLote($lote)
	{

		if (!preg_match('/^[0-9]+$/', $lote)) {
			throw new \InvalidArgumentException('El lote no es válido.');
		}
		if ((int)$lote <= 0) {
			throw new \InvalidArgumentException('El lote debe ser mayor que cero.');
		}
		$this->lote = $lote;
	}

	public function setIdInsumo($idInsumo)
	{

		if (!preg_match('/^[0-9]+$/', $idInsumo)) {
			throw new \InvalidArgumentException('El ID no es válido.');
		}
		if ((int)$idInsumo <= 0) {
			throw new \InvalidArgumentException('El ID debe ser mayor que cero.');
		}
		$this->idInsumo = $idInsumo;
	}


	// getter
	public function getCantidadEntrante()
	{
		return $this->cantidadEntrante;
	}
	public function getIdEntrada()
	{
		return $this->idEntrada;
	}

	public function getCantidadDisponible()
	{
		return $this->cantidadDisponible;
	}

	public function getPrecio()
	{
		return $this->precio;
	}

	public function getFechaDeIngreso()
	{
		return $this->fechaDeIngreso;
	}

	public function getFechaDeVencimiento()
	{
		return $this->fechaDeVencimiento;
	}

	public function getIdProveedor()
	{
		return $this->idProveedor;
	}

	public function getLote()
	{
		return $this->lote;
	}

	public function getIdInsumo()
	{
		return $this->idInsumo;
	}
}
