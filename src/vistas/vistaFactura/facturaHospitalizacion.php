<?php require_once './src/vistas/head/head.php'; ?>


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


    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto " style="width: 95%; ">


        <div style="height: 70px;" id="cajaBotones" class="d-flex justify-content-end">

           
            </button> 


            <div class="d-flex">
               
                <div class="mt-4 w-25 d-flex justify-content-center">
                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/hospitalizacion" class="text-decoration-none"
                        uk-tooltip="Retroceder">
                        <button class="btnRetroceder" id="btnRetrocederFactura"><svg
                                xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
                                class="bi bi-reply-fill azul" viewBox="0 0 16 16">
                                <path
                                    d="M5.921 11.9 1.353 8.62a.719.719 0 0 1 0-1.238L5.921 4.1A.716.716 0 0 1 7 4.719V6c1.5 0 6 0 7 8-2.5-4.5-7-4-7-4v1.281c0 .56-.606.898-1.079.62z" />
                            </svg>
                        </button>
                    </a>
                </div>
            </div>
        </div>





        <div class="mt-5 table table-responsive ">
            <!-- <div class="d-flex justify-content-end me-3">
						
					</div> -->
            <?php foreach ($hostalizacionFacturar as $datoH): ?>
                <!-- hospitalizacion -->
                <table class="table table-striped" id="tablaDB">
                    <thead>
                        <tr>
                            <th class="fw-bolder mb-0 mt-2">HOSPITALIZACIÓN
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tablaBODYDB">


                        <tr>
                            <td class="border-top">
                                <div class="fw-bolder">CI:</div>
                                <?= $datoH["nacionalidad"] . "-" . $datoH["cedula"]; ?>
                            </td>
                            <td class="border-top">
                                <div class="fw-bolder">PACIENTE:</div>
                                <?= $datoH["nombre"]; ?>
                                <?= $datoH["apellido"]; ?>
                            </td>

                            <td class="border-top">
                                <div class="fw-bolder">DOCTOR:</div>
                                <?= $datoH["nombredoc"]; ?>
                                <?= $datoH["apellidodoc"]; ?>
                            </td>





                        </tr>


                    </tbody>

                </table>

                <!-- servicios -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="fw-bolder mb-0 mt-2">SERVICIOS INCLUIDOS
                            </th>
                        </tr>
                    </thead>
                    <?php foreach ($serviciosDeHospitalizacion as $datoH): ?>

                        <tbody id="tablaBODYDB">


                            <tr>
                                <td class="border-top">
                                    <div class="fw-bolder">SERVICIO:</div>
                                    <?= $datoH["nombre"]; ?>
                                </td>


                                <td class="border-top">
                                    <div class="fw-bolder">PRECIO:</div>
                                    <?= $datoH["precio"] . '   BS'; ?>
                                </td>



                            </tr>


                        </tbody>


                    <?php endforeach ?>
                </table>




                <!-- insumos -->
                <table class="table table-striped" id="tablaIM">
                    <thead>
                        <tr>
                            <th class="fw-bolder mb-0 mt-3 border-bottom">INSUMOS</th>
                        </tr>
                    </thead>
                    <?php foreach ($insumosHospitalizacion as $datoH): ?>

                        <tbody id="tbody-insumos">
                            <tr>
                                <td class="border-top">
                                    <div class="fw-bolder">NOMBRE:</div>
                                    <?= $datoH["nombre"]; ?>
                                </td>


                                <td class="border-top">
                                    <div class="fw-bolder">MEDIDA:</div>
                                    <?= $datoH["medida"]; ?>
                                </td>

                                <td class="border-top">
                                    <div class="fw-bolder">PRECIO:</div>
                                    <?= $datoH["precio"] . '   BS'; ?>
                                </td>



                            </tr>
                        </tbody>

                    <?php endforeach; ?>
                </table>
                <!-- caja de los botones de vaciar , siguiente, total -->
                <!-- recordatorio acomodar esto del color -->
                <div class="d-flex justify-content-between align-items-center mt-5">

                    <div class="d-flex" id="cajaVaciarTotalSiguiente">
                        <button class="ico btn btn-agregarConsulta ms-3 me-4 " id="vaciarTabla">VACIAR</button>
                        <button id="siguienteFact" class="ico btn btn-agregarConsulta " data-bs-toggle="modal"
                            data-bs-target="#modal-cliente">SIGUIENTE</button>
                    </div>

                    <div class="ico " id="totalFac">
                        <label class="fw-bolder">TOTAL: </label>
                        <label>BS</label>
                        <?php foreach ($hostalizacionFacturar as $datoH): ?>
                            <input type="text" style="margin-left: -1px; padding-left: 6px;"
                                class="ico w-25 input-buscar text-center" id="totalFactura" disabled value=<?= $datoH['total'] ?>>
                            <input type="hidden" id="inputTotalCita" value="<?= $datoH['total'] ?>">
                        <?php endforeach; ?>


                    </div>
                </div>
            <?php endforeach ?>

            <!-- caja de los botones de vaciar , siguiente, total -->
            <!-- recoradatorio acomodar esto del color -->


        </div>

    </div>
</div>


<?php require_once 'modalAgregarFactura.php'; ?>
<?php require_once './src/vistas/head/footer.php'; ?>

<script type="module" src="<?= $urlBase ?>../src/assets/factura.js"></script>