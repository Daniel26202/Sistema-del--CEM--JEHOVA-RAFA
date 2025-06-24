document.addEventListener("DOMContentLoaded", function () {
  let botonDeAyuda = document.getElementById("btnayudaEntrada");
  botonDeAyuda.addEventListener("click", function () {
    introJs()
      .setOptions({
        steps: [
          {
            intro: "AHORA TE ENCUENTRAS EN LA SECCION ENTRADAS DEL MODULO INSUMOS",
          },

          {
            element: document.querySelector("#inicioPacientes"),
            intro: "ACÁ PODRÁS GESTIONAR LA INFORMACIÓN DE TODAS LAS ENTRADAS DE INSUMOS",
          },
          {
            element: document.querySelector("#registrarEntrada"),
            intro:
              "AL OPRIMIR ESTE BOTÓN SE VA A DESPLEGAR UN MODAL CON UN FORMULARIO PARA REGISTRAR LA INFORMACIÓN DE LAS NUEVAS ENTRADAS",
          },
          {
            element: document.querySelector(".dt-search"),
            intro: "AQUÍ TIENES UN BUSCADOR PARA FILTRAR LAS ENTRADAS",
          },
          {
            element: document.querySelector(".caja-contenedor-tabla"),
            intro: "EN ESTA TABLA SE MUESTRA LA INFORMACIÓN DE TODAS LAS ENTRADAS REGISTRADOS",
          },
          {
            element: document.querySelector(".btnEditarDoctor"),
            intro: "AL PULSAR ESTE BOTON SE VA A DESPLEGAR UN MODAL PARA MODIFICAR LA INFORMACIÓN DE LA ENTRADA",
          },
          {
            element: document.querySelector(".btnEliminarDoctor"),
            intro: "AL PULSAR ESTE BOTON SE VA A DESPLEGAR UN MODAL PARA ELIMINAR LA INFORMACIÓN DE LA ENTRADA",
          },
    

          {
            intro: "FIN DEL RECORRIDO POR LA SECCION DE ENTRADAS, ESPERO HABERTE AYUDADO",
          },
        ],

        nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
      })
      .start();
  });
});
