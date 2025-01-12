<?php require_once './src/vistas/head/head.php'; ?>


<!-- contenedor  -->

<div class="d-flex align-items-center justify-content-between mt-4 mb-4">
    <div class="ms-5 d-flex align-items-center" id="inicioDirectorio">
        <h1 class="fw-bold">DIRECTORIO MÉDICO</h1>
        <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" fill="currentColor"
            class="bi bi-clipboard2-pulse ms-2" viewBox="0 0 16 16">
            <path
                d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5h3Z" />
            <path
                d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-12Z" />
            <path
                d="M9.979 5.356a.5.5 0 0 0-.968.04L7.92 10.49l-.94-3.135a.5.5 0 0 0-.926-.08L4.69 10H4.5a.5.5 0 0 0 0 1H5a.5.5 0 0 0 .447-.276l.936-1.873 1.138 3.793a.5.5 0 0 0 .968-.04L9.58 7.51l.94 3.135A.5.5 0 0 0 11 11h.5a.5.5 0 0 0 0-1h-.128L9.979 5.356Z" />
        </svg>
    </div>

    <div class="me-4">

        <a><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-wrench-adjustable-circle azul" viewBox="0 0 16 16" id="desplegablefactura">
                <path d="M12.496 8a4.491 4.491 0 0 1-1.703 3.526L9.497 8.5l2.959-1.11c.027.2.04.403.04.61Z" />
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0Zm-1 0a7 7 0 1 0-13.202 3.249l1.988-1.657a4.5 4.5 0 0 1 7.537-4.623L7.497 6.5l1 2.5 1.333 3.11c-.56.251-1.18.39-1.833.39a4.49 4.49 0 0 1-1.592-.29L4.747 14.2A7 7 0 0 0 15 8Zm-8.295.139a.25.25 0 0 0-.288-.376l-1.5.5.159.474.808-.27-.595.894a.25.25 0 0 0 .287.376l.808-.27-.595.894a.25.25 0 0 0 .287.376l1.5-.5-.159-.474-.808.27.596-.894a.25.25 0 0 0-.288-.376l-.808.27.596-.894Z" />
            </svg></a>
        <div class="uk-nav uk-dropdown-nav" uk-dropdown="pos: top-right" id="desplegable2">
            <ul>
                <li id="perfilPaciente"><a href="?c=ControladorPerfil/perfil" class="uk-animation-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-fill azul uk-animation-scale-up" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        </svg>PERFIL
                    </a></li>
                <li class="uk-nav-divider"></li>
                <li><a href="#" id="btnayudaSA"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
                            <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                        </svg>AYUDA</a></li>
                <li class="uk-nav-divider"></li>

                <li><a href="#" data-bs-toggle="modal"
                        data-bs-target="#eliminar">
                        <img src="./src/assets/img/icono-cerrar-sesion.svg" width="34" height="34" uk-svg class="azul" style="margin-left: -4px;">
                        </svg>SALIR</a></li>
            </ul>
        </div>
    </div>
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

<div class="d-flex justify-content-center">

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

<!-- paginación servicio medico -->
<div class="d-flex">

    <div class="w-75 ms-5 pb-4">
        <h3 class="fw-bold" id="inicioServicio">SERVICIOS ADICIONALES


            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-tools mb-2" viewBox="0 0 16 16">
                <path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814L1 0Zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708ZM3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026L3 11Z" />
            </svg>

        </h3>

    </div>

    <div class=" me-3 mb-1  d-flex justify-content-end w-100">


        <ul class="sin-circulos d-flex justify-content-end">

            <li class="li">
                <div class="borde-de-menu mb-1 color-linea"></div>
                <div class="hover-grande">
                    <a href="?c=controladorConsultas/consultas" class="text-decoration-none text-black me-3" id="DMservicioMedico">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-clipboard-heart me-1 " viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M5 1.5A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5v-1Zm5 0a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1Z" />
                            <path d="M3 1.5h1v1H3a1 1 0 0 0-1 1V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3.5a1 1 0 0 0-1-1h-1v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2Z" />
                            <path d="M8 6.982C9.664 5.309 13.825 8.236 8 12 2.175 8.236 6.336 5.31 8 6.982Z" />
                        </svg>Servicios Médicos</a>
                </div>
            </li>
            <li class="li">
                <div class="borde-de-menu mb-1 "></div>
                <div class="hover-grande">
                    <a href="?c=ControladorDoctores/doctores" class="text-decoration-none text-black me-3 iconoDoctor " id="DMdoctores">
                        <img src="./src/assets/img/doctor.png" width="19" height="19" uk-svg class="azul color-activo-svg">
                        </svg>Doctores</a>
                </div>

            </li>
            <li class="li">
                <div class="borde-de-menu mb-1 color-linea"></div>
                <div class="hover-grande">
                    <a href="?c=ControladorEnfermeras/enfermeras" class="text-decoration-none text-black me-3 iconoDoctor" id="DMenfermeras">
                        <img src="./src/assets/img/enfermera (1).png" width="24" height="24" uk-svg class="azul">
                        </svg>Enfermería</a>
                </div>

            </li>
            <li class="li">
                <div class="mb-1 activo-border color-linea"></div>
                <div class="hover-grande">

                    <a href="?c=ControladorServiciosExtras/serviciosExtras" class="text-decoration-none text-black me-3" id="DMserviciosExtras">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-tools me-1 color-activo-svg" viewBox="0 0 16 16">
                            <path
                                d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814L1 0Zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708ZM3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026L3 11Z" />
                        </svg>Servicios Adicionales</a>
                </div>

            </li>

        </ul>

    </div>


</div>


<div class="div-tabla contenedor m-auto mt-3">
    <div class="d-flex justify-content-between align-items-center">

        <!-- Botón Agregar Consultas -->
        <div class="mover-input-agregarcita">
            <button class="btn btn-primary btn-agregar-doctores mt-4" uk-toggle="target: #modal-example" id="btnEspecialidades">
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                    class="bi bi-tools me-1 " viewBox="0 0 16 16">
                    <path
                        d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814L1 0Zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708ZM3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026L3 11Z" />
                </svg>
                Agregar Servicio Adicional
            </button>
        </div>





        <!-- modal de agregar -->
        <div id="modal-example" uk-modal>
            <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                <!-- Boton que cierra el modal -->
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                        class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                        <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                    </svg>
                </a>

                <div class="d-flex align-items-center mb-3">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor"
                            class="bi bi-tools azul me-3 mb-3" viewBox="0 0 16 16">
                            <path
                                d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814L1 0Zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708ZM3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026L3 11Z" />
                        </svg>
                    </div>
                    <div class="">
                        <p class="uk-modal-title fs-5 ">
                            Registrar Servicio Adicional
                        </p>
                    </div>

                </div>
                <div class="alert alert-danger d-none" role="alert" id="alerta"">
  <div class="">
   <p style=" font-size: 12px; height:10px; " class=" text-center">VERIFIQUE EL FORMULARIO ANTES DE ENVIARLO</p>
                </div>
            </div>

            <form class="form-modal" id="modalAgregar" action="?c=ControladorServiciosExtras/guardar" method="POST">

                <div class="input-group flex-nowrap">
                    <span class="input-modal mt-1">
                        <img src="./src/assets/img/doctor (2).png" width="19" height="19" uk-svg class="azul">
                    </span>
                    <select class="form-control input-modal" aria-label="" placeholder="Id_doctor" name="id_doctor" required>

                        <option value="" selected disabled>Doctor</option>

                        <?php foreach ($doctores as $doctor): ?>
                            <option value="<?php echo $doctor["id_doctor"]; ?>">
                                <?php echo $doctor["4"] ?>
                                <?php echo $doctor["apellido"] ?>
                            </option>
                        <?php endforeach ?>

                    </select>
                </div>



                <div class="input-group flex-nowrap" id="grp_nombre">
                    <span class="input-modal mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-clipboard-plus-fill azul" viewBox="0 0 16 16">
                            <path
                                d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z" />
                            <path
                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5zm4.5 6V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5a.5.5 0 0 1 1 0" />
                        </svg>
                    </span>

                    <input class="form-control input-modal" type="text" name="nombre" placeholder="Nombre" required>

                </div>

                <div class="input-group flex-nowrap" id="grp_precio">
                    <span class="input-modal mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-coin azul" viewBox="0 0 16 16">
                            <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z" />
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" />
                        </svg>
                    </span>
                    <input class="form-control input-modal" type="text" name="precio" placeholder="Precio" required>

                </div>

                <div class=" d-none d-flex align-items-center justify-content-center" id="leyenda" style="font-size: 12px; margin-top: -10px; margin-bottom: 5px; ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle azul me-1" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                    </svg>
                    <i>El formato del precio es incorrecto, Ejemplo 0,00 - 00,00 - 000,00 - 0.000,00 </i>
                </div>
                <div class="mt-3 uk-text-right">
                    <button class="uk-button col-6 me-2 uk-button-default uk-modal-close btn-cerrar-modal"
                        type="button">Cancelar</button>
                    <button class="btn col-5 btn-agregarcita-modal" type="sumit" name="guardar">Agregar</button>
                </div>
            </form>
        </div>
    </div>





    <!-- Buscador de consultas -->
    <div class="mover-input-buscar d-flex mt-4">
        <a class="btn d-none" title="Buscar" id="reiniciarBusqueda" uk-tooltip="Restablecer">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
            </svg>
        </a>
        <form class="d-flex justify-content-end" action="?c=ControladorServiciosExtras/buscarSA" method="POST" autocomplete="off" id="formServAdicionales">

            <input class="form-control input-buscar tamaño-input-buscar" type="text" name="nombre"
                placeholder="Servicio" id="inputBuscarSA">

            <button class="btn btn-buscar " title="Buscar" type="submit" id="btnBuscarDoc">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-search" viewBox="0 0 16 16">
                    <path
                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                </svg>
            </button>

        </form>
    </div>

</div>

<!-- Tabla -->
<div class="d-flex justify-content-center">
    <div class="tamaño-tabla mt-5 contenedor_tabla">
        <table class="table table-striped " id="tablaespecialidad">
            <thead>
                <tr>
                    <th class="d-none">
                        Id
                    </th>
                    <th class=" text-center">Doctor</th>
                    <th class=" text-center border-start">Servicio</th>
                    <th class=" text-center border-start">Precio</th>

                    <th class="border-start text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>

                <?php if ($extras): ?>
                    <?php foreach ($extras as $extra): ?>

                        <tr>
                            <td class="text-center d-none">
                                <?php echo $extra['0']; ?>
                            </td>

                            <td class="text-center">
                                <?php echo $extra['1']; ?>
                                <?php echo $extra['2']; ?>
                            </td>


                            <td class="border-start text-center">
                                <?php echo $extra['3']; ?>

                            </td>


                            <td class="border-start text-center">
                                <?php echo $extra['4']; ?> Bs
                            </td>





                            <td class="border-start">
                                <div class="d-flex justify-content-center">
                                    <div class="me-2 d-flex">
                                        <a href="#" class="botonesEditarSA" uk-toggle="target: #modal-exampleEditar<?= $extra['0']; ?>"
                                            title="Modificar Servicio Adicional" uk-tooltip id="btnEditarSA">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                                fill="currentColor" class="bi bi-pencil-square text-black"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd"
                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                            </svg>
                                        </a>
                                    </div>

                                    <!-- Boton Eliminar Pacientes-->

                                    <div class="me-2">
                                        <a href="#" uk-toggle="target:#eliminar<?php echo $extra['0']; ?>"
                                            title="Eliminar Servicio Adicional" uk-tooltip id="btnEliminarSA">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                                fill="currentColor" class="bi bi-trash3-fill text-black"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                            </svg>
                                        </a>
                                    </div>



                                    <!-- Modal de Modificar -->


                                    <div id="modal-exampleEditar<?= $extra['0']; ?>" uk-modal>
                                        <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                                            <!-- Boton que cierra el modal -->
                                            <a href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul "
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                    <path
                                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                                </svg>
                                            </a>

                                            <div class="d-flex align-items-center mb-3">
                                                <div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                                        fill="currentColor" class="bi bi-pencil-square azul me-3 mb-3 "
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                        <path fill-rule="evenodd"
                                                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                    </svg>
                                                </div>
                                                <div class="">
                                                    <p class="uk-modal-title fs-5 ">
                                                        Modificar Servicio Adicional
                                                    </p>
                                                </div>

                                            </div>
                                            <div class="alert alert-danger d-none alertaEditar" role="alert">
                                                <div class="">
                                                    <p style="font-size: 12px; height:10px; " class="text-center">VERIFIQUE EL FORMULARIO ANTES DE ENVIARLO</p>
                                                </div>
                                            </div>

                                            <form
                                                action="?c=ControladorserviciosExtras/editar&id_servicioExtra=<?php echo $extra['id_servicioExtra']; ?>"
                                                method="POST" id="formEditar" class="formEditar">

                                                <!-- <input class="form-control input-modal d-none input-disabled" type="text" name="id_sevicioExtra" placeholder="Id-sevicioExtra" value="<?php echo $extra['id_sevicioExtra']; ?>"> -->

                                                <div class="input-group flex-nowrap margin-inputs validar"
                                                    id="grp_cedulaEditar">
                                                    <span class="input-modal mt-1">
                                                        <img src="./src/assets/img/doctor (2).png" width=20" height="20" uk-svg class="azul">

                                                    </span>
                                                    <select class="form-control input-modal" aria-label=""
                                                        placeholder="Id_doctor" name="id_doctor">
                                                        <?php foreach ($doctores as $doctor): ?>

                                                            <option selected value="<?php echo $doctor["id_doctor"]; ?>">
                                                                <?php echo $doctor["4"]; ?>
                                                                <?php echo $doctor["apellido"]; ?>


                                                            </option>



                                                        <?php endforeach ?>

                                                    </select>
                                                </div>

                                                <div class="input-group flex-nowrap margin-inputs claseExpresiones editargrp_nombre" id="editargrp_nombre">
                                                    <span class="input-modal mt-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            fill="currentColor" class="bi bi-clipboard-plus-fill azul"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z" />
                                                            <path
                                                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5zm4.5 6V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5a.5.5 0 0 1 1 0" />
                                                        </svg>
                                                    </span>
                                                    <input class="form-control input-modal input-disabled input-paciente "
                                                        type="text" name="nombreEditar" placeholder="Nombre"
                                                        value="<?php echo $extra['3']; ?>">
                                                </div>

                                                <div class="input-group flex-nowrap margin-inputs claseExpresiones editargrp_precio" id="editargrp_precio">
                                                    <span class="input-modal mt-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-coin azul" viewBox="0 0 16 16">
                                                            <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z" />
                                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                            <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" />
                                                        </svg>
                                                    </span>
                                                    <input class="form-control input-modal input-disabled input-paciente"
                                                        type="text" name="precioEditar" placeholder="Precio"
                                                        value="<?php echo $extra['4']; ?>">
                                                </div>
                                                <div class="d-none d-flex align-items-center justify-content-center leyendaEditar" style="font-size: 12px; margin-top: -10px; margin-bottom: 5px; ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle azul me-1" viewBox="0 0 16 16">
                                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                                    </svg>
                                                    <i>El formato del precio es incorrecto, Ejemplo 0,00 - 00,00 - 000,00 - 0.000,00 </i>
                                                </div>

                                                <div class="mt-3 uk-text-right">
                                                    <button
                                                        class="uk-button col-6 me-2 uk-button-default uk-modal-close btn-cerrar-modal"
                                                        type="button">Cancelar</button>
                                                    <button class="btn col-4 btn-agregarcita-modal"
                                                        type="sumit">Modificar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>



                                    <!-- Modal Eliminar -->

                                    <div id="eliminar<?= $extra['0']; ?>" uk-modal>
                                        <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                                            <!-- Boton que cierra el modal -->
                                            <a href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul "
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                    <path
                                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                                </svg>
                                            </a>

                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                        fill="currentColor" class="bi bi-trash-fill azul me-2 mb-1"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h5>
                                                        ¿Desea eliminar el Servicio Adicional?
                                                    </h5>
                                                </div>
                                            </div>

                                            <div class="mt-3 uk-text-right">
                                                <button
                                                    class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                                                    type="button">Cancelar</button>

                                                <a
                                                    href="?c=ControladorServiciosExtras/eliminar&id_servicioExtra=<?php echo $extra['id_servicioExtra']; ?>">
                                                    <button class="btn col-4 btn-agregarcita-modal"
                                                        type="button">Eliminar</button>
                                                </a>
                                            </div>

                                        </div>
                                    </div>


                                </div>



                            </td>
                        </tr>
                    <?php endforeach ?>

                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">NO HAY REGISTROS

                        </td>
                    </tr>
                <?php endif ?>

            </tbody>
        </table>
        <table class="table table-striped " style="margin-top: -16px;">
            <thead>

            </thead>
            <tbody>
                <tr class="d-none" id="noResultadoSA">
                    <td colspan="9" class="text-center">NO HAY REGISTROS

                    </td>
                </tr>
            </tbody>

        </table>
    </div>
</div>

</div>

<?php require_once './src/vistas/head/footer.php'; ?>
<script src="./src/assets/js/buscadorServiciosAdicionales.js"></script>
<script type="text/javascript" src="./src/assets/js/ayudaServicioAdicional.js"></script>
<script src="./src/assets/js/validacionesServiciosAdicionalesRegistrar.js"></script>
<script src="./src/assets/js/validacionesServiciosAdicionalesEditar.js"></script>