<!--MODAL MOSTRAR-->
<?php foreach ($roles as $rol): ?>

    <div id="modal-exampleMostrar<?php echo $rol["id_rol"]; ?>" uk-modal>
        <div class="uk-modal-dialog uk-modal-body tamaño-modal uk-card uk-card-default uk-width-1-2@m">

            <div class="">

                <div class="modal-body text-center"></div>

                <h1 class="text-center">Modificar Rol</h1>

                <form method="post" data-index="<?= $rol["id_rol"]; ?>" class="form-ajax forms-editar form-validable<?= $rol["id_rol"]; ?> form">
                    <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario'] ?>">
                    <input type="hidden" name="id_rol" value="<?= $rol["id_rol"]; ?>">

                    <input type="hidden" name="nombreRegistrado" value="<?= $rol["nombre"]; ?>">


                    <!-- nombre del rol -->
                    <label class="mb-3 mt-1">Nombre del Rol</label>
                    <div class="margen-input-u w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" id="icono-dos" width="20" height="20" fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                        </svg>
                        <input type="text" name="nombre" id="inputDos" class="modal-input input-modal input-u col-12 input-validar" placeholder="Nombre Del Rol" required value="<?= $rol["nombre"] ?>">
                    </div>
                    <p class="p-error-nombre d-none">El Nombre debe contener solo letras, iniciar con una letra mayúscula y tener al menos 3 caracteres</p>

                    <!-- descripcion -->
                    <label class="mb-3 mt-1">Descripcion</label>
                    <div class="margen-input-u w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" id="icono-dos" width="20" height="20" fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                        </svg>
                        <input name="descripcion" class="input-u col-12 input-modal input-validar" style="height: 80px;" placeholder="Descripcion del permiso" value="<?= $rol["descripción"] ?>">
                    </div>
                    <p class="p-error-descripcion d-none">La Descripcion debe ser breve y tener al menos 8 caracteres</p>

                    <h4 class="mb-3 mt-1 text-center">Modificar Permisos</h4>

                    <div class="mt-2 form-check form-switch d-flex align-items-center">
                        <div>
                            <input class="form-check-input checkboxTodosLosPermisos<?= $rol["id_rol"]; ?>" type="checkbox" role="switch">
                        </div>
                        <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">Seleccionar Todos los permisos</label></div>
                    </div>

                    <div class="caja-de-permisos">
                        <ul uk-accordion="multiple: true" class="uk-accordion accordion-section">
                            <?php foreach ($categorias as $categoria => $modulos): ?>
                                <div class="d-flex flex-wrap">
                                    <?php foreach ($categorias as $categoria => $modulos): ?>
                                        <div class="w-100 p-2">
                                            <ul uk-accordion="multiple: true" class="uk-accordion accordion-section">
                                                <li>
                                                    <a class="uk-accordion-title text-decoration-none" href="#">
                                                        <h6 class="acordion-mostrar fw-2"><?= $categoria ?></h6>
                                                    </a>
                                                    <div class="uk-accordion-content " hidden="">
                                                        <div class="d-flex justify-content-between flex-wrap">
                                                            <?php foreach ($modulos as $modulo): ?>
                                                                <div class="input-modal mt-3  p-2" style="width: 48%;">
                                                                    <ul uk-accordion="multiple: false" class="uk-accordion accordion-section">
                                                                        <li>
                                                                            <a class="uk-accordion-title text-decoration-none" href="#">
                                                                                <h6 class="acordion-mostrar fw-2">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                                                        fill="currentColor" class="bi bi-calendar2-week-fill azul mb-2"
                                                                                        viewBox="0 0 16 16">
                                                                                    </svg>
                                                                                    <?= $modulo["modulo"]; ?>
                                                                                </h6>
                                                                            </a>
                                                                            <div class="uk-accordion-content" hidden="">
                                                                                <?php require "./src/vistas/vistaRoles/listaDePermisos.php" ?>;
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php break; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- botones -->
                    <div class="uk-card-footer d-flex justify-content-start">
                        <button class="uk-button uk-button-text btnMostrar btn-eliminar  mt-2 uk-modal-close" data-index="<?= $rol['id_rol'] ?>">Eliminar</button>
                        <button class="ico uk-button uk-button-text btnMostrar ms-4 mt-2">Modificar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php endforeach ?>




<!-- modal de registrar nuevo rol -->


<!--MODAL Guardar-->

<div id="modal-exampleGuardar" uk-modal>
    <div class="uk-modal-dialog uk-modal-body tamaño-modal uk-card uk-card-default uk-width-1-2@m">

        <div class="">

            <div class="modal-body text-center"></div>

            <form action="/Sistema-del--CEM--JEHOVA-RAFA/Roles/guardarRol" method="post" class="form-validable form form-ajax">

                <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario'] ?>">

                <h1 class="text-center">Registrar Rol</h1>

                <!-- nombre del rol -->
                <label class="mb-3 mt-1">Nombre del Rol</label>
                <div class="margen-input-u w-auto ">
                    <svg xmlns="http://www.w3.org/2000/svg" id="icono-dos" width="20" height="20"
                        fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                    </svg>
                    <input type="text" name="nombre" id="inputDos" class="input-u input-modal col-12 input-validar" placeholder="Nombre Del Rol"
                        required>
                </div>
                <p class="p-error-nombre d-none">El Nombre debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres</p>

                <!-- descripcion -->
                <label class="mb-3 mt-1">Descripcion</label>
                <div class="margen-input-u w-auto ">
                    <svg xmlns="http://www.w3.org/2000/svg" id="icono-dos" width="20" height="20"
                        fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                    </svg>
                    <input name="descripcion" class="input-u col-12 input-validar input-modal" style="height: 80px;" placeholder="Descripcion del permiso">
                </div>
                <p class="p-error-descripcion d-none">La Descripcion debe ser breve de al menos 8 caracteres</p>

                <h4 class="mb-3 mt-1 text-center">Permisos para el Rol</h4>

                <div class="mt-2 form-check form-switch d-flex align-items-center">
                    <div>
                        <input class="form-check-input checkboxTodosLosPermisos" type="checkbox" role="switch">
                    </div>
                    <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">
                            Seleccionar Todos los permisos
                        </label></div>
                </div>

                <div class="caja-de-permisos">
                    <ul uk-accordion="multiple: true" class="uk-accordion accordion-section">
                        <?php foreach ($categorias as $categoria => $modulos): ?>
                            <div class="d-flex flex-wrap">
                                <?php foreach ($categorias as $categoria => $modulos): ?>
                                    <div class="w-100 p-2">
                                        <ul uk-accordion="multiple: true" class="uk-accordion accordion-section">
                                            <li>
                                                <a class="uk-accordion-title text-decoration-none" href="#">
                                                    <h6 class="acordion-mostrar fw-2"><?= $categoria ?></h6>
                                                </a>
                                                <div class="uk-accordion-content " hidden="">
                                                    <div class="d-flex justify-content-between flex-wrap">
                                                        <?php foreach ($modulos as $modulo): ?>
                                                            <div class="input-modal mt-3  p-2" style="width: 48%;">
                                                                <ul uk-accordion="multiple: false" class="uk-accordion accordion-section">
                                                                    <li>
                                                                        <a class="uk-accordion-title text-decoration-none" href="#">
                                                                            <h6 class="acordion-mostrar fw-2">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                                                    fill="currentColor" class="bi bi-calendar2-week-fill azul mb-2"
                                                                                    viewBox="0 0 16 16">
                                                                                </svg>
                                                                                <?= $modulo["modulo"]; ?>
                                                                            </h6>
                                                                        </a>
                                                                        <div class="uk-accordion-content" hidden="">
                                                                            <div class="d-flex justify-content-between flex-wrap">
                                                                                <?php $permisosPorModulo = $modulo['permisosPorModulo'] . "[]"  ?>
                                                                                <input type="hidden" name="modulos[]" value="<?= $modulo["modulo"]; ?>">
                                                                                <input type="hidden" name="permisos[]" value="<?= $modulo['permisosPorModulo']; ?>">
                                                                                <?php $modulo = $modulo["modulo"];  ?>

                                                                                <div class="form-check form-switch d-flex align-items-center">
                                                                                    <div>
                                                                                        <input class="form-check-input form-check-js checkboxPermiso" data-index="<?= $modulo ?>" type="checkbox" role="switch"
                                                                                            value="consultar" name="<?= $permisosPorModulo ?>">
                                                                                    </div>
                                                                                    <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">
                                                                                            Consultar
                                                                                        </label></div>
                                                                                </div>

                                                                                <div class="form-check form-switch d-flex align-items-center <?= $modulo == "Reportes" || $modulo == "Estadisticas" ? "d-none" : ""; ?>">
                                                                                    <div>
                                                                                        <input class="form-check-input form-check-js checkboxPermiso" type="checkbox" role="switch" data-index="<?= $modulo ?>"
                                                                                            value="guardar" name="<?= $permisosPorModulo ?>">
                                                                                    </div>
                                                                                    <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">
                                                                                            Guardar
                                                                                        </label></div>
                                                                                </div>

                                                                                <div class="form-check form-switch d-flex align-items-center <?= $modulo == "Patologias" || $modulo == "Reportes" || $modulo == "Estadisticas" || $modulo == "Factura" || $modulo == "Mantenimiento" ? "d-none" : ""; ?>">
                                                                                    <div>
                                                                                        <input class="form-check-input form-check-js checkboxPermiso" type="checkbox" role="switch"
                                                                                            value="editar" name="<?= $permisosPorModulo ?>" data-index="<?= $modulo ?>">
                                                                                    </div>
                                                                                    <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">
                                                                                            Editar
                                                                                        </label></div>
                                                                                </div>

                                                                                <div class="form-check form-switch d-flex align-items-center <?= $modulo == "Control" || $modulo == "Reportes" || $modulo == "Estadisticas" || $modulo == "Mantenimiento" ? "d-none" : ""; ?>">
                                                                                    <div>
                                                                                        <input class="form-check-input form-check-js checkboxPermiso" type="checkbox" role="switch"
                                                                                            value="eliminar" name="<?= $permisosPorModulo ?>" data-index="<?= $modulo ?>">
                                                                                    </div>
                                                                                    <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">
                                                                                            Eliminar
                                                                                        </label></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php break; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- botones -->
                <div class="uk-card-footer d-flex justify-content-start">
                    <a href="#" class="uk-button uk-button-text btnMostrar mt-2 uk-modal-close">Cancelar</a>
                    <input type="submit" class="ico uk-button uk-button-text btnMostrar ms-4 mt-2" name="guardar"
                        value="Registrar">
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal Agregar-->
<div class="modal fade" id="exampleGuardarRol" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content tamaño-modal">
            <div class="modal-header">
                <h5 class="modal-title fs-4 fw-bold" id="exampleModalLabelPaciente">Registrar Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class=" form-validable" id="modalAgregar">

                <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario'] ?>">

                <input type="hidden" name="cedulaRegistrada" id="cedulaRegistrada">

                <input type="hidden" name="id" id="id_paciente">


                <div class="modal-body">
                    <label class="label-custom">Nombre</label>
                    <div class="campo-custom">
                        <div class="input-custom">
                            <span class="icono-izq">
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                </svg>
                            </span>
                            <input class="form-control txt-custom input-validar inputs" name="nombre" type="text" placeholder="Nombre">
                            <span class="icono-der">
                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                </svg>
                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </span>
                        </div>
                        <p class="error-msg d-none"></p>
                    </div>
                </div>



                <label class="label-custom">Descripcion</label>
                <div class="campo-custom">
                    <div class="input-custom">
                        <span class="icono-izq">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                            </svg>
                        </span>
                        <input class="form-control txt-custom input-validar inputs" name="descripcion" type="text" placeholder="Descripcion">
                        <span class="icono-der">
                            <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                            </svg>
                            <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </span>
                    </div>
                    <p class="error-msg d-none"></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-modals-cancelar me-2" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-modals" id="botonModal">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>