import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
  clearModalEnviar,
  initDataTable,
  showDataModal,
  hasPermision,
  initLoaderButton,
  finallyLoaderButton,
} from "../generic/funtionGeneric.js";
import { inicializarValidacionFormulario } from "../generic/expresionesModulares.js";
import { initConversion } from "../generic/coversion.js";

const url = "/Sistema-del--CEM--JEHOVA-RAFA/Servicios";
const dolar = parseFloat(document.getElementById("dolar").value);
const id_rol_global = document.getElementById("id_rol_global").value;

const modalAgregarServicio = new bootstrap.Modal(
  document.getElementById("modalAgregarServicios"),
);

//read

//create
const createService = async (form, inputs) => {
  try {
    const data = new FormData(form);
    console.log(url + "/guardar");
    let result = await executePetition(url + "/guardar", "POST", data);
    if (result.ok) {
      alertSuccess(result.message);
      form.reset();
      modalAgregarServicio.hide();
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

    let result = await executePetition(url + "/editar", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);
      readServices();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    console.log(error);
    alertError("Error", error);
  }
};

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

let selectCategoria = document.querySelector("#selectCategoria");
let objCServiciosSelect = {};
let objDoctoresSelect = {};
const readDatosDS = async () => {
  let metodo = "";
  let urlActual = window.location.href;

  if (!urlActual.includes("papelera")) {
    metodo = "datosServicios";
  } else {
    metodo = "datosServiciosPapelera";
  }

  const resultSelect = await executePetition(url + "/" + metodo, "GET");
  console.log(resultSelect);

  resultSelect["categorias"].forEach((res) => {
    console.log(res);

    objCServiciosSelect[res.id_categoria] = res;
    objDoctoresSelect[res.id_personal] = res;
    selectCategoria.innerHTML += `<option class='option-select-background' value="${res["id_categoria"]}">${res["nombre"]}</option>`;
  });
};

const readServices = async () => {
  try {
    let metodo = "";
    let urlActual = window.location.href;

    if (!urlActual.includes("papeleraServicio")) metodo = "serviciosAjax";
    else metodo = "papeleraAjax";
    const selector = ".exampleTable";

    // si ya existe DataTable, destrúyela
    if ($.fn.DataTable.isDataTable(selector)) {
      $(selector).DataTable().clear().destroy();
    }

    const columnsServicios = [
      { data: "categoria" },
      {
        data: "precio",
        render: (data, type, row) => `${(data * dolar).toFixed(2)} BS`,
      },
      {
        data: "precio",
        render: (data, type, row) => `${(data).toFixed(2)} $`,
      },
      { data: "tipo" },
      {
        data: null,
        orderable: false,
        render: function (data, type, row) {
          return `<!-- Horario Del Doctor -->
                                <div class="d-flex justify-content-center">

                                        <button class="${urlActual.includes("papelera") ? "d-none" : ""}
                                        btn btns-accion btn-tabla me-2 btnEditarCita botonesEditarSM btnPreciosEditar btn-dt-tabla"
                                            data-id-categoria="${row.id_categoria}"
                                            data-id-tabla="modal-exampleEditar${row.id_servicioMedico}" data-bs-toggle="modal" data-bs-target="#modalAgregarServicios" 
                                            id="btnEditarServicioMedico" data-index=${row.id_servicioMedico}>
                                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                </svg>
                                        </button>


                                    <!-- Eliminar servicio-->


                                        <button class="${
                                          urlActual.includes("papelera")
                                            ? "d-none"
                                            : ""
                                        }  btn btns-accion btn-tabla me-2 btn-dt-tabla btn-eliminar-servicio" data-index=${
                                          row.id_servicioMedico
                                        }>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                            </svg>
                                        </button>

                                        <button class="${!urlActual.includes("papelera") ? "d-none" : ""} btn btn-tabla btn-dt-tabla btnRestablecer"
                                        data-index=${row.id_servicioMedico} title="Restablecer Paciente" uk-tooltip id="btnModalEliminarPaciente">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise " viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                                                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                                            </svg>
                                        </button>
                                        
                                </div>`;
        },
      },
    ];

    const asignarEventos = () => {
      //llamar las funcion de eliminar
      document.querySelectorAll(".btn-eliminar-servicio").forEach((btn) => {
        btn.addEventListener("click", function () {
          const data = [
            this.getAttribute("data-index")
          ];
          alertConfirm(
            "Esta seguro de eliminar el servicio medico?",
            deleteService,
            data,
          );
        });
      });

      //llamar a la uncion de restablecer
      //llamar las funcion de eliminar
      document.querySelectorAll(".btnRestablecer").forEach((btn) => {
        btn.addEventListener("click", function () {
          const data = [
            this.getAttribute("data-index"),
            document.getElementById("id_usuario_session").value,
          ];

          alertConfirm(
            "Esta seguro de restablecer el servicio medico?",
            restablecerService,
            data,
          );
        });
      });

      document.querySelectorAll(".botonesEditarSM").forEach((btn) => {
        btn.addEventListener("click", function () {
          //objetos con todos los parametros de la funcion
          let idC = btn.getAttribute("data-id-categoria");
          let idServicio = btn.getAttribute("data-index");

          const parametros = {
            labelModal: divTitle,
            textLabelModal: "Modificar Servicio",
            form: formularioA,
            modal: document.querySelector("#modalAgregarServicios"),
            btnModal: document.querySelector("#botonModalServicio"),
            btnTextModal: "Modificar",
            data: {
              id_categoria: idC,
              precioBs: parseFloat(btn.closest("tr").children[1].innerText),
              precioD: parseFloat(btn.closest("tr").children[2].innerText),
              tipo: btn.closest("tr").children[3].innerText,
              id: idServicio,
            },
            inputs: document.querySelectorAll(".inputs"),
            cedulaOculta: false,
            idOculto: document.getElementById("id_servicio"),
          };
          console.log(parametros.data.id_categoria);
          showDataModal(parametros);
        });
      });

      //////gestionar persmisos
      hasPermision(id_rol_global, "Servicios", "guardar", ".btnOpenModal"); //guardar
      hasPermision(
        id_rol_global,
        "Servicios",
        "guardar",
        ".btnOpenModalCategoria",
      ); //guardar categoria

      hasPermision(id_rol_global, "Servicios", "eliminar", ".btn-eliminar-servicio"); //eliminar
      hasPermision(id_rol_global, "Servicios", "eliminar", ".btnRestablecer"); //restablecer
      hasPermision(id_rol_global, "Servicios", "editar", ".botonesEditarSM"); //editar
    };
    
    // re-inicializa
    initDataTable(selector, url + "/" + metodo,columnsServicios,(datosServer)=>{console.log(datosServer);
    }, asignarEventos);
  } catch (error) {
    alertError("Error", error);
  }
};

//delete
const deleteService = async (data) => {
  console.log(data);
  
  try {
    const result = await executePetition(url + `/eliminar/${data}`, "GET");
    if (result.ok) {
      alertSuccess(result.message);
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
      alertSuccess(result.message);
      readServices();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};
const divTitle = document.querySelector("#modalLabelServicios");
const btnOpenModalA = document.querySelector("#btnAgregarServicioMedico");

btnOpenModalA?.addEventListener("click", function () {
  //objetos con todos los parametros de la funcion
  const parametros = {
    labelModal: divTitle,
    textLabelModal: "Registrar Servicio",
    form: formularioA,
    modal: document.querySelector("#modalAgregarServicios"),
    btnModal: document.querySelector("#botonModalServicio"),
    btnTextModal: "Registrar",
    inputs: document.querySelectorAll(".inputs"),
  };
  clearModalEnviar(parametros);
});

let formularioA = document.getElementById("modalAgregar");
initConversion(formularioA);
if (formularioA) {
  let verificarFormulario = inicializarValidacionFormulario(formularioA);

  formularioA.addEventListener("submit", function (e) {
    e.preventDefault();

    let inputsBuenos = [];
    this.querySelectorAll(".input-validar").forEach((input) => {
      if (input.parentElement.classList.contains("valido"))
        inputsBuenos.push(true);
    });

    let esValido = verificarFormulario();

    if (esValido) {
      if (formularioA.classList.contains("editar")) {
        updateService(this, inputsBuenos);
      } else {
        createService(this, inputsBuenos);
      }
    } else {
      alertError(
        "Error",
        "Por favor verifique que todos los datos estén correctos.",
      );
    }
  });
}

readServices();
readDatosDS();
