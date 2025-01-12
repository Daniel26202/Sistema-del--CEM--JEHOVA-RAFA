document.getElementById('btnayudaCitaP').addEventListener("click", function() {
    introJs().setOptions({
      steps: [
        {
          intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DE CITAS"
        },
        {  
        element: document.querySelector('#inicioCita'),
          intro: "DESDE AQUÍ PODRÁS GESTIONAR LAS CITAS DE LOS PACIENTES"
        },
        {  
        element: document.querySelector('#citaPendiente'),
          intro: "ACTUALMENTE TE ENCUENTRAS EN ESTA SECCIÓN, DONDE ENCONTRARAS TODAS LAS CITAS PENDIENTES POR ATENDER"
        },
        {  
        element: document.querySelector('#btnAgendarCita'),
          intro: "ESTE BOTÓN DESPLIEGA UN MODAL DONDE PODRÁS AGENDAR LAS CITAS DE LOS PACIENTES"
        },
        {  
        element: document.querySelector('#buscadorCitasP'),
          intro: "CON ESTE BUSCADOR PODRÁS BUSCAR LA CITAS PENDIETES DE UN PACIENTE A TRAVÉS DE SU CI"
        },
        {  
        element: document.querySelector('#tabla'),
          intro: "AQUÍ SE ENCUENTRAN TODAS LAS CITAS PENDIENTES"
        },
        {  
        element: document.querySelector('#btnEditarCitaPendiente'),
          intro: "ESTE BOTÓN TE PERMITE EDITAR LA CITA DEL PACIENTE"
        },
        {  
        element: document.querySelector('#eliminarCitaP'),
          intro: "ESTE BOTÓN TE PERMITE ELIMINAR LA CITA DEL PACIENTE"
        },
        {  
          element: document.querySelector('#citaHoy'),
            intro: "EN ESTA SECCION SE ENCUENTRAN LAS CITAS PENDIENTES PARA EL DÍA DE HOY"
          },
        {  
          element: document.querySelector('#citaRealizada'),
            intro: "TODAS LAS CITAS QUE YA FUERON ATENDIDAS Y FACTURADAS SE ENCUENTRAN EN ESTA SECCIÓN"
          },
        {
          element: document.querySelector('#desplegablefactura'),
            intro: "PARA DESPLEGAR LA LISTA TIENES QUE PASAR EL MOUSE POR ESTE ÍCONO, EN LA LISTA ECONTRARAS UN BOTÓN PARA IR AL PERFIL, EL BOTÓN PARA ACCEDER A LA AYUDA Y EL BOTÓN PARA SALIR DEL SISTEMA"
          },
        {
          intro: "FIN DEL RECORRIDO POR EL MÓDULO DE CITAS, ESPERO HABERTE AYUDADO"
        }
      ], 

      nextLabel: "Siguiente",
          prevLabel: "Anterior",
          doneLabel: "Finalizar",
    }).start();
  });



  // document.getElementById('btnayudaFacturaIDCita').addEventListener("click", function() {
  //   introJs().setOptions({
  //     steps: [
  //       {
  //         intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DE FACTURACIÓN"
  //       },
    
  //     {
  //         element: document.querySelector('#inicioFactura'),
  //         intro: "DESDE AQUÍ PODRÁS FACTURAR LOS SERVICIOS MÉDICOS, LOS SERVICIOS EXTRAS Y LOS INSUMOS"
  //       },
  //       {
  //           element: document.querySelector('#botonAgregar'),
  //           intro: "CON ESTE BOTÓN PUEDES INSERTAR SERVICIOS EXTRAS A LA FACTURA"
  //         },
  //         {
  //           element: document.querySelector('#btnInsumos'),
  //           intro: "AQUI TIENES TODOS LOS INSUMOS DISPONIBLES"
  //         },
  //         {
  //           element: document.querySelector('#btnRetrocederFactura'),
  //           intro: "AL OPRIMIR ESTE BOTON PODRÁS RETROCEDER AL MÓDULO DE CITAS NUEVAMENTE"
  //         },
  //       {
  //         element: document.querySelector('#tablaDB'),
  //         intro: "EN ESTA SECCIÓN SE MUESTRA EL SERVICIO MÉDICO A FACTURAR"
  //       },
  //       {
  //         element: document.querySelector('#tablaSE'),
  //         intro: "EN ESTA SECCIÓN SE MUESTRAN LOS SERVICIOS EXTRAS INSERTADOS"
  //       },
  //       {
  //         element: document.querySelector('#tablaIM'),
  //         intro: "EN ESTA SECCIÓN SE MUESTRAN LOS INSUMOS QUE AGREGUES A LA FACTURA"
  //       },
  //       {
  //         element: document.querySelector('#vaciarTabla'),
  //         intro: "AL PULSAR ESTE BOTÓN SE VACÍA LA FACTURA"
  //       },
  //       {
  //         element: document.querySelector('#siguienteFact'),
  //         intro: "AL PULSAR ESTE BOTÓN SE VA A DESPLEGAR UN MODAL PARA LA GESTIÓN DEL PAGO Y LA CONFIRMACIÓN DE LA FACTURA"
  //       },
  //       {
  //         element: document.querySelector('#totalFac'),
  //         intro: "AQUÍ PODRAS VER EL TOTAL DE LA FACTURA"
  //       },
  //       {
  //         element: document.querySelector('#desplegablefactura2'),
  //         intro: "PARA DESPLEGAR LA LISTA TIENES QUE PASAR EL MOUSE POR ESTE ÍCONO, EN LA LISTA ECONTRARAS UN BOTÓN PARA IR AL PERFIL, EL BOTÓN PARA ACCEDER A LA AYUDA Y EL BOTÓN PARA SALIR DEL SISTEMA"
  //       },
  //       {
  //         intro: "FIN DEL RECORRIDO POR EL MÓDULO DE FACTURACIÓN, ESPERO HABERTE AYUDADO"
  //       }
  //     ], 

  //     nextLabel: "Siguiente",
  //         prevLabel: "Anterior",
  //         doneLabel: "Finalizar",
  //   }).start();
  // });