<?php require_once './src/vistas/head/head.php';  ?>

<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">
    <h5 style="width: 95%; " class="m-auto mb-3">Entradas <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-inboxes mb-2" viewBox="0 0 16 16">
            <path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562A.5.5 0 0 0 1.884 9h12.234a.5.5 0 0 0 .496-.438L14.933 6zM3.809.563A1.5 1.5 0 0 1 4.981 0h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393zm.941.83.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438l.32-2.562H10.45a2.5 2.5 0 0 1-4.9 0H1.066z" />
        </svg></h5>

    <input type="hidden" name="id_usuario" id="id_usuario_session" value="<?= $_SESSION['id_usuario'] ?>">

    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto table-responsive" style="width: 95%; ">

        <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">

            <?php require_once "./src/vistas/vistaInsumos/paginationInsumos.php" ?>


            <div style="width: 95%;">
                <div class=" me-3 d-flex justify-content-end w-100">


                    <ul class="sin-circulos d-flex justify-content-end">



                        <li class="li">
                            <div class="borde-de-menu mb-1 color-linea "></div>
                            <div class="hover-grande">
                                <a href="/Sistema-del--CEM--JEHOVA-RAFA/Entrada/papelera" class="text-decoration-none me-3 color-letras iconoDoctor" id="DMdoctores">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-recycle me-1 mb-1" viewBox="0 0 16 16">
                                        <path d="M9.302 1.256a1.5 1.5 0 0 0-2.604 0l-1.704 2.98a.5.5 0 0 0 .869.497l1.703-2.981a.5.5 0 0 1 .868 0l2.54 4.444-1.256-.337a.5.5 0 1 0-.26.966l2.415.647a.5.5 0 0 0 .613-.353l.647-2.415a.5.5 0 1 0-.966-.259l-.333 1.242-2.532-4.431zM2.973 7.773l-1.255.337a.5.5 0 1 1-.26-.966l2.416-.647a.5.5 0 0 1 .612.353l.647 2.415a.5.5 0 0 1-.966.259l-.333-1.242-2.545 4.454a.5.5 0 0 0 .434.748H5a.5.5 0 0 1 0 1H1.723A1.5 1.5 0 0 1 .421 12.24l2.552-4.467zm10.89 1.463a.5.5 0 1 0-.868.496l1.716 3.004a.5.5 0 0 1-.434.748h-5.57l.647-.646a.5.5 0 1 0-.708-.707l-1.5 1.5a.498.498 0 0 0 0 .707l1.5 1.5a.5.5 0 1 0 .708-.707l-.647-.647h5.57a1.5 1.5 0 0 0 1.302-2.244l-1.716-3.004z" />
                                    </svg>Papelera De Entrada</a>
                            </div>

                        </li>


                    </ul>

                </div>
            </div>



            <div class="mb-2 mb-md-0 caja-btn-margin w-25">
                <button class="btnOpenModal caja-btn-margin btn btn-modals" style="width: 100% !important" data-bs-toggle="modal" data-bs-target="#exampleModalagregarEntrada" id="btnOpenModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-bandaid-fill me-1" viewBox="0 0 16 16">
                        <path d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z"></path>
                    </svg>Agregar Entrada
                </button>
            </div>

        </div>


        <div class="table table-responsive">
            <table class="exampleTable table table-striped">
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

                </tbody>
            </table>
        </div>

    </div>



</div>







<?php require_once 'modalEntrada.php';  ?>

<?php require_once './src/vistas/head/footer.php';  ?>


<script type="module" src="<?= $urlBase; ?>../src/assets/js/ajax/entradas.js"></script>
<script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/ayudaEntradas.js"></script>