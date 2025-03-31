addEventListener("DOMContentLoaded", function () {
    // const iconoUno = document.querySelector("#icono-uno");
    // const inputUno = document.querySelector("#inputUno");

    // const iconoDos = document.querySelector("#icono-dos");
    // const inputDos = document.querySelector("#inputDos");

    // const iconoTres = document.querySelector("#icono-tres");
    // const inputTres = document.querySelector("#inputTres");

    // const iconoCuatro = document.querySelector("#icono-cuatro");
    // const inputCuatro = document.querySelector("#inputCuatro");

    // //este es el comentario 
    // const comentario = document.querySelector(".comentario");


    // // primer input
    // inputUno.addEventListener("focus", () => {

    //     iconoUno.classList.toggle("icono", false);
    //     iconoUno.classList.toggle("icono-animacion", true);

    // })

    // inputUno.addEventListener("blur", () => {

    //     if (inputUno.value == "") {
    //         iconoUno.classList.toggle("icono", true);
    //         iconoUno.classList.toggle("icono-animacion", false);
    //     }
    // })

    // // segundo input
    // inputDos.addEventListener("focus", () => {

    //     iconoDos.classList.toggle("icono", false);
    //     iconoDos.classList.toggle("icono-animacion", true);

    // })

    // inputDos.addEventListener("blur", () => {

    //     if (inputDos.value == "") {

    //         iconoDos.classList.toggle("icono", true);
    //         iconoDos.classList.toggle("icono-animacion", false);

    //     }
    // })

    // // tercer input
    // inputTres.addEventListener("focus", () => {

    //     iconoTres.classList.toggle("icono-respuesta-seguridad", false);
    //     iconoTres.classList.toggle("icono-respuesta-seguridad-animacion", true);

    // })

    // inputTres.addEventListener("blur", () => {

    //     if (inputTres.value == "") {

    //         iconoTres.classList.toggle("icono-respuesta-seguridad", true);
    //         iconoTres.classList.toggle("icono-respuesta-seguridad-animacion", false);

    //     }
    // })

    // // cuarto input
    // inputCuatro.addEventListener("focus", () => {

    //     iconoCuatro.classList.toggle("icono", false);
    //     iconoCuatro.classList.toggle("icono-animacion", true);

    // })

    // inputCuatro.addEventListener("blur", () => {

    //     if (inputCuatro.value == "") {

    //         iconoCuatro.classList.toggle("icono", true);
    //         iconoCuatro.classList.toggle("icono-animacion", false);

    //     }
    // })

    // //si existe el comentario lo muestra y después de 8sg lo oculta
    // if (comentario) {

    //     comentario.style.display = "block";

    //     setTimeout(function () {
    //         comentario.style.display = "none";
    //     }, 8000)

    // }

    // inputCuatro.addEventListener("keyup", () => {
    //     activarRecMostrarContra.classList.remove('d-none');
    //     if (inputCuatro.value == ""){
    //     activarRecMostrarContra.classList.add('d-none');
    //     desRecMostrarContra.classList.add("d-none");
    //     }if (inputCuatro.type == "text" && inputCuatro.value.length > 0) {
    //         desRecMostrarContra.classList.remove("d-none");
    //         activarRecMostrarContra.classList.add("d-none");
    //     } 
    // });

    // const activarRecMostrarContra = document.getElementById("mostrarPasswordRec");
    // const desRecMostrarContra = document.getElementById("ocultarPasswordRec");

    // function mostrarRecContrasena() {
    //     if (inputCuatro.type == "password") {
    //         inputCuatro.type = "text";
    //         desRecMostrarContra.classList.remove("d-none");
    //         activarRecMostrarContra.classList.add("d-none");
    //     } else {
    //         inputCuatro.type = "password";
    //         desRecMostrarContra.classList.add("d-none");
    //         activarRecMostrarContra.classList.remove("d-none");

    // }
    // }

    // activarRecMostrarContra.addEventListener("click", mostrarRecContrasena);
    // desRecMostrarContra.addEventListener("click", mostrarRecContrasena);

    /////////////////////////////////////////////////////////////////////

    //formulario, usuario correo electr 
    const formUCE = document.getElementById("formVerificarUCE");
    const formC = document.getElementById("formCodigo");
    const formRC = document.getElementById("formRecuperarPassword");


    const tituloPg = document.getElementById("tituloText");
    const btnVUCE = document.getElementById("divBtnVerificarUCE");
    const btnVC = document.getElementById("divBtnVerificarC");
    const btnRC = document.getElementById("divBtnVerificarRC");

    const divFormUno = document.getElementById("formUno");
    const divFormDos = document.getElementById("formDos");
    const divFormTres = document.getElementById("formTres");

    let alertaError = document.getElementById("alerta_error");

    const verificar = async (ruta, formulario, numero) => {
        // try {
            console.log("resultado");
            const datosFormulario = new FormData(formulario);
            const contenido = {
                method: "POST",
                body: datosFormulario
            };
            let peticion = await fetch(ruta, contenido);

            let resultado = await peticion.json();

            console.log(resultado);
            if (resultado === "conexionFallida") {
                // mensaje de alerta
                alertaMsj("Envío de código fallido, verifique si tiene conexión a internet", 8000, "rojo");
            }
            // primer formulario Verificar usuario y contraseña
            if (numero == "uno") {
                if (resultado == false) {
                    // mensaje de alerta
                    alertaMsj("Usuario o correo electrónico incorrectos.", 8000, "rojo");
                    tituloPg.textContent = "Olvide mi contraseña";

                    divFormUno.classList.remove("d-none");
                    divFormDos.classList.add("d-none");
                    divFormTres.classList.add("d-none");
                    btnVUCE.classList.remove("d-none");
                    btnVC.classList.add("d-none");
                    btnRC.classList.add("d-none");

                } else if (resultado != "conexionFallida") {
                    // mensaje de alerta
                    alertaMsj("Datos del personal hallados exitosamente", 8000, "azul");
                    tituloPg.textContent = "Ingresé el código para la recuperación";

                    document.querySelector("#idUsuario").value = parseInt(resultado.id_usuario);
                    document.querySelector("#correoV").value = resultado.correo;
                    document.querySelector("#idUsuarioDos").value = parseInt(resultado.id_usuario);
                    document.querySelector("#correoVDos").value = resultado.correo;
                    document.querySelector("#idUsuarioTres").value = parseInt(resultado.id_usuario);
                    document.querySelector("#correoVTres").value = resultado.correo;

                    divFormUno.classList.add("d-none");
                    divFormDos.classList.remove("d-none");
                    divFormTres.classList.add("d-none");
                    btnVUCE.classList.add("d-none");
                    btnVC.classList.remove("d-none");
                    btnRC.classList.add("d-none");

                } else{
                    
                }

                // segundo formulario verificación de código
            } else if (numero == "dos") {

                if (resultado === "exitoso") {
                    // mensaje de alerta
                    alertaMsj("Verificación exitosa", 8000, "azul");
                    tituloPg.textContent = "Ingresé su nueva contraseña";

                    divFormUno.classList.add("d-none");
                    divFormDos.classList.add("d-none");
                    divFormTres.classList.remove("d-none");
                    btnVUCE.classList.add("d-none");
                    btnVC.classList.add("d-none");
                    btnRC.classList.remove("d-none");
                } else if (resultado === "codigoIncorrecto") {
                    // mensaje de alerta
                    alertaMsj("Código invalido", 8000, "rojo");
                } else if (resultado === "CodExpiro") {
                    // mensaje de alerta
                    alertaMsj("Su código expiro.", 8000, "rojo");
                }

                // tercero formulario, nueva clave
            } else if (numero == "tres") {

                if (resultado === "Actualizado") {
                    // mensaje de alerta
                    alertaMsj("Contraseña actualizada correctamente", 8000, "azul");
                    tituloPg.textContent = "Olvide mi contraseña";

                    divFormUno.classList.remove("d-none");
                    divFormDos.classList.add("d-none");
                    divFormTres.classList.add("d-none");
                    btnVUCE.classList.remove("d-none");
                    btnVC.classList.add("d-none");
                    btnRC.classList.add("d-none");
                }

            }


        // } catch (error) {
            // console.log(error);
        // }

    }

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

        setTimeout(function () {
            // Oculta el div después del tiempo especificado
            alertaError.classList.add("d-none");
            alertaError.classList.remove(`${color}`);

        }, time);
    }


    // envío del I formularios
    document.querySelector("#btnVerificarUCE").addEventListener("click", function () {
        // en donde este el uno realiza la función
        verificar("http://localhost/Sistema-del--CEM--JEHOVA-RAFA/RecuperarContr/verificarUC", formUCE, "uno");
    });
    // envío del II formularios
    document.querySelector("#btnVerificarC").addEventListener("click", function () {
        // en donde este el dos realiza la función
        verificar("http://localhost/Sistema-del--CEM--JEHOVA-RAFA/RecuperarContr/verificarCodigo", formC, "dos");
    });
    // envío del III formularios
    document.querySelector("#btnVerificarRC").addEventListener("click", function () {
        // en donde este el tres realiza la función
        verificar("http://localhost/Sistema-del--CEM--JEHOVA-RAFA/RecuperarContr/cambiarC", formRC, "tres");
    });

})