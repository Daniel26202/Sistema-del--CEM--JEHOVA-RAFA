document.addEventListener("DOMContentLoaded", function () {
  let botonDeAyuda = document.getElementById("btnayudaAdministrador");

  botonDeAyuda.addEventListener("click", function () {
    introJs()
      .setOptions({
        steps: [
          {
            intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DE USUARIO EN LA SECCION DE ADMINISTRADORES",
          },

          {
            element: document.querySelector("#inicioPacientes"),
            intro: "ACÁ PODRÁS GESTIONAR LA INFORMACIÓN DE LOS USUARIOS ADMINISTRATIVOS",
          },
          {
            element: document.querySelector(".paginacion"),
            intro: "AQUI HAY UNA PAGINACION PARA PODER NAVEGAR ENTRE LOS USUARIOS, ADMINISTRADORES, ROLES",
          },
          {
            element: document.querySelector("#btnRegistrarPaciente"),
            intro:
              "AL OPRIMIR ESTE BOTÓN SE VA A DESPLEGAR UN MODAL CON UN FORMULARIO PARA REGISTRAR  LOS NUEVOS ADMINISTRADORES",
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
            intro: "FIN DEL RECORRIDO POR EL MÓDULO DE USUARIOS EN LA SECCION ADMINISTRADORES, ESPERO HABERTE AYUDADO",
          },
        ],

        nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
      })
      .start();
  });
});
