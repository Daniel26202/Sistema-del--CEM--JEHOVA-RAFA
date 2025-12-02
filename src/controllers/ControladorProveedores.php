<?php

use App\modelos\ModeloProveedores;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;

class ControladorProveedores
{

	private $modelo;
	private $bitacora;
	private $permisos;

	function __construct()
	{
		$this->modelo = new ModeloProveedores();
		$this->bitacora = new ModeloBitacora();
		$this->permisos = new ModeloPermisos();
	}

	public function proveedores($parametro)
	{
		$ayuda = "btnayudaProveedor";
		$vistaActiva = "proveedores";
		require_once './src/vistas/vistaProveedores/vistaProveedores.php';
	}

	public function proveedoresAjax() {
		echo json_encode($this->modelo->consultar());
	}

	public function papelera($parametro)
	{
		require_once './src/vistas/vistaProveedores/vistaProveedoresPapelera.php';
	}

	public function proveedoresPapeleraAjax()
	{
		echo json_encode($this->modelo->papeleraConsultar());
	}

	public function insertar()
	{

		$insercion = $this->modelo->agregar($_POST["nombre"], $_POST["rif"], $_POST["telefono"], $_POST["email"], $_POST["direccion"]);

		if (is_array($insercion) && $insercion[0] === "exito") {
			$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "proveedor", "Ha insertado un proveedor");

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $insercion]);
			exit;
		}

	}

	// eliminación logica
	public function update($datos)
	{
		$id_proveedor = $datos[0];
		$id_usuario_bitacora = $datos[1];

		$eliminacion = $this->modelo->update($id_proveedor);

		if (is_array($eliminacion) && $eliminacion[0] === "exito") {
			$this->bitacora->insertarBitacora($id_usuario_bitacora, "proveedor", "Ha eliminado un proveedor");

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $eliminacion]);
			exit;
		}
	}


	public function restablecerProveedor($datos)
	{
		$id_proveedor = $datos[0];
		$id_usuario_bitacora = $datos[1];
		
		$restablecimiento = $this->modelo->restablecerProveedor($id_proveedor);

		if (is_array($restablecimiento) && $restablecimiento[0] === "exito") {
			$this->bitacora->insertarBitacora($id_usuario_bitacora, "proveedor", "Ha restablecido un proveedor");

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $restablecimiento]);
			exit;
		}
	}


	public function editar()
	{
			$editado = $this->modelo->editar($_POST["id_proveedor"], $_POST["nombre"], $_POST["rif"], $_POST["telefono"], $_POST["email"], $_POST["direccion"], $_POST["rifRegistrado"]);


		if (is_array($editado) && $editado[0] === "exito") {
			$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "proveedor", "Ha modificado un proveedor");

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $editado]);
			exit;
		}
		
	}


	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}
}
