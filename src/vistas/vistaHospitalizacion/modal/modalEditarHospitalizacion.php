<div class="modal fade divModalE" id="modal-editar-hospitalizacion" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog uk-margin-auto-vertical uk-offcanvas-container">
        <div class="modal-content rounded-4 pt-3 pb-3 pe-4 ps-4">

            <div class=" d-flex justify-content-between align-items-center mt-2 pt-0">

                <div class=" d-flex justify-content-center align-items-center ">

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-pencil-fill color-icono me-1" viewBox="0 0 16 16">
                        <path
                            d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                    </svg>
                    <h4 class=" fw-bold ">Editar hospitalización</h4>
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


            <form method="post" class="me-3 ms-3 mt-2" id="formularioEditarH">

                <div class="mb-5 pb-2">

                    <div class="">
                        <div class="ms-3 mt-3 d-flex">

                            <h6 class="fw-bolder">Paciente: </h6>
                            <p class="fw-bolder ms-2" id="NombreAp"><!-- ESTA EN JS --></p>

                        </div>

                        <div class="" id="">
                            <div>
                                <div
                                    class="mb-3 col-12 d-flex align-items-center justify-content-center mt-3 pt-2 mb-2">

                                    <div class="col-3 ps-5 pt-1 ">

                                        <div class="d-none" id="btnAInsumoExisteE">

                                            <a href="#"
                                                class="d-flex justify-content-center align-items-center text-decoration-none"
                                                data-bs-toggle="modal" data-bs-target="#modal-editar-insumos">
                                                <p class="mt-3 me-1 fw-bolder ">Agregar</p>
                                                <div class="color-icono">


                                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                                        fill="currentColor" class="bi bi-plus-circle me-5"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                        <path
                                                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                                    </svg>
                                                </div>
                                            </a>
                                        </div>

                                    </div>

                                    <h5 class="fw-bold mt-2 ms-5 col-9 ">Medicamento y precio</h5>
                                </div>

                                <div class="" id="btnAInsumoNoExisteE">
                                    <a href="#" class="col-12 text-center text-decoration-none m-0"
                                        data-bs-toggle="modal" data-bs-target="#modal-editar-insumos">
                                        <div class="color-icono d-flex align-items-center justify-content-center p-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                                fill="currentColor" class="bi bi-plus-circle me-2 " viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                <path
                                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                            </svg>
                                            <p class="mt-3 ">Agregar insumos</p>
                                        </div>
                                    </a>
                                </div>

                                <div class="mb-1 div-insumosAE" id="divDI">
                                    <!-- los insumos esta en el js -->
                                </div>

                            </div>

                            <div>
                                <div class="m-auto mt-4 pt-1 col-12">
                                    <h5 class="text-center fw-bold">Hora y precio</h5>
                                </div>

                                <div class="d-flex justify-content-center align-items-center mt-4 ">

                                    <div class="borde-input-agregar m-auto col-12">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <div class="col-4 ms-4">

                                                <input type="number" name="horas" id="duracion"
                                                    class="input-agregar w-75" placeholder="Hora" value="" required><span class=" mt-1">h.</span>

                                            </div>
                                            <div class="col-2">

                                                <p class=" fw-bold margen-dos-puntos pb-2">:</p>

                                            </div>
                                            <div class="col-6 d-flex">
                                                <input type="number" name="precioHoras" step="any" id="precioH"
                                                    class="input-agregar w-50" placeholder="Precio" value="" required
                                                    readonly>
                                                <p class="mt-3 ps-1">bs</p>

                                            </div>


                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="mt-4 pt-2">
                            <h4 class="text-center fw-bold">Historia clínica</h4>

                            <div class="uk-margin">
                                <textarea name="historialE" class="uk-textarea" rows="5" placeholder="Textarea"
                                    aria-label="Textarea" id="historiaE" ></textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <div>
                    <input type="hidden" name="total" id="PTE" class="">
                    <input type="hidden" name="id_controlE" id="idCE">
                    <input type="hidden" name="id_h" id="idHptE">
                    <input type="hidden" name="id_insumos_eliminados[]" id="idInEli">
                    <input type="hidden" name="id_insumos_eliminados[]" id="idInEliDos">
                </div>

                <div class="d-flex mt-5 ms-2 col-12">
                    <div class="d-flex mt-2 col-3 d-none" id="divTPE">
                        <p class="p-0 m-0 fw-bold">Total:</p>
                        <p class="p-0 ms-1" id="totalPE"></p>
                        <p class="p-0">bs</p>
                    </div>
                    <p class="uk-text-right col-9">
                        <button class="uk-button rounded-5 btn-cancelar fw-bold " type="button"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button class="uk-button uk-button-primary rounded-5 fw-bold" type="submit"
                            data-bs-dismiss="modal" id="btnEH">Guardar</button>
                    </p>
                </div>

            </form>

        </div>
    </div>
</div>