import { executePetition, alertError, alertSuccess } from "../generic/funtionGeneric.js";
import { inicializarValidacionFormulario } from "../generic/expresionesModulares.js";

const url = "/Sistema-del--CEM--JEHOVA-RAFA/Perfil";
const formPerfil = document.getElementById("formPerfil");
const inputsCard = document.querySelectorAll(".fondo-perfil .input-validar");
const inputsValidacion = document.querySelectorAll(".form-validable .input-validar");
const imgPerfilModal = document.getElementById("img-perfil-modal");
const inputImagen = document.getElementById("inputImagen");
const imgUser = document.getElementById("imgUser");

//modal
const modalPerfil = new bootstrap.Modal(document.getElementById("exampleModalPerfil"));

//update
const updatePerfil = async (form) => {
    try {
        const data = new FormData(form);
        let result = await executePetition(url + "/guardar", "POST", data);
        console.log(result);
        if (result.ok) {
            alertSuccess(result.message);
            modalPerfil.hide();
            readProfile();
        } else throw new Error(`${result.error}`);
    } catch (error) {
        console.log(error);
        alertError("Error", error);
    }
};

//read
const readProfile = async () => {
    try {
        const result = await executePetition(url + "/perfilAjax", "GET");
        console.log(result);

        result.forEach((element) => {
            inputsCard[0].value = element.cedula;
            inputsCard[1].value = element.nombre;
            inputsCard[2].value = element.apellido;
            inputsCard[3].value = element.telefono;
            inputsCard[4].value = element.user;
            inputsCard[5].value = element.correo;

            //img
            imgUser.src = `../src/assets/images/img_ingresadas_por_usuarios/usuarios/${element.id_usuario}_${element.imagen}`;

            inputsValidacion[1].value = element.cedula;
            inputsValidacion[2].value = element.nombre;
            inputsValidacion[3].value = element.apellido;
            inputsValidacion[4].value = element.telefono;
            inputsValidacion[5].value = element.correo;
            inputsValidacion[6].value = element.user;

            imgPerfilModal.src = `../src/assets/images/img_ingresadas_por_usuarios/usuarios/${element.id_usuario}_${element.imagen}`;
        });
        inputsCard.forEach((e) => {
            e.setAttribute("disabled", true);
        });

        //disparar el evento para validar los inputs
        inputsValidacion.forEach((input) => {
            if (input.type == "file") {
                input.parentElement.classList.add("valido");
            } else {
                input.dispatchEvent(new Event("keyup", { bubbles: true }));
            }
        });
    } catch (error) {
        alertError("Error", error);
    }
};

//funvion generica para cargar imagenes en js
const cargarImgPerfil = (archivo) => {
    console.log(archivo);
    for (var i = 0; i < archivo.length; i++) {
        const reader = new FileReader();
        reader.readAsDataURL(archivo[i]);
        reader.addEventListener("load", function (e) {
            console.log(imgPerfilModal);
            imgPerfilModal.src = e.currentTarget.result;
        });
    }
};

readProfile();

let verificarForm = inicializarValidacionFormulario(formPerfil);

inputImagen.addEventListener("change", function () {
    cargarImgPerfil(this.files);
});

formPerfil.addEventListener("submit", function (e) {
    e.preventDefault();

    let esValido = verificarForm();
    if (esValido) {
        updatePerfil(this);
    } else {
        alertError("Error", "Por favor verifique que todos los datos estén correctos.");
    }
});
