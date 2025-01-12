<?php

use App\modelos\ModeloCategoria;
use App\modelos\ModeloConsultas;

class ControladorConsultas
{
	private $modelo;
	private $categoria;

	function __construct()
	{
		$this->modelo = new ModeloConsultas;
		$this->categoria = new ModeloCategoria();
	}
	public function consultas()
	{

		$doctores = $this->modelo->mostrarDoctores();
		$servicios = $this->modelo->mostrarConsultas();	 
		$categorias = $this->categoria->seleccionarCategoria();
		$todasLasCategorias = $this->categoria->seleccionarTodasLasCategoria();



		require_once './src/vistas/vistaConsultas/vistaConsultas.php';
	}
	public function papeleraServicio()
	{

		$doctores = $this->modelo->mostrarDoctores();
		$servicios = $this->modelo->mostrarConsultasDes();	 
		$categorias = $this->categoria->seleccionarCategoria();



		require_once './src/vistas/vistaConsultas/vistaConsultasPapelera.php';
	}

	public function guardar()
	{

		
$resultaServicio = $this->modelo->nombreConsulta($_POST['id_categoria'], $_POST['id_doctor']);

		
		if ($resultaServicio === "existeC") {
			header("location:?c=ControladorConsultas/consultas&error");

        } else {
          
            $precio_sin_puntos = str_replace('.', '', $_POST['precio']);

			$this->modelo->insertar($_POST['id_categoria'], $_POST['id_doctor'], $precio_sin_puntos);
			header("location: ?c=ControladorConsultas/consultas&agregado");

        }

	}

	public function eliminar()
	{
		$this->modelo->eliminar($_GET["id_servicioMedico"]);
		header("location: ?c=ControladorConsultas/consultas&eliminado");
	}
	public function restablecer()
	{
		$this->modelo->restablecerServ($_GET["id_servicioMedico"]);
		header("location: ?c=ControladorConsultas/consultas&restablecido");
	}


	public function editar()
	{

		$precio_sin_puntos = str_replace('.', '', $_POST['precioEditar']);
		$this->modelo->editar($_POST["id_servicioMedico"], $_POST["id_doctor"], $precio_sin_puntos);
		header("location: ?c=ControladorConsultas/consultas&editado");
	}


	// public function mostrarConsultasB()
	// {
	// 	$doctores = $this->modelo->mostrarDoctores();
	// 	$servicios = $this->modelo->buscar($_POST["busqueda"]);
	// 	require_once './src/vistas/vistaConsultas/vistaConsultaB.php';
	// }

	public function mostrarEspecialidad()
	{
		$respuesta = $this->modelo->especialidadDoctor($_GET["id_doctor"]);
		echo json_encode($respuesta);
	}
	

	public function registrarCategoria(){
		$this->categoria->registrarCategoria($_POST["nombre"]);
		header("location: ?c=ControladorConsultas/consultas&agregado");
	}
	public function eliminarCategoria(){
		$this->categoria->eliminarCategoria($_GET["id_categoria"]);
		header("location: ?c=ControladorConsultas/consultas&agregado");
	}

}
