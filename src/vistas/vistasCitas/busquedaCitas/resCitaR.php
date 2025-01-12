<?php require_once './src/vistas/head/head.php'; ?>
<div class="d-flex align-items-center justify-content-between mt-4 mb-4">
    <div class="ms-5 d-flex align-items-center" id="inicioCita">
        <h1 class="fw-bold">CITAS</h1>
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-journal-check ms-2" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0" />
            <path
                d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2" />
            <path
                d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z" />
        </svg>
    </div>

    <div class="me-4">

        <a><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                class="bi bi-wrench-adjustable-circle azul" viewBox="0 0 16 16" id="desplegablefactura">
                <path d="M12.496 8a4.491 4.491 0 0 1-1.703 3.526L9.497 8.5l2.959-1.11c.027.2.04.403.04.61Z" />
                <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0Zm-1 0a7 7 0 1 0-13.202 3.249l1.988-1.657a4.5 4.5 0 0 1 7.537-4.623L7.497 6.5l1 2.5 1.333 3.11c-.56.251-1.18.39-1.833.39a4.49 4.49 0 0 1-1.592-.29L4.747 14.2A7 7 0 0 0 15 8Zm-8.295.139a.25.25 0 0 0-.288-.376l-1.5.5.159.474.808-.27-.595.894a.25.25 0 0 0 .287.376l.808-.27-.595.894a.25.25 0 0 0 .287.376l1.5-.5-.159-.474-.808.27.596-.894a.25.25 0 0 0-.288-.376l-.808.27.596-.894Z" />
            </svg></a>
        <div class="uk-nav uk-dropdown-nav" uk-dropdown="pos: top-right" id="desplegable2">
            <ul>
                <li id="perfilPaciente"><a href="?c=ControladorPerfil/perfil" class="uk-animation-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                            class="bi bi-person-fill azul uk-animation-scale-up" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        </svg>PERFIL
                    </a></li>
                <li class="uk-nav-divider"></li>
                <li><a href="#" id="btnayudaCitaPBuscador"><svg xmlns="http://www.w3.org/2000/svg" width="26"
                            height="26" fill="currentColor" class="bi bi-question-octagon-fill azul me-1"
                            viewBox="0 0 16 16">
                            <path
                                d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                        </svg>AYUDA</a></li>
                <li class="uk-nav-divider"></li>

                <li><a href="#" data-bs-toggle="modal" data-bs-target="#eliminar">
                        <img src="./src/assets/img/icono-cerrar-sesion.svg" width="34" height="34" uk-svg class="azul"
                            style="margin-left: -4px;">
                        </svg>SALIR</a></li>
            </ul>
        </div>
    </div>
</div>

<!-- Modal Cerrar Sesion  -->
<div class="modal fade" id="eliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="m-3">
                <?php

                echo '<h5 class="modal-title" id="exampleModalLabel">
            ¿' . $_SESSION['usuario'] . '   ' . 'Desea Cerrar 
            la Sesion?
            </h5>';
                ?>
            </div>
            <div class="modal-body ">
                Una vez cerrada la sesión tendrá que iniciar sesión nuevamente.
            </div>
            <div class="m-3 me-4 d-flex justify-content-end">
                <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancelar</button>
                <a href="?c=ControladorInicio/inicio&cerrar" class="btn btn-primary  text-decoration-none">Salir</a>
            </div>
        </div>
    </div>
</div>
</div>

<div class="me-4">
    <div class="mt-3 mb-5">
        <ul class="sin-circulos d-flex justify-content-end ">
            <li class="borde-menu activo">
                <a href="?c=controladorCitas/citas" class="text-decoration-none text-black me-3" id="citaPendiente">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-clock-history me-1" viewBox="0 0 16 16">
                        <path
                            d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z" />
                        <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z" />
                        <path
                            d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5" />
                    </svg>Pendientes</a>
            </li>
            <li class="borde-menu activo">
                <a href="?c=controladorCitas/citasHoy" class="text-decoration-none text-black me-3" id="citaHoy">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-calendar2-check me-1" viewBox="0 0 16 16">
                        <path
                            d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                        <path
                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z" />
                        <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5z" />
                    </svg>Hoy</a>
            </li>

            <li class="borde-menu activo activo-borde">
                <a href="?c=controladorCitas/citasRealizadas" class="text-decoration-none text-black"
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

<div class="div-tabla contenedor m-auto mt-3">
    <div class="d-flex justify-content-start align-items-center retrocederCitas">

        <div class="mt-4">
            <a href="?c=controladorCitas/citasRealizadas" class="text-decoration-none">
                <button class="btnRetroceder" id="btnRetrocederCita"><svg xmlns="http://www.w3.org/2000/svg" width="36"
                        height="36" fill="currentColor" class="bi bi-reply-fill azul" viewBox="0 0 16 16">
                        <path
                            d="M5.921 11.9 1.353 8.62a.719.719 0 0 1 0-1.238L5.921 4.1A.716.716 0 0 1 7 4.719V6c1.5 0 6 0 7 8-2.5-4.5-7-4-7-4v1.281c0 .56-.606.898-1.079.62z" />
                    </svg>
                </button>
            </a>
        </div>

    </div>
    <!-- Tabla -->

    <div class="d-flex justify-content-center">
        <div class="tamaño-tabla contenedor_tabla mt-5">
            <table class="table table-striped" id="tabla">
                <thead>
                    <tr>
                        <th class=" text-center">CI</th>
                        <th class=" text-center border-start">Paciente</th>
                        <th class=" text-center border-start">Teléfono</th>
                        <th class=" text-center border-start">Doctor</th>
                        <th class="border-start text-center">Consulta</th>
                        <th class="border-start text-center">Fecha</th>
                        <th class="border-start text-center d-none">Hora</th>
                        <th class="border-start text-center">Hora</th>
                        <th class="border-start border-end border-top-0 text-center">Estado</th>
                        <th class="border-start text-center">Acción</th>
                    </tr>
                </thead>
                <tbody class="">
                    <?php if ($datosCitasR): ?>
                        <?php foreach ($datosCitasR as $datoCita): ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo $datoCita["nacionalidad"]; ?>-
                                    <?php echo $datoCita["cedula_p"]; ?>
                                </td>
                                <td class=" text-center border-start">
                                    <?= $datoCita["nombre_p"]; ?>
                                    <?= $datoCita["apellido_p"]; ?>
                                </td>
                                <td class=" text-center border-start">
                                    <?= $datoCita["telefono_p"]; ?>
                                </td>
                                <td class="d-none">
                                    <?= $datoCita["id_doctor"] ?>
                                </td>
                                <td class=" text-center border-start">
                                    <?= $datoCita["nombre_d"]; ?>
                                    <?= $datoCita["apellido_d"]; ?>
                                </td>
                                <td class=" text-center border-start">
                                    <?= $datoCita["especialidad"]; ?>
                                </td>
                                <td class=" text-center border-start">
                                    <?= $datoCita["fecha"]; ?>
                                </td>
                                <td class=" text-center border-start d-none" id="insertarhora">
                                    <?= $datoCita["hora"]; ?>
                                </td>
                                <td class=" text-center border-start " id="insertarhora2"></td>
                                <td class=" text-center border-start">
                                    <?= $datoCita["estado"]; ?>
                                </td>

                                <td class="border-start  d-flex justify-content-center">


                                    <!-- eliminar -->

                                    <div class="me-2">
                                        <a href="#" class="btns-accion"
                                            uk-toggle="target: #modal-exampleEliminarcita<?= $datoCita["id_cita"]; ?>"
                                            uk-tooltip="Cancelar Cita" id="eliminarCitaP">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                                class="bi bi-trash3" viewBox="0 0 16 16">
                                                <path
                                                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                            </svg>
                                        </a>
                                    </div>


                </div>



            </div>

            </td>
            </tr>

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
                                ¿Desea Eliminar el Registro de la Cita?
                            </h5>
                        </div>
                    </div>

                    <div class="mt-3 uk-text-right">
                        <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                            type="button">Cancelar</button>
                        <a class="btn col-3 btn-agregarcita-modal text-decoration-none"
                            href="?c=controladorCitas/eliminarCitaR&id_cita=<?= $datoCita["id_cita"]; ?>">Eliminar</a>
                    </div>

                </div>
            </div>

        <?php endforeach ?>
    <?php else: ?>


        <tr>
            <td colspan="9" class="text-center">El PACIENTE NO TIENE CITAS REALIZADAS

            </td>
        </tr>
    <?php endif ?>

    </tbody>

    </table>
</div>
</div>

</div>


<?php require_once 'modalesCitas-Control.php'; ?>
<script type="text/javascript" src="./src/assets/js/ayudaCitasRealizadasBuscador.js"></script>
<script type="text/javascript" src="./src/assets/citas.js"></script>


<?php require_once './src/vistas/head/footer.php'; ?>