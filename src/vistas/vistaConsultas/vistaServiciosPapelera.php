<?php require_once './src/vistas/head/head.php';  ?>


<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">

    <h5 style="width: 95%; " class="m-auto mb-3">Servicios <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
            fill="currentColor" class="bi bi-clipboard-heart mb-2 ms-2" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M5 1.5A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5v-1Zm5 0a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1Z" />
            <path
                d="M3 1.5h1v1H3a1 1 0 0 0-1 1V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3.5a1 1 0 0 0-1-1h-1v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2Z" />
            <path d="M8 6.982C9.664 5.309 13.825 8.236 8 12 2.175 8.236 6.336 5.31 8 6.982Z" />
        </svg>
    </h5>


    <!-- alertas -->
    <?php require_once "./src/vistas/alerts.php" ?>

    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto" style="width: 95%; ">

        <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">

            <a href="/Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas"
                class="btn-guardar-responsive btn btn-primary btn-agregar-doctores text-decoration-none col-8" id="">
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
                    class="bi bi-bandaid-fill me-1" viewBox="0 0 16 16">
                    <path
                        d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z">
                    </path>
                </svg>Servicios
            </a>


        </div>



        <div class="table table-responsive">
            <table class="example  table table-striped">
                <thead>
                    <tr>
                        <th class="text-dark">Servicio</th>
                        <th class="text-dark">Precio en BS</th>
                        <th class="text-dark">Precio en $</th>
                        <th class="text-dark">Acciones</th>
                    </tr>
                </thead>
                <tbody>


                    <?php foreach ($servicios as $servicio): ?>
                        <tr>
                            <td class="text-center">
                                <?= $servicio['categoria'] ?>
                            </td>
                            <td class="text-center">
                                <?= $servicio['precio'] * $_SESSION["dolar"] ?> BS
                            </td>
                            <td class="text-center">
                                <?= $servicio['precio'] ?> $
                            </td>
                            <td class="border-start">





                                <!-- Horario Del Doctor -->
                                <div class="d-flex justify-content-center">




                                    <!-- Eliminar CONSULTA-->

                                    <?php if (!$this->permisos($_SESSION["id_rol"], "eliminar", "Consultas")): ?>
                                        <!-- no hay -->
                                    <?php else: ?>
                                        <a href="#" class="btns-accion me-2"
                                            uk-toggle="target: #modal-exampleRestablecer<?= $servicio["id_servicioMedico"] ?>"
                                            uk-tooltip="Restablecer Servicio" id="btnEliminarServicioMedico">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                                class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                                                <path
                                                    d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                                            </svg>
                                        </a>

                                    <?php endif; ?>





                                </div>
                            </td>
                        </tr>

                        <!--modal de restablecer-->
                        <div id="modal-exampleRestablecer<?= $servicio["id_servicioMedico"] ?>" uk-modal>
                            <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                                <!-- Boton que cierra el modal -->
                                <a href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                        class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                        <path
                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                    </svg>
                                </a>

                                <div class="d-flex align-items-center">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                            class="bi bi-arrow-counterclockwise azul me-2 mb-1 " viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                                            <path
                                                d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h5>
                                            ¿Desea Restablecer El Servicio Médico?

                                        </h5>
                                    </div>
                                </div>


                                <div class="mt-3 uk-text-right">
                                    <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                                        type="button">Cancelar</button>
                                    <a class="btn col-3 btn-agregarcita-modal text-decoration-none"
                                        href="/Sistema-del--CEM--JEHOVA-RAFA/Consultas/restablecer/<?= $servicio["id_servicioMedico"] ?>/<?= $_SESSION['id_usuario'] ?>">Restablecer</a>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

    </div>


    <!-- modal de agregar -->








</div>

</div>
</div>




<?php require_once './src/vistas/head/footer.php';  ?>