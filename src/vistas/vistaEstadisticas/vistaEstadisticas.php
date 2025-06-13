<?php require_once './src/vistas/head/head.php'; ?>
<link rel="stylesheet" type="text/css" href="<?= $urlBase ?>../src/assets/cssVista/estadisticas.css">

<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo">


    <h5 style="width: 95%; " class="m-auto mb-3">Reportes <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-clipboard-data-fill" viewBox="0 0 16 16">
            <path d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z"></path>
            <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1ZM10 8a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0V8Zm-6 4a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0v-1Zm4-3a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z"></path>
        </svg></h5>



    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto" style="width: 95%; ">
        <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">
        </div>


        <div class="d-flex justify-content-between flex-wrap w-100">
            <div class=" card tajeta-estadistica-m mb-5">
                <h5 class="card-header">Distribución de pacientes</h5>
                <div class="card-body">
                    <canvas id="edadgenero" class="canvas">

                    </canvas>
                    <div class="text-center mt-4 pb-2">
                        <button type="button" class="btn btn-primary 75 m-auto  reporte-sintomas" data-bs-toggle="modal" data-bs-target="#reporteDistribucionPacientes">
                            Generar Reporte
                        </button>
                    </div>
                </div>
            </div>

            <div class="card tajeta-estadistica-m mb-5 contenido">
                <h5 class="card-header">Tasa de morbilidad</h5>
                <div class="card-body">
                    <canvas id="tasa_morbilidad" class="canvas">

                    </canvas>


                    <div class="text-center mt-4 pb-2">
                        <button type="button" class="btn btn-primary 75 m-auto  reporte-sintomas" data-bs-toggle="modal" data-bs-target="#reporteTasaMorbilidad">
                            Generar Reporte
                        </button>
                    </div>
                </div>
            </div>
            <div class="card tajeta-estadistica-g m-auto col-12 col-md-12 col-lg-8 mb-4">
                <h5 class="card-header">Moda Insumos</h5>
                <div class="card-body ">
                    <canvas id="insumos" class="canvas" style="object-fit: contain !important;"></canvas>
                    <div class="text-center mt-4 pb-2">
                        <button type="button" class="btn btn-primary 75 m-auto" data-bs-toggle="modal" data-bs-target="#reporteInsumos">
                            Generar Reporte
                        </button>
                    </div>
                </div>
            </div>
            <div class="card tarjetaa-pastel mb-5">
                <h5 class="card-header">Especialidades mas solicitadas
                </h5>
                <div class="card-body">
                    <canvas id="especialidades_solicitadas" class="canvas canvas-pastel">

                    </canvas>
                    <div class="text-center mt-4 pb-2">
                        <button type="button" class="btn btn-primary 75 m-auto" data-bs-toggle="modal" data-bs-target="#reporte">
                            Generar Reporte
                        </button>
                    </div>
                </div>
            </div>
            <div class="card tarjetaa-pastel mb-5">
                <h5 class="card-header">Sintomas mas comunes</h5>
                <div class="card-body">
                    <canvas id="sintomas_comunes" class="canvas canvas-pastel">

                    </canvas>
                    <div class="text-center mt-4 ">
                        <button type="button" class="btn btn-primary 75 m-auto  reporte-sintomas" data-bs-toggle="modal" data-bs-target="#reporteSintomas">
                            Generar Reporte
                        </button>
                    </div>
                </div>
            </div>
        </div>



    </div>

</div>



<?php require_once './src/vistas/vistaEstadisticas/modalsEstadisticas.php'; ?>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/jspdf.umd.min.js"></script>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/html2canvas.min.js"></script>


<!-- <script type=" text/javascript" src="../src/assets/DataTable/jquery-3.7.1.js"></script>

<script type="text/javascript" src="../src/assets/DataTable/datatables.js"></script> -->
<script type="text/javascript" src="../src/assets/js/estadisticas.js"></script>


<?php require_once './src/vistas/head/footer.php'; ?>