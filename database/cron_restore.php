<?php

$baseDir = __DIR__ . '/..';


if (php_sapi_name() !== 'cli') {
    die("Acceso denegado. Este script solo puede ejecutarse desde la terminal.\n");
}

if (file_exists($baseDir . "/vendor/autoload.php")) {
    require_once $baseDir . "/vendor/autoload.php";
}

$dotenv = Dotenv\Dotenv::createImmutable($baseDir);
$dotenv->load();

require_once $baseDir . "/src/modelos/ModelBase.php";
require_once $baseDir . "/src/modelos/ModeloMantenimiento.php";

use App\modelos\ModeloMantenimiento;

$backupRuta = $baseDir . "/src/config/backups/";

//tomo el .zip de la consola, si no hay, se buscará el más reciente automáticamente
$archivoZip = isset($argv[1]) ? $argv[1] : 'nohay';

$modelo = new ModeloMantenimiento();

if ($archivoZip === 'nohay') {
    echo "Buscando el respaldo más reciente automáticamente en: $backupRuta...\n";
} else {
    echo "Iniciando restauración del archivo: [$archivoZip]...\n";
}


$resultado = $modelo->restaurarBackup($backupRuta, $archivoZip);

//valido la respuesta del modelo
if (strpos($resultado, 'exitosa') !== false) {
    echo "¡Éxito!: " . $resultado . "\n";
} else {
    echo "Error en la restauración: " . $resultado . "\n";
}
