<?php require_once './src/vistas/head/head.php'; ?>

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
                <a href="?c=ControladorInicio/inicio&cerrar" class="btn btn-primary text-decoration-none">Salir</a>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    <?php if (isset($_GET["error"])): ?>
        <div class="uk-alert-danger comentario comentarioRed me-4 fw-bolder h-25" style="display: none;" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p class="pe-2">La cédula ya existe, intente de nuevo.</p>
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
        <h3 class="fw-bold" id="inicioServicio">ENFERMERÍA


            <img src="./src/assets/img/enfermera (1).png" width="35" height="30" uk-svg class="mb-2">

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
                <div class="borde-de-menu mb-1 color-linea activo-border"></div>
                <div class="hover-grande">
                    <a href="?c=ControladorEnfermeras/enfermeras" class="text-decoration-none text-black me-3 iconoDoctor" id="DMenfermeras">
                        <img src="./src/assets/img/enfermera (2).png" width="24" height="24" uk-svg class="azul">
                        </svg>Enfermería</a>
                </div>

            </li>
            <li class="li">
                <div class="mb-1 borde-de-menu  color-linea"></div>
                <div class="hover-grande">

                    <a href="?c=ControladorServiciosExtras/serviciosExtras" class="text-decoration-none text-black me-3" id="DMserviciosExtras">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-tools me-1" viewBox="0 0 16 16">
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
        <!-- Boton Agregar Enfermeras-->
        <div class="mover-input-agregarcita mt-4">
            <button class="btn btn-primary btn-agregar-doctores " uk-toggle="target: #modal-exampleEnfermeras">
                <img src="./src/assets/img/enfermera (3).png" width="24" height="24" uk-svg class="me-1 mb-1">Registrar Enfermeras
            </button>
        </div>

        <!-- Buscador de Enfermeras-->
        <div class="mover-input-buscar mt-4">
            <form id="form-buscador" class="d-flex justify-content-end" autocomplete="off">
                <input class="form-control input-buscar tamaño-input-buscar" type="text" name="cedula"
                    placeholder="Ingrese Cedula">

                <button class="btn btn-buscar " title="Buscar">
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
            <table class="table table-striped" id="tabla">
                <thead>
                    <tr>
                        <th class=" text-center d-none">Id</th>

                        <th class=" text-center">Cedula</th>
                        <th class=" text-center border-start">Nombre</th>
                        <th class=" text-center border-start">Apellido</th>
                        <th class="border-start text-center">Fecha de Nacimiento</th>
                        <th class="border-start text-center">Telefono</th>
                        <th class="border-start text-center">Correo</th>
                        <th class="border-start text-center">Turno</th>
                        <th class="border-start text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="">

                    <?php foreach ($enfermera as $enfermera): ?>
                        <tr>
                            <td class=" text-center d-none ">
                                <?php echo $proveedor["id_enfermeras"] ?>
                            </td>
                            <td class=" text-center">
                                <?php echo $enfermera["cedula"] ?>
                            </td>
                            <td class="border-start text-center">
                                <?php echo $enfermera["nombre"] ?>
                            </td>
                            <td class="border-start text-center">
                                <?php echo $enfermera["apellido"] ?>
                            </td>
                            <td class="border-start text-center">
                                <?php echo $enfermera["fechaNacimiento"] ?>
                            </td>
                            <td class="border-start text-center">
                                <?php echo $enfermera["telefono"] ?>
                            </td>
                            <td class="border-start text-center">
                                <?php echo $enfermera["correo"] ?>
                            </td>
                            <td class="border-start text-center">
                                <?php echo $enfermera["turno"] ?>
                            </td>
                            <td class="border-start d-flex justify-content-center">

                                <!-- Editar Enfermeras -->
                                <div class="me-2">
                                    <a href="#" class="btns-accion" uk-toggle="target: #modal-exampleEditarEnfermeras<?= $enfermera["id_enfermeras"];
                                                                                                                        ?>" uk-tooltip="Editar Enfermeras">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                            class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                        </svg>
                                    </a>
                                </div>


                                <!-- Eliminar Enfermeras-->

                                <div class="me-2">
                                    <a href="#" class="btns-accion" uk-toggle="target: #modal-exampleEliminarEnfermeras<?= $enfermera["id_enfermeras"];
                                                                                                                        ?>" uk-tooltip="Eliminar Enfermeras">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                            class="bi bi-trash3" viewBox="0 0 16 16">
                                            <path
                                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                        </svg>
                                    </a>
                                </div>

                            </td>
                        </tr>


                        <!--ELIMINAR MODAL-->

                        <div id="modal-exampleEliminarEnfermeras<?= $enfermera["id_enfermeras"]; ?>" uk-modal>
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

                                <div class="d-flex align-items-center">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                            class="bi bi-trash-fill azul me-2" viewBox="0 0 16 16">
                                            <path
                                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h5>

                                            ¿Desea eliminar a la Enfermera
                                            <?php echo $enfermera["nombre"] ?> ?
                                        </h5>
                                    </div>
                                </div>

                                <div class="mt-3 uk-text-right">
                                    <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                                        type="button">Cancelar</button>
                                    <a href="?c=ControladorEnfermeras/update&id_enfermeras=<?php echo $enfermera["id_enfermeras"] ?>"
                                        class="btn col-3 btn-agregarcita-modal text-decoration-none"
                                        type="button">Eliminar</a>
                                </div>

                            </div>
                        </div>



                        <!--MODAL EDITAR-->

                        <div id="modal-exampleEditarEnfermeras<?= $enfermera["id_enfermeras"]; ?>" uk-modal>
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

                                <div class="d-flex align-items-center">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                            class="bi bi-person-fill-gear azul me-3 mb-3" viewBox="0 0 16 16">
                                            <path
                                                d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Zm9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
                                        </svg>
                                    </div>
                                    <div class="">
                                        <p class="uk-modal-title fs-5">
                                            Editar Enfermeras
                                        </p>
                                    </div>

                                </div>

                                <form class="form-modal" id="modalAgregar" method="POST"
                                    action="?c=ControladorEnfermeras/editar">

                                    <div class="input-group flex-nowrap d-none">
                                        <span class="input-modal mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="currentColor" class="bi bi-person-vcard-fill azul"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                                            </svg>
                                        </span>
                                        <input class="form-control input-modal input-disabled" type="hidden"
                                            name="id_enfermeras" value="<?php echo $enfermera['id_enfermeras'] ?>"
                                            placeholder="Id">
                                    </div>

                                    <div id="grp_cedulaEditar" class="input-group flex-nowrap validar grpFormInCorrectEditar">
                                        <span class="input-modal mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-vcard-fill azul" viewBox="0 0 16 16">
                                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                                            </svg>
                                        </span>
                                        <input class="form-control input-modal input-disabled" type="text" name="cedula"
                                            value="<?php echo $enfermera['cedula'] ?>" placeholder="Cedula" pattern="([0-9]{6,8}\S)">
                                    </div>

                                    <div id="grp_nombreEditar" class="input-group flex-nowrap validar grpFormInCorrectEditar">
                                        <span class="input-modal mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                                class="bi bi-person-fill azul" viewBox="0 0 16 16">
                                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                            </svg>
                                        </span>
                                        <input class="form-control input-modal input-disabled" type="text" name="nombre"
                                            value="<?php echo $enfermera['nombre'] ?>" placeholder="Nombre" pattern="([A-Z]{1})([a-z]{2,10})">
                                    </div>

                                    <div id="grp_apellidoEditar" class="input-group flex-nowrap validar grpFormInCorrectEditar">
                                        <span class="input-modal mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                                class="bi bi-person-fill azul" viewBox="0 0 16 16">
                                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                            </svg>
                                        </span>
                                        <input class="form-control input-modal input-disabled" type="text" name="apellido"
                                            value="<?php echo $enfermera['apellido'] ?>" placeholder="Apellido" pattern="([A-Z]{1})([a-z]{2,10})">
                                    </div>

                                    <div id="grp_fechaNacimientoEditar" class="input-group flex-nowrap validar grpFormInCorrectEditar">
                                        <span class="input-modal mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
                                                <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
                                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
                                            </svg>
                                        </span>
                                        <input class="form-control input-modal input-disabled" type="date" name="fechaNacimiento"
                                            value="<?php echo $enfermera['fechaNacimiento'] ?>" placeholder="Fecha de Nacimiento" pattern="\d{4}\-\d{2}\-\d{2}">
                                    </div>

                                    <div id="grp_telefonoEditar" class="input-group flex-nowrap validar grpFormInCorrectEditar">
                                        <span class="input-modal mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="currentColor" class="bi bi-telephone-fill azul" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                                            </svg>
                                        </span>
                                        <input class="form-control input-modal input-disabled" type="text" name="telefono"
                                            value="<?php echo $enfermera['telefono'] ?>" placeholder="Telefono" pattern="([+]{1}[\d]{1,4})?[\s.-]?([\d]{3,4})[\s.-]?([\d]{3})[\s.-]?([\d]{4})">
                                    </div>

                                    <div id="grp_correoEditar" class="input-group flex-nowrap validar grpFormInCorrectEditar">
                                        <span class="input-modal mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-envelope-at-fill azul" viewBox="0 0 16 16">
                                                <path d="M2 2A2 2 0 0 0 .05 3.555L8 8.414l7.95-4.859A2 2 0 0 0 14 2zm-2 9.8V4.698l5.803 3.546zm6.761-2.97-6.57 4.026A2 2 0 0 0 2 14h6.256A4.5 4.5 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586zM16 9.671V4.697l-5.803 3.546.338.208A4.5 4.5 0 0 1 12.5 8c1.414 0 2.675.652 3.5 1.671" />
                                                <path d="M15.834 12.244c0 1.168-.577 2.025-1.587 2.025-.503 0-1.002-.228-1.12-.648h-.043c-.118.416-.543.643-1.015.643-.77 0-1.259-.542-1.259-1.434v-.529c0-.844.481-1.4 1.26-1.4.585 0 .87.333.953.63h.03v-.568h.905v2.19c0 .272.18.42.411.42.315 0 .639-.415.639-1.39v-.118c0-1.277-.95-2.326-2.484-2.326h-.04c-1.582 0-2.64 1.067-2.64 2.724v.157c0 1.867 1.237 2.654 2.57 2.654h.045c.507 0 .935-.07 1.18-.18v.731c-.219.1-.643.175-1.237.175h-.044C10.438 16 9 14.82 9 12.646v-.214C9 10.36 10.421 9 12.485 9h.035c2.12 0 3.314 1.43 3.314 3.034zm-4.04.21v.227c0 .586.227.8.581.8.31 0 .564-.17.564-.743v-.367c0-.516-.275-.708-.572-.708-.346 0-.573.245-.573.791" />
                                            </svg>
                                        </span>
                                        <input class="form-control input-modal input-disabled" type="text" name="correo"
                                            value="<?php echo $enfermera['correo'] ?>" placeholder="Correo" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}">
                                    </div>

                                    <div class="input-group flex-nowrap">
                                        <span class="input-modal mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-card-list azul" viewBox="0 0 16 16">
                                                <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z" />
                                                <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8m0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0M4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0" />
                                            </svg>

                                        </span>
                                        <select class="form-control input-modal input-disabled" type="text" name="turno" placeholder="Turno">

                                            <option>Diurno</option>
                                            <option>Nocturno</option>
                                        </select>

                                    </div>

                                    <div class="mt-3 uk-text-right">
                                        <button
                                            class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                                            type="button">Cancelar</button>
                                        <button type="submit" class="btn col-3 btn-agregarcita-modal"
                                            name="editar">Editar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php require_once 'modalEnfermeras.php'; ?>

<?php require_once './src/vistas/head/footer.php'; ?>

<script src=""></script>
<script type="text/javascript" src="./src/assets/js/validacionesEnfermeras.js"></script>

<script src=""></script>
<script type="text/javascript" src="./src/assets/js/validacionesEnfermerasEditar.js"></script>