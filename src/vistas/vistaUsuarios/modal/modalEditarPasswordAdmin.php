<!--MODAL MOSTRAR password-->

<div id="modal-exampleEditarPassword" uk-modal>
    <div class="uk-modal-dialog uk-modal-body tamaño-modal uk-card  uk-width-1-2@m">

        <form method="POST" class="formEditarUsuario" id="formUC" enctype="multipart/form-data">

            <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario'] ?>">

            <input type="hidden" name="usuario" value="<?= $dato['usuario'] ?>">


            <div id="padre<?php echo $dato["id_usuario"]; ?>">
                <div class="alert alert-danger text-center d-none" id="alertaUsuario">VERIFIQUE EL FORMULARIO ANTES DE
                    ENVIARLO</div>
                <div class="caja-imagen">
                    <div class="uk-grid-small uk-flex-middle d-flex justify-content-center" uk-grid>
                        <div class="uk-width-auto">
                            <?php if ($dato["imagen"] != "doctor.png"): ?>

                                <img src=" <?= $urlBase ?>../src/assets/img_ingresadas_por_usuarios/usuarios/<?= $dato['id_usuario'] . "_" . $dato['imagen'] ?>"
                                    class="uk-border-circle" width="55" height="55" alt="Avatar">
                            <?php else: ?>

                                <img src="<?= $urlBase ?>../src/assets/img_ingresadas_por_usuarios/usuarios/<?= $dato['imagen'] ?>"
                                    class="uk-border-circle" width="55" height="55" alt="Avatar">
                            <?php endif; ?>

                        </div>

                    </div>
                </div>
                <div class="uk-card-body pt-2">

                    <!-- alerta dinámica -->
                    <div class="h-20">

                        <div class=" comentarioADinamica comentarioRed fw-bolder d-none" id="alerta_errorMEPAc" uk-alert>
                            <!-- <a class="uk-alert-close" uk-close></a> -->
                            <p class="pe-2 text-center"></p>
                        </div>
                    </div>

                    <div class="d-flex flex-column w-auto ">

                        <p class="text-center m-0 pb-0 pt-3 fw-bolder">Contraseña actual</p>
                        <div class="margen-input-u w-auto grpFormCorrect d-flex">

                            <img src="<?= $urlBase ?>../src/assets/img/candado.svg" id="icono-dos" class="icono" alt="">

                            <input type="password" name="passwordActual" id="inputDos" class="input-u input-modal inputDos col-11 "
                                placeholder="Contraseña actual" value="">

                            <a href="#" class="text-decoration-none btnMostrarContrase">
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
                        <p class="text-center m-0 pb-0 pt-3 fw-bolder">Nueva contraseña</p>
                        <div class="margen-input-u w-auto grpFormCorrect d-flex">

                            <img src="<?= $urlBase ?>../src/assets/img/candado.svg" id="icono-dos" class="icono" alt="">

                            <input type="password" name="passwordNew" id="claveNew" class="input-u inputDos input-modal col-11 "
                                placeholder="Nueva contraseña" value="">

                            <a href="#" class="text-decoration-none btnMostrarContrase">
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
                        <p class="text-center m-0 pb-0 pt-4 fw-bolder">Reescribe la contraseña</p>
                        <div class="margen-input-u w-auto grpFormCorrect d-flex">

                            <img src="<?= $urlBase ?>../src/assets/img/candado.svg" id="icono-dos" class="icono" alt="">

                            <input type="password" id="inputVClave" class="input-u inputDos col-11 input-modal"
                                placeholder="Reescribe la contraseña">

                            <a href="#" class="text-decoration-none btnMostrarContrase">
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
                        <a href="#" id="btnEUsuario" class="uk-button-text uk-button btnMostrar mt-2 me-4 "
                            uk-toggle="target: #modal-exampleEdita">Editar usuario</a>
                        <a href="#" class="color_lineaText pe-0 ps-0 uk-button btnMostrar mt-2">Editar contraseña</a>
                    </div>
                    <div class="uk-card-footer d-flex justify-content-start">
                        <a href="#" class="uk-button uk-button-text btnMostrar mt-2 uk-modal-close">Cancelar</a>
                        <button class="uk-button uk-button-text btnMostrar ms-4 mt-2" name="actualizarPassw"
                            id="btnAPassw">Actualizar</button>
                    </div>
                </div>
        </form>
    </div>
</div>