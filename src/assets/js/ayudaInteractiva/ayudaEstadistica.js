document.addEventListener("DOMContentLoaded", function () {
  let botonDeAyuda = document.getElementById("btnayudaEstadistica");

  botonDeAyuda.addEventListener("click", function () {
    introJs()
      .setOptions({
        steps: [
          {
            intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DE REPORTES ESTADISTICOS",
          },

          {
            element: document.querySelector("#inicioPacientes"),
            intro: "ACÁ PODRÁS GESTIONAR LA INFORMACIÓN DE LOS DISTINTOS REPORTES ESTADISTICOS PARA LA TOMA DICISIONES",
          },
          {
            element: document.querySelector(".caja-contenedor-tabla"),
            intro: "AQUÍ SE MUESTRA TARJETAS CON DISTINTOS REPORTES ESTADISTICOS CADA UNA",
          },
          {
            element: document.querySelector(".reporte-distribucion"),
            intro:
              "ESTA ESTADISTICA MUESTRA LA DISTRIBUCIÓN DE PACIENTES QUE HAY REGISTRADOS  SEPARANDOLOS EN GRUPOS DE GENERO Y EDAD",
          },
          {
            element: document.querySelector(".btn-reporte-distribucion"),
            intro:
              "CON UN CLICK SE DESPLEGARA UN MODAL CON LA GRAFICA ANTES MENCIONA CON LA OPCION DE DESCARGARLO EN FORMATO PDF ",
          },
          {
            element: document.querySelector(".reporte-morbilidad"),
            intro:
              "ESTA ESTADISTICA MUESTRA LA TASA DE MORBILIDAD EN LA CLINICA (LA MORBILIDAD ES LA CANTIDAD DE PERSONASQUE PRESENTANT ALGUNA ENERMEDAD) EN ESTE CASO, POR CADA 1000 ATENDIDOS",
          },
          {
            element: document.querySelector(".btn-reporte-morbilidad"),
            intro:
              "CON UN CLICK SE DESPLEGARA UN MODAL CON LA GRAFICA ANTES MENCIONA CON LA OPCION DE DESCARGARLO EN FORMATO PDF Y FILTRAR POR FECHA",
          },
          {
            element: document.querySelector(".reporte-insumo"),
            intro: "ESTA ESTADISTICA MUESTRA LOS INSUMOS UTILIZADOS EN LA CLINICA",
          },
          {
            element: document.querySelector(".btn-reporte-insumo"),
            intro:
              "CON UN CLICK SE DESPLEGARA UN MODAL CON LA GRAFICA ANTES MENCIONA CON LA OPCION DE DESCARGARLO EN FORMATO PDF ",
          },
          {
            element: document.querySelector(".reporte-especialidades"),
            intro: "AQUÍ PODRÁS VISUALIZAR INFORMACION DE LAS 5 ESPECIALIDADES MAS SOLICITADAS EN FORMA GRAFICA.",
          },
          {
            element: document.querySelector(".btn-reporte-especialidades"),
            intro:
              "CON UN CLICK SE DESPLEGARA UN MODAL CON LA GRAFICA ANTES MENCIONA CON LA OPCION DE DESCARGARLO EN FORMATO PDF Y FILTRAR POR FECHA",
          },
          {
            element: document.querySelector(".reporte-sintoma"),
            intro: "AQUÍ PODRÁS VISUALIZAR INFORMACION DE LAS 5 SINTOMAS MAS COMUNES EN FORMA GRAFICA",
          },
          {
            element: document.querySelector(".btn-reporte-sintoma"),
            intro:
              "CON UN CLICK SE DESPLEGARA UN MODAL CON LA GRAFICA ANTES MENCIONA CON LA OPCION DE DESCARGARLO EN FORMATO PDF Y FILTRAR POR FECHA",
          },
          {
            intro: "FIN DEL RECORRIDO POR EL MÓDULO DE REPORTES ESTADISTICOS, ESPERO HABERTE AYUDADO",
          },
        ],

        nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
      })
      .start();
  });
});
