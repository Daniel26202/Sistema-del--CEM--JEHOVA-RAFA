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
                btnEC.classList.add("d-none");
                divTime.classList.add("d-none");
                btnRC.classList.add("d-none");

            } else if (resultado != "conexionFallida") {
                // mensaje de alerta
                alertaMsj("Código enviado al correo exitosamente", 8000, "azul");
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
                btnEC.classList.add("d-none");
                btnVC.classList.remove("d-none");
                btnRC.classList.add("d-none");
                divTime.classList.remove("d-none");
                temporizador();


            } else {

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
                btnEC.classList.add("d-none");
                divTime.classList.add("d-none");
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
            }

        } else if (numero == "cuatro") {
            if (resultado === true) {
                alertaMsj("Código enviado al correo exitosamente", 8000, "azul");

                divTime.classList.remove("d-none");
                divTime.textContent = "05:00";

                btnEC.classList.add("d-none");
                temporizador();

            }
        }


        // } catch (error) {
        // console.log(error);
        // }

    }


    function temporizador() {

        // Definimos la duración total del temporizador en milisegundos (5m = 300,000 ms)
        let duracion = 5 * 60 * 1000;
        // Calculamos el tiempo de finalización sumando la duración a la hora actual
        let endTime = Date.now() + duracion;

        // temporizador de los 5 minutos, dentro de la función  
        function temporizadorD() {
            // Calculamos la diferencia entre la hora final y la hora actual
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
        temporizadorD()
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

    function evitarEnvio(form) {
        form.addEventListener("submit", (e) => {
            e.preventDefault();
        })
    }

    evitarEnvio(formUCE);
    evitarEnvio(formC);
    evitarEnvio(formRC);


    // envío del I(1) formularios
    document.querySelector("#btnVerificarUCE").addEventListener("click", function (e) {
        // en donde este el uno realiza la función
        verificar("http://localhost/Sistema-del--CEM--JEHOVA-RAFA/RecuperarContr/verificarUC", formUCE, "uno");
    });
    // envío del II(2) formularios
    document.querySelector("#btnVerificarC").addEventListener("click", function (e) {
        // en donde este el dos realiza la función
        verificar("http://localhost/Sistema-del--CEM--JEHOVA-RAFA/RecuperarContr/verificarCodigo", formC, "dos");
    });
    // envío del III(3) formularios
    document.querySelector("#btnVerificarRC").addEventListener("click", function (e) {
        let inputNewC = document.getElementById("inputNewPass").value;
        let inputRescriC = document.getElementById("inputReescContr").value;
        let validar = false;

        validar = (inputRescriC === inputNewC) ? true : false;
 
        if (validar) {
            // en donde este el tres realiza la función
            verificar("http://localhost/Sistema-del--CEM--JEHOVA-RAFA/RecuperarContr/cambiarC", formRC, "tres");
        } else {
            alertaMsj("La contraseña nueva y reescrita no coinciden.", 8000, "rojo");

        }
    });
    // reenvío de código IIII(4) 
    document.querySelector("#btnEviarCod").addEventListener("click", function (e) {
        // en donde este el cuatro realiza la función
        verificar("http://localhost/Sistema-del--CEM--JEHOVA-RAFA/RecuperarContr/reenviarCodigo", formC, "cuatro");
    });

})