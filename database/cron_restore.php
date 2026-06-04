<?php
// cron_restore.php
$baseDir =__DIR__.'/..';


if (php_sapi_name() !== 'cli') {
die("Acceso denegado. Este script solo puede ejecutarse desde la terminal.\n");
}

// Cargamos el autoload de Composer
if (file_exists($baseDir. "/vendor/autoload.php")) {
require_once $baseDir. "/vendor/autoload.php";
}

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable($baseDir);
$dotenv->load();

require_once $baseDir. "/src/modelos/ModelBase.php";
require_once $baseDir. "/src/modelos/ModeloMantenimiento.php";

use App\modelos\ModeloMantenimiento;

$backupRuta = $baseDir . "/src/config/backups/";

// Tomamos el nombre del archivo ZIP de los argumentos de la consola
// Si no se pasa ninguno, se asume 'nohay' para buscar el más reciente
$archivoZip = isset($argv[1]) ? $argv[1] : 'nohay';

$modelo = new ModeloMantenimiento();

if ($archivoZip === 'nohay') {
echo "Buscando el respaldo más reciente automáticamente en: $backupRuta...\n";
} else {
echo "Iniciando restauración del archivo: [$archivoZip]...\n";
}

// Ejecutamos la restauración local usando el método de tu modelo
$resultado = $modelo->restaurarBackup($backupRuta, $archivoZip);

// Validamos la respuesta del modelo
if (strpos($resultado, 'exitosa') !== false) {
echo "¡Éxito!: " . $resultado . "\n";
} else {
echo "Error en la restauración: " . $resultado . "\n";
}