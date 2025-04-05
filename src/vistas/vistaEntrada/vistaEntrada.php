<?php require_once './src/vistas/head/head.php'; ?>
<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
        <div class="ms-5 d-flex align-items-center" id="inicioDirectorio">
            <h1 class="fw-bold">INSUMOS</h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" fill="currentColor" class="bi bi-capsule ms-2" viewBox="0 0 16 16">
                <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
            </svg>
        </div>

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
                    <li><a href="#" id="btnayudaServicioMedico"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
                                <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                            </svg>AYUDA</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="/Sistema-del--CEM--JEHOVA-RAFA/Bitacora/bitacora"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
                                <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z" />
                            </svg> CONFIGURACIÓN</a></li>
                    <li class="uk-nav-divider"></li>



                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#eliminar">
                            <img src="./src/assets/img/icono-cerrar-sesion.svg" width="34" height="34" uk-svg class="azul" style="margin-left: -4px;">
                            </svg>SALIR</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- modal de cerrar sesión -->
    <?php require_once './src/vistas/modalCierreS/modalCierreS.php'; ?>

</div>

<!-- paginación servicio medico -->
<div class="d-flex">

    <div class="w-75 ms-5">
        <h3 class="fw-bold" id="inicioServicio">ENTRADAS

            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-inboxes mb-2" viewBox="0 0 16 16">
                <path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562A.5.5 0 0 0 1.884 9h12.234a.5.5 0 0 0 .496-.438L14.933 6zM3.809.563A1.5 1.5 0 0 1 4.981 0h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393zm.941.83.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438l.32-2.562H10.45a2.5 2.5 0 0 1-4.9 0H1.066z" />
            </svg>
        </h3>

    </div>

    <div class=" me-3 mb-4  d-flex justify-content-end w-100">


        <ul class="sin-circulos d-flex justify-content-end">

            <li class="li">
                <div class="borde-de-menu  mb-1"></div>
                <div class="hover-grande">
                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Insumos/insumos" class="text-decoration-none text-black me-3" id="DMservicioMedico">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-capsule me-1" viewBox="0 0 16 16">
                            <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                        </svg>Insumos</a>
                </div>
            </li>
            <li class="li">
                <div class="borde-de-menu mb-1  activo-border"></div>
                <div class="hover-grande">
                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Entrada/entrada" class="text-decoration-none text-black me-3 iconoDoctor" id="DMdoctores">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-inboxes-fill me-1 mb-1 azul" viewBox="0 0 16 16">
                            <path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zM3.81.563A1.5 1.5 0 0 1 4.98 0h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393z" />
                        </svg>Entradas de Insumo</a>
                </div>

            </li>
            <li class="li">
                <div class="borde-de-menu mb-1 color-linea "></div>
                <div class="hover-grande">

                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Proveedores/proveedores" class="text-decoration-none text-black me-3" id="DMserviciosExtras">
                        <img src="<?= $urlBase ?>../src/assets/img/proveedor (3).png" width="20" height="20" uk-svg class="me-1">Proveedores</a>
                </div>

            </li>

            <li class="li">
                <div class="borde-de-menu mb-1 "></div>
                <div class="hover-grande">
                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Insumos/InsumosVencidos" class="text-decoration-none text-black me-3 iconoDoctor" id="DMdoctores">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-inboxes-fill me-1 mb-1" viewBox="0 0 16 16">
                            <path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zM3.81.563A1.5 1.5 0 0 1 4.98 0h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393z" />
                        </svg>Entrada de Insumos Vencidas</a>
                </div>

            </li>


        </ul>

    </div>
</div>


<div style="width: 95%;">
    <div class=" me-3 mb-4  d-flex justify-content-end w-100">


        <ul class="sin-circulos d-flex justify-content-end">



            <li class="li">
                <div class="borde-de-menu mb-1 color-linea "></div>
                <div class="hover-grande">
                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Entrada/papelera" class="text-decoration-none text-black me-3 iconoDoctor" id="DMdoctores">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-recycle me-1 mb-1" viewBox="0 0 16 16">
                            <path d="M9.302 1.256a1.5 1.5 0 0 0-2.604 0l-1.704 2.98a.5.5 0 0 0 .869.497l1.703-2.981a.5.5 0 0 1 .868 0l2.54 4.444-1.256-.337a.5.5 0 1 0-.26.966l2.415.647a.5.5 0 0 0 .613-.353l.647-2.415a.5.5 0 1 0-.966-.259l-.333 1.242-2.532-4.431zM2.973 7.773l-1.255.337a.5.5 0 1 1-.26-.966l2.416-.647a.5.5 0 0 1 .612.353l.647 2.415a.5.5 0 0 1-.966.259l-.333-1.242-2.545 4.454a.5.5 0 0 0 .434.748H5a.5.5 0 0 1 0 1H1.723A1.5 1.5 0 0 1 .421 12.24l2.552-4.467zm10.89 1.463a.5.5 0 1 0-.868.496l1.716 3.004a.5.5 0 0 1-.434.748h-5.57l.647-.646a.5.5 0 1 0-.708-.707l-1.5 1.5a.498.498 0 0 0 0 .707l1.5 1.5a.5.5 0 1 0 .708-.707l-.647-.647h5.57a1.5 1.5 0 0 0 1.302-2.244l-1.716-3.004z" />
                        </svg>Papelera De Entrada</a>
                </div>

            </li>




        </ul>

    </div>
</div>

<div>

    <!-- alerta -->
    <div class="alert alert-danger d-none text-center" id="alerta-fecha"></div>

    <div class="d-flex justify-content-end">



        <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 col-11 m-auto">


            <div class="col-12 caja-boton">
                <button class="btn-guardar-responsive  btn btn-primary btn-agregar-doctores col-8" uk-toggle="target: #modal-exampleEntrada" id="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-bandaid-fill me-1" viewBox="0 0 16 16">
                        <path d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z"></path>
                    </svg>Agregar Entrada
                </button>
            </div>

            <table class="example table-clinic col-12 ">
                <thead>
                    <tr>
                        <th class="text-dark">Nombre</th>
                        <th class="text-dark">Proveedor</th>
                        <th class="text-dark">Fecha De Ingreso</th>
                        <th class="text-dark">Fecha De Vencimiento</th>
                        <th class="text-dark">Cantidad</th>
                        <th class="text-dark">Precio</th>
                        <th class="text-dark">Numero De Lote</th>
                        <th class="text-dark">Acciones</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($entradas as $entrada): ?>
                        <tr>
                            <td class="text-center"><?= $entrada['nombre'] ?> </td>
                            <td class="text-center"><?= $entrada['proveedor'] ?></td>
                            <td class="text-center"><?= $entrada['fechaDeIngreso'] ?></td>
                            <td class="text-center"><?= $entrada['fechaDeVencimiento'] ?></td>
                            <td class="text-center"><?= $entrada['cantidad_entrada'] ?></td>
                            <td class="text-center"><?= $entrada['precio_entrada'] ?> BSs</td>
                            <td class="text-center"><?= $entrada['numero_de_lote'] ?></td>



                            <td class="text-center">

                                <div class="d-flex justify-content-center align-items-center">
                                    <!-- eliminar -->
                                    <div class="me-2">
                                        <button class="btn btn-tabla mb-1" uk-toggle="target: #modal-exampleEntradaEliminar<?= $entrada["id_entradaDeInsumo"] ?>" id="btnEliminarDoctor">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- eliminar -->
                                    <div>
                                        <button class="btn btn-tabla mb-1 btn-js editar botonesEdi" uk-toggle="target: #modal-exampleEntradaEditar<?= $entrada["id_entradaDeInsumo"] ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                            </svg>
                                        </button>
                                    </div>




                                </div>
                                <!-- modal editar -->

                                <!-- editar Entrada -->
                                <div id="modal-exampleEntradaEditar<?= $entrada["id_entradaDeInsumo"] ?>" uk-modal>
                                    <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                                        <!-- Boton que cierra el modal -->
                                        <a href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                            </svg>
                                        </a>

                                        <div class="d-flex align-items-center">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-inboxes-fill azul me-2 mb-3" viewBox="0 0 16 16">
                                                    <path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zM3.81.563A1.5 1.5 0 0 1 4.98 0h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393z" />
                                                </svg>
                                            </div>
                                            <div class="">
                                                <p class="uk-modal-title fs-5">
                                                    Modificar Entrada
                                                </p>
                                            </div>

                                        </div>

                                        <form class="form-modal" method="POST" action="/Sistema-del--CEM--JEHOVA-RAFA/Entrada/guardar" autocomplete="off" id="modalAgregarEntrada">
                                            <div id="alerta-guardar-entrada" class="alert alert-danger d-none">VERIFIQUE EL FORMULARIO ANTES DE ENVIARLO
                                            </div>

                                            <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario']; ?>">




                                            <div class="input-group flex-nowrap">
                                                <span class="input-modal mt-1 d-flex col-6" style="border-right: 3px solid #387ADF;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-capsule azul" viewBox="0 0 16 16">
                                                        <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                                                    </svg>
                                                    <div class=" text-center m-auto" style="font-size: 14px;">Nombre del Insumo</div>
                                                </span>
                                                <!-- <input class="form-control input-modal input-disabled input" type="text" placeholder="Ingrese el Insumo" id="nombre_insumo" disabled> -->
                                                <select class="form-control input-modal" name="id_insumo" id="id_insumoModal">
                                                    <option disabled selected value="<?= $entrada["id_insumo"] ?>"><?= $entrada["nombre"] ?></option>
                                                    <?php foreach ($insumos as $in): ?>
                                                        <option value="<?= $in["id_insumo"] ?>">
                                                            <?= $in["nombre"] ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>


                                                <!-- <input type="hidden" name="id_insumo" id="id_insumo"> -->
                                            </div>


                                            <input type="hidden" name="id_entrada" value="<?= $entrada["id_entrada"] ?>">

                                            <input type="hidden" name="id_proveedor" value="<?= $entrada["id_proveedor"] ?>">


                                            <input type="hidden" name="id_insumo" value="<?= $entrada["id_insumo"] ?>">




                                            <div class="input-group flex-nowrap">
                                                <span class="input-modal mt-1 d-flex col-6" style="border-right: 3px solid #387ADF;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-capsule azul" viewBox="0 0 16 16">
                                                        <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                                                    </svg>
                                                    <div class=" text-center m-auto" style="font-size: 14px;">Numero de Lote</div>
                                                </span>
                                                <!-- <input class="form-control input-modal input-disabled input" type="text" placeholder="Ingrese el Insumo" id="nombre_insumo" disabled> -->
                                                <input type="number" class="form-control input-modal" name="lote" value="<?= $entrada["numero_de_lote"] ?>">



                                                <!-- <input type="hidden" name="id_insumo" id="id_insumo"> -->
                                            </div>

                                            <div class="input-group flex-nowrap d-none">
                                                <span class="input-modal mt-1 d-flex col-6" style="border-right: 2px solid #387ADF;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-check-fill azul" viewBox="0 0 16 16">
                                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-2.6 5.854a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z" />
                                                    </svg>
                                                    <div class=" text-center m-auto" style="font-size: 14px;">Fecha de Ingreso</div>
                                                </span>
                                                <input class="form-control input-modal input" type="date" name="fechaDeIngreso" placeholder="Fecha De Ingreso" id="fechaDeIngreso" value=<?= date('Y-m-d'); ?>>
                                            </div>

                                            <div class="input-group flex-nowrap">
                                                <span class="input-modal mt-1 d-flex col-6" style="border-right: 2px solid #387ADF;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-check-fill azul" viewBox="0 0 16 16">
                                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-2.6 5.854a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z" />
                                                    </svg>
                                                    <div class=" text-center m-auto" style="font-size: 14px;">Fecha de Vencimiento</div>
                                                </span>
                                                <input class="form-control input-modal input" type="date" name="fechaDeVencimiento" placeholder="Fecha De Vencimiento" id="fechaDeVencimiento" value="<?= $entrada["fechaDeVencimiento"] ?>">
                                            </div>






                                            <div class="input-group flex-nowrap">
                                                <span class="input-modal mt-1 d-flex col-6" style="border-right: 2px solid #387ADF;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-stack azul" viewBox="0 0 16 16">
                                                        <path d="m14.12 10.163 1.715.858c.22.11.22.424 0 .534L8.267 15.34a.598.598 0 0 1-.534 0L.165 11.555a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.66zM7.733.063a.598.598 0 0 1 .534 0l7.568 3.784a.3.3 0 0 1 0 .535L8.267 8.165a.598.598 0 0 1-.534 0L.165 4.382a.299.299 0 0 1 0-.535L7.733.063z" />
                                                        <path d="m14.12 6.576 1.715.858c.22.11.22.424 0 .534l-7.568 3.784a.598.598 0 0 1-.534 0L.165 7.968a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.659z" />
                                                    </svg>
                                                    <div class=" text-center m-auto" style="font-size: 14px;">Cantidad</div>
                                                </span>
                                                <input class="form-control input-modal input" type="text" name="cantidad" placeholder="Cantidad" required value="<?= $entrada["cantidad_entrada"] ?>">
                                            </div>


                                            <div class="input-group flex-nowrap">
                                                <span class="input-modal mt-1 d-flex col-6" style="border-right: 2px solid #387ADF;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cash-coin azul" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z" />
                                                        <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z" />
                                                        <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z" />
                                                        <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z" />
                                                    </svg>
                                                    <div class=" text-center m-auto" style="font-size: 14px;">Precio</div>
                                                </span>
                                                <input class="form-control input-modal input" type="text" name="precio" placeholder="Precio" required value="<?= $entrada["precio_entrada"] ?>">

                                            </div>
                                            <i id="formatoPrecio" class="d-none">El formato del precio es incorrecto, Ejemplo 0,00 - 00,00 - 000,00 - 0.000,00 </i>




                                            <div class="mt-3 uk-text-right">
                                                <button class="uk-button col-6 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>

                                                <button class="btn col-5 btn-agregarcita-modal" type="submit" name="guardar">Editar</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>


                                <!-- modal -->





                                <!-- modal -->
                                <div id="modal-exampleEntradaEliminar<?= $entrada["id_entradaDeInsumo"]; ?>" uk-modal>
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
                                                    ¿Desea Eliminar La Entrada ?
                                            </div>
                                        </div>

                                        <div class="mt-3 uk-text-right">
                                            <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                                                type="button">Cancelar</button>
                                            <a class="btn col-3 btn-agregarcita-modal text-decoration-none"
                                                href="/Sistema-del--CEM--JEHOVA-RAFA/Entrada/eliminar/<?= $entrada["id_entrada"]; ?>/<?= $entrada["id_insumo"]; ?>/<?= $_SESSION['id_usuario']; ?>">Eliminar</a>
                                        </div>

                                    </div>
                                </div>

                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>




















    </div>
</div>

</div>
























<!-- agregar Entrada -->
<div id="modal-exampleEntrada" uk-modal>
    <div class="uk-modal-dialog uk-modal-body tamaño-modal">
        <!-- Boton que cierra el modal -->
        <a href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
            </svg>
        </a>

        <div class="d-flex align-items-center">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-inboxes-fill azul me-2 mb-3" viewBox="0 0 16 16">
                    <path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zM3.81.563A1.5 1.5 0 0 1 4.98 0h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393z" />
                </svg>
            </div>
            <div class="">
                <p class="uk-modal-title fs-5">
                    Registrar Entrada
                </p>
            </div>

        </div>

        <form class="form-modal form-validable" method="POST" action="/Sistema-del--CEM--JEHOVA-RAFA/Entrada/guardar" autocomplete="off" id="modalAgregarEntrada">
            <div id="alerta-guardar-entrada" class="alert alert-danger d-none">VERIFIQUE EL FORMULARIO ANTES DE ENVIARLO
            </div>

            <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario']; ?>">

            <div class="input-group flex-nowrap">
                <span class="input-modal mt-1">
                    <img src="../src/assets/img/proveedor(2).png" width="20" height="20" uk-svg class="me-1">
                </span>

                <select class="form-control input-modal" name="id_proveedor">
                    <?php foreach ($proveedores as $proveedor): ?>
                        <option value="<?= $proveedor['id_proveedor'] ?>">
                            <?= $proveedor['nombre'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>


            <div class="input-group flex-nowrap">
                <span class="input-modal mt-1 d-flex col-6" style="border-right: 3px solid #387ADF;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-capsule azul" viewBox="0 0 16 16">
                        <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                    </svg>
                    <div class=" text-center m-auto" style="font-size: 14px;">Nombre del Insumo</div>
                </span>
                <!-- <input class="form-control input-modal input-disabled input" type="text" placeholder="Ingrese el Insumo" id="nombre_insumo" disabled> -->
                <select class="form-control input-modal" name="id_insumo" id="id_insumoModal">
                    <?php foreach ($insumos as $in): ?>
                        <option value="<?= $in["id_insumo"] ?>">
                            <?= $in["nombre"] ?>
                        </option>
                    <?php endforeach ?>
                </select>


                <!-- <input type="hidden" name="id_insumo" id="id_insumo"> -->
            </div>


            <div class="input-group flex-nowrap">
                <span class="input-modal mt-1 d-flex col-6" style="border-right: 3px solid #387ADF;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-capsule azul" viewBox="0 0 16 16">
                        <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                    </svg>
                    <div class=" text-center m-auto" style="font-size: 14px;">Numero de Lote</div>
                </span>
                <!-- <input class="form-control input-modal input-disabled input" type="text" placeholder="Ingrese el Insumo" id="nombre_insumo" disabled> -->
                <input type="number" class="form-control input-modal input-validar" name="lote">




                <!-- <input type="hidden" name="id_insumo" id="id_insumo"> -->
            </div>

            <p class="p-error-lote d-none">El numero de lote solo debe incluir numeros minimos 4</p>

            <div class="input-group flex-nowrap d-none">
                <span class="input-modal mt-1 d-flex col-6" style="border-right: 2px solid #387ADF;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-check-fill azul" viewBox="0 0 16 16">
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-2.6 5.854a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z" />
                    </svg>
                    <div class=" text-center m-auto" style="font-size: 14px;">Fecha de Ingreso</div>
                </span>
                <input class="form-control input-modal input" type="date" name="fechaDeIngreso" placeholder="Fecha De Ingreso" id="fechaDeIngreso" value=<?= date('Y-m-d'); ?>>
            </div>

            <div class="input-group flex-nowrap">
                <span class="input-modal mt-1 d-flex col-6" style="border-right: 2px solid #387ADF;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-check-fill azul" viewBox="0 0 16 16">
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-2.6 5.854a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z" />
                    </svg>
                    <div class=" text-center m-auto" style="font-size: 14px;">Fecha de Vencimiento</div>
                </span>
                <input class="form-control input-modal input input-validar" type="date" name="fechaDeVencimiento" placeholder="Fecha De Vencimiento" id="fechaDeVencimiento">
            </div>

            <p class="p-error-fechaDeVencimiento d-none"></p>






            <div class="input-group flex-nowrap">
                <span class="input-modal mt-1 d-flex col-6" style="border-right: 2px solid #387ADF;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-stack azul" viewBox="0 0 16 16">
                        <path d="m14.12 10.163 1.715.858c.22.11.22.424 0 .534L8.267 15.34a.598.598 0 0 1-.534 0L.165 11.555a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.66zM7.733.063a.598.598 0 0 1 .534 0l7.568 3.784a.3.3 0 0 1 0 .535L8.267 8.165a.598.598 0 0 1-.534 0L.165 4.382a.299.299 0 0 1 0-.535L7.733.063z" />
                        <path d="m14.12 6.576 1.715.858c.22.11.22.424 0 .534l-7.568 3.784a.598.598 0 0 1-.534 0L.165 7.968a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.659z" />
                    </svg>
                    <div class=" text-center m-auto" style="font-size: 14px;">Cantidad</div>
                </span>
                <input class="form-control input-modal input input-validar" type="text" name="cantidad" placeholder="Cantidad" required>
            </div>

            <p class="p-error-cantidad d-none">La cantidad debe ser solo datos numericos</p>


            <div class="input-group flex-nowrap">
                <span class="input-modal mt-1 d-flex col-6" style="border-right: 2px solid #387ADF;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cash-coin azul" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z" />
                        <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z" />
                        <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z" />
                        <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z" />
                    </svg>
                    <div class=" text-center m-auto" style="font-size: 14px;">Precio</div>
                </span>
                <input class="form-control input-modal input input-validar" type="text" name="precio" placeholder="Precio" required>

            </div>
            <!-- <i id="formatoPrecio" class="d-none">El formato del precio es incorrecto, Ejemplo 0,00 - 00,00 - 000,00 - 0.000,00 </i> -->


            <p class="p-error-precio d-none">El formato del precio es incorrecto, Ejemplo 0,00 - 00,00 - 000,00 - 0.000,00</p>

            <div class="mt-3 uk-text-right">
                <button class="uk-button col-6 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>

                <button class="btn col-5 btn-agregarcita-modal" type="submit" name="guardar">Agregar</button>
            </div>

        </form>
    </div>
</div>



<!-- agregar Entrada -->






<?php require_once './src/vistas/head/footer.php'; ?>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/expresionesModulares.js"></script>