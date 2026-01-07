import { executePetition, alertConfirm, alertError, alertSuccess, initDataTable } from "./funtionGeneric.js";

import { inicializarValidacionFormulario } from "../js/expresionesModulares.js";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/Pacientes";

const modalAgregar = document.getElementById("modalAgregar");
const exampleModalLabel = document.getElementById("exampleModalLabelPaciente");
const selectGenero = document.getElementById("selectGenero");
const inputs = document.querySelectorAll(".input-validar");
const botonModal = document.getElementById("botonModal");
const cedulaRegistrada = document.getElementById("cedulaRegistrada");
const btnOpenModal = document.getElementById("btnOpenModal");
const id_paciente = document.getElementById("id_paciente");
const selector = ".exampleTable";

//read
const readPatients = async () => {
  try {
    let metodo = "";
    let urlActual = window.location.href;

    if (urlActual.includes("getPacientes")) metodo = "getPacientesAjax";
    else metodo = "papeleraPacienteAjax";

    const result = await executePetition(url + "/" + metodo, "GET");

    console.log(result);

    // construir html de filas
    let html = "";
    result.forEach((element) => {
      html += `
                      <tr>
                    <td class="text-center">${element.nacionalidad}-${element.cedula}</td>
                    <td class="text-center">${element.nombre}</td>
                    <td class="text-center">${element.apellido}</td>
                    <td class="text-center">${element.telefono}</td>
                    <td class="text-center">${element.direccion}</td>
                    <td class="text-center">${element.fn}</td>
                    <td class="text-center">${element.genero}</td>
                    <td class="text-center">${element.estado_salud}</td>
                    <td class="text-center">
                            <button class="${
                              !urlActual.includes("getPacientes") ? "d-none" : ""
                            } btn btn-tabla mb-1 btn-js editar botonesEdi btnModalEditarPaciente btn-dt-tabla"
                              data-bs-toggle="modal" data-bs-target="#exampleModalagregarPaciente" data-index="${
                                element.id_paciente
                              }">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                </svg>

                            </button>

                            <button class="${
                              !urlActual.includes("getPacientes") ? "d-none" : ""
                            } btn btn-tabla mb-1 btnModalEliminarPaciente btn-dt-tabla btn-eliminar" data-index=${
        element.id_paciente
      }>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                </svg>
                            </button>

                            <div class="me-2">
                    <a href="#" class="${
                      urlActual.includes("getPacientes") ? "d-none" : ""
                    } btn btn-tabla btn-dt-tabla btnRestablecer"  data-index=${
        element.id_paciente
      }  title="Restablecer Paciente" uk-tooltip id="btnModalEliminarPaciente">
                      <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-arrow-counterclockwise " viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                      </svg>
                    </a>
                  </div>

                        </div>
                    </td>
                </tr>
          `;
    });

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
        alertConfirm("Esta seguro de eliminar el paciente?", deletePattients, data);
      });
    });


    //llamar a la uncion de restablecer
    document.querySelectorAll(".btnRestablecer").forEach((btn) => {
      btn.addEventListener("click", function () {
        const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];
        alertConfirm("Esta seguro de restablecer el paciente?", restablecerPattients, data);
      });
    });

    //llamar las funcion de eliminar
    document.querySelectorAll(".botonesEdi").forEach((btn) => {
      btn.addEventListener("click", function () {
        showDataEdit(this, btn.getAttribute("data-index"));
      });
    });

    // re-inicializa
    initDataTable(selector);
  } catch (error) {
    alertError("Error", error);
  }
};
//create
const createPatients = async (form, inputs) => {
  try {
    const data = new FormData(form);
    let result = await executePetition(url + "/guardar", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);
      form.reset();
      inputs = [];
      inputs.forEach((input) => input.parentElement.classList.remove("valido"));
      readPatients();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//update
const updatePatients = async (form, inputs) => {
  try {
    const data = new FormData(form);

    let result = await executePetition(url + "/setPaciente", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);

      inputs = [];
      inputs.forEach((input) => input.parentElement.classList.remove("grpFormCorrect"));

      readPatients();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    console.log(error);
    alertError("Error", error);
  }
};

//delete
const deletePattients = async (data) => {
  try {
    const result = await executePetition(url + `/eliminar/${data}`, "GET");
    console.log(result);

    if (result.ok) {
      alertSuccess(result.message);
      readPatients();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//restablecer
const restablecerPattients = async (data) => {
  try {
    const result = await executePetition(url + `/restablecer/${data}`, "GET");
    if (result.ok) {
      alertSuccess(result.message);

      readPatients();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//mostrar datos a editat
const showDataEdit = (ele, id) => {
  exampleModalLabel.textContent = "Modificar Paciente";
  botonModal.textContent = "Modificar";
  modalAgregar.classList.add("editar");

  let rows = ele.closest("tr");
  let cells = rows.children;

  for (const key in cells) {
    const element = cells[key];

    if (key == 7) break;

    inputs[key].value = element.innerText;

    inputs[key].parentElement.classList.add("valido");

    console.log(element)
  }

  let cedula = inputs[0].value.slice(2);

  inputs[0].value = cedula;
  cedulaRegistrada.value = cedula;

  id_paciente.value = id;
};

const clearModalEnviar = () => {
  exampleModalLabel.textContent = "Registrar Paciente";
  botonModal.textContent = "Registrar";
  modalAgregar.classList.remove("editar");

  inputs.forEach((input) => {
    input.value = "";
    input.parentElement.classList.remove("valido");
  });
};

readPatients();

btnOpenModal.addEventListener("click", function () {
  clearModalEnviar();
});



let verificarFormulario = inicializarValidacionFormulario(modalAgregar);

modalAgregar.addEventListener("submit", function (e) {
  e.preventDefault();

  let inputsBuenos = [];
  this.querySelectorAll(".input-validar").forEach((input) => {
    if (input.parentElement.classList.contains("valido")) inputsBuenos.push(true);
  });

  let esValido = verificarFormulario();

  if (esValido) {
          if (modalAgregar.classList.contains("editar")) {
            updatePatients(this, inputsBuenos);
          } else {
            createPatients(this, inputsBuenos);
          }
  } else {
    alertError("Error", "Por favor verifique que todos los datos estén correctos.");
  }
});
