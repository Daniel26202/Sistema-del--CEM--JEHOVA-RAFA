<!-- modal para mostrar todo -->
<div class="modal fade" id="modal-categoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content tamaño-modal">
            <div class="modal-header">
                <h5 class="modal-title fs-4 fw-bold" id="modalLabelServicios">Categorías</h5>
                <!-- Ayuda interactiva -->
                <div class="d-flex justify-content-end mb-3">
                    <a href="#" uk-tooltip="Ayuda">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-question-octagon-fill azul ms-4" viewBox="0 0 16 16" id="btnayudaEspecialidades">
                            <path
                                d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                        </svg>
                    </a>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="">
                <table class="table exampleTableCategoria table-striped " id="tablaPatologia">
                    <thead>
                        <tr>
                            <th class=" text-center">#</th>
                            <th class=" text-center border-start">Nombre</th>
                            <th class=" text-center border-start">Acción</th>

                        </tr>
                    </thead>
                    <tbody id="cuerpoTablaEspecialidad" class="tbodyCategoria">


                    </tbody>
                </table>

                <table class="table table-striped d-none" style="margin-top: -16px;" id="noResultadoCat">
                    <thead>

                    </thead>
                    <tbody>
                        <tr class="">
                            <td colspan="9" class="text-center">NO HAY REGISTROS

                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-modals-cancelar me-2" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-modals" id="botonModalServicio" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalAgregarPatologias">Registrar</button>
                <span id="spinner-cargando" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </div>
        </div>
    </div>
</div>


<!-- modal agregar especialidad -->
<div class="modal fade" id="modalAgregarPatologias" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content tamaño-modal">
            <div class="modal-header">
                <h5 class="modal-title fs-4 fw-bold" id="modalLabelServicios">Registrar Categoría</h5>
                <!-- Ayuda interactiva -->
                <div class="d-flex justify-content-end mb-3">
                    <a href="#" uk-tooltip="Ayuda">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-question-octagon-fill azul ms-4" viewBox="0 0 16 16" id="btnayudaEspecialidades2">
                            <path
                                d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                        </svg>
                    </a>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="alert alert-danger d-none" role="alert" id="alerta">
                <div class="">
                    <p style="font-size: 13px;" class="text-center">VERIFIQUE EL FORMULARIO ANTES DE ENVIARLO</p>
                </div>
            </div>

            <form class="form-modal form-validable form-convercion" autocomplete="off" id="formularioCategoria">

                <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario'] ?>">

                <label class="label-custom">Nombre de la Categoría</label>
                <div class="campo-custom">
                    <div class="input-custom">
                        <span class="icono-izq">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-grid-1x2-fill azul" viewBox="0 0 16 16">
                                <path
                                    d="M0 1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V1zm0 9a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-5z" />
                            </svg>
                        </span>

                        <input class="form-control txt-custom input-validar inputs " name="nombre" type="text" placeholder="Nombre de la Categoría" required maxlength="20">
                        <span class="icono-der">
                            <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                            </svg>
                            <svg class="error d-none " width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </span>
                    </div>
                    <p class="error-msg d-none">La categoría debe mínimo 3 letras</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-modals-cancelar me-2" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modal-categoria">Cancelar</button>
                    <button type="submit" class="btn btn-modals" id="botonModalServicio" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalAgregarPatologias">Registrar</button>
                    <span id="spinner-cargando" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </div>
        </div>
    </div>
</div>