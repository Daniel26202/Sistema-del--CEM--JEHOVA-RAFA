import { executePetition, alertConfirm, alertError, alertSuccess } from "../generic/funtionGeneric.js";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/iniciarSesion";

// envió de datos
const sendData = async (form) => {
    try {
        const data = new FormData(form);
        let result = await executePetition(url + "/iniciarSesion", "POST", data);
        console.log(result);
        
        if (result.ok) {
            let ruta = window.location.href;
            window.location.href = ruta + "Inicio/inicio";
        } else {
            if (result.error == "session_active") {
                alertConfirm(
                    "El usuario ya tiene una sesión activa. desea cerrar la sesión para iniciar nuevamente",
                    closedSession
                );
            } else alertError("Error", "La contraseña o usuario son incorrectos.");
        }
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
