<!-- agregar contorl 2.0 -->

<div class="modal fade" id="exampleModalAgregarControl" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content tamaño-modal">
            <div class="modal-header">
                <h5 class="modal-title fs-4 fw-bold" id="modalTitleCita">Nuevo Control</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class=" form-validable" id="modalAgregarControl">

                <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario'] ?>">

                <input type="hidden" id="id_paciente" name="id_paciente">
                <input type="hidden" id="id_cita" name="id_cita">



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

                            <input class="form-control txt-custom input-validar inputs" name="cedula" type="number" placeholder="Cédula del paciente" id="cedulaControl">

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


                        <label class="label-custom">Edad</label>
                        <div class="campo-custom">
                            <div class="input-custom ">
                                <span class="icono-izq">
                                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"></path>
                                    </svg>
                                </span>
                                <input class="form-control txt-custom  inputs" disabled type="text" placeholder="Edad del paciente" id="inputEdad">
                                <span class="icono-der">
                                    <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"></path>
                                    </svg>
                                    <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                                    </svg>
                                </span>
                            </div>
                            <p class="error-msg fw-bold p-error-validaciones d-none">la edad no es correcta</p>
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

                                <select class="form-control txt-custom select-custom" id="severidad" name="severidad" required>
                                    <option class="option-select-background" value="LEVE">Leve</option>
                                    <option class="option-select-background" value="MODERADA">Moderada</option>
                                    <option class="option-select-background" value="GRAVE">Grave</option>

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

                        <!-- sintoma -->
                        <label class="label-custom">Doctores</label>
                        <!-- acordion de horarios -->
                        <div class="accordion " id="accordionExampleDoctores">
                            <div class="accordion-item bg-theme">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button bg-theme text-center" type="button" data-bs-toggle="collapse" data-bs-target="#horarioOne" aria-expanded="true" aria-controls="collapseOne">
                                        Doctores
                                    </button>
                                </h2>
                                <div id="horarioOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExampleDoctores">
                                    <div class="accordion-body" id="divDoctores">

                                    </div>
                                </div>
                            </div>

                        </div>


                        <!-- patologia -->

                        <div>
                            <label class="label-custom">Patologias</label>
                            <!-- acordion de horarios -->
                            <div class="accordion " id="accordionExamplePatologias">
                                <div class="accordion-item bg-theme">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button bg-theme text-center" type="button" data-bs-toggle="collapse" data-bs-target="#horarioOne" aria-expanded="true" aria-controls="collapseOne">
                                            Patologias
                                        </button>
                                    </h2>
                                    <div id="horarioOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExamplePatologias">
                                        <div class="accordion-body" id="divPatologias">

                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>

                        <!-- sintoma -->
                        <label class="label-custom">Sintomas</label>
                        <!-- acordion de horarios -->
                        <div class="accordion " id="accordionExampleSintomas">
                            <div class="accordion-item bg-theme">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button bg-theme text-center" type="button" data-bs-toggle="collapse" data-bs-target="#horarioOne" aria-expanded="true" aria-controls="collapseOne">
                                        Sintomas
                                    </button>
                                </h2>
                                <div id="horarioOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExampleSintomas">
                                    <div class="accordion-body" id="divSintomas">

                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- nota -->
                        <label class="label-custom">Notas</label>

                        <div class="campo-custom">
                            <div class="input-custom">
                                <span class="icono-izq">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gender-ambiguous azul" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M5 1.5A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5v-1Zm5 0a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1Z"></path>
                                        <path d="M3 1.5h1v1H3a1 1 0 0 0-1 1V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3.5a1 1 0 0 0-1-1h-1v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2Z"></path>
                                        <path d="M8 6.982C9.664 5.309 13.825 8.236 8 12 2.175 8.236 6.336 5.31 8 6.982Z"></path>
                                    </svg>
                                </span>

                                <textarea class="form-control txt-custom  inputs "
                                    placeholder="Leave a comment here" style="height: 50px;"
                                    name="nota"></textarea>

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


                        <label class="label-custom">Diagnostico</label>
                        <div class="campo-custom">
                            <div class="input-custom">
                                <span class="icono-izq">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gender-ambiguous azul" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M5 1.5A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5v-1Zm5 0a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1Z"></path>
                                        <path d="M3 1.5h1v1H3a1 1 0 0 0-1 1V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3.5a1 1 0 0 0-1-1h-1v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2Z"></path>
                                        <path d="M8 6.982C9.664 5.309 13.825 8.236 8 12 2.175 8.236 6.336 5.31 8 6.982Z"></path>
                                    </svg>
                                </span>

                                <textarea class="form-control txt-custom  inputs input-validar"
                                    placeholder="Leave a comment here" style="height: 50px;"
                                    name="diagnostico"></textarea>
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


                        <label class="label-custom">Preescripciones e Indicaciones</label>
                        <div class="campo-custom">
                            <div class="input-custom">
                                <span class="icono-izq">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gender-ambiguous azul" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M5 1.5A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5v-1Zm5 0a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1Z"></path>
                                        <path d="M3 1.5h1v1H3a1 1 0 0 0-1 1V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3.5a1 1 0 0 0-1-1h-1v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2Z"></path>
                                        <path d="M8 6.982C9.664 5.309 13.825 8.236 8 12 2.175 8.236 6.336 5.31 8 6.982Z"></path>
                                    </svg>
                                </span>

                                <textarea class="form-control txt-custom  inputs input-validar"
                                    placeholder="Leave a comment here" id="" style="height: 50px;"
                                    name="indicaciones"></textarea>
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

                        <label class="label-custom">Historial</label>
                        <div class="campo-custom">
                            <div class="input-custom">
                                <span class="icono-izq">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gender-ambiguous azul" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M5 1.5A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5v-1Zm5 0a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1Z"></path>
                                        <path d="M3 1.5h1v1H3a1 1 0 0 0-1 1V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3.5a1 1 0 0 0-1-1h-1v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2Z"></path>
                                        <path d="M8 6.982C9.664 5.309 13.825 8.236 8 12 2.175 8.236 6.336 5.31 8 6.982Z"></path>
                                    </svg>
                                </span>

                                <textarea class="form-control txt-custom  inputs input-validar"
                                    placeholder="Leave a comment here" style="height: 50px;"
                                    name="historial"></textarea>
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


                        <label class="label-custom">Fecha de Regreso</label>
                        <div class="campo-custom">
                            <div class="input-custom">
                                <span class="icono-izq">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
                                        <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
                                    </svg>
                                </span>
                                <input class="form-control txt-custom input-validar inputs" type="date" name="fechaDeCita">
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





                </div>
                <div class="modal-footer d-none" id="modal-footer">
                    <button type="button" class="btn btn-modals-cancelar me-2" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-modals" id="botonModal">Registrar</button>
                </div>
            </form>

            <div id="div-btn-add-pat" class="d-none">
                <button class="caja-btn-margin btn btn-modals" style="width: 100% !important" data-bs-toggle="modal" data-bs-target="#exampleModalagregarPaciente" id="btnOpenModalPac">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-bandaid-fill mx-2" viewBox="0 0 16 16">
                        <path
                            d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                    </svg>Registrar paciente
                </button>
            </div>

        </div>
    </div>
</div>