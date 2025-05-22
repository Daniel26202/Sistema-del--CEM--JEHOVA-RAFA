<?php require_once './src/vistas/head/head.php'; ?>
<link rel="stylesheet" type="text/css" href="<?= $concatenarRuta ?>../src/assets/cssVista/estadisticas.css">

<div class="container-fluid px-4">



    <div class="p-0 m-0 pb-3 d-flex justify-content-between">
        <h1 class="mt-4 mb-0">Estadisticas <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-bar-chart-fill" viewBox="0 0 16 16">
                <path d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V2z" />
            </svg></thead>
        </h1>

        <?php require_once './src/vistas/tasaBCV.php'; ?>



        <div class=" d-flex align-items-end">
            <!-- requerir los botones -->
            <?php require_once './src/vistas/btnOpciones.php'; ?>
        </div>
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
        <div class="card tajeta-estadistica-g m-auto mb-5">
            <h5 class="card-header">TITULO 3</h5>
            <div class="card-body">
                <canvas class="canvas">

                </canvas>
            </div>
        </div>
        <div class="card tajeta-estadistica-m mb-5">
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
        <div class="card tajeta-estadistica-m mb-5">
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

<?php require_once './src/vistas/vistaEstadisticas/modalsEstadisticas.php'; ?>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/jspdf.umd.min.js"></script>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/html2canvas.min.js"></script>


<!-- <script type=" text/javascript" src="../src/assets/DataTable/jquery-3.7.1.js"></script>

<script type="text/javascript" src="../src/assets/DataTable/datatables.js"></script> -->
<script type="text/javascript" src="../src/assets/js/estadisticas.js"></script>


<?php require_once './src/vistas/head/footer.php'; ?>