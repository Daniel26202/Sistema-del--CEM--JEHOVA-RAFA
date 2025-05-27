<?php require_once './src/vistas/head/head.php'; ?>


<div class="container-fluid px-4">

    <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
        <div class="ms-5 d-flex align-items-center" id="inicioFactura">
            <h1 class="fw-bold">FACTURACIÓN</h1>

            <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" fill="currentColor"
                class="bi bi-file-earmark-text ms-2 ico" viewBox="0 0 16 16">
                <path
                    d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z" />
                <path
                    d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
            </svg>
        </div>

        <?php require_once './src/vistas/tasaBCV.php'; ?>



        <div class=" d-flex align-items-end">
            <!-- requerir los botones -->
            <?php require_once './src/vistas/btnOpciones.php'; ?>
        </div>


    </div>

    <!-- modal de cerrar sesión -->
    <?php require_once './src/vistas/modalCierreS/modalCierreS.php'; ?>


    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 col-12 m-auto ">





        <div style="height: 70px;" id="cajaBotones" class="d-flex justify-content-end">

            <button id="botonAgregar"
                class="d-none btn btn-primary btn-agregar-doctores ms-4 mt-4 btn-agregar-ins-ser btn-factura"
                data-bs-toggle="modal" data-bs-target="#modal-agregar">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                    class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                </svg>
                Agregar Servicio
            </button>

            <button class="d-none btn ms-4 mt-4  btn-agregar-ins-ser btn-primary btn-agregar-doctores btn-factura"
                data-bs-toggle="modal" data-bs-target="#modal-agregar-insumos" id="btnInsumos">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                    class="bi bi-capsule" viewBox="0 0 16 16">
                    <path
                        d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                </svg>
                Agregar Insumos
            </button>

            <!-- <div class="d-flex mt-3">
			<form id="form-buscador-factura"  autocomplete="off" >

				<input class="form-control w-75 input-buscar" type="number" name="cedula" placeholder="Ingrese Cedula">

				<button class="btn btn-buscar" title="Buscar">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
						<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
					</svg>
				</button>

			</form>
			</div> -->

            <div class="d-flex">
                <div class="mt-4">
                    <h5 id="datosPaciente" class="mt-3 text-uppercase" style="margin-left: 15px;"></h5>
                    <div class="toast-container position-fixed top-0 end-5 p-3">
                        <div class="toast contenido" role="alert" aria-live="assertive" aria-atomic="true" autohide: false
                            id="myToastfactura">
                            <div class="toast-body">
                                <h5 class="fw-bold text-dark text-center">Haz Click en Registrar para Guardar un
                                    Nuevo Paciente</h5>
                                <div class="mt-2 pt-2 border-top">
                                    <a href="#">
                                        <button type="button" class="btn btn-agregarcita-modal" uk-toggle="target: #modal-examplePaciente"> Registrar </button>
                                    </a>

                                    <button type="button" class="uk-button me-3 uk-button-default btn-cerrar-modal"
                                        data-bs-dismiss="toast">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 validar" id="form-buscador">
                    <form id="form-buscador-factura" class="d-flex justify-content-end" autocomplete="off">
                        <input class="form-control input-buscar tamaño-input-buscar" type="text" name="cedula"
                            placeholder="Ingrese Cedula" required maxlength="8" minlength="6"
                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                            id="inputBusPaCi">

                        <button class="btn btn-buscar " title="Buscar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <!-- <div class="d-flex justify-content-end me-3">
						
					</div> -->
            <table class="table table-striped" id="ayudaTabla1">
                <thead>
                    <tr>
                        <th>SERVICIO MÉDICO</th>

                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

            <table class="table table-striped" id="ayudaTabla2">

                <tbody id="tbody">

                </tbody>
            </table>
            <table class="table table-striped" id="ayudaTabla3">
                <thead>
                    <tr>
                        <th>INSUMOS</th>

                    </tr>
                </thead>
                <tbody id="tbody-insumos">

                </tbody>
            </table>

            <!-- caja de los botones de vaciar , siguiente, total -->
            <!-- recoradatorio acomodar esto del color -->
            <div class="d-flex justify-content-between align-items-center mt-5">
                <div id="btnVaciar-Siguiente">
                    <div class="d-flex" id="cajaVaciarTotalSiguiente">
                        <button class="btn btn-agregarConsulta ms-3 me-4 btn-escondidos"
                            id="vaciarTabla">VACIAR</button>
                        <button id="btnSiguiente" class="btn btn-agregarConsulta btn-escondidos"
                            data-bs-toggle="modal" data-bs-target="#modal-pago">SIGUIENTE</button>
                    </div>
                </div>
                <div id="totalFac">

                    <label class="fw-bolder">TOTAL: </label>
                    <label>BS</label>
                    <input type="number" style="margin-left: -1px; padding-left: 6px;"
                        class=" w-25 input-buscar text-center" id="totalFactura" disabled>
                    <input type="hidden" id="inputTotalCita" value="0">
                </div>
            </div>

        </div>


    </div>


</div>




<?php require_once 'modalAgregarFactura.php'; ?>



<?php require_once './src/vistas/head/footer.php'; ?>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/factura.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/ayudaFactura.js"></script>