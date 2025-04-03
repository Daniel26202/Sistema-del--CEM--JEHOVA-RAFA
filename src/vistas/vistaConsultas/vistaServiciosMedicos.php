<?php require_once './src/vistas/head/head.php'; ?>


<div class="container-fluid px-4">
    <div class="p-0 m-0 pb-3 d-flex justify-content-between">
        <h1 class="mt-4 mb-0">SERVICIOS <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-clipboard-heart mb-2 ms-2" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M5 1.5A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5v-1Zm5 0a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1Z" />
                <path d="M3 1.5h1v1H3a1 1 0 0 0-1 1V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3.5a1 1 0 0 0-1-1h-1v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2Z" />
                <path d="M8 6.982C9.664 5.309 13.825 8.236 8 12 2.175 8.236 6.336 5.31 8 6.982Z" />
            </svg></thead>
        </h1>



        <div class=" d-flex align-items-end">
            <div class="me-4 mt-0">

                <a><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-wrench-adjustable-circle azul" viewBox="0 0 16 16" id="desplegableservicio">
                        <path d="M12.496 8a4.491 4.491 0 0 1-1.703 3.526L9.497 8.5l2.959-1.11c.027.2.04.403.04.61Z" />
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0Zm-1 0a7 7 0 1 0-13.202 3.249l1.988-1.657a4.5 4.5 0 0 1 7.537-4.623L7.497 6.5l1 2.5 1.333 3.11c-.56.251-1.18.39-1.833.39a4.49 4.49 0 0 1-1.592-.29L4.747 14.2A7 7 0 0 0 15 8Zm-8.295.139a.25.25 0 0 0-.288-.376l-1.5.5.159.474.808-.27-.595.894a.25.25 0 0 0 .287.376l.808-.27-.595.894a.25.25 0 0 0 .287.376l1.5-.5-.159-.474-.808.27.596-.894a.25.25 0 0 0-.288-.376l-.808.27.596-.894Z" />
                    </svg></a>
                <div class="uk-nav uk-dropdown-nav" uk-dropdown="pos: top-right" id="desplegable2">
                    <ul>
                        <li id="perfilservicio"><a href="/Sistema-del--CEM--JEHOVA-RAFA/Perfil/perfil" class="uk-animation-toggle">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-fill azul uk-animation-scale-up" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                </svg>PERFIL
                            </a></li>
                        <li class="uk-nav-divider"></li>
                        <li><a href="#" id="btnayudaservicio"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
                                    <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                                </svg>AYUDA</a></li>
                        <li class="uk-nav-divider"></li>
                        <li><a href="/Sistema-del--CEM--JEHOVA-RAFA/Bitacora/bitacora"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
                                    <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z" />
                                </svg> CONFIGURACIÓN</a></li>
                        <li class="uk-nav-divider"></li>

                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#eliminar">
                                <img src="<?= $urlBase ?>../src/assets/img/icono-cerrar-sesion.svg" width="34" height="34" uk-svg class="azul"
                                    style="margin-left: -4px;">
                                </svg>SALIR</a></li>
                    </ul>
                </div>
            </div>
        </div>


    </div>







    <!-- modal de cerrar sesión -->
    <?php require_once './src/vistas/modalCierreS/modalCierreS.php'; ?>



    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 col-11 m-auto">
        <div class="col-12 caja-boton">

            <?php if ($parametro != ""): ?>

                <?php if ($parametro[0] == "error"): ?>
                    <div class="uk-alert-danger comentario comentarioRed me-4 fw-bolder h-25" style="display: none;" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p class="pe-2">EL servicio ya exixte.</p>
                    </div>
                <?php elseif ($parametro[0] == "editado"): ?>
                    <div class="uk-alert-primary comentario me-4 fw-bolder h-25" style="display: none;" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p class="pe-2">El servicio se actualizo correctamente.</p>
                    </div>
                <?php elseif ($parametro[0] == "eliminado"): ?>
                    <div class="uk-alert-primary comentario me-4 fw-bolder h-25" style="display: none;" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p class="pe-2">El servicio se ha eliminado correctamente.</p>
                    </div>
                <?php elseif ($parametro[0] == "agregado"): ?>
                    <div class="uk-alert-primary comentario me-4 fw-bolder h-25" style="display: none;" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p class="pe-2">El servicio se ha agregado correctamente.</p>
                    </div>
                <?php elseif ($parametro[0] == "restablecido"): ?>
                    <div class="uk-alert-primary comentario me-4 fw-bolder h-25" style="display: none;" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p class="pe-2">El servicio se ha restablecido correctamente.</p>
                    </div>


                <?php elseif ($parametro[0] == "registrado"): ?>
                    <div class=" d-flex justify-content-center mb-5 comentarioD" style="display: none;">

                        <div class="uk-alert-primary comentario me-4 fw-bolder" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p class="pe-2 text-center">El Doctor se agrego correctamente, por favor registre el Servicio Médico del Doctor</p>
                        </div>

                    </div>
                <?php endif ?>



            <?php endif; ?>

            <button class="btn-guardar-responsive  btn btn-primary btn-agregar-doctores col-8" uk-toggle="target: #modal-example" id="">
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-bandaid-fill me-1" viewBox="0 0 16 16">
                    <path d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z"></path>
                </svg>Registrar Servicio
            </button>

        </div>


        <table class="example table-clinic col-12 ">
            <thead>
                <tr>
                    <th class="text-dark">Servicio</th>
                    <th class="text-dark">Doctor</th>
                    <th class="text-dark">Especialidad</th>
                    <th class="text-dark">Precio</th>
                    <th class="text-dark">Acciones</th>
                </tr>
            </thead>
            <tbody>


                <?php foreach ($servicios as $servicio): ?>
                    <tr>
                        <td class="text-center"><?= $servicio['nombre_categoria'] ?></td>
                        <td class="text-center"><?= $servicio['nombre_personal'] ?> <?= $servicio['apellido_personal'] ?></td>
                        <td class="text-center"><?= $servicio['nombre_especialidad'] ?></td>
                        <td class="text-center"><?= $servicio['precio'] ?> BSs</td>
                        <td class="border-start">





                            <!-- Horario Del Doctor -->
                            <div class="d-flex justify-content-center">

                                <a href="#" class="btns-accion me-2 btnEditarCita botonesEditarSM"
                                    uk-toggle="target: #modal-exampleEditar"
                                    uk-tooltip="Modificar Servicio  " id="btnEditarServicioMedico">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path
                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                        <path fill-rule="evenodd"
                                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                    </svg>
                                </a>



                                <!-- Eliminar CONSULTA-->


                                <a href="#" class="btns-accion me-2"
                                    uk-toggle="target: #modal-exampleEliminar<?= $servicio["id_servicioMedico"] ?>"
                                    uk-tooltip="Eliminar Servicio" id="btnEliminarServicioMedico">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        fill="currentColor" class="bi bi-trash3-fill text-black"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                    </svg>
                                </a>





                            </div>
                        </td>
                    </tr>

                    <!-- Modal de editar -->
                    <div id="modal-exampleEditar" uk-modal>
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
                                        class="bi bi-pencil-fill azul me-3 mb-3" viewBox="0 0 16 16">
                                        <path
                                            d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                    </svg>
                                </div>
                                <div class="">
                                    <p class="uk-modal-title fs-5">
                                        Editar Servicio Médico
                                    </p>
                                </div>

                            </div>

                            <div class="alert alert-danger d-none alertaEditar" role="alert">
                                <div class="">
                                    <p style="font-size: 12px; height:10px; " class="text-center">VERIFIQUE EL FORMULARIO ANTES DE ENVIARLO</p>
                                </div>
                            </div>

                            <form action="/Sistema-del--CEM--JEHOVA-RAFA/Consultas/editar" class="form-modal formEditar" id="modalEditar"
                                method="POST">

                                <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario']; ?>">

                                <input type="hidden" name="id_servicioMedico" value="<?= $servicio["id_servicioMedico"]
                                                                                        ?>">

                                <div class="input-group flex-nowrap">
                                    <span class="input-modal mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-grid-1x2-fill azul" viewBox="0 0 16 16">
                                            <path d="M0 1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V1zm0 9a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-5z" />
                                        </svg> </span>
                                    <select class="form-control input-modal" aria-label="" id="id_categoria" placeholder="id_categoria" name="id_categoria" required>

                                        <option selected disabled>
                                            <?php echo $servicio['nombre_categoria'] ?>

                                        </option>


                                    </select>


                                </div>


                                <div class="input-group flex-nowrap">
                                    <span class="input-modal mt-1">
                                        <img src="./src/assets/img/doctor (2).png" width="19" height="19" uk-svg class="azul">
                                    </span>

                                    <select class="form-control input-modal input-disabled" aria-label="" placeholder="Id_doctor"
                                        name="id_doctor" id="id_doctorEditar">
                                        <option value="<?php echo $servicio['id_personal']; ?>" selected>
                                            <?php echo $servicio['nombre_personal']; ?> <?php echo $servicio['apellido_personal']; ?>
                                        </option>
                                    </select>

                                    <span class="input-modal mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-lungs-fill azul" viewBox="0 0 16 16">
                                            <path d="M8 1a.5.5 0 0 1 .5.5v5.243L9 7.1V4.72C9 3.77 9.77 3 10.72 3c.524 0 1.023.27 1.443.592.431.332.847.773 1.216 1.229.736.908 1.347 1.946 1.58 2.48.176.405.393 1.16.556 2.011.165.857.283 1.857.24 2.759-.04.867-.232 1.79-.837 2.33-.67.6-1.622.556-2.741-.004l-1.795-.897A2.5 2.5 0 0 1 9 11.264V8.329l-1-.715-1 .715V7.214c-.1 0-.202.03-.29.093l-2.5 1.786a.5.5 0 1 0 .58.814L7 8.329v2.935A2.5 2.5 0 0 1 5.618 13.5l-1.795.897c-1.12.56-2.07.603-2.741.004-.605-.54-.798-1.463-.838-2.33-.042-.902.076-1.902.24-2.759.164-.852.38-1.606.558-2.012.232-.533.843-1.571 1.579-2.479.37-.456.785-.897 1.216-1.229C4.257 3.27 4.756 3 5.28 3 6.23 3 7 3.77 7 4.72V7.1l.5-.357V1.5A.5.5 0 0 1 8 1Zm3.21 8.907a.5.5 0 1 0 .58-.814l-2.5-1.786A.498.498 0 0 0 9 7.214V8.33l2.21 1.578Z" />
                                        </svg>
                                    </span>
                                    <input class="form-control input-modal input-disabled" type="text" id="inputEspecialidadEditar" name="especialidad" placeholder="Especialidad" disabled value="<?= $servicio["5"] ?>">

                                </div>


                                <div class="input-group flex-nowrap claseExpresiones editargrp_precio" id="editargrp_precio">
                                    <span class="input-modal mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                            class="bi bi-currency-exchange azul" viewBox="0 0 16 16">
                                            <path
                                                d="M0 5a5.002 5.002 0 0 0 4.027 4.905 6.46 6.46 0 0 1 .544-2.073C3.695 7.536 3.132 6.864 3 5.91h-.5v-.426h.466V5.05c0-.046 0-.093.004-.135H2.5v-.427h.511C3.236 3.24 4.213 2.5 5.681 2.5c.316 0 .59.031.819.085v.733a3.46 3.46 0 0 0-.815-.082c-.919 0-1.538.466-1.734 1.252h1.917v.427h-1.98c-.003.046-.003.097-.003.147v.422h1.983v.427H3.93c.118.602.468 1.03 1.005 1.229a6.5 6.5 0 0 1 4.97-3.113A5.002 5.002 0 0 0 0 5zm16 5.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0zm-7.75 1.322c.069.835.746 1.485 1.964 1.562V14h.54v-.62c1.259-.086 1.996-.74 1.996-1.69 0-.865-.563-1.31-1.57-1.54l-.426-.1V8.374c.54.06.884.347.966.745h.948c-.07-.804-.779-1.433-1.914-1.502V7h-.54v.629c-1.076.103-1.808.732-1.808 1.622 0 .787.544 1.288 1.45 1.493l.358.085v1.78c-.554-.08-.92-.376-1.003-.787H8.25zm1.96-1.895c-.532-.12-.82-.364-.82-.732 0-.41.311-.719.824-.809v1.54h-.005zm.622 1.044c.645.145.943.38.943.796 0 .474-.37.8-1.02.86v-1.674l.077.018z" />
                                        </svg>
                                    </span>

                                    <input class="form-control input-modal" type="text" name="precioEditar" placeholder="Precio" required value="<?= $servicio["precio"] ?>">
                                    <span class="input-modal mt-1">
                                        Bs
                                    </span>

                                </div>
                                <div class="d-none d-flex align-items-center justify-content-center leyendaEditar" style="font-size: 12px; margin-top: -10px; margin-bottom: 5px; ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle azul me-1" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                    </svg>
                                    <i>El formato del precio es incorrecto, Ejemplo 0,00 - 00,00 - 000,00 - 0.000,00 </i>
                                </div>

                                <!-- <div class=" d-none d-flex align-items-center justify-content-center" id="leyendaEditar" style="font-size: 12px; margin-top: -10px; margin-bottom: 5px; ">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle azul me-1" viewBox="0 0 16 16">
  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
</svg>
<i>El formato del precio es incorrecto, Ejemplo 0,00 - 00,00 - 000,00 - 0.000,00 </i>
</div> -->






                                <div class="mt-3 uk-text-right">
                                    <button
                                        class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                                        type="button">Cancelar</button>
                                    <button class="btn col-3 btn-agregarcita-modal" type="submit">Editar</button>
                                </div>
                            </form>


                        </div>
                    </div>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>


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
                    class="bi bi-clipboard2-plus-fill azul me-3 mb-3" viewBox="0 0 16 16">
                    <path
                        d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5Z" />
                    <path
                        d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585c.055.156.085.325.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5c0-.175.03-.344.085-.5ZM8.5 6.5V8H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V9H6a.5.5 0 0 1 0-1h1.5V6.5a.5.5 0 0 1 1 0Z" />
            </div>
            <div class="">
                <p class="uk-modal-title fs-5 ">
                    Registrar Servicio
                </p>
            </div>

        </div>

        <div class="alert alert-danger d-none" role="alert" id="alerta"">
  <div class="">
   <p style=" font-size: 12px; height:10px; " class=" text-center">VERIFIQUE EL FORMULARIO ANTES DE ENVIARLO</p>
        </div>
    </div>

    <form class="form-modal" id="modalAgregar" action="/Sistema-del--CEM--JEHOVA-RAFA/Consultas/guardar" method="POST" autocomplete="off">
        <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario']; ?>">


        <div class="input-group flex-nowrap">
            <span class="input-modal mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-grid-1x2-fill azul" viewBox="0 0 16 16">
                    <path d="M0 1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V1zm0 9a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-5z" />
                </svg> </span>
            <select class="form-control input-modal" aria-label="" id="id_categoria" placeholder="id_categoria" name="id_categoria" required>
                <option value="" selected disabled>Seleccione la Categoría del Servicio</option>

                <?php foreach ($todasLasCategorias as $categoria): ?>
                    <option value="<?php echo $categoria['id_categoria']; ?>">
                        <?php echo $categoria["nombre"] ?>

                    </option>

                <?php endforeach ?>

            </select>


        </div>

        <div class="input-group flex-nowrap">
            <span class="input-modal mt-1">
                <img src="./src/assets/img/doctor (2).png" width="21" height="21" uk-svg class="azul">
            </span>
            <select class="form-control input-modal" aria-label="" id="id_doctor" placeholder="Id_doctor" name="id_doctor" required>
                <option value="" selected disabled>Doctor</option>

                <?php foreach ($doctores as $doctor): ?>
                    <option value="<?php echo $doctor['id_personal']; ?>" class="opcionSelect">
                        <?php echo $doctor["nombre"] ?> <?php echo $doctor["apellido"] ?>

                    </option>
                <?php endforeach ?>

            </select>
            <span class="input-modal mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-lungs-fill azul" viewBox="0 0 16 16">
                    <path d="M8 1a.5.5 0 0 1 .5.5v5.243L9 7.1V4.72C9 3.77 9.77 3 10.72 3c.524 0 1.023.27 1.443.592.431.332.847.773 1.216 1.229.736.908 1.347 1.946 1.58 2.48.176.405.393 1.16.556 2.011.165.857.283 1.857.24 2.759-.04.867-.232 1.79-.837 2.33-.67.6-1.622.556-2.741-.004l-1.795-.897A2.5 2.5 0 0 1 9 11.264V8.329l-1-.715-1 .715V7.214c-.1 0-.202.03-.29.093l-2.5 1.786a.5.5 0 1 0 .58.814L7 8.329v2.935A2.5 2.5 0 0 1 5.618 13.5l-1.795.897c-1.12.56-2.07.603-2.741.004-.605-.54-.798-1.463-.838-2.33-.042-.902.076-1.902.24-2.759.164-.852.38-1.606.558-2.012.232-.533.843-1.571 1.579-2.479.37-.456.785-.897 1.216-1.229C4.257 3.27 4.756 3 5.28 3 6.23 3 7 3.77 7 4.72V7.1l.5-.357V1.5A.5.5 0 0 1 8 1Zm3.21 8.907a.5.5 0 1 0 .58-.814l-2.5-1.786A.498.498 0 0 0 9 7.214V8.33l2.21 1.578Z" />
                </svg>
            </span>
            <input class="form-control input-modal input-disabled" type="text" id="inputEspecialidad" name="especialidad" placeholder="Especialidad" disabled>

        </div>








        <div class="input-group flex-nowrap " id="grp_precio">
            <span class="input-modal mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-currency-exchange azul" viewBox="0 0 16 16">
                    <path
                        d="M0 5a5.002 5.002 0 0 0 4.027 4.905 6.46 6.46 0 0 1 .544-2.073C3.695 7.536 3.132 6.864 3 5.91h-.5v-.426h.466V5.05c0-.046 0-.093.004-.135H2.5v-.427h.511C3.236 3.24 4.213 2.5 5.681 2.5c.316 0 .59.031.819.085v.733a3.46 3.46 0 0 0-.815-.082c-.919 0-1.538.466-1.734 1.252h1.917v.427h-1.98c-.003.046-.003.097-.003.147v.422h1.983v.427H3.93c.118.602.468 1.03 1.005 1.229a6.5 6.5 0 0 1 4.97-3.113A5.002 5.002 0 0 0 0 5zm16 5.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0zm-7.75 1.322c.069.835.746 1.485 1.964 1.562V14h.54v-.62c1.259-.086 1.996-.74 1.996-1.69 0-.865-.563-1.31-1.57-1.54l-.426-.1V8.374c.54.06.884.347.966.745h.948c-.07-.804-.779-1.433-1.914-1.502V7h-.54v.629c-1.076.103-1.808.732-1.808 1.622 0 .787.544 1.288 1.45 1.493l.358.085v1.78c-.554-.08-.92-.376-1.003-.787H8.25zm1.96-1.895c-.532-.12-.82-.364-.82-.732 0-.41.311-.719.824-.809v1.54h-.005zm.622 1.044c.645.145.943.38.943.796 0 .474-.37.8-1.02.86v-1.674l.077.018z" />
                </svg>
            </span>

            <input class="form-control input-modal" type="text" name="precio" placeholder="Precio" required>
            <span class="input-modal mt-1">BS</span>

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

<script src="<?= $urlBase; ?>../src/assets/js/servicioMedico.js">
</script>
<script src="<?= $urlBase; ?>../src/assets/js/ayudaServicioMedico.js"></script>
<script src="<?= $urlBase; ?>../src/assets/js/validacionesServiciosMedicosRegistrar.js"></script>


<?php require_once './src/vistas/vistaConsultas/modalesCategoria.php'; ?>
<?php require_once './src/vistas/head/footer.php'; ?>