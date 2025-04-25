<?php
use App\modelos\ModeloReporte;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloInsumo;
use App\modelos\ModeloPermisos;
// use FPDF\FPDF; 	

class ControladorReportes{
		
	private $modelo;
	private $bitacora;
	private $insumo;
	private $permisos;

    function __construct()
    {
        $this->modelo = new ModeloReporte();
        $this->bitacora = new ModeloBitacora();
        $this->insumo = new ModeloInsumo();
		$this->permisos = new ModeloPermisos();
    }

	
	public function reportes($parametro){

		$facturas = $this->modelo->consultarFactura();
		$anuladas = $this->modelo->consultarFacturaAnuladas();
		$insumos = $this->insumo->insumos();
		require_once './src/vistas/vistaReportes/vistaReportes.php';
	}
	public function buscarPDF(){
		require_once './src/vistas/vistaReportes/vistaReporteCitasPdf.php';
	}

	public function buscarEntradasInsumosPDF(){
		require_once './src/vistas/vistaReportes/vistaReporteEntradasPdf.php';
	}
	public function factura() {
		// Verificar si se ha enviado el ID de cita
		if (isset($_GET["id_cita"]) && !empty($_GET["id_cita"])) {
			// Si se cumple la condición, requerir el primer archivo
			require_once './src/vistas/vistaReportes/vistaFacturaPdf2.php';
		} else {
			// Si no se cumple la condición, requerir el segundo archivo
			require_once './src/vistas/vistaReportes/vistaFacturaPdf.php';
		}
	}
	public function pacientePDF($datos){
		$pacientes = $this->modelo->pdfPaciente($datos[0]);
		require_once './src/vistas/vistaReportes/vistaPacientePDF.php';
	}
	public function insumosPDF(){
		require_once './src/vistas/vistaReportes/vistaInsumosPDF.php';
	}
	public function reportesFactura(){
		require_once './src/vistas/vistaReportes/vistaReporteFacturaPDF.php';
	}
	public function reportesFacturasAnuladas(){
		require_once './src/vistas/vistaReportes/vistaReporteFacturaAnuladas.php';
	}
	public function buscarPago($datos){
		$id_factura = $datos[0];
		$respuesta = $this->modelo->consultarPagoFactura($id_factura);

		echo json_encode($respuesta);
	}
	public function buscarMasServicios($datos){
		$id_factura = $datos[0];
		$respuesta = $this->modelo->consultarServiciosExtras($id_factura);

		echo json_encode($respuesta);
	}
	public function buscarInsumos($datos){

		$id_factura = $datos[0];
		$respuesta = $this->modelo->consultarFacturaInsumo($id_factura);

		echo json_encode($respuesta);
	}
	public function buscarCita(){

		$respuesta = $this->modelo->consultarcitafactura($_GET["id_factura"]);

		echo json_encode($respuesta);
	}
	public function anularFactura(){

	

		// $cadena = $_GET["id_insumo"];
		
		print_r($_POST);

		$respuesta = $this->modelo->insumosAnulados($_POST["id_factura"]);
	 	$eliminar = $this->modelo->anularFac($_POST["id_factura"]);
	
		foreach($respuesta as $res){
		$insumo = $this->modelo->cantidadAnulada($res["id_insumo"], $_POST["id_factura"], $res["numero_de_lote"]);
		}

		// Guardo la bitacora
		$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'],"factura","Ha anula una factura");
		
		// // $respuesta =$this->modelo->cantidadAnulada($array);
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Reportes/reportes/anulada");
		

	

	
	}

	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}
	

}


?>