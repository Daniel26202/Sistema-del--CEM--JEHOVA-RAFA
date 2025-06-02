<?php require_once './src/vistas/head/head.php'; ?>
<style>
    .h5-comprobante {
        font-size: 17px;
    }
</style>
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">
    <h5 style="width: 95%; " class="m-auto mb-3">Facturación

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
                            <div class="uk-width-auto">
                                <img class="uk-border-circle" width="40" height="40" src="<?= $urlBase ?>../src/assets/img/logotipo.jpg"
                                    alt="Avatar">
                            </div>
                            <div class="uk-width-expand">
                                <h3>Factura J-R</h3>
                            </div>
                        </div>
                    </div>
                    <div class="uk-card-body d-flex">
                        <div style="width:45%;">
                            <?php foreach ($datosFactura as $datoFactura): ?>
                                <h5 class="h5-comprobante ">Codigo:
                                    <?php echo $datoFactura['id_factura'] ?>
                                </h5><br>
                                <h5 class="h5-comprobante ">Fecha:
                                    <?php echo $datoFactura['fecha'] ?>
                                </h5><br>
                                <h5 class="h5-comprobante ">Total:
                                    <?php echo $datoFactura['total'] . " BS" ?>
                                </h5><br>
                                <h5 class="h5-comprobante ">Paciente:
                                    <?php echo $datoFactura['nombre_p'] . "  " . $datoFactura['apellido_p'] ?>
                                </h5><br>
                                <h5 class="h5-comprobante ">Cedula Paciente:
                                    <?php echo $datoFactura['nacionalidad'] . "-" . $datoFactura['cedula_p'] ?>
                                </h5>

                            <?php endforeach ?>
                        </div>
                        <div style="width:55%;">
                            <h5 class="text-center">Métodos de pago</h5>
                            <?php foreach ($datosPago as $datoPago): ?>
                                <h5 class="text-center h5-comprobante">
                                    <?php echo $datoPago["nombre"] ?>
                                    <?php echo $datoPago["monto"] . " BS" ?>
                                </h5>
                            <?php endforeach ?>
                            <br>
                            <h5 class="text-center">Servicios</h5>


                            <?php foreach ($datosServiciosExtras as $d): ?>
                                <div class="d-flex">
                                    <div class="w-50">
                                        <h5 class="text-center h5-comprobante">
                                            <?php echo $d["categoria_servicio"] ?>
                                        </h5>
                                    </div>

                                    <div class="w-50">
                                        <h5 class="text-center h5-comprobante">
                                            Doctor:
                                            <?php echo $d["nombre_d"] ?>
                                            <?php echo $d["apellido_d"] ?>
                                            <?php echo $d["precio"] . " BS" ?>
                                        </h5>
                                    </div>

                                </div>

                            <?php endforeach ?>
                            <br>

                            <h5 class="text-center">Insumos</h5>
                            <div class="d-flex">
                                <div class="w-50">
                                    <h5 class="text-center ">
                                        Insumo:
                                    </h5>
                                </div>
                                <div class="w-50">
                                    <h5 class="text-center ">
                                        Cantidad:
                                    </h5>
                                </div>

                                <div class="w-50">
                                    <h5 class="text-center ">
                                        Precio:
                                    </h5>
                                </div>

                            </div>
                            <?php foreach ($datosInsumos as $d): ?>
                                <div class="d-flex">
                                    <div class="w-50">
                                        <h5 class="text-center h5-comprobante">
                                            <?php echo $d["nombre"] ?>
                                        </h5>
                                    </div>
                                    <div class="w-50">
                                        <h5 class="text-center h5-comprobante">
                                            <?php echo $d["cantidad"] ?>
                                        </h5>
                                    </div>

                                    <div class="w-50">
                                        <h5 class="text-center h5-comprobante">
                                            <?php echo $d["precio"] . " BS" ?>
                                        </h5>
                                    </div>

                                </div>

                            <?php endforeach ?>
                        </div>
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