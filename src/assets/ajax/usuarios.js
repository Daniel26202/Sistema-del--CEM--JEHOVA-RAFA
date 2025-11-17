import { executePetition, alertConfirm, alertError, alertSuccess } from "./funtionExecutePetition.js";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/Usuarios";

const urlBase = document.getElementById("urlBase").value;

const btnEditarUsuarios = document.querySelectorAll(".editarUsuario");
const imagenesUsuarios = document.querySelectorAll(".imagenesUsuarios");

const activarMostrarContra = document.querySelectorAll(".mostrarPassword");
const desMostrarContra = document.querySelectorAll(".ocultarPassword");

const modalAgregar = document.getElementById('formAgregarAdmin');
const rol = document.getElementById("rol");

const expresionesEditarUsuario = {
  imagen: /([A-Za-z0-9._-]\s?)+\.(jpg|JPG|PNG|png|jpeg|JPEG)+/,
  usuario: /^[a-zA-Z0-9._-]{3,16}$/,
  password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/,
};

const camposEditarUsuario = {
  imagen: true,
  usuario: true,
  password: true,
};

function validarFormularioEditarUsuario(e) {
  switch (e.target.name) {
    case "imagenUsuario":
      let imagenSeparada = e.target.value.split("\\");
      let nombreImagen = imagenSeparada.pop();
      if (expresionesEditarUsuario.imagen.test(nombreImagen)) {
        e.target.parentElement.classList.remove("grpFormInCorrect");
        e.target.parentElement.classList.add("grpFormCorrect");
        camposInsumos["imagen"] = true;
      } else {
        e.target.parentElement.classList.remove("grpFormCorrect");
        e.target.parentElement.classList.add("grpFormInCorrect");
        camposInsumos["imagen"] = false;
      }
      break;

    // case "nombre":
    //     validarCamposEditarUsuario(expresionesEditarUsuario.nombre, e.target, 'nombre');
    //     break;

    // case "apellido":
    //     validarCamposEditarUsuario(expresionesEditarUsuario.apellido, e.target, 'apellido');

    //     break;
    case "usuario":
      validarCamposEditarUsuario(expresionesEditarUsuario.usuario, e.target, "usuario");

      break;

    case "password":
      validarCamposEditarUsuario(expresionesEditarUsuario.password, e.target, "password");

      break;
  }
}

const validarCamposEditarUsuario = (expresiones, input, campo) => {
  if (expresiones.test(input.value)) {
    input.parentElement.classList.remove("grpFormInCorrect");
    input.parentElement.classList.add("grpFormCorrect");
    camposEditarUsuario[campo] = true;
  } else {
    input.parentElement.classList.remove("grpFormCorrect");
    input.parentElement.classList.add("grpFormInCorrect");
    camposEditarUsuario[campo] = false;
  }
};

btnEditarUsuarios.forEach((btn) => {
  btn.addEventListener("click", function () {
    let id = this.getAttribute("uk-toggle").split(" ")[1].substring(1);
    let formulario = document.querySelector(`#${id} .uk-modal-dialog .formEditarUsuario`);
    let inputs = document.querySelectorAll(`#${id} .uk-modal-dialog .formEditarUsuario div .uk-card-body .flex-column input`);
    let alerta = document.querySelector(`#${id} .uk-modal-dialog .formEditarUsuario #alertaUsuario`);
    console.log(alerta);
    inputs.forEach((input) => {
      input.addEventListener("input", validarFormularioEditarUsuario);
    });

    formulario.addEventListener("submit", function (e) {
      e.preventDefault();
      console.log(camposEditarUsuario.imagen);

      if (camposEditarUsuario.imagen && camposEditarUsuario.password && camposEditarUsuario.usuario) {
        updateUser(formulario, inputs)
      } else {
        alertError("Error", "Por favor verifique que todos los datos esten correctos.");
      }
    });
  });
});

//imagenes de los usuarios
imagenesUsuarios.forEach((imagenUsuario) => {
  imagenUsuario.addEventListener("change", function (e) {
    let id = this.parentElement.parentElement.parentElement.parentElement.getAttribute("id");

    let imgSrc = document.querySelector(`#${id} .caja-imagen .uk-grid-small .uk-width-auto .uk-border-circle`);

    leerImagenesUsuarios(imagenUsuario.files, imgSrc);
  });
});

function leerImagenesUsuarios(ar, img) {
  for (var i = 0; i < ar.length; i++) {
    const reader = new FileReader();
    reader.readAsDataURL(ar[i]);
    reader.addEventListener("load", function (e) {
      img.setAttribute("src", `${e.currentTarget.result}`);
    });
  }
}

const inputDos = document.querySelectorAll(".inputDos");

inputDos.forEach((dos) => {
  dos.addEventListener("keyup", () => {
    activarMostrarContra.forEach((act) => {
      act.classList.remove("d-none");
      if (dos.value == "") {
        act.classList.add("d-none");
        desMostrarContra.forEach((des) => {
          des.classList.add("d-none");
        });
      }
      if (dos.type == "text" && dos.value.length > 0) {
        desMostrarContra.forEach((des) => {
          des.classList.remove("d-none");
        });
        act.classList.add("d-none");
      }
    });
  });
});

function mostrarContrasena() {
  inputDos.forEach((dos) => {
    if (dos.type == "password") {
      dos.type = "text";
      desMostrarContra.forEach((des) => {
        des.classList.remove("d-none");
      });
      activarMostrarContra.forEach((act) => {
        act.classList.add("d-none");
      });
    } else {
      dos.type = "password";
      desMostrarContra.forEach((des) => {
        des.classList.add("d-none");
      });
      activarMostrarContra.forEach((act) => {
        act.classList.remove("d-none");
      });
    }
  });
}

//Ajax

const readUser = async () => {
  try {
    let metodo = "";
    let urlActual = window.location.href;

    if (!urlActual.includes("administradores")) metodo = "usuariosAjax";
    else metodo = "administradoresAjax";

    const result = await executePetition(url + "/" + metodo, "GET");

    // construir html de filas
    let html = "";
    result.forEach((element) => {
      html += `<div class="card contenido col-9 col-sm-6 col-lg-3 tarjeta ms-2 me-4 d-flex align-items-center justify-content-center tarjeta">
                            

                                <img src="${urlBase}../src/assets/img_ingresadas_por_usuarios/usuarios/${element.id_usuario}_${element.imagen}" class="mt-2" alt="...">
                               
                           
                            <div class="mt-3">
                                <div class="ps-3 pe-3 text-center buscar">

                                    <h5 class="card-title mb-1 ">
                                        ${element.nombre} ${element.apellido}
                                    </h5>
                                    <p class="mb-4">
                                       ${element.user}
                                    </p>

                                </div>

                                <div class="d-flex align-items-center justify-content-center flex-column">
                                    <div class=" mb-3">
                                        <a href="#" class="mostrar btn btn-User text-decoration-none"
                                            uk-toggle="target: #modal-exampleMostrar${element.id_usuario}">Mostrar</a>
                                    </div>

                                </div>
                            </div>
                        </div>`;
    });

    // vuelca el html en el tbody
    document.getElementById("div-tarjet-user").innerHTML = html;

    document.querySelectorAll(".id_usuario_bitacora").forEach((ele) => {
      ele.value = document.getElementById("id_usuario_session").value;
    });

    //llamar las funcion de eliminar
    document.querySelectorAll(".btn-eliminar").forEach((btn) => {
      btn.addEventListener("click", function () {
        const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];
        console.log(data)
        alertConfirm("Esta seguro de eliminar el usuario?", deleteUser, data);
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
    let result = await executePetition(url + "/registrarAdmin", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);

      UIkit.modal("#modal-exampleAgregar").hide();
      form.reset();
      inputs = [];
      inputs.forEach((input) => input.parentElement.classList.remove("grpFormCorrect"));
      readPatients();
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
      readUser();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    console.log(error);
    alertError("Error", error);
  }
};

//delete
const deleteUser = async (data) => {
  try {
    const result = await executePetition(url + `/borrarUsuario/${data}`, "GET");
    if (result.ok) {
      alertSuccess(result.message)

      readUser();

      UIkit.modal(`#modal-exampleMostrar${data[0]}`).hide();

    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error)
  }
};

readUser();

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


if (modalAgregar) {
  modalAgregar.addEventListener("submit", function (e) {
    e.preventDefault();
    let inputsBuenos = [];
    this.querySelectorAll(".input-validar").forEach((input) => {
      if (input.parentElement.classList.contains("grpFormCorrect")) inputsBuenos.push(true);
    });
    console.log(inputsBuenos.length);
    console.log(rol.value);

    if (
      inputsBuenos.length == 8 &&
      rol.value != ""
    ) {
      createUser(this, inputsBuenos);
    } else {
      alertError("Error", "Por favor verifique que todos los datos esten correctos.");
    }
    
  });

}

