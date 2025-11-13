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
		$ayuda = "btnayudaServicioMedico";
		$doctores = $this->modelo->mostrarDoctores();
		$categorias = $this->categoria->seleccionarCategoria();
		$todasLasCategorias = $this->categoria->seleccionarTodasLasCategoria();
		require_once './src/vistas/vistaConsultas/vistaServiciosMedicos.php';
	}

	public function consultasAjax()
	{
		echo json_encode($this->modelo->mostrarConsultas());
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
		$insercion = $this->modelo->insertarSevicio($_POST['id_categoria'],  $precio_decimal, $_POST['tipo']);

		if (is_array($insercion) && $insercion[0] === "exito") {
			$this->bitacora->insertarBitacora($_POST['id_usuario'], "servicio Medico", "Ha Insertado un nuevo servicio medico");
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $insercion]);
			exit;
		}
	}

	public function eliminar($datos)
	{
		$id_servicioMedico = $datos[0];
		$id_usuario = $datos[1];
		$eliminacion = $this->modelo->eliminar($id_servicioMedico);

		if (is_array($eliminacion) && $eliminacion[0] === "exito") {
			$this->bitacora->insertarBitacora($id_usuario, "servicio Medico", "Ha eliminado un  servicio medico");
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $eliminacion]);
			exit;
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

		$edicion = $this->modelo->editar($_POST["id_servicioMedico"], $precio_decimal, $_POST['tipo']);
		if ($edicion) {
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario'], "servicioMedico", "Ha modificadp un servicio medico");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/editar");
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
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/registro");
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
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/eliminar");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas/errorSistem");
		}
	}

	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}
}
