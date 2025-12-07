<?php require_once './src/vistas/head/head.php'; ?>
<style>
    .h5-comprobante {
        font-size: 17px;
    }
</style>
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">
    <h5 style="width: 95%; " class="m-auto mb-3">Comprobante

        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
            class="bi bi-file-earmark-text ms-2 ico" viewBox="0 0 16 16">
            <path
                d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z" />
            <path
                d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
        </svg>
    </h5>




    <!-- paginacion de la tabla -->
    <div class="me-4">
        <div class="mt-3 mb-5">







            <div class="pb-3">
                <div class="uk-card uk-card-default uk-width-1-2@m m-auto" style="background-color: var(--color-surface);">
                    <div class="uk-card-header">
                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                            <div class=" m-auto d-flex justify-content-center" style="width: 40%;">
                                <img src="<?= $urlBase ?>../src/assets/icons/logo2.png">
                            </div>

                        </div>
                    </div>


                    <div class="uk-card-body">
                        <div class="">
                            <?php foreach ($datosFactura as $datoFactura): ?>
                                <div class="div-total p-2 mb-2">
                                    <h5 class="text-center"> <?php echo $datoFactura['total'] . " BS" ?></h5>
                                </div>

                                <div class="d-flex justify-content-between  ">
                                    <h5 class="h5-comprobante ">Código:</h5>
                                    <h5 class="h5-comprobante ">
                                        <?php echo $datoFactura['id_factura'] ?>
                                    </h5>

                                </div>

                                <div class="d-flex justify-content-between  ">
                                    <h5 class="h5-comprobante ">Fecha:</h5>
                                    <h5 class="h5-comprobante ">
                                        <?php echo $datoFactura['fecha'] ?>
                                    </h5>

                                </div>
                                <div class="d-flex justify-content-between  ">
                                    <h5 class="h5-comprobante ">Cédula Cliente:</h5>
                                    <h5 class="h5-comprobante ">
                                        <?php echo $datoFactura['nacionalidad'] . "-" . $datoFactura['cedula_p'] ?>
                                    </h5>

                                </div>
                                <div class="d-flex justify-content-between  ">
                                    <h5 class="h5-comprobante ">Cliente:</h5>
                                    <h5 class="h5-comprobante ">
                                        <?php echo $datoFactura['nombre_p'] . " " . $datoFactura['apellido_p'] ?>
                                    </h5>

                                </div>

                            <?php endforeach ?>
                        </div>
                        <hr>

                        <h5 class="text-center">Servicios</h5>


                        <?php foreach ($datosServiciosExtras as $d): ?>
                            <div class="d-flex justify-content-between  ">
                                <h5 class="h5-comprobante "><?php echo $d["categoria_servicio"] ?></h5>
                                <h5 class="h5-comprobante ">
                                    DR: <?php echo $d["nombre_d"] ?>
                                    <?php echo $d["apellido_d"] ?>
                                    <?php echo $d["precio"] . " BS" ?>
                                </h5>

                            </div>
                        <?php endforeach ?>


                        <hr>
                        <h5 class="text-center">Insumos</h5>
                        <?php foreach ($datosInsumos as $d): ?>
                            <div class="d-flex justify-content-between  ">
                                <h5 class="h5-comprobante ">Insumo</h5>
                                <h5 class="h5-comprobante ">
                                    <?php echo $d["nombre"] ?>
                                </h5>
                            </div>
                            <div class="d-flex justify-content-between  ">
                                <h5 class="h5-comprobante ">Cantidad</h5>
                                <h5 class="h5-comprobante ">
                                    <?php echo $d["cantidad"] ?>
                                </h5>
                            </div>
                            <div class="d-flex justify-content-between  ">
                                <h5 class="h5-comprobante ">Precio</h5>
                                <h5 class="h5-comprobante ">
                                    <?php echo ($d["iva"]) ? $d["precio"] - ($d["precio"] * 0.30) . " BS"  : $d["precio"] . " BS" ?>
                                </h5>
                            </div>
                            <div class="d-flex justify-content-between  ">
                                <h5 class="h5-comprobante ">IVA</h5>
                                <h5 class="h5-comprobante ">
                                    <?php echo ($d["iva"]) ? $d["precio"] * 0.30 . " BS"  : "0" . " BS" ?>
                                </h5>
                            </div>
                            <hr>

                        <?php endforeach ?>
                        <hr>

                        <h5 class="text-center">Métodos de pago</h5>
                        <?php foreach ($datosPago as $datoPago): ?>
                            <div class="d-flex justify-content-between  ">
                                <h5 class="h5-comprobante "><?php echo $datoPago["nombre"] ?></h5>
                                <h5 class="h5-comprobante ">
                                    <?php echo $datoPago["monto"] . " BS" ?>
                                </h5>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <?php $id_factura = $parametro[0]; ?>
                    <hr>
                    <div class="d-flex justify-content-end">
                        <div class="uk-card-footer">
                            <a href="/Sistema-del--CEM--JEHOVA-RAFA/Factura/mostrarPDF/<?php echo $id_factura; ?>"
                                class="btn btn-tabla">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
                                    class="bi bi-printer-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
                                    <path
                                        d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>







        </div>
    </div>

</div>





<?php require_once './src/vistas/head/footer.php'; ?>