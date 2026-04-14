import {
  executePetition,
  alertError,
  alertSuccess,
  searchElements,
  initDataTable,
  alertConfirm,
  hasPermision,
  clearModalEnviar,
  initLoaderButton,
  finallyLoaderButton,
} from "../generic/funtionGeneric.js";

import { inicializarValidacionFormulario } from "../generic/expresionesModulares.js";

const modalControlBoots = new bootstrap.Modal(
  document.getElementById("exampleModalAgregarControl"),
);

const modalSintomaBoots = new bootstrap.Modal(
  document.getElementById("exampleModalAgregarSintoma"),
);

const modalReadSintomaBoots = new bootstrap.Modal(
  document.getElementById("exampleModalConsultarSintoma"),
);

const modalPaciente = new bootstrap.Modal(
  document.getElementById("exampleModalagregarPaciente"),
);

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
const cedulaControl = document.getElementById("cedulaControl"); //input cedula
const Not_Patient = document.getElementById("No_paciente");
console.log(Not_Patient);
const divSintomasParent = document.getElementById("div-sintomas");
const divSintomas = document.getElementById("divSintomas");
const divPatologiasParent = document.getElementById("div-patologias");
const divPatologias = document.getElementById("divPatologias");
const divDoctores = document.getElementById("divDoctores");

const modalFooter = document.getElementById("modal-footer");

const modalTitleControl = document.getElementById("modalTitleControl");
const botonModal = document.getElementById("botonModal");
const inputIdControl = document.getElementById("id_control");
const boxDoctor = document.getElementById("div-doc");
const btnControl = document.getElementById("btnControl");
const inputs = modalAddControl.querySelectorAll(".input-validar");
const buscarDoctores = document.getElementById("buscarDoctores");
const buscarPatologias = document.getElementById("buscarPatologias");
const buscarSintomas = document.getElementById("buscarSintomas");
const modalAgregarSintoma = document.getElementById("modalAgregarSintoma");

const modalAgregarPaciente = document.getElementById("modalAgregar");
const cedulaPaciente = document.getElementById("cedulaPaciente");
const btnOpenModalPac = document.getElementById("btnOpenModalPac");
const nota = document.getElementById("nota");
const selectorPacietne = ".examplePaciente";

const id_rol_global = document.getElementById("id_rol_global").value;


///categoria///
const openModalSintomas = document.getElementById(
  "openModalSintomas",
);
const inputsSintimo = modalAgregarSintoma.querySelectorAll(".input-validar");
const exampleModalLabel = document.getElementById("exampleModalLabelPaciente");
const botonModalSintomas = document.getElementById('botonModalSintomas');

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

      console.log(result);
      let edad = "";
      if (result.fn) {
        const fechaNacimiento = new Date(result.fn);
        const fechaActual = new Date();
        edad = fechaActual.getFullYear() - fechaNacimiento.getFullYear();
        const mes = fechaActual.getMonth() - fechaNacimiento.getMonth();
        if (
          mes < 0 ||
          (mes === 0 && fechaActual.getDate() < fechaNacimiento.getDate())
        ) {
          edad--;
        }
      }

      if (result != []) {
        inputPaciente.value = result.nombre + " " + result.apellido;
        inputEdad.value = edad + " años";
        inputIdPaciente.value = result.id_paciente;
        [addClass, removeClass] = ["valido", "invalido"];
        divDataPaciente.classList.remove("d-none");
        divBtnAddPat.classList.add("d-none");
        modalFooter.classList.remove("d-none");

        // //llamar a la funcion para traer los sintomas y patologias del paciente
        traerDoctorSintomasPatologias();

        // //llamar a la funcion para traer a los doctores disponibles

        traerDoctores();
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

const traerDoctorSintomasPatologias = async () => {
  try {
    const sintomas = await executePetition(
      url + "/returnSistomasPaciente/",
      "GET",
    );
    const patologias = await executePetition(
      url + "/returnPatologiasPaciente/",
      "GET",
    );
    console.log(sintomas, patologias);

    let htmlSintomas = ``;
    let htmlPatologias = ``;

    if (sintomas.length > 0) {
      sintomas.forEach((res) => {
        htmlSintomas += `<div class="form-check form-switch d-flex align-items-center">
    <div class="form-check-sintomas">
        <input value="${res.id_sintomas}" name="sintomas[]" class="form-check-input check-sintomas" type="checkbox" value="${res.id_sintomas}" id="checkChecked${res.id_sintomas}">
        <label class="form-check-label-sintomas" for="checkChecked${res.id_sintomas}">
            ${res.nombre}
        </label>
    </div>
</div>`;
      });
    }
    if (patologias.length > 0) {
      patologias.forEach((res) => {
        htmlPatologias += `<div class="form-check form-switch d-flex align-items-center">
    <div class="form-check-patologias">
        <input value="${res.id_patologia}" name="patologias[]" class="form-check-input check-patologias" type="checkbox" value="${res.id_patologia}" id="checkChecked${res.id_patologia}">
        <label class="form-check-label-patologias" for="checkChecked${res.id_patologia}">
            ${res.nombre_patologia}
        </label>
    </div>
</div>`;
      });
    }

    divSintomas.innerHTML = htmlSintomas;
    divPatologias.innerHTML = htmlPatologias;

    checkedCheckboxes(
      document.querySelectorAll(".check-patologias:checked"),
      "mostrarPP/",
      cedulaControl.value,
    );
  } catch (error) {
    alertError("Error", "Lamentablemente algo salió mal. " + error);
  }
};

const traerDoctores = async () => {
  try {
    const doctores = await executePetition(url + "/returnDoctores/", "GET");

    let htmlDoctores = ``;

    if (doctores.length > 0) {
      doctores.forEach((res, index) => {
        htmlDoctores += `<div class="contenido card cards-horario" data-index=${index} id=${res.id_usuario} selection=false >
            <input type='hidden' class="valorDoctor" >
            <h5 style="font-size: 15;" class="text-center text-doctor">DR ${res.nombredoc} ${res.apellidodoc}</h5>
          </div>`;
      });
    }
    divDoctores.innerHTML = htmlDoctores;

    document.querySelectorAll(".cards-horario").forEach((card) => {
      card.addEventListener("click", function () {
        //aparecer el boton de guardar
        modalFooter.classList.remove("d-none");

        let dataIndex = this.getAttribute("data-index");
        let id = this.getAttribute("id");

        document.querySelectorAll(".cards-horario").forEach((card2) => {
          let input = card2.children[0];
          if (card2.getAttribute("data-index") == dataIndex) {
            console.log("se tecleo este input");
            console.log(card2.children[0]);
            card2.style.backgroundColor = "#387adf";
            input.value = id;
            input.setAttribute("name", "doctor");
          } else {
            console.log("los demas se quito es estile");
            console.log(card2.children[0]);
            card2.style.backgroundColor = "";
            input.value = 0;
            input.setAttribute("name", "");
          }
        });
      });
    });
  } catch (error) {
    alertError("Error", "Lamentablemente algo salió mal. " + error);
  }
};

const checkedCheckboxes = async (
  checkboxes,
  metodo,
  cedula,
  editar = false,
) => {
  try {
    const result = await executePetition(`${url}/${metodo}/${cedula}`, "GET");
    const ids = Array.from(checkboxes).map((checkbox) => checkbox.value);

    console.log(result);

    if (result.length > 0) {
      result.forEach((res) => {
        if (!ids.includes(res.id_sintoma || res.id_patologia)) {
          document.getElementById(
            `checkChecked${res.id_sintoma || res.id_patologia}`,
          ).checked = true;
          editar &&
            document
              .getElementById(
                `checkChecked${res.id_sintoma || res.id_patologia}`,
              )
              .setAttribute("disabled", true);
        }
      });
    }
  } catch (error) {
    alertError("Error", "Lamentablemente algo salió mal... " + error);
  }
};

const returnFragmentControl = async (data, element, index, disabled) => {
  let sintomas = await executePetition(
    url + "/mostrarSPAll/" + element.id_control,
    "GET",
  );
  let patologias = await executePetition(
    url + "/mostrarPPAll/" + element.id_control,
    "GET",
  );

  let sintomasText = sintomas.map((e) => e.nombreS).join(", ");
  let patologiasText = patologias.map((e) => e.nombre_patologia).join(", ");

  let fragment;
  fragment = `
              <tr>
                              <td>${element.fecha_control.split(" ")[0]}</td>
                              <td>${element.fechaRegreso}</td>
                              <td>
                                  <button class="btn col-3 btn-agregarcita-modal editar btnEditar buttomEditControl" type="button"
                                      data-bs-toggle="modal" data-bs-target="#exampleModalagregarControl" 
                                      data-id-Patient="${element.id_Patient
    }" data-cedula=${element.cedula} data-control=${element.id_control} ${disabled}><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
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

                                      <h5><b class="me-1">Nota:</b></h5>
                                      <p>${element.nota}</p>
                                      
                                  </div>
                              </td>
                          </tr>`;

  return fragment;
};

const showDataModalEdit = (ele, cedula, id_control) => {

  //ocultar patologias y sintomas
  divPatologiasParent.classList.add("d-none");
  divSintomasParent.classList.add("d-none");

  modalTitleControl.innerText = "Modificar Control";
  botonModal.innerText = "Modificar";
  modalAddControl.classList.add("editar");
  inputIdControl.value = id_control;
  boxDoctor.classList.add("d-none");

  cedulaControl.setAttribute("disabled", true);

  const tds = ele.closest("tr").children;
  const divInfoControl = document.querySelector(
    tds[2].children[1].getAttribute("data-bs-target"),
  );
  const divDataControl = divInfoControl.children[0].children;

  //darvalores a los inputs del modal
  cedulaControl.value = cedula;
  inputs[1].value = divDataControl[1].innerText;
  inputs[2].value = divDataControl[3].innerText;
  inputs[3].value = divDataControl[5].innerText;
  nota.value = divDataControl[11].innerText;
  inputs[4].value = tds[1].innerText;
  //disparar la validacion de los inputs
  inputs.forEach((input) => {
    input.dispatchEvent(new Event("keyup", { bubbles: true }));
  });
};

const clickButtonOpenModal = () => {
  //aparecer las patologias y sintomas
  divPatologiasParent.classList.remove("d-none");
  divSintomasParent.classList.remove("d-none");

  cedulaControl.removeAttribute("disabled");
  modalTitleControl.innerText = "Nuevo Control";
  botonModal.innerText = "Registrar";
  modalAddControl.classList.remove("editar");
  boxDoctor.classList.remove("d-none");

  inputs.forEach((input) => {
    input.value = "";
    input.dispatchEvent(new Event("keyup", { bubbles: true }));
    input.parentElement.classList.remove("valido");
    input.parentElement.classList.remove("invalido");

    //icons de error y de check
    input.nextElementSibling.children[0].classList.add("d-none");
    input.nextElementSibling.children[1].classList.add("d-none");

    //p con el texto de error
    input.parentElement.parentElement.children[1].classList.add("d-none");
    console.log(input.parentElement.parentElement);
  });
};

//function for add Patients in table
const readPatients = async () => {
  try {
    let result = await executePetition(url + "/listPacientesJS", "GET");
    let html = "";
    if (result.length > 0) {
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
    } else {
      html = `<tr class="collapse-row">
                              <td colspan="5">
                                  <div class="text-center">
                                      No se encontraron resultados.
                                  </div>
                              </td>
                          </tr>`;
    }
    // si ya existe DataTable, destrúyela
    if ($.fn.DataTable.isDataTable(selectorPacietne)) {
      $(selectorPacietne).DataTable().clear().destroy();
    }

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

    //////gestionar persmisos
    hasPermision(id_rol_global, "Control", "guardar", ".btnOpenModal"); //guardar

    initDataTable(selectorPacietne);
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
    console.log("readControl", result);
    let html = "";
    tbodyControl.innerHTML = ``;
    let index = 0;
    if (result[0].length > 0)
      for (const element of result[0]) {
        let disabled = "disabled";
        if (index == result[0].length - 1) {
          disabled = "";
        }

        html += await returnFragmentControl(
          result[0],
          element,
          index,
          disabled,
        );
        tbodyControl.parentElement.classList.remove("d-none");
        textStartControl.classList.add("d-none");
        index++;
      }
    else {
      html = `<tr class="collapse-row">
                              <td colspan="5">
                                  <div class="text-center">
                                      No se encontraron resultados.
                                  </div>
                              </td>
                          </tr>`;
    }

    tbodyControl.innerHTML = html;

    //aqui es dondeseva a ejecutar la funcionarlidarde llenar con los datosal presionar elboton de editar

    document.querySelectorAll(".buttomEditControl").forEach((btn) => {
      btn.addEventListener("click", function (e) {
        showDataModalEdit(
          btn,
          btn.getAttribute("data-cedula"),
          btn.getAttribute("data-control"),
        );
      });
    });

    semaforo = 0;

    hasPermision(id_rol_global, "Control", "guardar", ".btnOpenModalSin"); //guardar sintomas
    hasPermision(id_rol_global, "Control", "editar", ".buttomEditControl"); //editar

  } catch (error) {
    console.error("hola el error es :" + error);
    alertError("Error", error);
    semaforo = 0;
  } finally {
    loaderControlMedico.classList.add("d-none");
  }
};

//function for save the control
const createControl = async () => {
  try {
    initLoaderButton(botonModal)
    const data = new FormData(modalAddControl);
    let result = await executePetition(url + "/insertarControl", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);
      modalControlBoots.hide();
      readControl(result.data.cedula);
      readPatients();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  } finally {
    finallyLoaderButton(botonModal)
  }
};

//function for update the control
const updateControl = async () => {
  try {
    initLoaderButton(botonModal)
    const data = new FormData(modalAddControl);
    let result = await executePetition(url + "/editarControl", "POST", data);

    if (result.ok) {
      alertSuccess(result.message);
      modalControlBoots.hide();
      readControl(result.data.cedulaOculta);

    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  } finally {
    finallyLoaderButton(botonModal)
  }
};

//Sintomas
const readSintomas = async () => {
  try {
    let metodo = "";
    let urlActual = window.location.href;

    const result = await executePetition(
      url + "/returnSistomasPaciente" + metodo,
      "GET",
    );

    // construir html de filas
    let html = "";
    result.forEach((element, index) => {
      html += `<tr>
                            <td class="text-center">${index + 1}</td>
                            <td class="text-center">${element.nombre}</td>
                            <td class="text-center">

                                    <button class="btn btn-tabla mb-1  btn-dt-tabla btn-eliminar"
                                    
                                        data-index="${element.id_sintomas}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                        </svg>
                                    </button>

                        
                            </td>
                            
                        </tr>
`;
    });
    const selector = ".exampleTableSintoma";

    // si ya existe DataTable, destrúyela
    if ($.fn.DataTable.isDataTable(selector)) {
      $(selector).DataTable().clear().destroy();
    }

    // vuelca el html en el tbody
    document.querySelector(selector + " tbody").innerHTML = html;

    //llamar las funcion de eliminar
    document.querySelectorAll(".btn-eliminar").forEach((btn) => {
      btn.addEventListener("click", function () {
        const data = [
          this.getAttribute("data-index"),
          document.getElementById("id_usuario_session").value,
        ];

        alertConfirm(
          "Esta seguro de eliminar el sintoma?",
          deleteSintoma,
          data,
        );
      });
    });

    // re-inicializa
    initDataTable(selector);
  } catch (error) {
    alertError("Error", error);
  }
};

const insertarSintoma = async (data) => {
  try {
    initLoaderButton(botonModalSintomas)
    const data = new FormData(modalAgregarSintoma);
    const result = await executePetition(url + `/agregarSintoma`, "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);
      modalSintomaBoots.hide();
      modalReadSintomaBoots.show();
      readSintomas();

    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  } finally {
    finallyLoaderButton(botonModalSintomas)
  }
};

const deleteSintoma = async (data) => {
  try {
    const result = await executePetition(
      url + `/eliminarSintoma/${data}`,
      "GET",
    );
    if (result.ok) {
      alertSuccess(result.message);

      readSintomas();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//create paciente
//create
const createPatients = async (form) => {
  try {
    const data = new FormData(form);
    let result = await executePetition(
      "/Sistema-del--CEM--JEHOVA-RAFA/Pacientes/guardar",
      "POST",
      data,
    );
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);
      cedulaControl.value = cedulaPaciente.value;
      cedulaControl.dispatchEvent(new Event("keyup", { bubbles: true }));

      form.reset();

      modalControlBoots.show();
      modalPaciente.hide();

      readPatients();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

readPatients();

readSintomas();

openModalSintomas.addEventListener("click", function () {


  //objetos con todos los parametros de la funcion
  const parametros = {
    labelModal: exampleModalLabel,
    textLabelModal: "Registrar Sintoma",
    form: modalAgregarSintoma,
    modal: modalAgregarSintoma.parentElement.parentElement.parentElement,
    btnModal: openModalSintomas,
    btnTextModal: "Registrar",
    inputs: inputsSintimo,
  };

  clearModalEnviar(parametros);
});

cedulaControl.addEventListener("keyup", function () {
  document.getElementById("cedulaOculta").value = cedulaControl.value;
  traerPaciente();
});

btnControl.addEventListener("click", function () {
  clickButtonOpenModal();
});

//cuando se abra elmodal de agregar paciente se le da el valor de la cedula directamente
btnOpenModalPac.addEventListener("click", function () {
  console.log(cedulaPaciente);
  cedulaPaciente.value = cedulaControl.value;
  cedulaPaciente.dispatchEvent(new Event("keyup", { bubbles: true }));
});

buscarDoctores.addEventListener("keyup", function () {
  searchElements(
    buscarDoctores.value,
    "d-none",
    document.querySelectorAll(".text-doctor"),
    document.querySelector(".p-busqueda"),
    ".cards-horario",
  );
});

buscarPatologias.addEventListener("keyup", function () {
  searchElements(
    buscarPatologias.value,
    "d-none",
    document.querySelectorAll(".form-check-label-patologias"),
    document.querySelectorAll(".p-busqueda-patologia"),
    ".form-check-patologias",
  );
});

buscarSintomas.addEventListener("keyup", function () {
  searchElements(
    buscarSintomas.value,
    "d-none",
    document.querySelectorAll(".form-check-label-sintomas"),
    document.querySelector(".p-busqueda-sintoma"),
    ".form-check-sintomas",
  );
});

let verificarFormulario = inicializarValidacionFormulario(modalAddControl);

let verificarFormularioSintoma =
  inicializarValidacionFormulario(modalAgregarSintoma);

let verificarFormularioPaciente =
  inicializarValidacionFormulario(modalAgregarPaciente);

modalAddControl.addEventListener("submit", async function (e) {
  e.preventDefault();
  console.log("enviando formulario");

  //guardar alguna coincidencia de  las cards es decir para saber si alguna de las  cards de doctores fue selecionada prque si no no  seenviara el firnluario

  let doctorSeleciondo = false;
  document.querySelectorAll(".cards-horario").forEach((card) => {
    if (card.style.backgroundColor == "rgb(56, 122, 223)") {
      doctorSeleciondo = true;
      return;
    }
  });

  let esValido = verificarFormulario();
  if (esValido) {
    if (modalAddControl.classList.contains("editar")) {
      updateControl();
    } else {
      if (doctorSeleciondo) {
        createControl();
      } else {
        alertError(
          "Error",
          "Por favor, debe seleccionar un doctor para realizar el control medico.",
        );
      }
    }
  } else {
    alertError(
      "Error",
      "Por favor, complete todos los campos correctamente antes de enviar el formulario.",
    );
  }
});

modalAgregarSintoma.addEventListener("submit", async function (e) {
  e.preventDefault();
  console.log("enviando formulario");

  let esValido = verificarFormularioSintoma();
  if (esValido) {
    insertarSintoma();
  } else {
    alertError(
      "Error",
      "Por favor, complete todos los campos correctamente antes de enviar el formulario.",
    );
  }
});

//enviar firmulario de paciente
modalAgregarPaciente.addEventListener("submit", function (e) {
  e.preventDefault();

  let inputsBuenos = [];
  this.querySelectorAll(".input-validar").forEach((input) => {
    if (input.parentElement.classList.contains("valido"))
      inputsBuenos.push(true);
  });

  let esValido = verificarFormularioPaciente();

  if (esValido) {
    createPatients(this, inputsBuenos);
  } else {
    alertError(
      "Error",
      "Por favor verifique que todos los datos estén correctos.",
    );
  }
});
