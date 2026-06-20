<div class="modal fade" id="modal-agregar-hospitalizacion" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalHospitalizacionLabel" aria-hidden="true">

    <!-- Párrafo oculto para cerrar (igual que el original) -->
    <p class="text-center text-white fw-bolder d-none" id="pModalOculto" data-bs-dismiss="modal">Presione clic</p>

    <div class="modal-dialog modal-md" id="divModal">
        <div class="modal-content tamaño-modal hospit">

            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor"
                        class="bi bi-plus-circle-fill color-icono" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                    </svg>
                    <h5 class="modal-title fw-bold mb-0" id="modalHospitalizacionLabel">Agregar hospitalización</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>


            <form class="modal-body form-validable" id="formularioAgregarH" method="POST"
                action="#">

                <!-- Campos ocultos -->
                <input type="hidden" name="id_paciente" id="input-id-paciente">
                <input type="hidden" name="fecha" id="fechaHoy">
                <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario'] ?>">

                <!-- SECCIÓN: BUSCAR PACIENTE -->
                <div class="ms-4 me-4 mt-3 mb-4">
                    <div class="row align-items-center g-2">

                        <!-- Buscador por cédula -->
                        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">

                            <label class="label-custom">Buscar paciente</label>

                            <div class="campo-custom">
                                <div class="input-custom" id="divGrp_cedula">

                                    <span class="icono-izq">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-vcard-fill azul" viewBox="0 0 16 16">
                                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                                        </svg>
                                    </span>

                                    <!-- Selector de nacionalidad V / E -->
                                    <select class="form-control-plaintext tamaño-select-mini inputs" id="nacionalidadH" name="nacionalidad" aria-label="Nacionalidad">
                                        <option value="V" selected>V</option>
                                        <option value="E">E</option>
                                    </select>

                                    <!-- Input cédula — búsqueda automática (debounce 500 ms) -->
                                    <input class="form-control txt-custom input-validar inputs w-100" type="number" name="cedula" id="bt" placeholder="Cédula del paciente" maxlength="8" minlength="6">

                                    <span class="icono-der">
                                        <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                        </svg>
                                        <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                        </svg>
                                    </span>
                                </div>

                                <p class="error-msg fw-bold p-error-validaciones p-error-cedula d-none">
                                    La cédula debe contener únicamente números y estar entre 6 a 8 caracteres.
                                </p>
                            </div>

                        </div>

                        <!-- Info del paciente encontrado -->
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-7 ps-3 pt-0 pt-lg-3">

                            <!-- Enlace al off-canvas (visible solo cuando hay paciente) -->
                            <a href="#" id="inforPaciente"
                                class="d-none d-flex align-items-center gap-1 text-decoration-none color-icono"
                                data-bs-toggle="offcanvas" data-bs-target="#offcanvas-paciente-info">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                    class="bi bi-file-text-fill" viewBox="0 0 16 16">
                                    <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1z" />
                                </svg>
                                <p class="fw-bolder mb-0" id="p-paciente"></p>
                            </a>

                            <p class="fw-bolder mb-1" id="p-no-paciente"></p>
                            <a href="#" class="d-none text-decoration-none fw-bold azul" id="aPaciente"
                                data-bs-toggle="modal" data-bs-target="#modal-examplePaciente" data-bs-dismiss="modal">
                                Ir a agregar paciente
                            </a>

                        </div>

                    </div>
                </div>
                <!-- ── CONTENEDOR: resto del formulario (aparece al encontrar paciente) ── -->
                <div class="d-none" id="contenedorFormAgregar">

                    <!-- ── DOCTOR ── -->
                    <label class="label-custom">Seleccione el doctor</label>

                    <?php if (empty($doctores)): ?>
                        <p class="fw-bolder text-danger mb-3">
                            Tiene que existir al menos un doctor disponible para atenderle.
                        </p>
                    <?php endif; ?>

                    <div class="campo-custom mb-2">
                        <div class="input-custom">
                            <span class="icono-izq">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-clipboard2-check-fill azul" viewBox="0 0 16 16">
                                    <path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5" />
                                    <path d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585q.084.236.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5q.001-.264.085-.5m6.769 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                                </svg>
                            </span>

                            <?php if (empty($doctores)): ?>
                                <select class="txt-custom select-custom" name="" disabled>
                                    <option selected disabled>No hay doctores disponibles</option>
                                </select>
                            <?php else: ?>
                                <select class="txt-custom select-custom input-validar" name="id_personal" id="doctorS" required>
                                    <option value="" selected disabled>Seleccionar doctor</option>
                                    <?php foreach ($doctores as $doc): ?>
                                        <option value="<?= $doc['id_personal'] ?>">
                                            <?= $doc['nombre'] . ' ' . $doc['apellido'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="icono-der">
                                    <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                    </svg>
                                    <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                    </svg>
                                </span>
                            <?php endif; ?>

                        </div>
                        <p class="error-msg fw-bold p-error-validaciones p-error-cedula d-none"></p>
                    </div>

                    <!-- ── SERVICIO MÉDICO ── -->
                    <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
                        <h6 class="fw-bold mt-2 ms-2 mb-2 col-9 ">Servicio médico</h6>

                        <!-- Botón agregar (visible cuando ya hay al menos un servicio) -->
                        <a href="#" class="d-none d-flex align-items-center gap-1 text-decoration-none color-icono fw-bold azul"
                            id="btnAServiciosExisteA"
                            data-bs-toggle="modal" data-bs-target="#modal-agregar-servicios">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                class="bi bi-plus-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                            </svg>
                            Agregar
                        </a>
                    </div>

                    <!-- Botón inicial (cuando no hay servicios) -->
                    <div id="btnAServicioNoExiste">
                        <a href="#" class="d-flex align-items-center justify-content-center gap-2 text-decoration-none color-icono azul"
                            id="btnASA" data-bs-toggle="modal" data-bs-target="#modal-agregar-servicios">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                                class="bi bi-plus-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                            </svg>
                            <span>Agregar servicio</span>
                        </a>
                    </div>

                    <p class="d-none text-danger text-center fw-bolder mt-2 mb-3" id="NoPAservicioA">
                        No se puede agregar, ya existe el servicio.
                    </p>

                    <!-- Tarjetas de servicios (JS las inserta aquí) -->
                    <div class="row g-3 mb-3" id="div-serviciosA"></div>

                    <!-- ── MEDICAMENTOS / INSUMOS ── -->
                    <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
                        <h6 class="fw-bold mt-2 ms-2 col-9 mb-2 mt-2">Medicamento y precio</h6>


                        <!-- Botón agregar más insumos (visible cuando ya hay alguno) -->
                        <a href="#" class="d-none d-flex align-items-center gap-1 text-decoration-none color-icono fw-bold azul"
                            id="btnAInsumoExiste"
                            data-bs-toggle="modal" data-bs-target="#modal-agregar-insumos">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                class="bi bi-plus-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                            </svg>
                            Agregar
                        </a>
                    </div>

                    <!-- Botón inicial (cuando no hay insumos) -->
                    <div id="btnAInsumoNoExiste">
                        <a href="#" class="d-flex align-items-center justify-content-center gap-2 text-decoration-none color-icono azul"
                            id="btnAIA" data-bs-toggle="modal" data-bs-target="#modal-agregar-insumos">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                                class="bi bi-plus-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                            </svg>
                            <span>Agregar insumos</span>
                        </a>
                    </div>

                    <!-- Insumos (JS los inserta aquí) -->
                    <div class="mb-3" id="div-insumosA"></div>

                    <!-- ── HISTORIA CLÍNICA ── -->
                    <h5 class="text-center fw-bold mt-4 mb-3">Historia clínica</h5>

                    <div class="campo-custom">
                        <div class="input-custom" style="align-items: flex-start;">
                            <span class="icono-izq pt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                    class="bi bi-journal-text azul" viewBox="0 0 16 16">
                                    <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                                </svg>
                            </span>
                            <textarea name="historial" class="txt-custom input-validar" rows="4"
                                placeholder="Ingrese el historial médico del paciente"
                                id="historia_clinicaA" required></textarea>
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

                    <!-- ── SEVERIDAD ── -->
                    <label class="label-custom">Severidad</label>
                    <div class="campo-custom">
                        <div class="input-custom">
                            <span class="icono-izq">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                    class="bi bi-activity azul" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6 2a.5.5 0 0 1 .47.33L10 12.036l1.53-4.208A.5.5 0 0 1 12 7.5h3.5a.5.5 0 0 1 0 1h-3.15l-1.88 5.17a.5.5 0 0 1-.94 0L6 3.964 4.47 8.171A.5.5 0 0 1 4 8.5H.5a.5.5 0 0 1 0-1h3.15l1.88-5.17A.5.5 0 0 1 6 2z" />
                                </svg>
                            </span>
                            <select class="txt-custom select-custom input-validar" id="severidad" name="severidad" required>
                                <option value="LEVE">Leve</option>
                                <option value="MODERADA">Moderada</option>
                                <option value="GRAVE">Grave</option>
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

                    <!-- ── DIAGNÓSTICO ── -->
                    <label class="label-custom">Diagnóstico</label>
                    <div class="campo-custom">
                        <div class="input-custom" style="align-items: flex-start;">
                            <span class="icono-izq pt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-heart-pulse-fill azul" viewBox="0 0 16 16">
                                    <path d="M1.475 9C2.702 10.84 4.779 12.871 8 15c3.221-2.129 5.298-4.16 6.525-6H12a.5.5 0 0 1-.464-.314l-1.457-3.642-1.598 5.593a.5.5 0 0 1-.945.049L5.889 6.568l-1.473 2.21A.5.5 0 0 1 4 9z" />
                                    <path d="M.88 8C-2.427 1.68 4.41-2 7.823 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C11.59-2 18.426 1.68 15.12 8h-2.783l-1.874-4.686a.5.5 0 0 0-.945.049L7.921 8.956 6.464 5.314a.5.5 0 0 0-.88-.091L3.732 8z" />
                                </svg>
                            </span>
                            <textarea class="txt-custom input-validar" rows="3" placeholder="Diagnóstico del paciente"
                                id="floatingTextarea2" name="diagnostico"></textarea>
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

                </div><!-- /contenedorFormAgregar -->

                <!-- ── FOOTER ── -->
                <div class="modal-footer border-0 d-flex justify-content-end gap-2 pt-0">
                    <button type="button" class="btn btn-modals-cancelar fw-bold rounded-5"
                        data-bs-dismiss="modal">Cancelar</button>

                    <?php if (!empty($doctores)): ?>
                        <button type="submit" class="btn btn-modals fw-bold rounded-5 d-none"
                            id="btnEnviar">Guardar</button>
                    <?php endif; ?>
                </div>

            </form>


            <!-- OFFCANVAS(Bootstrap puro) -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-paciente-info"
                aria-labelledby="offcanvasPacienteLabel"
                data-bs-backdrop="true" data-bs-scroll="false">

                <!-- HEADER -->
                <div class="offcanvas-header" style="background-color: var(--color-primary);">
                    <div class="d-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white"
                            class="bi bi-file-text-fill flex-shrink-0" viewBox="0 0 16 16">
                            <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1z" />
                        </svg>
                        <h5 class="offcanvas-title fw-bold mb-0 text-white" id="offcanvasPacienteLabel">
                            <span id="nombreInfor">Datos del paciente</span>
                        </h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
                </div>

                <!-- BODY -->
                <div class="offcanvas-body" style="background-color: var(--color-bg-main);">

                    <p class="titulo-seccion-offcanvas">
                        <i class="bi bi-clipboard2-pulse-fill me-1"></i> Diagnóstico previo
                    </p>
                    <div class="caja-diagnostico-offcanvas">
                        <p class="parrafo-offcanvas" id="inforDiagnostico"></p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
