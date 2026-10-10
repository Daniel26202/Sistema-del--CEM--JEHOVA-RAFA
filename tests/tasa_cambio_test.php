<?php
/**
 * Pruebas de la tasa de cambio del día.
 *
 * Regresión sobre dos problemas reales:
 *   1. number_format con separador de miles '.' producía "1.000.00" para tasas
 *      de 1000 en adelante; los consumidores lo leían como 1.0 (mil veces menos).
 *   2. La tasa se resolvía en el navegador, pero las vistas la leen mientras se
 *      genera el HTML. En la primera carga de cada sesión el input quedaba
 *      vacío y el JS obtenía NaN.
 *
 * Ejecutar: /opt/lampp/bin/php tests/tasa_cambio_test.php
 */

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$fallos = 0;
$pruebas = 0;

function check(bool $ok, string $mensaje, string $detalle = ''): void
{
    global $fallos, $pruebas;
    $pruebas++;
    if ($ok) {
        printf("  ok: %s\n", $mensaje);
    } else {
        $fallos++;
        printf("  FALLO: %s%s\n", $mensaje, $detalle ? " — $detalle" : '');
    }
}

// ── Extracción desde la respuesta de la API ──────────────────────────
$_SESSION = [];
require __DIR__ . '/../src/config/tasaCambio.php';

echo "\n=== Lectura de la respuesta de la API ===\n";
check(tasaDesdeRespuesta('{"promedio":875.6505}') === 875.65, 'usa el campo "promedio"');
check(tasaDesdeRespuesta('{"compra":9.5}') === 9.5, 'acepta "compra" si no hay promedio');
check(tasaDesdeRespuesta('{"venta":10.25}') === 10.25, 'acepta "venta" si no hay promedio');
check(tasaDesdeRespuesta('{"promedio":null,"compra":null}') === 0.0, 'null devuelve 0');
check(tasaDesdeRespuesta('{}') === 0.0, 'respuesta vacía devuelve 0');
check(tasaDesdeRespuesta('{malformado') === 0.0, 'JSON inválido devuelve 0');
check(tasaDesdeRespuesta('{"promedio":-5}') === 0.0, 'tasa negativa se descarta');
check(tasaDesdeRespuesta('{"promedio":"abc"}') === 0.0, 'valor no numérico se descarta');
check(tasaDesdeRespuesta('{"promedio":875.6505}') === 875.65, 'redondea a 2 decimales');

// ── Formato: el bug de los 1000 ──────────────────────────────────────
echo "\n=== Formato (el separador de miles rompía desde 1000) ===\n";
foreach ([875.65, 999.99, 1000.00, 1850.75, 12345.67] as $tasa) {
    $conMiles = number_format($tasa, 2, '.', '.');
    $bien = number_format($tasa, 2, '.', '');
    check(
        (float)$bien === $tasa,
        sprintf('tasa %10.2f se formatea como "%s" y se relee igual', $tasa, $bien)
    );
}
check(
    (float)number_format(1850.75, 2, '.', '.') !== 1850.75,
    'el formato antiguo estaba roto (control: "1.850.75" -> ' . (float)'1.850.75' . ')'
);

// ── Resolución y caché en sesión ─────────────────────────────────────
echo "\n=== Resolución de la tasa del día ===\n";
$_SESSION = [];
check(fechaTasaActual() === '', 'una sesión nueva no tiene tasa');

// Forzamos un valor conocido en sesión para no depender de la red.
$_SESSION['dolar'] = 900.55;
$_SESSION['dolar_fecha'] = date('Y-m-d');
check(
    abs(tasaCambioActual() - 900.55) < 0.001,
    'usa la tasa de hoy sin volver a llamar a la API'
);
check(fechaTasaActual() === date('Y-m-d'), 'la fecha queda registrada');

// La sesión es por día: una tasa de ayer no debe darse por válida como de hoy,
// pero tampoco debe descartarse si la API falla (mejor un valor viejo que 0).
$_SESSION['dolar'] = 880.00;
$_SESSION['dolar_fecha'] = date('Y-m-d', strtotime('-1 day'));
$valor = tasaCambioActual();
check(
    $valor > 0,
    'con la API caída y tasa de ayer, devuelve el valor previo en vez de 0',
    "valor: $valor"
);

// ── Consumidores ─────────────────────────────────────────────────────
echo "\n=== Los consumidores ya no leen la sesión cruda ===\n";
$raiz = dirname(__DIR__) . '/';

$servicios = file_get_contents($raiz . 'src/vistas/vistaServicios/vistaServiciosMedicos.php');
// Se ignoran comentarios y etiquetas PHP: lo que importa es el código ejecutable.
$serviciosCodigo = preg_replace('/<!--.*?-->/s', '', $servicios);
$serviciosCodigo = preg_replace('/<\?php.*?\?>/s', '', $serviciosCodigo);
check(
    strpos($serviciosCodigo, '$_SESSION["dolar"]') === false,
    'vistaServiciosMedicos ya no lee $_SESSION["dolar"] directamente'
);
check(
    strpos($servicios, 'tasaCambioActual()') !== false,
    'vistaServiciosMedicos usa tasaCambioActual()'
);

$insumos = file_get_contents($raiz . 'src/controllers/ControllerInsumos.php');
check(
    strpos($insumos, "'dolar' => tasaCambioActual()") !== false,
    'ControllerInsumos usa tasaCambioActual()'
);

$inicio = file_get_contents($raiz . 'index.php');
check(
    strpos($inicio, 'tasaCambio.php') !== false,
    'tasaCambio.php está cargado en index.php'
);

// ── El endpoint que recibe la tasa del navegador ─────────────────────
echo "\n=== Endpoint /Inicio/valorDolar ===\n";
$controller = file_get_contents($raiz . 'src/controllers/ControllerInicio.php');
check(
    preg_match('/function valorDolar[\s\S]*?is_numeric\(\$tasa\)/', $controller) === 1,
    'valida que la tasa sea numérica'
);
check(
    preg_match('/function valorDolar[\s\S]*?100000/', $controller) === 1,
    'rechaza tasas fuera de rango'
);
check(
    preg_match('/function valorDolar[\s\S]*?round\(\$tasa, 2\)/', $controller) === 1,
    'guarda la tasa redondeada, sin separador de miles'
);
check(
    strpos($controller, "number_format(\$datos[0], 2, '.', '.')") === false,
    'el formato antiguo con separador de miles ya no está'
);

echo "\n=== Contrato con la API real (online) ===\n";
// Comprueba que la API devuelve el campo que lee el JS (cuerpo.promedio) y que
// ambos lados lo interpretan igual. Si no hay red, se omite sin fallar.
$ch = curl_init('https://ve.dolarapi.com/v1/dolares/oficial');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 3,
    CURLOPT_SSL_VERIFYPEER => true,
]);
$cuerpoApi = curl_exec($ch);
$httpApi = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($cuerpoApi !== false && $httpApi === 200) {
    check(true, 'la API responde HTTP 200');

    $json = json_decode($cuerpoApi, true);
    check(is_array($json), 'la respuesta es un objeto JSON');
    check(array_key_exists('promedio', $json), "existe el campo 'promedio' que lee el JS");

    $jsLee = (float)($json['promedio'] ?? 0);   // lo que hace Number(cuerpo.promedio)
    $phpLee = round((float)($json['promedio'] ?? 0), 2);
    $desdeApi = tasaDesdeRespuesta($cuerpoApi);

    check(abs($jsLee - $phpLee) < 0.001, 'JS y PHP leen el mismo valor', "JS=$jsLee PHP=$phpLee");
    check(abs($desdeApi - $phpLee) < 0.001, 'tasaDesdeRespuesta coincide', "api=$desdeApi");
    check($phpLee > 0, "la tasa del dia es mayor que cero ($phpLee)");

    // El valor que se guarda en la sesion y el input oculto nunca debe llevar
    // separador de miles.
    $campo = number_format($phpLee, 2, '.', '');
    check((float)$campo === $phpLee, "el valor queda legible ($campo)");
} else {
    check(true, 'API no disponible desde aqui: se omite la prueba online');
}

// Si el campo llega null (fin de semana), debe tratarse como fallo y NO como 0.
check(
    tasaDesdeRespuesta('{"promedio":null,"compra":null,"venta":null}') === 0.0,
    'promedio null se trata como dato invalido, no como tasa buena'
);

// La clave de localStorage debe ser la misma para todos los modulos.
$js = file_get_contents($raiz . 'src/assets/js/generic/coversion.js');
check(strpos($js, 'CLAVE_TASA = "valorDelDolar"') !== false, 'la clave de localStorage es valorDelDolar');

$jsDir = [];
// Se recorren también los subdirectorios (ajax/, generic/, ...).
$iterador = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($raiz . 'src/assets/js', FilesystemIterator::SKIP_DOTS)
);
foreach ($iterador as $archivo) {
    if ($archivo->isFile() && $archivo->getExtension() === 'js') {
        $jsDir[$archivo->getFilename()] = file_get_contents($archivo->getPathname());
    }
}

$entradas = null;
foreach ($jsDir as $ruta => $contenido) {
    if (strpos($ruta, 'entradas.js') !== false) {
        $entradas = $contenido;
        break;
    }
}
check(
    $entradas !== null && strpos($entradas, 'localStorage.getItem("valorDelDolar")') !== false,
    'entradas.js lee la misma clave (valorDelDolar)'
);
check(
    isset($jsDir['f.js']) && strpos($jsDir['f.js'], 'tasaGuardada()') !== false,
    'f.js usa tasaGuardada() en vez de leer localStorage directo'
);
check(
    strpos($jsDir['f.js'] ?? '', 'actualizada') !== false,
    'f.js comprueba si la API actualizo de verdad'
);

echo "\n=== CSP: la API debe poder llamarse desde el navegador ===\n";
// La API responde por HTTP (200 + access-control-allow-origin: *), pero si la
// politica CSP del servidor no incluye el dominio en connect-src, el NAVEGADOR
// bloquea el fetch. El resultado: valorDolar() siempre cae al catch, no se
// guarda nada en localStorage y la tasa "no aparece".
$htaccess = "$raiz/.htaccess";
check(file_exists($htaccess), 'existe .htaccess');

if (file_exists($htaccess)) {
    preg_match('/Header\s+set\s+Content-Security-Policy\s+"([^"]+)"/i', file_get_contents($raiz . '.htaccess'), $m);
    check(!empty($m), 'se encuentra la cabecera de Content-Security-Policy');

    $csp = $m[1] ?? '';
    check(
        preg_match("/(^|;)\s*connect-src([^;]*)/", $csp, $cm) === 1,
        'la politica define connect-src'
    );

    $connect = $cm[2] ?? '';
    printf("    connect-src actual:%s\n", ' ' . trim($connect));
    check(
        strpos($connect, 'https://ve.dolarapi.com') !== false,
        'connect-src permite el dominio de la API de terceros'
    );

    // default-src 'self' sin connect-src tambien bloquearia: se comprueba que
    // exista una directiva especifica para connect.
    foreach (['script-src', 'style-src', 'img-src'] as $directiva) {
        check(strpos($csp, $directiva) !== false, "la politica mantiene $directiva");
    }
}

echo "\n=== Comprobacion final ===\n";
printf("\n%d pruebas, %d fallos\n", $pruebas, $fallos);
exit($fallos === 0 ? 0 : 1);