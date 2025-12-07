import { executePetition, alertConfirm, alertError, alertSuccess } from "./funtionExecutePetition.js";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/Consultas";

const modalAgregar = document.getElementById("modalAgregarCategoria");

//read

const readCategory = async () => {
  try {
    const result = await executePetition(url + "/categoriasAjax", "GET");

    // construir html de filas
    let html = "";
    result.forEach((element, index) => {
      html += ` <tr>
                                <td class="text-center fw-bold">
                                    ${index + 1}
                                </td>

                                <td class="text-center border-start">
                                    ${element.nombre}
                                </td>


                                <td class="border-start text-center">
                                    <button class="btn-eliminar btn btn-tabla mb-1" data-index="${element.id_categoria}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                        </svg>
                                    </button>

                                </td>
                            </tr>`;
    });

    const selector = ".exampleTableCategoria";

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
        const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];

        alertConfirm("Esta seguro de eliminar la categoria?", deleteCategory, data);
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
    alertError("Error", error);
  }
};
//create
const createcategory = async (form, inputs) => {
  try {
    const data = new FormData(form);
    let result = await executePetition(url + "/registrarCategoria", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);

      UIkit.modal("#modal-exampleAgregarPatologias").hide();
      form.reset();
      inputs = [];
      inputs.forEach((input) => input.parentElement.classList.remove("grpFormCorrect"));
      readCategory();
      UIkit.modal("#modal-categoria").show();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//delete
const deleteCategory = async (data) => {
  try {
    const result = await executePetition(url + `/eliminarCategoria/${data}`, "GET");
    if (result.ok) {
      alertSuccess(result.message);
      readCategory();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

readCategory();

modalAgregar.addEventListener("submit", function (e) {
  e.preventDefault();
  let inputsBuenos = [];
  this.querySelectorAll(".input-validar").forEach((input) => {
    if (input.parentElement.classList.contains("grpFormCorrect")) inputsBuenos.push(true);
  });

  if (inputsBuenos.length == 1) {
    createcategory(this, inputsBuenos);
  } else {
    alertError("Error al enviar el formulario", "Por favor verifique que todos los datos esten correctos.");
  }
});
