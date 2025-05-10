<?php require_once './src/vistas/head/head.php'; ?>

<div class="container-fluid px-4">

    <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
        <div class="ms-5 d-flex align-items-center" id="inicioFactura">
            <h1 class="fw-bold">FACTURACIÓN</h1>

            <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" fill="currentColor"
                class="bi bi-file-earmark-text ms-2" viewBox="0 0 16 16">
                <path
                    d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z" />
                <path
                    d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
            </svg>
        </div>

        <?php require_once './src/vistas/tasaBCV.php'; ?>

        <div class="me-4" id="desplegarAyudafactura">

            <a><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                    class="bi bi-wrench-adjustable-circle azul" viewBox="0 0 16 16" id="desplegablefactura">
                    <path d="M12.496 8a4.491 4.491 0 0 1-1.703 3.526L9.497 8.5l2.959-1.11c.027.2.04.403.04.61Z" />
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0Zm-1 0a7 7 0 1 0-13.202 3.249l1.988-1.657a4.5 4.5 0 0 1 7.537-4.623L7.497 6.5l1 2.5 1.333 3.11c-.56.251-1.18.39-1.833.39a4.49 4.49 0 0 1-1.592-.29L4.747 14.2A7 7 0 0 0 15 8Zm-8.295.139a.25.25 0 0 0-.288-.376l-1.5.5.159.474.808-.27-.595.894a.25.25 0 0 0 .287.376l.808-.27-.595.894a.25.25 0 0 0 .287.376l1.5-.5-.159-.474-.808.27.596-.894a.25.25 0 0 0-.288-.376l-.808.27.596-.894Z" />
                </svg></a>
            <div class="uk-nav uk-dropdown-nav contenido" uk-dropdown="pos: top-right" id="desplegable2">
                <ul>
                    <li id="perfilPaciente"><a href="/Sistema-del--CEM--JEHOVA-RAFA/Perfil/perfil" class="uk-animation-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                class="bi bi-person-fill azul uk-animation-scale-up" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                            </svg>PERFIL
                        </a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="#" id="btnayudaFactura"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                                fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
                                <path
                                    d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                            </svg>AYUDA</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="/Sistema-del--CEM--JEHOVA-RAFA/Bitacora/bitacora"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
                                <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z" />
                            </svg> CONFIGURACIÓN</a></li>
                    <li class="uk-nav-divider"></li>

                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#eliminar">
                            <img src="<?= $urlBase ?>../src/assets/img/icono-cerrar-sesion.svg" width="34" height="34" uk-svg class="azul"
                                style="margin-left: -4px;">
                            </svg>SALIR</a></li>
                </ul>
            </div>
        </div>

    </div>

    <!-- modal de cerrar sesión -->
    <?php require_once './src/vistas/modalCierreS/modalCierreS.php'; ?>


    <div class="caja-contenedor-tabla fondo-tabla p-1 mb-2 col-12 m-auto">


        <div class="mt-5 ms-2" style="background: #F8FCFF; border-radius:20px; overflow-y: auto;">
            <div class="">
                <div style="height: 70px;" class=" d-flex justify-content-around">

                    <button id="botonAgregar" class="btn btn-primary btn-agregar-doctores ms-4 mt-4 btn-agregar-ins-ser"
                        data-bs-toggle="modal" data-bs-target="#modal-agregar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                            class="bi bi-plus-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                        </svg>
                        Agregar Servicio
                    </button>

                    <button class="btn btn-primary btn-agregar-doctores ms-4 btn-agregar-ins-ser mt-4"
                        data-bs-toggle="modal" data-bs-target="#modal-agregar-insumos" id="btnInsumos">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                            class="bi bi-capsule" viewBox="0 0 16 16">
                            <path
                                d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                        </svg>
                        Agregar Insumos
                    </button>
                    <!-- <div class="d-flex align-items-center">
	<h5 id="datosPaciente"></h5>
</div> -->
                    <div class="mt-4 w-25 d-flex justify-content-center">
                        <a href="/Sistema-del--CEM--JEHOVA-RAFA/Factura/factura" class="text-decoration-none"
                            uk-tooltip="Retroceder">
                            <button class="btnRetroceder" id="btnRetrocederFactura"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
                                    class="bi bi-reply-fill azul" viewBox="0 0 16 16">
                                    <path
                                        d="M5.921 11.9 1.353 8.62a.719.719 0 0 1 0-1.238L5.921 4.1A.716.716 0 0 1 7 4.719V6c1.5 0 6 0 7 8-2.5-4.5-7-4-7-4v1.281c0 .56-.606.898-1.079.62z" />
                                </svg>
                            </button>
                        </a>
                    </div>
                </div>
            </div>


            <div class="d-flex justify-content-center">

                <div class="tamaño-tabla mt-5">
                    <?php foreach ($citaFacturar as $datoCita): ?>
                        <table class="table table-striped" id="tablaDB">
                            <thead>
                                <tr>
                                    <th class="fw-bolder mb-0 mt-2">SERVICIO
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tablaBODYDB">


                                <tr>
                                    <td class="border-top">
                                        <div class="fw-bolder">CI:</div>
                                        <?= $datoCita["nacionalidad"] . "-" . $datoCita["cedula_p"]; ?>
                                    </td>
                                    <td class="border-top">
                                        <div class="fw-bolder">PACIENTE:</div>
                                        <?= $datoCita["nombre_p"]; ?>
                                        <?= $datoCita["apellido_p"]; ?>
                                    </td>

                                    <td class="border-top">
                                        <div class="fw-bolder">DOCTOR:</div>
                                        <?= $datoCita["nombre_d"]; ?>
                                        <?= $datoCita["apellido_d"]; ?>
                                    </td>

                                    <td class="border-top">
                                        <div class="fw-bolder">S/M:</div>
                                        <?= $datoCita["especialidad"]; ?>
                                    </td>
                                    <td class="border-top">
                                        <div class="fw-bolder">FECHA:</div>
                                        <?= $datoCita["fecha"]; ?>
                                    </td>



                                </tr>


                            </tbody>

                        </table>
                        <table class="table table-striped" id="tablaSE">

                            <tbody id="tbody">

                            </tbody>
                        </table>
                        <table class="table table-striped" id="tablaIM">
                            <thead>
                                <tr>
                                    <th class="fw-bolder mb-0 mt-3 border-bottom">INSUMOS</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-insumos">

                            </tbody>
                        </table>
                        <!-- caja de los botones de vaciar , siguiente, total -->
                        <!-- recoradatorio acomodar esto del color -->
                        <div class="d-flex justify-content-between align-items-center mt-5">

                            <div class="d-flex" id="cajaVaciarTotalSiguiente">
                                <button class="btn btn-agregarConsulta ms-3 me-4 " id="vaciarTabla">VACIAR</button>
                                <button id="siguienteFact" class="btn btn-agregarConsulta " data-bs-toggle="modal"
                                    data-bs-target="#modal-pago">SIGUIENTE</button>
                            </div>

                            <div class=" " id="totalFac">
                                <label class="fw-bolder">TOTAL: </label>
                                <label>BS</label>
                                <?php foreach ($citaFacturar as $datoCita): ?>
                                    <input type="number" style="margin-left: -1px; padding-left: 6px;"
                                        class=" w-25 input-buscar text-center" id="totalFactura" disabled>
                                    <input type="hidden" id="inputTotalCita" value="<?= $datoCita['precio'] ?>">
                                <?php endforeach; ?>


                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>



<?php require_once 'modalAgregarFactura.php'; ?>


<?php require_once './src/vistas/head/footer.php'; ?>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/factura.js"></script>