<?php require_once './src/vistas/head/head.php'; ?>

<div class="container pb-1">
    <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
        <div class="ms-5 d-flex align-items-center">

            <h1 class="fw-bold mt-2">USUARIOS</h1>
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

        <?php if ($parametro != ""): ?>
            <?php if ($parametro[0] == "error"): ?>

                <div class="uk-alert-danger comentario comentarioRed me-3 ms-5 fw-bolder h-25" style="display: none;"
                    uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p class="pe-2">La cédula o el usuario ya existen, intente de nuevo.</p>
                </div>
            <?php endif ?>
            <?php if ($parametro[0] == "editado"): ?>
                <div class="uk-alert-primary comentario me-4 fw-bolder h-25" style="display: none;" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p class="pe-2">Se actualizo correctamente.</p>
                </div>
            <?php endif ?>
            <?php if ($parametro[0] == "eliminado"): ?>
                <div class="uk-alert-primary comentario me-4 fw-bolder h-25" style="display: none;" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p class="pe-2">Se ha eliminado correctamente.</p>
                </div>
            <?php endif ?>
            <?php if ($parametro[0] == "agregado"): ?>
                <div class="uk-alert-primary comentario me-4 fw-bolder h-25" style="display: none;" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p class="pe-2">Se ha agregado correctamente.</p>
                </div>
            <?php endif ?>
            <?php if ($parametro[0] == "errorSistem"): ?>
                <div class="uk-alert-primary comentario me-4 fw-bolder h-25" style="display: none;" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p class="pe-2">lamentablemente ocurrio un error por favor intente mas tarde.</p>
                </div>
            <?php endif ?>
        <?php endif; ?>
    </div>




    <!-- modal de cerrar sesión -->
    <?php require_once './src/vistas/modalCierreS/modalCierreS.php'; ?>

    <!--AGREGAR Y BUSCAR-->
    <div class="fondo-tabla">
        <div class="d-flex justify-content-end align-items-center">

            <!-- Buscador de Usuarios -->
            <div class="d-flex justify-content-end mt-3 mb-3 col-3">
                <input class="form-control input-busca" type="text" name="" placeholder="Ingrese nombre" id="Buscarusuario">
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

            <div class=" me-3 mb-4  d-flex justify-content-end w-100">


                <ul class="ico sin-circulos d-flex justify-content-end">

                    <li class="li">
                        <div class="borde-de-menu  mb-1 activo-border"></div>
                        <div class="hover-grande">
                            <a href="/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/usuarios" class="text-decoration-none me-3 azul" id="DMservicioMedico">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-person-square ms-2 " viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path
                                        d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
                                </svg>Usuario</a>
                        </div>
                    </li>
                    <li class="li">
                        <div class="borde-de-menu mb-1 "></div>
                        <div class="hover-grande">
                            <a href="/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/administradores" class="text-decoration-none me-3 color-letras iconoDoctor" id="DMdoctores">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-person-square ms-2" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path
                                        d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
                                </svg>Administrador</a>
                        </div>

                    </li>


                    <li class="li">
                        <div class="borde-de-menu mb-1 "></div>
                        <div class="hover-grande">
                            <a href="/Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar" class="text-decoration-none me-3 color-letras iconoDoctor" id="DMdoctores">
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

        <!--TARJETAS DE Usuarios-->

        <!-- linea -->
        <hr class="mb-4 pb-2">

        <div class="d-flex flex-wrap justify-content-center ms-5 me-5 ">
            <?php if ($datosU): ?>

                <?php foreach ($datosU as $dato): ?>

                    <div class="card contenido col-9 col-sm-6 col-lg-3 tarjeta ms-2 me-4 d-flex align-items-center justify-content-center tarjeta">
                        <?php if ($dato["imagen"] != "doctor.png"): ?>

                            <img src="<?= $urlBase ?>../src/assets/img_ingresadas_por_usuarios/usuarios/<?= $dato['id_usuario'] . "_" . $dato['imagen'] ?>" class="mt-2" alt="...">
                        <?php else: ?>

                            <img src="<?= $urlBase ?>../src/assets/img_ingresadas_por_usuarios/usuarios/<?= $dato['imagen'] ?>" class="mt-2" alt="...">
                        <?php endif; ?>
                        <div class="mt-3">
                            <div class="ps-3 pe-3 text-center buscar">

                                <h5 class="card-title mb-1 ">Dr.
                                    <?php echo $dato["nombre"] . " " . $dato["apellido"]; ?>
                                </h5>
                                <p class="mb-4">
                                    <?php echo $dato["usuario"]; ?>
                                </p>

                            </div>

                            <div class="d-flex align-items-center justify-content-center flex-column">
                                <div class=" mb-3">
                                    <a href="#" class="btn btn-User text-decoration-none"
                                        uk-toggle="target: #modal-exampleMostrar<?php echo $dato["id_usuario"]; ?>">Mostrar</a>
                                </div>

                            </div>
                        </div>
                    </div>

                <?php endforeach ?>
            <?php else: ?>

                <div colspan="9" class="text-center">NO HAY REGISTROS

                </div>
            <?php endif ?>

        </div>


    </div>
</div>
<?php require_once './src/vistas/vistaUsuarios/modal/modalMostrarUsuario.php'; ?>
<?php require_once './src/vistas/head/footer.php'; ?>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/imgUsuarios.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/usuarios.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/admin.js"></script>