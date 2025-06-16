<?php require_once './src/vistas/head/head.php'; ?>

<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">




    <div class="container mt-5 col-md-9">

        <div class="row mb-4 mt-2">
            <div class="col text-center">
                <h1>Mantenimiento de Base de Datos</h1>
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
                            <a href="ruta_a_descargar.php" class="btn btn-primary btn-block w-100 text-white text-decoration-none">Descargar Respaldo</a>
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
                            <a href="ruta_a_restaurar.php" class="btn btn-secondary btn-block w-100 text-decoration-none">Restaurar Base</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <div class="alert alert-info " role="alert">
                    Recuerda que estas operaciones son críticas, asegúrate de tener los permisos necesarios.
                </div>
            </div>
        </div>

    </div>




</div>





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