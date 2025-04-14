<!--MODAL MOSTRAR-->
<?php foreach ($roles as $rol): ?>

    <div id="modal-exampleMostrar<?php echo $rol["id_rol"]; ?>" uk-modal>
        <div class="uk-modal-dialog uk-modal-body tamaño-modal uk-card uk-card-default uk-width-1-2@m">

            <div class="">


                <h1 class="text-center">Modificar Rol <?= $rol["nombre"]; ?></h1>

                <form action="/Sistema-del--CEM--JEHOVA-RAFA/Roles/modificarRol" method="post" class="form-validable<?= $rol["id_rol"]; ?>">
                    <div class="caja-de-permisos<?= $rol["id_rol"]; ?> ">


                        <!-- nombre del rol -->

                        <label class="mb-3 mt-1">Nombre del Rol</label>
                        <div class="margen-input-u w-auto ">

                            <svg xmlns="http://www.w3.org/2000/svg" id="icono-dos" width="20" height="20"
                                fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            </svg>

                            <input type="text" name="nombre" id="inputDos" class="input-u col-12 input-validar" placeholder="Nombre Del Rol"
                                required value="<?= $rol["nombre"] ?>">

                        </div>

                        <p class="d-none p-error-nombre<?= $rol["id_rol"] ?>">El Nombre debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres</p>


                        <!-- descripcion -->

                        <label class="mb-3 mt-1">Descripcion</label>
                        <div class="margen-input-u w-auto ">

                            <svg xmlns="http://www.w3.org/2000/svg" id="icono-dos" width="20" height="20"
                                fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            </svg>

                            <!-- <input type="text" name="nombre" id="inputDos" class="input-u col-12" placeholder="Nombre Del Rol"
                    required> -->
                            <input name="descripcion" class="input-u col-12 input-validar" style="height: 80px;" placeholder="Descripcion del permiso" value="<?= $rol["descripción"] ?>">

                        </div>

                        <p class="d-none p-error-descripcion<?= $rol["id_rol"] ?>">La Descripcion debe ser breve de al menos 8 caracteres</p>

                        <input type="hidden" name="id_rol" value="<?= $rol["id_rol"]; ?>">

                        <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario'] ?>">

                        <h4 class="mt-3 text-center">Modificar Permisos</h4>

                        <div class="mt-2 form-check form-switch d-flex align-items-center">
                            <div>
                                <input class="form-check-input checkboxTodosLosPermisos<?= $rol["id_rol"]; ?>" type="checkbox" role="switch">
                            </div>
                            <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">

                                    Seleccionar Todos los permisos
                                </label></div>

                        </div>


                        <!-- Pacientes -->
                        <div class="input-modal mt-3">
                            <ul uk-accordion="multiple: true" class="uk-accordion">
                                <li class="">
                                    <a
                                        class="uk-accordion-title text-decoration-none"
                                        href="#"
                                        id="uk-accordion-22-title-0"
                                        role="button"
                                        aria-controls="uk-accordion-22-content-0"
                                        aria-expanded="false"
                                        aria-disabled="false">
                                        <h6 class="acordion-mostrar fw-2">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="20"
                                                height="20"
                                                fill="currentColor"
                                                class="bi bi-calendar2-week-fill azul mb-2"
                                                viewBox="0 0 16 16">
                                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zM8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"></path>
                                            </svg>
                                            Pacientes
                                        </h6>
                                    </a>


                                    <input type="hidden" name="modulos[]" value="Pacientes">

                                    <?php $permisosPorModulo = "permisosPacientes[]"  ?>

                                    <?php $modulo = "Pacientes"  ?>

                                    <input type="hidden" name="permisos[]" value="permisosPacientes">


                                    <div
                                        class="uk-accordion-content"
                                        id="uk-accordion-22-content-0"
                                        role="region"
                                        aria-labelledby="uk-accordion-22-title-0"
                                        hidden="">



                                        <?php // require_once "..listaDePermisos.php"  
                                        ?>

                                        <?php require './src/vistas/vistaRoles/listaDePermisos.php'; ?>





                                    </div>
                                </li>
                            </ul>
                        </div>



                        <!-- Patologias -->

                        <div class="input-modal mt-3">
                            <ul uk-accordion="multiple: true" class="uk-accordion">
                                <li class="">
                                    <a
                                        class="uk-accordion-title text-decoration-none"
                                        href="#"
                                        id="uk-accordion-22-title-0"
                                        role="button"
                                        aria-controls="uk-accordion-22-content-0"
                                        aria-expanded="false"
                                        aria-disabled="false">
                                        <h6 class="acordion-mostrar fw-2">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="20"
                                                height="20"
                                                fill="currentColor"
                                                class="bi bi-calendar2-week-fill azul mb-2"
                                                viewBox="0 0 16 16">
                                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zM8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"></path>
                                            </svg>
                                            Patologias
                                        </h6>
                                    </a>


                                    <input type="hidden" name="modulos[]" value="Patologias">

                                    <?php $permisosPorModulo = "permisosPatologias[]"  ?>

                                    <?php $modulo = "Patologias"  ?>

                                    <input type="hidden" name="permisos[]" value="permisosPatologias">

                                    <div
                                        class="uk-accordion-content"
                                        id="uk-accordion-22-content-0"
                                        role="region"
                                        aria-labelledby="uk-accordion-22-title-0"
                                        hidden="">



                                        <?php // require_once "..listaDePermisos.php"  
                                        ?>

                                        <?php require './src/vistas/vistaRoles/listaDePermisos.php'; ?>





                                    </div>
                                </li>
                            </ul>
                        </div>




                    </div>



                    <!-- botones -->
                    <div class="uk-card-footer d-flex justify-content-start">

                        <button href="#" class="uk-button uk-button-text btnMostrar mt-2 ms-4 editarUsuario"
                            type="submit">Modificar</button>
                        <a href="#" class="uk-button uk-button-text btnMostrar mt-2 ms-4"
                            uk-toggle="target: #modal-exampleEliminar<?php echo $rol["id_rol"]; ?>">Eliminar</a>
                    </div>
                </form>
            </div>

        </div>
    </div>

<?php endforeach ?>

<?php //require_once("./src/vistas/vistaUsuarios/modal/modalEditarAdmin.php") 
?>
<?php //require_once("./src/vistas/vistaUsuarios/modal/modalEliminarAdmin.php") 
?>








<!-- modal de registrar nuevo rol -->


<!--MODAL MOSTRAR-->

<div id="modal-exampleGuardar" uk-modal>
    <div class="uk-modal-dialog uk-modal-body tamaño-modal uk-card uk-card-default uk-width-1-2@m">











        <div class="">

            <form action="/Sistema-del--CEM--JEHOVA-RAFA/Roles/guardarRol" method="post" class="form-validable">



                <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario'] ?>">

                <h1 class="text-center">Registrar Rol</h1>


                <!-- nombre del rol -->

                <label class="mb-3 mt-1">Nombre del Rol</label>
                <div class="margen-input-u w-auto ">

                    <svg xmlns="http://www.w3.org/2000/svg" id="icono-dos" width="20" height="20"
                        fill="currentColor" class="bi bi-person-fill icono" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                    </svg>

                    <input type="text" name="nombre" id="inputDos" class="input-u col-12 input-validar" placeholder="Nombre Del Rol"
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

                    <!-- <input type="text" name="nombre" id="inputDos" class="input-u col-12" placeholder="Nombre Del Rol"
                    required> -->
                    <input name="descripcion" class="input-u col-12 input-validar" style="height: 80px;" placeholder="Descripcion del permiso">

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



                <div class=" caja-de-permisos">
                    <!-- <h4>Pacientes</h4>
                    <div class=" bg-danger d-flex flex-wrap">
                        <div class="form-check form-switch d-flex align-items-center">
                            <div>
                                <input class="form-check-input " type="checkbox" role="switch"   
                                    value="">
                            </div>
                            <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">
                                    Nombre del permiso
                                </label></div>

                        </div>
                    </div>
                     -->




                    <!-- Pacientes -->
                    <div class="input-modal mt-3">
                        <ul uk-accordion="multiple: true" class="uk-accordion">
                            <li class="">
                                <a
                                    class="uk-accordion-title text-decoration-none"
                                    href="#"
                                    id="uk-accordion-22-title-0"
                                    role="button"
                                    aria-controls="uk-accordion-22-content-0"
                                    aria-expanded="false"
                                    aria-disabled="false">
                                    <h6 class="acordion-paciente fw-2">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="20"
                                            height="20"
                                            fill="currentColor"
                                            class="bi bi-calendar2-week-fill azul mb-2"
                                            viewBox="0 0 16 16">
                                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zM8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"></path>
                                        </svg>
                                        Pacientes
                                    </h6>
                                </a>

                                <!-- id oculto para mandar el nombre del modulo -->

                                <input type="hidden" name="modulos[]" value="Pacientes">


                                <?php $permisosPorModulo = "permisosPacientes[]"  ?>

                                <input type="hidden" name="permisos[]" value="permisosPacientes">

                                <div
                                    class="uk-accordion-content"
                                    id="uk-accordion-22-content-0"
                                    role="region"
                                    aria-labelledby="uk-accordion-22-title-0"
                                    hidden="">



                                    <div class="d-flex justify-content-between flex-wrap ">

                                        <div class="form-check form-switch d-flex align-items-center">
                                            <div>
                                                <input class="form-check-input form-check-js checkboxPermiso" data-index="<?= $modulo ?>" type="checkbox" role="switch"
                                                    value="consultar" name="<?= $permisosPorModulo ?>">
                                            </div>
                                            <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">

                                                    Consultar
                                                </label></div>

                                        </div>


                                        <div class="form-check form-switch d-flex align-items-center">
                                            <div>
                                                <input class="form-check-input form-check-js checkboxPermiso" type="checkbox" role="switch" data-index="<?= $modulo ?>"
                                                    value="guardar" name="  <?= $permisosPorModulo ?>">
                                            </div>
                                            <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">

                                                    Guardar
                                                </label></div>

                                        </div>


                                        <div class="form-check form-switch d-flex align-items-center">
                                            <div>
                                                <input class="form-check-input form-check-js checkboxPermiso" type="checkbox" role="switch"
                                                    value="editar" name="  <?= $permisosPorModulo ?>" data-index="<?= $modulo ?>">
                                            </div>
                                            <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">

                                                    Editar
                                                </label></div>

                                        </div>

                                        <div class="form-check form-switch d-flex align-items-center">
                                            <div>
                                                <input class="form-check-input form-check-js checkboxPermiso" type="checkbox" role="switch"
                                                    value="eliminar" name="  <?= $permisosPorModulo ?>" data-index="<?= $modulo ?>">
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



                    <!-- Patologias -->

                    <div class="input-modal mt-3">
                        <ul uk-accordion="multiple: true" class="uk-accordion">
                            <li class="">
                                <a
                                    class="uk-accordion-title text-decoration-none"
                                    href="#"
                                    id="uk-accordion-22-title-0"
                                    role="button"
                                    aria-controls="uk-accordion-22-content-0"
                                    aria-expanded="false"
                                    aria-disabled="false">
                                    <h6 class="acordion-paciente fw-2">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="20"
                                            height="20"
                                            fill="currentColor"
                                            class="bi bi-calendar2-week-fill azul mb-2"
                                            viewBox="0 0 16 16">
                                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zM8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"></path>
                                        </svg>
                                        Patologias
                                    </h6>
                                </a>


                                <input type="hidden" name="modulos[]" value="Patologias">

                                <?php $permisosPorModulo = "permisosPatologias[]"  ?>

                                <input type="hidden" name="permisos[]" value="permisosPatologias">

                                <div
                                    class="uk-accordion-content"
                                    id="uk-accordion-22-content-0"
                                    role="region"
                                    aria-labelledby="uk-accordion-22-title-0"
                                    hidden="">



                                    <div class="d-flex justify-content-between flex-wrap ">

                                        <div class="form-check form-switch d-flex align-items-center">
                                            <div>
                                                <input class="form-check-input form-check-js checkboxPermiso" data-index="<?= $modulo ?>" type="checkbox" role="switch"
                                                    value="consultar" name="<?= $permisosPorModulo ?>">
                                            </div>
                                            <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">

                                                    Consultar
                                                </label></div>

                                        </div>


                                        <div class="form-check form-switch d-flex align-items-center">
                                            <div>
                                                <input class="form-check-input form-check-js checkboxPermiso" type="checkbox" role="switch" data-index="<?= $modulo ?>"
                                                    value="guardar" name="  <?= $permisosPorModulo ?>">
                                            </div>
                                            <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">

                                                    Guardar
                                                </label></div>

                                        </div>


                                        <div class="form-check form-switch d-flex align-items-center">
                                            <div>
                                                <input class="form-check-input form-check-js checkboxPermiso" type="checkbox" role="switch"
                                                    value="editar" name="  <?= $permisosPorModulo ?>" data-index="<?= $modulo ?>">
                                            </div>
                                            <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">

                                                    Editar
                                                </label></div>

                                        </div>

                                        <div class="form-check form-switch d-flex align-items-center">
                                            <div>
                                                <input class="form-check-input form-check-js checkboxPermiso" type="checkbox" role="switch"
                                                    value="eliminar" name="  <?= $permisosPorModulo ?>" data-index="<?= $modulo ?>">
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




                </div>



                <!-- botones -->
                <div class="uk-card-footer d-flex justify-content-start">
                    <a href="#" class="uk-button uk-button-text btnMostrar mt-2 uk-modal-close">Cancelar</a>
                    <input type="submit" class="uk-button uk-button-text btnMostrar ms-4 mt-2" name="guardar"
                        value="Registrar">
                </div>
        </div>

        </form>







    </div>
</div>





<?php require_once "./src/vistas/vistaRoles/modal/modalEliminarRol.php"; ?>