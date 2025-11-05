<?php

namespace App\modelos;

use App\modelos\Db;
use App\modelos\ModeloInsumo;
use App\modelos\ModeloCliente;

class ModeloFactura extends Db
{

	private $conexion;
	private $modelo_insumo;
	private $modelo_cliente;

	public function __construct()
	{
		$this->conexion = $this->connectionSistema();
		$this->modelo_insumo = new ModeloInsumo;
		$this->modelo_cliente = new ModeloCliente;
	}
	//buscar Paciente tambien por la cita
	public function buscarPacientePorCita($cedula)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT d.nombre AS nombre_d,d.apellido AS apellido_d,sm.*,p.id_paciente, p.cedula AS cedula_p,p.nombre AS nombre_p, p.apellido AS apellido_p, p.telefono AS telefono_p ,c.id_cita,c.fecha, c.estado,e.nombre AS especialidad FROM paciente p INNER JOIN cita c ON p.id_paciente = c.paciente_id_paciente INNER JOIN serviciomedico s ON s.id_servicioMedico = c.serviciomedico_id_servicioMedico INNER JOIN personal_has_serviciomedico ps ON ps.serviciomedico_id_servicioMedico = s.id_servicioMedico INNER JOIN  personal d ON d.id_personal= ps.personal_id_personal INNER JOIN segurity.usuario u ON u.id_usuario = d.usuario INNER JOIN serviciomedico sm ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN especialidad e ON e.id_especialidad = d.id_especialidad   WHERE p.cedula =:cedula AND u.estado = 'ACT' AND c.fecha =CURRENT_DATE AND c.estado= 'Pendiente' limit 1 ");
			$consulta->bindParam(":cedula", $cedula);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}




	public function mostrarCitaFactura($id_cita)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT c.doctor,d.nombre AS nombre_d,d.apellido AS apellido_d,s.*,p.id_paciente,p.nacionalidad, p.cedula AS cedula_p,p.nombre AS nombre_p, p.apellido AS apellido_p, p.telefono AS telefono_p ,c.id_cita,c.fecha, c.estado,e.nombre AS especialidad FROM paciente p INNER JOIN cita c ON p.id_paciente = c.paciente_id_paciente INNER JOIN serviciomedico s ON s.id_servicioMedico  = c.serviciomedico_id_servicioMedico INNER JOIN personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = s.id_servicioMedico INNER JOIN personal d ON psm.personal_id_personal = d.id_personal INNER JOIN especialidad e ON d.id_especialidad = e.id_especialidad INNER JOIN segurity.usuario u ON u.id_usuario = d.usuario WHERE c.id_cita =:id_cita AND u.estado = 'ACT' limit 1 ");
			$consulta->bindParam(":id_cita", $id_cita);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function mostrarHospitalizacion($id_hospitalizacion)
	{

		try {
			$consulta = $this->conexion->prepare('SELECT h.id_hospitalizacion, h.fecha_hora_inicio, h.precio_horas, h.fecha_hora_final, h.total, pac.id_paciente, pac.nacionalidad, pac.cedula, pac.nombre, pac.apellido,  pe.nombre AS nombredoc, pe.apellido AS apellidodoc 
			FROM  hospitalizacion h INNER JOIN paciente pac ON pac.id_paciente = h.id_paciente INNER JOIN personal pe ON pe.id_personal = h.personal_id_personal  WHERE  h.id_hospitalizacion =:id_hospitalizacion GROUP BY h.id_hospitalizacion');
			$consulta->bindParam(":id_hospitalizacion", $id_hospitalizacion);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function serviciosIncluidosHospit($id_hospitalizacion)
	{

		try {
			$consulta = $this->conexion->prepare('SELECT * FROM hospitalizacion h INNER JOIN servicios_hospitalizacion sh ON sh.id_hospitalizacion = h.id_hospitalizacion INNER JOIN serviciomedico s ON s.id_servicioMedico = sh.id_servicioMedico INNER JOIN categoria_servicio cs ON cs.id_categoria = s.id_categoria WHERE  h.id_hospitalizacion =:id_hospitalizacion GROUP BY h.id_hospitalizacion');
			$consulta->bindParam(":id_hospitalizacion", $id_hospitalizacion);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function unirInsumosHospitalizacion($id_hospitalizacion)
	{
		try {
			$consulta = $this->conexion->prepare('SELECT  * FROM hospitalizacion h INNER JOIN insumodehospitalizacion ih ON h.id_hospitalizacion = ih.id_hospitalizacion INNER JOIN entrada_insumo ei ON ei.id_entradaDeInsumo = ih.id_entradaDeInsumo INNER JOIN insumo i ON i.id_insumo = ei.id_insumo   WHERE   i.estado = "ACT" AND h.estado = "Pendiente" AND h.id_hospitalizacion =:id_hospitalizacion ');
			$consulta->bindParam(":id_hospitalizacion", $id_hospitalizacion);
			$consulta->execute();
			return $consulta->fetchAll();
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function buscar($cedula)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT * FROM paciente WHERE cedula =:cedula AND estado = 'ACT' ");
			$consulta->bindParam(":cedula", $cedula);
			$consulta->execute();
			return ($consulta->execute()) ? $consulta->fetch() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function buscarCliente($cedula)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT * FROM cliente where cedula =:cedula");
			$consulta->bindParam(":cedula", $cedula);
			$consulta->execute();
			return ($consulta->execute()) ? $consulta->fetch() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function mostrarServicios()
	{
		try {
			$consulta = $this->conexion->prepare("SELECT cs.id_categoria,cs.nombre, d.nombre AS nombre_d, d.apellido AS apellido_d,sm.*,d.*  FROM bd.categoria_servicio cs JOIN bd.serviciomedico sm ON sm.id_categoria = cs.id_categoria JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico JOIN bd.personal d ON psm.personal_id_personal = d.id_personal JOIN segurity.usuario u ON  u.id_usuario = d.usuario WHERE sm.estado = 'ACT' AND cs.nombre != 'Consulta' AND tipo != 'Cita' ");
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	//buscar servicios
	public function buscarServicio($nombre)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT cs.id_categoria,cs.nombre, d.nombre AS nombre_d, d.apellido AS apellido_d,sm.*,d.* FROM serviciomedico sm INNER JOIN personal_has_serviciomedico psm ON sm.id_servicioMedico =psm.serviciomedico_id_servicioMedico INNER JOIN
			personal d ON d.id_personal = psm.serviciomedico_id_servicioMedico INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria INNER JOIN usuario u ON u.id_usuario = d.id_usuarioWHERE cs.nombre = 'Adicional' AND sm.estado = 'ACT' AND nombre =:nombre ");
			$busqueda = "%$nombre%";
			$consulta->bindParam(":nombre", $busqueda);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function mostrarDoctores($id_servicioExtra)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT sm.*, d.*, d.nombre as nombre_d FROM serviciomedico sm INNER JOIN personal d on d.id_personal = sm.id_personal INNER JOIN usuario u ON u.id_usuario = d.id_usuario WHERE sm.id_servicioMedico=:id_servicioExtra AND sm.estado = 'ACT' ");
			$consulta->bindParam(":id_servicioExtra", $id_servicioExtra);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}
	//desde aqui empizo a acomodar las consultas SQL 
	public function mostrarPrecioDoctores($id_doctor, $id_servicioExtra)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT sm.*, d.*, u.nombre as nombre_d, u.apellido FROM servicioextra sm INNER JOIN doctor d on d.id_doctor = sm.id_doctor INNER JOIN usuario u ON u.id_usuario = d.id_usuario WHERE d.id_doctor = :id_doctor AND sm.id_servicioExtra =:id_servicioExtra");

			$consulta->bindParam(":id_doctor", $id_doctor);
			$consulta->bindParam(":id_servicioExtra", $id_servicioExtra);

			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function mostrarNombreDoctores($id_doctor)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT d.nombre,d.id_usuario,u.id_usuario FROM usuario u INNER JOIN personal d 
    		on d.id_usuario = u.id_usuario WHERE d.id_personal =:id_doctor ");
			$consulta->bindParam(":id_doctor", $id_doctor);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}


	public function seleccionarIdConsulta($nombre, $nombreD)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT sm.*, d.nombre AS nombre_doctor, e.nombre AS especialidad FROM personal d JOIN
    		serviciomedico sm ON d.id_personal = sm.id_personal JOIN
    		usuario u ON d.id_usuario = u.id_usuario JOIN 
    		especialidad e ON d.id_especialidad = e.id_especialidad
    		WHERE e.nombre = :nombre AND d.nombre =:nombreD ");
			$consulta->bindParam(":nombre", $nombre);
			$consulta->bindParam(":nombreD", $nombreD);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function seleccionarIdDoctor($nombre)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT d.id_doctor,u.nombre,d.id_usuario,u.id_usuario FROM usuario u INNER JOIN personal d 
    		on d.id_usuario = u.id_usuario WHERE d.nombre =:nombre");
			$consulta->bindParam(":nombre", $nombre);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	//insumos 
	public function mostrarInsumos($id_insumo = "")
	{
		try {
			if ($id_insumo == "") {
				$consulta = $this->conexion->prepare(" SELECT i.*,i.cantidad AS cantidad_inventario, i.numero_de_lote, ins.* FROM insumo ins INNER JOIN inventario i ON i.id_insumo = ins.id_insumo WHERE ins.estado = 'ACT' AND i.cantidad > 0 ORDER BY ins.nombre ASC ");
			} else {
				$consulta = $this->conexion->prepare("SELECT * FROM insumo WHERE id_insumo=:id_insumo AND estado = 'ACT'  AND cantidad > 0  ");
				$consulta->bindParam(":id_insumo", $id_insumo);
			}
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function selectTodosLosInsumos()
	{
		return $this->modelo_insumo->insumos(false);
	}

	//metodo para mostra los tipos de pagos registrados en la base de Datos
	public function mostrarTiposDePagos()
	{
		try {
			$consulta = $this->conexion->prepare("SELECT * FROM pago");
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}



	public  function selectId_entrada($id_insumo)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT ei.id_entradaDeInsumo FROM entrada_insumo ei INNER JOIN entrada e ON e.id_entrada= ei.id_entrada WHERE ei.id_insumo =:id_insumo AND ei.cantidad_disponible > 0 ORDER BY e.fechaDeIngreso  LIMIT 1");
			$consulta->bindParam(":id_insumo", $id_insumo);
			$consulta->execute();
			$datos = $consulta->fetch();
			$id_entrada = $datos["id_entradaDeInsumo"];
			return $id_entrada;
		} catch (\Exception $e) {
			return 0;
		}
	}


	public function insertaFactura($fecha, $total, $formasDePago, $serviciosExtras, $id_cliente, $insumos, $cantidad, $montosDePago, $referencia, $id_cita, $id_hospitalizacion, $doctor, $precioInsumo, $precioServicio)
	{

		try {


			//insertar factura
			$consulta = $this->conexion->prepare("INSERT INTO factura VALUES (null, :fecha, :total, 'ACT', :id_cliente)");

			$consulta->bindParam(":fecha", $fecha);
			$consulta->bindParam(":total", $total);
			$consulta->bindParam(":id_cliente", $id_cliente);
			$consulta->execute();
			$id_factura = $this->conexion->lastInsertId();

			//Si el id_cita no es null se cambia el estado e la cita
			if ($id_cita != null) {
				$consulta = $this->conexion->prepare("UPDATE cita SET estado = 'Realizadas' WHERE id_cita =:id_cita");
				$consulta->bindParam(":id_cita", $id_cita);
				$consulta->execute();
			}

			//Si el id_hospitalizacion no es null se cambia el estado e la cita
			if ($id_hospitalizacion != null) {
				$consulta = $this->conexion->prepare("UPDATE hospitalizacion SET estado = 'Realizada' WHERE id_hospitalizacion =:id_hospitalizacion");
				$consulta->bindParam(":id_hospitalizacion", $id_hospitalizacion);
				$consulta->execute();

				//insertar en el dealle de factura  la hospitalizacion
				$consulta = $this->conexion->prepare("INSERT INTO detalle_factura  VALUES (null,:id_factura, 'Hospitalizacion', 1,:precioServicio, :precioServicio,:id_hospitalizacion,null,null)");
				$consulta->bindParam(":id_factura", $id_factura);
				$consulta->bindParam(":total", $precioServicio);
				$consulta->bindParam(":id_hospitalizacion", $id_hospitalizacion);
				if ($consulta->execute()) {
				} else {
					echo "NO";
				}

				// consulta datos del ultimo contro del paciente hospitalizado
				$consulta = $this->conexion->prepare("SELECT con.id_control, con.id_paciente, con.historiaclinica FROM control con INNER JOIN hospitalizacion h ON h.id_paciente = con.id_paciente WHERE h.id_hospitalizacion = :idHosp ORDER by con.id_control DESC LIMIT 1;");
				$consulta->bindParam(":idHosp", $id_hospitalizacion);
				$datosControl = ($consulta->execute()) ? $consulta->fetch() : false;

				$historialEnF = $datosControl["historiaclinica"];

				$consulta = $this->conexion->prepare("SELECT cs.nombre AS servicio, sh.cantidad, sm.tipo FROM servicios_hospitalizacion sh INNER JOIN serviciomedico sm ON sm.id_servicioMedico = sh.id_servicioMedico INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE sh.id_hospitalizacion = :id_hospitalizacion;");
				$consulta->bindParam(":id_hospitalizacion", $id_hospitalizacion);
				$consulta->execute();
				$servicios = ($consulta->execute()) ? $consulta->fetchAll() : false;

				if ($servicios) {
					$textoServicios = "Servicios utilizados: ";
					$lista = [];
					foreach ($servicios as $serv) {
						// para convertir el text en minuscula
						if (strtolower($serv["tipo"]) === "examenes") {
							$lista[] = "{$serv["servicio"]} ({$serv["cantidad"]} unidades)";
						} else {
							$lista[] = $serv["servicio"];
						}
					}

					$textoServicios .= implode(", ", $lista) . ".";

					$historialEnF = $textoServicios . "   El paciente: " . $historialEnF;
				}

				$consulta = $this->conexion->prepare('UPDATE control SET historiaclinica = :historial, estado = "ACT" WHERE id_control = :id_control;');
				$consulta->bindParam(":historial", $historialEnF);
				$consulta->bindParam(":id_control", $datosControl["id_control"]);
				$consulta->execute();
			}

			$arrayDePago = $formasDePago;
			//insertar tipos de pago
			$contador = 0;
			foreach ($arrayDePago as $aP) {
				echo "insertado en id: " . $aP . "<br><br>";
				$consulta = $this->conexion->prepare("INSERT INTO pagodefactura VALUES (null, :aP, :id_factura, :referencia, :montosDePago)");
				$consulta->bindParam(":aP", $aP);
				$consulta->bindParam(":id_factura", $id_factura);
				$consulta->bindParam(":referencia", $referencia);
				$consulta->bindParam(":montosDePago", $montosDePago[$contador]);
				if ($consulta->execute()) {
				} else {
					echo "NO";
				}
				$contador++;
			}
			//insertar servicios extras
			if ($serviciosExtras) {
				$contador = 0;

				foreach ($serviciosExtras as $s) {
					$consulta = $this->conexion->prepare("INSERT INTO detalle_factura  VALUES (null,:id_factura, 'Servicio', 1,:precioServicio, :precioServicio,null,:s,null)");
					$consulta->bindParam(":id_factura", $id_factura);
					$consulta->bindParam(":precioServicio", $precioServicio[$contador]);
					$consulta->bindParam(":s", $s);
					if ($consulta->execute()) {
					} else {
						echo "NO";
					}
					$contador++;
				}
			}
			if ($insumos) {
				$contador = 0;
				foreach ($insumos as $i) {
					$subtotal = $precioInsumo[$contador] * $cantidad[$contador];
					//actualizar la cantidad de insumos
					$id_entrada = $this->selectId_entrada($i);
					$consulta = $this->conexion->prepare("INSERT INTO detalle_factura  VALUES (null, :id_factura, 'Insumo', :cantidad,:precioInsumo, :subtotal,null,null,:i)");
					$consulta->bindParam(":id_factura", $id_factura);
					$consulta->bindParam(":i", $id_entrada);
					$consulta->bindParam(":cantidad", $cantidad[$contador]);
					$consulta->bindParam(":precioInsumo", $precioInsumo[$contador]);
					$consulta->bindParam(":subtotal", $subtotal);
					if ($consulta->execute()) {
						$consulta2 =  $this->conexion->prepare("CALL DescontarLotes(:i, :cantidad);");
						$consulta2->bindParam(":i", $i);
						$consulta2->bindParam(":cantidad", $cantidad[$contador]);
						$consulta2->execute();
					} else {
						echo "NO";
					}
					$contador++;
				}
			}

			return [$id_factura, "exito"];
		} catch (\Exception $e) {
			return $e;
		}
	}




	//insertar la hospitalizacion en la factura
	public function insertaFacturaHospit($id_hospitalizacion, $fecha, $total, $formasDePago, $insumos, $cantidad, $montosDePago, $referencia, $serviciosExtras)
	{



		//insertar factura
		$consulta = $this->conexion->prepare("INSERT INTO factura VALUES (null, NULL, :fecha, :total, NULL, :id_hospitalizacion,'ACT')");

		$consulta->bindParam(":fecha", $fecha);
		$consulta->bindParam(":total", $total);
		$consulta->bindParam(":id_hospitalizacion", $id_hospitalizacion);
		$consulta->execute();
		$id_factura = $this->conexion->lastInsertId();
		echo $id_factura;


		$consulta = $this->conexion->prepare("UPDATE hospitalizacion SET estado = 'Realizada' WHERE id_hospitalizacion =:id_hospitalizacion");
		$consulta->bindParam(":id_hospitalizacion", $id_hospitalizacion);
		$consulta->execute();


		$arrayDePago = $formasDePago;
		//insertar tipos de pago
		$contador = 0;
		foreach ($arrayDePago as $aP) {
			echo "<h1>" . "insertado en id: " . $aP . "</h1><br><br>";
			$consulta = $this->conexion->prepare("INSERT INTO pagodefactura VALUES (null, :aP, :id_factura, :referencia, :montosDePago)");
			$consulta->bindParam(":aP", $aP);
			$consulta->bindParam(":id_factura", $id_factura);
			$consulta->bindParam(":referencia", $referencia);
			$consulta->bindParam(":montosDePago", $montosDePago[$contador]);
			if ($consulta->execute()) {
			} else {
				echo "NO";
			}
			$contador++;
		}

		//insertar servicios extras
		if ($serviciosExtras) {
			foreach ($serviciosExtras as $s) {
				$consulta = $this->conexion->prepare("INSERT INTO facturadeservicio VALUES (null, :id_factura, :s)");
				$consulta->bindParam(":id_factura", $id_factura);
				$consulta->bindParam(":s", $s);
				if ($consulta->execute()) {
				} else {
					echo "NO";
				}
			}
		}


		if ($insumos) {
			print_r($_POST);
			$contador = 0;

			foreach ($insumos as $i) {
				if ($consulta->execute()) {
					//$this->actualizarCantidadEntradaHospit($i, $cantidad[$contador], $id_factura, $cantidad[$contador]);
				} else {
					echo "NO";
				}

				$contador++;
			}
		}





		header("location: ?c=controladorFactura/facturaInicio/" . $id_factura . "/" . $id_hospitalizacion);
	}



	public function consultarFactura($id_factura)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT f.*, c.nombre as nombre_p , c.apellido AS apellido_p, nacionalidad, c.cedula AS cedula_p FROM factura f INNER JOIN cliente c ON c.id_cliente = f.id_cliente  WHERE id_factura =:id_factura ");
			$consulta->bindParam(":id_factura", $id_factura);
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
			$consulta = $this->conexion->prepare("SELECT cs.nombre As categoria_servicio, sf.*,s.*,p.nombre AS nombre_d, p.apellido AS apellido_d FROM detalle_factura sf  INNER JOIN serviciomedico s ON s.id_servicioMedico = sf.serviciomedico_id_servicioMedico INNER JOIN categoria_servicio cs ON cs.id_categoria = s.id_categoria INNER JOIN personal_has_serviciomedico ps ON ps.serviciomedico_id_servicioMedico = s.id_servicioMedico INNER JOIN personal p ON p.id_personal = ps.personal_id_personal  WHERE id_factura =:id_factura ");
			$consulta->bindParam(":id_factura", $id_factura);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}


	public function consultarFacturaSinCita($id_factura)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT f.*, p.nombre as nombre_p , p.apellido AS apellido_p, nacionalidad, p.cedula AS cedula_p FROM factura f INNER JOIN cliente p ON p.id_cliente = f.id_cliente WHERE f.id_factura =:id_factura");
			$consulta->bindParam(":id_factura", $id_factura);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}


	public function consultarFacturaInsumo($id_factura)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT i.*,fi.*,f.*,ins.nombre, ins.precio, ins.iva  FROM entrada_insumo i INNER JOIN detalle_factura fi ON i.id_entradaDeInsumo = fi.entrada_insumo_id_entradaDeInsumo INNER JOIN factura f  ON f.id_factura = fi.id_factura INNER JOIN insumo ins ON ins.id_insumo = i.id_insumo  WHERE f.id_factura =:id_factura");
			$consulta->bindParam(":id_factura", $id_factura);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}


	//hospitalizcion
	// selecciono 6 tablas de la base de datos con el INNER JOIN, uso solo los datos que necesito, para mostrarlo en la tabla de la vista 
	public function selectsFacturaHosp($idH)
	{
		try {
			$consulta = $this->conexion->prepare('SELECT h.id_hospitalizacion, h.duracion, h.precio_horas, h.total, con.id_control, con.diagnostico, h.historiaclinica,pac.nacionalidad, pac.id_paciente, pac.cedula, pac.nombre, pac.apellido, u.id_usuario, doc.nombre AS nombredoc, doc.apellido AS apellidodoc FROM hospitalizacion h INNER JOIN control con ON h.id_control = con.id_control INNER JOIN paciente pac ON con.id_paciente = pac.id_paciente INNER JOIN usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal doc ON doc.id_usuario = u.id_usuario INNER JOIN serviciomedico sm ON sm.id_personal = doc.id_personal WHERE con.estado = "ACT" AND sm.estado = "ACT" AND u.estado = "ACT" AND h.estado = "Pendiente"  AND h.id_hospitalizacion =:idH GROUP BY h.id_hospitalizacion');
			$consulta->bindParam(":idH", $idH);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function selectInsumosHosp($idH)
	{
		try {
			$consulta = $this->conexion->prepare('SELECT i.*,ih.cantidad AS cantidad_insumo_hospit FROM insumodehospitalizacion ih INNER JOIN insumo i ON i.id_insumo = ih.id_insumo WHERE ih.id_hospitalizacion  = :idH ');
			$consulta->bindParam(":idH", $idH);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}


	public function consultarFacturaHosp($id_factura)
	{
		try {

			$consulta = $this->conexion->prepare('SELECT *,f.fecha, f.total, f.id_factura,p.nombre AS nombre_paciente, p.apellido AS apellido_paciente, p.cedula AS cedula_paciente ,p.nacionalidad,d.nombre AS nombre_d, d.apellido AS apellido_d FROM hospitalizacion h INNER JOIN factura f ON f.id_hospitalizacion = h.id_hospitalizacion INNER JOIN control c on h.id_control = c.id_control INNER JOIN usuario u on u.id_usuario = c.id_usuario INNER JOIN personal d ON d.id_usuario = u.id_usuario INNER JOIN paciente p ON c.id_paciente = p.id_paciente WHERE  f.id_factura =:id_factura');
			$consulta->bindParam(":id_factura", $id_factura);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function consultarFacturaHospSer($id_factura)
	{
		try {
			$consulta = $this->conexion->prepare('SELECT f.*,h.*,p.*,u.nombre AS nombre_d, u.apellido AS apellido_d FROM factura f inner join hospitalizacion h on h.id_hospitalizacion = f.id_hospitalizacion INNER JOIN control c ON c.id_control = h.id_control INNER JOIN paciente p ON p.id_paciente = c.id_paciente INNER JOIN usuario u ON u.id_usuario = c.id_usuario  WHERE f.id_factura =:id_factura');
			$consulta->bindParam(":id_factura", $id_factura);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function coincidenciaPacienteCliente($id_paciente)
	{
		try {
			$consulta = $this->conexion->prepare('SELECT * FROM paciente where id_paciente = :id_paciente');
			$consulta->bindParam(":id_paciente", $id_paciente);
			$consulta->execute();
			$dataPaciente = $consulta->fetch();

			$consulta2 = $this->conexion->prepare('SELECT * FROM paciente p INNER JOIN cliente c ON c.cedula = p.cedula WHERE  p.cedula = :cedula');
			$consulta2->bindParam(":cedula", $dataPaciente['cedula']);
			$consulta2->execute();
			$data = $consulta2->fetch();
			while ($data) {
				return $data['id_cliente'];
			}
			return 'no encontrado';
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function guardarCliente($id_paciente)
	{
		try {
			$consulta = $this->conexion->prepare('SELECT * FROM paciente where id_paciente = :id_paciente');
			$consulta->bindParam(":id_paciente", $id_paciente);
			$consulta->execute();
			$dataPaciente = $consulta->fetch();

			return $this->modelo_cliente->insertar($dataPaciente['nacionalidad'], $dataPaciente['cedula'], $dataPaciente['nombre'], $dataPaciente['apellido'], $dataPaciente['telefono'], $dataPaciente['direccion'], $dataPaciente['fn'], $dataPaciente['genero']);
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function comprobarSiFueHospit($id_factura)
	{
		try {
			$consulta = $this->conexion->prepare('SELECT  * FROM factura f INNER JOIN detalle_factura df ON df.id_factura = f.id_factura WHERE f.id_factura =:id_factura AND df.tipo= "Hospitalizacion"');
			$consulta->bindParam(":id_factura", $id_factura);
			$consulta->execute();
			$data  = $consulta->fetch();
			while ($data) {
				return $data['hospitalizacion_id_hospitalizacion'];
			}
			return 'no encontrado';
		} catch (\Exception $e) {
			return 0;
		}
	}
}
