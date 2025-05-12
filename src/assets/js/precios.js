// Definir el tipo de cambio (puedes actualizarlo dinámicamente)
let tipoCambio = 0; // 1 USD = 80.5 Bs (ejemplo)

async function valorDolar() {
  try {
    let peticion = await fetch("https://ve.dolarapi.com/v1/dolares/oficial");
    let resultado = await peticion.json();
    console.log(resultado);
    tipoCambio = resultado.promedio;
    localStorage.setItem("valorDelDolar", tipoCambio);
    console.log(resultado)
  } catch (error) {
    let valorDelDolar = localStorage.getItem("valorDelDolar");
    tipoCambio = valorDelDolar
    console.log(
      "NO SE ACTULIZO EL PRECIO DEL DOLAR REVISE SU CONEXION A INTERNET..."
    );
  }
  enviarValorDolar(tipoCambio);
}

//enviar valor del dolar a php

function enviarValorDolar(tipoCambio) {
  fetch("/Sistema-del--CEM--JEHOVA-RAFA/Inicio/valorDolar/" + tipoCambio)
    .then((response) => response.text())
    .then((data) => console.log("valor guardado", data));
}

// Función para guardar el tipo de moneda en localStorage
function guardarTipoMoneda(moneda) {
  localStorage.setItem("tipoMoneda", moneda);
}

// Función para convertir de dólares a bolívares
function convertirADolares(inputBolivares, inputDolares) {
  let bolivares = parseFloat(inputBolivares.value);
  if (!isNaN(bolivares)) {
    let dolares = bolivares / tipoCambio;
    inputDolares.value = dolares.toFixed(2);
    guardarTipoMoneda("Bolívares");
  }
}

// Función para convertir de bolívares a dólares
function convertirABolivares(inputDolares, inputBolivares) {
  let dolares = parseFloat(inputDolares.value);
  if (!isNaN(dolares)) {
    let bolivares = dolares * tipoCambio;
    inputBolivares.value = bolivares.toFixed(2);
    guardarTipoMoneda("Dólares");
  }
}

// Función para inicializar conversión en cualquier vista
function inicializarConversor() {
  valorDolar();
  // Seleccionar todos los modales que tienen inputs de precio
  document.querySelectorAll(".form-convercion").forEach((modal) => {
    let inputDolares = modal.querySelector(".precioDolares");
    let inputBolivares = modal.querySelector(".precioBolivares");

    if (inputDolares && inputBolivares) {
      // Asignar eventos para conversión automática
      inputDolares.addEventListener("input", () => {
        convertirABolivares(inputDolares, inputBolivares);
        console.log(this);
      });
      inputBolivares.addEventListener("input", () =>
        convertirADolares(inputBolivares, inputDolares)
      );
    }
  });

  document.querySelectorAll(`.btnPreciosEditar`).forEach((ele) => {
    ele.addEventListener("click", function () {
      let modalEditar = document.querySelector(
        "#modal-exampleEditar" + this.getAttribute("data-index")
      );
      let inputDolaresEditar = modalEditar.querySelector(
        ".precioDolaresEditar"
      );
      let inputBolivaresEditar = modalEditar.querySelector(
        ".precioBolivaresEditar"
      );

      if (inputDolaresEditar && inputBolivaresEditar) {
        // Asignar eventos para conversión automática
        inputDolaresEditar.addEventListener("input", () =>
          convertirABolivares(inputDolaresEditar, inputBolivaresEditar)
        );
        inputBolivaresEditar.addEventListener("input", () =>
          convertirADolares(inputBolivaresEditar, inputDolaresEditar)
        );
      }
    });
  });
}

// Ejecutar la función al cargar la página
document.addEventListener("DOMContentLoaded", inicializarConversor);
