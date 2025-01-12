<?php
use App\modelos\ModeloServiciosExtras;
class ControladorServiciosExtras
{

	private $modelo;

	function __construct()
	{
		$this->modelo = new ModeloServiciosExtras;
	}
	public function serviciosExtras()
	{

		$extras = $this->modelo->getServiciosExtras();
		$doctores = $this->modelo->getDoctores();


		require_once './src/vistas/vistaServiciosExtras/vistaServiciosExtras.php';
	}
	public function guardar()
	{
		$this->modelo->insertar($_POST['nombre'], $_POST['precio'], $_POST['id_doctor']);
		header("location: ?c=ControladorServiciosExtras/serviciosExtras&agregado");
	}



	public function editar()
	{
		$this->modelo->update($_GET['id_servicioExtra'], $_POST['nombreEditar'], $_POST['precioEditar'], $_POST['id_doctor']);
		header("location: ?c=ControladorServiciosExtras/serviciosExtras&editado");

	}

	public function eliminar()
	{

		$this->modelo->delete($_GET['id_servicioExtra']);
		header("location: ?c=ControladorServiciosExtras/serviciosExtras&eliminado");

	}
	public function buscarSA(){
		$respuesta = $this->modelo->ServAdiBuscar($_POST['nombre']);
	
		echo json_encode($respuesta);
	}

}

?>