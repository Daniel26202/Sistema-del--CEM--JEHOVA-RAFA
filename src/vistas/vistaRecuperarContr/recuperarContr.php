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

$urlBase = $concatenarRuta . '' . $concatenadorEspecial;

?>




<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J-R</title>
    <link href="<?= $urlBase ?>./src/assets/library/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $urlBase ?>./src/assets/cssVista/recuperarContr.css">

    <link rel="stylesheet" href="<?= $urlBase ?>./src/assets/library/intro/introjs.min.css">
    <link rel="stylesheet" href="<?= $urlBase ?>./src/assets/library/intro/introjs-modern.css">

</head>

<body>
    <main class="contenedor">

        <div class=" d-flex w-auto col">
            <!-- carrusel -->
            <div class="col-0 col-sm-6">
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
            <div id="formRecPassword" class="col-12 col-sm-6 pe-5">

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
                        <h2 class=" fw-bolder mb-1 text-theme " id="tituloText">Olvide mi contraseña</h2>
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
                            <form class="form-validable" action="" method="post" id="formVerificarUCE">
                                <div class="d-non" id="formUno">

                                    <label class="label-custom mt-0">Usuario</label>
                                    <div class="campo-custom" id="input-usuario-recpassword">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs" name="usuario"
                                                placeholder="Usuario" type="text">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none"></p>
                                    </div>

                                    <label class="label-custom">Correo electrónico</label>
                                    <div class="campo-custom" id="input-ps-recpassword">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    fill="currentColor" class="bi bi-envelope"
                                                    viewBox="0 0 16 16">
                                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1l-8 5-8-5V4z" />
                                                    <path d="M0 6.5v5.5A2 2 0 0 0 2 14h12a2 2 0 0 0 2-2V6.5l-8 5-8-5z" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs" name="correo"
                                                placeholder="Correo electrónico" type="text">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none"></p>
                                    </div>

                                    <div>
                                        <input type="hidden" name="id_usuario" id="idUsuario">
                                        <input type="hidden" name="" id="correoV">
                                    </div>
                                </div>
                            </form>

                            <!-- II siguiente paso para verificar -->
                            <form action="" method="post" id="formCodigo">
                                <div class="d-none" id="formDos">

                                    <div class=" mb-1 animacionInput w-auto col" id="input-rs-recpassword">

                                        <div class="campo-custom" id="input-usuario-recpassword">
                                            <div class="input-custom">
                                                <span class="icono-izq">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                        fill="currentColor"
                                                        class="bi bi-check-circle-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                                    </svg>
                                                </span>
                                                <input class="form-control txt-custom input-validar inputs" name="codigo" placeholder="Código" type="text">
                                                <span class="icono-der">
                                                    <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                    </svg>
                                                    <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <p class="error-msg d-none"></p>
                                        </div>




                                        <div>
                                            <input type="hidden" name="id_usuario" id="idUsuarioDos">
                                            <input type="hidden" name="correo" id="correoVDos">
                                        </div>
                                    </div>

                                    <h5 id="divTextError" class="text-danger mt-3 mb-0 pb-0 fw-bold text-center d-none">
                                        Su código expiro.</h5>
                                    <h5 id="divTime" class="mt-3 mb-0 pb-0 fw-bold text-center d-none">05:00</h5>
                                    <div class="text-center">
                                        <a href="#" id="btnEviarCod"
                                            class="fs-5 mt-3 text-decoration-none text-primary fw-bold">Reenviar el
                                            código</a>
                                    </div>

                                </div>


                            </form>

                            <!-- III siguiente paso para recuperar -->
                            <form action="" method="post" id="formRecuperarPassword">
                                <div class="d-none" id="formTres">

                                    <label class="label-custom mt-0">Nueva contraseña</label>
                                    <div class="campo-custom" id="input-usuario-recpassword">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <!-- Candado SVG inline -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs" name="passwordNew" id="inputNewPass"
                                                placeholder="Nueva contraseña" type="password">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>

                                            <span class="toggle-password mb-1" data-target="inputNewPass" style="cursor:pointer;">
                                                <!-- Ojo abierto -->
                                                <svg class="ojo-ver" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                                </svg>
                                                <!-- Ojo tachado -->
                                                <svg class="ojo-ocultar d-none" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z" />
                                                    <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z" />
                                                </svg>
                                            </span>

                                        </div>
                                        <p class="error-msg d-none">El formato es incorrecto, debe tener mayúscula, número y carácter especial.</p>
                                    </div>

                                    <label class="label-custom">Reescriba la contraseña</label>
                                    <div class="campo-custom" id="input-ps-recpassword">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs" name="passwordNew" id="inputReescContr"
                                                placeholder="Reescriba la contraseña" type="password">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>

                                            <span class="toggle-password mb-1" data-target="inputReescContr" style="cursor:pointer; ">
                                                <!-- Ojo abierto -->
                                                <svg class="ojo-ver" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                                </svg>
                                                <!-- Ojo tachado -->
                                                <svg class="ojo-ocultar d-none" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z" />
                                                    <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none">Las contraseñas no coinciden.</p>
                                    </div>

                                    <div>
                                        <input type="hidden" name="id_usuario" id="idUsuarioTres">
                                        <input type="hidden" name="correo" id="correoVTres">
                                    </div>
                                </div>
                            </form>

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

                        <div class="mt-2 margenL ">
                            <a href="/Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/mostrarIniciarSesion"
                                class="fw-bold pointer-event text-decoration-none text-theme margen-resposive-iniciar-sesion"
                                id="iniciarsesionEnlace">Iniciar
                                sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>



    <!-- SweetAlert2 -->
    <script type="text/javascript" src="<?= $urlBase ?>./src/assets/library/sweetalert2/sweetalert2@11.js"></script>

    <script type="module" src="<?= $urlBase ?>./src/assets/js/recuperarContr.js"></script>
    <script src="<?= $urlBase ?>./src/assets/library/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $urlBase ?>./src/assets/library/intro/intro.min.js"></script>
    <!-- <script src="<?= $urlBase ?>./src/assets/js/generic/expresionesModulares.js"></script> -->
    <script type="text/javascript" src="<?= $urlBase ?>./src/assets/js/ayudaInteractiva/ayudaInteractivarecContrasena.js"></script>
    <script src="<?= $urlBase ?>./src/assets/app.js"></script>

</body>

</html>