/**
 * Tasa de cambio del dólar.
 *
 * Fuente: https://ve.dolarapi.com/v1/dolares/oficial
 *
 * La tasa se guarda en localStorage para no depender de la API en cada carga,
 * pero se marca con la fecha en que se obtuvo (CLAVE_TASA_FECHA). Así el
 * llamador puede saber si la tasa que va a usar es de hoy o de ayer.
 */

const CLAVE_TASA = "valorDelDolar";
const CLAVE_TASA_FECHA = "valorDelDolarFecha";
const URL_API = "https://ve.dolarapi.com/v1/dolares/oficial";

// Tasa en memoria, compartida por los módulos de la página.
let tipoCambio = 0;

// Promesa en vuelo: si dos módulos piden la tasa al mismo tiempo, solo se
// hace una petición a la API.
let promesaEnVuelo = null;

/** Fecha de hoy en formato YYYY-MM-DD (hora local, no UTC). */
const hoyISO = () => {
  const d = new Date();
  const mes = String(d.getMonth() + 1).padStart(2, "0");
  const dia = String(d.getDate()).padStart(2, "0");
  return `${d.getFullYear()}-${mes}-${dia}`;
};

/**
 * Tasa guardada en localStorage, o 0 si no hay ninguna válida.
 *
 * Si localStorage no está disponible (modo privio estricto, cookies bloqueadas
 * por el navegador), getItem lanza SecurityError. Se devuelve 0 para que el
 * resto del código siga funcionando en vez de romperse.
 */
export const tasaGuardada = () => {
  try {
    const valor = parseFloat(localStorage.getItem(CLAVE_TASA));
    return Number.isFinite(valor) && valor > 0 ? valor : 0;
  } catch (_) {
    return 0;
  }
};

/** Fecha en que se obtuvo la tasa guardada ("" si nunca se obtuvo). */
export const fechaTasaGuardada = () => {
  try {
    return localStorage.getItem(CLAVE_TASA_FECHA) || "";
  } catch (_) {
    return "";
  }
};

/**
 * Guarda la tasa y su fecha. Devuelve false si el navegador no lo permite.
 * Así el llamador puede avisar en vez de quedarse sin tasa.
 */
const persistirTasa = (tasa, fecha) => {
  try {
    localStorage.setItem(CLAVE_TASA, String(tasa));
    localStorage.setItem(CLAVE_TASA_FECHA, fecha);
    return true;
  } catch (_) {
    return false;
  }
};

/** true si la tasa guardada es de hoy. */
export const tasaEsDeHoy = () => fechaTasaGuardada() === hoyISO();

/** Permite al usuario fijar la tasa a mano (si la API no responde o no coincide con el mercado). */
export const guardarTasaManual = (valor) => {
  const tasa = parseFloat(valor);
  if (!Number.isFinite(tasa) || tasa <= 0) {
    throw new Error("La tasa debe ser un número mayor que cero.");
  }
  const guardada = persistirTasa(tasa, hoyISO());
  tipoCambio = tasa;
  enviarValorDolar(tasa);
  if (!guardada) {
    throw new Error(
      "La tasa se aplicó pero no pudo guardarse: el navegador está bloqueando el almacenamiento local.",
    );
  }
  return tasa;
};

/**
 * Consulta la tasa del dia a la API y la guarda en localStorage.
 *
 * La API solo se usa como FUENTE: si responde, el valor de hoy manda. Si falla
 * o devuelve algo invalido, NO se toca lo que ya esta guardado: mejor un valor
 * de ayer que un 0, que rompe todos los calculos.
 *
 * @param {{forzar?: boolean}} opciones
 *   forzar=true ignora la cache local y siempre pregunta a la API.
 * @returns {Promise<{
 *   tasa: number,
 *   origen: 'api'|'cache'|'manual',
 *   fecha: string,
 *   actualizada: boolean,   // true solo si la API respondio con datos validos
 *   error?: string
 * }>}
 */
export const valorDolar = async ({ forzar = false } = {}) => {
  // Si ya tenemos la de hoy y no se fuerza, se reutiliza sin llamar a la API.
  if (!forzar && tasaGuardada() > 0 && tasaEsDeHoy()) {
    tipoCambio = tasaGuardada();
    return {
      tasa: tipoCambio,
      origen: "cache",
      fecha: fechaTasaGuardada(),
      actualizada: false,
    };
  }

  // Si ya hay una consulta en curso se comparte: dos módulos pidiendo la tasa
  // al mismo tiempo hacen una sola peticion.
  if (promesaEnVuelo) return promesaEnVuelo;

  promesaEnVuelo = (async () => {
    try {
      const control = new AbortController();
      // 5 s: si la API se cuelga no se deja la pantalla esperando.
      const temporizador = setTimeout(() => control.abort(), 5000);

      const respuesta = await fetch(URL_API, { signal: control.signal });
      clearTimeout(temporizador);

      // 1) ¿Respondio el servidor? Un 500/503 no es "tasa invalida", es caida.
      if (!respuesta.ok) {
        throw new Error(`La API respondio con HTTP ${respuesta.status}`);
      }

      // 2) ¿Vienen datos? Se espera {"promedio": 875.65, ...}
      const cuerpo = await respuesta.json();
      if (!cuerpo || typeof cuerpo !== "object") {
        throw new Error("La API no devolvio un objeto valido");
      }

      const tasa = Number(cuerpo.promedio);

      // 3) ¿El valor sirve? Debe ser un numero mayor que cero.
      //    Antes se guardaba tal cual: si la API mandaba null o 0, se guardaba
      //    null/0 y la pantalla empezaba a cobrar en cero.
      if (!Number.isFinite(tasa) || tasa <= 0) {
        throw new Error(
          cuerpo.promedio == null
            ? "La API no envio el campo 'promedio'"
            : `El valor de la API no es valido (${cuerpo.promedio})`,
        );
      }

      // 4) Solo ahora se pisa localStorage.
      const guardada = persistirTasa(tasa, hoyISO());
      tipoCambio = tasa;
      enviarValorDolar(tasa);

      return {
        tasa,
        origen: "api",
        fecha: hoyISO(),
        actualizada: true,
        // Si el navegador no deja guardar, el valor sigue sirviendo para esta
        // pantalla pero se pierde al recargar: hay que avisarlo.
        persistida: guardada,
      };
    } catch (error) {
      // Al no llegar aqui, localStorage queda intacto con la ultima tasa buena.
      const tasa = tasaGuardada();
      tipoCambio = tasa;
      return {
        tasa,
        origen: "cache",
        fecha: fechaTasaGuardada(),
        actualizada: false,
        error: error?.message ?? String(error),
      };
    } finally {
      promesaEnVuelo = null;
    }
  })();

  return promesaEnVuelo;
};

const enviarValorDolar = (tipo) => {
  fetch("/Sistema-del--CEM--JEHOVA-RAFA/Inicio/valorDolar/" + tipo)
    .then((r) => r.text())
    .catch((e) => console.warn("No se pudo guardar la tasa en la sesión:", e.message));
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