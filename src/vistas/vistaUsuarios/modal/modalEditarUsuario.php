<!--MODAL MOSTAR-->

<?php foreach ($datosU as $dato): ?>

    <div id="modal-exampleEditar<?php echo $dato["id_usuario"]; ?>" uk-modal>
        <div class="uk-modal-dialog uk-modal-body tamaño-modal uk-card  uk-width-1-2@m">

            <form method="POST" class="formEditarUsuario"
                action="/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/editarUsuario/<?php echo $dato["usuario"]; ?>"
                enctype="multipart/form-data">

                <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario']?>">

                <div id="padre<?php echo $dato["id_usuario"]; ?>">
                    <div class="alert alert-danger text-center d-none" id="alertaUsuario">VERIFIQUE EL FORMULARIO ANTES DE
                        ENVIARLO</div>
                    <div class="caja-imagen">
                        <div class="uk-grid-small uk-flex-middle d-flex justify-content-center" uk-grid>
                            <div class="uk-width-auto">
                                <?php if ($dato["imagen"] != "doctor.png"): ?>

                                    <img src="./src/assets/img_ingresadas_por_usuarios/usuarios/<?= $dato['id_usuario'] . "_" . $dato['imagen'] ?>"
                                        class="uk-border-circle" width="55" height="55" alt="Avatar">
                                <?php else: ?>

                                    <img src="./src/assets/img_ingresadas_por_usuarios/usuarios/<?= $dato['imagen'] ?>"
                                        class="uk-border-circle" width="55" height="55" alt="Avatar">
                                <?php endif; ?>

                            </div>

                        </div>
                    </div>
                    <div class="uk-card-body pt-2">

                        <div class="d-flex flex-column w-auto ">
                            <div class="input-group flex-nowrap grpFormCorrect">
                                <span class="input-modal ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                        class="bi bi-camera-fill azul" viewBox="0 0 16 16">
                                        <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                        <path
                                            d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z" />
                                    </svg>
                                </span>
                                <input class="form-control input-modal input-disabled imagenesUsuarios " type="file"
                                    name="imagenUsuario" placeholder="Imagen">
                            </div>

                            <p class="text-center fw-bolder mb-1 mt-3">Nombre de usuario</p>

                            <div class="margen-input-u w-auto grpFormCorrect">

                                <svg xmlns="http://www.w3.org/2000/svg" id="icono-dos" width="20" height="20"
                                    fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                </svg>

                                <input type="text" name="usuario" id="inputDos" class="input-u col-12" placeholder="Usuario"
                                    value="<?php echo $dato["usuario"]; ?>">

                            </div>

                        </div>

                        <!-- inputs ocultos -->
                        <div>
                            <input type="" name="id_usuario" value="<?php echo $dato["id_usuario"]; ?>" hidden>
                        </div>

                        <div class="uk-card-footer d-flex justify-content-start">
                            <a href="#" class="color_lineaText uk-button btnMostrar mt-2 me-4 pe-0 ps-0">Editar usuario</a>
                            <a href="#" class="uk-button uk-button-text btnMostrar mt-2 btn_editarPassword" uk-toggle="target: #modal-exampleEditarPassword" data-usuario="<?php echo $dato["usuario"]; ?>" data-id-u="<?php echo $dato["id_usuario"]; ?>" >Editar contraseña</a>
                        </div>

                        <div class="uk-card-footer d-flex justify-content-start">
                            <a href="#" class="uk-button uk-button-text btnMostrar mt-2 uk-modal-close">Cancelar</a>
                            <input type="submit" class="uk-button uk-button-text btnMostrar ms-4 mt-2" name="actualizar"
                                value="Actualizar">
                        </div>
                    </div>
            </form>
        </div>
    </div>
    <?php require_once './src/vistas/vistaUsuarios/modal/modalEditarPasswordAdmin.php'; ?>

<?php endforeach ?>