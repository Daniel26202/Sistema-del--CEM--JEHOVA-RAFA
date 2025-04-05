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
    <link rel="stylesheet" href="<?= $concatenarRuta ?><?= $concatenadorEspecial ?>./src/assets/cssVista/inicioSesion.css">
    <link rel="stylesheet" type="text/css" href="<?= $concatenarRuta ?><?= $concatenadorEspecial ?>./src/assets/intro/introjs.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $concatenarRuta ?><?= $concatenadorEspecial ?>./src/assets/intro/introjs-modern.css">


</head>

<?php $urlBase =  $concatenarRuta . '' . $concatenadorEspecial; ?>


<body style=" background-color: #f2f4f8;">
    <main>

        <!-- btn de ayuda Interactiva -->
        <div class="btn_ayuda">
            <div class="d-flex justify-content-end ">
                <div class="d-flex justify-content-end ">
                    <a href="#" uk-tooltip="Ayuda">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                            class="bi bi-question-octagon-fill azul mt-3 me-3" viewBox="0 0 16 16"
                            id="btnayudaInicioSesion">
                            <path
                                d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>


        <!-- Fin btn de ayuda Interactiva -->
        <div class="d-flex justify-content-center mt-5 pt-5">

            <div class="centro" style=" ">
                <img src="<?= $urlBase ?>./src/assets/icons/logo2.png" alt="Logo" class="logo" style="width: 290px; height: 100px; margin-top: 20px; margin-left: 50px;">
                <form autocomplete="off" action="/Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/iniciarSesion" method="POST"
                    id="formiIniciarSesion">

                    <div class="w-auto ">

                        <div class="mb-5 ms-5 mt-5 pt-2 ps-4 col">
                            <h2 class="titulo fw-bolder mb-1 " id="titulo">Iniciar sesión</h2>
                            <div class="linea-titulo ">
                            </div>
                        </div>

                        <div class="fondo_rsp">
                            <div class="col formulario w-auto me-2">
                                <div class="d-flex flex-column col">

                                    <div>
                                        <?php if ($parametro != ""): ?>

                                            <?php if ($parametro[0] == "mensaje"): ?>
                                                <div class="uk-alert-danger comentario comentarioRed me-4 fw-bolder h-25 mb-2"
                                                    style="display: none;" uk-alert>
                                                    <a class="uk-alert-close" uk-close></a>
                                                    <p class="pe-2">Usuario o Contraseña incorrectos.</p>
                                                </div>
                                            <?php elseif ($parametro[0] == "captcha"): ?>
                                                <div class="uk-alert-danger comentario comentarioRed me-4 fw-bolder h-25 mb-2"
                                                    style="display: none;" uk-alert>
                                                    <a class="uk-alert-close" uk-close></a>
                                                    <p class="pe-2">Captcha fallido</p>
                                                </div>
                                            <?php elseif ($parametro[0] == "campos"): ?>
                                                <div class="uk-alert-danger comentario comentarioRed me-4 fw-bolder h-25 mb-2"
                                                    style="display: none;" uk-alert>
                                                    <a class="uk-alert-close" uk-close></a>
                                                    <p class="pe-2">Tiene que llenar todos los campos.</p>
                                                </div>
                                            <?php endif ?>
                                        <?php endif; ?>
                                    </div>

                                    <div class=" mb-3 animacionInput" id="ingresar-usuario">

                                        <svg xmlns="http://www.w3.org/2000/svg" id="icono-uno" width="20" height="20"
                                            fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                                            <path
                                                d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                        </svg>
                                        <input type="text" name="usuario" id="inputUno" class="input col"
                                            placeholder="Usuario">
                                    </div>

                                    <div id="input-password">

                                        <img src="<?= $urlBase ?>./src/assets/img/candado.svg" id="icono-dos" class="icono candado" alt="">
                                        <input type="password" name="password" id="inputDos" class="input col"
                                            placeholder="Contraseña" maxlength="40">
                                        </input>


                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <!-- recaptcha -->
                                <div class="d-flex justify-content-end mt-4 pt-3 col">
                                    <div class="g-recaptcha" data-sitekey="6Le_rOgqAAAAANVWXtJV-5eOd2CEzOFgzphoNkd1"></div>
                                </div>

                                <div class="">
                                    <input class="btn fw-bold boton col rounded-5" id="boton_inicio_sesion" type="submit" name="validar"
                                        value="Ingresar ahora" id="btnInicioSesion">
                                    <a id="recuperar_contraseña" href="/Sistema-del--CEM--JEHOVA-RAFA/RecuperarContr/mostrarRecuperarContr"
                                        class="fw-bold pointer-event text-decoration-none text-dark" id="recPassword">Recuperar Contraseña</a>

                                </div>



                            </div>
                        </div>
                    </div>

                </form>
            </div class="d-flex justify-content-center mt-5 pt-5">

    </main>


    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script type="text/javascript" src="<?= $concatenarRuta ?>../src/assets/js/inicioSesion.js"></script>
    <script type="text/javascript" src="<?= $concatenarRuta ?>../src/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="<?= $concatenarRuta ?>../src/assets/uikit/js/uikit.min.js"></script>
    <script type="text/javascript" src="<?= $concatenarRuta ?>../src/assets/intro/intro.min.js"></script>
    <script type="text/javascript" src="<?= $concatenarRuta ?>../src/assets/js/ayudaInteractiva.js"></script>


</body>

</html>