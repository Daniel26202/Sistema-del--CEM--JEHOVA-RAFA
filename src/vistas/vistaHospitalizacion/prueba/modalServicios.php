<!-- ====================================================
     MODAL UNIFICADO DE SERVICIOS
     Sirve para Agregar Y Editar hospitalización.
===================================================== -->
<div class="modal fade" id="modal-servicios-uni" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down">
        <div class="modal-content rounded-4 p-4 hospit">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor"
                        class="bi bi-plus-circle-fill color-icono" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3
                        a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
                    </svg>
                    <h4 class="fw-bold mb-0">Agregar servicio</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BUSCADOR -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="fw-bolder mb-0" id="p-no-servicio-uni"></p>
                <div class="d-flex gap-2">
                    <input class="form-control input-buscar" type="text"
                        placeholder="Ingrese nombre" id="input-buscar-servicio-uni">
                    <button type="button" class="btn btn-buscar" id="btn-buscar-servicio-uni" title="Buscar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001
                            c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85
                            a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- LISTA DE SERVICIOS (cards con nuevo diseño) -->
            <h5 class="fw-bold text-center mb-3">Servicios disponibles</h5>
            <p class="d-none text-center text-muted" id="no-hay-servicio-uni">
                En estos momentos no hay servicios disponibles.
            </p>
            <div class="row g-3" id="servicios-uni"></div>

            <!-- FOOTER -->
            <div class="d-flex justify-content-end pt-3 mt-3 border-top">
                <button type="button" class="btn btn-modals-cancelar fw-bold rounded-5"
                    id="btn-cancelar-servicio-uni" data-bs-dismiss="modal">
                    Cancelar
                </button>
            </div>

        </div>
    </div>
</div>
