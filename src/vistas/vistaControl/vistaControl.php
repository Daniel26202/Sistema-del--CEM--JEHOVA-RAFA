<?php require_once './src/vistas/head/head.php';  ?>

<input type="hidden" id="id_usuario_bitacora" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario']; ?>">

<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">
    <h5 style="width: 95%; " class="m-auto mb-3">Control Médico<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
            class="bi bi-person-gear ms-2 mb-2" viewBox="0 0 16 16">
            <path
                d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm.256 7a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
        </svg></h5>

    <input type="hidden" name="id_usuario" id="id_usuario_session" value="<?= $_SESSION['id_usuario'] ?>">


    <div class="comentario  comentarioRed me-4 fw-bolder  text-center d-none" id="alert-control" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p class="pe-2"></p>
    </div>



    <div class="container">
        <!-- Tabla de Pacientes -->
        <div class="tabla-control-medico pacientes" id="pacientes">
            <button class="caja-btn-margin btn btn-modals btnOpenModal" style="width: 50% !important" data-bs-toggle="modal" data-bs-target="#exampleModalagregarControl" id="btnControl">
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                    class="bi bi-person-lines-fill me-1" viewBox="0 0 16 16">
                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z" />
                </svg>Registrar Control Médico
            </button>
            <h5>Pacientes</h5>
            <div class="scrollable">
                <table class="table table-striped examplePaciente   hover-control-m">
                    <thead>
                        <tr>
                            <th>Cédula</th>
                            <th>Nombre</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Sexo</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-pacientes">
                        <!-- js -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabla de Registros con scroll -->
        <div class="tabla-control-medico  registros" id="controles">
            <button class=" caja-btn-margin btn btn-modals btnOpenModalSin" data-bs-toggle="modal" data-bs-target="#exampleModalConsultarSintoma" id="btnOpenModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                    class="bi bi-person-lines-fill me-1" viewBox="0 0 16 16">
                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z" />
                </svg>Registrar Síntomas
            </button>
            <h5>Registros</h5>
            <div class="scrollable">
                <table class="table table-striped exampleControl d-none">
                    <thead>
                        <tr>
                            <th>Fecha de Control</th>
                            <th>Fecha de Regreso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-control">

                        <!-- js -->

                    </tbody>

                </table>
                <h5 class="text-center " id="text-start">Selecciona un paciente en la otra tarjeta para visualizar su control médico</h5>
                <h5 class="text-center d-none" id="loader-control-medico">Cargando...</h5>
            </div>
        </div>
    </div>
</div>









<?php require_once './src/vistas/vistaControl/modalAgregarControl.php'; ?>
<?php require_once './src/vistas/vistaControl/modalesSintomas.php'; ?>
<?php require_once './src/vistas/vistaPacientes/modalAgregarPaciente.php'; ?>

<script type="module" src="<?= $urlBase ?>../src/assets/js/ajax/control.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/ayudaControl.js"></script>
<?php require_once './src/vistas/head/footer.php';  ?>