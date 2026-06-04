// Variables globales
const { jsPDF } = window.jspdf;

// ─── URLs por chart ─────────────────────────────────────────────────────────
const URL_BASE = "/Sistema-del--CEM--JEHOVA-RAFA";
const URLS = {
  especialidades: {
    default: `${URL_BASE}/Inicio/especialidades_solicitadas`,
    filtrada: `${URL_BASE}/Inicio/especialidades_solicitadas_filtradas`,
  },
  sintomas: {
    default: `${URL_BASE}/Inicio/sintomas_comunes`,
    filtrada: `${URL_BASE}/Inicio/sintomas_comunes_filtrados`,
  },
  morbilidad: {
    default: `${URL_BASE}/Estadisticas/tasaMorbilidad`,
    filtrada: `${URL_BASE}/Estadisticas/filtrar_tasaMorbilidad`,
  },
};

const expresiones = {
  fn1: { expresion: /^\d{4}\-\d{2}\-\d{2}$/, mensajeError: "" },
  fn2: { expresion: /^\d{4}\-\d{2}\-\d{2}$/, mensajeError: "" },

  fechaDeCita: { expresion: /^\d{4}\-\d{2}\-\d{2}$/, mensajeError: "" },
};

let currentYear, currentMonth;
let events =
  []; /* Estructura: [{ date: 'YYYY-MM-DD', title: '...', recurrent: false }, ...] */

//elementos a imprimir
const elementoImprimirEspecialidad = document.getElementById("imprimir");
const elementoImprimirSintomas = document.getElementById("imprimirSintomas");
const elementoImprimirDistribucionPacientes =
  document.getElementById("imprimirPacientes");
const elementoImprimirMorbilidad =
  document.getElementById("imprimirMorbilidad");
const elementoImprimirinsumos = document.getElementById("imprimirInsumos");

//alerts
const alertEspecialidades = document.querySelector(".alert-no-encontrado");
const alertSintomas = document.querySelector(".alert-no-encontrado-s");
const alertMorbilidad = document.querySelector(".alert-no-encontrado-m");

document.addEventListener("DOMContentLoaded", function () {
  distribucion_edad_genero(
    "/Sistema-del--CEM--JEHOVA-RAFA/Estadisticas/edadGenero",
  );
  tasa_morbilidad(URLS.morbilidad.default);
  especialidades_chart(URLS.especialidades.default);
  sintomas_chart(URLS.sintomas.default);
  insumos(`/Sistema-del--CEM--JEHOVA-RAFA/Estadisticas/insumos`);
});

let distribucion_pacientes_chart = null;
let distribucion_pacientes_chart_modal = null;
let totalPacientes = 0;
let totalPacientesMasculinos = 0;
let totalPacientesFemeninos = 0;

const distribucion_edad_genero = async (url) => {
  try {
    let edadGenero = await fetch(url);
    let data = await edadGenero.json();

    // Reiniciamos contadores para evitar acumulaciones si se vuelve a llamar la función
    totalPacientes = 0;
    totalPacientesMasculinos = 0;
    totalPacientesFemeninos = 0;

    // Corrección de sumatoria técnica para acumular correctamente los totales
    data.forEach((elemento) => {
      totalPacientes += parseInt(elemento.total || 0, 10);
      totalPacientesMasculinos += parseInt(elemento.total_masculino || 0, 10);
      totalPacientesFemeninos += parseInt(elemento.total_femenino || 0, 10);
    });

    let label = data.map((item) => item.rango_edad);
    let masculino = data.map((item) => item.masculino);
    let femenino = data.map((item) => item.femenino);

    // Destruir el gráfico principal anterior si existe para evitar duplicados en el lienzo
    if (distribucion_pacientes_chart) {
      distribucion_pacientes_chart.destroy();
    }

    let ctx = document.getElementById("edadgenero").getContext("2d");

    // Evaluamos el color inicial leyendo tu localStorage directamente
    let colorTextoInicial =
      localStorage.getItem("theme") === "dark" ? "#e0e1dd" : "#1b1a1a";
    let colorGrid =
      localStorage.getItem("theme") === "dark"
        ? "rgba(255, 255, 255, 0.1)"
        : "rgba(0, 0, 0, 0.1)";

    distribucion_pacientes_chart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: label,
        datasets: [
          {
            label: "Masculino",
            data: masculino,
            backgroundColor: "#387adf", // Mantenemos tu color primario azul de la clínica
          },
          {
            label: "Femenino",
            data: femenino,
            backgroundColor: "#FF6384",
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
          x: {
            title: {
              display: true,
              text: "Intervalo de Edad",
              color: colorTextoInicial,
              font: { weight: "bold", size: 12 },
            },
            ticks: { color: colorTextoInicial, font: { weight: "bold" } },
            grid: { color: colorGrid },
            stacked: false,
          },
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: "Número de pacientes",
              color: colorTextoInicial,
              font: { weight: "bold", size: 12 },
            },
            ticks: { color: colorTextoInicial },
            grid: { color: colorGrid },
          },
        },
        plugins: {
          legend: {
            position: "bottom",
            labels: {
              color: colorTextoInicial,
              font: { weight: "bold", size: 12 },
            },
          },
          tooltip: {
            mode: "index",
            intersect: false,
          },
        },
      },
    });

    // --- Gráfico del Modal (PDF) ---
    if (distribucion_pacientes_chart_modal) {
      distribucion_pacientes_chart_modal.destroy();
    }

    let canvasModal = document.getElementById("pacientes_pdf");
    canvasModal.width = 300; // ancho deseado
    canvasModal.height = 180; // alto deseado
    let ctxModal = canvasModal.getContext("2d");

    distribucion_pacientes_chart_modal = new Chart(ctxModal, {
      type: "bar",
      data: {
        labels: label,
        datasets: [
          {
            label: "Masculino",
            data: masculino,
            backgroundColor: "#387adf",
          },
          {
            label: "Femenino",
            data: femenino,
            backgroundColor: "#FF6384",
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
          x: {
            title: {
              display: true,
              text: "Intervalo de Edad",
              color: colorTextoInicial,
            },
            ticks: { color: colorTextoInicial },
            stacked: false,
          },
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: "Número de pacientes",
              color: colorTextoInicial,
            },
            ticks: { color: colorTextoInicial },
          },
        },
        plugins: {
          legend: {
            position: "bottom",
            labels: { color: colorTextoInicial },
          },
          tooltip: {
            mode: "index",
            intersect: false,
          },
        },
      },
    });

    // Renderizar la descripción dinámica
    document.getElementById("textoPacientes").innerHTML = `
      <p class="text-center">
        Este gráfico ilustra la distribución de pacientes atendidos, segmentados por intervalos de edad y género.<br>
        <strong>Total de pacientes:</strong> ${totalPacientes}<br>
        <strong>Masculino:</strong> ${totalPacientesMasculinos} &nbsp; <strong>Femenino:</strong> ${totalPacientesFemeninos}<br>
        <strong>Rangos de edad:</strong> ${label.join(", ")}
      </p>
      <p class="text-center">
        El análisis permite identificar los grupos etarios con mayor demanda de atención y comparar la proporción de hombres y mujeres en cada rango de edad, facilitando la toma de decisiones en estrategias de salud y recursos.
      </p>
    `;
  } catch (error) {
    console.error(
      "Error al generar gráfico de distribución de pacientes:",
      error,
    );
  }
};

/*  el gráfico de insumos */

let insumosChart = null;
let insumosChartModal = null;

const insumos = async (url) => {
  try {
    let res = await fetch(url);
    let data = await res.json();

    const labels = data.map((item) => item.nombre_insumo);
    const cantidades = data.map((item) => parseInt(item.total_usado, 10));
    console.log("Datos de insumos:", data);

    // Destruir gráfico anterior si existe
    if (insumosChart) {
      insumosChart.destroy();
    }
    const ctx = document.getElementById("insumos").getContext("2d");

    // Evaluamos el color inicial leyendo tu localStorage directamente
    let colorTextoInicial =
      localStorage.getItem("theme") === "dark" ? "#e0e1dd" : "#1b1a1a";
    let colorGrid =
      localStorage.getItem("theme") === "dark"
        ? "rgba(255, 255, 255, 0.1)"
        : "rgba(0, 0, 0, 0.1)";

    insumosChart = new Chart(ctx, {
      type: "bar",
      data: {
        labels,
        datasets: [
          {
            label: "Cantidad usada",
            data: cantidades,
            backgroundColor: "#4CAF50", // Color verde para insumos
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          legend: { display: false }, // Se mantiene oculto según tu diseño original
          tooltip: { mode: "index", intersect: false },
        },
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: "Total usado",
              color: colorTextoInicial,
              font: { weight: "bold", size: 12 },
            },
            ticks: { color: colorTextoInicial },
            grid: { color: colorGrid },
          },
          x: {
            title: {
              display: true,
              text: "Insumo",
              color: colorTextoInicial,
              font: { weight: "bold", size: 12 },
            },
            ticks: { color: colorTextoInicial, font: { weight: "bold" } },
            grid: { color: colorGrid },
          },
        },
      },
    });

    // Versión para PDF
    if (insumosChartModal) {
      insumosChartModal.destroy();
    }

    const ctxModal = document
      .getElementById("insumos_canva_pdf")
      .getContext("2d");

    console.log(
      "Creando gráfico modal de insumos ctxModal:",
      ctxModal,
      "labels:",
      labels,
    );

    insumosChartModal = new Chart(ctxModal, {
      type: "bar",
      data: {
        labels,
        datasets: [
          {
            label: "Cantidad usada",
            data: cantidades,
            backgroundColor: "#4CAF50",
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          legend: { display: false },
          tooltip: { mode: "index", intersect: false },
        },
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: "Total usado",
              color: colorTextoInicial,
            },
            ticks: { color: colorTextoInicial },
          },
          x: {
            title: { display: true, text: "Insumo", color: colorTextoInicial },
            ticks: { color: colorTextoInicial },
          },
        },
      },
    });

    // Datos para texto descriptivo
    const totalUsos = cantidades.reduce((acc, val) => acc + val, 0);
    const insumoTop = labels[cantidades.indexOf(Math.max(...cantidades))];

    document.getElementById("textoInsumos").innerHTML = `
      <p class="text-center">
        Este gráfico muestra los insumos más utilizados en el sistema.<br>
        <strong>Total de unidades registradas:</strong> ${totalUsos}<br>
        <strong>Insumo más utilizado:</strong> ${insumoTop} con un total de ${Math.max(...cantidades)} unidades.
      </p>
      <p class="text-center">
        Esta información permite conocer cuáles insumos tienen mayor rotación y planificar mejor la reposición y abastecimiento.
      </p>
    `;
  } catch (error) {
    console.error("Error al generar el gráfico de insumos:", error);
  }
};
let tasaMorbilidadChart = null;
let tasaMorbilidadChartModal = null;

const tasa_morbilidad = async (url) => {
  try {
    let tes = await fetch(url);
    let data = await tes.json();
    console.log(data);

    if (!data.length > 0) {
      document.getElementById("textoMorbilidad").classList.add("d-none");
      document.getElementById("tasa_morbilidad").classList.add("d-none");
      document.getElementById("morbilidad_pdf").classList.add("d-none");

      // Alerta SweetAlert2
      Swal.fire({
        icon: "question",
        title: "Confirmacion",
        text: "No se encontraron datos en dicho rango de fecha por lo tanto si desea imprimir el registro completo de datos presione Aceptar de lo contrario Cancelar",
        showCancelButton: true,
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        customClass: {
          popup: "switAlert",
          confirmButton: "btn-agregarcita-modal",
          cancelButton: "btn-agregarcita-modal-cancelar",
        },
      }).then((result) => {
        if (result.isConfirmed) {
          const modal = document
            .getElementById("btnMorbilidad")
            .closest(".modal-content");
          // Resetear inputs de fechas
          modal.querySelectorAll(".input-validar").forEach((input) => {
            input.value = "";
            input.parentElement.classList.remove("valido", "invalido");
            // Iconos
            input.nextElementSibling.children[0].classList.add("d-none");
            input.nextElementSibling.children[1].classList.add("d-none");
          });

          tasa_morbilidad(URLS.morbilidad.default);
        }
      });

      return;
    }

    const labels = data.map((item) => item.nombre_patologia);
    const casos = data.map((item) => parseInt(item.casos, 10));
    const tasas = data.map((item) => parseFloat(item.tasa_por_1000));

    document.getElementById("tasa_morbilidad").classList.remove("d-none");
    document.getElementById("morbilidad_pdf").classList.remove("d-none");

    // Destruir el gráfico anterior si existe
    if (tasaMorbilidadChart) {
      tasaMorbilidadChart.destroy();
    }

    let ctx = document.getElementById("tasa_morbilidad").getContext("2d");

    // Evaluamos el color inicial leyendo tu localStorage directamente
    let colorTextoInicial =
      localStorage.getItem("theme") === "dark" ? "#e0e1dd" : "#1b1a1a";
    // Color tenue para las líneas divisorias (Grid) en modo oscuro o claro
    let colorGrid =
      localStorage.getItem("theme") === "dark"
        ? "rgba(255, 255, 255, 0.1)"
        : "rgba(0, 0, 0, 0.1)";

    tasaMorbilidadChart = new Chart(ctx, {
      data: {
        labels,
        datasets: [
          {
            type: "bar",
            label: "Casos",
            data: casos,
            backgroundColor: "#387adf", // Ajustado a tu color primario azul para consistencia visual
            yAxisID: "yCasos",
          },
          {
            type: "line",
            label: "Tasa por cada 1000 pacientes",
            data: tasas,
            borderColor: "#ff6666", // Color contrastante para la línea de la tasa
            backgroundColor: "#ff6666",
            yAxisID: "yTasa",
            tension: 0.2, // Suaviza un poco la línea
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
          x: {
            ticks: { color: colorTextoInicial, font: { weight: "bold" } },
            grid: { color: colorGrid },
          },
          yCasos: {
            type: "linear",
            position: "left",
            title: {
              display: true,
              text: "Número de Casos",
              color: colorTextoInicial,
              font: { weight: "bold", size: 12 },
            },
            ticks: { color: colorTextoInicial },
            grid: { color: colorGrid },
          },
          yTasa: {
            type: "linear",
            position: "right",
            title: {
              display: true,
              text: "Tasa por 1 000 pacientes",
              color: colorTextoInicial,
              font: { weight: "bold", size: 12 },
            },
            ticks: { color: colorTextoInicial },
            grid: { drawOnChartArea: false }, // No duplica las líneas horizontales del primer eje
          },
        },
        plugins: {
          legend: {
            position: "bottom",
            labels: {
              color: colorTextoInicial,
              font: { weight: "bold", size: 12 },
            },
          },
          tooltip: { mode: "index", intersect: false },
        },
      },
    });

    // --- Gráfico del Modal (PDF) ---
    if (tasaMorbilidadChartModal) {
      tasaMorbilidadChartModal.destroy();
    }

    let canvasModal = document.getElementById("morbilidad_pdf");
    canvasModal.width = 300;
    canvasModal.height = 180;
    let ctxModal = canvasModal.getContext("2d");

    tasaMorbilidadChartModal = new Chart(ctxModal, {
      data: {
        labels,
        datasets: [
          {
            type: "bar",
            label: "Casos",
            data: casos,
            backgroundColor: "#387adf",
            yAxisID: "yCasos",
          },
          {
            type: "line",
            label: "Tasa por cada 1000 pacientes",
            data: tasas,
            borderColor: "#ff6666",
            backgroundColor: "#ff6666",
            yAxisID: "yTasa",
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
          x: { ticks: { color: colorTextoInicial } },
          yCasos: {
            type: "linear",
            position: "left",
            title: {
              display: true,
              text: "Número de Casos",
              color: colorTextoInicial,
            },
            ticks: { color: colorTextoInicial },
          },
          yTasa: {
            type: "linear",
            position: "right",
            title: {
              display: true,
              text: "Tasa por 1 000 pacientes",
              color: colorTextoInicial,
            },
            ticks: { color: colorTextoInicial },
            grid: { drawOnChartArea: false },
          },
        },
        plugins: {
          legend: {
            position: "bottom",
            labels: { color: colorTextoInicial },
          },
          tooltip: { mode: "index", intersect: false },
        },
      },
    });

    // Calcular totales dinámicos
    const totalCasos = casos.reduce(
      (acumulador, valorActual) => acumulador + valorActual,
      0,
    );
    const patologiaMayor = labels[casos.indexOf(Math.max(...casos))];
    const tasaMayor = Math.max(...tasas).toFixed(2);

    // Descripción dinámica
    document.getElementById("textoMorbilidad").innerHTML = `
      <p class="text-center">
        Este gráfico muestra la cantidad de casos y la tasa de morbilidad por cada 1 000 pacientes para las patologías más frecuentes.<br>
        <strong>Total de casos registrados:</strong> ${totalCasos}<br>
        <strong>Patología con más casos:</strong> ${patologiaMayor}<br>
        <strong>Mayor tasa registrada:</strong> ${tasaMayor} por 1 000 pacientes
      </p>
      <p class="text-center">
        Analiza visualmente cuáles enfermedades tienen mayor impacto en la población y compara la frecuencia absoluta y relativa de cada una, facilitando la toma de decisiones en salud.
      </p>
    `;
    document.getElementById("textoMorbilidad").classList.remove("d-none");
  } catch (error) {
    console.error("Error en el gráfico de morbilidad:", error);
  }
};

//  el gráfico de especialidades

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
    <p>De Las ${resultado.total_servicios_por_cita} especialidades médicas, las ${data.length} mas solicitasdas son: ${especialidades}.</p>
    <p>Esta reporte analiza la distribución y tendencias de las especialidades médicas más solicitadas según la moda en un período determinado</p>
                        <p>El gráfico de pastel muestra la distribución porcentual de cada especialidad solicitada, identificando las áreas de mayor demanda.</p>

`;
}

function generarLeyendaEspecialidades(especialidades, totalSolicitudes) {
  // Selecciona el contenedor donde se mostrará la leyenda
  const contenedorLeyenda = document.querySelector(".leyenda-container");
  console.log(contenedorLeyenda);

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
  console.log(resultado);
  document.getElementById("textoSintomas").innerHTML = ``;
  console.log(data);

  let sintomas = data.map((item) => item.sintoma).join(",  ");
  console.log(sintomas);

  // Agrega esto al texto
  document.getElementById("textoSintomas").innerHTML += `
    <p>De Los ${resultado.total} sintomas registados ${data.length}  síntomas registrados, los mas comunes son: ${sintomas}.</p>
    <p>Este reporte examina la distribución y las tendencias de los síntomas más comunes según su frecuencia en un periodo determinado.</p>
                        <p>El gráfico de pastel muestra el porcentaje que representa cada uno de estos síntomas dentro del total de consultas, permitiendo identificar rápidamente cuáles son las manifestaciones clínicas que más demanda generan en la población atendida..</p>

`;
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

//lamar la funcion
inicializarValidacionFormulario(
  document.getElementById("buscadoresMorbilidad"),
);

//lamar la funcion para sintomas
inicializarValidacionFormulario(document.getElementById("buscadoresSintomas"));

//llamar funcion para especialidades
inicializarValidacionFormulario(
  document.getElementById("buscadoresEspecialidades"),
);

// ─── Construye la URL con fechas o devuelve la default ──────────────────────
function buildUrl(urls, fechaInicio, fechaFinal) {
  if (fechaInicio && fechaFinal) {
    return `${urls.filtrada}/${fechaInicio}/${fechaFinal}`;
  }
  return urls.default;
}

// ─── Validación y ejecución del filtro ──────────────────────────────────────
function filtrar_por_fecha(funcion, urls, fechaInicio, fechaFinal, alertFecha) {
  // Solo una fecha completada
  if ((fechaInicio && !fechaFinal) || (!fechaInicio && fechaFinal)) {
    alertFecha.textContent = "Completa ambas fechas para filtrar.";
    alertFecha.classList.remove("d-none");
    return;
  }

  // Rango inválido
  if (fechaInicio && fechaFinal && fechaInicio >= fechaFinal) {
    alertFecha.textContent =
      "La fecha de inicio debe ser menor a la fecha final.";
    alertFecha.classList.remove("d-none");
    return;
  }

  // Todo ok (o ambas vacías → carga default)
  alertFecha.classList.add("d-none");
  funcion(buildUrl(urls, fechaInicio, fechaFinal));
}

// ─── Referencias a inputs y alertas ─────────────────────────────────────────
const inputInicioEsp = document.getElementById("fechaInicio");
const inputFinalEsp = document.getElementById("fechaFinal");
const alertFechaEsp = document.querySelector("#reporte .alertaFechaInicio");

const inputInicioSin = document.getElementById("fechaInicioSintomas");
const inputFinalSin = document.getElementById("fechaFinalSintomas");
const alertFechaSin = document.querySelector(
  "#reporteSintomas .alertaFechaInicioSintomas",
);

// ─── Listeners de búsqueda ───────────────────────────────────────────────────

// ─── Resetear filtros al cerrar cada modal ───────────────────────────────────

document
  .getElementById("reporteTasaMorbilidad")
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

    tasa_morbilidad(URLS.morbilidad.default);
  });

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
  especialidades_chart(URLS.especialidades.default);
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

    sintomas_chart(URLS.sintomas.default);
  });

// seccion de generacion de reportes

//generar reporte de especialidades

//generar Reporte pacientes
document.getElementById("pacientes").addEventListener("click", function () {
  generarReporte(
    elementoImprimirDistribucionPacientes,
    "reporte_distribucion_de_pacientes.pdf",
  );
});

//generar repotte morbilidad
console.log(document.getElementById("btnMorbilidad"));
document.getElementById("btnMorbilidad").addEventListener("click", function () {
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

  tasa_morbilidad(
    `${URLS.morbilidad.filtrada}/${inputs[0].value}/${inputs[1].value}`,
  );

  setTimeout(() => {
    generarReporte(
      elementoImprimirMorbilidad,
      "reporte_tasa_de_morbilidad.pdf",
    );
  }, 800);

  console.log("hola");
});

//generar pdf sintomas

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
    `${URLS.sintomas.filtrada}/${inputs[0].value}/${inputs[1].value}`,
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
      `${URLS.especialidades.filtrada}/${inputs[0].value}/${inputs[1].value}`,
    );

    setTimeout(() => {
      generarReporte(
        elementoImprimirEspecialidad,
        "reporte_especialidades.pdf",
      );
    }, 800);

    console.log("hola");
  });

//repotte insumos
document
  .getElementById("descargarInsumos")
  .addEventListener("click", function () {
    generarReporte(elementoImprimirinsumos, "imprimirInsumos.pdf");
  });

//funcion generica para imprimir pdf
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

  // Escuchar el evento que creamos en el Paso 1
window.addEventListener("themeChanged", () => {
  // Determinamos el nuevo color
  const nuevoColor =
    localStorage.getItem("theme") === "dark" ? "#e0e1dd" : "#1b1a1a";
  const nuevoGrid =
    localStorage.getItem("theme") === "dark"
      ? "rgba(255, 255, 255, 0.1)"
      : "rgba(0, 0, 0, 0.1)";

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
  if (sintomasChartModal) {
    sintomasChartModal.options.plugins.legend.labels.color = nuevoColor;
    sintomasChartModal.update();
  }

  // --- Actualizar Tasa de Morbilidad Principal ---
  if (tasaMorbilidadChart) {
    // Color de Leyendas
    tasaMorbilidadChart.options.plugins.legend.labels.color = nuevoColor;

    // Colores de Ejes y Títulos
    tasaMorbilidadChart.options.scales.x.ticks.color = nuevoColor;
    tasaMorbilidadChart.options.scales.x.grid.color = nuevoGrid;

    tasaMorbilidadChart.options.scales.yCasos.ticks.color = nuevoColor;
    tasaMorbilidadChart.options.scales.yCasos.title.color = nuevoColor;
    tasaMorbilidadChart.options.scales.yCasos.grid.color = nuevoGrid;

    tasaMorbilidadChart.options.scales.yTasa.ticks.color = nuevoColor;
    tasaMorbilidadChart.options.scales.yTasa.title.color = nuevoColor;

    tasaMorbilidadChart.update();
  }

  // --- Actualizar Tasa de Morbilidad Modal ---
  if (tasaMorbilidadChartModal) {
    tasaMorbilidadChartModal.options.plugins.legend.labels.color = nuevoColor;
    tasaMorbilidadChartModal.options.scales.x.ticks.color = nuevoColor;
    tasaMorbilidadChartModal.options.scales.yCasos.ticks.color = nuevoColor;
    tasaMorbilidadChartModal.options.scales.yCasos.title.color = nuevoColor;
    tasaMorbilidadChartModal.options.scales.yTasa.ticks.color = nuevoColor;
    tasaMorbilidadChartModal.options.scales.yTasa.title.color = nuevoColor;
    tasaMorbilidadChartModal.update();
  }

  // --- Actualizar Distribución de Pacientes Principal ---
  if (distribucion_pacientes_chart) {
    distribucion_pacientes_chart.options.plugins.legend.labels.color =
      nuevoColor;

    // Eje X
    distribucion_pacientes_chart.options.scales.x.ticks.color = nuevoColor;
    distribucion_pacientes_chart.options.scales.x.title.color = nuevoColor;
    distribucion_pacientes_chart.options.scales.x.grid.color = nuevoGrid;

    // Eje Y
    distribucion_pacientes_chart.options.scales.y.ticks.color = nuevoColor;
    distribucion_pacientes_chart.options.scales.y.title.color = nuevoColor;
    distribucion_pacientes_chart.options.scales.y.grid.color = nuevoGrid;

    distribucion_pacientes_chart.update();
  }

  // --- Actualizar Distribución de Pacientes Modal ---
  if (distribucion_pacientes_chart_modal) {
    distribucion_pacientes_chart_modal.options.plugins.legend.labels.color =
      nuevoColor;
    distribucion_pacientes_chart_modal.options.scales.x.ticks.color =
      nuevoColor;
    distribucion_pacientes_chart_modal.options.scales.x.title.color =
      nuevoColor;
    distribucion_pacientes_chart_modal.options.scales.y.ticks.color =
      nuevoColor;
    distribucion_pacientes_chart_modal.options.scales.y.title.color =
      nuevoColor;
    distribucion_pacientes_chart_modal.update();
  }

  // --- Actualizar Insumos Principal ---
  if (insumosChart) {
    // Eje X
    insumosChart.options.scales.x.ticks.color = nuevoColor;
    insumosChart.options.scales.x.title.color = nuevoColor;
    insumosChart.options.scales.x.grid.color = nuevoGrid;

    // Eje Y
    insumosChart.options.scales.y.ticks.color = nuevoColor;
    insumosChart.options.scales.y.title.color = nuevoColor;
    insumosChart.options.scales.y.grid.color = nuevoGrid;

    insumosChart.update();
  }

  // --- Actualizar Insumos Modal ---
  if (insumosChartModal) {
    insumosChartModal.options.scales.x.ticks.color = nuevoColor;
    insumosChartModal.options.scales.x.title.color = nuevoColor;
    insumosChartModal.options.scales.y.ticks.color = nuevoColor;
    insumosChartModal.options.scales.y.title.color = nuevoColor;

    insumosChartModal.update();
  }
});
