<?php foreach ($datos as $dato): ?>
    <div id="modal-editar-doctores<?php echo $dato["id_personal"]; ?>" uk-modal class="">
        <div class="uk-modal-dialog uk-modal-body rounded-4 pt-3 w-50 pb-3 modal_responsiv">
            <div class=" d-flex justify-content-between align-items-center mt-2 pt-0">

                <div class=" d-flex justify-content-center align-items-center ">

                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor"
                        class="bi bi-pencil-fill color-icono me-2 mb-1" viewBox="0 0 16 16">
                        <path
                            d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                    </svg>
                    <h4 class="">Editar Doctor</h4>
                </div>
                <div>

                    <a href="#" class="uk-modal-close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor"
                            class="bi bi-x-circle color-icono" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path
                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                        </svg>
                    </a>
                </div>

            </div>


            <form class="me-2 ms-2 formulario_editar" method="POST"
                action="?c=controladorDoctores/editarDoctor&cedulaDb=<?php echo $dato["cedula"]; ?>">

                <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario']?>">

                <div class="contenedroInputsOcultos<?php echo $dato["id_personal"]; ?>">

                </div>
                <div class="col w-auto mt-2 mb-4 pb-1">
                    <div class="d-flex flex-column w-auto ">

                        <div class="margen-input mt-3 w-auto d-flex grpFormCorrect">

                            <svg xmlns="http://www.w3.org/2000/svg" id="icono-uno" width="20" height="20"
                                fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            </svg>
                            <select class="input" aria-label="2" placeholder="Nacionalidad" name="nacionalidad"
                                style="width: 70px;">
                                <option value="V" selected>V</option>
                                <option value="E">E</option>
                            </select>
                            <input type="number" name="cedula" id="inputUno" class="input" placeholder="Cédula" value="<?php echo $dato["cedula"]; ?>">

                        </div>
                        <div class="margen-input w-auto grpFormCorrect">

                            <svg xmlns="http://www.w3.org/2000/svg" id="icono-dos" width="20" height="20"
                                fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            </svg>

                            <input type="text" name="nombre" id="inputDos" class="input mayuscula" placeholder="Nombre" value="<?php echo $dato["9"]; ?>">

                        </div>
                        <div class="margen-input w-auto grpFormCorrect">

                            <svg xmlns="http://www.w3.org/2000/svg" id="icono-tres" width="20" height="20"
                                fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            </svg>

                            <input type="text" name="apellido" id="inputTres" class="input mayuscula" placeholder="Apellido"
                                value="<?php echo $dato["apellido"]; ?>">

                        </div>
                        <div class="margen-input w-auto grpFormCorrect">

                            <svg xmlns="http://www.w3.org/2000/svg" id="icono-cuatro" class="icono-telefono" width="20"
                                height="20" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                            </svg>

                            <input type="text" name="telefono" id="inputCuatro" class="input" placeholder="Teléfono"
                                value="<?php echo $dato["telefono"]; ?>">

                        </div>
                        <div class="margen-input w-auto grpFormCorrect">

                            <svg xmlns="http://www.w3.org/2000/svg" id="" width="19" height="19" fill="currentColor"
                                class="bi bi-envelope-at-fill icono" viewBox="0 0 16 16">
                                <path
                                    d="M2 2A2 2 0 0 0 .05 3.555L8 8.414l7.95-4.859A2 2 0 0 0 14 2H2Zm-2 9.8V4.698l5.803 3.546L0 11.801Zm6.761-2.97-6.57 4.026A2 2 0 0 0 2 14h6.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586l-1.239-.757ZM16 9.671V4.697l-5.803 3.546.338.208A4.482 4.482 0 0 1 12.5 8c1.414 0 2.675.652 3.5 1.671Z" />
                                <path
                                    d="M15.834 12.244c0 1.168-.577 2.025-1.587 2.025-.503 0-1.002-.228-1.12-.648h-.043c-.118.416-.543.643-1.015.643-.77 0-1.259-.542-1.259-1.434v-.529c0-.844.481-1.4 1.26-1.4.585 0 .87.333.953.63h.03v-.568h.905v2.19c0 .272.18.42.411.42.315 0 .639-.415.639-1.39v-.118c0-1.277-.95-2.326-2.484-2.326h-.04c-1.582 0-2.64 1.067-2.64 2.724v.157c0 1.867 1.237 2.654 2.57 2.654h.045c.507 0 .935-.07 1.18-.18v.731c-.219.1-.643.175-1.237.175h-.044C10.438 16 9 14.82 9 12.646v-.214C9 10.36 10.421 9 12.485 9h.035c2.12 0 3.314 1.43 3.314 3.034v.21Zm-4.04.21v.227c0 .586.227.8.581.8.31 0 .564-.17.564-.743v-.367c0-.516-.275-.708-.572-.708-.346 0-.573.245-.573.791Z" />
                            </svg>

                            <input type="email" name="email" class="input" placeholder="E_mail"
                                value="<?php echo $dato["email"]; ?>">

                        </div>

                        <!-- Nueva Especialidad -->

                        <div class="margen-input caja_select_especialidad">

                            <svg xmlns="http://www.w3.org/2000/svg" id="icono-cinco" class="icono" width="20" height="20"
                                fill="currentColor" class="bi bi-mortarboard-fill" viewBox="0 0 16 16">
                                <path
                                    d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5Z" />
                                <path
                                    d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032Z" />
                            </svg>


                            <select name="selectEspecialidad" class="input selectEspecialidad " placeholder="Especialidad">
                                <option selected value="<?php echo $dato[16]; ?>">
                                    <?php echo $dato[17]; ?>
                                </option>

                                <?php foreach ($datosEspecialidades as $e): ?>
                                    <option value="<?php echo $e['id_especialidad'] ?>">
                                        <?php echo $e['nombre'] ?>
                                    </option>
                                <?php endforeach ?>

                            </select>

                        </div>




                        <!-- caja de los dias -->

                        <div class="input-modal mt-3">
                            <ul uk-accordion="multiple: true">
                                <li>
                                    <a class="uk-accordion-title text-decoration-none" href="#">

                                        <h6 class="acordion-paciente fw-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                fill="currentColor" class="bi bi-calendar2-week-fill azul mb-2"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zM8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z" />
                                            </svg>
                                            Modificar El Horario Al Doctor
                                        </h6>
                                    </a>

                                    <div class="uk-accordion-content">
                                        <div class="d-flex justify-content-between flex-wrap">
                                            <?php foreach ($datosDias as $dia): ?>

                                                <div class="d-flex w-50 justify-content-between mb-3">






                                                    <div class="form-check form-switch d-flex align-items-center">
                                                        <div>
                                                            <input class="form-check-input diaslaborables diasIn input" type="checkbox"
                                                                role="switch" id="flexSwitchCheckDefault" name="dias[]"
                                                                value="<?php echo $dia['id_horario'] ?>">
                                                        </div>
                                                        <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">
                                                                <?php echo $dia['diaslaborables'] ?>
                                                            </label></div>

                                                    </div>
                                                    <div style="width: 60%;">


                                                        <div>
                                                            <input type="time"
                                                                class="input-dias hora-entrada inputHorario d-none input"
                                                                title="Hora De Entrada <?= $dia['diaslaborables'] ?>" name="horaEntradaNoChecked[]">
                                                            <input type="time"
                                                                class="input-dias hora-salida inputHorario mt-2 d-none input"
                                                                title="Hora De Salida <?= $dia['diaslaborables'] ?>" name="horaSalidaNoChecked[]">
                                                        </div>

                                                    </div>

                                                </div>
                                            <?php endforeach ?>


                                        </div>
                                    </div>
                                </li>
                            </ul>



                        </div>

                        <div class="d-flex align-items-center justify-content-center pe-3 ps-1 d-none msj" id="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-info-circle azul me-1" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z">
                                </path>
                                <path
                                    d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z">
                                </path>
                            </svg>
                            <i>El formato de la hora es incorrecto. La hora de salida tiene que ser más tarde que la hora de entrada.
                            </i>
                        </div>


                    </div>
                </div>



                <!-- inputs ocultos -->
                <div>
                    <input type="" name="id_usuario" value="<?php echo $dato["id_usuario"]; ?>" hidden>
                    <input type="" name="id_especialidad" value="<?php echo $dato["id_especialidad"]; ?>" hidden>

                    <input type="" name="id_personalyespecialidad" value=""
                        hidden>
                </div>

                <p class="uk-text-right mt-4">
                    <button class="uk-button uk-button-default uk-modal-close  btn-cerrar-modal"
                        type="button">Cancelar</button>
                    <input class="uk-button btn-agregarcita-modal" name="actualizar" type="submit" value="Editar">
                </p>

            </form>

        </div>
    </div>
<?php endforeach ?>