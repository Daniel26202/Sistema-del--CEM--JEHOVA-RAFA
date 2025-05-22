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
		$resultaServicio = $this->modelo->nombreConsulta($_POST['id_categoria'], $_POST['id_doctor']);
		if ($resultaServicio === "existeC") {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/error");
		} else {
			$precio_decimal = floatval($_POST['precioD']);
			$insercion = $this->modelo->insertarSevicio($_POST['id_categoria'],  $precio_decimal);
			if ($insercion) {
				// Guardar la bitacora
				$this->bitacora->insertarBitacora($_POST['id_usuario'], "servicioMedico", "Ha Insertado un nuevo  servicio medico");
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/agregado");
			} else {
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/errorSistem");
			}
		}
	}

	public function eliminar($datos)
	{
		$id_servicioMedico = $datos[0];
		$id_usuario = $datos[1];
		$eliminacion = $this->modelo->eliminar($id_servicioMedico);
		if ($eliminacion) {
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($id_usuario, "servicioMedico", "Ha eliminado un   servicio medico");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/eliminado");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/errorSistem");
		}
		
	}

	public function restablecer($datos)
	{
		$id_servicioMedico = $datos[0];
		$id_usuario = $datos[1];
		$restablecimiento = $this->modelo->restablecerServ($id_servicioMedico);
		if ($restablecimiento) {
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($id_usuario, "servicioMedico", "Ha restablecido un servicio medico");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/restablecido");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/errorSistem");
		}
	}

	public function editar()
	{
		$precio_decimal = floatval($_POST['precioD']);
	
		$edicion = $this->modelo->editar($_POST["id_servicioMedico"], $precio_decimal);
		if ($edicion) {
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario'], "servicioMedico", "Ha modificadp un servicio medico");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/editado");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/errorSistem");
		}
	}

	public function mostrarEspecialidad($datos)
	{
		$id_doctor = $datos[0];
		$respuesta = $this->modelo->especialidadDoctor($id_doctor);
		echo json_encode($respuesta);
	}


	public function registrarCategoria()
	{
		$insercion = $this->categoria->registrarCategoria($_POST["nombre"]);
		if ($insercion) {
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario'], "categoria_servicio", "Ha Insertado una nueva  categoria");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/agregado");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/errorSistem");
		}
	}
	public function eliminarCategoria($datos)
	{
		$id_categoria = $datos[0];
		$id_usuario = $datos[1];
		$eliminacion  = $this->categoria->eliminarCategoria($id_categoria);
		if ($eliminacion) {
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($id_usuario, "categoria_servicio", "Ha eliminado una  categoria");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/eliminado");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/errorSistem");
		}
	}

	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}

}
