<?php require_once './src/vistas/head/head.php'; ?>



<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">


    <h5 style="width: 95%; " class="m-auto mb-3">Proveedores Papelera <img src="<?= $urlBase ?>../src/assets/img/proveedor (1).png" width="22" height="22" uk-svg class="mb-2"></h5>

    <!-- alertas -->

    <?php require_once "./src/vistas/alerts.php" ?>

    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto table-responsive" style="width: 95%; ">
        <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">

            <?php require_once "./src/vistas/vistaInsumos/paginationInsumos.php" ?>


        </div>



        <div class="table table-responsive">

            <table class="example table table-striped">
                <thead>
                    <tr>
                        <th class="text-dark text-center">Nombre</th>
                        <th class="text-dark text-center">Rif</th>
                        <th class="text-dark text-center">Teléfono</th>
                        <th class="text-dark text-center">Correo</th>
                        <th class="text-dark text-center">Dirección</th>
                        <th class="text-dark text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($proveedor as $proveedor): ?>
                        <tr>


                            <td class="border-start text-center border-start-0">
                                <?php echo $proveedor["nombre"] ?>
                            </td>
                            <td class="border-start text-center">
                                <?php echo $proveedor["rif"] ?>
                            </td>
                            <td class="border-start text-center">
                                <?php echo $proveedor["telefono"] ?>
                            </td>
                            <td class="border-start text-center">
                                <?php echo $proveedor["email"] ?>
                            </td>
                            <td class="border-start text-center">
                                <?php echo $proveedor["direccion"] ?>
                            </td>


                            <td class="border-start d-flex justify-content-center">

                                <!-- Editar Proveedor -->



                                <!-- Eliminar Proveedores-->

                                <div class="me-2">
                                    <a href="#" class="btn btn-tabla mb-1 btn-dt-tabla" uk-toggle="target: #modal-exampleEliminarProveedores<?= $proveedor["id_proveedor"]; ?>" uk-tooltip="Eliminar Proveedores" data-id-tabla="modal-exampleEliminarProveedores<?= $proveedor["id_proveedor"]; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                                            <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                                        </svg>
                                    </a>
                                </div>

                            </td>
                        </tr>


                        <!--ELIMINAR MODAL-->

                        <div id="modal-exampleEliminarProveedores<?= $proveedor["id_proveedor"]; ?>" uk-modal>


                            <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                                <!-- Boton que cierra el modal -->
                                <div class="d-flex justify-content-between mb-5">




                                    <div class="d-flex align-items-center ajustar" id="eliminarEspecialidad">
                                        <div class="svgPapeleraPatologia">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-arrow-counterclockwise azul me-2 mb-1 " viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                                                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h5>
                                                ¿Desea restablecer la Entrada del Insumo?
                                            </h5>
                                        </div>
                                    </div>
                                    <!-- Ayuda Interactiva -->
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                        </svg>
                                    </a>
                                </div>


                                <div class="mt-5 uk-text-right btn_modal_patologias">
                                    <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button"
                                        id="cancelarEliminacion">Cancelar</button>

                                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Proveedores/restablecerProveedor/<?= $proveedor["id_proveedor"]; ?>/<?= $_SESSION['id_usuario']; ?>">
                                        <button class="btn col-4 btn-agregarcita-modal btnrestablecer" id="btnEliminarEspecialidad">Restablecer</button>
                                    </a>

                                </div>

                            </div>




                        </div>




                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
    </div>



</div>










<?php require_once './src/vistas/head/footer.php'; ?>