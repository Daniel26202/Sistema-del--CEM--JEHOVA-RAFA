/* ═══════════════════════════════════════════════════════════════════════════
   ASISTENTE IA · lógica del botón flotante y del modal
   ---------------------------------------------------------------------------
   El navegador NUNCA llama a FastAPI directamente: manda la consulta a
   Chat/preguntar (PHP), que hace de proxy y adjunta la API key y los datos
   del usuario. Aquí solo se pinta la conversación.
   ═══════════════════════════════════════════════════════════════════════════ */

import { mdRender, textoPlano, escaparHtml } from "./generic/chatMarkdown.js";

const BASE = "";
const ENDPOINT = `${BASE}/Chat/preguntar`;
const CLAVE_SESION = "cem_chat_session_id";
const CLAVE_HISTORIAL = "cem_chat_historial";

const $btnFlotante = document.getElementById("chatFlotante");
const $modalEl = document.getElementById("chatModal");
const $mensajes = document.getElementById("chatModalMensajes");
const $form = document.getElementById("chatModalForm");
const $input = document.getElementById("chatModalInput");
const $btnEnviar = document.getElementById("chatModalEnviar");
const $btnEnviarTexto = document.getElementById("chatModalEnviarTexto");
const $escribiendo = document.getElementById("chatModalEscribiendo");
const $accion = document.getElementById("chatModalAccion");
const $borrarMemoria = document.getElementById("chatBorrarMemoria");

if ($btnFlotante && $modalEl) {
    const modal = new bootstrap.Modal($modalEl);
    const LOGO = $mensajes.dataset.logo;
    let cargando = false;
    let historial = []; // [{rol: "usuario"|"asistente", contenido}]

    const sugerencias = [
        "Paciente con dolor de pecho",
        "¿Qué especialidades hay?",
        "Manchas rojas en la piel",
        "¿Cómo registro una cita?",
    ];

    const horaActual = () =>
        new Date().toLocaleTimeString("es-VE", {
            hour: "2-digit",
            minute: "2-digit",
            hour12: false,
        });

    const scrollAbajo = () => {
        $mensajes.scrollTop = $mensajes.scrollHeight;
    };

    const csrfToken = () =>
        document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") || "";

    // ── Persistencia (para sobrevivir a la recarga al cambiar de módulo) ────
    function guardarHistorial() {
        try {
            // Se acota para no crecer sin límite en localStorage.
            localStorage.setItem(CLAVE_HISTORIAL, JSON.stringify(historial.slice(-100)));
        } catch (e) {
            /* sin espacio o almacenamiento no disponible: no es crítico */
        }
    }

    function cargarHistorial() {
        try {
            const datos = JSON.parse(localStorage.getItem(CLAVE_HISTORIAL) || "[]");
            return Array.isArray(datos) ? datos : [];
        } catch (e) {
            return [];
        }
    }

    function limpiarChat() {
        historial = [];
        try {
            localStorage.removeItem(CLAVE_HISTORIAL);
            localStorage.removeItem(CLAVE_SESION);
        } catch (e) {
            /* ignore */
        }
    }

    // ── Pintado ─────────────────────────────────────────────────────────────
    function pintarVacio() {
        if (!historial.length) {
            $mensajes.innerHTML = `
                <div class="chat-vacio">
                    <img class="chat-vacio-logo" src="${LOGO}" alt="Asistente IA">
                    <p class="chat-vacio-titulo">¿En qué puedo ayudarte?</p>
                    <p class="chat-vacio-texto">
                        Descríbeme el motivo de consulta del paciente y te oriento
                        hacia la especialidad adecuada. No sustituyo al médico.
                    </p>
                    <div class="chat-sugerencias">
                        ${sugerencias
                            .map((t) => `<button type="button" class="chip chat-chip" data-sugerencia="${escaparHtml(t)}">${escaparHtml(t)}</button>`)
                            .join("")}
                    </div>
                </div>`;
        }
    }

    function burbujaUsuario(texto, hora) {
        return `
            <div class="chat-fila usuario">
                <div class="chat-avatar-icono">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                    </svg>
                </div>
                <div class="chat-burbuja-columna">
                    <div class="chat-burbuja">${textoPlano(texto)}</div>
                    <span class="chat-hora">${hora || horaActual()}</span>
                </div>
            </div>`;
    }

    function listaSeccion(titulo, items) {
        if (!Array.isArray(items) || !items.length) return "";
        return `
            <div class="chat-seccion">
                <p class="chat-seccion-titulo">${escaparHtml(titulo)}</p>
                <ul>${items.map((i) => `<li>${escaparHtml(i)}</li>`).join("")}</ul>
            </div>`;
    }

    function burbujaAsistente(resp, hora) {
        resp = resp || {};
        let contenido = mdRender(resp.mensaje || "");

        const pregunta = resp.pregunta_activa || resp.pregunta_aclaratoria;
        if (pregunta) {
            contenido += mdRender(pregunta);
        }

        if (resp.tipo_respuesta === "catalogo" && Array.isArray(resp.especialidades_disponibles) && resp.especialidades_disponibles.length) {
            contenido +=
                "<ul>" +
                resp.especialidades_disponibles
                    .map((e) => `<li>${escaparHtml(e)}</li>`)
                    .join("") +
                "</ul>";
        }

        if (resp.tipo_respuesta === "orientacion") {
            contenido += listaSeccion("Posibles asociaciones", resp.posibles_asociaciones);
            contenido += listaSeccion("Habría que descartar", resp.a_descartar);
            contenido += listaSeccion("Pruebas que suelen indicarse", resp.pruebas_sugeridas);
            if (resp.recomendacion) {
                contenido += `<p class="chat-recomendacion">${escaparHtml(resp.recomendacion)}</p>`;
            }
        }

        if (typeof resp.progreso === "number" && resp.progreso > 0 && resp.progreso < 100) {
            contenido += `
                <div class="chat-progreso">
                    <div class="chat-progreso-barra" style="width:${resp.progreso}%"></div>
                </div>
                <span class="chat-progreso-texto">Cuestionario: ${resp.progreso}%</span>`;
        }

        if (resp.observacion) {
            contenido += `<p class="chat-observacion"><em>${escaparHtml(resp.observacion)}</em></p>`;
        }

        const claseEmergencia =
            resp.tipo_respuesta === "emergencia" ? " chat-burbuja-emergencia" : "";

        return `
            <div class="chat-fila asistente">
                <img class="chat-avatar" src="${LOGO}" alt="Asistente">
                <div class="chat-burbuja-columna">
                    <div class="chat-burbuja${claseEmergencia}">${contenido}</div>
                    <span class="chat-hora">${hora || horaActual()}</span>
                </div>
            </div>`;
    }

    function pintar() {
        pintarVacio();
        if (!historial.length) return;
        $mensajes.innerHTML = historial
            .map((m) =>
                m.rol === "usuario"
                    ? burbujaUsuario(m.contenido, m.hora)
                    : burbujaAsistente(m.resp, m.hora),
            )
            .join("");
        scrollAbajo();
    }

    // ── Reanudar conversación tras recargar la página ───────────────────────
    function pintarReanudar() {
        $mensajes.innerHTML = `
            <div class="chat-reanudar">
                <img class="chat-vacio-logo" src="${LOGO}" alt="Asistente IA">
                <p class="chat-vacio-titulo">Tienes una conversación anterior</p>
                <p class="chat-vacio-texto">Puedes continuarla o empezar de cero.</p>
                <div class="chat-reanudar-acciones">
                    <button type="button" class="btn btn-modals" data-chat-accion="continuar">Continuar chat</button>
                    <button type="button" class="btn btn-modals-cancelar" data-chat-accion="nuevo">Nuevo chat</button>
                </div>
            </div>`;
    }

    function continuarChat() {
        historial = cargarHistorial();
        const ultimoAsistente = [...historial].reverse().find((m) => m.rol === "asistente");
        pintar();
        pintarAccion(ultimoAsistente?.resp?.accion_sugerida ?? null);
        $input.focus();
    }

    function nuevoChat() {
        limpiarChat();
        pintarAccion(null);
        pintar();
        $input.focus();
    }

    async function borrarMemoriaRemota() {
        if (!confirm("¿Borrar la memoria guardada de este usuario? Se perderán los resúmenes de pacientes.")) {
            return;
        }

        try {
            await fetch(`${BASE}/Chat/borrarMemoria`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": csrfToken(),
                },
                body: JSON.stringify({ session_id: localStorage.getItem(CLAVE_SESION) }),
            });
        } catch (e) {
            console.error("No se pudo borrar la memoria remota:", e);
        }

        limpiarChat();
        pintarAccion(null);
        pintar();
    }

    /** Decide qué mostrar al abrir el modal (chat actual, reanudar o vacío). */
    function prepararApertura() {
        if (historial.length) {
            pintar();
            return;
        }
        const guardado = cargarHistorial();
        if (guardado.length) {
            if (!$mensajes.querySelector(".chat-reanudar")) pintarReanudar();
        } else {
            pintar();
        }
    }

    // ── Botón de acción sugerida ────────────────────────────────────────────
    function pintarAccion(accion) {
        if (accion && accion.visible && accion.etiqueta && accion.ruta) {
            $accion.innerHTML = `<a class="btn btn-modals" href="${escaparHtml(accion.ruta)}">${escaparHtml(accion.etiqueta)}</a>`;
            $accion.classList.add("visible");
        } else {
            $accion.innerHTML = "";
            $accion.classList.remove("visible");
        }
    }

    // ── Envío ───────────────────────────────────────────────────────────────
    function estadoCargando(activo) {
        cargando = activo;
        $escribiendo.classList.toggle("d-none", !activo);
        $btnEnviar.disabled = activo;
        $btnEnviarTexto.textContent = activo ? "Enviando…" : "Enviar";
        if (activo) scrollAbajo();
    }

    async function enviar(texto) {
        const limpio = texto.trim();
        if (!limpio || cargando) return;

        historial.push({ rol: "usuario", contenido: limpio, hora: horaActual() });
        guardarHistorial();
        $input.value = "";
        ajustarAltura();
        pintarAccion(null);
        pintar();
        estadoCargando(true);

        try {
            const respuesta = await fetch(ENDPOINT, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": csrfToken(),
                },
                body: JSON.stringify({
                    consulta: limpio,
                    session_id: localStorage.getItem(CLAVE_SESION),
                }),
            });

            const datos = await respuesta.json().catch(() => null);

            if (!respuesta.ok || !datos || datos.ok === false) {
                throw new Error(datos?.error || `HTTP ${respuesta.status}`);
            }

            if (datos.session_id) {
                localStorage.setItem(CLAVE_SESION, datos.session_id);
            }

            historial.push({ rol: "asistente", resp: datos, hora: horaActual() });
            guardarHistorial();
            pintar();
            pintarAccion(datos.accion_sugerida);
        } catch (error) {
            console.error("Asistente IA:", error);
            historial.push({
                rol: "asistente",
                hora: horaActual(),
                resp: {
                    tipo_respuesta: "derivar",
                    mensaje:
                        "No se pudo obtener una respuesta del asistente. Verifique que el servicio esté activo e inténtelo de nuevo.",
                },
            });
            guardarHistorial();
            pintar();
        } finally {
            estadoCargando(false);
            $input.focus();
        }
    }

    // ── Textarea que crece solo ─────────────────────────────────────────────
    function ajustarAltura() {
        $input.style.height = "auto";
        $input.style.height = `${$input.scrollHeight}px`;
    }

    // ── Eventos ─────────────────────────────────────────────────────────────
    $btnFlotante.addEventListener("click", () => modal.show());

    $modalEl.addEventListener("show.bs.modal", prepararApertura);
    $modalEl.addEventListener("shown.bs.modal", () => $input.focus());

    if ($borrarMemoria) {
        $borrarMemoria.addEventListener("click", borrarMemoriaRemota);
    }

    $form.addEventListener("submit", (e) => {
        e.preventDefault();
        enviar($input.value);
    });

    $input.addEventListener("keydown", (e) => {
        if (e.key === "Enter" && !e.shiftKey) {
            e.preventDefault();
            enviar($input.value);
        }
    });

    $input.addEventListener("input", ajustarAltura);

    $mensajes.addEventListener("click", (e) => {
        const chip = e.target.closest("[data-sugerencia]");
        if (chip) {
            enviar(chip.dataset.sugerencia);
            return;
        }

        const accion = e.target.closest("[data-chat-accion]");
        if (!accion) return;
        if (accion.dataset.chatAccion === "continuar") continuarChat();
        if (accion.dataset.chatAccion === "nuevo") nuevoChat();
    });

    prepararApertura();
}
