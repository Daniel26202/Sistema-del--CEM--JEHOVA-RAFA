<!-- ====================================================
     MODAL UNIFICADO DE INSUMOS
     Sirve para Agregar Y Editar hospitalización.
     El contexto lo maneja JS con data-contexto="agregar|editar"
===================================================== -->
<div class="modal fade" id="modal-insumos" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalInsumosLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down">
        <div class="modal-content rounded-4 pt-3 pb-3 pe-4 ps-4 hospit">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mt-2 pt-0">
                <div class="d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor"
                        class="bi bi-plus-circle-fill color-icono" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5
                        0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
                    </svg>
                    <h4 class="fw-bold mb-0">Agregar insumo</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- BUSCADOR -->
            <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
                <p class="fw-bolder mb-0 ms-3" id="p-no-insumos-uni"></p>
                <div class="d-flex gap-2">
                    <input class="form-control input-buscar" type="text"
                        placeholder="Ingrese nombre" id="input-buscar-insumo-uni">
                    <button type="button" class="btn btn-buscar" id="btn-buscar-insumo-uni" title="Buscar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001
                            c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85
                            a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- LISTA DE INSUMOS (cards con nuevo diseño) -->
            <div class="mb-3">
                <h5 class="fw-bold text-center mb-3">Insumos disponibles</h5>

                <!-- Resultados de búsqueda dinámica -->
                <div class="row g-3" id="insumo-uni-existe"></div>

                <!-- Insumos iniciales (PHP) -->
                <div class="row g-3" id="insumos-uni-inicial">
                    <?php if ($datosI): ?>
                        <?php foreach ($datosI as $datoI): ?>
                            <div class="col-12 col-sm-6 col-md-4 divInsumosUni"
                                data-index="<?= $datoI['id_insumo'] ?>"
                                data-medida="<?= htmlspecialchars($datoI['medida'] ?? '') ?>"
                                data-precio="<?= $datoI['precio'] ?>"
                                data-cantidad="<?= $datoI['cantidad'] ?? 0 ?>"
                                data-nombre="<?= htmlspecialchars($datoI['nombre']) ?>">
                                <div class="card card-insumo-v2 border rounded-4 shadow-sm h-100"
                                    style="cursor:pointer">
                                    <div class="card-body pb-2">
                                        <p class="fw-bold mb-1 fs-6" style="color:var(--color-text-card)">
                                            <?= htmlspecialchars($datoI['nombre']) ?>
                                        </p>
                                        <?php if (!empty($datoI['medida'])): ?>
                                            <span class="insumo-v2-medida"><?= htmlspecialchars($datoI['medida']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <hr class="mx-3 my-0 opacity-25">
                                    <div class="card-body d-flex flex-column gap-2 pt-2">
                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="chip d-inline-flex align-items-center gap-1">
                                                <i class="bi bi-boxes"></i> Stock: <?= $datoI['cantidad'] ?? 0 ?>
                                            </span>
                                        </div>
                                        <div>
                                            <div class="precio-usd">$<?= number_format($datoI['precio'], 2) ?></div>
                                        </div>
                                        <button type="button"
                                            class="btn btn-v2 w-100 d-flex align-items-center justify-content-center gap-2 mt-auto btn-agregar-insumo-uni"
                                            data-index="<?= $datoI['id_insumo'] ?>">
                                            <i class="bi bi-plus-circle-fill"></i> Agregar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center text-muted">En estos momentos no hay insumos disponibles.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="d-flex justify-content-end pt-2 mt-3 border-top">
                <button type="button" class="btn btn-modals-cancelar fw-bold rounded-5"
                    id="btn-cancelar-insumo-uni" data-bs-dismiss="modal">
                    Cancelar
                </button>
            </div>

        </div>
    </div>
</div>
