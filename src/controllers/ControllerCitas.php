<?php

use App\models\ModeloCita;
use App\models\ModeloBitacora;
use App\models\Db;
use App\models\Validator;

function mostrarDataPaciente($datos)
{
	try {
		$db = new Db();
		$cita = new ModeloCita($db);

		$cita->setNacionalidad($datos[0]);
		$cita->setCedula($datos[1]);

		echo json_encode($cita->selectPaciente());
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function citas($parametro)
{
	$ayuda = "btnayudaCitaP";
	$vistaActiva = 'pendientes';
	require_once './src/vistas/vistasCitas/vistaCitas.php';
}

function citasAjax()
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
		exit;
	}

	$db = new Db();

	$draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
	$inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
	$limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
	$buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

	// Mapeo estricto del orden visual de las columnas en el JS de Citas
	$columnasMapeadas = ['paciente_cedula', 'paciente_nombre', 'telefono', 'doctor_nombre', 'categoria', 'fecha', 'hora', 'estado'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'c.id_cita';

	$modeloCita = new ModeloCita($db);
	$data = $modeloCita->mostrarCita($inicio, $limite, $buscar, $ordenColumna, $ordenDir);

	echo json_encode([
		"draw"            => $draw,
		"recordsTotal"    => (int)$data['total'],
		"recordsFiltered" => (int)$data['total_filtrado'],
		"data"            => is_array($data) ? $data['data']:[]
	]);
	exit;
}

function citasHoy($parametro)
{
	$ayuda = "btnayudaCitaP";
	$vistaActiva = 'hoy';
	// $servicios = $this->modelo->mostrarServicioDoctor();
	require_once './src/vistas/vistasCitas/vistaCitas.php';
}

function citasHoyAjax()
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
		exit;
	}

	$db = new Db();

	$draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
	$inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
	$limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
	$buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

	// Mapeo estricto del orden visual de las columnas en el JS de Citas
	$columnasMapeadas = ['paciente_cedula', 'paciente_nombre', 'telefono', 'doctor_nombre', 'categoria', 'fecha', 'hora', 'estado'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'c.id_cita';

	$modeloCita = new ModeloCita($db);
	$data = $modeloCita->mostrarCita($inicio, $limite, $buscar, $ordenColumna, $ordenDir);

	echo json_encode([
		"draw"            => $draw,
		"recordsTotal"    => (int)$data['total'],
		"recordsFiltered" => (int)$data['total_filtrado'],
		"data"            => is_array($data['data'])?$data['data']:[]
	]);
	exit;
}
function citasP($parametro)
{
	$db = new Db();
	$cita = new ModeloCita($db);
	echo json_encode($cita->mostrarCita());
}

function mostrarServiciosMedicosAjax()
{
	$db = new Db();
	$cita = new ModeloCita($db);

	// echo json_encode($cita->mostrarServicioDoctor());
	echo json_encode([]);
}

function validarHorariosDisponlibles($datos)
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	try {
		$db = new Db();

		$cita = new ModeloCita($db);

		$cita->setIdDoctor($datos[1]);
		$cita->setFecha($datos[0]);

		echo  json_encode($cita->validarHorariosDisponlibles());
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

//metodo para reservar la cita
function apartarCupo()
{
	// if (ob_get_length()) ob_clean();
	// header("Content-Type: application/json; charset=UTF-8");

	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}


	try {
		$idUsuario = $_SESSION['id_usuario'];
		$db = new Db();
		$validator = new Validator();
		$validator->set_session($_SESSION);
		$validator->set_id_usuario($idUsuario);
		$cita = new ModeloCita($db,$validator);
		$bitacora = new ModeloBitacora($db,$validator);

		// Separamos el string de hora idéntico a como lo haces en guardarCita
		$horaString = $_POST['hora_string'];
		$resultado = explode('a', $horaString);
		$resultado = array_map('trim', $resultado);

		$fechaHora1 = DateTime::createFromFormat('g:i A', $resultado[0]);
		$horaCita = $fechaHora1->format('H:i:s');
		$fechaHora2 = DateTime::createFromFormat('g:i A', $resultado[1]);
		$horaCitaSalida = $fechaHora2->format('H:i:s');

		$cita->setFecha($_POST['fecha']);
		$cita->setHora($horaCita);
		$cita->setIdDoctor(intval($_POST['doctor']));

		$cita->setIdPaciente(intval($_POST['id_paciente']));
		$cita->setIdServicioMedico(intval($_POST['id_servicioMedico']));
		$cita->setHoraSalida($horaCitaSalida);

		// Evaluamos si viene un ID anterior por cambio de opinión
		$cita->setIdCita(isset($_POST['id_cita_anterior']) ? intval($_POST['id_cita_anterior']) : null, true);


		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha Insertado una  cita");
		$bitacora->setTabla("cita");


		$reserva = $cita->reservarCita();

		if (is_array($reserva)) {
			$bitacora->guardar($bitacora->get_all(),$validator);
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $reserva]);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $reserva]);
			exit;
		}
	} catch (Exception $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function guardarCita()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	try {
		$idUsuario = $_SESSION['id_usuario'];
		$db = new Db();
		$validator = new Validator();
		$validator->set_session($_SESSION);
		$validator->set_id_usuario($idUsuario);
		$bitacora = new ModeloBitacora($db,$validator);
		$cita = new ModeloCita($db,$validator);

		$horaString = $_POST['listHoras'];
		$resultado = explode('a', $horaString);
		$resultado = array_map('trim', $resultado);

		$fechaHora1 = DateTime::createFromFormat('g:i A', $resultado[0]);
		$horaCita = $fechaHora1->format('H:i:s');
		$fechaHora2 = DateTime::createFromFormat('g:i A', $resultado[1]);
		$horaCitaSalida = $fechaHora2->format('H:i:s');

		$cita->setIdPaciente(intval($_POST["id_paciente"]));
		$cita->setIdServicioMedico(intval($_POST["id_servicio"]));
		$cita->setFecha($_POST["fechaDeCita"]);
		$cita->setHora($horaCita);
		$cita->setHoraSalida($horaCitaSalida);
		$cita->setEstado("Pendiente");
		$cita->setIdDoctor(intval($_POST["id_personal"]));

		$insercion = $cita->guardarCita();

		if (is_array($insercion)) {
			$bitacora->setId_usuario($idUsuario);
			$bitacora->setActividad("Ha Insertado una  cita");
			$bitacora->setTabla("cita");
			$bitacora->guardar($bitacora->get_all(),$validator);
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion]);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $insercion]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	} catch (Exception $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function eliminarCita($datos)
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}
	try {
		$idUsuario = $_SESSION['id_usuario'];
		$db = new Db();
		$validator = new Validator();
		$validator->set_session($_SESSION);
		$validator->set_id_usuario($idUsuario);
		$bitacora = new ModeloBitacora($db,$validator);
		$cita = new ModeloCita($db,$validator);

		$cita->setIdCita($datos[0]);

		$eliminacion = $cita->actualizar(['estado'=>'DES'],['id_cita'=>$cita->getIdCita()],$validator);

		if (is_array($eliminacion) && $eliminacion[0] === "exito") {
			$bitacora->setId_usuario($idUsuario);
			$bitacora->setActividad("Ha eliminado una  cita");
			$bitacora->setTabla("cita");
			$bitacora->guardar($bitacora->get_all(),$validator);
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $eliminacion]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	} catch (Exception $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}
function citasHoyP()
{
	$db = new Db();
	$cita = new ModeloCita($db);
	echo json_encode($cita->mostrarCitaHoy());
}

function citasRealizadas($parametro)
{
	$ayuda = "btnayudaCitaP";
	$vistaActiva = 'realizadas';
	require_once './src/vistas/vistasCitas/vistaCitas.php';
}

function citasRealizadasAjax()
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
		exit;
	}
	$db = new Db();

	$draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
	$inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
	$limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
	$buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

	$columnasMapeadas = ['paciente_cedula', 'paciente_nombre', 'telefono', 'doctor_nombre', 'categoria', 'fecha', 'hora', 'estado'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'c.id_cita';

	$modeloCita = new ModeloCita($db);
	$data = $modeloCita->mostrarCita($inicio, $limite, $buscar, $ordenColumna, $ordenDir);

	echo json_encode([
		"draw"            => $draw,
		"recordsTotal"    => (int)$data['total'],
		"recordsFiltered" => (int)$data['total_filtrado'],
		"data"            => is_array($data['data']) ? $data['data'] : []
	]);
	exit;
}

function mostrarDoctoresCita($datos)
{
	$db = new Db();
	$cita = new ModeloCita($db);
	// $cita->setIdServicioMedico($datos[0]);
	// echo json_encode($cita->mostrarDoctores());
	echo json_encode([]);
}

function mostrarHorario($datos)
{
	$db = new Db();
	$cita = new ModeloCita($db);
	// $cita->setIdDoctor($datos[0]);
	// echo json_encode($cita->mostrarHorarioDoctores());
	echo json_encode(['dffdf']);
}
function editarCita()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	try {
		$idUsuario = $_SESSION['id_usuario'];
		$db = new Db();
		$validator = new Validator();
		$validator->set_session($_SESSION);
		$validator->set_id_usuario($idUsuario);
		$bitacora = new ModeloBitacora($db,$validator);
		$cita = new ModeloCita($db,$validator);

		$horaString = $_POST['listHoras'];
		$resultado = explode('a', $horaString);
		$resultado = array_map('trim', $resultado);

		$fechaHora1 = DateTime::createFromFormat('g:i A', $resultado[0]);
		$horaCita = $fechaHora1->format('H:i:s');
		$fechaHora2 = DateTime::createFromFormat('g:i A', $resultado[1]);
		$horaCitaSalida = $fechaHora2->format('H:i:s');

		$cita->setIdPaciente(intval($_POST["id_paciente"]));
		$cita->setIdServicioMedico(intval($_POST["id_servicio"]));
		$cita->setFecha($_POST["fechaDeCita"]);
		$cita->setHora($horaCita);
		$cita->setHoraSalida($horaCitaSalida);
		$cita->setEstado("Pendiente");
		$cita->setIdDoctor(intval($_POST["id_personal"]));
		$cita->setIdCita($_POST['id_cita']);

		$edicion = $cita->actualizar($cita->get_all(),['id_cita'=>$cita->getIdCita()],$validator);

		if (is_array($edicion) && $edicion[0] === "exito") {
			$bitacora->setId_usuario($idUsuario);
			$bitacora->setActividad("Ha Modificado una  cita");
			$bitacora->setTabla("cita");
			$bitacora->guardar($bitacora->get_all(),$validator);
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $edicion]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	} catch (Exception $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}
function citasHoyCompletasApk()
{
	// Limpia el búfer de salida para eliminar cualquier espacio en blanco o eco previo.
	if (ob_get_length()) ob_clean();
	header("Content-Type: application/json; charset=UTF-8");
	// Permite el acceso CORS
	header("Access-Control-Allow-Origin: *");
	//  establce la zona horaria 
	date_default_timezone_set('America/Caracas');
	try {
		$db = new Db();
		$cita = new ModeloCita($db);
		$resultado = $cita->mostrarTodasCitasHoy();

		echo json_encode($resultado);
	} catch (\Throwable $e) {
		http_response_code(500);
		echo json_encode([
			"ok" => false,
			"error" => "Error interno en el servidor: " . $e->getMessage()
		]);
	}
	exit;
}
