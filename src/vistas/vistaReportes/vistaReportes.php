<?php require_once './src/vistas/head/head.php';  ?>
<link rel="stylesheet" type="text/css" href="<?= $urlBase ?>../src/assets/cssVista/estadisticas.css">


<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">


    <h5 style="width: 95%; " class="m-auto mb-3">Reportes <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-clipboard-data-fill" viewBox="0 0 16 16">
            <path d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z"></path>
            <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1ZM10 8a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0V8Zm-6 4a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0v-1Zm4-3a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z"></path>
        </svg></h5>
    <input type="hidden" name="id_usuario" id="id_usuario_session" value="<?= $_SESSION['id_usuario'] ?>">





    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto" style="width: 95%; ">
        <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">
        </div>
        <div class="d-flex justify-content-between flex-wrap w-100">
            <div class="card cardReporte reporte-citas tajeta-estadistica-m mb-5">
                <h3 class="card-header  ">Citas</h3>
                <div class="card-body ">
                    <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#exampleModalBuscador">
                        <div class="card-body cartaRepor d-flex justify-content-center align-items-center  h-100 ">
                            <div class="ico icono-card-reporte  d-flex flex-column align-items-center w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                                    class="bi bi-calendar2-heart-fill mb-2 icon-reporte" viewBox="0 0 16 16">
                                    <path
                                        d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5Zm-2 4v-1c0-.276.244-.5.545-.5h10.91c.3 0 .545.224.545.5v1c0 .276-.244.5-.546.5H2.545C2.245 5 2 4.776 2 4.5Zm6 3.493c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z" />
                                </svg>
                                <h5 class="statistic">Descargar Reporte de Citas</h5>
                            </div>

                        </div>
                    </a>
                </div>
            </div>

            <div class="card cardReporte reporte-pacientes tajeta-estadistica-m mb-5 contenido">
                <h3 class="card-header ">Pacientes</h3>
                <div class="card-body ">
                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Reportes/pacientePDF&pdf" class="text-decoration-none">
                        <div class="card-body cartaRepor d-flex justify-content-center align-items-center  h-100 ">
                            <div class="ico  d-flex flex-column align-items-center w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                                    class="icono-card-reporte bi bi-people-fill mb-2 t icon-reporte" viewBox="0 0 16 16">
                                    <path
                                        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                </svg>
                                <h5 class="statistic">Descargar Reporte de Pacientes</h5>
                            </div>

                        </div>
                    </a>
                </div>
            </div>

            <div class="card cardReporte reporte-entradas tajeta-estadistica-m mb-5 contenido">
                <h3 class="card-header">Entradas</h3>
                <div class="card-body ">
                    <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#exampleModalBuscadorEntradas">
                        <div class="card-body cartaRepor d-flex justify-content-center align-items-center  h-100 ">
                            <div class="ico icono-card-reporte  d-flex flex-column align-items-center w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                                    class="bi bi-people-fill mb-2 t icon-reporte" viewBox="0 0 16 16">
                                    <path
                                        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                </svg>
                                <h5 class="statistic">Descargar Reporte de Entradas</h5>
                            </div>

                        </div>
                    </a>
                </div>
            </div>

            <div class="card cardReporte reporte-insumos tajeta-estadistica-m mb-5 contenido">
                <h3 class="card-header ">Insumos</h3>
                <div class="card-body ">
                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Reportes/insumosPDF&pdf" class="text-decoration-none">
                        <div class="card-body cartaRepor d-flex justify-content-center align-items-center  h-100 ">
                            <div class="ico icono-card-reporte d-flex flex-column align-items-center w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                                    class="bi bi-capsule t icon-reporte" viewBox="0 0 16 16">
                                    <path
                                        d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                                </svg>
                                <h5 class="statistic">Descargar Reporte de Insumos</h5>
                            </div>

                        </div>
                    </a>
                </div>
            </div>

            <div class="card cardReporteFactura reporte-facturas tajeta-estadistica-m mb-5 contenido">
                <h3 class="card-header ">Factura</h3>
                <div class="card-body ">
                    <a href="#" id="cardFactura" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#reporteFactura">
                        <div class="card-body cartaRepor d-flex justify-content-center align-items-center  h-100 ">
                            <div class="ico  d-flex icono-card-reporte flex-column align-items-center w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-file-earmark-text-fill mb-2 t icon-reporte" viewBox="0 0 16 16">
                                    <path
                                        d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z" />
                                </svg>
                                <h5 class="statistic">Descargar Reporte de Factura</h5>
                            </div>

                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>







</div>

<?php require_once 'modalsReportes.php'; ?>

<!-- <script src="<?= $urlBase ?>../src/assets/js/reporteCitaYEntradasDeInsumos.js"></script> -->
<script type="module" src="<?= $urlBase ?>../src/assets/js/reportes.js"></script>

<?php require_once './src/vistas/head/footer.php'; ?>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/ayudaReportes.js"></script>