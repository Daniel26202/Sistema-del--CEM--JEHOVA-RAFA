<?php require_once './src/vistas/head/head.php'; ?>



<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">


    <h5 style="width: 95%; " class="m-auto mb-3">Proveedores <img src="<?= $urlBase ?>../src/assets/img/proveedor (1).png" width="22" height="22" uk-svg class="mb-2"></h5>

    <!-- alertas -->

    <?php require_once "./src/vistas/alerts.php" ?>

    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto" style="width: 95%; ">
        <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">

            <?php require_once "./src/vistas/vistaInsumos/paginationInsumos.php" ?>

            <div style="width: 95%;">
                <div class=" me-3 mb-2  d-flex justify-content-end w-100">


                    <ul class="sin-circulos d-flex justify-content-end">



                        <li class="li">
                            <div class="borde-de-menu mb-1 color-linea "></div>
                            <div class="hover-grande">
                                <a href="/Sistema-del--CEM--JEHOVA-RAFA/Proveedores/papelera" class="text-decoration-none me-3 color-letras iconoDoctor" id="DMdoctores">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-recycle me-1 mb-1" viewBox="0 0 16 16">
                                        <path d="M9.302 1.256a1.5 1.5 0 0 0-2.604 0l-1.704 2.98a.5.5 0 0 0 .869.497l1.703-2.981a.5.5 0 0 1 .868 0l2.54 4.444-1.256-.337a.5.5 0 1 0-.26.966l2.415.647a.5.5 0 0 0 .613-.353l.647-2.415a.5.5 0 1 0-.966-.259l-.333 1.242-2.532-4.431zM2.973 7.773l-1.255.337a.5.5 0 1 1-.26-.966l2.416-.647a.5.5 0 0 1 .612.353l.647 2.415a.5.5 0 0 1-.966.259l-.333-1.242-2.545 4.454a.5.5 0 0 0 .434.748H5a.5.5 0 0 1 0 1H1.723A1.5 1.5 0 0 1 .421 12.24l2.552-4.467zm10.89 1.463a.5.5 0 1 0-.868.496l1.716 3.004a.5.5 0 0 1-.434.748h-5.57l.647-.646a.5.5 0 1 0-.708-.707l-1.5 1.5a.498.498 0 0 0 0 .707l1.5 1.5a.5.5 0 1 0 .708-.707l-.647-.647h5.57a1.5 1.5 0 0 0 1.302-2.244l-1.716-3.004z" />
                                    </svg>Papelera De Proveedores</a>
                            </div>

                        </li>




                    </ul>

                </div>
            </div>


            <?php if (!$this->permisos($_SESSION["id_rol"], "guardar", "Proveedores")): ?>
                <!-- no hay -->
            <?php else: ?>


                <button class="btn-guardar-responsive  btn btn-primary btn-agregar-doctores col-8" uk-toggle="target: #modal-exampleProveedores" id="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-bandaid-fill me-1" viewBox="0 0 16 16">
                        <path d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z"></path>
                    </svg>Registrar Proveedores
                </button>
            <?php endif; ?>
        </div>



        <div class="table table-responsive">

            <table class="example table table-striped">
                <thead>
                    <tr>
                        <th class="text-dark text-center">Nombre</th>
                        <th class="text-dark text-center">Rif</th>
                        <th class="text-dark text-center">Telefono</th>
                        <th class="text-dark text-center">Correo</th>
                        <th class="text-dark text-center">Direccion</th>
                        <th class="text-dark text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>



                    <?php foreach ($proveedor as $proveedor): ?>
                        <tr>

                            <td class="border-start text-center border-start-0">
                                <?php echo $proveedor["nombre"] ?>
                            </td>
                            <td class="border-start text-center">
                                <?php echo $proveedor["rif"] ?>
                            </td>
                            <td class="border-start text-center">
                                <?php echo $proveedor["telefono"] ?>
                            </td>
                            <td class="border-start text-center">
                                <?php echo $proveedor["email"] ?>
                            </td>
                            <td class="border-start text-center">
                                <?php echo $proveedor["direccion"] ?>
                            </td>
                            <td class="border-start d-flex justify-content-center">

                                <!-- Editar Proveedor -->
                                <div class="me-2">
                                    <a href="#" class="btn btn-tabla mb-1" uk-toggle="target: #modal-exampleEditarProveedores<?= $proveedor["id_proveedor"];  ?>" uk-tooltip="Modificar Proveedores">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                            class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                        </svg>
                                    </a>
                                </div>


                                <!-- Eliminar Proveedores-->

                                <div class="me-2">
                                    <a href="#" class="btn btn-tabla mb-1" uk-toggle="target: #modal-exampleEliminarProveedores<?= $proveedor["id_proveedor"]; ?>" uk-tooltip="Eliminar Proveedores">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                            class="bi bi-trash3" viewBox="0 0 16 16">
                                            <path
                                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                        </svg>
                                    </a>
                                </div>






                                <!--ELIMINAR MODAL-->

                                <div id="modal-exampleEliminarProveedores<?= $proveedor["id_proveedor"]; ?>" uk-modal>
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

                                                    ¿Desea eliminar al Proveedor
                                                    <?php echo $proveedor["nombre"] ?> ?
                                                </h5>
                                            </div>
                                        </div>

                                        <div class="mt-3 uk-text-right">
                                            <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                                                type="button">Cancelar</button>
                                            <a href="/Sistema-del--CEM--JEHOVA-RAFA/Proveedores/update/<?php echo $proveedor["id_proveedor"] ?>/<?= $_SESSION['id_usuario']; ?>"
                                                class="btn col-3 btn-agregarcita-modal text-decoration-none"
                                                type="button">Eliminar</a>
                                        </div>

                                    </div>
                                </div>



                                <!--MODAL EDITAR-->

                                <div id="modal-exampleEditarProveedores<?= $proveedor["id_proveedor"]; ?>" uk-modal>
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
                                                <img src="./src/assets/img/proveedor(2).png" width="25" height="25" uk-svg class="me-2 mb-3">
                                            </div>
                                            <div class="">
                                                <p class="uk-modal-title fs-5">
                                                    Editar Proveedor
                                                </p>
                                            </div>

                                        </div>

                                        <div class="alert alert-danger d-none alerta-editar-proveedor text-center" style="font-size: 10px;">VERIFIQUE EL FORMULARIO ANTES DE ENVIARLO</div>


                                        <form class="form-modal" id="modalAgregar" method="POST"
                                            action="/Sistema-del--CEM--JEHOVA-RAFA/Proveedores/editar/<?= $proveedor["rif"]; ?>">

                                            <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario']; ?>">

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
                                                    name="id_proveedor" value="<?php echo $proveedor['id_proveedor'] ?>"
                                                    placeholder="Id">
                                            </div>

                                            <div class="input-group flex-nowrap grpFormCorrect">
                                                <span class="input-modal mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        fill="currentColor" class="bi bi-person-fill azul" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                                    </svg>
                                                </span>
                                                <input class="form-control input-modal input-disabled" type="text" name="nombre"
                                                    value="<?php echo $proveedor['nombre'] ?>" placeholder="Nombre">
                                            </div>

                                            <div class="input-group flex-nowrap grpFormCorrect">
                                                <span class="input-modal mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        fill="currentColor" class="bi bi-credit-card-2-front-fill azul"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2.5 1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-2zm0 3a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z" />
                                                    </svg>
                                                </span>
                                                <input class="form-control input-modal input-disabled" type="text" name="rif"
                                                    value="<?php echo $proveedor['rif'] ?>" placeholder="Rif">
                                            </div>

                                            <div class="input-group flex-nowrap grpFormCorrect">
                                                <span class="input-modal mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        fill="currentColor" class="bi bi-telephone-fill azul" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                                                    </svg>
                                                </span>
                                                <input class="form-control input-modal input-disabled" type="text" name="telefono"
                                                    value="<?php echo $proveedor['telefono'] ?>" placeholder="Telefono">
                                            </div>



                                            <div class="input-group flex-nowrap grpFormCorrect">
                                                <span class="input-modal mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                                        class="bi bi-credit-card-2-front-fill azul" viewBox="0 0 16 16">
                                                        <path
                                                            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2.5 1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-2zm0 3a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z" />
                                                    </svg>
                                                </span>
                                                <input class="form-control input-modal input-disabled" type="text" name="email" placeholder="Email" value="<?php echo $proveedor['email'] ?>" required>
                                            </div>


                                            <div class="input-group flex-nowrap grpFormCorrect">
                                                <span class="input-modal mt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                                        class="bi bi-credit-card-2-front-fill azul" viewBox="0 0 16 16">
                                                        <path
                                                            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2.5 1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-2zm0 3a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z" />
                                                    </svg>
                                                </span>
                                                <input class="form-control input-modal input-disabled" type="text" name="direccion" placeholder="Direccion" value="<?php echo $proveedor['direccion'] ?>" required>
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








                            </td>








                            </td>
                        </tr>


                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>



</div>








<?php require_once 'modalProveedores.php'; ?>

<?php require_once './src/vistas/head/footer.php'; ?>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/validacionProveedores.js">
</script>