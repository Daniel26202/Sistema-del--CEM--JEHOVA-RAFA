<?php require_once './src/vistas/head/head.php'; ?>


<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">


    <h5 style="width: 95%; " class="m-auto mb-3">Insumos<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-capsule ms-2"
            viewBox="0 0 16 16">
            <path
                d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
        </svg></h5>

    <input type="hidden" name="urlBase" id="urlBase" value="<?= $urlBase ?>">
    <!-- input para obteber el id para la bitacora -->
    <input type="hidden" id="id_usuario_bitacora" value="<?= $_SESSION['id_usuario'] ?>">



    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto table-responsive" style="width: 95%; ">
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


            <div class="fondo-tabla m-auto " style="width:95%;">

                <div class=" caja-de-buscador-insumos">
                    <div class="mover-input-agregarcita caja-insumos mt-2">
                        <button class="btn children-caja-insumos btn-primary btn-agregar-doctores" data-bs-toggle="modal" data-bs-target="#exampleModalagregarInsumos" id="registrarInsumo">
                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-capsule me-1"
                                viewBox="0 0 16 16">
                                <path
                                    d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                            </svg>Registrar Insumos
                        </button>
                    </div>

                    <!-- Buscador de Insumos -->
                    <div class="mover-input-buscar d-flex mt-3 caja-insumos">
                        <a href="" class="btn d-none" title="Buscar" id="reiniciarBusquedaInsumo" uk-tooltip="Restablecer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                            </svg>
                        </a>
                        <div id="form-buscador-insumo" class="d-flex justify-content-end form-responsive children-caja-insumos" autocomplete="off">
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
                    <div id="div-tarjets" class="tar caja-tarjets-responsive-insumos ">

                    </div>
                </div>


                <!--MODAL REGISTRAR-->
                <!-- Modal Agregar Insumos -->
                <div class="modal fade" id="exampleModalagregarInsumos" tabindex="-1" aria-labelledby="exampleModalLabelInsumos" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content tamaño-modal">
                            <div class="modal-header">
                                <h5 class="modal-title fs-4 fw-bold" id="exampleModalLabelInsumos">Agregar Insumos</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form class="form-validable" id="modalAgregarInsumos" enctype="multipart/form-data">

                                <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario'] ?>">

                                <div class="modal-body">

                                    <!-- Imagen -->
                                    <label class="label-custom">Imagen</label>
                                    <div class="campo-custom">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-camera-fill azul" viewBox="0 0 16 16">
                                                    <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                                    <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs" type="file" name="imagen" id="imagen" placeholder="Seleccionar imagen">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none">La imagen debe ser .jpg, .png o .jpeg</p>
                                    </div>

                                    <!-- Contenedor para vista previa de imagen -->
                                    <div id="contenedor-img" class="mb-2"></div>

                                    <!-- Nombre -->
                                    <label class="label-custom">Nombre</label>
                                    <div class="campo-custom">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-capsule azul" viewBox="0 0 16 16">
                                                    <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs" name="nombre" type="text" placeholder="Nombre del insumo">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none">El nombre debe contener solo letras, iniciar con mayúscula y tener al menos 3 caracteres</p>
                                    </div>

                                    <!-- Proveedor -->
                                    <label class="label-custom">Proveedor</label>
                                    <div class="campo-custom">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-building azul" viewBox="0 0 16 16">
                                                    <path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1ZM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Z" />
                                                    <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V1Zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3V1Z" />
                                                </svg>
                                            </span>
                                            <select class="form-control txt-custom select-custom input-validar inputs" name="id_proveedor">
                                                <option class="option-select-background" selected value="">Seleccionar Proveedor</option>
                                                <?php foreach ($proveedores as $proveedor): ?>
                                                    <option class="option-select-background" value="<?= $proveedor['id_proveedor'] ?>">
                                                        <?= $proveedor['nombre'] ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none">Debe seleccionar un proveedor</p>
                                    </div>

                                    <!-- Descripción -->
                                    <label class="label-custom">Descripción</label>
                                    <div class="campo-custom">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-text-left azul" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs" name="descripcion" type="text" placeholder="Descripción del insumo">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none">Debe estar completa y detallada</p>
                                    </div>

                                    <!-- Marca -->
                                    <label class="label-custom">Marca</label>
                                    <div class="campo-custom">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-tag-fill azul" viewBox="0 0 16 16">
                                                    <path d="M2 1a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l4.586-4.586a1 1 0 0 0 0-1.414l-7-7A1 1 0 0 0 6.586 1H2zm4 3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs" name="marca" type="text" placeholder="Marca del insumo">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none">Debe estar completa y detallada</p>
                                    </div>

                                    <!-- Medida -->
                                    <label class="label-custom">Medida</label>
                                    <div class="campo-custom">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-rulers azul" viewBox="0 0 16 16">
                                                    <path d="M1 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h5v-1H2v-1h4v-1H4v-1h2v-1H2v-1h4V9H4V8h2V7H2V6h4V5H4V4h2V3H2V2h4V1H2V0h4zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V0zm1 0v1h4v1h-4v1h2v1h-2v1h4v1h-4v1h2v1h-2v1h4v1h-4v1h2v1h-2v1h4v1h-4V0h4z" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs" name="medida" type="text" placeholder="Medida del insumo">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none">Debe especificar la medida</p>
                                    </div>

                                    <!-- Número de Lote -->
                                    <label class="label-custom">Número de Lote</label>
                                    <div class="campo-custom">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-stack azul" viewBox="0 0 16 16">
                                                    <path d="m14.12 10.163 1.715.858c.22.11.22.424 0 .534L8.267 15.34a.598.598 0 0 1-.534 0L.165 11.555a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.66zM7.733.063a.598.598 0 0 1 .534 0l7.568 3.784a.3.3 0 0 1 0 .535L8.267 8.165a.598.598 0 0 1-.534 0L.165 4.382a.299.299 0 0 1 0-.535L7.733.063z" />
                                                    <path d="m14.12 6.576 1.715.858c.22.11.22.424 0 .534l-7.568 3.784a.598.598 0 0 1-.534 0L.165 7.968a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.659z" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs" name="lote" type="text" placeholder="Número de lote">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none">El número de lote debe tener entre 4 y 10 dígitos</p>
                                    </div>

                                    <!-- Cantidad -->
                                    <label class="label-custom">Cantidad</label>
                                    <div class="campo-custom">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-seam azul" viewBox="0 0 16 16">
                                                    <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs" name="cantidad" type="number" placeholder="Cantidad">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none">La cantidad debe ser entre 1 y 9999</p>
                                    </div>

                                    <!-- Precio en BS -->
                                    <label class="label-custom">Precio en BS</label>
                                    <div class="campo-custom">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cash-coin azul" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z" />
                                                    <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z" />
                                                    <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z" />
                                                    <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs precioBolivares" name="precio" type="text" placeholder="Precio en BS">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none">El precio debe tener formato válido (ej: 1.00, 10.00, 100.00)</p>
                                    </div>

                                    <!-- Precio en $ -->
                                    <label class="label-custom">Precio en $</label>
                                    <div class="campo-custom">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-currency-dollar azul" viewBox="0 0 16 16">
                                                    <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs precioDolares" name="precioD" type="text" placeholder="Precio en $">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none">El precio debe tener formato válido (ej: 1.00, 10.00, 100.00)</p>
                                    </div>

                                    <!-- Fecha de Ingreso (oculto) -->
                                    <input type="hidden" name="fecha_de_ingreso" value="<?= date('Y-m-d') ?>">

                                    <!-- Fecha de Vencimiento -->
                                    <label class="label-custom">Fecha de Vencimiento</label>
                                    <div class="campo-custom">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-x-fill azul" viewBox="0 0 16 16">
                                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-6.6 5.146a.5.5 0 1 0-.708.708L7.293 10l-1.147 1.146a.5.5 0 0 0 .708.708L8 10.707l1.146 1.147a.5.5 0 0 0 .708-.708L8.707 10l1.147-1.146a.5.5 0 0 0-.708-.708L8 9.293 6.854 8.146z" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs" type="date" name="fecha_de_vencimiento">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none">Debe seleccionar una fecha de vencimiento</p>
                                    </div>

                                    <!-- Stock Mínimo -->
                                    <label class="label-custom">Stock Mínimo</label>
                                    <div class="campo-custom">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-collection-fill azul" viewBox="0 0 16 16">
                                                    <path d="M0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6v7zM2 3a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 0-1h-11A.5.5 0 0 0 2 3zm2-2a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7A.5.5 0 0 0 4 1z" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs" name="stockMinimo" type="number" placeholder="Stock mínimo">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none">El stock mínimo debe ser al menos 1</p>
                                    </div>

                                    <!-- IVA Switch -->
                                    <div class="campo-custom">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input checkboxIva" type="checkbox" role="switch" id="flexSwitchCheckIVA" name="iva" value="0">
                                            <label class="form-check-label" for="flexSwitchCheckIVA">IVA</label>
                                        </div>
                                    </div>

                                    <!-- Alerta de validación -->
                                    <div class="alert alert-danger d-none" id="alerta-guardar">VERIFIQUE EL FORMULARIO ANTES DE ENVIARLO</div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-modals-cancelar me-2" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-modals" id="botonModalInsumos">Agregar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>




                <!-- Modal editar -->
                <div class="modal fade" id="exampleModalEditarInsumos" tabindex="-1" aria-labelledby="exampleModalLabelInsumos" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content tamaño-modal">
                            <div class="modal-header">
                                <h5 class="modal-title fs-4 fw-bold" id="exampleModalLabelInsumos">Editar Insumos</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form class="form-validable" id="modalEditarInsumos" method="POST">

                                <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario'] ?>">
                                <input type="hidden" class="value-img" name="value-img">

                                <div class="modal-body">

                                    <!-- Imagen Preview -->
                                    <div class="mb-3">
                                        <img src="" class="img-editar img-fluid rounded" style="height: 200px; width: 100%; object-fit: cover;">
                                    </div>

                                    <!-- Campo Imagen -->
                                    <label class="label-custom">Imagen</label>
                                    <div class="campo-custom">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-camera-fill azul" viewBox="0 0 16 16">
                                                    <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                                    <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs" type="file" name="imagen" placeholder="Seleccionar imagen">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none"></p>
                                    </div>

                                    <!-- Campo Código (oculto) -->
                                    <div class="d-none">
                                        <label class="label-custom">Código</label>
                                        <div class="campo-custom">
                                            <div class="input-custom">
                                                <span class="icono-izq">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-qr-code azul" viewBox="0 0 16 16">
                                                        <path d="M2 2h2v2H2V2Z" />
                                                        <path d="M6 0v6H0V0h6ZM5 1H1v4h4V1ZM4 12H2v2h2v-2Z" />
                                                        <path d="M6 10v6H0v-6h6Zm-5 1v4h4v-4H1Zm11-9h2v2h-2V2Z" />
                                                        <path d="M10 0v6h6V0h-6Zm5 1v4h-4V1h4ZM8 1V0h1v2H8v2H7V1h1Zm0 5V4h1v2H8ZM6 8V7h1V6h1v2h1V7h5v1h-4v1H7V8H6Zm0 0v1H2V8H1v1H0V7h3v1h3Zm10 1h-1V7h1v2Zm-1 0h-1v2h2v-1h-1V9Zm-4 0h2v1h-1v1h-1V9Zm2 3v-1h-1v1h-1v1H9v1h3v-2h1Zm0 0h3v1h-2v1h-1v-2Zm-4-1v1h1v-2H7v1h2Z" />
                                                        <path d="M7 12h1v3h4v1H7v-4Zm9 2v2h-3v-1h2v-1h1Z" />
                                                    </svg>
                                                </span>
                                                <input class="form-control txt-custom inputs" type="text" name="Codigo" placeholder="Código">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Campo Nombre -->
                                    <label class="label-custom">Nombre</label>
                                    <div class="campo-custom">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-capsule azul" viewBox="0 0 16 16">
                                                    <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs" type="text" name="nombre" placeholder="Nombre del insumo">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none"></p>
                                    </div>

                                    <!-- Campo Descripción -->
                                    <label class="label-custom">Descripción</label>
                                    <div class="campo-custom">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-text-left azul" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs" type="text" name="descripcion" placeholder="Descripción del insumo">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none"></p>
                                    </div>

                                    <!-- Campo Marca -->
                                    <label class="label-custom">Marca</label>
                                    <div class="campo-custom">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-tag-fill azul" viewBox="0 0 16 16">
                                                    <path d="M2 1a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l4.586-4.586a1 1 0 0 0 0-1.414l-7-7A1 1 0 0 0 6.586 1H2zm4 3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs" type="text" name="marca" placeholder="Marca del insumo">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none"></p>
                                    </div>

                                    <!-- Campo Medida -->
                                    <label class="label-custom">Medida</label>
                                    <div class="campo-custom">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-rulers azul" viewBox="0 0 16 16">
                                                    <path d="M1 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h5v-1H2v-1h4v-1H4v-1h2v-1H2v-1h4V9H4V8h2V7H2V6h4V5H4V4h2V3H2V2h4V1H2V0h5a1 1 0 0 0-1-1H1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V0zm1 1v1h2v1h-2v1h2v1h-2v1h2v1h-2v1h2v1h-2v1h2v1h-2v1h2v1h-2v1h4V1h-4z" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs" type="text" name="medida" placeholder="Medida del insumo">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none"></p>
                                    </div>

                                    <!-- Campo Stock Mínimo -->
                                    <label class="label-custom">Stock Mínimo</label>
                                    <div class="campo-custom">
                                        <div class="input-custom">
                                            <span class="icono-izq">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-collection-fill azul" viewBox="0 0 16 16">
                                                    <path d="M0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6v7zM2 3a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 0-1h-11A.5.5 0 0 0 2 3zm2-2a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7A.5.5 0 0 0 4 1z" />
                                                </svg>
                                            </span>
                                            <input class="form-control txt-custom input-validar inputs" type="number" name="stockMinimo" placeholder="Stock mínimo">
                                            <span class="icono-der">
                                                <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                </svg>
                                                <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="error-msg d-none"></p>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-modals-cancelar me-2" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-modals" id="botonModalEditar">Editar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<?php require_once 'modalInsumos.php'; ?>


<script type="module" src="<?= $urlBase ?>../src/assets/insumo.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/ayudaInsumos.js"></script>
<?php require_once './src/vistas/head/footer.php'; ?>