<?php require_once './src/vistas/head/head.php'; ?>

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

    <div class="d-flex justify-content-between flex-wrap w-100" ">
        <div class=" card tajeta-estadistica-m mb-5">
        <h5 class="card-header">Distribución de pacientes</h5>
        <div class="card-body">
            <canvas id="edadgenero"></canvas>
        </div>
    </div>
    <div class="card tajeta-estadistica-m mb-5 contenido">
        <h5 class="card-header">Tasa de morbilidad</h5>
        <div class="card-body">
            <canvas id="tasa_morbilidad"></canvas>

            <div class="mt-4 w-100 mb-4 text-center">
                <div class="alert alert-danger text-center d-none alertaFechaInicio">Por favor la fecha de Inicio tiene que ser Menor a la fech final</div>
                <div class="d-flex">

                    <input type="date" name="fechaInicio" id="fechaInicio" class="form-control input-buscar fecha-exp" style="width: 40%;" title="fecha de Inicio">

                    <input type="date" name="fechaFinal" id="fechaFinal" class="form-control input-buscar fecha-exp" style="width: 40%;" title="fecha de final">



                    <a href="#" class="btn btn-buscar " id="buscarFecha" title="Buscar Entradas Por Fecha">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </a>
                    <div>
                        <button class="btn btn-tabla ms-5 d-none" id="btnImprimir">

                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                                <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
                                <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                            </svg>
                        </button>
                    </div>
                </div>


            </div>


        </div>
    </div>
    <div class="card tajeta-estadistica-g m-auto mb-5">
        <h5 class="card-header">TITULO 3</h5>
        <div class="card-body">
            <canvas>

            </canvas>
        </div>
    </div>
    <div class="card tajeta-estadistica-m mb-5">
        <h5 class="card-header">TITULO 4</h5>
        <div class="card-body">
            <canvas>

            </canvas>
        </div>
    </div>
    <div class="card tajeta-estadistica-m mb-5">
        <h5 class="card-header">TITULO 5</h5>
        <div class="card-body">
            <canvas>

            </canvas>
        </div>
    </div>
</div>



</div>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/jspdf.umd.min.js"></script>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/html2canvas.min.js"></script>


<script type=" text/javascript" src="<?= $urlBase ?>../src/assets/DataTable/jquery-3.7.1.js"></script>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/DataTable/datatables.js"></script>
<script type="text/javascript" src="../src/assets/js/estadisticas.js"></script>


<?php require_once './src/vistas/head/footer.php'; ?>