<div class="me-4" id="paginationInsumos">
    <div class="mt-3 mb-5">
        <ul class="sin-circulos d-flex justify-content-end ">
            <li class="borde-menu activo <?= $vistaActiva == 'insumos'  ? ' activo-borde ' : '' ?>">
                <a href="/Sistema-del--CEM--JEHOVA-RAFA/Insumos/insumos" class="ico text-decoration-none me-3 color-letras"
                    id="citaPendiente">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-clock-history me-1" viewBox="0 0 16 16">
                        <path
                            d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                    </svg>Insumos</a>
            </li>
            <li class="borde-menu activo <?= $vistaActiva == 'entradas'  ? ' activo-borde ' : '' ?>">
                <a href="/Sistema-del--CEM--JEHOVA-RAFA/Entrada/entrada" class="text-decoration-none  me-3 iconoDoctor" id="DMdoctores">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-inboxes-fill me-1 mb-1" viewBox="0 0 16 16">
                        <path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zM3.81.563A1.5 1.5 0 0 1 4.98 0h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393z" />
                    </svg>Entradas</a>
            </li>

            <li class="borde-menu activo <?= $vistaActiva == 'proveedores'  ? ' activo-borde ' : '' ?>">
                <a href="/Sistema-del--CEM--JEHOVA-RAFA/Proveedores/proveedores" class="text-decoration-none  me-3" id="DMserviciosExtras">
                    <img src="<?= $urlBase ?>../src/assets/img/proveedor (3).png" width="20" height="20" uk-svg class="me-1">Proveedores</a>
            </li>


            <li class="borde-menu activo <?= $vistaActiva == 'vencidos'  ? ' activo-borde ' : '' ?>">
                <a href="/Sistema-del--CEM--JEHOVA-RAFA/Insumos/InsumosVencidos" class="text-decoration-none  me-3 iconoDoctor" id="DMdoctores">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-inboxes-fill me-1 mb-1" viewBox="0 0 16 16">
                        <path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zM3.81.563A1.5 1.5 0 0 1 4.98 0h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393z" />
                    </svg>Vencidos</a>
            </li>


        </ul>
    </div>
</div>