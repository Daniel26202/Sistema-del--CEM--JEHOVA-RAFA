<?php require_once './src/vistas/head/head.php'; ?>

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

                    <?php if (!$this->permisos($_SESSION["id_rol"], "guardar", "Hospitalizacion")): ?>
                        <!-- no hay -->
                    <?php else: ?>
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
                    <?php endif ?>

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

                            <?php if ($_SESSION['rol'] == "usuario"): ?>
                                <!-- no hay -->
                            <?php endif ?>

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
    <!-- modal off-canvas que sale a la derecha  (CONSULTA)-->
    <div id="offcanvas-mostrarH"
        uk-offcanvas="esc-close: false; mode: reveal; flip: true; overlay: true">
        <div class="uk-offcanvas-bar">

            <button class="uk-offcanvas-close" id="closeModal" type="button" uk-close></button>

            <div class="d-flex align-items-start">

                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                    class="bi bi-file-text-fill me-1 pt-1 text-white col-1" viewBox="0 0 16 16">
                    <path
                        d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1zm0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1z" />
                </svg>
                <h3 class="fw-bold" id="nombreApellidoM">
                    <!-- se agrega en el js -->
                </h3>

            </div>
            <div class="d-flex align-items-start">

                <h4 class="fw-bold me-2 ">C.I:</h4>
                <p class="fw-bold fs-5 ce" id="cedulaM">
                    <!-- se agrega en el js -->
                </p>

            </div>

            <div class="d-flex align-items-start mt-4 mb-3 ">
                <div class="col-12">
                    <h4 class="text-center fw-bold text">Diagnostico</h4>
                    <p class="parrafo-offcanvas" id="diagnosticoM">
                        <!-- se agrega en el js -->
                    </p>
                </div>
            </div>

            <div class="d-flex align-items-start mb-2 ">
                <div class="col-5">
                    <h4 class=" fw-bold text">Doctor asignado</h4>
                    <p class="parrafo-offcanvas" id="doctorM">
                        <!-- se agrega en el js -->
                    </p>
                </div>

                <p class="col-2"></p> <!-- solo separación -->
                <div>
                    <h4 class="text-center fw-bold ">Horas de hospitaliza- ción</h4>
                    <p class="parrafo-offcanvas fs-5 text-center" id="hHosM"></p>
                </div>
            </div>

            <div class="mt-1">

            </div>

            <div>
                <h4 class="text-center fw-bold">Historia clínica</h4>
                <p class="parrafo-offcanvas text-center" id="historiaM">
                    <!-- se agrega en el js -->
                </p>
            </div>

            <div class="d-flex align-items-start mb-2 ">
                <div class="col-5">
                    <h4 class=" fw-bold text">Calculo de monto por hora</h4>
                    <div class="d-flex justify-content-center align-items-center text-center">
                        <p class="parrafo-offcanvas fw-bold fs-5" id="cMontoHoraM">
                            <!-- se agrega en el js -->
                        </p>
                        <p class="parrafo-offcanvas fw-bold fs-5">bs</p>
                    </div>

                </div>

                <p class="col-2"></p> <!-- solo separación -->
                <div>
                    <h4 class="text-center fw-bold ">Calculo a moneda extranjera</h4>
                    <div class="d-flex align-items-center justify-content-center text-center">
                        <p class="parrafo-offcanvas fs-5 " id="cMoHoraMoExM"></p>
                        <p class="parrafo-offcanvas fw-bold fs-5">$</p>
                    </div>
                </div>
            </div>

            <!-- verifico si es administrador o usuario -->
            <!-- uno es doctor -->
            <?php if ($validacionCargo == 1) : ?>
                <!--no hay-->
            <?php endif ?>

            <!-- verifico si es administrador o usuario -->
            <!-- cero es administrador más no doctor -->
            <?php if ($validacionCargo == 0) : ?>
                <div class="d-flex align-items-start mt-5">

                    <h4 class="fw-bold me-2 ">Cálculo del total:</h4>
                    <div class="">
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <p class="fw-bold fs-5" id="calculoTotal">${res.total}bs</p>
                            <p class="fw-bold fs-5">bs</p>
                        </div>

                        <h4 class="fw-bold text-center">o</h4>
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <p class="fw-bold fs-5" id="calculoTotalME">${res.total}bs</p>
                            <p class="fw-bold fs-5">$</p>
                        </div>
                    </div>

                </div>
            <?php endif ?>

        </div>
    </div>
    <!-- los modales se agregan en js -->
</div>




<div class="modal fade " id="modalEnvioFacturaHospitalizacion" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog uk-offcanvas-container" id="">
        <div class="modal-content rounded-4 pt-3 pb-3 pe-5 ps-5 hospit">
            <div class=" d-flex justify-content-between align-items-center mt-2 pt-0">

                <div class=" d-flex justify-content-center align-items-center ">

                    <h4 class=" fw-bold ">Informe de alta médica</h4>
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
            <div class="">
                <form class="" id="formEnvioFacturaHospitalizacion">

                    <div>
                        <div class="mt-4 pt-2">
                            <h4 class="text-center fw-bold">Historia clínica</h4>

                            <div class="uk-margin">
                                <textarea name="historialEnF" class="uk-textarea" rows="5" placeholder="Textarea"
                                    aria-label="Textarea" id="historiaEnF"></textarea>
                            </div>
                        </div>

                        <!-- acordion Sintomas -->
                        <div class="input-modal">
                            <ul uk-accordion="multiple: true">
                                <li class="uk-open">
                                    <a class="uk-accordion-title text-decoration-none" href="#">

                                        <h6 class="acordion-paciente"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                height="20" fill="currentColor" class="bi bi-person-fill azul me-2 mb-2"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                            </svg>Síntomas</h6>
                                    </a>
                                    <div class="uk-accordion-content">


                                        <?php if ($datosS): ?>
                                            <?php foreach ($datosS as $sintomas): ?>

                                                <div class="form-check form-switch d-flex align-items-center">
                                                    <div>
                                                        <input class="form-check-input inputExpresiones inpSin" type="checkbox"
                                                            role="switch" id="flexSwitchCheckDefault" name="sintomas[]"
                                                            value="<?= $sintomas["id_sintomas"]; ?>">
                                                    </div>
                                                    <div>
                                                        <label class="form-check-label mt-1" for="flexSwitchCheckDefault">
                                                            <?= $sintomas['nombre']; ?>
                                                        </label>
                                                    </div>

                                                </div>

                                            <?php endforeach ?>
                                        <?php else: ?>
                                            <p>NO HAY REGISTROS</p>

                                        <?php endif ?>


                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- patologías -->
                        <div class="input-modal mt-3">
                            <ul uk-accordion="multiple: true">
                                <li class="uk-open">
                                    <a class="uk-accordion-title text-decoration-none" href="#">

                                        <h6 class="acordion-paciente fw-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                                class="bi bi-calendar2-week-fill azul mb-2" viewBox="0 0 16 16">
                                                <path
                                                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zM8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z" />
                                            </svg>
                                            Añadir Patología Paciente
                                        </h6>
                                    </a>


                                    <div class="uk-accordion-content">
                                        <div class="d-flex justify-content-center">

                                            <input type="button" class="btn btn-outline-secondary fw-bold btnNin col-12 mb-3" value="Ninguno">
                                        </div>
                                        <div class="d-flex justify-content-between flex-wrap">
                                            <?php foreach ($datosPatologias as $patologia): ?>

                                                <div class="d-flex w-50 justify-content-between mb-3">

                                                    <div class="form-check form-switch d-flex align-items-center">
                                                        <div>
                                                            <input class="form-check-input inputExpresiones inputPP checkInputs" type="checkbox"
                                                                role="switch" id="flexSwitchCheckDefault" name="patologias[]"
                                                                value="<?php echo $patologia['id_patologia'] ?>">
                                                        </div>
                                                        <div>
                                                            <label class="form-check-label mt-2" for="flexSwitchCheckDefault">
                                                                <?php echo $patologia['nombre_patologia'] ?>
                                                            </label>
                                                        </div>

                                                    </div>


                                                </div>
                                            <?php endforeach ?>


                                        </div>

                                    </div>
                                </li>
                            </ul>

                        </div>

                        <!-- nota -->
                        <div class="form-floating input-modal">
                            <textarea class="form-control border-0 input-modal input-modal-remove"
                                placeholder="Leave a comment here" id="floatingTextarea2" style="height: 50px;"
                                name="nota"></textarea>
                            <label for="floatingTextarea2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                    class="bi bi-heart-pulse-fill azul me-2" viewBox="0 0 16 16">
                                    <path
                                        d="M1.475 9C2.702 10.84 4.779 12.871 8 15c3.221-2.129 5.298-4.16 6.525-6H12a.5.5 0 0 1-.464-.314l-1.457-3.642-1.598 5.593a.5.5 0 0 1-.945.049L5.889 6.568l-1.473 2.21A.5.5 0 0 1 4 9z" />
                                    <path
                                        d="M.88 8C-2.427 1.68 4.41-2 7.823 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C11.59-2 18.426 1.68 15.12 8h-2.783l-1.874-4.686a.5.5 0 0 0-.945.049L7.921 8.956 6.464 5.314a.5.5 0 0 0-.88-.091L3.732 8z" />
                                </svg>Nota</label>
                        </div>

                        <div class="form-floating input-modal">
                            <textarea class="form-control border-0 input-modal inputExpresiones input-modal-remove"
                                name="indicaciones" placeholder="Leave a comment here" id="floatingTextarea2"
                                style="height: 50px;"></textarea>
                            <label for="floatingTextarea2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                    class="bi bi-receipt-cutoff azul me-1" viewBox="0 0 16 16">
                                    <path
                                        d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5M11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z" />
                                    <path
                                        d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118z" />
                                </svg>
                                </svg>Prescripciones e indicaciones</label>
                        </div>

                        <div class="mt-4">
                            <p class=" p-0 m-0 fw-bolder text-center">Fecha de revisión médica</p>

                            <div class="input-group flex-nowrap mt-1">
                                <span class="input-modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-calendar-date-fill azul" viewBox="0 0 16 16">
                                        <path
                                            d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zm5.402 9.746c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2" />
                                        <path
                                            d="M16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-6.664-1.21c-1.11 0-1.656-.767-1.703-1.407h.683c.043.37.387.82 1.051.82.844 0 1.301-.848 1.305-2.164h-.027c-.153.414-.637.79-1.383.79-.852 0-1.676-.61-1.676-1.77 0-1.137.871-1.809 1.797-1.809 1.172 0 1.953.734 1.953 2.668 0 1.805-.742 2.871-2 2.871zm-2.89-5.435v5.332H5.77V8.079h-.012c-.29.156-.883.52-1.258.777V8.16a13 13 0 0 1 1.313-.805h.632z" />
                                    </svg>
                                </span>
                                <input
                                    class="form-control input-modal grp_control_fechaRegreso inputExpresiones input-modal-remove"
                                    type="date" name="fechaRegreso" placeholder="Fecha"
                                    uk-tooltip="title: Fecha de revisión médica; pos: right" require>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center pe-3 ps-1 d-none" id="leyendaFec">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-info-circle azul me-1" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z">
                                </path>
                                <path
                                    d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z">
                                </path>
                            </svg>
                            <i>El formato de la fecha es incorrecto. Debe ser mayor que la fecha de hoy y no debe exceder los 50
                                años en el futuro.
                            </i>
                        </div>



                        <div class="mb-3">
                            <label for="severidad" class="form-label col-12 text-center fw-bold">Severidad</label>
                            <select class="form-select" id="severidadEnF" name="severidad" required>
                                <option value="LEVE">Leve</option>
                                <option value="MODERADA">Moderada</option>
                                <option value="GRAVE">Grave</option>
                            </select>
                        </div>

                        <div class="form-floating input-modal mt-3">
                            <textarea class="form-control border-0 input-modal inputExpresiones input-modal-remove" rows="5"
                                placeholder="Diagnóstico" id="diagnosticoEnF"
                                name="diagnostico"></textarea>
                            <label for="diagnostico">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                    class="bi bi-heart-pulse-fill azul me-2" viewBox="0 0 16 16">
                                    <path
                                        d="M1.475 9C2.702 10.84 4.779 12.871 8 15c3.221-2.129 5.298-4.16 6.525-6H12a.5.5 0 0 1-.464-.314l-1.457-3.642-1.598 5.593a.5.5 0 0 1-.945.049L5.889 6.568l-1.473 2.21A.5.5 0 0 1 4 9z" />
                                    <path
                                        d="M.88 8C-2.427 1.68 4.41-2 7.823 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C11.59-2 18.426 1.68 15.12 8h-2.783l-1.874-4.686a.5.5 0 0 0-.945.049L7.921 8.956 6.464 5.314a.5.5 0 0 0-.88-.091L3.732 8z" />
                                </svg>Diagnóstico</label>
                        </div>

                    </div>

                    <div>
                        <input type="hidden" name="idH" id="idH">
                        <input type="hidden" name="monto" id="monto">
                        <input type="hidden" name="montoME" id="montoME">
                        <input type="hidden" name="total" id="total">
                        <input type="hidden" name="totalME" id="totalME">
                    </div>

                    <p class="uk-text-center mt-4 ">
                        <button class="uk-button rounded-5 btn-cancelar fw-bold" type="button"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button class="uk-button uk-button-primary rounded-5 ms-2 fw-bold" type="submit"
                            data-bs-dismiss="modal">Ir a facturar</button>
                    </p>


                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/hospitalizacion/reutilizableHospitalizacion.js"></script>
<script type="text/javascript"
    src="<?= $urlBase ?>../src/assets/js/hospitalizacion/validacioneshospitalizacion.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/hospitalizacion/hospitalizacionAgregar.js"></script>
<script type="module" src="<?= $urlBase ?>../src/assets/js/hospitalizacion/hospitalizacionEditar.js"></script>

<?php require_once './src/vistas/head/footer.php'; ?>
<?php require_once './src/vistas/vistaPacientes/modalAgregarPaciente.php'; ?>
<?php require_once './src/vistas/vistaHospitalizacion/modal/modalAgregarPacientes.php'; ?>
<?php require_once './src/vistas/vistaHospitalizacion/modal/modalEditarHospitalizacion.php'; ?>
<?php require_once './src/vistas/vistaHospitalizacion/modal/modalEliminarHospitalizacion.php'; ?>

<?php require_once './src/vistas/vistaHospitalizacion/modal/modalEditarInsumos.php'; ?>
<?php require_once './src/vistas/vistaHospitalizacion/modal/modalAgregarInsumos.php'; ?>
<?php require_once './src/vistas/vistaHospitalizacion/modal/modalPrecioHora.php'; ?>