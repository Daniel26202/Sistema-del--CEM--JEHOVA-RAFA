<?php
require_once "./vendor/autoload.php";
use App\config\Rutas;

$url = isset($_GET['url']) ? $_GET['url'] :  "IniciarSesion/mostrarIniciarSesion";

// borrar cache ...
header("Cache-Control: no-cache, no-store, must-revalidate"); // Combina instrucciones clave
header("Pragma: no-cache");
header("Expires: 0"); // Usar "0" es una práctica más común para evitar confusiones


$rutas = new Rutas($url);
$rutas->gestionarRutas();