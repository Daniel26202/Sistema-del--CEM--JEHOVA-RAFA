document.addEventListener("DOMContentLoaded", function () {
  let botonDeAyuda = document.getElementById("btnayudaPaciente");
  botonDeAyuda.addEventListener("click", function () {
    introJs()
      .setOptions({
        steps: [
          {
            intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DE CLIENTES",
          },

          {
            element: document.querySelector("#inicioClientes"),
            intro: "ACÁ PODRÁS GESTIONAR LA INFORMACIÓN DE LOS CLIENTES",
          },
          {
            element: document.querySelector(".btnOpenModal"),
            intro:
              "AL OPRIMIR ESTE BOTÓN SE VA A DESPLEGAR UN MODAL CON UN FORMULARIO PARA REGISTRAR LA INFORMACIÓN DE LOS NUEVOS CLIENTES",
          },
          {
            element: document.querySelector(".dt-search"),
            intro:
              "AQUÍ TIENES UN BUSCADOR QUE AL COLOCAR LA CI DEL CLIENTE VA A DESPLEGAR UN MODAL CON LOS RESULTADOS",
          },
          {
            element: document.querySelector(".caja-contenedor-tabla"),
            intro:
              "EN ESTA TABLA SE MUESTRA LA INFORMACIÓN DE TODOS LOS CLIENTE REGISTRADOS",
          },
          {
            element: document.querySelector(".btnModalEditarPaciente"),
            intro:
              "AL PULSAR ESTE BOTON SE VA A DESPLEGAR UN MODAL PARA MODIFICAR LA INFORMACIÓN DEL CLIENTE",
          },
          {
            element: document.querySelector(".btnModalEliminarPaciente"),
            intro:
              "AL PULSAR ESTE BOTON SE VA A DESPLEGAR UN MODAL PARA ELIMINAR LA INFORMACIÓN DEL CLIENTE",
          },
          {
            intro:
              "FIN DEL RECORRIDO POR EL MÓDULO DE CLIENTES, ESPERO HABERTE AYUDADO",
          },
        ],

        nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
      })
      .start();
  });
});
