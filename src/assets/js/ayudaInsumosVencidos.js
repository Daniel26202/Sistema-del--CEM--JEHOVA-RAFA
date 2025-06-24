document.addEventListener("DOMContentLoaded", function () {
  let botonDeAyuda = document.getElementById("btnayudaVencido");
  botonDeAyuda.addEventListener("click", function () {
    introJs()
      .setOptions({
        steps: [
          {
            intro: "AHORA TE ENCUENTRAS EN LA SECCION VENCIDOS DEL MODULO INSUMOS",
          },

          {
            element: document.querySelector("#inicioPacientes"),
            intro: "ACÁ PODRÁS GESTIONAR LA INFORMACIÓN DE TODOS LOS LAS ENTRADAS DE INSUMOS VENCIDOS",
          },
          {
            element: document.querySelector(".dt-search"),
            intro: "AQUÍ TIENES UN BUSCADOR PARA FILTRAR LAS ENTRADAS",
          },
          {
            element: document.querySelector(".caja-contenedor-tabla"),
            intro: "EN ESTA TABLA SE MUESTRA LA INFORMACIÓN DE TODAS LAS ENTRADAS REGISTRADAS",
          },

          {
            intro: "FIN DEL RECORRIDO POR LA SECCION DE VENCIDOS, ESPERO HABERTE AYUDADO",
          },
        ],

        nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
      })
      .start();
  });
});
