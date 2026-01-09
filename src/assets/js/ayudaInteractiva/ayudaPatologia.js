document.addEventListener("DOMContentLoaded", function () {
  let botonDeAyuda = document.getElementById("btnayudaPatologia");
  botonDeAyuda.addEventListener("click", function () {
    console.log(botonDeAyuda)
    introJs()
      .setOptions({
        steps: [
          {
            intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DE PATOLOGIAS",
          },

          {
            element: document.querySelector("#inicioPacientes"),
            intro: "ACÁ PODRÁS GESTIONAR LA INFORMACIÓN DE LAS PATOLOGIAS",
          },
          {
            element: document.querySelector(".btnRegistrarPatologia"),
            intro:
              "AL OPRIMIR ESTE BOTÓN SE VA A DESPLEGAR UN MODAL CON UN FORMULARIO PARA REGISTRAR LA INFORMACIÓN DE LOS NUEVAS PATOLOGIAS",
          },
          {
            element: document.querySelector(".dt-search"),
            intro:
              "AQUÍ TIENES UN BUSCADOR QUE AL COLOCAR EL NOMBRE DE LA PATOLOGIA VA A DESPLEGAR UN MODAL CON LOS RESULTADOS",
          },
          {
            element: document.querySelector(".caja-contenedor-tabla"),
            intro:
              "EN ESTA TABLA SE MUESTRA LA INFORMACIÓN DE TODOS LAS PATOLOGIAS REGISTRADOS",
          },
          {
            element: document.querySelector(".btnModalEliminarPatologia"),
            intro:
              "AL PULSAR ESTE BOTON SE VA A DESPLEGAR UN MODAL PARA ELIMINAR LA INFORMACIÓN DE LAS PATOLOGIAS",
          },
          {
            element: document.querySelector(".desplegableAyuda"),
            intro:
              "PARA DESPLEGAR LA LISTA TIENES QUE PASAR EL MOUSE POR ESTE ÍCONO, EN LA LISTA ECONTRARAS UN BOTÓN PARA IR AL PERFIL Y EL BOTÓN PARA ACCEDER A LA AYUDA",
          },

          {
            intro:
              "FIN DEL RECORRIDO POR EL MÓDULO DE LAS PATOLOGIAS, ESPERO HABERTE AYUDADO",
          },
        ],

        nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
      })
      .start();
  });
});
