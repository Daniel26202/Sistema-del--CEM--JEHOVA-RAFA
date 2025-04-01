<div id="modal-examplecita" uk-modal>
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

        <div class="d-flex align-items-center mb-3">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                    class="bi bi-calendar2-plus-fill azul me-3 mb-3" viewBox="0 0 16 16">
                    <path
                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 3.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5H2.545c-.3 0-.545.224-.545.5m6.5 5a.5.5 0 0 0-1 0V10H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V11H10a.5.5 0 0 0 0-1H8.5z" />
                </svg>
            </div>
            <div class="">
                <p class="uk-modal-title fs-5">
                    Agendar Cita
                </p>
            </div>

        </div>
        <div class="alert alert-danger d-none alerta-cedula-paciente d-none" role="alert">
            <div class="">
                <p style="font-size: 13px;" class="text-center">Por favor, añada la cantidad de numeros correspodientes...</p>
            </div>
        </div>
        <div class="toast-container position-fixed bottom-0 start-0 p-3">
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" autohide: false id="myToast">
                <div class="toast-body">
                    <h5 class="fw-bold text-dark text-center">El Paciente no se encuentra Registrado</h5>
                    <div class="mt-2 pt-2 border-top">
                        <a href="">
                            <button type="button" class="btn btn-agregarcita-modal" uk-toggle="target: #modal-examplePaciente"> Registrar </button>
                        </a>

                        <button type="button" class="uk-button me-3 uk-button-default btn-cerrar-modal"
                            data-bs-dismiss="toast">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <form class="form-modal" action="/Sistema-del--CEM--JEHOVA-RAFA/Citas/guardarCita" id="modalAgregarCita" method="POST"
            autocomplete="off">

            <input type="hidden" value="<?php echo $_SESSION['id_usuario'] ?>" name="id_usuario">

            <div class="input-group flex-nowrap" id="grp_cedula">


                <img src="<?php echo $urlBase ?>../src/assets/img/seguro-de-salud.png" width="60" height="60" uk-svg class="iconoB me-2"
                    id="imgCita">

                <span class="input-modal mt-1 d-none" id="iconoCedulaCita">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-person-vcard-fill azul" viewBox="0 0 16 16">
                        <path
                            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                    </svg>
                </span>
                <select class=" input-modal" aria-label="2" placeholder="Nacionalidad" name="nacionalidad"
                    style="width: 70px; padding-left: 20px;">
                    <option value="V" selected>V</option>
                    <option value="E">E</option>
                </select>

                <input class="form-control input-modal input-disabled" type="number" name="cedula" placeholder="Cedula"
                    id="cedulaCita" required>
                <span class="" id="pacienteCitas">
                    <button class="btn btn-buscar " title="Buscar" id="buscarPacienteCita">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </span>
            </div>

            <input type="hidden" id="id_paciente" name="id_paciente">

            <!-- ocultamos el contenedor -->
            <div class="d-none" id="contenedorFormCitas">
                <div class="input-group flex-nowrap">
                    <span class="input-modal mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-person-fill azul" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        </svg>
                    </span>

                    <input class="form-control input-modal input-disabled" type="text" name="paciente"
                        placeholder="Paciente" disabled id="paciente">
                </div>

                <div class="input-group flex-nowrap">
                    <span class="input-modal mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-telephone-fill azul" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                        </svg>
                    </span>
                    <input class="form-control input-modal input-disabled" type="text" name="telefono"
                        placeholder="Telefono" disabled id="telefono">
                </div>

                <div class="input-group flex-nowrap">
                    <span class="input-modal mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-clipboard2-check-fill azul" viewBox="0 0 16 16">
                            <path
                                d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5" />
                            <path
                                d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585q.084.236.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5q.001-.264.085-.5m6.769 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                        </svg>
                    </span>
                    <select class="form-control input-modal" name="consulta" id="especialidad" required>
                        <option selected disabled>Seleccionar Especialidad</option>
                        <?php foreach ($especialidades as $especialidad): ?>
                            <option value="<?php echo $especialidad["0"] ?>">
                                <?php echo $especialidad["1"] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>


                <div class="input-group flex-nowrap">
                    <span class=" mt-1">
                        <img src="./src/assets/img/doctor (2).png" width="19" height="18" uk-svg class="mb-2 me-1">
                        Doctor</span>


                </div>

                <div id="listaDoctores" class="mt-2 mb-2">

                </div>

                <input type="hidden" id="id_servicioMedico" name="id_servicioMedico">

                <div class="input-modal mt-3">
                    <ul uk-accordion="multiple: true">
                        <li>
                            <a class="uk-accordion-title text-decoration-none" href="#">

                                <h6 class="acordion-paciente fw-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-calendar2-week-fill azul mb-2" viewBox="0 0 16 16">
                                        <path
                                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zM8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z" />
                                    </svg>
                                    Horario Doctores
                                </h6>
                            </a>

                            <div class="uk-accordion-content horario-insertar">

                            </div>
                        </li>
                    </ul>
                </div>

                <div class="alert alert-danger d-flex align-items-center justify-content-center d-none" role="alert"
                    id="alertahorarioCita">
                    <div class="text-center">
                        <p style="font-size: 10px; height: 20px;" class="text-center mb-3">VERIFIQUE QUE LA FECHA DE LA
                            CONSULTA ESTE COMPRENDIDA EN EL HORARIO DEL DOCTOR</p>
                    </div>
                </div>


                <div class="input-group flex-nowrap" id="grp_fecha">
                    <span class="input-modal mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-calendar-date-fill azul" viewBox="0 0 16 16">
                            <path
                                d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zm5.402 9.746c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2" />
                            <path
                                d="M16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-6.664-1.21c-1.11 0-1.656-.767-1.703-1.407h.683c.043.37.387.82 1.051.82.844 0 1.301-.848 1.305-2.164h-.027c-.153.414-.637.79-1.383.79-.852 0-1.676-.61-1.676-1.77 0-1.137.871-1.809 1.797-1.809 1.172 0 1.953.734 1.953 2.668 0 1.805-.742 2.871-2 2.871zm-2.89-5.435v5.332H5.77V8.079h-.012c-.29.156-.883.52-1.258.777V8.16a13 13 0 0 1 1.313-.805h.632z" />
                        </svg>
                    </span>
                    <input class="form-control input-modal" type="date" name="fecha" id="fecha" placeholder="Fecha"
                        required>

                </div>


                <div class="input-group flex-nowrap" id="grp_hora">
                    <span class="input-modal mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-clock-fill azul" viewBox="0 0 16 16">
                            <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                        </svg>
                    </span>
                    <input class="form-control input-modal" type="time" id="horaCita" name="hora" placeholder="Hora"
                        required>
                </div>

                <div class="input-group flex-nowrap">
                    <!-- <span class="input-modal mt-1">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
        class="bi bi-clock-history azul" viewBox="0 0 16 16">
        <path
        d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z" />
        <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z" />
        <path
        d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z" />
    </svg>
</span> -->
                    <input class="form-control input-modal input-disabled" type="hidden" name="estado"
                        placeholder="Estado" value="Pendiente">

                </div>
            </div>

            <div class="mt-3 uk-text-right">
                <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                    type="button">Cancelar</button>
                <button class="btn col-3 btn-agregarcita-modal d-none" type="submit" id="btnAgregarCita">Agregar</button>
            </div>
        </form>
    </div>
</div>





















<!-- Modal editar -->


<div id="modal-exampleEliminarcita" uk-modal>
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
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-trash-fill azul me-2" viewBox="0 0 16 16">
                    <path
                        d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                </svg>
            </div>
            <div>
                <h5>
                    ¿Desea eliminar la cita?
                </h5>
            </div>
        </div>

        <div class="mt-3 uk-text-right">
            <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                type="button">Cancelar</button>
            <button class="btn col-3 btn-agregarcita-modal" type="button">Eliminar</button>
        </div>

    </div>
</div>



<!-- modal editar -->
<!-- <div id="modal-examplecontroleditar" uk-modal>
    <div class="uk-modal-dialog uk-modal-body tamaño-modal"> -->
<!-- Boton que cierra el modal -->
<!-- <a href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
        </svg>
    </a>

    <div class="d-flex align-items-center">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor"
            class="bi bi-person-lines-fill azul me-3 mb-3" viewBox="0 0 16 16">
            <path
            d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z" />
        </svg>
    </div>
    <div>
        <p class="uk-modal-title fs-5">
            Editar Control
        </p>
    </div>

</div>

<form class="form-modal" id="modalAgregar">


<div class="form-floating input-modal">
    <textarea class="form-control border-0 input-modal" placeholder="Leave a comment here"
    id="floatingTextarea2" style="height: 50px;" name="Síntomas"></textarea>
    <label for="floatingTextarea2">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
        class="bi bi-thermometer-half azul" viewBox="0 0 16 16">
        <path d="M9.5 12.5a1.5 1.5 0 1 1-2-1.415V6.5a.5.5 0 0 1 1 0v4.585a1.5 1.5 0 0 1 1 1.415" />
        <path
        d="M5.5 2.5a2.5 2.5 0 0 1 5 0v7.55a3.5 3.5 0 1 1-5 0zM8 1a1.5 1.5 0 0 0-1.5 1.5v7.987l-.167.15a2.5 2.5 0 1 0 3.333 0l-.166-.15V2.5A1.5 1.5 0 0 0 8 1" />
    </svg>Síntomas</label>
</div>
<div class="form-floating input-modal">
    <textarea class="form-control border-0 input-modal" placeholder="Leave a comment here"
    id="floatingTextarea2" style="height: 50px;" name="Síntomas"></textarea>
    <label for="floatingTextarea2">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
        class="bi bi-heart-pulse-fill azul me-2" viewBox="0 0 16 16">
        <path
        d="M1.475 9C2.702 10.84 4.779 12.871 8 15c3.221-2.129 5.298-4.16 6.525-6H12a.5.5 0 0 1-.464-.314l-1.457-3.642-1.598 5.593a.5.5 0 0 1-.945.049L5.889 6.568l-1.473 2.21A.5.5 0 0 1 4 9z" />
        <path
        d="M.88 8C-2.427 1.68 4.41-2 7.823 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C11.59-2 18.426 1.68 15.12 8h-2.783l-1.874-4.686a.5.5 0 0 0-.945.049L7.921 8.956 6.464 5.314a.5.5 0 0 0-.88-.091L3.732 8z" />
    </svg>Diagnóstico</label>
</div>
<div class="form-floating input-modal">
    <textarea class="form-control border-0 input-modal" placeholder="Leave a comment here"
    id="floatingTextarea2" style="height: 50px;" name="Síntomas"></textarea>
    <label for="floatingTextarea2">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
        class="bi bi-receipt-cutoff azul me-1" viewBox="0 0 16 16">
        <path
        d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5M11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z" />
        <path
        d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118z" />
    </svg>
</svg>Prescripciones e indicaciones</label>
</div>

<div class="input-group flex-nowrap">
    <span class="input-modal mt-1">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
        class="bi bi-calendar-date-fill azul" viewBox="0 0 16 16">
        <path
        d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zm5.402 9.746c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2" />
        <path
        d="M16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-6.664-1.21c-1.11 0-1.656-.767-1.703-1.407h.683c.043.37.387.82 1.051.82.844 0 1.301-.848 1.305-2.164h-.027c-.153.414-.637.79-1.383.79-.852 0-1.676-.61-1.676-1.77 0-1.137.871-1.809 1.797-1.809 1.172 0 1.953.734 1.953 2.668 0 1.805-.742 2.871-2 2.871zm-2.89-5.435v5.332H5.77V8.079h-.012c-.29.156-.883.52-1.258.777V8.16a13 13 0 0 1 1.313-.805h.632z" />
    </svg>
</span>
<input class="form-control input-modal" type="date" name="fecha" placeholder="Fecha"
uk-tooltip="title: Fecha de regreso; pos: right">
</div>
</form>

<div class="mt-3 uk-text-right">
    <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
    type="button">Cancelar</button>
    <button class="btn col-3 btn-agregarcita-modal" type="button">Editar</button>
</div>
</div>
</div> -->

<!-- Modal eliminar -->

<!-- <div id="modal-exampleEliminarcontrol" uk-modal>
    <div class="uk-modal-dialog uk-modal-body tamaño-modal"> -->
<!-- Boton que cierra el modal -->
<!-- <a href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
        </svg>
    </a>

    <div class="d-flex align-items-center">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
            class="bi bi-trash-fill azul me-2" viewBox="0 0 16 16">
            <path
            d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
        </svg>
    </div>
    <div>
        <h5>
            ¿Desea eliminar el registro?
        </h5>
    </div>
</div>

<div class="mt-3 uk-text-right">
    <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
    type="button">Cancelar</button>
    <button class="btn col-3 btn-agregarcita-modal" type="button">Eliminar</button>
</div>

</div>
</div> -->





<!-- registrar paciente desde la cita -->

<div id="modal-examplePaciente" uk-modal>
    <div class="uk-modal-dialog uk-modal-body tamaño-modal">
        <!-- Boton que cierra el modal -->
        <a href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
            </svg>
        </a>

        <div class="d-flex align-items-center mb-3">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-fill-add azul me-3 mb-3" viewBox="0 0 16 16">
                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z" />
                </svg>
            </div>
            <div class="">
                <p class="uk-modal-title fs-5 ">
                    Registrar Paciente
                </p>
            </div>

        </div>
        <div class="alert alert-danger d-none alertaFormulario" role="alert">
            <div class="">
                <p style="font-size: 13px;" class="text-center">Por favor, corrige los errores en el formulario.</p>
            </div>
        </div>

        <form class="form-modal form-validable form-ajax" id="modalAgregar" action="/Sistema-del--CEM--JEHOVA-RAFA/Pacientes/guardar" method="POST" autocomplete="off">
            <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario']; ?>">

            <div class="input-group flex-nowrap margin-inputs" id="grp_cedula">
                <span class="input-modal mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-vcard-fill azul" viewBox="0 0 16 16">
                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                    </svg>
                </span>
                <span class="">
                    <select class="form-control input-modal" aria-label="2" placeholder="Nacionalidad" name="nacionalidad">
                        <option value="V" selected>V</option>
                        <option value="E">E</option>
                    </select>
                </span>

                <input class="form-control input-modal input-disabled input-paciente input-validar" style="width: 7vh !important;" type="number" id="cedula" name="cedula" placeholder="Cedula" required maxlength="8" minlength="6" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
            </div>

            <p class="p-error-cedula d-none">Cedula</p>

            <div class="input-group flex-nowrap margin-inputs" id="grp_nombre">
                <span class="input-modal mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill azul" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                    </svg>
                </span>

                <input class="form-control mayuscula input-modal input-disabled input-paciente input-validar" type="text" id="nombre" name="nombre" placeholder="Nombre" required maxlength="11">
            </div>

            <p class="p-error-nombre d-none">Nombre</p>

            <div class="input-group flex-nowrap margin-inputs" id="grp_apellido">
                <span class="input-modal mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill azul" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                    </svg>
                </span>
                <input class="form-control input-modal mayuscula input-disabled input-paciente input-validar" type="text" id="apellido" name="apellido" placeholder="Apellido" required maxlength="11">

            </div>

            <p class="p-error-apellido d-none">Apellido</p>

            <div class="input-group flex-nowrap margin-inputs" id="grp_telefono">
                <span class="input-modal mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-telephone-fill azul" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                    </svg>
                </span>
                <input class="form-control input-modal input-disabled input-paciente input-validar" type="number" id="telefono" name="telefono" placeholder="Telefono" required maxlength="18">
            </div>
            <p class="p-error-telefono d-none">Telefono</p>

            <div class="input-group flex-nowrap margin-inputs" id="grp_direccion">
                <span class="input-modal mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-card-heading azul" viewBox="0 0 16 16">
                        <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                        <path d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-1z" />
                    </svg>
                </span>
                <input class="form-control  mayuscula input-modal input-disabled input-paciente input-validar" type="text" id="direccion" name="direccion" placeholder="Direccion" required maxlength="20">
            </div>
            <p class="p-error-direccion d-none">Ddireccion</p>

            <label for="" class=" fw-bold mb-1 mt-2">Fecha de nacimiento</label>
            <div class="input-group flex-nowrap margin-inputs" id="grp_fn">
                <span class="input-modal mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
                        <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
                    </svg>
                </span>
                <input class="form-control input-modal input-disabled input-paciente input-validar" type="date" id="fn" name="fn" placeholder="Fn" required pattern="\d{4}-\d{2}-\d{2}">
            </div>
            <p class="p-error-fn d-none">fecha no valida</p>


            <!-- <div class="input-modal mt-3">
        <ul uk-accordion="multiple: true">
          <li>
            <a class="uk-accordion-title text-decoration-none" href="#">

              <h6 class="acordion-paciente fw-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-calendar2-week-fill azul mb-2" viewBox="0 0 16 16">
                  <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zM8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z" />
                </svg>
                Añadir Patologia Paciente
              </h6>
            </a>

            <div class="uk-accordion-content">
              <div class="d-flex justify-content-between flex-wrap">
                <?php foreach ($datosPatologias as $patologia) : ?>

                  <div class="d-flex w-50 justify-content-between mb-3">

                    <div class="form-check form-switch d-flex align-items-center">
                      <div>
                        <input class="form-check-input " type="checkbox" role="switch" id="flexSwitchCheckDefault" name="patologias[]" value="<?php echo $patologia['id_patologia'] ?>">
                      </div>
                      <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">
                          <?php echo $patologia['nombre_patologia'] ?>
                        </label></div>

                    </div>


                  </div>
                <?php endforeach ?>


              </div>
            </div>
          </li>
        </ul>



      </div> -->


            <div class="mt-3 uk-text-right">
                <button class="uk-button col-6 me-2 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>
                <button class="btn col-5 btn-agregarcita-modal" type="sumit" name="crear" id="botonEnviar">Agregar</button>
            </div>
        </form>
    </div>
</div>