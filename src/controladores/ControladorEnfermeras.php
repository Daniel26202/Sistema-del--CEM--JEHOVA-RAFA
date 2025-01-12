<?php

use App\modelos\ModeloEnfermeras;

class ControladorEnfermeras
{

	private $modelo;

	function __construct()
	{
		$this->modelo = new ModeloEnfermeras();
	}

	public function enfermeras()
	{
		$enfermera = $this->modelo->consultar();
		require_once './src/vistas/vistaEnfermeras/vistaEnfermeras.php';
	}

	public function insertar()
	{

		$this->modelo->agregar($_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["fechaNacimiento"], $_POST["telefono"], $_POST["correo"], $_POST["turno"]);
		header("location:?c=ControladorEnfermeras/enfermeras&agregado");
	}

	// eliminación logica
	public function update()
	{
		if (isset($_GET["id_enfermeras"])) {
			$this->modelo->update($_GET["id_enfermeras"]);
			header("location:?c=ControladorEnfermeras/enfermeras&eliminado");
		}
	}

	public function editar()
	{
		if (isset($_POST["editar"])) {
			$this->modelo->editar($_POST["id_enfermeras"], $_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["fechaNacimiento"], $_POST["telefono"], $_POST["correo"], $_POST["turno"]);
			header("location:?c=ControladorEnfermeras/enfermeras&editado");
		}
	}
}
