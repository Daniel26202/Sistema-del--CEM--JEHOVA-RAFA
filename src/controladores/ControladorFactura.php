<?php
//requiero el modelo de factura
use App\modelos\ModeloFactura;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;

class ControladorFactura
{
	private $modelo; //atributo privado
	private $bitacora;
	private $permisos;

	//le damos el valor de el  modelo a el atributo $modelo
	function __construct()
	{
		$this->modelo = new ModeloFactura();
		$this->bitacora = new ModeloBitacora();
		$this->permisos = new ModeloPermisos();
	}

	//metodo para mostrar la vista de facturacion


	public function factura($parametro)
	{
		$ayuda = "btnayudaFactura";
		$insumos = $this->modelo->selectTodosLosInsumos();
		$tiposDePagos = $this->modelo->mostrarTiposDePagos();
		$todosLosInsumos = $this->modelo->selectTodosLosInsumos();
		$extras = $this->modelo->mostrarServicios();
		require_once './src/vistas/vistaFactura/factura.php';
	}

	public function facturaCita($parametro)
	{
		$idCita = preg_replace('/\D/', '', $parametro[0]);
		$insumos = $this->modelo->selectTodosLosInsumos();
		$tiposDePagos = $this->modelo->mostrarTiposDePagos();
		$todosLosInsumos = $this->modelo->selectTodosLosInsumos();
		$extras = $this->modelo->mostrarServicios();
		$citaFacturar = $this->modelo->mostrarCitaFactura($idCita);
		require_once './src/vistas/vistaFactura/facturaCita.php';
	}

	public function facturarHospitalizacion($parametro)
	{
		// Extrae solo los dígitos del parámetro para obtener el ID de hospitalización
		$idHospitalizacion = preg_replace('/\D/', '', $parametro[0]);
		$insumosHospitalizacion = $this->modelo->unirInsumosHospitalizacion($idHospitalizacion);
		$tiposDePagos = $this->modelo->mostrarTiposDePagos();
		$hostalizacionFacturar =  $this->modelo->mostrarHospitalizacion($idHospitalizacion);
		require_once './src/vistas/vistaFactura/facturaHospitalizacion.php';
	}

	public function comprobante($parametro)
	{

		if ($parametro == "") header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/factura");

		$datosFactura = $this->modelo->consultarFactura($parametro[0]);
		$datosPago = $this->modelo->consultarPagoFactura($parametro[0]);
		$datosServiciosExtras = $this->modelo->consultarServiciosExtras($parametro[0]);
		$datosInsumos = $this->modelo->consultarFacturaInsumo($parametro[0]);
		require_once './src/vistas/vistaFactura/comprobante.php';
	}

	//aqui mostramos al paciente de la base de datos
	public function mostrarPaciente()
	{
		$respuesta = $this->modelo->buscar($_POST['cedula']);
		$arrayName = array();
		array_push($arrayName, $respuesta);
		echo json_encode($arrayName);
	}

	//aqui mostramos al paciente si tiene cita
	public function mostrarPacienteConCita()
	{
		$respuesta = $this->modelo->buscarPacientePorCita($_POST["cedula"]);
		echo json_encode($respuesta);
	}

	public function mostrarTodosLosServicios()
	{
		$respuesta = $this->modelo->buscarServicio($_POST["nombre"]);
		echo json_encode($respuesta);
	}



	//metodo para guaradar Factura
	public function guardarFactura()
	{
		$fecha = date("Y-m-d");
		$serviciosExtras = isset($_POST["servicios"]) ? $_POST["servicios"] : false;
		$doctor = isset($_POST["doctores"]) ? $_POST["doctores"] : false;
		$insumos = isset($_POST["insumos"]) ? $_POST["insumos"] : false;
		$cantidad = isset($_POST["cantidad"]) ? $_POST["cantidad"] : false;
		$id_paciente = isset($_POST["id_paciente"]) ? $_POST["id_paciente"] : false;
		$id_cita = isset($_POST["id_cita"]) ? $_POST["id_cita"] : null;
		$referencia = isset($_POST["referencia"]) ? $_POST["referencia"] : null;
		$id_hospitalizacion = isset($_POST["id_hospitalizacion"]) ? $_POST["id_hospitalizacion"] : null;
		print_r($_POST);

		$factura = $this->modelo->insertaFactura($fecha, $_POST["total"], $_POST["formasDePago"], $serviciosExtras, $id_paciente, $insumos, $cantidad, $_POST["montosDePago"], $referencia,  $id_cita, $id_hospitalizacion, $doctor);

		if ($factura) {
			//Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "factura", "Ha facturado servicios y/o insumos");

			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/comprobante/" . $factura[0]);
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/factura/errorSistem");
		}
	}




	public function mostrarPDF($parametro)
	{
		$datosFactura = $this->modelo->consultarFacturaSinCita($parametro[0]);
		$datosPago = $this->modelo->consultarPagoFactura($parametro[0]);
		$datosServiciosExtras = $this->modelo->consultarServiciosExtras($parametro[0]);
		$datosInsumos = $this->modelo->consultarFacturaInsumo($parametro[0]);

		require_once './src/vistas/vistaFactura/vistaFacturaPdf.php';
	}
	public function mostrarPDF2()
	{
		require_once './src/vistas/vistaFactura/vistaFacturaPdf2.php';
	}
	public function mostrarPDF3()
	{
		require_once './src/vistas/vistaFactura/vistaFacturaPdf3.php';
	}

	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}
}
