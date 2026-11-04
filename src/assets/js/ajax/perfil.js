import { executePetition, alertError, alertSuccess, initLoaderButton, finallyLoaderButton, setImgWithFallback } from "../generic/funtionGeneric.js";
import { inicializarValidacionFormulario } from "../generic/expresionesModulares.js";

const url = "/Perfil";
const formPerfil = document.getElementById("formPerfil");
const inputsCard = document.querySelectorAll(".fondo-perfil .input-validar");
const inputsValidacion = document.querySelectorAll(".form-validable .input-validar");
const imgPerfilModal = document.getElementById("img-perfil-modal");
const imgUser = document.getElementById("imgUser");
const botonModal = document.getElementById('botonModal')

//modal
const modalPerfil = new bootstrap.Modal(document.getElementById("exampleModalPerfil"));

//update
const updatePerfil = async (form) => {
    try {
        initLoaderButton(botonModal)
        const data = new FormData(form);
        let result = await executePetition(url + "/guardar", "POST", data);
        console.log(result);
        if (result.ok) {
            alertSuccess(result.message);
            const inputImagen = form.querySelector('input[type="file"]');
            if (inputImagen) {
                inputImagen.value = "";
                inputImagen.dispatchEvent(new Event("change", { bubbles: true }));
            }
            modalPerfil.hide();
            readProfile();
        } else throw new Error(`${result.error}`);
    } catch (error) {
        console.log(error);
        alertError("Error", error);
    }finally{
        finallyLoaderButton(botonModal)
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
            const imagen = ["doctor.png", "imagen-generica.svg"].includes(element.imagen)
                ? `../src/assets/images/img/${encodeURIComponent(element.imagen)}`
                : `../src/assets/images/img_ingresadas_por_usuarios/usuarios/${element.id_usuario}_${encodeURIComponent(element.imagen)}`;
            const imagenAlternativa = "../src/assets/images/img/imagen-generica.svg";
            setImgWithFallback(imgUser, imagen, imagenAlternativa);

            inputsValidacion[1].value = element.cedula;
            inputsValidacion[2].value = element.nombre;
            inputsValidacion[3].value = element.apellido;
            inputsValidacion[4].value = element.telefono;
            inputsValidacion[5].value = element.correo;
            inputsValidacion[6].value = element.user;

            setImgWithFallback(imgPerfilModal, imagen, imagenAlternativa);
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

readProfile();

let verificarForm = inicializarValidacionFormulario(formPerfil);

formPerfil.addEventListener("submit", function (e) {
    e.preventDefault();

    let esValido = verificarForm();
    if (esValido) {
        updatePerfil(this);
    } else {
        alertError("Error", "Por favor verifique que todos los datos estén correctos.");
    }
});
