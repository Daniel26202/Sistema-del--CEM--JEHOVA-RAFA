<?php

/**
 * Tasa de cambio del día.
 *
 * Fuente: https://ve.dolarapi.com/v1/dolares/oficial (API de terceros).
 *
 * Por qué se resuelve en PHP y no solo en el navegador:
 * las vistas leen la tasa mientras se genera el HTML (por ejemplo
 * vistaServiciosMedicos.php:17), y eso ocurre ANTES de que corra app.js, que
 * es quien llama a la API. Con la tasa solo en sesión, la primera carga de cada
 * sesión renderizaba el input vacío y el JS leía NaN.
 *
 * Orden de resolución:
 *   1) tasa de hoy ya en sesión          → se usa, sin llamar a la API
 *   2) consulta a la API (3 s de timeout) → se guarda en sesión
 *   3) tasa de un día anterior           → mejor un valor viejo que ninguno
 *   4) 0                                   → el JS avisa y permite fijarla a mano
 */

if (!function_exists('tasaCambioActual')) {
    /**
     * Devuelve la tasa vigente (Bs por dólar). Nunca lanza ni devuelve null.
     */
    function tasaCambioActual(): float
    {
        static $resuelta = null;
        if ($resuelta !== null) {
            return $resuelta;
        }

        $hoy = date('Y-m-d');
        $enSesion = isset($_SESSION['dolar']) ? (float)$_SESSION['dolar'] : 0.0;
        $fechaSesion = $_SESSION['dolar_fecha'] ?? '';

        // 1) Ya tenemos la de hoy.
        if ($enSesion > 0 && $fechaSesion === $hoy) {
            return $resuelta = $enSesion;
        }

        // 2) La pedimos a la API de terceros.
        $deInternet = tasaDesdeApi();

        if ($deInternet > 0) {
            $_SESSION['dolar'] = $deInternet;
            $_SESSION['dolar_fecha'] = $hoy;
            return $resuelta = $deInternet;
        }

        // 3) Preferimos un valor previo a un 0 que rompe todos los cálculos.
        if ($enSesion > 0) {
            error_log("Tasa de cambio: la API no respondió, se usa la de $fechaSesion ($enSesion)");
            return $resuelta = $enSesion;
        }

        error_log("Tasa de cambio: no se pudo obtener el valor del día");
        return $resuelta = 0.0;
    }

    /**
     * Consulta la tasa a la API de terceros.
     *
     * @return float 0 si no se pudo obtener.
     */
    function tasaDesdeApi(): float
    {
        $url = 'https://ve.dolarapi.com/v1/dolares/oficial';

        if (!function_exists('curl_init')) {
            return tasaDesdeApiConStream();
        }

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 3,   // no dejar la página colgada
            CURLOPT_CONNECTTIMEOUT => 2,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT      => 'CEM-Jehova-Rafa/1.0',
        ]);

        $cuerpo = curl_exec($ch);
        $codigo = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($cuerpo === false || $codigo !== 200) {
            return 0.0;
        }

        return tasaDesdeRespuesta($cuerpo);
    }

    /** Alternativa sin cURL, por si el servidor no lo tiene habilitado. */
    function tasaDesdeApiConStream(): float
    {
        $contexto = stream_context_create([
            'http' => [
                'timeout'       => 3,
                'ignore_errors' => true,
                'user_agent'    => 'CEM-Jehova-Rafa/1.0',
            ],
        ]);

        $cuerpo = @file_get_contents(
            'https://ve.dolarapi.com/v1/dolares/oficial',
            false,
            $contexto
        );

        if ($cuerpo === false) {
            return 0.0;
        }

        return tasaDesdeRespuesta($cuerpo);
    }

    /** Extrae la tasa de la respuesta JSON de la API. */
    function tasaDesdeRespuesta(string $json): float
    {
        $datos = json_decode($json, true);
        if (!is_array($datos)) {
            return 0.0;
        }

        // La API devuelve "promedio"; algunos días puede venir null en
        // compra/venta, por eso se acepta cualquiera de los tres campos.
        foreach (['promedio', 'venta', 'compra'] as $campo) {
            $valor = $datos[$campo] ?? null;
            if (is_numeric($valor) && (float)$valor > 0) {
                return round((float)$valor, 2);
            }
        }

        return 0.0;
    }

    /** Fecha en que se obtuvo la tasa de la sesión ('' si no hay). */
    function fechaTasaActual(): string
    {
        return $_SESSION['dolar_fecha'] ?? '';
    }
}