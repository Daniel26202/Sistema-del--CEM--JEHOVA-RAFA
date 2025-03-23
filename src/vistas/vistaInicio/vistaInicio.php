<?php require_once './src/vistas/head/head.php'; ?>

<div class="d-flex align-items-center justify-content-between mt-4 mb-4 contInicioRes">
    <div class="ms-5 d-flex align-items-center" id="Inicioh1">
        <h1 class="fw-bold">INICIO</h1>
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-house ms-2 mb-2"
            viewBox="0 0 16 16">
            <path
                d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
        </svg>
    </div>

    <div class="contenedor-inicio me-3 aparecer">
        <div class="d-flex align-items-center justify-content-between  mt-2">
            <div class="ms-3 ps-1">
                <h5 class="fw-bold">
                    <?php echo $_SESSION["usuario"]; ?>
                </h5>
            </div>

            <div class="me-3 pe-1 mb-2 ms-1 d-flex align-items-center">
                <a class="svg_ayuda"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                        class="bi bi-wrench-adjustable-circle azul " viewBox="0 0 16 16" id="desplegablePaciente">
                        <path d="M12.496 8a4.491 4.491 0 0 1-1.703 3.526L9.497 8.5l2.959-1.11c.027.2.04.403.04.61Z" />
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0Zm-1 0a7 7 0 1 0-13.202 3.249l1.988-1.657a4.5 4.5 0 0 1 7.537-4.623L7.497 6.5l1 2.5 1.333 3.11c-.56.251-1.18.39-1.833.39a4.49 4.49 0 0 1-1.592-.29L4.747 14.2A7 7 0 0 0 15 8Zm-8.295.139a.25.25 0 0 0-.288-.376l-1.5.5.159.474.808-.27-.595.894a.25.25 0 0 0 .287.376l.808-.27-.595.894a.25.25 0 0 0 .287.376l1.5-.5-.159-.474-.808.27.596-.894a.25.25 0 0 0-.288-.376l-.808.27.596-.894Z" />
                    </svg></a>
                <div class="uk-nav uk-dropdown-nav" uk-dropdown="pos: top-right" id="desplegable2">
                    <ul>
                        <li id="perfilPaciente" class="mb-2"><a href="?c=ControladorPerfil/perfil"
                                class="uk-animation-toggle" id="inicioPerfilDos">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                    class="bi bi-person-fill azul uk-animation-scale-up" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                </svg>PERFIL
                            </a></li>

                        <li class="uk-nav-divider"></li>

                        <li class="mt-3 mb-3" id="btnayudaInicioDos"><a href="#"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="25" height="25" fill="currentColor"
                                    class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
                                    <path
                                        d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                                </svg>AYUDA</a></li>

                        <li class="uk-nav-divider"></li>

                        <li class="mt-3 mb-3"><a href="?c=ControladorInicio/manualUsuario" id="manualDos"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                    class="bi bi-journals azul" viewBox="0 0 16 16">
                                    <path
                                        d="M5 0h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2 2 2 0 0 1-2 2H3a2 2 0 0 1-2-2h1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1H1a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v9a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1H3a2 2 0 0 1 2-2z" />
                                    <path
                                        d="M1 6v-.5a.5.5 0 0 1 1 0V6h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V9h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 2.5v.5H.5a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1H2v-.5a.5.5 0 0 0-1 0z" />
                                </svg>MANUAL</a></li>

                        <li class="uk-nav-divider"></li>

                        <li class="mt-2"><a href="#" data-bs-toggle="modal" data-bs-target="#eliminar" id="inicioCerrarSesionDos">
                                <img src="../src/assets/img/icono-cerrar-sesion.svg" width="34" height="34" uk-svg
                                    class="azul" style="margin-left: -4px;">
                                </svg>SALIR</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>



    <div class="contenedor-inicio me-3 ocultar">
        <div class="me-4 d-flex align-items-end justify-content-between  mt-2">
            <div class="ms-3 ps-1">
                <h5 class="fw-bold">
                    <?php echo $_SESSION["usuario"]; ?>
                </h5>
            </div>
            <div class="mb-1 p-xs-5">
                <a href="#" uk-tooltip="Ayuda">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                        class="bi bi-question-octagon-fill azul ms-4" viewBox="0 0 16 16" id="btnayudaInicio">
                        <path
                            d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                    </svg>
                </a>
            </div>
        </div>
        <div class="d-flex flex-column mt-1">
            <a href="?c=ControladorPerfil/perfil" class="text-decoration-none text-black ms-3 col-2" id="inicioPerfil">
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                    class="bi bi-person-fill azul  pb-1" viewBox="0 0 16 16">
                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                </svg>
                Perfil
            </a>

            <a href="?c=ControladorInicio/manualUsuario" class="text-decoration-none text-black mb-2 ms-3 mt-2 col-4" id="manual">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                    class="bi bi-journals azul" viewBox="0 0 16 16">
                    <path
                        d="M5 0h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2 2 2 0 0 1-2 2H3a2 2 0 0 1-2-2h1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1H1a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v9a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1H3a2 2 0 0 1 2-2z" />
                    <path
                        d="M1 6v-.5a.5.5 0 0 1 1 0V6h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V9h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 2.5v.5H.5a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1H2v-.5a.5.5 0 0 0-1 0z" />
                </svg>
                Manual </a>


                <a href="?c=ControladorBitacora/bitacora" class="text-decoration-none text-black mb-2 ms-3 mt-2 col-4" >
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-journals azul" viewBox="0 0 16 16">
          <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z"/>
      </svg> Configuración </a>

                
            <a href="#" class="text-decoration-none text-black mb-4 ms-3 col-4" data-bs-toggle="modal"
                data-bs-target="#eliminar" id="inicioCerrarSesion">
                <img src="../src/assets/img/icono-cerrar-sesion.svg" width="24" height="24" uk-svg class="azul pb-1">
                Cerrar sesión
            </a>
        </div>
    </div>

</div>

<div class="d-flex justify-content-center carruselImg ocultar">
    <div class="carrusel">
        <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slideshow="animation: push">

            <ul class="uk-slideshow-items d-flex justify-content-center borde-img">
                <li>
                    <div
                        class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                        <img src="<?= $urlBase?>../src/assets/img/logotipo.jpg" uk-cover>
                    </div>
                </li>
                <li>
                    <div
                        class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-top-right">
                        <img src="<?= $urlBase?>../src/assets/img/Windows-11-Wallpaper-1-1-scaled.jpg" alt="" uk-cover>
                    </div>
                </li>
                <li>
                    <div
                        class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-bottom-left">
                        <img src="<?= $urlBase?>../src/assets/img/Windows-11-Wallpaper-1-1-scaled.jpg" alt="" uk-cover>
                    </div>
                </li>
            </ul>

            <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous
                uk-slideshow-item="previous"></a>
            <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next
                uk-slideshow-item="next"></a>

        </div>
    </div>
</div>
<?php if ($_SESSION['rol'] == "usuario"): ?>
    <!-- no hay -->
<?php elseif ($_SESSION['rol'] == "administrador"): ?>
    <div class="d-flex justify-content-center d-flex flex-row mt-5 divCartas">
        <div class="tamaño-tarjertas me-4" id="tarjetaInicio1">
            <a href="?c=Controladorcitas/citasHoy" class="text-decoration-none">
                <div class="uk-animation-toggle" tabindex="0">
                    <div
                        class="uk-card uk-card-default uk-card-body borde-img fondo-tarjetas uk-animation-scale-up uk-transform-origin-top-center">
                        <h1 class="uk-card-title text-center tamaño-letra fw-bolder text-white" id="hoy"></h1>
                        <p class="text-center text-white fw-bolder">Citas Hoy</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="tamaño-tarjertas" id="tarjetaInicio2">
            <a href="?c=Controladorcitas/citas" class="text-decoration-none">
                <div class="uk-animation-toggle" tabindex="0">
                    <div
                        class="uk-card uk-card-default uk-card-body borde-img fondo-tarjetas uk-animation-scale-up uk-transform-origin-top-center">
                        <h1 class="uk-card-title text-center tamaño-letra fw-bolder text-white" id="pendientes"></h1>
                        <p class="text-center text-white fw-bolder">Citas Pendientes</p>
                    </div>
                </div>
            </a>
        </div>

    </div>
<?php endif ?>


<!-- modal de serrar sesión -->
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
                Una vez cerrado tendrá que iniciar sesión nuevamente.
            </div>
            <div class="m-3 me-4 d-flex justify-content-end">
                <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancelar</button>
                <a href="?c=ControladorInicio/inicio&cerrar" class="btn btn-primary text-decoration-none">Salir</a>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="../src/assets/js/ayudaInicio.js"></script>
<script src="../src/assets/inicio.js"></script>
<?php require_once './src/vistas/head/footer.php'; ?>