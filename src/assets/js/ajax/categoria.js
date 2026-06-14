import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
  clearModalEnviar,
  initDataTable,
} from "../generic/funtionGeneric.js";
import { inicializarValidacionFormulario } from "../generic/expresionesModulares.js";

const url = "/Sistema-del--CEM--JEHOVA-RAFA/Servicios";

const formulario = document.getElementById("formularioCategoria");
const openBotonModalServicio = document.getElementById(
  "openBotonModalServicio",
);
const btnAgregarCategoria = document.getElementById("btnAgregarCategoria");
const botonModalServicio = document.getElementById("botonModalServicio");
const inputs = formulario.querySelectorAll(".input-validar");
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
    const selector = ".exampleTableCategoria";

    // si ya existe DataTable, destrúyela
    if ($.fn.DataTable.isDataTable(selector)) {
      $(selector).DataTable().clear().destroy();
    }

    const columsCategoria = [
      {
        data: null,
        render: function (data, type, row, meta) {
          // Genera el número de fila real tomando en cuenta la paginación actual
          return meta.row + meta.settings._iDisplayStart + 1;
        },
      },
      { data: "nombre" },
      {
        data: null,
        orderable: false,
        render: function (data, type, row) {
          return ` <button class="btn-eliminar-categoria btn btn-tabla mb-1" data-index="${row.id_categoria}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                        </svg>
                                    </button>`;
        },
      },
    ];

  const asignarEvestos = () => {
    //llamar las funcion de eliminar
    document.querySelectorAll(".btn-eliminar-categoria").forEach((btn) => {
        btn.addEventListener("click", function () {
            const data = [this.getAttribute("data-index")];
            alertConfirm(
            "Esta seguro de eliminar la categoria?",
            deleteCategory,
            data,
            );
        });
    });
  };
    // re-inicializa

    initDataTable(selector,`${url}/categoriasAjax`,columsCategoria,(datosServer)=>{console.log(datosServer);
    }, asignarEvestos);
  } catch (error) {
    alertError("Error", error);
  }
};
//create
const createcategory = async (form) => {
  try {
    const data = new FormData(form);
    let result = await executePetition(
      url + "/registrarCategoria",
      "POST",
      data,
    );
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
    const result = await executePetition(
      url + `/eliminarCategoria/${data}`,
      "GET",
    );
    if (result.ok) {
      alertSuccess(result.message);
      readCategory();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};


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

btnAgregarCategoria.addEventListener('click',function(){
    readCategory();
})

let verificarFormulario = inicializarValidacionFormulario(formulario);

formulario.addEventListener("submit", function (e) {
  e.preventDefault();

  let inputsBuenos = [];
  this.querySelectorAll(".input-validar").forEach((input) => {
    if (input.parentElement.classList.contains("valido"))
      inputsBuenos.push(true);
  });

  let esValido = verificarFormulario();

  if (esValido) {
    createcategory(this, inputsBuenos);
  } else {
    alertError(
      "Error",
      "Por favor verifique que todos los datos estén correctos.",
    );
  }
});
