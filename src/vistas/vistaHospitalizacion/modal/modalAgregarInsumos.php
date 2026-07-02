<!-- MODAL DE AGREGAR INSUMOS -->
<div class="modal fade " id="modal-agregar-insumos" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl  uk-offcanvas-container">
        <div class="modal-content tamaño-modal rounded-4 pt-3 pb-3 pe-4 ps-4 hospit">


            <div class=" d-flex justify-content-between align-items-center mt-2 pt-0">

                <div class=" d-flex justify-content-center align-items-center ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor"
                        class="bi bi-plus-circle-fill color-icono me-1" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                    </svg>
                    <h4 class=" fw-bold ">Agregar insumo</h4>
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


            <input type="hidden" id="semaforo">

            <div class="mb-5 pb-2">
                <div class="" id="">

                    <div class="d-flex justify-content-end mb-2">
                        <div class=" d-flex mt-3 caja-insumos">
                            <div id="form-buscador-insumo" class="d-flex justify-content-end form-responsive children-caja-insumos" autocomplete="off">
                                <input class="form-control input-buscar tamaño-input-buscar input-responsive" id="searchInputInsumos" type="text" name="nombre"
                                    placeholder="Buscar...">

                                <button class="btn btn-buscar boton-responsive" title="Buscar" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-search" viewBox="0 0 16 16">
                                        <path
                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 col-12 d-flex align-items-center justify-content-center  mt-4 pt-2 mb-2">
                        <h5 class="fw-bold text-center">Insumos</h5>
                    </div>

                    <div class="d-flex flex-wrap" id="insumoExiste"></div>

                    <div class="d-flex flex-wrap" id="div-insumos-modal">


                    </div>

                    <div id="pagination-insumos" class="pagination-div"></div>
                </div>
            </div>

            <p class="uk-text-right mt-4 text-center">
                <button type="button" class="btn btn-modals-cancelar fw-bold rounded-5"
                    data-bs-toggle="modal" data-bs-target="#modal-agregar-hospitalizacion">Cancelar</button>
            </p>

        </div>
    </div>
</div>


<?php //require_once './src/vistas/vistaHospitalizacion/modal/modalAgregarPacientes.php'; 
?>
<?php require_once './src/vistas/vistaHospitalizacion/modal/modalEditarHospitalizacion.php'; ?>