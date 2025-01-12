<!-- modal para mostrar todo -->
<div id="modal-patologia" uk-modal>
    <div class="uk-modal-dialog uk-modal-body tamaño-modal">
        <!-- Boton que cierra el modal -->
        <div class="d-flex justify-content-between ">


            <div class="d-flex align-items-center mb-3" id="EspecialidadesAyuda">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-grid-1x2-fill me-3 mb-3 azul" viewBox="0 0 16 16">
                        <path d="M0 1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V1zm0 9a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-5z" />
                    </svg>
                </div>
                <div class="">
                    <p class="uk-modal-title fs-5 fw-bold">
                        Categorías
                    </p>
                </div>
            </div>
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
        </div>

        <!-- Buscador -->
        <div class="d-flex justify-content-end">




            <div class="d-flex justify-content-end mb-4 col-6" id="form-buscador">

                <!-- <a class="btn boton-buscar d-none" title="Buscar" id="reiniciarBusquedaPatologia" uk-tooltip="Restablecer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat"
                        viewBox="0 0 16 16">
                        <path
                            d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                        <path fill-rule="evenodd"
                            d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                    </svg>
                </a> -->
                <form action="?c=ControladorDoctores/buscarEspecialidad" method="POST" id="form-buscadorPatologias"
                    class="d-flex justify-content-end" autocomplete="off">
                    <input class="form-control input-busca" type="text" name="nombre" placeholder="Ingrese Categoría"
                        id="inputBuscarCategoria">
                    <button class="btn boton-buscar" title="Buscar" id="especialidadBuscar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search"
                            viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        <div class="">
            <table class="table table-striped " id="tablaPatologia">
                <thead>
                    <tr>
                        <th class="d-none">
                            Id
                        </th>
                        <th class=" text-center">#</th>
                        <th class=" text-center border-start">Nombre</th>
                        <th class=" text-center border-start">Acción</th>

                    </tr>
                </thead>
                <tbody id="cuerpoTablaEspecialidad" class="tbodyCategoria">
                <tr>
                                <td class="text-center fw-bold">
                                   1
                                </td>

                                <td class="text-center border-start">
                                    Consulta
                                </td>


                                <td class="border-start text-center">
                                    No se puede eliminar 

                                </td>
                            </tr>
                    <?php if ($categorias): ?>
                        <?php $contadorCategoria = 2; ?>

                        <?php foreach ($categorias as $categoria): ?>

                            <tr>
                                <td class="text-center fw-bold">
                                    <?php echo $contadorCategoria++; ?>
                                </td>

                                <td class="text-center border-start">
                                    <?php echo $categoria['nombre']; ?>
                                </td>


                                <td class="border-start text-center">
                                    <button class="btn btn-tabla mb-1" uk-toggle="target: #eliminarEspecialidad<?= $categoria["0"]; ?>"
                                        id="btnEliminarEspecialidad">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                        </svg>
                                    </button>

                                    <div id="eliminarEspecialidad<?= $categoria["0"]; ?>" uk-modal>
                                        <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                                            <!-- Boton que cierra el modal -->
                                            <div class="d-flex justify-content-between mb-5">




                                                <div class="d-flex align-items-center" id="eliminarEspecialidad">
                                                    <div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                                            class="bi bi-trash-fill azul me-2 mb-1" viewBox="0 0 16 16">
                                                            <path
                                                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h5>
                                                            ¿Desea eliminar la Categoría?
                                                        </h5>
                                                    </div>
                                                </div>
                                                <!-- Ayuda Interactiva -->
                                                <div>
                                                    <a href="#" uk-tooltip="Ayuda">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                                            class="bi bi-question-octagon-fill azul ms-4" viewBox="0 0 16 16"
                                                            id="btnayudaEspecialidades3">
                                                            <path
                                                                d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>


                                            <div class="mt-5 uk-text-right">
                                                <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button"
                                                    id="cancelarEliminacion">Cancelar</button>

                                                <a href="?c=ControladorConsultas/eliminarCategoria&id_categoria=<?= $categoria["0"]; ?>">
                                                    <button class="btn col-4 btn-agregarcita-modal" id="btnEliminarEspecialidad">Eliminar</button>
                                                </a>

                                            </div>

                                        </div>


                                </td>
                            </tr>
                        <?php endforeach ?>


                     
                         



                    <?php else: ?>


                        <tr>
                            <td colspan="9" class="text-center">NO HAY REGISTROS

                            </td>
                        </tr>
                    <?php endif ?>



                </tbody>
            </table>

            <table class="table table-striped d-none" style="margin-top: -16px;" id="noResultadoCat">
                <thead>

                </thead>
                <tbody>
                    <tr class="" >
                        <td colspan="9" class="text-center">NO HAY REGISTROS

                        </td>
                    </tr>
                </tbody>

            </table>



        </div>

        <div class="mt-3 uk-text-right">
            <button class="uk-button col-6 me-2 uk-button-default uk-modal-close btn-cerrar-modal" type="button"
                id="cerrarModalEspecialidad">CERRAR</button>
            <a href="#" class="text-decoration-none">
                <button class="btn col-5 btn-agregarcita-modal" id="botonAgregarEspecialidad"
                    uk-toggle="target: #modal-exampleAgregarPatologias">Nueva</button></a>

        </div>

    </div>
</div>


<!-- modal agregar especialidad -->

<div id="modal-exampleAgregarPatologias" uk-modal>
    <div class="uk-modal-dialog uk-modal-body tamaño-modal">

        <div class="d-flex justify-content-between ">
            <div class="d-flex align-items-center mb-3" id="registrarEspecialidades">
                <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-grid-1x2-fill me-3 mb-3 azul" viewBox="0 0 16 16">
                        <path d="M0 1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V1zm0 9a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-5z" />
                    </svg>
                </div>
                <div class="">
                    <p class="uk-modal-title fs-5 ">
                        Registrar Categoría
                    </p>
                </div>
            </div>
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
        </div>


        <div class="alert alert-danger d-none" role="alert" id="alerta">
            <div class="">
                <p style="font-size: 13px;" class="text-center">VERIFIQUE EL FORMULARIO ANTES DE ENVIARLO</p>
            </div>
        </div>

        <form class="form-modal" id="modalAgregar" action="?c=ControladorConsultas/registrarCategoria" method="POST">


            <div class="input-group flex-nowrap margin-inputs validar" id="grp_nombrePatologia">
                <span class="input-modal mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-grid-1x2-fill azul" viewBox="0 0 16 16">
                        <path d="M0 1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V1zm0 9a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-5z" />
                    </svg>
                </span>

                <input class="form-control mayuscula input-modal input-disabled input-paciente" type="text" id="nombrePatologia" name="nombre"
                    placeholder="Nombre de la Categoría" required maxlength="20" pattern="[A-ZÁÉÍÓÚÑa-záéíóúñ]{1,}">
            </div>

            <div class="mt-3 uk-text-right">
                <button class="uk-button col-6 me-2 uk-button-default btn-cerrar-modal" type="button"
                    uk-toggle="target: #modal-patologia" id="cancelarRegistroespecialidades">Cancelar</button>
                <button class="btn col-5 btn-agregarcita-modal" type="submit" name="crear"
                    id="botonEnviarEspecialidad">Agregar</button>
            </div>
        </form>
    </div>
</div>


