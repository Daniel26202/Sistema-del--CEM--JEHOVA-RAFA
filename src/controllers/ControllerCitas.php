<?php

use App\modelos\ModeloCita;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloServicios;
use App\modelos\ModeloDoctores;
use App\modelos\ModeloPacientes;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloSanetizarJSON;
use App\config\Cifrado;

function mostrarDataPaciente($datos)
{
	ob_start();

	try {

		if (!isset($datos[0]) || !isset($datos[1])) {
			throw new InvalidArgumentException("Faltan datos (nacionalidad y cédula).");
		}

		$cita = new ModeloCita();
		$sanitizador = new ModeloSanetizarJSON();

		$sanitizador->setHashKeys(['id_paciente']);

		$cita->setNacionalidad($datos[0]);
		$cita->setCedula($datos[1]);

		$resultado = $cita->selectPaciente();
		responderJson($sanitizador->sanitizeRecursive($resultado));
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
	ob_start();

	if (empty($_GET)) {
		responderJson(['ok' => false, 'error' => "Error al realizar la petición :("], 409);
	}

	$draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
	$inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;

	// El tamaño de página lo manda el cliente, así que se acota: sin este
	// tope un length=999999 pediría la tabla entera en memoria
	$limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
	$limite = max(1, min($limite, 100));

	$buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

	// Mapeo estricto del orden visual de las columnas en el JS de Citas
	$columnasMapeadas = ['paciente_cedula', 'paciente_nombre', 'telefono', 'doctor_nombre', 'categoria', 'fecha', 'hora', 'estado'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'c.id_cita';

	$modeloCita = new ModeloCita();
	$sanitizador = new ModeloSanetizarJSON();

	$sanitizador->setHashKeys(['id_cita', 'id_paciente', 'id_categoria', 'doctor']);
	$citas = $sanitizador->sanitizeRecursive($modeloCita->mostrarCita($inicio, $limite, $buscar, $ordenColumna, $ordenDir));

	$totalRegistros = $modeloCita->contarTotalCitas('pendiente', 'Pendiente');
	$totalFiltrados = !empty($buscar) ? $modeloCita->contarTotalCitas('pendiente', 'Pendiente', $buscar) : $totalRegistros;

	responderJson([
		'draw'            => $draw,
		'recordsTotal'    => (int)$totalRegistros,
		'recordsFiltered' => (int)$totalFiltrados,
		'data'            => $citas
	]);
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

	$draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
	$inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
	// El tamaño de página lo manda el cliente, así que se acota
	$limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
	$limite = max(1, min($limite, 100));
	$buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

	// Mapeo estricto del orden visual de las columnas en el JS de Citas
	$columnasMapeadas = ['paciente_cedula', 'paciente_nombre', 'telefono', 'doctor_nombre', 'categoria', 'fecha', 'hora', 'estado'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'c.id_cita';

	$modeloCita = new ModeloCita();
	$sanitizador = new ModeloSanetizarJSON();

	$sanitizador->setHashKeys(['id_cita', 'id_paciente', 'id_categoria', 'doctor']);
	$citas = $sanitizador->sanitizeRecursive($modeloCita->mostrarCitaHoy($inicio, $limite, $buscar, $ordenColumna, $ordenDir));

	$totalRegistros = $modeloCita->contarTotalCitas('hoy', 'Pendiente');
	$totalFiltrados = !empty($buscar) ? $modeloCita->contarTotalCitas('hoy', 'Pendiente', $buscar) : $totalRegistros;

	responderJson([
		'draw'            => $draw,
		'recordsTotal'    => (int)$totalRegistros,
		'recordsFiltered' => (int)$totalFiltrados,
		'data'            => $citas
	]);
}
function citasP($parametro)
{
	$cita = new ModeloCita();
	$sanitizador = new ModeloSanetizarJSON();

	$sanitizador->setHashKeys(['id_cita', 'id_paciente', 'id_categoria', 'doctor']);
	echo json_encode($sanitizador->sanitizeRecursive($cita->mostrarCita()));
}

function mostrarServiciosMedicosAjax()
{
	ob_start();

	$cita = new ModeloCita();
	$sanitizador = new ModeloSanetizarJSON();

	$sanitizador->setHashKeys(['id_categoria']);
	responderJson($sanitizador->sanitizeRecursive($cita->mostrarServicioDoctor()));
}

function validarHorariosDisponlibles($datos)
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	try {
		// if (!isset($datos[0]) || !isset($datos[1]) || !is_numeric($datos[0]) || !is_numeric($datos[1])) {
		// 	throw new InvalidArgumentException("Datos inválidos (fecha y doctor).");
		// }

		$cita = new ModeloCita();
		$sanitizador = new ModeloSanetizarJSON();

		$cita->setIdDoctor(intval(unhashId($datos[1])));
		$cita->setFecha($datos[0]);

		$resultado = $cita->validarHorariosDisponlibles();
		responderJson($sanitizador->sanitizeRecursive($resultado));
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

/**
 * Emite la respuesta JSON y termina la ejecución.
 *
 * Descarta cualquier salida accidental (warnings/notices de PHP, porque el
 * proyecto tiene display_errors activo) antes de imprimir. Sin esto, un
 * simple warning delante del JSON producía un cuerpo con dos objetos
 * concatenados, el fetch no lograba parsearlo y el navegador terminaba
 * mostrando "Este cupo ya fue apartado por otro usuario" aunque el servidor
 * hubiera apartado el horario correctamente.
 */
function responderJson($datos, $codigo = 200)
{
	if (ob_get_length()) {
		ob_clean();
	}

	http_response_code($codigo);
	echo json_encode($datos);
	exit;
}

/**
 * Convierte el texto de una tarjeta de horario ("8:00 PM a 9:00 PM") en el
 * par [hora_entrada, hora_salida] con formato H:i:s.
 *
 * Devuelve null si el texto no tiene el formato esperado. Antes se llamaba
 * format() directamente sobre el resultado de createFromFormat(), que
 * devuelve false cuando la hora no existe: en PHP 8 eso es un Error fatal
 * (no una excepción) y terminaba en un 500 con página HTML en lugar de un
 * mensaje de validación.
 */
function convertirHorarioCita($horaString)
{
	$resultado = preg_split('/\s+a\s+/i', trim($horaString));

	// El formato esperado es exactamente "H:MM AM a H:MM PM". Aceptar textos
	// con más de un separador hacía que "8:00 PM a 9:00 PM a 10:00 PM" se
	// interpretara silenciosamente como 8-9 PM en lugar de rechazarse.
	if (!is_array($resultado) || count($resultado) !== 2) {
		return null;
	}

	$entrada = DateTime::createFromFormat('g:i A', trim($resultado[0]));
	$salida  = DateTime::createFromFormat('g:i A', trim($resultado[1]));

	if ($entrada === false || $salida === false) {
		return null;
	}

	return [$entrada->format('H:i:s'), $salida->format('H:i:s')];
}

//metodo para reservar la cita
function apartarCupo()
{
	// Todo lo que se imprima por accidente (warnings de PHP) queda en el
	// buffer y responderJson() lo descarta antes de emitir la respuesta
	ob_start();

	// if (ob_get_length()) ob_clean();
	// header("Content-Type: application/json; charset=UTF-8");

	if (empty($_POST)) {
		responderJson(['ok' => false, 'error' => "Error  al realizar la peticion :("], 409);
	}


	try {
		$headers = getallheaders();
		$csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;
		if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
			responderJson(['ok' => false, 'error' => 'Token CSRF inválido'], 403);
		}

		$cita = new ModeloCita();
		$bitacora = new ModeloBitacora();
		$idUsuario = $_SESSION['id_usuario'] ?? null;

		if (empty($idUsuario)) {
			responderJson(['ok' => false, 'error' => 'Su sesión expiró. Inicie sesión nuevamente.'], 409);
		}

		// Validación de los campos requeridos ANTES de aplicar unhashId().
		// Un identificador corrupto (por ejemplo la cadena "undefined" que
		// quedaba en el campo del paciente cuando su consulta fallaba)
		// reventaba dentro de unhashId() y el usuario recibía un mensaje
		// genérico sin saber qué corregir. Aquí se dice qué campo es.
		$camposRequeridos = [
			'fecha'             => ['Debe seleccionar la fecha de la cita.', null],
			'doctor'            => ['Debe seleccionar el doctor de la cita.', 'el doctor'],
			'id_paciente'       => ['Debe seleccionar un paciente (o registrar uno nuevo) antes de apartar el horario.', 'el paciente'],
			'id_servicioMedico' => ['Debe seleccionar un servicio médico antes de apartar el horario.', 'el servicio médico'],
		];

		foreach ($camposRequeridos as $campo => $reglas) {
			list($mensajeError, $etiqueta) = $reglas;
			$valor = isset($_POST[$campo]) ? trim((string)$_POST[$campo]) : '';

			if ($valor === '' || $valor === '0') {
				responderJson(['ok' => false, 'error' => $mensajeError], 409);
			}

			// Identificador corrupto: se dice qué campo es el que hay que
			// volver a seleccionar, en lugar de un error genérico
			if ($etiqueta !== null && !esHashIdValido($valor)) {
				responderJson([
					'ok' => false,
					'error' => "No se pudo validar $etiqueta. Vuelva a seleccionarlo antes de apartar el horario."
				], 409);
			}
		}

		// Separamos el string de hora idéntico a como lo haces en guardarCita
		$horario = !empty($_POST['hora_string']) ? convertirHorarioCita($_POST['hora_string']) : null;

		if ($horario === null) {
			responderJson(['ok' => false, 'error' => 'El horario seleccionado no es válido. Vuelva a elegir el horario.'], 409);
		}

		list($horaCita, $horaCitaSalida) = $horario;

		$cita->setFecha($_POST['fecha']);
		$cita->setHora($horaCita);
		$cita->setIdDoctor(intval(unhashId($_POST['doctor'])));

		$cita->setIdPaciente(intval(unhashId($_POST['id_paciente'])));
		$cita->setIdServicioMedico(intval(unhashId($_POST['id_servicioMedico'])));
		$cita->setHoraSalida($horaCitaSalida);

		// Evaluamos si viene un ID anterior por cambio de opinión
		$idCitaAnterior = isset($_POST['id_cita_anterior']) ? trim((string)$_POST['id_cita_anterior']) : '';

		// Si el identificador no es utilizable se ignora en lugar de romper:
		// el cupo anterior caduca solo a los 5 minutos
		if ($idCitaAnterior !== '' && esHashIdValido($idCitaAnterior)) {
			$cita->setIdCita(intval(unhashId($idCitaAnterior)), true);
		} else {
			if ($idCitaAnterior !== '' && $idCitaAnterior !== '0') {
				error_log("apartarCupo: id_cita_anterior ignorado por valor no válido");
			}
			$cita->setIdCita(null, true);
		}
		$reserva = $cita->reservarCita($idUsuario);

		if (is_array($reserva) && $reserva[0] === "exito") {
			$bitacora->setId_usuario($idUsuario);
			$bitacora->setActividad("Ha Insertado una  cita");
			$bitacora->setTabla("cita");
			$bitacora->insertarBitacora($idUsuario);
			// Se hashea el ID de la reserva porque el JS lo envía de vuelta
			// como "id_cita_anterior" cuando el usuario cambia de opinión
			responderJson([
				'ok'      => true,
				'message' => 'La operación se realizó con éxito',
				'data'    => ['id_cita' => hashId((int)$reserva[1])]
			]);
		}

		if (is_string($reserva)) {
			responderJson(['ok' => false, 'error' => $reserva], 409);
		}

		error_log("Error en apartarCitas: " . print_r($reserva, true));
		responderJson(['ok' => false, 'error' => 'Error al apartar la cita.'], 409);
	} catch (\InvalidArgumentException $e) {
		// Identificadores vacíos, con el valor "0" del placeholder o manipulados
		error_log("Error en apartarCupo (identificador): " . $e->getMessage());
		responderJson([
			'ok' => false,
			'error' => 'No se pudo validar la selección. Verifique que haya elegido paciente, servicio, doctor, fecha y horario.'
		], 409);
	} catch (Exception $e) {
		error_log("Error en apartarCupo: " . $e->getMessage());
		responderJson(['ok' => false, 'error' => 'Error interno del servidor'], 409);
	}
}

function guardarCita()
{
	ob_start();

	if (empty($_POST)) {
		responderJson(['ok' => false, 'error' => "Error  al realizar la peticion :("], 409);
	}

	try {
		$headers = getallheaders();
		$csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;
		if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
			responderJson(['ok' => false, 'error' => 'Token CSRF inválido'], 403);
		}

		$idUsuario = $_SESSION['id_usuario'];
		$bitacora = new ModeloBitacora();
		$cita = new ModeloCita();

		$horario = !empty($_POST['listHoras']) ? convertirHorarioCita($_POST['listHoras']) : null;

		if ($horario === null) {
			responderJson(['ok' => false, 'error' => 'No se ha seleccionado un horario válido.'], 409);
		}

		list($horaCita, $horaCitaSalida) = $horario;

		$cita->setIdPaciente(intval(unhashId($_POST["id_paciente"])));
		$cita->setIdServicioMedico(intval(unhashId($_POST["id_servicio"])));
		$cita->setFecha($_POST["fechaDeCita"]);
		$cita->setHora($horaCita);
		$cita->setHoraSalida($horaCitaSalida);
		$cita->setEstado("Pendiente");
		$cita->setIdDoctor(intval(unhashId($_POST["id_personal"])));

		$insercion = $cita->guardarCita($idUsuario);

		if (is_array($insercion) && $insercion[0] === "exito") {
			$bitacora->setId_usuario($idUsuario);
			$bitacora->setActividad("Ha Insertado una  cita");
			$bitacora->setTabla("cita");
			$bitacora->insertarBitacora($idUsuario);
			responderJson(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
		}

		if (is_string($insercion)) {
			responderJson(['ok' => false, 'error' => $insercion], 409);
		}

		error_log("Error en guardarCita: " . print_r($insercion, true));
		responderJson(['ok' => false, 'error' => 'Error al guardar la cita.'], 409);
	} catch (InvalidArgumentException $e) {
		responderJson(['ok' => false, 'error' => $e->getMessage()], 409);
	}
}

function eliminarCita()
{
	ob_start();

	if (empty($_GET)) {
		responderJson(['ok' => false, 'error' => "Error  al realizar la peticion :("], 409);
	}
	try {
		$headers = getallheaders();
		$csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;
		if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
			responderJson(['ok' => false, 'error' => 'Token CSRF inválido'], 403);
		}

		$idUsuario = $_SESSION['id_usuario'];
		$bitacora = new ModeloBitacora();
		$cita = new ModeloCita();

		$input = json_decode(file_get_contents("php://input"), true);
		$id = unhashId($input['id'] ?? null);

		$estado = empty($input["estado"]) ? 'DES' : 'ACT';
		$text = empty($input["estado"]) ? 'eliminado' : 'restablecido';
		$text_error = empty($input["estado"]) ? 'eliminar' : 'restablecer';

		$cita->setIdCita($id);

		$eliminacion = $cita->eliminarCitaPublic($idUsuario, $estado);

		if (is_array($eliminacion) && $eliminacion[0] === "exito") {
			$bitacora->setId_usuario($idUsuario);
			$bitacora->setActividad("Ha {$text} una  cita");
			$bitacora->setTabla("cita");
			$bitacora->insertarBitacora($idUsuario);
			responderJson(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		}

		if (is_string($eliminacion)) {
			responderJson(['ok' => false, 'error' => $eliminacion], 409);
		}

		error_log("Error en eliminarCita: " . print_r($eliminacion, true));
		responderJson(['ok' => false, 'error' => 'Error al ' . $text_error . ' la cita.'], 409);
	} catch (InvalidArgumentException $e) {
		responderJson(['ok' => false, 'error' => $e->getMessage()], 409);
	}
}
function citasHoyP()
{
	$cita = new ModeloCita();
	$sanitizador = new ModeloSanetizarJSON();

	$sanitizador->setHashKeys(['id_cita', 'id_paciente', 'id_categoria', 'doctor']);
	echo json_encode($sanitizador->sanitizeRecursive($cita->mostrarCitaHoy()));
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

	$draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
	$inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
	// El tamaño de página lo manda el cliente, así que se acota
	$limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
	$limite = max(1, min($limite, 100));
	$buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

	$columnasMapeadas = ['paciente_cedula', 'paciente_nombre', 'telefono', 'doctor_nombre', 'categoria', 'fecha', 'hora', 'estado'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'c.id_cita';

	$modeloCita = new ModeloCita();
	$sanitizador = new ModeloSanetizarJSON();

	$sanitizador->setHashKeys(['id_cita', 'id_paciente', 'id_categoria', 'doctor']);
	$citas = $sanitizador->sanitizeRecursive($modeloCita->mostrarCitaR($inicio, $limite, $buscar, $ordenColumna, $ordenDir));

	$totalRegistros = $modeloCita->contarTotalCitas('realizada', 'Realizadas');
	$totalFiltrados = !empty($buscar) ? $modeloCita->contarTotalCitas('realizada', 'Realizadas', $buscar) : $totalRegistros;

	responderJson([
		'draw'            => $draw,
		'recordsTotal'    => (int)$totalRegistros,
		'recordsFiltered' => (int)$totalFiltrados,
		'data'            => $citas
	]);
}

function mostrarDoctoresCita($datos)
{
	ob_start();

	$cita = new ModeloCita();
	$sanitizador = new ModeloSanetizarJSON();

	$sanitizador->setHashKeys(['id_personal']);
	$cita->setIdServicioMedico(intval(unhashId($datos[0])));
	responderJson($sanitizador->sanitizeRecursive($cita->mostrarDoctores()));
}

function mostrarHorario($datos)
{
	ob_start();

	$cita = new ModeloCita();
	$sanitizador = new ModeloSanetizarJSON();

	$sanitizador->setHashKeys(['id_servicioMedico', 'id_horarioydoctor', 'id_personal', 'id_horario']);
	$cita->setIdDoctor(intval(unhashId($datos[0])));
	responderJson($sanitizador->sanitizeRecursive($cita->mostrarHorarioDoctores()));
}
function editarCita()
{
	ob_start();

	if (empty($_POST)) {
		responderJson(['ok' => false, 'error' => "Error  al realizar la peticion :("], 409);
	}

	try {
		$headers = getallheaders();
		$csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;
		if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
			responderJson(['ok' => false, 'error' => 'Token CSRF inválido'], 403);
		}

		$idUsuario = $_SESSION['id_usuario'];
		$bitacora = new ModeloBitacora();
		$cita = new ModeloCita();

		$horario = !empty($_POST['listHoras']) ? convertirHorarioCita($_POST['listHoras']) : null;

		if ($horario === null) {
			responderJson(['ok' => false, 'error' => 'No se ha seleccionado un horario válido.'], 409);
		}

		list($horaCita, $horaCitaSalida) = $horario;

		$cita->setIdPaciente(intval(unhashId($_POST["id_paciente"])));
		$cita->setIdServicioMedico(intval(unhashId($_POST["id_servicio"])));
		$cita->setFecha($_POST["fechaDeCita"]);
		$cita->setHora($horaCita);
		$cita->setHoraSalida($horaCitaSalida);
		$cita->setEstado("Pendiente");
		$cita->setIdDoctor(intval(unhashId($_POST["id_personal"])));
		$cita->setIdCita(unhashId($_POST['id_cita']));

		$edicion = $cita->editarCita($idUsuario);

		if (is_array($edicion) && $edicion[0] === "exito") {
			$bitacora->setId_usuario($idUsuario);
			$bitacora->setActividad("Ha Modificado una  cita");
			$bitacora->setTabla("cita");
			$bitacora->insertarBitacora($idUsuario);
			responderJson(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		}

		if (is_string($edicion)) {
			responderJson(['ok' => false, 'error' => $edicion], 409);
		}

		error_log("Error en editarCita: " . print_r($edicion, true));
		responderJson(['ok' => false, 'error' => 'Error al editar la cita.'], 409);
	} catch (InvalidArgumentException $e) {
		responderJson(['ok' => false, 'error' => $e->getMessage()], 409);
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
		$cita = new ModeloCita();
		$sanitizador = new ModeloSanetizarJSON();

		$sanitizador->setHashKeys(['id_cita', 'id_categoria', 'id_paciente']);
		$resultado = $sanitizador->sanitizeRecursive($cita->mostrarTodasCitasHoy());

		echo json_encode(Cifrado::cifrarRespuesta($resultado));
	} catch (\Throwable $e) {
		http_response_code(500);
		echo json_encode(Cifrado::cifrarRespuesta([
			"ok" => false,
			"error" => "Error interno en el servidor: " . $e->getMessage()
		]));
	}
	exit;
}
