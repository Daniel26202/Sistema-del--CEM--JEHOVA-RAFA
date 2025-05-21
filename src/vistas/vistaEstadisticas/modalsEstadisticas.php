<!-- modal reporte especialidades-->
<div class="modal fade" id="reporte" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content contenido">
            <div class="imprimir" id="imprimir">
                <div class="cabecera" style="display:flex; justify-content: space-between; background-color: #397ae0; color: white; padding: 10px;">
                    <div class="icon">
                        <img
                            src="../src/assets/icons/logo.png"
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
                    <div class="texto reporte" id="texto" style="width: 90%; text-align: justify; font-size: 14px;">


                    </div>

                </div>
            </div>
            <div class="alertEspecialidades">

            </div>
            <h5 class="mt-4 text-center">Filtrar la Grafica Segun un Periodo de Tiempo</h5>
            <div class="mt-4 w-100 mb-4">
                <div class="alert alert-danger text-center d-none alertaFechaInicio">Por favor la fecha de Inicio tiene que ser Menor a la fech final</div>
                <div class="d-flex">

                    <input type="date" name="fechaInicio" id="fechaInicio" class="form-control input-buscar fecha-exp" style="width: 40%;" title="fecha de Inicio">

                    <input type="date" name="fechaFinal" id="fechaFinal" class="form-control input-buscar fecha-exp" style="width: 40%;" title="fecha de final">



                    <a href="#" class="btn btn-buscar " id="buscarFecha" title="Buscar Entradas Por Fecha">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </a>
                    <div>
                        <button class="btn btn-tabla ms-5 d-none" id="btnImprimir">

                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                                <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
                                <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                            </svg>
                        </button>
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
                            src="../src/assets/icons/logo.png"
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
                    <div class="texto" id="textoSintomas" style="width: 90%; text-align: justify; font-size: 14px;">
                    </div>

                </div>
            </div>
            <h5 class="mt-4 text-center">Filtrar la Grafica Segun un Periodo de Tiempo</h5>
            <div class="mt-4 w-100 mb-4">
                <div class="alert alert-danger text-center d-none alertaFechaInicioSintomas">Por favor la fecha de Inicio tiene que ser Menor a la fech final</div>
                <div class="d-flex">

                    <input type="date" name="fechaInicio" id="fechaInicioSintomas" class="form-control input-buscar fecha-exp" style="width: 40%;" title="fecha de Inicio">

                    <input type="date" name="fechaFinalS" id="fechaFinalSintomas" class="form-control input-buscar fecha-exp" style="width: 40%;" title="fecha de final">



                    <a href="#" class="btn btn-buscar " id="buscarFechaSintomas" title="Buscar Entradas Por Fecha">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </a>
                    <div>

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