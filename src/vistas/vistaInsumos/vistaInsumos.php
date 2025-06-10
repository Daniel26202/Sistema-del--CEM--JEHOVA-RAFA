<?php require_once './src/vistas/head/head.php'; ?>


<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">


    <h5 style="width: 95%; " class="m-auto mb-3">Insumos<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-capsule ms-2"
            viewBox="0 0 16 16">
            <path
                d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
        </svg></h5>

    <!-- alertas -->

    <?php require_once "./src/vistas/alerts.php" ?>

    <!-- input para obteber el id para la bitacora -->
    <input type="hidden" id="id_usuario_bitacora" value="<?= $_SESSION['id_usuario'] ?>">


    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto" style="width: 95%; ">
        <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">

            <?php require_once "./src/vistas/vistaInsumos/paginationInsumos.php" ?>

            <div style="width: 95%;">
                <div class=" me-3 mb-4  d-flex justify-content-end w-100">


                    <ul class="sin-circulos d-flex justify-content-end">



                        <li class="li">
                            <div class="borde-de-menu mb-1 color-linea "></div>
                            <div class="hover-grande">
                                <a href="/Sistema-del--CEM--JEHOVA-RAFA/Insumos/papelera" class="text-decoration-none  me-3 iconoDoctor" id="DMdoctores">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-recycle me-1 mb-1 " viewBox="0 0 16 16">
                                        <path d="M9.302 1.256a1.5 1.5 0 0 0-2.604 0l-1.704 2.98a.5.5 0 0 0 .869.497l1.703-2.981a.5.5 0 0 1 .868 0l2.54 4.444-1.256-.337a.5.5 0 1 0-.26.966l2.415.647a.5.5 0 0 0 .613-.353l.647-2.415a.5.5 0 1 0-.966-.259l-.333 1.242-2.532-4.431zM2.973 7.773l-1.255.337a.5.5 0 1 1-.26-.966l2.416-.647a.5.5 0 0 1 .612.353l.647 2.415a.5.5 0 0 1-.966.259l-.333-1.242-2.545 4.454a.5.5 0 0 0 .434.748H5a.5.5 0 0 1 0 1H1.723A1.5 1.5 0 0 1 .421 12.24l2.552-4.467zm10.89 1.463a.5.5 0 1 0-.868.496l1.716 3.004a.5.5 0 0 1-.434.748h-5.57l.647-.646a.5.5 0 1 0-.708-.707l-1.5 1.5a.498.498 0 0 0 0 .707l1.5 1.5a.5.5 0 1 0 .708-.707l-.647-.647h5.57a1.5 1.5 0 0 0 1.302-2.244l-1.716-3.004z" />
                                    </svg>Papelera de Insumos</a>
                            </div>

                        </li>




                    </ul>

                </div>
            </div>



            <!-- input para optener la fecha local -->
            <input type="hidden" id="fechaLocal" value="<?= date("Y-m-d"); ?>">


            <div class="fondo-tabla m-auto" style="width:95%;">

                <div class="d-flex justify-content-between  caja-de-buscador-insumos">
                    <?php if ($this->permisos($_SESSION["id_rol"], "guardar", "Insumos")): ?>
                        <div class="mover-input-agregarcita mt-2">
                            <button class="btn btn-primary btn-agregar-doctores col-11" uk-toggle="target: #modal-exampleInsumos">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-capsule me-1"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                                </svg>Registrar Insumos
                            </button>
                        </div>
                    <?php endif; ?>

                    <!-- Buscador de Insumos -->
                    <div class="mover-input-buscar d-flex mt-3">
                        <a href="?c=controladorInsumos/insumos" class="btn d-none" title="Buscar" id="reiniciarBusquedaInsumo" uk-tooltip="Restablecer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                            </svg>
                        </a>
                        <div id="form-buscador-insumo" class="d-flex justify-content-end form-responsive" autocomplete="off">
                            <input class="form-control input-buscar tamaño-input-buscar input-responsive" type="text" name="nombre"
                                placeholder="Codigo o Nombre">

                            <button class="btn btn-buscar boton-responsive" title="Buscar" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-search" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>




                <!--TARJETAS DE INSUMOS-->

                <div id="tarjetas" class="">
                    <hr>
                    <div class="tar ">
                        <?php foreach ($insumos as $i): ?>
                            <div class="contenido card ms-3 tarjet mt-2 tarjetas_iniciales " style="width: 15rem;">
                                <img src="<?= $urlBase ?>../src/assets/img_ingresadas_por_usuarios/insumos/<?= $i["imagen"] ?>" class="card-img-top" style="height: 35%;">
                                <div class="card-body mt-4 tarjeta-ajax">
                                    <!-- <div class="alert  text-center alertas-vencidos d-none p-0">  -->
                                    <!-- aqui es la alerta de los vencidos -->
                                    <!-- </div> -->

                                    <div class="w-100 ">
                                        <div class="fw-bolder alertas-vencidos d-none" uk-alert>
                                            <a class="uk-alert-close" uk-close></a>
                                            <p class="pe-2"></p>
                                        </div>
                                    </div>


                                    <h5 class="card-title titulo"><?= $i["nombre"] ?></h5>
                                    <p class="mt-3">Medida: <?= $i["medida"] ?></p>
                                    <p class="mt-3">Skock-Min: <?= $i["stockMinimo"] ?></p>
                                    <?php if ($i["cantidad_disponible"] <= 0): ?>
                                        <p class="text-danger">Cantidad: <?= $i["cantidad"] ?></p>
                                    <?php else: ?>
                                        <p>Cantidad: <?= $i["cantidad_inventario"] ?></p>
                                    <?php endif ?>

                                    <a href="#" class="btn btn-agregarcita-modal text-decoration-none botones-mostrar" data-index="<?= $i["id_insumo"] ?>"
                                        uk-toggle="target: #modal-exampleMostrar">Mostrar</a>
                                </div>
                            </div>
                        <?php endforeach; ?>


                    </div>
                </div>


                <!--MODAL REGISTRAR-->
                <div id="modal-exampleInsumos" uk-modal>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-capsule azul me-2 mb-3"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                                </svg>
                            </div>
                            <div class="">
                                <p class="uk-modal-title fs-5">
                                    Agregar Insumos
                                </p>
                            </div>

                        </div>

                        <form class="form-modal form-convercion" method="POST" action="/Sistema-del--CEM--JEHOVA-RAFA/Insumos/guardarInsumo" enctype="multipart/form-data" id="modalAgregarInsumos">

                            <div class="alert alert-danger d-none" id="alerta-guardar">VERIFIQUE EL FORMULARIO ANTES DE ENVIARLO</div>
                            <div id="contenedor-img" class="mb-2">

                            </div>

                            <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario'] ?>">

                            <div class="input-group flex-nowrap">
                                <span class="input-modal mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                        class="bi bi-camera-fill azul" viewBox="0 0 16 16">
                                        <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                        <path
                                            d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z" />
                                    </svg>
                                </span>
                                <input class="form-control input-modal input-disabled " type="file" name="imagen" id="imagen"
                                    placeholder="Imagen" required>
                            </div>

                            <p class="p-error-imagen d-none">La imagen debe ser .jpg o .png o jpeg</p>

                            <div class="input-group flex-nowrap">
                                <span class="input-modal mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-capsule azul"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                                    </svg>
                                </span>
                                <input class="form-control input-modal input-disabled" type="text" name="nombre"
                                    placeholder="Nombre" required>
                            </div>

                            <p class="p-error-nombre d-none">El Nombre debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres</p>

                            <div class="input-group flex-nowrap">
                                <span class="input-modal mt-1">
                                    <img src="./src/assets/img/proveedor(2).png" width="20" height="20" uk-svg class="me-1">
                                </span>

                                <select class="form-control input-modal" name="id_proveedor" required>
                                    <!-- <option disabled selected>Selecciona el Proveedor</option> -->
                                    <?php foreach ($proveedores as $proveedor): ?>
                                        <option value="<?= $proveedor['id_proveedor'] ?>">
                                            <?= $proveedor['nombre'] ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="input-group flex-nowrap">
                                <span class="input-modal mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-text-left azul" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                                    </svg>
                                </span>
                                <input class="form-control input-modal input-disabled" type="text" name="descripcion"
                                    placeholder="Descripcion" required>
                            </div>

                            <p class="p-error-descripcion d-none">Debe estar completa y detallada</p>

                            <div class="input-group flex-nowrap">
                                <span class="input-modal mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-text-left azul" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                                    </svg>
                                </span>
                                <input class="form-control input-modal input-disabled" type="text" name="marca"
                                    placeholder="Marca" required>
                            </div>

                            <p class="p-error-marca d-none">Debe estar completa y detallada</p>

                            <div class="input-group flex-nowrap">
                                <span class="input-modal mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-text-left azul" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                                    </svg>
                                </span>
                                <input class="form-control input-modal input-disabled" type="text" name="medida"
                                    placeholder="Medida" required>
                            </div>

                            <p class="p-error-medida d-none">debe ser tal</p>



                            <div class="input-group flex-nowrap">
                                <span class="input-modal mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-stack azul" viewBox="0 0 16 16">
                                        <path d="m14.12 10.163 1.715.858c.22.11.22.424 0 .534L8.267 15.34a.598.598 0 0 1-.534 0L.165 11.555a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.66zM7.733.063a.598.598 0 0 1 .534 0l7.568 3.784a.3.3 0 0 1 0 .535L8.267 8.165a.598.598 0 0 1-.534 0L.165 4.382a.299.299 0 0 1 0-.535L7.733.063z" />
                                        <path d="m14.12 6.576 1.715.858c.22.11.22.424 0 .534l-7.568 3.784a.598.598 0 0 1-.534 0L.165 7.968a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.659z" />
                                    </svg>
                                </span>
                                <input class="form-control input-modal input-disabled" type="text" name="lote"
                                    placeholder="Numero De Lote" required>
                            </div>

                            <p class="p-error-lote d-none">El numero de lote debe ser de almeno 4 digitos y como maximo 10</p>

                            <div class="input-group flex-nowrap">
                                <span class="input-modal mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-stack azul" viewBox="0 0 16 16">
                                        <path d="m14.12 10.163 1.715.858c.22.11.22.424 0 .534L8.267 15.34a.598.598 0 0 1-.534 0L.165 11.555a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.66zM7.733.063a.598.598 0 0 1 .534 0l7.568 3.784a.3.3 0 0 1 0 .535L8.267 8.165a.598.598 0 0 1-.534 0L.165 4.382a.299.299 0 0 1 0-.535L7.733.063z" />
                                        <path d="m14.12 6.576 1.715.858c.22.11.22.424 0 .534l-7.568 3.784a.598.598 0 0 1-.534 0L.165 7.968a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.659z" />
                                    </svg>
                                </span>
                                <input class="form-control input-modal input-disabled" type="text" name="cantidad"
                                    placeholder="Cantidad" required>
                            </div>

                            <p class="p-error-cantidad d-none">La cantidad solo puede contener numeros como minimo 1 maximo 4</p>

                            <div class="input-group flex-nowrap">
                                <span class="input-modal mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cash-coin azul" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z" />
                                        <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z" />
                                        <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z" />
                                        <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z" />
                                    </svg>
                                </span>
                                <input class="form-control input-modal input-disabled precioBolivares" type="text" name="precio"
                                    placeholder="Precio en BS" required>
                            </div>

                            <p class="p-error-precio d-none">El precio debe tener solo digitos con 2 decimales ejemplo 1.00 o 10.00 o 100.00</p>

                            <div class="input-group flex-nowrap">
                                <span class="input-modal mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cash-coin azul" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z" />
                                        <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z" />
                                        <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z" />
                                        <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z" />
                                    </svg>
                                </span>
                                <input class="form-control input-modal input-disabled precioDolares" type="text" name="precioD"
                                    placeholder="Precio en $" required>
                            </div>

                            <p class="p-error-precioD d-none">El precio debe tener solo digitos con 2 decimales ejemplo 1.00 o 10.00 o 100.00</p>


                            <div class="input-group flex-nowrap d-none">
                                <span class="input-modal mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-calendar2-x-fill azul" viewBox="0 0 16 16">
                                        <path
                                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-6.6 5.146a.5.5 0 1 0-.708.708L7.293 10l-1.147 1.146a.5.5 0 0 0 .708.708L8 10.707l1.146 1.147a.5.5 0 0 0 .708-.708L8.707 10l1.147-1.146a.5.5 0 0 0-.708-.708L8 9.293 6.854 8.146z" />
                                    </svg>
                                </span>
                                <input class="form-control input-modal input-disabled input" type="date"
                                    name="fecha_de_ingreso" title="Fecha de Ingreso" value="<?= date('Y-m-d') ?>">
                            </div>


                            <div class="input-group flex-nowrap">
                                <span class="input-modal mt-1 d-flex col-6" style="border-right: 2px solid #387ADF;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-calendar2-x-fill azul" viewBox="0 0 16 16">
                                        <path
                                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-6.6 5.146a.5.5 0 1 0-.708.708L7.293 10l-1.147 1.146a.5.5 0 0 0 .708.708L8 10.707l1.146 1.147a.5.5 0 0 0 .708-.708L8.707 10l1.147-1.146a.5.5 0 0 0-.708-.708L8 9.293 6.854 8.146z" />
                                    </svg>
                                    <div class="pe-2 ps-1 text-center m-auto" style="font-size: 14px;">Fecha de Vencimiento</div>
                                </span>
                                <input class="form-control input-modal input-disabled input" type="date"
                                    name="fecha_de_vencimiento" title="Fecha de Vencimiento" required>
                            </div>

                            <p class="p-error-fecha_de_vencimiento d-none">Vencimiento</p>

                            <div class="input-group flex-nowrap">
                                <span class="input-modal mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-collection-fill azul" viewBox="0 0 16 16">
                                        <path d="M0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6v7zM2 3a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 0-1h-11A.5.5 0 0 0 2 3zm2-2a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7A.5.5 0 0 0 4 1z" />
                                    </svg>
                                </span>
                                <input class="form-control input-modal input-disabled" type="text" name="stockMinimo"
                                    placeholder="Stock Minimo" required>
                            </div>

                            <p class="p-error-stockMinimo d-none">El stock minimo solo puede contener digitos como minimo 1</p>


                            <div class="mt-3 uk-text-right">
                                <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                                    type="button">Cancelar</button>
                                <button class="btn col-3 btn-agregarcita-modal" type="submit">Agregar</button>
                            </div>
                        </form>
                    </div>
                </div>




                <!-- Modal editar -->
                <div id="modal-exampleEditarInsumos" uk-modal>
                    <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                        <!-- Boton que cierra el modal -->
                        <a href="#" uk-toggle="target: #modal-exampleMostrar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path
                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                            </svg>
                        </a>

                        <div class="d-flex align-items-center">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-capsule azul me-2 mb-3"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                                </svg>
                            </div>
                            <div class="">
                                <p class="uk-modal-title fs-5">
                                    Editar Insumos
                                </p>
                            </div>

                        </div>

                        <form class="form-modal" method="POST" action="/Sistema-del--CEM--JEHOVA-RAFA/Insumos/editar" enctype="multipart/form-data" id="modalEditarInsumos">

                            <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario'] ?>">

                            <div class="alert alert-danger d-none" id="alerta-editar">VERIFIQUE EL FORMULARIO ANTES DE ENVIARLO</div>


                            <img src="" class="img-editar input-disabled input-modal" style="height: 200px;width: 100%;">
                            <input type="hidden" class="value-img" name="value-img">

                            <div class="input-group flex-nowrap grpFormCorrect">
                                <span class="input-modal mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                        class="bi bi-camera-fill azul" viewBox="0 0 16 16">
                                        <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                        <path
                                            d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z" />
                                    </svg>
                                </span>
                                <input class="form-control input-modal input-disabled input-editar-imagen" type="file" name="imagen"
                                    placeholder="Imagen">
                            </div>



                            <div class="input-group flex-nowrap d-none">
                                <span class="input-modal mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-qr-code azul" viewBox="0 0 16 16">
                                        <path d="M2 2h2v2H2V2Z" />
                                        <path d="M6 0v6H0V0h6ZM5 1H1v4h4V1ZM4 12H2v2h2v-2Z" />
                                        <path d="M6 10v6H0v-6h6Zm-5 1v4h4v-4H1Zm11-9h2v2h-2V2Z" />
                                        <path
                                            d="M10 0v6h6V0h-6Zm5 1v4h-4V1h4ZM8 1V0h1v2H8v2H7V1h1Zm0 5V4h1v2H8ZM6 8V7h1V6h1v2h1V7h5v1h-4v1H7V8H6Zm0 0v1H2V8H1v1H0V7h3v1h3Zm10 1h-1V7h1v2Zm-1 0h-1v2h2v-1h-1V9Zm-4 0h2v1h-1v1h-1V9Zm2 3v-1h-1v1h-1v1H9v1h3v-2h1Zm0 0h3v1h-2v1h-1v-2Zm-4-1v1h1v-2H7v1h2Z" />
                                        <path d="M7 12h1v3h4v1H7v-4Zm9 2v2h-3v-1h2v-1h1Z" />
                                    </svg>
                                </span>
                                <input class="form-control input-modal input-disabled input-editar" type="text" name="Codigo"
                                    placeholder="Codigo">
                            </div>

                            <div class="input-group flex-nowrap grpFormCorrect">
                                <span class="input-modal mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-capsule azul"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                                    </svg>
                                </span>
                                <input class="form-control input-modal input-disabled input-editar" type="text" name="nombre"
                                    placeholder="Nombre">
                            </div>





                            <div class="input-group flex-nowrap grpFormCorrect">
                                <span class="input-modal mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-text-left azul" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                                    </svg>
                                </span>
                                <input class="form-control input-modal input-disabled input-editar" type="text" name="descripcion"
                                    placeholder="Descripción">
                            </div>

                            <div class="input-group flex-nowrap grpFormCorrect">
                                <span class="input-modal mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-text-left azul" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                                    </svg>
                                </span>
                                <input class="form-control input-modal input-disabled input-editar" type="text" name="marca"
                                    placeholder="Marca" required>
                            </div>

                            <p class="p-error-marca d-none">Debe estar completa y detallada</p>

                            <div class="input-group flex-nowrap grpFormCorrect">
                                <span class="input-modal mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-text-left azul" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                                    </svg>
                                </span>
                                <input class="form-control input-modal input-disabled input-editar" type="text" name="medida"
                                    placeholder="Medida" required>
                            </div>

                            <p class="p-error-medida d-none">debe ser tal</p>




                            <div class="input-group flex-nowrap grpFormCorrect">
                                <span class="input-modal mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-collection-fill azul" viewBox="0 0 16 16">
                                        <path d="M0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6v7zM2 3a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 0-1h-11A.5.5 0 0 0 2 3zm2-2a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7A.5.5 0 0 0 4 1z" />
                                    </svg>
                                </span>
                                <input class="form-control input-modal input-disabled input-editar " type="number"
                                    name="stockMinimo" placeholder="Stock Minimo">
                            </div>



                            <div class="mt-3 uk-text-right">
                                <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                                    type="button">Cancelar</button>
                                <button class="btn col-3 btn-agregarcita-modal" type="submit">Editar</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<?php require_once 'modalInsumos.php'; ?>


<script type="text/javascript" src="<?= $urlBase ?>../src/assets/insumo.js"></script>

<?php require_once './src/vistas/head/footer.php'; ?>