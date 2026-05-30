import {
    executePetition,
    alertConfirm,
    alertError,
    alertInfo,
    alertSuccess,
    initDataTable,
    cargarImg,
    showDataModal,
    hasPermision,
    initLoaderButton,
    finallyLoaderButton,
    clearModalEnviar
} from "../generic/funtionGeneric.js";

import { inicializarValidacionFormulario } from "../generic/expresionesModulares.js";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/Doctores";

let dataDoctor;

const modalGestionarEspecialidad = new bootstrap.Modal(
  document.getElementById("exampleModalConsultarEspecialidad"),
);
const modaAgregarEspecialidad = new bootstrap.Modal(
  document.getElementById("exampleModalAgregarEspecialidad"),
);

const openBtnModalEspecialidad = document.getElementById(
  "openBtnModalEspecialidad",
);

const exampleModalEspecialidad = document.getElementById(
  "exampleModalLabelEspec",
);
const btnModalEspecialidad = document.getElementById("btnModalEspecialidad");
const formDoctor = document.getElementById("modalAgregarDoctores");
const imagenDoctor = document.getElementById("imagenDoctor");
const contenedorImg = document.getElementById("contenedor-img");
const contenedorImgEditar = document.getElementById("contenedor-img-editar");
const cedulaRegistrada = document.getElementById("cedulaRegistrada");
const id_doctor = document.getElementById("id_doctor");
const inputs = formDoctor.querySelectorAll(".campo-editar");

const labelModal = document.getElementById("exampleModalLabelDoctores");
const btnModal = document.getElementById("botonModal");
const formEspecialidad = document.getElementById("formEspecialidad");

const selectDoctor = document.querySelector("#select-doctor");
const selectService = document.querySelector("#select-servicio");
const formAsignarServicio = document.getElementById("formAsignarServicio");
const modalAsignarServicio = new bootstrap.Modal(document.getElementById("modal-designar-servicio"));
const modalADoctor = new bootstrap.Modal(document.getElementById("exampleModalagregarDocotor"));

const divHorarios = document.getElementById("div-horarios");
const cajaDeInfo = document.getElementById("cajaDeInfo");
const pServicios = document.getElementById("p-servicios");
const btnagregarDoctor = document.getElementById("btnagregarDoctor");
const id_rol_global = document.getElementById("id_rol_global").value;
const inputsEspecialidad = formEspecialidad.querySelectorAll(".campo-editar");

const urlActual = window.location.href;

//funcion para mostrar mas informacion del doctor
const info = (id_personal) => {
    let data = [];
    let htmlHorario = "";
    let textServicios = "";

    for (const item of dataDoctor) {
        const serivicios = item.servicios.find((s) => s.id_personal == id_personal);
        if (serivicios) {
            data.push({ ...item });
        }
    }

    if (data.length > 0) {
        for (const item of data[0].datosHorarios) {
            htmlHorario = `
    <!-- Nombre -->
                <div class="info-group mb-3">
                    <p class="fw-bold mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-capsule azul mb-1 me-1" viewBox="0 0 16 16">
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-2.6 5.854a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z" />
                        </svg>
                        Dia:
                        <span class="parrafo ms-4 h6">${item.diaslaborables}</span>

                    </p>

                    <p class="fw-bold mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-capsule azul mb-1 me-1" viewBox="0 0 16 16">
                            <path d="M6 .5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1H9v1.07a7.001 7.001 0 0 1 3.274 12.474l.601.602a.5.5 0 0 1-.707.708l-.746-.746A6.97 6.97 0 0 1 8 16a6.97 6.97 0 0 1-3.422-.892l-.746.746a.5.5 0 0 1-.707-.708l.602-.602A7.001 7.001 0 0 1 7 2.07V1h-.5A.5.5 0 0 1 6 .5zm2.5 5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5zM.86 5.387A2.5 2.5 0 1 1 4.387 1.86 8.035 8.035 0 0 0 .86 5.387zM11.613 1.86a2.5 2.5 0 1 1 3.527 3.527 8.035 8.035 0 0 0-3.527-3.527z" />
                        </svg>
                        Horario:
                        <span class="parrafo ms-4 h6">${item.horaDeEntrada} a ${item.horaDeSalida}</span>

                    </p>
                </div>
    `;
        }

        for (const item of data[0].servicios) {
            textServicios += item.nombre + " ,  ";
        }
    } else {
        htmlHorario = '<h5 class="text-center">El doctor no tiene un horario disponible</h5>';
        pServicios = "De momento el doctor no ofrece ningun servicio";
    }
    cajaDeInfo.innerHTML = htmlHorario;
    pServicios.innerText = textServicios;
};

//funcion para mostrar los dias de la semana
const mostrarDiasSemana = async () => {
    try {
        const result = await executePetition("/Sistema-del--CEM--JEHOVA-RAFA/Doctores/mostrarDiasSemana", "GET");
        let html = "";
        if (result.length > 0) {
            result.forEach((element) => {
                html += ` <div class="col-md-6 mb-3" >
    <div class="card card-schedule p-3 h-100 shadow-sm border-0" style="background-color: var(--color-bg-card); border: 1px solid var(--color-primary);">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="fw-bold text-dark">${element.diaslaborables}</span>
            <div class="form-check form-switch p-0 m-0">
                <input class="form-check-input day-toggle m-0" name="dias[]" value=${element.id_horario} type="checkbox"  style="width: 2.4em; height: 1.2em; cursor:pointer;">
            </div>
        </div>

        <div class="time-container mt-3">
            <div class="row g-2">
                <div class="col-6">
                    <label class="text-muted fw-bold mb-1" style="font-size: 10px; letter-spacing: 0.5px;">ENTRADA</label>
                    <input type="time" class="form-control form-control-sm border-0 bg-light py-2 px-1" 
                           style="font-size: 0.8rem; min-height: auto;" value="">
                </div>
                <div class="col-6">
                    <label class="text-muted fw-bold mb-1" style="font-size: 10px; letter-spacing: 0.5px;">SALIDA</label>
                    <input type="time" class="form-control form-control-sm border-0 bg-light py-2 px-1" 
                           style="font-size: 0.8rem; min-height: auto;" value="">
                </div>
            </div>
        </div>

        <div class="rest-badge mt-2 text-center py-2 rounded-3 bg-light text-muted small" style="display: none;">
            <i class="bi bi-moon-stars me-1"></i> Día de descanso
        </div>
    </div>
</div>`;
            });
        } else {
            html = `<div class="col-12">
        <div class="alert alert-warning text-center">
          No hay días laborables registrados.
        </div>
      </div>`;
        }
        divHorarios.innerHTML = html;
    } catch (error) {
        alertError("Error", error);
        console.log(error);
    }
};

//read
const readDoctor = async () => {
    try {
        let metodo = "";

        if (!urlActual.includes("papelera")) metodo = "DoctoresAjax";
        else metodo = "papeleraDoctoresAjax";

        const result = await executePetition(url + "/" + metodo, "GET");
        dataDoctor = result;

        // construir html de filas
        let html = "";
        let html2 = "";

        let id_usuario = 0;
        console.log("readDoctor");
        console.log(dataDoctor);

        if (!urlActual.includes("papelera")) {
            console.log(result);

            dataDoctor.forEach((element) => {
                html += ` <tr>
                            <td class=" ">
                                ${element.nacionalidad}-${element.cedula}
                            </td>
                            <td class="">
                                ${element.nombre_d}
                            </td>
                            <td class="">
                                ${element.apellido}
                            </td>
                            <td class="">
                                ${element.telefono}
                            </td>
                            <td class="" colspan="2">
                                ${element.correo}
                            </td>
                            <td class="">
                                ${element.nombre}
                            </td>


                            <td class="text-center">
                                <!-- editar -->

                                    <button class="btn btn-tabla mb-1 btn-js editar botonesEdi btn-dt-tabla"
                                       data-bs-toggle="modal" data-bs-target="#exampleModalagregarDocotor"
                                        data-especialidad=${element.id_especialidad} data-index-usuario=${element.id_usuario} data-index="${element.id_personal}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                        </svg>

                                    </button>


                                    <button class="btn btn-tabla mb-1 btn-dt-tabla btnRestablecer ${!urlActual.includes("paplera") ? "d-none" : ""
                    }" data-index=${element.id_usuario}>


                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>
                                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                                        </svg>


                                    </button>

                                    <button class="btn btn-tabla mb-1 btn-dt-tabla btn-eliminar ${urlActual.includes("papelera") ? "d-none" : ""
                    }" data-index=${element.id_usuario}>

                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                        </svg>

                                    </button>

                             
                                <button class="btn btn-tabla mb-1 botonesInfo btn-dt-tabla" title="Horarios Del Doctor"
                                    data-bs-toggle="modal" data-bs-target="#exampleModalInfoDoctor"
                                    data-index="${element.id_personal}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                    </svg>
                                </button>
                            </td>
                            
                            <td>


                            </td>
                        </tr>

        
                        `;
            });
        } else {
            result.forEach((element) => {
                html += ` <tr>
                            <td class=" ">
                                ${element.nacionalidad}-${element.cedula}
                            </td>
                            <td class="">
                                ${element.nombre_d}
                            </td>
                            <td class="">
                                ${element.apellido}
                            </td>
                            <td class="">
                                ${element.telefono}
                            </td>
                            <td class="" colspan="2">
                                ${element.correo}
                            </td>
                            <td class="">
                                ${element.nombre}
                            </td>


                            <td class="text-center">
                                <!-- editar -->

                                    <button class="btn btn-tabla mb-1 btn-js editar botonesEdi btn-dt-tabla ${!urlActual.includes("paplera") ? "d-none" : ""
                    }"
                                        uk-toggle="target: #modal-editar-doctores${element.id_usuario
                    }" data-id-tabla="modal-editar-doctoresmodal-editar-doctores${element.id_usuario}"
                                        id="btneditarDoctor" data-index="${element.id_personal}>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                        </svg>

                                    </button>


                                    <button class="btn btn-tabla mb-1 btn-dt-tabla btnRestablecer ${urlActual.includes("paplera") ? "d-none" : ""
                    }" data-index=${element.id_usuario}>


                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>
                                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                                        </svg>


                                    </button>

                                    <button class="btn btn-tabla mb-1 btn-dt-tabla btn-eliminar ${urlActual.includes("papelera") ? "d-none" : ""
                    }" data-index=${element.id_usuario}>

                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                        </svg>

                                    </button>

                             
                                <button class="btn btn-tabla mb-1 botonesInfo btn-dt-tabla ${!urlActual.includes("paplera") ? "d-none" : ""
                    }" title="Horarios Del Doctor"
                                    uk-toggle="target: #modal-info-doctores" data-id-tabla="modal-info-doctores${element.id_usuario
                    }"
                                    data-index="${element.id_usuario}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                    </svg>
                                </button>
                            </td>
                            <td></td>
                            
                        </tr>

        
                        `;
            });
        }

        const selector = ".exampleTable";

        // si ya existe DataTable, destrúyela
        if ($.fn.DataTable.isDataTable(selector)) {
            $(selector).DataTable().clear().destroy();
        }

        // vuelca el html en el tbody
        document.querySelector(selector + " tbody").innerHTML = html;

        document.querySelectorAll(".id_usuario_bitacora").forEach((ele) => {
            ele.value = document.getElementById("id_usuario_session").value;
            console.log(ele.value);
        });

        //llamar las funcion de eliminar
        if (document.querySelectorAll(".btn-eliminar")) {
            document.querySelectorAll(".btn-eliminar").forEach((btn) => {
                btn.addEventListener("click", function () {
                    const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];
                    alertConfirm("Esta seguro de eliminar el doctor?", deleteDoctor, data);
                });
            });
        }

        if (document.querySelectorAll(".btnRestablecer")) {
            document.querySelectorAll(".btnRestablecer").forEach((btn) => {
                btn.addEventListener("click", function () {
                    console.log(btn);

                    const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];
                    alertConfirm("Esta seguro de restablecer el doctor?", restablecerDoctor, data);
                });
            });
        }

        ///informacion del doctro
        document.querySelectorAll(".botonesInfo").forEach((btn) => {
            btn.addEventListener("click", function () {
                info(this.getAttribute("data-index"));
            });
        });

        let srcImg = "";

        //llamar a la uncion de editar
        document.querySelectorAll(".botonesEdi").forEach((btn) => {
            btn.addEventListener("click", function () {
                let tr = btn.closest("tr");
                inputs[1].value = parseInt(tr.children[0].innerText.slice(2));
                inputs[2].value = tr.children[1].innerText;
                inputs[3].value = tr.children[2].innerText;
                inputs[4].value = tr.children[3].innerText;
                inputs[5].value = tr.children[4].innerText;
                inputs[6].value = btn.getAttribute("data-especialidad");

                cedulaRegistrada.value = parseInt(tr.children[0].innerText.slice(2));
                id_doctor.value = btn.getAttribute("data-index-usuario");

                formDoctor.querySelectorAll(".input-validar").forEach((inp) => {
                    let divParent = inp.closest(".campo-custom");
                    // se activa la validacion con todos excepto con el inputt de la imagen

                    if (!inp.classList.contains("campo-editar")) {
                        divParent.classList.add("d-none");

                        //le coloco d-none a los label tambien
                        divParent.previousElementSibling.classList.add("d-none");
                        inp.parentElement.classList.add("valido");
                    } else {
                        if (inp.getAttribute("type") == "file") {
                            inp.parentElement.classList.add("valido");
                            // divParent.classList.add("valido");
                        } else {
                            inp.dispatchEvent(new Event("keyup", { bubbles: true }));
                        }
                    }
                });

                contenedorImg.classList.add("d-none");
                //ahora gestionar la imagen del insumo es decir mostrar un previsualizacion en el modal de editar
                contenedorImgEditar.classList.remove("d-none");
                imgEditar.setAttribute("src", `../src/assets/images/img_ingresadas_por_usuarios/insumos/${srcImg}`);

                let id_personal = parseInt(btn.getAttribute("data-index"));

                let coincidencias = dataDoctor.filter((doc) => doc.id_personal == id_personal);

                // Crear un conjunto para almacenar todos los id_horario únicos
                const idHorariosSet = new Set();

                // Recorrer cada objeto en data y agregar sus id_horario al conjunto
                coincidencias.forEach((item) => {
                    item.datosHorarios.forEach((item2) => {
                        idHorariosSet.add(item2.id_horario);
                    });
                });

                // Convertir el conjunto a un array para facilitar la comparación
                const idHorarios = Array.from(idHorariosSet);

                // Iterar sobre cada checkbox

                formDoctor.querySelectorAll(".day-toggle").forEach((checkbox) => {
                    const timeContainer = checkbox.querySelector(".time-container");
                    const restBadge = checkbox.querySelector(".rest-badge");

                    checkbox.setAttribute("name", "dias[]");

                    // Comprobar si el value del checkbox está incluido en id_horarios
                    const card = checkbox.closest(".card-schedule");
                    const inputEntrada = card.querySelectorAll('input[type="time"]')[0];
                    const inputSalida = card.querySelectorAll('input[type="time"]')[1];
                    if (idHorarios.includes(Number(checkbox.value))) {
                        checkbox.checked = true; // Marcar el checkbox
                        checkbox.setAttribute("name", "diaAnterio[]");

                        const dataHorario = buscarcarHorarioPorId(
                            dataDoctor,
                            checkbox.value,
                            btn.getAttribute("data-index"),
                        ).datosHorarios;

                        inputEntrada.setAttribute("name", "horaEntrada[]");
                        inputSalida.setAttribute("name", "horaSalida[]");

                        console.log(dataHorario[0].horaDeEntrada);
                        inputEntrada.value = dataHorario[0].horaDeEntrada;
                        inputSalida.value = dataHorario[0].horaDeSalida;
                    } else {
                        checkbox.checked = false; // Desmarcar el checkbox
                        inputEntrada.setAttribute("name", "");
                        inputSalida.setAttribute("name", "");
                    }
                });

                labelModal.innerText = "Modificar Doctor";
                btnModal.innerText = "Modificar";
                contenedorImgEditar.classList.add("d-none");
            });

            formDoctor.classList.add("editar");
        });

        //////gestionar persmisos
        hasPermision(id_rol_global, "Doctores", "guardar", ".btnOpenModal"); //guardar doctor
        hasPermision(id_rol_global, "Doctores", "guardar", ".btnOpenModalSer"); //guardar servicio
        hasPermision(id_rol_global, "Doctores", "guardar", ".btnOpenModalEsp"); //guardar especialidad

        hasPermision(id_rol_global, "Doctores", "eliminar", ".btn-eliminar"); //eliminar
        hasPermision(id_rol_global, "Doctores", "eliminar", ".btnRestablecer"); //restablecer
        hasPermision(id_rol_global, "Doctores", "editar", ".botonesEdi"); //editar

        // re-inicializa
        initDataTable(selector);

        console.log("cargada...");
    } catch (error) {
        alertError("Error", error);
        console.log(error);
    }
};

//funcion par abuscar horarios especiicos por id\
const buscarcarHorarioPorId = (list, id_horario, id_personal) => {
    for (const item of list) {
        const horario = item.datosHorarios.find((h) => h.id_horario == id_horario && h.id_personal == id_personal);
        if (horario) {
            return { ...item };
        }
    }
    return null;
};

//read
const readEspecialidad = async () => {
    try {
        const result = await executePetition("/Sistema-del--CEM--JEHOVA-RAFA/Doctores/selectEspcAjax", "GET");

        // construir html de filas
        let html = "";

        result.forEach((element, index) => {
            html += ` 
       <tr>
                <td class="text-center fw-bold">
                 ${index + 1}
                </td>

                <td class="text-center border-start">
                  ${element.nombre}
                </td>


                <td class="border-start text-center">
                  <button class="btn btn-tabla mb-1 btn-dt-tabla btn-eliminar-epe" data-index="${element.id_especialidad}" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-trash3-fill" viewBox="0 0 16 16">
                      <path
                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                    </svg>
                  </button>

                  
  

                </td>
              </tr>
      
        
                        `;
        });

        const selector = ".exampleTable2";

        // si ya existe DataTable, destrúyela
        if ($.fn.DataTable.isDataTable(selector)) {
            $(selector).DataTable().clear().destroy();
        }

        // vuelca el html en el tbody
        if (!urlActual.includes("papelera")) {
            document.querySelector(selector + " tbody").innerHTML = html;
        }

        //llamar las funcion de eliminar
        document.querySelectorAll(".btn-eliminar-epe").forEach((btn) => {
            console.log(btn);
            btn.addEventListener("click", function () {
                const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];
                alertConfirm("Esta seguro de eliminar la especialidad?", deleteEspecialidad, data);
            });
        });

        // re-inicializa
        initDataTable(selector);
        console.log("cargada...");
    } catch (error) {
        alertError("Error", error);
    }
};

//create
const createDoctor = async (form) => {
    try {
        initLoaderButton(btnModal)
        const data = new FormData(form);
        let result = await executePetition(url + "/agregarDoctor", "POST", data);
        if (result.ok) {
            alertSuccess(result.message);
            modalADoctor.hide();
            readDoctor();
        } else throw new Error(`${result.error}`);
    } catch (error) {
        alertError("Error", error);
    } finally {
        finallyLoaderButton(btnModal)
    }
};

//delete
const deleteDoctor = async (data) => {
    try {
        const result = await executePetition(url + `/borrarDoctor/${data}`, "GET");
        if (result.ok) {
            alertSuccess(result.message);
            readDoctor();
        } else throw new Error(`${result.error}`);
    } catch (error) {
        alertError("Error", error);
    }
};

//update
const updateDoctor = async (form) => {
    try {
        initLoaderButton(btnModal)
        const data = new FormData(form);
        let result = await executePetition(url + "/editarDoctor", "POST", data);
        console.log(result);
        if (result.ok) {
            alertSuccess(result.message);
            modalADoctor.hide();
            readDoctor();
        } else throw new Error(`${result.error}`);
    } catch (error) {
        console.log(error);
        alertError("Error", error);
    } finally {
        finallyLoaderButton(btnModal)
    }
};

//delete
const deleteEspecialidad = async (data) => {
    try {
        const result = await executePetition(`/Sistema-del--CEM--JEHOVA-RAFA/Doctores/eliminarEspecialidad/${data}`, "GET");
        if (result.ok) {
            alertSuccess(result.message);
            readEspecialidad();
        } else throw new Error(`${result.error}`);
    } catch (error) {
        alertError("Error", error);
    }
};

//create especialida
const createEspecialidad = async (form) => {
    try {
        const data = new FormData(form);
        let result = await executePetition(url + "/registrarEspecialidad", "POST", data);
        console.log(result);
        if (result.ok) {
            alertSuccess(result.message);
            modaAgregarEspecialidad.hide();
            modalGestionarEspecialidad.show();
            readEspecialidad();
        } else throw new Error(`${result.error}`);
    } catch (error) {
        alertError("Error", error);
    }
};

//restablecer
const restablecerDoctor = async (data) => {
    try {
        const result = await executePetition(url + `/restablecer/${data}`, "GET");
        if (result.ok) {
            alertSuccess(result.message);

            readDoctor();
        } else throw new Error(`${result.error}`);
    } catch (error) {
        alertError("Error", error);
    }
};

//asignar servicio
const asignarServicio = async (form) => {
    try {
        const data = new FormData(form);
        let result = await executePetition(url + "/guardarDoctores", "POST", data);
        console.log(result);
        if (result.ok) {
            alertSuccess(result.message);
            modalAsignarServicio.hide();
            readDoctor();
        } else throw new Error(`${result.error}`);
    } catch (error) {
        alertError("Error", error);
    }
};

//funcion para llenar los selects de doctor y servicio
const traerServicioAndDoctor = async () => {
    try {
        const result = await executePetition(`${url}/serviciosDoctor`, "GET");
        console.log(result);

        let htmlDoc = `<option class="option-select-background" selected="" value="">Seleccionar Doctor</option>`;
        let htmlSer = `<option class="option-select-background" selected="" value="">Seleccionar Servicio  Medico</option>`;

        //doctores
        for (const res of result[0]) {
            console.log(res);
            htmlDoc += `<option class="option-select-background" name="id_doctor" value="${res.id_personal}">Dr: ${res.nombre_d} ${res.apellido}</option>`;
        }

        //servicio
        for (const res of result[1]) {
            console.log(res);
            htmlSer += `<option class="option-select-background" name='id_categoria' value="${res.id_categoria}">${res.nombre}</option>`;
        }

        selectDoctor.innerHTML = htmlDoc;
        selectService.innerHTML = htmlSer;
    } catch (error) {
        console.log(error);
    }
};

traerServicioAndDoctor();
readDoctor();

readEspecialidad();


openBtnModalEspecialidad.addEventListener("click", function () {
  //objetos con todos los parametros de la funcion
  const parametros = {
    labelModal: exampleModalEspecialidad,
    textLabelModal: "Registrar Patologia",
    form: formEspecialidad,
    modal: formEspecialidad.parentElement.parentElement.parentElement,
    btnModal: btnModalEspecialidad,
    btnTextModal: "Registrar",
    inputs: inputsEspecialidad,
  };
  clearModalEnviar(parametros);
});

// Variable externa para contar cuántos días están activos
let diasActivosContador = 0;

mostrarDiasSemana();

divHorarios.addEventListener("change", async (e) => {
    if (e.target.classList.contains("day-toggle")) {
        const checkbox = e.target;
        const card = checkbox.closest(".card-schedule");
        const timeContainer = card.querySelector(".time-container");
        const restBadge = card.querySelector(".rest-badge");
        const inputEntrada = card.querySelectorAll('input[type="time"]')[0];
        const inputSalida = card.querySelectorAll('input[type="time"]')[1];

        // 1. LÓGICA VISUAL
        if (checkbox.checked) {
            timeContainer.style.display = "block";
            restBadge.style.display = "none";
            card.style.opacity = "1";
            inputEntrada.setAttribute("name", "horaEntrada[]");
            inputSalida.setAttribute("name", "horaSalida[]");
        } else {
            timeContainer.style.display = "none";
            restBadge.style.display = "block";
            card.style.opacity = "0.8";
            inputEntrada.setAttribute("name", "");
            inputSalida.setAttribute("name", "");
        }

        // 2. VALIDACIÓN: AL MENOS UN DÍA ACTIVO
        diasActivosContador = divHorarios.querySelectorAll(".day-toggle:checked").length;
        if (diasActivosContador === 0) {
            alert("¡Error! Debe haber al menos un día de trabajo seleccionado.");
            checkbox.checked = true;
            timeContainer.style.display = "block";
            restBadge.style.display = "none";
            card.style.opacity = "1";
            return;
        }

        // 3. VALIDACIÓN DE HORAS (Solo si el día está activo)
        if (checkbox.checked) {
            validarBloquesCompletos(card);
        }
    }
});

// Escuchar cuando cambian las horas manualmente
divHorarios.addEventListener("change", (e) => {
    if (e.target.type === "time") {
        const card = e.target.closest(".card-schedule");
        validarBloquesCompletos(card);
    }
});

function validarBloquesCompletos(card) {
    const inputEntrada = card.querySelectorAll('input[type="time"]')[0];
    const inputSalida = card.querySelectorAll('input[type="time"]')[1];

    // Extraemos hora y minutos por separado
    let [hEntrada, mEntrada] = inputEntrada.value.split(":").map(Number);
    let [hSalida, mSalida] = inputSalida.value.split(":").map(Number);

    // REGLA 1: Forzar minutos a 00 (No permitir 14:30, 14:15, etc.)
    if (mEntrada !== 0 || mSalida !== 0) {
        alertError("Error", "Los turnos deben ser en horas exactas (ejemplo: 14:00). Se han ajustado los minutos.");
        inputEntrada.value = `${String(hEntrada).padStart(2, "0")}:00`;
        inputSalida.value = `${String(hSalida).padStart(2, "0")}:00`;
        // Actualizamos las variables locales después del ajuste
        mEntrada = 0;
        mSalida = 0;
    }

    // REGLA 2: Diferencia mínima de 1 hora
    const diferencia = hSalida - hEntrada;

    if (diferencia < 1) {
        alertInfo("Informacion", "El horario de salida debe ser al menos 1 hora después de la entrada.");
        // Si hay error, reseteamos a un rango válido por defecto
        inputSalida.value = `${String(hEntrada + 1).padStart(2, "0")}:00`;
    }
}

//funcion para limpiar el formulario
btnagregarDoctor.addEventListener("click", function () {
    formDoctor.querySelectorAll(".input-validar").forEach((ele) => {
        let divParent = ele.closest(".campo-custom");
        divParent.querySelector(".input-custom").classList.remove("valido", "invalido");
        divParent.querySelector(".check").classList.add("d-none");
        divParent.querySelector(".error").classList.add("d-none");
        divParent.querySelector(".error-msg").classList.add("d-none");
        console.log(divParent);

        ele.value = "";
    });
    labelModal.innerText = "Registrar Doctor";
    btnModal.innerText = "Registrar";
    contenedorImgEditar.classList.add("d-none");
    formDoctor.classList.remove("editar");
});

imagenDoctor.addEventListener("change", function (e) {
    let newImg = `<img  style="height: 200px;width: 100%;" src=''>`;

    contenedorImg.classList.remove("d-none");
    contenedorImgEditar.classList.add("d-none");
    cargarImg(this.files, newImg, contenedorImg);
});

let verificarFormulario = inicializarValidacionFormulario(formDoctor);
let verificarFormularioEsp = inicializarValidacionFormulario(formEspecialidad);
let verifcarFormAsignar = inicializarValidacionFormulario(formAsignarServicio);

formDoctor.addEventListener("submit", function (e) {
    e.preventDefault();

    let esValido = verificarFormulario();

    if (esValido) {
        if (formDoctor.classList.contains("editar")) {
            console.log("editar");

            updateDoctor(this);
        } else {
            console.log("guardar");
            createDoctor(this);
        }
    } else {
        alertError("Error", "Por favor verifique que todos los datos estén correctos.");
    }
});

formEspecialidad.addEventListener("submit", function (e) {
    e.preventDefault();

    let esValido = verificarFormularioEsp();

    if (esValido) {
        console.log("guardar");
        createEspecialidad(this);
    } else {
        alertError("Error", "Por favor verifique que todos los datos estén correctos.");
    }
});

formAsignarServicio.addEventListener("submit", function (e) {
    e.preventDefault();

    let esValido = verifcarFormAsignar();

    if (esValido) {
        console.log("guardar");
        asignarServicio(this);
    } else {
        alertError("Error", "Por favor verifique que todos los datos estén correctos.");
    }
});
