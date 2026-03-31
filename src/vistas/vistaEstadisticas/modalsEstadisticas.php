<!-- Reporte d insumos -->
<!-- Modal Reporte de Insumos -->
<div class="modal fade" id="reporteInsumos" tabindex="-1" aria-labelledby="reporteInsumosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content contenido">
            <div class="imprimir" id="imprimirInsumos">
                <div class="cabecera" style="display:flex; justify-content: space-between; background-color: #397ae0; color: white; padding: 10px;">
                    <div class="icon">
                        <img
                            src="<?= $urlBase ?>../src/assets/images/icons/logo.png"
                            alt="Logo"
                            class="logo"
                            style="width: 290px; height: 100px; margin-left: 20px;" />
                    </div>
                    <div id="fecha" style="display: flex; align-items: center; padding-right: 20px; color: white !important;">
                        <?php echo date("d-m-Y"); ?>
                    </div>
                </div>
                <div class="contenido content-modal" style="display: flex; flex-direction: column;  padding: 20px;">
                    <div class="titulo">
                        <h1>Reporte de Insumos Más Usados</h1>
                    </div>

                    <!-- Canvas para el gráfico -->
                    <div class="canva contenido" style="margin: 20px 0;">
                        <canvas id="insumos_canva_pdf"></canvas>
                    </div>

                    <h5 class="texto" id="textoInsumos" style="width: 90%; text-align: center; font-size: 14px;">
                    </h5>
                </div>
            </div>

            <!-- Botones del modal -->
            <div class="d-flex justify-content-center mb-3">
                <button id="descargarInsumos" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>


<!-- modal reporte especialidades-->
<div class="modal fade" id="reporte" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content contenido">
            <div class="imprimir" id="imprimir">
                <div class="cabecera" style="display:flex; justify-content: space-between; background-color: #397ae0; color: white; padding: 10px;">
                    <div class="icon">
                        <img
                            src="<?= $urlBase ?>../src/assets/images/icons/logo.png"
                            alt="Logo"
                            class="logo"
                            style="width: 290px; height: 100px; margin-left: 20px;" />
                    </div>
                    <div id="fecha" style="display: flex; align-items: center; padding-right: 20px;     color: white !important;">
                        <?php echo date("d-m-Y"); ?>
                    </div>
                </div>
                <div class="contenido content-modal" style="display: flex; flex-direction: column; align-items: center; padding: 20px;">
                    <div class="titulo" id="titulo">
                        <h1>Reporte de Especialidades Más Solicitadas</h1>
                    </div>

                    <!-- filtro de busqueda -->

                    <div class="canva contenido" style="margin: 20px 0;">
                        <canvas class="contenido" id="especialidades_solicitadas_pdf" width="400" height="400"></canvas>
                    </div>
                    <div class="leyenda-container reporte" style="width: 80%; margin: 20px 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
                    </div>
                    <h5 class="texto reporte" id="texto" style="width: 90%; text-align: justify; font-size: 14px;">


                    </h5>

                </div>
            </div>
            <div class="alertEspecialidades">

            </div>

            <div class="alert alert-primary text-center d-none alert-no-encontrado">No se encontraron datos en dicho periodo de tiempo</div>

            <h5 class="mt-4 text-center">Filtrar la Grafica Segun un Periodo de Tiempo</h5>

            <div class=" d-flex justify-content-between modal-body" id="buscadoresEspecialidades">
                <div class="col-5">
                    <label class="label-custom">Fecha de Inicio</label>
                    <div class="campo-custom">
                        <div class="input-custom">
                            <span class="icono-izq">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
                                    <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
                                </svg>
                            </span>
                            <input class="form-control txt-custom input-validar inputs" type="date" name="fn1">
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

                <div class="col-5">
                    <label class="label-custom">Fecha Final</label>
                    <div class="campo-custom">
                        <div class="input-custom">
                            <span class="icono-izq">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
                                    <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
                                </svg>
                            </span>
                            <input class="form-control txt-custom input-validar inputs" type="date" name="fn2">
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


            <div class="d-flex justify-content-center mb-3">
                <button id="especialidades" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                    </svg></button>
            </div>
        </div>
    </div>
</div>


<!-- modal reporte sintomas-->
<div class="modal fade" id="reporteSintomas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content contenido">
            <div class="imprimir" id="imprimirSintomas">
                <div class="cabecera" style="display:flex; justify-content: space-between; background-color: #397ae0; color: white; padding: 10px;">
                    <div class="icon">
                        <img
                            src="<?= $urlBase ?>../src/assets/images/icons/logo.png"
                            alt="Logo"
                            class="logo"
                            style="width: 290px; height: 100px; margin-left: 20px;" />
                    </div>
                    <div id="" style="display: flex; align-items: center; padding-right: 20px;     color: white !important;">
                        <?php echo date("d-m-Y"); ?>
                    </div>
                </div>
                <div class="contenido content-modal" style="display: flex; flex-direction: column; align-items: center; padding: 20px;">
                    <div class="titulo">
                        <h1>Reporte de los 5 Sintomas Más Comunes</h1>
                    </div>

                    <!-- filtro de busqueda -->

                    <div class="canva contenido" style="margin: 20px 0;">
                        <canvas class="contenido" id="sintomas_solicitadas_pdf" width="400" height="400"></canvas>
                    </div>
                    <div class="leyenda-sintomas-container" style="width: 80%; margin: 20px 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
                    </div>
                    <h5 class="texto" id="textoSintomas" style="width: 90%; text-align: justify; font-size: 14px;">
                    </h5>

                </div>
            </div>

            <div class="alert alert-primary text-center d-none alert-no-encontrado-s">No se encontraron datos en dicho periodo de tiempo</div>

            <h5 class="mt-4 text-center">Filtrar la Grafica Segun un Periodo de Tiempo</h5>

            <div class=" d-flex justify-content-between modal-body" id="buscadoresSintomas">
                <div class="col-5">
                    <label class="label-custom">Fecha de Inicio</label>
                    <div class="campo-custom">
                        <div class="input-custom">
                            <span class="icono-izq">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
                                    <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
                                </svg>
                            </span>
                            <input class="form-control txt-custom input-validar inputs" type="date" name="fn1">
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

                <div class="col-5">
                    <label class="label-custom">Fecha Final</label>
                    <div class="campo-custom">
                        <div class="input-custom">
                            <span class="icono-izq">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
                                    <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
                                </svg>
                            </span>
                            <input class="form-control txt-custom input-validar inputs" type="date" name="fn2">
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


            <div class="d-flex justify-content-center mb-3">
                <button id="sintomas" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                    </svg></button>
            </div>
        </div>
    </div>
</div>





<!-- modal reporte pacientes-->
<div class="modal fade" id="reporteDistribucionPacientes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content contenido">
            <div class="imprimir" id="imprimirPacientes">
                <div class="cabecera" style="display:flex; justify-content: space-between; background-color: #397ae0; color: white; padding: 10px;">
                    <div class="icon">
                        <img
                            src="<?= $urlBase ?>../src/assets/images/icons/logo.png"
                            alt="Logo"
                            class="logo"
                            style="width: 290px; height: 100px; margin-left: 20px;" />
                    </div>
                    <div id="" style="display: flex; align-items: center; padding-right: 20px;     color: white !important;">
                        <?php echo date("d-m-Y"); ?>
                    </div>
                </div>
                <div class="contenido content-modal" style="display: flex; flex-direction: column; padding: 20px;">
                    <div class="titulo">
                        <h1 class="text-center">Reporte de la distribución de pacientes</h1>
                    </div>

                    <!-- filtro de busqueda -->

                    <div class="canva contenido" style="margin: 20px 0;">
                        <canvas class="contenido" id="pacientes_pdf" width="400" height="400"></canvas>
                    </div>
                    <div class="leyenda-pacientes-container" style="width: 80%; margin: 20px 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
                    </div>
                    <h5 class="texto" id="textoPacientes" style="width: 90%; text-align: justify; font-size: 14px;">
                    </h5>

                </div>
            </div>


            <div class="d-flex justify-content-center mb-3">
                <button id="pacientes" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                    </svg></button>
            </div>
        </div>
    </div>
</div>


<!-- modal reporte pacientes morbilidad-->
<div class="modal fade" id="reporteTasaMorbilidad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content contenido">
            <div class="imprimir" id="imprimirMorbilidad">
                <div class="cabecera" style="display:flex; justify-content: space-between; background-color: #397ae0; color: white; padding: 10px;">
                    <div class="icon">
                        <img
                            src="../src/assets/images/icons/logo.png"
                            alt="Logo"
                            class="logo"
                            style="width: 290px; height: 100px; margin-left: 20px;" />
                    </div>
                    <div id="" style="display: flex; align-items: center; padding-right: 20px;     color: white !important;">
                        <?php echo date("d-m-Y"); ?>
                    </div>
                </div>
                <div class="contenido content-modal" style="display: flex; flex-direction: column; padding: 20px;">
                    <div class="titulo">
                        <h1 class="text-center">Reporte de Tasa de morbilidad</h1>
                    </div>

                    <!-- filtro de busqueda -->

                    <div class="canva contenido" style="margin: 20px 0;">
                        <canvas class="contenido canvas-modal" id="morbilidad_pdf" width="300" height="300"></canvas>
                    </div>
                    <div class="leyenda-morbilidad-container" style="width: 80%; margin: 20px 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
                    </div>
                    <h5 class="texto" id="textoMorbilidad" style="width: 90%; text-align: justify; font-size: 14px;">
                    </h5>

                </div>
            </div>

            <div class="alert alert-primary text-center d-none alert-no-encontrado-m">No se encontraron datos en dicho periodo de tiempo</div>

            <h5 class="mt-4 text-center">Filtrar la Grafica Segun un Periodo de Tiempo</h5>

            <div class=" d-flex justify-content-between modal-body" id="buscadoresMorbilidad">
                <div class="col-5">
                    <label class="label-custom">Fecha de Inicio</label>
                    <div class="campo-custom">
                        <div class="input-custom">
                            <span class="icono-izq">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
                                    <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
                                </svg>
                            </span>
                            <input class="form-control txt-custom input-validar inputs" type="date" name="fn1">
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

                <div class="col-5">
                    <label class="label-custom">Fecha Final</label>
                    <div class="campo-custom">
                        <div class="input-custom">
                            <span class="icono-izq">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
                                    <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
                                </svg>
                            </span>
                            <input class="form-control txt-custom input-validar inputs" type="date" name="fn2">
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





            <div class="d-flex justify-content-center mb-3">
                <button id="btnMorbilidad" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                    </svg></button>
            </div>
        </div>
    </div>
</div>