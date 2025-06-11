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

    <!-- alertas -->

    <?php require_once "./src/vistas/alerts.php" ?>


    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto" style="width: 95%; ">

        <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">
            <?php if (!$this->permisos($_SESSION["id_rol"], "guardar", "Doctores")): ?>
                <!-- no hay -->
            <?php else: ?>


                <button class="btn-guardar-responsive  btn btn-primary btn-agregar-doctores col-8 " uk-toggle="target: #modal-agregar-doctores" id="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                        class="bi bi-plus-circle-fill me-1" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                    </svg>
                    Registrar doctor
                </button>
            <?php endif; ?>

            <button class="btn-guardar-responsive btn btn-primary btn-agregar-doctores col-8"
                uk-toggle="target: #modal-especialidad" id="">
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                    class="bi bi-lungs-fill azul" viewBox="0 0 16 16">
                    <path
                        d="M8 1a.5.5 0 0 1 .5.5v5.243L9 7.1V4.72C9 3.77 9.77 3 10.72 3c.524 0 1.023.27 1.443.592.431.332.847.773 1.216 1.229.736.908 1.347 1.946 1.58 2.48.176.405.393 1.16.556 2.011.165.857.283 1.857.24 2.759-.04.867-.232 1.79-.837 2.33-.67.6-1.622.556-2.741-.004l-1.795-.897A2.5 2.5 0 0 1 9 11.264V8.329l-1-.715-1 .715V7.214c-.1 0-.202.03-.29.093l-2.5 1.786a.5.5 0 1 0 .58.814L7 8.329v2.935A2.5 2.5 0 0 1 5.618 13.5l-1.795.897c-1.12.56-2.07.603-2.741.004-.605-.54-.798-1.463-.838-2.33-.042-.902.076-1.902.24-2.759.164-.852.38-1.606.558-2.012.232-.533.843-1.571 1.579-2.479.37-.456.785-.897 1.216-1.229C4.257 3.27 4.756 3 5.28 3 6.23 3 7 3.77 7 4.72V7.1l.5-.357V1.5A.5.5 0 0 1 8 1Zm3.21 8.907a.5.5 0 1 0 .58-.814l-2.5-1.786A.498.498 0 0 0 9 7.214V8.33l2.21 1.578Z" />
                </svg>
                </svg>Registrar Especialidades
            </button>

            <?php if (!$this->permisos($_SESSION["id_rol"], "guardar", "Consultas")): ?>
                <!-- no hay -->
            <?php else: ?>

                <button class="btn-guardar-responsive btn btn-primary btn-agregar-doctores col-8"
                    uk-toggle="target: #modal-example-servicio" id="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                        class="bi bi-bandaid-fill me-1" viewBox="0 0 16 16">
                        <path
                            d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z">
                        </path>
                    </svg>Registrar Servicio
                </button>
            <?php endif; ?>

        </div>



        <div class="table table-responsive">
            <table class="example table table-striped ">
                <thead>
                    <tr>
                        <th class="border-start-0 text-center">Cédula</th>
                        <th class="border-start text-center">Nombre</th>
                        <th class="border-start text-center">Apellido</th>
                        <th class="border-start text-center">Teléfono</th>
                        <th class="border-start text-center">E_mail</th>
                        <th class="border-start text-center">Especialidad</th>

                        <th class="border-start text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($datos as $dato): ?>
                        <tr>
                            <td class=" text-center">
                                <?php echo $dato["nacionalidad"] . '-' . $dato["cedula"]; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $dato["nombre_d"]; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $dato["apellido"]; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $dato["telefono"]; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $dato["correo"]; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $dato["nombre"]; ?>
                            </td>


                            <td class="text-center">
                                <!-- editar -->

                                <?php if (!$this->permisos($_SESSION["id_rol"], "editar", "Doctores")): ?>
                                    <!-- no hay -->
                                <?php else: ?>
                                    <button class="btn btn-tabla mb-1 btn-js editar botonesEdi"
                                        uk-toggle="target: #modal-editar-doctores<?php echo $dato["id_personal"]; ?>"
                                        id="btneditarDoctor" data-index="<?php echo $dato["id_personal"]; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                        </svg>

                                    </button>


                                <?php endif; ?>

                                <?php if (!$this->permisos($_SESSION["id_rol"], "eliminar", "Doctores")): ?>
                                    <!-- no hay -->
                                <?php else: ?>
                                    <button class="btn btn-tabla mb-1"
                                        uk-toggle="target: #modal-eliminar-doctores<?php echo $dato["id_personal"]; ?>"
                                        id="btnEliminarDoctor">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                        </svg>
                                    </button>

                                <?php endif; ?>
                                <button class="btn btn-tabla mb-1 botonesInfo" title="Horarios Del Doctor"
                                    uk-toggle="target: #modal-info-doctores"
                                    data-index="<?php echo $dato["id_personal"]; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>

                    <?php endforeach ?>

                </tbody>
            </table>
        </div>

    </div>

</div>


!-- modal agregar servicios -->
<!-- modal de agregar -->
<div id="modal-example-servicio" uk-modal>
    <div class="uk-modal-dialog uk-modal-body tamaño-modal">
        <!-- Boton que cierra el modal -->
        <a href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                <path
                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
            </svg>
        </a>

        <div class="d-flex align-items-center mb-3">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor"
                    class="bi bi-clipboard2-plus-fill azul me-3 mb-3" viewBox="0 0 16 16">
                    <path
                        d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5Z" />
                    <path
                        d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585c.055.156.085.325.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5c0-.175.03-.344.085-.5ZM8.5 6.5V8H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V9H6a.5.5 0 0 1 0-1h1.5V6.5a.5.5 0 0 1 1 0Z" />
            </div>
            <div class="">
                <p class="uk-modal-title fs-5 ">
                    Registrar Servicio
                </p>
            </div>

        </div>

        <div class="alert alert-danger d-none" role="alert" id="alerta">
            <div class="">
                <p style=" font-size: 12px; height:10px; " class=" text-center">VERIFIQUE EL FORMULARIO ANTES DE
                    ENVIARLO</p>
            </div>
        </div>

        <form class="form-modal form-convercion" id="modalAgregar" action="/Sistema-del--CEM--JEHOVA-RAFA/Doctores/guardarDoctores" method="POST"
            autocomplete="off">
            <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario']; ?>">

            <div class="input-group flex-nowrap">
                <span class="input-modal mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-grid-1x2-fill azul" viewBox="0 0 16 16">
                        <path
                            d="M0 1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V1zm0 9a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-5z" />
                    </svg> </span>
                <select class="form-control input-modal" aria-label="" id="id_categoria" placeholder="id_categoria"
                    name="id_servicioMedico" required>
                    <option value="" selected disabled>Seleccione la Categoría del Servicio</option>

                    <?php foreach ($todasLasServicios as $categoria): ?>
                        <option value="<?php echo $categoria['id_servicioMedico']; ?>">
                            <?php echo $categoria["categoria"] ?>
                        </option>

                    <?php endforeach ?>

                </select>

            </div>

            <div class="input-group flex-nowrap">
                <span class="input-modal mt-1">
                    <img src="<?= $urlBase ?>../src/assets/img/doctor (2).png" width="19" height="19" uk-svg
                        class="azul">
                </span>





                <select class="form-control input-modal input-disabled" aria-label=""
                    placeholder="Id_doctor" name="id_doctor" id="id_doctor">
                    <?php foreach ($doctores as $servicio): ?>
                        <option value="<?php echo $servicio['id_personal']; ?>" selected>
                            <?php echo $servicio['nombre']; ?>
                            <?php echo $servicio['apellido']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>


                <span class="input-modal mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-lungs-fill azul" viewBox="0 0 16 16">
                        <path
                            d="M8 1a.5.5 0 0 1 .5.5v5.243L9 7.1V4.72C9 3.77 9.77 3 10.72 3c.524 0 1.023.27 1.443.592.431.332.847.773 1.216 1.229.736.908 1.347 1.946 1.58 2.48.176.405.393 1.16.556 2.011.165.857.283 1.857.24 2.759-.04.867-.232 1.79-.837 2.33-.67.6-1.622.556-2.741-.004l-1.795-.897A2.5 2.5 0 0 1 9 11.264V8.329l-1-.715-1 .715V7.214c-.1 0-.202.03-.29.093l-2.5 1.786a.5.5 0 1 0 .58.814L7 8.329v2.935A2.5 2.5 0 0 1 5.618 13.5l-1.795.897c-1.12.56-2.07.603-2.741.004-.605-.54-.798-1.463-.838-2.33-.042-.902.076-1.902.24-2.759.164-.852.38-1.606.558-2.012.232-.533.843-1.571 1.579-2.479.37-.456.785-.897 1.216-1.229C4.257 3.27 4.756 3 5.28 3 6.23 3 7 3.77 7 4.72V7.1l.5-.357V1.5A.5.5 0 0 1 8 1Zm3.21 8.907a.5.5 0 1 0 .58-.814l-2.5-1.786A.498.498 0 0 0 9 7.214V8.33l2.21 1.578Z" />
                    </svg>
                </span>
                <input class="form-control input-modal input-disabled" type="text"
                    id="inputEspecialidad" name="especialidad" placeholder="Especialidad" disabled
                    value="">

            </div>







            <div class="mt-3 uk-text-right">
                <button class="uk-button col-6 me-2 uk-button-default uk-modal-close btn-cerrar-modal"
                    type="button">Cancelar</button>
                <button class="btn col-5 btn-agregarcita-modal" type="sumit" name="guardar">Agregar</button>
            </div>
        </form>
    </div>

    <?php require_once './src/vistas/vistaDoctores/modal/modalAgregarDoctores.php'; ?>
    <?php require_once './src/vistas/vistaDoctores/modal/modalEditarDoctores.php'; ?>
    <?php require_once './src/vistas/vistaDoctores/modal/modalEliminarDoctores.php'; ?>
    <?php require_once './src/vistas/vistaDoctores/modal/modalesEspecialidades.php'; ?>
    <?php require_once './src/vistas/vistaDoctores/modal/infoModalDoctores.php'; ?>



    <script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/especialidades.js"></script>
    <script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/ayudaDoctores.js"></script>
    <script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/buscadorDoctores.js"></script>
    <script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/validacionesDoctoresRegistrar.js"></script>
    <script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/validacionesDoctorEditar.js"></script>
    <script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/imgDoctores.js"></script>
    <script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/doctores.js"></script>

    <?php require_once './src/vistas/head/footer.php'; ?>