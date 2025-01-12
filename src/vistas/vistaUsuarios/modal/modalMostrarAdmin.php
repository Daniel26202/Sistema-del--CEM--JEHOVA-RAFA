<!--MODAL MOSTRAR-->
<?php foreach ($datosU as $dato): ?>

    <div id="modal-exampleMostrar<?php echo $dato["id_usuario"]; ?>" uk-modal>
        <div class="uk-modal-dialog uk-modal-body tamaño-modal uk-card uk-card-default uk-width-1-2@m">

            <div class="">
                <div class="uk-card-header">
                    <div class="uk-grid-small uk-flex-middle mb-1" uk-grid>
                        <div class="uk-width-auto">

                            <?php if ($dato["imagen"] != "doctor.png"): ?>

                                <img src="./src/assets/img_ingresadas_por_usuarios/usuarios/<?= $dato['id_usuario'] . "_" . $dato['imagen'] ?>"
                                    class="uk-border-circle" width="55" height="55" alt="Avatar">
                            <?php else: ?>

                                <img src="./src/assets/img_ingresadas_por_usuarios/usuarios/<?= $dato['imagen'] ?>"
                                    class="uk-border-circle" width="55" height="55" alt="Avatar">
                            <?php endif; ?>
                        </div>
                        <div class="uk-width-expand">
                            <h4 class="uk-card-title uk-margin-remove-bottom">
                                <?php echo $dato["9"] . "" . $dato["apellido"]; ?>
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
                            <?php echo $dato["usuario"]; ?>
                        </p>
                    </div>
                    <div class="d-flex align-items-center col-12 mb-2">
                        <h5 class="me-2 col-5">Contraseña:</h5>
                        <input type="password" class="m-0 col-3 input-mostrar inputDos"
                            value="<?php echo $dato["password"]; ?>" disabled id="">
                        <a href="#" class="text-decoration-none">
                            <svg id="ocultarPassword" xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                fill="currentColor" class="bi bi-eye-slash-fill azul ocultarPassword d-none"
                                viewBox="0 0 16 16">
                                <path
                                    d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z" />
                                <path
                                    d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z" />
                            </svg>
                            <svg id="mostrarPassword" xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                fill="currentColor" class="bi bi-eye-fill azul mostrarPassword" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                <path
                                    d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                            </svg>
                        </a>
                    </div>

                </div>
                <div class="uk-card-footer d-flex justify-content-start">
                    <a href="#" class="uk-button uk-button-text btnMostrar mt-2 uk-modal-close">Cancelar</a>
                    <a href="#" class="uk-button uk-button-text btnMostrar mt-2 ms-4 editarUsuario"
                        uk-toggle="target: #modal-exampleEditar<?php echo $dato["id_usuario"]; ?>">Modificar</a>
                    <a href="#" class="uk-button uk-button-text btnMostrar mt-2 ms-4"
                        uk-toggle="target: #modal-exampleEliminar<?php echo $dato["id_usuario"]; ?>">Eliminar</a>
                </div>
            </div>

        </div>
    </div>

<?php endforeach ?>

<?php require_once("./src/vistas/vistaUsuarios/modal/modalEditarAdmin.php") ?>
<?php require_once("./src/vistas/vistaUsuarios/modal/modalEliminarAdmin.php") ?>