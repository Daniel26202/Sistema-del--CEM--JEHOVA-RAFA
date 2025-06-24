<?php require_once './src/vistas/head/head.php';  ?>

<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">
    <h5 style="width: 95%; " class="m-auto mb-3">Vencidos <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-inboxes mb-2" viewBox="0 0 16 16">
            <path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562A.5.5 0 0 0 1.884 9h12.234a.5.5 0 0 0 .496-.438L14.933 6zM3.809.563A1.5 1.5 0 0 1 4.981 0h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393zm.941.83.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438l.32-2.562H10.45a2.5 2.5 0 0 1-4.9 0H1.066z" />
        </svg></h5>

    <!-- alertas -->

    <?php require_once "./src/vistas/alerts.php" ?>

    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto table-responsive" style="width: 95%; ">

        <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">

            <?php require_once "./src/vistas/vistaInsumos/paginationInsumos.php" ?>




        </div>


        <div class="table table-responsive">
            <table class="example table table-striped">
                <thead>
                    <tr>
                        <th class="text-dark">Nombre</th>
                        <th class="text-dark">Proveedor</th>
                        <th class="text-dark">Fecha De Ingreso</th>
                        <th class="text-dark">Fecha De Vencimiento</th>
                        <th class="text-dark">Cantidad</th>
                        <th class="text-dark">Precio</th>
                        <th class="text-dark">Numero De Lote</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($vencidos as $entrada): ?>
                        <tr>
                            <td class="text-center"><?= $entrada['nombre'] ?> </td>
                            <td class="text-center"><?= $entrada['proveedor'] ?></td>
                            <td class="text-center"><?= $entrada['fechaDeIngreso'] ?></td>
                            <td class="text-center"><?= $entrada['fechaDeVencimiento'] ?></td>
                            <td class="text-center"><?= $entrada['cantidad_entrada'] ?></td>
                            <td class="text-center"><?= $entrada['precio_entrada'] ?> BS</td>
                            <td class="text-center"><?= $entrada['numero_de_lote'] ?></td>




                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

    </div>



</div>




<?php require_once './src/vistas/head/footer.php';  ?>
<script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/ayudaInsumosVencidos.js"></script>