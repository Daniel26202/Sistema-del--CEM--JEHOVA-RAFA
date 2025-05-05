// Definir el tipo de cambio (puedes actualizarlo dinámicamente)
const tipoCambio = 80.5; // 1 USD = 80.5 Bs (ejemplo)

//enviar valor del dolar a php
fetch("/Sistema-del--CEM--JEHOVA-RAFA/Inicio/valorDolar/" + tipoCambio)
  .then((response) => response.text())
  .then((data) => console.log("valor guardado", data));

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
  // Seleccionar todos los modales que tienen inputs de precio
  document.querySelectorAll(".form-convercion").forEach((modal) => {
    let inputDolares = modal.querySelector(".precioDolares");
    let inputBolivares = modal.querySelector(".precioBolivares");

    if (inputDolares && inputBolivares) {
      // Asignar eventos para conversión automática
      inputDolares.addEventListener("input", () =>
        convertirABolivares(inputDolares, inputBolivares)
      );
      inputBolivares.addEventListener("input", () =>
        convertirADolares(inputBolivares, inputDolares)
      );
    }
  });
}

// Ejecutar la función al cargar la página
document.addEventListener("DOMContentLoaded", inicializarConversor);
