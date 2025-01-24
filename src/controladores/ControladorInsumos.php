<?php

use App\modelos\ModeloInsumo;

class ControladorInsumos
{

	private $modelo;

	function __construct()
	{
		$this->modelo = new ModeloInsumo();
	}


	public function insumos(){


		$proveedores = $this->modelo->selectProveedores();
		$insumos = $this->modelo->insumos();

		if ($insumos) {
			$this->modelo->vencerInsumos(date("Y-m-d"));
			//$this->modelo->insumoProximos();
		} 
		require_once './src/vistas/vistaInsumos/insumos.php';
	}

	public function retornarLasEntradas()
	{
		$respuesta = $this->modelo->todasLasEntradas();
		echo json_encode($respuesta);
	}

	public function InsumosVencidos(){
		$vencidos = $this->modelo->InsumosVencidos();
		$insumos = $this->modelo->insumos();
		require_once './src/vistas/vistaInsumos/vistaInsumosVencidos.php';
	}

	public function info()
	{
		$datosDeInsumo = $this->modelo->insumosInfo($_GET['id_insumo']);
		$datosDeVencimiento =  $this->modelo->retornarFechaDeVencimiento($_GET['id_insumo']);
		$informacion = array('insumo' => $datosDeInsumo, 'vencimiento' => $datosDeVencimiento);
		echo json_encode($informacion);
	}


	public function cantidadInsumos()
	{
		$respuesta = $this->modelo->cantidadInsumos($_GET['id_insumo']);
		echo json_encode($respuesta);
	}



	public function mostrarBusquedaInsumo()
	{
		$respuesta = $this->modelo->buscarInsumos($_POST['nombre']);
		// $respuesta = array('nombre' => "Dixon");
		echo json_encode($respuesta);
	}

	public function guardarInsumo()
	{
		if (isset($_POST)) {
			$precio_sin_puntos = str_replace('.', '', $_POST['precio']);
			$this->modelo->insertarInsumos($_POST["nombre"], $_POST["id_proveedor"], $_POST["descripcion"], $_POST["fecha_de_ingreso"], $_POST["fecha_de_vencimiento"], $precio_sin_puntos, $_POST["cantidad"], $_POST["stockMinimo"], 'ACT', $_POST["lote"]);
			header("location: ?c=controladorInsumos/insumos&agregado");
		}
	}

	public function eliminar()
	{
		$this->modelo->eliminar($_GET["id_insumo"]);
		header("location: ?c=controladorInsumos/insumos&eliminado");
	}

	public function editar()
	{
		print_r($_POST);

		$this->modelo->editar($_POST["Codigo"], $_POST["nombre"], $_POST['descripcion'], $_POST["stockMinimo"], $_FILES["imagen"]);
		header("location: ?c=controladorInsumos/insumos&editado");
	}


	public function papelera()
	{
		$desactivos = $this->modelo->papelera();
		require_once './src/vistas/vistaInsumos/insumosPapelera.php';
	}

	public function restablecerInsumo()
	{
		$this->modelo->restablecerInsumo($_GET['id_insumo']);
		print_r($_GET);
		header("location: ?c=controladorInsumos/papelera");
	}



}
