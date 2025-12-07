<?php

namespace App\modelos;

use App\modelos\Db;
use App\config\Validations;

class ModeloProveedores extends Db
{

	private $conexion;
	public function __construct()
	{
		$this->conexion = $this->connectionSistema();
	}


	public function consultar()
	{
		try {
			$sql = $this->conexion->prepare("SELECT * FROM proveedor WHERE estado='ACT' ");
			$sql->execute();
			return $sql->fetchAll();
		} catch (\Exception $e) {
			return 0;
		}
	}


	public function papeleraConsultar()
	{
		try {
			$sql = $this->conexion->prepare("SELECT * FROM proveedor WHERE estado='DES' ");
			$sql->execute();
			return $sql->fetchAll();
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function agregar($nombre, $rif, $telefono, $email, $direccion)
	{
		try {


			$validaciones  = Validations::validationRules($nombre, $telefono, $rif, $email, $direccion);


			foreach ($validaciones as $v) {
				if (!preg_match($v['regex'], $v['valor'])) {
					throw new \Exception($v['mensaje']);
				}
			}

			if ($this->validarRif($rif) === "existeC") {
				throw new \Exception("El rif ya existe en el sistema.");
			}

			$sql = $this->conexion->prepare("INSERT INTO proveedor(nombre, rif, telefono, email, direccion, estado) VALUES (:nombre, :rif, :telefono, :email, :direccion, 'ACT');");
			$sql->bindParam(":nombre", $nombre);
			$sql->bindParam(":rif", $rif);
			$sql->bindParam(":telefono", $telefono);
			$sql->bindParam(":email", $email);
			$sql->bindParam(":direccion", $direccion);
			$sql->execute();

            $id = $this->conexion->lastInsertId();

			$consulta = $this->conexion->prepare("SELECT * from proveedor where id_proveedor=:id_proveedor");
			$consulta->bindParam(":id_proveedor", $id);
			$consulta->execute();
			$data = ($consulta->execute()) ? $consulta->fetch() : false;

			return ["exito", $data];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	// eliminación logica
	public function update($id_proveedor)
	{
		try {
			$validar = $this->conexion->prepare("SELECT * from proveedor where id_proveedor=:id_proveedor");
			$validar->bindParam(":id_proveedor", $id_proveedor);
			$validar->execute();
			if ($validar->rowCount() <= 0) {
				throw new \Exception("Fallo el id no existe");
			}
			$sql = $this->conexion->prepare("UPDATE proveedor SET estado='DES' WHERE id_proveedor = :id_proveedor;");
			$sql->bindParam(":id_proveedor", $id_proveedor);
			$sql->execute();
			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function restablecerProveedor($id_proveedor)
	{
		try {
			$validar = $this->conexion->prepare("SELECT * from proveedor where id_proveedor=:id_proveedor");
			$validar->bindParam(":id_proveedor", $id_proveedor);
			$validar->execute();
			if ($validar->rowCount() <= 0) {
				throw new \Exception("Fallo el id no existe");
			}
			$sql = $this->conexion->prepare("UPDATE proveedor SET estado='ACT' WHERE id_proveedor = :id_proveedor");
			$sql->bindParam(":id_proveedor", $id_proveedor);
			$sql->execute();
			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function editar($id_proveedor, $nombre, $rif, $telefono, $email, $direccion, $rifRegistrado)
	{
		try {
			$validaciones  = Validations::validationRules($nombre, $telefono, $rif, $email, $direccion);


			foreach ($validaciones as $v) {
				if (!preg_match($v['regex'], $v['valor'])) {
					throw new \Exception($v['mensaje']);
				}
			}


			if($rifRegistrado == $rif){

			}else{
				if ($this->validarRif($rif) === "existeC") {
					throw new \Exception("El rif ya existe en el sistema.");
				}
			}

			$validar = $this->conexion->prepare("SELECT * from proveedor where id_proveedor=:id_proveedor");
			$validar->bindParam(":id_proveedor", $id_proveedor);
			$validar->execute();
			if ($validar->rowCount() <= 0) {
				throw new \Exception("Fallo el id no existe");
			}
			$sql = $this->conexion->prepare("UPDATE proveedor SET nombre =:nombre, rif =:rif, telefono =:telefono, email=:email, direccion=:direccion WHERE id_proveedor = :id_proveedor");
			$sql->bindParam(":nombre", $nombre);
			$sql->bindParam(":rif", $rif);
			$sql->bindParam(":telefono", $telefono);
			$sql->bindParam(":email", $email);
			$sql->bindParam(":direccion", $direccion);
			$sql->bindParam(":id_proveedor", $id_proveedor);
			$sql->execute();
			
			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function validarRif($rif)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT * FROM proveedor WHERE rif =:rif");

			$consulta->bindParam(":rif", $rif);
			$consulta->execute();

			while ($consulta->fetch()) {
				return "existeC";
			}
			return "noExiste";
		} catch (\Exception $e) {
			return 0;
		}
	}
}
