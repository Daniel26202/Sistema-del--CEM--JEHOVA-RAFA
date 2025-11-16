<?php

namespace App\modelos;

use App\modelos\Db;
use App\modelos\ModeloInsumo;

use App\config\Validations;
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
			return $e->getMessage();
		}
	}

	public function todasLasEntradas()
	{
		try {
			//se cambio para que muestre las entradas act y que no estan vencidas
			$consulta = $this->conexion->prepare(" SELECT ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad_entrante AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE  e.estado = 'ACT' AND i.estado = 'ACT' AND ei.fechaDeVencimiento > CURRENT_DATE ORDER BY ei.fechaDeVencimiento ");
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function insumosEntrada($id_insumo)
	{
		try {
			$consulta = $this->conexion->prepare(" SELECT ei.id_entradaDeInsumo,i.*,e.*,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE i.id_insumo=:id_insumo AND e.estado = 'ACT' AND i.estado = 'ACT' ORDER BY e.fechaDeIngreso");
			$consulta->bindParam(":id_insumo", $id_insumo);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function insertarEntrada($id_proveedor, $id_insumo, $fechaDeIngreso, $fechaDeVencimiento, $cantidad, $precio, $lote)
	{
		try {
			$this->conexion->beginTransaction();

			$fecha = date("Y-m-d");

			$errores = [];

			$validaciones  = Validations::validationEntrada($fechaDeVencimiento, $cantidad, $precio, $lote);


			foreach ($validaciones as $regla) {
				if (!preg_match($regla['regex'], $regla['valor'])) {
					$errores[] = $regla['mensaje'];
				}
			}

			if (count($errores) > 0) {
				$mensaje = "";
				foreach ($errores as $error) {
					$mensaje .= $error . "\n";
				}
				throw new \Exception($mensaje);
			}

			if ($fecha > $fechaDeVencimiento) {
				throw new \Exception("La fecha no puede ser del pasado.");
			}

			$consulta = $this->conexion->prepare("call insert_entrada(:id_insumo, :id_proveedor, :fechaDeIngreso, :fechaDeVencimiento, :precio, :cantidad_disponible, :lote)");
			$consulta->bindParam(":lote", $lote);
			$consulta->bindParam(":id_proveedor", $id_proveedor);
			$consulta->bindParam(":fechaDeIngreso", $fechaDeIngreso);
			$consulta->bindParam(":id_insumo", $id_insumo);
			$consulta->bindParam(":fechaDeVencimiento", $fechaDeVencimiento);
			$consulta->bindParam(":precio", $precio);
			$consulta->bindParam(":cantidad_disponible", $cantidad);
			$consulta->execute();

			$id = $this->conexion->lastInsertId();

			$consulta = $this->conexion->prepare("SELECT * from entrada where id_entrada=:id_entrada");
			$consulta->bindParam(":id_entrada", $id);
			$consulta->execute();
			$data = ($consulta->execute()) ? $consulta->fetch() : false;

			$this->conexion->commit();

			return ["exito", $data];
		} catch (\Exception $e) {
			$this->conexion->rollBack();
			return $e->getMessage();
		}
	}

	public function eliminar($id_entrada)
	{
		try {
			$this->conexion->beginTransaction();

			$validar = $this->conexion->prepare("SELECT * from entrada where id_entrada=:id_entrada");
			$validar->bindParam(":id_entrada", $id_entrada);
			$validar->execute();
			if ($validar->rowCount() <= 0) {
				throw new \Exception("Fallo");
			}


			$consulta = $this->conexion->prepare("UPDATE entrada SET estado='DES' WHERE id_entrada =:id_entrada");
			$consulta->bindParam(":id_entrada", $id_entrada);
			$consulta->execute();

			$this->conexion->commit();
			return ["exito"];
		} catch (\Exception $e) {
			$this->conexion->rollBack();
			return $e->getMessage();
		}
	}


	public function actualizarEntrada($id_entrada, $id_proveedor, $fechaDeVencimiento, $cantidad, $precio, $id_insumo, $lote)
	{
		try {
			$this->conexion->beginTransaction();

			$fecha = date("Y-m-d");

			$errores = [];

			$validaciones  = Validations::validationEntrada($fechaDeVencimiento, $cantidad, $precio, $lote);


			foreach ($validaciones as $regla) {
				if (!preg_match($regla['regex'], $regla['valor'])) {
					$errores[] = $regla['mensaje'];
				}
			}

			if (count($errores) > 0) {
				$mensaje = "";
				foreach ($errores as $error) {
					$mensaje .= $error . "\n";
				}
				throw new \Exception($mensaje);
			}

			if ($fecha > $fechaDeVencimiento) {
				throw new \Exception("La fecha no puede ser del pasado.");
			}


			$validar = $this->conexion->prepare("SELECT * from entrada where id_entrada=:id_entrada");
			$validar->bindParam(":id_entrada", $id_entrada);
			$validar->execute();
			if ($validar->rowCount() <= 0) {
				throw new \Exception("Fallo");
			}

			$consulta = $this->conexion->prepare("UPDATE entrada_insumo SET fechaDeVencimiento=:fechaDeVencimiento,  precio=:precio,cantidad_entrante=:cantidad_entrante WHERE id_entrada=:id_entrada");

			//return ($consulta->execute()) ? $consulta->fetchAll() : false;
			$consulta->bindParam(":fechaDeVencimiento", $fechaDeVencimiento);
			$consulta->bindParam(":cantidad_entrante", $cantidad);
			$consulta->bindParam(":precio", $precio);
			$consulta->bindParam(":id_entrada", $id_entrada);
			$consulta->execute();

			$consulta = $this->conexion->prepare("UPDATE entrada SET numero_de_lote=:lote WHERE id_entrada=:id_entrada");
			$consulta->bindParam(":lote", $lote);
			$consulta->bindParam(":id_entrada", $id_entrada);
			$consulta->execute();

			$this->conexion->commit();
			return ["exito"];
		} catch (\Exception $e) {
			$this->conexion->rollBack();
			return $e->getMessage();
		}
	}


	//insumos
	public function insumos()
	{
		try {
			$consulta = $this->conexion->prepare("SELECT * FROM insumo WHERE estado = 'ACT' ");
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function seleccionarDesactivos()
	{
		try {
			$consulta = $this->conexion->prepare(" SELECT ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad_disponible AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE  e.estado = 'DES'  ORDER BY ei.fechaDeVencimiento ");
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function restablecerEntrada($id_entrada)
	{
		try {
			$validar = $this->conexion->prepare("SELECT * from entrada where id_entrada=:id_entrada");
			$validar->bindParam(":id_entrada", $id_entrada);
			$validar->execute();
			if ($validar->rowCount() <= 0) {
				throw new \Exception("Fallo");
			}
			$consulta = $this->conexion->prepare("UPDATE entrada SET estado='ACT' WHERE id_entrada =:id_entrada");
			$consulta->bindParam(":id_entrada", $id_entrada);
			$consulta->execute();
			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
}
