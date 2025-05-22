<?php require_once './src/vistas/head/head.php'; ?>

<div class="container pb-1">
    <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
        <div class="ms-5 d-flex align-items-center">

            <h1 class="fw-bold mt-2">ROLES</h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" fill="currentColor"
                class="bi bi-person-square ms-2" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                <path
                    d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
            </svg>

        </div>

        <?php require_once './src/vistas/tasaBCV.php'; ?>

        <div class="me-4">
            <!-- requerir los botones -->
            <?php require_once './src/vistas/btnOpciones.php'; ?>
        </div>
    </div>

    <div class="d-flex justify-content-center">

        <?php if (isset($_GET["error"])): ?>
            <div class="uk-alert-danger comentario comentarioRed me-3 ms-5 fw-bolder h-25" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">El Usuario ya Existe Por favor ingrese un usuario distinto.</p>
            </div>
        <?php endif ?>
        <?php if (isset($_GET["editado"])): ?>
            <div class="uk-alert-primary comentario me-4 fw-bolder h-25" style="display: none;" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">Se actualizo correctamente.</p>
            </div>
        <?php endif ?>
        <?php if (isset($_GET["eliminado"])): ?>
            <div class="uk-alert-primary comentario me-4 fw-bolder h-25" style="display: none;" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">Se ha eliminado correctamente.</p>
            </div>
        <?php endif ?>
        <?php if (isset($_GET["agregado"])): ?>
            <div class="uk-alert-primary comentario me-4 fw-bolder h-25" style="display: none;" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">Se ha agregado correctamente.</p>
            </div>
        <?php endif ?>

    </div>

    <!-- modal de cerrar sesión -->
    <?php require_once './src/vistas/modalCierreS/modalCierreS.php'; ?>


    <?php if ($parametro != ""): ?>


        <?php if ($parametro[0] == "error"): ?>
            <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder alertaGenerica h-25 text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">El nombre del rol ya existen, intente de nuevo con otro nombre.</p>
            </div>
            <div class="d-flex justify-content-center">
            <?php elseif ($parametro[0] == "registro"): ?>
                <div class="uk-alert-primary comentarioD  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p class="pe-2">Se registro el rol correctamente.</p>
                </div>
            <?php elseif ($parametro[0] == "editar"): ?>
                <div class="uk-alert-primary comentarioD  me-4 fw-bolder  alertaGenerica text-center" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p class="pe-2">Se actualizo el rol correctamente.</p>
                </div>
            <?php elseif ($parametro[0] == "eliminar"): ?>
                <div class="uk-alert-primary comentarioD  me-4 fw-bolder  alertaGenerica text-center" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p class="pe-2">Se ha eliminado el rol correctamente.</p>
                </div>
            <?php elseif ($parametro[0] == "restablecido"): ?>
                <div class="uk-alert-primary comentarioD  me-4 fw-bolder alertaGenerica text-center" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p class="pe-2">Se ha restablecido el rol correctamente.</p>
                </div>

                <div class="d-flex justify-content-center">
                <?php elseif ($parametro[0] == "errorfecha"): ?>
                    <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p class="pe-2">la fecha de nacimiento no concuerda, intente de nuevo.</p>
                    </div>

                </div>
            <?php endif ?>
        <?php endif ?>


        <!--AGREGAR Y BUSCAR-->
        <div class="fondo-tabla">
            <div class="d-flex justify-content-between align-items-center">
                <div class="">
                    <button class="btn btn-primary btn-agregar-doctores col-11" uk-toggle="target: #modal-exampleGuardar"
                        id="btnRegistrarrol">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor"
                            class="bi bi-person-square me-2" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            <path
                                d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
                        </svg>Registrar Rol
                    </button>
                </div>
                <!-- Buscador de Usuarios -->
                <div class="d-flex justify-content-end mt-3 mb-3 col-3">
                    <input class="form-control input-busca" type="text" name="" placeholder="Ingrese nombre"
                        id="buscarRol">
                    <button class="btn boton-buscar" title="Buscar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
            </div>


            <div class="d-flex">

                <div class="me-3 mb-4  d-flex justify-content-end w-100">


                    <ul class="ico sin-circulos d-flex justify-content-end">

                        <li class="li">
                            <div class="borde-de-menu  mb-1 "></div>
                            <div class="hover-grande">
                                <a href="/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/usuarios" class="text-decoration-none me-3 color-letras "
                                    id="DMservicioMedico">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-person-square ms-2 " viewBox="0 0 16 16">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                        <path
                                            d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
                                    </svg>Usuario</a>
                            </div>
                        </li>
                        <li class="li">
                            <div class="borde-de-menu  mb-1 "></div>
                            <div class="hover-grande">
                                <a href="/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/administradores" class="text-decoration-none me-3 color-letras "
                                    id="DMservicioMedico">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-person-square ms-2 " viewBox="0 0 16 16">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                        <path
                                            d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
                                    </svg>Administrador</a>
                            </div>
                        </li>

                        <li class="li">
                            <div class="borde-de-menu mb-1 activo-border"></div>
                            <div class="hover-grande">
                                <a href="/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/administradores" class=text-decoration-none me-3 azul me-3
                                    iconoDoctor" id="DMdoctores">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-person-square ms-2" viewBox="0 0 16 16">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                        <path
                                            d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
                                    </svg>Roles</a>
                            </div>

                        </li>




                    </ul>

                </div>
            </div>

            <!--TARJETAS DE roles-->

            <!-- linea -->
            <hr class="mb-4 pb-2">


            <?php if ($roles): ?>


                <div class="d-flex flex-wrap justify-content-center ms-5 me-5">
                    <?php foreach ($roles as $rol): ?>


                        <div
                            class="card  contenido col-9 col-sm-6 col-lg-3 tarjeta ms-2 me-4 d-flex align-items-center justify-content-center tarjeta" style="max-height: 420px;">




                            <img src="<?= $urlBase ?>../src/assets/img/logoRol.jpeg" class="mt-2"
                                alt="...">

                            <div class="mt-3">
                                <div class="ps-3 pe-3 text-center buscar">

                                    <h5 class="card-title mb-1 ">
                                        <?= $rol["nombre"]; ?>
                                    </h5>
                                    <p class="mb-4">
                                        <?= $rol["descripción"]; ?>
                                    </p>

                                </div>

                                <div class="d-flex align-items-center justify-content-center flex-column">
                                    <div class=" mb-3">
                                        <a href="#" class="btn btn-User text-decoration-none btn-mostrar-permisos botonesEdi"
                                            uk-toggle="target: #modal-exampleMostrar<?php echo $rol["id_rol"]; ?>" data-index="<?php echo $rol["id_rol"]; ?>">Mostrar</a>
                                    </div>

                                </div>
                            </div>
                        </div>



                        <!-- <div colspan="9" class="text-center">NO HAY REGISTROS

                </div> -->



                    <?php endforeach; ?>

                </div>




            <?php else: ?>

                <div colspan="9" class="text-center">NO HAY REGISTROS

                </div>

            <?php endif; ?>


        </div>
            </div>



            <?php require_once './src/vistas/vistaRoles/modal/modalMostrarPermisos.php'; ?>
            <?php require_once './src/vistas/head/footer.php'; ?>

            <script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/roles.js"></script>

            <!-- <script type="text/javascript" src="./src/assets/js/usuarios.js"></script> -->