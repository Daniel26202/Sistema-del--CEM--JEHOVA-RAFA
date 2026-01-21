// Objeto con las expresiones regulares para validar cada tipo de campo
const expresiones = {
    nombre: {
        expresion: /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/,
        mensajeError: "El Nombre debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres",
    },

    apellido: {
        expresion: /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/,
        mensajeError:
            "El Apellido debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres",
    },

    usuario: { expresion: /^[a-zA-Z0-9._-]{8,16}$/, mensajeError: "" },
    correo: { expresion: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/, mensajeError: "" },
    password: { expresion: /^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,12}$/, mensajeError: "" },
    cedula: {
        expresion: /^([1-9]{1})([0-9]{7,8})$/,
        mensajeError: "La cédula debe contener únicamente números y estar entre 7 a 8 caracteres",
    },
    telefono: {
        expresion: /^(0?)(412|414|416|424|426|422|212|24[1-9]|25[1-9])\d{7}$/,
        mensajeError: 'El Teléfono solo debe contener y comen números, comenzando con "0412 o 0414 o 0416 o 0424 o 0426 o 0422',
    },
    direccion: { expresion: /^([A-Za-z0-9\s\.,#-]{8,})$/, mensajeError: "Debe estar completa y detallada" },
    descripcion: { expresion: /^([A-ZÁÉÍÓÚÑ][a-záéíóúñ0-9\s\.,#-]{8,})$/, mensajeError: "" },
    fn: { expresion: /^\d{4}\-\d{2}\-\d{2}$/, mensajeError: "" },
    fechaDeCita: { expresion: /^\d{4}\-\d{2}\-\d{2}$/, mensajeError: "" },
    cantidad: { expresion: /^([1-9]{1})([0-9]{1,4})?$/, mensajeError: "" },
    precio: { expresion: /^(?!0$)(?!1$)\d+([.,]\d+)?$/, mensajeError: "" },
    fechaDeVencimiento: { expresion: /^\d{4}\-\d{2}\-\d{2}$/, mensajeError: "" },
    lote: { expresion: /^[0-9-_]{4,10}$/, mensajeError: "" },
    marca: { expresion: /^[A-ZÁÉÍÓÚÑ\s][a-záéíóúñ\s]{4,10}$/, mensajeError: "" },
    medida: { expresion: /^\d+(\.\d+)?\s?(ml|L|g|kg|m|cm|mm)$/, mensajeError: "" },
    genero: { expresion: /^"Masculino"|"Femenino"$/, mensajeError: "El Genero debe ser Masculino o Femenino" },
};

// Nueva función para validar fechas no futuras ni pasadas
function validarFecha(input, arrayElementos, campo, formulario) {
    let { pError, check, error } = arrayElementos;
    const valorFecha = new Date(input.value);
    const fechaHoy = new Date();
    // Establece el tiempo a la medianoche para comparación
    fechaHoy.setHours(0, 0, 0, 0);

    pError.classList.add("fw-bold");
    pError.classList.add("p-error-validaciones");

    if (campo == "fn") {
        actualizarEstadoInput(input, "incorrecto", formulario);
        if (!expresiones.fn.expresion.test(input.value)) {
            pError.textContent = "La fecha debe tener el formato YYYY-MM-DD.";
            pError.classList.remove("d-none");
            chulitoYX(check, error, "inValido");
            return false;
        } else if (valorFecha > fechaHoy) {
            pError.textContent = "La fecha no puede ser del futuro.";
            pError.classList.remove("d-none");
            chulitoYX(check, error, "inValido");
            return false;
        }
    } else if (campo == "fechaDeCita") {
        actualizarEstadoInput(input, "incorrecto", formulario);
        if (!expresiones.fn.expresion.test(input.value)) {
            pError.textContent = "La fecha debe tener el formato YYYY-MM-DD.";
            pError.classList.remove("d-none");
            chulitoYX(check, error, "inValido");
            return false;
        } else if (valorFecha < fechaHoy) {
            pError.textContent = "La fecha no puede ser del pasado.";
            pError.classList.remove("d-none");
            chulitoYX(check, error, "inValido");
            return false;
        }
    } else if (campo === "fechaDeVencimiento") {
        actualizarEstadoInput(input, "incorrecto", formulario);
        if (!expresiones.fechaDeVencimiento.expresion.test(input.value)) {
            pError.textContent = "La fecha debe tener el formato YYYY-MM-DD.";
            pError.classList.remove("d-none");
            chulitoYX(check, error, "inValido");
            return false;
        } else if (valorFecha <= fechaHoy) {
            pError.textContent = "La fecha de vencimiento no puede ser del pasado o de hoy.";
            pError.classList.remove("d-none");
            chulitoYX(check, error, "inValido");
            return false;
        }
    }
    // Si pasa todas las validaciones
    chulitoYX(check, error, "valido");
    pError.classList.add("d-none");
    actualizarEstadoInput(input, "correcto", formulario);
    return true;
}

// Función para validar los campos de tipo <select>
function validarSelect(select, arrayElementos, campos, formulario) {
    let { pError, check, error } = arrayElementos;
    pError.classList.add("fw-bold");
    pError.classList.add("p-error-validaciones");
    if (select.value === "selection" || select.value === "" || expresiones.genero.expresion.test(select.value)) {
        pError.textContent = "Por favor, selecciona una opción válida.";
        pError.classList.remove("d-none");

        //chulito y equis
        chulitoYX(check, error, "inValido");
        campos[select.name] = false;
        actualizarEstadoInput(select, "incorrecto", formulario);
        return false;
    } else {
        pError.classList.add("d-none");

        //chulito y equis
        chulitoYX(check, error, "valido");
        campos[select.name] = true;
        actualizarEstadoInput(select, "correcto", formulario);
        return true;
    }
}


export function inicializarValidacionFormulario(formulario) {
    const campos = {};

    const inputs = formulario.querySelectorAll(".input-validar");

    // Inicializar campos
    inputs.forEach((input) => {
        campos[input.name] = false;
        // Marcar como modificado cuando el usuario interactúa
        input.addEventListener("keyup", (e) => {
            validarFormulario(e, formulario, campos);
        });
        input.addEventListener("input", (e) => {
            validarFormulario(e, formulario, campos);
        });
        input.addEventListener("blur", (e) => {
            validarFormulario(e, formulario, campos);
        });
    });

    // Retornar función verificadora
    return function verificarFormulario() {

        let longitudInputs = inputs.length;
        let inputsTrue = []

        inputs.forEach(input => {
            if (input.parentElement.classList.contains('valido')) inputsTrue.push(true);    
        });

        if (inputsTrue.length == longitudInputs) {
            return true

        } else return false
        
    };
}



// Función que valida los campos cada vez que ocurre un evento en un input
function validarFormulario(e, formulario, campos) {
    const input = e.target;
    const nameInput = input.name;
    let mensajeError = expresiones[input.name].mensajeError;

    let campoCustom = input.closest(".campo-custom");

    let pError = campoCustom.querySelector("p");
    let check = campoCustom.querySelector(".check");
    let error = campoCustom.querySelector(".error");
    let arrayElementos = {
        pError: pError,
        check: check,
        error: error,
    };

    // validar select
    if (input.tagName === "SELECT") {
        validarSelect(input, arrayElementos, campos, formulario);
    } else if (nameInput === "fn" || nameInput === "fechaDeCita" || nameInput === "fechaDeVencimiento") {
        campos[nameInput] = validarFecha(input, arrayElementos, nameInput, formulario);
    } else {
        const expresion = expresiones[nameInput].expresion;
        if (expresion) {
            validarCampo(expresion, input, nameInput, campos, formulario, arrayElementos, mensajeError);
        }
    }
}
// Función que valida los campos cada vez que se abra el modal de editar


// Función que valida un campo individual
function validarCampo(expresion, input, campo, campos, formulario, arrayElementos, mensajeError) {
    let { pError, check, error } = arrayElementos;
    pError.innerText = mensajeError;
    pError.classList.add("fw-bold");
    pError.classList.add("p-error-validaciones");

    if (expresion.test(input.value)) {
        actualizarEstadoInput(input, "correcto");
        pError.classList.add("d-none");
        chulitoYX(check, error, "valido");
        campos[campo] = true;
    } else {
        actualizarEstadoInput(input, "incorrecto");
        pError.classList.remove("d-none");
        chulitoYX(check, error, "inValido");
        campos[campo] = false;
    }

}

// Función que actualiza el aspecto visual del input según su estado de validación
function actualizarEstadoInput(input, estado) {
    input.parentElement.classList.toggle("valido", estado === "correcto");
    input.parentElement.classList.toggle("invalido", estado === "incorrecto");
}

export function chulitoYX(check, error, Validar) {
    if (Validar === "valido") {
        check.classList.remove("d-none");
        error.classList.add("d-none");
    } else if (Validar === "inValido") {
        check.classList.add("d-none");
        error.classList.remove("d-none");
    }
}
