<?php
// SELECT i.*,e.*,SUM(e.cantidad) AS cantidad_sumada FROM entrada e INNER JOIN insumo i ON e.id_insumo = i.id_insumo GROUP BY i.nombre HAVING i.id_insumo = 2
namespace App\modelos;

use App\modelos\ModelBase;
use App\modelos\ModeloProveedores;
use DateTime;
use  App\config\Validations;

class ModeloInsumo extends ModelBase
{


	private $idInsumo, $cantidadCero, $parametro, $nombre, $imagen, $descripcion, $fechaDeIngreso, $fechaDeVencimiento, $precio, $cantidad, $stockMinimo, $lote, $marca, $medida, $iva, $imagenAntigua, $insumosArray, $idProveedor;
	public function __construct($dbSystem = true)
	{
		parent::__construct($dbSystem);
	}

	private function returnObjetModel()
	{
		return [
			"modeloProveedores" => new ModeloProveedores(),
		];
	}

	public function selectProveedores()
	{
		try {
			$sql = "SELECT * FROM proveedor";
			$this->setSQL($sql);
			$consulta = $this->read();
			return $consulta;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function cantidadCero($cantidadCero) {}

	public function insumos($cantidadCero = true)
	{
		try {
			$sql = "";
			if ($cantidadCero) $sql = "SELECT *,sum(inv.cantidad_disponible) cantidad_inventario, ROW_NUMBER() OVER (ORDER BY inv.id_insumo) AS indice  FROM entrada_insumo inv INNER JOIN insumo i ON i.id_insumo =  inv.id_insumo WHERE i.estado ='ACT' AND inv.cantidad_disponible >= 0  GROUP BY inv.id_insumo ";

			else   $sql = "SELECT *,sum(inv.cantidad_disponible) as cantidad_inventario  FROM entrada_insumo inv INNER JOIN insumo i ON i.id_insumo =  inv.id_insumo WHERE i.estado ='ACT' AND inv.cantidad_disponible > 0  GROUP BY inv.id_insumo ";

			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function InsumosVencidos()
	{
		try {
			$sql = "SELECT ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad_disponible AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE ei.fechaDeVencimiento <= CURRENT_DATE";
			$this->setSQL($sql);
			$consulta = $this->read();
			return $consulta;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function insumosInfo()
	{
		try {
			$sql = "SELECT * FROM insumo WHERE id_insumo =:id_insumo";
			$this->setSQL($sql);
			$consulta = $this->search(["id_insumo" => $this->getIdInsumo()]);
			return $consulta;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	//metodo para taerme el insumo que su fecha de vencimiento esta mas cercana para mostrarlo en el modal de info
	public function retornarFechaDeVencimiento()
	{
		try {
			$sql = "SELECT fechaDeVencimiento FROM entrada_insumo WHERE id_insumo =:id_insumo ORDER BY fechaDeVencimiento LIMIT 1";
			$this->setSQL($sql);
			$consulta = $this->search(["id_insumo" => $this->getIdInsumo()]);
			return $consulta;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	//cantidad insumos
	public function cantidadInsumos($id_insumo)
	{
		try {
			$sql = "SELECT i.id_insumo,SUM(ei.cantidad) AS cantidad_sumada FROM entrada e INNER JOIN entrada_insumo ei ON e.id_entrada = e.id_entrada INNER JOIN insumo i ON i.id_insumo = ei.id_insumo GROUP BY i.nombre HAVING i.id_insumo =:id_insumo";
			$consulta = $this->search(["id_insumo" => $this->getIdInsumo()]);
			return $consulta;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function buscarInsumos()
	{
		try {
			$sql = "SELECT * FROM insumo WHERE nombre LIKE :buscar AND estado = 'ACT' OR id_insumo LIKE :buscar AND estado = 'ACT'";
			$parametro = $this->getParametro();
			$buscar = "$parametro%";
			$consulta = $this->search(["buscar" => $buscar]);
			return $consulta;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}






	//insertar insumo
	public function insertarInsumos()
	{
		try {
			// $this->conexion->beginTransaction();

			$data = [
				"imagen" => $this->getImagen(),
				"nombre" => $this->getNombre(),
				"id_proveedor" => $this->getIdProveedor(),
				"descripcion" => $this->getDescripcion(),
				"fechaDeIngreso" => $this->getFechaDeIngreso(),
				"fechaDeVecimiento" => $this->getFechaDeVencimiento(),
				"precio" => $this->getPrecio(),
				"cantidad" => $this->getCantidad(),
				"stockMinimo" => $this->getStockMinimo(),
				"lote" => $this->getLote(),
				"marca" => $this->getMarca(),
				"medida" => $this->getMedida(),
				"iva" => $this->getIva()
			];

			$sql = "call insert_insumo(:imagen, :nombre, :id_proveedor, :descripcion, :fechaDeIngreso, :fechaDeVecimiento,:precio, :cantidad, :stockMinimo, :lote, :marca, :medida, :iva)";
			$this->setSQL($sql);
			

			$this->storedProcedure($data, true,true);


			// $this->conexion->commit();

			return ["exito", $data];
		} catch (\Exception $e) {
			// $this->conexion->rollBack();
			// Puedes registrar el error si lo deseas: error_log($e->getMessage());
			return $e->getMessage();
		}
	}



	public function eliminar()
	{
		try {
			$sql = "SELECT * from insumo where id_insumo=:id_insumo";
			$this->setSQL($sql);
			$validar = $this->search(["id_insumo" => $this->getIdInsumo()]);
			if ($validar == []) {
				throw new \Exception("Fallo");
			}

			$sql = "UPDATE insumo SET estado = 'DES' WHERE id_insumo =:id";
			$this->setSQL($sql);
			$consulta = $this->update([], $this->getIdInsumo());
			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function editar()
	{
		try {
			// Buscar datos actuales para obtener el nombre de la imagen vieja
			$sql = "SELECT imagen FROM insumo WHERE id_insumo = :id_insumo";
			$this->setSQL($sql);
			$datos = $this->search(["id_insumo" => $this->getIdInsumo()], false);

			if (!$datos) {
				throw new \Exception("Fallo: el id no existe");
			}

			$imagenNueva = $this->getImagen(); // El nombre generado en el controlador
			$imagenAntigua = $datos["imagen"];

			if ($imagenNueva != null) {
				// SI HAY IMAGEN NUEVA: Borrar la vieja y actualizar campo
				$rutaImagenAntigua = "./src/assets/images/img_ingresadas_por_usuarios/insumos/" . $imagenAntigua;
				if (!empty($imagenAntigua) && file_exists($rutaImagenAntigua)) {
					unlink($rutaImagenAntigua);
				}

				$sql = "UPDATE insumo SET imagen = :imagen, nombre = :nombre, descripcion = :descripcion, 
                    stockMinimo = :stockMinimo, marca = :marca, medida = :medida WHERE id_insumo = :id";
				$data = [
					"imagen" => $imagenNueva,
					"nombre" => $this->getNombre(),
					"descripcion" => $this->getDescripcion(),
					"stockMinimo" => $this->getStockMinimo(),
					"marca" => $this->getMarca(),
					"medida" => $this->getMedida()
				];
			} else {
				// NO HAY IMAGEN NUEVA: Mantener la actual (no tocar el campo imagen)
				$sql = "UPDATE insumo SET nombre = :nombre, descripcion = :descripcion, 
                    stockMinimo = :stockMinimo, marca = :marca, medida = :medida WHERE id_insumo = :id";
				$data = [
					"nombre" => $this->getNombre(),
					"descripcion" => $this->getDescripcion(),
					"stockMinimo" => $this->getStockMinimo(),
					"marca" => $this->getMarca(),
					"medida" => $this->getMedida()
				];
			}

			$this->setSQL($sql);
			$this->update($data, $this->getIdInsumo());

			return ["exito", $imagenNueva];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	//gestionar salidas
	public function todasLasEntradas()
	{
		try {
			$sql = "SELECT ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad_entrante AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE  i.estado = 'ACT' AND e.estado = 'ACT' AND fechaDeVencimiento BETWEEN CURRENT_DATE + INTERVAL 1 DAY AND CURRENT_DATE + INTERVAL 7 DAY ORDER BY  ei.fechaDeVencimiento";
			$this->setSQL($sql);
			$consulta = $this->read();
			return ($consulta) ? $consulta : false;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function vencerInsumos()
	{
		try {
			$insumos = $this->insumos();
			foreach ($insumos as $key) {
				//echo $key["id_insumo"]."<br>";
				$inventario = $this->actualizar_cantidad_insumo($key["id_insumo"]);
				// print_r($cantidad[0]["cantidad"]);

				//esto es para actualizar la cantidad de insumos
				$sql = "UPDATE inventario SET cantidad=:cantidad WHERE id_insumo=:id";
				$this->setSQL($sql);
				$this->update(['cantidad' => $inventario[0]["cantidad"]], $key["id_insumo"]);
			}
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	//funcion mejorada de actualizacion de la cantidad
	public function actualizar_cantidad_insumo()
	{
		try {
			$sql = " SELECT ei.id_insumo, ei.fechaDeVencimiento, SUM(ei.cantidad_disponible) AS cantidad, e.numero_de_lote FROM entrada_insumo ei INNER JOIN entrada e on e.id_entrada = ei.id_entrada WHERE ei.id_insumo =:id_insumo AND ei.fechaDeVencimiento > CURRENT_DATE AND e.estado = 'ACT' ";
			$this->setSQL($sql);
			$consulta = $this->search(['id_insumo' => $this->getIdInsumo()], true);
			return ($consulta) ? $consulta : false;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}



	//
	public function papelera()
	{
		try {
			$sql = "SELECT *,inv.cantidad_disponible as cantidad_inventario  FROM entrada_insumo inv INNER JOIN insumo i ON i.id_insumo =  inv.id_insumo WHERE i.estado ='DES' AND inv.cantidad_disponible >= 0  GROUP BY inv.id_insumo ";
			$this->setSQL($sql);
			$consulta = $this->read();

			return ($consulta) ? $consulta : false;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}



	public function restablecerInsumo()
	{
		try {
			$sql = "SELECT * from insumo where id_insumo=:id_insumo";
			$this->setSQL($sql);
			$validar = $this->search(['id_insumo' => $this->getIdInsumo()]);
			if ($validar == []) {
				throw new \Exception("Fallo el id no existe");
			}
			$sql = "UPDATE insumo SET estado = 'ACT' WHERE id_insumo =:id";
			$this->setSQL($sql);
			$this->update([], $this->getIdInsumo());

			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}



	// getter y setter
	// setter
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
	public function setCantidad($cantidad)
	{

		if (!preg_match('/^[0-9]+$/', $cantidad)) {
			throw new \InvalidArgumentException('La cantidad no es válida.');
		}
		if ((int)$cantidad <= 0) {
			throw new \InvalidArgumentException('La cantidad debe ser mayor que cero.');
		}
		$this->cantidad = $cantidad;
	}

	public function setStockMinimo($stockMinimo)
	{

		if (!preg_match('/^[0-9]+$/', $stockMinimo)) {
			throw new \InvalidArgumentException('El stock mínimo no es válido.');
		}
		if ((int)$stockMinimo <= 0) {
			throw new \InvalidArgumentException('El stock mínimo debe ser mayor que cero.');
		}
		$this->stockMinimo = $stockMinimo;
	}

	public function setIva($iva)
	{

		if (!preg_match('/^[0-9]+$/', $iva)) {
			throw new \InvalidArgumentException('El iva no es válido.');
		}
		$this->iva = $iva;
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

	public function setCantidadCero($cantidadCero)
	{
		if (!preg_match('/^[0-1]+$/', $cantidadCero) && !is_bool($cantidadCero)) {
			throw new \InvalidArgumentException('no es válido.');
		}

		$this->cantidadCero = $cantidadCero;
	}

	public function setParametro($parametro)
	{
		if (!preg_match('/^[\p{L}\p{N}]+$/u', $parametro)) {
			throw new \InvalidArgumentException('El parámetro no es válido.');
		}

		$this->parametro = $parametro;
	}

	public function setNombre($nombre)
	{
		if (!preg_match('/^[\p{L}]+$/u', $nombre)) {
			throw new \InvalidArgumentException('El nombre no es válido.');
		}

		$this->nombre = $nombre;
	}

	public function setDescripcion($descripcion)
	{
		if (!preg_match('/^[\p{L}\p{N}\s\.,-]+$/u', $descripcion)) {
			throw new \InvalidArgumentException('La descripción no es válida.');
		}

		$this->descripcion = $descripcion;
	}

	public function setImagen($imagen)
	{
		// Validar que el archivo se haya subido sin errores
		// if ($imagen['error'] !== UPLOAD_ERR_OK) {
		// 	throw new \InvalidArgumentException('Error al subir la imagen.');
		// }

		// // Validar extensión
		// $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
		// $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));

		// if (!in_array($extension, $extensionesPermitidas)) {
		// 	throw new \InvalidArgumentException('Solo se permiten imágenes JPG, PNG o GIF.');
		// }

		// // Validar tamaño (ejemplo: máximo 5 MB)
		// if ($imagen['size'] > 5 * 1024 * 1024) {
		// 	throw new \InvalidArgumentException('La imagen no debe superar los 5 MB.');
		// }

		// Si todo está bien, guardamos el nombre temporal para moverlo después
		$this->imagen = $imagen;
	}
	public function setImagenAntigua($imagen)
	{
		// Validar que el archivo se haya subido sin errores
		if ($imagen['error'] !== UPLOAD_ERR_OK) {
			throw new \InvalidArgumentException('Error al subir la imagen.');
		}

		// Validar extensión
		$extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
		$extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));

		if (!in_array($extension, $extensionesPermitidas)) {
			throw new \InvalidArgumentException('Solo se permiten imágenes JPG, PNG o GIF.');
		}

		// Validar tamaño (ejemplo: máximo 5 MB)
		if ($imagen['size'] > 5 * 1024 * 1024) {
			throw new \InvalidArgumentException('La imagen no debe superar los 5 MB.');
		}

		// Si todo está bien, guardamos el nombre temporal para moverlo después
		$this->imagen = $imagen;
	}

	public function setMarca($marca)
	{
		if (!preg_match('/^[\p{L}\p{N}\s\-\.,]{1,100}$/u', $marca)) {
			throw new \InvalidArgumentException('La marca no es válida.');
		}

		$this->marca = $marca;
	}

	public function setMedida($medida)
	{
		if (!preg_match('/^\d+(\.\d+)?\s?(kg|g|mg|l|ml|m|cm|mm)$/i', $medida)) {
			throw new \InvalidArgumentException('La medida no es válida.');
		}

		$this->medida = $medida;
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

	// Setter: fecha de vencimiento debe ser menor a hoy
	public function setFechaDeVencimiento($fechaDeVencimiento)
	{
		$dt = \DateTime::createFromFormat('Y-m-d', $fechaDeVencimiento);
		$fechaHoy = date("Y-m-d");

		if (!$dt || $dt->format('Y-m-d') !== $fechaDeVencimiento) {
			throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
		}
		if ($fechaDeVencimiento <= $fechaHoy) {
			throw new \InvalidArgumentException("La fecha no puede ser del pasado.");
		}
		$this->fechaDeVencimiento = $fechaDeVencimiento;
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

	// getter

	public function getInsumosArray()
	{
		return $this->insumosArray;
	}

	public function getIva()
	{
		return $this->iva;
	}

	public function getMarca()
	{
		return $this->marca;
	}

	public function getMedida()
	{
		return $this->medida;
	}

	public function getPrecio()
	{
		return $this->precio;
	}

	public function getLote()
	{
		return $this->lote;
	}

	public function getStockMinimo()
	{
		return $this->stockMinimo;
	}

	public function getCantidad()
	{
		return $this->cantidad;
	}

	public function getFechaDeVencimiento()
	{
		return $this->fechaDeVencimiento;
		// return $this->fechaDeVencimiento->format('Y-m-d');
	}

	public function getFechaDeIngreso()
	{
		return $this->fechaDeIngreso;
	}

	public function getDescripcion()
	{
		return $this->descripcion;
	}

	public function getImagen()
	{
		return $this->imagen;
	}
	public function getImagenAntigua()
	{
		return $this->imagenAntigua;
	}

	public function getIdInsumo()
	{
		return $this->idInsumo;
	}

	public function getNombre()
	{
		return $this->nombre;
	}

	public function getParametro()
	{
		return $this->parametro;
	}

	public function getCantidadCero()
	{
		return $this->cantidadCero;
	}

	public function getIdProveedor()
	{
		return $this->idProveedor;
	}
}
