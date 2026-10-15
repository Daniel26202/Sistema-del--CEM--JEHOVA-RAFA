document.addEventListener("DOMContentLoaded", function () {
  let botonDeAyuda = document.getElementById("btnayudaChat");

  // El botón vive en el menú lateral, dentro del desplegable del usuario.
  if (!botonDeAyuda) return;

  botonDeAyuda.addEventListener("click", function () {
    const pasos = [
      {
        intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DEL ASISTENTE IA",
      },

      {
        element: document.querySelector(".chat-lateral"),
        intro:
          "ACÁ PUEDES CREAR UNA NUEVA CONVERSACIÓN Y VOLVER A ABRIR LAS CONVERSACIONES ANTERIORES",
      },
    ];

    // El estado vacío solo existe cuando la conversación está recién creada.
    if (document.querySelector(".chat-sugerencias")) {
      pasos.push({
        element: document.querySelector(".chat-sugerencias"),
        intro:
          "SI NO SABES QUÉ PREGUNTAR, TOCA UNA DE ESTAS SUGERENCIAS PARA EMPEZAR",
      });
    }

    pasos.push(
      {
        element: document.querySelector(".chat-composer"),
        intro:
          "ESCRIBE TU PREGUNTA ACÁ. CON ENTER SE ENVÍA EL MENSAJE Y CON SHIFT + ENTER SE HACE UN SALTO DE LÍNEA. NO SE PUEDEN ADJUNTAR ARCHIVOS",
      },

      {
        element: document.querySelector(".chat-area"),
        intro:
          "ACÁ APARECEN TUS PREGUNTAS Y LAS RESPUESTAS DEL ASISTENTE. AL PASAR EL MOUSE POR UNA RESPUESTA PUEDES COPIARLA O PEDIR QUE LA VUELVA A GENERAR",
      },

      {
        intro:
          "FIN DEL RECORRIDO POR EL MÓDULO DEL ASISTENTE, ESPERO HABERTE AYUDADO",
      },
    );

    introJs()
      .setOptions({
        steps: pasos,
        nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
      })
      .start();
  });
});
