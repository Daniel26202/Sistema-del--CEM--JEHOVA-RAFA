<div class="modal fade" id="exampleModalCita" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content tamaño-modal">
            <div class="modal-header">
                <h5 class="modal-title fs-4 fw-bold" id="exampleModalLabelPaciente">Agendar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class=" form-validable" id="modalAgregarCita">

                <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario'] ?>">

                <input type="hidden" id="id_paciente" name="id_paciente">


                <div class="modal-body">

                    <label class="label-custom">Buscar Cédula</label>
                    <div class="campo-custom">
                        <div class="input-custom">
                            <span class="icono-izq">

                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-person-vcard-fill azul" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </span>

                            <select class="form-control-plaintext tamaño-select-mini inputs" id="nacionalidadCita" aria-label="2" placeholder="Nacionalidad" name="nacionalidad">
                                <option value="V" selected>V</option>
                                <option value="E">E</option>
                            </select>

                            <input class="form-control txt-custom input-validar inputs" name="cedula" type="number" placeholder="Cédula del paciente" id="cedulaCita">

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


                    <div id="div-data-paciente" class="d-none">
                        <label class="label-custom">Paciente</label>
                        <div class="campo-custom">
                            <div class="input-custom ">
                                <span class="icono-izq">
                                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"></path>
                                    </svg>
                                </span>
                                <input class="form-control txt-custom  inputs" name="nombre" type="text" placeholder="Nombre del paciente" id="inputPaciente" disabled>
                                <span class="icono-der">
                                    <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"></path>
                                    </svg>
                                    <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                                    </svg>
                                </span>
                            </div>
                            <p class="error-msg fw-bold p-error-validaciones d-none">El Nombre debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres</p>
                        </div>


                        <label class="label-custom">Telefono</label>
                        <div class="campo-custom">
                            <div class="input-custom ">
                                <span class="icono-izq">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-telephone-fill azul" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"></path>
                                    </svg>
                                </span>
                                <input class="form-control txt-custom  inputs" disabled type="number" placeholder="Teléfono del paciente" id="inputTelefono">
                                <span class="icono-der">
                                    <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"></path>
                                    </svg>
                                    <svg class="error  d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                                    </svg>
                                </span>
                            </div>
                            <p class="error-msg fw-bold p-error-validaciones d-none">El Teléfono solo debe contener y comen números, comenzando con "0412 o 0414 o 0416 o 0424 o 0426 o 0422</p>
                        </div>

                        <label class="label-custom">Seleccione el servicio médico</label>

                        <div class="campo-custom">
                            <div class="input-custom">
                                <span class="icono-izq">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gender-ambiguous azul" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M5 1.5A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5v-1Zm5 0a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1Z"></path>
                                        <path d="M3 1.5h1v1H3a1 1 0 0 0-1 1V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3.5a1 1 0 0 0-1-1h-1v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2Z"></path>
                                        <path d="M8 6.982C9.664 5.309 13.825 8.236 8 12 2.175 8.236 6.336 5.31 8 6.982Z"></path>
                                    </svg>
                                </span>

                                <select class="form-control txt-custom select-custom " id="select-servicios" name="id_servicio">


                                </select>
                                <span class="icono-der">
                                    <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"></path>
                                    </svg>
                                    <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                                    </svg>
                                </span>
                            </div>
                            <p class="error-msg fw-bold p-error-validaciones d-none">Por favor, selecciona una opción válida.</p>

                        </div>



                        <div id="div-doctor" class='d-none'>
                            <label class="label-custom">Seleccione el doctor</label>

                            <!-- acordion de doctores -->
                            <div class="accordion " id="accordionExampleDoctores">
                                <div class="accordion-item bg-theme">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button bg-theme text-center" type="button" data-bs-toggle="collapse" data-bs-target="#doctorOne" aria-expanded="true" aria-controls="collapseOne">
                                            Seleccione el doctor
                                        </button>
                                    </h2>
                                    <div id="doctorOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExampleDoctores">
                                        <div class="accordion-body" id="accordion-body-doctor">

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>



                        <div id="div-horarios" class='d-none'>
                            <label class="label-custom">Horarios</label>


                            <!-- acordion de horarios -->
                            <div class="accordion " id="accordionExampleHorarios">
                                <div class="accordion-item bg-theme">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button id="accordion-button-horario" class="accordion-button bg-theme text-center" type="button" data-bs-toggle="collapse" data-bs-target="#horarioOne" aria-expanded="true" aria-controls="collapseOne">

                                        </button>
                                    </h2>
                                    <div id="horarioOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExampleHorarios">
                                        <div class="accordion-body" id="accordion-body-horario">

                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>


                        <div id="div-fecha" class="d-none">
                            <label class="label-custom">Fecha de la cita</label>
                            <div class="campo-custom">
                                <div class="input-custom ">
                                    <span class="icono-izq">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
                                            <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z"></path>
                                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z"></path>
                                        </svg>
                                    </span>
                                    <input class="form-control txt-custom input-validar inputs" id="fecha" name="fechaDeCita" type="date">
                                    <span class="icono-der">
                                        <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"></path>
                                        </svg>
                                        <svg class="error  d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                                        </svg>
                                    </span>
                                </div>
                                <p class="error-msg fw-bold p-error-validaciones d-none"></p>
                            </div>
                        </div>

                        <div id="div-hora-disp" class='d-none'>
                            <label class="label-custom">Horarios disponibles</label>



                            <!-- acordion de horarios -->
                            <div class="accordion " id="accordionExampleDisp">
                                <div class="accordion-item bg-theme">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button bg-theme text-center" type="button" data-bs-toggle="collapse" data-bs-target="#dispOne" aria-expanded="true" aria-controls="collapseOne">
                                            Horarios Disponibles
                                        </button>
                                    </h2>
                                    <div id="dispOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExampleDisp">
                                        <div class="accordion-body d-flex justify-content-between" id="accordion-body-disp">

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>



                    </div>



                </div>
                <div class="modal-footer d-none" id="modal-footer">
                    <button type="button" class="btn btn-modals-cancelar me-2" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-modals" id="botonModal" data-bs-dismiss="modal">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>