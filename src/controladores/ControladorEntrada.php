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
		$ayuda = "btnayudaEntrada";
		$vistaActiva = "entradas";
		$insumos = $this->modelo->insumos();
		$proveedores = $this->modelo->selectProveedores();
		$entradas = $this->modelo->todasLasEntradas();
		require_once './src/vistas/vistaEntrada/vistaEntrada.php';
	}

	public function papelera($parametro)
	{
		$desactivos = $this->modelo->seleccionarDesactivos();
		$insumos = $this->modelo->insumos();
		require_once './src/vistas/vistaEntrada/vistaEntradaDesactiva.php';
	}


	public function restablecerEntrada($datos)
	{
		$id_entrada = $datos[0];
		$id_usuario_bitacora = $datos[1];
		$restablecimiento = $this->modelo->restablecerEntrada($id_entrada);
		if ($restablecimiento) {
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($id_usuario_bitacora, "entrada", "Ha restablecido una entrada");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Entrada/papelera/restablecido");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Entrada/papelera/errorSistem");
		}
	}

	public function proveedoresEditar()
	{
		$respuesta = $this->modelo->selectProveedores();
		echo json_encode($respuesta);
	}



	public function guardar()
	{
		$precio_sin_puntos = str_replace('.', '', $_POST['precio']);
		$insercion = $this->modelo->insertarEntrada($_POST["id_proveedor"], $_POST["id_insumo"], $_POST["fechaDeIngreso"], $_POST["fechaDeVencimiento"], $_POST["cantidad"], $precio_sin_puntos, $_POST["lote"]);
		if ($insercion) {
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "entrada", "Ha insertado una entrada");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Entrada/entrada/registro");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Entrada/entrada/errorSistem");
		}
	}

	public function eliminar($datos)
	{
		$id_entrada = $datos[0];
		$id_insumo = $datos[1];
		$id_usuario_bitacora = $datos[2];
		$elimincion = $this->modelo->eliminar($id_entrada, $id_insumo);
		if ($elimincion) {
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($id_usuario_bitacora, "entrada", "Ha eliminado una entrada");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Entrada/entrada/eliminar");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Entrada/entrada/errorSistem");
		}
	}

	public function editar()
	{
		$precio_sin_puntos = str_replace('.', '', $_POST['precio']);
		$edicion = $this->modelo->actualizarEntrada($_POST["id_entrada"], $_POST["id_proveedor"], $_POST["fechaDeVencimiento"], $_POST["cantidad"], $precio_sin_puntos, $_POST["id_insumo"]);

		if ($edicion) {
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "entrada", "Ha modificado una entrada");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Entrada/entrada/editar");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Entrada/entrada/errorSistem");
		}
	}

	public function entradaInsumo()
	{
		$respuesta = $this->modelo->insumosEntrada($_GET['id_insumo']);
		echo json_encode($respuesta);
	}

	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}
}
