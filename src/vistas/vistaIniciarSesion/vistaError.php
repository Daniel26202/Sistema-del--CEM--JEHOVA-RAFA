<?php


// Obtiene la ruta local eliminando barras inclinadas iniciales y finales.
// $_SERVER["REQUEST_URI"] contiene la URL solicitada al servidor.
// parse_url() extrae la parte de la URL que corresponde al camino (path).
// trim() elimina cualquier barra inclinada ('/') al inicio y al final de la cadena resultante.
$ruta_local = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), '/');

// Establece un valor predeterminado para el "concatenador especial" como un punto (.).
$concatenadorEspecial = '.';

// Define una función personalizada para verificar si una cadena termina con un sufijo dado.
// $haystack es la cadena principal y $needle es el sufijo buscado.
function ends_with($haystack, $needle)
{
    $length = strlen($needle); // Calcula la longitud del sufijo.
    if ($length === 0) { // Si el sufijo está vacío, siempre retorna true.
        return true;
    }
    // Verifica si el final de la cadena principal coincide con el sufijo.
    return substr($haystack, -$length) === $needle;
}

// Verifica si $ruta_local termina con el texto especificado.
// Si termina con "Sistema-del--CEM--JEHOVA-RAFA", se limpia el valor del "concatenador especial".
if (ends_with($ruta_local, 'Sistema-del--CEM--JEHOVA-RAFA')) {
    $concatenadorEspecial = "";
}

// Inicializa una cadena vacía para construir la ruta concatenada.
$concatenarRuta = "";

// Verifica si el array $parametro no está vacío.
// Si contiene valores, recorre cada elemento y concatena '../' por cada uno.
// Esto se usa para construir un camino relativo dependiendo de los valores en $parametro.
if (!empty($parametro)) {
    foreach ($parametro as $p) {
        $concatenarRuta .= "../";
    }
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J-R</title>
    <link rel="stylesheet" type="text/css" href="<?= $concatenarRuta ?><?= $concatenadorEspecial ?>./src/assets/uikit/css/uikit.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $concatenarRuta ?><?= $concatenadorEspecial ?>./src/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $concatenarRuta ?><?= $concatenadorEspecial ?>./src/assets/cssVista/error.css">

</head>


<?php $urlBase =  $concatenarRuta . '' . $concatenadorEspecial; ?>

<body>
    <div>
        <div class="fondo-tabla-error w-75 m-auto">
            <h1 class="titulo text-center display-1 fw-bold ">ERROR</h1>
            <h2 class="titulo text-center display-1 fw-bold ">404</h2>
            <p class="p text-center lead">Lo sentimos, no tiene permiso acceder a esta pagina o no se encuentra disponible.</p>
            <p class="p text-center lead">Por favor vuelve al <a class="p" href="/Sistema-del--CEM--JEHOVA-RAFA/">Inicio session</a> o contacte al administrador si crees que esto es un error.</p>
        </div>
    </div>
</body>




</html>