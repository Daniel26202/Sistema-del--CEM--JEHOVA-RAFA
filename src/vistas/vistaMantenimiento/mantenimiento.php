<?php require_once './src/vistas/head/head.php'; ?>

<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">


    <div class="d-flex justify-content-center">
        <?php require_once './src/vistas/alerts.php'; ?>
    </div>

    <div class="container mt-5 col-md-9">
        <div class="row mb-4 mt-2">
            <div class="col text-center">
                <h1>Mantenimiento del sistema</h1>
                <p class="p-mantenimiento">Realiza operaciones básicas como descarga de respaldo y restauración.</p>
            </div>
        </div>

        <div class="row ">
            <div class="col-md-6 mb-3">
                <div class="card card-mentenimiento card-descarga p-2 h-100">
                    <div class="fw-bold ms-3 mt-3 me-3 fs-4">
                        Descargar Respaldo
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-between h-100">
                            <p class="card-text">Haz clic para generar y descargar una copia de seguridad de tu base de datos.</p>
                            <a href="#" class="btn btn-primary btn-block w-100 text-white text-decoration-none card-descarga-btn" data-bs-dismiss="modal"
                                uk-toggle="#Verificar" id="descarBd">Descargar Respaldo</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3 ">
                <div class="card card-mentenimiento card-restaurar p-2 h-100">
                    <div class="fw-bold ms-3 mt-3 me-3 fs-4">
                        Restaurar Base de Datos
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-between h-100">
                            <p class="card-text">Selecciona un respaldo previamente descargado para restaurar la base de datos.</p>
                            <button class="btn btn-secondary card-restaurar-btn btn-block w-100 text-decoration-none" data-bs-dismiss="modal"
                                uk-toggle="#Verificar" id="btnRD">Restaurar Base</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <div class="alert alert-info " role="alert">
                    Esta acción puede afectar la integridad de los datos. Si no estás seguro, contacta al administrador antes de continuar.
                </div>
            </div>
        </div>

    </div>



</div>


<!-- modales -->

<div class="modal fade" id="modalBaseDatos" tabindex="-1" aria-labelledby="modalBaseDatosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="tamaño-modal modal-content">
            <div class="d-flex justify-content-between align-items-center ps-4 pe-4 ms-1 me-1 pt-4 ">
                <h4 class="fw-bold" id="modalBaseDatosLabel">Seleccionar Base de Datos</h4>
                <a href="#" class="" data-bs-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-x-circle color-icono" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"></path>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"></path>
                    </svg>
                </a>
            </div>
            <div class="modal-body ms-3 mt-3 me-3">
                <!-- campo de búsqueda -->
                <div class="d-flex justify-content-end mb-4 mt-2 me-2 col">
                    <input class="form-control input-busca" type="text" name="" placeholder="Buscar por nombre o fecha" id="buscarBD">
                    <button class="btn boton-buscar" title="Buscar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
                        </svg>
                    </button>
                </div>

                <!-- tabla de bases de datos -->
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Nombre y Fecha</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="datosTable">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-end align-items-center ps-4 pe-4 ms-1 me-1 pt-3 pb-4">

                <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button" data-bs-dismiss="modal">Cancelar</button>

                <a href="#" data-bs-dismiss="modal"
                    uk-toggle="target: #restablecer"><button class="uk-button uk-button-primary rounded-5 fw-bold ms-4" type="submit" id="btnEnviar">Restaurar el más reciente</button></a>
            </div>
        </div>
    </div>
</div>


<!-- modal de restaurar la bd mas actual -->
<div>
    <div id="restablecer" uk-modal>
        <div class="uk-modal-dialog uk-modal-body tamaño-modal">
            <!-- Boton que cierra el modal -->
            <div class="d-flex justify-content-between mb-5">

                <div class="d-flex align-items-center ajustar" id="">
                    <div class="svgPapeleraPatologia">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                            class="bi bi-trash-fill azul me-2 mb-1" viewBox="0 0 16 16">
                            <path
                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                        </svg>
                    </div>
                    <div>
                        <h5>
                            ¿Desea restaurar la base de datos?
                        </h5>
                    </div>
                </div>
                <!-- Ayuda Interactiva -->
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                        class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                        <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                    </svg>
                </a>
            </div>


            <div class="mt-5 uk-text-right btn_modal_patologias">
                <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button"
                    data-bs-toggle="modal" data-bs-target="#modalBaseDatos">Cancelar</button>

                <a href="/Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/restaurarRespaldo/nohay/<?= $_SESSION["id_usuario"] ?>">
                    <button class="seleccionar btn col-4 btn-agregarcita-modal btnrestablecer" id="">Restaurar</button>
                </a>

            </div>

        </div>
    </div>
</div>
<!-- modal de descargar la bd -->
<div>
    <div id="descargarBd" uk-modal>
        <div class="uk-modal-dialog uk-modal-body tamaño-modal">
            <!-- Boton que cierra el modal -->
            <div class="d-flex justify-content-between mb-5">

                <div class="d-flex align-items-center ajustar" id="">
                    <div class="svgPapeleraPatologia">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                            class="bi bi-trash-fill azul me-2 mb-1" viewBox="0 0 16 16">
                            <path
                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                        </svg>
                    </div>
                    <div>
                        <h5>
                            ¿Desea descargar la base de datos?
                        </h5>
                    </div>
                </div>
                <!-- Ayuda Interactiva -->
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                        class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                        <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                    </svg>
                </a>
            </div>


            <div class="mt-5 uk-text-right btn_modal_patologias">
                <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>

                <a href="/Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/generarRespaldo/<?= $_SESSION["id_usuario"] ?>">
                    <button class="seleccionar btn col-4 btn-agregarcita-modal btnrestablecer" id="">Descargar</button>
                </a>

            </div>

        </div>
    </div>
</div>

<!-- modal de verificación -->
<div>
    <div id="Verificar" uk-modal>
        <div class="uk-modal-dialog uk-modal-body tamaño-modal">
            <!-- Boton que cierra el modal -->
            <div class="d-flex justify-content-center mb-5">
                <form autocomplete="off" action="/Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/iniciarSesion" method="POST"
                    id="fVerificacionU" class="form-validable">

                    <div class="msjE"></div>

                    <div class=" m-auto">

                        <div class="mb-5 ms-5 mt-5 pt-2 ps-4 col">
                            <h2 class="titulo text-theme fw-bolder mb-1 " id="titulo">Identificación de usuario</h2>
                            <div class="linea-titulo ">
                            </div>
                        </div>
                        <div>

                            <p class="mensajeP ms-4 me-4 ico fw-bolder">El usuario tiene que ser super administrador, y el usuario, además de la contraseña, debe ser correcta</p>
                        </div>
                        <!-- <div class="fondo_rsp"> -->


                        <div class="col-11 m-auto ">
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
                                        <?php elseif ($parametro[0] == "errorSession"): ?>
                                            <div class="uk-alert-danger comentario comentarioRed me-4 fw-bolder h-25 mb-2"
                                                style="display: none;" uk-alert>
                                                <a class="uk-alert-close" uk-close></a>
                                                <p class="pe-2">Ya tiene una session abierta por favor ciérrala e inténtelo nuevamente.</p>

                                                <a href="/Sistema-del--CEM--JEHOVA-RAFA/Inicio/inicio/cerrar">Cerrar Session</a>
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
                                    <input type="text" name="usuario" id="inputUno" class="input input-modal col input-validar"
                                        placeholder="Usuario" required>
                                </div>

                                <p class="p-error-usuario d-none p-error-validaciones">El Usuario debe contener Letras, números, guiones y guion bajo, de 8 a 16 caracteres</p>

                                <div id="input-password">

                                    <img src="<?= $urlBase ?>../src/assets/img/candado.svg" id="icono-dos" class="icono candado" alt="">
                                    <input type="password" name="password" id="inputDos" class="input input-modal col input-validar"
                                        placeholder="Contraseña" maxlength="40" required>
                                    </input>


                                    <a href="#" class="text-decoration-none btnMostrarContrase">
                                        <svg id="ocultarPassword" xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                            fill="currentColor" class="bi bi-eye-slash-fill azul ocultarPassword d-none"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z" />
                                            <path
                                                d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z" />
                                        </svg>
                                        <svg id="mostrarPassword" xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                            fill="currentColor" class="bi bi-eye-fill azul mostrarPassword" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                            <path
                                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                        </svg>
                                    </a>


                                </div>

                                <p class="p-error-password d-none p-error-validaciones">La Contraseña debe contener de 8 a 12 caracteres, una mayúscula, un número y un símbolo
                                </p>
                            </div>
                        </div>

                    </div>

                </form>
            </div>


            <div class="mt-5 uk-text-right btn_modal_patologias">
                <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>


                <button class=" btn col-4 btn-agregarcita-modal btnrestablecer" id="btnVerifi">Verificar</button>

            </div>

        </div>
    </div>
</div>



<div class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center loader-overlay " style="z-index: 9999;" id="loaderModal">
    <div class="spinner-border text-light" role="status" style="width: 4rem; height: 4rem;">
        <span class="visually-hidden">Cargando...</span>
    </div>
</div>


<script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/ayudaMantenimiento.js"></script>
<script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/mantenimiento.js"></script>
<?php require_once './src/vistas/head/footer.php'; ?>