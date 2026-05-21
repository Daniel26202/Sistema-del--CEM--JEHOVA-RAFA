// Objeto con las expresiones regulares para validar cada tipo de campo
const expresiones = {
    nombre: {
        expresion: /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}(\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,})*$/,
        mensajeError:
            "El nombre debe iniciar con mayúscula, tener al menos 3 letras y puede incluir un segundo nombre separado por un espacio.",
    },
    categoria: {
        // Inicia con mayúscula, permite letras (mayúsculas o minúsculas), acentos y espacios.
        expresion: /^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ\s]{2,49}$/,
        mensajeError:
            "La categoría debe iniciar con mayúscula, contener al menos 3 letras y solo puede incluir letras y espacios.",
    },
    patologia: {
        // Inicia con mayúscula. Permite letras, números, espacios y guiones. Mínimo 3 caracteres.
        expresion: /^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ0-9\s-]{2,70}$/,
        mensajeError:
            "El nombre de la patología debe iniciar con mayúscula, tener al menos 3 caracteres y solo puede incluir letras, números, espacios o guiones.",
    },

    codigo: {
        expresion: /^\d{6,11}$/,
        mensajeError: "El código debe contener solo números y tener al menos 6 caracteres",
    },

    apellido: {
        expresion: /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}(\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,})*$/,
        mensajeError:
            "El Apellido debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres",
    },

    usuario: {
        expresion: /^[a-zA-Z0-9._-]{8,16}$/,
        mensajeError: "Usuario incorrecto, debe tener al menos 8 caracteres",
    },
    correo: {
        expresion: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
        mensajeError: "El correo debe tener un formato válido (ej: ejemplo@dominio.com)",
    },
    password: {
        expresion: /^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,12}$/,
        mensajeError:
            "La contraseña debe tener entre 8 y 12 caracteres, incluir al menos una mayúscula, un número y un carácter especial.",
    },
    passwordNew: {
        expresion: /^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,12}$/,
        mensajeError:
            "La contraseña debe tener entre 8 y 12 caracteres, incluir al menos una mayúscula, un número y un carácter especial.",
    },
    passwordConf: {
        expresion: /^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,12}$/,
        mensajeError:
            "La contraseña debe tener entre 8 y 12 caracteres, incluir al menos una mayúscula, un número y un carácter especial.",
    },
    cedula: {
        expresion: /^([1-9]{1})([0-9]{6,7})$/,
        mensajeError: "La cédula debe contener únicamente números y estar entre 7 a 8 caracteres",
    },
    telefono: {
        expresion: /^(0?)(412|414|416|424|426|422|212|24[1-9]|25[1-9])\d{7}$/,
        mensajeError: 'El Teléfono solo debe contener y comen números, comenzando con "0412 o 0414 o 0416 o 0424 o 0426 o 0422',
    },
    direccion: {
        expresion: /^([A-Za-z0-9\s\.,#-]{8,})$/,
        mensajeError: "Debe estar completa y detallada",
    },
    descripcion: {
        expresion: /^([A-ZÁÉÍÓÚÑ][a-záéíóúñ0-9\s\.,#-]{8,})$/,
        mensajeError: "",
    },
    fn: { expresion: /^\d{4}\-\d{2}\-\d{2}$/, mensajeError: "" },
    fechaDeCita: { expresion: /^\d{4}\-\d{2}\-\d{2}$/, mensajeError: "" },
    cantidad: {
        expresion: /^([1-9]{1})([0-9]{1,4})?$/,
        mensajeError: "La cantidad debe ser entre 1 y 9999",
    },
    precio: {
        expresion: /^(?!0$)(?!1$)\d+([.,]\d+)?$/,
        mensajeError: "El precio debe tener formato válido (ej: 1.00, 10.00, 100.00)",
    },
    precioD: {
        expresion: /^(?!0$)(?!1$)\d+([.,]\d+)?$/,
        mensajeError: "El precio debe tener formato válido (ej: 1.00, 10.00, 100.00)",
    },

    referencia: {
        expresion: /^\d{4}$/,
        mensajeError: "La Referencia debe tener solo ultimos 4 numeros",
    },
    fechaDeVencimiento: { expresion: /^\d{4}\-\d{2}\-\d{2}$/, mensajeError: "" },
    lote: {
        expresion: /^[0-9-_]{4,10}$/,
        mensajeError: "El número de lote debe tener entre 4 y 10 dígitos",
    },
    marca: { expresion: /^[A-ZÁÉÍÓÚÑ\s][a-záéíóúñ\s]{4,10}$/, mensajeError: "" },
    medida: {
        expresion: /^\d+(\.\d+)?\s?(ml|L|g|kg|m|cm|mm)$/,
        mensajeError: "",
    },
    stockMinimo: {
        expresion: /^([1-9]{1})([0-9]{1})?$/,
        mensajeError: "El stock mínimo debe ser al menos 1",
    },
    genero: {
        expresion: /^"Masculino|| Femenino"$/,
        mensajeError: "El Genero debe ser Masculino o Femenino",
    },

    proveedor: {
        expresion: /^\d+$/,
        mensajeError: "El proveedor esta mal seleccionado",
    },

    id_personal: {
        expresion: /^\d+$/,
        mensajeError: "El Doctor esta mal seleccionado",
    },

    id_rol: {
        expresion: /^\d+$/,
        mensajeError: "El rol esta mal seleccionado",
    },

    id_insumo: {
        expresion: /^\d+$/,
        mensajeError: "El insumo esta mal seleccionado",
    },
    id_categoria: {
        expresion: /^\d+$/,
        mensajeError: "El serivico esta mal seleccionado",
    },
    id_doctor: {
        expresion: /^\d+$/,
        mensajeError: "El doctor esta mal seleccionado",
    },
    indicaciones: {
        // Permite Mayúscula inicial y luego cualquier combinación de letras (mayus/minus), números y espacios
        expresion: /^[A-ZÁÉÍÓÚÑ][A-Za-záéíóúñ0-9\s]{7,}$/,
        mensajeError: "Debe iniciar con mayúscula y tener al menos 8 caracteres (letras o números).",
    },
    diagnostico: {
        // Permite mayúscula inicial, letras, números, acentos, signos de puntuación y saltos de línea (\n)
        expresion: /^[A-ZÁÉÍÓÚÑ][A-Za-záéíóúñ0-9\s,.\n\r]{7,}$/,
        mensajeError:
            "El diagnóstico debe iniciar con mayúscula y tener al menos 8 caracteres (puedes incluir puntos, comas y saltos de línea).",
    },
    historial: {
        expresion: /^[A-ZÁÉÍÓÚÑ\s][a-záéíóúñ0-9\s]{8,}$/,
        mensajeError: "Debe iniciar con mayúscula y tener al menos 8 caracteres.",
    },

    historialE: {
        expresion: /^[A-ZÁÉÍÓÚÑ\s][a-záéíóúñ0-9\s]{8,}$/,
        mensajeError: "Debe iniciar con mayúscula y tener al menos 8 caracteres.",
    },

    historialEnF: {
        expresion: /^[A-ZÁÉÍÓÚÑ\s][a-záéíóúñ0-9\s]{8,}$/,
        mensajeError: "Debe iniciar con mayúscula y tener al menos 8 caracteres.",
    },

    imagen: {
        expresion: /([A-Za-z0-9._-]\s?)+\.(jpg|JPG|PNG|png|jpeg|JPEG)+/,
        mensajeError: "La imagen debe ser .jpg, .png o .jpeg",
    },

    rif: {
        expresion: /^[VJEGP]\-[0-9]{8,9}$/,
        mensajeError: "El RIF debe tener el formato V-12345678 o J-12345678",
    },
    tipo: {
        expresion: /^(Cita|Examenes)$/,
        mensajeError: "Debe seleccionar un tipo de servicio válido",
    },
    severidad: {
        expresion: /^(LEVE|MODERADA|GRAVE)$/,
        mensajeError: "Debe seleccionar la severidad",
    },

    precioD: {
        expresion: /^\d+(?:[.,]\d+)?$/,
        mensajeError: "El precio debe ser un número válido, puede incluir decimales con punto o coma",
    },
    precioBs: {
        expresion: /^\d+(?:[.,]\d+)?$/,
        mensajeError: "El precio debe ser un número válido, puede incluir decimales con punto o coma",
    },
    id_especialidad: {
        expresion: /^\d+$/,
        mensajeError: "La especialidad esta mal selecionada",
    },
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
function validarSelect(select, arrayElementos, campos, formulario, attExpresion) {
    let { pError, check, error } = arrayElementos;
    pError.classList.add("fw-bold");
    pError.classList.add("p-error-validaciones");

    if (select.value === "selection" || select.value === "" || !expresiones[attExpresion].expresion.test(select.value)) {
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
        let inputsTrue = [];

        inputs.forEach((input) => {
            if (input.parentElement.classList.contains("valido")) inputsTrue.push(true);
        });
        // Retornar función verificadora
        if (inputsTrue.length == longitudInputs) {
            return true;
        } else return false;
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
        validarSelect(input, arrayElementos, campos, formulario, nameInput);
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
    } else if (Validar === "vacio") {
        check.classList.add("d-none");
        error.classList.add("d-none");
    }
}
