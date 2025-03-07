<?php

use App\modelos\ModeloCategoria;
use App\modelos\ModeloConsultas;
use App\modelos\ModeloBitacora;

class ControladorConsultas
{
	private $modelo;
	private $categoria;
	private $bitacora;

	function __construct()
	{
		$this->modelo = new ModeloConsultas;
		$this->categoria = new ModeloCategoria();
		$this->bitacora = new ModeloBitacora();
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
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario'],"servicioMedico","Ha Insertado un nuevo  servicio medico");
			header("location: ?c=ControladorConsultas/consultas&agregado");

        }

	}

	public function eliminar()
	{
		$this->modelo->eliminar($_GET["id_servicioMedico"]);
		// Guardar la bitacora
		$this->bitacora->insertarBitacora($_GET['id_usuario'],"servicioMedico","Ha eliminado un   servicio medico");
		header("location: ?c=ControladorConsultas/consultas&eliminado");
	}

	public function restablecer()
	{
		$this->modelo->restablecerServ($_GET["id_servicioMedico"]);
		// Guardar la bitacora
		$this->bitacora->insertarBitacora($_GET['id_usuario'],"servicioMedico","Ha restablecido un servicio medico");
		header("location: ?c=ControladorConsultas/consultas&restablecido");
	}


	public function editar()
	{

		$precio_sin_puntos = str_replace('.', '', $_POST['precioEditar']);
		$this->modelo->editar($_POST["id_servicioMedico"], $_POST["id_doctor"], $precio_sin_puntos);
		// Guardar la bitacora
		$this->bitacora->insertarBitacora($_POST['id_usuario'],"servicioMedico","Ha modificadp un servicio medico");
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
		// Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario'],"categoria_servicio","Ha Insertado una nueva  categoria");
		header("location: ?c=ControladorConsultas/consultas&agregado");
	}
	public function eliminarCategoria(){
		$this->categoria->eliminarCategoria($_GET["id_categoria"]);
		// Guardar la bitacora
			$this->bitacora->insertarBitacora($_GET['id_usuario'],"categoria_servicio","Ha eliminado una  categoria");
		header("location: ?c=ControladorConsultas/consultas&agregado");
	}

}
