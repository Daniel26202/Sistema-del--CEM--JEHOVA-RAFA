import { executePetition, alertConfirm, alertError, alertSuccess } from "./funtionExecutePetition.js";

console.log("roles");

const url = "/Sistema-del--CEM--JEHOVA-RAFA/Roles";

const urlBase = document.getElementById("urlBase").value;

const btnEditarUsuarios = document.querySelectorAll(".editarUsuario");
const imagenesUsuarios = document.querySelectorAll(".imagenesUsuarios");

const activarMostrarContra = document.querySelectorAll(".mostrarPassword");
const desMostrarContra = document.querySelectorAll(".ocultarPassword");

const modalAgregar = document.getElementById("formAgregarAdmin");
const rol = document.getElementById("rol");

// Input para buscar roles
const buscarRol = document.getElementById("buscarRol");

// Filtrar tarjetas según el texto ingresado en el input
buscarRol.addEventListener("input", function () {
  const query = this.value.toLowerCase(); // Convertir a minúsculas para búsqueda insensible a mayúsculas
  document.querySelectorAll(".tarjeta").forEach((element) => {
    const nombreDelRol = element.querySelector(".card-title").innerText.toLowerCase();
    element.classList.toggle("d-none", !nombreDelRol.includes(query));
  });
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
  modal.querySelector("form").addEventListener("submit", function (event) {
    console.log(modal);
    let isValid = true;
    let listPermisos = [];
    sections.forEach((section) => {
      const consultarCheckbox = section.querySelector('input[value="consultar"]');
      if (!consultarCheckbox.checked) {
        isValid = false;
      } else {
        section.classList.remove("error");
        listPermisos.push(consultarCheckbox.value);
      }
    });

    if (!isValid) {
      event.preventDefault(); // Prevenir envío del formulario
      alertError("Error", "Debe seleccionar al menos 'Consultar' en cada sección..");
    }

    if (listPermisos.length >= 1) {
      createUser(modal.querySelector("form"), document.querySelectorAll(".input-validar"));
    } else {
      alertError("Error", "Por favor verifique que todos los datos esten correctos.");
    }
  });
}

// Función para manejar los checkboxes dentro de cada sección del acordeón
function manejarCheckboxConsultar(section) {
  const consultarCheckbox = section.querySelector('input[value="consultar"]');
  const otherCheckboxes = section.querySelectorAll('input[value="guardar"], input[value="editar"], input[value="eliminar"]');

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
    const modalMostrar = document.getElementById("modal-exampleMostrar" + id_rol); // Modal específico
    const checkboxTodosLosPermisos = modalMostrar.querySelector(".checkboxTodosLosPermisos" + id_rol);

    // Manejar el checkbox de "Todos los Permisos"
    manejarCheckboxTodosLosPermisos(modalMostrar, checkboxTodosLosPermisos);

    // Manejar cada sección del acordeón
    modalMostrar.querySelectorAll(".accordion-section").forEach(manejarCheckboxConsultar);
  });
});

// Manejar el modal de "Guardar"
const modalGuardar = document.getElementById("modal-exampleGuardar");
const checkboxTodosLosPermisosGuardar = modalGuardar.querySelector(".checkboxTodosLosPermisos");

// Manejar el checkbox de "Todos los Permisos" en el modal de "Guardar"
manejarCheckboxTodosLosPermisos(modalGuardar, checkboxTodosLosPermisosGuardar);

// Manejar cada sección del acordeón en el modal de "Guardar"
modalGuardar.querySelectorAll(".accordion-section").forEach(manejarCheckboxConsultar);

//Ajax

const readRol = async () => {
  try {
    const result = await executePetition(url + "/mostrarAjax", "GET");

    // construir html de filas
    let html = "";
    result.forEach((element) => {
      html += `<div class="card contenido col-9 col-sm-6 col-lg-3 tarjeta ms-2 me-4 d-flex align-items-center justify-content-center tarjeta">


                            <img src="${urlBase}../src/assets/img/logoRol.jpeg" class="mt-2" alt="...">

                            <div class="mt-3">
                                <div class="ps-3 pe-3 text-center buscar">

                                    <h5 class="card-title mb-1 ">
                                        ${element.nombre}
                                    </h5>
                                    <p class="mb-4">
                                        ${element.descripción}
                                    </p>

                                </div>

                                <div class="d-flex align-items-center justify-content-center flex-column">
                                    <div class="mostrar mb-3">
                                        <a href="#" class="btn btn-User  text-decoration-none"
                                            uk-toggle="target: #modal-exampleMostrar${element.id_rol}">Mostrar</a>
                                    </div>

                                </div>
                            </div>
                        </div>`;
    });

    // vuelca el html en el tbody
    document.getElementById("div-rol").innerHTML = html;

    document.querySelectorAll(".id_usuario_bitacora").forEach((ele) => {
      ele.value = document.getElementById("id_usuario_session").value;
    });

    //llamar las funcion de eliminar
    document.querySelectorAll(".btn-eliminar").forEach((btn) => {
      btn.addEventListener("click", function () {
        const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];
        console.log(data);
        alertConfirm("Esta seguro de eliminar el rol?", deleteUser, data);
      });
    });

    document.querySelectorAll(".forms-editar").forEach((formEditar) => {
      formEditar.addEventListener("submit", function (e) {
        e.preventDefault();
        let inputsBuenos = [];

        this.querySelectorAll(".input-validar").forEach((input) => {
          if (input.value != "") inputsBuenos.push(true);
        });

        if (inputsBuenos.length == 2) {
          updateRol(this, inputsBuenos);
        } else {
          alertError("Error al enviar el formulario", "Por favor verifique que todos los datos esten correctos.");
        }
      });
    });
  } catch (error) {
    alertError("Error", error);
  }
};

//create
const createUser = async (form, inputs) => {
  try {
    const data = new FormData(form);
    let result = await executePetition(url + "/guardarRol", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);

      UIkit.modal("#modal-exampleGuardar").hide();
      form.reset();
      inputs = [];
      inputs.forEach((input) => input.parentElement.classList.remove("grpFormCorrect"));
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

      UIkit.modal(`#${form.parentElement.parentElement.getAttribute("id")}`).hide();
      inputs = [];
      inputs.forEach((input) => input.parentElement.classList.remove("grpFormCorrect"));
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

      UIkit.modal(`#modal-exampleMostrar${form.getAttribute("data-index")}`).hide();
      inputs = [];
      inputs.forEach((input) => input.parentElement.classList.remove("grpFormCorrect"));
      readRol();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    console.log(error);
    alertError("Error", error);
  }
};

readRol();

activarMostrarContra.forEach((act) => {
  act.addEventListener("click", mostrarContrasena);
});
desMostrarContra.forEach((des) => {
  des.addEventListener("click", mostrarContrasena);
});

//Buscador
document.getElementById("Buscarusuario").addEventListener("keyup", function () {
  const searchTerm = this.value.toLowerCase();
  const cards = document.querySelectorAll(".card");

  cards.forEach((card) => {
    const cardTitle = card.querySelector(".card-title").textContent.toLowerCase();

    if (cardTitle.includes(searchTerm)) {
      card.classList.remove("d-none");
      // Muestra la tarjeta si coincide
    } else {
      card.classList.add("d-none"); // Oculta la tarjeta si no coincide
    }
  });
});
