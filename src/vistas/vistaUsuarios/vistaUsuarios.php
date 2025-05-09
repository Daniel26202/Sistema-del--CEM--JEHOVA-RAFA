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

            <a><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-wrench-adjustable-circle azul" viewBox="0 0 16 16" id="desplegablefactura">
                    <path d="M12.496 8a4.491 4.491 0 0 1-1.703 3.526L9.497 8.5l2.959-1.11c.027.2.04.403.04.61Z" />
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0Zm-1 0a7 7 0 1 0-13.202 3.249l1.988-1.657a4.5 4.5 0 0 1 7.537-4.623L7.497 6.5l1 2.5 1.333 3.11c-.56.251-1.18.39-1.833.39a4.49 4.49 0 0 1-1.592-.29L4.747 14.2A7 7 0 0 0 15 8Zm-8.295.139a.25.25 0 0 0-.288-.376l-1.5.5.159.474.808-.27-.595.894a.25.25 0 0 0 .287.376l.808-.27-.595.894a.25.25 0 0 0 .287.376l1.5-.5-.159-.474-.808.27.596-.894a.25.25 0 0 0-.288-.376l-.808.27.596-.894Z" />
                </svg></a>
            <div class="uk-nav uk-dropdown-nav" uk-dropdown="pos: top-right" id="desplegable2">
                <ul>
                    <li id="perfilPaciente"><a href="/Sistema-del--CEM--JEHOVA-RAFA/Perfil/perfil" class="uk-animation-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-fill azul uk-animation-scale-up" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                            </svg>PERFIL
                        </a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="#" id="btna/Sistema-del--CEM--JEHOVA-RAFA/yudaServicioMedico"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
                                <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                            </svg>AYUDA</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="/Sistema-del--CEM--JEHOVA-RAFA/Bitacora/bitacora"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
                                <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z" />
                            </svg> CONFIGURACIÓN</a></li>
                    <li class="uk-nav-divider"></li>

                    <li><a href="#" data-bs-toggle="modal"
                            data-bs-target="#eliminar">
                            <img src="<?= $urlBase ?>../src/assets/img/icono-cerrar-sesion.svg" width="34" height="34" uk-svg class="azul" style="margin-left: -4px;">
                            </svg>SALIR</a></li>
                </ul>
            </div>
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


                <ul class="sin-circulos d-flex justify-content-end">

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
                            <a href="/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/administradores" class="text-decoration-none text-black me-3 iconoDoctor" id="DMdoctores">
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
                            <a href="/Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar" class="text-decoration-none text-black me-3 iconoDoctor" id="DMdoctores">
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