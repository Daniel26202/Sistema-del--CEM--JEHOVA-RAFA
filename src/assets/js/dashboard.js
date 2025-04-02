// Variables globales
let currentYear, currentMonth;
let events = []; // Estructura: [{ date: 'YYYY-MM-DD', title: '...', recurrent: false }, ...]
// ========================== EVENTOS DOM ==========================

// Inicialización del DOM
document.addEventListener("DOMContentLoaded", function () {
  initCalendar(); // Inicializa el calendario
  traerCitas(); // Carga las citas pendientes
  traerCitashoy(); // Carga las citas del día
  traerDatosServicios(); // Carga los datos de la tabla de precios
  especialidades_chart(); // Genera el gráfico de especialidades
});

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

  renderCalendar(currentYear, currentMonth); // Renderiza el calendario inicial
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

  let date = 1;
  for (let i = 0; i < 6; i++) {
    let row = document.createElement("tr"); // Crea una fila
    for (let j = 0; j < 7; j++) {
      let cell = document.createElement("td");
      if (i === 0 && j < firstDay) {
        cell.innerHTML = ""; // Celdas vacías antes del inicio del mes
      } else if (date > daysInMonth) {
        break;
      } else {
        let cellDate = new Date(year, month, date);
        let dateString = formatDate(cellDate); // Formato 'YYYY-MM-DD'

        cell.innerHTML = date;
        cell.dataset.date = dateString;

        // Doble clic para abrir el modal de eventos
        cell.addEventListener("dblclick", () => openEventModal(dateString));

        // Si hay un evento en este día, aplica estilos
        let eventToday = events.find((e) => e.date === dateString);
        if (eventToday) {
          cell.classList.add("bg-info", "text-white");
        }

        date++;
      }
      row.appendChild(cell);
    }
    calendarBody.appendChild(row);
  }
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

// ========================== FUNCIONES DE EVENTOS ==========================

// Abre el modal para agregar/editar un evento
function openEventModal(dateString) {
  document.getElementById("eventDate").value = dateString;

  // Verifica si ya existe un evento para esta fecha
  let existingEvent = events.find((e) => e.date === dateString);
  if (existingEvent) {
    document.getElementById("eventTitle").value = existingEvent.title;
    document.getElementById("recurrentCheckbox").checked =
      existingEvent.recurrent || false;
  } else {
    // Limpia los campos
    document.getElementById("eventTitle").value = "";
    document.getElementById("recurrentCheckbox").checked = false;
  }

  // Muestra el modal (usando Bootstrap 4)
  $("#eventModal").modal("show");
}

// Guarda un evento
function saveEvent(e) {
  e.preventDefault();
  const title = document.getElementById("eventTitle").value;
  const dateString = document.getElementById("eventDate").value;
  const recurrent = document.getElementById("recurrentCheckbox").checked;

  // Verifica si ya existe un evento para esta fecha
  let existingEvent = events.find((e) => e.date === dateString);
  if (existingEvent) {
    existingEvent.title = title;
    existingEvent.recurrent = recurrent;
  } else {
    events.push({ date: dateString, title, recurrent });
  }

  // Oculta el modal y actualiza el calendario
  $("#eventModal").modal("hide");
  renderCalendar(currentYear, currentMonth);
}

// Elimina un evento
function deleteEvent() {
  const dateString = document.getElementById("eventDate").value;
  events = events.filter((e) => e.date !== dateString);

  // Oculta el modal y actualiza el calendario
  $("#eventModal").modal("hide");
  renderCalendar(currentYear, currentMonth);
}

// ========================== FUNCIONES DE DATOS ==========================

// Carga los datos de la tabla de precios
const traerDatosServicios = async () => {
  try {
    let peticion = await fetch(
      "/Sistema-del--CEM--JEHOVA-RAFA/Inicio/servicios"
    );
    let resultado = await peticion.json();
    console.log(resultado);
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
      "/Sistema-del--CEM--JEHOVA-RAFA/Inicio/citasDeHoy"
    );
    let resultado = await peticion.json();
    document.getElementById("citasDeHoy").textContent = resultado.length;
  } catch (error) {
    console.log("Error al traer las citas de hoy:", error);
  }
};

// ========================== FUNCIONES DE GRÁFICOS ==========================

// Genera el gráfico de especialidades
const especialidades_chart = async () => {
  try {
    let especialidades_solicitadas = await fetch(
      "/Sistema-del--CEM--JEHOVA-RAFA/Inicio/especialidades_solicitadas"
    );
    let data = await especialidades_solicitadas.json();
    let especialidades = data.map((item) => item.especialidad);
    let totalSolicitudes = data.map((item) => item.total_solicitudes);

    let ctx = document
      .getElementById("especialidades_solicitadas")
      .getContext("2d");
    new Chart(ctx, {
      type: "doughnut",
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
    });
  } catch (error) {
    console.log("Error al generar el gráfico de especialidades:", error);
  }
};
