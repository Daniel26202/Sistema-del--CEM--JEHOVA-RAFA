<!-- ====================================================
     MODAL: EDITAR HOSPITALIZACIÓN
     Insumos y servicios usan los modales unificados.
===================================================== -->
<div class="modal fade divModalE" id="modal-editar-hospitalizacion" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalEditarHospitalizacionLabel" aria-hidden="true">

    <div class="modal-dialog modal-md">
        <div class="modal-content tamaño-modal hospit">

            <!-- HEADER -->
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                        class="bi bi-pencil-fill color-icono" viewBox="0 0 16 16">
                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0
                        0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0
                        0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468
                        7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5
                        0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5
                        0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                    </svg>
                    <h5 class="modal-title fw-bold mb-0" id="modalEditarHospitalizacionLabel">
                        Editar hospitalización
                    </h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- FORM -->
            <form method="POST" class="modal-body form-validable" id="formularioEditarH">

                <!-- Campos ocultos -->
                <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario']; ?>">
                <input type="hidden" name="id_controlE" id="idCE">
                <input type="hidden" name="id_h" id="idHptE">
                <input type="hidden" name="id_insumos_eliminados[]" id="idInEli">
                <input type="hidden" name="id_insumos_eliminados[]" id="idInEliDos">

                <div class="ms-2 me-2 mt-1">

                    <!-- PACIENTE (solo lectura, JS lo llena) -->
                    <div class="ms-3 mt-3 d-flex align-items-center gap-2">
                        <h6 class="fw-bolder mb-0">Paciente:</h6>
                        <span class="azul">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                            </svg>
                        </span>
                        <p class="fw-bolder mb-0" id="NombreAp"></p>
                    </div>

                    <!-- SERVICIO MÉDICO -->
                    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                        <h6 class="fw-bold mt-2 ms-2 mb-2 col-9">Servicio médico</h6>
                        <!-- Botón agregar más (visible cuando ya hay servicios) -->
                        <a href="#" class="azul d-none d-flex align-items-center gap-1 text-decoration-none color-icono fw-bold"
                            id="btnAServiciosExisteE"
                            data-bs-toggle="modal" data-bs-target="#modal-servicios-uni"
                            data-contexto="editar">
                            <i class="bi bi-plus-circle fs-5"></i> Agregar
                        </a>
                    </div>
                    <!-- Botón inicial sin servicios -->
                    <a href="#" id="btnASE"
                        class="azul d-flex align-items-center justify-content-center gap-2 text-decoration-none color-icono"
                        data-bs-toggle="modal" data-bs-target="#modal-servicios-uni"
                        data-contexto="editar">
                        <i class="bi bi-plus-circle fs-4"></i>
                        <span>Agregar servicio</span>
                    </a>
                    <p class="d-none text-danger text-center fw-bolder mt-2 mb-3" id="NoPAservicioE">
                        No se puede agregar, ya existe el servicio.
                    </p>
                    <!-- Cards de servicios (JS las inserta) -->
                    <div class="row g-3 mb-3" id="div-serviciosE"></div>

                    <!-- MEDICAMENTOS / INSUMOS -->
                    <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
                        <h6 class="fw-bold mt-2 ms-2 col-9 mb-2">Medicamento y precio</h6>
                        <!-- Botón agregar más (visible cuando ya hay insumos) -->
                        <a href="#" class="d-none d-flex align-items-center gap-1 text-decoration-none color-icono fw-bold azul"
                            id="btnAInsumoExisteE"
                            data-bs-toggle="modal" data-bs-target="#modal-insumos"
                            data-contexto="editar">
                            <i class="bi bi-plus-circle fs-5"></i> Agregar
                        </a>
                    </div>
                    <!-- Botón inicial sin insumos -->
                    <a href="#" id="btnAInsumoNoExisteE"
                        class="azul d-flex align-items-center justify-content-center gap-2 text-decoration-none color-icono"
                        data-bs-toggle="modal" data-bs-target="#modal-insumos"
                        data-contexto="editar">
                        <i class="bi bi-plus-circle fs-4"></i>
                        <span>Agregar insumos</span>
                    </a>
                    <!-- Cards de insumos (JS las inserta) -->
                    <div class="row g-3 mb-3" id="div-insumosE"></div>

                    <!-- HISTORIA CLÍNICA -->
                    <h5 class="text-center fw-bold mt-4 mb-3 pt-1">Historia clínica</h5>
                    <div class="campo-custom">
                        <div class="input-custom" style="align-items: flex-start;">
                            <span class="icono-izq pt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                    class="bi bi-journal-text azul" viewBox="0 0 16 16">
                                    <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5
                                    0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5
                                    0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5
                                    0 0 1-.5-.5z"/>
                                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1
                                    0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                                </svg>
                            </span>
                            <textarea name="historialE" class="txt-custom input-validar" rows="5"
                                placeholder="Historial médico del paciente"
                                id="historiaE"></textarea>
                            <span class="icono-der">
                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01
                                    1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0
                                    1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                </svg>
                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5
                                    0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707
                                    l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </span>
                        </div>
                        <p class="error-msg fw-bold p-error-validaciones p-error-cedula d-none"></p>
                    </div>

                    <!-- DIAGNÓSTICO -->
                    <label class="label-custom">Diagnóstico</label>
                    <div class="campo-custom">
                        <div class="input-custom" style="align-items: flex-start;">
                            <span class="icono-izq pt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-heart-pulse-fill azul" viewBox="0 0 16 16">
                                    <path d="M1.475 9C2.702 10.84 4.779 12.871 8 15c3.221-2.129 5.298-4.16
                                    6.525-6H12a.5.5 0 0 1-.464-.314l-1.457-3.642-1.598 5.593a.5.5 0 0
                                    1-.945.049L5.889 6.568l-1.473 2.21A.5.5 0 0 1 4 9z"/>
                                    <path d="M.88 8C-2.427 1.68 4.41-2 7.823 1.143q.09.083.176.171a3 3 0
                                    0 1 .176-.17C11.59-2 18.426 1.68 15.12 8h-2.783l-1.874-4.686a.5.5 0
                                    0 0-.945.049L7.921 8.956 6.464 5.314a.5.5 0 0 0-.88-.091L3.732 8z"/>
                                </svg>
                            </span>
                            <textarea class="txt-custom input-validar" rows="4"
                                placeholder="Diagnóstico del paciente"
                                id="diagnostico" name="diagnostico"></textarea>
                            <span class="icono-der">
                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01
                                    1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0
                                    1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                </svg>
                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5
                                    0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707
                                    l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </span>
                        </div>
                        <p class="error-msg fw-bold p-error-validaciones p-error-cedula d-none"></p>
                    </div>

                </div><!-- /ms-2 me-2 mt-1 -->

                <!-- FOOTER -->
                <div class="modal-footer border-0 d-flex justify-content-end gap-2 pt-2">
                    <button type="button" class="btn btn-modals-cancelar fw-bold rounded-5"
                        data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-modals fw-bold rounded-5" id="btnEH">Guardar</button>
                </div>

            </form>
        </div>
    </div>
</div>
