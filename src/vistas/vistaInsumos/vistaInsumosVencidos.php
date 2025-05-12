<?php require_once './src/vistas/head/head.php'; ?>
<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
        <div class="ms-5 d-flex align-items-center" id="inicioDirectorio">
            <h1 class="fw-bold">INSUMOS</h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" fill="currentColor" class="bi bi-capsule ms-2" viewBox="0 0 16 16">
                <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
            </svg>
        </div>

        <div class="me-4">

            <!-- requerir los botones -->
            <?php require_once './src/vistas/btnOpciones.php'; ?>
        </div>
    </div>

    <!-- modal de cerrar sesión -->
    <?php require_once './src/vistas/modalCierreS/modalCierreS.php'; ?>

</div>

<!-- paginación servicio medico -->
<div class="d-flex">

    <div class="w-75 ms-5">
        <h3 class="fw-bold" id="inicioServicio">ENTRADAS VENCIDAS

            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-inboxes mb-2" viewBox="0 0 16 16">
                <path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562A.5.5 0 0 0 1.884 9h12.234a.5.5 0 0 0 .496-.438L14.933 6zM3.809.563A1.5 1.5 0 0 1 4.981 0h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393zm.941.83.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438l.32-2.562H10.45a2.5 2.5 0 0 1-4.9 0H1.066z" />
            </svg>
        </h3>

    </div>

    <div class=" me-3 mb-4  d-flex justify-content-end w-100">


        <ul class="sin-circulos d-flex justify-content-end">

            <li class="li">
                <div class="borde-de-menu  mb-1"></div>
                <div class="hover-grande">
                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Insumos/insumos" class="text-decoration-none text-black me-3" id="DMservicioMedico">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-capsule me-1" viewBox="0 0 16 16">
                            <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                        </svg>Insumos</a>
                </div>
            </li>
            <li class="li">
                <div class="borde-de-menu mb-1  "></div>
                <div class="hover-grande">
                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Entrada/entrada" class="text-decoration-none text-black me-3 iconoDoctor" id="DMdoctores">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-inboxes-fill me-1 mb-1 " viewBox="0 0 16 16">
                            <path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zM3.81.563A1.5 1.5 0 0 1 4.98 0h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393z" />
                        </svg>Entradas de Insumo</a>
                </div>

            </li>
            <li class="li">
                <div class="borde-de-menu mb-1 color-linea activo-border"></div>
                <div class="hover-grande">

                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Proveedores/proveedores" class="text-decoration-none text-black me-3" id="DMserviciosExtras">
                        <img src="<?= $urlBase ?>../src/assets/img/proveedor (3).png" width="20" height="20" uk-svg class="me-1">Proveedores</a>
                </div>

            </li>

            <li class="li">
                <div class="borde-de-menu mb-1 "></div>
                <div class="hover-grande">
                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Insumos/InsumosVencidos" class="text-decoration-none text-black me-3 iconoDoctor" id="DMdoctores">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-inboxes-fill me-1 mb-1 azul" viewBox="0 0 16 16">
                            <path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zM3.81.563A1.5 1.5 0 0 1 4.98 0h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393z" />
                        </svg>Entrada de Insumos Vencidas</a>
                </div>

            </li>


        </ul>

    </div>
</div>



<div>

    <!-- alerta -->
    <div class="alert alert-danger d-none text-center" id="alerta-fecha"></div>

    <div class="d-flex justify-content-end">



        <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 col-11 m-auto">


            <table class="example  col-12 ">
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
                            <td class="text-center"><?= $entrada['precio_entrada'] ?> BSs</td>
                            <td class="text-center"><?= $entrada['numero_de_lote'] ?></td>




                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>




















    </div>
</div>

</div>
























<!-- agregar Entrada -->
<div id="modal-exampleEntrada" uk-modal>
    <div class="uk-modal-dialog uk-modal-body tamaño-modal">
        <!-- Boton que cierra el modal -->
        <a href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
            </svg>
        </a>

        <div class="d-flex align-items-center">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-inboxes-fill azul me-2 mb-3" viewBox="0 0 16 16">
                    <path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zM3.81.563A1.5 1.5 0 0 1 4.98 0h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393z" />
                </svg>
            </div>
            <div class="">
                <p class="uk-modal-title fs-5">
                    Registrar Entrada
                </p>
            </div>

        </div>

        <form class="form-modal" method="POST" action="/Sistema-del--CEM--JEHOVA-RAFA/Entrada/guardar" autocomplete="off" id="modalAgregarEntrada">
            <div id="alerta-guardar-entrada" class="alert alert-danger d-none">VERIFIQUE EL FORMULARIO ANTES DE ENVIARLO
            </div>

            <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario']; ?>">

            <div class="input-group flex-nowrap">
                <span class="input-modal mt-1">
                    <img src="./src/assets/img/proveedor(2).png" width="20" height="20" uk-svg class="me-1">
                </span>

                <select class="form-control input-modal" name="id_proveedor">
                    <option disabled selected>Selecciona El Proveedor</option>
                    <?php foreach ($proveedores as $proveedor): ?>
                        <option value="<?= $proveedor['id_proveedor'] ?>">
                            <?= $proveedor['nombre'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>


            <div class="input-group flex-nowrap">
                <span class="input-modal mt-1 d-flex col-6" style="border-right: 3px solid #387ADF;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-capsule azul" viewBox="0 0 16 16">
                        <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                    </svg>
                    <div class=" text-center m-auto" style="font-size: 14px;">Nombre del Insumo</div>
                </span>
                <!-- <input class="form-control input-modal input-disabled input" type="text" placeholder="Ingrese el Insumo" id="nombre_insumo" disabled> -->
                <select class="form-control input-modal" name="id_insumo" id="id_insumoModal">
                    <option disabled selected value="">Seleccion Insumo</option>
                    <?php foreach ($insumos as $in): ?>
                        <option value="<?= $in["id_insumo"] ?>">
                            <?= $in["nombre"] ?>
                        </option>
                    <?php endforeach ?>
                </select>


                <!-- <input type="hidden" name="id_insumo" id="id_insumo"> -->
            </div>


            <div class="input-group flex-nowrap">
                <span class="input-modal mt-1 d-flex col-6" style="border-right: 3px solid #387ADF;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-capsule azul" viewBox="0 0 16 16">
                        <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                    </svg>
                    <div class=" text-center m-auto" style="font-size: 14px;">Numero de Lote</div>
                </span>
                <!-- <input class="form-control input-modal input-disabled input" type="text" placeholder="Ingrese el Insumo" id="nombre_insumo" disabled> -->
                <input type="number" class="form-control input-modal" name="lote">



                <!-- <input type="hidden" name="id_insumo" id="id_insumo"> -->
            </div>

            <div class="input-group flex-nowrap d-none">
                <span class="input-modal mt-1 d-flex col-6" style="border-right: 2px solid #387ADF;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-check-fill azul" viewBox="0 0 16 16">
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-2.6 5.854a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z" />
                    </svg>
                    <div class=" text-center m-auto" style="font-size: 14px;">Fecha de Ingreso</div>
                </span>
                <input class="form-control input-modal input" type="date" name="fechaDeIngreso" placeholder="Fecha De Ingreso" id="fechaDeIngreso" value=<?= date('Y-m-d'); ?>>
            </div>

            <div class="input-group flex-nowrap">
                <span class="input-modal mt-1 d-flex col-6" style="border-right: 2px solid #387ADF;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-check-fill azul" viewBox="0 0 16 16">
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-2.6 5.854a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z" />
                    </svg>
                    <div class=" text-center m-auto" style="font-size: 14px;">Fecha de Vencimiento</div>
                </span>
                <input class="form-control input-modal input" type="date" name="fechaDeVencimiento" placeholder="Fecha De Vencimiento" id="fechaDeVencimiento">
            </div>






            <div class="input-group flex-nowrap">
                <span class="input-modal mt-1 d-flex col-6" style="border-right: 2px solid #387ADF;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-stack azul" viewBox="0 0 16 16">
                        <path d="m14.12 10.163 1.715.858c.22.11.22.424 0 .534L8.267 15.34a.598.598 0 0 1-.534 0L.165 11.555a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.66zM7.733.063a.598.598 0 0 1 .534 0l7.568 3.784a.3.3 0 0 1 0 .535L8.267 8.165a.598.598 0 0 1-.534 0L.165 4.382a.299.299 0 0 1 0-.535L7.733.063z" />
                        <path d="m14.12 6.576 1.715.858c.22.11.22.424 0 .534l-7.568 3.784a.598.598 0 0 1-.534 0L.165 7.968a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.659z" />
                    </svg>
                    <div class=" text-center m-auto" style="font-size: 14px;">Cantidad</div>
                </span>
                <input class="form-control input-modal input" type="text" name="cantidad" placeholder="Cantidad" required>
            </div>


            <div class="input-group flex-nowrap">
                <span class="input-modal mt-1 d-flex col-6" style="border-right: 2px solid #387ADF;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cash-coin azul" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z" />
                        <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z" />
                        <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z" />
                        <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z" />
                    </svg>
                    <div class=" text-center m-auto" style="font-size: 14px;">Precio</div>
                </span>
                <input class="form-control input-modal input" type="text" name="precio" placeholder="Precio" required>

            </div>
            <i id="formatoPrecio" class="d-none">El formato del precio es incorrecto, Ejemplo 0,00 - 00,00 - 000,00 - 0.000,00 </i>




            <div class="mt-3 uk-text-right">
                <button class="uk-button col-6 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>

                <button class="btn col-5 btn-agregarcita-modal" type="submit" name="guardar">Agregar</button>
            </div>

        </form>
    </div>
</div>



<!-- agregar Entrada -->






<?php require_once './src/vistas/head/footer.php'; ?>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/entradas.js"></script>