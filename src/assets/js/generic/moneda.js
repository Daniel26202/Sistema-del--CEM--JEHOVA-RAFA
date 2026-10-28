/**
 * Formato y lectura de importes (guía Promp_metodo_pago.md).
 *
 * Reglas de presentación:
 *   USD -> $ 1,250.50     símbolo, coma de miles, punto decimal
 *   BS  -> Bs. 45.643,25  símbolo, punto de miles, coma decimal
 *
 * Se formatea a mano en vez de con Intl porque el separador de miles de
 * Intl/ICU cambia según la versión del navegador (a veces devuelve un espacio
 * duro en es-VE) y el comprobante y la pantalla tienen que mostrar lo mismo.
 */

export const SIMBOLO_USD = "$";
export const SIMBOLO_BS = "Bs.";

/** Agrupa la parte entera cada `tamano` dígitos. */
const agrupar = (entero, separador) =>
  entero.replace(/\B(?=(\d{3})+(?!\d))/g, separador);

/** Separa un número en signo, entero y decimales, ya redondeado. */
const descomponer = (valor, decimales) => {
  const numero = Number(valor);
  const seguro = Number.isFinite(numero) ? numero : 0;
  const [entero, decimal] = Math.abs(seguro).toFixed(decimales).split(".");
  return { negativo: seguro < 0, entero, decimal };
};

/**
 * Importe en dólares: `$ 1,250.50`.
 * @param {number} valor
 * @param {number} decimales
 */
export const formatUSD = (valor, decimales = 2) => {
  const { negativo, entero, decimal } = descomponer(valor, decimales);
  return `${negativo ? "-" : ""}${SIMBOLO_USD} ${agrupar(entero, ",")}.${decimal}`;
};

/**
 * Importe en bolívares: `Bs. 45.643,25`.
 * @param {number} valor
 * @param {number} decimales
 */
export const formatBS = (valor, decimales = 2) => {
  const { negativo, entero, decimal } = descomponer(valor, decimales);
  return `${negativo ? "-" : ""}${SIMBOLO_BS} ${agrupar(entero, ".")},${decimal}`;
};

/**
 * Valor numérico sin símbolo, para precargar un <input> editable.
 * No lleva separador de miles: al escribir el cajero no tiene que borrarlos.
 */
export const valorEditable = (valor, decimales = 2) => {
  const numero = Number(valor);
  const seguro = Number.isFinite(numero) ? numero : 0;
  return seguro.toFixed(decimales);
};

/**
 * Lee un importe escrito por el cajero y devuelve su valor numérico.
 *
 * Acepta las dos convenciones (`1.234,56` y `1,234.56`) y también los símbolos
 * que pinta la interfaz (`$ 50.00`, `Bs. 45.643,25`).
 *
 * @param {string} texto
 * @returns {number|null} null si el texto no es un importe válido
 */
export const parseMonto = (texto) => {
  let limpio = String(texto ?? "")
    .replace(/\s+/g, "")
    .replace(/\$/g, "")
    .replace(/bs\.?/gi, "");

  if (limpio === "") return null;

  // Signo menos delante del número, no del símbolo de moneda.
  const negativo = limpio.startsWith("-");
  if (negativo) limpio = limpio.slice(1);
  if (!/^[\d.,]+$/.test(limpio)) return null;

  const ultimaComa = limpio.lastIndexOf(",");
  const ultimoPunto = limpio.lastIndexOf(".");
  let normalizado;

  if (ultimaComa >= 0 && ultimoPunto >= 0) {
    // Con los dos separadores, el que aparece al final es el decimal:
    // "45.643,25" (Bs) y "1,250.50" (USD) se leen igual de bien.
    normalizado =
      ultimaComa > ultimoPunto
        ? limpio.replace(/\./g, "").replace(",", ".")
        : limpio.replace(/,/g, "");
  } else if (ultimaComa >= 0) {
    // Solo comas: 3 dígitos detrás se interpretan como miles ("1,250"),
    // 1 o 2 como decimales ("1,25").
    const decimales = limpio.length - ultimaComa - 1;
    normalizado = decimales === 3 ? limpio.replace(/,/g, "") : limpio.replace(",", ".");
  } else if (ultimoPunto >= 0) {
    // Solo puntos: varios puntos o 3 dígitos detrás son miles ("1.234.567",
    // "1.250"); el resto es decimal ("50.00", "12.5").
    const puntos = (limpio.match(/\./g) ?? []).length;
    const decimales = limpio.length - ultimoPunto - 1;
    normalizado = puntos > 1 || decimales === 3 ? limpio.replace(/\./g, "") : limpio;
  } else {
    normalizado = limpio;
  }

  const valor = Number(normalizado);
  if (!Number.isFinite(valor)) return null;

  return negativo ? -valor : valor;
};

/**
 * Bloque estándar de doble moneda de la guía:
 *   <b>$ 50.00</b> <span class="text-muted small">(Bs. 44.311,50)</span>
 *
 * Sin tasa de cambio se muestra solo el importe en bolívares, que es el único
 * dato confiable en ese momento.
 *
 * @param {number} montoBs   importe canónico en bolívares
 * @param {number} tasa      bolívares por dólar (0 si no hay)
 * @param {"USD"|"BS"} principal moneda que va resaltada
 */
export const montoDualHTML = (montoBs, tasa, principal = "USD") => {
  const enBs = Number.isFinite(Number(montoBs)) ? Number(montoBs) : 0;
  const conTasa = Number.isFinite(Number(tasa)) && Number(tasa) > 0;
  const enUsd = conTasa ? enBs / Number(tasa) : 0;

  if (!conTasa) {
    return `<span class="fw-bolder">${formatBS(enBs)}</span>`;
  }

  return principal === "BS"
    ? `<span class="fw-bolder">${formatBS(enBs)}</span> <span class="text-muted small">(${formatUSD(enUsd)})</span>`
    : `<span class="fw-bolder">${formatUSD(enUsd)}</span> <span class="text-muted small">(${formatBS(enBs)})</span>`;
};
