import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
  hasPermision,
  initDataTable,
} from "../generic/funtionGeneric.js";
import Paginator from "../generic/Paginator.js";
import { inicializarValidacionFormulario } from "../generic/expresionesModulares.js";

console.log("roles");

const url = "/Sistema-del--CEM--JEHOVA-RAFA/Roles";

const urlBase = document.getElementById("urlBase").value;

const formAgregarRol = document.getElementById("formAgregarRol");
const rol = document.getElementById("rol");
const btnRegistrarRol = document.getElementById("btnRegistrarrol");
const inputs = formAgregarRol.querySelectorAll(".input-validar");
const modalRegistrarRol = new bootstrap.Modal(
  document.getElementById("exampleGuardarRol"),
);

const id_rol = document.getElementById("id_rol");
// Input para buscar roles
const buscarRol = document.getElementById("buscarRol");
const nombreRegiistrado = document.getElementById("nombreRegiistrado");

const botonModal = document.getElementById("botonModal");
const titleModal = document.getElementById("title-modal");
const id_rol_global = document.getElementById("id_rol_global").value;
const btnEliminar = document.getElementById("btn-eliminar");
const formModulo = document.getElementById("formModulo");

const modalGestionarModulo = new bootstrap.Modal(
  document.getElementById("gestionarModulo"),
);

let listModule = [];

const returnFragmentHtml = (element) => {
  return `         
                        <div class="card contenido mb-4 mx-3" style="width: 18rem;">
        <img src="${urlBase}../src/assets/images/img/logoRol.jpeg" class="card-img-top" alt="...">
        <div class="card-body">
                                    <h5 class=" mb-1 ">
                                        ${element.nombre}
                                    </h5>
                                    <p class="mb-4">
                                        ${element.descripcion}
                                    </p>
                                                

                                    <button href="#" class=" caja-btn-margin btn btn-modals botones-mostrar" data-index="${
                                      element.id_rol
                                    }" data-name="${element.nombre}"  data-descripcion="${element.descripcion}" data-img=${element.id_rol}
                                        data-bs-toggle="modal" data-bs-target="#exampleGuardar">Mostrar</button>
                                </div>
                          </div>
                        
                        `;
};

//Ajax
const returnModuleCategiry = async () => {
  try {
    const modulos = await executePetition(
      "/Sistema-del--CEM--JEHOVA-RAFA/Permisos/returnPermisionModule",
    );

    // Clasificación de módulos en categorías.
    const clasificacion = {
      Administración: ["Usuarios", "Roles", "Mantenimiento"],
      "Gestión Médica": [
        "Pacientes",
        "Patologias",
        "Citas",
        "Servicios",
        "Hospitalizacion",
        "Doctores",
        "Control",
      ],
      Inventario: ["Insumos", "Entrada", "Proveedores"],
      Reportes: ["Factura", "Reportes", "Estadisticas"],
    };

    // Inicializamos un objeto para almacenar los módulos clasificados por categoría.
    const categorias = Object.keys(clasificacion).reduce((acc, categoria) => {
      acc[categoria] = []; // Inicializa cada categoría como un array vacío.
      return acc;
    }, {});

    // Clasificamos los módulos en las categorías correspondientes.
    modulos.forEach((modulo) => {
      for (const [categoria, modulosCategoria] of Object.entries(
        clasificacion,
      )) {
        // Si el módulo pertenece a la categoría actual, lo añadimos a esa categoría.

        if (modulosCategoria.includes(modulo.modulo)) {
          categorias[categoria].push(modulo);
          break; // Salimos del bucle interno una vez clasificado.
        }
      }
    });

    listModule = categorias;
  } catch (error) {
    alertError("Error", error);
  }
};


const readRol = async () => {
  try {
    console.log("cargada");

    const items = await executePetition(url + "/mostrarAjax", "GET");

    const paginator = new Paginator(
      items,
      3,
      "cardContainer",
      "pagination",
      "searchInput",
      returnFragmentHtml,
    );

    paginator.displayItems();

    document.querySelectorAll(".id_usuario_bitacora").forEach((ele) => {
      ele.value = document.getElementById("id_usuario_session").value;
    });

    //llamar las funcion de eliminar
    document
      .querySelector(".btn-eliminar")
      .addEventListener("click", function () {
        const data = [
          this.getAttribute("data-index"),
          document.getElementById("id_usuario_session").value,
        ];
        console.log(data);
        alertConfirm("Esta seguro de eliminar el rol?", deleteUser, data);
      });

    //mostrar modal
    document.querySelectorAll(".botones-mostrar").forEach((btn) => {
      btn.addEventListener("click", async function () {
        botonModal.innerHTML = "Modificar";
        titleModal.innerText = "Modificar Rol";
        document.querySelector(".btn-eliminar").classList.remove("d-none");

        id_rol.value = this.getAttribute("data-index");
        nombreRegiistrado.value = this.getAttribute("data-name");
        inputs[0].value = this.getAttribute("data-name");
        inputs[1].value = this.getAttribute("data-descripcion");

        //btn eliminar
        document
          .querySelector(".btn-eliminar")
          .setAttribute("data-index", this.getAttribute("data-index"));

        inputs.forEach((input) => {
          input.dispatchEvent(new Event("keyup", { bubbles: true }));
        });

        formAgregarRol.classList.add("editar");
        modalRegistrarRol.show();
        let permisosGuardados = await traerPermisosGuardados(
          this.getAttribute("data-index"),
        );
        console.log(this.getAttribute("data-index"), permisosGuardados);
        readPermisos(permisosGuardados);
      });
    });

    //////gestionar persmisos
    hasPermision(id_rol_global, "Roles", "guardar", ".btnOpenModal"); //guardar
    hasPermision(id_rol_global, "Roles", "eliminar", ".btn-eliminar"); //eliminar
    hasPermision(id_rol_global, "Roles", "editar", ".btn-open-editar"); //editar
  } catch (error) {
    alertError("Error", error);
  }
};

//create
const createRol = async (form) => {
  try {
    const data = new FormData(form);
    let result = await executePetition(url + "/guardarRol", "POST", data);
    console.log(result);

    if (result.ok) {
      alertSuccess(result.message);
      readRol();
      modalRegistrarRol.hide();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//update
const updateRol = async (form) => {
  try {
    const data = new FormData(form);
    let result = await executePetition(url + "/modificarRol", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);
      readRol();
      modalRegistrarRol.hide();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    console.log(error);
    alertError("Error", error);
  }
};

//delete
const deleteUser = async (data) => {
  try {
    const result = await executePetition(url + `/eliminarRol/${data}`, "GET");
    if (result.ok) {
      alertSuccess(result.message);
      modalRegistrarRol.hide();
      readRol();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

const traerPermisosGuardados = async (id_rol) => {
  try {
    const result = await executePetition(
      url + `/cargarPermisosGuardados/${id_rol}`,
      "GET",
    );
    return result;
  } catch (error) {
    return error;
  }
};
const readPermisos = async (permisosGuardados = {}) => {
  const accordionContainer = document.getElementById("accordion-div");
  if (!accordionContainer) return;

  accordionContainer.innerHTML = "";

  try {
    // 1. Obtenemos la lista maestra de permisos (id_permiso y nombre del permiso)
    const listaPermisosDB = await executePetition(
      "/Sistema-del--CEM--JEHOVA-RAFA/Roles/returnPermisos",
    );

    // 2. Traemos los módulos agrupados por categorías

    for (const [categoria, modulos] of Object.entries(listModule)) {
      const categoriaSlug = categoria.replace(/\s+/g, "-");
      const categoriaId = `heading-${categoriaSlug}`;
      const categoriaCollapseId = `collapse-${categoriaSlug}`;

      const categoriaDiv = document.createElement("div");
      categoriaDiv.classList.add("card", "mb-3", "w-100");

      categoriaDiv.innerHTML = `
          <h2 class="accordion-header" id="${categoriaId}">
              <button class="accordion-button bg-theme text-center" type="button" 
                      data-bs-toggle="collapse" data-bs-target="#${categoriaCollapseId}">
                  ${categoria}
              </button>
          </h2>
          <div id="${categoriaCollapseId}" class="accordion-collapse collapse" 
               aria-labelledby="${categoriaId}" data-bs-parent="#accordion-div">
              <div class="accordion-body d-flex flex-wrap cards-hours">
                  ${modulos
                    .map((modulo) => {
                      const modName = modulo.modulo;
                      const modId = modName.replace(/\s+/g, "-");

                      // 3. Convertimos el string "30,31,32,33," en un Array de Strings: ["30", "31", "32", "33"]
                      const IDsAsignados = permisosGuardados[modName]
                        ? permisosGuardados[modName]
                            .split(",")
                            .filter((id) => id !== "")
                        : [];

                      // 4. Generamos los switches comparando IDs
                      const switchesHTML = listaPermisosDB
                        .map((p, index) => {
                          // Comparamos el ID de la DB con los IDs que tiene el módulo en el objeto
                          const isChecked = IDsAsignados.includes(
                            p.id_permiso.toString(),
                          )
                            ? "checked"
                            : "";

                          return `
                              <div class="form-check form-switch d-flex align-items-center">
                                  <input class="form-check-input" type="checkbox" role="switch" 
                                      id="check-${index}-${modId}" 
                                      name="permisos[${modName}][]" 
                                      value="${p.id_permiso}" 
                                      ${isChecked}>
                                  <label class="form-check-label ms-2 mt-1" for="check-${index}-${modId}">
                                      ${p.permisos.charAt(0).toUpperCase() + p.permisos.slice(1)}
                                  </label>
                              </div>
                          `;
                        })
                        .join("");

                      return `
                      <div class="card fondo-tabla mb-3 m-auto w-100" style="width: 14rem;">
                          <input type='hidden' name="modulos[]" value="${modName}">
                          <div class="card-body">
                              <h5 class="card-title">${modName}</h5>
                              ${switchesHTML}
                          </div>
                      </div>`;
                    })
                    .join("")}
              </div>
          </div>
      `;
      accordionContainer.appendChild(categoriaDiv);
    }
  } catch (error) {
    console.error("Error al renderizar permisos:", error);
  }
};

///Gestion de modulos
const readModule = async () => {
  try {
    const result = await executePetition(
      "/Sistema-del--CEM--JEHOVA-RAFA/Permisos/returnModules",
    );
    console.log(result);
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
                                      <button class="btn-eliminar btn btn-tabla mb-1" data-index="${element.id_modulo}">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                              class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                              <path
                                                  d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                          </svg>
                                      </button>
  
                                  </td>
                              </tr>`;
    });

    const selector = ".exampleTableModulo";

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

        alertConfirm("Esta seguro de eliminar el modulo?", deleteModule, data);
      });
    });

    // re-inicializa

    initDataTable(selector);
  } catch (error) {
    alertError("Error", error);
  }
};

//create
const createModule = async (form) => {
  try {
    const data = new FormData(form);
    let result = await executePetition(
      "/Sistema-del--CEM--JEHOVA-RAFA/Permisos/registrarModulo",
      "POST",
      data,
    );
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);
      form.reset();

      readModule();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//delete
const deleteModule = async (data) => {
  try {
    const result = await executePetition(
      `/Sistema-del--CEM--JEHOVA-RAFA/Permisos/eliminar_modulo/${data}`,
      "GET",
    );
    if (result.ok) {
      alertSuccess(result.message);
      readModule();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

returnModuleCategiry();


readRol();

readPermisos();

readModule();

//abrir el modal de agregar
btnRegistrarRol.addEventListener("click", function () {
  modalRegistrarRol.show();
  botonModal.innerHTML = "Registrar";
  titleModal.innerText = "Registrar Rol";
  btnEliminar.classList.add("d-none");

  formAgregarRol.querySelectorAll(".input-validar").forEach((input) => {
    input.value = "";
    input.parentElement.classList.remove("invalido", "valido");
    input.nextElementSibling.children[0].classList.add("d-none");
    input.nextElementSibling.children[1].classList.add("d-none");
    input.parentElement.parentElement.children[1].classList.add("d-none");
  });
});

//cerrar modal del registrar modulo
document
  .getElementById("modalAgregarModulo")
  .addEventListener("hidden.bs.modal", function () {
    modalGestionarModulo.show();
    console.log("cerrado");
  });

//validacion formulario
let verificarFormularioG = inicializarValidacionFormulario(formAgregarRol);
let verificarFormulariosModulo = inicializarValidacionFormulario(formModulo);

formAgregarRol.addEventListener("submit", function (e) {
  e.preventDefault();
  let esValido = verificarFormularioG();

  if (esValido) {
    if (formAgregarRol.classList.contains("editar")) {
      updateRol(this);
    } else {
      console.log("guardar");
      createRol(this);
    }
  } else {
    alertError(
      "Error",
      "Por favor verifique que todos los datos estén correctos.",
    );
  }
});

formModulo.addEventListener("submit", function (e) {
  e.preventDefault();
  let esValido = verificarFormulariosModulo();

  if (esValido) {
    createModule(this);
  } else {
    alertError(
      "Error",
      "Por favor verifique que todos los datos estén correctos.",
    );
  }
});
