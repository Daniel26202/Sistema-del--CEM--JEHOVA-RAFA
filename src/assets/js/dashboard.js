// Variables globales
/* const { jsPDF } = window.jspdf;
 */
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
  traerDoctor(); //Cargar doctores en el select
});

document
  .getElementById("especialidades")
  .addEventListener("click", generarReporte);

//Evento para actualizar la informacion del doctor
document.getElementById("selectDoctor").addEventListener("change", function () {
  let allDates = [];
  document.querySelectorAll(".date").forEach((element) => {
    allDates.push(element.getAttribute("data-date"));
    //console.log(date)
  });

  traerHorarioDoctor(this.value, allDates);
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
                DR ${workDay.personal}` // Muestra el número de citas en el tooltip
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
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
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
      "/Sistema-del--CEM--JEHOVA-RAFA/Inicio/retornarDoctores"
    );
    let resultado = await peticion.json();

    if (resultado.length > 0) {
      let html = "<option selected disabled>Sellccionar Doctor</option>";
      resultado.forEach((element) => {
        html += `<option value="${element.id_personal}">${element.nombre_d}  ${element.apellido}</option>`;
      });
      console.log(html);
      document.getElementById("selectDoctor").innerHTML = html;
      console.log(resultado);
    }
  } catch (error) {
    console.log(error);
  }
};

const traerHorarioDoctor = async (id) => {
  try {
    // Realiza la petición AJAX
    let peticion = await fetch(
      "/Sistema-del--CEM--JEHOVA-RAFA/Inicio/diasConMasCitas/" + id
    );
    let resultado = await peticion.json(); 
    //Quitar los dias marcados para marcalos nuevamente
    document.querySelectorAll(".date").forEach(date =>{
      date.classList.remove("diasOcupados")
      date.removeAttribute("data-bs-original-title");
    })
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
                DR ${res.personal}` // Muestra el número de citas en el tooltip
        );
      } 
    });
  } catch (error) {
    console.error("Error al traer el horario del doctor:", error);
  }
};

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

const especialidades_chart_pdf = async () => {
  try {
    let especialidades_solicitadas_pdf = await fetch(
      "/Sistema-del--CEM--JEHOVA-RAFA/Inicio/especialidades_solicitadas"
    );
    let data = await especialidades_solicitadas_pdf.json();
    let especialidades = data.map((item) => item.especialidad);
    let totalSolicitudes = data.map((item) => item.total_solicitudes);

    let ctx = document
      .getElementById("especialidades_solicitadas_pdf")
      .getContext("2d");
    new Chart(ctx, {
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
        options: {
          responsive: false,
          plugins: {
            legend: {
              display: false, // La leyenda la haremos nosotros con jsPDF
            },
          },
        },
      },
    });
  } catch (error) {
    console.log("Error al generar el gráfico de especialidades:", error);
  }
  //Genera el grafico de sintomas comunes
};

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
        options: {
          responsive: false,
          plugins: {
            legend: {
              display: false, // La leyenda la haremos nosotros con jsPDF
            },
          },
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
/* 

async function generarReporte() {
  // 1. Elimina el contenido previo si existe
  const existente = document.getElementById("reporte_pdf");
  if (existente) existente.remove();

  // 2. Crea el contenedor del reporte
  const contenedor = document.createElement("div");
  contenedor.id = "reporte_pdf";
  contenedor.style.width = "800px";
  contenedor.style.margin = "0 auto";
  contenedor.style.backgroundColor = "white";
  contenedor.style.fontFamily = "Arial, sans-serif";
  contenedor.innerHTML = `
    <div class="imprimir" id="imprimir">
      <div class="cabecera" style="display:flex; justify-content: space-between; background-color: #397ae0; color: white; padding: 10px;">
        <div class="icon">
          <img
            src="assets/icons/logo2.png"
            alt="Logo"
            class="logo"
            style="width: 290px; height: 100px; margin-left: 20px;"
          />
        </div>
        <div id="fecha" style="display: flex; align-items: center; padding-right: 20px;">
          ${new Date().toLocaleDateString()}
        </div>
      </div>
      <div class="contenido" style="display: flex; flex-direction: column; align-items: center; padding: 20px;">
        <div class="titulo" id="titulo">
          <h1>Reporte de Inventario</h1>
        </div>
        <div class="canva" style="margin: 20px 0;">
          <canvas id="especialidades_solicitadas_pdf" width="400" height="400"></canvas>
        </div>
        <div class="texto" id="texto" style="width: 90%; text-align: justify; font-size: 14px;">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </div>
      </div>
    </div>
  `;

  document.body.appendChild(contenedor);

  // 3. Espera a que el gráfico se genere
  await especialidades_chart_pdf();

  // 4. Espera un instante para asegurar que el canvas esté pintado
  setTimeout(async () => {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF("p", "pt", "a4");
    await pdf.html(contenedor, {
      callback: function (doc) {
        doc.save("reporte_sintomas.pdf");
      },
      x: 10,
      y: 10,
      html2canvas: {
        scale: 0.8,
        useCORS: true,
      },
    });
  }, 800); // Puedes aumentar este delay si el canvas tarda en renderizar
}
 */

async function generarReporte() {
  // 1) Obtener el canvas de Chart.js y convertirlo en imagen Base64
  const chartCanvas = document.getElementById("especialidades_solicitadas");
  if (!chartCanvas) {
    console.error("No encontré el canvas de Chart.js");
    return;
  }
  const chartImage = chartCanvas.toDataURL("image/png");

  // 2) Configurar y crear el PDF
  //    - "pt" usa puntos (1/72") para unidades
  const pdf = new jsPDF("p", "pt", "a4");
  const pageWidth = pdf.internal.pageSize.getWidth();
  const margin = 40;

  // 3) Encabezado con título centrado y fecha a la derecha
  pdf.setFontSize(18);
  pdf.setFont("helvetica", "bold");
  pdf.text("Reporte: Especialidades más Solicitadas", pageWidth / 2, 40, {
    align: "center",
  });

  pdf.setFontSize(10);
  pdf.setFont("helvetica", "normal");
  const fecha = new Date().toLocaleDateString();
  pdf.text(fecha, pageWidth - margin, 20, { align: "right" });

  // 4) Insertar la imagen del gráfico manteniendo proporción
  const imgProps = pdf.getImageProperties(chartImage);
  const pdfImgWidth = pageWidth - margin * 2;
  const pdfImgHeight = (imgProps.height * pdfImgWidth) / imgProps.width;
  pdf.addImage(
    chartImage,
    "PNG",
    margin,
    60, // Y de inicio debajo del encabezado
    pdfImgWidth,
    pdfImgHeight
  );

  // 5) Texto descriptivo debajo del gráfico
  const startY = 60 + pdfImgHeight + 20;
  pdf.setFontSize(12);
  pdf.text("Descripción:", margin, startY);
  pdf.setFontSize(10);
  const descripcion =
    "El gráfico muestra las especialidades más solicitadas en el periodo " +
    "analizado. La moda corresponde a la categoría con mayor número de citas, " +
    "y la media refleja el promedio de solicitudes por especialidad.";
  pdf.text(descripcion, margin, startY + 16, { maxWidth: pdfImgWidth });

  // 6) Finalizar y descargar
  pdf.save("reporte_especialidades.pdf");
}
