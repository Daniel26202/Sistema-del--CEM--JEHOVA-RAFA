/* ═══════════════════════════════════════════════════════════════════════════
   ASISTENTE IA · lógica del botón flotante y del modal
   ---------------------------------------------------------------------------
   El navegador NUNCA llama a FastAPI directamente: manda la consulta a
   Chat/preguntar (PHP), que hace de proxy y adjunta la API key y los datos
   del usuario. Aquí solo se pinta la conversación.
   ═══════════════════════════════════════════════════════════════════════════ */

import { mdRender, textoPlano, escaparHtml } from "./generic/chatMarkdown.js";

const BASE = "/Sistema-del--CEM--JEHOVA-RAFA";
const ENDPOINT = `${BASE}/Chat/preguntar`;
const CLAVE_SESION = "cem_chat_session_id";

const $btnFlotante = document.getElementById("chatFlotante");
const $modalEl = document.getElementById("chatModal");
const $mensajes = document.getElementById("chatModalMensajes");
const $form = document.getElementById("chatModalForm");
const $input = document.getElementById("chatModalInput");
const $btnEnviar = document.getElementById("chatModalEnviar");
const $btnEnviarTexto = document.getElementById("chatModalEnviarTexto");
const $escribiendo = document.getElementById("chatModalEscribiendo");
const $accion = document.getElementById("chatModalAccion");

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

    function burbujaUsuario(texto) {
        return `
            <div class="chat-fila usuario">
                <div class="chat-avatar-icono">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                    </svg>
                </div>
                <div class="chat-burbuja-columna">
                    <div class="chat-burbuja">${textoPlano(texto)}</div>
                    <span class="chat-hora">${horaActual()}</span>
                </div>
            </div>`;
    }

    function burbujaAsistente(resp) {
        let contenido = mdRender(resp.mensaje || "");

        if (resp.pregunta_aclaratoria) {
            contenido += mdRender(resp.pregunta_aclaratoria);
        }

        if (resp.tipo_respuesta === "catalogo" && Array.isArray(resp.especialidades_disponibles) && resp.especialidades_disponibles.length) {
            contenido +=
                "<ul>" +
                resp.especialidades_disponibles
                    .map((e) => `<li>${escaparHtml(e)}</li>`)
                    .join("") +
                "</ul>";
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
                    <span class="chat-hora">${horaActual()}</span>
                </div>
            </div>`;
    }

    function pintar() {
        pintarVacio();
        if (!historial.length) return;
        $mensajes.innerHTML = historial
            .map((m) =>
                m.rol === "usuario"
                    ? burbujaUsuario(m.contenido)
                    : burbujaAsistente(m.resp),
            )
            .join("");
        scrollAbajo();
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

        historial.push({ rol: "usuario", contenido: limpio });
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

            historial.push({ rol: "asistente", resp: datos });
            pintar();
            pintarAccion(datos.accion_sugerida);
        } catch (error) {
            console.error("Asistente IA:", error);
            historial.push({
                rol: "asistente",
                resp: {
                    tipo_respuesta: "derivar",
                    mensaje:
                        "No se pudo obtener una respuesta del asistente. Verifique que el servicio esté activo e inténtelo de nuevo.",
                },
            });
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
    $btnFlotante.addEventListener("click", () => {
        pintar();
        modal.show();
    });

    $modalEl.addEventListener("shown.bs.modal", () => $input.focus());

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
        if (chip) enviar(chip.dataset.sugerencia);
    });

    pintarVacio();
}
