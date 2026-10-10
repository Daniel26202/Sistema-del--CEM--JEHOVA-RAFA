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

  // Estado de la validación personalizada de la fecha de la cita
  let fechaValidaParaDoctor = false;
  let ultimaFechaProcesada = "";

  // Bandera para evitar peticiones duplicadas al hacer doble clic en un horario
  let apartandoCupo = false;

  // Normaliza un texto eliminando acentos y pasándolo a minúsculas,
  // así los días laborables se comparan sin importar tildes (ej: "miércoles" === "miercoles")
  const normalizarDia = (texto) =>
    String(texto)
      .normalize("NFD")
      .replace(/[\u0300-\u036f]/g, "")
      .toLowerCase();

  const traerPacienteCita = async () => {
    try {
      let [addClass, removeClass] = ["", ""];
      if (cedulaCita.value.length == 7 || cedulaCita.value.length == 8) {
        const result = await executePetition(
          `/Sistema-del--CEM--JEHOVA-RAFA/Citas/mostrarDataPaciente/${nacionalidadCita.value}/${cedulaCita.value}`,
          "GET",
        );

        console.log(result, `${nacionalidadCita.value}/${cedulaCita.value}`);

        // Solo se acepta la respuesta si trae un identificador hasheado real.
        // Antes la condición era "if (result != [])", que es verdadera para
        // cualquier objeto: si la petición fallaba (límite de peticiones,
        // sesión vencida, etc.) se entraba a la rama "encontrado" y se
        // guardaba la cadena "undefined" en el campo oculto. El servidor no
        // podía descifrarla y respondía "No se pudo validar la selección".
        const idRecibido = result ? result.id_paciente : null;
        const tieneIdValido =
          idRecibido !== undefined &&
          idRecibido !== null &&
          /^[a-zA-Z0-9]{4,}$/.test(String(idRecibido));

        if (tieneIdValido) {
          inputPaciente.value = result.nombre + " " + result.apellido;
          inputTelefono.value = result.telefono;
          inputIdPaciente.value = idRecibido;
          [addClass, removeClass] = ["valido", "invalido"];
          divDataPaciente.classList.remove("d-none");

          divBtnAddPat.classList.add("d-none");
        } else {
          inputPaciente.value = "Paciente no encontrado";
          inputTelefono.value = "Telefono no encontrado";
          inputIdPaciente.value = "0";
          [addClass, removeClass] = ["invalido", "valido"];
          divDataPaciente.classList.add("d-none");

          //hacer que aparesca la caja que contine el boton para abrir el modal de agregar paciente
          divBtnAddPat.classList.remove("d-none");

          modalFooter.classList.add("d-none");

          // Si la consulta no llegó a completarse se explica por qué, en
          // lugar de dejar que el fallo aparezca más adelante al apartar
          if (result && result.error && !result.nombre) {
            alertError("No se pudo buscar el paciente", result.error);
          }
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
      let html = `<option class="option-select-background" selected="" disabled value="">Seleccionar Servicio médico</option>`;

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

      // Limpiar los horarios disponibles y el estado de la fecha
      // al cambiar de servicio (evita dejar una hora apartada huérfana)
      accordionBodyDisp.innerHTML = "";
      fechaValidaParaDoctor = false;
      ultimaFechaProcesada = "";

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
      if (result.length > 0) {
        result.forEach((res) => {
          html += `
                <div class="mb-2" id="divAcordion">
                  <div class="d-flex "><p class="fw-bold"> Día Laborable: ${res.diaslaborables}<p></div>
                  <div class="d-flex"> <p class="fw-bold">Hora de: ${convertirHora(res.horaDeEntrada)} a ${convertirHora(res.horaDeSalida)}<p></div>
                  <hr>
                </div> 
                `;

          // Se crea un objeto nuevo por cada día laborable y se normaliza su clave
          // para que la comparación con el día seleccionado sea sin tildes
          const dia = normalizarDia(res.diaslaborables);
          diasLaborablesDoctor.push({
            [dia]: {
              entrada: convertirHora(res.horaDeEntrada),
              salida: convertirHora(res.horaDeSalida),
            },
          });
        });
        console.log("aqui", diasLaborablesDoctor);
        divFecha.classList.remove("d-none");
        divHorarios.classList.remove("d-none");

        // Limpiar los horarios disponibles anteriores al cambiar de doctor
        accordionBodyDisp.innerHTML = "";
        divHorariosDisp.classList.add("d-none");
        fechaValidaParaDoctor = false;
        ultimaFechaProcesada = "";
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
    const campoCustom = input.closest(".campo-custom");
    const inputCustom = campoCustom.querySelector(".input-custom");
    const check = campoCustom.querySelector(".check");
    const error = campoCustom.querySelector(".error");
    const pError = campoCustom.querySelector(".error-msg");

    // Si el campo está vacío o la fecha no es válida, se deja en estado neutro
    const partesFecha = (input.value || "").split("-");
    const fecha = new Date(partesFecha[0], partesFecha[1] - 1, partesFecha[2]);
    if (!input.value || isNaN(fecha.getTime())) {
      fechaValidaParaDoctor = false;
      return;
    }

    // Nombre del día sin tildes para compararlo con los días laborables del doctor
    const dateName = normalizarDia(
      fecha.toLocaleDateString("es-ES", { weekday: "long" }),
    );
    fechaGlobal = input.value;

    // No se encontraron registros de horario para el doctor
    if (diasLaborablesDoctor.length === 0) {
      fechaValidaParaDoctor = false;
      divHorariosDisp.classList.add("d-none");
      if (input.value !== ultimaFechaProcesada) {
        ultimaFechaProcesada = input.value;
        alertError("Error", "Lamentablemente no se encontraron días del doctor");
      }
      return;
    }

    // ¿El día seleccionado está dentro de los días laborables del doctor?
    const esDiaLaborable = diasLaborablesDoctor.some((ele) => ele[dateName]);

    if (!esDiaLaborable) {
      // Agregar clase de inválido al input ya que el día no está dentro del horario del doctor
      fechaValidaParaDoctor = false;
      inputCustom.classList.remove("valido");
      inputCustom.classList.add("invalido");

      check.classList.add("d-none");
      error.classList.remove("d-none");

      if (pError) {
        pError.textContent = `El ${dateName} no está dentro del horario del doctor.`;
        pError.classList.remove("d-none");
      }

      divHorariosDisp.classList.add("d-none");

      // Se avisa solo cuando la fecha cambia para no duplicar alertas
      if (input.value !== ultimaFechaProcesada) {
        ultimaFechaProcesada = input.value;
        alertError("Error", `El ${dateName} no está dentro del horario del doctor.`);
      }
      return;
    }

    // El día es válido para el doctor
    fechaValidaParaDoctor = true;
    inputCustom.classList.remove("invalido");
    inputCustom.classList.add("valido");

    check.classList.remove("d-none");
    error.classList.add("d-none");

    if (pError) {
      pError.classList.add("d-none");
    }

    divHorariosDisp.classList.remove("d-none");

    // Solo consulta los horarios disponibles cuando la fecha cambia
    if (input.value !== ultimaFechaProcesada) {
      ultimaFechaProcesada = input.value;
      validarHorarioDisponible(fechaGlobal, id_doctor, listHoraRegistrada);
    }
  };

  // Convierte el inicio de una tarjeta ("8:00 PM a 9:00 PM" o "8:00 PM") a
  // "20:00:00". Es la MISMA clave que usa el servidor para detectar el
  // conflicto (cita.hora), así la UI y el backend coinciden exactamente.
  const convertirA24Hora = (textoHora) => {
    const partes = String(textoHora).split(" a ")[0].trim();
    const coincidencia = partes.match(/^(\d{1,2}):(\d{2})\s*(AM|PM)$/i);

    if (!coincidencia) return "";

    let horas = parseInt(coincidencia[1], 10) % 12;
    if (/pm/i.test(coincidencia[3])) horas += 12;

    return `${String(horas).padStart(2, "0")}:${coincidencia[2]}:00`;
  };

  const validarHorarioDisponible = async (fecha, id, listHoraRegistrada) => {
    try {
      const result = await executePetition(
        `/Sistema-del--CEM--JEHOVA-RAFA/Citas/validarHorariosDisponlibles/${fecha}/${id}`,
        "GET",
      );
      console.log(result);

      let html = "";

      if (!Array.isArray(result) || result.length < 2) {
        accordionBodyDisp.innerHTML = "";
        return;
      }

      const [horasDeTrabajo, horasOcupadas] = result;

      // Los horarios pueden venir como arreglo de arreglos o plano, .flat() normaliza ambos
      const horasTrabajo = (Array.isArray(horasDeTrabajo) ? horasDeTrabajo : []).flat();
      const horasOcupadasUnidas = (Array.isArray(horasOcupadas) ? horasOcupadas : []).flat();

      // Horarios laborables del doctor que aún no están ocupados por otra cita
      // Se compara por la hora de INICIO, que es exactamente lo que el
      // servidor bloquea al apartar el cupo
      let horasLibres = horasTrabajo.filter(
        (item) => !horasOcupadasUnidas.includes(convertirA24Hora(item)),
      );

      // Al editar una cita se incluye su hora actual, aunque ya esté ocupada por la misma cita
      if (Array.isArray(listHoraRegistrada) && listHoraRegistrada.length > 0) {
        listHoraRegistrada.forEach((hora) => {
          if (!horasLibres.includes(hora)) horasLibres.push(hora);
        });
      }

      horasLibres.forEach((res, index) => {
        html += `
          <div class="contenido card cards-horario" data-index=${index} selection=false >
            <input type='hidden' class="valorHorasEntrada" >
            <h5 style="font-size: 15;" class="text-center">${res}</h5>
          </div>`;
      });

      accordionBodyDisp.innerHTML = html;

      document.querySelectorAll(".cards-horario").forEach((card) => {
        card.addEventListener("click", function () {
          // Ignorar clics mientras se está apartando un cupo (evita doble clic)
          if (apartandoCupo) return;

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
    console.log(btn, "datoseditar");

    //cambiar el estilo del modal
    modalAgregarCita.classList.add("editar");

    console.log(modalTitle);
    modalTitle.innerText = "Modificar Cita";
    btnModal.innerText = "Modificar";

    inputIdCita.value = btn.getAttribute("data-index");
    // Cédula y fecha se leen de los atributos del botón (datos crudos de la
    // base) en vez del texto de la tabla, para que el flujo de edición no
    // dependa de cómo se vea cada columna en pantalla
    cedulaCita.value =
      btn.getAttribute("data-cedula") ||
      btn.closest("tr").children[0].innerText.slice(2);
    console.log(cedulaCita.value);

    // La nacionalidad se ajusta a la del paciente: antes se buscaba con la que
    // estuviera en el <select> (siempre "V" por defecto) y un paciente de
    // otra nacionalidad aparecía como "no encontrado" al modificar su cita
    const nacionalidadPaciente = btn.getAttribute("data-nacionalidad");

    if (nacionalidadPaciente) {
      nacionalidadCita.value = nacionalidadPaciente;

      if (nacionalidadCita.value !== nacionalidadPaciente) {
        alertError(
          "Nacionalidad no disponible",
          `Este paciente tiene la nacionalidad "${nacionalidadPaciente}" y no está en la lista del formulario. Agrega esa opción para poder modificar su cita.`,
        );
        return;
      }
    }

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
    inputFechaCita.value =
      btn.getAttribute("data-fecha") || btn.closest("tr").children[5].innerText;

    //disparar el evento keyup para que se active la validación genérica de la cédula
    cedulaCita.dispatchEvent(new Event("keyup", { bubbles: true }));

    // La hora se toma del atributo data-hora (formato 24 horas de la base),
    // no del texto de la tabla, que ahora se muestra en 12 horas
    let horaTable = btn.getAttribute("data-hora") || btn.closest("tr").children[6].innerText;

    let horaEntradaEdi = convertirHora(sumarUnaHora(horaTable));
    let horaSalidaEdi = convertirHora(sumarUnaHora(horaTable, 1));

    const listHourEdit = [`${horaEntradaEdi} a ${horaSalidaEdi}`];

    // Se reinicia el control de fechas para forzar la carga de horarios
    // incluyendo la hora actual de la cita que se está editando
    ultimaFechaProcesada = "";
    validarFechaCita(inputFechaCita, listHourEdit);

    // //seleccionar la hora en base a la cita
    setTimeout(() => {
      document.querySelectorAll(".cards-horario").forEach((card) => {
        let horaCard = card.children[1].innerText;
        let input = card.children[0];
        console.log(horaCard, listHourEdit);
        if (horaCard == listHourEdit[0]) {
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

    // Reiniciar el estado de la validación de fecha/horarios
    fechaValidaParaDoctor = false;
    ultimaFechaProcesada = "";

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

      if (urlActual.includes("Hoy")) {
        metodo = "citasHoyAjax";
      } else if (urlActual.includes("Realizadas")) {
        metodo = "citasRealizadasAjax";
        btnAgendarCita.classList.add('d-none');
      } else {
        metodo = "citasAjax";
      }

      const selector = ".exampleTable";

      // si ya existe DataTable, destrúyela
      if ($.fn.DataTable.isDataTable(selector)) {
        $(selector).DataTable().clear().destroy();
      }

      const columnsCitas = [
        {
          data: "paciente_cedula",
          render: function (data, type, row) {
            return `${row.paciente_nacionalidad}-${row.paciente_cedula}`;
          },
        },
        {
          data: "paciente_nombre",
          render: function (data, type, row) {
            return `${row.paciente_nombre} ${row.apellido_p}`;
          },
        },
        { data: "telefono_p" },
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
          render: function (data, type, row) {
            // Se muestra en formato de 12 horas ("8:00 PM") para que sea
            // más intuitivo. Solo se transforma en pantalla: la base de
            // datos sigue guardando y comparando la hora en 24 horas.
            if (type !== "display" || !data) return data;

            return convertirHora(data);
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
                                            <button class="btn btn-tabla botonesEditar botonesEdi btn-dt-tabla"
                                                data-bs-toggle="modal" data-bs-target="#exampleModalCita" id="btnOpenModal" 
                                                data-index="${row.id_cita}" data-id-categoria="${row.id_categoria}" data-id-doctor="${row.doctor}" uk-tooltip="Modificar Cita"
                                                data-hora="${row.hora}" data-fecha="${row.fecha}" data-cedula="${row.paciente_cedula}" data-nacionalidad="${row.paciente_nacionalidad}"
                                                id="btnEditarCitaPendiente">
                                               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                                </svg>
                                            </button>
                                        </div>
                                   
                                        <div class="me-2">
                                            <button class="btn btn-tabla btn-eliminar btn-dt-tabla" data-index=${
                                              row.id_cita
                                            } 
                                                uk-tooltip="Eliminar Cita" id="eliminarCitaP">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"></path>
                                </svg>
                                            </button>
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
            const data = [this.getAttribute("data-index"), 0];

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

        // Refrescar la grilla de horarios del día: la hora recién usada deja
        // de estar disponible y se descartan las tarjetas anteriores que ya
        // no corresponden a la selección actual
        if (fechaGlobal && id_doctor) {
          ultimaFechaProcesada = "";
          validarHorarioDisponible(fechaGlobal, id_doctor, []);
        } else {
          accordionBodyDisp.innerHTML = "";
          divHorariosDisp.classList.add("d-none");
        }
      } else {
        // Mostrar el error real que devolvió el servidor
        alertError("Error", result.error || "No se pudo registrar la cita.");
      }
    } catch (error) {
      alertError(
        "Error",
        "No se pudo comunicar con el servidor. Verifique su conexión.",
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
        "POST",
        payload,
      );
      if (result.ok) {
        alertSuccess(result.message);

        readCita();
      } else {
        alertError("Error", result.error || "No se pudo eliminar la cita.");
      }
    } catch (error) {
      alertError("Error", "No se pudo comunicar con el servidor.");
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
      } else {
        // Mostrar el error real que devolvió el servidor
        alertError("Error", result.error || "No se pudo modificar la cita.");
      }
    } catch (error) {
      console.log(error);
      alertError(
        "Error",
        "No se pudo comunicar con el servidor. Verifique su conexión.",
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
      } else {
        alertError("Error", result.error || "No se pudo registrar el paciente.");
      }
    } catch (error) {
      alertError("Error", "No se pudo comunicar con el servidor.");
    }
  };

  // Agregamos "async" al inicio de la función
  const seleccionarHorarioDisponibilidad = async (elementoTarjetaHora) => {
    console.log("id_doctor" + id_doctor);

    // Validaciones previas. Sin esto se enviaban identificadores vacíos o con
    // el "0" del <option> placeholder y el servidor respondía
    // "Error interno del servidor" al no poder aplicar unhashId()
    if (!inputFechaCita.value || !id_doctor) {
      alertError(
        "Datos incompletos",
        "Seleccione la fecha y el doctor antes de elegir un horario.",
      );
      return;
    }

    if (!inputIdPaciente.value || inputIdPaciente.value === "0") {
      alertError(
        "Datos incompletos",
        "Debe seleccionar o registrar un paciente antes de apartar el horario.",
      );
      // inputPaciente es de solo lectura, el campo accionable es la cédula
      cedulaCita.focus();
      return;
    }

    if (!selectServicios.value || selectServicios.value === "0") {
      alertError(
        "Datos incompletos",
        "Seleccione un servicio médico antes de apartar el horario.",
      );
      selectServicios.focus();
      return;
    }

    // Evitar peticiones duplicadas por doble clic en el horario
    if (apartandoCupo) return;
    apartandoCupo = true;

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

      if (data.ok) {
        console.log(
          "Cupo apartado de manera optimista en MariaDB con async/await.",
        );

        // Guardamos el ID (hasheado) de la nueva reserva generada
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

        // Revertir la selección visual del horario que no se pudo apartar
        elementoTarjetaHora.style.backgroundColor = "";
        const inputTarjeta = elementoTarjetaHora.querySelector("input");
        if (inputTarjeta) {
          inputTarjeta.value = "";
          inputTarjeta.removeAttribute("name");
        }
      }
    } catch (error) {
      // Reemplazamos el .catch() tradicional
      console.error("Error en la petición asíncrona con async/await:", error);
      alertError("Error de Conexión", "No se pudo comunicar con el servidor.");
    } finally {
      apartandoCupo = false;
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

  btnAgendarCita.addEventListener("click", function () {
    modalAgregarCita.classList.remove("editar");

    modalTitle.innerText = "Agendar Cita";
    btnModal.innerText = "Registrar";

    modalAgregarCita.reset();

    // Reiniciar el estado de la validación de fecha/horarios
    fechaValidaParaDoctor = false;
    ultimaFechaProcesada = "";

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

    modalFooter.classList.add("d-none");
  });

  traerServiciosMedicos();

  //funcion para busacar paciente por cita

  //inicializar las validaciones del formulario

  let verificarFormulario = inicializarValidacionFormulario(modalAgregarCita);

  // La validación personalizada de la fecha se registra DESPUÉS de la
  // validación genérica para que la clase "invalido" (día no laborable)
  // no sea sobrescrita. Se re-aplica en keyup/blur porque la validación
  // genérica también se ejecuta en esos eventos.
  const revalidarFechaCita = function () {
    validarFechaCita(inputFechaCita);
  };
  inputFechaCita.addEventListener("input", revalidarFechaCita);
  inputFechaCita.addEventListener("keyup", revalidarFechaCita);
  inputFechaCita.addEventListener("blur", revalidarFechaCita);

  //enviar formulario de cita
  modalAgregarCita.addEventListener("submit", function (e) {
    e.preventDefault();

    let inputs = this.querySelectorAll(".input-validar");
    console.log(inputs);

    // Debe existir la hora seleccionada (apartada o heredada al editar)
    const horaSeleccionada = this.querySelector('input[name="listHoras"]');

    // El paciente debe estar resuelto (id hasheado real) y el servicio
    // seleccionado: si no, el servidor recibiría identificadores vacíos
    const pacienteResuelto =
      inputIdPaciente.value && inputIdPaciente.value !== "0";
    const servicioSeleccionado =
      selectServicios.value && selectServicios.value !== "0";

    if (
      inputs.length == 2 &&
      verificarFormulario() &&
      fechaValidaParaDoctor &&
      horaSeleccionada &&
      pacienteResuelto &&
      servicioSeleccionado
    ) {
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
