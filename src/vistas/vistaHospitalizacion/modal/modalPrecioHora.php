<!-- MODAL DE AGREGAR INSUMOS -->
<!-- para agregar una hospitalización -->
<div class="modal fade" id="modal-agregar-precio-hora" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down  uk-offcanvas-container">
        <div class="modal-content rounded-4 pt-3 pb-3 pe-4 ps-4">


            <div class=" d-flex justify-content-between align-items-center mt-2 pt-0">

                <div class=" d-flex justify-content-center align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor"
                        class="bi bi-plus-circle-fill color-icono me-1 mb-4" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                    </svg>
                    <div class="me-5">
                        <h4 class="fw-bold ms-1">Agregar el precio por horas de atención</h4>
                    </div>
                </div>

                <!-- btn close -->
                <div class="mb-5">
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



            <form class="" method="get" id="formCostoHora">
                <div class="mb-5 pb-2">

                    <div class="me-3 ms-3 mt-2">
                        <div class="m-auto mt-4 pt-1 col-12">
                            <h5 class="text-center fw-bold">Hora y precio</h5>
                        </div>

                        <div class="d-flex justify-content-center align-items-center mt-4 ">

                            <div class="borde-input-agregar m-auto col-12">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="col-4 ms-4">

                                        <input type="number" name="horasSe" id="inpHorasS" class="input-agregar w-75 "
                                            placeholder="Hora" value="" min="1" required><span class=" mt-1">h.</span>

                                    </div>
                                    <div class="col-2">

                                        <p class=" fw-bold margen-dos-puntos pb-2">:</p>

                                    </div>
                                    <div class="col-6 d-flex">
                                        <input type="number" step="any" name="precioHorasSe" id="inpCostoHS"
                                            class="input-agregar w-50" placeholder="Precio" value="" min="0.10" required>
                                        <p class="mt-3 ps-1">bs</p>
                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>


                </div>

                <p class="uk-text-right mt-4 text-center">
                    <button class="uk-button rounded-5 fw-bold " type="button" data-bs-toggle="modal">Cancelar</button>
                    <button class="uk-button uk-button-primary rounded-5 fw-bold d-non" type="submit"
                        data-bs-dismiss="modal" id="btnCH">Guardar</button>
                </p>
            </form>

        </div>
    </div>
</div>


<?php require_once './src/vistas/vistaHospitalizacion/modal/modalAgregarPacientes.php'; ?>
<?php require_once './src/vistas/vistaHospitalizacion/modal/modalEditarHospitalizacion.php'; ?>