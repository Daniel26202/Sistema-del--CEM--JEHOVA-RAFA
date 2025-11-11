<?php require_once './src/vistas/head/head.php'; ?>


<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">
    <h5 style="width: 95%; " class="m-auto mb-3">Citas <?= ucfirst($vistaActiva) ?><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
            class="bi bi-calendar2-heart ms-2 ico" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5ZM1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v11a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V3Zm2 .5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V4a.5.5 0 0 0-.5-.5H3Zm5 4.493c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z" />
        </svg></h5>


    <input type="hidden" name="id_usuario" id="id_usuario_session" value="<?= $_SESSION['id_usuario'] ?>">


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
            <table class="exampleTable table table-striped" id="tabla">
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
                    <!-- js -->

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'modalesCitas-Control.php'; ?>
<?php require_once './src/vistas/head/footer.php'; ?>

<script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/expresionesModulares.js"></script>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/ayudaCitasPendientes.js"></script>
<script type="module" src="<?= $urlBase ?>../src/assets/citas.js"></script>