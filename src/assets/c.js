addEventListener("DOMContentLoaded", function () {
  console.log("hello control medico");

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
  const Not_Patient = this.document.getElementById("No_paciente");
  const edad = document.getElementById("edad");
  const dataPatient = document.getElementById("datosPaciente");
  const idPatient = document.getElementById("idPaciente");
  const alertControl = document.getElementById("alert-control");
  const showDataPatientEdit = document.querySelectorAll(".showDataPatientEdit");
  const id_usuario_bitacora = document.getElementById("id_usuario_bitacora").value; // constante que guarda el id que inicio session de esa manera podemos realizar la bitacora;
  const divSintomas = document.querySelector(".divSintomas");
  const divPatologias = document.querySelector(".divPatologias");

  let url = "/Sistema-del--CEM--JEHOVA-RAFA/Control";

  //function generica for execute petiticon ajax
  const executePetition = async (url, method, data = null) => {
    try {
      const options = { method: method };

      if (data instanceof FormData) {
        options.body = data;
      } else if (data && typeof data === "object") {
        options.headers = {
          "Content-Type": "application/json",
        };
        options.body = JSON.stringify(data);
      }

      let response = await fetch(url, options);
      return response.json();
    } catch (error) {
      return error;
    }
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

      //Bucle and Event for selected the Patient and control medico
      document.querySelectorAll(".row-Patients").forEach((row) => {
        row.addEventListener("click", function () {
          let background = row.style.backgroundColor;
          document.querySelectorAll(".row-Patients").forEach((row) => {
            row.style.backgroundColor = "";
          });
          row.style.backgroundColor = background == "var(--color-primary)" ? "" : "var(--color-primary)";

          let cedula = this.closest("tr").children[0].innerText;
          readControl(cedula);
        });
      });
    } catch (error) {
      console.log("Error in the function readPatients " + error);
    }
  };

  const returnFragmentControl = (data, element, index) => {
    let fragment;
    if (data.length > 0) {
      fragment = `
            <tr>
                            <td>${element.fecha_control.split(" ")[0]}</td>
                            <td>${element.fechaRegreso}</td>
                            <td>
                                <button class="btn col-3 btn-agregarcita-modal editar btnEditar buttomEditControl" type="button"
                                    uk-toggle="target: #modal-examplecontroleditar" data-id-control="${
                                      element.id_control
                                    }" data-id-Patient="${
        element.id_Patient
      }"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
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
    try {
      loaderControlMedico.classList.remove("d-none");
      let result = await executePetition(url + "/mostrarControlPacientesJS/" + cedulaPatient, "GET");
      let html = "";
      tbodyControl.innerHTML = ``;

      result[0].forEach((element, index) => {
        console.log(element);
        html += returnFragmentControl(result[0], element, index);
        tbodyControl.parentElement.classList.remove("d-none");
        textStartControl.classList.add("d-none");
      });

      tbodyControl.innerHTML = html;
      document.querySelectorAll(".buttomEditControl").forEach((element) => {
        element.addEventListener("click", function (e) {
          showDataPatient(this.getAttribute("data-id-control"), result);
        });
      });
    } catch (error) {
      console.error("hola el error es :" + error);
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
        Not_Patient.innerText = `NO SE ENCONTRÓ AL Patient, PRESIONE CLIC AQUÍ PARA REGISTRAR`;
      }
    } catch (error) {
      console.log("error function dataPatientModal" + error);
    }
  };

  //function for save the control
  const saveControl = async () => {
    let textAlert = "",
      classAlert = "";
    try {
      const data = new FormData(modalAddControl);
      let result = await executePetition(url + "/insertarControl", "POST", data);
      alertControl.classList.remove("d-none");
      textAlert = `Se registro correctamente el control medico del Paciente con la cedula ${result.data.cedula}`;
      classAlert = "uk-alert-primary";
      readControl(result.data.cedula);
      console.log("Resultado");
      console.log(result);
    } catch (error) {
      textAlert = `Lamenteblemente algo salio mal por favor intente mas tarde`;
      classAlert = "uk-alert-danger";
    } finally {
      showAlert(alertControl, textAlert, classAlert);
    }
  };

  //function for edit the control
  const editControl = async () => {
    let textAlert = "",
      classAlert = "";
    try {
      const data = new FormData(modalEditControl);
      let result = await executePetition(url + "/editarControl", "POST", data);
      console.log(result);
      if (!result.mensaje) {
        await readControl(result.data.cedula);
        console.log(result.data.cedula);
        textAlert = `Se modifico correctamente el control medico del Paciente con la cedula ${result.data.cedula}`;
        classAlert = "uk-alert-primary";
      } else {
        textAlert = `Lamenteblemente algo salio mal por favor intente mas tarde`;
        classAlert = "uk-alert-danger";
      }
    } catch (error) {
      console.log(error);
    } finally {
      showAlert(alertControl, textAlert, classAlert);
    }
  };

  //function for show and hidden alert the control
  const showAlert = (alert, text, classAlert) => {
    alert.classList.add(`${classAlert}`);
    alert.innerText = `${text}`;
    alert.classList.remove("d-none");
    setTimeout(() => {
      alert.classList.add("d-none");
    }, 7000);
  };

  //function for show the data the patient in edit
  const showDataPatient = (idControl, data) => {
    let dataControl = data[0].find((element) => element.id_control == idControl);
    console.log(dataControl);
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

    data[1].forEach((element) => {
      htmlSintomas += returnFrangmentCheckbox("sintomas[]", element.nombreS, true);
    });

    data[3].forEach((element) => {
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
    UIkit.modal("#modal-examplecontrol").hide();
    saveControl();
  });

  modalEditControl.addEventListener("submit", function (e) {
    e.preventDefault();
    UIkit.modal("#modal-examplecontroleditar").hide();
    editControl();
  });
});
