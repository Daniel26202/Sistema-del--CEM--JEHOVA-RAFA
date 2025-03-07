<?php

use App\modelos\ModeloProveedores;
use App\modelos\ModeloBitacora;

class ControladorProveedores
{

	private $modelo;
	private $bitacora;

	function __construct()
	{
		$this->modelo = new ModeloProveedores();
		$this->bitacora = new ModeloBitacora();
	}

	public function proveedores()
	{
		$proveedor = $this->modelo->consultar();
		require_once './src/vistas/vistaProveedores/vistaProveedores.php';
	}


	public function papelera()
	{
		$proveedor = $this->modelo->papelera();
		require_once './src/vistas/vistaProveedores/vistaProveedoresPapelera.php';
	}

	public function insertar()
	{
		$resultadoDeRif = $this->modelo->validarRif($_POST['rif']);


		if ($resultadoDeRif === "existeC") {
			header("location:?c=ControladorProveedores/proveedores&error");
		} else {


			$this->modelo->agregar($_POST["nombre"], $_POST["rif"], $_POST["telefono"], $_POST["email"], $_POST["direccion"]);
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'],"proveedor","Ha insertado un proveedor");
			header("location:?c=ControladorProveedores/proveedores&agregado");
		}
	}

	// eliminación logica
	public function update()
	{
		if (isset($_GET["id_proveedor"])) {
			$this->modelo->update($_GET["id_proveedor"]);
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($_GET['id_usuario_bitacora'],"proveedor","Ha eliminado un proveedor");

			header("location:?c=ControladorProveedores/proveedores&eliminado");
		}
	}


	public function restablecerProveedor()
	{
		$this->modelo->restablecerProveedor($_GET["id_proveedor"]);
		// Guardar la bitacora
		$this->bitacora->insertarBitacora($_GET['id_usuario_bitacora'],"proveedor","Ha restablecido un proveedor");

		header("location: ?c=controladorProveedores/papelera&restablecido");
	}


	public function editar()
	{

		$resultadoDeCedula = $this->modelo->validarRif($_POST['rif']);

		// //se verifica si la cédula del input es igual a la cédula ya existente 
		if ($_GET["cedulaDb"] == $_POST["rif"]) {

			$this->modelo->editar($_POST["id_proveedor"], $_POST["nombre"], $_POST["rif"], $_POST["telefono"], $_POST["email"], $_POST["direccion"]);

			// Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'],"proveedor","Ha modificado un proveedor");


			header("location:?c=ControladorProveedores/proveedores&editado");

			// NOTA: Esto "&&" es "Y"
			//se verifica si la cédula del input no es igual a la cédula ya existente.  
		} elseif ($_GET["cedulaDb"] != $_POST["rif"]) {

			//verifica si la cédula es igual a la información de la base de datos.
			if ($resultadoDeCedula === "existeC") {
				header("location:?c=ControladorProveedores/proveedores&error");
			} else {

				$this->modelo->editar($_POST["id_proveedor"], $_POST["nombre"], $_POST["rif"], $_POST["telefono"], $_POST["email"], $_POST["direccion"]);
				// Guardar la bitacora
				$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'],"proveedor","Ha modificado un proveedor");
				header("location:?c=ControladorProveedores/proveedores&editado");
			}
		} else {

			$this->modelo->editar($_POST["id_proveedor"], $_POST["nombre"], $_POST["rif"], $_POST["telefono"], $_POST["email"], $_POST["direccion"]);
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'],"proveedor","Ha modificado un proveedor");
			header("location:?c=ControladorProveedores/proveedores&editado");
		}
	}
}
