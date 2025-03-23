<?php

use App\modelos\ModeloInsumo;
use App\modelos\ModeloBitacora;

class ControladorInsumos
{

	private $modelo;
	private $bitacora;

	function __construct()
	{
		$this->modelo = new ModeloInsumo();
		$this->bitacora = new ModeloBitacora();
	}


	public function insumos($parametro){


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

	public function InsumosVencidos($parametro){
		$vencidos = $this->modelo->InsumosVencidos();
		$insumos = $this->modelo->insumos();
		require_once './src/vistas/vistaInsumos/vistaInsumosVencidos.php';
	}

	public function info($datos)
	{
		$id_insumo = $datos[0];
		$datosDeInsumo = $this->modelo->insumosInfo($id_insumo);
		$datosDeVencimiento =  $this->modelo->retornarFechaDeVencimiento($id_insumo);
		$informacion = array('insumo' => $datosDeInsumo, 'vencimiento' => $datosDeVencimiento);
		echo json_encode($informacion);
	}


	// public function cantidadInsumos()
	// {
	// 	$respuesta = $this->modelo->cantidadInsumos($_GET['id_insumo']);
	// 	echo json_encode($respuesta);
	// }



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

			// Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'],"insumo","Ha Insertado un insumo");

			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Insumos/insumos/agregado");
		}
	}

	public function eliminar($datos)
	{
		$id_insumo = $datos[0];
		$id_usuario_bitacora = $datos[1];
		$this->modelo->eliminar($id_insumo);
		// Guardar la bitacora
		$this->bitacora->insertarBitacora($id_usuario_bitacora ,"insumo","Ha eliminado un insumo");
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Insumos/insumos/eliminado");
	}

	public function editar()
	{
		print_r($_POST);

		$this->modelo->editar($_POST["Codigo"], $_POST["nombre"], $_POST['descripcion'], $_POST["stockMinimo"], $_FILES["imagen"]);
		// Guardar la bitacora
		$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'],"insumo","Ha modificado un insumo");
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Insumos/insumos/editado");
	}


	public function papelera()
	{
		$desactivos = $this->modelo->papelera();
		require_once './src/vistas/vistaInsumos/insumosPapelera.php';
	}

	public function restablecerInsumo($datos)
	{
		$id_insumo = $datos[0];
		$id_usuario_bitacora = $datos[1];
		$this->modelo->restablecerInsumo($id_insumo);
		// Guardar la bitacora
		$this->bitacora->insertarBitacora($id_usuario_bitacora,"insumo","Ha restablecido un insumo");
		print_r($_GET);
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Insumos/papelera");
	}



}
