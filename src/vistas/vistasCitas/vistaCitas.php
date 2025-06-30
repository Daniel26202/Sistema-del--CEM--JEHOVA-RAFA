<?php require_once './src/vistas/head/head.php'; ?>


<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">
    <h5 style="width: 95%; " class="m-auto mb-3">Citas <?= ucfirst($vistaActiva) ?><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
            class="bi bi-calendar2-heart ms-2 ico" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5ZM1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v11a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V3Zm2 .5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V4a.5.5 0 0 0-.5-.5H3Zm5 4.493c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z" />
        </svg></h5>


    <?php require_once "./src/vistas/alerts.php" ?>



    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto" style="width: 95%; ">

        <div class="me-4">
            <div class="mt-3 mb-5">
                <ul class="sin-circulos d-flex justify-content-end ">
                    <li class="borde-menu activo <?= $vistaActiva == 'pendientes'  ? ' activo-borde ' : '' ?>">
                        <a href="/Sistema-del--CEM--JEHOVA-RAFA/Citas/citas" class="ico text-decoration-none me-3 color-letras"
                            id="citaPendiente">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-clock-history me-1" viewBox="0 0 16 16">
                                <path
                                    d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z" />
                                <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z" />
                                <path
                                    d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5" />
                            </svg>Pendientes</a>
                    </li>
                    <li class="borde-menu activo <?= $vistaActiva == 'hoy'  ? ' activo-borde ' : '' ?>">
                        <a href="/Sistema-del--CEM--JEHOVA-RAFA/Citas/citasHoy" class="ico text-decoration-none me-3 color-letras"
                            id="citaHoy">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-calendar2-check me-1" viewBox="0 0 16 16">
                                <path
                                    d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                                <path
                                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z" />
                                <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5z" />
                            </svg>Hoy</a>
                    </li>

                    <li class="borde-menu activo <?= $vistaActiva == 'realizadas'  ? ' activo-borde ' : '' ?>">
                        <a href="/Sistema-del--CEM--JEHOVA-RAFA/Citas/citasRealizadas" class="ico text-decoration-none text-black"
                            id="citaRealizada">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-clipboard2-check me-1" viewBox="0 0 16 16">
                                <path
                                    d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5z" />
                                <path
                                    d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5z" />
                                <path
                                    d="M10.854 7.854a.5.5 0 0 0-.708-.708L7.5 9.793 6.354 8.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z" />
                            </svg>Realizadas </a>
                    </li>
                </ul>
            </div>
        </div>


        <div class="me-2 ps-3 col-10 caja-boton d-flex justify-content-between align-items-center row ">

            <?php if (!$this->permisos($_SESSION["id_rol"], "guardar", "Citas")): ?>
                <!-- no hay -->
            <?php else: ?>


                <button class="btn-guardar-responsive  btn btn-primary btn-agregar-doctores col-8 <?= $vistaActiva == "realizadas" ? "d-none" : ""; ?>" uk-toggle="target: #modal-examplecita" id="btnAgendarCita">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                        class="bi bi-bandaid-fill me-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5ZM1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v11a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V3Zm2 .5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V4a.5.5 0 0 0-.5-.5H3Zm5 4.493c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z" />
                    </svg>Agendar Cita
                </button>
            <?php endif; ?>

        </div>


        <div class="table table-responsive">
            <!--  <?php
                    echo '<pre>';
                    print_r($datosCitas);
                    echo '</pre>';
                    ?> -->
            <table class="example table table-striped" id="tabla">
                <thead>
                    <tr>
                        <th class="text-dark">Cédula</th>
                        <th class="text-dark">Paciente</th>
                        <th class="text-dark">Teléfono</th>
                        <th class="text-dark">Doctor</th>
                        <th class="text-dark">Consulta</th>
                        <th class="text-dark">Fecha</th>
                        <th class="text-dark">Hora</th>
                        <th class="text-dark">Estado</th>
                        <th class="text-dark">Acciones</th>

                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($datosCitas as $datoCita): ?>
                        <tr>
                            <td class="text-center"><?= $datoCita['nacionalidad'] ?> <?= $datoCita['cedula'] ?></td>
                            <td class="text-center"><?= $datoCita['nombre_p'] ?> <?= $datoCita['apellido_p'] ?></td>
                            <td class="text-center"><?= $datoCita['telefono_p'] ?></td>
                            <td class="text-center"><?= $datoCita['nombre_d'] ?> <?= $datoCita['apellido_d'] ?></td>
                            <td class="text-center"><?= $datoCita['categoria'] ?></td>
                            <td class="text-center"><?= $datoCita['fecha'] ?></td>
                            <td class="text-center"><?= $datoCita['hora'] ?></td>

                            <td class="text-center"><?= $datoCita['estado'] ?></td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center">
                                    <!-- editar -->
                                    <?php if (!$this->permisos($_SESSION["id_rol"], "editar", "Citas")): ?>
                                        <!-- no hay -->
                                    <?php else: ?>
                                        <div class="me-2 botonesEdi <?= $vistaActiva == "realizadas" ? "d-none" : ""; ?>">
                                            <a href="#" class="btns-accion botonesEditar botonesEdi"
                                                uk-toggle="target: #modal-examplecitaeditar<?= $datoCita["id_cita"]; ?>"
                                                data-index="<?= $datoCita["id_cita"]; ?>" uk-tooltip="Modificar Cita"
                                                id="btnEditarCitaPendiente">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                    fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd"
                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                </svg>
                                            </a>
                                        </div>
                                    <?php endif; ?>


                                    <!-- eliminar -->
                                    <?php if (!$this->permisos($_SESSION["id_rol"], "editar", "Citas")): ?>
                                        <!-- no hay -->
                                    <?php else: ?>
                                        <div class="me-2">
                                            <a href="#" class="btns-accion"
                                                uk-toggle="target: #modal-exampleEliminarcita<?= $datoCita["id_cita"]; ?>"
                                                uk-tooltip="Eliminar Cita" id="eliminarCitaP">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                    fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                    <path
                                                        d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                                </svg>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                </div>





        </div>
        <!-- modal -->
        <div id="modal-exampleEliminarcita<?= $datoCita["id_cita"]; ?>" uk-modal>
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-trash-fill azul me-2" viewBox="0 0 16 16">
                            <path
                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                        </svg>
                    </div>
                    <div>
                        <h5>
                            ¿Desea Eliminar La Cita Pendiente?
                    </div>
                </div>

                <div class=" mt-3 uk-text-right">
                    <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                        type="button">Cancelar</button>
                    <a class="btn col-3 btn-agregarcita-modal text-decoration-none"
                        href="/Sistema-del--CEM--JEHOVA-RAFA/Citas/eliminarCita/<?= $datoCita["id_cita"]; ?>/<?= $_SESSION['id_usuario']; ?>">Eliminar</a>
                </div>

            </div>
        </div>

        <!-- modal -->
        <div id="modal-examplecitaeditar<?= $datoCita["id_cita"]; ?>" uk-modal class="modalEditar">
            <div class="uk-modal-dialog uk-modal-body tamaño-modal" id="modal<?= $datoCita["id_cita"]; ?>">
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                            class="bi bi-calendar-day-fill azul me-2 mb-3 " viewBox="0 0 16 16">
                            <path
                                d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5h16v9zm-4.785-6.145a.428.428 0 1 0 0-.855.426.426 0 0 0-.43.43c0 .238.192.425.43.425zm.336.563h-.672v4.105h.672V8.418zm-6.867 4.105v-2.3h2.261v-.61H4.684V7.801h2.464v-.61H4v5.332h.684zm3.296 0h.676V9.98c0-.554.227-1.007.953-1.007.125 0 .258.004.329.015v-.613a1.806 1.806 0 0 0-.254-.02c-.582 0-.891.32-1.012.567h-.02v-.504H7.98v4.105z" />
                        </svg>
                    </div>
                    <div class="">
                        <p class="uk-modal-title fs-5">
                            Editar Cita
                        </p>
                    </div>

                </div>

                <form class="form-modal form-validable<?= $datoCita["id_cita"]; ?>"
                    action="/Sistema-del--CEM--JEHOVA-RAFA/Citas/editarCita/<?= $datoCita["id_cita"]; ?>"
                    method="POST">
                    <input type="hidden" value="<?php echo $_SESSION['id_usuario']; ?>" name="id_usuario">

                    <form class="form-modal"
                        action="/Sistema-del--CEM--JEHOVA-RAFA/editarCitaHoy/<?= $datoCita["id_cita"]; ?>"
                        method="POST">

                        <input type="hidden" value="<?php echo $datoCita['id_paciente']; ?>"
                            name="id_paciente">

                        <input type="hidden" name="id_cita" value="<?= $datoCita["id_cita"]; ?>">

                        <input type="hidden" value="<?php echo $_SESSION['id_usuario']; ?>"
                            name="id_usuario">

                        <input type="hidden" value="<?php echo $datoCita['serviciomedico_id_servicioMedico']; ?>"
                            name="serviciomedico_id_servicioMedico">








                        <div class="input-group flex-nowrap caja">
                            <span class="input-modal mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="currentColor" class="bi bi-clipboard2-check-fill azul"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5" />
                                    <path
                                        d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585q.084.236.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5q.001-.264.085-.5m6.769 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                                </svg>
                            </span>
                            <select class="form-control input-modal especialidad" name="consulta">
                                <option selected disabled value="<?= $datoCita["serviciomedico_id_servicioMedico"] ?>">
                                    <?= $datoCita["categoria"] ?>
                                </option>

                            </select>
                        </div>

                        <div class="input-group flex-nowrap">
                            <span class=" mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                    fill="currentColor" class="bi bi-person-fill azul mb-2"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                </svg>
                                Doctor</span>


                        </div>

                        <div class="mt-2 mb-2 listaDoctores"></div>

                        <input type="hidden" class="id_servicioMedico" name="id_servicioMedico">

                        <div class="input-modal mt-3">
                            <ul uk-accordion="multiple: true">
                                <li>
                                    <a class="uk-accordion-title text-decoration-none" href="#">

                                        <h6 class="acordion-datoCita fw-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="currentColor"
                                                class="bi bi-calendar2-week-fill azul mb-2"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zM8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z" />
                                            </svg>
                                            Horario del Doctor
                                        </h6>
                                    </a>

                                    <div class="uk-accordion-content">

                                    </div>
                                </li>
                            </ul>
                        </div>


                        <div class="alert alert-danger d-flex align-items-center justify-content-center alertaClassEditar d-none"
                            role="alert" id="alertahorarioCitaEdi">
                            <div class="text-center">
                                <p style="font-size: 10px; height: 20px;" class="text-center mb-3">VERIFIQUE
                                    QUE LA
                                    FECHA DE LA CONSULTA ESTE COMPRENDIDA EN EL HORARIO DEL DOCTOR</p>
                            </div>
                        </div>


                        <div class="input-group flex-nowrap validar">
                            <span class="input-modal mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="currentColor" class="bi bi-calendar-date-fill azul"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zm5.402 9.746c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2" />
                                    <path
                                        d="M16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-6.664-1.21c-1.11 0-1.656-.767-1.703-1.407h.683c.043.37.387.82 1.051.82.844 0 1.301-.848 1.305-2.164h-.027c-.153.414-.637.79-1.383.79-.852 0-1.676-.61-1.676-1.77 0-1.137.871-1.809 1.797-1.809 1.172 0 1.953.734 1.953 2.668 0 1.805-.742 2.871-2 2.871zm-2.89-5.435v5.332H5.77V8.079h-.012c-.29.156-.883.52-1.258.777V8.16a13 13 0 0 1 1.313-.805h.632z" />
                                </svg>
                            </span>
                            <input class="form-control input-modal fecha input-validar" id="fechaEditar" type="date"
                                name="fechaDeCita" required pattern="\d{2}\/\d{2}\/\d{4}" placeholder="Fecha"
                                value="<?= $datoCita["fecha"] ?>">

                        </div>

                        <p class="p-error-fechaDeCita<?= $datoCita["id_cita"] ?>"></p>

                        <div class="input-group flex-nowrap">
                            <span class="input-modal mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="currentColor" class="bi bi-clock-fill azul" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                                </svg>
                            </span>
                            <input class="form-control input-modal" type="time" name="hora"
                                placeholder="Hora" required value="<?= $datoCita["hora"] ?>">
                        </div>





                        <div class="mt-3 uk-text-right">
                            <button
                                class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                                type="button">Cancelar</button>
                            <button class="btn col-3 btn-agregarcita-modal btnEditarCita" id="btnEditarCita"
                                type="submit">Editar</button>
                        </div>
                    </form>
                </form>
            </div>
            </td>




            </tr>
        <?php endforeach; ?>

        </tbody>
        </table>
        </div>
    </div>
</div>

<?php require_once 'modalesCitas-Control.php'; ?>
<?php require_once './src/vistas/head/footer.php'; ?>

<script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/expresionesModulares.js"></script>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/ayudaCitasPendientes.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/citas.js"></script>