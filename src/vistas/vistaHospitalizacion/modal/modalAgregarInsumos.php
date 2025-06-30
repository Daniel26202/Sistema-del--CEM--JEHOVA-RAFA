<!-- MODAL DE AGREGAR INSUMOS -->
<div class="modal fade " id="modal-agregar-insumos" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down  uk-offcanvas-container">
        <div class="modal-content rounded-4 pt-3 pb-3 pe-4 ps-4 hospit">


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
                <form class="me-3 ms-3 mt-2" method="POST" action="/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/agregarH">
                    <div class="d-flex justify-content-between align-items-center mt-1 ">

                        <div class="col-6">
                            <p class="ms-3 mt-4 fw-bolder " id="p-no-insumos"></p>
                        </div>

                        <div class="d-flex justify-content-end mt-4 mb-3 col-6">
                            <input class="form-control input-buscar" type="text" name="nombre"
                                placeholder="Ingrese nombre" id="btbt">
                            <a href="#" class="btn btn-buscar" title="Buscar" id="btn-buscarInsumo">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-search" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </a>
                        </div>

                    </div>
                </form>
                <div class="" id="">

                    <div class="mb-3 col-12 d-flex align-items-center justify-content-center  mt-4 pt-2 mb-2">
                        <h5 class="fw-bold text-center">Insumos</h5>
                    </div>

                    <div class="d-flex flex-wrap" id="insumoExiste"></div>

                    <div class="d-flex flex-wrap" id="insumos">

                        <?php if ($datosI): ?>
                            <?php foreach ($datosI as $datoI): ?>
                                <div class="col-6 divInsumos" data-index=<?php echo $datoI["id_insumo"]; ?>>
                                    <a href="#" class="text-center text-decoration-none m-0" data-bs-toggle="modal"
                                        data-bs-target="#modal-agregar-hospitalizacion">
                                        <div class="color-icono d-flex align-items-center justify-content-center p-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor"
                                                class="bi bi-plus-circle me-2 " viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                <path
                                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                            </svg>
                                            <p class="mt-3 ">
                                                <?php echo $datoI["nombre"]; ?>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach ?>
                        <?php else: ?>
                            <p class="m-auto">En estos momentos, no hay insumos disponibles</p>
                        <?php endif ?>

                    </div>


                </div>
            </div>

            <p class="uk-text-right mt-4 text-center">
                <button class="uk-button rounded-5 fw-bold " type="button" data-bs-toggle="modal"
                    data-bs-target="#modal-agregar-hospitalizacion">Cancelar</button>
            </p>

        </div>
    </div>
</div>


<?php require_once './src/vistas/vistaHospitalizacion/modal/modalAgregarPacientes.php'; ?>
<?php require_once './src/vistas/vistaHospitalizacion/modal/modalEditarHospitalizacion.php'; ?>