addEventListener("DOMContentLoaded", function () {
    const iconoUno = document.querySelector("#icono-uno");
    const inputUno = document.querySelector("#inputUno");
    const iconoDos = document.querySelector("#icono-dos");
    const inputDos = document.querySelector("#inputDos");

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

    //si existe el comentario lo muestra y después de 8sg lo oculta
    if (comentario) {

        comentario.style.display = "block";

        setTimeout(function () {
            comentario.style.display = "none";
        }, 8000)

    }
    inputDos.addEventListener("keyup", () => {
        activarMostrarContra.classList.remove('d-none');
        if (inputDos.value == ""){
            activarMostrarContra.classList.add('d-none');
            desMostrarContra.classList.add("d-none");
        }if (inputDos.type == "text" && inputDos.value.length > 0) {
            desMostrarContra.classList.remove("d-none");
            activarMostrarContra.classList.add("d-none");
        } 
    });

    const activarMostrarContra = document.getElementById("mostrarPassword");
    const desMostrarContra = document.getElementById("ocultarPassword");
    
    function mostrarContrasena() {
        if (inputDos.type == "password") {
            inputDos.type = "text";
            desMostrarContra.classList.remove("d-none");
            activarMostrarContra.classList.add("d-none");
        } else {
            inputDos.type = "password";
            desMostrarContra.classList.add("d-none");
            activarMostrarContra.classList.remove("d-none");
        
    }
    }
    
    activarMostrarContra.addEventListener("click", mostrarContrasena);
    desMostrarContra.addEventListener("click", mostrarContrasena);
    
    

})