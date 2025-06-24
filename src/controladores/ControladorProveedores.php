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
		$proveedor = $this->modelo->consultar();
		require_once './src/vistas/vistaProveedores/vistaProveedores.php';
	}


	public function papelera($parametro)
	{
		$proveedor = $this->modelo->papelera();
		require_once './src/vistas/vistaProveedores/vistaProveedoresPapelera.php';
	}

	public function insertar()
	{
		$resultadoDeRif = $this->modelo->validarRif($_POST['rif']);

		if ($resultadoDeRif === "existeC") {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Proveedores/proveedores/errorRif");
		} else {
			$insercion = $this->modelo->agregar($_POST["nombre"], $_POST["rif"], $_POST["telefono"], $_POST["email"], $_POST["direccion"]);
			if ($insercion) {
				// Guardar la bitacora
				$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "proveedor", "Ha insertado un proveedor");
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Proveedores/proveedores/registro");
			} else {
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Proveedores/proveedores/errorSistem");
			}
		}
	}

	// eliminación logica
	public function update($datos)
	{
		$id_proveedor = $datos[0];
		$id_usuario_bitacora = $datos[1];

		$eliminacion = $this->modelo->update($id_proveedor);

		if ($eliminacion) {
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($id_usuario_bitacora, "proveedor", "Ha eliminado un proveedor");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Proveedores/proveedores/eliminar");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Proveedores/proveedores/errorSistem");
		}
	}


	public function restablecerProveedor($datos)
	{
		$id_proveedor = $datos[0];
		$id_usuario_bitacora = $datos[1];
		$this->modelo->restablecerProveedor($id_proveedor);
		// Guardar la bitacora
		$this->bitacora->insertarBitacora($id_usuario_bitacora, "proveedor", "Ha restablecido un proveedor");

		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Proveedores/papelera/restablecido");
	}


	public function editar($datos)
	{
		$cedula = $datos[0];

		$resultadoDeCedula = $this->modelo->validarRif($_POST['rif']);

		// //se verifica si la cédula del input es igual a la cédula ya existente 
		if ($cedula == $_POST["rif"]) {

			$this->modelo->editar($_POST["id_proveedor"], $_POST["nombre"], $_POST["rif"], $_POST["telefono"], $_POST["email"], $_POST["direccion"]);

			// Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "proveedor", "Ha modificado un proveedor");


			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Proveedores/proveedores/editar");

			// NOTA: Esto "&&" es "Y"
			//se verifica si la cédula del input no es igual a la cédula ya existente.  
		} elseif ($cedula != $_POST["rif"]) {

			//verifica si la cédula es igual a la información de la base de datos.
			if ($resultadoDeCedula === "existeC") {

				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Proveedores/proveedores/errorRif");
			} else {

				$this->modelo->editar($_POST["id_proveedor"], $_POST["nombre"], $_POST["rif"], $_POST["telefono"], $_POST["email"], $_POST["direccion"]);
				// Guardar la bitacora
				$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "proveedor", "Ha modificado un proveedor");
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Proveedores/proveedores/editar");
			}
		} else {

			$this->modelo->editar($_POST["id_proveedor"], $_POST["nombre"], $_POST["rif"], $_POST["telefono"], $_POST["email"], $_POST["direccion"]);
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "proveedor", "Ha modificado un proveedor");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Proveedores/proveedores/editar");
		}
	}


	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}
}
