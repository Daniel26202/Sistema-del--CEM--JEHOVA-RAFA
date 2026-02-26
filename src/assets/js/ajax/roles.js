import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
  returnModulos,
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
      1,
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

        readPermisos(permisosGuardados);
      });
    });
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
    return 0;
  }
};

const readPermisos = (permisosGuardados = {}) => {
  const accordionContainer = document.getElementById("accordion-div");
  accordionContainer.innerHTML = "";

  // Trae la lista completa de TODOS los módulos del sistema
  const categorias = returnModulos();

  for (const [categoria, modulos] of Object.entries(categorias)) {
    const categoriaSlug = categoria.replace(/\s+/g, "-");
    const categoriaId = `heading-${categoriaSlug}`;
    const categoriaCollapseId = `collapse-${categoriaSlug}`;

    const categoriaDiv = document.createElement("div");
    categoriaDiv.classList.add("card", "mb-3", "w-100");

    categoriaDiv.innerHTML = `
        <h2 class="accordion-header" id="${categoriaId}">
            <button class="accordion-button bg-theme text-center" type="button" data-bs-toggle="collapse" data-bs-target="#${categoriaCollapseId}" aria-expanded="true" aria-controls="${categoriaCollapseId}">
                ${categoria}
            </button>
        </h2>
        <div id="${categoriaCollapseId}" class="accordion-collapse collapse" aria-labelledby="${categoriaId}" data-bs-parent="#accordion-div">
            <div class="accordion-body d-flex flex-wrap cards-hours">
                ${modulos
                  .map((modulo) => {
                    const modName = modulo.modulo;
                    const modId = modName.replace(/\s+/g, "-");

                    // 1. Buscamos si el rol tiene permisos en este módulo específico
                    // Si el rol tiene "Usuarios": "consultar,guardar", esto crea ['consultar', 'guardar']
                    const permisosDeEsteModulo = permisosGuardados[modName]
                      ? permisosGuardados[modName].split(",")
                      : [];

                    // 2. Función que verifica si el permiso actual está en la lista del rol
                    const isChecked = (permiso) =>
                      permisosDeEsteModulo.includes(permiso) ? "checked" : "";

                    return `
                    <div class="card fondo-tabla mb-3 m-auto" style="width: 14rem;">
                        <input type='hidden' name="modulos[]" value="${modName}">
                        
                        <div class="card-body">
                            <h5 class="card-title">${modName}</h5>

                            <div class="form-check form-switch d-flex align-items-center">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                    id="check-0-${modId}" 
                                    name="permisos[${modName}][]" value="consultar" ${isChecked("consultar")}>
                                <label class="form-check-label ms-2 mt-1" for="check-0-${modId}">Consultar</label>
                            </div>

                            <div class="form-check form-switch d-flex align-items-center">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                    id="check-1-${modId}" 
                                    name="permisos[${modName}][]" value="guardar" ${isChecked("guardar")}>
                                <label class="form-check-label ms-2 mt-1" for="check-1-${modId}">Guardar</label>
                            </div>

                            <div class="form-check form-switch d-flex align-items-center">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                    id="check-2-${modId}" 
                                    name="permisos[${modName}][]" value="editar" ${isChecked("editar")}>
                                <label class="form-check-label ms-2 mt-1" for="check-2-${modId}">Editar</label>
                            </div>

                            <div class="form-check form-switch d-flex align-items-center">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                    id="check-3-${modId}" 
                                    name="permisos[${modName}][]" value="eliminar" ${isChecked("eliminar")}>
                                <label class="form-check-label ms-2 mt-1" for="check-3-${modId}">Eliminar</label>
                            </div>
                        </div>
                    </div>`;
                  })
                  .join("")}
            </div>
        </div>
    `;

    accordionContainer.appendChild(categoriaDiv);
  }
};

readRol();

readPermisos();

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
