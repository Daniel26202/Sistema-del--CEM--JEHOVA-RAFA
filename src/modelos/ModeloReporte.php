<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\modelos\ModeloFactura;
use App\modelos\ModeloInsumo;


class ModeloReporte extends ModelBase
{


	private $fechaInicio, $fechaFinal, $numeroDeLote;

	public function __construct($dbSystem = true)
	{
		parent::__construct($dbSystem);
	}

	private function returnObjectModel()
	{
		return [
			'modeloFactura' => new ModeloFactura(),
			'modeloInsumo' => new ModeloInsumo()
		];
	}

	public function consultarFactura()
	{
		try {
			$sql = "SELECT f.*, p.nombre as nombre_p , p.apellido AS apellido_p, nacionalidad, p.cedula AS cedula_p FROM factura f INNER JOIN cliente p ON p.id_cliente = f.id_cliente  WHERE f.id_factura = f.id_factura AND f.estado='ACT' ORDER BY id_factura ASC ;";
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function consultarFacturaPDF()
	{
		try {
			$data = ['id_factura' => $this->returnObjectModel()['modeloFactura']->getIdFactura()];
			$sql = "SELECT cs.nombre AS categoria_servicio, d.nombre AS nombre_d, d.apellido AS apellido_d,e.nombre AS especialidad, p.nombre AS nombre_p, p.apellido AS apellido_p, p.nacionalidad, p.cedula AS cedula_p , f.*,c.*,sm.precio AS precio_servicio FROM factura f INNER JOIN cita c ON f.id_cita =c.id_cita  INNER JOIN paciente p ON c.id_paciente = p.id_paciente INNER JOIN serviciomedico sm ON c.id_servicioMedico = sm.id_servicioMedico INNER JOIN personal d ON sm.id_personal = d.id_personal INNER JOIN especialidad e ON d.id_especialidad = e.id_especialidad INNER JOIN usuario u ON d.id_usuario = u.id_usuario INNER JOIN categoria_servicio cs on cs.id_categoria = sm.id_categoria WHERE id_factura =:id_factura";
			$this->setSQL($sql);
			return $this->search($data, false);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function consultarReporteFactura()
	{

		try {
			$data = [
				'fechaInicio' => $this->getFechaInicio(),
				'fechaFinal' => $this->getFechaFinal()

			];
			$sql = "SELECT f.*, p.nombre as nombre_p , p.apellido AS apellido_p, nacionalidad, p.cedula AS cedula_p FROM factura f INNER JOIN paciente p ON p.id_paciente = f.paciente_id_paciente  WHERE f.fecha BETWEEN :fechaInicio AND :fechaFinal AND f.id_factura = f.id_factura AND f.estado='ACT' ORDER BY id_factura ASC";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function consultarReporteFacturaAnuladas()
	{
		try {
			$data = [
				'fechaInicio' => $this->getFechaInicio(),
				'fechaFinal' => $this->getFechaFinal(),
				'estado' => 'Anulada'
			];

			$sql = "SELECT f.*, p.nombre as nombre_p , p.apellido AS apellido_p, nacionalidad, p.cedula AS cedula_p FROM factura f INNER JOIN cliente p ON p.id_cliente = f.id_cliente  WHERE f.fecha BETWEEN :fechaInicio AND :fechaFinal AND f.id_factura = f.id_factura AND f.estado=:estado ORDER BY id_factura ASC";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function consultarFacturaAnuladas()
	{
		try {
			$sql = "SELECT f.*, p.nombre as nombre_p , p.apellido AS apellido_p, nacionalidad, p.cedula AS cedula_p FROM factura f INNER JOIN cliente p ON p.id_cliente = f.id_cliente  WHERE f.id_factura = f.id_factura AND f.estado='Anulada' ORDER BY id_factura ASC";
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function Citaspdf()
	{
		try {
			$data = [
				'fechaInicio' => $this->getFechaInicio(),
				'fechaFinal' => $this->getFechaFinal(),
				'estado' => 'Anulada'
			];

			$sql = "SELECT p.nacionalidad, d.nombre AS nombre_d, d.apellido AS apellido_d,s.*, p.id_paciente, p.cedula AS cedula_p, p.nombre AS nombre_p, p.apellido AS apellido_p, p.telefono AS telefono_p, c.id_cita, c.fecha, c.hora, c.estado, e.nombre AS especialidad, e.id_especialidad FROM paciente p INNER JOIN cita c ON p.id_paciente = c.paciente_id_paciente INNER JOIN serviciomedico s ON s.id_servicioMedico = c.serviciomedico_id_servicioMedico INNER JOIN personal_has_serviciomedico ps ON s.id_servicioMedico =  ps.serviciomedico_id_servicioMedico INNER JOIN personal d ON ps.personal_id_personal = d.id_personal INNER JOIN especialidad e ON d.id_especialidad = e.id_especialidad INNER JOIN segurity.usuario u ON u.id_usuario = d.usuario WHERE c.fecha BETWEEN :fechaInicio AND :fechaFinal AND (c.estado = 'Pendiente' OR c.estado = 'Realizadas')";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	//consulta sql para mostrar el pdf parametrisado
	public function entradasInsumosPdf($id_insumo, $desdeFecha, $fechaHasta)
	{

		try {
			if ($this->getFechaInicio() != "" && $this->getFechaFinal() != "") {
				$data = [
					'fechaInicio' => $this->getFechaInicio(),
					'fechaFinal' => $this->getFechaFinal(),
					'id_insumo' => $this->returnObjectModel()['modeloInsumo']->getIdInsumo()
				];

				$sql = "SELECT p.nombre AS nombre_proveedor, p.rif, ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad_entrante AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE  e.estado = 'ACT' AND i.estado = 'ACT' AND e.fechaDeIngreso BETWEEN :fechaInicio AND :fechaFinal AND ei.id_insumo =:id_insumo AND ei.fechaDeVencimiento > CURRENT_DATE ORDER BY e.fechaDeIngreso";

				$this->setSQL($sql);
				return $this->search($data);
			} else {
				$data = [
					'id_insumo' => $this->returnObjectModel()['modeloInsumo']->getIdInsumo()
				];
				$sql = "SELECT p.nombre AS nombre_proveedor, p.rif, ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad_entrante AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE  e.estado = 'ACT' AND i.estado = 'ACT' AND ei.id_insumo =:id_insumo AND ei.fechaDeVencimiento > CURRENT_DATE ORDER BY e.fechaDeIngreso";
				$this->setSQL($sql);
				return $this->search($data);
			}
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}




	public function pdfPaciente()
	{
		try {
			$sql = "SELECT * FROM paciente WHERE estado = 'ACT'";
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function pdfInsumos()
	{
		try {
			$sql = "SELECT *,inv.cantidad as cantidad_inventario  FROM inventario inv INNER JOIN insumo i ON i.id_insumo =  inv.id_insumo WHERE i.estado ='ACT' AND inv.cantidad >= 0  GROUP BY inv.id_insumo ";
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function consultarPagoFactura()
	{
		try {
			$data = [
				'id_factura' => $this->returnObjectModel()['modeloFactura']->getIdFactura()
			];
			$sql = "SELECT pf.* , p.nombre
    		FROM pago p INNER JOIN pagodefactura pf ON p.id_pago = pf.id_pago
    		INNER JOIN factura f ON pf.id_factura = f.id_factura WHERE f.id_factura =:id_factura";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function consultarServiciosExtras()
	{
		try {
			$data = [
				'id_factura' => $this->returnObjectModel()['modeloFactura']->getIdFactura()
			];
			$sql = "SELECT cs.nombre As categoria_servicio, sf.*,s.*,p.nombre AS nombre_d, p.apellido AS apellido_d FROM serviciomedico_has_factura sf INNER JOIN personal p  ON sf.doctor = p.id_personal INNER JOIN serviciomedico s ON s.id_servicioMedico = sf.serviciomedico_id_servicioMedico INNER JOIN categoria_servicio cs ON cs.id_categoria = s.id_categoria  WHERE factura_id_factura =:id_factura ";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function consultarFacturaInsumo()
	{
		try {
			$data = [
				'id_factura' => $this->returnObjectModel()['modeloFactura']->getIdFactura()
			];
			$sql = "SELECT i.*,fi.*,f.*,ins.nombre, ins.precio FROM entrada_insumo i INNER JOIN factura_has_inventario fi ON i.id_entradaDeInsumo = fi.id_entradaDeInsumo INNER JOIN factura f  ON f.id_factura = fi.factura_id_factura INNER JOIN insumo ins ON ins.id_insumo = i.id_insumo  WHERE f.id_factura =:id_factura";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function consultarcitafactura()
	{
		try {
			$data = [
				'id_factura' => $this->returnObjectModel()['modeloFactura']->getIdFactura()
			];
			$sql = "SELECT cs.nombre AS categoria_servicio, d.nombre AS nombre_d, d.apellido AS apellido_d,e.nombre AS especialidad, p.nombre AS nombre_p, p.apellido AS apellido_p, p.nacionalidad, p.cedula AS cedula_p , f.*,c.*,sm.precio AS precio_servicio FROM factura f INNER JOIN cita c ON f.id_cita =c.id_cita  INNER JOIN paciente p ON c.id_paciente = p.id_paciente INNER JOIN serviciomedico sm ON c.id_servicioMedico = sm.id_servicioMedico INNER JOIN personal d ON sm.id_personal = d.id_personal INNER JOIN especialidad e ON d.id_especialidad = e.id_especialidad INNER JOIN usuario u ON d.id_usuario = u.id_usuario INNER JOIN categoria_servicio cs on cs.id_categoria = sm.id_categoria   WHERE id_factura =:id_factura  ";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function anularFac()
	{
		try {
			$data = [
				'id_factura' => $this->returnObjectModel()['modeloFactura']->getIdFactura()
			];
			$sql = "UPDATE factura SET estado = 'Anulada' WHERE id_factura = :id";
			$this->setSQL($sql);
			$this->update_logic($data['id_factura']);
			// Nota hay que revisar esto
			// if ($consulta->execute()) {
			// 	$consulta2 =  $this->conexion->prepare("CALL devolver_cantidad_insumos(:id_factura);");
			// 	$consulta2->bindParam(":id_factura", $id_factura);
			// 	$consulta2->execute();
			// }
			return ['exito'];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function consultarFacturaSinCita()
	{
		try {
			$data = [
				'id_factura' => $this->returnObjectModel()['modeloFactura']->getIdFactura()
			];
			$sql = "SELECT p.nacionalidad, p.nombre AS  nombre_p,p.apellido AS apellido_p,p.cedula AS cedula_p,f.* FROM factura f INNER JOIN paciente p ON f.paciente_id_paciente = p.id_paciente WHERE f.id_factura =:id_factura ";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function insumosAnulados()
	{
		try {
			$data = [
				'id_factura' => $this->returnObjectModel()['modeloFactura']->getIdFactura()
			];
			$sql = "SELECT i.id_insumo, i.numero_de_lote FROM inventario i INNER JOIN insumo ins ON ins.id_insumo = i.id_insumo INNER JOIN factura_has_inventario idf ON idf.inventario_id_inventario = i.id_inventario WHERE idf.factura_id_factura=:id_factura";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function cantidadAnulada($id_insumo, $id_factura, $numero_de_lote)
	{
		try {
			$sql = "SELECT inv.id_insumo,inv.numero_de_lote,inv.cantidad AS cantidadInsumo FROM inventario inv INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo WHERE inv.id_insumo =:id_insumo AND inv.numero_de_lote =:numero_de_lote";
			$this->setSQL($sql);
			$data = [
				'id_insumo' => $this->returnObjectModel()['modeloInsumo']->getIdInsumo(),
				'numero_de_lote' => $this->getNumeroDeLote()
			];
			$x = $this->search($data, false);
			$cantidadInsumoPre = $x["cantidadInsumo"];

			// echo $cantidadInsumoPre."<br>";


			// echo $id_insumo;
			$sql = "SELECT idf.cantidad AS total_cantidad_facturada FROM factura_has_inventario idf INNER JOIN inventario i ON i.id_inventario = idf.inventario_id_inventario INNER JOIN insumo ins ON ins.id_insumo = i.id_insumo WHERE ins.estado = 'ACT' AND i.id_insumo = :id_insumo AND idf.factura_id_factura =:id_factura AND i.numero_de_lote = :numero_de_lote";
			$this->setSQL($sql);
			$data = [
				'id_insumo' => $this->returnObjectModel()['modeloInsumo']->getIdInsumo(),
				'id_factura' => $this->returnObjectModel()['modeloFactura']->getIdFactura(),
				'numero_de_lote' => $this->getNumeroDeLote()
			];
			$facturados = $this->search($data, false);

			$totalFacturado = $facturados["total_cantidad_facturada"];

			//esto es para restar los insumos que ya fueron facturados

			$cantidadInsumo = $cantidadInsumoPre + $totalFacturado;

			echo "<br>" . "Pre: " . $cantidadInsumoPre . "<br>";
			echo "Factrado: " . $totalFacturado . "<br>";
			echo "Ttosl: " . $cantidadInsumo;



			// $consulta = $this->conexion->prepare("UPDATE insumo SET cantidad =:cantidadInsumo WHERE id_insumo =:id_insumo");
			// $consulta->bindParam(":id_insumo", $id_insumo);
			// $consulta->bindParam(":cantidadInsumo", $cantidadInsumo);
			// $consulta->execute();


			//actualiza Cantidades
			$sql = "UPDATE entrada_insumo ei INNER JOIN entrada e ON e.id_entrada= ei.id_entrada SET ei.cantidad_disponible=:cantidad WHERE ei.id_insumo=:id AND e.numero_de_lote =:numero_de_lote";
			$this->setSQL($sql);
			$data = [
				'cantidad' => $cantidadInsumo,
				'numero_de_lote' => $this->getNumeroDeLote()
			];
			$this->update($data, $this->returnObjectModel()['modeloInsumo']->getIdInsumo());

			$cantidad_actualidad_insumo = $this->returnObjectModel()['modeloInsumo']->actualizar_cantidad_insumo();
			// print_r($cantidad[0]["cantidad"]);

			//esto es para actualizar la cantidad de insumos
			$sql = "UPDATE insumo SET cantidad=:cantidad WHERE id_insumo=:id_insumo";
			$this->setSQL($sql);
			$this->update([$cantidad_actualidad_insumo[0]["cantidad"]], $this->returnObjectModel()['modeloInsumo']->getIdInsumo());

			//actualizar tabla inventario segun el numero de lote y la cantidad comprada

			$sql = "UPDATE inventario SET cantidad=:cantidad WHERE id_insumo=:id_insumo AND numero_de_lote =:numero_de_lote";
			$this->setSQL($sql);
			$data = [
				'cantidad' => $cantidadInsumo,
				'numero_de_lote' => $this->getNumeroDeLote()
			];
			$this->update($data, $this->returnObjectModel()['modeloInsumo']->getIdInsumo());
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function getFechaInicio()
	{
		return $this->fechaInicio;
	}

	public function getFechaFinal()
	{
		return $this->fechaFinal;
	}

	public function getNumeroDeLote()
	{
		return $this->numeroDeLote;
	}

	public function setNumeroDeLote($numeroDeLote)
	{
		if (!preg_match("/^[0-9]+$/", $numeroDeLote)) {
			throw new \InvalidArgumentException("El número de lote debe ser un número entero positivo.");
		}

		if ((int)$numeroDeLote <= 0) {
			throw new \InvalidArgumentException("El número de lote debe ser mayor que cero.");
		}

		$this->numeroDeLote = (int)$numeroDeLote;
	}

	public function setFechaInicio($fechaInicio)
	{
		$dt = \DateTime::createFromFormat('Y-m-d', $fechaInicio);
		$fechaHoy = date("Y-m-d");

		if (!$dt || $dt->format('Y-m-d') !== $fechaInicio) {
			throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
		}
		if ($fechaInicio >= $fechaHoy) {
			throw new \InvalidArgumentException("La fecha no puede ser del futuro.");
		}
		if ($fechaInicio >= $this->getFechaFinal()) {
			throw new \InvalidArgumentException("La fecha de inicio no puede ser mayor o igual a la fecha final.");
		}
		$this->fechaInicio = $fechaInicio;
	}

	public function setFinal($fechaFinal)
	{
		$dt = \DateTime::createFromFormat('Y-m-d', $fechaFinal);
		$fechaHoy = date("Y-m-d");

		if (!$dt || $dt->format('Y-m-d') !== $fechaFinal) {
			throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
		}
		if ($fechaFinal >= $fechaHoy) {
			throw new \InvalidArgumentException("La fecha no puede ser del futuro.");
		}
		if ($fechaFinal <= $this->getFechaInicio()) {
			throw new \InvalidArgumentException("La fecha final no puede ser menor o igual a la fecha de inicio.");
		}
		$this->fechaFinal = $fechaFinal;
	}
}
