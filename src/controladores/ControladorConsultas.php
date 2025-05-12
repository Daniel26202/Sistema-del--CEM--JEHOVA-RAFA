<?php

use App\modelos\ModeloCategoria;
use App\modelos\ModeloConsultas;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;

class ControladorConsultas
{
	private $modelo;
	private $categoria;
	private $bitacora;
	private $permisos;

	function __construct()
	{
		$this->modelo = new ModeloConsultas;
		$this->categoria = new ModeloCategoria();
		$this->bitacora = new ModeloBitacora();
		$this->permisos = new ModeloPermisos();
	}
	public function consultas($parametro)
	{

		$doctores = $this->modelo->mostrarDoctores();
		$servicios = $this->modelo->mostrarConsultas();
		$categorias = $this->categoria->seleccionarCategoria();
		$todasLasCategorias = $this->categoria->seleccionarTodasLasCategoria();



		require_once './src/vistas/vistaConsultas/vistaServiciosMedicos.php';
	}
	public function papeleraServicio($parametro)
	{

		$doctores = $this->modelo->mostrarDoctores();
		$servicios = $this->modelo->mostrarConsultasDes();
		$categorias = $this->categoria->seleccionarCategoria();



		require_once './src/vistas/vistaConsultas/vistaServiciosPapelera.php';
	}

	public function guardar()
	{
		$precio_decimal = floatval($_POST['precioD']);


		$resultaServicio = $this->modelo->nombreConsulta($_POST['id_categoria'], $_POST['id_doctor']);


		if ($resultaServicio === "existeC") {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/error");

		} else {



			$this->modelo->insertarSevicio($_POST['id_categoria'],  $precio_decimal);
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario'], "servicioMedico", "Ha Insertado un nuevo  servicio medico");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/agregado");

		}

	}

	public function eliminar($datos)
	{
		$id_servicioMedico = $datos[0];
		$id_usuario = $datos[1];
		$this->modelo->eliminar($id_servicioMedico);
		// Guardar la bitacora
		$this->bitacora->insertarBitacora($id_usuario, "servicioMedico", "Ha eliminado un   servicio medico");
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/eliminado");
	}

	public function restablecer($datos)
	{
		$id_servicioMedico = $datos[0];
		$id_usuario = $datos[1];
		$this->modelo->restablecerServ($id_servicioMedico);
		// Guardar la bitacora
		$this->bitacora->insertarBitacora($id_usuario, "servicioMedico", "Ha restablecido un servicio medico");
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/restablecido");
	}


	public function editar()
	{

		$precio_decimal = floatval($_POST['precioD']);
		
		$this->modelo->editar($_POST["id_servicioMedico"], $precio_decimal);
		// Guardar la bitacora
		$this->bitacora->insertarBitacora($_POST['id_usuario'], "servicioMedico", "Ha modificadp un servicio medico");
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/editado");
	}


	// public function mostrarConsultasB()
	// {
	// 	$doctores = $this->modelo->mostrarDoctores();
	// 	$servicios = $this->modelo->buscar($_POST["busqueda"]);
	// 	require_once './src/vistas/vistaConsultas/vistaConsultaB.php';
	// }

	public function mostrarEspecialidad($datos)
	{
		$id_doctor = $datos[0];
		$respuesta = $this->modelo->especialidadDoctor($id_doctor);
		echo json_encode($respuesta);
	}


	public function registrarCategoria()
	{
		$this->categoria->registrarCategoria($_POST["nombre"]);
		// Guardar la bitacora
		$this->bitacora->insertarBitacora($_POST['id_usuario'], "categoria_servicio", "Ha Insertado una nueva  categoria");
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/agregado");
	}
	public function eliminarCategoria($datos)
	{
		$id_categoria = $datos[0];
		$id_usuario = $datos[1];
		$this->categoria->eliminarCategoria($id_categoria);
		// Guardar la bitacora
		$this->bitacora->insertarBitacora($id_usuario, "categoria_servicio", "Ha eliminado una  categoria");
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/eliminado");
	}

	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}

}
