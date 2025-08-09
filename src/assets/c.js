addEventListener("DOMContentLoaded", function () {
  console.log("hello control medico");

  const tbodyControl = document.getElementById("tbody-control");
  const tbodyPacientes = document.getElementById("tbody-pacientes");
  const textStartControl = document.getElementById("text-start");
  const loaderControlMedico = document.getElementById("loader-control-medico");
  const modalAddControl = document.getElementById("modalAgregarControl"); //modal control
  const cedulaControl = document.getElementById("cedulaControl"); //input cedula
  const showPaciente = document.getElementById("mostrarPaciente");
  const btnAC = document.getElementById("btnAC");
  const contentF = document.getElementById("contenedorF");
  const mandarAddPaciente = document.getElementById("mandarRegistrarPaciente");
  const Not_paciente = this.document.getElementById("No_paciente");
  const edad = document.getElementById("edad");
  const dataPaciente = document.getElementById("datosPaciente");
  const idPaciente = document.getElementById("idPaciente");
  const alertControl = document.getElementById("alert-control");
  let url = "/Sistema-del--CEM--JEHOVA-RAFA/Control";

  //funtion generica for execute petiticon ajax
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

  //funtion for add pacientes in table
  const readPacientes = async () => {
    try {
      let result = await executePetition(url + "/listPacientesJS", "GET");
      let html = "";
      result.forEach((element) => {
        html += `
            <tr class="row-pacientes">
                            <td>${element.cedula}</td>
                            <td>${element.nombre}</td>
                            <td>${element.fn}</td>
                            <td>${element.genero}</td>
                        </tr>
            `;
      });
      tbodyPacientes.innerHTML = html;

      //Bucle and Event for selected the paciente and control medico
      document.querySelectorAll(".row-pacientes").forEach((row) => {
        row.addEventListener("click", function () {
          let background = row.style.backgroundColor;
          document.querySelectorAll(".row-pacientes").forEach((row) => {
            row.style.backgroundColor = "";
          });
          row.style.backgroundColor = background == "var(--color-primary)" ? "" : "var(--color-primary)";

          let cedula = this.closest("tr").children[0].innerText;
          readControl(cedula);
        });
      });
    } catch (error) {
      console.log(error);
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
                                <button class="btn col-3 btn-agregarcita-modal editar btnEditar" type="button"
                                    uk-toggle="target: #modal-examplecontroleditar${element.id_control}" data-id-control="${
        element.id_control
      }" data-id-paciente="${
        element.id_paciente
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

  //funtion for add control medico in table
  const readControl = async (cedulaPaciente) => {
    try {
      loaderControlMedico.classList.remove("d-none");
      let result = await executePetition(url + "/mostrarControlPacientesJS/" + cedulaPaciente, "GET");
      let html = "";
      tbodyControl.innerHTML = ``;

      result[0].forEach((element, index) => {
        console.log(element);
        html += returnFragmentControl(result[0], element, index);
        tbodyControl.parentElement.classList.remove("d-none");
        textStartControl.classList.add("d-none");
      });

      tbodyControl.innerHTML = html;
    } catch (error) {
      console.error("hola el error es :" + error);
    } finally {
      loaderControlMedico.classList.add("d-none");
    }
  };

  const dataPacienteModal = async (cedula) => {
    try {
      let result = await executePetition(url + "/mostrarPacienteJS/" + cedula, "GET");

      if (result.length > 0) {
        result.forEach((res) => {
          // calcula la edad
          const fechaNac = new Date(res.fn);
          const edadDif = Date.now() - fechaNac.getTime();
          const edadFecha = new Date(edadDif);
          edad.innerText = `Edad: ${Math.abs(edadFecha.getUTCFullYear() - 1970)}`;
          dataPaciente.innerText = `Paciente: ${res.nombre} ${res.apellido}`;
          idPaciente.value = res.id_paciente;
        });
        // console.log(result[0].id_paciente);
        // // mostrarPIdP es la función...
        // let verificar = await patologiaC(result[0].id_paciente, "inputPP", "mostrarPIdP");
        // // si
        // if (verificar != undefined) {
        //   let inputChe = document.querySelectorAll(`.inputPP`);
        // }

        showPaciente.classList.remove("d-none");
        btnAC.classList.remove("d-none");
        contentF.classList.remove("d-none");
        mandarAddPaciente.classList.add("d-none");
        Not_paciente.innerText = "";
      } else {
        showPaciente.classList.add("d-none");
        btnAC.classList.add("d-none");
        contentF.classList.add("d-none");
        mandarAddPaciente.classList.remove("d-none");
        Not_paciente.innerText = `NO SE ENCONTRÓ AL PACIENTE, PRESIONE CLIC AQUÍ PARA REGISTRAR`;
      }
    } catch (error) {
      console.log("error funtion dataPacienteModal" + error);
    }
  };

  //funtion for save the control
  const saveControl = async () => {
    let textAlert = "", classAlert = "";
    try {
      const data = new FormData(modalAddControl);
      let result = await executePetition(url + "/insertarControl", "POST", data);
      alertControl.classList.remove("d-none");
      textAlert = `Se registro correctamente el control medico del paciente con la cedula ${result.data.cedula}`;
      classAlert = "uk-alert-primary";
      readControl(result.data.cedula);
    } catch (error) {
      textAlert = `Lamenteblemente algo salio mal por favor intente mas tarde`;
      classAlert = "uk-alert-danger";
    }finally{
      showAlert(alertControl, textAlert, classAlert);
    }
  };

  //funtion for show and hidden alert the control
  const showAlert = (alert, text, classAlert) => {
    alert.classList.add(`${classAlert}`);
    alert.innerText = `${text}`;
    alert.classList.remove("d-none");
    setTimeout(() => {
      alert.classList.add("d-none");
    }, 7000);
  };


  readPacientes();

  cedulaControl.addEventListener("keyup", function () {
    dataPacienteModal(this.value);
  });

  modalAddControl.addEventListener("submit", function (e) {
    e.preventDefault();
    UIkit.modal("#modal-examplecontrol").hide();
    saveControl();
  });
});
