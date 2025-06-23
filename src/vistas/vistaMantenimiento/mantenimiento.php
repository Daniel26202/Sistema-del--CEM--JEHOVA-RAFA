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
                            <a href="/Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/restaurarRespaldo" class="btn btn-secondary btn-block w-100 text-decoration-none">Restaurar Base</a>
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
            <div class="modal-header">
                <h5 class="modal-title" id="modalBaseDatosLabel">Seleccionar Base de Datos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <!-- Campo de búsqueda -->
                <div class="mb-3">
                    <input type="text" class="form-control" id="searchInput" placeholder="Buscar por nombre o fecha">
                </div>

                <!-- Tabla de bases de datos -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Fecha</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="datosTable">
                            <!-- Ejemplo de datos. Puedes generar estas filas dinámicamente con JavaScript -->
                            <tr>
                                <td>Base de Datos 1</td>
                                <td>2025-06-01</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm">Seleccionar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Base de Datos 2</td>
                                <td>2025-06-15</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm">Seleccionar</button>
                                </td>
                            </tr>
                            <!-- Agrega más filas según requieras -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Incluye el JS Bundle de Bootstrap (que ya trae Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script para filtrar la tabla -->
<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        const filter = this.value.toUpperCase();
        const rows = document.querySelectorAll('#datosTable tr');

        rows.forEach(row => {
            // Concatenamos el contenido de las celdas de nombre y fecha para una búsqueda sencilla
            const value = row.cells[0].textContent.toUpperCase() + " " + row.cells[1].textContent.toUpperCase();
            row.style.display = value.includes(filter) ? "" : "none";
        });
    });
</script>









<script type="text/javascript"
    src="<?= $urlBase ?>../src/assets/js/hospitalizacion/validacioneshospitalizacion.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/hospitalizacion/hospitalizacionAgregar.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/hospitalizacion/hospitalizacionEditar.js"></script>


<?php require_once './src/vistas/head/footer.php'; ?>
<?php require_once './src/vistas/vistaPacientes/modalAgregarPaciente.php'; ?>
<?php require_once './src/vistas/vistaHospitalizacion/modal/modalAgregarPacientes.php'; ?>
<?php require_once './src/vistas/vistaHospitalizacion/modal/modalEditarHospitalizacion.php'; ?>
<?php require_once './src/vistas/vistaHospitalizacion/modal/modalEliminarHospitalizacion.php'; ?>

<?php require_once './src/vistas/vistaHospitalizacion/modal/modalEditarInsumos.php'; ?>
<?php require_once './src/vistas/vistaHospitalizacion/modal/modalAgregarInsumos.php'; ?>
<?php require_once './src/vistas/vistaHospitalizacion/modal/modalPrecioHora.php'; ?>