<?php require_once './src/vistas/head/head.php'; ?>
<style>
    .h5-comprobante {
        font-size: 17px;
    }

    .text-primary {
        color: var(--color-primary) !important;
    }

    .text-comprobante {
        color: var(--color-text-card) !important;
    }

    .bg-comprobante {
        background-color: var(--color-surface)
    }
</style>
<div class="col-12 m-auto pt-3 contenedor-fondo  mb-3">
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
    <div class="container-fluid me-4">
        <div class="mt-3 mb-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8">

                    <div class="card shadow-sm border-0 m-auto bg-comprobante" style="border-radius: 15px;">

                        <div class="card-header border-0 bg-transparent pt-4">
                            <div class="d-flex justify-content-center">
                                <img style="max-width: 250px; height: auto;" src="<?= $urlBase ?>../src/assets/images/icons/logo2.png" alt="Logo">
                            </div>
                        </div>

                        <div class="card-body px-4 px-md-5 bg-comprobante">

                            <?php foreach ($datosFactura as $datoFactura): ?>
                                <div class="div-total p-3 mb-4 text-center rounded shadow-sm" style="background-color: #3b82f6; color: white;">
                                    <h3 class="fw-bold mb-0"><?php echo $datoFactura['total'] . " BS" ?></h3>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-6 text-start text-comprobante"><span class="fw-bold ">Código:</span></div>
                                    <div class="col-6 text-end text-comprobante"><span><?php echo $datoFactura['id_factura'] ?></span></div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-6 text-start text-comprobante"><span class="fw-bold">Fecha:</span></div>
                                    <div class="col-6 text-end text-comprobante"><span><?php echo $datoFactura['fecha'] ?></span></div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-6 text-start text-comprobante"><span class="fw-bold ">Cédula Cliente:</span></div>
                                    <div class="col-6 text-end text-comprobante"><span><?php echo $datoFactura['nacionalidad'] . "-" . $datoFactura['cedula_p'] ?></span></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6 text-start text-comprobante"><span class="fw-bold ">Cliente:</span></div>
                                    <div class="col-6 text-end text-comprobante"><span><?php echo $datoFactura['nombre_p'] . " " . $datoFactura['apellido_p'] ?></span></div>
                                </div>
                            <?php endforeach ?>

                            <hr class="my-4 opacity-25">

                            <h6 class="text-center text-uppercase fw-bold mb-3 text-primary" style="letter-spacing: 1px;">Servicios</h6>

                            <?php if (!$vistaActiva): ?>
                                <?php foreach ($datosServiciosExtras as $d): ?>
                                    <div class=" p-2 rounded mb-3 border-start border-primary border-3 bg-comprobante">

                                        <div class="d-flex justify-content-between mb-2 bg-comprobante">
                                            <span class="fw-semibold text-comprobante"><?php echo $d["categoria_servicio"] ?></span>
                                            <span class=" text-comprobante">
                                                DR: <?php echo $d["nombre_d"] . " " . $d["apellido_d"] ?> | <?php echo $d["precio"] . " BS" ?>
                                            </span>
                                        </div>
                                    </div>

                                <?php endforeach ?>
                            <?php endif; ?>

                            <?php if ($vistaActiva): ?>
                                <?php foreach ($serviciosDeHospitalizacion as $d): ?>
                                    <div class="d-flex justify-content-between mb-2 bg-comprobante">
                                        <span class="text-comprobante"><?= $d["nombre"]; ?></span>
                                        <span class="fw-semibold text-comprobante"><?= $d["precio"] . " BS" ?></span>
                                    </div>
                                <?php endforeach ?>
                            <?php endif; ?>

                            <hr class="my-4 opacity-25">

                            <h6 class="text-center text-uppercase fw-bold mb-3 text-primary" style="letter-spacing: 1px;">Insumos</h6>
                            <?php foreach ($datosInsumos as $d): ?>
                                <div class=" p-2 rounded mb-3 border-start border-primary border-3 bg-comprobante">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold text-comprobante"><?php echo $d["nombre"] ?></span>
                                        <span class="text-comprobante">Cant: <?php echo $d["cantidad"] ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between small ">
                                        <span class="text-comprobante">Base: <?php echo ($d["iva"]) ? $d["precio"] - ($d["precio"] * 0.30) . " BS"  : $d["precio"] . " BS" ?></span>
                                        <span class="text-comprobante">IVA: <?php echo ($d["iva"]) ? $d["precio"] * 0.30 . " BS"  : "0 BS" ?></span>
                                    </div>
                                </div>
                            <?php endforeach ?>

                            <hr class="my-4 opacity-25">

                            <h6 class="text-center text-uppercase fw-bold mb-3 text-primary" style="letter-spacing: 1px;">Métodos de pago</h6>
                            <?php $referencia = ''; ?>
                            <?php foreach ($datosPago as $datoPago): ?>
                                <div class="d-flex justify-content-between mb-1 bg-comprobante">
                                    <span class="text-comprobante"><?php echo $datoPago["nombre"] ?></span>
                                    <span class="fw-bold text-comprobante"><?php echo $datoPago["monto"] . " BS" ?></span>
                                    <?php $referencia =( $datoPago["referencia"] != '0') ?$datoPago["referencia"]: "Sin Referencia" ?>
                                </div>
                            <?php endforeach ?>

                            <hr>
                            <div class="d-flex justify-content-between mb-1 bg-comprobante">
                                <span class="text-comprobante">Numero de Referencia:</span>
                                <span class="fw-bold text-comprobante"><?= $referencia ?></span>
                            </div>

                        </div>

                        <?php $id_factura = $parametro[0]; ?>

                        <div class="card-footer bg-transparent border-0 pb-4 bg-comprobante">
                            <div class="d-flex justify-content-center">
                                <a href="/Sistema-del--CEM--JEHOVA-RAFA/Factura/mostrarPDF/<?php echo $id_factura; ?>"
                                    class="btn btn-outline-primary rounded-circle p-3 d-flex align-items-center justify-content-center shadow-sm"
                                    style="width: 60px; height: 60px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                                        <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
                                        <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>





<?php require_once './src/vistas/head/footer.php'; ?>