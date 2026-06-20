import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
  initDataTable,
  showDataModal,
  clearModalEnviar,
  hasPermision,
  initLoaderButton,
  finallyLoaderButton,
} from "../generic/funtionGeneric.js";
import { inicializarValidacionFormulario } from "../generic/expresionesModulares.js";

const url = "/Sistema-del--CEM--JEHOVA-RAFA/Proveedores";

const modalAgregarProveedor = new bootstrap.Modal(
  document.getElementById("exampleModalProveedor"),
);
const formProveedor = document.getElementById("formProveedor");
const exampleModalLabel = document.getElementById("exampleModalLabelProveedor");
const botonModal = document.getElementById("botonModalProveedor");
console.log(botonModal);

const inputs = formProveedor.querySelectorAll(".input-validar");
const id_proveedor = document.getElementById("id_proveedor");
const btnOpenModalProveedor = document.getElementById("btnOpenModalProveedor");

const id_rif_oculto = document.getElementById("id_rif_oculto");
const id_rol_global = document.getElementById("id_rol_global").value;

const urlBase = document.getElementById("urlBase").value;

//read

const readProveedores = async () => {
  try {
    let metodo = "";
    let urlActual = window.location.href;

    if (!urlActual.includes("papelera")) metodo = "proveedoresAjax";
    else metodo = "proveedoresPapeleraAjax";

    const selector = ".exampleTable";

    // si ya existe DataTable, destrúyela
    if ($.fn.DataTable.isDataTable(selector)) {
      $(selector).DataTable().clear().destroy();
    }

    const columnsEntradas = [
      { data: "nombre" },
      { data: "rif" },
      { data: "telefono" },
      { data: "correo" },
      { data: "direccion" },
      {
        data: null,
        orderable: false,
        render: function (data, type, row) {
          return `    <!-- Editar Proveedor -->
                              
                                    <button href="#" class="${
                                      !urlActual.includes("papelera")
                                        ? ""
                                        : "d-none"
                                    } btn-editar btn btn-tabla mb-1 btnEditarDoctor btn-dt-tabla" uk-tooltip="Modificar Proveedores" data-bs-toggle="modal" data-bs-target="#exampleModalProveedor" data-index="${
                                      row.id_proveedor
                                    }" data-index-rif="${row.rif}">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                </svg>
                                    </button>



                                <!-- Eliminar Proveedores-->

                                    <button href="#" class="${
                                      !urlActual.includes("papelera")
                                        ? ""
                                        : "d-none"
                                    } btn btn-tabla mb-1 btnEliminarDoctor btn-dt-tabla btn-eliminar" data-index="${
                                      row.id_proveedor
                                    }">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                </svg>
                                    </button>

                    <a href="#" class=" btn btn-tabla btn-dt-tabla btnRestablecer ${
                      urlActual.includes("papelera") ? "" : "d-none"
                    }" data-index="${
                      row.id_proveedor
                    }" title="Restablecer Entrada" uk-tooltip=""  aria-describedby="uk-tooltip-27">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise " viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>
                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                      </svg>
                    </a>

`;
        },
      },
    ];

    const asignarEventos = () => {
      //llamar las funcion de eliminar
      document.querySelectorAll(".btn-eliminar").forEach((btn) => {
        btn.addEventListener("click", function () {
          const data = [
            this.getAttribute("data-index"),
            document.getElementById("id_usuario_session").value,
          ];
          alertConfirm(
            "Esta seguro de eliminar el proveedor?",
            daleteProveedor,
            data,
          );
        });
      });

      //llamar las funciones de editar
      document.querySelectorAll(".btn-editar").forEach((btn) => {
        btn.addEventListener("click", function () {
          const parametros = {
            labelModal: exampleModalLabel,
            textLabelModal: "Modificar Proveedor",
            form: formProveedor,
            modal: formProveedor.parentElement.parentElement.parentElement,
            btnModal: botonModal,
            btnTextModal: "Modificar",
            data: {
              nombre: btn.closest("tr").children[0].innerText,
              rif: btn.closest("tr").children[1].innerText,
              telefono: btn.closest("tr").children[2].innerText,
              correo: btn.closest("tr").children[3].innerText,
              direccion: btn.closest("tr").children[4].innerText,
              id: btn.getAttribute("data-index"),
            },
            inputs: inputs,
            idOculto: id_proveedor,
            rifOculto: id_rif_oculto,
            cedulaOculta: null,
          };
          showDataModal(parametros);
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
          console.log(data);
          alertConfirm(
            "Esta seguro de restablecer el proveedor?",
            restablecerProveedor,
            data,
          );
        });
      });

      //////gestionar persmisos
      hasPermision(id_rol_global, "Proveedores", "guardar", ".btnOpenModal"); //guardar
      hasPermision(id_rol_global, "Proveedores", "eliminar", ".btn-eliminar"); //eliminar
      hasPermision(id_rol_global, "Proveedores", "eliminar", ".btnRestablecer"); //restablecer
      hasPermision(id_rol_global, "Proveedores", "editar", ".btn-editar"); //editar
    };

    // re-inicializa
    initDataTable(
      selector,
      `${url}/${metodo}`,
      columnsEntradas,
      (datosServer) => {
        console.log(datosServer);
      },
      asignarEventos,
    );
  } catch (error) {
    alertError("Error", error);
  }
};
//create
const createProveedor = async (form) => {
  try {
    initLoaderButton(botonModal);
    const data = new FormData(form);
    let result = await executePetition(url + "/insertar", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);
      modalAgregarProveedor.hide();
      readProveedores();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    console.log(error);
    alertError("Error", error);
  } finally {
    finallyLoaderButton(botonModal);
  }
};

//update
const updateProveedor = async (form) => {
  try {
    initLoaderButton(botonModal);
    const data = new FormData(form);
    let result = await executePetition(url + "/editar", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);
      modalAgregarProveedor.hide();
      readProveedores();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    console.log(error);
    alertError("Error", error);
  } finally {
    finallyLoaderButton(botonModal);
  }
};

//delete
const daleteProveedor = async (data) => {
  try {
    const result = await executePetition(url + `/update/${data}`, "GET");
    if (result.ok) {
      alertSuccess(result.message);

      readProveedores();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//restablecer
const restablecerProveedor = async (data) => {
  try {
    const result = await executePetition(
      url + `/restablecerProveedor/${data}`,
      "GET",
    );
    if (result.ok) {
      alertSuccess(result.message);

      readProveedores();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

readProveedores();

btnOpenModalProveedor.addEventListener("click", function () {
  console.log(botonModal);
  const parametros = {
    labelModal: exampleModalLabel,
    textLabelModal: "Registrar Proveedor",
    form: formProveedor,
    modal: formProveedor.parentElement.parentElement.parentElement,
    btnModal: botonModal,
    btnTextModal: "Registrar",
    inputs: inputs,
  };
  console.log(parametros);

  clearModalEnviar(parametros);
});

let verificarFormulario = inicializarValidacionFormulario(formProveedor);

formProveedor.addEventListener("submit", function (e) {
  e.preventDefault();

  console.log("submit");

  let esValido = verificarFormulario();

  if (esValido) {
    if (formProveedor.classList.contains("editar")) {
      console.log("editar");
      updateProveedor(this);
    } else {
      console.log("crear");
      createProveedor(this);
    }
  } else {
    alertError("Error", "Por favor complete correctamente el formulario.");
  }
});
