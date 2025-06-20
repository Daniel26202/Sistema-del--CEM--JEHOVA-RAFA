<!--MODAL MOSTAR-->


<div id="modal-exampleAgregar" uk-modal>
    <div class="uk-modal-dialog uk-modal-body tamaño-modal uk-card  uk-width-1-2@m">

        <form method="POST" class="formAgregarAdmin form-validable" action="/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/registrarAdmin"
            enctype="multipart/form-data">

            <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario'] ?>">

            <div id="padre">
                <div class="alert alert-danger text-center d-none" id="alertaAdmin">VERIFIQUE EL FORMULARIO ANTES DE
                    ENVIARLO</div>
                <div class="caja-imagen" id="contenedor-img">
                    <!-- <div class="uk-grid-small uk-flex-middle d-flex justify-content-center" uk-grid>
                            <div class="uk-width-auto">
                            <?php if ($dato["imagen"] != "doctor.png"): ?>
                       
                       <img src="./src/assets/img_ingresadas_por_usuarios/usuarios/<?= $dato['id_usuario'] . "_" . $dato['imagen'] ?>" class="uk-border-circle"  width="55" height="55" alt="Avatar">
                       <?php else: ?>
                           
                           <img src="./src/assets/img_ingresadas_por_usuarios/usuarios/<?= $dato['imagen'] ?>" class="uk-border-circle"  width="55" height="55" alt="Avatar">
                       <?php endif; ?>
                                
                            </div>

                        </div> -->
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
                                name="imagenUsuario" placeholder="Imagen" id="imagen">
                        </div>

                        <div class="input-group flex-nowrap margin-inputs" id="grp_cedula">
                            <span class="input-modal mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-person-vcard-fill azul" viewBox="0 0 16 16">
                                    <path
                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                                </svg>
                            </span>
                            <span class="">
                                <select class="form-control input-modal" aria-label="2" placeholder="Nacionalidad"
                                    name="nacionalidad">
                                    <option value="V" selected>V</option>
                                    <option value="E">E</option>
                                </select>
                            </span>

                            <input class="form-control input-modal input-modal input-disabled input-paciente input-u input-validar"
                                style="width: 7vh !important;" type="number" id="cedula" name="cedula"
                                placeholder="Cedula" required maxlength="8" minlength="6"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                        </div>
                        <p class="p-error-cedula d-none">La cedula debe contener únicamente números y estar entre 7 a 8 caracteres</p>

                        <div class="margen-input-u w-auto ">

                            <svg xmlns="http://www.w3.org/2000/svg" id="icono-dos" width="20" height="20"
                                fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            </svg>

                            <input type="text" name="nombre" id="inputDos" class="input-validar input-modal input-u col-12" placeholder="Nombre"
                                required>

                        </div>
                        <p class="p-error-nombre d-none">El Nombre debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres</p>

                        <div class="margen-input-u w-auto">

                            <svg xmlns="http://www.w3.org/2000/svg" id="icono-tres" width="20" height="20"
                                fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            </svg>

                            <input type="text" name="apellido" id="inputTres" class="input-validar input-modal input-u col-12"
                                placeholder="Apellido" required>

                        </div>

                        <p class="p-error-apellido d-none">El Apellido debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres</p>


                        <div class="margen-input-u w-auto">

                            <svg xmlns="http://www.w3.org/2000/svg" id="icono-tres" width="20" height="20"
                                fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            </svg>

                            <input type="number" name="telefono" id="inputTres" class="input-validar input-modal input-u col-12"
                                placeholder="Telefono" required>

                        </div>
                        <p class="p-error-telefono d-none">El Telefono solo debe contener y comen números, comenzando con "0412 o 0414 o 0416 o 0424 o 0426 o 0212 o 24"</p>


                        <div class="margen-input-modal -u w-auto">

                            <svg xmlns="http://www.w3.org/2000/svg" id="icono-tres" width="20" height="20"
                                fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            </svg>

                            <input type="email" name="correo" id="inputTres" class="input-validar input-modal input-u col-12" placeholder="Gamil"
                                required>

                        </div>

                        <p class="p-error-correo d-none">El correo debe contener letras , numeros y/o caracteres especiales y que contenga el @</p>


                        <div class="margen-input-u w-auto ">

                            <svg xmlns="http://www.w3.org/2000/svg" id="icono-dos" width="20" height="20"
                                fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            </svg>

                            <input type="text" name="usuario" id="inputDos" class="input-validar input-modal input-u col-12" placeholder="Usuario"
                                required>

                        </div>

                        <p class="p-error-usuario d-none">El usuario debe contener letras,numeros y caracteres especiales con ._- ademas iniciar con una letra mayúscula y tenga entre 8 a 16 caracteres</p>

                        <div class="margen-input-u w-auto ">

                            <svg xmlns="http://www.w3.org/2000/svg" id="icono-dos" width="20" height="20"
                                fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            </svg>

                            <select name="id_rol" class="input-modal input-u col-12" required>
                                <option selected disabled>Seleccionar Rol</option>
                                <?php foreach ($datosRoles as $dato): ?>
                                    <option value="<?= $dato["id_rol"] ?>"><?= $dato["nombre"] ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>


                        <div class="margen-input-u w-auto grpFormCorrect d-flex">

                            <img src="<?= $urlBase; ?>../src/assets/img/candado.svg" id="icono-dos" class="icono" alt="">

                            <input type="password" name="password" id="inputDos" class="input-validar input-modal input-u inputDos col-11 "
                                placeholder="Contraseña" required>

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

                        <p class="p-error-password d-none">La Contraseña debe contener de 8 a 12 caracteres, una mayúscula, un número y un símbolo</p>

                    </div>

                    <!-- inputs ocultos -->


                    <div class="uk-card-footer d-flex justify-content-start">
                        <a href="#" class="uk-button uk-button-text btnMostrar mt-2 uk-modal-close">Cancelar</a>
                        <input type="submit" class="uk-button uk-button-text btnMostrar ms-4 mt-2" name="actualizar"
                            value="Registrar">
                    </div>
                </div>
        </form>
    </div>
</div>



<script src="./src/assets/js/validacionesAdmin.js"></script>