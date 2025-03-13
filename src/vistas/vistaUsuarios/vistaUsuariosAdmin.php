<?php require_once './src/vistas/head/head.php'; ?>

<div class="container pb-1">
    <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
        <div class="ms-5 d-flex align-items-center">

            <h1 class="fw-bold mt-2">ADMINISTRADORES</h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" fill="currentColor"
                class="bi bi-person-square ms-2" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                <path
                    d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
            </svg>

        </div>

        <div class="me-4">

            <a><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                    class="bi bi-wrench-adjustable-circle azul" viewBox="0 0 16 16" id="desplegablefactura">
                    <path d="M12.496 8a4.491 4.491 0 0 1-1.703 3.526L9.497 8.5l2.959-1.11c.027.2.04.403.04.61Z" />
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0Zm-1 0a7 7 0 1 0-13.202 3.249l1.988-1.657a4.5 4.5 0 0 1 7.537-4.623L7.497 6.5l1 2.5 1.333 3.11c-.56.251-1.18.39-1.833.39a4.49 4.49 0 0 1-1.592-.29L4.747 14.2A7 7 0 0 0 15 8Zm-8.295.139a.25.25 0 0 0-.288-.376l-1.5.5.159.474.808-.27-.595.894a.25.25 0 0 0 .287.376l.808-.27-.595.894a.25.25 0 0 0 .287.376l1.5-.5-.159-.474-.808.27.596-.894a.25.25 0 0 0-.288-.376l-.808.27.596-.894Z" />
                </svg>
            </a>
            <div class="uk-nav uk-dropdown-nav" uk-dropdown="pos: top-right" id="desplegable2">
                <ul>
                    <li id="perfilPaciente"><a href="?c=ControladorPerfil/perfil" class="uk-animation-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                class="bi bi-person-fill azul uk-animation-scale-up" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                            </svg>PERFIL
                        </a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="#" id="btnayudaServicioMedico"><svg xmlns="http://www.w3.org/2000/svg" width="26"
                                height="26" fill="currentColor" class="bi bi-question-octagon-fill azul me-1"
                                viewBox="0 0 16 16">
                                <path
                                    d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                            </svg>AYUDA</a></li>
                    <li class="uk-nav-divider"></li>

                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#eliminar">
                            <img src="./src/assets/img/icono-cerrar-sesion.svg" width="34" height="34" uk-svg
                                class="azul" style="margin-left: -4px;">
                            </svg>SALIR</a></li>
                </ul>
            </div>
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

    <!-- Modal Cerrar Sesion  -->
    <div class="modal fade" id="eliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="m-3">
                    <?php

                    echo '<h5 class="modal-title" id="exampleModalLabel">
                    ¿' . $_SESSION['usuario'] . '   ' . 'Desea Cerrar 
                    la Sesion?
                    </h5>';
                    ?>
                </div>
                <div class="modal-body ">
                    Una vez cerrada la sesión tendrá que iniciar sesión nuevamente.
                </div>
                <div class="m-3 me-4 d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancelar</button>
                    <a href="?c=ControladorInicio/inicio&cerrar" class="btn btn-primary  text-decoration-none">Salir</a>
                </div>
            </div>
        </div>
    </div>

    <!--AGREGAR Y BUSCAR-->
    <div class="fondo-tabla">
        <div class="d-flex justify-content-between align-items-center">
            <div class="">
                <button class="btn btn-primary btn-agregar-doctores col-11" uk-toggle="target: #modal-exampleAgregar"
                    id="btnRegistrarPaciente">
                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor"
                        class="bi bi-person-square me-2" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                        <path
                            d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
                    </svg>Registrar Administrador
                </button>
            </div>
            <!-- Buscador de Usuarios -->
            <div class="d-flex justify-content-end mt-3 mb-3 col-3">
                <input class="form-control input-busca" type="text" name="" placeholder="Ingrese nombre"
                    id="Buscarusuario">
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


                <ul class="sin-circulos d-flex justify-content-end">

                    <li class="li">
                        <div class="borde-de-menu  mb-1 "></div>
                        <div class="hover-grande">
                            <a href="?c=ControladorUsuarios/usuarios" class="text-decoration-none text-black me-3 "
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
                        <div class="borde-de-menu mb-1 activo-border"></div>
                        <div class="hover-grande">
                            <a href="?c=ControladorUsuarios/administradores" class=text-decoration-none me-3 azul me-3
                                iconoDoctor" id="DMdoctores">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-person-square ms-2" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path
                                        d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
                                </svg>Administrador</a>
                        </div>

                    </li>




                </ul>

            </div>
        </div>

        <!--TARJETAS DE Usuarios-->

        <!-- linea -->
        <hr class="mb-4 pb-2">

        <div class="d-flex flex-wrap justify-content-center ms-5 me-5">
            <?php if ($datosU): ?>

                <?php foreach ($datosU as $dato): ?>

                    <div
                        class="card col-9 col-sm-6 col-lg-3 tarjeta ms-2 me-4 d-flex align-items-center justify-content-center tarjeta">
                        <?php if ($dato["imagen"] != "doctor.png"): ?>

                            <img src="./src/assets/img_ingresadas_por_usuarios/usuarios/<?= $dato['id_usuario'] . "_" . $dato['imagen'] ?>"
                                class="mt-2" alt="...">
                        <?php else: ?>

                            <img src="./src/assets/img_ingresadas_por_usuarios/usuarios/<?= $dato['imagen'] ?>" class="mt-2"
                                alt="...">
                        <?php endif; ?>
                        <div class="mt-3">
                            <div class="ps-3 pe-3 text-center buscar">

                                <h5 class="card-title mb-1 ">Dr.
                                    <?php echo $dato["9"] . " " . $dato["apellido"]; ?>
                                </h5>
                                <p class="mb-4">
                                    <?php echo $dato["nombre"]; ?>
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
<?php require_once './src/vistas/vistaUsuarios/modal/modalMostrarAdmin.php'; ?>
<?php require_once './src/vistas/vistaUsuarios/modal/modalAgregarAdmin.php'; ?>
<?php require_once './src/vistas/head/footer.php'; ?>

<script type="text/javascript" src="./src/assets/js/imgAdmin.js"></script>
<script type="text/javascript" src="./src/assets/js/admin.js"></script>
<!-- <script type="text/javascript" src="./src/assets/js/usuarios.js"></script> -->