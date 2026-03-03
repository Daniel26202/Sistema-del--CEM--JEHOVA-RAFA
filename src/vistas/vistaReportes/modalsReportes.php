<!-- Modal Citas-->
<div class="modal fade modalBuscadorP" id="exampleModalBuscador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content contenido modalBuscador">
            <div>
                <a href="#" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default text-white " viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                    </svg>
                </a>
                <h5 class="fw-bolder mt-3 ms-3 text-uppercase text-white fecha_citas" id="exampleModalLabel">Seleccione el Rango de Fechas</h5>
            </div>

            <div class="modal-body ">
                <div id="alertaDeFecha" class="alert alert-danger text-center d-none"></div>


                <article class="uk-comment" role="comment" id="articulo">

                    <div class="uk-grid-medium uk-flex-middle" uk-grid>

                        <div class="uk-width-auto">

                            <!-- <img src="./src/assets/img/seguro-de-salud.png" width="80" height="80" uk-svg class="iconoB pb-1">  -->



                        </div>

                        <div class="d-flex justify-content-center">


                            <form action="/Sistema-del--CEM--JEHOVA-RAFA/Reportes/buscarPDF" method="POST" id="formularioCita">
                                <ul class="  uk-subnav-divider uk-margin-remove-top margin d-flex fechas_mover" id="ul">
                                    <li><a href="#" class="text-decoration-none fw-bolder text-uppercase text-white me-3" id="cedulab">DESDE<input class="input-expresion form-control  input-disabled input-paciente col-10" type="date" name="desdeFecha" id="desdeFecha"></a></li>
                                    <li class="li_mover"><a href="#" class="text-decoration-none fw-bolder text-uppercase text-white" id="telefonob">HASTA<input class="input-expresion form-control input-disabled input-paciente col-10" name="fechaHasta" id="fechaHasta" type="date"></a></li>
                                </ul>

                        </div>
                    </div>



                </article>
            </div>
            <div class="d-flex justify-content-end aling-items-center">
                <button class="uk-button col-4 uk-button-default uk-modal-close btn-cerrar-modal " data-bs-dismiss="modal" type="button">Cancelar</button>

                <button type="submit" class="btn me-3 " id="botonDeImprimir"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                        <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1" />
                        <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                    </svg></button>
                </form>
            </div>


        </div>
    </div>
</div>


<!-- Modal  de entradas-->
<div class="modal fade modalBuscadorP" id="exampleModalBuscadorEntradas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">


        <div class="modal-content modalBuscador tamaño-modal">

            <div class="modal-header">
                <h5 class="modal-title fs-4 fw-bold" id="exampleModalLabelDoctores">Seleccionar el insumos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="modal-body ">
                <div id="alertaDeFechaEntradas" class="alert alert-danger text-center d-none"></div>


                <article class="uk-comment" role="comment" id="articulo">

                    <div>



                        <div class="">


                            <form action="/Sistema-del--CEM--JEHOVA-RAFA/Reportes/buscarEntradasInsumosPDF" method="POST" id="formularioEntradas">

                                <div class="campo-custom  w-100">
                                    <div class="input-custom ">
                                        <span class="icono-izq">

                                            <img src="<?= $urlBase ?>../src/assets/images/img/proveedor(2).png" width="20" height="20" uk-svg class="me-1">

                                        </span>
                                        <select id="selectInsumoEntradas" name="id_insumo" class="form-control txt-custom select-custom input-validar inputs ">
                                            <option selected disabled>Seleccione un Insumo</option>

                                            <?php foreach ($insumos as $i): ?>
                                                <option class="option-select-background" value="<?= $i['id_insumo'] ?>"><?= $i['nombre'] ?></option>
                                            <?php endforeach ?>
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





                                <!-- <h5 class="fw-bolder mt-3 ms-3 text-uppercase text-white fecha_entradas"><input type="checkbox" class="form-check-input m-3 card-title t" id="fechas_entradas" >BUSQUÉ POR FECHAS LAS ENTRADAS</h5> -->

                                <div id="cajaCheckboxEntrada" class="form-check mt-2 mb-2 d-none">
                                    <input class="form-check-input" type="checkbox" value="" id="checkboxEntradas">
                                    <h6 class="form-check-label fw-bolder ms-3 text-uppercase fecha_entradas" for="flexCheckDefault">
                                        BUSQUÉ POR FECHAS LAS ENTRADAS
                                    </h6>
                                </div>


                                <div class="d-flex justify-content-between d-none" id="cajaModalEntradas">
                                    <div>
                                        <label class="label-custom">Fecha de Inicio</label>
                                        <div class="campo-custom">
                                            <div class="input-custom">
                                                <span class="icono-izq">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
                                                        <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
                                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
                                                    </svg>
                                                </span>
                                                <input class="form-control txt-custom input-validar inputs" type="date" name="fn">
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
                                    <div>
                                        <label class="label-custom">Fecha Final</label>
                                        <div class="campo-custom">
                                            <div class="input-custom">
                                                <span class="icono-izq">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
                                                        <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
                                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
                                                    </svg>
                                                </span>
                                                <input class="form-control txt-custom input-validar inputs" type="date" name="fn">
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

                        </div>
                    </div>



                </article>
            </div>
            <div class="d-flex justify-content-end aling-items-center">
                <button class="btn btn-modals-cancelar me-2 " data-bs-dismiss="modal" type="button">Cancelar</button>

                <button type="submit" class="btn btn-modals  d-none" id="botonDeImprimirEntradas"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                        <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1" />
                        <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                    </svg></button>
                </form>
            </div>


        </div>
    </div>
</div>



<!-- Modal Factura -->
<div class="modal fade" id="reporteFactura" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content tamaño-modal">
            <div class="modal-header">
                <h5 class="modal-title fs-4 fw-bold" id="titleModalFactura">Gestionar Factura Activas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="table table-responsive">
                <table class="exampleTableFactura table table-striped">
                    <thead>
                        <tr>
                            <th class="text-dark text-center">Codigo Factura</th>
                            <th class="text-dark text-center">CI</th>
                            <th class="text-dark text-center">Paciente</th>
                            <th class="text-dark text-center">Fecha</th>
                            <th class="text-dark text-center">Monto</th>
                            <th class="text-dark text-center">Accion</th>


                        </tr>
                    </thead>
                    <tbody>



                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-modals-cancelar me-2" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-modals" id="btn-modal-factura">Facturas Anuladas</button>
            </div>

        </div>
    </div>
</div>



<!-- info factura -->
<div class="modal fade" id="modal-info-factura" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content tamaño-modal">
            <div class="modal-header">
                <h5 class="modal-title fs-4 fw-bold" id="exampleModalLabelDoctores">Informacion de la Factura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>



            <div class="container-fluid me-4">
                <div class="mt-3 mb-5">
                    <div class="row justify-content-center">


                        <div class="shadow-sm border-0 m-auto bg-comprobante" style="border-radius: 15px;">

                            <div class="card-header border-0 bg-transparent pt-4">
                                <div class="d-flex justify-content-center">
                                    <img style="max-width: 250px; height: auto;" src="<?= $urlBase ?>../src/assets/images/icons/logo2.png" alt="Logo">
                                </div>
                            </div>

                            <div class="card-body px-4 px-md-5 bg-comprobante">

                                <div id="data-card-factura">
                                    <!-- js -->
                                </div>

                                <hr class="my-4 opacity-25">

                                <h6 class="text-center text-uppercase fw-bold mb-3 text-primary" style="letter-spacing: 1px;">Servicios</h6>


                                <div id="data-card-servicio">
                                    <!-- js -->
                                </div>


                                <hr class="my-4 opacity-25">

                                <h6 class="text-center text-uppercase fw-bold mb-3 text-primary" style="letter-spacing: 1px;">Insumos</h6>

                                <div id="data-card-insumos">
                                    <!-- js -->
                                </div>

                                <hr class="my-4 opacity-25">

                                <h6 class="text-center text-uppercase fw-bold mb-3 text-primary" style="letter-spacing: 1px;">Métodos de pago</h6>

                                <div id="data-card-pagos">
                                    <!-- js -->
                                </div>


                            </div>


                            <div class="card-footer bg-transparent border-0 pb-4 bg-comprobante">
                                <div class="d-flex justify-content-center">
                                    <a id="btn-imprimir-factura"
                                        class="btn btn-outline-primary rounded-circle p-3 d-flex align-items-center justify-content-center shadow-sm"
                                        style="width: 60px; height: 60px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                                            <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
                                            <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>




        </div>


    </div>
</div>
</div>