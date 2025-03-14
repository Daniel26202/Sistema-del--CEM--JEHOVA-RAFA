<?php
require_once "./vendor/autoload.php";
$url = isset($_GET['url']) ? $_GET['url'] :  "IniciarSesion/mostrarIniciarSesion";
$partes = explode("/", $url);
$controlador = ucfirst($partes['0']);
$metodo = isset($partes['1']) ? $partes['1'] : "IniciarSesion";
$parametro = "";

//si partes en la posicion 2 existe es por que se enviaron parametros
if(isset($partes[2])){
	for ($i=2; $i < count($partes); $i++) { 
		$parametro .= $partes[$i].",";
	}

	//trim en php es para quitar el ultimo caracter en este caso es para quitar la ultima "," del parametro
	$parametro = trim($parametro, ",");

}

$controlador = "Controlador".$controlador;

$directorio = "src/controladores/" . $controlador . ".php";

if (file_exists($directorio)) {
	require_once $directorio;

	$instancia = new $controlador();

	if (method_exists($instancia, $metodo)) {
		$instancia->$metodo($parametro);
	} else {
		echo "NO EXISTE EL METODO";
	}

} else {
	echo "NO EXISTE EL CONTROLADOR";
}

