<?php
$vistaActiva = 'Chat';
$ayuda = 'btnayudaChat';
?>
<?php require_once './src/vistas/head/head.php'; ?>
<link rel="stylesheet" href="<?= $urlBase ?>../src/assets/cssVista/chat.css">

<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo">

    <h5 style="width: 95%; " class="m-auto mb-3">Asistente IA
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-robot ms-2" viewBox="0 0 16 16">
            <path d="M6 12.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5M3 8.062c0-.525.11-1.02.312-1.469A1.5 1.5 0 0 0 4.5 6h7a1.5 1.5 0 0 0 1.188.593c.202.448.312.944.312 1.469v3.5a1.5 1.5 0 0 1-1.5 1.5h-7A1.5 1.5 0 0 1 3 11.562zM4.5 4a.5.5 0 0 0-.5.5v.5a.5.5 0 0 0 1 0V4.5a.5.5 0 0 0-.5-.5m7 0a.5.5 0 0 0-.5.5v.5a.5.5 0 0 0 1 0V4.5a.5.5 0 0 0-.5-.5M8 1a3 3 0 0 0-3 3v1h6V4a3 3 0 0 0-3-3" />
        </svg>
    </h5>

    <input type="hidden" id="vistaActiva" value="<?= $vistaActiva ?>">

    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto row" style="width: 95%; ">

        <!-- ── Columna izquierda: conversaciones ───────────────────────────── -->
        <div class="col-12 col-lg-3 chat-lateral" id="chatLateral">

            <button class="btn btn-modals w-100 mb-3 d-flex align-items-center justify-content-center" id="chatNueva" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle me-2" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                </svg>
                Nueva conversación
            </button>

            <p class="chat-lateral-titulo">Recientes</p>
            <ul class="sin-circulos chat-lista" id="chatLista"></ul>
        </div>

        <!-- ── Columna derecha: la conversación ────────────────────────────── -->
        <div class="col-12 col-lg-9 chat-principal">

            <!-- Solo móvil: muestra/oculta la lista de conversaciones -->
            <button class="btn btn-modals-cancelar chat-toggle-lateral mb-2" id="chatToggleLateral" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-plus-circle me-2" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                </svg>
                Conversaciones
            </button>

            <div class="chat-area" id="chatArea" data-logo="<?= $urlBase ?>../src/assets/images/icons/logo.png">
                <div class="chat-mensajes" id="chatMensajes"></div>

                <div class="chat-escribiendo d-none" id="chatEscribiendo">
                    <span class="chat-punto"></span>
                    <span class="chat-punto"></span>
                    <span class="chat-punto"></span>
                    <span class="chat-escribiendo-texto">El asistente está escribiendo…</span>
                </div>
            </div>

            <!-- Zona de escritura: solo texto, SIN icono de adjuntar archivo -->
            <form class="input-custom chat-composer" id="chatForm" autocomplete="off">
                <textarea id="chatInput" class="txt-custom chat-textarea" rows="1" placeholder="Escribe tu mensaje…"></textarea>
                <button class="btn btn-modals chat-enviar" id="chatEnviar" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 5.88 9.77" class="me-1">
                        <path d="M3.49,4.88,2.27,3.65l-2-2A1,1,0,0,1,.26.32a1,1,0,0,1,1.4,0l4,4a.94.94,0,0,1,0,1.33L3,8.12c-.43.43-.84.87-1.27,1.3a1,1,0,0,1-1.44.07A1,1,0,0,1,.36,8L3.51,4.89" />
                    </svg>
                    <span id="chatEnviarTexto">Enviar</span>
                </button>
            </form>

            <p class="chat-ayuda-texto">Enter envía el mensaje · Shift + Enter salto de línea · No se pueden adjuntar archivos.</p>
        </div>

    </div>

</div>



<?php require_once './src/vistas/head/footer.php';  ?>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/ayudaInteractiva/ayudaChat.js"></script>
<script type="module" src="<?= $urlBase ?>../src/assets/js/chatInterfaz.js"></script>