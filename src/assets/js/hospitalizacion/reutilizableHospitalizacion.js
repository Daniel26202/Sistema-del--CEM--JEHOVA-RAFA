//function genérica para ejecutar la petición ajax
const url = "/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion";
window.executePetition = async function (url, method, data = null) {
    try {
        const options = { method: method };

        if (data instanceof FormData) {
            options.body = data;
        } else if (data && typeof data === "object") {
            options.headers = {
                "Content-Type": "application/json",
            };
            options.body = JSON.stringify(data);
        }

        let response = await fetch(url, options);
        return response.json();
    } catch (error) {
        return error;
    }
};

let objServiciosBD = {};

// // reutilizableHospitalizacion.js
// export const traerSerevicio = async (direccionM) => { ... }

// // hospitalizacionEditar.js
// import { traerSerevicio } from './reutilizableHospitalizacion.js';
// await traerSerevicio("editar");

window.traerSerevicio = async function (direccionM) {
    let resultado = await executePetition(url + "/selectServiciosD", "GET");
    console.log(resultado);
    let text;
    let modal;
    if (direccionM === "agregar") {
        text = "A";
        modal = "#modal-agregar-hospitalizacion";
    } else if (direccionM === "editar") {
        text = "E";
        modal = "#modal-editar-hospitalizacion";
    }
    let btnCancelar = document.querySelector("#btnCancelar");
    let noHayServicio = document.querySelector("#noHayServicio");
    let noPAservicio = document.querySelector("#NoPAservicio" + text);
    let serviciosConten = document.querySelector("#div-servicios" + text);

    btnCancelar.setAttribute("data-bs-target", modal);
    // si no se trae nada
    if (resultado.length < 1) {
        console.log("hay un problema, el servicio seleccionado no existe");
        if (noHayServicio) {
            noHayServicio.classList.remove("d-none");
        }

        //si se trae algo
    } else {
        if (noHayServicio) {
            noHayServicio.classList.add("d-none");
        }
        let html = ``;

        for (const datoS of resultado) {
            objServiciosBD[datoS["id_servicioMedico"]] = datoS;
            html += `<div class="col-12 col-sm-6 col-md-4 col-lg-4 divServicio"
                                data-index="${datoS["id_servicioMedico"]}">
                                <a href="#" class="card text-center text-decoration-none h-100"
                                    data-bs-toggle="modal" data-bs-target="${modal}">
                                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                        <i class="bi bi-plus-circle mb-2 fs-3"></i>
                                        <p class="fw-bolder mb-1">${datoS["categoria"]}</p>
                                        <p class="mb-0 small">${datoS["nombre"] + " " + datoS["apellido"]}</p>
                                    </div>
                                </a>
                            </div>`;
        }

        console.log(objServiciosBD);

        document.querySelector("#servicios").innerHTML = html;
        let htmlL = ``;
        let divServicios = document.querySelectorAll(".divServicio");
        if (divServicios) {
            for (const div of divServicios) {
                div.addEventListener("click", function () {
                    let idS = parseInt(this.getAttribute("data-index"));
                    console.log(idS);

                    htmlL = `<div class="col-12 col-sm-6 col-md-6 col-lg-6 position-relative servicioA" data-index="${idS}">
                                    <!-- Botón eliminar -->
                                    <button type="button"
                                        class="position-absolute top-0 start-50 translate-middle-x mt-1 eliminarServ"
                                        data-index="${idS}"
                                        style="background:none; border:none; font-size:2rem; font-weight:bold; color:#0d6efd; cursor:pointer; z-index:10;">
                                        ×
                                    </button>

                                    <!-- Tarjeta -->
                                    <a href="#"
                                        class="card text-decoration-none h-100 shadow-sm border-0 rounded-4"
                                        style="background: #f4f9ff61; transition: all 0.2s ease;">

                                        <div class="card-body d-flex flex-column justify-content-center text-center mt-1 py-5 pb-4">
                                            <div class="fw-semibold text-dark mb-2 m-auto d-flex ">
                                                <p class="me-1 text-center cantidadServicio" style="font-size:1rem;">
                                                    1
                                                </p>
                                                <p class="" style="font-size:1rem;">
                                                    ${objServiciosBD[idS]["categoria"]}
                                                </p>
                                            </div>
                                            <p class="text-muted mb-1" style="font-size:0.9rem;">
                                                ${objServiciosBD[idS]["nombre"]} ${objServiciosBD[idS]["apellido"]}
                                            </p>
                                            <p class="fw-bold text-primary mb-0 precioS" style="font-size:0.95rem;">
                                                ${objServiciosBD[idS]["precio"]} Bs
                                            </p>
                                            <div>
                                                <input type="hidden" name="id_servicio[]" class="" value="${idS}">
                                                <input type="hidden" name="cantidadS[]" class="cantidadServicioInput" value="1">
                                            </div>                         
                                        </div>
                                    </a>
                                </div>`;

                    if (objServiciosBD[idS]["tipo"] == "Examenes") {
                        // buscar si el servicio ya está agregado en el contenedor
                        const servicioExistente = serviciosConten.querySelector(`.servicioA[data-index="${idS}"]`);

                        if (servicioExistente) {
                            // aumentar la cantidad Serv
                            const pCantidad = servicioExistente.querySelector(".cantidadServicio");
                            const inputCantidad = servicioExistente.querySelector(".cantidadServicioInput");
                            if (pCantidad) {
                                let newCantidad = parseInt(pCantidad.textContent.trim()) || 1;
                                newCantidad = newCantidad + 1;
                                pCantidad.textContent = newCantidad;
                                inputCantidad.value = newCantidad;
                                // Actualizar el precio
                                let precioS = newCantidad * objServiciosBD[idS]["precio"];
                                let pMoneyS = servicioExistente.querySelector(".precioS");
                                if (pMoneyS) {
                                    pMoneyS.textContent = precioS + " Bs";
                                }
                            }
                        } else {
                            // si no existe, agrega el servicio tipo examen
                            serviciosConten.innerHTML += htmlL;
                            document.querySelector("#btnAS" + text).classList.add("d-none");
                            document.querySelector("#btnAServiciosExiste" + text).classList.remove("d-none");
                        }
                    } else {
                        const servicioExistente = serviciosConten.querySelector(`.servicioA[data-index="${idS}"]`);

                        if (servicioExistente) {
                            noPAservicio.classList.remove("d-none");
                            setTimeout(() => {
                                noPAservicio.classList.add("d-none");
                            }, 8000);
                        } else {
                            serviciosConten.innerHTML += htmlL;
                            document.querySelector("#btnAS" + text).classList.add("d-none");
                            document.querySelector("#btnAServiciosExiste" + text).classList.remove("d-none");
                        }
                    }
                });
            }
        }
        if (serviciosConten) {
            serviciosConten.addEventListener("click", function (e) {
                console.log(e);

                const servicioElem = e.target.closest(".servicioA");
                servicioElem.remove();
            });
        }
    }
};

//objeto de las expresiones:
const expresiones = {
    historial: /^([a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,;:!?'-]{5,})$/,
    diagnostico: /^([a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,;:!?'-]{5,})$/,
    indicaciones: /^([a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,;:!?'-]{5,})$/,
    fechaRegreso: /^\d{4}\-\d{2}\-\d{2}$/,
};

window.campos = {
    sintomas: false,
    historial: false,
    diagnostico: false,
    indicaciones: false,
    fechaRegreso: false,
};

window.validarCamposControl = (expresiones, input, campo) => {
    if (expresiones.test(input.value)) {
        input.parentElement.classList.remove("grpFormInCorrectControl");
        input.parentElement.classList.add("grpFormCorrectControl");

        campos[campo] = true;
    } else {
        input.parentElement.classList.remove("grpFormCorrectControl");
        input.parentElement.classList.add("grpFormInCorrectControl");
        campos[campo] = false;
    }
};

//validar forumlario
window.validarFormularioControl = function (e) {
    switch (e.target.name) {
        case "sintomas[]":
            // recolecto los inputs
            let inputCheS = document.querySelectorAll(`.inpSin`);

            // Array.from es para convertir el html en array y el .some es para verificar(en una array) si cumple con la condición especifica; devolviendo true si es verdadero y false si es falso
            let seleccionadoS = Array.from(inputCheS).some((checkbox) => checkbox.checked);
            if (seleccionadoS) {
                campos["sintomas"] = true;
            } else {
                campos["sintomas"] = false;
            }
            break;

        case "diagnostico":
            console.log(e.target);
            
            validarCamposControl(expresiones.diagnostico, e.target, "diagnostico");

            break;

        case "indicaciones":
            validarCamposControl(expresiones.indicaciones, e.target, "indicaciones");

            break;
        case "fechaRegreso":
            // obtengo la hora de hoy.
            let hoy = new Date();
            // para que la hora minutos s mm este en cero, como no lo voy a usar
            hoy.setHours(0, 0, 0, 0);
            // tomo la fecha del input
            let fechaInput = document.querySelector(`.grp_control_fechaRegreso`).value;
            fechaInput = new Date(fechaInput);

            // obtengo la hora de hoy.
            let fechaMaxima = new Date();
            // actualizamos la fecha de hoy, sumándole la fecha(en este caso el año) de hoy más 50
            fechaMaxima.setFullYear(hoy.getFullYear() + 50);
            // para que la hora minutos s mm este en cero, como no lo voy a usar
            fechaMaxima.setHours(0, 0, 0, 0);

            if (
                expresiones.fechaRegreso.test(document.querySelector(`.grp_control_fechaRegreso`).value) &&
                fechaInput >= hoy &&
                fechaInput <= fechaMaxima
            ) {
                document.querySelector(`.grp_control_fechaRegreso`).style.borderBottom = "2px solid rgb(13, 240, 13)";
                document.querySelector("#leyendaFec").classList.add("d-none");

                campos["fechaRegreso"] = true;
            } else {
                document.querySelector(`.grp_control_fechaRegreso`).style.borderBottom = "2px solid rgb(224, 3, 3)";
                document.querySelector("#leyendaFec").classList.remove("d-none");

                campos["fechaRegreso"] = false;
            }
            break;
    }
};

//function for show and hidden alert the control
window.showAlert = (alert, text, classAlert) => {
    alert.classList.add(`${classAlert}`);
    alert.innerText = `${text}`;
    alert.classList.remove("d-none");
    setTimeout(() => {
        alert.classList.add("d-none");
    }, 7000);
};
