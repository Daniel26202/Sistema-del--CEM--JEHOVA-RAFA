import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
  initDataTable,
  showDataModal,
  clearModalEnviar,
} from "../generic/funtionGeneric.js";
import { inicializarValidacionFormulario } from "../generic/expresionesModulares.js";

addEventListener("DOMContentLoaded", function () {
  console.log("entradas.js ...");

  const valorDolar = localStorage.getItem("valorDelDolar");

  const url = "/Sistema-del--CEM--JEHOVA-RAFA/Entrada";

  const formAgregarEntrada = document.getElementById("formAgregarEntrada");
  const inputs = formAgregarEntrada.querySelectorAll(".input-validar");
  const modalAgregarEntrada = new bootstrap.Modal(
    document.getElementById("exampleModalagregarEntrada"),
  );
  const botonModal = document.getElementById("botonModal");
  const exampleModalLabel = document.getElementById("exampleModalLabelEntrada");

  const btnOpenModal = document.getElementById("btnOpenModal");
  const id_entrada = document.getElementById("id_entrada");

  const readEntrada = async () => {
    try {
      let metodo = "";
      let urlActual = window.location.href;

      if (!urlActual.includes("papelera")) metodo = "entradasAjax";
      else metodo = "entradasPapeleraAjax";

      const result = await executePetition(url + "/" + metodo, "GET");
      console.log(result);
      // construir html de filas
      let html = "";
      if (result.length > 0) {
        result.forEach((element) => {
          html += `<tr>
                            <td class="text-center">${element.nombre}</td>
                            <td class="text-center">${element.proveedor}</td>
                            <td class="text-center">${element.fechaDeIngreso}</td>
                            <td class="text-center">${element.fechaDeVencimiento}</td>
                            <td class="text-center">${element.cantidad_entrada}</td>
                            <td class="text-center">${element.precio_entrada} BS</td>
                            <td class="text-center">${element.numero_de_lote}</td>



                            <td class="text-center">

                                <div class="d-flex justify-content-center align-items-center">
                                    <!-- eliminar -->
                                    <div class="me-2">
                                        <button class="${
                                          !urlActual.includes("papelera")
                                            ? ""
                                            : "d-none"
                                        } btn btn-tabla btn-eliminar btnEliminarDoctor btn-dt-tabla mb-1" data-index="${
                                          element.id_entrada
                                        }">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- eliminar -->
                                    <div>
                                        <button class="${
                                          !urlActual.includes("papelera")
                                            ? ""
                                            : "d-none"
                                        } btn btnEditarDoctor btn-tabla btn-dt-tabla mb-1 btn-js editar botonesEdi" data-bs-toggle="modal" data-bs-target="#exampleModalagregarEntrada" data-index='${element.id_entrada}' data-insumo=${element.id_insumo} data-proveedor=${element.id_proveedor} data-precio=${element.precio_entrada}>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                            </svg>
                                        </button>
                                    </div>


                                    <div class="me-2">
                    <a href="#" class=" btn btn-tabla btn-dt-tabla btnRestablecer ${
                      urlActual.includes("papelera") ? "" : "d-none"
                    }" data-index="${element.id_entrada}" title="Restablecer Entrada" uk-tooltip=""  aria-describedby="uk-tooltip-27">
                      <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-arrow-counterclockwise " viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>
                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                      </svg>
                    </a>
                  </div>



                                </div>
                                <!-- modal editar -->

  

                            </td>
                        </tr>`;
        });
      }

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
            "Esta seguro de eliminar la entrada?",
            deleteEntrada,
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
            "Esta seguro de restablecer la entrada ?",
            restablecerEntrada,
            data,
          );
        });
      });

      //llamar las funcion de eliminar
      document.querySelectorAll(".botonesEdi").forEach((btn) => {
        btn.addEventListener("click", function () {
          //objetos con todos los parametros de la funcion
          const parametros = {
            labelModal: exampleModalLabel,
            textLabelModal: "Modificar Entrada",
            form: formAgregarEntrada,
            modal: formAgregarEntrada.parentElement.parentElement.parentElement,
            btnModal: botonModal,
            btnTextModal: "Modificar",
            data: {
              fechaDeVencimiento: btn.closest("tr").children[3].innerText,
              cantidad: btn.closest("tr").children[4].innerText,
              lote: btn.closest("tr").children[6].innerText,

              id_insumo: btn.getAttribute("data-insumo"),
              proveedor: btn.getAttribute("data-proveedor"),
              precioD: btn.getAttribute("data-precio"),
              precio: parseFloat(btn.getAttribute("data-precio") * valorDolar),
              id: btn.getAttribute("data-index"),
            },
            inputs: inputs,
            // cedulaOculta: cedulaRegistrada,
            idOculto: id_entrada,
          };
          showDataModal(parametros);
        });
      });

      // re-inicializa
      initDataTable(selector);
    } catch (error) {
      alertError("Error", error);
    }
  };

  //delete
  const deleteEntrada = async (data) => {
    try {
      const result = await executePetition(url + `/eliminar/${data}`, "GET");
      if (result.ok) {
        alertSuccess(result.message);

        readEntrada();
      } else throw new Error(`${result.error}`);
    } catch (error) {
      alertError("Error", error);
    }
  };

  //create
  const createEntrada = async (form) => {
    try {
      const data = new FormData(form);
      let result = await executePetition(url + "/guardar", "POST", data);
      console.log(result);
      if (result.ok) {
        alertSuccess(result.message);

        readEntrada();
        modalAgregarEntrada.hide();
      } else throw new Error(`${result.error}`);
    } catch (error) {
      alertError("Error", error);
    }
  };

  //update
  const updateEntrada = async (form, inputs) => {
    console.log(url + "/editar");
    try {
      const data = new FormData(form);
      let result = await executePetition(url + "/editar", "POST", data);
      console.log(result);
      if (result.ok) {
        alertSuccess(result.message);

        modalAgregarEntrada.hide();
        readEntrada();
      } else throw new Error(`${result.error}`);
    } catch (error) {
      console.log(error);
      alertError("Error", error);
    }
  };

  //restablecer
  const restablecerEntrada = async (data) => {
    try {
      const result = await executePetition(
        url + `/restablecerEntrada/${data}`,
        "GET",
      );
      if (result.ok) {
        alertSuccess(result.message);

        readEntrada();
      } else throw new Error(`${result.error}`);
    } catch (error) {
      alertError("Error", error);
    }
  };

  readEntrada();

  btnOpenModal.addEventListener("click", function () {
    //objetos con todos los parametros de la funcion
    const parametros = {
      labelModal: exampleModalLabel,
      textLabelModal: "Registrar Entrada",
      form: formAgregarEntrada,
      modal: formAgregarEntrada.parentElement.parentElement.parentElement,
      btnModal: botonModal,
      btnTextModal: "Registrar",
      inputs: inputs,
    };
    clearModalEnviar(parametros);
  });

  console.log(formAgregarEntrada);
  //verificar el envio del formulario
  let verificarFormulario = inicializarValidacionFormulario(formAgregarEntrada);

  formAgregarEntrada.addEventListener("submit", function (e) {
    e.preventDefault();

    let esValido = verificarFormulario();

    if (esValido) {
      if (formAgregarEntrada.classList.contains("editar")) {
        console.log("editar");
        updateEntrada(this);
      } else {
        console.log("guardar");

        createEntrada(this);
      }
    } else {
      alertError(
        "Error",
        "Por favor verifique que todos los datos estén correctos.",
      );
    }
  });
});
