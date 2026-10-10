<?php

use App\modelos\ModeloFactura;
use App\modelos\ModeloFacturaHospitalizacion;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloInsumo;
use App\modelos\ModeloSanetizarJSON;

function factura($parametro)
{

	$modeloInsumos = new ModeloInsumo();
	$sanetizar = new ModeloSanetizarJSON();
	$vistaActiva = 'factura';
	$ayuda = "btnayudaFactura";
	$sanetizar->setHashKeys(['id_insumo']);
	$insumos = $sanetizar->sanitizeRecursive($modeloInsumos->insumos());
	require_once './src/vistas/vistaFactura/factura.php';
}

function mostrarServicios()
{
	$modeloFactura = new ModeloFactura();
	$sanetizar = new ModeloSanetizarJSON();

	$sanetizar->setHashKeys(['id_servicioMedico', 'id_personal', 'id_categoria']);
	$result = [];

	foreach ($modeloFactura->mostrarServicios() as $servicio) {
		$result[] = [
			'id' => hashId((int)$servicio['id_servicioMedico']) . hashId((int)$servicio['id_personal']),
			'id_personal' => $servicio['id_personal'],
			'id_servicioMedico' => $servicio['id_servicioMedico'],
			'id_categoria' => $servicio['id_categoria'],
			'nombre_d' => $servicio['nombre_d'],
			'apellido_d' => $servicio['apellido_d'],
			'precio' => $servicio['precio'],
			'categoria' => $servicio['categoria'],
		];
	}

	echo json_encode($sanetizar->sanitizeRecursive($result));
}

function mostrarInsumos()
{
	$modeloInsumos = new ModeloInsumo();
	$sanetizar = new ModeloSanetizarJSON();

	$sanetizar->setHashKeys(['id_insumo']);
	echo json_encode($sanetizar->sanitizeRecursive($modeloInsumos->insumos()));
}

function mostrarMetodosDePago()
{
	$modeloFactura = new ModeloFactura();
	$sanetizar = new ModeloSanetizarJSON();

	$sanetizar->setHashKeys(['id_pago']);
	echo json_encode($sanetizar->sanitizeRecursive($modeloFactura->mostrarTiposDePagos()));
}

function facturaCita($parametro)
{
	$modeloInsumos = new ModeloInsumo();
	$modeloFactura = new ModeloFactura();
	$sanetizar = new ModeloSanetizarJSON();

	$idCita = unhashId($parametro[0]);

	$modeloFactura->setIdCita($idCita);

	$sanetizar->setHashKeys(['id_insumo', 'id_pago', 'id_servicioMedico', 'id_personal', 'id_categoria', 'id_cita', 'id_paciente']);
	$insumos = $sanetizar->sanitizeRecursive($modeloInsumos->insumos());
	$tiposDePagos = $sanetizar->sanitizeRecursive($modeloFactura->mostrarTiposDePagos());
	$todosLosInsumos = $insumos;
	$extras = $sanetizar->sanitizeRecursive($modeloFactura->mostrarServicios());
	$citaFacturar = $sanetizar->sanitizeRecursive($modeloFactura->mostrarCitaFactura());

	require_once './src/vistas/vistaFactura/facturaCita.php';
}

function facturarHospitalizacion($parametro)
{
	$modeloFactura = new ModeloFactura();
	$sanetizar = new ModeloSanetizarJSON();

	$idHospitalizacion = unhashId($parametro[0]);

	$modeloFactura->setIdH($idHospitalizacion);

	$sanetizar->setHashKeys(['id_entradaDeInsumo', 'id_hospitalizacion', 'id_insumo', 'id_pago', 'id_paciente', 'id_personal', 'id_servicioMedico', 'id_doctor']);
	$insumosHospitalizacion = $sanetizar->sanitizeRecursive($modeloFactura->unirInsumosHospitalizacion());
	$tiposDePagos = $sanetizar->sanitizeRecursive($modeloFactura->mostrarTiposDePagos());
	$hostalizacionFacturar = $sanetizar->sanitizeRecursive($modeloFactura->mostrarHospitalizacion());
	$serviciosDeHospitalizacion = $sanetizar->sanitizeRecursive($modeloFactura->serviciosIncluidosHospit());

	require_once './src/vistas/vistaFactura/facturaHospitalizacion.php';
}

function datosHospitalizacion($parametro)
{
	$modeloFactura = new ModeloFactura();
	$sanetizar = new ModeloSanetizarJSON();
	$sanetizar->setHashKeys(['id_hospitalizacion', 'id_paciente', 'id_servicioMedico', 'id_doctor', 'id_entradaDeInsumo']);
	$modeloFactura->setIdH(unhashId($parametro[0]));

	$result = [];
	$hospit = null;
	$datosServicios = [];
	$datosInsumos = [];

	foreach ($modeloFactura->mostrarHospitalizacion() as $hospit) {
		$id_hospit = $hospit['id_hospitalizacion'];

		$servicios = array_filter(
			$modeloFactura->serviciosIncluidosHospit(),
			fn($s) => $s['id_hospitalizacion'] === $id_hospit
		);
		$insumos = array_filter(
			$modeloFactura->unirInsumosHospitalizacion(),
			fn($i) => $i['id_hospitalizacion'] === $id_hospit
		);

		foreach ($servicios as $servicio) {
			$datosServicios[] = [
				'id_servicioMedico' => $servicio['id_servicioMedico'],
				'id_doctor' => $servicio['id_doctor'],
				'nombre_d' => $servicio['nombre_d'],
				'apellido_d' => $servicio['apellido_d'],
				'categoria' => $servicio['categoria'],
				'precios_servicio' => $servicio['precios_servicio']
			];
		}
		foreach ($insumos as $insumo) {
			$datosInsumos[] = [
				'id_entradaDeInsumo' => $insumo['id_entradaDeInsumo'],
				'nombre' => $insumo['nombre'],
				'medida' => $insumo['medida'],
				'precio' => $insumo['precio'],
				// f.js lee el atributo `iva` de la tarjeta para decidir la tasa.
				'iva' => $insumo['aplica_iva'] ?? $insumo['iva'] ?? 0,
				'cantidad' => $insumo['cantidad'],
			];
		}
	}

	if ($hospit) {
		$result[] = [
			'id_hospitalizacion' => $hospit['id_hospitalizacion'],
			'fecha_hora_inicio' => $hospit['fecha_hora_inicio'],
			'precio_horas' => $hospit['precio_horas'],
			'fecha_hora_final' => $hospit['fecha_hora_final'],
			'total_MoEx' => $hospit['total_MoEx'],
			'total' => $hospit['total'],
			'id_paciente' => $hospit['id_paciente'],
			'nacionalidad' => $hospit['nacionalidad'],
			'nombre_p' => $hospit['nombre'],
			'apellido_p' => $hospit['apellido'],
			'nombredoc' => $hospit['nombredoc'],
			'apellidodoc' => $hospit['apellidodoc'],
			'fecha_de_nacimiento' => $hospit['fn'],
			'servicios' => $datosServicios,
			'insumos' => $datosInsumos
		];
	}

	echo json_encode($sanetizar->sanitizeRecursive($result));
}

function comprobante($parametro)
{
	$modeloFactura = new ModeloFactura();
	$sanetizar = new ModeloSanetizarJSON();

	if ($parametro == "") {
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/factura");
		exit;
	}

	try {
		$modeloFactura->setIdFactura(unhashId($parametro[0]));
	} catch (\Throwable $e) {
		// Identificador manipulado o vacío: no se intenta cargar la factura.
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/factura");
		exit;
	}

	$sanetizar->setHashKeys(['id_factura', 'id_pago', 'id_servicioMedico', 'id_doctor', 'id_hospitalizacion', 'id_entradaDeInsumo', 'id_insumo']);
	$datosFactura = $sanetizar->sanitizeRecursive($modeloFactura->consultarFactura());

	// Factura inexistente o de otro usuario: se avisa con 404 en vez de
	// renderizar un comprobante vacío.
	if (!is_array($datosFactura) || count($datosFactura) === 0) {
		http_response_code(404);
		echo "La factura solicitada no existe.";
		exit;
	}

	$datosPago = $sanetizar->sanitizeRecursive($modeloFactura->consultarPagoFactura());
	$datosServiciosExtras = $sanetizar->sanitizeRecursive($modeloFactura->consultarServiciosExtras());
	$x = $sanetizar->sanitizeRecursive($modeloFactura->comprobarSiFueHospit());
	$serviciosDeHospitalizacion = $sanetizar->sanitizeRecursive($modeloFactura->serviciosIncluidosHospit());

	$vistaActiva = is_array($x) ? 1 : (int)$x;

	// Los insumos de una hospitalización se leen SIEMPRE del detalle de la
	// factura: unirInsumosHospitalizacion() devuelve los insumos pendientes del
	// registro y, si el hospitalizado ya fue cerrado, devolvía una lista vacía y
	// el comprobante salía sin insumos pese a haberlos cobrado.
	$datosInsumos = $sanetizar->sanitizeRecursive($modeloFactura->consultarFacturaInsumo());

	require_once './src/vistas/vistaFactura/comprobante.php';
}

function mostrarPaciente()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
		exit;
	}
	try {
		$modeloFactura = new ModeloFactura();
		$sanetizar = new ModeloSanetizarJSON();

		$sanetizar->setHashKeys(['id_paciente']);
		$modeloFactura->setCedula($_POST['cedula']);
		echo json_encode($sanetizar->sanitizeRecursive($modeloFactura->buscar()));
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function mostrarCliente()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
		exit;
	}
	try {
		$modeloFactura = new ModeloFactura();
		$sanetizar = new ModeloSanetizarJSON();

		$sanetizar->setHashKeys(['id_cliente']);
		$modeloFactura->setCedula($_POST['cedula']);
		echo json_encode($sanetizar->sanitizeRecursive($modeloFactura->buscarCliente()));
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function mostrarPacienteConCita()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
		exit;
	}
	$modeloFactura = new ModeloFactura();
	$sanetizar = new ModeloSanetizarJSON();

	$sanetizar->setHashKeys([
		'id_paciente', 'id_cita', 'id_servicioMedico', 'id_personal', 'id_categoria',
		// La consulta aliasa el doctor como `id_doctor_c`. Sin hashearlo, el
		// navegador manda el id crudo en `doctores[]` y unhashId() lanza
		// "Identificador inválido o manipulado" al confirmar la factura.
		'id_doctor_c',
	]);
	$modeloFactura->setCedula($_POST["cedula"]);
	echo json_encode($sanetizar->sanitizeRecursive($modeloFactura->buscarPacientePorCita()));
}

/**
 * Descuenta del inventario los insumos consumidos durante una hospitalización.
 *
 * Se invoca al cerrar la hospitalización. El flujo anterior lo hacía el
 * procedimiento DescontarLotes, que recorría los lotes y terminaba sin error
 * aunque no alcanzara el stock.
 */
function registrarInsumosHospitalizacion()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => 'Petición vacía.']);
		exit;
	}

	$csrf = $_POST['csrf_token'] ?? (getallheaders()['X-CSRF-Token'] ?? null);
	if (empty($_SESSION['csrf_token']) || empty($csrf) || !hash_equals($_SESSION['csrf_token'], $csrf)) {
		http_response_code(403);
		echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
		exit;
	}

	try {
		$idH = !empty($_POST['id_hospitalizacion']) ? unhashId($_POST['id_hospitalizacion']) : 0;
		$modelo = new ModeloFacturaHospitalizacion();
		$modelo->setIdH($idH);
		$resultado = $modelo->registrarConsumo($_SESSION['id_usuario'] ?? null);
	} catch (\Throwable $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}

	if (!empty($resultado['exito'])) {
		echo json_encode(['ok' => true, 'message' => 'Consumo de insumos registrado.']);
		exit;
	}

	http_response_code(409);
	echo json_encode(['ok' => false, 'error' => $resultado['error']]);
	exit;
}

function guardarFactura()
{
	if (empty($_POST)) {
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/factura");
		exit;
	}

	$headers = getallheaders();
	$csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;

	if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
		http_response_code(403);
		echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
		exit;
	}

	$idUsuario = $_SESSION['id_usuario'] ?? null;
	$modeloBitacora = new ModeloBitacora();
	$modeloFactura  = new ModeloFactura();

	try {
		$id_cliente_input = !empty($_POST["id_cliente"]) ? unhashId($_POST["id_cliente"]) : 0;
		$id_paciente_input = isset($_POST["id_paciente"]) && !empty($_POST["id_paciente"]) ? unhashId($_POST["id_paciente"]) : 0;
		$id_cita_input = isset($_POST["id_cita"]) && !empty($_POST["id_cita"]) ? unhashId($_POST["id_cita"]) : 0;
		$id_hosp_input = isset($_POST["id_hospitalizacion"]) && !empty($_POST["id_hospitalizacion"]) ? unhashId($_POST["id_hospitalizacion"]) : 0;

		$modeloFactura->setFecha(date("Y-m-d"));
		$modeloFactura->setServicios(isset($_POST["servicios"]) ? array_map('unhashId', $_POST["servicios"]) : []);
		$modeloFactura->setInsumos(isset($_POST["insumos"]) ? array_map('unhashId', $_POST["insumos"]) : []);
		$modeloFactura->setDoctores(isset($_POST["doctores"]) ? array_map(
			fn($d) => ($d === '' ? null : unhashId($d)),
			$_POST["doctores"]
		) : []);
		$modeloFactura->setCatidad($_POST["cantidad"] ?? []);
		$modeloFactura->setPrecioInsumo($_POST["precioInsumo"] ?? []);
		// Tasa con la que el navegador calculó los importes: se guarda en la
		// factura y se contrasta contra la del servidor (nunca se confía en ella).
		$modeloFactura->setTipoCambio($_POST["tipo_cambio"] ?? 0);
		// Indicador de IVA por insumo, para persistirlo en detalle_factura y que
		// el comprobante pueda separar base e impuesto sin inventarse un 30%.
		$modeloFactura->setAplicaIVA($_POST["aplicaIVA"] ?? []);
		$modeloFactura->setPrecioServicio($_POST["precioServicio"] ?? []);
		$modeloFactura->setIdCliente($id_cliente_input);
		$modeloFactura->setIdPaciente($id_paciente_input);
		$modeloFactura->setIdCita($id_cita_input);
		$modeloFactura->setReferencia(!empty($_POST["referencia"]) ? $_POST["referencia"] : 0);
		$modeloFactura->setIdH($id_hosp_input);
		$modeloFactura->setTotal($_POST["total"] ?? 0);
		$modeloFactura->setFormasDePago(isset($_POST["formasDePago"]) ? array_map('unhashId', $_POST["formasDePago"]) : []);
		$modeloFactura->setMontosPago($_POST["montosDePago"] ?? []);
	} catch (\Throwable $e) {
		// Errores de validación/identificadores: se responde al usuario en vez
		// de reventar con un error 500 y la traza completa en pantalla
		// (display_errors está activo en este proyecto).
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}

	// Resolver cliente: se necesita un id_cliente válido para la factura.
	try {
		if (!$modeloFactura->getIdCliente()) {
			if (!$id_paciente_input) {
				throw new \DomainException("Debe seleccionar un paciente o un cliente antes de facturar.");
			}

			$coincidencia = $modeloFactura->coincidenciaPacienteCliente();
			if ($coincidencia && !is_array($coincidencia)) {
				$id_cliente = $coincidencia;
			} else {
				$guardado = $modeloFactura->guardarCliente($idUsuario);
				if (!is_array($guardado) || !isset($guardado[1])) {
					throw new \DomainException("No se pudo obtener el cliente de la factura.");
				}
				$id_cliente = $guardado[1];
			}
			$modeloFactura->setIdCliente($id_cliente);
		}
	} catch (\Throwable $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}

	$guardar = $modeloFactura->guardarFactura($idUsuario);

	// El modelo devuelve SIEMPRE ['exito' => bool, ...]. Antes devolvía un string
	// con el mensaje de error, que al ser truthy se tomaba como éxito: se
	// escribía la bitácora y se redirigía a un comprobante inexistente,
	// perdiendo la factura sin avisar al usuario.
	if (is_array($guardar) && !empty($guardar['exito'])) {
		$modeloBitacora->setId_usuario($idUsuario);
		$modeloBitacora->setActividad("Ha facturado servicios y/o insumos");
		$modeloBitacora->setTabla("factura");
		$modeloBitacora->insertarBitacora($idUsuario);

		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/comprobante/" . hashId((int)$guardar['id_factura']));
		exit;
	}

	$error = is_array($guardar) ? ($guardar['error'] ?? 'No se pudo registrar la factura.') : 'No se pudo registrar la factura.';
	error_log("Factura rechazado: " . $error);

	http_response_code(409);
	echo json_encode(['ok' => false, 'error' => $error]);
	exit;
}

function mostrarPDF($parametro)
{
	$modeloFactura = new ModeloFactura();
	$sanetizar = new ModeloSanetizarJSON();

	$sanetizar->setHashKeys(['id_factura', 'id_pago', 'id_servicioMedico', 'id_doctor', 'id_hospitalizacion', 'id_entradaDeInsumo', 'id_insumo']);
	$modeloFactura->setIdFactura(unhashId($parametro[0]));
	$datosFactura = $sanetizar->sanitizeRecursive($modeloFactura->consultarFacturaSinCita());
	$datosPago = $sanetizar->sanitizeRecursive($modeloFactura->consultarPagoFactura());
	$datosServiciosExtras = $sanetizar->sanitizeRecursive($modeloFactura->consultarServiciosExtras());
	$datosInsumos = $sanetizar->sanitizeRecursive($modeloFactura->consultarFacturaInsumo());
	require_once './src/vistas/vistaFactura/vistaFacturaPdf.php';
}

function mostrarPDF2()
{
	require_once './src/vistas/vistaFactura/vistaFacturaPdf2.php';
}

function mostrarPDF3()
{
	require_once './src/vistas/vistaFactura/vistaFacturaPdf3.php';
}