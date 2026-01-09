    import { executePetition, alertConfirm, alertError, alertSuccess } from "./funtionExecutePetition.js";

    console.log("entradas.js ...");

    const url = "/Sistema-del--CEM--JEHOVA-RAFA/Entrada";

    const modalAgregar = document.getElementById("modalAgregarEntrada");

    
    const readEntrada = async () => {
      try {
        let metodo = "";
        let urlActual = window.location.href;
    
        if (!urlActual.includes("papelera")) metodo = "entradasAjax";
        else metodo = "entradasPapeleraAjax";
    
        const result = await executePetition(url + "/" + metodo, "GET");
        console.log(result)
        // construir html de filas
        let html = "";
        result.forEach((element) => {
          html += `<tr>
                            <td class="text-center">${element.nombre}</td>
                            <td class="text-center">${element.proveedor}</td>
                            <td class="text-center">${element.fechaDeIngreso}</td>
                            <td class="text-center">${element.fechaDeVencimiento}</td>
                            <td class="text-center">${element.cantidad_entrada}</td>
                            <td class="text-center">${element.precio_entrada} BS</td>
                            <td class="text-center">${element.numero_de_lote}</td>



                            <td class="text-center">

                                <div class="d-flex justify-content-center align-items-center">
                                    <!-- eliminar -->
                                    <div class="me-2">
                                        <button class="${
                                          !urlActual.includes("papelera") ? "" : "d-none"
                                        } btn btn-tabla btn-eliminar btnEliminarDoctor btn-dt-tabla mb-1" data-index="${
            element.id_entrada
          }">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- eliminar -->
                                    <div>
                                        <button class="${
                                          !urlActual.includes("papelera") ? "" : "d-none"
                                        } btn btnEditarDoctor btn-tabla btn-dt-tabla mb-1 btn-js editar botonesEdi" data-id-tabla="modal-exampleEntradaEditar${
            element.id_entrada
          }" uk-toggle="target: #modal-exampleEntradaEditar${element.id_entrada}" data-index='${element.id_entrada}'>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                            </svg>
                                        </button>
                                    </div>


                                    <div class="me-2">
                    <a href="#" class=" btn btn-tabla btn-dt-tabla btnRestablecer ${
                                          urlActual.includes("papelera") ? "" : "d-none"
                                        }" data-index="${element.id_entrada}" title="Restablecer Entrada" uk-tooltip=""  aria-describedby="uk-tooltip-27">
                      <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-arrow-counterclockwise " viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>
                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                      </svg>
                    </a>
                  </div>



                                </div>
                                <!-- modal editar -->

                                <!-- editar Entrada -->
                                <div id="modal-exampleEntradaEditar${element.id_entrada}" uk-modal>
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
                                                    Modificar Entrada
                                                </p>
                                            </div>

                                        </div>

                                        <form class="form-modal form-validable${
                                          element.id_entrada
                                        } form-ajax forms-editar"  autocomplete="off" >
                                            <div id="alerta-guardar-entrada" class="alert alert-danger d-none">VERIFIQUE EL FORMULARIO ANTES DE ENVIARLO
                                            </div>

                                            <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario']; ?>">




                                            <div class="input-group flex-nowrap">
                                                <span class="input-modal mt-1 d-flex col-6" style="border-right: 3px solid #387ADF;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-capsule azul" viewBox="0 0 16 16">
                                                        <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                                                    </svg>
                                                    <div class=" text-center m-auto" style="font-size: 14px;">Nombre del Insumo</div>
                                                </span>
                                                <!-- <input class="form-control input-modal input-disabled input" type="text" placeholder="Ingrese el Insumo" id="nombre_insumo" disabled> -->
                                                <select class="form-control input-modal" name="id_insumo" id="id_insumoModal">
                                                    <option disabled selected value="${element.id_insumo}">${
            element.nombre
          }</option>
                                                    
                                                </select>


                                                <!-- <input type="hidden" name="id_insumo" id="id_insumo"> -->
                                            </div>


                                            <input type="hidden" name="id_entrada" value="${element.id_entrada}">

                                            <input type="hidden" name="id_proveedor" value="${element.id_proveedor}">


                                            <input type="hidden" name="id_insumo" value="${element.id_insumo}">




                                            <div class="input-group flex-nowrap grpFormCorrect">
                                                <span class="input-modal mt-1 d-flex col-6" style="border-right: 3px solid #387ADF;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-capsule azul" viewBox="0 0 16 16">
                                                        <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
                                                    </svg>
                                                    <div class=" text-center m-auto" style="font-size: 14px;">Numero de Lote</div>
                                                </span>
                                                <!-- <input class="form-control input-modal input-disabled input" type="text" placeholder="Ingrese el Insumo" id="nombre_insumo" disabled> -->
                                                <input type="number" class="form-control input-modal input-validar" name="lote" value="${
                                                  element.numero_de_lote
                                                }">



                                                <!-- <input type="hidden" name="id_insumo" id="id_insumo"> -->
                                            </div>


                                            <p class="p-error-lote${
                                              element.id_entrada
                                            } d-none">El numero de lote solo debe incluir numeros minimos 4</p>

                                            <div class="input-group flex-nowrap d-none">
                                                <span class="input-modal mt-1 d-flex col-6" style="border-right: 2px solid #387ADF;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-check-fill azul" viewBox="0 0 16 16">
                                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-2.6 5.854a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z" />
                                                    </svg>
                                                    <div class=" text-center m-auto" style="font-size: 14px;">Fecha de Ingreso</div>
                                                </span>
                                                <input class="form-control input-modal input" type="date" name="fechaDeIngreso" placeholder="Fecha De Ingreso" id="fechaDeIngreso" value=<?= date('Y-m-d'); ?>>
                                            </div>

                                            <div class="input-group flex-nowrap grpFormCorrect">
                                                <span class="input-modal mt-1 d-flex col-6" style="border-right: 2px solid #387ADF;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-check-fill azul" viewBox="0 0 16 16">
                                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-2.6 5.854a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z" />
                                                    </svg>
                                                    <div class=" text-center m-auto" style="font-size: 14px;">Fecha de Vencimiento</div>
                                                </span>
                                                <input class="input-validar form-control input-modal input" type="date" name="fechaDeVencimiento" placeholder="Fecha De Vencimiento" id="fechaDeVencimiento" value="${
                                                  element.fechaDeVencimiento
                                                }">
                                            </div>

                                            <p class="p-error-fechaDeVencimiento${element.id_entrada} d-none"></p>





                                            <div class="input-group flex-nowrap  grpFormCorrect">
                                                <span class="input-modal mt-1 d-flex col-6" style="border-right: 2px solid #387ADF;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-stack azul" viewBox="0 0 16 16">
                                                        <path d="m14.12 10.163 1.715.858c.22.11.22.424 0 .534L8.267 15.34a.598.598 0 0 1-.534 0L.165 11.555a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.66zM7.733.063a.598.598 0 0 1 .534 0l7.568 3.784a.3.3 0 0 1 0 .535L8.267 8.165a.598.598 0 0 1-.534 0L.165 4.382a.299.299 0 0 1 0-.535L7.733.063z" />
                                                        <path d="m14.12 6.576 1.715.858c.22.11.22.424 0 .534l-7.568 3.784a.598.598 0 0 1-.534 0L.165 7.968a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.659z" />
                                                    </svg>
                                                    <div class=" text-center m-auto" style="font-size: 14px;">Cantidad</div>
                                                </span>
                                                <input class="input-validar form-control input-modal input" type="text" name="cantidad" placeholder="Cantidad" required value="${
                                                  element.cantidad_entrada
                                                }">
                                            </div>

                                            <p class="p-error-cantidad${
                                              element.id_entrada
                                            } d-none">La cantidad debe ser solo datos numericos</p>




                                            <div class="input-group flex-nowrap grpFormCorrect">
                                                <span class="input-modal mt-1 d-flex col-6" style="border-right: 2px solid #387ADF;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cash-coin azul" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z" />
                                                        <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z" />
                                                        <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z" />
                                                        <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z" />
                                                    </svg>
                                                    <div class=" text-center m-auto" style="font-size: 14px;">Precio</div>
                                                </span>
                                                <input class="form-control input-validar input-modal input" type="text" name="precio" placeholder="Precio" required value="${
                                                  element.precio_entrada
                                                }">

                                            </div>
                                            <p class="p-error-precio${
                                              element.id_entrada
                                            } d-none">El formato del precio es incorrecto, Ejemplo 0,00 - 00,00 - 000,00 - 0.000,00</p>



                                            <div class="mt-3 uk-text-right">
                                                <button class="uk-button col-6 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>

                                                <button class="btn col-5 btn-agregarcita-modal" type="submit" name="guardar">Editar</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>

                            </td>
                        </tr>`;
        });
    
        const selector = ".exampleTable";
    
        // si ya existe DataTable, destrúyela
        if ($.fn.DataTable.isDataTable(selector)) {
          $(selector).DataTable().clear().destroy();
        }
    
        // vuelca el html en el tbody
        document.querySelector(selector + " tbody").innerHTML = html;
    
        document.querySelectorAll(".id_usuario_bitacora").forEach((ele) => {
          ele.value = document.getElementById("id_usuario_session").value;
        });
    
        //llamar las funcion de eliminar
        document.querySelectorAll(".btn-eliminar").forEach((btn) => {
          btn.addEventListener("click", function () {
            const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];
            alertConfirm("Esta seguro de eliminar la entrada?", deleteEntrada, data);
          });
        });
    
        //llamar las funciones de editar
        document.querySelectorAll(".forms-editar").forEach((formEditar) => {
          formEditar.addEventListener("submit", function (e) {
            e.preventDefault();
            let inputsBuenos = [];
    
            this.querySelectorAll(".input-validar").forEach((input) => {
              if (input.parentElement.classList.contains("grpFormCorrect")) inputsBuenos.push(true);
            });
    
            if (
              inputsBuenos.length == 4
            ) {
              updateEntrada(this, inputsBuenos);
            } else {
              alertError("Error al enviar el formulario", "Por favor verifique que todos los datos esten correctos.")
            }
          });
        });
    
        //llamar a la uncion de restablecer
        //llamar las funcion de eliminar
        document.querySelectorAll(".btnRestablecer").forEach((btn) => {
          btn.addEventListener("click", function () {
            const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];
            alertConfirm("Esta seguro de restablecer la entrada ?",restablecerEntrada, data)
          });
        });
    
        // re-inicializa
        $(selector).DataTable({
          language: {
            language: {
              decimal: ",",
              thousands: ".",
              lengthMenu: "Mostrar por página _MENU_ ",
              zeroRecords: "No se encontraron resultados",
              info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
              infoEmpty: "No hay registros disponibles",
              infoFiltered: "(filtrado de _MAX_ registros en total)",
              search: "Buscar:",
            },
          },
        });
      } catch (error) {
        alertError("Error", error)
      }
    };


    //delete
    const deleteEntrada = async (data) => {
      try {
        const result = await executePetition(url + `/eliminar/${data}`, "GET");
        if (result.ok) {
          alertSuccess(result.message)
    
          readEntrada();
        } else throw new Error(`${result.error}`);
      } catch (error) {
        alertError("Error", error)
      }
    };

    //create
    const createEntrada = async (form, inputs) => {
      try {
        const data = new FormData(form);
        let result = await executePetition(url + "/guardar", "POST", data);
        console.log(result);
        if (result.ok) {
          alertSuccess(result.message);
    
          UIkit.modal("#modal-exampleEntrada").hide();
          form.reset();
          inputs = [];
          inputs.forEach((input) => input.parentElement.classList.remove("grpFormCorrect"));
          readEntrada();
        } else throw new Error(`${result.error}`);
      } catch (error) {
        alertError('Error', error)
      }
    };

    //update
    const updateEntrada = async (form, inputs) => {
      console.log(url + "/editar");
      try {
        const data = new FormData(form);
        let result = await executePetition(url + "/editar", "POST", data);
        console.log(result);
        if (result.ok) {
          alertSuccess(result.message)
    
          UIkit.modal(`#${form.parentElement.parentElement.getAttribute("id")}`).hide();
          inputs = [];
          inputs.forEach((input) => input.parentElement.classList.remove("grpFormCorrect"));
          readEntrada();
        } else throw new Error(`${result.error}`);
      } catch (error) {
        console.log(error);
        alertError('Error', error)
      }
    };

    //restablecer
    const restablecerEntrada = async (data) => {
      try {
        const result = await executePetition(url + `/restablecerEntrada/${data}`, "GET");
        if (result.ok) {
          alertSuccess(result.message)
    
          readEntrada();
        } else throw new Error(`${result.error}`);
      } catch (error) {
        alertError("Error",error)
      }
    };

    readEntrada();


    if (modalAgregar) {
      modalAgregar.addEventListener("submit", function (e) {
        e.preventDefault();
        let inputsBuenos = [];
        this.querySelectorAll(".input-validar").forEach((input) => {
          if (input.parentElement.classList.contains("grpFormCorrect")) inputsBuenos.push(true);
        });
    
        if (
          inputsBuenos.length == 3
        ) {
          createEntrada(this, inputsBuenos);
        } else {
          alertError("Error", "Por favor verifique que todos los datos esten correctos.");
        }
        
      });
    }