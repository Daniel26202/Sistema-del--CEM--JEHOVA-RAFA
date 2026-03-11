let tipoCambio = 0;

export const valorDolar = async () => {
  try {
    let peticion = await fetch("https://ve.dolarapi.com/v1/dolares/oficial");
    let resultado = await peticion.json();
    tipoCambio = resultado.promedio;
    localStorage.setItem("valorDelDolar", tipoCambio);
  } catch (error) {
    let valorDelDolar = localStorage.getItem("valorDelDolar");
    tipoCambio = valorDelDolar ? valorDelDolar : 0;
    console.log(tipoCambio);
  }
  enviarValorDolar(tipoCambio);
};

const enviarValorDolar = (tipoCambio) => {
  fetch("/Sistema-del--CEM--JEHOVA-RAFA/Inicio/valorDolar/" + tipoCambio)
    .then((response) => response.text())
    .then((data) => console.log("valor guardado", data));
};

const conversion = (inputD, inputBS, tipo) => {
  const valorDesde = parseFloat(inputD.value);
  if (isNaN(valorDesde)) {
    inputBS.value = "";
    return;
  }

  if (tipo === "dolar") {
    const resultado = valorDesde * tipoCambio;
    inputBS.value = resultado.toFixed(2);
    inputBS.dispatchEvent(new Event("keyup", { bubbles: true }));
    return;
  }
  if (tipo === "bolivares") {
    const resultado = valorDesde / tipoCambio;
    inputBS.value = resultado.toFixed(2);
    return;
  }
};

export const initConversion = (form) => {
  valorDolar(); 

  let inputDolares = form.querySelector(".precioDolares");
  let inputBolivares = form.querySelector(".precioBolivares");

  inputDolares.addEventListener("keyup", () =>
    conversion(inputDolares, inputBolivares, "dolar"),
  );

  inputBolivares.addEventListener("keyup", () =>
    conversion(inputBolivares, inputDolares, "bolivares"),
  );

  inputDolares.addEventListener("blur", () =>
    conversion(inputDolares, inputBolivares, "dolar"),
  );

  inputBolivares.addEventListener("blur", () =>
    conversion(inputBolivares, inputDolares, "bolivares"),
  );
};
