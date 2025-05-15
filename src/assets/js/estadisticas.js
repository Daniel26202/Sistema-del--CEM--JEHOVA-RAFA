// Variables globales
const { jsPDF } = window.jspdf;

let currentYear, currentMonth;
let events = []; // Estructura: [{ date: 'YYYY-MM-DD', title: '...', recurrent: false }, ...]

document.addEventListener("DOMContentLoaded", function () {
  distribucion_edad_genero(
    "/Sistema-del--CEM--JEHOVA-RAFA/Estadisticas/edadGenero"
  );
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
