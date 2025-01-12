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
        element: document.querySelector('#citaRealizada'),
          intro: "ACTUALMENTE TE ENCUENTRAS EN ESTA SECCIÓN, DONDE ENCONTRARAS TODAS LAS CITAS QUE YA HAN SIDO REALIZADAS"
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
        element: document.querySelector('#eliminarCitaP'),
          intro: "ESTE BOTÓN TE PERMITE ELIMINAR EL REGISTRO DE LA CITA DEL PACIENTE"
        },
        {  
          element: document.querySelector('#citaPendiente'),
            intro: "EN ESTA SECCIÓN SE ENCUENTRAN LAS CITAS PENDIENTES POR ATENDER"
          },
        {  
          element: document.querySelector('#citaHoy'),
            intro: "EN ESTA SECCION SE ENCUENTRAN LAS CITAS PENDIENTES PARA EL DÍA DE HOY"
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
