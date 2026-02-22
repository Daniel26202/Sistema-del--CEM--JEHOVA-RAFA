import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
  returnModulos,
} from "../generic/funtionGeneric.js";
import { inicializarValidacionFormulario } from "../generic/expresionesModulares.js";

console.log("roles");

const url = "/Sistema-del--CEM--JEHOVA-RAFA/Roles";

const urlBase = document.getElementById("urlBase").value;

const btnEditarUsuarios = document.querySelectorAll(".editarUsuario");
const imagenesUsuarios = document.querySelectorAll(".imagenesUsuarios");

const activarMostrarContra = document.querySelectorAll(".mostrarPassword");
const desMostrarContra = document.querySelectorAll(".ocultarPassword");

const formAgregarRol = document.getElementById("formAgregarRol");
const rol = document.getElementById("rol");
const btnRegistrarRol = document.getElementById("btnRegistrarrol");

const modalRegistrarRol = new bootstrap.Modal(
  document.getElementById("exampleGuardarRol"),
);

// Input para buscar roles
const buscarRol = document.getElementById("buscarRol");

// Filtrar tarjetas según el texto ingresado en el input
buscarRol.addEventListener("input", function () {
  const query = this.value.toLowerCase(); // Convertir a minúsculas para búsqueda insensible a mayúsculas
  document.querySelectorAll(".tarjeta").forEach((element) => {
    const nombreDelRol = element
      .querySelector(".card-title")
      .innerText.toLowerCase();
    element.classList.toggle("d-none", !nombreDelRol.includes(query));
  });
});

btnRegistrarRol.addEventListener("click", function () {
  modalRegistrarRol.show();
});

// Función para manejar el evento de "Todos los Permisos"
function manejarCheckboxTodosLosPermisos(modal, checkboxTodos) {
  const allCheckboxes = modal.querySelectorAll('input[type="checkbox"]');
  checkboxTodos.addEventListener("change", function () {
    allCheckboxes.forEach((checkbox) => {
      checkbox.checked = checkboxTodos.checked;
    });
  });

  // Validar que al menos "consultar" esté seleccionado en cada sección
  const sections = modal.querySelectorAll(".accordion-section");
  // modal.querySelector("form").addEventListener("submit", function (event) {
  //   console.log(modal);
  //   let isValid = true;
  //   let listPermisos = [];
  //   sections.forEach((section) => {
  //     const consultarCheckbox = section.querySelector('input[value="consultar"]');
  //     if (!consultarCheckbox.checked) {
  //       isValid = false;
  //     } else {
  //       section.classList.remove("error");
  //       listPermisos.push(consultarCheckbox.value);
  //     }
  //   });

  //   if (!isValid) {
  //     event.preventDefault(); // Prevenir envío del formulario
  //     alertError("Error", "Debe seleccionar al menos 'Consultar' en cada sección..");
  //   }

  //   if (listPermisos.length >= 1) {
  //     createRol(modal.querySelector("form"), document.querySelectorAll(".input-validar"));
  //   } else {
  //     alertError("Error", "Por favor verifique que todos los datos esten correctos.");
  //   }
  // });
}

// Función para manejar los checkboxes dentro de cada sección del acordeón
function manejarCheckboxConsultar(section) {
  const consultarCheckbox = section.querySelector('input[value="consultar"]');
  const otherCheckboxes = section.querySelectorAll(
    'input[value="guardar"], input[value="editar"], input[value="eliminar"]',
  );

  consultarCheckbox.addEventListener("change", function () {
    const isChecked = consultarCheckbox.checked;
    otherCheckboxes.forEach((checkbox) => {
      checkbox.checked = false; // Desmarcar siempre al cambiar
      checkbox.disabled = !isChecked; // Habilitar o deshabilitar según el estado de "Consultar"
    });
  });
}

// Manejar eventos de los botones "Mostrar Permisos"
document.querySelectorAll(".btn-mostrar-permisos").forEach((btn) => {
  btn.addEventListener("click", function () {
    const id_rol = this.getAttribute("data-index"); // Obtener ID del rol
    const modalMostrar = document.getElementById(
      "modal-exampleMostrar" + id_rol,
    ); // Modal específico
    const checkboxTodosLosPermisos = modalMostrar.querySelector(
      ".checkboxTodosLosPermisos" + id_rol,
    );

    // Manejar el checkbox de "Todos los Permisos"
    manejarCheckboxTodosLosPermisos(modalMostrar, checkboxTodosLosPermisos);

    // Manejar cada sección del acordeón
    modalMostrar
      .querySelectorAll(".accordion-section")
      .forEach(manejarCheckboxConsultar);
  });
});





// Manejar el modal de "Guardar"
const modalGuardar = document.getElementById("modal-exampleGuardar");
// const checkboxTodosLosPermisosGuardar = modalGuardar.querySelector(".checkboxTodosLosPermisos");

// Manejar el checkbox de "Todos los Permisos" en el modal de "Guardar"
// manejarCheckboxTodosLosPermisos(modalGuardar, checkboxTodosLosPermisosGuardar);

// Manejar cada sección del acordeón en el modal de "Guardar"
// modalGuardar.querySelectorAll(".accordion-section").forEach(manejarCheckboxConsultar);

//Ajax

const readRol = async () => {
  try {
    console.log("cargada");

    const result = await executePetition(url + "/mostrarAjax", "GET");

    // construir html de filas
    let html = "";
    result.forEach((element) => {
      html += `         
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
                                    }" data-img=${element.id_rol}
                                        data-bs-toggle="modal" data-bs-target="#exampleGuardar">Mostrar</button>
                                </div>
                          </div>
                        
                        `;
    });

    // vuelca el html en el tbody
    document.getElementById("div-rol").innerHTML = html;

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
        console.log(data);
        alertConfirm("Esta seguro de eliminar el rol?", deleteUser, data);
      });
    });



    //mostrar modal
document.querySelectorAll('.botones-mostrar').forEach(btn=>{
  btn.addEventListener('click', function(){
    console.log('cllikc')
    modalRegistrarRol.show();
  })
})

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
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//update
const updateUser = async (form, inputs) => {
  try {
    const data = new FormData(form);
    console.log(form);
    console.log(inputs);

    let result = await executePetition(url + "/editarUsuario", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);

      UIkit.modal(
        `#${form.parentElement.parentElement.getAttribute("id")}`,
      ).hide();
      inputs = [];
      inputs.forEach((input) =>
        input.parentElement.classList.remove("grpFormCorrect"),
      );
      readRol();
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

      readRol();

      UIkit.modal(`#modal-exampleMostrar${data[0]}`).hide();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//update
const updateRol = async (form, inputs) => {
  try {
    const data = new FormData(form);

    let result = await executePetition(url + "/modificarRol", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);

      UIkit.modal(
        `#modal-exampleMostrar${form.getAttribute("data-index")}`,
      ).hide();
      inputs = [];
      inputs.forEach((input) =>
        input.parentElement.classList.remove("grpFormCorrect"),
      );
      readRol();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    console.log(error);
    alertError("Error", error);
  }
};

const readPermisos = () => {
  console.log(returnModulos());

  // Generar acordeones
  const accordionContainer = document.getElementById("accordion-div");

  //guardar los permisos en la constante categoria'
  const categorias = returnModulos();

  for (const [categoria, modulos] of Object.entries(categorias)) {
    // Crear el acordeón para la categoría
    const categoriaId = `heading-${categoria.replace(/\s+/g, "-")}`;
    const categoriaCollapseId = `collapse-${categoria.replace(/\s+/g, "-")}`;

    const categoriaDiv = document.createElement("div");
    categoriaDiv.classList.add("card", "mb-3", "w-100");

    categoriaDiv.innerHTML = `
       <h2 class="accordion-header" id="${categoriaId}">
            <button class="accordion-button bg-theme text-center"  type="button" data-bs-toggle="collapse" data-bs-target="#${categoriaCollapseId}" aria-expanded="true" aria-controls="${categoriaCollapseId}">
                ${categoria}
            </button>
        </h2>
        <div id="${categoriaCollapseId}" class="accordion-collapse collapse" aria-labelledby="${categoriaId}" data-bs-parent="#${categoriaCollapseId}">
            <div class="accordion-body d-flex flex-wrap cards-hours">
                ${modulos
                  .map(
                    (modulo) =>
                      `
                       <div class="card fondo-tabla mb-3 m-auto" style="width: 14rem;">
                    <input type='hidden' name="modulos[]" value=${modulo.modulo}>
                        <div class="card-body">
                            <h5 class="card-title">${modulo.modulo}</h5>

                            <div class="form-check form-switch d-flex align-items-center">
                              <div>
                                <input class="form-check-input tiposDePago" type="checkbox" role="switch" id="flexSwitchCheckDefault0${modulo}" name="permisos[]" value="consultar">
                              </div>
                              <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault0${modulo}">
                                Consultar
                              </label></div>

                             </div>

                            <div class="form-check form-switch d-flex align-items-center">
                              <div>
                                <input class="form-check-input tiposDePago" type="checkbox" role="switch" id="flexSwitchCheckDefault1${modulo}" name="permisos[]" value="guardar">
                              </div>
                              <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault1${modulo}">
                                Guardar
                              </label></div>

                             </div>

                             <div class="form-check form-switch d-flex align-items-center">
                              <div>
                                <input class="form-check-input tiposDePago" type="checkbox" role="switch" id="flexSwitchCheckDefault2${modulo}" name="permisos[]" value="editar">
                              </div>
                              <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault2${modulo}">
                                Editar
                              </label></div>

                             </div>


                             <div class="form-check form-switch d-flex align-items-center">
                              <div>
                                <input class="form-check-input tiposDePago" type="checkbox" role="switch" id="flexSwitchCheckDefault3${modulo}" name="permisos[]" value="eliminar">
                              </div>
                              <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault3${modulo}">
                                Eliminar
                              </label></div>

                             </div>

                        </div>
                    </div>`,
                  )
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
      // updatePatients(this);
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
