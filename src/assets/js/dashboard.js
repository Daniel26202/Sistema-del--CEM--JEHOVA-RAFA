// Variables globales
let currentYear, currentMonth;
let events = []; // Estructura: [{ date: 'YYYY-MM-DD', title: '...', recurrent: false }, ...]

// ========================== EVENTOS DOM ==========================

// Inicialización del DOM
document.addEventListener("DOMContentLoaded", function () {
  initCalendar(); // Inicializa el calendario
  traerCitas(); // Carga las citas pendientes
  traerCitashoy(); // Carga las citas del día
  pacientes_hospitalizados(); // Carga los pacientes hospitalizados
  traerDatosServicios(); // Carga los datos de la tabla de precios
  especialidades_chart(); // Genera el gráfico de especialidades
  sintomas_chart(); // Genera el gráfico de sintomas comunes
});

document
  .getElementById("especialidades")
  .addEventListener("click", generarReporte);
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
      "/Sistema-del--CEM--JEHOVA-RAFA/Inicio/citasDeHoy"
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
      "/Sistema-del--CEM--JEHOVA-RAFA/Inicio/pacientes_hospitalizados"
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
        options: {
          responsive: false, // Importante para que respete las dimensiones del canvas
        },
      },
    });
  } catch (error) {
    console.log("Error al generar el gráfico de especialidades:", error);
  }
  //Genera el grafico de sintomas comunes
};

const sintomas_chart = async () => {
  try {
    let sintomas_comunes = await fetch(
      "/Sistema-del--CEM--JEHOVA-RAFA/Inicio/sintomas_comunes"
    );
    let data = await sintomas_comunes.json();
    let sintomas = data.map((item) => item.sintoma);
    let total = data.map((item) => item.total);

    let ctx = document.getElementById("sintomas_comunes").getContext("2d");
    new Chart(ctx, {
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
    });
  } catch (error) {
    console.log("Error al generar el gráfico de especialidades:", error);
  }
};

function generarReporte() {
  const imagenBase64 = document
    .getElementById("especialidades_solicitadas")
    .toDataURL("image/png");

  // Puedes calcular aquí o tener ya calculados los datos estadísticos (p.ej., moda, media)
  const descripcion =
    "El gráfico muestra los servicios más solicitados. La moda es el servicio de color Naranja, siendo el más frecuente.";

  fetch("/Sistema-del--CEM--JEHOVA-RAFA/Inicio/exportar_pdf", {
    // Actualiza con la ruta correcta de tu endpoint
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      imagen: imagenBase64,
      descripcion: descripcion,
    }),
  })
    .then((response) => response.blob())
    .then((blob) => {
      const url = URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.href = url;
      a.download = "reporte_servicios_mas_solicitados.pdf";
      a.click();
    })
    .catch((error) => console.error("Error generando el reporte:", error));
}
