<?php

use App\modelos\ModeloEntrada;
class ControladorEntrada
{

	private $modelo;

	function __construct()
	{
		$this->modelo = new ModeloEntrada();
	}

	public function entrada()
	{
		
		$insumos = $this->modelo->insumos();
		$proveedores = $this->modelo->selectProveedores();
		$entradas = $this->modelo->todasLasEntradas();
		require_once './src/vistas/vistaEntrada/vistaEntrada.php';
	}

	public function papelera(){
		$desactivos = $this->modelo->seleccionarDesactivos();
		$insumos = $this->modelo->insumos();
		require_once './src/vistas/vistaEntrada/vistaEntradaDesactiva.php';
	}


	public function restablecerEntrada()
	{
		$this->modelo->restablecerEntrada($_GET['id_entrada']);
		header("location: ?c=controladorEntrada/papelera");
	}


	

	

	public function proveedoresEditar(){
		$respuesta = $this->modelo->selectProveedores();
		echo json_encode($respuesta);
	}



	public function guardar()
	{
			print_r($_POST);
			$precio_sin_puntos = str_replace('.', '', $_POST['precio']);
			$this->modelo->insertarEntrada($_POST["id_proveedor"], $_POST["id_insumo"], $_POST["fechaDeIngreso"], $_POST["fechaDeVencimiento"], $_POST["cantidad"],$precio_sin_puntos, $_POST["lote"]);
			header("location: ?c=controladorEntrada/entrada");

		
	}

	public function eliminar(){
		$this->modelo->eliminar($_GET["id_entrada"],$_GET["id_insumo"]);
		header("location: ?c=controladorEntrada/entrada");
	}

	public function editar(){
		print_r($_POST);
		$precio_sin_puntos = str_replace('.', '', $_POST['precio']);
		 $this->modelo->actualizarEntrada($_POST["id_entrada"], $_POST["id_proveedor"], $_POST["fechaDeVencimiento"], $_POST["cantidad"], $precio_sin_puntos, $_POST["id_insumo"]);
		 header("location: ?c=controladorEntrada/entrada");

	}




	public function entradaInsumo(){
		$respuesta = $this->modelo->insumosEntrada($_GET['id_insumo']);
		echo json_encode($respuesta);
	}



}

?>
