<!--MODAL REGISTRAR-->

<div id="modal-exampleEnfermeras" uk-modal>
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
            <img src="./src/assets/img/enfermera (3).png" width="30" height="27" uk-svg class="me-1 mb-3">
            </div>
            <div class="">
                <p class="uk-modal-title fs-5">
                    Registrar Enfermeras
                </p>
            </div>

        </div>
        <div class="alert alert-danger d-flex align-items-center d-none" role="alert" id="alerta">
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
  <div>
    Error en el envío del formulario
  </div>
</div>

        <form class="form-modal" id="modalAgregarEnfermeras" method="POST" action="?c=ControladorEnfermeras/insertar">

            <div class="input-group flex-nowrap" id="grp_cedula">

                <span class="input-modal mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-vcard-fill azul" viewBox="0 0 16 16">
                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z"/>
                </svg>
                    
                </span>
                <input class="form-control input-modal input-disabled input-paciente" style="width: 7vh !important;" type="number" id="cedula" name="cedula" placeholder="Cedula" required maxlength="8" minlength="6" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
            </div>

            <div class="input-group flex-nowrap" id="grp_nombre">
                <span class="input-modal mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-person-fill azul" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                    </svg>
                    
                </span>
                <input class="form-control input-modal input-disabled" type="text" name="nombre" id="nombre" placeholder="Nombre" required  maxlength="11">
            </div>

            <div class="input-group flex-nowrap" id="grp_apellido">
                <span class="input-modal mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-person-fill azul" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                    </svg>
                </span>
                <input class="form-control input-modal input-disabled" type="text" name="apellido" id="apellido" placeholder="Apellido" required  maxlength="11">
            </div>

            <div class="input-group flex-nowrap" id="grp_fechaNacimiento">
                <span class="input-modal mt-1">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
                        <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z"/>
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z"/>
                      </svg>
                </span>
                <input class="form-control input-modal input-disabled" type="date" name="fechaNacimiento" id="fechaNacimiento" 
                    placeholder="Fecha de Nacimiento" required  pattern="\d{4}-\d{2}-\d{2}">
            </div>

            <div class="input-group flex-nowrap" id="grp_telefono">
                <span class="input-modal mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-telephone-fill azul" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                    </svg>
                </span>
                <input class="form-control input-modal input-disabled" type="number" name="telefono"
                    placeholder="Telefono" required  maxlength="18">
            </div>

            <div class="input-group flex-nowrap" id="grp_correo">
                <span class="input-modal mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-envelope-at-fill azul" viewBox="0 0 16 16">
                      <path d="M2 2A2 2 0 0 0 .05 3.555L8 8.414l7.95-4.859A2 2 0 0 0 14 2zm-2 9.8V4.698l5.803 3.546zm6.761-2.97-6.57 4.026A2 2 0 0 0 2 14h6.256A4.5 4.5 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586zM16 9.671V4.697l-5.803 3.546.338.208A4.5 4.5 0 0 1 12.5 8c1.414 0 2.675.652 3.5 1.671"/>
                      <path d="M15.834 12.244c0 1.168-.577 2.025-1.587 2.025-.503 0-1.002-.228-1.12-.648h-.043c-.118.416-.543.643-1.015.643-.77 0-1.259-.542-1.259-1.434v-.529c0-.844.481-1.4 1.26-1.4.585 0 .87.333.953.63h.03v-.568h.905v2.19c0 .272.18.42.411.42.315 0 .639-.415.639-1.39v-.118c0-1.277-.95-2.326-2.484-2.326h-.04c-1.582 0-2.64 1.067-2.64 2.724v.157c0 1.867 1.237 2.654 2.57 2.654h.045c.507 0 .935-.07 1.18-.18v.731c-.219.1-.643.175-1.237.175h-.044C10.438 16 9 14.82 9 12.646v-.214C9 10.36 10.421 9 12.485 9h.035c2.12 0 3.314 1.43 3.314 3.034zm-4.04.21v.227c0 .586.227.8.581.8.31 0 .564-.17.564-.743v-.367c0-.516-.275-.708-.572-.708-.346 0-.573.245-.573.791"/>
                  </svg>
                </span>
                <input class="form-control input-modal input-disabled" type="text" name="correo"
                    placeholder="Correo" maxlength="50" required>
            </div>

            <div class="input-group flex-nowrap" id="grp_turno">
                <span class="input-modal mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-card-list azul" viewBox="0 0 16 16">
                      <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                      <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8m0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0M4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0"/>
                  </svg>

                </span>
                <select class="form-control input-modal input-disabled" type="text" name="turno" placeholder="Turno">
                    <option disabled>Turno</option>
                    <option>Diurno</option>
                    <option>Nocturno</option> 
                </select>
            </div>


            <div class="mt-3 uk-text-right">
                <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                    type="button">Cancelar</button>
                <button class="btn col-3 btn-agregarcita-modal" name="enviar" type="submit" >Agregar</button>
            </div>
        </form>


    </div>
</div>

