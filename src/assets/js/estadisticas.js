// Variables globales
const { jsPDF } = window.jspdf;

let currentYear, currentMonth;
let events = []; // Estructura: [{ date: 'YYYY-MM-DD', title: '...', recurrent: false }, ...]

//elementos a imprimir
const elementoImprimirEspecialidad = document.getElementById("imprimir");
const elementoImprimirSintomas = document.getElementById("imprimirSintomas");

document.addEventListener("DOMContentLoaded", function () {
  distribucion_edad_genero("/Sistema-del--CEM--JEHOVA-RAFA/Estadisticas/edadGenero");
  tasa_morbilidad("/Sistema-del--CEM--JEHOVA-RAFA/Estadisticas/tasaMorbilidad");
  especialidades_chart("/Sistema-del--CEM--JEHOVA-RAFA/Inicio/especialidades_solicitadas");
  sintomas_chart(`/Sistema-del--CEM--JEHOVA-RAFA/Inicio/sintomas_comunes`);
});

const distribucion_edad_genero = async (url) => {
  let edadGenero = await fetch(url);
  let data = await edadGenero.json();
  console.log(data);
  let label = data.map((item) => item.rango_edad);
  let masculino = data.map((item) => item.masculino);
  let femenino = data.map((item) => item.femenino);
  console.log(label);
  console.log(masculino);
  console.log(femenino);

  new Chart(document.getElementById("edadgenero"), {
    type: "bar",
    data: {
      labels: label,
      datasets: [
        {
          label: "Masculino",
          data: masculino,
          backgroundColor: "#36A2EB",
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
      scales: {
        x: {
          title: {
            display: true,
            text: "Intervalo de Edad",
          },
          stacked: false,
        },

        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: "Numero de pacientes",
          },
        },
      },
      plugins: {
        legend: {
          position: "bottom",
        },
        tooltip: {
          mode: "index",
          intersect: false,
        },
      },
    },
  });
};

let tasaMorbilidadChart = null;

const tasa_morbilidad = async (url) => {
  let tes = await fetch(url);
  let data = await tes.json();
  console.log(data);

  const labels = data.map((item) => item.nombre_patologia);
  const casos = data.map((item) => parseInt(item.casos, 10));
  const tasas = data.map((item) => parseFloat(item.tasa_por_1000));

  // Destruir el gráfico anterior si existe
  if (tasaMorbilidadChart) {
    tasaMorbilidadChart.destroy();
  }

  tasaMorbilidadChart = new Chart(document.getElementById("tasa_morbilidad"), {
    data: {
      labels,
      datasets: [
        {
          type: "bar",
          label: "Casos",
          data: casos,
          backgroundColor: "#36A2EB",
          yAxisID: "yCasos",
        },
        {
          type: "line",
          label: "Tasa por 1000",
          data: tasas,
          borderColor: "#8aafff",
          backgroundColor: "#8aafff",
          yAxisID: "yTasa",
        },
      ],
    },
    options: {
      responsive: true,
      scales: {
        yCasos: {
          type: "linear",
          position: "left",
          title: { display: true, text: "Número de Casos" },
        },
        yTasa: {
          type: "linear",
          position: "right",
          title: { display: true, text: "Tasa por 1 000 pacientes" },
          grid: { drawOnChartArea: false },
        },
      },
      plugins: {
        legend: { position: "bottom" },
        tooltip: { mode: "index", intersect: false },
      },
    },
  });
};

//  el gráfico de especialidades

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

      generarLeyendaEspecialidades(especialidades, totalSolicitudes); //  la leyenda de especialidades
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

//Sintomas
//Genera el grafico de sintomas comunes
let sintomasChartModal = null;
let sintomasChart = null;
const sintomas_chart = async (url) => {
  let sintomas_comunes = await fetch(url);
  let data = await sintomas_comunes.json();
  if (data.length > 0) {
    //Quitarle lo oculto a los graficos
    document.getElementById("sintomas_comunes").classList.remove("d-none");
    document.getElementById("sintomas_solicitadas_pdf").classList.remove("d-none");
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
    //aparece el boton de impirmir
    document.getElementById("textoSintomas").classList.remove("d-none");
    document.querySelectorAll("#textoSintomas p").forEach((ele) => ele.classList.remove("d-none"));
  } else {
    //vacia todos los elementos si no hay datos para relizar la grafica
    document.getElementById("sintomas_comunes").classList.add("d-none");
    document.getElementById("sintomas_solicitadas_pdf").classList.add("d-none");
    document.querySelector(".leyenda-sintomas-container").innerHTML = "";
    document.querySelectorAll("#textoSintomas p").forEach((ele) => ele.classList.add("d-none"));
    document.getElementById("sintomas").classList.add("d-none");
  }
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

//Funcion para  filtrar por fecha

function filtrar_por_fecha(funcion, fechaInicio, fechaFinal, parametros = "") {
  if (fechaInicio < fechaFinal) {
    funcion(parametros);
  } else {
    UIkit.notification({
      message:
        '<div style="z-index: 300 !important; box-shadow: 0 4px 16px rgba(0,0,0,0.25); border-radius: 6px; padding: 8px 16px;">No se puede filtrar por fecha. La fecha de inicio debe ser menor que la fecha final.</div>',
      status: "warning",
      pos: "top-right",
      timeout: 5000,
    });
  }
}

//filtros por fecha

//especialidades por fecha
document.getElementById("buscarFecha").addEventListener("click", function () {
  let fechaInicio = this.parentElement.firstElementChild.value;
  let fechaFinal = this.parentElement.firstElementChild.nextElementSibling.value;
  filtrar_por_fecha(
    especialidades_chart,
    fechaInicio,
    fechaFinal,
    `/Sistema-del--CEM--JEHOVA-RAFA/Inicio/especialidades_solicitadas_filtradas/${fechaInicio}/${fechaFinal}`
  );
});

//sintomas por fecha
document.getElementById("buscarFechaSintomas").addEventListener("click", function () {
  let fechaInicio = this.parentElement.firstElementChild.value;
  let fechaFinal = this.parentElement.firstElementChild.nextElementSibling.value;
  filtrar_por_fecha(
    sintomas_chart,
    fechaInicio,
    fechaFinal,
    `/Sistema-del--CEM--JEHOVA-RAFA/Inicio/sintomas_comunes_filtrados/${fechaInicio}/${fechaFinal}`
  );
});

// seccion de generacion de reportes

//generar reporte de especialidades
document.getElementById("especialidades").addEventListener("click", function () {
  generarReporte(elementoImprimirEspecialidad, "reporte_especialidades.pdf");
});

//generar reporte de sintoams
document.getElementById("sintomas").addEventListener("click", function () {
  generarReporte(elementoImprimirSintomas, "reporte_sintomas.pdf");
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
