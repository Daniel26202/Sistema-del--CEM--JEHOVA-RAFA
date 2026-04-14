<?php require_once './src/vistas/head/head.php';  ?>


<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">

    <h5 style="width: 95%; " class="m-auto mb-3">Servicios <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
            fill="currentColor" class="bi bi-clipboard-heart mb-2 ms-2" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M5 1.5A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5v-1Zm5 0a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1Z" />
            <path
                d="M3 1.5h1v1H3a1 1 0 0 0-1 1V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3.5a1 1 0 0 0-1-1h-1v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2Z" />
            <path d="M8 6.982C9.664 5.309 13.825 8.236 8 12 2.175 8.236 6.336 5.31 8 6.982Z" />
        </svg>
    </h5>
    <input type="hidden" name="id_usuario" id="id_usuario_session" value="<?= $_SESSION['id_usuario'] ?>">

    <input type="hidden" id="dolar" value="<?= $_SESSION["dolar"] ?>">

    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto" style="width: 95%; ">

        <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between  ">


            <button class="<?= ($vistaActiva == 'papelera') ? 'd-none':'' ?> btn-guardar-responsive  caja-btn-margin btn btn-modals btnOpenModal"
                data-bs-toggle="modal" data-bs-target="#modalAgregarServicios" id="btnAgregarServicioMedico">
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                    class="bi bi-bandaid-fill me-1" viewBox="0 0 16 16">
                    <path
                        d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z">
                    </path>
                </svg>Registrar Servicio
            </button>
            <button class="<?= ($vistaActiva == 'papelera') ? 'd-none':'' ?> btn-guardar-responsive  caja-btn-margin btn btn-modals btnOpenModalCategoria"
                data-bs-toggle="modal" data-bs-target="#modal-categoria" id="btnAgregarCategoria">
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                    class="bi bi-bandaid-fill me-1" viewBox="0 0 16 16">
                    <path
                        d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z">
                    </path>
                </svg>Registrar Categoría
            </button>


            <div class="d-flex flex-column flex-md-row">
                <a href="<?= $vistaActiva == 'papelera' ? '/Sistema-del--CEM--JEHOVA-RAFA/Servicios/servicios' : '/Sistema-del--CEM--JEHOVA-RAFA/Servicios/papeleraServicio' ?>" class="btn me-md-2 lista-menu-pacientes text-decoration-none"><?= $vistaActiva == 'papelera' ? 'Servicios' : 'Papelera' ?></a>
            </div>


        </div>



        <div class="table table-responsive">
            <table class="exampleTable  table table-striped">
                <thead>
                    <tr class="text-align-left">
                        <th class="text-dark">Servicio</th>
                        <th class="text-dark">Precio en BS</th>
                        <th class="text-dark">Precio en $</th>
                        <th class="text-dark">Tipo</th>
                        <th class="text-dark">Acciones</th>
                    </tr>
                </thead>
                <tbody>


                    <!-- js -->
                </tbody>
            </table>
        </div>

    </div>


</div>


<!-- Modal Agregar-->
<div class="modal fade" id="modalAgregarServicios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content tamaño-modal">
            <div class="modal-header">
                <h5 class="modal-title fs-4 fw-bold" id="modalLabelServicios">Registrar Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="form-modal form-validable form-convercion" id="modalAgregar" autocomplete="off">

                    <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario'] ?>">
                    <input type="hidden" name="id_servicioMedico" value="" id="id_servicio">



                    <label class="label-custom">Categorías del Servicio</label>
                    <div class="campo-custom">
                        <div class="input-custom">
                            <span class="icono-izq">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-grid-1x2-fill azul" viewBox="0 0 16 16">
                                    <path
                                        d="M0 1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V1zm0 9a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-5z" />
                                </svg>
                            </span>

                            <select class="form-control txt-custom select-custom input-validar inputs" id="selectCategoria" name="id_categoria" required>
                                <option class='option-select-background' selected value="">Seleccione la Categoría del Servicio</option>
                            </select>
                            <span class="icono-der">
                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                </svg>
                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </span>
                        </div>
                        <p class="error-msg d-none"></p>

                    </div>

                    <label class="label-custom">Precio en dolares</label>
                    <div class="campo-custom">
                        <div class="input-custom">
                            <span class="icono-izq">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-currency-exchange azul" viewBox="0 0 16 16">
                                    <path
                                        d="M0 5a5.002 5.002 0 0 0 4.027 4.905 6.46 6.46 0 0 1 .544-2.073C3.695 7.536 3.132 6.864 3 5.91h-.5v-.426h.466V5.05c0-.046 0-.093.004-.135H2.5v-.427h.511C3.236 3.24 4.213 2.5 5.681 2.5c.316 0 .59.031.819.085v.733a3.46 3.46 0 0 0-.815-.082c-.919 0-1.538.466-1.734 1.252h1.917v.427h-1.98c-.003.046-.003.097-.003.147v.422h1.983v.427H3.93c.118.602.468 1.03 1.005 1.229a6.5 6.5 0 0 1 4.97-3.113A5.002 5.002 0 0 0 0 5zm16 5.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0zm-7.75 1.322c.069.835.746 1.485 1.964 1.562V14h.54v-.62c1.259-.086 1.996-.74 1.996-1.69 0-.865-.563-1.31-1.57-1.54l-.426-.1V8.374c.54.06.884.347.966.745h.948c-.07-.804-.779-1.433-1.914-1.502V7h-.54v.629c-1.076.103-1.808.732-1.808 1.622 0 .787.544 1.288 1.45 1.493l.358.085v1.78c-.554-.08-.92-.376-1.003-.787H8.25zm1.96-1.895c-.532-.12-.82-.364-.82-.732 0-.41.311-.719.824-.809v1.54h-.005zm.622 1.044c.645.145.943.38.943.796 0 .474-.37.8-1.02.86v-1.674l.077.018z" />
                                </svg>
                            </span>
                            <input class="form-control txt-custom input-validar inputs precioDolares inputsConversion" data-index='dolares' name="precioD" type="text" placeholder="Precio en dolares">
                            <span class="input-modal mt-1">$</span>
                            <span class="icono-der">
                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                </svg>
                                <svg class="error d-none " width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </span>
                        </div>
                        <p class="error-msg d-none">El formato del precio es incorrecto, Ejemplo 0,00 - 00,00 - 000,00 - 0.000,00 </p>
                    </div>

                    <label class="label-custom">Precio en bolivares</label>
                    <div class="campo-custom">
                        <div class="input-custom">
                            <span class="icono-izq">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-currency-exchange azul" viewBox="0 0 16 16">
                                    <path
                                        d="M0 5a5.002 5.002 0 0 0 4.027 4.905 6.46 6.46 0 0 1 .544-2.073C3.695 7.536 3.132 6.864 3 5.91h-.5v-.426h.466V5.05c0-.046 0-.093.004-.135H2.5v-.427h.511C3.236 3.24 4.213 2.5 5.681 2.5c.316 0 .59.031.819.085v.733a3.46 3.46 0 0 0-.815-.082c-.919 0-1.538.466-1.734 1.252h1.917v.427h-1.98c-.003.046-.003.097-.003.147v.422h1.983v.427H3.93c.118.602.468 1.03 1.005 1.229a6.5 6.5 0 0 1 4.97-3.113A5.002 5.002 0 0 0 0 5zm16 5.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0zm-7.75 1.322c.069.835.746 1.485 1.964 1.562V14h.54v-.62c1.259-.086 1.996-.74 1.996-1.69 0-.865-.563-1.31-1.57-1.54l-.426-.1V8.374c.54.06.884.347.966.745h.948c-.07-.804-.779-1.433-1.914-1.502V7h-.54v.629c-1.076.103-1.808.732-1.808 1.622 0 .787.544 1.288 1.45 1.493l.358.085v1.78c-.554-.08-.92-.376-1.003-.787H8.25zm1.96-1.895c-.532-.12-.82-.364-.82-.732 0-.41.311-.719.824-.809v1.54h-.005zm.622 1.044c.645.145.943.38.943.796 0 .474-.37.8-1.02.86v-1.674l.077.018z" />
                                </svg>
                            </span>
                            <input class="form-control txt-custom input-validar inputs precioBolivares inputsConversion" data-index='bolivares' name="precioBs" type="text" placeholder="Precio en bolivares">
                            <span class="input-modal mt-1">bs</span>
                            <span class="icono-der">
                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                </svg>
                                <svg class="error d-none " width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </span>
                        </div>
                        <p class="error-msg d-none">El formato del precio es incorrecto, Ejemplo 0,00 - 00,00 - 000,00 - 0.000,00 </p>
                    </div>

                    <label class="label-custom">Tipo de Servicio</label>
                    <div class="campo-custom">
                        <div class="input-custom">
                            <span class="icono-izq">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-grid-1x2-fill azul" viewBox="0 0 16 16">
                                    <path
                                        d="M0 1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V1zm0 9a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-5z" />
                                </svg>
                            </span>

                            <select class="form-control txt-custom select-custom input-validar inputs" id="id_tipo" name="tipo" required>
                                <option class='option-select-background' selected value="">Seleccione el tipo de Servicio</option>

                                <option class='option-select-background' value="Cita">Cita</option>
                                <option class='option-select-background' value="Examenes">Exámenes</option>

                            </select>
                            <span class="icono-der">
                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                </svg>
                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </span>
                        </div>
                        <p class="error-msg d-none"></p>

                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-modals-cancelar me-2" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-modals" id="botonModalServicio" data-bs-dismiss="modal">Registrar</button>
            </div>
            </form>
        </div>
    </div>
</div>




<?php require_once './src/vistas/vistaServicios/modalesCategoria.php';
?>

<script type="module" src="<?= $urlBase; ?>../src/assets/js/ajax/servicios.js"></script>
<script type="module" src="<?= $urlBase; ?>../src/assets/js/ajax/categoria.js"></script>
<script src="<?= $urlBase; ?>../src/assets/js/ayudaInteractiva/ayudaServicioMedico.js"></script>


<?php require_once './src/vistas/head/footer.php';  ?>