<?php
// cron_backup.php
if (php_sapi_name() !== 'cli') {
    die("Acceso denegado. Este script solo puede ejecutarse desde la terminal.");
}

// CARGAMOS EL AUTOLOAD DE COMPOSER PARA QUE ENCUENTRE TODAS LAS CLASES (Db, ModelBase, etc.)
if (file_exists(__DIR__ . "/vendor/autoload.php")) {
    require_once __DIR__ . "/vendor/autoload.php";
}

// cargar variables de entorno desde el archivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once __DIR__ . "/src/modelos/ModelBase.php";
require_once __DIR__ . "/src/modelos/ModeloMantenimiento.php";

use App\modelos\ModeloMantenimiento;

// Toma el argumento de la consola (completo, incremental, diferencial o log). Por defecto 'completo'.
$tipo = isset($argv[1]) ? $argv[1] : 'completo';
$backupRuta = __DIR__ . "/src/config/backups/";

if (!is_dir($backupRuta)) {
    mkdir($backupRuta, 0777, true);
}

$modelo = new ModeloMantenimiento();
echo "Iniciando respaldo automático de tipo: [$tipo]...\n";

$resultado = $modelo->generateBackup($backupRuta, $tipo);

if ($resultado === true) {
    echo "¡Respaldo ejecutado con éxito!\n";
} else {
    echo "Error en el respaldo: " . $resultado . "\n";
}
