<?php
require_once "./vendor/autoload.php";
use App\config\Rutas;
$url = isset($_GET['url']) ? $_GET['url'] :  "IniciarSesion/mostrarIniciarSesion";

$rutas = new Rutas($url);
$rutas->gestionarRutas();