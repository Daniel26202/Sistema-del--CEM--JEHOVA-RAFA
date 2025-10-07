<div id="modal-agregar-doctores" uk-modal>
    <div class="uk-modal-dialog uk-modal-body tamaño-modal">
        <!-- Boton que cierra el modal -->
        <a href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
            </svg>
        </a>

        <div class="d-flex align-items-center mb-3">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-fill-add azul me-3 mb-3" viewBox="0 0 16 16">
                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z" />
                </svg>
            </div>
            <div class="">
                <p class="uk-modal-title fs-5 ">
                    Registrar Doctor
                </p>
            </div>

        </div>
        <div class="alert alert-danger d-none alertaFormulario" role="alert">
            <div class="">
                <p style="font-size: 13px;" class="text-center">Por favor, corrige los errores en el formulario.</p>
            </div>
        </div>

        <form class="me-2 ms-2" method="POST" action="/Sistema-del--CEM--JEHOVA-RAFA/Doctores/agregarDoctor" id="modalAgregarDoctores"
            autocomplete="off" enctype="multipart/form-data">

            <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario'] ?>">

            <div class="alert alert-danger d-none" id="alerta-guardar">VERIFIQUE EL FORMULARIO ANTES DE ENVIARLO</div>

            <div class="col w-auto mt-4 mb-4 pb-1">
                <div id="contenedor-img-doctor" class="mb-3">
                    <!--  Aqui se va a inserta la imagen seleccionada -->
                </div>

                <div class="input-group flex-nowrap">
                    <span class="input-modal ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                            class="bi bi-camera-fill azul" viewBox="0 0 16 16">
                            <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                            <path
                                d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z" />
                        </svg>
                    </span>
                    <div class="mb-3">
                        <!--  <label for="formFileSm" class="form-label">imagen</label> -->
                        <input class="form-control form-control-sm" id="imagenDoctores" name="imagenDoctores" type="file">
                    </div>
                </div>

                <div class="input-group flex-nowrap margin-inputs ">

                    <span class="input-modal mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-vcard-fill azul" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                        </svg>
                    </span>
                    <span class="">
                        <select class="form-control input-modal" aria-label="2" placeholder="Nacionalidad" name="nacionalidad">
                            <option value="V" selected>V</option>
                            <option value="E">E</option>
                        </select>
                    </span>
                    <input type="number" name="cedula" id="inputUno" class="form-control input-modal input-disabled inputA" placeholder="Cédula">

                </div>
                <div class="input-group flex-nowrap margin-inputs ">

                    <svg xmlns="http://www.w3.org/2000/svg" id="icono-dos" width="20" height="20"
                        fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                    </svg>

                    <input type="text" name="nombre" id="inputDos" class="form-control input-modal input-disabled inputA mayuscula" placeholder="Nombre">

                </div>
                <div class="input-group flex-nowrap margin-inputs">

                    <svg xmlns="http://www.w3.org/2000/svg" id="icono-tres" width="20" height="20"
                        fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                    </svg>

                    <input type="text" name="apellido" id="inputTres" class="form-control input-modal input-disabled inputA mayuscula" placeholder="Apellido">

                </div>
                <div class="input-group flex-nowrap margin-inputs">

                    <svg xmlns="http://www.w3.org/2000/svg" id="icono-cuatro" class="icono-telefono" width="20"
                        height="20" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                    </svg>

                    <input type="text" name="telefono" id="inputCuatro" class="form-control input-modal input-disabled inputA" placeholder="Teléfono">

                </div>
                <div class="input-group flex-nowrap margin-inputs">

                    <svg xmlns="http://www.w3.org/2000/svg" id="" width="19" height="19" fill="currentColor"
                        class="bi bi-envelope-at-fill icono" viewBox="0 0 16 16">
                        <path
                            d="M2 2A2 2 0 0 0 .05 3.555L8 8.414l7.95-4.859A2 2 0 0 0 14 2H2Zm-2 9.8V4.698l5.803 3.546L0 11.801Zm6.761-2.97-6.57 4.026A2 2 0 0 0 2 14h6.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586l-1.239-.757ZM16 9.671V4.697l-5.803 3.546.338.208A4.482 4.482 0 0 1 12.5 8c1.414 0 2.675.652 3.5 1.671Z" />
                        <path
                            d="M15.834 12.244c0 1.168-.577 2.025-1.587 2.025-.503 0-1.002-.228-1.12-.648h-.043c-.118.416-.543.643-1.015.643-.77 0-1.259-.542-1.259-1.434v-.529c0-.844.481-1.4 1.26-1.4.585 0 .87.333.953.63h.03v-.568h.905v2.19c0 .272.18.42.411.42.315 0 .639-.415.639-1.39v-.118c0-1.277-.95-2.326-2.484-2.326h-.04c-1.582 0-2.64 1.067-2.64 2.724v.157c0 1.867 1.237 2.654 2.57 2.654h.045c.507 0 .935-.07 1.18-.18v.731c-.219.1-.643.175-1.237.175h-.044C10.438 16 9 14.82 9 12.646v-.214C9 10.36 10.421 9 12.485 9h.035c2.12 0 3.314 1.43 3.314 3.034v.21Zm-4.04.21v.227c0 .586.227.8.581.8.31 0 .564-.17.564-.743v-.367c0-.516-.275-.708-.572-.708-.346 0-.573.245-.573.791Z" />
                    </svg>

                    <input type="email" name="email" class="form-control input-modal input-disabled inputA" placeholder="E_mail">

                </div>




                <?php if ($datosEspecialidades == array()): ?>


                    <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder h-25 w-100" uk-alert>

                        <p class="pe-2 text-center">Debe Registrar una especialidad para añadir un doctor</p>
                    </div>
                <?php else: ?>
                    <div class="input-group flex-nowrap margin-inputs ">

                        <svg xmlns="http://www.w3.org/2000/svg" class="icono" width="20" height="20" fill="currentColor"
                            class="bi bi-mortarboard-fill" viewBox="0 0 16 16">
                            <path
                                d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5Z" />
                            <path
                                d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032Z" />
                        </svg>

                        <select name="selectEspecialidad" class="form-control input-modal input-disabled inputA selectEspecialidad" placeholder="Especialidad" required>
                            <option value="" selected disabled>Seleccionar Especialidad</option>
                            <?php foreach ($datosEspecialidades as $e): ?>
                                <option value="<?php echo $e['id_especialidad'] ?>">
                                    <?php echo $e['nombre'] ?>
                                </option>
                            <?php endforeach ?>

                        </select>



                    </div>
                <?php endif; ?>


                <div class="margen-input d-none">

                    <svg xmlns="http://www.w3.org/2000/svg" id="icono-cinco" class="icono" width="20" height="20"
                        fill="currentColor" class="bi bi-mortarboard-fill" viewBox="0 0 16 16">
                        <path
                            d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5Z" />
                        <path
                            d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032Z" />
                    </svg>

                    <input type="text" name="especialidad" id="inputCinco" class="input inputA especialidad"
                        placeholder="Especialidad">

                </div>
                <div class="input-group flex-nowrap margin-inputs">

                    <svg xmlns="http://www.w3.org/2000/svg" id="icono-dos" width="20" height="20"
                        fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                    </svg>

                    <input type="text" name="usuario" id="inputDos" class="form-control input-modal input-disabled inputA" placeholder="Usuario">

                </div>
                <div class="input-group flex-nowrap margin-inputs">

                    <img src="<?= $urlBase; ?>../src/assets/img/candado.svg" id="icono-dos" class="icono" alt="">

                    <input type="password" name="password" id="passwordMostrar" class="form-control input-modal input-disabled inputA" placeholder="Contraseña">

                    <a href="#" class="text-decoration-none">
                        <svg id="ocultarPassword" xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                            fill="currentColor" class="bi bi-eye-slash-fill azul d-none"
                            viewBox="0 0 16 16">
                            <path
                                d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z" />
                            <path
                                d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z" />
                        </svg>
                        <svg id="mostrarPassword" xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                            fill="currentColor" class="bi bi-eye-fill azul d-none" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                            <path
                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                        </svg>
                    </a>


                </div>



                <!-- caja de los dias -->

                <div class="input-modal mt-3">
                    <ul uk-accordion="multiple: true">
                        <li class="uk-open">
                            <a class="uk-accordion-title text-decoration-none" href="#">

                                <h6 class="acordion-paciente fw-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        fill="currentColor" class="bi bi-calendar2-week-fill azul mb-2"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zM8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z" />
                                    </svg>
                                    Añadir Horario Al Doctor
                                </h6>
                            </a>

                            <div class="uk-accordion-content">
                                <div class="d-flex justify-content-between flex-wrap">
                                    <?php foreach ($datosDias as $dia): ?>

                                        <div class="d-flex w-50 justify-content-between mb-3">

                                            <div class="form-check form-switch d-flex align-items-center">
                                                <div>
                                                    <input class="form-check-input diaslaborables input inputA diasInA" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="dias[]" value="<?php echo $dia['id_horario'] ?>">
                                                </div>
                                                <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">
                                                        <?php echo $dia['diaslaborables'] ?>
                                                    </label></div>

                                            </div>
                                            <div style="width: 60%;">


                                                <div>
                                                    <input type="time" class="input-dias hora-entrada inputHorario d-none form-control input-modal input-disabled input inputA" title="Hora De Entrada <?= $dia['diaslaborables'] ?>">
                                                    <input type="time" class="input-dias hora-salida inputHorario mt-2 d-none form-control input-modal input-disabled input inputA" title="Hora De Salida <?= $dia['diaslaborables'] ?>">
                                                </div>

                                            </div>

                                        </div>
                                    <?php endforeach ?>


                                </div>
                            </div>
                        </li>
                    </ul>



                </div>

                <div class="d-flex align-items-center justify-content-center pe-3 ps-1 d-none" id="leyendaDia">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-info-circle azul me-1" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z">
                        </path>
                        <path
                            d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z">
                        </path>
                    </svg>
                    <i class="text-danger">Debe seleccionar al menos un dia laborable</i>
                </div>
                <div class="d-flex align-items-center justify-content-center pe-3 ps-1 d-none" id="leyendaHoraA">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-info-circle azul me-1" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z">
                        </path>
                        <path
                            d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z">
                        </path>
                    </svg>
                    <i class="text-danger">La hora de salida tiene que ser más tarde que la hora de entrada.</i>
                </div>


            </div>

            <p class="uk-text-right mt-4">

                <button class="uk-button col-6 me-2 uk-button-default uk-modal-close btn-cerrar-modal"
                    type="button">Cancelar</button>

                <!-- este condicional es para que si no hay una especialidad desaparesa el boton de agregar -->
                <?php if ($datosEspecialidades == array()): ?>
                    <!-- no hay nada -->
                <?php else: ?>
                    <button class="btn col-5 btn-agregarcita-modal" type="submit" name="agregar" id="botonEnviar">Agregar</button>
                <?php endif; ?>
            </p>

        </form>




    </div>
</div>