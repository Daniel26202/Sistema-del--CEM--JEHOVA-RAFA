document.addEventListener("DOMContentLoaded", function () {
  let botonDeAyuda = document.getElementById("btnayudaPerfil");

  botonDeAyuda.addEventListener("click", function () {
    introJs()
      .setOptions({
        steps: [
          {
            intro: "AHORA TE ENCUENTRAS EN TU PERFIL",
          },

          {
            element: document.querySelector("#inicioPacientes"),
            intro: "ACÁ PODRÁS GESTIONAR TU INFORMACIÓN",
          },
          {
            element: document.querySelector(".fondo-perfil"),
            intro: "AQUÍ SE MUESTRA UNA TARJETA CON LA INFORMACION DE TU USUARIO.",
          },
          {
            element: document.querySelector(".botonesEdi"),
            intro: "AL PULSAR ESTE BOTON SE VA A DESPLEGAR UN MODAL PARA MODIFICAR LA INFORMACIÓN DE SU PERFIL",
          },
          {
            intro: "FIN DEL RECORRIDO POR SU PERFIL , ESPERO HABERTE AYUDADO",
          },
        ],

        nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
      })
      .start();
  });
});
