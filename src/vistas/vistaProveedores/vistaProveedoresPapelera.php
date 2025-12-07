<?php require_once './src/vistas/head/head.php'; ?>



<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">


    <h5 style="width: 95%; " class="m-auto mb-3">Proveedores Papelera <img src="<?= $urlBase ?>../src/assets/img/proveedor (1).png" width="22" height="22" uk-svg class="mb-2"></h5>

    <input type="hidden" name="id_usuario" id="id_usuario_session" value="<?= $_SESSION['id_usuario'] ?>">

    <input type="hidden" name="urlBase" id="urlBase" value="<?= $urlBase ?>">

    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto table-responsive" style="width: 95%; ">
        <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">

            <?php require_once "./src/vistas/vistaInsumos/paginationInsumos.php" ?>


        </div>



        <div class="table table-responsive">

            <table class="exampleTable table table-striped">
                <thead>
                    <tr>
                        <th class="text-dark text-center">Nombre</th>
                        <th class="text-dark text-center">Rif</th>
                        <th class="text-dark text-center">Teléfono</th>
                        <th class="text-dark text-center">Correo</th>
                        <th class="text-dark text-center">Dirección</th>
                        <th class="text-dark text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>



</div>










<?php require_once './src/vistas/head/footer.php'; ?>

<script type="module" src="<?= $urlBase; ?>../src/assets/ajax/proveedor.js"></script>