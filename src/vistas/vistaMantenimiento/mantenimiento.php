<?php require_once './src/vistas/head/head.php'; ?>

<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">




    <div class="container mt-5 col-md-9">

        <div class="row mb-4 mt-2">
            <div class="col text-center">
                <h1>Mantenimiento del sistema</h1>
                <p>Realiza operaciones básicas como descarga de respaldo y restauración.</p>
            </div>
        </div>

        <div class="row ">
            <div class="col-md-6 mb-3">
                <div class="card p-2 h-100">
                    <div class="fw-bold ms-3 mt-3 me-3 fs-4">
                        Descargar Respaldo
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-between h-100">
                            <p class="card-text">Haz clic para generar y descargar una copia de seguridad de tu base de datos.</p>
                            <a href="/Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/generarRespaldo" class="btn btn-primary btn-block w-100 text-white text-decoration-none">Descargar Respaldo</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3 ">
                <div class="card p-2 h-100">
                    <div class="fw-bold ms-3 mt-3 me-3 fs-4">
                        Restaurar Base de Datos
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-between h-100">
                            <p class="card-text">Selecciona un respaldo previamente descargado para restaurar la base de datos.</p>
                            <a href="#" class="btn btn-secondary btn-block w-100 text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalBaseDatos">Restaurar Base</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <div class="alert alert-info " role="alert">
                    Esta acción puede afectar la integridad de los datos. Si no estás seguro, contacta al administrador antes de continuar.
                </div>
            </div>
        </div>

    </div>



</div>

<div class="modal fade" id="modalBaseDatos" tabindex="-1" aria-labelledby="modalBaseDatosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="d-flex justify-content-between align-items-center ps-4 pe-4 ms-1 me-1 pt-4 ">
                <h4 class="fw-bold" id="modalBaseDatosLabel">Seleccionar Base de Datos</h4>
                <a href="#" class="" data-bs-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-x-circle color-icono" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"></path>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"></path>
                    </svg>
                </a>
            </div>
                <div class="modal-body ms-3 mt-3 me-3">
                    <!-- campo de búsqueda -->
                    <div class="mb-3">
                        <input type="text" class="form-control" id="buscarBD" placeholder="Buscar por nombre o fecha">
                    </div>

                    <!-- tabla de bases de datos -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre y Fecha</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="datosTable">
                                <?php foreach ($respaldos as $db) : ?>
                                    <tr>
                                        <td><?= basename($db) ?></td>
                                        <td>
                                            <a href="/Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/restaurarRespaldo/<?= basename($db) ?>" class="p-2 uk-button-primary rounded-5 fw-bold text-decoration-none text-white" type="button" id="btnEnviar">Seleccionar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <!-- Agrega más filas según requieras -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-end align-items-center ps-4 pe-4 ms-1 me-1 pt-3 pb-4">
                    <button class="uk-button rounded-5 btn-cancelar fw-bold " type="button" data-bs-dismiss="modal">Cancelar</button>
                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/restaurarRespaldo"><button class="uk-button uk-button-primary rounded-5 fw-bold ms-4" type="submit" id="btnEnviar">Restaurar el más resiente</button></a>
                </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('buscarBD').addEventListener('input', function() {
        const textMayuscl = this.value.toUpperCase();
        const trs = document.querySelectorAll('#datosTable tr');

        trs.forEach(tr => {
            // nombre de la celda
            const valor = tr.cells[0].textContent.toUpperCase();
            tr.style.display = valor.includes(textMayuscl) ? "" : "none";
        });
    });
</script>


<?php require_once './src/vistas/head/footer.php'; ?>