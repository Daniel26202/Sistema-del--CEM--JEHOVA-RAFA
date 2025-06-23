document.addEventListener("DOMContentLoaded", function () {
  let botonDeAyuda = document.getElementById("btnayudaInsumo");

  botonDeAyuda.addEventListener("click", function () {
    introJs()
      .setOptions({
        steps: [
          {
            intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DE INSUMOS",
          },

          {
            element: document.querySelector("#inicioPacientes"),
            intro: "ACÁ PODRÁS GESTIONAR LA INFORMACIÓN DE LOS INSUMOS",
          },
          {
            element: document.querySelector("#paginationInsumos"),
            intro:
              "AQUI HAY UNA PAGINACION PARA PODER NAVEGAR ENTRE LOS INSUMOS, ENTRADAS, PROVEEDORES Y VENCIDOS",
          },
          {
            element: document.querySelector("#registrarInsumo"),
            intro:
              "AL OPRIMIR ESTE BOTÓN SE VA A DESPLEGAR UN MODAL CON UN FORMULARIO PARA REGISTRAR LA INFORMACIÓN DE LOS NUEVOS INSUMOS",
          },
          {
            element: document.querySelector("#form-buscador-insumo"),
            intro: "AQUÍ TIENES UN BUSCADOR QUE AL COLOCAR EL NOMBRE DEL INSUMO VA A FILTRAR LOS RESULTADOS",
          },
          {
            element: document.querySelector(".caja-contenedor-tabla"),
            intro: "EN ESTA TABLA SE MUESTRA LA INFORMACIÓN DE TODOS LOS INSUMOS REGISTRADOS",
          },
          {
            element: document.querySelector(".botones-mostrar"),
            intro:
              "AL PULSAR ESTE BOTON SE VA A DESPLEGAR UN MODAL CON LOS DETALLES DEL INSUMOS ADEMAS  CON LAS OPCIONES DE EDITAR Y ELIMINAR",
          },
          {
            intro: "FIN DEL RECORRIDO POR EL MÓDULO DE INSUMOS, ESPERO HABERTE AYUDADO",
          },
        ],

        nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
      })
      .start();
  });
});
