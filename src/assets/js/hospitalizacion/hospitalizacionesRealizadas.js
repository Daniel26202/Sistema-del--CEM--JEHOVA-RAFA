addEventListener("DOMContentLoaded", function () {
    ////////////////////////////////////////////////////////////////////
    // hospitalizaciones realizadas//
    // Ajax //

    // mostrar datos en la tabla de hospitalizaciones realizadas
    const vistaTablaR = async () => {
        // llamo la función
        let resultad = await executePetition(url + "/traerSesionR", "GET");

        if (resultad.length == 0) {
            console.log("algo salio mal");
        } else {
            if (resultad[1] == false) {
                html = `<tr>
                                <td colspan="8" class="text-center">NO HAY REGISTROS
                                </td>
                            </tr>`;
                document.querySelector("#tbodyR").innerHTML = html;
            } else {
                let html = ``;
                // recorro los datos de hospitalización
                resultad[1].forEach((res) => {
                    // contenido de la tabla.
                    html += `<tr>
                                    <td>
                                        ${res["cedula"]}
                                    </td>
                                    <td>
                                        ${res["nombre"]}
                                    </td>
                                    <td>
                                        ${res["apellido"]}
                                    </td>
                                    <td>
                                        ${res["diagnostico"]}
                                    </td>
                                    <td>
                                        ${res["nombredoc"]} ${res["apellidodoc"]}
                                    </td>`;

                    // verifico si es administrador o usuario
                    // uno es doctor
                    if (resultad[0] == 1) {
                        html += `<!--no hay-->`;
                    }
                    // verifico si es administrador o usuario
                    // cero es administrador mas no doctor
                    if (resultad[0] == 0) {
                        html += `<td>
                                        ${res["total"]} bs
                                    </td>`;
                    }
                });

                document.querySelector("#tbodyR").innerHTML = html;
            }
        }

    };
    vistaTablaR();

    let inputBuscHR = document.querySelector("#inputBuscHR");
    const notifi = document.querySelector("#notificacionR");

    // buscador de hospitalización
    function buscarH() {
        let contadorH = 0;
        let contadorHNo = 0;

        // selecciono todos los tr de la tabla
        const filas = document.querySelectorAll("#tbodyR tr");
        // recolecto la cédula del input
        let cdH = inputBuscHR.value;
        // recorro las filas de la tabla
        filas.forEach((fila) => {
            // cuenta las hospitalizaciones que existen.
            contadorH = contadorH + 1;

            // verifico si la cédula existe
            if (fila.children[0].innerText.includes(cdH)) {
                console.log("si existe");
                fila.classList.remove("d-none");
                notifi.classList.add("d-none");
            } else {
                console.log("no existe");
                fila.classList.add("d-none");
                // cuenta las veces que no encuentra una hospitalización
                contadorHNo = contadorHNo + 1;
            }
        });

        // verifica, si el contador de hospitalizaciones existentes es igual a las hospitalizaciones no existentes
        if (contadorH === contadorHNo) {
            // muestra el texto.
            notifi.classList.remove("d-none");
        }
    }

    // al presionar click realiza la función
    document.querySelector("#btnBuscHR").addEventListener("click", function () {
        buscarH();
    });
});
