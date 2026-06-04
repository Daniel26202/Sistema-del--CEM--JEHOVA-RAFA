// Variables globales
const { jsPDF } = window.jspdf;

let currentYear, currentMonth;
let events = []; // Estructura: [{ date: 'YYYY-MM-DD', title: '...', recurrent: false }, ...]

const elementoImprimirEspecialidad = document.getElementById("imprimir");
const elementoImprimirSintomas = document.getElementById("imprimirSintomas");

const expresiones = {
  fn1: { expresion: /^\d{4}\-\d{2}\-\d{2}$/, mensajeError: "" },
  fn2: { expresion: /^\d{4}\-\d{2}\-\d{2}$/, mensajeError: "" },

  fechaDeCita: { expresion: /^\d{4}\-\d{2}\-\d{2}$/, mensajeError: "" },
};

// ========================== EVENTOS DOM ==========================

// Inicialización del DOM
document.addEventListener("DOMContentLoaded", function () {
  initCalendar(); // Inicializa el calendario
  traerCitas(); // Carga las citas pendientes
  traerCitashoy(); // Carga las citas del día
  pacientes_hospitalizados(); // Carga los pacientes hospitalizados
  traerDatosServicios(); // Carga los datos de la tabla de precios
  especialidades_chart(
    "/Sistema-del--CEM--JEHOVA-RAFA/Inicio/especialidades_solicitadas",
  ); // Genera el gráfico de especialidades
  sintomas_chart("/Sistema-del--CEM--JEHOVA-RAFA/Inicio/sintomas_comunes"); // Genera el gráfico de sintomas comunes
  traerDoctor(); //Cargar doctores en el select

  //mostrar una aaler si eun poersona no tiene permiso
  if (window.location.href.includes("permiso")) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "No tiene permiso para hacer dicha acción por favor comuníquese con el administrador del sistema",
      customClass: {
        popup: "switAlert",
        confirmButton: "btn-agregarcita-modal",
        cancelButton: "btn-agregarcita-modal-cancelar",
      },
    });
  }
});

///validacion de las estadisticas
//validacioenes de inputs
function inicializarValidacionFormulario(formulario) {
  const campos = {};
  formulario.querySelectorAll(".input-validar").forEach((input) => {
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
}

function validarFormulario(e, formulario, campos) {
  formulario.querySelectorAll(".input-validar").forEach((input, index) => {
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
    console.log(campoCustom);

    campos[nameInput] = validarFecha(
      input,
      arrayElementos,
      nameInput,
      formulario,
    );
  });
}

// Nueva función para validar fechas no futuras ni pasadas
function validarFecha(input, arrayElementos, campo, formulario) {
  let { pError, check, error } = arrayElementos;
  const inputs = formulario.querySelectorAll(".input-validar");
  const valorFecha = new Date(input.value);
  const fechaHoy = new Date();
  // Establece el tiempo a la medianoche para comparación
  fechaHoy.setHours(0, 0, 0, 0);

  pError.classList.add("fw-bold");
  pError.classList.add("p-error-validaciones");

  if (campo == "fn1" || campo == "fn2") {
    actualizarEstadoInput(input, "incorrecto", formulario);
    if (!expresiones.fn1.expresion.test(input.value)) {
      pError.textContent = "La fecha debe tener el formato YYYY-MM-DD.";
      pError.classList.remove("d-none");
      chulitoYX(check, error, "inValido");
      return false;
    }
    if (valorFecha > fechaHoy) {
      pError.textContent = "La fecha no puede ser del futuro.";
      pError.classList.remove("d-none");
      chulitoYX(check, error, "inValido");
      return false;
    }
    if (inputs[0].value >= inputs[1].value) {
      pError.textContent =
        "La fecha de inicio no puede ser mayor a la fecha final";
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

// Función que actualiza el aspecto visual del input según su estado de validación
function actualizarEstadoInput(input, estado) {
  input.parentElement.classList.toggle("valido", estado === "correcto");
  input.parentElement.classList.toggle("invalido", estado === "incorrecto");
}

function chulitoYX(check, error, Validar) {
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

//lamar la funcion para sintomas
inicializarValidacionFormulario(document.getElementById("buscadoresSintomas"));

//llamar funcion para especialidades
inicializarValidacionFormulario(
  document.getElementById("buscadoresEspecialidades"),
);

///filtro

document.getElementById("sintomas").addEventListener("click", function () {
  const inputs =
    this.closest(".modal-content").querySelectorAll(".input-validar");
  if (
    !inputs[0].parentElement.classList.contains("valido") &&
    !inputs[1].parentElement.classList.contains("valido")
  ) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Por favor verifique que todos los datos sean correctos ",
      customClass: {
        popup: "switAlert",
        confirmButton: "btn-agregarcita-modal",
        cancelButton: "btn-agregarcita-modal-cancelar",
      },
    });
    return;
  }

  if (inputs[0].value > inputs[1].value) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Por favor la fecha de inicio no puede ser mayor a la fecha final ",
      customClass: {
        popup: "switAlert",
        confirmButton: "btn-agregarcita-modal",
        cancelButton: "btn-agregarcita-modal-cancelar",
      },
    });
    return;
  }

  sintomas_chart(
    `/Sistema-del--CEM--JEHOVA-RAFA/Inicio/sintomas_comunes_filtrados/${inputs[0].value}/${inputs[1].value}`,
  );

  setTimeout(() => {
  generarReporte(elementoImprimirSintomas, "reporte_sintomas.pdf");
    
  }, 800);

  console.log("hola");
});

document
  .getElementById("especialidades")
  .addEventListener("click", function () {
    console.log("llevo");

    const inputs =
      this.closest(".modal-content").querySelectorAll(".input-validar");
    if (
      !inputs[0].parentElement.classList.contains("valido") &&
      !inputs[1].parentElement.classList.contains("valido")
    ) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Por favor verifique que todos los datos sean correctos ",
        customClass: {
          popup: "switAlert",
          confirmButton: "btn-agregarcita-modal",
          cancelButton: "btn-agregarcita-modal-cancelar",
        },
      });
      return;
    }

    if (inputs[0].value > inputs[1].value) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Por favor la fecha de inicio no puede ser mayor a la fecha final ",
        customClass: {
          popup: "switAlert",
          confirmButton: "btn-agregarcita-modal",
          cancelButton: "btn-agregarcita-modal-cancelar",
        },
      });
      return;
    }

     especialidades_chart(
      `/Sistema-del--CEM--JEHOVA-RAFA/Inicio/especialidades_solicitadas_filtradas/${inputs[0].value}/${inputs[1].value}`,
    );

    setTimeout(() => {
      generarReporte(
        elementoImprimirEspecialidad,
        "reporte_especialidades.pdf",
      );
    }, 800);

    console.log("hola");
  });

///
const convertirHora = (horaMilitar) => {
    // Separamos hora y minutos
    let [horaStr, minutoStr] = horaMilitar.split(":");

    let hora = parseInt(horaStr, 10);
    let minutos = parseInt(minutoStr, 10);

  // Validamos rango
  if (
    isNaN(hora) ||
    isNaN(minutos) ||
    hora < 0 ||
    hora > 23 ||
    minutos < 0 ||
    minutos > 59
  ) {
    return "Hora inválida";
  }

    // Determinamos AM o PM
    let sufijo = hora >= 12 ? "PM" : "AM";

    // Convertimos a formato 12 horas
    let hora12 = hora % 12;
    if (hora12 === 0) {
        hora12 = 12;
    }

    // Aseguramos que los minutos siempre tengan dos dígitos
    let minutosFormateados = minutos.toString().padStart(2, "0");

    return `${hora12}:${minutosFormateados} ${sufijo}`;
};

//validar que el elemento exista

if (document.getElementById("selectDoctor")) {
  //Evento para actualizar la informacion del doctor
  document
    .getElementById("selectDoctor")
    .addEventListener("change", function () {
      let allDates = [];
      document.querySelectorAll(".date").forEach((element) => {
        allDates.push(element.getAttribute("data-date"));
      });

      traerHorarioDoctor(this.value, allDates);
    });
}

// ========================== FUNCIONES DEL CALENDARIO ==========================

// Inicializa el calendario
function initCalendar() {
  const today = new Date();
  currentYear = today.getFullYear();
  currentMonth = today.getMonth();

  // Botones de navegación del calendario
  document
    .getElementById("prev")
    .addEventListener("click", () => changeMonth(-1));
  document
    .getElementById("next")
    .addEventListener("click", () => changeMonth(1));
  document.getElementById("today").addEventListener("click", goToToday);

  // Renderiza el calendario inicial
  renderCalendar(currentYear, currentMonth);
}

// Renderiza el calendario
function renderCalendar(year, month) {
  const calendarBody = document.getElementById("calendar-body");
  calendarBody.innerHTML = ""; // Limpia el contenido previo

  // Configura el encabezado del calendario
  const monthYearLabel = document.getElementById("monthYear");
  const months = [
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre",
  ];
  monthYearLabel.textContent = `${months[month]} ${year}`;

  // Obtiene el primer día del mes y la cantidad de días
  const firstDay = new Date(year, month).getDay();
  const daysInMonth = 32 - new Date(year, month, 32).getDate();

  // Realiza la petición AJAX para obtener los días con mayor carga de trabajo
  fetch(`/Sistema-del--CEM--JEHOVA-RAFA/Inicio/diasConMasCitas`)
    .then((response) => response.json())
    .then((workDays) => {
      // workDays es un array con los días que más trabaja el doctor, por ejemplo: [{ date: "2025-04-05", citas: 10 }, { date: "2025-04-12", citas: 15 }]

      let date = 1;
      for (let i = 0; i < 6; i++) {
        let row = document.createElement("tr"); // Crea una fila
        for (let j = 0; j < 7; j++) {
          let cell = document.createElement("td"); // Crea una celda
          cell.classList.add("date"); //Agregar clase date
          if (i === 0 && j < firstDay) {
            // Celdas vacías antes del inicio del mes
            cell.innerHTML = "";
          } else if (date > daysInMonth) {
            // Detiene el bucle si se excede el número de días del mes
            break;
          } else {
            let cellDate = new Date(year, month, date); // Crea un objeto de fecha para el día actual
            let dateString = formatDate(cellDate); // Formatea la fecha en 'YYYY-MM-DD'

            cell.innerHTML = date; // Muestra el número del día en la celda
            cell.dataset.date = dateString; // Agrega un atributo personalizado con la fecha

            // Busca si el día actual está en el array de días con mayor carga de trabajo
            let workDay = workDays.find((day) => day.date === dateString);
            if (workDay) {
              cell.classList.add("diasOcupados", "text-white"); // Clase para marcar días con mayor carga

              // Agrega un tooltip de Bootstrap con información adicional
              cell.setAttribute("data-bs-toggle", "tooltip"); // Activa el tooltip de Bootstrap
              cell.setAttribute(
                "title",
                `Citas: ${workDay.total_citas}
                DR ${workDay.personal}`, // Muestra el número de citas en el tooltip
              );
            }

            // Doble clic para abrir el modal de eventos
            cell.addEventListener("dblclick", () => openEventModal(dateString));

            date++; // Incrementa el día
          }

          row.appendChild(cell); // Agrega la celda a la fila
        }
        calendarBody.appendChild(row); // Agrega la fila al cuerpo del calendario
      }

      // Inicializa los tooltips de Bootstrap
      const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]'),
      );
      tooltipTriggerList.forEach((tooltipTriggerEl) => {
        new bootstrap.Tooltip(tooltipTriggerEl); // Crea un tooltip para cada elemento con el atributo 'data-bs-toggle="tooltip"'
      });
    })
    .catch((error) => {
      console.error("Error al obtener los días de trabajo:", error); // Maneja errores en la petición
    });
}

// Cambia el mes del calendario
function changeMonth(offset) {
  currentMonth += offset;
  if (currentMonth < 0) {
    currentMonth = 11;
    currentYear--;
  } else if (currentMonth > 11) {
    currentMonth = 0;
    currentYear++;
  }
  renderCalendar(currentYear, currentMonth);
}

// Ir al mes/año actual
function goToToday() {
  const today = new Date();
  currentYear = today.getFullYear();
  currentMonth = today.getMonth();
  renderCalendar(currentYear, currentMonth);
}

// Formatea una fecha en formato 'YYYY-MM-DD'
function formatDate(dateObj) {
  const year = dateObj.getFullYear();
  const month = ("0" + (dateObj.getMonth() + 1)).slice(-2);
  const day = ("0" + dateObj.getDate()).slice(-2);
  return `${year}-${month}-${day}`;
}
// ========================== FUNCIONES DE DATOS ==========================

//Cargar los doctores en el select
const traerDoctor = async () => {
  try {
    let peticion = await fetch(
      "/Sistema-del--CEM--JEHOVA-RAFA/Inicio/retornarDoctores",
    );
    let resultado = await peticion.json();

    if (resultado.length > 0) {
      let html = "<option selected disabled>Seleccionar Doctor</option>";
      resultado.forEach((element) => {
        html += `<option value="${element.id_personal}">${element.nombre_d}  ${element.apellido}</option>`;
      });
      document.getElementById("selectDoctor").innerHTML = html;
    }
  } catch (error) {
    console.log(error);
  }
};

traerHorarioEspecificoDelDr = async (id) => {
  try {
    // Realiza la petición AJAX
    let peticion = await fetch(
      "/Sistema-del--CEM--JEHOVA-RAFA/Inicio/mostrarHorario/" + id,
    );
    let resultado = await peticion.json();

    document.querySelector(".horario-insertar").innerHTML = "";
    let div = document.createElement("div");
    // diaNumero = []; // Reiniciar el arreglo para evitar acumulación de datos previos
    // let diasLaborablesMap = {}; // Mapa para almacenar los días y sus horarios
    if (resultado.length > 0) {
      resultado.forEach((res) => {
        div.innerHTML += `
                <div class="mb-2 " >
                <div class="d-flex text-horario">Día Laborable: <p class="fw-bold text-horario"> ${res.diaslaborables}</p> </div>
              
                <div class="d-flex text-horario">Hora de Entrada: <p class="fw-bold text-horario"> ${convertirHora(
                  res.horaDeEntrada,
                )}</p></div>
                <div class="d-flex text-horario">Hora de Salida: <p class="fw-bold text-horario"> ${convertirHora(
                  res.horaDeSalida,
                )}</p></div>
                </div> 
                `;
      });

      document.getElementById("titulo").innerText = `Horario del Doctor`;
    }

    document.querySelector(".horario-insertar").appendChild(div);
  } catch (error) {
    console.log(error);
  }
};

const traerHorarioDoctor = async (id) => {
  try {
    // Realiza la petición AJAX
    let peticion = await fetch(
      "/Sistema-del--CEM--JEHOVA-RAFA/Inicio/diasConMasCitas/" + id,
    );
    let resultado = await peticion.json();
    console.log(
      resultado,
      "/Sistema-del--CEM--JEHOVA-RAFA/Inicio/diasConMasCitas/" + id,
    );
    //Quitar los dias marcados para marcalos nuevamente
    document.querySelectorAll(".date").forEach((date) => {
      date.classList.remove("diasOcupados");
      date.removeAttribute("data-bs-original-title");
    });
    // Itera sobre las fechas recibidas
    resultado.forEach((res) => {
      // Busca el <td> con el atributo data-date que coincida con la fecha
      const td = document.querySelector(`td[data-date="${res.fecha}"]`);

      if (td) {
        // Si el <td> existe, agrega la clase
        td.classList.add("diasOcupados");
        td.setAttribute("data-bs-toggle", "tooltip"); // Activa el tooltip de Bootstrap
        td.setAttribute(
          "title",
          `Citas: ${res.total_citas}
                DR ${res.personal}`, // Muestra el número de citas en el tooltip
        );
      }
      //Darle el teto al boton del horario
      document.getElementById("btnHorario").innerText =
        `Horario del Dr ${res.personal} especialidad (${res.especialidad})`;

      //Llamar funcion para el horario especifico
      traerHorarioEspecificoDelDr(id);
    });

    //Aparecer el boton del horario cuando seleccione el doctor
    document.getElementById("btnHorario").classList.remove("d-none");
  } catch (error) {
    console.error("Error al traer el horario del doctor:", error);
  }
};

// Carga los datos de la tabla de precios
const traerDatosServicios = async () => {
  try {
    let peticion = await fetch(
      "/Sistema-del--CEM--JEHOVA-RAFA/Inicio/servicios",
    );
    let resultado = await peticion.json();
    const tbody = document.querySelector("#precios tbody");
    tbody.innerHTML = "";

    resultado.forEach((element) => {
      const row = document.createElement("tr");
      row.innerHTML = `<td>${element.categoria}</td><td>${element.precio}</td>`;
      tbody.appendChild(row);
    });

    // Inicializa DataTable
    if ($.fn.DataTable.isDataTable("#precios")) {
      $("#precios").DataTable().destroy();
    }

    $("#precios").DataTable({
      paging: true,
      pageLength: 3,
      searching: true,
      info: false,
      ordering: true,
      lengthChange: false,
      dom: '<"top"f>rt<"bottom"p><"clear">',
      language: {
        decimal: ",",
        thousands: ".",
        zeroRecords: "No se encontraron resultados",
        infoEmpty: "No hay registros disponibles",
        search: "Buscar:",
      },
      columns: [
        { data: "categoria" },
        {
          data: "precio",
          render: function (data, type, row) {
            return data + " BSs";
          },
        },
      ],
    });
  } catch (error) {
    console.log("Error al traer los datos:", error);
  }
};

// Carga las citas pendientes
const traerCitas = async () => {
  try {
    let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Inicio/citas");
    let resultado = await peticion.json();
    document.getElementById("citasPendentes").textContent = resultado.length;
  } catch (error) {
    console.log("Error al traer las citas pendientes:", error);
  }
};

// Carga las citas del día
const traerCitashoy = async () => {
  try {
    let peticion = await fetch(
      "/Sistema-del--CEM--JEHOVA-RAFA/Inicio/citasDeHoy",
    );
    let resultado = await peticion.json();
    document.getElementById("citasDeHoy").textContent = resultado.length;
  } catch (error) {
    console.log("Error al traer las citas de hoy:", error);
  }
};

const pacientes_hospitalizados = async () => {
  try {
    let peticion = await fetch(
      "/Sistema-del--CEM--JEHOVA-RAFA/Inicio/pacientes_hospitalizados",
    );
    let resultado = await peticion.json();
    document.getElementById("pacientes_hospitalizados").textContent =
      resultado.length;
    console.log(resultado);
  } catch (error) {
    console.log("Error al traer los pacientes hospitalizados:", error);
  }
};

// ========================== FUNCIONES DE GRÁFICOS ==========================

// Genera el gráfico de especialidades

let especialidadesChartModal = null;
let especialidadesChart = null;
const especialidades_chart = async (url) => {
  try {
    let especialidades_solicitadas = await fetch(url);
    let data = await especialidades_solicitadas.json();
    console.log(url, data);

    if (data.length > 0) {
      //Quitarle lo oculto a los graficos
      document
        .getElementById("especialidades_solicitadas")
        .classList.remove("d-none");
      document
        .getElementById("especialidades_solicitadas_pdf")
        .classList.remove("d-none");

      let especialidades = data.map((item) => item.especialidad);
      let totalSolicitudes = data.map((item) => item.total_solicitudes);
      generarLeyendaEspecialidades(especialidades, totalSolicitudes); // Genera la leyenda de especialidades
      let ctx = document
        .getElementById("especialidades_solicitadas")
        .getContext("2d");
      if (especialidadesChart) {
        especialidadesChart.destroy();
      }

      // Evaluamos el color inicial leyendo tu localStorage directamente
      let colorTextoInicial =
        localStorage.getItem("theme") === "dark" ? "#e0e1dd" : "#1b1a1a";
      especialidadesChart = new Chart(ctx, {
        type: "pie",
        data: {
          labels: especialidades,
          datasets: [
            {
              data: totalSolicitudes,
              backgroundColor: [
                "#387adf",
                "#78a0f0",
                "#a4c7ff",
                "#ffcc00",
                "#ff6666",
              ],
            },
          ],
        },
        options: {
          responsive: true, // 👈 CAMBIO CLAVE: Permite que el gráfico se adapte al ancho de la tarjeta
          maintainAspectRatio: true, // 👈 Mantiene la proporción circular perfecta del pastel
          plugins: {
            legend: {
              display: true, // Tu leyenda nativa activa
              position: "bottom", // Abajo para optimizar el espacio vertical
              align: "center",
              labels: {
                color: colorTextoInicial,
                boxWidth: 12, // Reducimos un poco el cuadro de color para ganar espacio
                padding: 10, // Ajustamos el espaciado para que no empuje el gráfico hacia afuera
                font: {
                  size: 12, // 12px es ideal para que quepa en pantallas medianas/pequeñas
                  weight: "bold",
                },
              },
            },
          },
        },
      });

      // Renderiza el gráfico en el canvas del modal
      let ctxModal = document
        .getElementById("especialidades_solicitadas_pdf")
        .getContext("2d");

      // Destruye el gráfico existente en el modal si ya fue creado
      if (especialidadesChartModal) {
        especialidadesChartModal.destroy();
      }

      // Crea un nuevo gráfico para el modal y lo asigna a una variable global
      especialidadesChartModal = new Chart(ctxModal, {
        type: "pie",
        data: {
          labels: especialidades,
          datasets: [
            {
              data: totalSolicitudes,
              backgroundColor: [
                "#387adf",
                "#78a0f0",
                "#a4c7ff",
                "#ffcc00",
                "#ff6666",
              ],
            },
          ],
        },
        options: {
          responsive: false,
          plugins: {
            legend: {
              display: false, // La leyenda se genera manualmente
            },
          },
        },
      });
      //Aparecer el boton de impirmir
      document.getElementById("especialidades").classList.remove("d-none");
      //Aparecer el escrito

      totalDeEspecialidades(data);
      document
        .querySelectorAll("#texto p")
        .forEach((ele) => ele.classList.remove("d-none"));

      document.querySelector(".alert-no-encontrado").classList.add("d-none");
    } else {
      document.querySelector(".alert-no-encontrado").classList.remove("d-none");
      //Vaciando todos los elementos si no hay datos para relizar la grafica
      document
        .getElementById("especialidades_solicitadas")
        .classList.add("d-none");
      document
        .getElementById("especialidades_solicitadas_pdf")
        .classList.add("d-none");
      document.querySelector(".leyenda-container").innerHTML = "";
      document
        .querySelectorAll("#texto p")
        .forEach((ele) => ele.classList.add("d-none"));
      document.getElementById("especialidades").classList.add("d-none");
    }
  } catch (error) {
    console.log("Error al generar el gráfico de especialidades:", error);
  }
};

async function totalDeEspecialidades(data) {
  let peticion = await fetch(
    "/Sistema-del--CEM--JEHOVA-RAFA/Inicio/todas_las_especialidades",
  );
  let resultado = await peticion.json();
  document.getElementById("texto").innerHTML = ``;

  let especialidades = data.map((item) => item.especialidad).join(",  ");

  // Agrega esto al texto
  document.getElementById("texto").innerHTML += `
    <p>De las ${resultado.total_servicios_por_cita} especialidades médicas, las ${data.length} más solicitadas son: ${especialidades}.</p>
    <p>Este reporte analiza la distribución y tendencias de las especialidades médicas más solicitadas según la moda en un período determinado</p>
    <p>El gráfico de pastel muestra la distribución porcentual de cada especialidad solicitada, identificando las áreas de mayor demanda.</p>
    `;
}

//Genera el grafico de sintomas comunes
let sintomasChartModal = null;
let sintomasChart = null;
const sintomas_chart = async (url) => {
  let sintomas_comunes = await fetch(url);
  let data = await sintomas_comunes.json();

  if (data.length > 0) {
    //Quitarle lo oculto a los graficos
    document.getElementById("sintomas_comunes").classList.remove("d-none");
    document
      .getElementById("sintomas_solicitadas_pdf")
      .classList.remove("d-none");
    let sintomas = data.map((item) => item.sintoma);
    let total = data.map((item) => item.total);

    // Generar el primer gráfico (ctx)
    let ctx = document.getElementById("sintomas_comunes").getContext("2d");
    if (sintomasChart) {
      sintomasChart.destroy();
    }

    // Evaluamos el color inicial leyendo tu localStorage directamente
    let colorTextoInicial =
      localStorage.getItem("theme") === "dark" ? "#e0e1dd" : "#1b1a1a";

    sintomasChart = new Chart(ctx, {
      type: "pie",
      data: {
        labels: sintomas,
        datasets: [
          {
            data: total,
            backgroundColor: [
              "#387adf",
              "#78a0f0",
              "#a4c7ff",
              "#ffcc00",
              "#ff6666",
            ],
          },
        ],
      }, // En esta línea se cierra data correctamente
      options: {
        // Solución estructural: options va afuera del objeto data
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          legend: {
            display: true, // Tu leyenda nativa activa
            position: "bottom", // Abajo para optimizar el espacio vertical dentro de la caja
            align: "center",
            labels: {
              color: colorTextoInicial,
              boxWidth: 12, // Reducimos un poco el cuadro de color para ganar espacio
              padding: 10, // Ajustamos el espaciado interno
              font: {
                size: 12, // 12px es ideal para que no se desborde la tarjeta
                weight: "bold",
              },
            },
          },
        },
      },
    });

    // Verificar que el canvas del modal exista
    let canvasModal = document.getElementById("sintomas_solicitadas_pdf");
    if (!canvasModal) {
      console.error(
        "El canvas 'sintomas_solicitadas_pdf' no existe en el DOM.",
      );
      return;
    }

    // Asegurarse de que el canvas no esté oculto
    canvasModal.classList.remove("d-none");

    // Obtener el contexto del canvas del modal
    let ctxModal = canvasModal.getContext("2d");

    // Destruir el gráfico existente en el modal antes de crear uno nuevo
    if (sintomasChartModal) {
      sintomasChartModal.destroy();
    }

    // Crear el nuevo gráfico para el modal
    sintomasChartModal = new Chart(ctxModal, {
      type: "pie",
      data: {
        labels: sintomas,
        datasets: [
          {
            data: total,
            backgroundColor: [
              "#387adf",
              "#78a0f0",
              "#a4c7ff",
              "#ffcc00",
              "#ff6666",
            ],
          },
        ],
      },
      options: {
        responsive: false,
        plugins: {
          legend: {
            display: false,
          },
        },
      },
    });

    generarLeyendaSintomas(sintomas, total); // genera la leyenda de síntomas

    totalDeSintomas(data);

    //Aparecer el boton de impirmir
    document.getElementById("textoSintomas").classList.remove("d-none");
    //Aparecer el escrito

    document
      .querySelectorAll("#textoSintomas p")
      .forEach((ele) => ele.classList.remove("d-none"));
    document.querySelector(".alert-no-encontrado-s").classList.add("d-none");
  } else {
    document.querySelector(".alert-no-encontrado-s").classList.remove("d-none");

    //Vaciando todos los elementos si no hay datos para relizar la grafica
    document.getElementById("sintomas_comunes").classList.add("d-none");
    document.getElementById("sintomas_solicitadas_pdf").classList.add("d-none");
    document.querySelector(".leyenda-container").innerHTML = "";
    document
      .querySelectorAll("#textoSintomas p")
      .forEach((ele) => ele.classList.add("d-none"));
    document.getElementById("sintomas").classList.add("d-none");
  }
};

async function totalDeSintomas(data) {
  let peticion = await fetch(
    "/Sistema-del--CEM--JEHOVA-RAFA/Inicio/todos_los_sintomas",
  );
  let resultado = await peticion.json();
  document.getElementById("textoSintomas").innerHTML = ``;

  let sintomas = data.map((item) => item.sintoma).join(",  ");

  // Agrega esto al texto
  document.getElementById("textoSintomas").innerHTML += `
    <p>De Los ${resultado.total} sintomas registados, los ${data.length}  síntomas registrados, los mas comunes son: ${sintomas}.</p>
    <p>Este reporte examina la distribución y las tendencias de los síntomas más comunes según su frecuencia en un periodo determinado.</p>
                        <p>El gráfico de pastel muestra el porcentaje que representa cada uno de estos síntomas dentro del total de consultas, permitiendo identificar rápidamente cuáles son las manifestaciones clínicas que más demanda generan en la población atendida..</p>

`;
}

function generarLeyendaEspecialidades(especialidades, totalSolicitudes) {
  // Selecciona el contenedor donde se mostrará la leyenda
  const contenedorLeyenda = document.querySelector(".leyenda-container");

  // Limpia cualquier contenido previo en el contenedor
  contenedorLeyenda.innerHTML = "";

  // Calcula el total de solicitudes para obtener los porcentajes
  const totalSolicitudesGlobal = totalSolicitudes.reduce(
    (acumulado, actual) => acumulado + actual,
    0,
  );

  // Recorre cada especialidad y genera un elemento de leyenda
  especialidades.forEach((especialidad, indice) => {
    // Calcula el porcentaje de solicitudes para esta especialidad
    const porcentaje = (
      (totalSolicitudes[indice] / totalSolicitudesGlobal) *
      100
    ).toFixed(1);

    // Crea el contenedor principal para el elemento de la leyenda
    const elementoLeyenda = document.createElement("div");
    elementoLeyenda.style.display = "flex";
    elementoLeyenda.style.alignItems = "center";
    elementoLeyenda.style.margin = "5px 0";

    // Crea el cuadro de color que representa la especialidad
    const cuadroColor = document.createElement("div");
    cuadroColor.style.width = "20px";
    cuadroColor.style.height = "20px";
    cuadroColor.style.backgroundColor = [
      "#387adf",
      "#78a0f0",
      "#a4c7ff",
      "#ffcc00",
      "#ff6666",
    ][indice % 5]; // Selecciona un color basado en el índice
    cuadroColor.style.marginRight = "10px";
    cuadroColor.style.borderRadius = "3px";

    // Crea el texto descriptivo para la especialidad
    const textoLeyenda = document.createElement("h5");
    textoLeyenda.innerHTML = `
      ${especialidad}:
      ${totalSolicitudes[indice]} solicitudes (${porcentaje}%)
    `;
    textoLeyenda.style.fontSize = "14px";

    // Agrega el cuadro de color y el texto al contenedor principal
    elementoLeyenda.appendChild(cuadroColor);
    elementoLeyenda.appendChild(textoLeyenda);

    // Agrega el elemento de la leyenda al contenedor principal de la leyenda
    contenedorLeyenda.appendChild(elementoLeyenda);
  });
}

function generarLeyendaSintomas(sintomas, total) {
  // Selecciona el contenedor donde se mostrará la leyenda de síntomas
  const contenedorLeyenda = document.querySelector(
    ".leyenda-sintomas-container",
  );
  if (!contenedorLeyenda) return;

  // Limpia cualquier contenido previo en el contenedor
  contenedorLeyenda.innerHTML = "";

  // Calcula el total de síntomas para obtener los porcentajes
  const totalGlobal = total.reduce(
    (acumulado, actual) => acumulado + actual,
    0,
  );

  // Colores para los síntomas (igual que en el gráfico)
  const colores = ["#387adf", "#78a0f0", "#a4c7ff", "#ffcc00", "#ff6666"];

  // Recorre cada síntoma y genera un elemento de leyenda
  sintomas.forEach((sintoma, indice) => {
    const porcentaje = ((total[indice] / totalGlobal) * 100).toFixed(1);

    // Contenedor principal del elemento de la leyenda
    const elementoLeyenda = document.createElement("div");
    elementoLeyenda.style.display = "flex";
    elementoLeyenda.style.alignItems = "center";
    elementoLeyenda.style.margin = "5px 0";

    // Cuadro de color
    const cuadroColor = document.createElement("div");
    cuadroColor.style.width = "20px";
    cuadroColor.style.height = "20px";
    cuadroColor.style.backgroundColor = colores[indice % colores.length];
    cuadroColor.style.marginRight = "10px";
    cuadroColor.style.borderRadius = "3px";

    // Texto descriptivo
    const textoLeyenda = document.createElement("h5");
    textoLeyenda.innerHTML = `
      ${sintoma}: ${total[indice]} casos (${porcentaje}%)
    `;
    textoLeyenda.style.fontSize = "14px";

    elementoLeyenda.appendChild(cuadroColor);
    elementoLeyenda.appendChild(textoLeyenda);

    contenedorLeyenda.appendChild(elementoLeyenda);
  });
}

function generarReporte(elementoImprimir, nombreArchivo) {
  // Buscar el elemento del DOM

  if (!elementoImprimir) {
    console.error("El elemento con ID 'imprimir' no existe.");
    return;
  }

  // Modificar los canvas dentro del elemento
  const canvasElements = elementoImprimir.querySelectorAll("canvas");

  canvasElements.forEach((canvas) => {
    const ctx = canvas.getContext("2d");
    ctx.globalCompositeOperation = "destination-over";
    canvas.classList.add("contenido");
    const bgColor = getComputedStyle(canvas).backgroundColor;
    ctx.fillStyle = bgColor;
    ctx.fillRect(0, 0, canvas.width, canvas.height);
  });

  // Obtener color de fondo desde la clase CSS
  const estilo = getComputedStyle(document.querySelectorAll(".contenido")[0]);
  const bgColor = estilo.backgroundColor;

  // Crear instancia de jsPDF
  const pdf = new jsPDF("p", "mm", "a4");

  // Convirtiendo el formato jsPDF (r, g, b)
  const rgbMatch = bgColor.match(/\d+/g);
  const r = rgbMatch ? parseInt(rgbMatch[0]) : 255;
  const g = rgbMatch ? parseInt(rgbMatch[1]) : 255;
  const b = rgbMatch ? parseInt(rgbMatch[2]) : 255;

  // Se establecer el color de fondo
  pdf.setFillColor(r, g, b);
  pdf.rect(
    0,
    0,
    pdf.internal.pageSize.getWidth(),
    pdf.internal.pageSize.getHeight(),
    "F",
  ); // "F" para rellenar

  elementoImprimir.classList.add("carta-imprimir");

  // Generar PDF con fondo adecuado
  pdf.html(elementoImprimir, {
    callback: function (doc) {
      doc.save(nombreArchivo || "reporte.pdf");
    },
    x: 0,
    y: 0,
    width: pdf.internal.pageSize.getWidth(), // Ajuste al ancho de la página
    height: pdf.internal.pageSize.getHeight(), // Ajuste a la altura de la página
    scaleFactor: 2,
    windowWidth: elementoImprimir.scrollWidth,
  });
  elementoImprimir.classList.remove("carta-imprimir");
}

///resetear modal y estadistica
document.getElementById("reporte").addEventListener("hidden.bs.modal", () => {
  const inputs = document
    .getElementById("buscadoresEspecialidades")
    .querySelectorAll(".input-validar");
  inputs.forEach((input) => {
    let campoCustom = input.closest(".campo-custom");
    let spamP = campoCustom.querySelector(".icono-der");
    let check = spamP.children[0];
    let error = spamP.children[1];

    input.value = "";
    input.parentElement.classList.remove("invalido", "valido");
    let pError = campoCustom.querySelector("p");
    pError.classList.add("d-none");

    if (check && error) {
      check.classList.add("d-none");
      error.classList.add("d-none");
    }
  });
  //   alertFechaEsp.classList.add("d-none");
  especialidades_chart(
    `/Sistema-del--CEM--JEHOVA-RAFA/Inicio/especialidades_solicitadas`,
  );
});

document
  .getElementById("reporteSintomas")
  .addEventListener("hidden.bs.modal", () => {
    const inputs = document
      .getElementById("buscadoresSintomas")
      .querySelectorAll(".input-validar");
    inputs.forEach((input) => {
      let campoCustom = input.closest(".campo-custom");
      let spamP = campoCustom.querySelector(".icono-der");
      let check = spamP.children[0];
      let error = spamP.children[1];

      input.value = "";
      input.parentElement.classList.remove("invalido", "valido");
      let pError = campoCustom.querySelector("p");
      pError.classList.add("d-none");

      if (check && error) {
        check.classList.add("d-none");
        error.classList.add("d-none");
      }
    });
    //   alertFechaEsp.classList.add("d-none");

    sintomas_chart("/Sistema-del--CEM--JEHOVA-RAFA/Inicio/sintomas_comunes");
  });


  // Escuchar el evento que creamos en el Paso 1
window.addEventListener("themeChanged", () => {
  // Determinamos el nuevo color
  const nuevoColor =
    localStorage.getItem("theme") === "dark" ? "#e0e1dd" : "#1b1a1a";

  // Si el gráfico principal existe, cambiar color y actualizar en caliente
  if (especialidadesChart) {
    especialidadesChart.options.plugins.legend.labels.color = nuevoColor;
    especialidadesChart.update();
  }

  // Si el gráfico del modal existe, hacer lo mismo
  if (especialidadesChartModal) {
    especialidadesChartModal.options.plugins.legend.labels.color = nuevoColor;
    especialidadesChartModal.update();
  }

  // --- Actualizar Síntomas ---
  if (sintomasChart) {
    sintomasChart.options.plugins.legend.labels.color = nuevoColor;
    sintomasChart.update();
  }
});