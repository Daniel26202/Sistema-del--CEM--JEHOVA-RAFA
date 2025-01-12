document.getElementById('btnayudaCitaPBuscador').addEventListener("click", function() {
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
        element: document.querySelector('#citaHoy'),
          intro: "ACTUALMENTE TE ENCUENTRAS EN ESTA SECCIÓN, DONDE ENCONTRARAS TODAS LAS CITAS PENDIENTES POR ATENDER EL DÍA DE HOY"
        },
        {  
        element: document.querySelector('#btnRetrocederCita'),
          intro: "ESTE BOTÓN TE DEVUELVE A LA VISTA ANTERIOR"
        },
        {  
        element: document.querySelector('#tabla'),
          intro: "AQUÍ SE ENCUENTRAN TODAS LAS COINCIDENCIAS QUE SE ENCONTRARON"
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
        element: document.querySelector('#btnFacturarCitaP'),
          intro: "AL PRESIONAR ESTE BOTÓN, ENVÍA LA INFORMACIÓN DE LA CITA AL MÓDULO DE FACTURACIÓN PARA PROCEDER A REGISTRAR LA FACTURA"
        },
        {  
          element: document.querySelector('#citaPendiente'),
            intro: "EN ESTA SECCIÓN SE ENCUENTRAN LAS CITAS PENDIENTES POR ATENDER"
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
