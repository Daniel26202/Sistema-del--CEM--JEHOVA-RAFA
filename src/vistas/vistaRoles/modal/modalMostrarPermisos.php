<!--MODAL MOSTRAR-->
<?php foreach ($roles as $rol): ?>

    <div id="modal-exampleMostrar<?php echo $rol["id_rol"]; ?>" uk-modal>
        <div class="uk-modal-dialog uk-modal-body tamaño-modal uk-card uk-card-default uk-width-1-2@m">

            <div class="">

                <div class="modal-body text-center"></div>

                <h1 class="text-center">Modificar Rol</h1>

                <form action="/Sistema-del--CEM--JEHOVA-RAFA/Roles/modificarRol/<?= $rol["nombre"]; ?>" method="post" class="form-ajax form-validable<?= $rol["id_rol"]; ?> form">
                    <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario'] ?>">
                    <input type="hidden" name="id_rol" value="<?= $rol["id_rol"]; ?>">

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
                        <a href="#" class="uk-button uk-button-text btnMostrar mt-2 uk-modal-close" uk-toggle="target: #modal-exampleEliminar<?php echo $rol["id_rol"]; ?>">Eliminar</a>
                        <button type=" submit" class="ico uk-button uk-button-text btnMostrar ms-4 mt-2">Modificar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php endforeach ?>




<!-- modal de registrar nuevo rol -->


<!--MODAL MOSTRAR-->

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

                                                                                <div class="form-check form-switch d-flex align-items-center <?= $modulo == "Patologias" || $modulo == "Reportes" || $modulo == "Estadisticas" ? "d-none" : ""; ?>">
                                                                                    <div>
                                                                                        <input class="form-check-input form-check-js checkboxPermiso" type="checkbox" role="switch"
                                                                                            value="editar" name="<?= $permisosPorModulo ?>" data-index="<?= $modulo ?>">
                                                                                    </div>
                                                                                    <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">
                                                                                            Editar
                                                                                        </label></div>
                                                                                </div>

                                                                                <div class="form-check form-switch d-flex align-items-center <?= $modulo == "Control" || $modulo == "Reportes" || $modulo == "Estadisticas" ? "d-none" : ""; ?>">
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





<?php require_once "./src/vistas/vistaRoles/modal/modalEliminarRol.php"; ?>