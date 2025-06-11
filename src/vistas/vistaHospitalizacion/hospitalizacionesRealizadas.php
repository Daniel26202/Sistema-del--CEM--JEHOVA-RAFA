<?php require_once './src/vistas/head/head.php'; ?>

<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">
    <div class="m-auto" style="width: 95%;">
        <div class=" d-flex justify-content-between mb-2">
            <div class=" d-flex align-items-center ">
                <h5 class="fw-bolder ms-3">Hospitalizaciones realizadas</h5>
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


        </div>

        <div class=" me-5 pe-1 mb-2 mt-3 d-flex justify-content-end w-100">

            <ul class="sin-circulos d-flex justify-content-end">

                <li class="">
                    <div class="borde-de-menu color-linea mb-1"></div>
                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/hospitalizacion"
                        class="text-decoration-none me-3 color-letras" id="DMservicioMedico">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="20" fill="currentColor"
                            class="bi bi-clipboard-pulse me-1" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M10 1.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5zm-5 0A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5zm-2 0h1v1H3a1 1 0 0 0-1 1V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3.5a1 1 0 0 0-1-1h-1v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2m6.979 3.856a.5.5 0 0 0-.968.04L7.92 10.49l-.94-3.135a.5.5 0 0 0-.895-.133L4.232 10H3.5a.5.5 0 0 0 0 1h1a.5.5 0 0 0 .416-.223l1.41-2.115 1.195 3.982a.5.5 0 0 0 .968-.04L9.58 7.51l.94 3.135A.5.5 0 0 0 11 11h1.5a.5.5 0 0 0 0-1h-1.128z" />
                        </svg>Hospitalizaciones pendientes</a>
                </li>
                <li class="li">
                    <div class="borde-de-menu mb-1 activo-border"></div>
                    <div class="hover-grande">
                        <a href="/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/hospitalizacionesRealizadas"
                            class="text-decoration-none me-3 color-letras" id="DMserviciosExtras">
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
</div>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/hospitalizacion/hospitalizacionesRealizadas.js"></script>

<?php require_once './src/vistas/head/footer.php'; ?>