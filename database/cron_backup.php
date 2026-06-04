<?php
// cron_backup.php

$baseDir =__DIR__.'/..';

if (php_sapi_name() !== 'cli') {
    die("Acceso denegado. Este script solo puede ejecutarse desde la terminal.");
}

//cargar el vendor de Composer si existe
if (file_exists($baseDir. "/vendor/autoload.php")) {
    require_once $baseDir. "/vendor/autoload.php";
}


$dotenv = Dotenv\Dotenv::createImmutable($baseDir);
$dotenv->load();

require_once $baseDir . "/src/modelos/ModelBase.php";
require_once $baseDir . "/src/modelos/ModeloMantenimiento.php";

use App\modelos\ModeloMantenimiento;

//tomo el tipo de respaldo desde la consola, si no hay, se hará un respaldo completo por defecto
$tipo = isset($argv[1]) ? $argv[1] : 'completo';
$backupRuta = __DIR__ . "/../src/config/backups/";

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
