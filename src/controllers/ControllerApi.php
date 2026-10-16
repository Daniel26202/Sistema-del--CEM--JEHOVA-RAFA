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

/**
 * Verifica que la petición traiga la API key compartida correcta.
 * Si falta o no coincide, corta con 401.
 */
function validarApiKeyCompartida()
{
    $headers  = getallheaders();
    $recibida = $headers['X-API-Key'] ?? $headers['x-api-key'] ?? '';
    $esperada = $_ENV['API_KEY_IA'] ?? '';

    if (empty($esperada) || $recibida !== $esperada) {
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