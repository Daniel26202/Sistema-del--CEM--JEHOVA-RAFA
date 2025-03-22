addEventListener("DOMContentLoaded", function () {

    const btnEPassword = document.querySelectorAll(".btn_editarPassword");
    const btnEUsuario = document.getElementById("btnEUsuario");
    const btnAPassw = document.getElementById("btnAPassw");
    const formUContr = document.getElementById("formUC");
    let idU = "";
    let nameUsuario = "";

    btnEPassword.forEach(btn => {
        btn.addEventListener("click", function () {
            formUContr.reset();
            verificadorClaves = "";
            idU = btn.getAttribute("data-id-u");
            nameUsuario = btn.getAttribute("data-usuario");
            btnEUsuario.setAttribute("uk-toggle", `target: #modal-exampleEditar${idU}`);

            // Oculta el div después del tiempo especificado
            alertaError.classList.add("d-none");
            alertaError.classList.remove(`${color}`);
        })

    });


    // Ajax
    const verificarPassw = async () => {
        try {
            const datosFormulario = new FormData(formUContr);
            const contenido = {
                method: "POST",
                body: datosFormulario
            };
            let peticion = await fetch(`?c=ControladorUsuarios/verificarPassw&usuario=${nameUsuario}`, contenido);
            let resultado = await peticion.json();

            console.log(resultado);
            if (resultado == false) {

                // mensaje de alerta
                alertaMsj("Contraseña actual incorrecta.", 8000, "rojo");
            } else {

                // mensaje de alerta
                alertaMsj("La contraseña se actualizo correctamente.", 8000, "azul");
            }
        } catch (e) {
            console.log("error Ajax");
        }
    };

    // alerta dinámica
    let alertaError = document.getElementById("alerta_errorMEPAc");
    // función de alertas
    function alertaMsj(msj, time, color) {
        let p = alertaError.querySelector("P");
        p.textContent = msj;
        // Muestra el div
        alertaError.classList.remove("d-none");

        if (color == "rojo") {
            alertaError.classList.add(`comentarioRed`);
            alertaError.classList.add(`uk-alert-danger`);
            alertaError.classList.remove(`comentarioAzul`);
            alertaError.classList.remove(`uk-alert-primary`);
        } else if (color == "azul") {
            alertaError.classList.add(`comentarioAzul`);
            alertaError.classList.add(`uk-alert-primary`);
            alertaError.classList.remove(`comentarioRed`);
            alertaError.classList.remove(`uk-alert-danger`);

        }
        if (time > 1) {

            setTimeout(function () {
                // Oculta el div después del tiempo especificado
                alertaError.classList.add("d-none");
                alertaError.classList.remove(`${color}`);

            }, time);
        }
    }


    let verificadorClaves = "";
    let inputVClave = document.querySelector("#inputVClave");
    inputVClave.addEventListener("keyup", function () {
        let valorV = inputVClave.value;
        let valorN = document.querySelector("#claveNew").value;
        if (valorV === valorN) {
            verificadorClaves = "Igual";
            alertaMsj("", 10, "rojo");
        } else {
            verificadorClaves = "diferente";
            // mensaje de alerta
            alertaMsj("La contraseña nueva y reescrita no coinciden.", "estático", "rojo");
        }
    })

    btnAPassw.addEventListener("click", function () {
        if (verificadorClaves == "Igual") {
            verificarPassw();
            formUContr.reset();
        } else {
            // mensaje de alerta
            alertaMsj("Complete los campos.", 8000, "rojo");
        }
    })

})