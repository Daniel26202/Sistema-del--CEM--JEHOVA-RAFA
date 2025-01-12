<?php
namespace App\modelos;
use App\modelos\Db;

class ModeloFactura extends Db
{

	private $conexion;

	public function __construct(){
        // Llama al constructor de la clase padre para establecer la conexión
        parent::__construct();
        
        // Aquí puedes usar $this para acceder a la conexión

        $this->conexion = $this; // Guarda la instancia de la conexión
    }
	//buscar Paciente tambien por la cita
	public function buscarPacientePorCita($cedula,$fecha)
	{
		$consulta = $this->conexion->prepare("SELECT d.nombre AS nombre_d,d.apellido AS apellido_d,sm.*,p.id_paciente, p.cedula AS cedula_p,p.nombre AS nombre_p, p.apellido AS apellido_p, p.telefono AS telefono_p ,c.id_cita,c.fecha, c.estado,e.nombre AS especialidad FROM paciente p INNER JOIN cita c ON p.id_paciente = c.id_paciente INNER JOIN serviciomedico s ON s.id_servicioMedico = c.id_servicioMedico INNER JOIN personal d ON s.id_personal = d.id_personal INNER JOIN usuario u ON u.id_usuario = d.id_usuario INNER JOIN serviciomedico sm ON c.id_servicioMedico = sm.id_servicioMedico INNER JOIN especialidad e ON e.id_especialidad = d.id_especialidad  WHERE p.cedula =:cedula AND u.estado = 'ACT' AND c.fecha =:fecha AND c.estado= 'Pendiente' ");
		$consulta->bindParam(":cedula", $cedula);
		$consulta->bindParam(":fecha", $fecha);
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}


	

	public function mostrarCitaFactura($id_cita)
	{
		$consulta = $this->conexion->prepare("SELECT d.nombre AS nombre_d,d.apellido AS apellido_d,sm.*,p.id_paciente,p.nacionalidad, p.cedula AS cedula_p,p.nombre AS nombre_p, p.apellido AS apellido_p, p.telefono AS telefono_p ,c.id_cita,c.fecha, c.estado,e.nombre AS especialidad FROM paciente p INNER JOIN cita c ON p.id_paciente = c.id_paciente INNER JOIN serviciomedico s ON s.id_servicioMedico  = c.id_servicioMedico INNER JOIN personal d ON s.id_personal = d.id_personal INNER JOIN especialidad e ON d.id_especialidad = e.id_especialidad INNER JOIN usuario u ON u.id_usuario = d.id_usuario INNER JOIN serviciomedico sm ON c.id_servicioMedico = sm.id_servicioMedico WHERE c.id_cita =:id_cita AND u.estado = 'ACT' ");
		$consulta->bindParam(":id_cita", $id_cita);
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}

	public function buscar($cedula)
	{
		$consulta = $this->conexion->prepare("SELECT * FROM paciente WHERE cedula =:cedula AND estado = 'ACT' ");
		$consulta->bindParam(":cedula", $cedula);
		$consulta->execute();
		return ($consulta->execute()) ? $consulta->fetch() : false;
	}

	public function mostrarServicioExtra()
	{
		$consulta = $this->conexion->prepare("SELECT cs.id_categoria,cs.nombre, d.nombre AS nombre_d, d.apellido AS apellido_d,sm.*,d.* FROM serviciomedico sm INNER JOIN personal d ON d.id_personal = sm.id_personal INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria INNER JOIN usuario u ON u.id_usuario = d.id_usuario WHERE sm.estado = 'ACT' AND cs.nombre != 'Consulta' ");
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}
	
	//buscar servicios
	public function buscarServicioExtra($nombre)
	{
		$consulta = $this->conexion->prepare("SELECT u.nombre AS nombre_d, u.apellido AS apellido_d,sm.*,d.* FROM serviciomedico sm INNER JOIN doctor d ON d.id_doctor = sm.id_doctor INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria INNER JOIN usuario u ON u.id_usuario = d.id_usuario WHERE cs.nombre = 'Adicional' AND sm.estado = 'ACT' AND nombre =:nombre ");
		$busqueda = "%$nombre%";
		$consulta->bindParam(":nombre",$busqueda);
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}

	public function mostrarDoctores($id_servicioExtra)
	{
		$consulta = $this->conexion->prepare("SELECT sm.*, d.*, d.nombre as nombre_d FROM serviciomedico sm INNER JOIN personal d on d.id_personal = sm.id_personal INNER JOIN usuario u ON u.id_usuario = d.id_usuario WHERE sm.id_servicioMedico=:id_servicioExtra AND sm.estado = 'ACT' ");


		$consulta->bindParam(":id_servicioExtra", $id_servicioExtra);

		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}
	//desde aqui empizo a acomodar las consultas SQL 
	public function mostrarPrecioDoctores($id_doctor, $id_servicioExtra)
	{
		$consulta = $this->conexion->prepare("SELECT sm.*, d.*, u.nombre as nombre_d, u.apellido FROM servicioextra sm INNER JOIN doctor d on d.id_doctor = sm.id_doctor INNER JOIN usuario u ON u.id_usuario = d.id_usuario WHERE d.id_doctor = :id_doctor AND sm.id_servicioExtra =:id_servicioExtra");

		$consulta->bindParam(":id_doctor", $id_doctor);
		$consulta->bindParam(":id_servicioExtra", $id_servicioExtra);

		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}

	public function mostrarNombreDoctores($id_doctor)
	{
		$consulta = $this->conexion->prepare("SELECT d.nombre,d.id_usuario,u.id_usuario FROM usuario u INNER JOIN personal d 
			on d.id_usuario = u.id_usuario WHERE d.id_personal =:id_doctor ");

		$consulta->bindParam(":id_doctor", $id_doctor);

		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}


	public function seleccionarIdConsulta($nombre, $nombreD)
	{
		$consulta = $this->conexion->prepare("SELECT sm.*, d.nombre AS nombre_doctor, e.nombre AS especialidad FROM personal d JOIN
			serviciomedico sm ON d.id_personal = sm.id_personal JOIN
			usuario u ON d.id_usuario = u.id_usuario JOIN 
			especialidad e ON d.id_especialidad = e.id_especialidad
			WHERE e.nombre = :nombre AND d.nombre =:nombreD ");

		$consulta->bindParam(":nombre", $nombre);
		$consulta->bindParam(":nombreD", $nombreD);

		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}

	//https://www.mediafire.com/file/04mpuerx3cg5hbb

	public function seleccionarIdDoctor($nombre)
	{
		$consulta = $this->conexion->prepare("SELECT d.id_doctor,u.nombre,d.id_usuario,u.id_usuario FROM usuario u INNER JOIN personal d 
			on d.id_usuario = u.id_usuario WHERE d.nombre =:nombre");
		$consulta->bindParam(":nombre", $nombre);
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}

	//insumos 
	public function mostrarInsumos($id_insumo = "")
	{
		if ($id_insumo == "") {
			$consulta = $this->conexion->prepare(" SELECT i.*,i.cantidad AS cantidad_inventario, i.numero_de_lote, ins.* FROM insumo ins INNER JOIN inventario i ON i.id_insumo = ins.id_insumo WHERE ins.estado = 'ACT' AND i.cantidad > 0 ORDER BY ins.nombre ASC ");
		} else {
			$consulta = $this->conexion->prepare("SELECT * FROM insumo WHERE id_insumo=:id_insumo AND estado = 'ACT'  AND cantidad > 0  ");
			$consulta->bindParam(":id_insumo", $id_insumo);
		}
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}





	//metodo para mostra los tipos de pagos registrados en la base de Datos
	public function mostrarTiposDePagos()
	{
		$consulta = $this->conexion->prepare("SELECT * FROM pago");
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}

	private function actualizarCantidadEntrada($id_insumo)
	{
		$consulta = $this->conexion->prepare("SELECT ei.id_insumo,SUM(ei.cantidad) AS cantidadInsumo FROM entrada e INNER JOIN entrada_insumo ei ON ei.id_entrada = e.id_entrada INNER JOIN insumo i on i.id_insumo = ei.id_insumo GROUP BY ei.id_insumo HAVING ei.id_insumo =:id_insumo ");
		$consulta->bindParam(":id_insumo", $id_insumo);
		$consulta->execute();
		$x = $consulta->fetch();
		$cantidadInsumoPre = $x["cantidadInsumo"];
		echo $cantidadInsumoPre."<br>";

		$consulta = $this->conexion->prepare("SELECT * FROM entrada e INNER JOIN entrada_insumo ei ON ei.id_entrada = e.id_entrada INNER JOIN insumo i ON i.id_insumo = ei.id_insumo WHERE ei.id_insumo =:id_insumo AND e.estado = 'DES' ");
		$consulta->bindParam(":id_insumo", $id_insumo);
		$consulta->execute();
		$desactivos = $consulta->fetchAll();
		$totalDesactivo = 0;
		foreach ($desactivos as $des) {
			$totalDesactivo += $des["cantidad"];
		}
		echo $id_insumo;
		$consultaInsumosFacturados = $this->conexion->prepare("SELECT SUM(edf.cantidad) AS total_cantidad_facturada FROM insumodefactura edf INNER JOIN inventario i on i.id_inventario = edf.id_inventario INNER JOIN insumo ins ON ins.id_insumo = i.id_insumo WHERE edf.estado = 'ACT' AND i.id_insumo =:id_insumo");
		$consultaInsumosFacturados->bindParam(":id_insumo", $id_insumo);
		$consultaInsumosFacturados->execute();
		$facturados = $consultaInsumosFacturados->fetch();
		
		$totalFacturado = $facturados["total_cantidad_facturada"];

		//esto es para restar los insumos que ya fueron facturados

		$cantidadInsumo = ($cantidadInsumoPre - $totalDesactivo) - $totalFacturado;

		// echo "Pre: " .$cantidadInsumoPre."<br>";
		// echo "Desactivado: ".$totalDesactivo."<br>";
		// echo "Factrado: ".$totalFacturado."<br>";
		// echo $cantidadInsumo;



		$consulta = $this->conexion->prepare("UPDATE insumo SET cantidad =:cantidadInsumo WHERE id_insumo =:id_insumo");
		$consulta->bindParam(":id_insumo", $id_insumo);
		$consulta->bindParam(":cantidadInsumo", $cantidadInsumo);
		$consulta->execute();
		
	}


	public function insertaFactura($id_cita, $fecha, $total, $formasDePago, $serviciosExtras, $id_paciente,$insumos,$cantidad,$montosDePago,$referencia)
	{



		//insertar factura
		$consulta = $this->conexion->prepare("INSERT INTO factura VALUES (null, :id_cita, :fecha, :total, :id_paciente, NULL,'ACT')");

		$consulta->bindParam(":id_cita", $id_cita);
		$consulta->bindParam(":fecha", $fecha);
		$consulta->bindParam(":total", $total);
		$consulta->bindParam(":id_paciente", $id_paciente);
		$consulta->execute();
		$id_factura = $this->conexion->lastInsertId();
		echo $id_factura;

		$consulta = $this->conexion->prepare("UPDATE cita SET estado = 'Realizadas' WHERE id_cita =:id_cita");
		$consulta->bindParam(":id_cita", $id_cita);
		$consulta->execute();


		$arrayDePago = $formasDePago;
		//insertar tipos de pago
		$contador = 0;
		foreach ($arrayDePago as $aP) {
			echo "insertado en id: " . $aP . "<br><br>";
			$consulta = $this->conexion->prepare("INSERT INTO pagodefactura VALUES (null, :aP, :id_factura, :referencia, :montosDePago)");
			$consulta->bindParam(":aP", $aP);
			$consulta->bindParam(":id_factura", $id_factura);
			$consulta->bindParam(":referencia", $referencia);
			$consulta->bindParam(":montosDePago",$montosDePago[$contador]);
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
			$contador = 0;
	
			foreach ($insumos as $i) {
				$consulta = $this->conexion->prepare("INSERT INTO insumodefactura VALUES (null, :id_factura, :i, :cantidad, 'ACT')");
				$consulta->bindParam(":id_factura", $id_factura);
				$consulta->bindParam(":i", $i);
				$consulta->bindParam(":cantidad", $cantidad[$contador]);
				if ($consulta->execute()) {
					$this->actualizarCantidadEntrada($i);
				} else {
					echo "NO";
				}
				$contador++;
			}
		}

	


		if ($id_cita == null) {
			header("location: ?c=controladorFactura/facturaInicio&id_factura=" . $id_factura);
		} else {
			header("location: ?c=controladorFactura/facturaInicio&id_factura=" . $id_factura . "&id_cita=" . $id_cita);
		}


	}




	//insertar la hospitalizacion en la factura
	public function insertaFacturaHospit($id_hospitalizacion, $fecha,$total, $formasDePago, $insumos,$cantidad,$montosDePago,$referencia,$serviciosExtras)
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
			echo "insertado en id: " . $aP . "<br><br>";
			$consulta = $this->conexion->prepare("INSERT INTO pagodefactura VALUES (null, :aP, :id_factura, :referencia, :montosDePago)");
			$consulta->bindParam(":aP", $aP);
			$consulta->bindParam(":id_factura", $id_factura);
			$consulta->bindParam(":referencia", $referencia);
			$consulta->bindParam(":montosDePago",$montosDePago[$contador]);
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
				$consulta = $this->conexion->prepare("INSERT INTO inventario VALUES (null, :i, :cantidad, '2024-12-12', '112345')");
				$consulta->bindParam(":i", $i);
				$consulta->bindParam(":cantidad", $cantidad[$contador]);
				if ($consulta->execute()) {
					$id_inventario = $this->lastInsertId();
					$consulta = $this->conexion->prepare("INSERT INTO insumodefactura VALUES (null, :id_factura, :id_inventario, :cantidad, 'ACT')");
					$consulta->bindParam(":id_factura", $id_factura);
					$consulta->bindParam(":id_inventario", $id_inventario);
					$consulta->bindParam(":cantidad", $cantidad[$contador]);
					$this->actualizarCantidadEntrada($i);
				} else {
					echo "NO";
				}

				$contador++;
			}
		}

	


		
			header("location: ?c=controladorFactura/facturaInicio&id_factura=" . $id_factura . "&idH=" . $id_hospitalizacion);
		


	}

		

	public function consultarFactura($id_factura)
	{
		$consulta = $this->conexion->prepare("SELECT cs.nombre AS categoria_servicio, d.nombre AS nombre_d, d.apellido AS apellido_d,e.nombre AS especialidad, p.nombre AS nombre_p, p.apellido AS apellido_p, p.nacionalidad, p.cedula AS cedula_p , f.*,c.*,sm.precio AS precio_servicio FROM factura f INNER JOIN cita c ON f.id_cita =c.id_cita  INNER JOIN paciente p ON c.id_paciente = p.id_paciente INNER JOIN serviciomedico sm ON c.id_servicioMedico = sm.id_servicioMedico INNER JOIN personal d ON sm.id_personal = d.id_personal INNER JOIN especialidad e ON  e.id_especialidad = d.id_especialidad INNER JOIN usuario u ON d.id_usuario = u.id_usuario INNER JOIN categoria_servicio cs on cs.id_categoria = sm.id_categoria  WHERE id_factura =:id_factura ");
		$consulta->bindParam(":id_factura", $id_factura);
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}

	public function consultarPagoFactura($id_factura)
	{
		$consulta = $this->conexion->prepare("SELECT pf.* , p.nombre
			FROM pago p INNER JOIN pagodefactura pf ON p.id_pago = pf.id_pago
			INNER JOIN factura f ON pf.id_factura = f.id_factura WHERE f.id_factura =:id_factura");
		$consulta->bindParam(":id_factura", $id_factura);
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}

	public function consultarServiciosExtras($id_factura)
	{
		$consulta = $this->conexion->prepare("SELECT cs.nombre As categoria_servicio, fs.*,s.*,f.*,d.nombre AS nombre_d, d.apellido AS apellido_d FROM factura f INNER JOIN facturadeservicio fs ON f.id_factura = fs.id_factura INNER JOIN serviciomedico s ON s.id_servicioMedico = fs.id_servicioMedico INNER JOIN personal d ON s.id_personal= d.id_personal INNER JOIN usuario u ON u.id_usuario = d.id_usuario INNER JOIN categoria_servicio cs ON s.id_categoria = cs.id_categoria WHERE f.id_factura =:id_factura  AND cs.id_categoria != 9");
		$consulta->bindParam(":id_factura", $id_factura);
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}


	public function consultarFacturaSinCita($id_factura)
	{
		$consulta = $this->conexion->prepare("SELECT p.nacionalidad, p.nombre AS nombre_p,p.apellido AS apellido_p,p.cedula AS cedula_p,f.* FROM factura f INNER JOIN paciente p ON f.id_paciente = p.id_paciente WHERE f.id_factura =:id_factura");
		$consulta->bindParam(":id_factura", $id_factura);
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}


	public function consultarFacturaInsumo($id_factura)
	{
		$consulta = $this->conexion->prepare("SELECT i.*,fi.*,f.*,ins.nombre, ins.precio FROM inventario i INNER JOIN insumodefactura fi ON i.id_inventario = fi.id_inventario INNER JOIN factura f  ON f.id_factura = fi.id_factura INNER JOIN insumo ins ON ins.id_insumo = i.id_insumo  WHERE f.id_factura =:id_factura");
		$consulta->bindParam(":id_factura", $id_factura);
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}


	//hospitalizcion
	// selecciono 6 tablas de la base de datos con el INNER JOIN, uso solo los datos que necesito, para mostrarlo en la tabla de la vista 
    public function selectsFacturaHosp($idH)
    {

        $consulta = $this->conexion->prepare('SELECT h.id_hospitalizacion, h.duracion, h.precio_horas, h.total, con.id_control, con.diagnostico, h.historiaclinica,pac.nacionalidad, pac.id_paciente, pac.cedula, pac.nombre, pac.apellido, u.id_usuario, doc.nombre AS nombredoc, doc.apellido AS apellidodoc FROM hospitalizacion h INNER JOIN control con ON h.id_control = con.id_control INNER JOIN paciente pac ON con.id_paciente = pac.id_paciente INNER JOIN usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal doc ON doc.id_usuario = u.id_usuario INNER JOIN serviciomedico sm ON sm.id_personal = doc.id_personal WHERE con.estado = "ACT" AND sm.estado = "ACT" AND u.estado = "ACT" AND h.estado = "Pendiente"  AND h.id_hospitalizacion =:idH GROUP BY h.id_hospitalizacion');
		$consulta->bindParam(":idH",$idH);
        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

	public function selectInsumosHosp($idH)
    {

        $consulta = $this->conexion->prepare('SELECT i.*,ih.cantidad AS cantidad_insumo_hospit FROM insumodehospitalizacion ih INNER JOIN insumo i ON i.id_insumo = ih.id_insumo WHERE ih.id_hospitalizacion  = :idH ');
		$consulta->bindParam(":idH",$idH);
        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }


	public function consultarFacturaHosp($id_factura)
    {

        $consulta = $this->conexion->prepare('SELECT *,d.nombre AS nombre_d, d.apellido AS apellido_d FROM hospitalizacion h INNER JOIN factura f ON f.id_hospitalizacion = h.id_hospitalizacion INNER JOIN control c on h.id_control = c.id_control INNER JOIN usuario u on u.id_usuario = c.id_usuario INNER JOIN personal d ON d.id_usuario = u.id_usuario WHERE  f.id_factura =:id_factura');
		$consulta->bindParam(":id_factura",$id_factura);
        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

	public function consultarFacturaHospSer($id_factura)
    {

        $consulta = $this->conexion->prepare('SELECT f.*,h.*,p.*,u.nombre AS nombre_d, u.apellido AS apellido_d FROM factura f inner join hospitalizacion h on h.id_hospitalizacion = f.id_hospitalizacion INNER JOIN control c ON c.id_control = h.id_control INNER JOIN paciente p ON p.id_paciente = c.id_paciente INNER JOIN usuario u ON u.id_usuario = c.id_usuario  WHERE f.id_factura =:id_factura');
		$consulta->bindParam(":id_factura",$id_factura);
        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }


}