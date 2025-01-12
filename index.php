<?php
require_once "./vendor/autoload.php";

$ruta = isset($_GET['c']) ? $_GET['c'] :  "ControladorIniciarSesion/mostrarIniciarSesion";
$partes = explode("/", $ruta);
$nomClase = ucfirst($partes['0']);
$metodo = isset($partes['1']) ? $partes['1'] : "IniciarSesion";
$url = "src/controladores/" . $partes['0'] . ".php";

if (file_exists($url)) {
	require_once $url;

	$instancia = new $nomClase();

	if (method_exists($instancia, $metodo)) {
		$instancia->$metodo();
	} else {
		echo "NO EXISTE EL METODO";
	}

} else {
	echo "NO EXISTE EL CONTROLADOR";
}

