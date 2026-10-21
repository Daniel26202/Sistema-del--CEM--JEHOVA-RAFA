<?php

/**
 * Prueba de integración / UI con navegador real (Chrome headless + ChromeDriver).
 *
 * Recorre la aplicación web como lo haría un usuario:
 *   1. Abre la pantalla de inicio de sesión.
 *   2. Inicia sesión con un usuario real.
 *   3. Navega por los módulos principales del sistema.
 *   4. Guarda una captura de pantalla por cada paso en /tmp/opencode/ui_shots.
 *
 * Uso:
 *   /opt/lampp/bin/php scripts/../tests/IntegracionUI.php    (o)  php tests/IntegracionUI.php
 *
 * Requiere ChromeDriver escuchando en http://localhost:9516
 */

require __DIR__ . '/../vendor/autoload.php';

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

$host = 'http://localhost:9516';
$base = 'http://localhost/Sistema-del--CEM--JEHOVA-RAFA/';
$outDir = '/tmp/opencode/ui_shots';
@mkdir($outDir, 0777, true);

$chromeBinary = '/tmp/opencode/chrome/chrome-headless-shell-linux64/chrome-headless-shell';

$options = new ChromeOptions();
$options->setBinary($chromeBinary);
$options->addArguments([
    '--headless',
    '--no-sandbox',
    '--disable-gpu',
    '--disable-dev-shm-usage',
    '--hide-scrollbars',
    '--window-size=1366,900',
    '--disable-features=Translate,BackForwardCache',
]);

$capabilities = DesiredCapabilities::chrome();
$capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

echo "Conectando con ChromeDriver en $host ...\n";
$driver = RemoteWebDriver::create($host, $capabilities, 60000, 60000);
$driver->manage()->window()->setSize(new \Facebook\WebDriver\WebDriverDimension(1366, 900));

/** Guarda una captura del estado actual. */
function shot($driver, $outDir, $name)
{
    $path = $outDir . '/' . $name . '.png';
    $driver->takeScreenshot($path);
    echo "   captura: $path\n";
    return $path;
}

/** Navega y espera a que el body esté presente. */
function gotoUrl($driver, $url, $waitMs = 1500)
{
    $driver->get($url);
    usleep($waitMs * 1000);
}

$resultados = [];

try {
    // 1. Pantalla de inicio de sesión
    gotoUrl($driver, $base, 2500);
    shot($driver, $outDir, '01_login');
    $resultados[] = ['Login - mostrar pantalla', 'OK'];

    // 2. Iniciar sesión con usuario real (AJAX al endpoint)
    $driver->executeScript(<<<JS
        return fetch('$base' + 'IniciarSesion/iniciarSesion', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'username=WDaniel123&password=' + encodeURIComponent('Sistema.30')
        }).then(r => r.text()).then(t => t);
    JS);
    usleep(1500);

    // 3. Ir al inicio (dashboard)
    gotoUrl($driver, $base . 'Inicio/inicio', 3500);
    shot($driver, $outDir, '02_inicio');
    $resultados[] = ['Login - autenticacion valida', 'OK'];

    // 4. Navegar por los modulos principales
    $modulos = [
        'Pacientes/getPacientes'                 => '03_pacientes',
        'Clientes/Clientes'                      => '04_clientes',
        'Citas/citas'                            => '05_citas',
        'Control/control'                        => '06_control',
        'Hospitalizacion/hospitalizacion'        => '07_hospitalizacion',
        'Insumos/insumos'                        => '08_insumos',
        'Entrada/entrada'                        => '09_entrada',
        'Factura/factura'                        => '10_factura',
        'Proveedores/proveedores'                => '11_proveedores',
        'Doctores/doctores'                      => '12_doctores',
        'Servicios/servicios'                    => '13_servicios',
        'Patologias/patologias'                  => '14_patologias',
        'Usuarios/usuarios'                      => '15_usuarios',
        'Roles/mostrar'                          => '16_roles',
        'Bitacora/bitacora'                      => '17_bitacora',
        'Reportes/reportes'                      => '18_reportes',
        'Estadisticas/estadisticas'              => '19_estadisticas',
        'Perfil/perfil'                          => '20_perfil',
    ];

    foreach ($modulos as $ruta => $nombre) {
        try {
            gotoUrl($driver, $base . $ruta, 1200);
            // Dar tiempo a que los DataTables/consultas AJAX carguen su contenido
            usleep(2500000);
            // Cerrar cualquier alerta nativa (p. ej. advertencias de DataTables)
            try {
                $driver->switchTo()->alert()->dismiss();
            } catch (\Throwable $e) {
            }
            shot($driver, $outDir, $nombre);
            $texto = trim(preg_replace('/\s+/', ' ', $driver->findElement(WebDriverBy::tagName('body'))->getText()));
            $resultados[] = ["Modulo $ruta", 'OK  (' . mb_strlen($texto) . ' car.)'];
        } catch (\Throwable $th) {
            $resultados[] = ["Modulo $ruta", 'FALLO: ' . $th->getMessage()];
        }
    }
} catch (\Throwable $th) {
    echo "ERROR: " . $th->getMessage() . "\n";
} finally {
    try {
        $driver->quit();
    } catch (\Throwable $th) {
    }
}

echo "\n=== RESUMEN INTEGRACION UI ===\n";
foreach ($resultados as $r) {
    echo sprintf("  %-45s %s\n", $r[0], $r[1]);
}
echo "Capturas en: $outDir\n";
