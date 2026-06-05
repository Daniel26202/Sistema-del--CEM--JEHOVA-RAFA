<?php require_once './src/vistas/head/head.php'; ?>



<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">

    <h5 style="width: 95%; " class="m-auto mb-3">Directorio Médico<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
            class="bi bi-clipboard2-pulse ms-2" viewBox="0 0 16 16">
            <path
                d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5h3Z" />
            <path
                d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-12Z" />
            <path
                d="M9.979 5.356a.5.5 0 0 0-.968.04L7.92 10.49l-.94-3.135a.5.5 0 0 0-.926-.08L4.69 10H4.5a.5.5 0 0 0 0 1H5a.5.5 0 0 0 .447-.276l.936-1.873 1.138 3.793a.5.5 0 0 0 .968-.04L9.58 7.51l.94 3.135A.5.5 0 0 0 11 11h.5a.5.5 0 0 0 0-1h-.128L9.979 5.356Z" />
        </svg></h5>

    <input type="hidden" name="id_usuario_bitacora" id="id_usuario_session" value="<?= $_SESSION['id_usuario'] ?>">


    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto" style="width: 95%; ">

        <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">


            <button class="btnOpenModal btn-guardar-responsive  caja-btn-margin btn btn-modals col-2 <?= $vistaActiva == "papelera" ? 'd-none' : '' ?>" data-bs-toggle="modal" data-bs-target="#exampleModalagregarDocotor" id="btnagregarDoctor">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                    class="bi bi-plus-circle-fill me-1" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                </svg>
                Registrar doctor
            </button>


            <button class="btnOpenModalEsp btn-guardar-responsive  caja-btn-margin btn btn-modals col-2  <?= $vistaActiva == "papelera" ? 'd-none' : '' ?>"
                data-bs-toggle="modal" data-bs-target="#exampleModalConsultarEspecialidad" id="btnEspecialidades">
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                    class="bi bi-lungs-fill azul" viewBox="0 0 16 16">
                    <path
                        d="M8 1a.5.5 0 0 1 .5.5v5.243L9 7.1V4.72C9 3.77 9.77 3 10.72 3c.524 0 1.023.27 1.443.592.431.332.847.773 1.216 1.229.736.908 1.347 1.946 1.58 2.48.176.405.393 1.16.556 2.011.165.857.283 1.857.24 2.759-.04.867-.232 1.79-.837 2.33-.67.6-1.622.556-2.741-.004l-1.795-.897A2.5 2.5 0 0 1 9 11.264V8.329l-1-.715-1 .715V7.214c-.1 0-.202.03-.29.093l-2.5 1.786a.5.5 0 1 0 .58.814L7 8.329v2.935A2.5 2.5 0 0 1 5.618 13.5l-1.795.897c-1.12.56-2.07.603-2.741.004-.605-.54-.798-1.463-.838-2.33-.042-.902.076-1.902.24-2.759.164-.852.38-1.606.558-2.012.232-.533.843-1.571 1.579-2.479.37-.456.785-.897 1.216-1.229C4.257 3.27 4.756 3 5.28 3 6.23 3 7 3.77 7 4.72V7.1l.5-.357V1.5A.5.5 0 0 1 8 1Zm3.21 8.907a.5.5 0 1 0 .58-.814l-2.5-1.786A.498.498 0 0 0 9 7.214V8.33l2.21 1.578Z" />
                </svg>
                </svg>Especialidades
            </button>



            <button class="btnOpenModalSer btn-guardar-responsive caja-btn-margin btn btn-modals col-2 <?= $vistaActiva == "papelera" ? 'd-none' : '' ?>"
                data-bs-toggle="modal" data-bs-target="#modal-designar-servicio" id="DMservicioMedico">
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                    class="bi bi-bandaid-fill me-1" viewBox="0 0 16 16">
                    <path
                        d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z">
                    </path>
                </svg>Asignar Servicio
            </button>



            <div class="col-1">
                <a href="<?= $vistaActiva == "papelera" ?
                                '/Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores' : '/Sistema-del--CEM--JEHOVA-RAFA/Doctores/papelera' ?>" class="btn me-md-2 lista-menu-pacientes text-decoration-none <?= $vistaActiva == 'papelera' ? 'active' : '' ?>"><?= $vistaActiva == "papelera" ? 'Doctores' : 'Papelera' ?></a>
            </div>


        </div>



        <div class="table table-responsive">
            <table class="exampleTable table table-striped ">
                <thead>
                    <tr class="text-align-left">
                        <th class="border-start-0 ">Cédula</th>
                        <th class="border-start ">Nombre</th>
                        <th class="border-start ">Apellido</th>
                        <th class="border-start ">Teléfono</th>
                        <th class="border-start " colspan="2">E_mail</th>
                        <th class="border-start ">Especialidad</th>

                        <th class="border-start ">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    <!-- js -->
                </tbody>
            </table>
        </div>

    </div>

</div>



<?php
if ($vistaActiva != "papelera") {
    require_once './src/vistas/vistaDoctores/modal/modalAgregarDoctores.php';
    require_once './src/vistas/vistaDoctores/modal/modalesEspecialidades.php';
}
?>

<script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/ayudaInteractiva/ayudaDoctores.js"></script>
<script type="module" src="<?= $urlBase; ?>../src/assets/js/ajax/doctor.js"></script>
<!-- <script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/doctores.js"></script> -->

<?php require_once './src/vistas/head/footer.php'; ?>