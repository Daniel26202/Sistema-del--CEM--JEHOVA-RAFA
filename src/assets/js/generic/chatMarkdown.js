/* ═══════════════════════════════════════════════════════════════════════════
   Markdown básico para el módulo CHAT
   ---------------------------------------------------------------------------
   El sistema no puede usar librerías por CDN: el .htaccess limita script-src
   a 'self', así que el formateo de las respuestas se hace aquí.

   Orden obligatorio: PRIMERO se escapa el HTML y DESPUÉS se aplica el
   formato. Así la respuesta del asistente nunca puede inyectar etiquetas ni
   atributos (mismo criterio que sanitizeText() de funtionGeneric.js).

   Soportado: **negrita**, *cursiva*, `código`, listas (- y 1.), encabezados
   (# a ####), citas (>), párrafos y bloques de código ``` ``` .
   ═══════════════════════════════════════════════════════════════════════════ */

const CARACTERES_A_ESCAPAR = {
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': "&quot;",
    "'": "&#39;",
};

/** Convierte cualquier texto en HTML inofensivo. */
export const escaparHtml = (texto = "") =>
    String(texto ?? "").replace(/[&<>"']/g, (c) => CARACTERES_A_ESCAPAR[c]);

/** Salto de línea a <br>, para los mensajes escritos por el usuario. */
export const textoPlano = (texto = "") =>
    escaparHtml(texto).replace(/\n/g, "<br>");

/** Formato en la misma línea (ya sobre texto escapado). */
const enLinea = (html) =>
    html
        .replace(/`([^`\n]+)`/g, "<code>$1</code>")
        .replace(/\*\*([^*\n]+)\*\*/g, "<strong>$1</strong>")
        .replace(/\*([^*\n]+)\*/g, "<em>$1</em>");

/**
 * Convierte Markdown básico en HTML seguro.
 *
 * @param {string} texto Respuesta del asistente (puede contener Markdown).
 * @returns {string} HTML listo para insertar en la burbuja.
 */
export const mdRender = (texto = "") => {
    const lineas = escaparHtml(texto).split("\n");
    const salida = [];

    let enCodigo = false;
    let lista = null; // "ul" | "ol" | null
    let parrafo = [];

    const cerrarParrafo = () => {
        if (parrafo.length) {
            salida.push(`<p>${enLinea(parrafo.join(" "))}</p>`);
            parrafo = [];
        }
    };

    const cerrarLista = () => {
        if (lista) {
            salida.push(`</${lista}>`);
            lista = null;
        }
    };

    const cerrarBloques = () => {
        cerrarParrafo();
        cerrarLista();
    };

    for (const linea of lineas) {
        // Bloque de código: se copia tal cual, sin interpretar Markdown.
        if (/^```/.test(linea)) {
            if (enCodigo) {
                salida.push("</code></pre>");
                enCodigo = false;
            } else {
                cerrarBloques();
                salida.push("<pre><code>");
                enCodigo = true;
            }
            continue;
        }

        if (enCodigo) {
            salida.push(linea + "\n");
            continue;
        }

        if (linea.trim() === "") {
            cerrarBloques();
            continue;
        }

        const viñeta = linea.match(/^\s*[-•*]\s+(.*)$/);
        const numerada = linea.match(/^\s*\d+[.)]\s+(.*)$/);
        const titulo = linea.match(/^(#{1,4})\s+(.*)$/);
        const cita = linea.match(/^>\s?(.*)$/);

        if (viñeta || numerada) {
            cerrarParrafo();
            const tipo = viñeta ? "ul" : "ol";
            if (lista !== tipo) {
                cerrarLista();
                salida.push(`<${tipo}>`);
                lista = tipo;
            }
            salida.push(`<li>${enLinea((viñeta || numerada)[1])}</li>`);
            continue;
        }

        cerrarLista();

        if (titulo) {
            cerrarParrafo();
            // # → h5, ## → h6: nada más grande, para no romper la tarjeta.
            const nivel = titulo[1].length === 1 ? 5 : 6;
            salida.push(`<h${nivel}>${enLinea(titulo[2])}</h${nivel}>`);
            continue;
        }

        if (cita) {
            cerrarParrafo();
            salida.push(`<blockquote>${enLinea(cita[1])}</blockquote>`);
            continue;
        }

        parrafo.push(linea.trim());
    }

    // Si quedó algo abierto (respuesta cortada) se cierra igual.
    if (enCodigo) salida.push("</code></pre>");
    cerrarBloques();

    return salida.join("");
};
