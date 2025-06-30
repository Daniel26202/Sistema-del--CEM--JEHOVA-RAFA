document.addEventListener("DOMContentLoaded", function () {
  let botonDeAyuda = document.getElementById("btnayudaMantenimiento");

  botonDeAyuda.addEventListener("click", function () {
    introJs()
      .setOptions({
        steps: [
          {
            intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DE MANTENIMIENTO",
          },

          {
            element: document.querySelector(".card-descarga"),
            intro: "ACÁ PODRÁS GESTIONAR LA DESCARGA DE LA BASE DE DATOS",
          },
          {
            element: document.querySelector(".card-descarga-btn"),
            intro:
              "AL OPRIMIR ESTE BOTÓN SE VA A DESPLEGAR UN MODAL CON UN FORMULARIO PARA REGISTRAR LA INFORMACIÓN DE LOS NUEVOS INSUMOS",
          },
          {
            element: document.querySelector(".card-restaurar"),
            intro:
              "AL OPRIMIR ESTE BOTÓN SE VA A DESPLEGAR UN MODAL CON UN FORMULARIO PARA REGISTRAR LA INFORMACIÓN DE LOS NUEVOS INSUMOS",
          },
          {
            element: document.querySelector("#card-restaurar-btn"),
            intro: "ACÁ EN ESTA TARJETA PODRÁS GESTIONAR LA RESTAURACION DE LA BASE DE DATOS",
          },
        ],

        nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
      })
      .start();
  });
});
