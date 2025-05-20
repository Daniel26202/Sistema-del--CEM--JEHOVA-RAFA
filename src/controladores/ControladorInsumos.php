<?php

use App\modelos\ModeloInsumo;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;

class ControladorInsumos
{

	private $modelo;
	private $bitacora;
	private $permisos;

	function __construct()
	{
		$this->modelo = new ModeloInsumo();
		$this->bitacora = new ModeloBitacora();
		$this->permisos = new ModeloPermisos();
	}

	public function insumos($parametro)
	{
		$proveedores = $this->modelo->selectProveedores();
		$insumos = $this->modelo->insumos();
		if ($insumos) {
			$this->modelo->vencerInsumos(date("Y-m-d"));
			//$this->modelo->insumoProximos();
		}
		require_once './src/vistas/vistaInsumos/vistaInsumos.php';
	}

	public function retornarLasEntradas()
	{
		$respuesta = $this->modelo->todasLasEntradas();
		echo json_encode($respuesta);
	}

	public function InsumosVencidos($parametro)
	{
		$vencidos = $this->modelo->InsumosVencidos();
		$insumos = $this->modelo->insumos();
		require_once './src/vistas/vistaInsumos/vistaInsumosVencidos.php';
	}

	public function info($datos)
	{
		$id_insumo = $datos[0];
		$datosDeInsumo = $this->modelo->insumosInfo($id_insumo);
		$datosDeVencimiento =  $this->modelo->retornarFechaDeVencimiento($id_insumo);
		$informacion = array('insumo' => $datosDeInsumo, 'vencimiento' => $datosDeVencimiento, 'dolar' => $_SESSION["dolar"]);
		echo json_encode($informacion);
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
			$precio_decimal = floatval($_POST['precioD']);
			$insercion = $this->modelo->insertarInsumos($_POST["nombre"], $_POST["id_proveedor"], $_POST["descripcion"], $_POST["fecha_de_ingreso"], $_POST["fecha_de_vencimiento"], $precio_decimal, $_POST["cantidad"], $_POST["stockMinimo"], 'ACT', $_POST["lote"], $_POST["marca"], $_POST["medida"]);
			if ($insercion) {
				// Guardar la bitacora
				$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "insumo", "Ha Insertado un insumo");
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Insumos/insumos/agregado");
			} else {
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Insumos/insumos/errorSistem");
			}
		}
	}

	public function eliminar($datos)
	{
		$id_insumo = $datos[0];
		$id_usuario_bitacora = $datos[1];
		$eliminacion = $this->modelo->eliminar($id_insumo);
		if ($eliminacion) {
			$this->bitacora->insertarBitacora($id_usuario_bitacora, "insumo", "Ha eliminado un insumo");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Insumos/insumos/eliminado");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Insumos/insumos/errorSistem");
		}
	}

	public function editar()
	{
		$edicion = $this->modelo->editar($_POST["Codigo"], $_POST["nombre"], $_POST['descripcion'], $_POST["stockMinimo"], $_FILES["imagen"], $_POST["marca"], $_POST["medida"]);
		if ($edicion) {
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "insumo", "Ha modificado un insumo");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Insumos/insumos/editado");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Insumos/insumos/errorSistem");
		}
	}


	public function papelera($parametro)
	{
		$desactivos = $this->modelo->papelera();
		require_once './src/vistas/vistaInsumos/insumosPapelera.php';
	}

	public function restablecerInsumo($datos)
	{
		$id_insumo = $datos[0];
		$id_usuario_bitacora = $datos[1];
		$restablecimiento = $this->modelo->restablecerInsumo($id_insumo);

		if ($restablecimiento) {
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($id_usuario_bitacora, "insumo", "Ha restablecido un insumo");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Insumos/papelera");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Insumos/papelera/errorSistem");
		}
	}

	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}
}
