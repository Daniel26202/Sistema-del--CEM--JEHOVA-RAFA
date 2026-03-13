import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
  returnModulos,
  hasPermision,
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

const returnFragmentHtml = (element) => {
  return `         
                        <div class="card contenido mb-4 mx-3" style="width: 18rem;">
        <img src="${urlBase}../src/assets/images/img/logoRol.jpeg" class="card-img-top" alt="...">
        <div class="card-body">
                                    <h5 class=" mb-1 ">
                                        ${element.nombre}
                                    </h5>
                                    <p class="mb-4">
                                        ${element.descripción}
                                    </p>
                                                

                                    <button href="#" class=" caja-btn-margin btn btn-modals botones-mostrar" data-index="${
                                      element.id_rol
                                    }" data-name="${element.nombre}"  data-descripcion="${element.descripción}" data-img=${element.id_rol}
                                        data-bs-toggle="modal" data-bs-target="#exampleGuardar">Mostrar</button>
                                </div>
                          </div>
                        
                        `;
};

//Ajax

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
        console.log(permisosGuardados);
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
    const categorias = returnModulos();

    for (const [categoria, modulos] of Object.entries(categorias)) {
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
                      <div class="card fondo-tabla mb-3 m-auto" style="width: 14rem;">
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

readRol();

readPermisos();

//abrir el modal de agregar
btnRegistrarRol.addEventListener("click", function () {
  modalRegistrarRol.show();
});

//validacion formulario
let verificarFormularioG = inicializarValidacionFormulario(formAgregarRol);

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
