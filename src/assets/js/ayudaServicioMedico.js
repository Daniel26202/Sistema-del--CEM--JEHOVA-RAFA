document.getElementById("btnayudaServicioMedico").addEventListener("click", function () {
  introJs()
    .setOptions({
      steps: [
        {
          element: document.querySelector("#DMservicioMedico"),
          intro: "ACTUALMENTE TE TENCUENTRAS EN LA SECCIÓN DE LOS SERVICIOS MÉDICOS",
        },
        {
          element: document.querySelector("#inicioServicio"),
          intro: "DESDE AQUÍ PODRÁS GESTIONAR LOS SERVICIOS MÉDICOS",
        },
        {
          element: document.querySelector("#btnAgregarServicioMedico"),
          intro: "ESTE BOTÓN DESPLIEGA UN MODAL DONDE PODRÁS  REGISTRAR NUEVOS SERVICIOS MÉDICOS DISPONIBLES",
        },
        {
          element: document.querySelector("#btnAgregarCategoria"),
          intro: "ESTE BOTÓN DESPLIEGA UN MODAL DONDE PODRÁS  REGISTRAR NUEVAS CATEGORIAS DE SERVICIOS",
        },
        {
          element: document.querySelector("#btnAgregarServicioMedicoPapelera"),
          intro: "ESTE BOTÓN TE ENVIARA A LA PAPELERA DE LOS SERVICIOS MEDICOS",
        },
        {
          element: document.querySelector(".dt-search"),
          intro: "ESTE BUSCADOR TE PERMITE BUSCAR LOS SERVICIOS MÉDICOS REGISTRADOS A TRAVÉS DE LA ESPECIALIDAD",
        },
        {
          element: document.querySelector(".caja-contenedor-tabla"),
          intro: "AQUÍ SE ENCUENTRAN TODOS LOS SERVICIOS MÉDICOS REGISTRADOS",
        },
        {
          element: document.querySelector("#btnEditarServicioMedico"),
          intro: "ESTE BOTÓN TE PERMITE EDITAR EL SERVICIO MÉDICO ",
        },
        {
          element: document.querySelector("#btnEliminarServicioMedico"),
          intro: "ESTE BOTÓN TE PERMITE ELIMINAR EL SERVICIO MÉDICO",
        },
        {
          intro:
            "FIN DEL RECORRIDO POR  EL MODULO DE SERVICIOS MÉDICOS, ESPERO HABERTE AYUDADO",
        },
      ],

      nextLabel: "Siguiente",
      prevLabel: "Anterior",
      doneLabel: "Finalizar",
    })
    .start();
});
