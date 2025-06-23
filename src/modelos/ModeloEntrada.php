<?php

namespace App\modelos;

use App\modelos\Db;
use App\modelos\ModeloInsumo;

class ModeloEntrada extends Db
{

	private $conexion;
	private $modeloInsumo;



	public function __construct()
	{
		$this->conexion = $this->connectionSistema();
		$this->modeloInsumo = new ModeloInsumo();
	}
	public function selectProveedores()
	{
		try {
			$consulta = $this->conexion->prepare("SELECT * FROM proveedor WHERE estado ='ACT' ");
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function todasLasEntradas()
	{
		try {
			//se cambio para que muestre las entradas act y que no estan vencidas
			$consulta = $this->conexion->prepare(" SELECT ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad_entrante AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE  e.estado = 'ACT' AND i.estado = 'ACT' AND ei.fechaDeVencimiento > CURRENT_DATE ORDER BY ei.fechaDeVencimiento ");
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function insumosEntrada($id_insumo)
	{
		try {
			$consulta = $this->conexion->prepare(" SELECT ei.id_entradaDeInsumo,i.*,e.*,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE i.id_insumo=:id_insumo AND e.estado = 'ACT' AND i.estado = 'ACT' ORDER BY e.fechaDeIngreso");
			$consulta->bindParam(":id_insumo", $id_insumo);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function insertarEntrada($id_proveedor, $id_insumo, $fechaDeIngreso, $fechaDeVencimiento, $cantidad, $precio, $lote)
	{
		try {
			$this->conexion->beginTransaction();

			$consulta = $this->conexion->prepare("INSERT INTO entrada VALUES (null, :id_proveedor, :lote, :fechaDeIngreso, 'ACT')");
			$consulta->bindParam(":lote", $lote);
			$consulta->bindParam(":id_proveedor", $id_proveedor);
			$consulta->bindParam(":fechaDeIngreso", $fechaDeIngreso);
			$consulta->execute();
			$id_entrada = $this->conexion->lastInsertId();

			$consulta2 = $this->conexion->prepare("INSERT INTO entrada_insumo VALUES (null, :id_insumo, :id_entrada,:fechaDeVencimiento,:precio, :cantidad_entrante, :cantidad_disponible)");
			$consulta2->bindParam(":id_insumo", $id_insumo);
			$consulta2->bindParam(":id_entrada", $id_entrada);
			$consulta2->bindParam(":fechaDeVencimiento", $fechaDeVencimiento);
			$consulta2->bindParam(":precio", $precio);
			$consulta2->bindParam(":cantidad_entrante", $cantidad);
			$consulta2->bindParam(":cantidad_disponible", $cantidad);
			$consulta2->execute();

			$this->conexion->commit();
			return 1;
		} catch (\Exception $e) {
			$this->conexion->rollBack();
			return 0;
		}
	}

	public function eliminar($id_entrada, $id_insumo)
	{
		try {
			$this->conexion->beginTransaction();
			$consulta = $this->conexion->prepare("UPDATE entrada SET estado='DES' WHERE id_entrada =:id_entrada");
			$consulta->bindParam(":id_entrada", $id_entrada);
			$consulta->execute();
			$this->conexion->commit();
			return 1;
		} catch (\Exception $e) {
			$this->conexion->rollBack();
			return 0;
		}
	}


	public function actualizarEntrada($id_entrada, $id_proveedor, $fechaDeVencimiento, $cantidad, $precio, $id_insumo)
	{
		try {
			$this->conexion->beginTransaction();

			$consulta = $this->conexion->prepare("UPDATE entrada_insumo SET fechaDeVencimiento=:fechaDeVencimiento,  precio=:precio,cantidad_entrante=:cantidad_entrante WHERE id_entrada=:id_entrada");

			//return ($consulta->execute()) ? $consulta->fetchAll() : false;
			$consulta->bindParam(":fechaDeVencimiento", $fechaDeVencimiento);
			$consulta->bindParam(":cantidad_entrante", $cantidad);
			$consulta->bindParam(":precio", $precio);
			$consulta->bindParam(":id_entrada", $id_entrada);
			$consulta->execute();

			//se llama a un metodo de el ModeloInsumo para traer la cantidad de insumo que hay disponible y se guarda en una variable llamada cantidadInsumos
			$cantidadInsumos = $this->modeloInsumo->actualizar_cantidad_insumo($id_insumo);
			$this->conexion->commit();
			return 1;
		} catch (\Exception $e) {
			$this->conexion->rollBack();
			return 0;
		}
	}


	//insumos
	public function insumos()
	{
		try {
			$consulta = $this->conexion->prepare("SELECT * FROM insumo WHERE estado = 'ACT' ");
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}


	public function seleccionarDesactivos()
	{
		try {
			$consulta = $this->conexion->prepare(" SELECT ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad_disponible AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE  e.estado = 'DES'  ORDER BY ei.fechaDeVencimiento ");
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}


	public function restablecerEntrada($id_entrada)
	{
		try {
			$consulta = $this->conexion->prepare("UPDATE entrada SET estado='ACT' WHERE id_entrada =:id_entrada");
			$consulta->bindParam(":id_entrada", $id_entrada);
			$consulta->execute();
			return 1;
		} catch (\Exception $e) {
			return 0;
		}
	}
}
