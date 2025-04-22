<?php

use App\modelos\ModeloEntrada;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
class ControladorEntrada
{

	private $modelo;
	private $bitacora;
	private $permisos;

	function __construct()
	{
		$this->modelo = new ModeloEntrada();
		$this->bitacora = new ModeloBitacora();
		$this->permisos = new ModeloPermisos();
	}

	public function entrada($parametro)
	{
		$vistaActiva = 'activas';
		$insumos = $this->modelo->insumos();
		$proveedores = $this->modelo->selectProveedores();
		$entradas = $this->modelo->todasLasEntradas();
		require_once './src/vistas/vistaEntrada/vistaEntrada.php';
	}

	public function papelera($parametro){
		$desactivos = $this->modelo->seleccionarDesactivos();
		$insumos = $this->modelo->insumos();
		require_once './src/vistas/vistaEntrada/vistaEntradaDesactiva.php';
	}


	public function restablecerEntrada($datos)
	{
		$id_entrada =$datos[0];
		$id_usuario_bitacora =$datos[1];
		$this->modelo->restablecerEntrada($id_entrada);
		// Guardar la bitacora
		$this->bitacora->insertarBitacora($id_usuario_bitacora,"entrada","Ha restablecido una entrada");
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Entrada/papelera");
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
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'],"entrada","Ha insertado una entrada");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Entrada/entrada");

		
	}

	public function eliminar($datos){
		$id_entrada = $datos[0];
		$id_insumo= $datos[1];
		$id_usuario_bitacora =$datos[2]; 
		$this->modelo->eliminar($id_entrada,$id_insumo);
		// Guardar la bitacora
		$this->bitacora->insertarBitacora($id_usuario_bitacora,"entrada","Ha eliminado una entrada");
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Entrada/entrada");
	}

	public function editar(){
		print_r($_POST);
		$precio_sin_puntos = str_replace('.', '', $_POST['precio']);
		$this->modelo->actualizarEntrada($_POST["id_entrada"], $_POST["id_proveedor"], $_POST["fechaDeVencimiento"], $_POST["cantidad"], $precio_sin_puntos, $_POST["id_insumo"]);
		 // Guardar la bitacora
		$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'],"entrada","Ha modificado una entrada");

		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Entrada/entrada");

	}




	public function entradaInsumo(){
		$respuesta = $this->modelo->insumosEntrada($_GET['id_insumo']);
		echo json_encode($respuesta);
	}


	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}



}

?>
