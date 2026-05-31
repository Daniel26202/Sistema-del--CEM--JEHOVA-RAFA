    <!-- Modal Agregar-->
    <div class="modal fade" id="modalAddUserBlckList" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content tamaño-modal">
                <div class="modal-header">
                    <h5 class="modal-title fs-4 fw-bold" id="labelBlackList">Agregar usuario a la lista negra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class=" form-validable" id="formAgregarBlackList">

                    <input type="hidden" name="cedulaRegistrada" id="cedulaRegistrada">

                    <input type="hidden" name="id" id="id_paciente">


                    <div class="modal-body">
                        <label class="label-custom">Seleccionar el usuario</label>
                        <div class="campo-custom">
                            <div class="input-custom">
                                <span class="icono-izq">
                                    <img src="<?= $urlBase ?>../src/assets/images/img/proveedor(2).png" width="20" height="20" uk-svg class="me-1">

                                </span>
                                <select class="form-control txt-custom select-custom input-validar inputs" id="select-user" name="id_personal">

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
                            <p class="error-msg p-error-validaciones d-none fw-bold"></p>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-modals-cancelar me-2" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-modals" id="botonModal">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>