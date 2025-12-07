<?php require_once './src/vistas/head/head.php';  ?>

<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">


    <h5 style="width: 95%; " class="m-auto mb-3">Reportes <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-clipboard-data-fill" viewBox="0 0 16 16">
            <path d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z"></path>
            <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1ZM10 8a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0V8Zm-6 4a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0v-1Zm4-3a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z"></path>
        </svg></h5>

    <!-- alertas -->

    <?php require_once "./src/vistas/alerts.php" ?>



    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto" style="width: 95%; ">
        <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">
        </div>
        <div class="d-flex justify-content-between flex-wrap w-100">
            <div class="card cardReporte reporte-citas tajeta-estadistica-m mb-5">
                <h3 class="card-header text-center fw-bold card-text-reporte">Citas</h3>
                <div class="card-body ">
                    <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#exampleModalBuscador">
                        <div class="card-body cartaRepor d-flex justify-content-center align-items-center  h-100 ">
                            <div class="ico icono-card-reporte  d-flex flex-column align-items-center w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                                    class="bi bi-calendar2-heart-fill mb-2" viewBox="0 0 16 16">
                                    <path
                                        d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5Zm-2 4v-1c0-.276.244-.5.545-.5h10.91c.3 0 .545.224.545.5v1c0 .276-.244.5-.546.5H2.545C2.245 5 2 4.776 2 4.5Zm6 3.493c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z" />
                                </svg>
                                <h5 class="card-text-reporte t text-center">Descargar Reporte de Citas</h5>
                            </div>

                        </div>
                    </a>
                </div>
            </div>

            <div class="card cardReporte reporte-pacientes tajeta-estadistica-m mb-5 contenido">
                <h3 class="card-header text-center fw-bold card-text-reporte">Pacientes</h3>
                <div class="card-body ">
                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Reportes/pacientePDF&pdf" class="text-decoration-none">
                        <div class="card-body cartaRepor d-flex justify-content-center align-items-center  h-100 ">
                            <div class="ico  d-flex flex-column align-items-center w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                                    class="icono-card-reporte bi bi-people-fill mb-2 t" viewBox="0 0 16 16">
                                    <path
                                        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                </svg>
                                <h5 class="card-text-reporte t text-center">Descargar Reporte de Pacientes</h5>
                            </div>

                        </div>
                    </a>
                </div>
            </div>

            <div class="card cardReporte reporte-entradas tajeta-estadistica-m mb-5 contenido">
                <h3 class="card-header text-center fw-bold card-text-reporte">Entradas</h3>
                <div class="card-body ">
                    <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#exampleModalBuscadorEntradas">
                        <div class="card-body cartaRepor d-flex justify-content-center align-items-center  h-100 ">
                            <div class="ico icono-card-reporte  d-flex flex-column align-items-center w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                                    class="bi bi-people-fill mb-2 t" viewBox="0 0 16 16">
                                    <path
                                        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                </svg>
                                <h5 class="card-text-reporte t text-center">Descargar Reporte de Entradas</h5>
                            </div>

                        </div>
                    </a>
                </div>
            </div>

            <div class="card cardReporteFactura reporte-insumos tajeta-estadistica-m mb-5 contenido">
                <h3 class="card-header text-center fw-bold card-text-reporte">Insumos</h3>
                <div class="card-body ">
                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Reportes/insumosPDF&pdf" class="text-decoration-none">
                        <div class="card-body cartaRepor d-flex justify-content-center align-items-center  h-100 ">
                            <div class="ico icono-card-reporte d-flex flex-column align-items-center w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                                    class="bi bi-capsule t" viewBox="0 0 16 16">
                                    <path
                                        d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                                </svg>
                                <h5 class="card-text-reporte t text-center">Descargar Reporte de Insumos</h5>
                            </div>

                        </div>
                    </a>
                </div>
            </div>

            <div class="card cardReporteFactura reporte-facturas tajeta-estadistica-m mb-5 contenido">
                <h3 class="card-header text-center fw-bold card-text-reporte">Factura</h3>
                <div class="card-body ">
                    <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#myModal">
                        <div class="card-body cartaRepor d-flex justify-content-center align-items-center  h-100 ">
                            <div class="ico  d-flex icono-card-reporte flex-column align-items-center w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-file-earmark-text-fill mb-2 t" viewBox="0 0 16 16">
                                    <path
                                        d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z" />
                                </svg>
                                <h5 class="card-text-reporte t text-center">Descargar Reporte de Factura</h5>
                            </div>

                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>







<!-- Modal Citas-->
<div class="modal fade modalBuscadorP" id="exampleModalBuscador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content contenido modalBuscador">
            <div>
                <a href="#" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default text-white " viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                    </svg>
                </a>
                <h5 class="fw-bolder mt-3 ms-3 text-uppercase text-white fecha_citas" id="exampleModalLabel">Seleccione el Rango de Fechas</h5>
            </div>

            <div class="modal-body ">
                <div id="alertaDeFecha" class="alert alert-danger text-center d-none"></div>


                <article class="uk-comment" role="comment" id="articulo">

                    <div class="uk-grid-medium uk-flex-middle" uk-grid>

                        <div class="uk-width-auto">

                            <!-- <img src="./src/assets/img/seguro-de-salud.png" width="80" height="80" uk-svg class="iconoB pb-1">  -->



                        </div>

                        <div class="d-flex justify-content-center">


                            <form action="/Sistema-del--CEM--JEHOVA-RAFA/Reportes/buscarPDF" method="POST" id="formularioCita">
                                <ul class="  uk-subnav-divider uk-margin-remove-top margin d-flex fechas_mover" id="ul">
                                    <li><a href="#" class="text-decoration-none fw-bolder text-uppercase text-white me-3" id="cedulab">DESDE<input class="input-expresion form-control  input-disabled input-paciente col-10" type="date" name="desdeFecha" id="desdeFecha"></a></li>
                                    <li class="li_mover"><a href="#" class="text-decoration-none fw-bolder text-uppercase text-white" id="telefonob">HASTA<input class="input-expresion form-control input-disabled input-paciente col-10" name="fechaHasta" id="fechaHasta" type="date"></a></li>
                                </ul>

                        </div>
                    </div>



                </article>
            </div>
            <div class="d-flex justify-content-end aling-items-center">
                <button class="uk-button col-4 uk-button-default uk-modal-close btn-cerrar-modal " data-bs-dismiss="modal" type="button">Cancelar</button>

                <button type="submit" class="btn me-3 " id="botonDeImprimir"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                        <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1" />
                        <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                    </svg></button>
                </form>
            </div>


        </div>
    </div>
</div>


<!-- Modal  de entradas-->
<div class="modal fade modalBuscadorP" id="exampleModalBuscadorEntradas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content modalBuscador">
            <div>
                <a href="#" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default text-white " viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                    </svg>
                </a>
                <h5 class="fw-bolder mt-3 ms-3 text-uppercase text-white fecha_entradas" id="exampleModalLabel">Seleccione El Insumo</h5>
            </div>

            <div class="modal-body ">
                <div id="alertaDeFechaEntradas" class="alert alert-danger text-center d-none"></div>


                <article class="uk-comment" role="comment" id="articulo">

                    <div class="uk-grid-medium uk-flex-middle" uk-grid>

                        <div class="uk-width-auto">

                            <!-- <img src="./src/assets/img/seguro-de-salud.png" width="80" height="80" uk-svg class="iconoB pb-1">  -->



                        </div>

                        <div class="d-flex justify-content-center">


                            <form action="/Sistema-del--CEM--JEHOVA-RAFA/Reportes/buscarEntradasInsumosPDF" method="POST" id="formularioEntradas">

                                <select id="selectInsumoEntradas" name="id_insumo" class="form-control w-100">
                                    <option selected disabled>Seleccione un Insumo</option>

                                    <?php foreach ($insumos as $i): ?>
                                        <option value="<?= $i['id_insumo'] ?>"><?= $i['nombre'] ?></option>
                                    <?php endforeach ?>
                                </select>


                                <!-- <h5 class="fw-bolder mt-3 ms-3 text-uppercase text-white fecha_entradas"><input type="checkbox" class="form-check-input m-3 card-title t" id="fechas_entradas" >BUSQUÉ POR FECHAS LAS ENTRADAS</h5> -->

                                <div id="cajaCheckboxEntrada" class="form-check mt-2 mb-2 d-none">
                                    <input class="form-check-input" type="checkbox" value="" id="checkboxEntradas">
                                    <label class="form-check-label fw-bolder ms-3 text-uppercase text-white fecha_entradas" for="flexCheckDefault">
                                        BUSQUÉ POR FECHAS LAS ENTRADAS
                                    </label>
                                </div>




                                <ul class="  uk-subnav-divider uk-margin-remove-top margin d-flex fechas_mover d-none " id="cajaModalEntradas">

                                    <li><a href="#" class="text-decoration-none fw-bolder text-uppercase text-white me-3">DESDE<input class="input-expresion form-control  input-disabled input-paciente col-10" type="date" name="desdeFechaEntradas" id="desdeFechaEntradas"></a></li>
                                    <li class="li_mover"><a href="#" class="text-decoration-none fw-bolder text-uppercase text-white">HASTA<input class="input-expresion form-control input-disabled input-paciente col-10" name="fechaHastaEntradas" id="fechaHastaEntradas" type="date"></a></li>
                                </ul>

                        </div>
                    </div>



                </article>
            </div>
            <div class="d-flex justify-content-end aling-items-center">
                <button class="uk-button col-4 uk-button-default uk-modal-close btn-cerrar-modal " data-bs-dismiss="modal" type="button">Cancelar</button>

                <button type="submit" class="btn me-3 d-none" id="botonDeImprimirEntradas"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                        <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1" />
                        <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                    </svg></button>
                </form>
            </div>


        </div>
    </div>
</div>



<!-- Modal Factura -->
<div class="modal fade modalCapa " id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-xxl-down fullscreen-modal">
        <div class="modal-content contenido" style="width: 100vw;">





            <div class="modal-header height_modal_factura">
                <div class="d-flex justify-content-center align-items-center">
                    <div>
                        <img class="rounded-circle d-flex justify-content-center " width="75" height="75" src="<?= $urlBase ?>../src/assets/img/logotipo.jpg">
                    </div>
                    <div>
                        <h3 class="modal-title fw-bold text-white ms-4" id="exampleModalLabel">REPORTES DE FACTURACIÓN <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-file-earmark-text-fill mb-1" viewBox="0 0 16 16">
                                <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z" />
                            </svg></h3>

                    </div>
                </div>
                <div>
                    <button type="button" class="btn btn-cerrar-modalFactura" data-bs-dismiss="modal" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-circle text-white" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                        </svg></button>
                </div>
            </div>
            <div class="modal-body">




                <!-- alerta -->
                <div class="alert alert-danger text-center d-none" id="alerta-fecha"></div>
                <div class="d-flex justify-content-between">

                    <div class="mover-input-buscar mt-4">
                        <form id="formularioDeFecha" class="d-flex" autocomplete="off" action="/Sistema-del--CEM--JEHOVA-RAFA/Reportes/reportesFactura" method="POST">

                            <input type="date" name="fechaInicio" id="fechaInicio" class="form-control input-buscar fecha-exp" style="width: 27%;" title="fecha de Inicio">

                            <input type="date" name="fechaFinal" id="fechaFinal" class="form-control input-buscar fecha-exp" style="width: 27%;" title="fecha de final">



                            <a href="#" class="btn btn-buscar " id="buscarFecha" title="Buscar Entradas Por Fecha">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </a>
                            <div>
                                <button class="btn btn-tabla ms-5 d-none" id="btnImprimir" type="submit">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                                        <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
                                        <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                                    </svg>
                                </button>
                            </div>
                        </form>


                    </div>



                    <div class="d-flex justify-content-end mb-4 col-6 mt-3 me-5" id="form-buscador" style="margin-left: -100px;">

                        <form id="form-buscadorEspecialidad"
                            class="d-flex justify-content-end mt-4 me-5 mb-3" autocomplete="off">
                            <input class="form-control input-busca" type="text" name="nombre" placeholder="Paciente"
                                id="inputBuscarEspecialidad">
                            <a href="#" class="btn boton-buscar" title="Buscar" id="especialidadBuscar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </a>
                        </form>
                    </div>

                </div>

                <div class="tamaño_tabla contenedor_tabla m-auto">

                    <table class="table table-striped">

                        <thead>
                            <tr>
                                <th class="text-center">Código Factura</th>
                                <th class=" text-center border-start">CI</th>
                                <th class=" text-center border-start">Paciente</th>
                                <th class=" text-center border-start">Fecha</th>
                                <th class=" text-center border-start">Monto</th>
                                <th class=" text-center border-start">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="tbody" id="tbodyReporte">
                            <?php foreach ($facturas as $factura): ?>

                                <tr>
                                    <td class="text-center"><?php echo $factura["id_factura"] ?></td>
                                    <td class=" text-center border-start"><?php echo $factura["nacionalidad"] . "-" . $factura["cedula_p"] ?></td>
                                    <td class=" text-center border-start"><?php echo $factura["nombre_p"] . " " . $factura["apellido_p"]  ?></td>
                                    <td class=" text-center border-start"><?php echo $factura["fecha"] ?></td>
                                    <td class=" text-center border-start"><?php echo $factura["total"] . " BS" ?></td>
                                    <td class=" text-center border-start">

                                        <!-- boton informacion -->

                                        <button class="btn btn-tabla mb-1 infoFactura" uk-toggle="target: #modal-example<?= $factura["id_factura"] ?>" name="<?= $factura["id_factura"] ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                            </svg>
                                        </button>



                                        <!-- Modal Mostrar Info  -->












                                    </td>
                                </tr>











                                <div id="modal-example<?= $factura["id_factura"] ?>" uk-modal class="modalCapa modalInterno">
                                    <div class="uk-modal-dialog uk-modal-body contenido" style="border-radius: 20px; background-color: var(--color-surface);">
                                        <!-- Boton que cierra el modal -->
                                        <a href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                                class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                <path
                                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                            </svg>
                                        </a>

                                        <div class="pb-3">
                                            <div class="uk-card   m-auto contenido" style="width:100%;background-color: var(--color-surface);">
                                                <div class="uk-card-header">
                                                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                                                        <div class=" m-auto d-flex justify-content-center" style="width: 40%;">
                                                            <img src="<?= $urlBase ?>../src/assets/icons/logo2.png">
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="uk-card-body ">
                                                    <div class="">

                                                        <div class="div-total p-2 mb-2">
                                                            <h5 class="text-center"> <?php echo $factura['total'] . " BS" ?></h5>
                                                        </div>

                                                        <div class="d-flex justify-content-between">
                                                            <h5 class="h5-comprobante ">Codigo:</h5>
                                                            <h5 class="h5-comprobante ">
                                                                <?php echo $factura['id_factura'] ?>
                                                            </h5>

                                                        </div>

                                                        <div class="d-flex justify-content-between  ">
                                                            <h5 class="h5-comprobante ">Fecha:</h5>
                                                            <h5 class="h5-comprobante ">
                                                                <?php echo $factura['fecha'] ?>
                                                            </h5>

                                                        </div>
                                                        <div class="d-flex justify-content-between  ">
                                                            <h5 class="h5-comprobante ">Cedula Paciente:</h5>
                                                            <h5 class="h5-comprobante ">
                                                                <?php echo $factura['nacionalidad'] . "-" . $factura['cedula_p'] ?>
                                                            </h5>

                                                        </div>
                                                        <div class="d-flex justify-content-between  ">
                                                            <h5 class="h5-comprobante ">Paciente:</h5>
                                                            <h5 class="h5-comprobante ">
                                                                <?php echo $factura['nombre_p'] . " " . $factura['apellido_p'] ?>
                                                            </h5>

                                                        </div>


                                                    </div>

                                                    <!-- servicios -->
                                                    <hr>
                                                    <h5 class="text-center">Servicios</h5>



                                                    <div class="d-flex justify-content-between masSer ">

                                                    </div>

                                                    <!--  insumos -->

                                                    <hr>
                                                    <h5 class="text-center">Insumos</h5>


                                                    <div class="insumos">

                                                    </div>

                                                    <hr>

                                                    <h5 class="text-center">Métodos de pago</h5>

                                                    <div class="d-flex justify-content-between  pagoDefac" id="pagoDefac">

                                                    </div>



                                                </div>




                                            </div>

                                            <div class="d-flex justify-content-end">
                                                <div class="uk-card-footer">
                                                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Reportes/factura/<?= $factura["id_factura"] ?>"
                                                        class="btn btn-tabla pdf2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
                                                            class="bi bi-printer-fill" viewBox="0 0 16 16">
                                                            <path
                                                                d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
                                                            <path
                                                                d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                                                        </svg>
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3 uk-text-right">
                                            <button class="uk-button col-6 me-2 uk-button-default uk-modal-close btn-cerrar-modal"
                                                type="button">Cerrar</button>
                                            <button class="btn col-5 btn-agregarcita-modal" type="sumit" name="guardar" uk-toggle="target:#eliminar<?= $factura["id_factura"] ?>">Anular</button>
                                        </div>
                                    </div>


                                </div>
                </div>


                <div id="eliminar<?= $factura["id_factura"] ?>" uk-modal class="madalAnular">
                    <div class="uk-modal-dialog uk-modal-body tamaño-modal contenido">
                        <!-- Boton que cierra el modal -->
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                            </svg>
                        </a>

                        <div class="d-flex align-items-center">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill azul me-2 mb-2" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                </svg>
                            </div>
                            <div>
                                <h5>
                                    ¿Está seguro de Anular la Factura?
                                </h5>
                            </div>
                        </div>

                        <div class="mt-3 uk-text-right">
                            <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>


                            <form action="/Sistema-del--CEM--JEHOVA-RAFA/Reportes/anularFactura" method="POST">
                                <input type="hidden" value="<?= $factura["id_factura"] ?>" name="id_factura">
                                <input type="hidden" value="<?= $_SESSION['id_usuario'] ?>" name="id_usuario_bitacora">

                                <button class="btn col-4 btn-agregarcita-modal " type="submit">Si</button>
                            </form>

                        </div>

                    </div>
                </div>




















            <?php endforeach ?>

            </tbody>
            </table>

            <table class="table table-striped d-none" style="margin-top: -16px;" id="noresultados">
                <thead>

                </thead>
                <tbody>
                    <tr class="">
                        <td colspan="9" class="text-center">NO HAY REGISTROS

                        </td>
                    </tr>
                </tbody>

            </table>
            </div>
        </div>


        <div class="modal-footer d-flex justify-content-between">
            <div class="">
                <a href="#" uk-tooltip="Ayuda">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                        class="bi bi-question-octagon-fill azul ms-4" viewBox="0 0 16 16" id="btnayudaEspecialidades">
                        <path
                            d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                    </svg>
                </a>
            </div>
            <div class="me-4">
                <button type="button" class="btn uk-button-default uk-modal-close btn-cerrar-modal" data-bs-dismiss="modal">CERRAR</button>
                <button type="button" class="btn btn-agregarcita-modal" data-bs-toggle="modal" data-bs-target="#myModalAnular">Facturas Anuladas</button>
            </div>
        </div>
    </div>
</div>
</div>

<!-- facturas Anuladas -->

<div class="modal fade modalCapa " id="myModalAnular" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-xxl-down fullscreen-modal">
        <div class="modal-content contenido" style="width: 100vw;">
            <div class="modal-header height_modal_factura">
                <div class="d-flex justify-content-center align-items-center">
                    <div>
                        <img class="rounded-circle d-flex justify-content-center " width="75" height="75" src="<?= $urlBase ?>../src/assets/img/logotipo.jpg">
                    </div>
                    <div>
                        <h3 class="modal-title fw-bold text-white ms-4" id="exampleModalLabel">FACTURAS ANULADAS <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-file-earmark-text-fill mb-1" viewBox="0 0 16 16">
                                <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z" />
                            </svg></h3>

                    </div>
                </div>
                <div>
                    <button type="button" class="btn btn-cerrar-modalFactura" data-bs-toggle="modal" data-bs-target="#myModal" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-circle text-white" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                        </svg></button>
                </div>
            </div>
            <div class="modal-body ">

                <div class="contenido">
                    <div class="d-flex justify-content-between">

                        <div class="mover-input-buscar mt-4">
                            <form id="formularioDeFechaAnulada" class="d-flex" autocomplete="off" action="/Sistema-del--CEM--JEHOVA-RAFA/Reportes/reportesFacturasAnuladas" method="POST">

                                <input type="date" name="fechaInicioAnulada" id="fechaInicioAnulada" class="form-control input-buscar fecha-exp" style="width: 27%;" title="fecha de Inicio">

                                <input type="date" name="fechaFinalAnulada" id="fechaFinalAnulada" class="form-control input-buscar fecha-exp" style="width: 27%;" title="fecha de final">



                                <a href="#" class="btn btn-buscar " id="buscarFechaAnulada" title="Buscar Entradas Por Fecha">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                    </svg>
                                </a>
                                <div>
                                    <button class="btn btn-tabla ms-5 d-none" id="btnImprimirAnulada" type="submit">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                                            <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
                                            <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                                        </svg>
                                    </button>
                                </div>
                            </form>


                        </div>





                        <div class="d-flex justify-content-end mb-4 col-6 mt-3 me-5" id="form-buscador">

                            <form id="form-buscadorEspecialidad"
                                class="d-flex justify-content-end mt-4 me-5 mb-3" autocomplete="off">
                                <input class="form-control input-busca" type="text" name="nombre" placeholder="Paciente" id="buscarFacturasAnuladas">
                                <a href="#" class="btn boton-buscar" title="Buscar" id="especialidadBuscar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                    </svg>
                                </a>
                            </form>
                        </div>
                    </div>

                    <div class="tamaño_tabla contenedor_tabla m-auto">

                        <table class="table table-striped">

                            <thead>
                                <tr>
                                    <th class="text-center">Código Factura</th>
                                    <th class=" text-center border-start">CI</th>
                                    <th class=" text-center border-start">Paciente</th>
                                    <th class=" text-center border-start">Fecha</th>
                                    <th class=" text-center border-start">Monto</th>
                                    <th class=" text-center border-start">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="tbodyAnuladas" id="tbodyAnuladas">
                                <?php foreach ($anuladas as $factura): ?>

                                    <tr>
                                        <td class="text-center"><?php echo $factura["id_factura"] ?></td>
                                        <td class=" text-center border-start"><?php echo $factura["nacionalidad"] . "-" . $factura["cedula_p"] ?></td>
                                        <td class=" text-center border-start"><?php echo $factura["nombre_p"] . " " . $factura["apellido_p"]  ?></td>
                                        <td class=" text-center border-start"><?php echo $factura["fecha"] ?></td>
                                        <td class=" text-center border-start"><?php echo $factura["total"] . " BS" ?></td>
                                        <td class=" text-center border-start">

                                            <!-- boton informacion -->

                                            <button class="btn btn-tabla mb-1 infoFactura" uk-toggle="target: #modal-example<?= $factura["id_factura"] ?>" name="<?= $factura["id_factura"] ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                                </svg>
                                            </button>



                                            <!-- Modal Mostrar Info  -->












                                        </td>
                                    </tr>











                                    <div id="modal-example<?= $factura["id_factura"] ?>" uk-modal class="modalCapa modalInterno">

                                        <div class="uk-modal-dialog uk-modal-body contenido" style="border-radius: 20px; background-color: var(--color-surface);">
                                            <!-- Boton que cierra el modal -->
                                            <a href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                                    class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                    <path
                                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                                </svg>
                                            </a>

                                            <div class="pb-3">
                                                <div class="uk-card   m-auto contenido" style="width:100%;background-color: var(--color-surface);">
                                                    <div class="uk-card-header">
                                                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                                                            <div class=" m-auto d-flex justify-content-center" style="width: 40%;">
                                                                <img src="<?= $urlBase ?>../src/assets/icons/logo2.png">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="uk-card-body ">
                                                        <div class="">

                                                            <div class="div-total p-2 mb-2">
                                                                <h5 class="text-center"> <?php echo $factura['total'] . " BS" ?></h5>
                                                            </div>

                                                            <div class="d-flex justify-content-between">
                                                                <h5 class="h5-comprobante ">Codigo:</h5>
                                                                <h5 class="h5-comprobante ">
                                                                    <?php echo $factura['id_factura'] ?>
                                                                </h5>

                                                            </div>

                                                            <div class="d-flex justify-content-between  ">
                                                                <h5 class="h5-comprobante ">Fecha:</h5>
                                                                <h5 class="h5-comprobante ">
                                                                    <?php echo $factura['fecha'] ?>
                                                                </h5>

                                                            </div>
                                                            <div class="d-flex justify-content-between  ">
                                                                <h5 class="h5-comprobante ">Cedula Paciente:</h5>
                                                                <h5 class="h5-comprobante ">
                                                                    <?php echo $factura['nacionalidad'] . "-" . $factura['cedula_p'] ?>
                                                                </h5>

                                                            </div>
                                                            <div class="d-flex justify-content-between  ">
                                                                <h5 class="h5-comprobante ">Paciente:</h5>
                                                                <h5 class="h5-comprobante ">
                                                                    <?php echo $factura['nombre_p'] . " " . $factura['apellido_p'] ?>
                                                                </h5>

                                                            </div>


                                                        </div>

                                                        <!-- servicios -->
                                                        <hr>
                                                        <h5 class="text-center">Servicios</h5>



                                                        <div class="d-flex justify-content-between masSer ">

                                                        </div>

                                                        <!--  insumos -->

                                                        <hr>
                                                        <h5 class="text-center">Insumos</h5>


                                                        <div class="insumos">

                                                        </div>

                                                        <hr>

                                                        <h5 class="text-center">Métodos de pago</h5>

                                                        <div class="d-flex justify-content-between  pagoDefac" id="pagoDefac">

                                                        </div>



                                                    </div>




                                                </div>

                                                <div class="d-flex justify-content-end">
                                                    <div class="uk-card-footer">
                                                        <a href="/Sistema-del--CEM--JEHOVA-RAFA/Reportes/factura/<?= $factura["id_factura"] ?>"
                                                            class="btn btn-tabla pdf2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
                                                                class="bi bi-printer-fill" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
                                                                <path
                                                                    d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                                                            </svg>
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3 uk-text-right">
                                                <button class="uk-button col-6 me-2 uk-button-default uk-modal-close btn-cerrar-modal"
                                                    type="button">Cerrar</button>
                                            </div>
                                        </div>

                                    </div>


                    </div>
                </div>


                <div id="eliminar<?= $factura["id_factura"] ?>" uk-modal class="madalAnular">
                    <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                        <!-- Boton que cierra el modal -->
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                            </svg>
                        </a>

                        <div class="d-flex align-items-center">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill azul me-2 mb-2" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                </svg>
                            </div>
                            <div>
                                <h5>
                                    ¿Está seguro de Anular la Factura?
                                </h5>
                            </div>
                        </div>

                        <div class="mt-3 uk-text-right d-flex">
                            <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>

                            <a href="#">
                                <button class="btn col-4 btn-agregarcita-modal anularfactura uk-modal-close " type="button" name="<?= $factura["id_factura"] ?>">Si</button>
                            </a>
                        </div>

                    </div>
                </div>




















            <?php endforeach ?>

            </tbody>
            </table>
            <table class="table table-striped d-none" style="margin-top: -16px;" id="noresultadosAnuladas">
                <thead>

                </thead>
                <tbody>
                    <tr class="">
                        <td colspan="9" class="text-center">NO HAY REGISTROS

                        </td>
                    </tr>
                </tbody>

            </table>
            </div>
        </div>
    </div>

    <div class="modal-footer d-flex justify-content-between">
        <div class="">
            <a href="#" uk-tooltip="Ayuda">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                    class="bi bi-question-octagon-fill azul ms-4" viewBox="0 0 16 16" id="btnayudaEspecialidades">
                    <path
                        d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                </svg>
            </a>
        </div>
        <div class="me-4">
            <button type="button" class="btn uk-button-default uk-modal-close btn-cerrar-modal" data-bs-toggle="modal" data-bs-target="#myModal">VOLVER</button>

        </div>
    </div>
</div>
</div>


</div>


<script src="<?= $urlBase ?>../src/assets/js/reporteCitaYEntradasDeInsumos.js"></script>
<script src="<?= $urlBase ?>../src/assets/js/reportes.js"></script>

<?php require_once './src/vistas/head/footer.php'; ?>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/ayudaReportes.js"></script>