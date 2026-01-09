document.addEventListener("DOMContentLoaded", function () {
  let botonDeAyuda = document.getElementById("btnayudaRoles");

  botonDeAyuda.addEventListener("click", function () {
    introJs()
      .setOptions({
        steps: [
          {
            intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DE USUARIO EN LA SECCION DE ROLES",
          },

          {
            element: document.querySelector("#inicioPacientes"),
            intro: "ACÁ PODRÁS GESTIONAR LA INFORMACIÓN DE LOS ROLES QUE VAN A TENER LOS DISTINTOS USUARIOS",
          },
          {
            element: document.querySelector(".paginacion"),
            intro: "AQUI HAY UNA PAGINACION PARA PODER NAVEGAR ENTRE LOS USUARIOS, ADMINISTRADORES, ROLES",
          },
          {
            element: document.querySelector("#btnRegistrarrol"),
            intro: "AL OPRIMIR ESTE BOTÓN SE VA A DESPLEGAR UN MODAL CON UN FORMULARIO PARA REGISTRAR  LOS NUEVOS ROLES",
          },
          {
            element: document.querySelector(".caja-buscador-usuario"),
            intro: "AQUÍ TIENES UN BUSCADOR QUE AL COLOCAR EL NOMBRE DEL USUARIO VA A FILTRAR LOS RESULTADOS",
          },
          {
            element: document.querySelector(".caja-contenedor-tabla"),
            intro: "EN ESTA TABLA SE MUESTRA LA INFORMACIÓN DE TODOS LOS ROLES REGISTRADOS",
          },
          {
            element: document.querySelector(".mostrar"),
            intro:
              "AL PULSAR ESTE BOTON SE VA A DESPLEGAR UN MODAL CON LOS DETALLES DEL ROL INCLUYENDO SUS PERMISO ASOCIADOS ADEMAS  CON LAS OPCIONES DE EDITAR Y ELIMINAR",
          },
          {
            intro: "FIN DEL RECORRIDO POR EL MÓDULO DE USUARIOS EN LA SECCION ROLES, ESPERO HABERTE AYUDADO",
          },
        ],

        nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
      })
      .start();
  });
});
