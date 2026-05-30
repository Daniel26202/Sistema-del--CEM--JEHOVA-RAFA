import { executePetition, alertConfirm, alertError, alertSuccess, clearModalEnviar, initDataTable } from "../generic/funtionGeneric.js";
import { inicializarValidacionFormulario } from "../generic/expresionesModulares.js";

const url = "/Sistema-del--CEM--JEHOVA-RAFA/Servicios";

const formulario = document.getElementById("formularioCategoria");
const openBotonModalServicio = document.getElementById(
  "openBotonModalServicio",
);
const botonModalServicio = document.getElementById('botonModalServicio');
const inputs =formulario.querySelectorAll('.input-validar')
const exampleModalLabel = document.getElementById("modalLabelServicios"); 

// modal categoria
const modalCategoria = new bootstrap.Modal(
  document.getElementById("modal-categoria"),
);
//modal agregar categoria
const modalAgregarCategoria = new bootstrap.Modal(
  document.getElementById("modalAgregarPatologias"),
);

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
       
        initDataTable(selector)
    } catch (error) {
        alertError("Error", error);
    }
};
//create
const createcategory = async (form) => {
    try {
        const data = new FormData(form);
        let result = await executePetition(url + "/registrarCategoria", "POST", data);
        console.log(result);
        if (result.ok) {
            alertSuccess(result.message);
            form.reset();
            modalAgregarCategoria.hide();
            modalCategoria.show();
            readCategory();
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


openBotonModalServicio.addEventListener("click", function () {
  
  //objetos con todos los parametros de la funcion
  const parametros = {
    labelModal: exampleModalLabel,
    textLabelModal: "Registrar Categoría",
    form: formulario,
    modal: formulario.parentElement.parentElement.parentElement,
    btnModal: botonModalServicio,
    btnTextModal: "Registrar",
    inputs: inputs,
  };
  clearModalEnviar(parametros);
});


let verificarFormulario = inicializarValidacionFormulario(formulario);

formulario.addEventListener("submit", function (e) {
    e.preventDefault();

    let inputsBuenos = [];
    this.querySelectorAll(".input-validar").forEach((input) => {
        if (input.parentElement.classList.contains("valido")) inputsBuenos.push(true);
    });

    let esValido = verificarFormulario();

    if (esValido) {
        createcategory(this, inputsBuenos);
    } else {
        alertError("Error", "Por favor verifique que todos los datos estén correctos.");
    }
});
