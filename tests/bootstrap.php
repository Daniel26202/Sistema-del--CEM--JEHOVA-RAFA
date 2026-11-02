<?php
//configura el entorno de ejecución de las pruebas PHPUnit.

require_once __DIR__ . '/../vendor/autoload.php';

if (class_exists(Dotenv\Dotenv::class)) {
    try {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->safeLoad();
    } catch (\Throwable $e) {
        fwrite(STDERR, "Aviso: no se pudo cargar .env: " . $e->getMessage() . PHP_EOL);
    }
}

require_once __DIR__ . '/../src/config/helpers.php';
require_once __DIR__ . '/../src/config/tasaCambio.php';
require_once __DIR__ . '/TestHelpers.php';
