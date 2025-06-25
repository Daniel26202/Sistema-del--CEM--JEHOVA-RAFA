document.addEventListener("DOMContentLoaded", function () {
  let botonDeAyuda = document.getElementById("btnayudaReporte");

  botonDeAyuda.addEventListener("click", function () {
    introJs()
      .setOptions({
        steps: [
          {
            intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DE REPORTES",
          },

          {
            element: document.querySelector("#inicioPacientes"),
            intro: "ACÁ PODRÁS GESTIONAR LA INFORMACIÓN DE LOS DISTINTOS REPORTES",
          },
          {
            element: document.querySelector(".caja-contenedor-tabla"),
            intro: "AQUÍ SE MUESTRA TARJETAS CON DISTINTOS REPORTES CADA UNA",
          },
          {
            element: document.querySelector(".reporte-citas"),
            intro:
              "AL PULSAR ESTA TARJETA SE VA A DESPLEGAR UN MODAL PARA FILTRAR TODAS LAS CITAS REALIZADAS EN UN RANGO DE TIEMPO DETERMINADO LUEGO QUE SE FILTRE SE PUEDE IMPRIMIR ESA INFORMACION EN UN PDF",
          },
          {
            element: document.querySelector(".reporte-pacientes"),
            intro:
              "AL PULSAR ESTA TARJETA TE VA A MOSTRAR UN PDF CON LOS DATOS DE TODOS LOS PACIENTES REGISTRADOS EN EL SISTEMA.",
          },
          {
            element: document.querySelector(".reporte-entradas"),
            intro:
              "AL PULSAR ESTA TARJETA SE VA A DESPLEGAR UN MODAL PARA FILTRAR TODAS LAS ENTRADAS DE INSUMOS  EN UN RANGO DE TIEMPO DETERMINADO LUEGO QUE SE FILTRE SE PUEDE IMPRIMIR ESA INFORMACION EN UN PDF",
          },
          {
            element: document.querySelector(".reporte-insumos"),
            intro: "AL PULSAR ESTA TARJETA TE VA A MOSTRAR UN PDF CON LOS DATOS DE TODOS LOS INSUMOS REGISTRADOS EN EL SISTEMA.",
          },
          {
            element: document.querySelector(".reporte-facturas"),
            intro:
              "AL PULSAR ESTA TARJETA SE VA A DESPLEGAR UN MODAL PARA CON TODAS LAS FACTURAS REALIZADAS SE PUEDEN ANULAR (SI ESA FACTURA CINTENIA INSUMOS ESOSVUELVEN AL STOCK) ASI MISMO SE  PUEDEN IMPRIMIR CADA FACTURA INDIVIDUALMENTE.",
          },
          {
            intro: "FIN DEL RECORRIDO POR EL MÓDULO DE USUARIOS, ESPERO HABERTE AYUDADO",
          },
        ],

        nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
      })
      .start();
  });
});
