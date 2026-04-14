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

const url = "/Sistema-del--CEM--JEHOVA-RAFA/Clientes";

const modalAgregarCliente = new bootstrap.Modal(
  document.getElementById("modalCliente"),
);
const modalAgregar = document.getElementById("modalAgregarCliente");
const modalInfo = new bootstrap.Modal(document.getElementById("info-cliente"));

const selectGenero = document.getElementById("selectGenero");
const exampleModalLabel = document.getElementById("exampleModalLabelCliente");
const botonModal = document.getElementById("botonModal");
const btnOpenModal = document.getElementById("btnOpenModal");
const inputs = document.querySelectorAll(".inputs");
const cedulaRegistrada = document.getElementById("cedulaOculta");
const id_cliente = document.getElementById("id_oculto");
const id_rol_global = document.getElementById("id_rol_global").value;
const fnTextInfo = document.getElementById("fn-text");
const direccionTextInfo = document.getElementById("direccion-text");
let dataCustomer = [];


//searchObectPattiens es para buscar los datos de un paciente especifico y retornar el objeto
const searchObectCustomer = (id) =>
  dataCustomer.find((data) => data.id_cliente == id);

//show info pacientes especifico
const infoCustomer = (id) => {
  let customer = searchObectCustomer(id);
  fnTextInfo.innerText = customer.fn;
  direccionTextInfo.innerText = customer.direccion;
};



//read

const readCustomer = async () => {
  try {
    let metodo = "";
    let urlActual = window.location.href;

    if (!urlActual.includes("papelera")) metodo = "clientesAjax";
    else metodo = "papeleraAjax";

    const result = await executePetition(url + "/" + metodo, "GET");
    dataCustomer = result;

    // construir html de filas
    let html = "";
    dataCustomer.forEach((element) => {
      html += ` <tr>
              <td class="">${element.nacionalidad}-${element.cedula}</td>
              <td class="">${element.nombre}</td>
              <td class="">${element.apellido}</td>
              <td class="">${element.telefono}</td>
              <td class="">${element.genero}</td>
              <td class="text-center">
              <button class="${
                urlActual.includes("papelera") ? "d-none" : ""
              } btn btn-tabla mb-1 btn-js editar botonesEdi btnModalEditarPaciente btn-dt-tabla"
                                data-bs-toggle="modal" data-bs-target="#modalCliente" data-index="${element.id_cliente}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                </svg>

                            </button>

     
                    <button class="${
                      urlActual.includes("papelera") ? "d-none" : ""
                    } btn btn-tabla mb-1 btnModalEliminarPaciente btn-dt-tabla btn-eliminar" data-index="${element.id_cliente}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"></path>
                                </svg>
                            </button>
                            </button>

                            <button class="btn btn-tabla mb-1 botonesInfo btn-dt-tabla" data-index="${element.id_cliente}" data-bs-toggle="modal" data-bs-target="#info-cliente" title="Mas Informacion">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
                                    </svg>
                                </button>


                 
                    <button class="${
                      !urlActual.includes("papelera") ? "d-none" : ""
                    } btn btn-tabla btn-dt-tabla  mb-1 btnRestablecer"  data-index=${
                      element.id_cliente
                    }  title="Restablecer Paciente" uk-tooltip id="btnModalEliminarPaciente">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise " viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                      </svg>
                    </button>
                  
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
        const data = [
          this.getAttribute("data-index"),
          document.getElementById("id_usuario_session").value,
        ];
        alertConfirm(
          "Esta seguro de eliminar el cliente?",
          deleteCustomer,
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
          "Esta seguro de restablecer el cliente?",
          restablecerCustomers,
          data,
        );
      });
    });

    //llamar las funcion de eliminar
    document.querySelectorAll(".botonesEdi").forEach((btn) => {
      btn.addEventListener("click", function () {
        let customer = searchObectCustomer(btn.getAttribute("data-index"));
        //objetos con todos los parametros de la funcion
        const parametros = {
          labelModal: exampleModalLabel,
          textLabelModal: "Modificar Cliente",
          form: modalAgregar,
          modal: modalAgregar.parentElement.parentElement.parentElement,
          btnModal: botonModal,
          btnTextModal: "Modificar",
          data: {
            nacionalidad: customer.nacionalidad,
            cedula: customer.cedula,
            nombre: customer.nombre,
            apellido: customer.apellido,
            telefono: customer.telefono,
            direccion: customer.direccion,
            fn: customer.fn,
            genero: customer.genero,
            id: customer.id_cliente,
          },
          inputs: inputs,
          cedulaOculta: cedulaRegistrada,
          idOculto: id_cliente,
        };
        showDataModal(parametros);
      });
    });

    //mostrar mas info
    document.querySelectorAll(".botonesInfo").forEach((btn) => {
      btn.addEventListener("click", function () {
        let id = btn.getAttribute("data-index");
        modalInfo.show();
        infoCustomer(id);
      });
    });

    //////gestionar persmisos
    hasPermision(id_rol_global, "Clientes", "guardar", ".btnOpenModal"); //guardar
    hasPermision(id_rol_global, "Clientes", "eliminar", ".btn-eliminar"); //eliminar
    hasPermision(id_rol_global, "Clientes", "eliminar", ".btnRestablecer"); //restablecer
    hasPermision(id_rol_global, "Clientes", "editar", ".botonesEdi"); //editar

    // re-inicializa
    initDataTable(selector);
  } catch (error) {
    alertError("Error", error);
  }
};
//create
const createCustomer = async (form) => {
  try {
    initLoaderButton(botonModal)
    const data = new FormData(form);
    let result = await executePetition(url + "/guardar", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);
      modalAgregarCliente.hide();
      readCustomer();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  } finally {
    finallyLoaderButton(botonModal)
  }
};

//update
const updateCustomers = async (form) => {
  try {
    initLoaderButton(botonModal)
    const data = new FormData(form);
    let result = await executePetition(url + "/setCliente", "POST", data);
    console.log(result);

    if (result.ok) {
      alertSuccess(result.message);
      modalAgregarCliente.hide();
      readCustomer();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  } finally {
    finallyLoaderButton(botonModal)
  }
};

//delete
const deleteCustomer = async (data) => {
  try {
    const result = await executePetition(url + `/eliminar/${data}`, "GET");
    if (result.ok) {
      alertSuccess(result.message);

      readCustomer();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//restablecer
const restablecerCustomers = async (data) => {
  try {
    const result = await executePetition(url + `/restablecer/${data}`, "GET");
    if (result.ok) {
      alertSuccess(result.message);
      readCustomer();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

readCustomer();

btnOpenModal.addEventListener("click", function () {
  //objetos con todos los parametros de la funcion
  const parametros = {
    labelModal: exampleModalLabel,
    textLabelModal: "Registrar Cliente",
    form: modalAgregar,
    modal: modalAgregar.parentElement.parentElement.parentElement,
    btnModal: botonModal,
    btnTextModal: "Registrar",
    inputs: inputs,
  };
  clearModalEnviar(parametros);
});

let verificarFormulario = inicializarValidacionFormulario(modalAgregar);

modalAgregar.addEventListener("submit", function (e) {
  e.preventDefault();

  let inputsBuenos = [];
  this.querySelectorAll(".input-validar").forEach((input) => {
    if (input.parentElement.classList.contains("valido"))
      inputsBuenos.push(true);
  });

  let esValido = verificarFormulario();

  if (esValido) {
    if (modalAgregar.classList.contains("editar")) {
      console.log("Actualizar cliente");
      updateCustomers(this, inputsBuenos);
    } else {
      console.log("Crear cliente");
      createCustomer(this, inputsBuenos);
    }
  } else {
    alertError(
      "Error",
      "Por favor verifique que todos los datos estén correctos.",
    );
  }
});
