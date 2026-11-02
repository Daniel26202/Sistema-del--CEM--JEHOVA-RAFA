import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
  setImgWithFallback,
  hasPermision,
  clearModalEnviar,
  initLoaderButton,
  finallyLoaderButton,
} from "../generic/funtionGeneric.js";
import Paginator from "../generic/Paginator.js";
import { inicializarValidacionFormulario } from "../generic/expresionesModulares.js";

const url = "/Sistema-del--CEM--JEHOVA-RAFA/Usuarios";

const modalEditarUsuario = new bootstrap.Modal(
  document.getElementById("modal-exampleEditar"),
);
const modalEditarPass = new bootstrap.Modal(
  document.getElementById("modal-exampleEditarPass"),
);

const urlBase = document.getElementById("urlBase").value;

const activarMostrarContra = document.querySelectorAll(".mostrarPassword");
const desMostrarContra = document.querySelectorAll(".ocultarPassword");

const imgInfo = document.getElementById("imgInfo");
const dataInfo = document.querySelectorAll(".data-info");

const inputDos = document.querySelectorAll(".inputDos");
const formEdiUsuario = document.getElementById("formEdiUsuario");
const formEdiPass = document.getElementById("formEdiPass");

const contenedorImgEditar = document.getElementById("contenedor-img-editar");
const imgEditar = document.getElementById("imgEditar");
const contenedorImg = document.getElementById("contenedor-img");
const usuarioRegistrado = document.getElementById("usuarioRegistrado");
const id_usuario = document.getElementById("id_usuario");
const usurioHiddenPass = document.getElementById("usurioHiddenPass");
const btnEliminar = document.getElementById("btnEliminar");
const formAgregarAdmin = document.getElementById("formAgregarAdmin");
const id_rol_global = document.getElementById("id_rol_global").value;
const modalInfoBoots = new bootstrap.Modal(
  document.getElementById("modal-exampleMostrar"),
);
const btnOpenModal = document.getElementById("btnOpenModal");
const exampleModalLabel = document.getElementById("exampleModalLabelAdmin");
const inputsAdmin = formAgregarAdmin.querySelectorAll(".input-validar");
const botonModal = document.getElementById("botonModal");
const botonModalPass = document.getElementById("botonModalPass");

let nameUser = "";
let nombreAndApellido = "";

const mostrarContrasena = (div) => {
  const input = div.querySelector("input");

  if (input.type == "password") {
    input.type = "text";
    desMostrarContra.forEach((des) => {
      des.classList.remove("d-none");
    });
    activarMostrarContra.forEach((act) => {
      act.classList.add("d-none");
    });
  } else {
    input.type = "password";
    desMostrarContra.forEach((des) => {
      des.classList.add("d-none");
    });
    activarMostrarContra.forEach((act) => {
      act.classList.remove("d-none");
    });
  }
};

//Ajax

const readUser = async () => {
  try {
    let metodo = "";
    let urlActual = window.location.href;

    if (!urlActual.includes("administradores")) metodo = "usuariosAjax";
    else metodo = "administradoresAjax";

    const items = await executePetition(url + "/" + metodo, "GET");
    let objValidationImg = {
      setImgWithFallback,
      imgSrcDefecto: `${urlBase}../src/assets/images/img/imagen-generica.svg`,
    };
    const paginator = new Paginator(
      items,
      3,
      "cardContainer",
      "pagination",
      "searchInput",
      returnFragmentHtml,
      "id_usuario",
      mostrarInfo,
      objValidationImg,
    );

    paginator.displayItems();

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
        alertConfirm("Esta seguro de eliminar el usuario?", deleteUser, data);
      });
    });

    // console.log(document.querySelectorAll(".botones-mostrar"));
    // document.querySelectorAll(".botones-mostrar").forEach((btn) => {
    //   btn.addEventListener("click", function () {
    //     mostrarInfo(btn);
    //   });
    // });

    //////gestionar persmisos
    hasPermision(id_rol_global, "Usuarios", "guardar", ".btnOpenModal"); //guardar
    hasPermision(id_rol_global, "Usuarios", "eliminar", ".btn-eliminar"); //eliminar
    hasPermision(id_rol_global, "Usuarios", "editar", ".btn-open-editar"); //editar
  } catch (error) {
    alertError("Error", error);
  }
};

//funciona para retirnar el html de las tarjetas
const returnFragmentHtml = (element) => {
  const imagen = ["doctor.png", "imagen-generica.svg"].includes(element.imagen)
    ? `${urlBase}../src/assets/images/img/${encodeURIComponent(element.imagen)}`
    : `${urlBase}../src/assets/images/img_ingresadas_por_usuarios/usuarios/${element.id_usuario}_${encodeURIComponent(element.imagen)}`;
  return ` <div class="card contenido mb-4 mx-3" style="width: 18rem;">
        <img src="${imagen}" class="card-img-top" style="width: 100%; height: 200px; object-fit: cover;" alt="Foto de ${element.user}">
        <div class="card-body">
            <h5 class="titulo user-name">Usuario: ${element.user}</h5>

            <p class="mt-3 name-apellido">Nombre: ${element.nombre} ${element.apellido}</p>
         

                                                

                                    <button href="#" class=" caja-btn-margin btn btn-modals botones-mostrar" data-index="${
                                      element.id_usuario
                                    }"                                     data-img="${encodeURIComponent(element.imagen)}"
                                        data-bs-toggle="modal" data-bs-target="#modal-exampleMostrar">Mostrar</button>
        </div>
    </div>`;
};

//mostrar inof user

const mostrarInfo = (id) => {
  modalInfoBoots.show();
  const btn = document.querySelector(`.botones-mostrar[data-index="${id}"]`);
  const card = btn.closest(".card");
  const nombreImagen = decodeURIComponent(btn.getAttribute("data-img") || "");
  const src = ["doctor.png", "imagen-generica.svg"].includes(nombreImagen)
    ? `${urlBase}../src/assets/images/img/${encodeURIComponent(nombreImagen)}`
    : `${urlBase}../src/assets/images/img_ingresadas_por_usuarios/usuarios/${btn.getAttribute("data-index")}_${encodeURIComponent(nombreImagen)}`;
  const imagenAlternativa = `${urlBase}../src/assets/images/img/imagen-generica.svg`;

  contenedorImgEditar.classList.remove("d-none");

  setImgWithFallback(
    imgInfo,
    src,
    imagenAlternativa,
  );
  setImgWithFallback(
    imgEditar,
    src,
    imagenAlternativa,
  );

  nameUser = card.querySelector(".user-name").innerText;
  nombreAndApellido = card.querySelector(".name-apellido").innerText;

  dataInfo[0].innerText = nameUser;
  dataInfo[1].innerText = nombreAndApellido;

  const inputsEdi = formEdiUsuario.querySelectorAll(".input-validar");
  inputsEdi[1].value = nameUser.slice(9);

  usuarioRegistrado.value = nameUser.slice(9);
  id_usuario.value = btn.getAttribute("data-index");
  usurioHiddenPass.value = nameUser.slice(9);

  btnEliminar.setAttribute("data-index", btn.getAttribute("data-index"));

  //llenar de una vez el modal de editar
  inputsEdi.forEach((inp) => {
    inp.parentElement.classList.add("valido");
    inp.parentElement.classList.remove("invalido");
  });
};

//create
const createUser = async (form) => {
  try {
    initLoaderButton(botonModal);
    const data = new FormData(form);
    let result = await executePetition(url + "/registrarAdmin", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);
      readUser();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    console.log("lamentablemente " + error);
    alertError("Error", error);
  } finally {
    finallyLoaderButton(botonModal);
  }
};

//update
const updateUser = async (form) => {
  try {
    initLoaderButton(botonModal);
    const data = new FormData(form);
    let result = await executePetition(url + "/editarUsuario", "POST", data);
    console.log(result);

    if (result.ok) {
      alertSuccess(result.message);
      const inputImagen = form.querySelector('input[type="file"]');
      if (inputImagen) {
        inputImagen.value = "";
        inputImagen.dispatchEvent(new Event("change", { bubbles: true }));
      }
      modalInfoBoots.hide();
      modalEditarUsuario.hide();
      readUser();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  } finally {
    finallyLoaderButton(botonModal, "Editar Usuario");
  }
};

//update password
const updateUserPass = async (form) => {
  try {
    initLoaderButton(botonModalPass);
    const data = new FormData(form);
    let result = await executePetition(url + "/verificarPassw", "POST", data);
    console.log(result);

    if (result.ok) {
      alertSuccess(result.message);
      readUser();
      modalEditarPass.hide();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  } finally {
    finallyLoaderButton(botonModalPass, "Editar Contraseña");
  }
};

//delete
const deleteUser = async (data) => {
  try {
    const payload = { id: data[0] };

    const result = await executePetition(
      url + `/borrarUsuario`,
      "POST",
      payload,
    );
    if (result.ok) {
      alertSuccess(result.message);
      modalInfoBoots.hide();
      readUser();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

readUser();

activarMostrarContra.forEach((act) => {
  act.addEventListener("click", function () {
    const divParent = act.closest(".input-custom");
    mostrarContrasena(divParent);
  });
});
desMostrarContra.forEach((des) => {
  des.addEventListener("click", function () {
    const divParent = des.closest(".input-custom");
    mostrarContrasena(divParent);
  });
});

btnOpenModal.addEventListener("click", function () {
  //objetos con todos los parametros de la funcion
  const parametros = {
    labelModal: exampleModalLabel,
    textLabelModal: "Registrar Administrador",
    form: formAgregarAdmin,
    modal: formAgregarAdmin.parentElement.parentElement.parentElement,
    btnModal: botonModal,
    btnTextModal: "Registrar",
    inputs: inputsAdmin,
  };
  clearModalEnviar(parametros);
});

botonModal.addEventListener("click", function () {
  contenedorImg.classList.add("d-none");
});

let verificarFormularioEdi = inicializarValidacionFormulario(formEdiUsuario);
let verificarFormularioPass = inicializarValidacionFormulario(formEdiPass);
let verificarFormularioAdmin =
  inicializarValidacionFormulario(formAgregarAdmin);

formEdiUsuario.addEventListener("submit", function (e) {
  e.preventDefault();

  let esValido = verificarFormularioEdi();

  if (esValido) {
    console.log("editar");
    updateUser(this);
  } else {
    alertError(
      "Error",
      "Por favor verifique que todos los datos estén correctos.",
    );
  }
});

formEdiPass.addEventListener("submit", function (e) {
  e.preventDefault();

  let esValido = verificarFormularioPass();

  if (esValido) {
    updateUserPass(this);
  } else {
    alertError(
      "Error",
      "Por favor verifique que todos los datos estén correctos.",
    );
  }
});

formAgregarAdmin.addEventListener("submit", function (e) {
  e.preventDefault();

  let esValido = verificarFormularioAdmin();

  if (esValido) {
    createUser(this);
  } else {
    alertError(
      "Error",
      "Por favor verifique que todos los datos estén correctos.",
    );
  }
});
