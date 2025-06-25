document.addEventListener("DOMContentLoaded", function () {
  let botonDeAyuda = document.getElementById("btnayudaUsuario");

  botonDeAyuda.addEventListener("click", function () {
    introJs()
      .setOptions({
        steps: [
          {
            intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DE USUARIO",
          },

          {
            element: document.querySelector("#inicioPacientes"),
            intro: "ACÁ PODRÁS GESTIONAR LA INFORMACIÓN DE LOS USUARIOS NORMALES",
          },
          {
            element: document.querySelector(".paginacion"),
            intro: "AQUI HAY UNA PAGINACION PARA PODER NAVEGAR ENTRE LOS USUARIOS, ADMINISTRADORES, ROLES",
          },
          {
            element: document.querySelector(".caja-buscador-usuario"),
            intro: "AQUÍ TIENES UN BUSCADOR QUE AL COLOCAR EL NOMBRE DEL USUARIO VA A FILTRAR LOS RESULTADOS",
          },
          {
            element: document.querySelector(".caja-contenedor-tabla"),
            intro: "EN ESTA TABLA SE MUESTRA LA INFORMACIÓN DE TODOS LOS USUARIOS REGISTRADOS",
          },
          {
            element: document.querySelector(".mostrar"),
            intro:
              "AL PULSAR ESTE BOTON SE VA A DESPLEGAR UN MODAL CON LOS DETALLES DEL USUARIO ADEMAS  CON LAS OPCIONES DE EDITAR Y ELIMINAR",
          },
          {
            intro: "FIN DEL RECORRIDO POR EL MÓDULO DE USUARIOS, ESPERO HABERTE AYUDADO",
          },
        ],

        nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
      })
      .start();
  });
});
