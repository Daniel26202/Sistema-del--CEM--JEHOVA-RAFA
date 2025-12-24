import { executePetition, alertConfirm, alertError, alertSuccess, initDataTable } from "../ajax/funtionGeneric.js";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/InicioSesion";

// envio de datos
const sendData = async (form) => {
    try {
        const data = new FormData(form);
        let result = await executePetition(url + "/iniciarSesion", "POST", data);
        console.log(result);
    } catch (error) {
        alertError("Error", error);
    }
};

const formLog = document.getElementById("loginForm");


addEventListener("DOMContentLoaded", function () {
    formLog.addEventListener("submit", function (e) {
        e.preventDefault();
        console.log("hola");
        alert("hola");
        sendData(formLog);
    });
});
