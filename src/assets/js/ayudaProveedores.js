document.addEventListener("DOMContentLoaded", function () {
  let botonDeAyuda = document.getElementById("btnayudaProveedor");
  botonDeAyuda.addEventListener("click", function () {
    introJs()
      .setOptions({
        steps: [
          {
            intro: "AHORA TE ENCUENTRAS EN LA SECCION PROVEEDORES DEL MODULO INSUMOS",
          },

          {
            element: document.querySelector("#inicioPacientes"),
            intro: "ACÁ PODRÁS GESTIONAR LA INFORMACIÓN DE TODOS LOS PROVEEDORES",
          },
          {
            element: document.querySelector(".registrarEntrada"),
            intro:
              "AL OPRIMIR ESTE BOTÓN SE VA A DESPLEGAR UN MODAL CON UN FORMULARIO PARA REGISTRAR LA INFORMACIÓN DE LOS NUEVOS PROVEEDORES",
          },
          {
            element: document.querySelector(".dt-search"),
            intro: "AQUÍ TIENES UN BUSCADOR PARA FILTRAR LOS PROVEEDORES",
          },
          {
            element: document.querySelector(".caja-contenedor-tabla"),
            intro: "EN ESTA TABLA SE MUESTRA LA INFORMACIÓN DE TODOS LOS PROVEEDORES REGISTRADOS",
          },
          {
            element: document.querySelector(".btnEditarDoctor"),
            intro: "AL PULSAR ESTE BOTON SE VA A DESPLEGAR UN MODAL PARA MODIFICAR LA INFORMACIÓN DEL PROVEEDOR",
          },
          {
            element: document.querySelector(".btnEliminarDoctor"),
            intro: "AL PULSAR ESTE BOTON SE VA A DESPLEGAR UN MODAL PARA ELIMINAR LA INFORMACIÓN DEL PROVEEDOR",
          },

          {
            intro: "FIN DEL RECORRIDO POR LA SECCION DE PROVEEDORES, ESPERO HABERTE AYUDADO",
          },
        ],

        nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
      })
      .start();
  });
});
