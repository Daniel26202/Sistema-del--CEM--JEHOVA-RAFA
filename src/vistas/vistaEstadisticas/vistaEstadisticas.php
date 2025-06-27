<?php require_once './src/vistas/head/head.php'; ?>
<link rel="stylesheet" type="text/css" href="<?= $urlBase ?>../src/assets/cssVista/estadisticas.css">

<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo">


    <h5 style="width: 95%; " class="m-auto mb-3">Reportes Estadisticos <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-bar-chart-fill" viewBox="0 0 16 16">
            <path d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V2z"></path>
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

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/estadisticas.js"></script>


<?php require_once './src/vistas/head/footer.php'; ?>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/ayudaEstadistica.js"></script>