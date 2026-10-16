<?php

use App\modelos\ModeloBitacora;

/**
 * La vista de chat de página completa quedó desusada: ahora el asistente se
 * abre como un modal flotante en cualquier pantalla (ver modalChat.php).
 * Cualquier enlace viejo a /Chat/chat vuelve al inicio.
 */
function chat()
{
	header("location: /Sistema-del--CEM--JEHOVA-RAFA/Inicio/inicio");
	exit;
}

/**
 * Endpoint que consume el modal del navegador (POST /Chat/preguntar).
 *
 * Hace de proxy hacia el componente inteligente en FastAPI: FastAPI nunca
 * habla directo con el navegador, así no se expone la API key ni el gemelo
 * de Gemini. Requiere sesión activa y token CSRF.
 */
function preguntar()
{
	if (ob_get_length()) ob_clean();
	header('Content-Type: application/json; charset=utf-8');

	// 1) Sesión activa (ControllerChat está exento del chequeo de permisos del
	//    router, por eso aquí se valida explícitamente).
	if (empty($_SESSION['id_usuario'])) {
		http_response_code(401);
		echo json_encode(['ok' => false, 'error' => 'Sesión no válida o expirada. Vuelva a iniciar sesión.']);
		exit;
	}

	// 2) Token CSRF (el mismo que usa el resto del sistema).
	$headers = function_exists('getallheaders') ? getallheaders() : [];
	$headersLower = array_change_key_case($headers, CASE_LOWER);
	$csrf = $headersLower['x-csrf-token'] ?? ($_POST['csrf_token'] ?? null);

	if (empty($_SESSION['csrf_token']) || empty($csrf) || !hash_equals($_SESSION['csrf_token'], $csrf)) {
		http_response_code(403);
		echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido.']);
		exit;
	}

	// 3) Cuerpo de la petición: { consulta, session_id }.
	$cuerpo = json_decode(file_get_contents('php://input'), true);
	if (!is_array($cuerpo)) {
		http_response_code(400);
		echo json_encode(['ok' => false, 'error' => 'Petición malformada.']);
		exit;
	}

	$consulta  = trim((string)($cuerpo['consulta'] ?? ''));
	$sessionId = $cuerpo['session_id'] ?? null;

	if (mb_strlen($consulta) < 2 || mb_strlen($consulta) > 2000) {
		http_response_code(422);
		echo json_encode(['ok' => false, 'error' => 'La consulta debe tener entre 2 y 2000 caracteres.']);
		exit;
	}

	$url    = $_ENV['IA_API_URL'] ?? '';
	$apiKey = $_ENV['API_KEY_IA'] ?? '';

	if ($url === '' || $apiKey === '') {
		http_response_code(503);
		echo json_encode(['ok' => false, 'error' => 'El asistente no está configurado en el servidor.']);
		exit;
	}

	$payload = json_encode([
		'consulta'   => $consulta,
		'session_id' => $sessionId,
	], JSON_UNESCAPED_UNICODE);

	// Los headers X-Usuario-* permiten al componente saber quién consulta.
	$headersEnvio = [
		'Content-Type: application/json',
		'X-API-Key: ' . $apiKey,
		'X-Usuario-Id: ' . ($_SESSION['id_usuario'] ?? ''),
		'X-Usuario-Rol: ' . ($_SESSION['rol'] ?? ''),
		'X-Usuario-Nombre: ' . trim(($_SESSION['nombre'] ?? '') . ' ' . ($_SESSION['apellido'] ?? '')),
	];

	$respuesta = enviarConsultaIA($url, $payload, $headersEnvio);

	if ($respuesta === null) {
		http_response_code(503);
		echo json_encode(['ok' => false, 'error' => 'El servicio de orientación no está disponible en este momento.']);
		exit;
	}

	// 4) Auditoría: dejar constancia de quién consultó (no rompe el chat si falla).
	try {
		$bitacora = new ModeloBitacora();
		$bitacora->setId_usuario($_SESSION['id_usuario']);
		$bitacora->setTabla('asistente_ia');
		$bitacora->setActividad('Ha consultado al asistente IA');
		$bitacora->insertarBitacora();
	} catch (\Throwable $e) {
		error_log('Asistente IA: no se pudo registrar en bitácora: ' . $e->getMessage());
	}

	echo $respuesta;
	exit;
}

/**
 * Envía la consulta al componente FastAPI.
 *
 * @return string|null Cuerpo de la respuesta (JSON) o null si falló la
 *                     comunicación con el servicio.
 */
function enviarConsultaIA(string $url, string $payload, array $headers): ?string
{
	$timeout = 30; // Gemini puede tardar; no bloquear la petición por menos.

	if (function_exists('curl_init')) {
		$ch = curl_init($url);
		curl_setopt_array($ch, [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST           => true,
			CURLOPT_POSTFIELDS     => $payload,
			CURLOPT_HTTPHEADER     => $headers,
			CURLOPT_TIMEOUT        => $timeout,
			CURLOPT_CONNECTTIMEOUT => 5,
			CURLOPT_SSL_VERIFYPEER => true,
		]);

		$cuerpo = curl_exec($ch);
		$codigo = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$error  = curl_error($ch);
		curl_close($ch);

		if ($cuerpo === false || $codigo < 200 || $codigo >= 400) {
			error_log("Asistente IA: fallo HTTP $codigo ($error) al llamar $url");
			return null;
		}

		return $cuerpo;
	}

	// Alternativa sin cURL, por si el servidor no lo tiene habilitado.
	$contexto = stream_context_create([
		'http' => [
			'method'        => 'POST',
			'header'        => implode("\r\n", $headers),
			'content'       => $payload,
			'timeout'       => $timeout,
			'ignore_errors' => true,
		],
	]);

	$cuerpo = @file_get_contents($url, false, $contexto);
	if ($cuerpo === false) {
		error_log("Asistente IA: no se pudo conectar a $url");
		return null;
	}

	return $cuerpo;
}
