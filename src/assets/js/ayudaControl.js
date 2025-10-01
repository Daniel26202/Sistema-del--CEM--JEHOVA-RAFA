addEventListener("DOMContentLoaded", function () {

document.getElementById('btnayudaControl').addEventListener("click", function() {



    introJs()
      .setOptions({
        steps: [
          {
            intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DEL CONTROL MÉDICO",
          },
          {
            element: document.querySelector("#inicioControlM"),
            intro: "DESDE AQUÍ PODRÁS GESTIONAR LOS CONTROLES MÉDICOS DE LOS PACIENTES",
          },
          {
            element: document.querySelector("#btnControl"),
            intro: "ESTE BOTÓN DESPLIEGA UN MODAL DONDE PODRÁS REGISTRAR EL CONTROL DE UN PACIENTE",
          },
          {
            element: document.querySelector(".dt-search"),
            intro: "ESTE BUSCADOR TE PERMITE BUSCAR EL CONTROL DE UN PACIENTE ",
          },
          {
            element: document.querySelector("#controles"),
            intro: "AQUÍ VAS A ENCONTRAR TODA LA INFORMACIÓN DE CADA CONTROL DE LOS PACIENTES INCLUYENDO DOS BOTONES UNO PARA DETALLAR EL CONTROL Y EL OTRO PARA EDITAR EL MISMO",
          },
          {
            element: document.querySelector("#pacientes"),
            intro: "DE ESTE LADO ESTAN TODOS LOS PACIENTES QUE TIENEN UN CONTROL MÉDICO ",
          },
          {
            intro:
              "FIN DEL RECORRIDO POR EL MÓDULO DE CONTROL MÉDICO , ESPERO HABERTE AYUDADO",
          },
        ],

        nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
      })
      .start();
  });
  });


