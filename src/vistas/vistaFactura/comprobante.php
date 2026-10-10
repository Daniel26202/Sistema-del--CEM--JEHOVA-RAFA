<?php require_once './src/vistas/head/head.php'; ?>

<?php
/**
 * Escapa cualquier valor antes de imprimirlo. Los datos vienen de la base y
 * antes se imprimían con echo desnudo (XSS almacenado: un insumo o paciente
 * con HTML en el nombre se ejecutaba en el comprobante de todos).
 */
$e = static fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
$bs = static fn($v) => number_format((float)$v, 2, '.', '');
$tasa = defined('TASA_IMPUESTO') ? (float)TASA_IMPUESTO : 0.16;
?>

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
                                    <h3 class="fw-bold mb-0"><?= $bs($datoFactura['total'] ?? 0) ?> BS</h3>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-6 text-start text-comprobante"><span class="fw-bold ">Código:</span></div>
                                    <div class="col-6 text-end text-comprobante"><span><?= $e($datoFactura['id_factura'] ?? '') ?></span></div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-6 text-start text-comprobante"><span class="fw-bold">Fecha:</span></div>
                                    <div class="col-6 text-end text-comprobante"><span><?= $e($datoFactura['fecha'] ?? '') ?></span></div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-6 text-start text-comprobante"><span class="fw-bold ">Cédula Cliente:</span></div>
                                    <div class="col-6 text-end text-comprobante"><span><?= $e(($datoFactura['nacionalidad'] ?? '') . '-' . ($datoFactura['cedula_p'] ?? '')) ?></span></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6 text-start text-comprobante"><span class="fw-bold ">Cliente:</span></div>
                                    <div class="col-6 text-end text-comprobante"><span><?= $e(($datoFactura['nombre_p'] ?? '') . ' ' . ($datoFactura['apellido_p'] ?? '')) ?></span></div>
                                </div>
                            <?php endforeach ?>

                            <hr class="my-4 opacity-25">

                            <h6 class="text-center text-uppercase fw-bold mb-3 text-primary" style="letter-spacing: 1px;">Servicios</h6>

                            <?php if (!$vistaActiva): ?>
                                <?php foreach ($datosServiciosExtras as $d): ?>
                                    <div class="p-2 rounded mb-3 border-start border-primary border-3 bg-comprobante">
                                        <div class="d-flex justify-content-between mb-2 bg-comprobante">
                                            <span class="fw-semibold text-comprobante"><?= $e($d["categoria_servicio"] ?? '') ?></span>
                                            <span class="text-comprobante">
                                                DR: <?= $e(trim(($d["nombre_d"] ?? '') . ' ' . ($d["apellido_d"] ?? ''))) ?> |
                                                <?= $bs($d["subtotal"] ?? 0) ?> BS
                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php endif; ?>

                            <?php if ($vistaActiva): ?>
                                <?php foreach ($serviciosDeHospitalizacion as $d): ?>
                                    <div class="d-flex justify-content-between mb-2 bg-comprobante">
                                        <span class="text-comprobante"><?= $e($d["categoria"] ?? ($d["nombre"] ?? '')) ?></span>
                                        <span class="fw-semibold text-comprobante"><?= $bs($d["precios_servicio"] ?? ($d["precio"] ?? 0)) ?> $</span>
                                    </div>
                                <?php endforeach ?>
                            <?php endif; ?>

                            <hr class="my-4 opacity-25">

                            <h6 class="text-center text-uppercase fw-bold mb-3 text-primary" style="letter-spacing: 1px;">Insumos</h6>

                            <?php
                            /*
                             * Antes el IVA se recalculaba aquí con un 30% fijo sobre
                             * un precio que además se imprimía como "BS" siendo la
                             * columna del catálogo en divisa. Ahora:
                             *   - la base y el IVA salen del detalle guardado,
                             *   - el precio unitario del insumo viene con IVA incluido
                             *     (columna precio_unitario de detalle_factura).
                             */
                            $hayInsumos = false;
                            foreach ($datosInsumos as $d) : $hayInsumos = true; ?>
                                <div class="p-2 rounded mb-3 border-start border-primary border-3 bg-comprobante">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold text-comprobante"><?= $e($d["nombre"] ?? '') ?></span>
                                        <span class="text-comprobante">Cant: <?= $e($d["cantidad"] ?? 0) ?></span>
                                    </div>
                                    <?php
                                    $aplicaIVA = !empty($d['aplica_iva']) || !empty($d['iva_aplicado']);
                                    // precio_unitario ya incluye IVA cuando aplica.
                                    $unitario = (float)($d['precio_unitario'] ?? ($d['precio'] ?? 0));
                                    $importe = isset($d['subtotal']) && (float)$d['subtotal'] > 0
                                        ? (float)$d['subtotal']
                                        : $unitario * (float)($d['cantidad'] ?? 0);
                                    $tasaAplicada = (float)($d['tasa_iva'] ?? $tasa);
                                    $ivaUnitario = $aplicaIVA ? $unitario * ($tasaAplicada / (1 + $tasaAplicada)) : 0.0;
                                    $ivaTotal = $ivaUnitario * (float)($d['cantidad'] ?? 0);
                                    $baseTotal = max(0.0, $importe - $ivaTotal);
                                    ?>
                                    <div class="d-flex justify-content-between small">
                                        <span class="text-comprobante">Base: <?= $bs($baseTotal) ?> BS</span>
                                        <span class="text-comprobante">IVA (<?= $e(number_format($tasaAplicada * 100, 0)) ?>%): <?= $bs($ivaTotal) ?> BS</span>
                                    </div>
                                    <div class="d-flex justify-content-between small">
                                        <span class="fw-bold text-comprobante">Total insumo:</span>
                                        <span class="fw-bold text-comprobante"><?= $bs($importe) ?> BS</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <?php if (!$hayInsumos): ?>
                                <p class="text-center text-comprobante">Sin insumos</p>
                            <?php endif; ?>

                            <hr class="my-4 opacity-25">

                            <h6 class="text-center text-uppercase fw-bold mb-3 text-primary" style="letter-spacing: 1px;">Métodos de pago</h6>
                            <?php $referencia = ''; ?>
                            <?php foreach ($datosPago as $datoPago): ?>
                                <div class="d-flex justify-content-between mb-1 bg-comprobante">
                                    <span class="text-comprobante"><?= $e($datoPago["nombre"] ?? '') ?></span>
                                    <span class="fw-bold text-comprobante"><?= $bs($datoPago["monto"] ?? 0) ?> BS</span>
                                    <?php
                                    $ref = (string)($datoPago["referencia"] ?? '0');
                                    $referencia = ($ref !== '' && $ref !== '0') ? $ref : "Sin Referencia";
                                    ?>
                                </div>
                            <?php endforeach ?>

                            <hr>
                            <div class="d-flex justify-content-between mb-1 bg-comprobante">
                                <span class="text-comprobante">Numero de Referencia:</span>
                                <span class="fw-bold text-comprobante"><?= $e($referencia) ?></span>
                            </div>

                        </div>

                        <?php $id_factura = $parametro[0] ?? ''; ?>

                        <div class="card-footer bg-transparent border-0 pb-4 bg-comprobante">
                            <div class="d-flex justify-content-center">
                                <a href="/Sistema-del--CEM--JEHOVA-RAFA/Factura/mostrarPDF/<?= $e($id_factura) ?>"
                                    class="btn btn-outline-primary rounded-circle p-3 d-flex align-items-center justify-content-center shadow-sm"
                                    style="width: 60px; height: 60px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                                        <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a2 2 0 0 0-1 1v3a2 2 0 0 0 1 1h6a2 2 0 0 0 1-1v-3a2 2 0 0 0-1-1z" />
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