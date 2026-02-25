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

                <div class=" d-flex justify-content-between ">
                    <div class=" caja-insumos mt-3">
                        <button class=" caja-btn-margin btn btn-modals" data-bs-toggle="modal" data-bs-target="#exampleModalagregarInsumos" id="registrarInsumo">
                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-capsule me-1"
                                viewBox="0 0 16 16">
                                <path
                                    d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                            </svg>Registrar Insumos
                        </button>
                    </div>

                    <!-- Buscador de Insumos -->
                    <div class=" d-flex mt-3 caja-insumos">
                        <a href="" class="btn d-none" title="Buscar" id="reiniciarBusquedaInsumo" uk-tooltip="Restablecer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                            </svg>
                        </a>
                        <div id="form-buscador-insumo" class="d-flex justify-content-end form-responsive children-caja-insumos" autocomplete="off">
                            <input class="form-control input-buscar tamaño-input-buscar input-responsive" id="searchInput" type="text" name="nombre"
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



                <div id="cardContainer" class="tarjects-style  caja-tarjets-responsive-insumos mt-3 "></div>


                <div id="pagination" class="pagination-div"></div>





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


<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/generic/Paginator.js"></script>
<script type="module" src="<?= $urlBase ?>../src/assets/js/insumo.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/ayudaInsumos.js"></script>
<?php require_once './src/vistas/head/footer.php'; ?>