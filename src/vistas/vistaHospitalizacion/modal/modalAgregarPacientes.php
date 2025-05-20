<div class="modal fade" id="modal-agregar-hospitalizacion" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <p class="text-center text-white fw-bolder" id="pModalOculto" data-bs-dismiss="modal">Presione clic</p>
    <div class="modal-dialog uk-offcanvas-container" id="divModal">
        <div class="modal-content rounded-4 pt-3 pb-3 pe-4 ps-4">


            <div class=" d-flex justify-content-between align-items-center mt-2 pt-0">

                <div class=" d-flex justify-content-center align-items-center ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor"
                        class="bi bi-plus-circle-fill color-icono me-1" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                    </svg>
                    <h4 class=" fw-bold ">Agregar hospitalización</h4>
                </div>

                <!-- btn close -->
                <div>
                    <a href="#" class="" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor"
                            class="bi bi-x-circle color-icono" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path
                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                        </svg>
                    </a>
                </div>

            </div>


            <form class="me-3 ms-3 mt-2 form-validable" method="POST" id="formularioAgregarH"
                action="/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/agregarH">



                <div class="mb-5 pb-2">

                    <div class="d-flex justify-content-between align-items-center mt-1 ">

                        <div class="col-6">
                            <a href="#" class="d-none d-flex align-items-center text-decoration-none color-icono"
                                uk-toggle="target: #offcanvas-reveal" id="inforPaciente">
                                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" fill="currentColor"
                                    class="bi bi-file-text-fill me-1" viewBox="0 0 16 16">
                                    <path
                                        d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1z" />
                                </svg>
                                <p class="fw-bolder text-center mt-3" id="p-paciente"><!-- esto se llena en el js -->
                                </p>
                            </a>

                            <input type="hidden" name="id_control" id="input-id-controlP">
                            <input type="hidden" name="fecha" id="fechaHoy">
                            <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario'] ?>">

                            <p class="ms-3 mt-4 fw-bolder " id="p-no-paciente"><!-- esto se llena en el js --></p>
                            <a href="#" class="d-none ms-3 text-decoration-none fw-bold" id="aPaciente" uk-toggle="target: #modal-examplePaciente" data-bs-dismiss="modal">ir a agregar</a>
                            <a href="/Sistema-del--CEM--JEHOVA-RAFA/ControladorControl/control" class="d-none ms-3 text-decoration-none fw-bold"
                                id="aControl">ir a agregar</a>
                            <a href="?c=ControladorCitas/citas" class="d-none ms-3 text-decoration-none fw-bold"
                                id="aCita">ir a citas</a>
                        </div>
                        <div class="d-flex justify-content-end mt-4 mb-3 col-6 divGrp_cedula" id="">
                            <input class="form-control input-buscar input-validar" type="number" name="cedula" placeholder="Ingrese cédula" id="bt" maxlength="8" minlength="6" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            <p class="p-error-cedula d-none">La cédula debe contener únicamente números y estar entre 6 a 7 caracteres</p>

                            <a href="#" class="btn btn-buscar" title="Buscar" id="btn-buscar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-search" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </a>
                            <!-- este btn es para que no enviar-->
                            <a href="#" class="btn btn-buscar d-none" title="Buscar" id="no-buscar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-search" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </a>
                        </div>

                    </div>

                    <div class="d-none" id="contenedorFormAgregar">
                        <div>
                            <div class="col-12 d-flex align-items-center justify-content-center  mt-4 pt-3 mb-2">

                                <div class="col-3 ps-5 pt-1 ">

                                    <div class="d-none" id="btnAInsumoExiste">
                                        <a href="#"
                                            class="d-flex justify-content-center align-items-center text-decoration-none"
                                            id="btnAIADos" data-bs-toggle="modal"
                                            data-bs-target="#modal-agregar-insumos">
                                            <p class="mt-3 me-1 fw-bolder ">Agregar</p>
                                            <div class="color-icono">


                                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                                    fill="currentColor" class="bi bi-plus-circle me-5"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                    <path
                                                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                                </svg>
                                            </div>
                                        </a>
                                    </div>

                                </div>

                                <h6 class="fw-bold mt-2 ms-5 col-9 ">Medicamento y precio</h6>
                            </div>

                            <div class="" id="btnAInsumoNoExiste">
                                <a href="#" class="col-12 text-center text-decoration-none m-0" id="btnAIA"
                                    data-bs-toggle="modal" data-bs-target="#modal-agregar-insumos">
                                    <div class="color-icono d-flex align-items-center justify-content-center p-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                            fill="currentColor" class="bi bi-plus-circle me-2 " viewBox="0 0 16 16">
                                            <path
                                                d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                            <path
                                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                        </svg>
                                        <p class="mt-3 ">Agregar insumos</p>
                                    </div>
                                </a>
                            </div>

                            <div class="mb-1" id="div-insumosA">
                                <!-- los insumos esta en el js -->
                            </div>


                        </div>

                        <div class="mt-4 pt-2">
                            <h4 class="text-center fw-bold">Historia clínica</h4>

                            <div class="uk-margin">
                                <textarea name="historial" class="uk-textarea" rows="5" placeholder="Historial médico"
                                    aria-label="Textarea" id="historia_clinicaA" required></textarea>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="d-flex mt-5 ms-2 col-12">

                    <p class="uk-text-right col-9">
                        <button class="uk-button rounded-5 btn-cancelar fw-bold " type="button"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button class="uk-button uk-button-primary rounded-5 fw-bold d-none" type="submit"
                            id="btnEnviar">Guardar</button>
                    </p>

                </div>

            </form>

            <!-- modal off-canvas que sale a la derecha -->
            <div id="offcanvas-reveal" uk-offcanvas="esc-close: false; mode: reveal; flip: true; overlay: true">
                <div class="uk-offcanvas-bar">

                    <button class="uk-offcanvas-close" id="closeModal" type="button" uk-close></button>
                    <div class="d-flex align-items-start">

                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                            class="bi bi-file-text-fill me-1 pt-1 text-white col-1" viewBox="0 0 16 16">
                            <path
                                d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1z" />
                        </svg>
                        <h3 class="fw-bold" id="nombreInfor">Datos de Falwa Altrezi</h3>

                    </div>
                    <div class="mt-4 pt-1">
                        <h4 class="text-center fw-bold">Diagnostico</h4>
                        <p class="parrafo-offcanvas mt-2" id="inforDiagnostico"></p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>