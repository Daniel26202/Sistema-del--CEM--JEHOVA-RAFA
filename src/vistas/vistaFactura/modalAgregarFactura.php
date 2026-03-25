<!-- prueba -->





<!-- Modal Agregar Servicio Extra-->


<div class="modal fade" id="modal-agregar" tabindex="-1" aria-labelledby="modalBaseDatosLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content  tamaño-modal ">
      <div class="modal-header">
        <div class="fw-bolder d-flex" id="staticBackdropLabel">
          <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor"
            class="bi bi-clipboard2-plus-fill azul me-3" viewBox="0 0 16 16">
            <path
              d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5Z" />
            <path
              d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585c.055.156.085.325.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5c0-.175.03-.344.085-.5ZM8.5 6.5V8H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V9H6a.5.5 0 0 1 0-1h1.5V6.5a.5.5 0 0 1 1 0Z" />
          </svg>
          <h5>SELECCIONAR SERVICIOS </h5>
        </div>
        <a type="button" data-bs-dismiss="modal" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" width="80" height="40" fill="currentColor"
            class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
              d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
          </svg>
        </a>
      </div>

      <div class=" d-flex justify-content-end mt-3 caja-insumos">
        <a href="" class="btn d-none" title="Buscar" id="reiniciarBusquedaInsumo" uk-tooltip="Restablecer">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
            <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
            <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
          </svg>
        </a>
        <div class="d-flex justify-content-end form-responsive children-caja-insumos" autocomplete="off">
          <input class="form-control input-buscar tamaño-input-buscar input-responsive" id="searchInputSer" type="text" name="nombre"
            placeholder="Codigo o Nombre">

          <button class="btn btn-buscar boton-responsive" title="Buscar" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
              class="bi bi-search" viewBox="0 0 16 16">
              <path
                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
            </svg>
          </button>
        </div>
      </div>



      <div class="m-4">


        <div id="div-modal-servicio" class="modal-body d-flex justify-content-between flex-wrap">




        </div>


        <div id="paginationSer" class="pagination-div"></div>


        <div class="modal-footer">
          <button type="button" class="btn btn-modals-cancelar me-2" data-bs-dismiss="modal" id="btnCancelarInsertServ">Cancelar</button>
          <button type="submit" class="btn btn-modals " data-bs-dismiss="modal" id="btnInsertarServicioModal">Insertar</button>
        </div>

      </div>


    </div>
  </div>
</div>






<!-- Modal Agregar Insumo-->





<div class="modal fade" id="modal-agregar-insumos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content tamaño-modal">
      <div class="modal-header">
        <div class="fw-bolder d-flex" id="staticBackdropLabel">
          <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor"
            class="bi bi-capsule azul me-3" viewBox="0 0 16 16">
            <path
              d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
          </svg>
          <h5>SELECCIONAR INSUMOS </h5>
        </div>
        <a type="button" data-bs-dismiss="modal" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" width="80" height="40" fill="currentColor"
            class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
              d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
          </svg>
        </a>
      </div>

      <div class="form-modal  m-2 " style="width: 97%; overflow-y: auto;">
        <!-- Buscador de Insumos -->
        <div class=" d-flex justify-content-end mt-3 caja-insumos">
          <a href="" class="btn d-none" title="Buscar" id="reiniciarBusquedaInsumo" uk-tooltip="Restablecer">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
              <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
              <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
            </svg>
          </a>
          <div id="form-buscador-insumo" class="d-flex justify-content-end form-responsive children-caja-insumos" autocomplete="off">
            <input class="form-control input-buscar tamaño-input-buscar input-responsive" id="searchInput" type="text" name="nombre"
              placeholder="Codigo o Nombre">

            <button class="btn btn-buscar boton-responsive" title="Buscar" type="button">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-search" viewBox="0 0 16 16">
                <path
                  d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
              </svg>
            </button>
          </div>
        </div>


        <div class=" modal-body d-flex justify-content-between flex-wrap">


          <div id="div-modal-insumo" class="d-flex justify-content-between g-3">
            <!-- js -->
          </div>



        </div>

        <div id="pagination" class="pagination-div"></div>


        <div class="modal-footer">
          <button type="button" class="btn btn-modals-cancelar me-2" data-bs-dismiss="modal" id="btnCancelarInsertInsumo">Cancelar</button>
          <button type="submit" class="btn btn-modals " data-bs-dismiss="modal" id="btnInsertarInsumo">Insertar</button>
        </div>
      </div>
    </div>
  </div>
</div>







<!-- modal de para veriicar si paga el cliente o el paciente -->

<div class="modal fade" id="modal-cliente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog tamaño-modal">
    <div class="modal-content agregar">
      <div class="modal-header">
        <div class="fw-bolder d-flex" id="staticBackdropLabel">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-check-all azul me-2 " viewBox="0 0 16 16">
            <path
              d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992a.252.252 0 0 1 .02-.022zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486-.943 1.179z" />
          </svg>
          <div class="mt-1">VERIFICAR</div>
        </div>
        <a type="button" data-bs-dismiss="modal" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
              d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
          </svg>
        </a>
      </div>

      <div class="mt-4">
        <h5 id="datosPaciente" class="mt-3 text-uppercase" style="font-size: 15px; "></h5>
        <div class="toast-container position-fixed top-0 end-5 p-3">
          <div class="toast contenido" role="alert" aria-live="assertive" aria-atomic="true" autohide: false
            id="myToastfacturaCliente">
            <div class="toast-body">
              <h5 class="fw-bold  text-center">Haz click en registrar para guardar un
                nuevo cliente</h5>
              <div class="mt-2 pt-2 border-top">
                <a href="#">
                  <button type="button" id="btnRegistrarCliente" class="btn btn-agregarcita-modal" uk-toggle="target: #modal-exampleCliente" data-bs-dismiss="toast"> Registrar </button>
                </a>

                <button type="button" class="uk-button me-3 uk-button-default btn-cerrar-modal"
                  data-bs-dismiss="toast">Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="form-modal mt-2" id="inputCom">


        <div class="form-check form-switch d-flex align-items-center">
          <div>
            <input class="form-check-input paciente-cliente-check" type="checkbox" role="switch" id="flexSwitchCheckDefault"
              value="">
          </div>
          <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">
              Desea que la factura sea a nombre de otra persona, que no sea el paciente?
            </label></div>

        </div>

        <div class=" d-none" id="caja-buscar-cliente">


          <h5 style="margin-bottom: 20px;margin-top: 20px;" class="text-center">Buscar el cliente por la cedula</h5>

          <form style="margin-bottom: 20px;margin-top: 20px;" id="form-buscador-otro-cliente" class="d-flex justify-content-end" autocomplete="off">
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

          <h5 style="margin-bottom: 20px;margin-top: 20px;" class="text-center" id="data-cliente"></h5>

          <div id="div-cliente-no-encontrado" class=" d-none">
            <h5 class="text-center">El cliente no fue encontrado por favor añadalo</h5>
            <button class=" d-none caja-btn-margin btn btn-modals" style="width: 100% !important" data-bs-toggle="modal" data-bs-target="#modalCliente" id="btnAddCli">
              <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-bandaid-fill mx-2" viewBox="0 0 16 16">
                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
              </svg>Registrar cliente
            </button>
          </div>

        </div>



      </div>




      <div class="modal-footer ">
        <button type="button" class="btn btn-modals-cancelar me-2"
          data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-modals" data-bs-toggle="modal"
          data-bs-target="#modal-pago" id="botonPC">Siguiente</button>
      </div>

    </div>
  </div>
</div>




<!-- modal de tipo de pago -->


<div class="modal fade" id="modal-pago" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog tamaño-modal">
    <div class="modal-content agregar">
      <div class="modal-header">
        <div class="fw-bolder d-flex" id="staticBackdropLabel">
          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
            class="bi bi-cash-coin azul me-3 " viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z" />
            <path
              d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z" />
            <path
              d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z" />
            <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z" />
          </svg>
          <div>TIPOS DE PAGO</div>
        </div>
        <a type="button" data-bs-dismiss="modal" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
              d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
          </svg>
        </a>
      </div>


      <div class="form-modal" id="body-modal-pago">

        <!-- js -->


      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-modals-cancelar me-2"
          data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class=" btn btn-modals d-none" data-bs-dismiss="modal"
          id="btnTipoDePago">Siguiente</button>
      </div>

    </div>
  </div>
</div>






<!-- modal de validacion -->

<div class="modal fade" id="modal-validacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog tamaño-modal">
    <div class="modal-content agregar">
      <div class="modal-header">
        <div class="fw-bolder d-flex" id="staticBackdropLabel">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-check-all azul me-2 " viewBox="0 0 16 16">
            <path
              d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992a.252.252 0 0 1 .02-.022zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486-.943 1.179z" />
          </svg>
          <div class="mt-1"> VERIFICAR</div>
        </div>
        <a type="button" data-bs-dismiss="modal" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
              d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
          </svg>
        </a>
      </div>

      <div class="alert alert-primary p-1 text-center m-auto alerta-varios-metodos d-none" style="width: 96%;">La cantidad total de todos los campos tiene que ser equivalente al total y si alguno de los metodos de pago requiere referencia tambien es obligatoria</div>


      <div class="form-modal mt-2" id="inputCom">



        <label id="forma1"></label>
        <input type="number" class="form-control input-modal inputsDeValidacion" id="input1">

        <label id="forma2"></label>
        <input type="number" class="form-control input-modal inputsDeValidacion" id="input2">


        <label id="forma3"></label>
        <input type="number" class="form-control input-modal inputsDeValidacion d-none">

        <input type="text" class="form-control input-modal d-none" id="equivalenteDivisas"
          placeholder="Equivalente en Divisas">

        <input type="number" class="form-control input-modal d-none"
          uk-tooltip="Ingrese los 4 ultimos digitos de la referencia" id="referencia" placeholder="Referencia"
          maxlength="4" minlength="4"
          oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">


        <div>
          <p id="total-modal-validacion"></p>
          <input type="hidden" id="input-validacion-pago">
        </div>

      </div>





      <div class="modal-footer ">
        <button type="button" class="btn btn-modals-cancelar me-2"
          data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-modals d-none suguiente" data-bs-toggle="modal"
          data-bs-target="#modal-confirmacion" id="btnValidacion">Siguiente</button>
      </div>

    </div>
  </div>
</div>





<!-- modal de confirmacion -->

<div class="modal fade" id="modal-confirmacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog tamaño-modal modal-xl">
    <div class="modal-content agregar table-responsive">
      <div class="modal-header">
        <div class="fw-bolder d-flex" id="staticBackdropLabel">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
            class="bi bi-check-circle-fill azul me-2" viewBox="0 0 16 16">
            <path
              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
          </svg>CONFIRMAR OPERACIÓN
        </div>
        <a type="button" data-bs-dismiss="modal" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" width="80" height="40" fill="currentColor"
            class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
              d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
          </svg>
        </a>
      </div>

      <?php if (isset($_GET["idH"])): ?>
        <form action="/Sistema-del--CEM--JEHOVA-RAFA/Factura/guardarFacturaHospit" method="POST" class="" style="overflow-y: auto;">
          <!-- este input va a guardar el id del usuario que inicie sesion para la bitacora -->
          <input type="hidden" id="id_usuario_bitacora" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario']; ?>">
        <?php else: ?>
          <form action="/Sistema-del--CEM--JEHOVA-RAFA/Factura/guardarFactura" method="POST" class="">
            <!-- este input va a guardar el id del usuario que inicie sesion para la bitacora -->
            <input type="hidden" id="id_usuario_bitacora" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario']; ?>">
          <?php endif; ?>
          <form action="/Sistema-del--CEM--JEHOVA-RAFA/Factura/guardarFactura" method="POST" class="">
            <!-- este input va a guardar el id del usuario que inicie sesion para la bitacora -->
            <input type="hidden" id="id_usuario_bitacora" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario']; ?>">

            <table class="table table-striped" id="tablaConfirmaroperacion">
              <thead>
                <tr>
                  <p class="fw-bolder mb-0 mt-2 border-bottom">SERVICIOS</p>
                </tr>
              </thead>
              <tbody style="font-size: 14px;" id="cuerpoTablaConfirmaroperacion">


              </tbody>
            </table>
            <table class="table table-striped">
              <thead>

              </thead>
              <tbody id="tbodyDelModal" style="font-size: 14px;">

              </tbody>
            </table>
            <table class="table table-striped">
              <thead>
                <tr>
                  <p class="fw-bolder mb-0 mt-3 border-bottom">INSUMOS</p>
                </tr>
              </thead>
              <tbody style="font-size: 14px;" id="tbodyInsumos">

              </tbody>
            </table>

            <div>
              <input type="hidden" name="id_cita" id="inputIdCita">

              <p class="fw-bolder mb-0 mt-2">TIPOS DE PAGO</p>
              <p id="pagosDeConfirmacion"></p>
              <p id="valorInput"></p>
              <p id="pagosDeConfirmacion2"></p>
              <p id="valorInput2"></p>
              <p id="pagosDeConfirmacion3"></p>
              <p id="valorInput3"></p>
              <p id="p_divisas"></p>
              <p id="p_referencia"></p>


              <p class="fw-bolder mb-0 mt-2">TOTAL</p>

              <div id="totalDeConfirmacion"></div>

              <!-- //id_paciente -->
              <input type="hidden" name="id_paciente" id="inputPaciente">
              <input type="hidden" name="id_hospitalizacion" id="inputHospitalizacion">




              <input type="text" class="d-none" id="inputTotalDeConfirmacion" name="total">

              <div id="divInputPago">
                <input type="hidden" name="formasDePago[]">
                <input type="hidden">
                <input type="hidden">
              </div>

              <div id="divMontosPago">
                <input type="hidden" name="montosDePago[]">
                <input type="hidden">
                <input type="hidden">
              </div>

              <input type="hidden" id="referencia_confirmar" name="referencia">

            </div>




            <div class="modal-footer">
              <button type="button" class="btn btn-modals-cancelar me-2"
                data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-modals">Confirmar</button>
            </div>

          </form>

    </div>
  </div>
</div>





</div>