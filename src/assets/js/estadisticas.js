// Variables globales
const { jsPDF } = window.jspdf;

let currentYear, currentMonth;
let events = []; // Estructura: [{ date: 'YYYY-MM-DD', title: '...', recurrent: false }, ...]

document.addEventListener("DOMContentLoaded", function () {
  distribucion_edad_genero(
    "/Sistema-del--CEM--JEHOVA-RAFA/Estadisticas/edadGenero"
  );
  tasa_morbilidad("/Sistema-del--CEM--JEHOVA-RAFA/Estadisticas/tasaMorbilidad");
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

const tasa_morbilidad = async (url) => {
  let tes = await fetch(url);
  let data = await tes.json();
  console.log(data);

  const labels = data.map((item) => item.nombre_patologia);
  const casos = data.map((item) => parseInt(item.casos, 10));
  const tasas = data.map((item) => parseFloat(item.tasa_por_1000));

  new Chart(document.getElementById("tasa_morbilidad"), {
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
