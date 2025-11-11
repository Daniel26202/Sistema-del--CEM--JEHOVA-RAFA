import { executePetition } from "./funtionExecutePetition.js";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/Patologias";

const modalAgregar = document.getElementById("modalAgregar");
const selectGenero = document.getElementById("selectGenero");

//read

const readPathology = async () => {
  try {
    let metodo = "";
    let urlActual = window.location.href;

    if (!urlActual.includes("papelera")) metodo = "patologiasAjax";
    else metodo = "papeleraAjax";

    const result = await executePetition(url + "/" + metodo, "GET");

    // construir html de filas
    let html = "";
    result.forEach((element, index) => {
      html += `<tr>
                            <td class="text-center">${index + 1}</td>
                            <td class="text-center">${element.nombre_patologia}</td>
                            <td class="text-center">

                                    <button class="${
                                      urlActual.includes("papelera") ? "d-none" : ""
                                    } btn btn-tabla mb-1 btnModalEliminarPatologia btn-dt-tabla btn-eliminar"
                                    
                                        data-index="${element.id_patologia}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                        </svg>
                                    </button>

                                    <div class="me-2">
                    <a href="#" class="${
                      !urlActual.includes("papelera") ? "d-none" : ""
                    } btn btn-tabla btn-dt-tabla btnRestablecer"  data-index=${
        element.id_patologia
      }  title="Restablecer Paciente" uk-tooltip id="btnModalEliminarPaciente">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-arrow-counterclockwise " viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                      </svg>
                    </a>
                  </div>
                            </td>
                            
                        </tr>
`;
    });
    const selector = ".exampleTable";

    // si ya existe DataTable, destrúyela
    if ($.fn.DataTable.isDataTable(selector)) {
      $(selector).DataTable().clear().destroy();
    }

    // vuelca el html en el tbody
    document.querySelector(selector + " tbody").innerHTML = html;

    //llamar las funcion de eliminar
    document.querySelectorAll(".btn-eliminar").forEach((btn) => {
      btn.addEventListener("click", function () {
        const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];
        Swal.fire({
          icon: "question",
          title: "Confirmacion",
          text: "Esta seguro de eliminar la patologia?",
          confirmButtonText: "Aceptar",
          showCancelButton: true,
          confirmButtonText: "Aceptar",
          cancelButtonText: "Cancelar",
          customClass: {
            popup: "switAlert",
            confirmButton: "btn-agregarcita-modal",
            cancelButton: "btn-agregarcita-modal-cancelar",
          },
        }).then((result) => {
          if (result.isConfirmed) {
            deletePathology(data);
            console.log(data);
          }
        });
      });
    });

    //llamar a la uncion de restablecer
    document.querySelectorAll(".btnRestablecer").forEach((btn) => {
      btn.addEventListener("click", function () {
        const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];
        Swal.fire({
          icon: "question",
          title: "Confirmacion",
          text: "Esta seguro de restablecer la patologia?",
          showCancelButton: true,
          confirmButtonText: "Aceptar",
          cancelButtonText: "Cancelar",
          customClass: {
            popup: "switAlert",
            confirmButton: "btn-agregarcita-modal",
            cancelButton: "btn-agregarcita-modal-cancelar",
          },
        }).then((result) => {
          if (result.isConfirmed) {
            console.log(data);
            restablecerPathology(data);
          }
        });
      });
    });

    // re-inicializa
    $(selector).DataTable({
      language: {
        language: {
          decimal: ",",
          thousands: ".",
          lengthMenu: "Mostrar por página _MENU_ ",
          zeroRecords: "No se encontraron resultados",
          info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
          infoEmpty: "No hay registros disponibles",
          infoFiltered: "(filtrado de _MAX_ registros en total)",
          search: "Buscar:",
        },
      },
    });
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: `${error}`,
    });
  }
};
//create
const createPathology = async (form, inputs) => {
  try {
    const data = new FormData(form);
    let result = await executePetition(url + "/registrarPatologia", "POST", data);
    console.log(result);
    if (result.ok) {
      Swal.fire({
        icon: "success",
        title: "Exito",
        text: `${result.message}`,
        customClass: {
          popup: "switAlert",
          confirmButton: "btn-agregarcita-modal",
          cancelButton: "btn-agregarcita-modal-cancelar",
        },
      });
      UIkit.modal("#modal-exampleAgregarPatologias").hide();
      form.reset();
      inputs = [];
      inputs.forEach((input) => input.parentElement.classList.remove("grpFormCorrect"));
      readPathology();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: `${error}`,
      customClass: {
        popup: "switAlert",
        confirmButton: "btn-agregarcita-modal",
        cancelButton: "btn-agregarcita-modal-cancelar",
      },
    });
  }
};

//delete
const deletePathology = async (data) => {
  try {
    const result = await executePetition(url + `/eliminarPatologia/${data}`, "GET");
    if (result.ok) {
      Swal.fire({
        icon: "success",
        title: "Exito",
        text: `${result.message}`,
        customClass: {
          popup: "switAlert",
          confirmButton: "btn-agregarcita-modal",
          cancelButton: "btn-agregarcita-modal-cancelar",
        },
      });
      readPathology();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: `${error}`,
      customClass: {
        popup: "switAlert",
        confirmButton: "btn-agregarcita-modal",
        cancelButton: "btn-agregarcita-modal-cancelar",
      },
    });
  }
};

//restablecer
const restablecerPathology = async (data) => {
  try {
    const result = await executePetition(url + `/restablecerPatologia/${data}`, "GET");
    if (result.ok) {
      Swal.fire({
        icon: "success",
        title: "Exito",
        text: `${result.message}`,
        customClass: {
          popup: "switAlert",
          confirmButton: "btn-agregarcita-modal",
          cancelButton: "btn-agregarcita-modal-cancelar",
        },
      });
      readPathology();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: `${error}`,
      customClass: {
        popup: "switAlert",
        confirmButton: "btn-agregarcita-modal",
        cancelButton: "btn-agregarcita-modal-cancelar",
      },
    });
  }
};

readPathology();

if (modalAgregar) {
  modalAgregar.addEventListener("submit", function (e) {
    e.preventDefault();
    let inputsBuenos = [];
    this.querySelectorAll(".input-validar").forEach((input) => {
      if (input.parentElement.classList.contains("grpFormCorrect")) inputsBuenos.push(true);
    });

    if (inputsBuenos.length == 1) {
      createPathology(this, inputsBuenos);
    } else {
      Swal.fire({
        icon: "error",
        title: "Error al enviar el formulario",
        text: "Por favor verifique que todos los datos esten correctos.",
        customClass: {
          popup: "switAlert",
          confirmButton: "btn-agregarcita-modal",
          cancelButton: "btn-agregarcita-modal-cancelar",
        },
      });
    }
  });
}
