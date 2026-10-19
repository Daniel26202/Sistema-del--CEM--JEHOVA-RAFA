<?php
/**
 * Bootstrap para la suite de pruebas PHPUnit.
 *
 * - Carga el autoloader de Composer (App\ -> src/).
 * - Carga las variables de entorno desde .env para que la clase Db
 *   (src/modelos/Db.php -> src/config/config.php) pueda conectarse.
 * - Carga los helpers usados por los modelos/controladores.
 */

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
