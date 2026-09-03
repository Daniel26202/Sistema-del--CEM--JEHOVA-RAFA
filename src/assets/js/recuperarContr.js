import { executePetition, alertConfirm, alertError, alertSuccess } from "../js/generic/funtionGeneric.js";
import { inicializarValidacionFormulario, chulitoYX } from "./generic/expresionesModulares.js";

addEventListener("DOMContentLoaded", function () {
    /////////////////////////////////////////////////////////////////////
    const url = "/Sistema-del--CEM--JEHOVA-RAFA/RecuperarContr";

    //formulario, usuario correo electr
    const formUCE = document.getElementById("formVerificarUCE");
    const formC = document.getElementById("formCodigo");
    const formRC = document.getElementById("formRecuperarPassword");

    const tituloPg = document.getElementById("tituloText");
    const btnVUCE = document.getElementById("divBtnVerificarUCE");
    const btnEC = document.getElementById("btnEviarCod");
    const btnVC = document.getElementById("divBtnVerificarC");
    const btnRC = document.getElementById("divBtnVerificarRC");
    const divTime = document.getElementById("divTime");
    const divTextError = document.getElementById("divTextError");

    const divFormUno = document.getElementById("formUno");
    const divFormDos = document.getElementById("formDos");
    const divFormTres = document.getElementById("formTres");

    let alertaError = document.getElementById("alerta_error");

    const verificar = async (ruta, formulario, numero) => {
        // try {
        console.log("resultado");
        const data = new FormData(formulario);
        let resultado = await executePetition(url + ruta, "POST", data);

        console.log(resultado);
        if (resultado === "conexionFallida") {
            // mensaje de alerta
            alertError("Error", "Envío de código fallido, verifique si tiene conexión a internet");
        }
        // primer formulario Verificar usuario y contraseña
        if (numero == "uno") {
            if (resultado == false) {
                // mensaje de alerta
                alertError("Error", "Usuario o correo electrónico incorrectos.");
                tituloPg.textContent = "Olvide mi contraseña";

                divFormUno.classList.remove("d-none");
                divFormDos.classList.add("d-none");
                divFormTres.classList.add("d-none");
                btnVUCE.classList.remove("d-none");
                btnVC.classList.add("d-none");
                btnEC.classList.add("d-none");
                divTime.classList.add("d-none");
                btnRC.classList.add("d-none");
            } else if (resultado && resultado.ok === true) {
                // mensaje de alerta

                alertSuccess("Código enviado al correo exitosamente");
                tituloPg.textContent = "Ingresé el código para la recuperación";

                divFormUno.classList.add("d-none");
                divFormDos.classList.remove("d-none");
                divFormTres.classList.add("d-none");
                btnVUCE.classList.add("d-none");
                btnEC.classList.add("d-none");
                btnVC.classList.remove("d-none");
                btnRC.classList.add("d-none");
                divTime.classList.remove("d-none");
                temporizador();
            }
            // segundo formulario verificación de código
        } else if (numero == "dos") {
            if (resultado === "exitoso") {
                // mensaje de alerta
                alertSuccess("Verificación exitosa");
                tituloPg.textContent = "Ingresé su nueva contraseña";

                divFormUno.classList.add("d-none");
                divFormDos.classList.add("d-none");
                divFormTres.classList.remove("d-none");
                btnVUCE.classList.add("d-none");
                btnVC.classList.add("d-none");
                btnEC.classList.add("d-none");
                divTime.classList.add("d-none");
                btnRC.classList.remove("d-none");
            } else if (resultado === "codigoIncorrecto") {
                // mensaje de alerta
                alertError("Error", "Código invalido");
            } else if (resultado === "CodExpiro") {
                // mensaje de alerta

                alertError("Error", "Su código expiro.");
            } else if (resultado === "demasiadosIntentos") {
                alertError("Error", "Se excedió el número de intentos permitidos.");
            }

            // tercero formulario, nueva clave
        } else if (numero == "tres") {
            if (resultado === "Actualizado") {
                // mensaje de alerta

                alertSuccess("Contraseña actualizada correctamente");

                tituloPg.textContent = "Olvide mi contraseña";

                formC.reset();
                formRC.reset();
                formUCE.reset();

                divFormUno.classList.remove("d-none");
                divFormDos.classList.add("d-none");
                divFormTres.classList.add("d-none");
                btnVUCE.classList.remove("d-none");
                btnEC.classList.add("d-none");
                btnVC.classList.add("d-none");
                divTime.classList.add("d-none");
                btnRC.classList.add("d-none");
            } else if (resultado === "recuperacionInvalida") {
                alertError("Error", "La recuperación no está validada o expiró.");
            } else if (resultado === "passwordInvalida") {
                alertError("Error", "La contraseña no cumple los requisitos.");
            }
        } else if (numero == "cuatro") {
            if (resultado === true) {
                alertSuccess("Código enviado al correo exitosamente");

                divTime.classList.remove("d-none");
                divTime.textContent = "05:00";

                btnEC.classList.add("d-none");
                temporizador();
            }
        }

        // } catch (error) {
        // console.log(error);
        // }
    };

    function evitarEnvio(form) {
        form.addEventListener("submit", (e) => {
            e.preventDefault();
        });
    }

    evitarEnvio(formUCE);
    evitarEnvio(formC);
    evitarEnvio(formRC);

    function temporizador() {
        // Definimos la duración total del temporizador en milisegundos (5m = 300,000 ms)
        let duracion = 5 * 60 * 1000;
        let endTime = Date.now() + duracion;

        function temporizadorD() {
            const tiempoMl = endTime - Date.now();
            // Convertimos milisegundos a minutos
            const minutos = Math.floor(tiempoMl / 60000);
            // // Convertimos milisegundos a segundos
            const segundos = Math.floor((tiempoMl % 60000) / 1000);
            divTime.textContent = `${minutos}:${segundos < 10 ? "0" : ""}${segundos}`;

            if (tiempoMl <= 0) {
                btnEC.classList.remove("d-none");
                divTextError.classList.remove("d-none");

                divTime.textContent = "";
                setTimeout(function () {
                    // Oculta el div después del tiempo especificado
                    divTextError.classList.add("d-none");
                }, 8000);

                return;
            }

            setTimeout(temporizadorD, 1000);
        }
        temporizadorD();
    }

    // reenvío de código IIII(4)
    document.querySelector("#btnEviarCod").addEventListener("click", function (e) {
        // en donde este el cuatro realiza la función
        verificar("/reenviarCodigo", formC, "cuatro");
    });

    let verificarFormularioVUCE = inicializarValidacionFormulario(formUCE);

    btnVUCE.addEventListener("click", function (e) {
        let inputsBuenos = [];
        this.querySelectorAll(".input-validar").forEach((input) => {
            if (input.parentElement.classList.contains("valido")) inputsBuenos.push(true);
        });

        let esValido = verificarFormularioVUCE();

        if (esValido) {
            // envío del I(1) formularios, en donde este el uno realiza la función
            verificar("/verificarUC", formUCE, "uno");
            document.querySelectorAll(".input-validar").forEach((input) => {
                let campoCustom = input.closest(".campo-custom");
                let iconoDer = campoCustom.querySelector(".icono-der");
                let check = iconoDer.children[0];
                let error = iconoDer.children[1];
                input.parentElement.classList.remove("invalido");
                input.parentElement.classList.remove("valido");
                let pError = campoCustom.querySelector("p");
                pError.classList.add("d-none");
                if (check && error) chulitoYX(check, error, "vacio");
            });
        } else {
            alertError("Error", "Por favor verifique que todos los datos estén correctos.");
        }
    });

    let verificarFormularioC = inicializarValidacionFormulario(formC);

    document.querySelector("#btnVerificarC").addEventListener("click", function (e) {
        let inputsBuenos = [];
        this.querySelectorAll(".input-validar").forEach((input) => {
            if (input.parentElement.classList.contains("valido")) inputsBuenos.push(true);
        });

        let esValido = verificarFormularioC();

        if (esValido) {
            // envío del II(2) formularios en donde este el dos realiza la función
            verificar("/verificarCodigo", formC, "dos");
            document.querySelectorAll(".input-validar").forEach((input) => {
                let campoCustom = input.closest(".campo-custom");
                let iconoDer = campoCustom.querySelector(".icono-der");
                let check = iconoDer.children[0];
                let error = iconoDer.children[1];
                input.parentElement.classList.remove("invalido");
                input.parentElement.classList.remove("valido");
                let pError = campoCustom.querySelector("p");
                pError.classList.add("d-none");
                if (check && error) chulitoYX(check, error, "vacio");
            });
        } else {
            alertError("Error", "Por favor verifique que todos los datos estén correctos.");
        }
    });

    let verificarFormularioRC = inicializarValidacionFormulario(formRC);

    document.querySelector("#btnVerificarRC").addEventListener("click", function (e) {
        let inputNewC = document.getElementById("inputNewPass").value;
        let inputRescriC = document.getElementById("inputReescContr").value;
        let validar = false;

        let inputsBuenos = [];
        this.querySelectorAll(".input-validar").forEach((input) => {
            if (input.parentElement.classList.contains("valido")) inputsBuenos.push(true);
        });

        let esValido = verificarFormularioRC();

        if (esValido) {
            validar = inputRescriC === inputNewC ? true : false;

            if (validar) {
                // envío del III(3) formularios en donde este el tres realiza la función
                verificar("/cambiarC", formRC, "tres");

                document.querySelectorAll(".input-validar").forEach((input) => {
                    let campoCustom = input.closest(".campo-custom");
                    let iconoDer = campoCustom.querySelector(".icono-der");
                    let check = iconoDer.children[0];
                    let error = iconoDer.children[1];
                    input.parentElement.classList.remove("invalido");
                    input.parentElement.classList.remove("valido");
                    let pError = campoCustom.querySelector("p");
                    pError.classList.add("d-none");
                    if (check && error) chulitoYX(check, error, "vacio");
                });
            } else {
                alertError("Error", "La contraseña nueva y reescrita no coinciden.");
            }
        } else {
            alertError("Error", "Por favor verifique que todos los datos estén correctos.");
        }
    });

    document.querySelectorAll(".toggle-password").forEach(function (toggle) {
        toggle.addEventListener("click", function () {
            const input = document.getElementById(this.getAttribute("data-target"));
            const ojover = this.querySelector(".ojo-ver");
            const ojoOcultar = this.querySelector(".ojo-ocultar");

            if (input.type === "password") {
                input.type = "text";
                ojover.classList.add("d-none");
                ojoOcultar.classList.remove("d-none");
            } else {
                input.type = "password";
                ojover.classList.remove("d-none");
                ojoOcultar.classList.add("d-none");
            }
        });
    });
});
