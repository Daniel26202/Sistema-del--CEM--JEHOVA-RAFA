<?php require_once './src/vistas/head/head.php'; ?>

<div class="container-fluid px-4">

    <div class="d-flex align-items-center justify-content-between mt-4 mb-4 Reportes_ayuda">
        <div class="ms-5 d-flex align-items-center">
            <h1 class="fw-bold">REPORTES</h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" fill="currentColor" class="bi bi-clipboard-data ms-2" viewBox="0 0 16 16">
                <path d="M4 11a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0zm6-4a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0zM7 9a1 1 0 0 1 2 0v3a1 1 0 1 1-2 0z" />
                <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z" />
                <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z" />
            </svg>
        </div>

        <div class="me-4">

            <!-- requerir los botones -->
            <?php require_once './src/vistas/btnOpciones.php'; ?>
        </div>
    </div>



    <!-- modal de cerrar sesión -->
    <?php require_once './src/vistas/modalCierreS/modalCierreS.php'; ?>

    <!-- 
Caja padre de reportes -->

    <div class="d-flex justify-content-between flex-wrap w-100">
        <div class="card cardReporte tajeta-estadistica-m mb-5">
            <h3 class="card-header text-center fw-bold">Citas</h3>
            <div class="card-body ">
                <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#exampleModalBuscador">
                    <div class="card-body cartaRepor d-flex justify-content-center align-items-center  h-100 ">
                        <div class="ico  d-flex flex-column align-items-center w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                                class="bi bi-calendar2-heart-fill mb-2" viewBox="0 0 16 16">
                                <path
                                    d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5Zm-2 4v-1c0-.276.244-.5.545-.5h10.91c.3 0 .545.224.545.5v1c0 .276-.244.5-.546.5H2.545C2.245 5 2 4.776 2 4.5Zm6 3.493c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z" />
                            </svg>
                            <h5 class="card-text t text-center">Descargar Reporte de Citas</h5>
                        </div>

                    </div>
                </a>
            </div>
        </div>
        <div class="card tajeta-estadistica-m mb-5 contenido">
            <h5 class="card-header">TITULO 2</h5>
            <div class="card-body">

            </div>
        </div>
        <div class="card tajeta-estadistica-g m-auto mb-5">
            <h5 class="card-header">TITULO 3</h5>
            <div class="card-body">

            </div>
        </div>
        <div class="card tajeta-estadistica-m mb-5">
            <h5 class="card-header">TITULO 4</h5>
            <div class="card-body">

            </div>
        </div>
        <div class="card tajeta-estadistica-m mb-5">
            <h5 class="card-header">TITULO 5</h5>
            <div class="card-body">

            </div>
        </div>
    </div>

</div>





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

<?php require_once './src/vistas/head/footer.php'; ?>