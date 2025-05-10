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

    <div class="d-flex justify-content-between flex-wrap w-100">
        <div class="card tajeta-estadistica-m mb-5">
            <h5 class="card-header">TITULO 1</h5>
            <div class="card-body">
                <canvas>

                </canvas>
            </div>
        </div>
        <div class="card tajeta-estadistica-m mb-5 contenido">
            <h5 class="card-header">TITULO 2</h5>
            <div class="card-body">
                <canvas>

                </canvas>
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



<?php require_once './src/vistas/head/footer.php'; ?>