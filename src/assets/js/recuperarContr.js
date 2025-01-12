addEventListener("DOMContentLoaded", function () {
    const iconoUno = document.querySelector("#icono-uno");
    const inputUno = document.querySelector("#inputUno");

    const iconoDos = document.querySelector("#icono-dos");
    const inputDos = document.querySelector("#inputDos");

    const iconoTres = document.querySelector("#icono-tres");
    const inputTres = document.querySelector("#inputTres");

    const iconoCuatro = document.querySelector("#icono-cuatro");
    const inputCuatro = document.querySelector("#inputCuatro");

    //este es el comentario 
    const comentario = document.querySelector(".comentario");


    // primer input
    inputUno.addEventListener("focus", () => {

        iconoUno.classList.toggle("icono", false);
        iconoUno.classList.toggle("icono-animacion", true);

    })

    inputUno.addEventListener("blur", () => {

        if (inputUno.value == "") {
            iconoUno.classList.toggle("icono", true);
            iconoUno.classList.toggle("icono-animacion", false);
        }
    })

    // segundo input
    inputDos.addEventListener("focus", () => {

        iconoDos.classList.toggle("icono", false);
        iconoDos.classList.toggle("icono-animacion", true);

    })

    inputDos.addEventListener("blur", () => {

        if (inputDos.value == "") {

            iconoDos.classList.toggle("icono", true);
            iconoDos.classList.toggle("icono-animacion", false);

        }
    })

    // tercer input
    inputTres.addEventListener("focus", () => {

        iconoTres.classList.toggle("icono-respuesta-seguridad", false);
        iconoTres.classList.toggle("icono-respuesta-seguridad-animacion", true);

    })

    inputTres.addEventListener("blur", () => {

        if (inputTres.value == "") {

            iconoTres.classList.toggle("icono-respuesta-seguridad", true);
            iconoTres.classList.toggle("icono-respuesta-seguridad-animacion", false);

        }
    })

    // cuarto input
    inputCuatro.addEventListener("focus", () => {

        iconoCuatro.classList.toggle("icono", false);
        iconoCuatro.classList.toggle("icono-animacion", true);

    })

    inputCuatro.addEventListener("blur", () => {

        if (inputCuatro.value == "") {

            iconoCuatro.classList.toggle("icono", true);
            iconoCuatro.classList.toggle("icono-animacion", false);

        }
    })

    //si existe el comentario lo muestra y después de 8sg lo oculta
    if (comentario) {

        comentario.style.display = "block";

        setTimeout(function () {
            comentario.style.display = "none";
        }, 8000)

    }

    inputCuatro.addEventListener("keyup", () => {
        activarRecMostrarContra.classList.remove('d-none');
        if (inputCuatro.value == ""){
        activarRecMostrarContra.classList.add('d-none');
        desRecMostrarContra.classList.add("d-none");
        }if (inputCuatro.type == "text" && inputCuatro.value.length > 0) {
            desRecMostrarContra.classList.remove("d-none");
            activarRecMostrarContra.classList.add("d-none");
        } 
    });

    const activarRecMostrarContra = document.getElementById("mostrarPasswordRec");
    const desRecMostrarContra = document.getElementById("ocultarPasswordRec");
    
    function mostrarRecContrasena() {
        if (inputCuatro.type == "password") {
            inputCuatro.type = "text";
            desRecMostrarContra.classList.remove("d-none");
            activarRecMostrarContra.classList.add("d-none");
        } else {
            inputCuatro.type = "password";
            desRecMostrarContra.classList.add("d-none");
            activarRecMostrarContra.classList.remove("d-none");
        
    }
    }
    
    activarRecMostrarContra.addEventListener("click", mostrarRecContrasena);
    desRecMostrarContra.addEventListener("click", mostrarRecContrasena);



})