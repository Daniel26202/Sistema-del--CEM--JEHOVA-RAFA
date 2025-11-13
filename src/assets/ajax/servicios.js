import { executePetition, alertConfirm, alertError, alertSuccess } from "./funtionExecutePetition.js";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/Consultas";

const dolar = parseFloat(document.getElementById("dolar").value);

const form = document.getElementById("modalAgregar");
const inputs = document.querySelectorAll("#modalAgregar input");

const expresiones = {
  precio: /^(\d{1,3}\.\d{3}.\d{2}|\d{1,3}.\d{2})$/,
};

const campos = {
  precio: true,
};

function validarFormulario(e) {
  switch (e.target.name) {
    case "precio":
      validarCampos(expresiones.precio, e.target, "precio");
      break;
    case "precioD":
      validarCampos(expresiones.precio, e.target, "precioD");
      break;
  }
}

const validarCampos = (expresiones, input, campo) => {
  if (expresiones.test(input.value)) {
    document.getElementById(`grp_${campo}`).classList.remove("grpFormInCorrect");
    document.getElementById(`grp_${campo}`).classList.add("grpFormCorrect");
    campos[campo] = true;
  } else {
    document.getElementById(`grp_${campo}`).classList.remove("grpFormCorrect");
    document.getElementById(`grp_${campo}`).classList.add("grpFormInCorrect");
    campos[campo] = false;
  }
  if (campos.precio === true) {
    document.getElementById("leyenda").classList.add("d-none");
  }
  if (campos.precio === false) {
    document.getElementById("leyenda").classList.remove("d-none");
  }
};

inputs.forEach((input) => {
  input.addEventListener("keyup", validarFormulario);
  input.addEventListener("input", validarFormulario);
  input.addEventListener("blur", validarFormulario);
});

if (form) {
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    if (campos.precio) {
      console.log("se envio");
      createService(form, inputs);
    } else {

      alertError("Error al enviar el formulario", "Por favor verifique que todos los datos esten correctos.");
    }
  });
}

//read

const readServices = async () => {
  try {
    let metodo = "";
    let urlActual = window.location.href;

    if (!urlActual.includes("papelera")) metodo = "consultasAjax";
    else metodo = "papeleraAjax";

    const result = await executePetition(url + "/" + metodo, "GET");
    console.log(result);

    // construir html de filas
    let html = "";
    result.forEach((element) => {
      html += `<tr>
                            <td class="text-center">
                                ${element.categoria}
                            </td>
                            <td class="text-center">
                               ${element.precio * dolar}  BS
                            </td>
                            <td class="text-center">
                                ${element.precio} $
                            </td>
                            <td class="border-start">





                                <!-- Horario Del Doctor -->
                                <div class="d-flex justify-content-center">

                                        <a href="#" class="${
                                          urlActual.includes("papelera") ? "d-none" : ""
                                        }  btn btns-accion btn-tabla me-2 btnEditarCita botonesEditarSM btnPreciosEditar btn-dt-tabla"
                                            uk-toggle="target: #modal-exampleEditar${
                                              element.id_servicioMedico
                                            }" data-id-tabla="modal-exampleEditar${
        element.id_servicioMedico
      }" uk-tooltip="Modificar Servicio  "
                                            id="btnEditarServicioMedico" data-index=${element.id_servicioMedico}>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                                class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd"
                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                            </svg>
                                        </a>


                                    <!-- Eliminar CONSULTA-->


                                        <a href="#" class="${
                                          urlActual.includes("papelera") ? "d-none" : ""
                                        }  btn btns-accion btn-tabla me-2 btn-dt-tabla btn-eliminar" data-index=${
        element.id_servicioMedico
      }>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                                class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                            </svg>
                                        </a>

                                     
                    <a href="#" class="${
                      !urlActual.includes("papelera") ? "d-none" : ""
                    } btn btn-tabla btn-dt-tabla btnRestablecer"  data-index=${
        element.id_servicioMedico
      }  title="Restablecer Paciente" uk-tooltip id="btnModalEliminarPaciente">
                      <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-arrow-counterclockwise " viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                      </svg>
                    </a>
                  

                                        
                                </div>
                                
                        <!-- Modal de editar -->
                        <div id="modal-exampleEditar${element.id_servicioMedico}" data-index="${
        element.id_servicioMedico
      }" uk-modal>
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
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                            class="bi bi-pencil-fill azul me-3 mb-3" viewBox="0 0 16 16">
                                            <path
                                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                        </svg>
                                    </div>
                                    <div class="">
                                        <p class="uk-modal-title fs-5">
                                            Editar Servicio Médico
                                        </p>
                                    </div>

                                </div>

                                <div class="alert alert-danger d-none alertaEditar" role="alert">
                                    <div class="">
                                        <p style="font-size: 12px; height:10px; " class="text-center">VERIFIQUE EL FORMULARIO
                                            ANTES DE ENVIARLO</p>
                                    </div>
                                </div>

                                <form class="form-modal formEditar forms-editar form-convercion${element.id_servicioMedico}"
                                    id="modalEditar" >

                                    <input type="hidden" class='id_usuario_bitacora' name="id_usuario">

                                    <input type="hidden" name="id_servicioMedico" value="${element.id_servicioMedico}">

                                    <div class="input-group flex-nowrap">
                                        <span class="input-modal mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                                class="bi bi-grid-1x2-fill azul" viewBox="0 0 16 16">
                                                <path
                                                    d="M0 1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V1zm0 9a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-5z" />
                                            </svg> </span>
                                        <select class="form-control input-modal" aria-label="" id="id_categoria"
                                            placeholder="id_categoria" name="id_categoria" required>

                                            <option selected disabled>
                                                ${element.categoria}

                                            </option>


                                        </select>


                                    </div>





                                    <div class="input-group flex-nowrap claseExpresiones editargrp_precio"
                                        id="editargrp_precio">
                                        <span class="input-modal mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                                class="bi bi-currency-exchange azul" viewBox="0 0 16 16">
                                                <path
                                                    d="M0 5a5.002 5.002 0 0 0 4.027 4.905 6.46 6.46 0 0 1 .544-2.073C3.695 7.536 3.132 6.864 3 5.91h-.5v-.426h.466V5.05c0-.046 0-.093.004-.135H2.5v-.427h.511C3.236 3.24 4.213 2.5 5.681 2.5c.316 0 .59.031.819.085v.733a3.46 3.46 0 0 0-.815-.082c-.919 0-1.538.466-1.734 1.252h1.917v.427h-1.98c-.003.046-.003.097-.003.147v.422h1.983v.427H3.93c.118.602.468 1.03 1.005 1.229a6.5 6.5 0 0 1 4.97-3.113A5.002 5.002 0 0 0 0 5zm16 5.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0zm-7.75 1.322c.069.835.746 1.485 1.964 1.562V14h.54v-.62c1.259-.086 1.996-.74 1.996-1.69 0-.865-.563-1.31-1.57-1.54l-.426-.1V8.374c.54.06.884.347.966.745h.948c-.07-.804-.779-1.433-1.914-1.502V7h-.54v.629c-1.076.103-1.808.732-1.808 1.622 0 .787.544 1.288 1.45 1.493l.358.085v1.78c-.554-.08-.92-.376-1.003-.787H8.25zm1.96-1.895c-.532-.12-.82-.364-.82-.732 0-.41.311-.719.824-.809v1.54h-.005zm.622 1.044c.645.145.943.38.943.796 0 .474-.37.8-1.02.86v-1.674l.077.018z" />
                                            </svg>
                                        </span>

                                        <input class="form-control input-modal precioBolivaresEditar" type="text" name="precioEditar"
                                            placeholder="Precio" required value="${element.precio * dolar}">
                                        <span class="input-modal mt-1">
                                            Bs
                                        </span>

                                    </div>
                                    <div class="d-none d-flex align-items-center justify-content-center leyendaEditar"
                                        style="font-size: 12px; margin-top: -10px; margin-bottom: 5px; ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-info-circle azul me-1" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                            <path
                                                d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                        </svg>
                                        <i>El formato del precio es incorrecto, Ejemplo 0,00 - 00,00 - 000,00 - 0.000,00 </i>
                                    </div>

                                    <!-- <div class=" d-none d-flex align-items-center justify-content-center" id="leyendaEditar" style="font-size: 12px; margin-top: -10px; margin-bottom: 5px; ">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle azul me-1" viewBox="0 0 16 16">
  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
</svg>
<i>El formato del precio es incorrecto, Ejemplo 0,00 - 00,00 - 000,00 - 0.000,00 </i>
</div> -->

                                    <div class="input-group flex-nowrap " id="editargrp_precioD">
                                        <span class="input-modal mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                                class="bi bi-currency-exchange azul" viewBox="0 0 16 16">
                                                <path
                                                    d="M0 5a5.002 5.002 0 0 0 4.027 4.905 6.46 6.46 0 0 1 .544-2.073C3.695 7.536 3.132 6.864 3 5.91h-.5v-.426h.466V5.05c0-.046 0-.093.004-.135H2.5v-.427h.511C3.236 3.24 4.213 2.5 5.681 2.5c.316 0 .59.031.819.085v.733a3.46 3.46 0 0 0-.815-.082c-.919 0-1.538.466-1.734 1.252h1.917v.427h-1.98c-.003.046-.003.097-.003.147v.422h1.983v.427H3.93c.118.602.468 1.03 1.005 1.229a6.5 6.5 0 0 1 4.97-3.113A5.002 5.002 0 0 0 0 5zm16 5.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0zm-7.75 1.322c.069.835.746 1.485 1.964 1.562V14h.54v-.62c1.259-.086 1.996-.74 1.996-1.69 0-.865-.563-1.31-1.57-1.54l-.426-.1V8.374c.54.06.884.347.966.745h.948c-.07-.804-.779-1.433-1.914-1.502V7h-.54v.629c-1.076.103-1.808.732-1.808 1.622 0 .787.544 1.288 1.45 1.493l.358.085v1.78c-.554-.08-.92-.376-1.003-.787H8.25zm1.96-1.895c-.532-.12-.82-.364-.82-.732 0-.41.311-.719.824-.809v1.54h-.005zm.622 1.044c.645.145.943.38.943.796 0 .474-.37.8-1.02.86v-1.674l.077.018z" />
                                            </svg>
                                        </span>

                                        <input class="form-control input-modal precioDolaresEditar" type="text" name="precioD" placeholder="$" required value="${
                                          element.precio
                                        }">
                                        <span class="input-modal mt-1">$</span>

                                    </div>

                                    <select class="form-control input-modal" aria-label=""
                                        name="tipo" >
                                        <option value="Cita">Cita</option>
                                        <option value="Examenes">Examenes</option>
                                    </select>






                                    <div class="mt-3 uk-text-right">
                                        <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal"
                                            type="button">Cancelar</button>
                                        <button class="btn col-3 btn-agregarcita-modal" type="submit">Editar</button>
                                    </div>
                                </form>


                            </div>
                        </div>
                            </td>
                            
                        </tr>

`;
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
        alertConfirm("Esta seguro de eliminar el servicio medico?", deleteService,data)
      });
    });

    //llamar las funciones de editar
    console.log(document.querySelectorAll(".forms-editar"));

    document.querySelectorAll(".forms-editar").forEach((formEditar) => {
      formEditar.addEventListener("submit", function (e) {
        e.preventDefault();
        let inputsBuenos = [];

        this.querySelectorAll(".input-validar").forEach((input) => {
          if (input.parentElement.classList.contains("grpFormCorrect")) inputsBuenos.push(true);
        });

        if (
          campos.precio
        ) {
          updateService(this, inputsBuenos);
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

        alertConfirm("Esta seguro de restablecer el servicio medico?", restablecerService, data)
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
//create
const createService = async (form, inputs) => {
  try {
    const data = new FormData(form);
    console.log(url + "/guardar");
    let result = await executePetition(url + "/guardar", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message)
      
      UIkit.modal("#modal-example").hide();
      form.reset();
      inputs = [];
      inputs.forEach((input) => input.parentElement.classList.remove("grpFormCorrect"));
      readServices();
    } else throw new Error(`${result.error}`);
  } catch (error) {
       alertError("Error", error);

  }
};

//update
const updateService = async (form, inputs) => {
  try {
    const data = new FormData(form);
    console.log(form);
    console.log(inputs);

    let result = await executePetition(url + "/editar", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message)
      UIkit.modal(`#${form.parentElement.parentElement.getAttribute("id")}`).hide();
      inputs = [];
      inputs.forEach((input) => input.parentElement.classList.remove("grpFormCorrect"));
      readServices();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    console.log(error);
        alertError("Error", error);

  }
};

//delete
const deleteService = async (data) => {
  try {
    const result = await executePetition(url + `/eliminar/${data}`, "GET");
    if (result.ok) {
      alertSuccess(result.message)

      readServices();
    } else throw new Error(`${result.error}`);
  } catch (error) {
        alertError("Error", error);

  }
};

// //restablecer
const restablecerService = async (data) => {
  try {
    const result = await executePetition(url + `/restablecer/${data}`, "GET");
    if (result.ok) {
      alertSuccess(result.message)
      readServices();
    } else throw new Error(`${result.error}`);
  } catch (error) {
        alertError("Error", error);

  }
};

readServices();
