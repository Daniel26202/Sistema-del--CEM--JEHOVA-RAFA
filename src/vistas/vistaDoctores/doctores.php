z<?php require_once './src/vistas/head/head.php'; ?>

<div class="">

    <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
        <div class="ms-5 d-flex align-items-center" id="inicioDirectorio">
            <h1 class="fw-bold">DIRECTORIO MÉDICO</h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" fill="currentColor"
                class="bi bi-clipboard2-pulse ms-2" viewBox="0 0 16 16">
                <path
                    d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5h3Z" />
                <path
                    d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-12Z" />
                <path
                    d="M9.979 5.356a.5.5 0 0 0-.968.04L7.92 10.49l-.94-3.135a.5.5 0 0 0-.926-.08L4.69 10H4.5a.5.5 0 0 0 0 1H5a.5.5 0 0 0 .447-.276l.936-1.873 1.138 3.793a.5.5 0 0 0 .968-.04L9.58 7.51l.94 3.135A.5.5 0 0 0 11 11h.5a.5.5 0 0 0 0-1h-.128L9.979 5.356Z" />
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
                    <li id="perfilPaciente"><a href="/Sistema-del--CEM--JEHOVA-RAFA/Perfil/perfil" class="uk-animation-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                class="bi bi-person-fill azul uk-animation-scale-up" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                            </svg>PERFIL
                        </a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="#" id="btnayudaDoctores"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                                fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
                                <path
                                    d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                            </svg>AYUDA</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="/Sistema-del--CEM--JEHOVA-RAFA/Bitacora/bitacora"><svg xmlns="http://www.w3.org/2000/svg" width="25"
                                height="25" fill="currentColor" class="bi bi-question-octagon-fill azul me-1"
                                viewBox="0 0 16 16">
                                <path
                                    d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z" />
                            </svg> CONFIGURACIÓN</a></li>
                    <li class="uk-nav-divider"></li>

                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#eliminar">
                            <img src="<?= $urlBase; ?>../src/assets/img/icono-cerrar-sesion.svg" width="34" height="34" uk-svg
                                class="azul" style="margin-left: -4px;">
                            </svg>SALIR</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- modal de cerrar sesión -->
    <?php require_once './src/vistas/modalCierreS/modalCierreS.php'; ?>

    <div class="d-flex justify-content-center">

        <?php if ($parametro != ""): ?>


            <?php if ($parametro[0] == "error"): ?>
                <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder h-25" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p class="pe-2">La cédula o el usuario ya existen, intente de nuevo.</p>
                </div>
                <div class="d-flex justify-content-center">
                <?php elseif ($parametro[0] == "Usuario"): ?>
                    <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p class="pe-2">EL usuario ya existe, intente de nuevo.</p>
                    </div>
                <?php elseif ($parametro[0] == "editado"): ?>
                    <div class="uk-alert-primary comentarioD  me-4 fw-bolder " uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p class="pe-2">Se actualizo correctamente.</p>
                    </div>
                <?php elseif ($parametro[0] == "eliminado"): ?>
                    <div class="uk-alert-primary comentarioD  me-4 fw-bolder " uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p class="pe-2">Se ha eliminado correctamente.</p>
                    </div>
                <?php elseif ($parametro[0] == "especialidadRegistrar"): ?>
                    <div class="uk-alert-primary comentarioD  me-4 fw-bolder" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p class="pe-2">Se insertó la Especialidad correctamente.</p>
                    </div>
                <?php elseif ($parametro[0] == "especialidadEliminar"): ?>

                    <div class="uk-alert-primary comentarioD  me-4 fw-bolder " uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p class="pe-2">Se eliminó la Especialidad correctamente.</p>
                    </div>
                <?php endif ?>
                </div>
            <?php endif ?>



    </div>

    <div class="d-flex">

        <div class="w-75 ms-5 pb-4">
            <h3 class="fw-bold" id="inicioServicio">DOCTORES


                <img src="<?= $urlBase ?>../src/assets/img/doctor.png" width="30" height="30" uk-svg class="azul mb-2">

            </h3>

        </div>

        <div class="d-flex justify-content-end mb-3 me-4">

            <button class="btn btn-primary btn-agregar-doctores mb-2" uk-toggle="target: #modal-especialidad"
                id="btnEspecialidades">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                    class="bi bi-mortarboard-fill me-1" viewBox="0 0 16 16">
                    <path
                        d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5Z" />
                    <path
                        d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032Z" />
                </svg>
                Especialidades
            </button>

        </div>
    </div>

    <div class="div-tabla m-auto contenedor">

        <div class="d-flex justify-content-between align-items-center">

            <div class="">
                <?php if (!$this->permisos($_SESSION["id_rol"], "guardar", "Doctores")): ?>
                    <!-- no hay -->
                <?php else: ?>
                    <button class="btn btn-primary btn-agregar-doctores mb-2" uk-toggle="target: #modal-agregar-doctores"
                        id="btnagregarDoctor">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                            class="bi bi-plus-circle-fill me-1" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                        </svg>
                        Registrar doctor
                    </button>
                <?php endif; ?>
            </div>
            <div class="d-flex justify-content-end mt-4 mb-4 col-5">

                <div class="mover-input-buscar d-flex">

                    <a class="btn d-none" title="Buscar" id="reiniciarBusqueda" uk-tooltip="Restablecer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                            <path
                                d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                            <path fill-rule="evenodd"
                                d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                        </svg>
                    </a>

                    <form class="d-flex justify-content-end" action="/Sistema-del--CEM--JEHOVA-RAFA/Doctores/buscarDoctor" method="POST"
                        autocomplete="off" id="buscadorDoctores">

                        <input class="form-control input-buscar tamaño-input-buscar" type="number" name="busqueda"
                            placeholder="Ingrese la Cedula" id="inputBuscadorDoctor">

                        <button class="btn btn-buscar " title="Buscar" type="submit" id="btnBuscarDoc">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                        </button>

                    </form>
                </div>
            </div>

        </div>

        <div>
            <div class="contenedor_tabla">

                <table class="table table-striped" id="tabla">
                    <thead>
                        <tr>
                            <th class="border-start-0 text-center">Cédula</th>
                            <th class="border-start text-center">Nombre</th>
                            <th class="border-start text-center">Apellido</th>
                            <th class="border-start text-center">Teléfono</th>
                            <th class="border-start text-center">E_mail</th>
                            <th class="border-start text-center">Especialidad</th>

                            <th class="border-start text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($datos): ?>
                            <?php foreach ($datos as $dato): ?>
                                <tr>
                                    <td class=" text-center">
                                        <?php echo $dato["nacionalidad"] . '-' . $dato["cedula"]; ?>
                                    </td>
                                    <td class="border-start text-center">
                                        <?php echo $dato["nombre_d"]; ?>
                                    </td>
                                    <td class="border-start text-center">
                                        <?php echo $dato["apellido"]; ?>
                                    </td>
                                    <td class="border-start text-center">
                                        <?php echo $dato["telefono"]; ?>
                                    </td>
                                    <td class="border-start text-center">
                                        <?php echo $dato["correo"]; ?>
                                    </td>
                                    <td class="border-start text-center">
                                        <?php echo $dato["nombre"]; ?>
                                    </td>


                                    <td class="border-start text-center">
                                        <!-- editar -->

                                        <?php if (!$this->permisos($_SESSION["id_rol"], "editar", "Doctores")): ?>
                                            <!-- no hay -->
                                        <?php else: ?>
                                            <button class="btn btn-tabla mb-1 btn-js editar botonesEdi"
                                                uk-toggle="target: #modal-editar-doctores<?php echo $dato["id_personal"]; ?>"
                                                id="btneditarDoctor" data-index="<?php echo $dato["id_personal"]; ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                    class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                                </svg>

                                            </button>


                                        <?php endif; ?>

                                        <?php if (!$this->permisos($_SESSION["id_rol"], "eliminar", "Doctores")): ?>
                                            <!-- no hay -->
                                        <?php else: ?>
                                            <button class="btn btn-tabla mb-1"
                                                uk-toggle="target: #modal-eliminar-doctores<?php echo $dato["id_personal"]; ?>"
                                                id="btnEliminarDoctor">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                    class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                                </svg>
                                            </button>

                                        <?php endif; ?>
                                        <button class="btn btn-tabla mb-1 botonesInfo" title="Horarios Del Doctor"
                                            uk-toggle="target: #modal-info-doctores"
                                            data-index="<?php echo $dato["id_personal"]; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>

                            <?php endforeach ?>

                        <?php else: ?>


                            <tr>
                                <td colspan="9" class="text-center">NO HAY REGISTROS

                                </td>
                            </tr>
                        <?php endif ?>

                    </tbody>
                </table>
            </div>
            <table class="table table-striped " style="margin-top: -16px;">
                <thead>

                </thead>
                <tbody>
                    <tr class="d-none" id="noResultadoDoc">
                        <td colspan="9" class="text-center">NO HAY REGISTROS

                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

    </div>

</div>

<?php require_once './src/vistas/vistaDoctores/modal/modalAgregarDoctores.php'; ?>
<?php require_once './src/vistas/vistaDoctores/modal/modalEditarDoctores.php'; ?>
<?php require_once './src/vistas/vistaDoctores/modal/modalEliminarDoctores.php'; ?>
<?php require_once './src/vistas/vistaDoctores/modal/modalesEspecialidades.php'; ?>
<?php require_once './src/vistas/vistaDoctores/modal/infoModalDoctores.php'; ?>

<?php if ($parametro != ""): ?>
    <?php $concatenarRuta = ""; ?>
    <?php foreach ($parametro as $p): ?>
        <?php $concatenarRuta .= "../"; ?>
        <script type="text/javascript" src="<?= $concatenarRuta ?>../src/assets/js/especialidades.js"></script>
        <script type="text/javascript" src="<?= $concatenarRuta ?>../src/assets/js/ayudaDoctores.js"></script>
        <script type="text/javascript" src="<?= $concatenarRuta ?>../src/assets/js/buscadorDoctores.js"></script>
        <script type="text/javascript" src="<?= $concatenarRuta ?>../src/assets/js/validacionesDoctoresRegistrar.js"></script>
        <script type="text/javascript" src="<?= $concatenarRuta ?>../src/assets/js/validacionesDoctorEditar.js"></script>
        <script type="text/javascript" src="<?= $concatenarRuta ?>../src/assets/js/imgDoctores.js"></script>
        <script type="text/javascript" src="<?= $concatenarRuta ?>../src/assets/js/doctores.js"></script>

    <?php endforeach; ?>

<?php else: ?>
    <script type="text/javascript" src="../src/assets/js/especialidades.js"></script>
    <script type="text/javascript" src="../src/assets/js/ayudaDoctores.js"></script>
    <script type="text/javascript" src="../src/assets/js/buscadorDoctores.js"></script>
    <script type="text/javascript" src="../src/assets/js/validacionesDoctoresRegistrar.js"></script>
    <script type="text/javascript" src="../src/assets/js/validacionesDoctorEditar.js"></script>
    <script type="text/javascript" src="../src/assets/js/imgDoctores.js"></script>
    <script type="text/javascript" src="../src/assets/js/doctores.js"></script>
<?php endif; ?>
<?php require_once './src/vistas/head/footer.php'; ?>