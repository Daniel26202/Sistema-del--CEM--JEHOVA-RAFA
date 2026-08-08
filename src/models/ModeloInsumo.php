<?php
// SELECT i.*,e.*,SUM(e.cantidad) AS cantidad_sumada FROM entrada e INNER JOIN insumo i ON e.id_insumo = i.id_insumo GROUP BY i.nombre HAVING i.id_insumo = 2
namespace App\models;

use App\models\ModelBase;
use App\models\interfaces\InterfaceConnection;
use App\models\interfaces\InterfaceValidator;
use App\models\TraitCreate;
use App\models\TraitUpdate;
use DateTime;
use PDO;

class ModeloInsumo extends ModelBase
{


	private $idInsumo, $cantidadCero, $parametro, $nombre, $imagen, $descripcion, $fechaDeIngreso, $fechaDeVencimiento, $precio, $cantidad, $stockMinimo, $lote, $marca, $medida, $iva, $imagenAntigua, $insumosArray;
	private $validator;
	use TraitCreate,TraitUpdate;

	public function __construct(InterfaceConnection $conn, InterfaceValidator $vali)
	{
		parent::__construct($conn);
		$this->validator = $vali;
	}
	public function insumos()
	{
		$this->set_tables(['view_resumen_insumos']);
		$this->set_colums(['id_insumo', 'nombre', 'imagen', 'descripcion', 'marca', 'medida', 'precio', 'stockMinimo', 'iva', 'disponible']);
		return $this->read();
	}


	public function InsumosVencidos($start = 0, $limit = 10, $search = '', $ordenColumn = 'id_paciente', $ordenDir = 'DESC')
	{
		$alias = ['ei', 'i', 'e', 'p'];
		$unions = [
			'i.id_insumo = ei.id_insumo',
			'e.id_entrada = ei.id_entrada',
			'p.id_proveedor = e.id_proveedor'
		];
		$coditions = [
			'condiciones' => ['ei.fechaDeVencimiento' => 'CURRENT_DATE'],
			'conectores' => [''],
			'operadores' => ['<=']
		];
		$this->set_tables(["entrada_insumo", "insumo", "entrada", "proveedor"]);
		$this->set_colums(['ei.fechaDeVencimiento', 'ei.id_entradaDeInsumo', 'i.imagen', 'i.nombre', 'i.descripcion', 'i.marca', 'i.medida', 'i.precio', 'i.stockMinimo', 'i.iva', 'i.id_insumo AS id_insumo_e', 'ei.cantidad_disponible AS cantidad_entrada', 'ei.precio AS precio_entrada', 'p.nombre AS proveedor']);
		$this->set_alias($alias);
		$this->set_union($unions);

		$this->set_search($search);
		$this->set_start($start);
		$this->set_limit($limit);
		$this->set_orden_dir($ordenDir);
		$this->set_orden_column($ordenColumn);
		$this->set_condicion_aditional($coditions);

		return $this->pagination();
	}

	public function insumosInfo()
	{
		$coditions = [
			'condiciones' => ['id_insumo' => $this->getIdInsumo()],
			'conectores' => [''],
			'operadores' => ['=']
		];
		$this->set_tables(['insumo']);
		$this->set_colums(['id_insumo', 'imagen', 'nombre', 'descripcion', 'marca', 'medida', 'precio', 'stockMinimo', 'iva']);
		$this->set_condicion_aditional($coditions);
		return $this->read(false);
	}

	//metodo para taerme el insumo que su fecha de vencimiento esta mas cercana para mostrarlo en el modal de info
	public function retornarFechaDeVencimiento()
	{
		$this->set_tables(['entrada_insumo']);
		$this->set_colums(['fechaDeVencimiento']);
		return $this->read(false);
	}


	//cantidad insumos
	public function cantidadInsumos()
	{
		try {
			$sql = "SELECT i.id_insumo,SUM(ei.cantidad) AS cantidad_sumada FROM entrada e INNER JOIN entrada_insumo ei ON e.id_entrada = e.id_entrada INNER JOIN insumo i ON i.id_insumo = ei.id_insumo GROUP BY i.nombre HAVING i.id_insumo =:id_insumo";
			$query = $this->getPDO()->prepare($sql);
			$query->execute([
				'id_insumo' => $this->getIdInsumo(),
			]);

			return ($query->fetchAll(PDO::FETCH_ASSOC));
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function buscarInsumos()
	{
		$parametro = '%' . $this->getParametro() . '%';

		$coditions = [
			'condiciones' => ['nombre' => $parametro, 'estado' => 'ACT'],
			'conectores' => ['AND'],
			'operadores' => ['LIKE', '=']
		];
		$this->set_tables(['insumo']);
		$this->set_colums(['id_insumo', 'imagen', 'nombre', 'descripcion', 'marca', 'medida', 'precio', 'stockMinimo', 'iva']);
		$this->set_condicion_aditional($coditions);

		return $this->read();
	}


	//funcion mejorada de actualizacion de la cantidad
	// public function actualizar_cantidad_insumo()
	// {
	// 	try {
	// 		$sql = " SELECT ei.id_insumo, ei.fechaDeVencimiento, SUM(ei.cantidad_disponible) AS cantidad, e.numero_de_lote FROM entrada_insumo ei INNER JOIN entrada e on e.id_entrada = ei.id_entrada WHERE ei.id_insumo =:id_insumo AND ei.fechaDeVencimiento > CURRENT_DATE AND e.estado = 'ACT' ";
	// 		$this->setSQL($sql);
	// 		$consulta = $this->search(['id_insumo' => $this->getIdInsumo()], true);
	// 		return ($consulta) ? $consulta : false;
	// 	} catch (\Exception $e) {
	// 		return $e->getMessage();
	// 	}
	// }

	//
	public function papelera()
	{
		$coditions = [
			'condiciones' => ['i.estado ' => 'DES', 'inv.cantidad_disponible' => 0],
			'conectores' => ['AND'],
			'operadores' => ['=', '>=']
		];
		$this->set_tables(['insumo', 'entrada_insumo']);
		$this->set_colums(['i.id_insumo', 'i.imagen', 'i.nombre', 'i.descripcion', 'i.marca', 'i.medida', 'i.precio', 'i.stockMinimo', 'i.iva', 'inv.cantidad_disponible AS cantidad_inventario']);
		$this->set_alias(['i','inv']);
		$this->set_union(['i.id_insumo =  inv.id_insumo']);
		$this->set_condicion_aditional($coditions);
		return $this->read();
	}


	// ── PRIVADOS─────────────────────────────────────────
	//insertar insumo
	private function insertarInsumos()
	{
		// Bandera de control para evitar fallos de transacción en el catch
		$transaccionActiva = false;

		try {
			$this->beginTransaction();
			$transaccionActiva = true;

			$coditions1 = [
				'condiciones' => ['nombre' => $this->getNombre()],
				'conectores' => [],
				'operadores' => ['=']
			];

			$coditions2 = [
				'condiciones' => ['id_proveedor' => $this->getIdProveedor()],
				'conectores' => [],
				'operadores' => ['=']
			];

			$this->set_tables(['insumo']);
			$this->set_colums(['id_insumo']);
			$this->set_condicion_aditional($coditions1);
			$existeInsumo = $this->read(false,false,'',true);

			if ($existeInsumo) {
				throw new \Exception("Ya existe un insumo registrado con este nombre en el catálogo.");
			}

			//bloquear proveedor
			$this->set_tables(['proveedor']);
			$this->set_colums(['id_proveedor']);
			$this->set_condicion_aditional($coditions2);
			$this->read(false, false, '', true);

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

			$this->callStoredProdcedure('insert_insumo',$data,true,true);
			$this->commit();

			return [1];
		} catch (\Exception $e) {
			// Solo ejecutamos el rollback si la transacción realmente se abrió con éxito
			if ($transaccionActiva) {
				$this->rollBack();
			}
			return $e->getMessage();
		}
	}

	public function editar()
	{
		try {
			// Buscar datos actuales para obtener el nombre de la imagen vieja
			$coditions = [
				'condiciones' => ['id_insumo' => $this->getIdInsumo()],
				'conectores' => [],
				'operadores' => ['=']
			];
			$this->set_tables(['insumo']);
			$this->set_colums(['imagen']);
			$this->set_condicion_aditional($coditions);

			$datos = $this->read(false);

			if (empty($datos)) {
				throw new \Exception("Fallo: el id no existe");
			}

			$imagenNueva = $this->getImagen(); // El nombre generado en el controlador
			$imagenAntigua = $datos["imagen"];
			$imagen = '';

			if ($imagenNueva != null) {
				// SI HAY IMAGEN NUEVA: Borrar la vieja y actualizar campo
				$rutaImagenAntigua = "./src/assets/images/img_ingresadas_por_usuarios/insumos/" . $imagenAntigua;
				if (!empty($imagenAntigua) && file_exists($rutaImagenAntigua)) {
					unlink($rutaImagenAntigua);
				}
				$imagen = $imagenNueva;
			} else {
				$imagen = $imagenAntigua;
			}

			$data = [
				"imagen" => $imagen,
				"nombre" => $this->getNombre(),
				"descripcion" => $this->getDescripcion(),
				"stockMinimo" => $this->getStockMinimo(),
				"marca" => $this->getMarca(),
				"medida" => $this->getMedida()
			];
			$this->set_tables(['insumo']);
			$edicion = $this->actualizar($data,['id_insumo'=>$this->getIdInsumo()],$this->validator);

			return [$edicion];
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
		if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}(\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,})*$/", $nombre)) {
			throw new \InvalidArgumentException("El nombre debe iniciar con mayúscula, tener al menos 3 letras y puede incluir un segundo nombre separado por un espacio.");
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
}
