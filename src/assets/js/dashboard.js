// Variables globales
const { jsPDF } = window.jspdf;

let currentYear, currentMonth;
let events = []; // Estructura: [{ date: 'YYYY-MM-DD', title: '...', recurrent: false }, ...]


const elementoImprimirEspecialidad= document.getElementById("imprimir");
const elementoImprimirSintomas = document.getElementById("imprimirSintomas");

// ========================== EVENTOS DOM ==========================

// Inicialización del DOM
document.addEventListener("DOMContentLoaded", function () {
  initCalendar(); // Inicializa el calendario
  traerCitas(); // Carga las citas pendientes
  traerCitashoy(); // Carga las citas del día
  pacientes_hospitalizados(); // Carga los pacientes hospitalizados
  traerDatosServicios(); // Carga los datos de la tabla de precios
  especialidades_chart("/Sistema-del--CEM--JEHOVA-RAFA/Inicio/especialidades_solicitadas"); // Genera el gráfico de especialidades
  sintomas_chart(); // Genera el gráfico de sintomas comunes
  traerDoctor(); //Cargar doctores en el select
});

document.getElementById("especialidades").addEventListener("click", function () {
  generarReporte(elementoImprimirEspecialidad, "reporte_especialidades.pdf");
});

document.getElementById("sintomas").addEventListener("click", function () {
  generarReporte(elementoImprimirSintomas, "reporte_sintomas.pdf");
});
//Filtrar grafica de especialidades por fecha
document.getElementById("buscarFecha").addEventListener("click", function () {
  let fechaInicio = this.parentElement.firstElementChild;
  let fechaFinal = this.parentElement.firstElementChild.nextElementSibling;
  if (fechaInicio.value < fechaFinal.value) {
    document.getElementById("especialidades").classList.remove("d-none");
    console.log("removida");
    document.querySelector(".alertaFechaInicio").classList.add("d-none");
    especialidades_chart(
      `/Sistema-del--CEM--JEHOVA-RAFA/Inicio/especialidades_solicitadas_filtradas/${fechaInicio.value}/${fechaFinal.value}`
    );
  } else {
    document.querySelector(".alertaFechaInicio").classList.remove("d-none");
    document.getElementById("especialidades").classList.add("d-none");
  }
});


//Filtrar grafica de sintomas por fecha
document.getElementById("buscarFechaSintomas").addEventListener("click", function () {
  let fechaInicio = this.parentElement.firstElementChild;
  let fechaFinal = this.parentElement.firstElementChild.nextElementSibling;
  if (fechaInicio.value < fechaFinal.value) {
    document.getElementById("sintomas").classList.remove("d-none");
    console.log("removida");
    document.querySelector(".alertaFechaInicioSintomas").classList.add("d-none");
    especialidades_chart(
      `/Sistema-del--CEM--JEHOVA-RAFA/Inicio/sintomas_comunes_filtrados/${fechaInicio.value}/${fechaFinal.value}`
    );
  } else {
    document.querySelector(".alertaFechaInicioSintomas").classList.remove("d-none");
    document.getElementById("sintomas").classList.add("d-none");
  }
});


//validar que el elemento exista

if (document.getElementById("selectDoctor")) {
  //Evento para actualizar la informacion del doctor
  document.getElementById("selectDoctor").addEventListener("change", function () {
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
  document.getElementById("prev").addEventListener("click", () => changeMonth(-1));
  document.getElementById("next").addEventListener("click", () => changeMonth(1));
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
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
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
    let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Inicio/retornarDoctores");
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

traerHorarioEspecificoDelDr = async (id) => {
  // try {
  // Realiza la petición AJAX
  console.log(id);
  let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Inicio/mostrarHorario/" + id);
  let resultado = await peticion.json();

  document.querySelector(".horario-insertar").innerHTML = "";
  let div = document.createElement("div");
  // diaNumero = []; // Reiniciar el arreglo para evitar acumulación de datos previos
  // let diasLaborablesMap = {}; // Mapa para almacenar los días y sus horarios
  console.log(resultado);
  if (resultado.length > 0) {
    resultado.forEach((res) => {
      div.innerHTML += `
                <div class="mb-2" id="divAcordion">
                <div class="d-flex text-horario">Días Laborables: <h6 class="fw-bold text-horario"> ${res.diaslaborables}</h6> </div>
              
                <div class="d-flex text-horario">Hora de Entrada: <h6 class="fw-bold text-horario"> ${res.horaDeEntrada}</h6></div>
                <div class="d-flex text-horario">Hora de Salida: <h6 class="fw-bold text-horario"> ${res.horaDeSalida}</h6></div></div>  `;
    });

    document.getElementById("titulo").innerText = `Horario del Doctor`;
  }

  document.querySelector(".horario-insertar").appendChild(div);
  // } catch (error) {
  //   console.log(error);
  // }
};

const traerHorarioDoctor = async (id) => {
  try {
    // Realiza la petición AJAX
    let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Inicio/diasConMasCitas/" + id);
    let resultado = await peticion.json();
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
                DR ${res.personal}` // Muestra el número de citas en el tooltip
        );
      }
      //Darle el teto al boton del horario
      document.getElementById("btnHorario").innerText = `Horario del Dr ${res.personal} especialidad (${res.especialidad})`;

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
    let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Inicio/servicios");
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
    let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Inicio/citasDeHoy");
    let resultado = await peticion.json();
    document.getElementById("citasDeHoy").textContent = resultado.length;
  } catch (error) {
    console.log("Error al traer las citas de hoy:", error);
  }
};

const pacientes_hospitalizados = async () => {
  try {
    let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Inicio/pacientes_hospitalizados");
    let resultado = await peticion.json();
    document.getElementById("pacientes_hospitalizados").textContent = resultado.length;
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
    console.log(data);
    if (data.length > 0) {
      //Quitarle lo oculto a los graficos
      document.getElementById("especialidades_solicitadas").classList.remove("d-none");
      document.getElementById("especialidades_solicitadas_pdf").classList.remove("d-none");

      let especialidades = data.map((item) => item.especialidad);
      let totalSolicitudes = data.map((item) => item.total_solicitudes);
      generarLeyendaEspecialidades(especialidades, totalSolicitudes); // Genera la leyenda de especialidades
      let ctx = document.getElementById("especialidades_solicitadas").getContext("2d");
      if (especialidadesChart) {
        especialidadesChart.destroy();
      }
      especialidadesChart = new Chart(ctx, {
        type: "pie",
        data: {
          labels: especialidades,
          datasets: [
            {
              data: totalSolicitudes,
              backgroundColor: ["#387adf", "#78a0f0", "#a4c7ff", "#ffcc00", "#ff6666"],
            },
          ],
          options: {
            responsive: false,
            plugins: {
              legend: {
                display: false, // La leyenda con jsPDF
              },
            },
          },
        },
      });

      // Renderiza el gráfico en el canvas del modal
      let ctxModal = document.getElementById("especialidades_solicitadas_pdf").getContext("2d");

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
              backgroundColor: ["#387adf", "#78a0f0", "#a4c7ff", "#ffcc00", "#ff6666"],
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
      document.querySelectorAll("#texto p").forEach((ele) => ele.classList.remove("d-none"));
    } else {
      //Vaciando todos los elementos si no hay datos para relizar la grafica
      document.getElementById("especialidades_solicitadas").classList.add("d-none");
      document.getElementById("especialidades_solicitadas_pdf").classList.add("d-none");
      document.querySelector(".leyenda-container").innerHTML = "";
      document.querySelectorAll("#texto p").forEach((ele) => ele.classList.add("d-none"));
      document.getElementById("especialidades").classList.add("d-none");
    }
  } catch (error) {
    console.log("Error al generar el gráfico de especialidades:", error);
  }
};

async function totalDeEspecialidades(data) {
  let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Inicio/todas_las_especialidades");
  let resultado = await peticion.json();
  document.getElementById("texto").innerHTML = ``;

  let especialidades = data.map((item) => item.especialidad).join(",  ");

  // Agrega esto al texto
  document.getElementById("texto").innerHTML += `
    <p>De Las ${resultado.total_servicios_por_cita} especialidades médicas, las ${data.length} mas solicitasdas son: ${especialidades}.</p>
    <p>Esta reporte analiza la distribución y tendencias de las especialidades médicas más solicitadas según la moda en un período determinado</p>
                        <p>El gráfico de pastel muestra la distribución porcentual de cada especialidad solicitada, identificando las áreas de mayor demanda.</p>

`;
}

//Genera el grafico de sintomas comunes
let sintomasChartModal = null;
let sintomasChart = null;
const sintomas_chart = async () => {
  let sintomas_comunes = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Inicio/sintomas_comunes");
  let data = await sintomas_comunes.json();
  let sintomas = data.map((item) => item.sintoma);
  let total = data.map((item) => item.total);

  // Generar el primer gráfico (ctx)
  let ctx = document.getElementById("sintomas_comunes").getContext("2d");
  if (sintomasChart) {
    sintomasChart.destroy();
  }
  sintomasChart = new Chart(ctx, {
    type: "pie",
    data: {
      labels: sintomas,
      datasets: [
        {
          data: total,
          backgroundColor: ["#387adf", "#78a0f0", "#a4c7ff", "#ffcc00", "#ff6666"],
        },
      ],
    },
  });

  // Verificar que el canvas del modal exista
  let canvasModal = document.getElementById("sintomas_solicitadas_pdf");
  if (!canvasModal) {
    console.error("El canvas 'sintomas_solicitadas_pdf' no existe en el DOM.");
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
          backgroundColor: ["#387adf", "#78a0f0", "#a4c7ff", "#ffcc00", "#ff6666"],
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
};

async function totalDeSintomas(data) {
  let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Inicio/todos_los_sintomas");
  let resultado = await peticion.json();
  console.log(resultado);
  document.getElementById("textoSintomas").innerHTML = ``;
  console.log(data);

  let sintomas = data.map((item) => item.sintoma).join(",  ");
  console.log(sintomas);

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
  console.log(contenedorLeyenda);

  // Limpia cualquier contenido previo en el contenedor
  contenedorLeyenda.innerHTML = "";

  // Calcula el total de solicitudes para obtener los porcentajes
  const totalSolicitudesGlobal = totalSolicitudes.reduce((acumulado, actual) => acumulado + actual, 0);

  // Recorre cada especialidad y genera un elemento de leyenda
  especialidades.forEach((especialidad, indice) => {
    // Calcula el porcentaje de solicitudes para esta especialidad
    const porcentaje = ((totalSolicitudes[indice] / totalSolicitudesGlobal) * 100).toFixed(1);

    // Crea el contenedor principal para el elemento de la leyenda
    const elementoLeyenda = document.createElement("div");
    elementoLeyenda.style.display = "flex";
    elementoLeyenda.style.alignItems = "center";
    elementoLeyenda.style.margin = "5px 0";

    // Crea el cuadro de color que representa la especialidad
    const cuadroColor = document.createElement("div");
    cuadroColor.style.width = "20px";
    cuadroColor.style.height = "20px";
    cuadroColor.style.backgroundColor = ["#387adf", "#78a0f0", "#a4c7ff", "#ffcc00", "#ff6666"][indice % 5]; // Selecciona un color basado en el índice
    cuadroColor.style.marginRight = "10px";
    cuadroColor.style.borderRadius = "3px";

    // Crea el texto descriptivo para la especialidad
    const textoLeyenda = document.createElement("span");
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
  const contenedorLeyenda = document.querySelector(".leyenda-sintomas-container");
  if (!contenedorLeyenda) return;

  // Limpia cualquier contenido previo en el contenedor
  contenedorLeyenda.innerHTML = "";

  // Calcula el total de síntomas para obtener los porcentajes
  const totalGlobal = total.reduce((acumulado, actual) => acumulado + actual, 0);

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
    const textoLeyenda = document.createElement("span");
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
  pdf.rect(0, 0, pdf.internal.pageSize.getWidth(), pdf.internal.pageSize.getHeight(), "F"); // "F" para rellenar

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
