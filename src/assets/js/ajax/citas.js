import {
    executePetition,
    alertConfirm,
    alertError,
    alertSuccess,
    initDataTable,
    convertirHora,
} from "../generic/funtionGeneric.js";

import { inicializarValidacionFormulario } from "../generic/expresionesModulares.js";
addEventListener("DOMContentLoaded", function () {
    console.log("Citas....");

    const url = "/Sistema-del--CEM--JEHOVA-RAFA/Citas";

    const modalCita = new bootstrap.Modal(document.getElementById("exampleModalCita"));
    const modalPaciente = new bootstrap.Modal(document.getElementById("exampleModalagregarPaciente"));

    const modalAgregarCita = document.getElementById("modalAgregarCita");
    const cedulaCita = document.getElementById("cedulaCita");
    const cedulaPaciente = document.getElementById("cedulaPaciente");
    const nacionalidadCita = document.getElementById("nacionalidadCita");
    const inputPaciente = document.getElementById("inputPaciente");
    const inputTelefono = document.getElementById("inputTelefono");
    const divDataPaciente = document.getElementById("div-data-paciente");
    const inputIdPaciente = document.getElementById("id_paciente");
    const inputIdCita = document.getElementById("id_cita");
    const selectServicios = document.getElementById("select-servicios");
    const divDoctor = document.getElementById("div-doctor");
    const divHorarios = document.getElementById("div-horarios");
    const divHorariosDisp = document.getElementById("div-hora-disp");
    const accordionBodyDoctor = document.getElementById("accordion-body-doctor");
    const accordionBodyHorario = document.getElementById("accordion-body-horario");
    const accordionBodyDisp = document.getElementById("accordion-body-disp");
    const accordionButtonHorario = document.getElementById("accordion-button-horario");
    const divFecha = document.getElementById("div-fecha");
    const inputFechaCita = document.getElementById("fecha");
    const modalFooter = document.getElementById("modal-footer");
    const modalTitle = document.getElementById("modalTitleCita");
    const btnModal = modalFooter.children[1];
    const btnAgendarCita = document.getElementById("btnAgendarCita");

    const modalAgregarPaciente = document.getElementById("modalAgregar");
    const divBtnAddPat = document.getElementById("div-btn-add-pat");
    const btnOpenModalPac = document.getElementById("btnOpenModalPac");

    let nombreDoctorSelect = "";
    let diasLaborablesDoctor = [];
    let fechaGlobal = "";
    let id_doctor = 0;

    const traerPacienteCita = async () => {
        try {
            let [addClass, removeClass] = ["", ""];
            if (cedulaCita.value.length == 7 || cedulaCita.value.length == 8) {
                const result = await executePetition(
                    `/Sistema-del--CEM--JEHOVA-RAFA/Citas/mostrarDataPaciente/${nacionalidadCita.value}/${cedulaCita.value}`,
                    "GET",
                );

                console.log(result, `${nacionalidadCita.value}/${cedulaCita.value}`);
                if (result != []) {
                    inputPaciente.value = result.nombre + " " + result.apellido;
                    inputTelefono.value = result.telefono;
                    inputIdPaciente.value = result.id_paciente;
                    [addClass, removeClass] = ["valido", "invalido"];
                    divDataPaciente.classList.remove("d-none");

                    divBtnAddPat.classList.add("d-none");
                } else {
                    inputPaciente.value = "Paciente no encontrado";
                    inputTelefono.value = "Telefono no encontrado";
                    inputIdPaciente.value = 0;
                    [addClass, removeClass] = ["invalido", "valido"];
                    divDataPaciente.classList.add("d-none");

                    //hacer que aparesca la caja que contine el boton para abrir el modal de agregar paciente
                    divBtnAddPat.classList.remove("d-none");

                    modalFooter.classList.add("d-none");
                }
            } else {
                divDataPaciente.classList.add("d-none");
            }
        } catch (error) {
            alertError("Error", "Lamentablemente algo salió mal. " + error);
        }
    };

    const traerServiciosMedicos = async () => {
        try {
            const result = await executePetition(`/Sistema-del--CEM--JEHOVA-RAFA/Citas/mostrarServiciosMedicosAjax`, "GET");
            console.log(result);
            let html = `<option class="option-select-background" selected="" disabled value="0">Seleccionar Genero</option>`;

            if (result.length > 0) {
                result.forEach((res) => {
                    html += `<option class="option-select-background"  value="${res.id_categoria}">${res.nombre}</option>`;
                });
            }

            selectServicios.innerHTML = html;
        } catch (error) {
            alertError("Error", error);
        }
    };

    const traerDoctores = async (id) => {
        try {
            console.log(id);
            id_doctor = id;
            console.log(id_doctor);
            const result = await executePetition(`/Sistema-del--CEM--JEHOVA-RAFA/Citas/mostrarDoctoresCita/${id}`, "GET");
            let html = "";
            if (result.length > 0) {
                result.forEach((res) => {
                    nombreDoctorSelect = `Horarios de Dr ${res.nombre_doctor} ${res.apellido_doctor}`;
                    html += `<div class="form-check">
                  <input class="form-check-input checks-doctores" type="radio" value='${res.id_personal}' name="id_personal" id="flexRadioDefault2">
                  <label class="form-check-label" for="flexRadioDefault2">
                    Dr ${res.nombre_doctor} ${res.apellido_doctor}
                  </label>
                </div>`;
                });
                divDoctor.classList.remove("d-none");
            } else {
                html = `<h5 class="text-center">No hay doctores disponibles para dicho servicio</h5>`;
                divDoctor.classList.add("d-none");
            }
            accordionBodyDoctor.innerHTML = html;

            document.querySelectorAll(".checks-doctores").forEach((ele) => {
                ele.addEventListener("change", function () {
                    traerHorarioDoctor(this.value);
                });
            });

            divFecha.classList.add("d-none");
            divHorarios.classList.add("d-none");
            divHorariosDisp.classList.add("d-none");
            modalFooter.classList.add("d-none");

            inputFechaCita.value = "";
        } catch (error) {
            alertError("Error", error);
        }
    };

    const traerHorarioDoctor = async (id) => {
        try {
            id_doctor = id;
            console.log(id);
            const result = await executePetition(`/Sistema-del--CEM--JEHOVA-RAFA/Citas/mostrarHorario/${id}`, "GET");
            let html = "";
            diasLaborablesDoctor = [];
            let object = {};
            if (result.length > 0) {
                result.forEach((res) => {
                    html += `
                <div class="mb-2" id="divAcordion">
                  <div class="d-flex ">Días Laborables :  <p class="fw-bold"> ${res.diaslaborables}<p></div>
                  <div class="d-flex">Hora de: <p class="fw-bold"> ${convertirHora(res.horaDeEntrada)} a ${convertirHora(res.horaDeSalida)}<p></div>
                  <hr>
                </div> 
                `;

                    object[res.diaslaborables] = {
                        entrada: convertirHora(res.horaDeEntrada),
                        salida: convertirHora(res.horaDeSalida),
                    };

                    diasLaborablesDoctor.push(object);
                });
                console.log("aqui", diasLaborablesDoctor);
                divFecha.classList.remove("d-none");
                divHorarios.classList.remove("d-none");
            } else {
                divFecha.classList.add("d-none");
                divHorarios.classList.remove("d-none");
            }

            accordionButtonHorario.innerText = nombreDoctorSelect;
            accordionBodyHorario.innerHTML = html;
        } catch (error) {
            alertError("Error", error);
        }
    };

    const validarFechaCita = (input, listHoraRegistrada = []) => {
        let partesFecha = input.value.split("-");
        let fecha = new Date(partesFecha[0], partesFecha[1] - 1, partesFecha[2]);
        let dateName = fecha.toLocaleDateString("es-ES", { weekday: "long" }).toLowerCase();
        fechaGlobal = input.value;

        console.log(diasLaborablesDoctor);
        diasLaborablesDoctor.forEach((ele) => {
            if (ele[dateName]) {
                divHorariosDisp.classList.remove("d-none");
                validarHorarioDisponible(fechaGlobal, id_doctor, listHoraRegistrada);
                console.log("El dia es valido para el doctor");
                return;
            } else {
                divHorariosDisp.classList.add("d-none");

                alertError("Error", `El ${dateName} no esta dentro del horario del doctor.`);
            }
        });
    };

    const validarHorarioDisponible = async (fecha, id, listHoraRegistrada) => {
        try {
            const result = await executePetition(
                `/Sistema-del--CEM--JEHOVA-RAFA/Citas/validarHorariosDisponlibles/${fecha}/${id}`,
                "GET",
            );

            let html = "";

            let horasLibres1 = [];
            let horasLibres2 = [];

            const [horasDeTrabajo, horasOcupadas] = result;

            let horasOcupadasUnidas = horasOcupadas.flat();

            if (horasDeTrabajo.length > 0) {
                horasDeTrabajo.forEach((horaT, index) => {
                    horasLibres1 = horaT.filter((item) => !horasOcupadasUnidas.includes(item));
                    horasLibres2 = horasOcupadasUnidas.filter((item) => !horaT.includes(item));
                });

                const horasLibres = [...horasLibres1, ...horasLibres2];
                if (listHoraRegistrada != []) {
                    horasLibres.push(...listHoraRegistrada);
                }

                console.log(horasLibres);

                if (listHoraRegistrada.length == 0 && listHoraRegistrada[0] != undefined) {
                    horasLibres.push(listHoraRegistrada[0]);
                }
                console.log(horasLibres);

                horasLibres.forEach((res, index) => {
                    html += `
          <div class="contenido card cards-horario" data-index=${index} selection=false >
            <input type='hidden' class="valorHorasEntrada" >
            <h5 style="font-size: 15;" class="text-center">${res}</h5>
          </div>`;
                });
            }

            accordionBodyDisp.innerHTML = html;

            document.querySelectorAll(".cards-horario").forEach((card) => {
                card.addEventListener("click", function () {
                    //aparecer el boton de guardar
                    modalFooter.classList.remove("d-none");

                    let dataIndex = this.getAttribute("data-index");
                    let textHora = card.children[1].innerText;
                    document.querySelectorAll(".cards-horario").forEach((card2) => {
                        let input = card2.children[0];
                        if (card2.getAttribute("data-index") == dataIndex) {
                            console.log("se tecleo este input");
                            console.log(card2.children[0]);
                            card2.style.backgroundColor = "#387adf";
                            input.value = textHora;
                            input.setAttribute("name", "listHoras");
                        } else {
                            console.log("los demas se quito es estile");
                            console.log(card2.children[0]);
                            card2.style.backgroundColor = "";
                            input.value = "";
                            input.setAttribute("name", "");
                        }
                    });
                });
            });
        } catch (error) {
            alertError("Error ", error);
        }
    };

    const sumarUnaHora = (hora, sumarHora = 0) => {
        const fecha = new Date();

        const [h, m] = hora.split(":").map(Number);

        fecha.setHours(h);
        fecha.setMinutes(m);

        fecha.setHours(fecha.getHours() + sumarHora);

        const newHour = fecha.getHours().toString().padStart(2, "0");
        const newMinute = fecha.getMinutes().toString().padStart(2, "0");

        // retorna la nueva hora en formato "HH:MM"
        return `${newHour}:${newMinute}`;
    };

    const cargarDatosEditar = async (btn) => {
        //cambiar el estilo del modal
        modalAgregarCita.classList.add("editar");

        console.log(modalTitle);
        modalTitle.innerText = "Modificar Cita";
        btnModal.innerText = "Modificar";

        inputIdCita.value = btn.getAttribute("data-index");
        cedulaCita.value = btn.closest("tr").children[0].innerText.slice(2);
        await traerPacienteCita();

        await traerServiciosMedicos();
        selectServicios.value = btn.getAttribute("data-id-categoria");

        await traerDoctores(selectServicios.value);

        const valorABuscar = btn.getAttribute("data-id-doctor");
        // Buscamos todos los checkboxes

        document.querySelectorAll(".checks-doctores").forEach((check) => {
            check.checked = false;
            if (check.value == valorABuscar) {
                check.checked = true;
            }
        });
        await traerHorarioDoctor(valorABuscar);
        inputFechaCita.value = btn.closest("tr").children[5].innerText;

        //disparar el evento input para que se activr la validacion
        inputFechaCita.dispatchEvent(new Event("keyup", { bubbles: true }));
        cedulaCita.dispatchEvent(new Event("keyup", { bubbles: true }));

        let horaTable = btn.closest("tr").children[6].innerText;

        let horaEntradaEdi = convertirHora(sumarUnaHora(horaTable));
        let horaSalidaEdi = convertirHora(sumarUnaHora(horaTable, 1));

        const listHourEdit = [`${horaEntradaEdi} a ${horaSalidaEdi}`];

        validarFechaCita(inputFechaCita, listHourEdit);

        // //seleccionar la hora en base a la cita
        setTimeout(() => {
            document.querySelectorAll(".cards-horario").forEach((card) => {
                let horaCard = card.children[1].innerText;
                let input = card.children[0];
                console.log(horaCard, listHourEdit);
                if (horaCard == listHourEdit) {
                    modalFooter.classList.remove("d-none");
                    console.log("se tecleo este input");
                    console.log(card.children[0]);
                    card.style.backgroundColor = "#387adf";
                    input.value = horaCard;
                    input.setAttribute("name", "listHoras");
                } else {
                    console.log("los demas se quito es estile");
                    console.log(card.children[0]);
                    card.style.backgroundColor = "";
                    input.value = "";
                    input.setAttribute("name", "");
                }
            });
        }, 500);
    };

    const resetForm = (form) => {
        form.reset();

        divDataPaciente.classList.add("d-none");
        inputPaciente.value = "";
        inputTelefono.value = "";

        //quitar clase a los inputs
        document.querySelectorAll(".input-validar").forEach((input) => {
            input.parentElement.classList.remove("valido");
            input.parentElement.classList.remove("invalido");

            let span = input.nextElementSibling;

            span.children[0].classList.add("d-none");
            span.children[1].classList.add("d-none");
        });

        modalFooter.classList.remove("d-none");

        modalCita.hide();
    };

    //read
    const readCita = async () => {
        try {
            console.log("problemas");
            let metodo = "";
            let urlActual = window.location.href;

            if (urlActual.includes("Hoy")) metodo = "citasHoyAjax";
            else if (urlActual.includes("Realizadas")) metodo = "citasRealizadasAjax";
            else metodo = "citasAjax";

            console.log(url + "/" + metodo);
            const result = await executePetition(url + "/" + metodo, "GET");

            console.log(result);
            // construir html de filas
            let html = "";
            result.forEach((element) => {
                html += ` <tr>
                            <td class="text-center">${element.nacionalidad} ${element.cedula}</td>
                            <td class="text-center">${element.nombre_p} ${element.apellido_p}</td>
                            <td class="text-center">${element.telefono_p}</td>
                            <td class="text-center">${element.nombre_d} ${element.apellido_d}</td>
                            <td class="text-center">${element.categoria}</td>
                            <td class="text-center">${element.fecha}</td>
                            <td class="text-center">${element.hora}</td>

                            <td class="text-center">${element.estado}</td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center">
                                    <!-- editar -->
                                    
                                        <div class="me-2 botonesEdi ${urlActual.includes("Realizadas") ? "d-none" : ""}">
                                            <a href="#" class="btns-accion botonesEditar botonesEdi btn-dt-tabla"
                                                data-bs-toggle="modal" data-bs-target="#exampleModalCita" id="btnOpenModal" 
                                                data-index="${element.id_cita}" data-id-categoria="${element.id_categoria}" data-id-doctor="${element.doctor}" uk-tooltip="Modificar Cita"
                                                id="btnEditarCitaPendiente">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                    fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd"
                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                </svg>
                                            </a>
                                        </div>
                                   
                                        <div class="me-2">
                                            <a href="#" class="btns-accion btn-eliminar btn-dt-tabla" data-index=${
                                                element.id_cita
                                            } 
                                                uk-tooltip="Eliminar Cita" id="eliminarCitaP">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                    fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                    <path
                                                        d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                                </svg>
                                            </a>
                                        </div>
                                  

                                    </div>


                                </div>

        
                            </td>
                        </tr>`;
            });

            const selector = ".exampleTable";

            // si ya existe DataTable, destrúyela
            if ($.fn.DataTable.isDataTable(selector)) {
                $(selector).DataTable().clear().destroy();
            }

            // vuelca el html en el tbody
            document.querySelector(selector + " tbody").innerHTML = html;

            document.querySelectorAll(".id_usuario_bitacora").forEach((ele) => {
                ele.value = document.getElementById("id_usuario_session").value;
            });

            //llamar las funcion de eliminar
            document.querySelectorAll(".btn-eliminar").forEach((btn) => {
                btn.addEventListener("click", function () {
                    const data = [this.getAttribute("data-index"), document.getElementById("id_usuario_session").value];

                    alertConfirm("Esta seguro de eliminar la cita?", deleteCita, data);
                });
            });

            //editar cita
            document.querySelectorAll(".botonesEditar").forEach((btn) => {
                btn.addEventListener("click", async function () {
                    cargarDatosEditar(btn);
                });
            });

            // re-inicializa
            initDataTable(selector);
        } catch (error) {
            alertError("Error", error);
        }
    };

    //create
    const createCita = async (form) => {
        try {
            const data = new FormData(form);
            let result = await executePetition(url + "/guardarCita", "POST", data);
            console.log(result);
            if (result.ok) {
                alertSuccess(result.message);

                //funvcion para resetaer el formulario
                resetForm(form);

                readCita();
            } else throw new Error(`${result.error}`);
        } catch (error) {
            alertError("Error", error);
        }
    };

    //delete
    const deleteCita = async (data) => {
        try {
            const result = await executePetition(url + `/eliminarCita/${data}`, "GET");
            if (result.ok) {
                alertSuccess(result.message);

                readCita();
            } else throw new Error(`${result.error}`);
        } catch (error) {
            alertError("Error", error);
        }
    };

    //update
    const updateCitas = async (form) => {
        try {
            const data = new FormData(form);

            let result = await executePetition(url + "/editarCita", "POST", data);
            console.log(result);
            if (result.ok) {
                alertSuccess(result.message);

                //funvcion para resetaer el formulario
                resetForm(form);

                readCita();

                console.log(result.error);
            } else throw new Error(`${result.error}`);
        } catch (error) {
            console.log(error);
            alertError("Error", error);
        }
    };

    //create paciente
    //create
    const createPatients = async (form, inputs) => {
        try {
            const data = new FormData(form);
            let result = await executePetition("/Sistema-del--CEM--JEHOVA-RAFA/Pacientes/guardar", "POST", data);
            console.log(result);
            if (result.ok) {
                alertSuccess(result.message);
                cedulaCita.value = cedulaPaciente.value;
                cedulaCita.dispatchEvent(new Event("keyup", { bubbles: true }));

                form.reset();
                inputs = [];
                inputs.forEach((input) => input.parentElement.classList.remove("valido"));
                readCita();
                modalCita.show();
                modalPaciente.hide();
            } else throw new Error(`${result.error}`);
        } catch (error) {
            alertError("Error", error);
        }
    };

    readCita();

    cedulaCita.addEventListener("keyup", function () {
        cedulaCita.length;
        traerPacienteCita();
    });

    //evento para abrir el modal  del paciente
    btnOpenModalPac.addEventListener("click", function () {
        cedulaPaciente.value = cedulaCita.value;
        cedulaPaciente.dispatchEvent(new Event("keyup", { bubbles: true }));
    });

    selectServicios.addEventListener("change", function () {
        traerDoctores(this.value);
    });

    inputFechaCita.addEventListener("input", function () {
        validarFechaCita(this);
    });

    btnAgendarCita.addEventListener("click", function () {
        modalAgregarCita.classList.remove("editar");

        modalTitle.innerText = "Agendar Cita";
        btnModal.innerText = "Registrar";

        inputFechaCita.parentElement.classList.remove("valido");
        cedulaCita.parentElement.classList.remove("valido");
        inputFechaCita.parentElement.classList.remove("invalido");
        cedulaCita.parentElement.classList.remove("invalido");
    });

    traerServiciosMedicos();

    //funcion para busacar paciente por cita

    //inicializar las validaciones del formulario

    let verificarFormulario = inicializarValidacionFormulario(modalAgregarCita);

    //enviar formulario de cita
    modalAgregarCita.addEventListener("submit", function (e) {
        e.preventDefault();

        let inputs = this.querySelectorAll(".input-validar");

        if (inputs.length == 2) {
            console.log(modalAgregarCita);
            if (modalAgregarCita.classList.contains("editar")) {
                console.log("editar");
                updateCitas(this);
            } else {
                createCita(this);
            }
        } else {
            alertError("Error", "Por favor verifique que todos los datos estén correctos.");
        }
    });

    let verificarFormularioPaciente = inicializarValidacionFormulario(modalAgregarPaciente);

    //enviar firmulario de paciente
    modalAgregarPaciente.addEventListener("submit", function (e) {
        e.preventDefault();

        let inputsBuenos = [];
        this.querySelectorAll(".input-validar").forEach((input) => {
            if (input.parentElement.classList.contains("valido")) inputsBuenos.push(true);
        });

        let esValido = verificarFormularioPaciente();

        if (esValido) {
            createPatients(this, inputsBuenos);
        } else {
            alertError("Error", "Por favor verifique que todos los datos estén correctos.");
        }
    });
});
