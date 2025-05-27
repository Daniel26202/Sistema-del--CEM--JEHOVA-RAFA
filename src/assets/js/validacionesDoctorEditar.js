addEventListener("DOMContentLoaded", function () {
    const mens = document.querySelectorAll(".msj");
    function sumaUnaH(horaEntrada) {
        // map(Number) es para transformar el string en numero, cuando le pertenece a un array
        let [hora, minutos] = horaEntrada.split(":").map(Number);
        hora = hora + 1;
        if (hora >= 24) hora = 0;
        // padStart : se asegura que la cadena tenga al menos 2 caracteres, si no los tiene agrega un 0 ejemplo : 9 a 09
        horaEntrada = `${hora.toString().padStart(2, "0")}:${minutos.toString().padStart(2, "0")}`;
        return horaEntrada;
    }
    const expresionesEditar = {
        cedula: /^([1-9]{1})([0-9]{5,7})$/,
        nombre: /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/,
        apellido: /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/,
        telefono: /^(0?)(412|414|416|424|426|212|24[1-9]|25[1-9])\d{7}$/,
        email: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
        usuario: /^[a-zA-Z0-9._-]{3,16}$/,
        password: /^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/,
        preguntaDeSeguridad: /^([A-Za-z0-12\s\.,#-]+)$/,
        respuestaDeSeguridad: /^([A-Za-z0-12\s\.,#-]+)$/,
    };
    const camposEditar = {
        cedula: true,
        nombre: true,
        apellido: true,
        telefono: true,
        email: true,
        dia: true,
        horas: true,
    };
    let horaEntrada = 0;
    let horaSalida = 0;
    function validarFormularioEditar(e) {
        console.log(e.target.name);
        switch (e.target.name) {
            case "cedula":
                validarCamposEditar(expresionesEditar.cedula, e.target, "cedula");
                break;

            case "nombre":
                validarCamposEditar(expresionesEditar.nombre, e.target, "nombre");

                break;
            case "apellido":
                validarCamposEditar(expresionesEditar.apellido, e.target, "apellido");

                break;

            case "telefono":
                validarCamposEditar(expresionesEditar.telefono, e.target, "telefono");

                break;
            case "email":
                validarCamposEditar(expresionesEditar.email, e.target, "email");

                break;
            case "dias[]":
                // recolecto los inputs
                let inputCheD = document.querySelectorAll(`.diasIn`);

                // Array.from es para convertir el html en array y el .some es para verificar(en una array) si cumple con la condición especifica; devolviendo true si es verdadero y false si es falso
                let seleccionadoD = Array.from(inputCheD).some((checkbox) => checkbox.checked);
                if (seleccionadoD) {
                    camposEditar["dia"] = true;
                } else {
                    camposEditar["dia"] = false;
                }
                break;
            case "horaEntrada[]":
                horaEntrada = e.target.value;

                break;
            case "horaSalida[]":
                horaSalida = e.target.value;

                break;
        }

        if (e.target.name == "horaEntrada[]" || e.target.name == "horaSalida[]") {
            // si deselecciona un dia
            // console.log(horaEntrada + " " + horaSalida);
            // console.log(e.target);
            if (horaEntrada === undefined && horaSalida === undefined) {
                camposEditar.horas = true;
            } else {
                if (e.target.name == "horaEntrada[]") {
                    // selecciono el input siguiente
                    horaSalida = e.target.nextElementSibling.value;
                    // console.log(horaSalida + " salida esperada");
                }
                if (e.target.name == "horaSalida[]") {
                    // selecciono el input siguiente
                    horaEntrada = e.target.previousElementSibling.value;
                    horaEntrada = sumaUnaH(horaEntrada);

                    // console.log(horaEntrada + " entrada esperada");
                }

                if (e.target.name === "horaEntrada[]") {
                    horaEntrada = sumaUnaH(horaEntrada);
                    console.log(horaEntrada);
                }
                console.log(horaEntrada);

                if (horaEntrada < horaSalida) {
                    camposEditar.horas = true;
                } else {
                    camposEditar.horas = false;
                }
            }
        }
    }

    const validarCamposEditar = (expresiones, input, campo) => {
        if (expresiones.test(input.value)) {
            input.parentElement.classList.remove("grpFormInCorrect");
            input.parentElement.classList.add("grpFormCorrect");
            camposEditar[campo] = true;
        } else {
            input.parentElement.classList.remove("grpFormCorrect");
            input.parentElement.classList.add("grpFormInCorrect");
            camposEditar[campo] = false;
        }
    };

    document.querySelectorAll(".editar").forEach((ele) => {
        ele.addEventListener("click", function () {
            let idModal = ele.getAttribute("uk-toggle").split(" ")[1].substring(1);

            document.querySelectorAll(`#${idModal} .input`).forEach((eleEditar) => {
                eleEditar.addEventListener("input", validarFormularioEditar);
            });

            document.querySelector(`#${idModal} .uk-modal-dialog .formulario_editar`).addEventListener("submit", (e) => {
                e.preventDefault();

                if (
                    camposEditar.cedula &&
                    camposEditar.nombre &&
                    camposEditar.horas &&
                    camposEditar.dia &&
                    camposEditar.apellido &&
                    camposEditar.telefono &&
                    camposEditar.email
                ) {
                    document.querySelector(`#${idModal} .uk-modal-dialog .formulario_editar`).submit();
                    mens.forEach((msj) => {
                        msj.classList.add("d-none");
                    });
                } else {
                    e.preventDefault();
                    mens.forEach((msj) => {
                        msj.classList.remove("d-none");
                    });

                    if (camposEditar.dia) {
                        document.querySelectorAll(".leyendaDiaE").forEach((msj) => {
                            msj.classList.add("d-none");
                        });
                    } else {
                        document.querySelectorAll(".leyendaDiaE").forEach((msj) => {
                            msj.classList.remove("d-none");
                        });
                    }
                    alert("Los datos del formulario son incorrectos");

                    //   document.getElementById('alerta-guardar').classList.remove('d-none')
                    //    setTimeout(function() {
                    //          document.getElementById('alerta-guardar').classList.add('');
                    //    }, 10000);
                }
            });
        });
    });
});
