<?php

namespace App\modelos;

use App\modelos\Db;
use App\modelos\ModeloInsumo;

class ModeloFactura extends Db
{

	private $conexion;
	private $modelo_insumo;

	public function __construct()
	{
		// Llama al constructor de la clase padre para establecer la conexión
		parent::__construct();

		// Aquí puedes usar $this para acceder a la conexión

		$this->conexion = $this; // Guarda la instancia de la conexión
		$this->modelo_insumo = new ModeloInsumo;
	}
	//buscar Paciente tambien por la cita
	public function buscarPacientePorCita($cedula, $fecha)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT d.nombre AS nombre_d,d.apellido AS apellido_d,sm.*,p.id_paciente, p.cedula AS cedula_p,p.nombre AS nombre_p, p.apellido AS apellido_p, p.telefono AS telefono_p ,c.id_cita,c.fecha, c.estado,e.nombre AS especialidad FROM paciente p INNER JOIN cita c ON p.id_paciente = c.paciente_id_paciente INNER JOIN serviciomedico s ON s.id_servicioMedico = c.serviciomedico_id_servicioMedico INNER JOIN personal_has_serviciomedico ps ON ps.serviciomedico_id_servicioMedico = s.id_servicioMedico INNER JOIN  personal d ON d.id_personal= ps.personal_id_personal INNER JOIN usuario u ON u.id_usuario = d.id_usuario INNER JOIN serviciomedico sm ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN especialidad e ON e.id_especialidad = d.id_especialidad  WHERE p.cedula =:cedula AND u.estado = 'ACT' AND c.fecha =:fecha AND c.estado= 'Pendiente' ");
			$consulta->bindParam(":cedula", $cedula);
			$consulta->bindParam(":fecha", $fecha);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}




	public function mostrarCitaFactura($id_cita)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT d.nombre AS nombre_d,d.apellido AS apellido_d,s.*,p.id_paciente,p.nacionalidad, p.cedula AS cedula_p,p.nombre AS nombre_p, p.apellido AS apellido_p, p.telefono AS telefono_p ,c.id_cita,c.fecha, c.estado,e.nombre AS especialidad FROM paciente p INNER JOIN cita c ON p.id_paciente = c.paciente_id_paciente INNER JOIN serviciomedico s ON s.id_servicioMedico  = c.serviciomedico_id_servicioMedico INNER JOIN personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = s.id_servicioMedico INNER JOIN personal d ON psm.personal_id_personal = d.id_personal INNER JOIN especialidad e ON d.id_especialidad = e.id_especialidad INNER JOIN usuario u ON u.id_usuario = d.id_usuario WHERE c.id_cita =:id_cita AND u.estado = 'ACT' ");
			$consulta->bindParam(":id_cita", $id_cita);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function mostrarHospitalizacion($id_hospitalizacion)
	{

		try {
			$consulta = $this->conexion->prepare('SELECT h.id_hospitalizacion, h.fecha_hora_inicio, h.precio_horas, h.fecha_hora_final, h.total, con.id_control, con.diagnostico, con.historiaclinica, pac.id_paciente, pac.nacionalidad, pac.cedula, pac.nombre, pac.apellido, u.id_usuario, pe.nombre AS nombredoc, pe.apellido AS apellidodoc FROM hospitalizacion h INNER JOIN control con ON h.id_control = con.id_control INNER JOIN paciente pac ON con.id_paciente = pac.id_paciente INNER JOIN usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal pe ON pe.id_usuario = u.id_usuario INNER JOIN personal_has_serviciomedico psm ON psm.personal_id_personal = pe.id_personal INNER JOIN serviciomedico sm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico WHERE con.estado = "ACT" AND sm.estado = "ACT" AND u.estado = "ACT" AND h.estado = "Pendiente"  AND  h.id_hospitalizacion =:id_hospitalizacion GROUP BY h.id_hospitalizacion');
			$consulta->bindParam(":id_hospitalizacion", $id_hospitalizacion);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function unirInsumosHospitalizacion($id_hospitalizacion)
	{
		try {
			$consulta = $this->conexion->prepare('SELECT h.id_hospitalizacion, idh.id_insumoDeHospitalizacion, ins.id_insumo, idh.cantidad, ins.nombre, inv.cantidad AS cantidadEx, ins.precio, h.fecha_hora_inicio FROM hospitalizacion h INNER JOIN control con ON h.id_control = con.id_control INNER JOIN paciente pac ON con.id_paciente = pac.id_paciente INNER JOIN usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal pe ON pe.id_usuario = u.id_usuario INNER JOIN personal_has_serviciomedico psm ON psm.personal_id_personal = pe.id_personal INNER JOIN serviciomedico sm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico INNER JOIN insumodehospitalizacion idh ON h.id_hospitalizacion = idh.id_hospitalizacion INNER JOIN inventario inv ON idh.id_inventario = inv.id_inventario INNER JOIN insumo ins ON inv.id_insumo = ins.id_insumo WHERE con.estado = "ACT" AND sm.estado = "ACT" AND u.estado = "ACT" AND ins.estado = "ACT" AND h.estado = "Pendiente" AND h.id_hospitalizacion =:id_hospitalizacion ');
			$consulta->bindParam(":id_hospitalizacion", $id_hospitalizacion);
			$consulta->execute();
			$insumos = $consulta->fetchAll();
			if (!is_array($insumos)) {
				return "";
			}
			$cadena = "";
			foreach ($insumos as $insumo) {
				$cadena .= $insumo['nombre'] . " Cantidad (" . $insumo['cantidad'] . "), ";
			}
			// Quitar la última coma y espacio
			$cadena = rtrim($cadena, ', ');
			return $cadena;
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

	public function mostrarServicios()
	{
		try {
			$consulta = $this->conexion->prepare("SELECT cs.id_categoria,cs.nombre, d.nombre AS nombre_d, d.apellido AS apellido_d,sm.*,d.*  FROM categoria_servicio cs JOIN serviciomedico sm ON sm.id_categoria = cs.id_categoria JOIN personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico JOIN personal d ON psm.personal_id_personal = d.id_personal JOIN usuario u ON  u.id_usuario = d.id_usuario WHERE sm.estado = 'ACT' AND cs.nombre != 'Consulta' ");
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

	public function updateCantidadEntrada($id_insumo, $cantidad_requerida)
	{

		try {
			// Consultar lotes disponibles
			$consultaLote = $this->conexion->prepare("SELECT ei.*,e.numero_de_lote FROM entrada_insumo ei INNER JOIN entrada e ON e.id_entrada = ei.id_entrada WHERE ei.id_insumo =:id_insumo AND ei.cantidad_disponible > 0 ORDER BY ei.cantidad_disponible ASC");
			$consultaLote->bindParam(":id_insumo", $id_insumo);
			$consultaLote->execute();
			$lotesDisponibles = $consultaLote->fetchAll();

			// Consultar suma de lotes disponibles
			$consultaLote2 = $this->conexion->prepare("SELECT SUM(cantidad_disponible)AS cantidad_disponible FROM entrada_insumo WHERE id_insumo =:id_insumo GROUP BY id_insumo ORDER BY cantidad_disponible ASC");
			$consultaLote2->bindParam(":id_insumo", $id_insumo);
			$consultaLote2->execute();
			$lotesDisponibles2 = $consultaLote2->fetchAll();

			//cantidad total
			$cantidad_total = 0;

			//llenar en el bucle la cantidad total
			foreach ($lotesDisponibles2 as $fila) {
				$cantidad_total += $fila["cantidad_disponible"];
			}


			if ($cantidad_requerida <= $cantidad_total) {
				// Verificar si hay lotes disponibles
				if ($cantidad_total > 0) {
					// Iterar sobre los lotes y restar la cantidad requerida
					$cantidad_actualidad_insumo = [];
					foreach ($lotesDisponibles as $fila) {
						$lote_id = $fila['id_entradaDeInsumo'];
						$lote_cantidad = $fila['cantidad_disponible'];
						$numero_de_lote = $fila['numero_de_lote'];
						$id_insumo = $fila['id_insumo'];

						if ($lote_cantidad >= $cantidad_requerida) {
							// Suficiente cantidad en el lote actual
							$nuevo_lote_cantidad = $lote_cantidad - $cantidad_requerida;
							$cantidad_requerida = 0;
						} else {
							// No hay suficiente cantidad en el lote actual
							$nuevo_lote_cantidad = 0;
							$cantidad_requerida -= $lote_cantidad;
						}

						// Actualizar la cantidad en el lote

						$editarLote = $this->conexion->prepare("UPDATE entrada_insumo SET cantidad_disponible = :nuevo_lote_cantidad WHERE id_entradaDeInsumo = :lote_id");
						$editarLote->bindParam(":nuevo_lote_cantidad", $nuevo_lote_cantidad);
						$editarLote->bindParam(":lote_id", $lote_id);
						$editarLote->execute();

						// Actualizar la cantidad en el inventario
						$editarInventario = $this->conexion->prepare("UPDATE inventario SET cantidad = :nuevo_lote_cantidad WHERE id_insumo =:id_insumo AND numero_de_lote =:numero_de_lote");
						$editarInventario->bindParam(":nuevo_lote_cantidad", $nuevo_lote_cantidad);
						$editarInventario->bindParam(":id_insumo", $id_insumo);
						$editarInventario->bindParam(":numero_de_lote", $numero_de_lote);
						$editarInventario->execute();
					}
				}
			}
			return [$cantidad_total, $lotesDisponibles];
		} catch (\Exception $e) {

			return 0;
		}
	}

	//Metodo para actualizar la cantidad insumos de la hospitalizacion
	public function actualizarCantidadEntradaTotales($id_insumo, $cantidad_requerida, $id_factura, $cantidad_en_la_factura)
	{
		try {
			$this->conexion->beginTransaction();

			$datos = $this->updateCantidadEntrada($id_insumo, $cantidad_requerida);

			if ($datos) {
				$cantidad_total = $datos[0];
				$lotesDisponibles = $datos[1];

				if ($cantidad_requerida <= $cantidad_total) {
					// Verificar si hay lotes disponibles
					if ($cantidad_total > 0) {
						$id_inventario = "";
						// Iterar sobre los lotes y restar la cantidad requerida
						foreach ($lotesDisponibles as $fila) {
							$numero_de_lote = $fila['numero_de_lote'];
							$id_insumo = $fila['id_insumo'];

							$consultaIdInventario = $this->conexion->prepare("SELECT id_inventario FROM inventario WHERE id_insumo =:id_insumo AND numero_de_lote =:numero_de_lote ");
							$consultaIdInventario->bindParam(":id_insumo", $id_insumo);
							$consultaIdInventario->bindParam(":numero_de_lote", $numero_de_lote);
							$consultaIdInventario->execute();
							$datos = $consultaIdInventario->fetch();

							$id_inventario = $datos["id_inventario"]; //id de el inventario

							// $cantidad_actualidad_insumo = $this->modelo_insumo->actualizar_cantidad_insumo($id_insumo);
							// // print_r($cantidad[0]["cantidad"]);

							//esto es para actualizar la cantidad de insumos

						}

						$consulta = $this->conexion->prepare("INSERT INTO factura_has_inventario VALUES (:id_factura, :id_inventario, :cantidad, 'ACT')");
						$consulta->bindParam(":id_factura", $id_factura);
						$consulta->bindParam(":id_inventario", $id_inventario);
						$consulta->bindParam(":cantidad", $cantidad_en_la_factura);
						$consulta->execute();





						if ($cantidad_requerida > 0) {
							echo "No hay suficientes insumos disponibles para cubrir la cantidad requerida.";
						} else {
							echo "Venta realizada exitosamente.";
						}
					} else {
						echo "No hay lotes disponibles.";
					}
				} else {
					echo "NO..";
				}
			}


			$this->conexion->commit();
		} catch (\Exception $e) {
			$this->conexion->rollBack();
			// Puedes manejar el error aquí, por ejemplo, loguearlo o devolver el mensaje
			return 0;
		}
	}


	public function insertaFactura($fecha, $total, $formasDePago, $serviciosExtras, $id_paciente, $insumos, $cantidad, $montosDePago, $referencia, $id_cita, $id_hospitalizacion)
	{

		// try {


			//insertar factura
			$consulta = $this->conexion->prepare("INSERT INTO factura VALUES (null, :fecha, :total, 'ACT', :id_paciente)");

			$consulta->bindParam(":fecha", $fecha);
			$consulta->bindParam(":total", $total);
			$consulta->bindParam(":id_paciente", $id_paciente);
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
				foreach ($serviciosExtras as $s) {
					$consulta = $this->conexion->prepare("INSERT INTO serviciomedico_has_factura  VALUES (:s, :id_factura)");
					$consulta->bindParam(":id_factura", $id_factura);
					$consulta->bindParam(":s", $s);
					if ($consulta->execute()) {
					} else {
						echo "NO";
					}
				}
			}
			if ($insumos) {
				$contador = 0;
				foreach ($insumos as $i) {
					$insumo = $this->actualizarCantidadEntradaTotales($i, $cantidad[$contador], $id_factura, $cantidad[$contador]);
					if ($insumo) {
						$contador++;
					}
				}
			}

			return $id_factura;
		// } catch (\Exception $e) {
		// 	return 0;
		// }
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
			$consulta = $this->conexion->prepare("SELECT f.*, p.nombre as nombre_p , p.apellido AS apellido_p, nacionalidad, p.cedula AS cedula_p FROM factura f INNER JOIN paciente p ON p.id_paciente = f.paciente_id_paciente   WHERE id_factura =:id_factura ");
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
			$consulta = $this->conexion->prepare("SELECT cs.nombre As categoria_servicio, fs.*,s.*,f.*,d.nombre AS nombre_d, d.apellido AS apellido_d FROM factura f INNER JOIN serviciomedico_has_factura fs ON f.id_factura = fs.factura_id_factura INNER JOIN serviciomedico s ON s.id_servicioMedico = fs.serviciomedico_id_servicioMedico INNER JOIN personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = fs.serviciomedico_id_servicioMedico INNER JOIN  personal d ON psm.personal_id_personal = d.id_personal INNER JOIN usuario u ON u.id_usuario = d.id_usuario INNER JOIN categoria_servicio cs ON s.id_categoria = cs.id_categoria WHERE f.id_factura =:id_factura ");
			$consulta->bindParam(":id_factura", $id_factura);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}


	public function consultarFacturaSinCita($id_factura)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT f.*, p.nombre as nombre_p , p.apellido AS apellido_p, nacionalidad, p.cedula AS cedula_p FROM factura f INNER JOIN paciente p ON p.id_paciente = f.paciente_id_paciente WHERE f.id_factura =:id_factura");
			$consulta->bindParam(":id_factura", $id_factura);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}


	public function consultarFacturaInsumo($id_factura)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT i.*,fi.*,f.*,ins.nombre, ins.precio FROM inventario i INNER JOIN factura_has_inventario fi ON i.id_inventario = fi.inventario_id_inventario INNER JOIN factura f  ON f.id_factura = fi.factura_id_factura INNER JOIN insumo ins ON ins.id_insumo = i.id_insumo  WHERE f.id_factura =:id_factura");
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
}
