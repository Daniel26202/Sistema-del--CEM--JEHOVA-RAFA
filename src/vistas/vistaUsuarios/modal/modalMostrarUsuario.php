<!--MODAL MOSTRAR-->
<?php foreach ($datosU as $dato): ?>

    <div id="modal-exampleMostrar<?php echo $dato["id_usuario"]; ?>" uk-modal>
        <div class="uk-modal-dialog uk-modal-body tamaño-modal uk-card uk-card-default uk-width-1-2@m">

            <div class="">
                <div class="uk-card-header">
                    <div class="uk-grid-small uk-flex-middle mb-1" uk-grid>
                        <div class="uk-width-auto">

                            <?php if ($dato["imagen"] != "doctor.png"): ?>

                                <img src="<?= $urlBase ?>../src/assets/img_ingresadas_por_usuarios/usuarios/<?= $dato['id_usuario'] . "_" . $dato['imagen'] ?>"
                                    class="uk-border-circle" width="55" height="55" alt="Avatar">
                            <?php else: ?>

                                <img src="<?= $urlBase ?>../src/assets/img_ingresadas_por_usuarios/usuarios/<?= $dato['imagen'] ?>"
                                    class="uk-border-circle" width="55" height="55" alt="Avatar">
                            <?php endif; ?>
                        </div>
                        <div class="uk-width-expand">
                            <h4 class="uk-card-title uk-margin-remove-bottom">
                                <?php echo $dato["9"] . " " . $dato["apellido"]; ?>
                            </h4>
                            <h5 class="uk-margin-remove-top">
                                <?php echo $dato["nombre"]; ?>
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="uk-card-body">
                    <div class="d-flex align-items-center col-12 mb-2">
                        <h5 class="me-2 col-5">Usuario:</h5>
                        <p class="m-0 col-5">
                            <?php echo $dato["user"]; ?>
                        </p>
                    </div>

                </div>
                <div class="uk-card-footer d-flex justify-content-start">
                    <button  class="uk-button uk-button-text btnMostrar mt-2 uk-modal-close">Cancelar</button>
                    <button  class="uk-button uk-button-text btnMostrar mt-2 ms-4 editarUsuario"
                        uk-toggle="target: #modal-exampleEditar<?php echo $dato["id_usuario"]; ?>">Modificar</button>
                    <button class="uk-button uk-button-text btnMostrar mt-2 ms-4 btn-eliminar" data-index="<?php echo $dato["id_usuario"]; ?>">Eliminar</button>
                </div>
            </div>

        </div>
    </div>

<?php endforeach ?>

<?php require_once("./src/vistas/vistaUsuarios/modal/modalEditarUsuario.php") ?>