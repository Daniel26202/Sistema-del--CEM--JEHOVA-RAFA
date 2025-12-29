import { executePetition, alertConfirm, alertError, alertSuccess, initDataTable } from "../ajax/funtionGeneric.js";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion";

// envio de datos
const sendData = async (form) => {
    try {
        const data = new FormData(form);
        let result = await executePetition(url + "/iniciarSesion", "POST", data);
        console.log(result);
        window.location.href = "http://localhost/Sistema-del--CEM--JEHOVA-RAFA/Inicio/inicio";
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
