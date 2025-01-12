<?php
//requiero el modelo de factura
use App\modelos\ModeloFactura;
use App\modelos\ModeloCategoria;

class ControladorFactura
{

	private $modelo; //atributo privado
	private $categoria;

	//le damos el valor de el  modelo a el atributo $modelo
	function __construct()
	{
		$this->modelo = new ModeloFactura();
	}

	//metodo para mostrar la vista de facturacion
	public function facturaInicio()
	{
		//aqui instacio y uso el metodo para mostrar los tipos de pago

		$tiposDePagos = $this->modelo->mostrarTiposDePagos();

		$extras = $this->modelo->mostrarServicioExtra();

		$insumos = $this->modelo->mostrarInsumos();

		require_once './src/vistas/vistaFactura/vistaFactura.php';
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
	public function mostrarPacienteConCita(){
		date_default_timezone_set('America/Mexico_City');

		$fecha = date("Y-m-d");
		$respuesta = $this->modelo->buscarPacientePorCita($_POST["cedula"], $fecha);
		echo json_encode($respuesta);
	}

	public function mostrarTodosLosServicios()
	{
		//$respuesta = array('id' => $_GET["id"]);
		$respuesta = $this->modelo->buscarServicioExtra($_POST["nombre"]);

		echo json_encode($respuesta);
	}

	public function mostrarTodosLosDoctores()
	{
		//$respuesta = array('id' => $_GET["id"]);
		$respuesta = $this->modelo->mostrarDoctores($_GET["id"]);

		echo json_encode($respuesta);
	}

	public function mostrarPrecio()
	{
		$respuesta = $this->modelo->mostrarPrecioDoctores($_GET["idD"], $_GET["id"]);
		// $respuesta = array('id' => $_GET["id"],'idD' => $_GET["idD"]);
		echo json_encode($respuesta);
	}

	public function mostrarNombreTodosDoctores()
	{
		$respuesta = $this->modelo->mostrarNombreDoctores($_GET["id_doctor"]);
		echo json_encode($respuesta);
	}

	public function nombreSegunIdC()
	{
		$respuesta = $this->modelo->seleccionarIdConsulta($_GET["nombreC"], $_GET["nombreD"]);
		echo json_encode($respuesta);
	}

	public function nombreSegunIdD()
	{
		$respuesta = $this->modelo->seleccionarIdDoctor($_GET["nombreD"]);
		echo json_encode($respuesta);
	}

	//insumos
	public function insumosAjax()
	{
		$respuesta = $this->modelo->mostrarInsumos($_GET["id_insumo"]);
		echo json_encode($respuesta);
	}

	//metodo para guaradar Factura
	public function guardarFactura()
	{
		$fecha = date("Y-m-d");
		$serviciosExtras = isset($_POST["servicios"]) ? $_POST["servicios"] : false;
		$insumos = isset($_POST["insumos"]) ? $_POST["insumos"] : false;
		$cantidad = isset($_POST["cantidad"]) ? $_POST["cantidad"] : false;
		$id_cita = isset($_POST["id_cita"]) ? $_POST["id_cita"] : null;
		$id_paciente = isset($_POST["id_paciente"]) ? $_POST["id_paciente"] : null;
		$referencia = isset($_POST["referencia"]) ? $_POST["referencia"] : null;
		print_r($serviciosExtras);

		$this->modelo->insertaFactura($id_cita, $fecha, $_POST["total"], $_POST["formasDePago"], $serviciosExtras, $id_paciente, $insumos, $cantidad, $_POST["montosDePago"], $referencia);

		


		// echo $fecha."<br><br>";
// print_r($serviciosExtras)."<br><br>";

		// echo "id_cita".$id_cita."<br><br>";
// echo "paciente".$id_paciente."<br><br>";
// echo $_POST["total"]."<br><br>";
// print_r($_POST["formasDePago"])."<br><br>";	

	}


	public function guardarFacturaHospit(){
		$fecha = date("Y-m-d");
		$insumos = isset($_POST["insumosHospi"]) ? $_POST["insumosHospi"] : false;
		$cantidad = isset($_POST["cantidadInsumosHospi"]) ? $_POST["cantidadInsumosHospi"] : false;
		$idH = isset($_POST["id_hospitalizacion"]) ? $_POST["id_hospitalizacion"] : false;
		$referencia = isset($_POST["referencia"]) ? $_POST["referencia"] : null;
		$serviciosExtras = isset($_POST["servicios"]) ? $_POST["servicios"] : false;
	

		$this->modelo->insertaFacturaHospit($idH, $fecha, $_POST["total"], $_POST["formasDePago"],  $insumos, $cantidad, $_POST["montosDePago"], $referencia,$serviciosExtras);

		
	}

	public function mostrarPDF()
	{
		
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


}
