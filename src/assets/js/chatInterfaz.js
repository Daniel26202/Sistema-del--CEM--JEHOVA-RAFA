/* ═══════════════════════════════════════════════════════════════════════════
   MÓDULO CHAT (ASISTENTE IA) · lógica de la interfaz
   ---------------------------------------------------------------------------
   Estado actual: SOLO INTERFAZ. Los datos son de prueba y están en este
   archivo (objeto `api`, más abajo).

   ── PARA CONECTAR EL BACKEND (cuando exista ControllerChat.php) ────────────
   Basta con cambiar el cuerpo de las tres funciones del objeto `api` por
   executePetition() (ya está disponible en src/assets/js/generic/
   funtionGeneric.js y añade el token CSRF solo):

     import { executePetition } from "./generic/funtionGeneric.js";

     const api = {
       conversaciones: () => executePetition(
         "/Chat/chatConversacionesAjax", "GET"),
       mensajes: (id) => executePetition(
         `/Chat/chatMensajesAjax/${id}`, "GET"),
       enviar: (texto, id) => executePetition(
         "/Chat/chatEnviarAjax", "POST",
         { id_conversacion: id, mensaje: texto }),
     };

   El resto del archivo (render, burbujas, autocrecido del textarea, copiar,
   regenerar) no necesita ningún cambio.
   ═══════════════════════════════════════════════════════════════════════════ */

import { mdRender, textoPlano } from "./generic/chatMarkdown.js";

// ── Elementos del DOM ────────────────────────────────────────────────────────
const $area = document.getElementById("chatArea");
const $mensajes = document.getElementById("chatMensajes");
const $lista = document.getElementById("chatLista");
const $lateral = document.getElementById("chatLateral");
const $form = document.getElementById("chatForm");
const $input = document.getElementById("chatInput");
const $btnEnviar = document.getElementById("chatEnviar");
const $btnEnviarTexto = document.getElementById("chatEnviarTexto");
const $btnNueva = document.getElementById("chatNueva");
const $btnToggle = document.getElementById("chatToggleLateral");
const $escribiendo = document.getElementById("chatEscribiendo");

const LOGO = $area.dataset.logo; // logo del sistema para el avatar del bot

// ── Estado ───────────────────────────────────────────────────────────────────
let conversacionActiva = null; // null = conversación nueva (aún sin crear)
let mensajesActivos = []; // mensajes de la conversación abierta
let cargando = false;
let siguienteId = 100;

// ── Datos de prueba (desaparecen con el backend) ─────────────────────────────
const conversaciones = [
    { id: 1, titulo: "Redactar un informe médico", fecha: "Hoy · 10:24" },
    { id: 2, titulo: "¿Cómo registro una cita?", fecha: "Ayer · 16:02" },
    { id: 3, titulo: "Resumen de protocolo de triaje", fecha: "12/10/2026" },
];

const mensajes = {
    1: [
        {
            rol: "usuario",
            contenido: "Redacta un informe médico breve para un paciente dado de alta hoy.",
            hora: "10:22",
        },
        {
            rol: "asistente",
            contenido:
                "**Informe médico de alta**\n\nPaciente dado de alta el día de hoy, evolución favorable y sin complicaciones durante la hospitalización.\n\n- Signos vitales estables\n- Sin fiebre en las últimas 48 h\n- Se indica control en 7 días\n\n> Recuerda: este texto es un borrador, el médico debe revisarlo antes de archivarlo.",
            hora: "10:24",
        },
    ],
    2: [
        {
            rol: "usuario",
            contenido: "¿Cómo registro una cita en el sistema?",
            hora: "16:00",
        },
        {
            rol: "asistente",
            contenido:
                "Para registrar una cita:\n\n1. Abre el módulo **Citas** en el menú lateral.\n2. Pulsa el botón *Agendar cita*.\n3. Elige paciente, doctor, servicio y horario disponible.\n4. Confirma con **Registrar**.\n\nSi el horario no aparece, es porque ya está ocupado.",
            hora: "16:02",
        },
    ],
    3: [
        {
            rol: "usuario",
            contenido: "Resume el protocolo de triaje en tres puntos.",
            hora: "09:15",
        },
        {
            rol: "asistente",
            contenido:
                "1. **Valoración inicial**: signos vitales y motivo de consulta.\n2. **Clasificación**: se asigna la prioridad según el riesgo.\n3. **Derivación**: se envía al área que corresponde.",
            hora: "09:16",
        },
    ],
};

const sugerencias = [
    "Explica cómo registrar una cita",
    "Redacta un informe médico breve",
    "Resume este texto en tres puntos",
    "Dime cómo buscar un insumo",
];

// ── API simulada ──────────────────────────────────────────────────────────────
// ⬇⬄⬇ ÚNICO punto que se cambia al conectar el backend ⬇⬄⬇
const api = {
    conversaciones: async () => conversaciones,
    mensajes: async (id) => mensajes[id] ?? [],
    enviar: async (texto) => {
        // Simula el tiempo de respuesta del asistente.
        await new Promise((resuelve) => setTimeout(resuelve, 1100));
        return {
            respuesta: `Recibido: "${texto}"\n\nEsta es una respuesta de ejemplo. Cuando conectemos el backend, acá llega la respuesta real del asistente.\n\n- Mientras tanto puedes probar **negrita**, *cursiva*, listas y \`código\`.`,
        };
    },
};

// ── Utilidades ───────────────────────────────────────────────────────────────
const horaActual = () =>
    new Date().toLocaleTimeString("es-VE", {
        hour: "2-digit",
        minute: "2-digit",
        hour12: false,
    });

const escaparParaAtributo = (texto = "") =>
    String(texto)
        .replace(/&/g, "&amp;")
        .replace(/"/g, "&quot;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/'/g, "&#39;");

const scrollAbajo = () => {
    $area.scrollTop = $area.scrollHeight;
};

// ── Pintado ──────────────────────────────────────────────────────────────────

/** Dibuja la lista de conversaciones de la columna izquierda. */
function pintarLista() {
    $lista.innerHTML = conversaciones
        .map(
            (conv) => `
        <li class="chat-item ${conv.id === conversacionActiva ? "activo" : ""}"
            data-id="${conv.id}" title="${escaparParaAtributo(conv.titulo)}">
            <span class="chat-item-titulo">${escaparParaAtributo(conv.titulo)}</span>
            <span class="chat-item-fecha">${escaparParaAtributo(conv.fecha)}</span>
        </li>`,
        )
        .join("");
}

/** Dibuja los mensajes (o el estado vacío si es una conversación nueva). */
function pintarMensajes() {
    if (!mensajesActivos.length) {
        $mensajes.innerHTML = `
            <div class="chat-vacio">
                <img class="chat-vacio-logo" src="${LOGO}" alt="Asistente IA">
                <p class="chat-vacio-titulo">¿En qué puedo ayudarte?</p>
                <p class="chat-vacio-texto">
                    Soy el asistente del sistema. Puedes preguntarme sobre el
                    funcionamiento de los módulos o pedirme ayuda para redactar
                    textos. No tengo acceso a los datos de los pacientes.
                </p>
                <div class="chat-sugerencias">
                    ${sugerencias
                        .map((texto) => `<button type="button" class="chip chat-chip" data-sugerencia="${escaparParaAtributo(texto)}">${escaparParaAtributo(texto)}</button>`)
                        .join("")}
                </div>
            </div>`;
        return;
    }

    $mensajes.innerHTML = mensajesActivos
        .map((mensaje) => {
            const esUsuario = mensaje.rol === "usuario";
            const contenido = esUsuario
                ? `<p>${textoPlano(mensaje.contenido)}</p>`
                : mdRender(mensaje.contenido);

            const avatar = esUsuario
                ? `<div class="chat-avatar-icono">
                       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                           <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                       </svg>
                   </div>`
                : `<img class="chat-avatar" src="${LOGO}" alt="Asistente">`;

            const acciones = esUsuario
                ? `<button type="button" class="chat-accion" data-accion="copiar">Copiar</button>`
                : `<button type="button" class="chat-accion" data-accion="copiar">Copiar</button>
                   <button type="button" class="chat-accion" data-accion="regenerar">Regenerar</button>`;

            return `
            <div class="chat-fila ${esUsuario ? "usuario" : "asistente"}">
                ${avatar}
                <div class="chat-burbuja-columna">
                    <div class="chat-burbuja">${contenido}</div>
                    <div class="chat-acciones">
                        <span class="chat-hora">${escaparParaAtributo(mensaje.hora ?? "")}</span>
                        ${acciones}
                    </div>
                </div>
            </div>`;
        })
        .join("");
}

/** Refresca las dos columnas y deja el scroll al final. */
function pintar() {
    pintarLista();
    pintarMensajes();
    scrollAbajo();
}

// ── Acciones ─────────────────────────────────────────────────────────────────

/** Conversación nueva: todavía no se crea, se crea con el primer mensaje. */
function nuevaConversacion() {
    conversacionActiva = null;
    mensajesActivos = [];
    $lateral.classList.remove("chat-lateral-abierto");
    $input.value = "";
    ajustarAltura();
    pintar();
    $input.focus();
}

function crearConversacion(primerMensaje) {
    const id = siguienteId++;
    const titulo =
        primerMensaje.length > 40
            ? `${primerMensaje.slice(0, 40)}…`
            : primerMensaje;

    conversaciones.unshift({ id, titulo, fecha: `Hoy · ${horaActual()}` });
    mensajes[id] = [];
    conversacionActiva = id;
    mensajesActivos = mensajes[id];
    pintarLista();
    return id;
}

async function abrirConversacion(id) {
    if (cargando) return;
    conversacionActiva = Number(id);
    mensajesActivos = await api.mensajes(conversacionActiva);
    $lateral.classList.remove("chat-lateral-abierto");
    pintar();
}

/** Muestra/oculta el "escribiendo…" y bloquea el botón de enviar. */
function estadoCargando(activo) {
    cargando = activo;
    $escribiendo.classList.toggle("d-none", !activo);
    $btnEnviar.disabled = activo;
    // Solo se cambia el texto: el icono del botón se queda donde está.
    $btnEnviarTexto.textContent = activo ? "Enviando…" : "Enviar";
    if (activo) scrollAbajo();
}

/** Envía el mensaje escrito y espera la respuesta del asistente. */
async function enviarMensaje(texto) {
    const limpio = texto.trim();
    if (!limpio || cargando) return;

    if (conversacionActiva === null) crearConversacion(limpio);

    mensajesActivos.push({
        rol: "usuario",
        contenido: limpio,
        hora: horaActual(),
    });
    pintarMensajes();
    scrollAbajo();

    $input.value = "";
    ajustarAltura();
    estadoCargando(true);

    try {
        const { respuesta } = await api.enviar(limpio, conversacionActiva);
        mensajesActivos.push({
            rol: "asistente",
            contenido: respuesta,
            hora: horaActual(),
        });
    } catch (error) {
        console.log("Error en el chat:", error);
        mensajesActivos.push({
            rol: "asistente",
            contenido: "No se pudo obtener una respuesta. Inténtalo de nuevo.",
            hora: horaActual(),
        });
    } finally {
        estadoCargando(false);
        pintar();
        $input.focus();
    }
}

/** Vuelve a pedir la respuesta del último mensaje del usuario. */
async function regenerar() {
    if (cargando || !mensajesActivos.length) return;

    const ultimoUsuario = [...mensajesActivos]
        .reverse()
        .find((mensaje) => mensaje.rol === "usuario");
    if (!ultimoUsuario) return;

    // Se descarta la última respuesta del asistente.
    while (
        mensajesActivos.length &&
        mensajesActivos[mensajesActivos.length - 1].rol === "asistente"
    ) {
        mensajesActivos.pop();
    }

    pintarMensajes();
    estadoCargando(true);

    try {
        const { respuesta } = await api.enviar(
            ultimoUsuario.contenido,
            conversacionActiva,
        );
        mensajesActivos.push({
            rol: "asistente",
            contenido: respuesta,
            hora: horaActual(),
        });
    } catch (error) {
        console.log("Error al regenerar:", error);
    } finally {
        estadoCargando(false);
        pintar();
    }
}

async function copiar(boton, texto) {
    const textoOriginal = boton.innerText;
    try {
        await navigator.clipboard.writeText(texto);
        boton.innerText = "¡Copiado!";
    } catch (error) {
        console.log("No se pudo copiar:", error);
        boton.innerText = "No se pudo copiar";
    }
    setTimeout(() => {
        boton.innerText = textoOriginal;
    }, 1500);
}

// ── Eventos ──────────────────────────────────────────────────────────────────

/** El textarea crece solo hasta 160px (límite puesto en chat.css). */
function ajustarAltura() {
    $input.style.height = "auto";
    $input.style.height = `${$input.scrollHeight}px`;
}

$form.addEventListener("submit", (evento) => {
    evento.preventDefault();
    enviarMensaje($input.value);
});

$input.addEventListener("keydown", (evento) => {
    // Enter envía; Shift + Enter hace salto de línea.
    if (evento.key === "Enter" && !evento.shiftKey) {
        evento.preventDefault();
        enviarMensaje($input.value);
    }
});

$input.addEventListener("input", ajustarAltura);

$btnNueva.addEventListener("click", nuevaConversacion);

$btnToggle.addEventListener("click", () => {
    $lateral.classList.toggle("chat-lateral-abierto");
});

// Clic en una conversación de la lista.
$lista.addEventListener("click", (evento) => {
    const item = evento.target.closest(".chat-item");
    if (item) abrirConversacion(item.dataset.id);
});

// Sugerencias del estado vacío.
$mensajes.addEventListener("click", (evento) => {
    const chip = evento.target.closest("[data-sugerencia]");
    if (!chip) return;
    enviarMensaje(chip.dataset.sugerencia);
});

// Copiar / regenerar sobre una burbuja.
$mensajes.addEventListener("click", (evento) => {
    const boton = evento.target.closest(".chat-accion");
    if (!boton) return;

    const burbuja = boton.closest(".chat-fila").querySelector(".chat-burbuja");
    const texto = burbuja.innerText;

    if (boton.dataset.accion === "copiar") copiar(boton, texto);
    if (boton.dataset.accion === "regenerar") regenerar();
});

// ── Arranque ─────────────────────────────────────────────────────────────────
(async function iniciar() {
    try {
        const datos = await api.conversaciones();
        conversaciones.length = 0;
        conversaciones.push(...datos);

        // Abre la conversación más reciente, si existe.
        if (conversaciones.length) {
            await abrirConversacion(conversaciones[0].id);
        } else {
            pintar();
        }
    } catch (error) {
        console.log("Error al cargar las conversaciones:", error);
        pintar();
    }

    $input.focus();
})();
