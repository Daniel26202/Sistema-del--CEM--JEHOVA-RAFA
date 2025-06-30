<?php require_once './src/vistas/head/head.php';  ?>


<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">

    <h5 style="width: 95%; " class="m-auto mb-3">Servicios <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
            fill="currentColor" class="bi bi-clipboard-heart mb-2 ms-2" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M5 1.5A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5v-1Zm5 0a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1Z" />
            <path
                d="M3 1.5h1v1H3a1 1 0 0 0-1 1V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3.5a1 1 0 0 0-1-1h-1v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2Z" />
            <path d="M8 6.982C9.664 5.309 13.825 8.236 8 12 2.175 8.236 6.336 5.31 8 6.982Z" />
        </svg>
    </h5>


    <!-- alertas -->
    <?php require_once "./src/vistas/alerts.php" ?>

    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto" style="width: 95%; ">

        <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">

            <?php if (!$this->permisos($_SESSION["id_rol"], "guardar", "Consultas")): ?>
                <!-- no hay -->
            <?php else: ?>
                <button class="btn-guardar-responsive btn btn-primary btn-agregar-doctores col-8"
                    uk-toggle="target: #modal-example" id="btnAgregarServicioMedico">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                        class="bi bi-bandaid-fill me-1" viewBox="0 0 16 16">
                        <path
                            d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z">
                        </path>
                    </svg>Registrar Servicio
                </button>
                <button class="btn-guardar-responsive btn btn-primary btn-agregar-doctores col-8"
                    uk-toggle="target: #modal-categoria" id="btnAgregarCategoria">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                        class="bi bi-bandaid-fill me-1" viewBox="0 0 16 16">
                        <path
                            d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z">
                        </path>
                    </svg>Registrar Categoría
                </button>

            <?php endif; ?>
            <a href="/Sistema-del--CEM--JEHOVA-RAFA/Consultas/papeleraServicio"
                class="btn-guardar-responsive btn btn-primary btn-agregar-doctores text-decoration-none col-8" id="btnAgregarServicioMedicoPapelera">
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                    class="bi bi-bandaid-fill me-1" viewBox="0 0 16 16">
                    <path
                        d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z">
                    </path>
                </svg>Papelera
            </a>

        </div>



        <div class="table table-responsive">
            <table class="example  table table-striped">
                <thead>
                    <tr>
                        <th class="text-dark">Servicio</th>
                        <th class="text-dark">Precio en BS</th>
                        <th class="text-dark">Precio en $</th>
                        <th class="text-dark">Acciones</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($servicios as $servicio): ?>
                        <tr>
                            <td class="text-center">
                                <?= $servicio['categoria'] ?>
                            </td>
                            <td class="text-center">
                                <?= $servicio['precio'] * $_SESSION["dolar"] ?> BS
                            </td>
                            <td class="text-center">
                                <?= $servicio['precio'] ?> $
                            </td>
                            <td class="border-start">





                                <!-- Horario Del Doctor -->
                                <div class="d-flex justify-content-center">

                                    <?php if (!$this->permisos($_SESSION["id_rol"], "editar", "Consultas")): ?>
                                        <!-- no hay -->
                                    <?php else: ?>

                                        <a href="#" class="btns-accion me-2 btnEditarCita botonesEditarSM btnPreciosEditar"
                                            uk-toggle="target: #modal-exampleEditar<?= $servicio['id_servicioMedico'] ?>" uk-tooltip="Modificar Servicio  "
                                            id="btnEditarServicioMedico" data-index=<?= $servicio['id_servicioMedico'] ?>>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                                class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd"
                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                            </svg>
                                        </a>

                                    <?php endif; ?>



                                    <!-- Eliminar CONSULTA-->

                                    <?php if (!$this->permisos($_SESSION["id_rol"], "eliminar", "Consultas")): ?>
                                        <!-- no hay -->
                                    <?php else: ?>
                                        <a href="#" class="btns-accion me-2"
                                            uk-toggle="target: #modal-exampleEliminar<?= $servicio['id_servicioMedico'] ?>"
                                            uk-tooltip="Eliminar Servicio" id="btnEliminarServicioMedico">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                                class="bi bi-trash3-fill text-black" viewBox="0 0 16 16">
                                                <path
                                                    d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                            </svg>
                                        </a>

                                    <?php endif; ?>





                                </div>
                            </td>
                        </tr>

                        <!-- Modal eliminar servicio -->
                        <div id="modal-exampleEliminar<?= $servicio['id_servicioMedico'] ?>" uk-modal>
                            <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                                <form class="">

                                    <!-- Boton que cierra el modal -->
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                            class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                            <path
                                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                        </svg>
                                    </a>

                                    <div class="d-flex align-items-center">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                                class="bi bi-trash-fill azul me-2" viewBox="0 0 16 16">
                                                <path
                                                    d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h5>
                                                ¿Desea eliminar el servicio <?= $servicio['categoria'] ?>?
                                            </h5>
                                        </div>
                                    </div>



                                    <div class="mt-3 uk-text-right">

                                        <button class="uk-button fw-bold uk-button-default uk-modal-close btn-cerrar-modal" type="button"
                                            data-bs-dismiss="modal">Cancelar</button>
                                        <a class="uk-button uk-button-primary btn-agregarcita-modal ms-2 fw-bold" href='/Sistema-del--CEM--JEHOVA-RAFA/Consultas/eliminar/<?= $servicio['id_servicioMedico'] ?>/<?= $_SESSION['id_usuario'] ?>'>Eliminar</a>

                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal de editar -->
                        <div id="modal-exampleEditar<?= $servicio['id_servicioMedico'] ?>" uk-modal>
                            <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                                <!-- Boton que cierra el modal -->
                                <a href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                        class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                        <path
                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                    </svg>
                                </a>

                                <div class="d-flex align-items-center">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                            class="bi bi-pencil-fill azul me-3 mb-3" viewBox="0 0 16 16">
                                            <path
                                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                        </svg>
                                    </div>
                                    <div class="">
                                        <p class="uk-modal-title fs-5">
                                            Editar Servicio Médico
                                        </p>
                                    </div>

                                </div>

                                <div class="alert alert-danger d-none alertaEditar" role="alert">
                                    <div class="">
                                        <p style="font-size: 12px; height:10px; " class="text-center">VERIFIQUE EL FORMULARIO
                                            ANTES DE ENVIARLO</p>
                                    </div>
                                </div>

                                <form action="/Sistema-del--CEM--JEHOVA-RAFA/Consultas/editar" class="form-modal formEditar form-convercion<?= $servicio['id_servicioMedico'] ?>"
                                    id="modalEditar" method="POST">

                                    <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario']; ?>">

                                    <input type="hidden" name="id_servicioMedico" value="<?= $servicio["id_servicioMedico"]
                                                                                            ?>">

                                    <div class="input-group flex-nowrap">
                                        <span class="input-modal mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                                class="bi bi-grid-1x2-fill azul" viewBox="0 0 16 16">
                                                <path
                                                    d="M0 1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V1zm0 9a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-5z" />
                                            </svg> </span>
                                        <select class="form-control input-modal" aria-label="" id="id_categoria"
                                            placeholder="id_categoria" name="id_categoria" required>

                                            <option selected disabled>
                                                <?php echo $servicio['categoria'] ?>

                                            </option>


                                        </select>


                                    </div>





                                    <div class="input-group flex-nowrap claseExpresiones editargrp_precio"
                                        id="editargrp_precio">
                                        <span class="input-modal mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                                class="bi bi-currency-exchange azul" viewBox="0 0 16 16">
                                                <path
                                                    d="M0 5a5.002 5.002 0 0 0 4.027 4.905 6.46 6.46 0 0 1 .544-2.073C3.695 7.536 3.132 6.864 3 5.91h-.5v-.426h.466V5.05c0-.046 0-.093.004-.135H2.5v-.427h.511C3.236 3.24 4.213 2.5 5.681 2.5c.316 0 .59.031.819.085v.733a3.46 3.46 0 0 0-.815-.082c-.919 0-1.538.466-1.734 1.252h1.917v.427h-1.98c-.003.046-.003.097-.003.147v.422h1.983v.427H3.93c.118.602.468 1.03 1.005 1.229a6.5 6.5 0 0 1 4.97-3.113A5.002 5.002 0 0 0 0 5zm16 5.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0zm-7.75 1.322c.069.835.746 1.485 1.964 1.562V14h.54v-.62c1.259-.086 1.996-.74 1.996-1.69 0-.865-.563-1.31-1.57-1.54l-.426-.1V8.374c.54.06.884.347.966.745h.948c-.07-.804-.779-1.433-1.914-1.502V7h-.54v.629c-1.076.103-1.808.732-1.808 1.622 0 .787.544 1.288 1.45 1.493l.358.085v1.78c-.554-.08-.92-.376-1.003-.787H8.25zm1.96-1.895c-.532-.12-.82-.364-.82-.732 0-.41.311-.719.824-.809v1.54h-.005zm.622 1.044c.645.145.943.38.943.796 0 .474-.37.8-1.02.86v-1.674l.077.018z" />
                                            </svg>
                                        </span>

                                        <input class="form-control input-modal precioBolivaresEditar" type="text" name="precioEditar"
                                            placeholder="Precio" required value="<?= $servicio["precio"] * $_SESSION["dolar"] ?>">
                                        <span class="input-modal mt-1">
                                            Bs
                                        </span>

                                    </div>
                                    <div class="d-none d-flex align-items-center justify-content-center leyendaEditar"
                                        style="font-size: 12px; margin-top: -10px; margin-bottom: 5px; ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-info-circle azul me-1" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                            <path
                                                d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                        </svg>
                                        <i>El formato del precio es incorrecto, Ejemplo 0,00 - 00,00 - 000,00 - 0.000,00 </i>
                                    </div>

                                    <!-- <div class=" d-none d-flex align-items-center justify-content-center" id="leyendaEditar" style="font-size: 12px; margin-top: -10px; margin-bottom: 5px; ">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle azul me-1" viewBox="0 0 16 16">
  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
</svg>
<i>El formato del precio es incorrecto, Ejemplo 0,00 - 00,00 - 000,00 - 0.000,00 </i>
</div> -->

                                    <div class="input-group flex-nowrap " id="editargrp_precioD">
                                        <span class="input-modal mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                                class="bi bi-currency-exchange azul" viewBox="0 0 16 16">
                                                <path
                                                    d="M0 5a5.002 5.002 0 0 0 4.027 4.905 6.46 6.46 0 0 1 .544-2.073C3.695 7.536 3.132 6.864 3 5.91h-.5v-.426h.466V5.05c0-.046 0-.093.004-.135H2.5v-.427h.511C3.236 3.24 4.213 2.5 5.681 2.5c.316 0 .59.031.819.085v.733a3.46 3.46 0 0 0-.815-.082c-.919 0-1.538.466-1.734 1.252h1.917v.427h-1.98c-.003.046-.003.097-.003.147v.422h1.983v.427H3.93c.118.602.468 1.03 1.005 1.229a6.5 6.5 0 0 1 4.97-3.113A5.002 5.002 0 0 0 0 5zm16 5.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0zm-7.75 1.322c.069.835.746 1.485 1.964 1.562V14h.54v-.62c1.259-.086 1.996-.74 1.996-1.69 0-.865-.563-1.31-1.57-1.54l-.426-.1V8.374c.54.06.884.347.966.745h.948c-.07-.804-.779-1.433-1.914-1.502V7h-.54v.629c-1.076.103-1.808.732-1.808 1.622 0 .787.544 1.288 1.45 1.493l.358.085v1.78c-.554-.08-.92-.376-1.003-.787H8.25zm1.96-1.895c-.532-.12-.82-.364-.82-.732 0-.41.311-.719.824-.809v1.54h-.005zm.622 1.044c.645.145.943.38.943.796 0 .474-.37.8-1.02.86v-1.674l.077.018z" />
                                            </svg>
                                        </span>

                                        <input class="form-control input-modal precioDolaresEditar" type="text" name="precioD" placeholder="$" required value="<?= $servicio["precio"] ?>">
                                        <span class="input-modal mt-1">$</span>

                                    </div>

                                    <select class="form-control input-modal" aria-label=""
                                        name="tipo" >
                                        <option value="Cita">Cita</option>
                                        <option value="Examenes">Examenes</option>
                                    </select>






                                    <div class="mt-3 uk-text-right">
                                        <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                                            type="button">Cancelar</button>
                                        <button class="btn col-3 btn-agregarcita-modal" type="submit">Editar</button>
                                    </div>
                                </form>


                            </div>
                        </div>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

    </div>


    <!-- modal de agregar -->
    <div id="modal-example" uk-modal>
        <div class="uk-modal-dialog uk-modal-body tamaño-modal">
            <!-- Boton que cierra el modal -->
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                    class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                </svg>
            </a>

            <div class="d-flex align-items-center mb-3">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor"
                        class="bi bi-clipboard2-plus-fill azul me-3 mb-3" viewBox="0 0 16 16">
                        <path
                            d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5Z" />
                        <path
                            d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585c.055.156.085.325.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5c0-.175.03-.344.085-.5ZM8.5 6.5V8H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V9H6a.5.5 0 0 1 0-1h1.5V6.5a.5.5 0 0 1 1 0Z" />
                </div>
                <div class="">
                    <p class="uk-modal-title fs-5 ">
                        Registrar Servicio
                    </p>
                </div>

            </div>

            <div class="alert alert-danger d-none" role="alert" id="alerta"">
            <div class="">
                <p style=" font-size: 12px; height:10px; " class=" text-center">VERIFIQUE EL FORMULARIO ANTES DE
                ENVIARLO</p>
            </div>
        </div>

        <form class="form-modal form-convercion" id="modalAgregar" action="/Sistema-del--CEM--JEHOVA-RAFA/Consultas/guardar" method="POST"
            autocomplete="off">
            <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario']; ?>">

            <div class="input-group flex-nowrap">
                <span class="input-modal mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-grid-1x2-fill azul" viewBox="0 0 16 16">
                        <path
                            d="M0 1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V1zm0 9a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-5z" />
                    </svg> </span>
                <select class="form-control input-modal" aria-label="" id="id_categoria" placeholder="id_categoria"
                    name="id_categoria" required>
                    <option value="" selected disabled>Seleccione la Categoría del Servicio</option>

                    <?php foreach ($todasLasCategorias as $categoria): ?>
                        <option value="<?php echo $categoria['id_categoria']; ?>">
                            <?php echo $categoria["nombre"] ?>

                        </option>

                    <?php endforeach ?>

                </select>

            </div>



            <div class="input-group flex-nowrap " id="grp_precio">
                <span class="input-modal mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-currency-exchange azul" viewBox="0 0 16 16">
                        <path
                            d="M0 5a5.002 5.002 0 0 0 4.027 4.905 6.46 6.46 0 0 1 .544-2.073C3.695 7.536 3.132 6.864 3 5.91h-.5v-.426h.466V5.05c0-.046 0-.093.004-.135H2.5v-.427h.511C3.236 3.24 4.213 2.5 5.681 2.5c.316 0 .59.031.819.085v.733a3.46 3.46 0 0 0-.815-.082c-.919 0-1.538.466-1.734 1.252h1.917v.427h-1.98c-.003.046-.003.097-.003.147v.422h1.983v.427H3.93c.118.602.468 1.03 1.005 1.229a6.5 6.5 0 0 1 4.97-3.113A5.002 5.002 0 0 0 0 5zm16 5.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0zm-7.75 1.322c.069.835.746 1.485 1.964 1.562V14h.54v-.62c1.259-.086 1.996-.74 1.996-1.69 0-.865-.563-1.31-1.57-1.54l-.426-.1V8.374c.54.06.884.347.966.745h.948c-.07-.804-.779-1.433-1.914-1.502V7h-.54v.629c-1.076.103-1.808.732-1.808 1.622 0 .787.544 1.288 1.45 1.493l.358.085v1.78c-.554-.08-.92-.376-1.003-.787H8.25zm1.96-1.895c-.532-.12-.82-.364-.82-.732 0-.41.311-.719.824-.809v1.54h-.005zm.622 1.044c.645.145.943.38.943.796 0 .474-.37.8-1.02.86v-1.674l.077.018z" />
                    </svg>
                </span>

                <input class="form-control input-modal precioBolivares" type="text" name="precio" placeholder="Precio" required>
                <span class="input-modal mt-1">BS</span>

            </div>
            <div class=" d-none d-flex align-items-center justify-content-center" id="leyenda"
                style="font-size: 12px; margin-top: -10px; margin-bottom: 5px; ">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-info-circle azul me-1" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path
                        d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                </svg>
                <i>El formato del precio es incorrecto, Ejemplo 0,00 - 00,00 - 000,00 - 0.000,00 </i>
            </div>

            <div class="input-group flex-nowrap " id="grp_precioD">
                <span class="input-modal mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-currency-exchange azul" viewBox="0 0 16 16">
                        <path
                            d="M0 5a5.002 5.002 0 0 0 4.027 4.905 6.46 6.46 0 0 1 .544-2.073C3.695 7.536 3.132 6.864 3 5.91h-.5v-.426h.466V5.05c0-.046 0-.093.004-.135H2.5v-.427h.511C3.236 3.24 4.213 2.5 5.681 2.5c.316 0 .59.031.819.085v.733a3.46 3.46 0 0 0-.815-.082c-.919 0-1.538.466-1.734 1.252h1.917v.427h-1.98c-.003.046-.003.097-.003.147v.422h1.983v.427H3.93c.118.602.468 1.03 1.005 1.229a6.5 6.5 0 0 1 4.97-3.113A5.002 5.002 0 0 0 0 5zm16 5.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0zm-7.75 1.322c.069.835.746 1.485 1.964 1.562V14h.54v-.62c1.259-.086 1.996-.74 1.996-1.69 0-.865-.563-1.31-1.57-1.54l-.426-.1V8.374c.54.06.884.347.966.745h.948c-.07-.804-.779-1.433-1.914-1.502V7h-.54v.629c-1.076.103-1.808.732-1.808 1.622 0 .787.544 1.288 1.45 1.493l.358.085v1.78c-.554-.08-.92-.376-1.003-.787H8.25zm1.96-1.895c-.532-.12-.82-.364-.82-.732 0-.41.311-.719.824-.809v1.54h-.005zm.622 1.044c.645.145.943.38.943.796 0 .474-.37.8-1.02.86v-1.674l.077.018z" />
                    </svg>
                </span>

                <input class="form-control input-modal precioDolares" type="text" name="precioD" placeholder="$" required>
                <span class="input-modal mt-1">$</span>

            </div>

            <select class="form-control input-modal" aria-label=""
                name="tipo" required>
                <option value="" selected disabled>Seleccione el de Servicio</option>


                <option value="Cita">Cita</option>
                <option value="Examenes">Examenes</option>



            </select>



            <div class="mt-3 uk-text-right">
                <button class="uk-button col-6 me-2 uk-button-default uk-modal-close btn-cerrar-modal"
                    type="button">Cancelar</button>
                <button class="btn col-5 btn-agregarcita-modal" type="sumit" name="guardar">Agregar</button>
            </div>
        </form>
    </div>
</div>
</div>






</div>

</div>
</div>



<script src="<?= $urlBase; ?>../src/assets/js/servicioMedico.js"></script>
<script src="<?= $urlBase; ?>../src/assets/js/ayudaServicioMedico.js"></script>
<script src="<?= $urlBase; ?>../src/assets/js/validacionesServiciosMedicosRegistrar.js"></script>


<?php require_once './src/vistas/vistaConsultas/modalesCategoria.php'; ?>
<?php require_once './src/vistas/head/footer.php';  ?>