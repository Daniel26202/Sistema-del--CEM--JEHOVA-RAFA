<?php

namespace App\modelos;

use App\modelos\Db;
use App\modelos\ModeloInsumo;


class ModeloReporte extends Db
{

	private $conexion;
	private $modelo_insumo;

	public function __construct()
	{
		$this->conexion = $this->connectionSistema();
		$this->modelo_insumo = new ModeloInsumo;
	}

	public function consultarFactura()
	{
		try {
			$consulta = $this->conexion->prepare("SELECT f.*, p.nombre as nombre_p , p.apellido AS apellido_p, nacionalidad, p.cedula AS cedula_p FROM factura f INNER JOIN cliente p ON p.id_cliente = f.id_cliente  WHERE f.id_factura = f.id_factura AND f.estado='ACT' ORDER BY id_factura ASC ;");
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function consultarFacturaPDF($id_factura)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT cs.nombre AS categoria_servicio, d.nombre AS nombre_d, d.apellido AS apellido_d,e.nombre AS especialidad, p.nombre AS nombre_p, p.apellido AS apellido_p, p.nacionalidad, p.cedula AS cedula_p , f.*,c.*,sm.precio AS precio_servicio FROM factura f INNER JOIN cita c ON f.id_cita =c.id_cita  INNER JOIN paciente p ON c.id_paciente = p.id_paciente INNER JOIN serviciomedico sm ON c.id_servicioMedico = sm.id_servicioMedico INNER JOIN personal d ON sm.id_personal = d.id_personal INNER JOIN especialidad e ON d.id_especialidad = e.id_especialidad INNER JOIN usuario u ON d.id_usuario = u.id_usuario INNER JOIN categoria_servicio cs on cs.id_categoria = sm.id_categoria WHERE id_factura =:id_factura ");
			$consulta->bindParam(":id_factura", $id_factura);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}
	public function consultarReporteFactura($fechaInicio, $fechaFinal)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT f.*, p.nombre as nombre_p , p.apellido AS apellido_p, nacionalidad, p.cedula AS cedula_p FROM factura f INNER JOIN paciente p ON p.id_paciente = f.paciente_id_paciente  WHERE f.fecha BETWEEN :fechaInicio AND :fechaFinal AND f.id_factura = f.id_factura AND f.estado='ACT' ORDER BY id_factura ASC
");
			$consulta->bindParam(":fechaInicio", $fechaInicio);
			$consulta->bindParam(":fechaFinal", $fechaFinal);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}
	public function consultarReporteFacturaAnuladas($fechaInicioAnulada, $fechaFinalAnulada)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT f.*, p.nombre as nombre_p , p.apellido AS apellido_p, nacionalidad, p.cedula AS cedula_p FROM factura f INNER JOIN cliente p ON p.id_cliente = f.id_cliente  WHERE f.fecha BETWEEN :fechaInicioAnulada AND :fechaFinalAnulada AND f.id_factura = f.id_factura AND f.estado='Anulada' ORDER BY id_factura ASC
");
			$consulta->bindParam(":fechaInicioAnulada", $fechaInicioAnulada);
			$consulta->bindParam(":fechaFinalAnulada", $fechaFinalAnulada);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}
	public function consultarFacturaAnuladas()
	{
		try {
			$consulta = $this->conexion->prepare("SELECT f.*, p.nombre as nombre_p , p.apellido AS apellido_p, nacionalidad, p.cedula AS cedula_p FROM factura f INNER JOIN cliente p ON p.id_cliente = f.id_cliente  WHERE f.id_factura = f.id_factura AND f.estado='Anulada' ORDER BY id_factura ASC");

			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function Citaspdf($desdeFecha, $fechaHasta)
	{
		try {
			$consulta = $this->conexion->prepare(" SELECT p.nacionalidad, d.nombre AS nombre_d, d.apellido AS apellido_d,s.*, p.id_paciente, p.cedula AS cedula_p, p.nombre AS nombre_p, p.apellido AS apellido_p, p.telefono AS telefono_p, c.id_cita, c.fecha, c.hora, c.estado, e.nombre AS especialidad, e.id_especialidad FROM paciente p INNER JOIN cita c ON p.id_paciente = c.paciente_id_paciente INNER JOIN serviciomedico s ON s.id_servicioMedico = c.serviciomedico_id_servicioMedico INNER JOIN personal_has_serviciomedico ps ON s.id_servicioMedico =  ps.serviciomedico_id_servicioMedico INNER JOIN personal d ON ps.personal_id_personal = d.id_personal INNER JOIN especialidad e ON d.id_especialidad = e.id_especialidad INNER JOIN segurity.usuario u ON u.id_usuario = d.usuario WHERE c.fecha BETWEEN :desdeFecha AND :fechaHasta AND (c.estado = 'Pendiente' OR c.estado = 'Realizadas')");
			$consulta->bindParam(":desdeFecha", $desdeFecha);
			$consulta->bindParam(":fechaHasta", $fechaHasta);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}


	//consulta sql para mostrar el pdf parametrisado
	public function entradasInsumosPdf($id_insumo, $desdeFecha, $fechaHasta)
	{

		try {
			if ($desdeFecha != "" && $fechaHasta != "") {
				$sql = "SELECT p.nombre AS nombre_proveedor, p.rif, ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad_entrante AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE  e.estado = 'ACT' AND i.estado = 'ACT' AND e.fechaDeIngreso BETWEEN :desdeFecha AND :fechaHasta AND ei.id_insumo =:id_insumo AND ei.fechaDeVencimiento > CURRENT_DATE ORDER BY e.fechaDeIngreso";

				$consulta = $this->conexion->prepare($sql);
				$consulta->bindParam(":desdeFecha", $desdeFecha);
				$consulta->bindParam(":fechaHasta", $fechaHasta);
			} else {
				$sql = "SELECT p.nombre AS nombre_proveedor, p.rif, ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad_entrante AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE  e.estado = 'ACT' AND i.estado = 'ACT' AND ei.id_insumo =:id_insumo AND ei.fechaDeVencimiento > CURRENT_DATE ORDER BY e.fechaDeIngreso";
				$consulta = $this->conexion->prepare($sql);
			}


			$consulta->bindParam(":id_insumo", $id_insumo);

			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}




	public function pdfPaciente()
	{
		try {
			$consulta = $this->conexion->prepare("SELECT * FROM paciente WHERE estado = 'ACT'");
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}
	public function pdfInsumos()
	{
		try {
			$consulta = $this->conexion->prepare("SELECT *,inv.cantidad as cantidad_inventario  FROM inventario inv INNER JOIN insumo i ON i.id_insumo =  inv.id_insumo WHERE i.estado ='ACT' AND inv.cantidad >= 0  GROUP BY inv.id_insumo ");
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}
	public function consultarPagoFactura($id_factura)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT pf.* , p.nombre
    		FROM pago p INNER JOIN pagodefactura pf ON p.id_pago = pf.id_pago
    		INNER JOIN factura f ON pf.id_factura = f.id_factura WHERE f.id_factura =:id_factura");
			$consulta->bindParam(":id_factura", $id_factura);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function consultarServiciosExtras($id_factura)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT cs.nombre As categoria_servicio, sf.*,s.*,p.nombre AS nombre_d, p.apellido AS apellido_d FROM serviciomedico_has_factura sf INNER JOIN personal p  ON sf.doctor = p.id_personal INNER JOIN serviciomedico s ON s.id_servicioMedico = sf.serviciomedico_id_servicioMedico INNER JOIN categoria_servicio cs ON cs.id_categoria = s.id_categoria  WHERE factura_id_factura =:id_factura  ");
			$consulta->bindParam(":id_factura", $id_factura);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}
	public function consultarFacturaInsumo($id_factura)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT i.*,fi.*,f.*,ins.nombre, ins.precio FROM entrada_insumo i INNER JOIN factura_has_inventario fi ON i.id_entradaDeInsumo = fi.id_entradaDeInsumo INNER JOIN factura f  ON f.id_factura = fi.factura_id_factura INNER JOIN insumo ins ON ins.id_insumo = i.id_insumo  WHERE f.id_factura =:id_factura");
			$consulta->bindParam(":id_factura", $id_factura);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}
	public function consultarcitafactura($id_factura)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT cs.nombre AS categoria_servicio, d.nombre AS nombre_d, d.apellido AS apellido_d,e.nombre AS especialidad, p.nombre AS nombre_p, p.apellido AS apellido_p, p.nacionalidad, p.cedula AS cedula_p , f.*,c.*,sm.precio AS precio_servicio FROM factura f INNER JOIN cita c ON f.id_cita =c.id_cita  INNER JOIN paciente p ON c.id_paciente = p.id_paciente INNER JOIN serviciomedico sm ON c.id_servicioMedico = sm.id_servicioMedico INNER JOIN personal d ON sm.id_personal = d.id_personal INNER JOIN especialidad e ON d.id_especialidad = e.id_especialidad INNER JOIN usuario u ON d.id_usuario = u.id_usuario INNER JOIN categoria_servicio cs on cs.id_categoria = sm.id_categoria   WHERE id_factura =:id_factura ");
			$consulta->bindParam(":id_factura", $id_factura);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}
	public function anularFac($id_factura)
	{
		try {
			$consulta = $this->conexion->prepare("UPDATE factura SET estado = 'Anulada' WHERE id_factura = :id_factura");
			$consulta->bindParam(":id_factura", $id_factura);
			if ($consulta->execute()) {
				$consulta2 =  $this->conexion->prepare("CALL devolver_cantidad_insumos(:id_factura);");
				$consulta2->bindParam(":id_factura", $id_factura);
				$consulta2->execute();
			}
			return "exito";
		} catch (\Exception $e) {
			return 0;
		}
	}
	public function consultarFacturaSinCita($id_factura)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT p.nacionalidad, p.nombre AS  nombre_p,p.apellido AS apellido_p,p.cedula AS cedula_p,f.* FROM factura f INNER JOIN paciente p ON f.paciente_id_paciente = p.id_paciente WHERE f.id_factura =:id_factura");
			$consulta->bindParam(":id_factura", $id_factura);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}
	public function insumosAnulados($id_factura)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT i.id_insumo, i.numero_de_lote FROM inventario i INNER JOIN insumo ins ON ins.id_insumo = i.id_insumo INNER JOIN factura_has_inventario idf ON idf.inventario_id_inventario = i.id_inventario WHERE idf.factura_id_factura=:id_factura");
			$consulta->bindParam(":id_factura", $id_factura);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function cantidadAnulada($id_insumo, $id_factura, $numero_de_lote)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT inv.id_insumo,inv.numero_de_lote,inv.cantidad AS cantidadInsumo FROM inventario inv INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo WHERE inv.id_insumo =:id_insumo AND inv.numero_de_lote =:numero_de_lote");
			$consulta->bindParam(":id_insumo", $id_insumo);
			$consulta->bindParam(":numero_de_lote", $numero_de_lote);
			$consulta->execute();
			$x = $consulta->fetch();
			$cantidadInsumoPre = $x["cantidadInsumo"];
			// echo $cantidadInsumoPre."<br>";


			// echo $id_insumo;
			$consultaInsumosFacturados = $this->conexion->prepare("SELECT idf.cantidad AS total_cantidad_facturada FROM factura_has_inventario idf INNER JOIN inventario i ON i.id_inventario = idf.inventario_id_inventario INNER JOIN insumo ins ON ins.id_insumo = i.id_insumo WHERE ins.estado = 'ACT' AND i.id_insumo = :id_insumo AND idf.factura_id_factura =:id_factura AND i.numero_de_lote = :numero_de_lote");
			$consultaInsumosFacturados->bindParam(":id_insumo", $id_insumo);
			$consultaInsumosFacturados->bindParam(":id_factura", $id_factura);
			$consultaInsumosFacturados->bindParam(":numero_de_lote", $numero_de_lote);
			$consultaInsumosFacturados->execute();
			$facturados = $consultaInsumosFacturados->fetch();

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
			$consulta = $this->conexion->prepare("UPDATE entrada_insumo ei INNER JOIN entrada e ON e.id_entrada= ei.id_entrada SET ei.cantidad_disponible=:cantidad WHERE ei.id_insumo=:id_insumo AND e.numero_de_lote =:numero_de_lote");
			$consulta->bindParam(":cantidad", $cantidadInsumo);
			$consulta->bindParam(":id_insumo", $id_insumo);
			$consulta->bindParam(":numero_de_lote", $numero_de_lote);
			$consulta->execute();

			$cantidad_actualidad_insumo = $this->modelo_insumo->actualizar_cantidad_insumo($id_insumo);
			// print_r($cantidad[0]["cantidad"]);

			//esto es para actualizar la cantidad de insumos
			$consulta = $this->conexion->prepare("UPDATE insumo SET cantidad=:cantidad WHERE id_insumo=:id_insumo");
			$consulta->bindParam(":cantidad", $cantidad_actualidad_insumo[0]["cantidad"]);
			$consulta->bindParam(":id_insumo", $id_insumo);
			$consulta->execute();

			//actualizar tabla inventario segun el numero de lote y la cantidad comprada

			$consulta = $this->conexion->prepare("UPDATE inventario SET cantidad=:cantidad WHERE id_insumo=:id_insumo AND numero_de_lote =:numero_de_lote");
			$consulta->bindParam(":cantidad", $cantidadInsumo);
			$consulta->bindParam(":id_insumo", $id_insumo);
			$consulta->bindParam(":numero_de_lote", $numero_de_lote);
			$consulta->execute();
		} catch (\Exception $e) {
			return 0;
		}
	}
}
