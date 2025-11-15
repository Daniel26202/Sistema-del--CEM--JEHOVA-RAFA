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
		$ayuda = "btnayudaInsumo";
		$vistaActiva = "insumos";
		$proveedores = $this->modelo->selectProveedores();
		$insumos = $this->modelo->insumos();
		if ($insumos) {
			$this->modelo->vencerInsumos(date("Y-m-d"));
			//$this->modelo->insumoProximos();
		}
		require_once './src/vistas/vistaInsumos/vistaInsumos.php';
	}

	public function insumosAjax()
	{
		echo json_encode($this->modelo->insumos());
	}


	public function InsumosVencidos($parametro)
	{
		$ayuda = "btnayudaVencido";
		$vistaActiva = "vencidos";
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

			$iva = isset($_POST["iva"]) && $_POST["iva"] == 1 ? 1 : 0;

			if ($iva === 1) {
				$precio_decimal += $precio_decimal * 0.30;
			}

			$insercion = $this->modelo->insertarInsumos($_POST["nombre"], $_POST["id_proveedor"], $_POST["descripcion"], $_POST["fecha_de_ingreso"], $_POST["fecha_de_vencimiento"], $precio_decimal, $_POST["cantidad"], $_POST["stockMinimo"], 'ACT', $_POST["lote"], $_POST["marca"], $_POST["medida"],$iva);

			if (is_array($insercion) && $insercion[0] === "exito") {
				$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "insumo", "Ha Insertado un insumo");

				echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
			} else {
				http_response_code(409);
				echo json_encode(['ok' => false, 'error' => $insercion]);
				exit;
			}
		}
	}

	public function eliminar($datos)
	{
		$id_insumo = $datos[0];
		$id_usuario_bitacora = $datos[1];
		$eliminacion = $this->modelo->eliminar($id_insumo);

		if (is_array($eliminacion) && $eliminacion[0] === "exito") {
			$this->bitacora->insertarBitacora($id_usuario_bitacora, "insumo", "Ha eliminado un insumo");

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $eliminacion]);
			exit;
		}
	}

	public function editar()
	{
		$edicion = $this->modelo->editar($_POST["Codigo"], $_POST["nombre"], $_POST['descripcion'], $_POST["stockMinimo"], $_FILES["imagen"], $_POST["marca"], $_POST["medida"]);


		if (is_array($edicion) && $edicion[0] === "exito") {
			$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "insumo", "Ha modificado un insumo");

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $edicion]);
			exit;
		}
	}


	public function papelera($parametro)
	{
		require_once './src/vistas/vistaInsumos/insumosPapelera.php';
	}

	public function papeleraInsumosAjax()
	{
		echo json_encode($this->modelo->papelera());
	}

	public function restablecerInsumo($datos)
	{
		$id_insumo = $datos[0];
		$id_usuario_bitacora = $datos[1];
		$restablecimiento = $this->modelo->restablecerInsumo($id_insumo);


		if (is_array($restablecimiento) && $restablecimiento[0] === "exito") {
			$this->bitacora->insertarBitacora($id_usuario_bitacora, "insumo", "Ha restablecido un insumo");

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $restablecimiento]);
			exit;
		}
	}

	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}
}
