import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
  initDataTable,
} from "../ajax/funtionGeneric.js";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/iniciarSesion";

// envio de datos
const sendData = async (form) => {
  try {
    const data = new FormData(form);
    let result = await executePetition(url + "/iniciarSesion", "POST", data);
    console.log(result);

    if (result.error == "session_active") {
      alertConfirm(
        "El usuario ya tiene una sesion activa. desea cerrar la sesion para iniciar nuevamente",
        closedSession
      );
    }else window.location.href ="http://localhost/Sistema-del--CEM--JEHOVA-RAFA/Inicio/inicio";
    
  } catch (error) {
    alertError("Error", error);
  }
};

const closedSession = async () => {
  try {
    let result = await executePetition("/Sistema-del--CEM--JEHOVA-RAFA/Inicio/cerrarSession", "GET");
    console.log(result);
    alertSuccess();
  } catch (error) {
    alertError("Error", error);
  }
};

const formLog = document.getElementById("loginForm");

addEventListener("DOMContentLoaded", function () {
  formLog.addEventListener("submit", function (e) {
    e.preventDefault();
    sendData(formLog);
  });
});
