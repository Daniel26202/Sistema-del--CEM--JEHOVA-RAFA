<?php


$ruta_local = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), '/');


$concatenadorEspecial = '.';

function ends_with($haystack, $needle)
{
    $length = strlen($needle);
    if ($length === 0) {
        return true;
    }
    return substr($haystack, -$length) === $needle;
}

if (ends_with($ruta_local, 'Sistema-del--CEM--JEHOVA-RAFA')) {
    $concatenadorEspecial = "";
}

$concatenarRuta = "";
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

    <link rel="stylesheet" type="text/css"
        href="<?= $concatenarRuta ?><?= $concatenadorEspecial ?>./src/assets/uikit/css/uikit.min.css">
    <link rel="stylesheet" type="text/css"
        href="<?= $concatenarRuta ?><?= $concatenadorEspecial ?>./src/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="<?= $concatenarRuta ?><?= $concatenadorEspecial ?>./src/assets/cssVista/recuperarContr.css">
    <link rel="stylesheet" type="text/css"
        href="<?= $concatenarRuta ?><?= $concatenadorEspecial ?>./src/assets/intro/introjs.min.css">
    <link rel="stylesheet" type="text/css"
        href="<?= $concatenarRuta ?><?= $concatenadorEspecial ?>./src/assets/intro/introjs-modern.css">

</head>

<?php $urlBase = $concatenarRuta . '' . $concatenadorEspecial; ?>

<body>
    <main>

        <div class=" d-flex w-auto col">
            <!-- carrusel -->
            <div class="col-6">
                <div class="col-6 carrusel-responsive posicionCarrusel">

                    <!-- carrusel -->
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">

                            <div class="carousel-item active tamano">
                                <img src="<?= $urlBase ?>./src/assets/img/recuperar1.jpg"
                                    class="d-block col-12 h-100 uk-background-blend-multiply " alt="">
                            </div>
                            <div class="carousel-item tamano">
                                <img src="<?= $urlBase ?>./src/assets/img/recuperar2.png"
                                    class="d-block col-12 h-100 uk-background-blend-multiply " alt="">
                            </div>
                            <div class="carousel-item tamano">
                                <img src="<?= $urlBase ?>./src/assets/img/recuperar3.jpg"
                                    class="d-block h-100 uk-background-blend-multiply " alt="">
                            </div>

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                </div>
            </div>
            <div id="formRecPassword">

                <!-- btn de ayuda Interactiva -->
                <div class="d-flex justify-content-end">
                    <div class="d-flex justify-content-end ">
                        <a href="#" uk-tooltip="Ayuda">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                                class="bi bi-question-octagon-fill azul mt-2" viewBox="0 0 16 16"
                                id="btnayudarecuperaPassword">
                                <path
                                    d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="w-auto ">

                    <div class="ms-5 mt-4 ps-4 col me-2 titulo">
                        <h2 class=" fw-bolder mb-1 " id="tituloText">Olvide mi contraseña</h2>
                        <div class="linea-titulo "></div>
                    </div>

                    <div class="w-auto col ps-4 ms-5 mb-3">

                        <div class=" comentario comentarioRed me-4 fw-bolder h-25 d-none" id="alerta_error" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p class="pe-2 text-center"></p>
                        </div>

                        <div class="uk-alert-danger bordeC comentarioRed me-4 fw-bolder h-25 msjE d-none" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p class="pe-2">Ingrese los datos correctamente</p>
                        </div>
                    </div>

                    <div class="col formulario w-auto">
                        <div class="d-flex flex-column fondo-formulario w-auto ">

                            <!-- I paso para verificar -->
                            <form action="" method="post" id="formVerificarUCE">
                                <div class="d-non" id="formUno">

                                    <div class=" mb-2 pb-1 animacionInput w-auto" id="input-usuario-recpassword">

                                        <svg xmlns="http://www.w3.org/2000/svg" id="icono-uno" width="20" height="20"
                                            fill="currentColor" class="bi bi-person-fill icono " viewBox="0 0 16 16">
                                            <path
                                                d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                        </svg>
                                        <input type="text" name="usuario" id="inputUno" class="input"
                                            placeholder="Usuario">

                                    </div>

                                    <div class=" mb-2 pb-1 animacionInput w-auto" id="input-ps-recpassword">

                                        <svg xmlns="http://www.w3.org/2000/svg" id="icono-dos" width="18" height="18"
                                            fill="currentColor" class="bi bi-envelope icono ms-1 pe-1"
                                            viewBox="0 0 16 16">
                                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1l-8 5-8-5V4z" />
                                            <path d="M0 6.5v5.5A2 2 0 0 0 2 14h12a2 2 0 0 0 2-2V6.5l-8 5-8-5z" />
                                        </svg>
                                        <input type="text" name="cE" id="inputDos" class="input"
                                            placeholder="Correo electrónico">

                                    </div>
                                    <div>
                                        <input type="hidden" name="id_usuario" id="idUsuario">
                                        <input type="hidden" name="correo" id="correoV">
                                    </div>
                                </div>
                            </form>

                            <!-- II siguiente paso para verificar -->
                            <form action="" method="post" id="formCodigo">
                                <div class="d-none" id="formDos">

                                    <div class=" mb-1 animacionInput w-auto col" id="input-rs-recpassword">

                                        <svg xmlns="http://www.w3.org/2000/svg" id="icono-tres" width="25" height="25"
                                            fill="currentColor"
                                            class="bi bi-check-circle-fill icono-respuesta-seguridad "
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                        </svg>
                                        <input type="text" name="codigo" id="inputTres" class="input"
                                            placeholder="Código">
                                        <div>
                                            <input type="hidden" name="id_usuario" id="idUsuarioDos">
                                            <input type="hidden" name="correo" id="correoVDos">
                                        </div>
                                    </div>

                                </div>
                            </form>

                            <!-- III siguiente paso para recuperar -->
                            <form action="" method="post" id="formRecuperarPassword">
                                <div class="d-none" id="formTres">

                                    <div class="ms-2 me-2 mb-3 pb-1 animacionInput w-auto"
                                        id="input-usuario-recpassword">
                                        <div id="input-new-password">

                                            <img src="<?= $urlBase ?>./src/assets/img/candado.svg" id="icono-cuatro"
                                                class="icono" alt="">
                                            <input type="password" name="passwordNew" id="inputNewPass" class="input"
                                                placeholder="Nueva contraseña">

                                            <a href="#" class="text-decoration-none">
                                                <svg id="ocultarPasswordRec" xmlns="http://www.w3.org/2000/svg"
                                                    width="23" height="23" fill="currentColor"
                                                    class="bi bi-eye-slash-fill azul d-none" viewBox="0 0 16 16">
                                                    <path
                                                        d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z" />
                                                    <path
                                                        d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z" />
                                                </svg>
                                                <svg id="mostrarPasswordRec" xmlns="http://www.w3.org/2000/svg"
                                                    width="23" height="23" fill="currentColor"
                                                    class="bi bi-eye-fill d-none " viewBox="0 0 16 16">
                                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                                    <path
                                                        d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                                </svg>
                                            </a>

                                        </div>
                                        <div class="d-flex align-items-center justify-content-center pe-3 ps-1 d-none"
                                            id="leyendaC" style="font-size: 12px; margin-top: 5px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-info-circle azul me-1"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z">
                                                </path>
                                                <path
                                                    d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z">
                                                </path>
                                            </svg>
                                            <i>El formato de la contraseña es incorrecto, debe tener mayúscula, número y
                                                carácter
                                                especial.
                                            </i>
                                        </div>
                                    </div>

                                    <div class="ms-2 me-2 mb-3 pb-1 animacionInput w-auto"
                                        id="input-usuario-recpassword">
                                        <div id="input-new-password">

                                            <img src="<?= $urlBase ?>./src/assets/img/candado.svg" id="icono-cuatro"
                                                class="icono" alt="">
                                            <input type="password" name="" id="inputReescContr" class="input"
                                                placeholder="Reescriba la contraseña">

                                            <a href="#" class="text-decoration-none">
                                                <svg id="ocultarPasswordRec" xmlns="http://www.w3.org/2000/svg"
                                                    width="23" height="23" fill="currentColor"
                                                    class="bi bi-eye-slash-fill azul d-none" viewBox="0 0 16 16">
                                                    <path
                                                        d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z" />
                                                    <path
                                                        d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z" />
                                                </svg>
                                                <svg id="mostrarPasswordRec" xmlns="http://www.w3.org/2000/svg"
                                                    width="23" height="23" fill="currentColor"
                                                    class="bi bi-eye-fill d-none " viewBox="0 0 16 16">
                                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                                    <path
                                                        d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                                </svg>
                                            </a>

                                        </div>
                                        <div class="d-flex align-items-center justify-content-center pe-3 ps-1 d-none"
                                            id="leyendaC" style="font-size: 12px; margin-top: 5px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-info-circle azul me-1"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z">
                                                </path>
                                                <path
                                                    d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z">
                                                </path>
                                            </svg>
                                            <i>El formato de la contraseña es incorrecto, debe tener mayúscula, número y
                                                carácter
                                                especial.
                                            </i>
                                        </div>
                                    </div>

                                    <div>
                                        <input type="hidden" name="id_usuario" id="idUsuarioTres">
                                        <input type="hidden" name="correo" id="correoVTres">
                                    </div>
                                </div>
                            </form>
                            <h5 id="divTime" class="mt-3 mb-0 pb-0 fw-bold text-center d-none">05:00</h5>

                        </div>
                    </div>

                    <div class="w-auto col">
                        <!-- I siguiente paso para verificar -->
                        <div class="mt-3 pt-2 w-auto" id="divBtnVerificarUCE">

                            <a href="#" class="btn btn-primary fw-bold boton rounded-5 text-decoration-none" name=""
                                id="btnVerificarUCE">Verificar ahora</a>

                        </div>
                        <!-- II siguiente paso para verificar -->
                        <div class="mt-3 pt-2 w-auto d-none" id="divBtnVerificarC">

                            <a href="#" class="btn btn-primary fw-bold boton rounded-5 text-decoration-none" name=""
                                id="btnVerificarC">Verificar código</a>

                        </div>

                        <!-- III siguiente paso para verificar -->
                        <div class="mt-3 pt-2 w-auto d-none" id="divBtnVerificarRC">

                            <a href="#" class="btn btn-primary fw-bold boton rounded-5 text-decoration-none" name=""
                                id="btnVerificarRC">Actualizar ahora</a>

                        </div>

                        <div class="d-flex justify-content-end mt-2 me-4">
                            <a href="/Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/mostrarIniciarSesion"
                                class="fw-bold pointer-event text-decoration-none text-dark ms-auto margen-resposive-iniciar-sesion"
                                id="iniciarsesionEnlace">Iniciar
                                sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script type="text/javascript"
        src="<?= $concatenarRuta ?><?= $concatenadorEspecial ?>./src/assets/js/recuperarContr.js"></script>
    <script type="text/javascript"
        src="<?= $concatenarRuta ?><?= $concatenadorEspecial ?>./src/assets/js/validacionesRecuperarContr.js"></script>
    <script type="text/javascript"
        src="<?= $concatenarRuta ?><?= $concatenadorEspecial ?>./src/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"
        src="<?= $concatenarRuta ?><?= $concatenadorEspecial ?>./src/assets/uikit/js/uikit.min.js"></script>
    <script type="text/javascript"
        src="<?= $concatenarRuta ?><?= $concatenadorEspecial ?>./src/assets/intro/intro.min.js"></script>
    <script type="text/javascript"
        src="<?= $concatenarRuta ?><?= $concatenadorEspecial ?>./src/assets/js/ayudaInteractivarecContrasena.js"></script>

</body>

</html>