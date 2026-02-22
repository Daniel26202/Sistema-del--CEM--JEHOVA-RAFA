<?php require_once './src/vistas/head/head.php'; ?>

<input type="hidden" name="id_usuario" id="id_usuario_session" value="<?= $_SESSION['id_usuario'] ?>">


<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">
    <div class="col mt-2">
        <div id="divComentarios" class="ms-3 col-12 d-flex justify-content-center"></div>
    </div>
    <div class="m-auto" style="width: 95%;">
        <div class=" d-flex justify-content-between mb-2">
            <div class=" d-flex align-items-center ">
                <h5 class="fw-bolder ms-3">Hospitalizaciones pendientes</h5>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="color-borde-ventas bi bi-plus-circle ms-1" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                </svg>
            </div>

            <div class="d-flex justify-content-end">
                <div class="fondoPH mb-2 color-letras" id="btnPH" data-bs-toggle="modal" data-bs-target="#modal-agregar-precio-hora">

                    <p class="fw-bolder p-0 pt m-0">Costo por Hora</p>
                    <div class="d-flex justify-content-center">
                        <p class="m-0 p-0" id="horasS">0</p>
                        <p class="m-0 p-0">h.</p>
                        <p class="m-0 pe-1 fw-bolder">=</p>
                    </div>
                    <div class="d-flex justify-content-center">
                        <p class="m-0 p-0" id="costoHS">0</p>
                        <p class="m-0 p-0">bs</p>
                        <p class="m-0 p-0 ps-1 pe-1 fw-bolder">o</p>
                        <p class="m-0 p-0" id="costoHSMoEx">0</p>
                        <p class="m-0 p-0">$</p>
                    </div>

                </div>
            </div>



        </div>

        <div class=" me-5 pe-1 mb-2 mt-3 d-flex justify-content-end w-100">

            <ul class="sin-circulos d-flex justify-content-end">

                <li class="">
                    <div class="borde-de-menu activo-border mb-1"></div>
                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/hospitalizacion"
                        class="text-decoration-none me-3 color-letras" id="DMservicioMedico">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="20" fill="currentColor"
                            class="bi bi-clipboard-pulse me-1 color-activo-svg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M10 1.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5zm-5 0A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5zm-2 0h1v1H3a1 1 0 0 0-1 1V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3.5a1 1 0 0 0-1-1h-1v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2m6.979 3.856a.5.5 0 0 0-.968.04L7.92 10.49l-.94-3.135a.5.5 0 0 0-.895-.133L4.232 10H3.5a.5.5 0 0 0 0 1h1a.5.5 0 0 0 .416-.223l1.41-2.115 1.195 3.982a.5.5 0 0 0 .968-.04L9.58 7.51l.94 3.135A.5.5 0 0 0 11 11h1.5a.5.5 0 0 0 0-1h-1.128z" />
                        </svg>Hospitalizaciones</a>
                </li>
                <li class="li">
                    <div class="borde-de-menu mb-1 color-linea"></div>
                    <div class="hover-grande">
                        <a href="/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/hospitalizacionesRealizadas"
                            class="text-decoration-none me-3 color-letras" id="DMserviciosExtras">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="20" fill="currentColor"
                                class="bi bi-clipboard-check me-1" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                                <path
                                    d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z" />
                                <path
                                    d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z" />
                            </svg>Hospitalizaciones realizadas</a>
                    </div>

                </li>

            </ul>

        </div>
        <div class="comentario  comentarioRed me-4 fw-bolder  text-center d-none" id="alertHEnvF" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p class="pe-2"></p>
        </div>

        <div class="fondo-tabla">

            <div class="d-flex justify-content-between align-items-center">
                <div class="text-start mb-2">

                    <!-- no hay -->
                    <div id="alertaPrecioHora" style="display:none; color:red;">
                        Debe agregar el precio por hora antes de registrar hospitalizaciones.
                    </div>
                    <button class="btn btn-primary btn-agregar-pacientes mb-2" data-bs-toggle="modal"
                        data-bs-target="#modal-agregar-hospitalizacion" id="btnAgregarH">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                            class="bi bi-plus-circle-fill me-1" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                        </svg>
                        Registrar hospitalización
                    </button>

                </div>
                <div class="d-flex justify-content-end mb-3 mt-2 me-2 col-3">
                    <input class="form-control input-busca" type="number" name="" placeholder="Ingrese cédula"
                        id="inputBuscH">
                    <button class="btn boton-buscar" title="Buscar" id="btnBuscH">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class=" table-responsive">

                <table class="table exampleTable table-striped ">
                    <thead>
                        <tr>
                            <th>Cédula</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Diagnostico</th>
                            <th>Doctor asignado</th>


                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <!-- se agrega en el js -->
                    </tbody>
                </table>
                <div id="notificacion" class="text-center d-none">Paciente no encontrado</div>
            </div>

        </div>


    </div>

</div>


<!-- modal consultar -->
<div id="modalCon">
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-mostrarH"
        aria-labelledby="offcanvasMostrarLabel"
        data-bs-backdrop="true" data-bs-scroll="false">

        <!-- HEADER -->
        <div class="offcanvas-header" style="background-color: var(--color-primary);">
            <div class="d-flex align-items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white"
                    class="bi bi-file-text-fill flex-shrink-0" viewBox="0 0 16 16">
                    <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1z" />
                </svg>
                <div>
                    <h5 class="offcanvas-title fw-bold mb-0 text-white" id="offcanvasMostrarLabel">
                        <span id="nombreApellidoM"></span>
                    </h5>
                    <p class="mb-0 text-white" style="font-size:.82rem; opacity:.85;">
                        C.I: <span id="cedulaM"></span>
                    </p>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white"
                data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
        </div>

        <!-- BODY -->
        <div class="offcanvas-body" style="background-color: var(--color-bg-main);">

            <!-- Diagnóstico -->
            <p class="titulo-seccion-offcanvas">
                <i class="bi bi-clipboard2-pulse-fill me-1"></i> Diagnóstico
            </p>
            <div class="caja-diagnostico-offcanvas mb-3">
                <p class="parrafo-offcanvas" id="diagnosticoM"></p>
            </div>

            <!-- Doctor + Horas -->
            <div class="row g-2 mb-3">
                <div class="col-7">
                    <p class="titulo-seccion-offcanvas">
                        <i class="bi bi-person-badge-fill me-1"></i> Doctor asignado
                    </p>
                    <div class="caja-diagnostico-offcanvas h-auto">
                        <p class="parrafo-offcanvas" id="doctorM"></p>
                    </div>
                </div>
                <div class="col-5">
                    <p class="titulo-seccion-offcanvas">
                        <i class="bi bi-clock-fill me-1"></i> Tiempo
                    </p>
                    <div class="caja-diagnostico-offcanvas h-auto text-center">
                        <p class="parrafo-offcanvas fw-bold" id="hHosM"></p>
                    </div>
                </div>
            </div>

            <!-- Historia clínica -->
            <p class="titulo-seccion-offcanvas">
                <i class="bi bi-journal-medical me-1"></i> Historia clínica
            </p>
            <div class="caja-diagnostico-offcanvas mb-3">
                <p class="parrafo-offcanvas" id="historiaM"></p>
            </div>

            <!-- Montos -->
            <div class="row g-2 mb-3">
                <div class="col-6">
                    <p class="titulo-seccion-offcanvas">
                        <i class="bi bi-calculator me-1"></i> Monto/hora
                    </p>
                    <div class="caja-diagnostico-offcanvas h-auto text-center d-flex align-items-center">
                        <p class="parrafo-offcanvas fw-bold fs-5 mb-0" id="cMontoHoraM"></p>
                        <small class="parrafo-offcanvas mt-1 ms-2" style="opacity:.6; font-size:.75rem;">Bs</small>
                    </div>
                </div>
                <div class="col-6">
                    <p class="titulo-seccion-offcanvas">
                        <i class="bi bi-currency-dollar me-1"></i> Moneda ext.
                    </p>
                    <div class="caja-diagnostico-offcanvas h-auto text-center d-flex align-items-center">
                        <p class="parrafo-offcanvas fw-bold fs-5 mb-0" id="cMoHoraMoExM"></p>
                        <small class="parrafo-offcanvas mt-1 ms-2" style="opacity:.6; font-size:.75rem;">$</small>
                    </div>
                </div>
            </div>

            <!-- Total solo admin -->
            <?php if ($validacionCargo == 0) : ?>
                <p class="titulo-seccion-offcanvas">
                    <i class="bi bi-receipt me-1"></i> Total estimado
                </p>
                <div class="caja-diagnostico-offcanvas">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="parrafo-offcanvas">En bolívares</span>
                        <span class="parrafo-offcanvas fw-bold">
                            <span id="calculoTotal"></span>
                            <small style="opacity:.6;"> Bs</small>
                        </span>
                    </div>
                    <hr style="border-color: var(--color-border); margin:.5rem 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="parrafo-offcanvas">En dólares</span>
                        <span class="parrafo-offcanvas fw-bold">
                            <span id="calculoTotalME"></span>
                            <small style="opacity:.6;"> $</small>
                        </span>
                    </div>
                </div>
            <?php endif ?>

        </div>
    </div>
</div>








<div class="modal fade" id="modalEnvioFacturaHospitalizacion" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content tamaño-modal">

            <div class="modal-header">
                <h5 class="modal-title fs-4 fw-bold">Informe de alta médica</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form class="form-validable" id="formEnvioFacturaHospitalizacion">

                <!-- Hidden inputs -->
                <input type="hidden" name="idH" id="idH">
                <input type="hidden" name="monto" id="monto">
                <input type="hidden" name="montoME" id="montoME">
                <input type="hidden" name="total" id="total">
                <input type="hidden" name="totalME" id="totalME">

                <div class="modal-body">

                    <!-- Historia Clínica -->
                    <label class="label-custom">Historia clínica</label>
                    <div class="campo-custom">
                        <div class="input-custom">
                            <span class="icono-izq">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-journal-text azul" viewBox="0 0 16 16">
                                    <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                                </svg>
                            </span>
                            <textarea name="historialEnF" class="form-control txt-custom inputs input-validar"
                                placeholder="Historia clínica" style="height: 80px;"
                                id="historiaEnF"></textarea>
                            <span class="icono-der">
                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"></path>
                                </svg>
                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                                </svg>
                            </span>

                        </div>
                        <p class="error-msg fw-bold p-error-validaciones d-none">Por favor, ingrese la historia clínica.</p>
                    </div>

                    <!-- Síntomas -->
                    <label class="label-custom">Síntomas</label>
                    <div class="accordion mb-2" id="accordionSintomasF">
                        <div class="accordion-item bg-theme">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-theme" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseSintomasF"
                                    aria-expanded="true">
                                    Síntomas
                                </button>
                            </h2>
                            <div id="collapseSintomasF" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <?php if ($datosS): ?>
                                        <?php foreach ($datosS as $sintomas): ?>
                                            <div class="form-check form-switch d-flex align-items-center mb-1">
                                                <input class="form-check-input inputExpresiones inpSin me-2"
                                                    type="checkbox" role="switch"
                                                    name="sintomas[]"
                                                    value="<?= $sintomas["id_sintomas"]; ?>">
                                                <label class="form-check-label mt-1">
                                                    <?= $sintomas['nombre']; ?>
                                                </label>
                                            </div>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <p>NO HAY REGISTROS</p>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Patologías -->
                    <label class="label-custom">Patologías del paciente</label>
                    <div class="accordion mb-2" id="accordionPatologiasF">
                        <div class="accordion-item bg-theme">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-theme" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapsePatologiasF"
                                    aria-expanded="true">
                                    Patologías
                                </button>
                            </h2>
                            <div id="collapsePatologiasF" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <div class="d-flex justify-content-center mb-3">
                                        <input type="button"
                                            class="btn btn-outline-secondary fw-bold btnNin col-12"
                                            value="Ninguno">
                                    </div>
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <?php foreach ($datosPatologias as $patologia): ?>
                                            <div class="d-flex w-50 justify-content-between mb-2">
                                                <div class="form-check form-switch d-flex align-items-center">
                                                    <input class="form-check-input inputExpresiones inputPP checkInputs me-2"
                                                        type="checkbox" role="switch"
                                                        name="patologias[]"
                                                        value="<?php echo $patologia['id_patologia'] ?>">
                                                    <label class="form-check-label mt-2">
                                                        <?php echo $patologia['nombre_patologia'] ?>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nota -->
                    <label class="label-custom">Nota <span class="text-muted fw-normal">(opcional)</span></label>
                    <div class="campo-custom">
                        <div class="input-custom">
                            <span class="icono-izq">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-heart-pulse-fill azul" viewBox="0 0 16 16">
                                    <path d="M1.475 9C2.702 10.84 4.779 12.871 8 15c3.221-2.129 5.298-4.16 6.525-6H12a.5.5 0 0 1-.464-.314l-1.457-3.642-1.598 5.593a.5.5 0 0 1-.945.049L5.889 6.568l-1.473 2.21A.5.5 0 0 1 4 9z" />
                                    <path d="M.88 8C-2.427 1.68 4.41-2 7.823 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C11.59-2 18.426 1.68 15.12 8h-2.783l-1.874-4.686a.5.5 0 0 0-.945.049L7.921 8.956 6.464 5.314a.5.5 0 0 0-.88-.091L3.732 8z" />
                                </svg>
                            </span>
                            <textarea class="form-control txt-custom inputs" name="nota"
                                placeholder="La nota es opcional" style="height: 50px;"></textarea>
                            <span class="icono-der">
                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"></path>
                                </svg>
                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                                </svg>
                            </span>
                        </div>
                        <p class="error-msg fw-bold p-error-validaciones d-none"></p>

                    </div>

                    <!-- Prescripciones e Indicaciones -->
                    <label class="label-custom">Prescripciones e indicaciones</label>
                    <div class="campo-custom">
                        <div class="input-custom">
                            <span class="icono-izq">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-receipt-cutoff azul" viewBox="0 0 16 16">
                                    <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5M11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z" />
                                    <path d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118z" />
                                </svg>
                            </span>
                            <textarea class="form-control txt-custom inputs input-validar"
                                name="indicaciones" placeholder="Prescripciones e indicaciones"
                                style="height: 50px;"></textarea>
                            <span class="icono-der">
                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                </svg>
                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </span>
                        </div>
                        <p class="error-msg fw-bold p-error-validaciones d-none">Por favor, ingrese las indicaciones.</p>
                    </div>

                    <!-- Fecha de revisión -->
                    <label class="label-custom">Fecha de revisión médica</label>
                    <div class="campo-custom">
                        <div class="input-custom">
                            <span class="icono-izq">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-calendar-date-fill azul" viewBox="0 0 16 16">
                                    <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zm5.402 9.746c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2" />
                                    <path d="M16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-6.664-1.21c-1.11 0-1.656-.767-1.703-1.407h.683c.043.37.387.82 1.051.82.844 0 1.301-.848 1.305-2.164h-.027c-.153.414-.637.79-1.383.79-.852 0-1.676-.61-1.676-1.77 0-1.137.871-1.809 1.797-1.809 1.172 0 1.953.734 1.953 2.668 0 1.805-.742 2.871-2 2.871zm-2.89-5.435v5.332H5.77V8.079h-.012c-.29.156-.883.52-1.258.777V8.16a13 13 0 0 1 1.313-.805h.632z" />
                                </svg>
                            </span>
                            <input class="form-control txt-custom input-validar inputs grp_control_fechaRegreso"
                                type="date" name="fechaDeCita"
                                uk-tooltip="title: Fecha de revisión médica; pos: right">
                            <span class="icono-der">
                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                </svg>
                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </span>
                        </div>
                        <!-- leyenda fecha (se muestra con JS igual que antes) -->
                        <p class="error-msg fw-bold p-error-validaciones d-none" id="leyendaFec">
                            El formato de la fecha es incorrecto. Debe ser mayor que la fecha de hoy y no debe exceder los 50 años en el futuro.
                        </p>
                    </div>

                    <!-- Severidad -->
                    <label class="label-custom">Severidad</label>
                    <div class="campo-custom">
                        <div class="input-custom">
                            <span class="icono-izq">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-heart-pulse-fill azul" viewBox="0 0 16 16">
                                    <path d="M1.475 9C2.702 10.84 4.779 12.871 8 15c3.221-2.129 5.298-4.16 6.525-6H12a.5.5 0 0 1-.464-.314l-1.457-3.642-1.598 5.593a.5.5 0 0 1-.945.049L5.889 6.568l-1.473 2.21A.5.5 0 0 1 4 9z" />
                                    <path d="M.88 8C-2.427 1.68 4.41-2 7.823 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C11.59-2 18.426 1.68 15.12 8h-2.783l-1.874-4.686a.5.5 0 0 0-.945.049L7.921 8.956 6.464 5.314a.5.5 0 0 0-.88-.091L3.732 8z" />
                                </svg>
                            </span>
                            <select class="form-control txt-custom select-custom input-validar" id="severidadEnF" name="severidad" required>
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
                        <p class="error-msg fw-bold p-error-validaciones d-none"> </p>
                    </div>

                    <!-- Diagnóstico -->
                    <label class="label-custom">Diagnóstico</label>
                    <div class="campo-custom">
                        <div class="input-custom">
                            <span class="icono-izq">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-clipboard2-pulse-fill azul" viewBox="0 0 16 16">
                                    <path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5" />
                                    <path d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585c.055.156.085.325.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5c0-.175.03-.344.085-.5M9.98 5.356 11.372 8H12a.5.5 0 0 1 0 1h-.75a.5.5 0 0 1-.447-.276L9.97 6.68l-1.475 4.425a.5.5 0 0 1-.93.049L6.44 8.884l-.902 1.127A.5.5 0 0 1 5.15 10H4a.5.5 0 0 1 0-1h.846L6.3 7.116a.5.5 0 0 1 .932.08l.87 2.175" />
                                </svg>
                            </span>
                            <textarea class="form-control txt-custom inputs input-validar"
                                placeholder="Diagnóstico" style="height: 50px;"
                                id="diagnosticoEnF" name="diagnostico"></textarea>
                            <span class="icono-der">
                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                </svg>
                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </span>
                        </div>
                        <p class="error-msg fw-bold p-error-validaciones d-none">Por favor, ingrese el diagnóstico.</p>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-modals-cancelar me-2" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-modals" data-bs-dismiss="modal">Ir a facturar</button>
                </div>

            </form>
        </div>
    </div>
</div>





























<div id="div-oculto">
    <!-- js -->
</div>


<script type="module" src="<?= $urlBase ?>../src/assets/js/hospitalizacion/reutilizableHospitalizacion.js"></script>
<script type="module" src="<?= $urlBase ?>../src/assets/js/hospitalizacion/hospitalizacionAgregar.js"></script>
<script type="module" src="<?= $urlBase ?>../src/assets/js/hospitalizacion/hospitalizacionEditar.js"></script>

<?php require_once './src/vistas/head/footer.php'; ?>
<?php require_once './src/vistas/vistaPacientes/modalAgregarPaciente.php'; ?>
<?php require_once './src/vistas/vistaHospitalizacion/modal/modalAgregarPacientes.php'; ?>
<?php require_once './src/vistas/vistaHospitalizacion/modal/modalEditarHospitalizacion.php'; ?>
<?php require_once './src/vistas/vistaHospitalizacion/modal/modalEliminarHospitalizacion.php'; ?>

<?php require_once './src/vistas/vistaHospitalizacion/modal/modalEditarInsumos.php'; ?>
<?php require_once './src/vistas/vistaHospitalizacion/modal/modalAgregarInsumos.php'; ?>
<?php require_once './src/vistas/vistaHospitalizacion/modal/modalPrecioHora.php'; ?>