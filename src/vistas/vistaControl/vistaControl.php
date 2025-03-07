<?php require_once './src/vistas/head/head.php'; ?>

<div class="d-flex align-items-center justify-content-between mt-4 mb-5">
    <div class="ms-5 d-flex align-items-center" id="inicioPacientes">
        <h1 class="fw-bold">CONTROL MÉDICO</h1>
        <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor"
            class="bi bi-person-gear ms-2 mb-2" viewBox="0 0 16 16">
            <path
                d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm.256 7a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
        </svg>
    </div>

    <div class="me-4">

        <a><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                class="bi bi-wrench-adjustable-circle azul" viewBox="0 0 16 16" id="desplegablePaciente">
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
                <li><a href="#" id="btnayudaPaciente"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                            fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
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

<!-- Modal Cerrar Sesión  -->
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
                <a href="?c=ControladorInicio/inicio&cerrar" class="btn btn-primary text-decoration-none">Salir</a>
            </div>
        </div>
    </div>
</div>

<!-- Aqui se guarda el id del usuario que inicio session -->
<input type="hidden" id="id_usuario_bitacora" value="<?= $_SESSION['id_usuario'];?>">


<div class="d-flex justify-content-end mb-3 me-4">

    <button class="btn btn-primary btn-agregar-doctores mb-2" uk-toggle="target: #modal-sintomas"
        id="btnEspecialidades">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
            class="bi bi-mortarboard-fill me-1" viewBox="0 0 16 16">
            <path
                d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5Z">
            </path>
            <path
                d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032Z">
            </path>
        </svg>
        Síntomas
    </button>

</div>

<div class="div-tabla contenedor m-auto mt-3 p-auto">

    <div class="text-center comentarioControl fw-bolder" style="display: none;" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p class="pe-2"></p>
    </div>
    <!-- comentario comentarioRed me-4 fw-bolder h-25 mb-2 -->
    <div class="d-flex justify-content-between align-items-center">
        <!-- Boton Agregar control -->
        <div class="mover-input-agregarcita mt-4 ">
            <button class="btn btn-primary btn-agregar-doctores col-11" uk-toggle="target: #modal-examplecontrol"
                id="btnControl">
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                    class="bi bi-person-lines-fill me-1" viewBox="0 0 16 16">
                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z" />
                </svg>Registrar Control Médico
            </button>
        </div>
        <!-- Buscador de pacientes -->
        <div class="mover-input-buscar mt-4">
            <form id="form-buscador" class="d-flex justify-content-end" autocomplete="off">
                <input id="input-buscador" class="form-control input-buscar tamaño-input-buscar" type="text"
                    name="cedula" placeholder="Ingrese Cedula">

                <button class="btn btn-buscar " title="Buscar Paciente">
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
    <div class="tamaño-tabla ms-auto mt-4">
        <table>
            <thead>
                <tr class="">
                    <th class="">Pacientes</th>
                    <th class="text-center">Descripción</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="lista-pacientes" id="ul-pacientes"></div>
                        <!-- js -->

                    </td>

                    <td class=" ">
                        <input type="hidden" name="" id="id_control">
                        <div class="justificar lista-pacientes2" id="div-controles">
                            <ul>
                                <div id="div"></div>
                                <!-- js -->
                            </ul>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>






<!-- Modales del modulo Control -->

<!-- agregar Control-->
<div id="modal-examplecontrol" uk-modal>
    <div class="uk-modal-dialog uk-modal-body tamaño-modal">
        <!-- Botón que cierra el modal -->
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
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                    class="bi bi-person-lines-fill azul me-3 mb-3" viewBox="0 0 16 16">
                    <path
                        d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z" />
                </svg>
            </div>
            <div>
                <p class="uk-modal-title fs-5">
                    Nuevo control
                </p>
            </div>

        </div>

        <form class="form-modal" id="modalAgregarControl">

            <div>
                <input type="hidden" name="fecha_hora" id="fechaHora">
            </div>

            <div class="input-group flex-nowrap ">
                <span class="input-modal mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-person-vcard-fill azul" viewBox="0 0 16 16">
                        <path
                            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                    </svg>
                </span>

                <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario'];?>">

                <input class="form-control input-modal  input-disabled inputExpresiones input-modal-remove" type="text"
                    name="cedula" id="cedulaControl" placeholder="Cedula">
            </div>

            <!-- accordion -->
            <div class="input-modal">
                <ul uk-accordion="multiple: true">
                    <li>
                        <a class="uk-accordion-title text-decoration-none" href="#">

                            <h6 class="acordion-paciente"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="currentColor" class="bi bi-person-fill azul me-2 mb-2" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                </svg>Paciente</h6>
                        </a>

                        <div class="uk-accordion-content">
                            <div id="mostrarPaciente">
                                <p id="datosPaciente">Paciente:</p>
                                <p id="edad">Edad:</p>
                                <input type="hidden" name="id_paciente" id="idPaciente">
                            </div>
                            <div id="mandarRegistrarPaciente">

                                <a href="?c=ControladorPacientes/getPacientes" class="text-decoration-none">
                                    <p id="No_paciente" style="font-size: 14px;" class="azul text-center"></p>
                                </a>

                            </div>
                        </div>

                    </li>
                </ul>
            </div>

            <div class="d-none" id="contenedorF">

                <!-- accordion -->
                <div class="input-modal">
                    <ul uk-accordion="multiple: true">
                        <li class="uk-open">
                            <a class="uk-accordion-title text-decoration-none" href="#">

                                <h6 class="acordion-paciente"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                        height="20" fill="currentColor" class="bi bi-person-fill azul me-2 mb-2"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                    </svg>Síntomas</h6>
                            </a>
                            <div class="uk-accordion-content">


                                <?php if ($datosS): ?>
                                    <?php foreach ($datosS as $sintomas): ?>

                                        <div class="form-check form-switch d-flex align-items-center">
                                            <div>
                                                <input class="form-check-input inputExpresiones inpSin" type="checkbox"
                                                    role="switch" id="flexSwitchCheckDefault" name="sintomas[]"
                                                    value="<?= $sintomas["id_sintomas"]; ?>">
                                            </div>
                                            <div>
                                                <label class="form-check-label mt-1 for=" flexSwitchCheckDefault">
                                                    <?= $sintomas['nombre']; ?>
                                                </label>
                                            </div>

                                        </div>

                                    <?php endforeach ?>
                                <?php else: ?>
                                    <p>NO HAY REGISTROS</p>

                                <?php endif ?>


                            </div>
                        </li>
                    </ul>
                </div>

                <?php if ($_SESSION['rol'] == "usuario"): ?>
                    <!-- no hay --><input type="hidden" id="idDExisteU" name="doctor" value="<?= $_SESSION['id_usuario'] ?>">
                <?php elseif ($_SESSION['rol'] == "administrador"): ?>
                    <!-- accordion -->
                    <div class="input-modal">
                        <ul uk-accordion="multiple: true">
                            <li class="uk-open">
                                <a class="uk-accordion-title text-decoration-none" href="#">

                                    <h6 class="acordion-paciente"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                            height="20" fill="currentColor" class="bi bi-person-fill azul me-2 mb-2"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                        </svg>Doctor</h6>
                                </a>
                                <div class="uk-accordion-content" id="divD">

                                    <?php if ($datosD): ?>
                                        <?php foreach ($datosD as $doctor): ?>

                                            <div class="form-check form-switch d-flex align-items-center">
                                                <div>
                                                    <input class="form-check-input inputExpresiones" type="radio" role="switch"
                                                        id="flexSwitchCheckDefault" name="doctor"
                                                        value="<?= $doctor["id_usuario"]; ?>">
                                                </div>
                                                <div>
                                                    <label class="form-check-label mt-1 for=" flexSwitchCheckDefault">
                                                        <?= $doctor['nombredoc']; ?>
                                                    </label>
                                                </div>

                                            </div>

                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <p>NO HAY REGISTROS</p>

                                    <?php endif ?>

                                </div>
                            </li>
                        </ul>
                    </div>
                <?php endif ?>



                <div class="input-modal mt-3">
                    <ul uk-accordion="multiple: true">
                        <li class="uk-open">
                            <a class="uk-accordion-title text-decoration-none" href="#">

                                <h6 class="acordion-paciente fw-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                        class="bi bi-calendar2-week-fill azul mb-2" viewBox="0 0 16 16">
                                        <path
                                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zM8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z" />
                                    </svg>
                                    Añadir Patología Paciente
                                </h6>
                            </a>

                            <div class="uk-accordion-content">
                                <div class="d-flex justify-content-center">

                                    <input type="button" class="btn btn-outline-secondary fw-bold btnNin col-12 mb-3" value="Ninguno">
                                </div>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <?php foreach ($datosPatologias as $patologia): ?>

                                        <div class="d-flex w-50 justify-content-between mb-3">

                                            <div class="form-check form-switch d-flex align-items-center">
                                                <div>
                                                    <input class="form-check-input inputExpresiones inputPP" type="checkbox"
                                                        role="switch" id="flexSwitchCheckDefault" name="patologias[]"
                                                        value="<?php echo $patologia['id_patologia'] ?>">
                                                </div>
                                                <div>
                                                    <label class="form-check-label mt-2" for="flexSwitchCheckDefault">
                                                        <?php echo $patologia['nombre_patologia'] ?>
                                                    </label>
                                                </div>

                                            </div>


                                        </div>
                                    <?php endforeach ?>


                                </div>

                            </div>
                        </li>
                    </ul>

                </div>

                <!-- nota -->
                <div class="form-floating input-modal">
                    <textarea class="form-control border-0 input-modal input-modal-remove"
                        placeholder="Leave a comment here" id="floatingTextarea2" style="height: 50px;"
                        name="nota"></textarea>
                    <label for="floatingTextarea2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                            class="bi bi-heart-pulse-fill azul me-2" viewBox="0 0 16 16">
                            <path
                                d="M1.475 9C2.702 10.84 4.779 12.871 8 15c3.221-2.129 5.298-4.16 6.525-6H12a.5.5 0 0 1-.464-.314l-1.457-3.642-1.598 5.593a.5.5 0 0 1-.945.049L5.889 6.568l-1.473 2.21A.5.5 0 0 1 4 9z" />
                            <path
                                d="M.88 8C-2.427 1.68 4.41-2 7.823 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C11.59-2 18.426 1.68 15.12 8h-2.783l-1.874-4.686a.5.5 0 0 0-.945.049L7.921 8.956 6.464 5.314a.5.5 0 0 0-.88-.091L3.732 8z" />
                        </svg>Nota</label>
                </div>

                <div class="form-floating input-modal">
                    <textarea class="form-control border-0 input-modal inputExpresiones input-modal-remove"
                        placeholder="Leave a comment here" id="floatingTextarea2" style="height: 50px;"
                        name="diagnostico"></textarea>
                    <label for="floatingTextarea2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                            class="bi bi-heart-pulse-fill azul me-2" viewBox="0 0 16 16">
                            <path
                                d="M1.475 9C2.702 10.84 4.779 12.871 8 15c3.221-2.129 5.298-4.16 6.525-6H12a.5.5 0 0 1-.464-.314l-1.457-3.642-1.598 5.593a.5.5 0 0 1-.945.049L5.889 6.568l-1.473 2.21A.5.5 0 0 1 4 9z" />
                            <path
                                d="M.88 8C-2.427 1.68 4.41-2 7.823 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C11.59-2 18.426 1.68 15.12 8h-2.783l-1.874-4.686a.5.5 0 0 0-.945.049L7.921 8.956 6.464 5.314a.5.5 0 0 0-.88-.091L3.732 8z" />
                        </svg>Diagnóstico</label>
                </div>
                <div class="form-floating input-modal">
                    <textarea class="form-control border-0 input-modal inputExpresiones input-modal-remove"
                        name="indicaciones" placeholder="Leave a comment here" id="floatingTextarea2"
                        style="height: 50px;"></textarea>
                    <label for="floatingTextarea2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                            class="bi bi-receipt-cutoff azul me-1" viewBox="0 0 16 16">
                            <path
                                d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5M11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z" />
                            <path
                                d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118z" />
                        </svg>
                        </svg>Prescripciones e indicaciones</label>
                </div>

                <div class="mt-4">
                    <p class=" p-0 m-0 fw-bolder text-center">Fecha de regreso</p>

                    <div class="input-group flex-nowrap mt-1">
                        <span class="input-modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-calendar-date-fill azul" viewBox="0 0 16 16">
                                <path
                                    d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zm5.402 9.746c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2" />
                                <path
                                    d="M16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-6.664-1.21c-1.11 0-1.656-.767-1.703-1.407h.683c.043.37.387.82 1.051.82.844 0 1.301-.848 1.305-2.164h-.027c-.153.414-.637.79-1.383.79-.852 0-1.676-.61-1.676-1.77 0-1.137.871-1.809 1.797-1.809 1.172 0 1.953.734 1.953 2.668 0 1.805-.742 2.871-2 2.871zm-2.89-5.435v5.332H5.77V8.079h-.012c-.29.156-.883.52-1.258.777V8.16a13 13 0 0 1 1.313-.805h.632z" />
                            </svg>
                        </span>
                        <input
                            class="form-control input-modal grp_control_fechaRegreso inputExpresiones input-modal-remove"
                            type="date" name="fechaRegreso" placeholder="Fecha"
                            uk-tooltip="title: Fecha de regreso; pos: right" require>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-center pe-3 ps-1 d-none" id="leyendaFec">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-info-circle azul me-1" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z">
                        </path>
                        <path
                            d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z">
                        </path>
                    </svg>
                    <i>El formato de la fecha es incorrecto. Debe ser mayor que la fecha de hoy y no debe exceder los 50
                        años en el futuro.
                    </i>
                </div>

            </div>


            <div class="mt-3 uk-text-right">
                <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                    type="button">Cancelar</button>
                <button class="btn col-4 btn-agregarcita-modal d-none" id="btnAC" type="submit">Agregar</button>
            </div>

        </form>

    </div>
</div>


<script type="text/javascript" src="./src/assets/control.js"></script>

<?php require_once './src/vistas/vistaControl/modalesSintomas.php'; ?>
<?php require_once './src/vistas/head/footer.php'; ?>