<div class="modal fade " id="modal-agregar-hospitalizacion" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <p class="text-center text-white fw-bolder" id="pModalOculto" data-bs-dismiss="modal">Presione clic</p>
    <div class="modal-dialog uk-offcanvas-container" id="divModal">
        <div class="modal-content rounded-4 pt-3 pb-3 pe-4 ps-4 hospit">


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

                <?php if (empty($doctores)) : ?>
                    <form class="me-3 ms-3 mt-2 form-validable" method="" id="formularioAgregarH"
                        action="#">
                <?php else: ?>

                    <form class="me-3 ms-3 mt-2 form-validable" method="POST" id="formularioAgregarH"
                        action="/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/agregarH">
                <?php endif; ?>




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

                                <input type="hidden" name="id_paciente" id="input-id-paciente">
                                <input type="hidden" name="fecha" id="fechaHoy">
                                <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario'] ?>">

                                <p class="ms-3 mt-4 fw-bolder " id="p-no-paciente"><!-- esto se llena en el js --></p>
                                <a href="#" class="d-none ms-3 text-decoration-none fw-bold" id="aPaciente" uk-toggle="target: #modal-examplePaciente" data-bs-dismiss="modal">ir a agregar</a>

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
                            <div class="mt-3">
                                <h6 class="fw-bold mt-2 ms-5 col-9 ">Seleccione el doctor</h6>
                                <?php if (empty($doctores)) : ?>
                                    <p class="fw-bolder text-danger mb-2 mt-2">Tiene que existir al menos un doctor disponible para atenderle.</p>
                                <?php else: ?>
                                <?php endif; ?>


                                <div class="input-group flex-nowrap">
                                    <span class="input-modal mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                            class="bi bi-clipboard2-check-fill azul" viewBox="0 0 16 16">
                                            <path
                                                d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5" />
                                            <path
                                                d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585q.084.236.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5q.001-.264.085-.5m6.769 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                                        </svg>
                                    </span>

                                    <?php if (empty($doctores)) : ?>
                                        <select class="form-control input-modal" name="" id="" disabled required>
                                            <option selected disabled>No hay doctores disponibles</option>
                                        </select>
                                    <?php else: ?>
                                        <select class="form-control input-modal" name="doctor" id="doctorS" required>
                                            <option value="" selected disabled>Seleccionar doctor</option>
                                            <?php foreach ($doctores as $doc): ?>
                                                <option value="<?php echo $doc["id_personal"] ?>">
                                                    <?php echo $doc["nombre"] . " " . $doc["apellido"] ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div>
                                <div class="col-12 d-flex align-items-center justify-content-center  mt-4 pt-3 mb-2">

                                    <div class="col-3 ps-5 pt-1 ">

                                        <div class="d-none" id="btnAServiciosExisteA">
                                            <a href="#"
                                                class="d-flex justify-content-center align-items-center text-decoration-none"
                                                id="" data-bs-toggle="modal" data-bs-target="#modal-agregar-servicios">
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

                                    <h6 class="fw-bold mt-2 ms-5 col-9 ">Servicio médico</h6>
                                </div>

                                <div class="" id="btnAServicioNoExiste">
                                    <a href="#" class="col-12 text-center text-decoration-none m-0" id="btnASA"
                                        data-bs-toggle="modal" data-bs-target="#modal-agregar-servicios">
                                        <div class="color-icono d-flex align-items-center justify-content-center p-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                                fill="currentColor" class="bi bi-plus-circle me-2 " viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                <path
                                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                            </svg>
                                            <p class="mt-3 ">Agregar servicio</p>
                                        </div>
                                    </a>
                                </div>
                                <p class="mb-4 mt-3 d-none text-danger text-center fw-bolder" id="NoPAservicioA">No se puede agregar, ya existe el servicio.</p>

                                <div class="row g-3" id="div-serviciosA">



                                    <!-- Más tarjetas se agregan aquí dinámicamente desde JS -->

                                </div>
                            </div>





                            <div class="col-12 d-flex align-items-center justify-content-center  mt-4 pt-3 mb-2">

                                <div class="col-3 ps-5 pt-1 ">

                                    <div class="d-none" id="btnAInsumoExiste">
                                        <a href="#"
                                            class="d-flex justify-content-center align-items-center text-decoration-none"
                                            id="" data-bs-toggle="modal"
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


                            <div class="mt-5 pt-1">
                                <h4 class="text-center fw-bold">Historia clínica</h4>

                                <div class="uk-margin">
                                    <textarea name="historial" class="uk-textarea input-modal" rows="5" placeholder="Historial médico"
                                        aria-label="Textarea" id="historia_clinicaA" required></textarea>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="severidad" class="form-label col-12 text-center fw-bold">Severidad</label>
                                <select class="form-select" id="severidad" name="severidad" required>
                                    <option value="LEVE">Leve</option>
                                    <option value="MODERADA">Moderada</option>
                                    <option value="GRAVE">Grave</option>
                                </select>
                            </div>

                            <div class="form-floating input-modal mt-3">
                                <textarea class="form-control border-0 input-modal inputExpresiones input-modal-remove" rows="5"
                                    placeholder="Diagnóstico" id="floatingTextarea2"
                                    name="diagnostico"></textarea>
                                <label for="floatingTextarea2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                        class="bi bi-heart-pulse-fill azul me-2" viewBox="0 0 16 16">
                                        <path
                                            d="M1.475 9C2.702 10.84 4.779 12.871 8 15c3.221-2.129 5.298-4.16 6.525-6H12a.5.5 0 0 1-.464-.314l-1.457-3.642-1.598 5.593a.5.5 0 0 1-.945.049L5.889 6.568l-1.473 2.21A.5.5 0 0 1 4 9z" />
                                        <path
                                            d="M.88 8C-2.427 1.68 4.41-2 7.823 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C11.59-2 18.426 1.68 15.12 8h-2.783l-1.874-4.686a.5.5 0 0 0-.945.049L7.921 8.956 6.464 5.314a.5.5 0 0 0-.88-.091L3.732 8z" />
                                    </svg>Diagnóstico</label>
                            </div>

                        </div>
                    </div>
                    <div class="d-flex mt-3 ms-2 col-12">

                        <p class="uk-text-right col-9">
                            <button class="uk-button rounded-5 btn-cancelar fw-bold " type="button"
                                data-bs-dismiss="modal">Cancelar</button>
                            <?php if (empty($doctores)) : ?>

                            <?php else: ?>

                                <button class="uk-button uk-button-primary rounded-5 fw-bold d-none" type="submit"
                                    id="btnEnviar">Guardar</button>
                            <?php endif; ?>
                        </p>

                    </div>

                    </form>
        </div>


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





<!-- MODAL DE AGREGAR servicios -->
<div class="modal fade" id="modal-agregar-servicios" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down">
        <div class="modal-content rounded-4 p-4">

            <div class="d-flex justify-content-between align-items-center btnServicioNoEx">
                <div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor"
                        class="bi bi-plus-circle-fill color-icono me-2" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 
                        0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 
                        0 0 0 0-1h-3z" />
                    </svg>
                    <h4 class="fw-bold mb-0">Agregar servicio</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form class="me-3 ms-3 mt-2" method="POST" action="/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/agregarH">
                    <div class="d-flex justify-content-between align-items-center mt-1 ">

                        <div class="col-6">
                            <p class="ms-3 mt-4 fw-bolder " id="p-no-servicio"></p>
                        </div>

                        <div class="d-flex justify-content-end mt-4 mb-3 col-6">
                            <input class="form-control input-buscar" type="text" name="nombre"
                                placeholder="Ingrese nombre" id="btnBuscardorServicio">
                            <a href="#" class="btn btn-buscar" title="Buscar" id="btn-buscarServicio">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-search" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </a>
                        </div>

                    </div>
                </form>

                <h5 class="fw-bold text-center mb-3">Servicios</h5>

                <div class="row g-3" id="servicios">

                    <p class="m-auto d-none" id="noHayServicio">En estos momentos, no hay servicios disponibles</p>
                </div>
            </div>

            <p class="uk-text-right mt-4 text-center">
                <button class="uk-button rounded-5 fw-bold " id="btnCancelar" type="button" data-bs-toggle="modal"
                    data-bs-target="#modal-agregar-hospitalizacion">Cancelar</button>
            </p>

        </div>
    </div>
</div>