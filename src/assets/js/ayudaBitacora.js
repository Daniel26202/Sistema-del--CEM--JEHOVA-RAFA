document.addEventListener("DOMContentLoaded", function () {   
  let botonDeAyuda = document.getElementById("btnayudaBitacora");
  botonDeAyuda.addEventListener("click", function () {
    console.log(botonDeAyuda);
    introJs()
      .setOptions({
        steps: [
          {
            intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DE BITACORA",
          },

          {
            element: document.querySelector("#inicioPacientes"),
            intro: "ACÁ PODRÁS CONSULTAR LA INFORMACIÓN DE LAS DISTINTAS ACCIONES QUE SE REALIZARON EN EL SISTEMA",
          },
          {
            element: document.querySelector(".sin-circulos"),
            intro:
              "AQUI HAY UNA PAGINACION PARA PODER NAVEGAR ENTRE LOS LA BITACORA PROPIA (SOLO MIS ACCIONES) Y LA BITACORA DE TODOS LOS USUARIOS (SOLO ESTA DISPONOBLE SI ES EL SUPER ADMINISTRADOR)",
          },
          {
            element: document.querySelector(".dt-search"),
            intro: "AQUÍ TIENES UN BUSCADOR QUE AL COLOCAR CUALQUIER DATO SE VA A FILTRAR LOS RESULTADOS",
          },
          {
            element: document.querySelector(".caja-contenedor-tabla"),
            intro: "EN ESTA TABLA SE MUESTRA LA INFORMACIÓN DE TODOS LAS ACCIONES  RAELIZADAS",
          },

          {
            intro: "FIN DEL RECORRIDO POR EL MÓDULO DE BITACORA, ESPERO HABERTE AYUDADO",
          },
        ],

        nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
      })
      .start();
  });
});
