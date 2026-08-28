import {
  executePetition,
  alertConfirm,
  alertError,
  alertSuccess,
  initDataTable,
  convertirHora,
  hasPermision,
  initLoaderButton,
  finallyLoaderButton,
  iniciarTemporizador,
  detenerTemporizador,
} from "../generic/funtionGeneric.js";

import { inicializarValidacionFormulario } from "../generic/expresionesModulares.js";
addEventListener("DOMContentLoaded", function () {
  console.log("Citas....");

  const url = "/Sistema-del--CEM--JEHOVA-RAFA/Citas";

  const modalCita = new bootstrap.Modal(
    document.getElementById("exampleModalCita"),
  );
  const modalPaciente = new bootstrap.Modal(
    document.getElementById("exampleModalagregarPaciente"),
  );

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
  const accordionBodyHorario = document.getElementById(
    "accordion-body-horario",
  );
  const accordionBodyDisp = document.getElementById("accordion-body-disp");
  const accordionButtonHorario = document.getElementById(
    "accordion-button-horario",
  );
  const divFecha = document.getElementById("div-fecha");
  const inputFechaCita = document.getElementById("fecha");
  const modalFooter = document.getElementById("modal-footer");
  const modalTitle = document.getElementById("modalTitleCita");
  const btnModal = modalFooter.children[1];
  const btnAgendarCita = document.getElementById("btnAgendarCita");

  const modalAgregarPaciente = document.getElementById("modalAgregar");
  const divBtnAddPat = document.getElementById("div-btn-add-pat");
  const btnOpenModalPac = document.getElementById("btnOpenModalPac");

  const id_rol_global = document.getElementById("id_rol_global").value;

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
      const result = await executePetition(
        `/Sistema-del--CEM--JEHOVA-RAFA/Citas/mostrarServiciosMedicosAjax`,
        "GET",
      );
      console.log(result);
      let html = `<option class="option-select-background" selected="" disabled value="0">Seleccionar Servicio médico</option>`;

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
      const result = await executePetition(
        `/Sistema-del--CEM--JEHOVA-RAFA/Citas/mostrarDoctoresCita/${id}`,
        "GET",
      );
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
      const result = await executePetition(
        `/Sistema-del--CEM--JEHOVA-RAFA/Citas/mostrarHorario/${id}`,
        "GET",
      );
      let html = "";
      diasLaborablesDoctor = [];
      let object = {};
      if (result.length > 0) {
        result.forEach((res) => {
          html += `
                <div class="mb-2" id="divAcordion">
                  <div class="d-flex "><p class="fw-bold"> Día Laborable: ${res.diaslaborables}<p></div>
                  <div class="d-flex"> <p class="fw-bold">Hora de: ${convertirHora(res.horaDeEntrada)} a ${convertirHora(res.horaDeSalida)}<p></div>
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
    let dateName = fecha
      .toLocaleDateString("es-ES", { weekday: "long" })
      .toLowerCase();
    fechaGlobal = input.value;

    console.log(diasLaborablesDoctor);
    // dateName = dateName.charAt(0).toUpperCase() + dateName.slice(1);
    console.log(dateName);
    //no se encontraron registros
    if (!diasLaborablesDoctor.length > 0) {
      divHorariosDisp.classList.add("d-none");
      alertError("Error", `Lamentablemente no se encontraron dias del doctor `);
      return;
    }

    diasLaborablesDoctor.forEach((ele) => {
      console.log(ele[dateName]);
      if (!ele[dateName]) {
        //agregar clase de invalido al input ya que el dia no esta dentro del horario  del doctor
        let campoCustom = input.closest(".campo-custom");
        let inputCustom = campoCustom.querySelector(".input-custom");
        let check = campoCustom.querySelector(".check");
        let error = campoCustom.querySelector(".error");

        inputCustom.classList.remove("valido");
        inputCustom.classList.add("invalido");

        check.classList.add("d-none");
        error.classList.remove("d-none");

        console.log(campoCustom, inputCustom, check, error);

        divHorariosDisp.classList.add("d-none");
        alertError(
          "Error",
          `El ${dateName} no esta dentro del horario del doctor.`,
        );
        return;
      }
      if (ele[dateName]) {
        divHorariosDisp.classList.remove("d-none");
        validarHorarioDisponible(fechaGlobal, id_doctor, listHoraRegistrada);
        console.log("El dia es valido para el doctor");
        return;
      }
    });
  };

  const validarHorarioDisponible = async (fecha, id, listHoraRegistrada) => {
    try {
      console.log(
        `/Sistema-del--CEM--JEHOVA-RAFA/Citas/validarHorariosDisponlibles/${fecha}/${id}`,
      );

      const result = await executePetition(
        `/Sistema-del--CEM--JEHOVA-RAFA/Citas/validarHorariosDisponlibles/${fecha}/${id}`,
        "GET",
      );
      console.log(result);

      let html = "";

      let horasLibres1 = [];
      let horasLibres2 = [];

      const [horasDeTrabajo, horasOcupadas] = result;

      let horasOcupadasUnidas = horasOcupadas.flat();

      if (horasDeTrabajo.length > 0) {
        horasDeTrabajo.forEach((horaT, index) => {
          horasLibres1 = horaT.filter(
            (item) => !horasOcupadasUnidas.includes(item),
          );
          horasLibres2 = horasOcupadasUnidas.filter(
            (item) => !horaT.includes(item),
          );
        });

        const horasLibres = [...horasLibres1, ...horasLibres2];
        if (listHoraRegistrada != []) {
          horasLibres.push(...listHoraRegistrada);
        }

        console.log(horasLibres);

        if (
          listHoraRegistrada.length == 0 &&
          listHoraRegistrada[0] != undefined
        ) {
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
              if (!modalAgregarCita.classList.contains("editar")) {
                seleccionarHorarioDisponibilidad(card2);
              }
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
    console.log(btn,'datoseditar');
    
    //cambiar el estilo del modal
    modalAgregarCita.classList.add("editar");

    console.log(modalTitle);
    modalTitle.innerText = "Modificar Cita";
    btnModal.innerText = "Modificar";

    inputIdCita.value = btn.getAttribute("data-index");
    cedulaCita.value = btn.closest("tr").children[0].innerText.slice(2);
    console.log(cedulaCita.value);
    
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
      let metodo = "";
      let urlActual = window.location.href;

      if (urlActual.includes("Hoy")) metodo = "citasHoyAjax";
      else if (urlActual.includes("Realizadas")) metodo = "citasRealizadasAjax";
      else metodo = "citasAjax";

      const selector = ".exampleTable";

      // si ya existe DataTable, destrúyela
      if ($.fn.DataTable.isDataTable(selector)) {
        $(selector).DataTable().clear().destroy();
      }

      const columnsCitas = [
        {
          data: "paciente_cedula",
          render: function (data, type, row) {
            return `${row.nacionalidad}-${row.paciente_cedula}`;
          },
        },
        {
          data: "paciente_nombre",
          render: function (data, type, row) {
            return `${row.paciente_nombre} ${row.apellido_p}`;
          },
        },
        { data: "telefono" },
        {
          data: "doctor_nombre",
          render: function (data, type, row) {
            return `Dr. ${row.doctor_nombre} ${row.apellido_d}`;
          },
        },
        { data: "categoria" },
        { data: "fecha" },
        {
          data: "hora",
          render: function (data) {
            // Reutiliza tu función global para formatear la hora a formato amigable si la tienes
            return data;
          },
        },
        { data: "estado" },

        {
          data: null,
          orderable: false,
          render: function (data, type, row) {
            return `
                                <div class="d-flex justify-content-center align-items-center">
                                    <!-- editar -->
                                    
                                        <div class="me-2 botonesEdi ${urlActual.includes("Realizadas") ? "d-none" : ""}">
                                            <a href="#" class="btn btn-tabla botonesEditar botonesEdi btn-dt-tabla"
                                                data-bs-toggle="modal" data-bs-target="#exampleModalCita" id="btnOpenModal" 
                                                data-index="${row.id_cita}" data-id-categoria="${row.id_categoria}" data-id-doctor="${row.doctor}" uk-tooltip="Modificar Cita"
                                                id="btnEditarCitaPendiente">
                                               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                </svg>
                                            </a>
                                        </div>
                                   
                                        <div class="me-2">
                                            <a href="#" class="btn btn-tabla btn-eliminar btn-dt-tabla" data-index=${
                                              row.id_cita
                                            } 
                                                uk-tooltip="Eliminar Cita" id="eliminarCitaP">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"></path>
                                </svg>
                                            </a>
                                        </div>
                                  

                                    </div>


                                </div>
      `;
          },
        },
      ];

      const asignarEventos = () => {
        //llamar las funcion de eliminar
        document.querySelectorAll(".btn-eliminar").forEach((btn) => {
          btn.addEventListener("click", function () {
            const data = [
              this.getAttribute("data-index"),
              0,
            ];

            alertConfirm("Esta seguro de eliminar la cita?", deleteCita, data);
          });
        });

        //editar cita
        document.querySelectorAll(".botonesEditar").forEach((btn) => {
          btn.addEventListener("click", async function () {
            cargarDatosEditar(btn);
          });
        });

        //////gestionar persmisos
        hasPermision(id_rol_global, "Citas", "guardar", ".btnOpenModal"); //guardar
        hasPermision(id_rol_global, "Citas", "eliminar", ".btn-eliminar"); //eliminar
        hasPermision(id_rol_global, "Citas", "editar", ".botonesEditar"); //editar
      };
      console.log(url + "/" + metodo);

      // re-inicializa
      initDataTable(
        selector,
        url + "/" + metodo,
        columnsCitas,
        (datosServer) => {
          console.log(datosServer);
        },
        asignarEventos,
      );
    } catch (error) {
      alertError("Error", error);
    }
  };

  //create
  const createCita = async (form) => {
    try {
      initLoaderButton(btnModal);
      const data = new FormData(form);
      let result = await executePetition(url + "/guardarCita", "POST", data);
      console.log(result);
      if (result.ok) {
        alertSuccess(result.message);
        //deterner temporizador
        detenerTemporizador("citas");
        //funvcion para resetaer el formulario
        resetForm(form);
        readCita();
      } else throw new Error(`${result.error}`);
    } catch (error) {
      alertError(
        "Error",
        "El Formulario debe estar lleno para poder enviarlo.",
      );
    } finally {
      finallyLoaderButton(btnModal);
    }
  };

  //delete
  const deleteCita = async (data) => {
    try {
      const payload = { id: data[0], estado: data[1] };
      const result = await executePetition(
        url + `/eliminarCita/`,
        "POST",payload
      );
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
      initLoaderButton(btnModal);
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
      alertError(
        "Error",
        "El Formulario debe estar lleno para poder enviarlo.",
      );
    } finally {
      finallyLoaderButton(btnModal);
    }
  };

  //create paciente
  //create
  const createPatients = async (form, inputs) => {
    try {
      const data = new FormData(form);
      let result = await executePetition(
        "/Sistema-del--CEM--JEHOVA-RAFA/Pacientes/guardar",
        "POST",
        data,
      );
      console.log(result);
      if (result.ok) {
        alertSuccess(result.message);
        cedulaCita.value = cedulaPaciente.value;
        cedulaCita.dispatchEvent(new Event("keyup", { bubbles: true }));

        form.reset();
        inputs = [];
        inputs.forEach((input) =>
          input.parentElement.classList.remove("valido"),
        );
        readCita();
        modalCita.show();
        modalPaciente.hide();
      } else throw new Error(`${result.error}`);
    } catch (error) {
      alertError("Error", error);
    }
  };

  // Agregamos "async" al inicio de la función
  const seleccionarHorarioDisponibilidad = async (elementoTarjetaHora) => {
    console.log("id_doctor" + id_doctor);

    const form = new FormData();
    form.append("fecha", inputFechaCita.value);
    form.append("hora_string", elementoTarjetaHora.innerText.trim());
    form.append("doctor", id_doctor);
    form.append("id_paciente", inputIdPaciente.value);
    form.append("id_servicioMedico", selectServicios.value);

    // Si ya tiene un ID en el input oculto (cambio de opinión)
    if (inputIdCita.value && inputIdCita.value !== "") {
      form.append("id_cita_anterior", inputIdCita.value);
    }

    // Estructura obligatoria try/catch para manejar el asincronismo de forma segura
    try {
      // Reemplazamos el .then() por "await"
      const data = await executePetition(url + "/apartarCupo", "POST", form);
      let result = await executePetition(url + "/guardarCita", "POST", data);

      if (data.ok) {
        console.log(
          "Cupo apartado de manera optimista en MariaDB con async/await.",
        );

        // Guardamos el ID de la nueva cita generada
        inputIdCita.value = data.id_cita;

        // DISPARAMOS LAS ALERTAS SILENCIOSAS EN SEGUNDO PLANO
        iniciarTemporizador(
          "citas",
          {
            idModal: "exampleModalCita",
            idFormulario: "modalAgregarCita",
            callbackAlExpirar: function () {
              inputIdPaciente.value = "";
              inputIdCita.value = "";
              divDataPaciente.classList.add("d-none");
            },
          },
          "¡Atención! Le quedan 30 segundos para agendar la cita antes de que expire el cupo",
        );
      } else {
        alertError(
          "Horario No Disponible",
          data.error || "Este cupo ya fue apartado por otro usuario.",
        );
      }
    } catch (error) {
      // Reemplazamos el .catch() tradicional
      console.error("Error en la petición asíncrona con async/await:", error);
      alertError("Error de Conexión", "No se pudo comunicar con el servidor.");
    }
  };

  readCita();

  cedulaCita.addEventListener("keyup", function () {
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

    modalAgregarCita.reset();

    inputFechaCita.parentElement.classList.remove("valido");
    cedulaCita.parentElement.classList.remove("valido");
    inputFechaCita.parentElement.classList.remove("invalido");
    cedulaCita.parentElement.classList.remove("invalido");

    cedulaCita.nextElementSibling.children[0].classList.add("d-none");
    cedulaCita.nextElementSibling.children[1].classList.add("d-none");

    inputFechaCita.nextElementSibling.children[0].classList.add("d-none");
    inputFechaCita.nextElementSibling.children[1].classList.add("d-none");

    cedulaCita.parentElement.parentElement
      .querySelector(".error-msg")
      .classList.add("d-none");

    inputFechaCita.parentElement.parentElement
      .querySelector(".error-msg")
      .classList.add("d-none");

    //limpiar las divs con datos en el formulario
    accordionBodyDoctor.innerHTML = "";
    accordionBodyHorario.innerHTML = "";
    accordionBodyDisp.innerHTML = "";

    divDoctor.classList.add("d-none");
    divHorarios.classList.add("d-none");
    divFecha.classList.add("d-none");
    divHorariosDisp.classList.add("d-none");

    ///ocultar la data
    divDataPaciente.classList.add("d-none");

    //ocultar btn paciente
    divBtnAddPat.classList.add("d-none");
  });

  traerServiciosMedicos();

  //funcion para busacar paciente por cita

  //inicializar las validaciones del formulario

  let verificarFormulario = inicializarValidacionFormulario(modalAgregarCita);

  //enviar formulario de cita
  modalAgregarCita.addEventListener("submit", function (e) {
    e.preventDefault();

    let inputs = this.querySelectorAll(".input-validar");
    console.log(inputs);

    if (inputs.length == 2) {
      console.log(modalAgregarCita);
      if (modalAgregarCita.classList.contains("editar")) {
        console.log("editar");
        updateCitas(this);
      } else {
        createCita(this);
      }
    } else {
      alertError(
        "Error",
        "Por favor verifique que todos los datos estén correctos.",
      );
    }
  });

  let verificarFormularioPaciente =
    inicializarValidacionFormulario(modalAgregarPaciente);

  //enviar firmulario de paciente
  modalAgregarPaciente.addEventListener("submit", function (e) {
    e.preventDefault();

    let inputsBuenos = [];
    this.querySelectorAll(".input-validar").forEach((input) => {
      if (input.parentElement.classList.contains("valido"))
        inputsBuenos.push(true);
    });

    let esValido = verificarFormularioPaciente();

    if (esValido) {
      createPatients(this, inputsBuenos);
    } else {
      alertError(
        "Error",
        "Por favor verifique que todos los datos estén correctos.",
      );
    }
  });
});
