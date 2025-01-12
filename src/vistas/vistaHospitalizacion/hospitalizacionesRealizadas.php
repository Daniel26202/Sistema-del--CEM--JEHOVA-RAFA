<?php require_once './src/vistas/head/head.php'; ?>

<div class="container pt-4">

    <div class=" d-flex justify-content-between mb-2">
        <div class=" d-flex align-items-center ">
            <h3 class="fw-bolder ms-3">Hospitalizaciones realizadas</h3>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                class="color-borde-ventas bi bi-plus-circle ms-1" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path
                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
            </svg>
        </div>
        <div class="col-5 mt-2">
            <div id="divComentarios" class="ms-3 col-9"></div>
        </div>

        <!-- ayuda -->
        <div class="me-3 mb-2 pb-1 mt-2">

            <a tabindex="0" role="button" aria-haspopup="true"><svg xmlns="http://www.w3.org/2000/svg" width="50"
                    height="50" fill="currentColor" class="bi bi-wrench-adjustable-circle azul" viewBox="0 0 16 16"
                    id="desplegablefactura">
                    <path d="M12.496 8a4.491 4.491 0 0 1-1.703 3.526L9.497 8.5l2.959-1.11c.027.2.04.403.04.61Z"></path>
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0Zm-1 0a7 7 0 1 0-13.202 3.249l1.988-1.657a4.5 4.5 0 0 1 7.537-4.623L7.497 6.5l1 2.5 1.333 3.11c-.56.251-1.18.39-1.833.39a4.49 4.49 0 0 1-1.592-.29L4.747 14.2A7 7 0 0 0 15 8Zm-8.295.139a.25.25 0 0 0-.288-.376l-1.5.5.159.474.808-.27-.595.894a.25.25 0 0 0 .287.376l.808-.27-.595.894a.25.25 0 0 0 .287.376l1.5-.5-.159-.474-.808.27.596-.894a.25.25 0 0 0-.288-.376l-.808.27.596-.894Z">
                    </path>
                </svg></a>
            <div class="uk-nav uk-dropdown-nav uk-drop uk-dropdown" uk-dropdown="pos: top-right" id="desplegable2"
                style="top: 66.8755px; left: 421px; max-width: 606px;">
                <ul>
                    <li id="perfilPaciente"><a href="?c=ControladorPerfil/perfil" class="uk-animation-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                class="bi bi-person-fill azul uk-animation-scale-up" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6">
                                </path>
                            </svg>PERFIL
                        </a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="#" id="btnayudaCitaP"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                                fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
                                <path
                                    d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z">
                                </path>
                            </svg>AYUDA</a></li>
                    <li class="uk-nav-divider"></li>

                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#eliminar">
                            <img src="./src/assets/img/icono-cerrar-sesion.svg" width="34" height="34" uk-svg=""
                                class="azul" style="margin-left: -4px;" hidden=""><svg enable-background="new 0 0 64 64"
                                height="34" version="1.1" viewBox="0 0 64 64" width="34" xml:space="preserve"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                class="azul uk-svg" style="margin-left: -4px;">
                                <path
                                    d="M56.826,32C56.826,18.311,45.689,7.174,32,7.174S7.174,18.311,7.174,32S18.311,56.826,32,56.826S56.826,45.689,56.826,32z   M34.437,31.962c0,1.301-1.054,2.356-2.356,2.356c-1.301,0-2.356-1.055-2.356-2.356V19.709c0-1.301,1.055-2.356,2.356-2.356  c1.301,0,2.356,1.054,2.356,2.356V31.962z M48.031,32.041c0,8.839-7.191,16.03-16.031,16.03s-16.031-7.191-16.031-16.03  c0-4.285,1.669-8.313,4.701-11.34c0.46-0.46,1.062-0.689,1.665-0.689s1.207,0.23,1.667,0.691c0.92,0.921,0.919,2.412-0.002,3.332  c-2.139,2.138-3.318,4.981-3.318,8.006c0,6.24,5.077,11.317,11.318,11.317s11.318-5.077,11.318-11.317  c0-3.023-1.176-5.865-3.314-8.003c-0.92-0.921-0.919-2.412,0.001-3.333c0.921-0.921,2.412-0.919,3.333,0.001  C46.364,23.734,48.031,27.76,48.031,32.041z">
                                </path>
                            </svg>
                            SALIR</a></li>
                </ul>
            </div>
        </div>

    </div>

    <div class=" me-5 pe-1 mb-2 mt-3 d-flex justify-content-end w-100">

        <ul class="sin-circulos d-flex justify-content-end">

            <li class="">
                <div class="borde-de-menu color-linea mb-1"></div>
                <a href="?c=ControladorHospitalizacion/hospitalizacion" class="text-decoration-none text-black me-3"
                    id="DMservicioMedico">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="20" fill="currentColor"
                        class="bi bi-clipboard-pulse me-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M10 1.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5zm-5 0A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5zm-2 0h1v1H3a1 1 0 0 0-1 1V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3.5a1 1 0 0 0-1-1h-1v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2m6.979 3.856a.5.5 0 0 0-.968.04L7.92 10.49l-.94-3.135a.5.5 0 0 0-.895-.133L4.232 10H3.5a.5.5 0 0 0 0 1h1a.5.5 0 0 0 .416-.223l1.41-2.115 1.195 3.982a.5.5 0 0 0 .968-.04L9.58 7.51l.94 3.135A.5.5 0 0 0 11 11h1.5a.5.5 0 0 0 0-1h-1.128z" />
                    </svg>Hospitalizaciones pendientes</a>
            </li>
            <li class="li">
                <div class="borde-de-menu mb-1 activo-border"></div>
                <div class="hover-grande">
                    <a href="?c=ControladorHospitalizacion/hospitalizacionesRealizadas"
                        class="text-decoration-none text-black me-3" id="DMserviciosExtras">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="20" fill="currentColor"
                            class="bi bi-clipboard-check me-1 color-activo-svg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                            <path
                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z" />
                            <path
                                d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z" />
                        </svg>Hospitalizaciones realizadas</a>
                </div>

            </li>

        </ul>

    </div>

    <div class="fondo-tabla">

        <div class="d-flex justify-content-between align-items-center">
            <div class="text-start mb-2"></div>
            <div class="d-flex justify-content-end mb-3 mt-2 me-2 col-3">
                <input class="form-control input-busca" type="number" name="" placeholder="Ingrese cédula"
                    id="inputBuscHR">
                <button class="btn boton-buscar" title="Buscar" id="btnBuscHR">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                </button>
            </div>
        </div>
        <div class=" table-responsive">

            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Diagnostico</th>
                        <th>Doctor asignado</th>
                        <th>Horas</th>

                        <?php if ($_SESSION['rol'] == "usuario"): ?>
                            <!-- no hay -->
                        <?php elseif ($_SESSION['rol'] == "administrador"): ?>

                            <th>Precio total</th>

                        <?php endif ?>

                    </tr>
                </thead>
                <tbody id="tbodyR">
                    <!-- se agrega en el js -->
                </tbody>
            </table>
            <div id="notificacionR" class="text-center d-none">Paciente no encontrado</div>
        </div>

    </div>

</div>

<script type="text/javascript" src="./src/assets/js/hospitalizacion/hospitalizacionesRealizadas.js"></script>

<?php require_once './src/vistas/head/footer.php'; ?>