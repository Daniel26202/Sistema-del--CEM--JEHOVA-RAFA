<?php

namespace App\models;

use App\models\interfaces\InterfaceConnection;
use App\models\interfaces\InterfaceValidator;
use App\models\TraitCreate;
use App\models\TraitUpdate;

class ModeloEntrada extends ModelBase
{

	private $fechaDeVencimiento, $fechaDeIngreso, $precio, $cantidadDisponible, $idEntrada, $cantidadEntrante, $lote;
	private $validator;
	use TraitCreate, TraitUpdate;

	public function __construct(InterfaceConnection $conn, ?InterfaceValidator $vali = null)
	{
		parent::__construct($conn);
		$this->set_tables(["entrada"]);
		$this->validator = $vali;
	}


	public function todasLasEntradas($estado = 'ACT', $start = 0, $limit = 10, $search = '', $ordenColumn = 'id_entrada', $ordenDir = 'DESC')
	{
		$coditions = [
			'condiciones' => ['e.estado' => $estado],
			'conectores' => [],
			'operadores' => ['=']
		];
		$alias =[
			'e',
			'p',
			'ei',
			'i'
		];
		$unions =[
			'p.id_proveedor = e.id_proveedor ',
			'ei.id_entrada = e.id_entrada',
			'i.id_insumo = ei.id_insumo'
		];
		$this->set_tables(["entrada","proveedor",'entrada_insumo','insumo']);
		$this->set_colums(['i.nombre','p.nombre AS proveedor','e.fechaDeIngreso','ei.fechaDeVencimiento', 'ei.cantidad_entrante AS cantidad_entrada', 'ei.precio AS precio_entrada','e.numero_de_lote']);

		$this->set_search($search);
		$this->set_start($start);
		$this->set_limit($limit);
		$this->set_orden_dir($ordenDir);
		$this->set_orden_column($ordenColumn);
		$this->set_condicion_aditional($coditions);
		$this->set_union($unions);
		$this->set_alias($alias);

		return $this->pagination();
	}



	// ── PRIVADOS─────────────────────────────────────────

	public function insertarEntrada()
	{
		try {
			$this->beginTransaction();

			$data = [
				'id_insumo' => $this->getIdInsumo(),
				'id_proveedor' => $this->getIdProveedor(),
				'fechaDeIngreso' => $this->getFechaDeIngreso(),
				'fechaDeVencimiento' => $this->getFechaDeVencimiento(),
				'precio' => $this->getPrecio(),
				'cantidad_disponible' => $this->getCantidadDisponible(),
				'lote' => $this->getLote(),
			];

			$this->callStoredProdcedure('insert_entrada', $data, false, true);
			$this->commit();
			return [1];
		} catch (\Exception $e) {
			$this->rollBack();
			return $e->getMessage();
		}
	}



	public function actualizarEntrada()
	{
		try {
			$this->beginTransaction();
			$coditions = [
				'condiciones' => ['id_entrada' => $this->getIdEntrada()],
				'conectores' => [],
				'operadores' => ['=']
			];
			$this->set_tables(["entrada"]);
			$this->set_colums(['id_entrada']);
			$this->set_condicion_aditional($coditions);
			$listData = $this->read(false);

			if (empty($listData)) {
				throw new \Exception("Fallo el id entrada no existe");
			}

			$data =[
				'fechaDeVencimiento'=>$this->getFechaDeVencimiento(),
				'precio'=>$this->getPrecio(),
				'cantidad'=>$this->getCantidadEntrante()
			];
			$this->set_tables(['entrada_insumo']);
			$this->actualizar($data, ['id_entrada'=>$this->getIdEntrada()],$this->validator);

			$this->set_tables(['entrada']);
			$this->actualizar(['numero_de_lote'=>$this->getLote()], ['id_entrada' => $this->getIdEntrada()], $this->validator);

			$this->commit();
			return [1];
		} catch (\Exception $e) {
			$this->rollBack();
			return $e->getMessage();
		}
	}


	public function get_all()
	{
		return [
			'fechaDeVencimiento' => $this->getFechaDeVencimiento(),
			'fechaDeIngreso' => $this->getFechaDeIngreso(),
			'precio' => $this->getPrecio(),
			'cantidadDisponible' => $this->getCantidadDisponible(),
			'id_entrada' => $this->getIdEntrada(),
			'cantidadEntrante' => $this->getCantidadEntrante(),
			'lote' => $this->getLote(),
			'estado' => 'ACT'
		];
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
	public function getLote()
	{
		return $this->lote;
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
}
