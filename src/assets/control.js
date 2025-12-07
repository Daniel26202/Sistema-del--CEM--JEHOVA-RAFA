import { executePetition, alertConfirm, alertError, alertSuccess } from "./../assets/ajax/funtionExecutePetition.js";

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
const id_usuario_bitacora = document.getElementById("id_usuario_bitacora").value; // constante que guarda el id que inicio session de esa manera podemos realizar la bitacora;
const divSintomas = document.querySelector(".divSintomas");
const divPatologias = document.querySelector(".divPatologias");
const inputsExpresiones = document.querySelectorAll("#modalAgregarControl .inputExpresiones");
const inputsEdit = document.querySelectorAll("#modalEditar .input-edit");
let semaforo = 0;

let url = "/Sistema-del--CEM--JEHOVA-RAFA/Control";

//Secction the expresion regular

//objeto de las expresiones:
const expresiones = {
  cedula: /^([1-9]{1})([0-9]{5,7})$/,
  diagnostico: /^([a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,;:!?'-]{5,})$/,
  indicaciones: /^([a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,;:!?'-]{5,})$/,
  fechaRegreso: /^\d{4}\-\d{2}\-\d{2}$/,
};

const campos = {
  cedula: false,
  sintomas: false,
  doctor: false,
  diagnostico: false,
  indicaciones: false,
  fechaRegreso: false,
};
let idDU = document.querySelector("#idDExisteU");
console.log(idDU);
if (idDU) {
  campos.doctor = true;
}

const camposEditar = {
  diagnostico: true,
  indicaciones: true,
  fechaRegreso: true,
};

//validar forumlario
function validarFormularioControl(e) {
  switch (e.target.name) {
    case "cedula":
      if (expresiones.cedula.test(cedulaControl.value)) {
        cedulaControl.style.borderBottom = "2px solid rgb(13, 240, 13)";
        campos["cedula"] = true;
      } else {
        cedulaControl.style.borderBottom = "2px solid rgb(224, 3, 3)";
        campos["cedula"] = false;
      }
      break;

    case "sintomas[]":
      // recolecto los inputs
      let inputCheS = document.querySelectorAll(`.inpSin`);

      // Array.from es para convertir el html en array y el .some es para verificar(en una array) si cumple con la condición especifica; devolviendo true si es verdadero y false si es falso
      let seleccionadoS = Array.from(inputCheS).some((checkbox) => checkbox.checked);
      if (seleccionadoS) {
        campos["sintomas"] = true;
      } else {
        campos["sintomas"] = false;
      }
      break;
    case "doctor":
      if (e.target.checked) {
        campos["doctor"] = true;
      } else {
        campos["doctor"] = false;
      }

      break;
    case "diagnostico":
      validarCamposControl(expresiones.diagnostico, e.target, "diagnostico");

      break;

    case "indicaciones":
      validarCamposControl(expresiones.indicaciones, e.target, "indicaciones");

      break;
    case "fechaRegreso":
      // obtengo la hora de hoy.
      let hoy = new Date();
      // para que la hora minutos s mm este en cero, como no lo voy a usar
      hoy.setHours(0, 0, 0, 0);
      // tomo la fecha del input
      let fechaInput = document.querySelector(`.grp_control_fechaRegreso`).value;
      fechaInput = new Date(fechaInput);

      // obtengo la hora de hoy.
      let fechaMaxima = new Date();
      // actualizamos la fecha de hoy, sumándole la fecha(en este caso el año) de hoy más 50
      fechaMaxima.setFullYear(hoy.getFullYear() + 50);
      // para que la hora minutos s mm este en cero, como no lo voy a usar
      fechaMaxima.setHours(0, 0, 0, 0);

      if (
        expresiones.fechaRegreso.test(document.querySelector(`.grp_control_fechaRegreso`).value) &&
        fechaInput >= hoy &&
        fechaInput <= fechaMaxima
      ) {
        document.querySelector(`.grp_control_fechaRegreso`).style.borderBottom = "2px solid rgb(13, 240, 13)";
        document.querySelector("#leyendaFec").classList.add("d-none");

        campos["fechaRegreso"] = true;
      } else {
        document.querySelector(`.grp_control_fechaRegreso`).style.borderBottom = "2px solid rgb(224, 3, 3)";
        document.querySelector("#leyendaFec").classList.remove("d-none");

        campos["fechaRegreso"] = false;
      }
      break;
  }
}

const validarCamposControl = (expresiones, input, campo) => {
  if (expresiones.test(input.value)) {
    input.parentElement.classList.remove("grpFormInCorrectControl");
    input.parentElement.classList.add("grpFormCorrectControl");

    campos[campo] = true;
  } else {
    input.parentElement.classList.remove("grpFormCorrectControl");
    input.parentElement.classList.add("grpFormInCorrectControl");
    campos[campo] = false;
  }
};

inputsExpresiones.forEach((input) => {
  input.addEventListener("input", validarFormularioControl);
});

//expresionesedit

//función para keyup de los inputs de editar
function inputsKeyupEditar(arrayControl) {
  arrayControl.forEach((ele) => {
    ele.addEventListener("input", function (e) {
      if (e.target.name == "indicaciones") {
        if (expresiones.indicaciones.test(e.target.value)) {
          e.target.parentElement.classList.remove("grpFormInCorrectControlEditar");
          e.target.parentElement.classList.add("grpFormCorrectControlEditar");
          camposEditar["indicaciones"] = true;
        } else {
          e.target.parentElement.classList.remove("grpFormCorrectControlEditar");
          e.target.parentElement.classList.add("grpFormInCorrectControlEditar");
          camposEditar["indicaciones"] = false;
        }
      } else if (e.target.name == "fechaRegreso") {
        // obtengo la hora de hoy.
        let hoy = new Date();
        // para que la hora minutos s mm este en cero, como no lo voy a usar
        hoy.setHours(0, 0, 0, 0);
        // tomo la fecha del input
        let fechaInput = e.target.value;
        fechaInput = new Date(fechaInput);

        // obtengo la hora de hoy.
        let fechaMaxima = new Date();
        // actualizamos la fecha de hoy, sumándole la fecha(en este caso el año) de hoy más 50
        fechaMaxima.setFullYear(hoy.getFullYear() + 50);
        // para que la hora minutos s mm este en cero, como no lo voy a usar
        fechaMaxima.setHours(0, 0, 0, 0);

        if (expresiones.fechaRegreso.test(e.target.value) && fechaInput >= hoy && fechaInput <= fechaMaxima) {
          let input = e.target;
          input.classList.remove("grpFormInCorrectControlEditar");
          input.classList.add("grpFormCorrectControlEditar");

          // selecciono el padre del input
          let div = input.parentElement;
          // selecciono el hermano del div (en donde esta el texto de alerta)
          let divD = div.nextElementSibling;

          divD.classList.add("d-none");
          camposEditar["fechaRegreso"] = true;
        } else {
          let input = e.target;
          input.classList.remove("grpFormCorrectControlEditar");
          input.classList.add("grpFormInCorrectControlEditar");
          // selecciono el padre del input
          let div = input.parentElement;
          // selecciono el hermano del div (en donde esta el texto de alerta)
          let divD = div.nextElementSibling;

          divD.classList.remove("d-none");
          camposEditar["fechaRegreso"] = false;
        }
      }
    });
  });
}



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
        row.style.backgroundColor = background == "var(--color-primary)" ? "" : "var(--color-primary)";

        let cedula = this.closest("tr").children[0].innerText;
        document.getElementById("cedulaPE").value = cedula;
        readControl(cedula);
      });
    });
  } catch (error) {
    alertError("Error", error);
  }
};

const returnFragmentControl = async (data, element, index, disabled) => {
  let sintomas = await executePetition(url + "/mostrarSP/" + element.id_control, "GET");
  let patologias = await executePetition(url + "/mostrarPP/" + element.id_control, "GET");

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

const returnFrangmentCheckbox = (nameInput, element, checked = false) => {
  let fragment = "";

  console.log(element);
  fragment = `                        
                                          <div class="form-check form-switch d-flex align-items-center">
                                              <div>
                                                  <input class="form-check-input inputExpresiones inpSin" type="checkbox" role="switch" id="flexSwitchCheckDefault" checked=${checked} disabled name=${nameInput} value="16">
                                              </div>
                                              <div>
                                                  <label class="form-check-label mt-1 for=" flexswitchcheckdefault"="">
                                                      ${element}                                              </label>
                                              </div>
  
                                          </div>  `;

  return fragment;
};

//function for add control medico in table
const readControl = async (cedulaPatient) => {
  if (semaforo === 1) return;
  semaforo = 1;
  try {
    loaderControlMedico.classList.remove("d-none");
    let result = await executePetition(url + "/mostrarControlPacientesJS/" + cedulaPatient, "GET");
    let html = "";
    tbodyControl.innerHTML = ``;
    let index = 0;
    
    for (const element of result[0]) {
      console.log(element);
      console.log(result[0].length);
      console.log(result[0]);
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
    document.querySelectorAll(".buttomEditControl").forEach((element) => {
      element.addEventListener("click", function (e) {
        showDataPatient(this.getAttribute("data-id-control"), result);
        inputsKeyupEditar(inputsEdit);
        document.getElementById("idCE").value = this.getAttribute("data-id-control");
        document.getElementById("idPac").value = this.getAttribute("data-id-Patient");
      });
    });
    semaforo = 0;
  } catch (error) {
    console.error("hola el error es :" + error);
    alertError("Error", error);
    semaforo = 0;
  } finally {
    loaderControlMedico.classList.add("d-none");
  }
};

const dataPatientModal = async (cedula) => {
  try {
    let result = await executePetition(url + "/mostrarPacienteJS/" + cedula, "GET");

    if (result.length > 0) {
      result.forEach((res) => {
        // calcula la edad
        const fechaNac = new Date(res.fn);
        const edadDif = Date.now() - fechaNac.getTime();
        const edadFecha = new Date(edadDif);
        edad.innerText = `Edad: ${Math.abs(edadFecha.getUTCFullYear() - 1970)}`;
        dataPatient.innerText = `Patient: ${res.nombre} ${res.apellido}`;
        idPatient.value = res.id_paciente;
      });
      showPatient.classList.remove("d-none");
      btnAC.classList.remove("d-none");
      contentF.classList.remove("d-none");
      mandarAddPatient.classList.add("d-none");
      Not_Patient.innerText = "";
    } else {
      showPatient.classList.add("d-none");
      btnAC.classList.add("d-none");
      contentF.classList.add("d-none");
      mandarAddPatient.classList.remove("d-none");
      Not_Patient.innerText = `NO SE ENCONTRÓ AL PACIENTE, PRESIONE CLIC AQUÍ PARA REGISTRAR`;
    }
  } catch (error) {
    console.log("error function dataPatientModal" + error);
    alertError("Error", error);
  }
};

//function for save the control
const saveControl = async () => {
  try {
    const data = new FormData(modalAddControl);
    let result = await executePetition(url + "/insertarControl", "POST", data);

    readControl(result.data.cedula);

    alertSuccess(result.message);
  } catch (error) {
    alertError("Error", error);
  }
};

//function for edit the control
const editControl = async () => {
  try {
    const data = new FormData(modalEditControl);
    let result = await executePetition(url + "/editarControl", "POST", data);

     readControl(result.data.cedula);

     alertSuccess(result.message);
  } catch (error) {
    alertError("Error", error);
  }
};


//function for show the data the patient in edit
const showDataPatient = async (idControl, data) => {
  let dataControl = data[0].find((element) => element.id_control == idControl);
  let sintomas = await executePetition(url + "/mostrarSP/" + dataControl.id_control, "GET");
  let patologias = await executePetition(url + "/mostrarPP/" + dataControl.id_control, "GET");

  console.log(dataControl);
  console.log(data);

  showDataPatientEdit[0].value = id_usuario_bitacora;
  showDataPatientEdit[1].value = dataControl.id_control;
  showDataPatientEdit[2].value = dataControl.cedula;
  showDataPatientEdit[3].value = dataControl.id_paciente;
  showDataPatientEdit[4].innerText = dataControl.nota;
  showDataPatientEdit[5].innerText = dataControl.medicamentosRecetados;
  showDataPatientEdit[6].value = dataControl.fechaRegreso;
  showDataPatientEdit[7].innerText = dataControl.historiaclinica;

  let htmlSintomas = "";
  let htmlPatologias = "";

  sintomas.forEach((element) => {
    htmlSintomas += returnFrangmentCheckbox("sintomas[]", element.nombreS, true);
  });

  patologias.forEach((element) => {
    htmlPatologias += returnFrangmentCheckbox("patologias[]", element.nombre_patologia, true);
  });

  divSintomas.innerHTML = htmlSintomas;

  divPatologias.innerHTML = htmlPatologias;
};

readPatients();

cedulaControl.addEventListener("keyup", function () {
  dataPatientModal(this.value);
});

modalAddControl.addEventListener("submit", function (e) {
  e.preventDefault();
  if (campos.cedula && campos.sintomas && campos.doctor && campos.diagnostico && campos.indicaciones && campos.fechaRegreso) {
    UIkit.modal("#modal-examplecontrol").hide();
    saveControl();
    modalAgregarControl.reset();
    document.querySelectorAll(`#modalAgregarControl .input-modal-remove`).forEach((ele) => {
      if (ele.parentElement.classList.contains("grpFormCorrectControl")) {
        ele.parentElement.classList.remove("grpFormCorrectControl");
      } else {
        ele.setAttribute("style", "");
      }
    });
  } else {
    alertError("Error al enviar el formulario", "Por favor verifique el formulario antes de enviarlo");
  }
});

modalEditControl.addEventListener("submit", function (e) {
  e.preventDefault();

  if (camposEditar.indicaciones && camposEditar.fechaRegreso) {
    UIkit.modal("#modal-examplecontroleditar").hide();
    editControl();
    modalEditControl.reset();
    document.querySelectorAll(`#modalAgregarControl .input-modal-remove`).forEach((ele) => {
      if (ele.parentElement.classList.contains("grpFormCorrectControl")) {
        ele.parentElement.classList.remove("grpFormCorrectControl");
      } else {
        ele.setAttribute("style", "");
      }
    });
  } else {
        alertError("Error al enviar el formulario", "Por favor verifique el formulario antes de enviarlo");

  }
});

// para el buscador de Sintomas
let inputBuscS = document.querySelector("#inputBuscarS");
const notifi = document.querySelector(".notifi");

// buscador de sintomas
function buscarS() {
  let contadorS = 0;
  let contadorSNo = 0;

  // selecciono todos los tr de la tabla
  const filas = document.querySelectorAll(".tbodyS tr");
  // recolecto el nombre del input
  let nombreInS = inputBuscS.value;
  // se convierte en minúscula
  nombreInS = nombreInS.toLowerCase();

  // recorro las filas de la tabla
  filas.forEach((fila) => {
    // cuenta los síntomas que existen.
    contadorS = contadorS + 1;

    let nombre = fila.children[1].innerText;

    // se convierte en minúscula
    nombre = nombre.toLowerCase();
    // verifico si el nombre existe
    if (nombre.includes(nombreInS)) {
      fila.classList.remove("d-none");
      notifi.classList.add("d-none");
    } else {
      fila.classList.add("d-none");
      // cuenta las veces que no encuentra un síntoma
      contadorSNo = contadorSNo + 1;
    }
  });

  // verifica, si el contador de hospitalizaciones existentes es igual a las hospitalizaciones no existentes
  if (contadorS === contadorSNo) {
    // muestra el texto.
    notifi.classList.remove("d-none");
  }
}

inputBuscS.addEventListener("keyup", () => {
  buscarS();
});

let btnNin = document.querySelector(".btnNin");

btnNin.addEventListener("click", function () {
  document.querySelectorAll(".checkInputs").forEach((checkbox) => (checkbox.checked = false));
});
