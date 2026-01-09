document.getElementById('btnayudaDoctores').addEventListener("click", function() {
  introJs()
    .setOptions({
      steps: [
        {
          intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DEL DIRECTORIO MÉDICO",
        },
        {
          element: document.querySelector("#inicioServicio"),
          intro: "DESDE AQUÍ PODRÁS GESTIONAR LOS DOCTORES",
        },
        {
          element: document.querySelector("#btnagregarDoctor"),
          intro: "ESTE BOTÓN DESPLIEGA UN MODAL DONDE PODRÁS  REGISTRAR NUEVOS DOCTORES",
        },
        {
          element: document.querySelector("#btnEspecialidades"),
          intro: "ESTE BOTÓN TE PERMITE GESTIONAR LAS ESPECIALIDADES DE LOS DOCTORES",
        },
        {
          element: document.querySelector("#DMservicioMedico"),
          intro: "ESTE BOTÓN DESPLIEGA UN MODAL DONDE PODRÁS  REGISTRARLE UN SERVICIO MEDICO A UN DOCTOR. ",
        },
        {
          element: document.querySelector(".dt-search"),
          intro: "ESTE BUSCADOR TE PERMITE BUSCAR LOS DOCTORES REGISTRADOS A TRAVÉS DE LA CI",
        },
        {
          element: document.querySelector(".caja-contenedor-tabla"),
          intro: "AQUÍ SE ENCUENTRAN TODOS LOS DOCTORES REGISTRADOS",
        },
        {
          element: document.querySelector("#btneditarDoctor"),
          intro: "ESTE BOTÓN TE PERMITE EDITAR EL DOCTOR ",
        },
        {
          element: document.querySelector("#btnEliminarDoctor"),
          intro: "ESTE BOTÓN TE PERMITE ELIMINAR EL DOCTOR",
        },
        {
          element: document.querySelector(".botonesInfo"),
          intro: "ESTE BOTÓN TE PERMITE VER INFORMACIÓN DEL DOCTOR",
        },
  
        {
          intro: "FIN DEL RECORRIDO POR EL MÓDULO DEL DIRECTORIO MÉDICO, ESPERO HABERTE AYUDADO",
        },
      ],

      nextLabel: "Siguiente",
      prevLabel: "Anterior",
      doneLabel: "Finalizar",
    })
    .start();
});
