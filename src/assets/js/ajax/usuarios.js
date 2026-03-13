import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
  cargarImg,
  hasPermision,
} from "../generic/funtionGeneric.js";
import Paginator from "../generic/Paginator.js";
import { inicializarValidacionFormulario } from "../generic/expresionesModulares.js";

const url = "/Sistema-del--CEM--JEHOVA-RAFA/Usuarios";

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
const inputImg = document.getElementById("inputImg");
const usuarioRegistrado = document.getElementById("usuarioRegistrado");
const id_usuario = document.getElementById("id_usuario");
const usurioHiddenPass = document.getElementById("usurioHiddenPass");
const btnEliminar = document.getElementById('btnEliminar');
const formAgregarAdmin = document.getElementById('formAgregarAdmin');

const id_rol_global = document.getElementById("id_rol_global").value;



const modalInfoBoots = new bootstrap.Modal(document.getElementById("modal-exampleMostrar"));


let nameUser = "";
let nombreAndApellido = "";

function mostrarContrasena(div) {
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
}

//Ajax

const readUser = async () => {
  try {
    let metodo = "";
    let urlActual = window.location.href;

    if (!urlActual.includes("administradores")) metodo = "usuariosAjax";
    else metodo = "administradoresAjax";

    const items = await executePetition(url + "/" + metodo, "GET");

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

    console.log(document.querySelectorAll(".botones-mostrar"));
    document.querySelectorAll(".botones-mostrar").forEach((btn) => {
      btn.addEventListener("click", function () {
        mostrarInfo(btn);
      });
    });

    //////gestionar persmisos
    hasPermision(id_rol_global, "Usuarios", "guardar", ".btnOpenModal"); //guardar
    hasPermision(id_rol_global, "Usuarios", "eliminar", ".btn-eliminar"); //eliminar
    hasPermision(id_rol_global, "Usuarios", "editar", ".btn-open-editar"); //editar
  } catch (error) {
    alertError("Error", error);
  }
};

//funciona para retirnar el html de las tarjetas
const returnFragmentHtml=(element)=>{
  return ` <div class="card contenido mb-4 mx-3" style="width: 18rem;">
        <img src="${urlBase}../src/assets/images/img_ingresadas_por_usuarios/usuarios/${element.id_usuario}_${
          element.imagen
        }" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="titulo user-name">Usuario: ${element.user}</h5>

            <p class="mt-3 name-apellido">Nombre: ${element.nombre} ${element.apellido}</p>
         

                                                

                                    <button href="#" class=" caja-btn-margin btn btn-modals botones-mostrar" data-index="${
                                      element.id_usuario
                                    }" data-img=${element.imagen}
                                        data-bs-toggle="modal" data-bs-target="#modal-exampleMostrar">Mostrar</button>
        </div>
    </div>`
}

//mostrar inof user

const mostrarInfo = (btn) => {
  
  modalInfoBoots.show();

  const card = btn.closest(".card");
  let src = `${urlBase}../src/assets/images/img_ingresadas_por_usuarios/usuarios/${btn.getAttribute("data-index")}_${btn.getAttribute(
    "data-img",
  )}`;

  contenedorImgEditar.classList.remove("d-none");

  imgInfo.src = src;
  imgEditar.src = src;

  nameUser = card.querySelector(".user-name").innerText;
  nombreAndApellido = card.querySelector(".name-apellido").innerText;

  dataInfo[0].innerText = nameUser;
  dataInfo[1].innerText = nombreAndApellido;

  const inputsEdi = formEdiUsuario.querySelectorAll(".input-validar");
  inputsEdi[1].value = nameUser.slice(9);

  usuarioRegistrado.value = nameUser.slice(9);
  id_usuario.value = btn.getAttribute("data-index");
  usurioHiddenPass.value = nameUser.slice(9);

  btnEliminar.setAttribute('data-index', btn.getAttribute("data-index"));

  //llenar de una vez el modal de editar
  inputsEdi.forEach((inp) => {
    inp.parentElement.classList.add("valido");
    inp.parentElement.classList.remove("invalido");
  });
};

//create
const createUser = async (form) => {
  try {
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
  }
};

//update
const updateUser = async (form) => {
  try {
    const data = new FormData(form);
    let result = await executePetition(url + "/editarUsuario", "POST", data);
    console.log(result);

    if (result.ok) {
      alertSuccess(result.message);
      readUser();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//update password
const updateUserPass = async (form) => {
  try {
    const data = new FormData(form);
    let result = await executePetition(url + "/verificarPassw", "POST", data);
    console.log(result);

    if (result.ok) {
      alertSuccess(result.message);
      readUser();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

//delete
const deleteUser = async (data) => {
  try {
    console.log(url + `/borrarUsuario/${data[0]}/${data[1]}`)
    const result = await executePetition(url + `/borrarUsuario/${data[0]}/${data[1]}`, "GET");
    if (result.ok) {
      alertSuccess(result.message);

      readUser();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};

readUser();

//llamar a la funcion para cargar la imagen del insumo
inputImg.addEventListener("change", function (e) {
  let newImg = `<img  style="height: 200px;width: 100%;" src=''>`;

  contenedorImg.classList.remove("d-none");
  contenedorImgEditar.classList.add("d-none");
  cargarImg(this.files, newImg, contenedorImg);
});

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

let verificarFormularioEdi = inicializarValidacionFormulario(formEdiUsuario);
let verificarFormularioPass = inicializarValidacionFormulario(formEdiPass);
let verificarFormularioAdmin = inicializarValidacionFormulario(formAgregarAdmin);

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
