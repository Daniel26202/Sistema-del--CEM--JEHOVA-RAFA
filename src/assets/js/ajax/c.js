import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
} from "../generic/funtionGeneric.js";

import { inicializarValidacionFormulario } from "../generic/expresionesModulares.js";

const inputPaciente = document.getElementById("inputPaciente");
const inputEdad = document.getElementById("inputEdad");
const divDataPaciente = document.getElementById("div-data-paciente");
const inputIdPaciente = document.getElementById("id_paciente");
const divBtnAddPat = document.getElementById("div-btn-add-pat");

const tbodyControl = document.getElementById("tbody-control");
const tbodyPatients = document.getElementById("tbody-pacientes");
const textStartControl = document.getElementById("text-start");
const loaderControlMedico = document.getElementById("loader-control-medico");
const modalAddControl = document.getElementById("modalAgregarControl"); //modal control
const modalEditControl = document.getElementById("modalEditar");
const cedulaControl = document.getElementById("cedulaControl"); //input cedula
const showPatient = document.getElementById("mostrarPaciente");
const btnAC = document.getElementById("btnAC");
const contentF = document.getElementById("contenedorF");
const mandarAddPatient = document.getElementById("mandarRegistrarPaciente");
const Not_Patient = document.getElementById("No_paciente");
console.log(Not_Patient);
const edad = document.getElementById("edad");
const dataPatient = document.getElementById("datosPaciente");
const idPatient = document.getElementById("idPaciente");
const alertControl = document.getElementById("alert-control");
const showDataPatientEdit = document.querySelectorAll(".showDataPatientEdit");
const id_usuario_bitacora = document.getElementById(
  "id_usuario_bitacora",
).value; // constante que guarda el id que inicio session de esa manera podemos realizar la bitacora;
const divSintomas = document.querySelector(".divSintomas");
const divPatologias = document.querySelector(".divPatologias");
const inputsExpresiones = document.querySelectorAll(
  "#modalAgregarControl .inputExpresiones",
);
const inputsEdit = document.querySelectorAll("#modalEditar .input-edit");
let semaforo = 0;

let url = "/Sistema-del--CEM--JEHOVA-RAFA/Control";

const traerPaciente = async () => {
  try {
    let [addClass, removeClass] = ["", ""];
    if (cedulaControl.value.length == 7 || cedulaControl.value.length == 8) {
      const result = await executePetition(
        `/Sistema-del--CEM--JEHOVA-RAFA/Control/mostrarPacienteJS/${nacionalidadCita.value}/${cedulaControl.value}`,
        "GET",
      );
      
      let edad = "";
       if (result.fn) {
        const fechaNacimiento = new Date(result.fn);
        const fechaActual = new Date();
        edad = fechaActual.getFullYear() - fechaNacimiento.getFullYear();
        const mes = fechaActual.getMonth() - fechaNacimiento.getMonth();
        if (mes < 0 || (mes === 0 && fechaActual.getDate() < fechaNacimiento.getDate())) {
          edad--;
        }
      }

      if (result != []) {
        inputPaciente.value = result.nombre + " " + result.apellido;
        inputEdad.value = edad+" años";
        inputIdPaciente.value = result.id_paciente;
        [addClass, removeClass] = ["valido", "invalido"];
        divDataPaciente.classList.remove("d-none");
        divBtnAddPat.classList.add("d-none");
      } else {
        inputPaciente.value = "Paciente no encontrado";
        inputEdad.value = "Edad no encontrado";
        inputIdPaciente.value = 0;
        [addClass, removeClass] = ["invalido", "valido"];
        divDataPaciente.classList.add("d-none");
        //hacer que aparesca la caja que contine el boton para abrir el modal de agregar paciente
        divBtnAddPat.classList.remove("d-none");
        modalFooter.classList.add("d-none");
      }
    } else {
      divDataPaciente.classList.add("d-none");
    }
  } catch (error) {
    alertError("Error", "Lamentablemente algo salió mal. " + error);
  }
};

const returnFragmentControl = async (data, element, index, disabled) => {
  let sintomas = await executePetition(
    url + "/mostrarSP/" + element.id_control,
    "GET",
  );
  let patologias = await executePetition(
    url + "/mostrarPP/" + element.id_control,
    "GET",
  );

  let sintomasText = sintomas.map((e) => e.nombreS).join(", ");
  let patologiasText = patologias.map((e) => e.nombre_patologia).join(", ");

  let fragment;
  if (data.length > 0) {
    fragment = `
              <tr>
                              <td>${element.fecha_control.split(" ")[0]}</td>
                              <td>${element.fechaRegreso}</td>
                              <td>
                                  <button class="btn col-3 btn-agregarcita-modal editar btnEditar buttomEditControl" type="button"
                                      uk-toggle="target: #modal-examplecontroleditar" data-id-control="${element.id_control}" 
                                      data-id-Patient="${
                                        element.id_Patient
                                      }" ${disabled}><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                          class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                          <path
                                              d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                      </svg></button>
  
                                  <button class="btn col-3 btn-agregarcita-modal" type="button" data-bs-toggle="collapse" data-bs-target="#desc${index}" aria-expanded="false" aria-controls="desc${index}">
  
                                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                          <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
                                      </svg>
  
                                  </button>
                              </td>
                          </tr>
                          <!-- Fila oculta que se despliega como acordeón -->
                          <tr class="collapse-row">
                              <td colspan="5">
                                  <div class="collapse " id="desc${index}">
                                      <div class="card card-body fila-oculta text-white div-descripcion-oculto">
                                      <h5><b class="me-1">Diagnostico:</b></h5>
                                      <p>${element.diagnostico}</p>
  
                                      <h5><b class="me-1">Indicaciones:</b></h5>
                                      <p>${element.medicamentosRecetados}</p>
                                          
                                      <h5><b class="me-1">Historia clínica:</b></h5>
                                      <p>${element.historiaclinica}</p>

                                      <h5><b class="me-1">Síntomas:</b></h5>
                                      <p>${sintomasText}</p>
                                      
                                      <h5><b class="me-1">Patología:</b></h5>
                                      <p>${patologiasText}</p>
                                      
                                  </div>
                              </td>
                          </tr>`;
  } else {
    fragment = `<tr class="collapse-row">
                              <td colspan="5">
                                  <div class="text-center">
                                      No se encontraron resultados.
                                  </div>
                              </td>
                          </tr>`;
  }
  return fragment;
};

//function for add Patients in table
const readPatients = async () => {
  try {
    let result = await executePetition(url + "/listPacientesJS", "GET");
    let html = "";
    result.forEach((element) => {
      html += `
                          <tr class="row-Patients">
                              <td>${element.cedula}</td>
                              <td>${element.nombre}</td>
                              <td>${element.fn}</td>
                              <td>${element.genero}</td>
                          </tr>
              `;
    });
    tbodyPatients.innerHTML = html;

    //Bucle and Event for selected the Patient and the control medico
    document.querySelectorAll(".row-Patients").forEach((row) => {
      row.addEventListener("click", function () {
        let background = row.style.backgroundColor;
        document.querySelectorAll(".row-Patients").forEach((row) => {
          row.style.backgroundColor = "";
        });
        row.style.backgroundColor =
          background == "var(--color-primary)" ? "" : "var(--color-primary)";

        let cedula = this.closest("tr").children[0].innerText;
        readControl(cedula);
      });
    });
  } catch (error) {
    alertError("Error", error);
  }
};

//function for add control medico in table
const readControl = async (cedulaPatient) => {
  if (semaforo === 1) return;
  semaforo = 1;
  try {
    loaderControlMedico.classList.remove("d-none");
    let result = await executePetition(
      url + "/mostrarControlPacientesJS/" + cedulaPatient,
      "GET",
    );
    let html = "";
    tbodyControl.innerHTML = ``;
    let index = 0;

    for (const element of result[0]) {
      let disabled = "disabled";
      if (index == result[0].length - 1) {
        disabled = "";
      }
      html += await returnFragmentControl(result[0], element, index, disabled);
      tbodyControl.parentElement.classList.remove("d-none");
      textStartControl.classList.add("d-none");
      index++;
    }

    tbodyControl.innerHTML = html;
    // document.querySelectorAll(".buttomEditControl").forEach((element) => {
    //   element.addEventListener("click", function (e) {
    //     showDataPatient(this.getAttribute("data-id-control"), result);
    //     inputsKeyupEditar(inputsEdit);
    //     document.getElementById("idCE").value = this.getAttribute("data-id-control");
    //     document.getElementById("idPac").value = this.getAttribute("data-id-Patient");
    //   });
    // });
    semaforo = 0;
  } catch (error) {
    console.error("hola el error es :" + error);
    alertError("Error", error);
    semaforo = 0;
  } finally {
    loaderControlMedico.classList.add("d-none");
  }
};

readPatients();

cedulaControl.addEventListener("keyup", function () {
  console.log(cedulaControl);
  traerPaciente();
});

let verificarFormulario = inicializarValidacionFormulario(modalAddControl);
