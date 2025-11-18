import { executePetition, alertError, alertSuccess } from "./funtionExecutePetition.js";

const url = "/Sistema-del--CEM--JEHOVA-RAFA/Perfil";
const modalAgregar = document.getElementById("modalAgregar");
const inputs = document.querySelectorAll(".input-perfil");
const inputsValidacion = document.querySelectorAll(".input-validar");


//update
const updatePerfil = async (form, inputs) => {
  try {
    const data = new FormData(form);
    let result = await executePetition(url + "/guardar", "POST", data);
    console.log(result);
    if (result.ok) {
      alertSuccess(result.message);

    //   UIkit.modal(`#exampleModal`).hide();
      inputs = [];
      inputs.forEach((input) => input.parentElement.classList.remove("grpFormCorrect"));
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
    console.log(result)

    
    result.forEach(element => {
        inputs[0].value = element.cedula;
        inputs[1].value = element.nombre;
        inputs[2].value = element.apellido;
        inputs[3].value = element.telefono;
        inputs[4].value = element.user;
        inputs[5].value = element.correo;

        inputsValidacion[0].value = element.cedula;
        inputsValidacion[1].value = element.nombre;
        inputsValidacion[2].value = element.apellido;
        inputsValidacion[3].value = element.telefono;
        inputsValidacion[4].value = element.user;
        inputsValidacion[5].value = element.correo;

    });

  } catch (error) {
    alertError("Error", error);
  }
};

readProfile();

modalAgregar.addEventListener("submit", function (e) {
  e.preventDefault();
  let inputsMalos = [];

  this.querySelectorAll(".input-validar").forEach((input) => {
    if (input.parentElement.classList.contains("grpFormInCorrect")) {
      inputsMalos.push(true);
    }
  });

  if (!inputsMalos.length >= 1 && inputsMalos.length <= 6) {
    updatePerfil(this, inputsMalos);
  } else {
    alertError("Error al enviar el formulario", "Por favor verifique que todos los datos esten correctos.");
  }
});
