import { formatBS, parseMonto } from "./moneda.js";

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

/**
 * Redondea la tasa a 2 decimales, igual que hace el lado PHP (tasaCambio.php).
 * Sin esto el navegador guardaba/comparaba 886.2271 mientras el servidor
 * redondeaba a 886.23: el mismo flujo calculaba importes distintos.
 */
const redondearTasa = (tasa) => Math.round(tasa * 100) / 100;

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
    const redondeada = Number.isFinite(valor) ? redondearTasa(valor) : 0;
    return redondeada > 0 ? redondeada : 0;
  } catch (_) {
    return 0;
  }
};
tipoCambio = tasaGuardada();

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
  const tasa = redondearTasa(parseFloat(valor));
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

      const tasa = redondearTasa(Number(cuerpo.promedio));

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
  fetch("/Inicio/valorDolar/" + tipo)
    .then((r) => r.text())
    .catch((e) => console.warn("No se pudo guardar la tasa en la sesión:", e.message));
};

const formulariosInicializados = new WeakSet();

export const initConversion = (form) => {
  if (!(form instanceof Element) || formulariosInicializados.has(form)) return;

  const dolares = Array.from(form.querySelectorAll(".precioDolares"));
  const bolivares = Array.from(form.querySelectorAll(".precioBolivares"));
  const pares = dolares.slice(0, Math.min(dolares.length, bolivares.length))
    .map((usd, index) => ({ usd, bs: bolivares[index] }));

  if (pares.length === 0) return;
  formulariosInicializados.add(form);

  const paresEditados = new Map();
  let actualizando = false;
  let indicacion = form.querySelector(".currency-conversion-hint");

  if (!indicacion) {
    indicacion = document.createElement("p");
    indicacion.className = "currency-conversion-hint form-text";
    indicacion.setAttribute("role", "status");
    indicacion.setAttribute("aria-live", "polite");
    const campoBs = pares[0].bs.closest(".campo-custom");
    if (campoBs) {
      campoBs.insertAdjacentElement("afterend", indicacion);
    } else {
      form.append(indicacion);
    }
  }

  const mostrarTasa = (resultado = {}) => {
    if (!tipoCambio || tipoCambio <= 0) {
      indicacion.textContent =
        "No hay una tasa de cambio disponible. Verifica la tasa para convertir el precio.";
      indicacion.classList.add("text-danger");
      return;
    }

    const fecha = fechaTasaGuardada();
    const fechaTexto = fecha ? ` · actualizada ${fecha}` : "";
    const avisoError = resultado.error
      ? " No se pudo actualizar; se usa la última tasa disponible."
      : "";
    indicacion.textContent =
      `Escribe el precio en cualquiera de las monedas; el otro se calcula automáticamente. Tasa: ${formatBS(tipoCambio)} por USD${fechaTexto}.${avisoError}`;
    indicacion.classList.toggle("text-danger", Boolean(resultado.error));
  };

  const actualizarPar = (par, origen) => {
    if (actualizando) return;

    paresEditados.set(par, origen);
    const destino = origen === "usd" ? par.bs : par.usd;
    const monto = parseMonto(origen === "usd" ? par.usd.value : par.bs.value);

    if (monto === null || (origen === "usd" ? par.usd.value : par.bs.value).trim() === "") {
      destino.value = "";
      actualizando = true;
      destino.dispatchEvent(new Event("input", { bubbles: true }));
      actualizando = false;
      return;
    }

    if (!Number.isFinite(tipoCambio) || tipoCambio <= 0) {
      destino.value = "";
      actualizando = true;
      destino.dispatchEvent(new Event("input", { bubbles: true }));
      actualizando = false;
      mostrarTasa();
      return;
    }

    const convertido = origen === "usd" ? monto * tipoCambio : monto / tipoCambio;
    destino.value = convertido.toFixed(2);
    actualizando = true;
    destino.dispatchEvent(new Event("input", { bubbles: true }));
    actualizando = false;
  };

  pares.forEach((par) => {
    par.usd.addEventListener("input", () => actualizarPar(par, "usd"));
    par.bs.addEventListener("input", () => actualizarPar(par, "bs"));

    [par.usd, par.bs].forEach((input) => {
      input.addEventListener("blur", () => {
        const monto = parseMonto(input.value);
        if (monto === null || input.value.trim() === "") return;
        input.value = monto.toFixed(2);
        actualizarPar(par, input === par.usd ? "usd" : "bs");
      });
    });
  });

  mostrarTasa();
  valorDolar().then((resultado) => {
    tipoCambio = resultado.tasa;
    mostrarTasa(resultado);
    if (tipoCambio <= 0) return;

    pares.forEach((par) => {
      const origen = paresEditados.get(par) ??
        (par.usd.value.trim() !== "" ? "usd" : "bs");
      const monto = parseMonto(origen === "usd" ? par.usd.value : par.bs.value);
      if (monto !== null) actualizarPar(par, origen);
    });
  });

  form.addEventListener("submit", () => {
    pares.forEach(({ usd, bs }) => {
      [usd, bs].forEach((input) => {
        const monto = parseMonto(input.value);
        if (monto !== null && input.value.trim() !== "") {
          input.value = monto.toFixed(2);
        }
      });
    });
  });
};