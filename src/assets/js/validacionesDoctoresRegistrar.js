document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("modalAgregarDoctores");
    const inputs = document.querySelectorAll("#modalAgregarDoctores .inputA");

    const expresiones = {
        cedula: /^([1-9]{1})([0-9]{5,7})$/,
        nombre: /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/,
        apellido: /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/,
        telefono: /^(0?)(412|414|416|424|426|212|24[1-9]|25[1-9])\d{7}$/,
        email: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
        usuario: /^[a-zA-Z0-9._-]{3,16}$/,
        password: /^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/,
    };
    const campos = {
        cedula: false,
        nombre: false,
        apellido: false,
        telefono: false,
        usuario: false,
        password: false,
        dia: false,
        horas: false,
    };
    let mens = document.querySelector("#leyendaHoraA");
    let horaEntrada;
    let horaSalida;
    function validarFormulario(e) {
        console.log(e.target.name);

        switch (e.target.name) {
            case "cedula":
                validarCampos(expresiones.cedula, e.target, "cedula");
                break;

            case "nombre":
                validarCampos(expresiones.nombre, e.target, "nombre");

                break;
            case "apellido":
                validarCampos(expresiones.apellido, e.target, "apellido");

                break;

            case "telefono":
                validarCampos(expresiones.telefono, e.target, "telefono");

                break;
            case "email":
                validarCampos(expresiones.email, e.target, "email");

                break;
            case "usuario":
                validarCampos(expresiones.usuario, e.target, "usuario");
                break;
            case "password":
                validarCampos(expresiones.password, e.target, "password");
                break;

            case "dias[]":
                // recolecto los inputs
                let inputCheD = document.querySelectorAll(`.diasInA`);

                // Array.from es para convertir el html en array y el .some es para verificar(en una array) si cumple con la condición especifica; devolviendo true si es verdadero y false si es falso
                let seleccionadoD = Array.from(inputCheD).some((checkbox) => checkbox.checked);
                if (seleccionadoD) {
                    campos["dia"] = true;
                } else {
                    campos["dia"] = false;
                }

                break;
            case "horaEntrada[]":
                horaEntrada = e.target.value;
                console.log(e.target.value);

                break;
            case "horaSalida[]":
                horaSalida = e.target.value;
                // console.log(horaSalida);

                break;
        }

        // si deselecciona un dia
        if (horaEntrada === undefined && horaSalida === undefined) {
            mens.classList.add("d-none");
            campos.horas = true;
        } else {
            if (e.target.name === "horaEntrada[]") {
                // map(Number) es para transformar el string en numero, cuando le pertenece a un array
                let [hora, minutos] = horaEntrada.split(":").map(Number);
                hora = hora + 1;
                if (hora >= 24) hora = 0;
                // padStart : se asegura que la cadena tenga al menos 2 caracteres, si no los tiene agrega un 0 ejemplo : 9 a 09
                horaEntrada = `${hora.toString().padStart(2, "0")}:${minutos.toString().padStart(2, "0")}`;
            }

            if (horaEntrada < horaSalida) {
                mens.classList.add("d-none");
                campos.horas = true;
            } else {
                campos.horas = false;
                mens.classList.remove("d-none");
            }
        }
    }

    const validarCampos = (expresiones, input, campo) => {
        if (expresiones.test(input.value)) {
            input.parentElement.classList.remove("grpFormInCorrect");
            input.parentElement.classList.add("grpFormCorrect");
            campos[campo] = true;
        } else {
            input.parentElement.classList.remove("grpFormCorrect");
            input.parentElement.classList.add("grpFormInCorrect");
            campos[campo] = false;
        }
    };

    inputs.forEach((input) => {
        input.addEventListener("input", validarFormulario);
    });

    let alerta = document.getElementById("alerta");
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        if (
            campos.cedula &&
            campos.nombre &&
            campos.horas &&
            campos.dia &&
            campos.apellido &&
            campos.telefono &&
            campos.usuario &&
            campos.password &&
            campos.email
        ) {
            form.submit();
        } else {
            e.preventDefault();

            document.getElementById("alerta-guardar").classList.remove("d-none");
            if (campos.dia) {
                document.querySelector("#leyendaDia").classList.add("d-none");
            } else {
                document.querySelector("#leyendaDia").classList.remove("d-none");
            }
        }
    });

    //Funcion para eliminar los mensajes, ya sea de registrar, eliminar o modificar

    if (document.getElementById("alerta-registrar")) {
        setTimeout(function () {
            document.getElementById("alerta-registrar").remove();
        }, 10000);
    }

    if (document.getElementById("alerta-eliminar")) {
        setTimeout(function () {
            document.getElementById("alerta-eliminar").remove();
        }, 10000);
    }

    if (document.getElementById("alerta-editar")) {
        setTimeout(function () {
            document.getElementById("alerta-editar").remove();
        }, 10000);
    }
});
