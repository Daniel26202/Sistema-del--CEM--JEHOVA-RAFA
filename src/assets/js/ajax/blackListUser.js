import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
  initDataTable,
  showDataModal,
  clearModalEnviar,
  hasPermision,
  alertInfo,
  initLoaderButton,
  finallyLoaderButton,
} from "../generic/funtionGeneric.js";

import { inicializarValidacionFormulario } from "../generic/expresionesModulares.js";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/Usuarios";

addEventListener("DOMContentLoaded", function () {
  console.log("hola");
  const modalAddUserBlckList = new bootstrap.Modal(
    document.getElementById("modalAddUserBlckList"),
  );
  const formAgregarBlackList = document.getElementById("formAgregarBlackList");
  const botonModal = document.getElementById("botonModal");
  const selectUser = document.getElementById("select-user");
  const btnOpenModal = document.getElementById("btnOpenModal");
  const exampleModalLabel = document.getElementById("labelBlackList");
  const inputs = formAgregarBlackList.querySelectorAll(".inputs");

  const selector = ".exampleTable";

  let verificarFormulario =
    inicializarValidacionFormulario(formAgregarBlackList);

  //read
  const readBlackList = async () => {
    try {
      // const result = await executePetition(url + "/listaNegraAjax", "GET");
      // console.log(result);

      // // construir html de filas
      // let html = "";
      // result.forEach((element) => {
      //   html += `
      //             <tr  class="text-align-left">
      //                 <td class="">${element.nacionalidad}-${element.cedula}</td>
      //                 <td class="">${element.nombre}</td>
      //                 <td class="">${element.apellido}</td>
      //                 <td class="">${element.telefono}</td>
      //                 <td class="">${element.correo}</td>
      //                 <td class="">${element.user}</td>
      //                 <td class="text-center">
      //                         <button class=" btn btn-tabla btn-dt-tabla mb-1 btnRestablecer" data-index="${element.id_usuario}" title="Restablecer Paciente" uk-tooltip="" id="btnModalEliminarPaciente">
      //                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise " viewBox="0 0 16 16">
      //                             <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>
      //                             <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
      //                     </div>
      //                 </td>
      //             </tr>
      //       `;
      // });

      // si ya existe DataTable, destrúyela
      if ($.fn.DataTable.isDataTable(selector)) {
        $(selector).DataTable().clear().destroy();
      }

      const columnsBlackList = [
        {
          data: "cedula",
          render: (data, type, row) => `${row.nacionalidad}-${data}`,
        },
        { data: "nombre" },
        { data: "apellido" },
        { data: "telefono" },
        { data: "correo" },
        { data: "user" },
        {
          data: null,
          orderable: false,
          render: function (data, type, row) {
            return `<button class=" btn btn-tabla btn-dt-tabla mb-1 btnRestablecer" data-index="${row.id_usuario}" title="Desbloquear Usuario." uk-tooltip="" id="btnModalEliminarPaciente">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise " viewBox="0 0 16 16">
                                  <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>
                                  <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                                </svg>
                              </button>`;
          },
        },
      ];

      const asignarEventos = () => {
        //llamar las funcion de eliminar
        document.querySelectorAll(".btnRestablecer").forEach((btn) => {
          btn.addEventListener("click", function () {
            const data = [this.getAttribute("data-index")];
            alertConfirm(
              "Esta seguro de desbloquear el usuario?",
              restablecerUsuario,
              data,
            );
          });
        });
      };

      // re-inicializa
      initDataTable(
        selector,
        url + "/listaNegraAjax",
        columnsBlackList,
        (datosServer) => console.log(datosServer),
        asignarEventos,
      );
    } catch (error) {
      alertError("Error", error);
    }
  };

  //read
  const readUserList = async () => {
    try {
      const result = await executePetition(url + "/listaUserAjax", "GET");
      console.log(result);

      // construir html de filas
      let html =
        '<option class="option-select-background" selected="" value="" disabled>Seleccionar Usuario</option>';
      result.forEach((element) => {
        html += `
                <option class="option-select-background" value="${element.id_usuario}">
                  ${element.user}
                </option>
            `;
      });

      selectUser.innerHTML = html;
    } catch (error) {
      alertError("Error", error);
    }
  };

  //agregar

  //create
  const addUserBlackList = async (form) => {
    try {
      initLoaderButton(botonModal);
      const data = new FormData(form);
      let result = await executePetition(
        url + "/addUserBlackList",
        "POST",
        data,
      );
      console.log(result);
      if (result.ok) {
        alertSuccess(result.message);
        modalAddUserBlckList.hide();
        form.reset();
        readBlackList();
        readUserList();
      } else throw new Error(`${result.error}`);
    } catch (error) {
      alertError("Error", error);
    } finally {
      finallyLoaderButton(botonModal, "Agregar");
    }
  };

  //delete
  const restablecerUsuario = async (data) => {
    try {
      const payload = { id: data[0] };
      const result = await executePetition(
        url + `/removeBlackList`,
        "POST",
        payload,
      );

      if (result.ok) {
        alertSuccess(result.message);
        readBlackList();
        readUserList();
      } else throw new Error(`${result.error}`);
    } catch (error) {
      alertError("Error", error);
    }
  };

  readBlackList();
  readUserList();

  btnOpenModal.addEventListener("click", function () {
    //objetos con todos los parametros de la funcion
    const parametros = {
      labelModal: exampleModalLabel,
      textLabelModal: "Agregar usuario a la lista negra",
      form: formAgregarBlackList,
      modal: formAgregarBlackList.parentElement.parentElement.parentElement,
      btnModal: botonModal,
      btnTextModal: "Agregar",
      inputs: inputs,
    };
    clearModalEnviar(parametros);
    console.log("si");
  });

  formAgregarBlackList.addEventListener("submit", function (e) {
    e.preventDefault();
    let esValido = verificarFormulario();

    if (esValido) {
      addUserBlackList(this);
      return;
    }

    alertError(
      "Error",
      "Por favor verifique que todos los datos estén correctos.",
    );
  });
});
