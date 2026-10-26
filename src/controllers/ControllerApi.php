<?php
/**
 * Endpoints internos para el componente inteligente (FastAPI).
 *
 * A diferencia del resto del sistema, estos endpoints NO usan sesión de usuario
 * porque son consumidos servicio-a-servicio por el backend Python. En su lugar
 * exigen una API key compartida, guardada en el .env del sistema.
 *
 * Son solo de lectura: el componente inteligente nunca modifica datos.
 */

use App\modelos\ModeloCategoria;
use App\modelos\ModeloCita;
use App\modelos\ModeloApi;

/**
 * Verifica que la petición traiga la API key compartida correcta.
 * Si falta o no coincide, corta con 401.
 */
function validarApiKeyCompartida()
{
    $headers  = function_exists('getallheaders') ? getallheaders() : [];
    $headers  = array_change_key_case($headers, CASE_LOWER);
    $recibida = $headers['x-api-key'] ?? '';
    $esperada = $_ENV['API_KEY_IA'] ?? '';

    if ($esperada === '' || !hash_equals($esperada, $recibida)) {
        http_response_code(401);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => false, 'error' => 'API key inválida o ausente']);
        exit;
    }
}

/**
 * Devuelve las categorías de servicio activas (especialidades que ofrece el centro).
 */
function apiEspecialidades()
{
    if (ob_get_length()) ob_clean();
    validarApiKeyCompartida();
    header('Content-Type: application/json; charset=utf-8');

    $modelo     = new ModeloCategoria();
    $categorias = $modelo->seleccionarCategoria();

    echo json_encode($categorias);
    exit;
}

/**
 * Devuelve los doctores activos de una categoría.
 * Parámetro: id_categoria (entero, uso interno sin hash).
 */
function apiDoctoresPorEspecialidad($datos)
{
    if (ob_get_length()) ob_clean();
    validarApiKeyCompartida();

    if (empty($datos[0]) || !is_numeric($datos[0])) {
        http_response_code(400);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => false, 'error' => 'ID de especialidad requerido']);
        exit;
    }

    header('Content-Type: application/json; charset=utf-8');

    $cita = new ModeloCita();
    $cita->setIdServicioMedico((int)$datos[0]);
    $doctores = $cita->mostrarDoctores();

    echo json_encode($doctores);
    exit;
}

/**
 * Datos clínicos del PACIENTE asociado al usuario logueado (por cédula).
 *
 * Todo se resuelve a partir del id_usuario: el componente inteligente nunca
 * elige qué paciente leer. Solo el personal del centro tiene acceso; un
 * "usuario normal" recibe acceso denegado.
 *
 * Parámetro: id_usuario (entero, uso interno sin hash).
 */
function apiDatosUsuario($datos)
{
    if (ob_get_length()) ob_clean();
    validarApiKeyCompartida();
    header('Content-Type: application/json; charset=utf-8');

    if (empty($datos[0]) || !is_numeric($datos[0])) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'ID de usuario requerido']);
        exit;
    }

    $idUsuario = (int)$datos[0];
    $modelo    = new ModeloApi();

    if (!$modelo->esPersonalDelCentro($idUsuario)) {
        echo json_encode([
            'ok'     => true,
            'acceso' => 'denegado',
            'motivo' => 'El usuario no pertenece al personal del centro.',
        ]);
        exit;
    }

    $paciente = $modelo->pacienteDeUsuario($idUsuario);
    if (!$paciente) {
        echo json_encode([
            'ok'     => true,
            'acceso' => 'permitido',
            'motivo' => 'El usuario no tiene un paciente asociado a su cédula.',
            'paciente' => null,
        ]);
        exit;
    }

    $idPaciente = (int)$paciente['id_paciente'];

    echo json_encode([
        'ok'                => true,
        'acceso'            => 'permitido',
        'paciente'          => $paciente,
        'historial'         => $modelo->historialDePaciente($idPaciente),
        'citas'             => $modelo->citasDePaciente($idPaciente),
        'hospitalizaciones' => $modelo->hospitalizacionesDePaciente($idPaciente),
    ]);
    exit;
}

/**
 * Exige que la petición venga identificada con un usuario del personal.
 * Se usa en los endpoints que exponen datos clínicos de terceros.
 */
function validarPersonalDelCentroApi(): int
{
    $headers = function_exists('getallheaders') ? getallheaders() : [];
    $headers = array_change_key_case($headers, CASE_LOWER);
    $idUsuario = $headers['x-usuario-id'] ?? '';

    if ($idUsuario === '' || !is_numeric($idUsuario)) {
        http_response_code(403);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => false, 'error' => 'Usuario no identificado']);
        exit;
    }

    $modelo = new ModeloApi();
    if (!$modelo->esPersonalDelCentro((int)$idUsuario)) {
        http_response_code(403);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => false, 'error' => 'Sin permiso para consultar pacientes']);
        exit;
    }

    return (int)$idUsuario;
}

/**
 * Busca pacientes por cédula, nombre o apellido.
 * Query: ?q=texto
 */
function apiBuscarPaciente($datos = [])
{
    if (ob_get_length()) ob_clean();
    validarApiKeyCompartida();
    validarPersonalDelCentroApi();
    header('Content-Type: application/json; charset=utf-8');

    $q = trim($_GET['q'] ?? '');
    if (mb_strlen($q) < 2) {
        echo json_encode([]);
        exit;
    }

    $modelo = new ModeloApi();
    echo json_encode($modelo->buscarPacientes($q));
    exit;
}

/**
 * Controles de los últimos 6 meses del paciente.
 * Parámetro: id_paciente (entero).
 */
function apiControlesPaciente($datos)
{
    if (ob_get_length()) ob_clean();
    validarApiKeyCompartida();
    validarPersonalDelCentroApi();
    header('Content-Type: application/json; charset=utf-8');

    if (empty($datos[0]) || !is_numeric($datos[0])) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'ID de paciente requerido']);
        exit;
    }

    $modelo = new ModeloApi();
    echo json_encode($modelo->controlesRecientes((int)$datos[0]));
    exit;
}

/**
 * Patologías diagnosticadas al paciente.
 * Parámetro: id_paciente (entero).
 */
function apiPatologiasPaciente($datos)
{
    if (ob_get_length()) ob_clean();
    validarApiKeyCompartida();
    validarPersonalDelCentroApi();
    header('Content-Type: application/json; charset=utf-8');

    if (empty($datos[0]) || !is_numeric($datos[0])) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'ID de paciente requerido']);
        exit;
    }

    $modelo = new ModeloApi();
    echo json_encode($modelo->patologiasDePaciente((int)$datos[0]));
    exit;
}