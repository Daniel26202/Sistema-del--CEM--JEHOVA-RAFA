<?php require_once './src/vistas/head/head.php'; ?>

<div class="d-flex align-items-center justify-content-between mt-4 mb-4">
    <div class="ms-5 d-flex align-items-center" id="inicioCita">
        <h1 class="fw-bold">CITAS</h1>
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-calendar2-heart ms-2" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5ZM1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v11a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V3Zm2 .5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V4a.5.5 0 0 0-.5-.5H3Zm5 4.493c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z" />
        </svg>
    </div>

    <div class="me-4">

        <a><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-wrench-adjustable-circle azul" viewBox="0 0 16 16" id="desplegablefactura">
                <path d="M12.496 8a4.491 4.491 0 0 1-1.703 3.526L9.497 8.5l2.959-1.11c.027.2.04.403.04.61Z" />
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0Zm-1 0a7 7 0 1 0-13.202 3.249l1.988-1.657a4.5 4.5 0 0 1 7.537-4.623L7.497 6.5l1 2.5 1.333 3.11c-.56.251-1.18.39-1.833.39a4.49 4.49 0 0 1-1.592-.29L4.747 14.2A7 7 0 0 0 15 8Zm-8.295.139a.25.25 0 0 0-.288-.376l-1.5.5.159.474.808-.27-.595.894a.25.25 0 0 0 .287.376l.808-.27-.595.894a.25.25 0 0 0 .287.376l1.5-.5-.159-.474-.808.27.596-.894a.25.25 0 0 0-.288-.376l-.808.27.596-.894Z" />
            </svg></a>
        <div class="uk-nav uk-dropdown-nav" uk-dropdown="pos: top-right" id="desplegable2">
            <ul>
                <li id="perfilPaciente"><a href="?c=ControladorPerfil/perfil" class="uk-animation-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-fill azul uk-animation-scale-up" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        </svg>PERFIL
                    </a></li>
                <li class="uk-nav-divider"></li>
                <li><a href="#" id="btnayudaCitaHoy"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
                            <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                        </svg>AYUDA</a></li>
                <li class="uk-nav-divider"></li>
                <li><a href="?c=ControladorBitacora/bitacora" ><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
          <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z"/>
      </svg> CONFIGURACIÓN</a></li>
      
        <li class="uk-nav-divider"></li>

                <li><a href="#" data-bs-toggle="modal"
                        data-bs-target="#eliminar">
                        <img src="./src/assets/img/icono-cerrar-sesion.svg" width="34" height="34" uk-svg class="azul" style="margin-left: -4px;">
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

<div class="d-flex justify-content-center">
<?php if (isset($_GET["error"])): ?>
        <div class="uk-alert-danger comentario comentarioRed me-4 fw-bolder h-25" style="display: none;" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p class="pe-2">Ya existe una cita registrada para ese día.</p>
        </div>
    <?php endif ?>

    <?php if (isset($_GET["editado"])): ?>
        <div class="uk-alert-primary comentario me-4 fw-bolder h-25" style="display: none;" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p class="pe-2">Se actualizo correctamente.</p>
        </div>
    <?php endif ?>
    <?php if (isset($_GET["eliminado"])): ?>
        <div class="uk-alert-primary comentario me-4 fw-bolder h-25" style="display: none;" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p class="pe-2">Se ha eliminado correctamente.</p>
        </div>
    <?php endif ?>


</div>

<div class="me-4">
    <div class="mt-3 mb-5">
        <ul class="sin-circulos d-flex justify-content-end ">
            <li class="borde-menu activo ">
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
            <li class="borde-menu activo activo-borde">
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

            <li class="borde-menu activo">
                <a href="?c=controladorCitas/citasRealizadas" class="text-decoration-none text-black" id="citaRealizada">
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
    <div class="d-flex justify-content-between align-items-center">
        <!-- Boton Agregar cita -->
        <div class="mover-input-agregarcita mt-4 ">
            <button class="btn btn-primary btn-agregar-doctores  icono-agregarCita" uk-toggle="target: #modal-examplecita" id="btnAgendarCita">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                    class="bi bi-calendar2-plus-fill me-2 " viewBox="0 0 16 16">
                    <path
                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 3.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5H2.545c-.3 0-.545.224-.545.5m6.5 5a.5.5 0 0 0-1 0V10H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V11H10a.5.5 0 0 0 0-1H8.5z" />
                </svg>Registrar Cita
            </button>
        </div>
        <!-- Buscador de pacientes -->
        <div class="mover-input-buscar mt-4 validar" id="buscadorCitasP">
            <form id="form" class="d-flex justify-content-end" autocomplete="off" method="POST" action="?c=controladorCitas/mostrarBusquedaPendienteHoy">
                <input class="form-control input-buscar tamaño-input-buscar" type="text" name="cedula"
                    placeholder="Ingrese Cedula" required maxlength="8" minlength="6" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">

                <button class="btn btn-buscar " title="Buscar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
    <!-- Tabla -->

    <div class="d-flex justify-content-center">
        <div class="tamaño-tabla contenedor_tabla mt-5">
            <table class="table table-striped" id="tabla">
                <thead>
                    <tr>
                        <th class=" text-center ">CI</th>
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
                    <?php if ($datosCitasHoy): ?>
                        <?php foreach ($datosCitasHoy as $datoCita): ?>
                            <tr>
                                <td class="text-center"><?php echo $datoCita["nacionalidad"]; ?>-<?php echo $datoCita["cedula_p"]; ?></td>
                                <td class=" text-center border-start"><?= $datoCita["nombre_p"]; ?> <?= $datoCita["apellido_p"]; ?></td>
                                <td class=" text-center border-start"><?= $datoCita["telefono_p"]; ?></td>
                                <td class="d-none"><?= $datoCita["id_doctor"] ?></td>
                                <td class=" text-center border-start"><?= $datoCita["nombre_d"]; ?> <?= $datoCita["apellido_d"]; ?></td>
                                <td class=" text-center border-start"><?= $datoCita["especialidad"]; ?></td>
                                <td class=" text-center border-start"><?= $datoCita["fecha"]; ?></td>
                                <td class=" text-center border-start d-none" id="insertarhora"><?= $datoCita["hora"]; ?></td>
                                <td class=" text-center border-start " id="insertarhora2"></td>
                                <td class=" text-center border-start"><?= $datoCita["estado"]; ?></td>

                                <td class="border-start">

                                    <div class="d-flex justify-content-center align-items-center">
                                        <!-- editar -->
                                        <div class="me-2">
                                            <a href="#" class="btns-accion botonesEditar" uk-toggle="target: #modal-examplecitaeditar<?= $datoCita["id_cita"]; ?>"
                                                uk-tooltip="Modificar Cita" id="btnEditarCitaPendiente">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                    fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd"
                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                </svg>
                                            </a>
                                        </div>


                                        <!-- eliminar -->

                                        <div class="me-2">
                                            <a href="#" class="btns-accion" uk-toggle="target: #modal-exampleEliminarcita<?= $datoCita["id_cita"]; ?>"
                                                uk-tooltip="Eliminar Cita" id="eliminarCitaP">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                    fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                    <path
                                                        d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                                </svg>
                                            </a>
                                        </div>

                                        <!-- status -->
                                        

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
                            ¿Desea Eliminar La Cita de Hoy?
                        </h5>
                    </div>
                </div>

                <div class="mt-3 uk-text-right">
                    <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                        type="button">Cancelar</button>
                    <a class="btn col-3 btn-agregarcita-modal text-decoration-none" href="?c=controladorCitas/eliminarCitaHoy&id_cita=<?= $datoCita["id_cita"]; ?>&id_usuario=<?= $_SESSION['id_usuario']?>">Eliminar</a>
                </div>

            </div>
        </div>




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
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-calendar-day-fill azul me-2 mb-3 " viewBox="0 0 16 16">
                            <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5h16v9zm-4.785-6.145a.428.428 0 1 0 0-.855.426.426 0 0 0-.43.43c0 .238.192.425.43.425zm.336.563h-.672v4.105h.672V8.418zm-6.867 4.105v-2.3h2.261v-.61H4.684V7.801h2.464v-.61H4v5.332h.684zm3.296 0h.676V9.98c0-.554.227-1.007.953-1.007.125 0 .258.004.329.015v-.613a1.806 1.806 0 0 0-.254-.02c-.582 0-.891.32-1.012.567h-.02v-.504H7.98v4.105z" />
                        </svg>
                    </div>
                    <div class="">
                        <p class="uk-modal-title fs-5">
                            Editar Cita
                        </p>
                    </div>

                </div>

                <form class="form-modal" action="?c=controladorCitas/editarCitaHoy&cedulaDb<?= $datoCita["id_cita"]; ?>" method="POST">

                    <input type="hidden" name="id_cita" value="<?= $datoCita["id_cita"]; ?>">

                    <input type="hidden" name="id_usuario" value="<?= $_SESSION["id_usuario"]; ?>">

                    <div class="input-group flex-nowrap caja">
                        <span class="input-modal mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-clipboard2-check-fill azul" viewBox="0 0 16 16">
                                <path
                                    d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5" />
                                <path
                                    d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585q.084.236.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5q.001-.264.085-.5m6.769 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                            </svg>
                        </span>
                        <select class="form-control input-modal especialidad" name="consulta">
                            <option selected disabled value="<?= $datoCita["id_especialidad"] ?>"><?= $datoCita["especialidad"] ?></option>
                        </select>
                    </div>

                    <div class="input-group flex-nowrap">
                        <span class=" mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                                class="bi bi-person-fill azul mb-2" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                            </svg>
                            Doctor</span>


                    </div>

                    <div class="mt-2 mb-2 listaDoctores">

                    </div>

                    <input type="hidden" class="id_servicioMedico" name="id_servicioMedico">

                    <div class="input-modal mt-3">
                        <ul uk-accordion="multiple: true">
                            <li>
                                <a class="uk-accordion-title text-decoration-none" href="#">

                                    <h6 class="acordion-paciente fw-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-week-fill azul mb-2" viewBox="0 0 16 16">
                                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zM8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z" />
                                        </svg>
                                        Horario del Doctor
                                    </h6>
                                </a>

                                <div class="uk-accordion-content">

                                </div>
                            </li>
                        </ul>
                    </div>


                    <div class="alert alert-danger d-flex align-items-center justify-content-center alertaClassEditar d-none" role="alert" id="alertahorarioCitaEdi">
                        <div class="text-center">
                            <p style="font-size: 10px; height: 20px;" class="text-center mb-3">VERIFIQUE QUE LA FECHA DE LA CONSULTA ESTE COMPRENDIDA EN EL HORARIO DEL DOCTOR</p>
                        </div>
                    </div>


                    <div class="input-group flex-nowrap validar">
                        <span class="input-modal mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-calendar-date-fill azul" viewBox="0 0 16 16">
                                <path
                                    d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zm5.402 9.746c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2" />
                                <path
                                    d="M16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-6.664-1.21c-1.11 0-1.656-.767-1.703-1.407h.683c.043.37.387.82 1.051.82.844 0 1.301-.848 1.305-2.164h-.027c-.153.414-.637.79-1.383.79-.852 0-1.676-.61-1.676-1.77 0-1.137.871-1.809 1.797-1.809 1.172 0 1.953.734 1.953 2.668 0 1.805-.742 2.871-2 2.871zm-2.89-5.435v5.332H5.77V8.079h-.012c-.29.156-.883.52-1.258.777V8.16a13 13 0 0 1 1.313-.805h.632z" />
                            </svg>
                        </span>
                        <input class="form-control input-modal fecha" id="fechaEditar" type="date" name="fecha" required pattern="\d{2}\/\d{2}\/\d{4}" placeholder="Fecha" value="<?= $datoCita["fecha"] ?>">

                    </div>

                    <div class="input-group flex-nowrap">
                        <span class="input-modal mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-clock-fill azul" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                            </svg>
                        </span>
                        <input class="form-control input-modal" type="time" name="hora" placeholder="Hora" required value="<?= $datoCita["hora"] ?>">
                    </div>





                    <div class="mt-3 uk-text-right">
                        <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                            type="button">Cancelar</button>
                        <button class="btn col-3 btn-agregarcita-modal btnEditarCita" id="btnEditarCita" type="submit">Editar</button>
                    </div>
            </div>
        </div>

        </form>

    <?php endforeach ?>

<?php else: ?>


    <tr>
        <td colspan="9" class="text-center">NO HAY CITAS PARA HOY

        </td>
    </tr>
<?php endif ?>

</tbody>

</table>
    </div>
</div>

</div>


<?php require_once 'modalesCitas-Control.php'; ?>

<?php require_once './src/vistas/head/footer.php'; ?>

<script type="text/javascript" src="./src/assets/js/validacionesCitasRegistrar.js"></script>
<script type="text/javascript" src="./src/assets/js/ayudaCitasHoy.js"></script>
<script type="text/javascript" src="./src/assets/citas.js"></script>




<!-- botones -->