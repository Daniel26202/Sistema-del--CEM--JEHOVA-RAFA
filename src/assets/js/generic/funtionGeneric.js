import {
  chulitoYX,
  inicializarValidacionFormulario,
} from "./expresionesModulares.js";

const sanitizeText = (text) => {
  if (!text) return "";
  const map = {
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': "&quot;",
    "'": "&#x27;",
    "/": "&#x2F;",
  };
  return String(text).replace(/[&<>"'/]/g, function (s) {
    return map[s];
  });
};

//function generica for execute petiticon ajax
export const executePetition = async (url, method, data = null) => {
  try {
    const options = { method: method };

    // ✅ Obtener el token CSRF (desde meta tag o variable global)
    const csrfToken = document
      .querySelector('meta[name="csrf-token"]')
      ?.getAttribute("content");

    // ✅ Si es una petición que modifica datos, añadir el header CSRF
    const unsafeMethods = ["POST", "PUT", "PATCH", "DELETE"];
    if (unsafeMethods.includes(method.toUpperCase()) && csrfToken) {
      options.headers = options.headers || {};
      options.headers["X-CSRF-Token"] = csrfToken;
    }

    if (data instanceof FormData) {
      options.body = data;
    } else if (data && typeof data === "object") {
      options.headers = {
        ...options.headers, // ✅ Conserva el header CSRF
        "Content-Type": "application/json",
      };
      options.body = JSON.stringify(data);
    }

    let response = await fetch(url, options);

    // Si el servidor no responde JSON (ej: redirección al login por sesión
    // expirada, 429 del limitador de peticiones o un error 500), se devuelve
    // un error legible en lugar de lanzar y perder la causa real
    if (!response.ok) {
      try {
        const cuerpoError = await response.json();
        return {
          ok: false,
          error:
            cuerpoError.error || `Error del servidor (HTTP ${response.status}).`,
        };
      } catch (errorJson) {
        return {
          ok: false,
          error: `Error del servidor (HTTP ${response.status}). Verifique que la sesión esté activa.`,
        };
      }
    }

    let result;
    try {
      result = await response.json();
    } catch (errorJson) {
      return {
        ok: false,
        error:
          "Respuesta inesperada del servidor. Verifique que la sesión esté activa.",
      };
    }

    if (result.message) {
      result.message = sanitizeText(result.message);
    }
    if (result.error) {
      result.error = sanitizeText(result.error);
    }

    return result;

  } catch (error) {
    return error;
  }
};


//mostrar datos a editat

export const showDataModal = (parametros) => {
  parametros.labelModal.textContent = parametros.textLabelModal;
  parametros.btnModal.textContent = parametros.btnTextModal;
  parametros.form.classList.add("editar");

  if (parametros.cedulaOculta)
    parametros.cedulaOculta.value = parametros.data.cedula;

  if (parametros.idOculto) parametros.idOculto.value = parametros.data.id;

  if (parametros.rifOculto) parametros.rifOculto.value = parametros.data.rif;

  parametros.inputs.forEach((input) => {
    let campoCustom = input.closest(".campo-custom");
    let spamP = campoCustom.querySelector(".icono-der");
    let check = spamP.children[0];
    let error = spamP.children[1];

    input.value = parametros.data[input.getAttribute("name")];
    input.parentElement.classList.remove("invalido");
    input.parentElement.classList.add("valido");

    let pError = campoCustom.querySelector("p");
    pError.classList.add("d-none");

    if (check && error) chulitoYX(check, error, "valido");
  });

  // Inicializar con editar = true
  parametros.verificarFormulario = inicializarValidacionFormulario(
    parametros.form,
  );
};

export const clearStyleVInputs = () => {
  document.querySelectorAll(".input-validar").forEach((input) => {
    let campoCustom = input.closest(".campo-custom");
    let spamP = campoCustom.querySelector(".icono-der");
    let check = spamP.children[0];
    let error = spamP.children[1];
    input.parentElement.classList.remove("invalido");
    input.parentElement.classList.remove("valido");

    let pError = campoCustom.querySelector("p");
    pError.classList.add("d-none");

    if (check && error) chulitoYX(check, error, "vacio");
  });
};

export const clearModalEnviar = (parametros) => {
  parametros.labelModal.textContent = parametros.textLabelModal;
  parametros.btnModal.textContent = parametros.btnTextModal;
  parametros.form.classList.remove("editar");

  parametros.btnModal.textContent = parametros.btnTextModal;
  parametros.form.classList.remove("editar");

  parametros.inputs.forEach((input) => {
    let campoCustom = input.closest(".campo-custom");
    let spamP = campoCustom.querySelector(".icono-der");
    let check = spamP.children[0];
    let error = spamP.children[1];

    input.value = "";
    input.parentElement.classList.remove("valido");
    input.parentElement.classList.remove("invalido");
    let pError = campoCustom.querySelector("p");
    pError.classList.add("d-none");

    if (check && error) {
      check.classList.add("d-none");
      error.classList.add("d-none");
    }
  });
};

export const alertConfirm = (text, action, param = "") => {
  Swal.fire({
    icon: "question",
    title: "Confirmacion",
    text: text,
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
      action(param);
    }
  });
};

export const alertError = (title, text) => {
  Swal.fire({
    icon: "error",
    title: title,
    text: text,
    customClass: {
      popup: "switAlert",
      confirmButton: "btn-agregarcita-modal",
      cancelButton: "btn-agregarcita-modal-cancelar",
    },
  });
};

export const alertSuccess = (text) => {
  Swal.fire({
    icon: "success",
    title: "Éxito",
    text: text,
    customClass: {
      popup: "switAlert",
      confirmButton: "btn-agregarcita-modal",
      cancelButton: "btn-agregarcita-modal-cancelar",
    },
  });
};

export const alertInfo = (title, text) => {
  Swal.fire({
    icon: "info",
    title: title,
    text: text,
    customClass: {
      popup: "switAlert",
      confirmButton: "btn-agregarcita-modal",
      cancelButton: "btn-agregarcita-modal-cancelar",
    },
  });
};

/* ═══════════════════════════════════════════════════════════════════════════
   TABLAS RESPONSIVE (extensión "Responsive" de DataTables)
   ---------------------------------------------------------------------------
   ¿Cuándo una tabla "no cabe"? Cuando la suma del ancho de todas sus columnas
   es mayor que el ancho de la pantalla. Antes eso se "solucionaba" con un
   scroll horizontal; ahora la extensión Responsive hace algo mejor:

     1. Mide el ancho real (mínimo) de cada columna.
     2. Si no caben todas, oculta las menos importantes (de derecha a
        izquierda) en lugar de comprimirlas.
     3. Los datos ocultos NO se pierden: se muestan en una "fila hija" que se
        abre y cierra con el botón ▶ que aparece en la primera columna.

   Para usarla sólo hay que cargar el archivo de la extensión
   (`src/assets/library/DataTable/dataTables.responsive.js`) después de
   `datatables.js` (ya está incluido en `src/vistas/head/footer.php` y su CSS
   en `src/vistas/head/head.php`).

   `initDataTable()` se encarga de TODO lo anterior sin que tengas que
   configurar nada más. Ver la documentación de `initDataTable` más abajo.
   ═══════════════════════════════════════════════════════════════════════════ */

/**
 * Configuración base del modo responsive. Cada tabla puede cambiarla con el
 * 6.º parámetro de `initDataTable` (ver su documentación).
 */
const CONFIG_RESPONSIVE_BASE = {
  // true → la tabla se adapta al ancho de la pantalla
  activo: true,
  // true → la columna de botones (la última con `data: null`) nunca se oculta,
  // así sus botones siguen funcionando igual que en escritorio
  protegerBotones: true,
  // Cómo se muestran las columnas ocultas:
  //   type: 'inline' → dentro de la primera celda visible, con el botón ▶
  //                   que la extensión agrega automáticamente
  //   type: 'column' → en una fila nueva debajo de la fila actual
  //   target        → columna sobre la que se hace clic para abrir/cerrar
  detalles: { type: "inline", target: 0 },
};

/**
 * Clases que Responsive interpreta como "control manual" de columnas. Si una
 * columna ya trae alguna, significa que el programador configuró el responsive
 * a mano y no debemos tocar sus prioridades.
 */
const CLASE_RESPONSIVE_MANUAL =
  /(^|\s)(all|none|never|control|dtr-all|dtr-none|dtr-never|dtr-control|desktop|tablet|mobile|not-|min-|max-)(\s|$)/;

/**
 * Indica si la extensión Responsive está cargada en la página.
 *
 * @returns {boolean} true si se puede usar el modo responsive.
 *
 * @example
 * if (!responsiveDisponible()) {
 *   console.warn("Falta cargar dataTables.responsive.js");
 * }
 */
export const responsiveDisponible = () =>
  typeof $ !== "undefined" &&
  !!($.fn?.DataTable?.Responsive || $.fn?.dataTable?.Responsive);

/**
 * Copia un objeto ignorando los valores `undefined`.
 *
 * @param {object} base Objeto con los valores por defecto.
 * @param {object} [extra] Objeto con los valores a sobreescribir.
 * @returns {object} Nuevo objeto con la mezcla de ambos.
 */
const mezclarOpciones = (base, extra) => {
  const salida = { ...base };
  if (!extra) return salida;

  Object.keys(extra).forEach((clave) => {
    if (extra[clave] === undefined) return;
    salida[clave] = extra[clave];
  });

  return salida;
};

/**
 * ¿La columna es la de botones (acciones)? En este sistema se identifican
 * porque se definen con `data: null` (los datos los arma el `render`).
 *
 * @param {object} columna Definición de la columna de DataTables.
 * @returns {boolean}
 */
const esColumnaDeBotones = (columna) =>
  !!columna && (columna.data === null || columna.data === undefined);

/**
 * Prepara las columnas para el modo responsive:
 *
 *   · Columna de botones → recibe la clase `all` (nunca se oculta).
 *   · Resto de columnas → reciben prioridad de izquierda a derecha, así las
 *     primeras se mantienen visibles y las últimas son las que se ocultan.
 *
 * El botón ▶ (abrir/cerrar el detalle) NO se asigna a una columna fija: la
 * extensión lo dibuja sola en la primera columna que quede visible, así nunca
 * se pierde información en pantallas anchas.
 *
 * Si alguna columna ya trae `responsivePriority` o una clase responsive
 * (`all`, `none`, `control`, `desktop`, ...), se respeta la configuración
 * hecha a mano y no se toca nada.
 *
 * @param {Array<object>} columnas Columnas que recibe `initDataTable`.
 * @param {object} config Config normalizada (`prepararResponsive`).
 * @returns {Array<object>} Columnas listas para DataTables.
 */
const aplicarResponsiveAColumnas = (columnas, config) => {
  if (!Array.isArray(columnas) || columnas.length === 0) return columnas;

  const yaConfigurado = columnas.some(
    (col) =>
      col?.responsivePriority !== undefined ||
      (typeof col?.className === "string" &&
        CLASE_RESPONSIVE_MANUAL.test(col.className)),
  );

  // El programador ya definió las prioridades: no interferimos
  if (yaConfigurado) return columnas;

  const total = columnas.length;

  // Última columna con `data: null` = columna de botones
  let botones = -1;
  if (config.protegerBotones) {
    for (let i = total - 1; i >= 0; i--) {
      if (esColumnaDeBotones(columnas[i])) {
        botones = i;
        break;
      }
    }
  }

  let prioridad = 1;

  return columnas.map((col, index) => {
    const nueva = { ...col };

    if (index === botones) {
      // `all` = "columna siempre visible" para Responsive
      nueva.className = [col?.className, "all"].filter(Boolean).join(" ");
    } else {
      // Número más alto = se oculta primero (de derecha a izquierda)
      prioridad += 1;
      nueva.responsivePriority = prioridad;
    }

    return nueva;
  });
};

/**
 * Evita que al pulsar un botón (o un enlace/input) que esté dentro de la celda
 * que tiene el botón ▶ se abra/cierre también la fila hija.
 *
 * Responsive escucha los clics de esa celda para mostrar el detalle, así que
 * sin este "guardián" en pantallas muy pequeñas (donde la flecha puede caer
 * sobre la columna de acciones) un clic haría las dos cosas a la vez.
 *
 * OJO: el listener tiene que ser DELEGADO y enlazarse antes que el de la
 * extensión, porque jQuery ejecuta los handlers delegados antes que los
 * directos y en el orden en que se enlazaron.
 *
 * @param {HTMLElement} tabla Elemento `<table>` ya convertido en DataTable.
 */
const protegerBotonesDeLaFilaHija = (tabla) => {
  const $tbody = $(tabla).find("tbody");
  if (!$tbody.length) return;

  // `off` por si la tabla se reinicializa y no duplicar listeners
  $tbody.off("click.dt-guardia-fila-hija");

  $tbody.on("click.dt-guardia-fila-hija", "td,th", (evento) => {
    const celda = $(evento.currentTarget);
    if (!celda.hasClass("dtr-control")) return;

    const esInteractivo = evento.target.closest(
      'button, a, input, select, textarea, label, [data-bs-toggle], [data-bs-target]',
    );

    if (esInteractivo) {
      // El clic es para el botón, no para abrir la fila hija.
      // El listener del botón ya corrió (va antes en la burbuja), así que
      // sólo cancelamos el de Responsive.
      evento.stopImmediatePropagation();
    }
  });
};

/**
 * Normaliza las opciones responsive recibidas por `initDataTable`.
 *
 * @param {object} [opciones] Objeto de opciones del 6.º parámetro.
 * @returns {null|{
 *   activo: boolean,
 *   protegerBotones: boolean,
 *   detalles: object,
 *   dataTables: object
 * }} `null` si el responsive está apagado; si no, la configuración lista para
 * DataTables (`responsive: dataTables`).
 */
const prepararResponsive = (opciones = {}) => {
  const recibido = opciones.responsive;

  // `responsive: false` apaga el modo responsive para esa tabla
  if (recibido === false || opciones.activo === false) return null;

  // Si `responsive` es un objeto, se usa como configuración de la extensión
  const extension = recibido && typeof recibido === "object" ? recibido : {};

  // Fila hija: nuestros valores por defecto y, si se pidieron, los del
  // programador (todo lo demás lo resuelve la extensión con sus defaults)
  const detalles = mezclarOpciones(
    CONFIG_RESPONSIVE_BASE.detalles,
    mezclarOpciones(extension.detalles, opciones.detalles),
  );

  return {
    activo: true,
    protegerBotones:
      opciones.protegerBotones ?? CONFIG_RESPONSIVE_BASE.protegerBotones,
    detalles,
    // Objeto final que se le pasa a DataTables (`responsive: dataTables`)
    dataTables: mezclarOpciones(extension, { detalles }),
  };
};

/**
 * Crea una DataTable con datos del servidor (serverSide) y **responsive**.
 *
 * ─────────────────────────────────────────────────────────────────────────────
 * ¿QUÉ HACE EL MODO RESPONSIVE?
 * ─────────────────────────────────────────────────────────────────────────────
 * Cuando la tabla no cabe en el ancho de la pantalla (celular, tablet o una
 * ventana pequeña) la extensión Responsive:
 *
 *   1. Calcula el ancho real de cada columna.
 *   2. Oculta las columnas menos importantes (de derecha a izquierda) en lugar
 *      de comprimirlas y deformar la tabla.
 *   3. Muestra un botón ▶ en la primera columna: al pulsarlo se abre una fila
 *      hija con el nombre y el valor de cada columna oculta.
 *
 * Todo eso se configura solo: `initDataTable` asigna las prioridades de las
 * columnas por ti.
 *
 * ─────────────────────────────────────────────────────────────────────────────
 * PRIORIDADES AUTOMÁTICAS
 * ─────────────────────────────────────────────────────────────────────────────
 *   · Columna de botones (última con `data: null`) → clase `all`: nunca se
 *     oculta, para que sus botones sigan funcionando igual que en escritorio.
 *   · Resto → prioridad de izquierda a derecha: las primeras columnas son las
 *     más importantes y las últimas son las primeras en ocultarse.
 *   · El botón ▶ lo dibuja la extensión sola en la primera columna que quede
 *     visible (no hace falta reservar una columna para él).
 *
 * Si prefieres controlarlo a mano, pon `responsivePriority: 1` (o la clase
 * `all`) en tus columnas y `initDataTable` respeta tu configuración.
 *
 * ─────────────────────────────────────────────────────────────────────────────
 * PARÁMETROS
 * ─────────────────────────────────────────────────────────────────────────────
 * @param {string} selector Selector CSS de la tabla (ej: ".exampleTable").
 * @param {string} urlControlador URL del controlador que devuelve el JSON.
 * @param {Array<object>} [columnas] Definición de las columnas de DataTables
 *        (`{ data: "nombre", render: fn, orderable: false, ... }`).
 * @param {function(Array):void} [callbackDatos] Recibe `json.data` en cada
 *        petición (para guardar la data en una variable, por ejemplo).
 * @param {function():void} [callbackEventos] Se ejecuta en cada `drawCallback`
 *        (aquí se asignan los eventos de los botones de la tabla).
 * @param {object} [opciones] Opciones extra (todas opcionales):
 *        - `responsive` {boolean|object}  Activa/desactiva el responsive.
 *          Si es un objeto se usa como configuración de la extensión
 *          (`{ breakpoints: [...] }`). Default: `true`.
 *        - `protegerBotones` {boolean} Mantener siempre visible la columna de
 *          botones. Default: `true`.
 *        - `detalles` {object} Config de la fila hija:
 *          `{ type: "inline" | "column", target: number }`.
 *          Default: `{ type: "inline", target: 0 }`.
 *        - `dataTable` {object} Opciones extra de DataTables que quieras
 *          fijar aquí (ej: `{ pageLength: 25 }`).
 *
 * @returns {object} Instancia de DataTables creada.
 *
 * @example
 * // Uso normal (la tabla ya queda responsive)
 * initDataTable(selector, url + "/listar", columnas, guardarData, eventos);
 *
 * @example
 * // Apagando el responsive sólo en esta tabla
 * initDataTable(selector, url, columnas, null, null, { responsive: false });
 *
 * @example
 * // Fila hija en una fila nueva debajo (en vez de dentro de la celda)
 * initDataTable(selector, url, columnas, null, null, {
 *   detalles: { type: "column", target: 0 },
 * });
 *
 * @example
 * // Controlando a mano qué columnas se ocultan primero
 * const columnas = [
 *   { data: "cedula", responsivePriority: 1 }, // nunca se oculta
 *   { data: "nombre", responsivePriority: 2 },
 *   { data: "observaciones" },                 // se oculta primero
 *   { data: null, orderable: false, className: "all" }, // botones
 * ];
 * initDataTable(selector, url, columnas);
 */
export const initDataTable = (
  selector,
  urlControlador,
  columnas,
  callbackDatos = null,
  callbackEventos = null,
  opciones = {},
) => {
  // ── 1. Configuración del modo responsive ─────────────────────────────────
  const configResponsive = prepararResponsive(opciones);
  const usarResponsive = configResponsive !== null && responsiveDisponible();

  if (configResponsive !== null && !usarResponsive) {
    console.warn(
      "[initDataTable] El modo responsive está activo pero no se cargó la " +
        'extensión Responsive. Agrega "dataTables.responsive.js" después de ' +
        '"datatables.js" (src/vistas/head/footer.php) y su CSS en ' +
        "src/vistas/head/head.php. Mientras tanto la tabla funciona normal.",
    );
  }

  // ── 2. Prioridades automáticas de las columnas ───────────────────────────
  const columnasFinales = usarResponsive
    ? aplicarResponsiveAColumnas(columnas, configResponsive)
    : columnas;

  const $tabla = $(selector);

  // Los clics en botones/inputs no deben abrir la fila hija ni romperse.
  // Se enlaza ANTES de crear la DataTable para que corra antes que el
  // listener que agrega la extensión Responsive.
  if (usarResponsive) protegerBotonesDeLaFilaHija($tabla[0]);

  return $tabla.DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: urlControlador,
      type: "GET",
      //esto es para si lo necesito guardar la data en una variable
      dataSrc: function (json) {
        if (callbackDatos && typeof callbackDatos === "function") {
          callbackDatos(json.data);
        }
        return json.data;
      },
      error: function (xhr, error, thrown) {
        console.error("Error en DataTables Ajax: ", error);
      },
    },
    //columnas dimanicas seguna la tabla
    columns: columnasFinales,

    // 👇 magia del responsive: las columnas que no caben se ocultan y sus
    // datos se muestran en una fila hija que se abre con el botón ▶
    ...(usarResponsive ? { responsive: configResponsive.dataTables } : {}),

    // opciones extra que quieras fijar desde initDataTable
    ...(opciones.dataTable || {}),

    // basicamente esto es para llamar a los eventos que esten relacionados con la tabla ejemplo los botones de eliminar
    drawCallback: function (settings) {
      if (callbackEventos && typeof callbackEventos === "function") {
        callbackEventos();
      }
    },
    language: {
      decimal: ",",
      thousands: ".",
      lengthMenu: "Mostrar por página _MENU_ ",
      zeroRecords: "No se encontraron resultados",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
      infoEmpty: "No hay registros disponibles",
      infoFiltered: "(filtrado de _MAX_ registros en total)",
      search: "Buscar:",
      processing: "Cargando Registros...",
    },
  });
};

//funcion para convertir la hora militar en cita
export const convertirHora = (horaMilitar) => {
  // Separamos hora y minutos
  let [horaStr, minutoStr] = horaMilitar.split(":");

  let hora = parseInt(horaStr, 10);
  let minutos = parseInt(minutoStr, 10);

  // Validamos rango
  if (
    isNaN(hora) ||
    isNaN(minutos) ||
    hora < 0 ||
    hora > 23 ||
    minutos < 0 ||
    minutos > 59
  ) {
    return "Hora inválida";
  }

  // Determinamos AM o PM
  let sufijo = hora >= 12 ? "PM" : "AM";

  // Convertimos a formato 12 horas
  let hora12 = hora % 12;
  if (hora12 === 0) {
    hora12 = 12;
  }

  // Aseguramos que los minutos siempre tengan dos dígitos
  let minutosFormateados = minutos.toString().padStart(2, "0");

  return `${hora12}:${minutosFormateados} ${sufijo}`;
};

export const searchElements = (
  text,
  className,
  elements,
  pMensaje = null,
  parentSelector = "",
) => {
  const searchTerm = text.trim().toLowerCase();
  let coincidenciasTotales = 0;

  elements.forEach((ele) => {
    // Definimos el objetivo (el padre o el elemento mismo)
    const target = parentSelector !== "" ? ele.closest(parentSelector) : ele;
    if (!target) return;

    // Caso: Buscador vacío
    if (searchTerm === "") {
      target.classList.remove(className);
      return;
    }

    // Lógica de búsqueda
    const content = (
      ele.innerText +
      ele.textContent +
      (ele.value || "")
    ).toLowerCase();
    const matches = content.includes(searchTerm);

    if (matches) {
      target.classList.remove(className);
      coincidenciasTotales++;
    } else {
      target.classList.add(className);
    }
  });

  // --- Lógica del mensaje de "No resultados" ---
  if (pMensaje) {
    console.log("Total coincidencias:", coincidenciasTotales);
    if (searchTerm !== "" && coincidenciasTotales === 0) {
      console.log(`No se encontraron resultados para "${text}"`);
      pMensaje.innerText = `No se encontraron resultados para "${text}"`;
    } else {
      console.log(
        `Resultados encontrados para "${text}": ${coincidenciasTotales}`,
      );
      pMensaje.innerText = "";
    }
    console.log("Mensaje actualizado en el DOM:", pMensaje.innerText);
  }
};

//funvion generica para cargar imagenes en js
export const cargarImg = (archivo, imgHtml, contenedorImg) => {
  for (var i = 0; i < archivo.length; i++) {
    const reader = new FileReader();
    reader.readAsDataURL(archivo[i]);
    reader.addEventListener("load", function (e) {
      let newImg = imgHtml;
      contenedorImg.innerHTML = newImg;
      contenedorImg.querySelector("img").src = e.currentTarget.result;
    });
  }
};

//function para retorn true o false dependiendo si el usuario tiene el permiso o no
export const hasPermision = async (id_rol, module, permision, btns) => {
  try {
    const btnsList = document.querySelectorAll(btns);

    const result = await executePetition(
      `/Sistema-del--CEM--JEHOVA-RAFA/Permisos/hasPermision/${id_rol}/${module}/${permision}`,
      "GET",
    );
    if (!result) {
      btnsList.forEach((btn) => {
        btn.classList.add("d-none");
      });
      return;
    }
  } catch (error) {
    console.log("Error Permisos " + error);
  }
};

//funcion para manejar los loaders de los botones de los formularios////

//esta es para iniciar
export const initLoaderButton = (btn) => {
  btn.innerText = "Cargando...";
  btn.setAttribute("type", "button");
  btn.setAttribute("disabled", true);
};

//esta para finaliZar el loader
export const finallyLoaderButton = (btn, textButton = "Registrar") => {
  btn.innerText = textButton;
  btn.setAttribute("type", "submit");
  btn.removeAttribute("disabled");
};

export const setImgWithFallback = (
  imgElement,
  src,
  fallbackSrc = "../src/assets/images/img/logoRol.jpeg",
) => {
  if (!imgElement) return;

  imgElement.onerror = () => {
    imgElement.onerror = null;
    if (imgElement.src !== fallbackSrc) {
      imgElement.src = fallbackSrc;
    }
  };

  imgElement.src = src && src.trim() !== "" ? src : fallbackSrc;
};

// Objeto interno invisible para almacenar los hilos de los temporizadores en memoria
const procesosActivos = {};

/**
 * Inicia las dos alarmas silenciosas para el Administrador.
 * @param {string} idUnico - Identificador del módulo (ej: 'citas')
 * @param {Object} config - Configuración de IDs del DOM y callbacks
 */
export function iniciarTemporizador(idUnico, config, textAlert = "") {
  // Si ya existían alarmas corriendo para este formulario, las cancelamos primero
  detenerTemporizador(idUnico);

  procesosActivos[idUnico] = {};

  // ── ALERTA 1: A los 4 minutos y 30 segundos (Faltan 30 segundos para expirar)
  // 4.5 minutos * 60 segundos * 1000 milisegundos = 270000 ms
  procesosActivos[idUnico].alertaProximidad = setTimeout(() => {
    alertInfo("Información", textAlert);
  }, 270000);

  // ── ALERTA 2: A los 5 minutos exactos (Expiración total)
  // 5 minutos * 60 segundos * 1000 milisegundos = 300000 ms
  procesosActivos[idUnico].alertaCierre = setTimeout(() => {
    // 1. Cerrar el modal dinámicamente con Bootstrap
    if (config.idModal) {
      const modalElement = document.getElementById(config.idModal);
      if (modalElement) {
        const modalInstance =
          bootstrap.Modal.getInstance(modalElement) ||
          new bootstrap.Modal(modalElement);
        modalInstance.hide();
      }
    }

    // 2. Resetear el formulario HTML
    if (config.idFormulario) {
      const formulario = document.getElementById(config.idFormulario);
      if (formulario) formulario.reset();
    }

    // 3. Ejecutar limpiezas extras de variables en tu citas.js
    if (typeof config.callbackAlExpirar === "function") {
      config.callbackAlExpirar();
    }

    // 4. Alerta final indicando el cierre
    alertInfo(
      "Información",
      "⌛ El tiempo límite de 5 minutos ha expirado. El formulario ha sido cerrado y el cupo fue liberado.",
    );
  }, 300000);
}

/**
 * Cancela las alertas activas (Se llama cuando el administrador guarda con éxito antes de los 5 min).
 */
export function detenerTemporizador(idUnico) {
  if (procesosActivos[idUnico]) {
    if (procesosActivos[idUnico].alertaProximidad) {
      clearTimeout(procesosActivos[idUnico].alertaProximidad);
    }
    if (procesosActivos[idUnico].alertaCierre) {
      clearTimeout(procesosActivos[idUnico].alertaCierre);
    }
    delete procesosActivos[idUnico];
  }
}
