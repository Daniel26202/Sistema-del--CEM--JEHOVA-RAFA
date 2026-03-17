document.getElementById('btnayudaCitaP').addEventListener("click", function() {
    introJs()
      .setOptions({
        steps: [
          {
            intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DE CITAS",
          },
          {
            element: document.querySelector("#inicioCita"),
            intro: "DESDE AQUÍ PODRÁS GESTIONAR LAS CITAS DE LOS PACIENTES",
          },
          {
            element: document.querySelector(".activo-borde"),
            intro: "ACTUALMENTE TE ENCUENTRAS EN ESTA SECCIÓN",
          },
          {
            element: document.querySelector("#citaPendiente"),
            intro: "EN ESTA SECCION SE ENCUENTRAN TODAS LAS CITAS PENDIENTES",
          },
          {
            element: document.querySelector("#citaHoy"),
            intro:
              "EN ESTA SECCION SE ENCUENTRAN LAS CITAS PENDIENTES PARA EL DÍA DE HOY",
          },
          {
            element: document.querySelector("#citaRealizada"),
            intro:
              "TODAS LAS CITAS QUE YA FUERON ATENDIDAS Y FACTURADAS SE ENCUENTRAN EN ESTA SECCIÓN",
          },
          {
            element: document.querySelector(".btnOpenModal"),
            intro:
              "ESTE BOTÓN DESPLIEGA UN MODAL DONDE PODRÁS AGENDAR LAS CITAS DE LOS PACIENTES",
          },
          {
            element: document.querySelector(".dt-search"),
            intro:
              "CON ESTE BUSCADOR PODRÁS BUSCAR LA CITAS PENDIETES DE UN PACIENTE A TRAVÉS DE CUALQUIER DATO",
          },
          {
            element: document.querySelector(".caja-contenedor-tabla"),
            intro: "AQUÍ SE ENCUENTRAN TODAS LAS CITAS PENDIENTES",
          },
          {
            element: document.querySelector(".botonesEdi"),
            intro: "ESTE BOTÓN TE PERMITE EDITAR LA CITA DEL PACIENTE",
          },
          {
            element: document.querySelector("#eliminarCitaP"),
            intro: "ESTE BOTÓN TE PERMITE ELIMINAR LA CITA DEL PACIENTE",
          },
          {
            intro:
              "FIN DEL RECORRIDO POR EL MÓDULO DE CITAS, ESPERO HABERTE AYUDADO",
          },
        ],

        nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
      })
      .start();
  });


