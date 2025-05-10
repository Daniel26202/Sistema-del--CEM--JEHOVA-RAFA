<?php
require_once "./vendor/autoload.php";
use App\config\Rutas;

$url = isset($_GET['url']) ? $_GET['url'] :  "IniciarSesion/mostrarIniciarSesion";

// borrar cache ...
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");


$rutas = new Rutas($url);
$rutas->gestionarRutas();