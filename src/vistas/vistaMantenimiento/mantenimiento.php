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
                                uk-toggle="#descargarBd">Descargar Respaldo</a>
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
                            <a href="#" class="btn btn-secondary card-restaurar-btn btn-block w-100 text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalBaseDatos">Restaurar Base</a>

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
        <div class="contenido modal-content">
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
                            <?php
                            $contadorDb = 0;
                            foreach ($respaldos as $db) :
                                $contadorDb++;
                            ?>
                                <tr>
                                    <td><?= basename($db) ?></td>
                                    <td>
                                        <a href="#" class="p-2 uk-button-primary rounded-5 fw-bold text-decoration-none text-white" type="button" id="btnEnviar" data-bs-dismiss="modal"
                                            uk-toggle="target: #restablecer<?= $contadorDb ?>">Seleccionar</a>
                                    </td>

                                </tr>

                                <!-- modales -->
                                <div>
                                    <div id="restablecer<?= $contadorDb ?>" uk-modal>
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

                                                <a href="/Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/restaurarRespaldo/<?= basename($db) ?>/<?= $_SESSION["id_usuario"] ?>" class="seleccionar">
                                                    <button class="btn col-4 btn-agregarcita-modal btnrestablecer"
                                                        id="">Restaurar</button>
                                                </a>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-end align-items-center ps-4 pe-4 ms-1 me-1 pt-3 pb-4">
                <button class="uk-button rounded-5 btn-cancelar fw-bold " type="button" data-bs-dismiss="modal">Cancelar</button>

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






<script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/ayudaMantenimiento.js"></script>
<script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/mantenimiento.js"></script>
<?php require_once './src/vistas/head/footer.php'; ?>