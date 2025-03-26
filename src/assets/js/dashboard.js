let currentYear, currentMonth;
let events = []; // Estructura: [{ date: 'YYYY-MM-DD', title: '...', recurrent: false }, ...]
document.addEventListener("DOMContentLoaded", initCalendar);
function initCalendar() {
  const today = new Date();
  currentYear = today.getFullYear();
  currentMonth = today.getMonth();

  // Botones de navegación
  document
    .getElementById("prev")
    .addEventListener("click", () => changeMonth(-1));
  document
    .getElementById("next")
    .addEventListener("click", () => changeMonth(1));
  document.getElementById("today").addEventListener("click", goToToday);

  // Manejo de formulario en modal
  document.getElementById("eventForm").addEventListener("submit", saveEvent);
  document.getElementById("deleteEvent").addEventListener("click", deleteEvent);

  // Cargar eventos (desde DB o LocalStorage)
  // loadEventsFromDB(); // Ejemplo

  renderCalendar(currentYear, currentMonth);
}

// Generar calendario
function renderCalendar(year, month) {
  const calendarBody = document.getElementById("calendar-body");
  calendarBody.innerHTML = "";

  // Establecer mes y año en header
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

  // Obtener día de la semana del 1er día
  const firstDay = new Date(year, month).getDay();
  // Obtener cantidad de días del mes
  const daysInMonth = 32 - new Date(year, month, 32).getDate();

  let date = 1;
  for (let i = 0; i < 6; i++) {
    // Creamos fila
    let row = document.createElement("tr");
    for (let j = 0; j < 7; j++) {
      let cell = document.createElement("td");
      if (i === 0 && j < firstDay) {
        // Celdas vacías antes de iniciar el mes
        cell.innerHTML = "";
      } else if (date > daysInMonth) {
        break;
      } else {
        let cellDate = new Date(year, month, date);
        let dateString = formatDate(cellDate); // 'YYYY-MM-DD'

        cell.innerHTML = date;
        cell.dataset.date = dateString;
        // Manejo de doble click para abrir modal
        cell.addEventListener("dblclick", () => openEventModal(dateString));

        // Si hay evento guardado en este día
        let eventToday = events.find((e) => e.date === dateString);
        if (eventToday) {
          cell.classList.add("bg-info", "text-white"); // Ejemplo
        }

        date++;
      }
      row.appendChild(cell);
    }
    calendarBody.appendChild(row);
  }
}

// Cambiar de mes
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

// Formatear fecha a 'YYYY-MM-DD'
function formatDate(dateObj) {
  const year = dateObj.getFullYear();
  const month = ("0" + (dateObj.getMonth() + 1)).slice(-2);
  const day = ("0" + dateObj.getDate()).slice(-2);
  return `${year}-${month}-${day}`;
}

// Abrir modal para agregar/editar evento
function openEventModal(dateString) {
  document.getElementById("eventDate").value = dateString;
  // Ver si hay un evento ya registrado
  let existingEvent = events.find((e) => e.date === dateString);
  if (existingEvent) {
    document.getElementById("eventTitle").value = existingEvent.title;
    document.getElementById("recurrentCheckbox").checked =
      existingEvent.recurrent || false;
  } else {
    // Limpia campos
    document.getElementById("eventTitle").value = "";
    document.getElementById("recurrentCheckbox").checked = false;
  }
  // Mostrar modal (usando Bootstrap 4)
  $("#eventModal").modal("show");
}

// Guardar evento
function saveEvent(e) {
  e.preventDefault();
  const title = document.getElementById("eventTitle").value;
  const dateString = document.getElementById("eventDate").value;
  const recurrent = document.getElementById("recurrentCheckbox").checked;

  // Ver si ya existe un evento para esa fecha
  let existingEvent = events.find((e) => e.date === dateString);
  if (existingEvent) {
    existingEvent.title = title;
    existingEvent.recurrent = recurrent;
  } else {
    events.push({ date: dateString, title, recurrent });
  }

  // Guardar en DB o LocalStorage
  // saveEventsToDB();

  $("#eventModal").modal("hide");
  renderCalendar(currentYear, currentMonth);
}

// Eliminar evento
function deleteEvent() {
  const dateString = document.getElementById("eventDate").value;
  events = events.filter((e) => e.date !== dateString);

  // Eliminar de DB o LocalStorage
  // deleteEventFromDB();

  $("#eventModal").modal("hide");
  renderCalendar(currentYear, currentMonth);
}

document.addEventListener("DOMContentLoaded", function () {
  let ctx = document.getElementById("chartFluids").getContext("2d");
  new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: ["Intracellular", "Extracellular", "Other"],
      datasets: [
        {
          data: [50, 30, 20],
          backgroundColor: ["#387adf", "#78a0f0", "#a4c7ff"],
        },
      ],
    },
  });
});
