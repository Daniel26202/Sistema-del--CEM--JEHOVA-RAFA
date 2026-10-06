<?php
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/config/helpers.php';

use App\config\Rutas;
// cargar variables de entorno desde el archivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$url = isset($_GET['url']) ? $_GET['url'] :  "IniciarSesion/mostrarIniciarSesion";

// borrar cache ...
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");


$rutas = new Rutas($url);
$rutas->gestionarRutas();
