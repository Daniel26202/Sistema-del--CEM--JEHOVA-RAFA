<?php
use App\modelos\ModeloReporte;
// use FPDF\FPDF; 	

class ControladorReportes{
		
	private $modelo;

    function __construct()
    {
        $this->modelo = new ModeloReporte();
    }

	
	public function reportes(){

		$facturas = $this->modelo->consultarFactura();
		$anuladas = $this->modelo->consultarFacturaAnuladas();
		require_once './src/vistas/vistaReportes/vistaReportes.php';
	}
	public function buscarPDF(){
		require_once './src/vistas/vistaReportes/vistaReporteCitasPdf.php';
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
	public function pacientePDF(){
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
	public function buscarPago(){

		$respuesta = $this->modelo->consultarPagoFactura($_GET["id_factura"]);

		echo json_encode($respuesta);
	}
	public function buscarMasServicios(){

		$respuesta = $this->modelo->consultarServiciosExtras($_GET["id_factura"]);

		echo json_encode($respuesta);
	}
	public function buscarInsumos(){

		$respuesta = $this->modelo->consultarFacturaInsumo($_GET["id_factura"]);

		echo json_encode($respuesta);
	}
	public function buscarCita(){

		$respuesta = $this->modelo->consultarcitafactura($_GET["id_factura"]);

		echo json_encode($respuesta);
	}
	public function anularFactura(){

	

		// $cadena = $_GET["id_insumo"];
		

	 $respuesta = $this->modelo->insumosAnulados($_POST["id_factura"]);
	 $eliminar = $this->modelo->anularFac($_POST["id_factura"]);
	
		foreach($respuesta as $res){
		$insumo = $this->modelo->cantidadAnulada($res["id_insumo"], $_POST["id_factura"]);
		}
		
		// $respuesta =$this->modelo->cantidadAnulada($array);
		header("location: ?c=ControladorReportes/reportes&anulada");
		

	

	
	}

	

}


 ?>