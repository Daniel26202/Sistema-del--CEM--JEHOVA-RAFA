document.getElementById('btnayudaServicioMedico').addEventListener("click", function() {
    introJs().setOptions({
      steps: [
        {
          intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DEL DIRECTORIO MÉDICO"
        },
        {  
        element: document.querySelector('#inicioDirectorio'),
          intro:  "DESDE AQUÍ PODRÁS GESTIONAR LOS SERVICIOS MÉDICOS, LOS DOCTORES, LOS SERVICIOS ADICIONALES Y LAS ENFERMERAS"
        },
        {  
        element: document.querySelector('#DMservicioMedico'),
          intro: "ACTUALMENTE TE TENCUENTRAS EN LA SECCIÓN DE LOS SERVICIOS MÉDICOS"
        },
        {  
        element: document.querySelector('#inicioServicio'),
          intro: "DESDE AQUÍ PODRÁS GESTIONAR LOS SERVICIOS MÉDICOS"
        },
        {  
          element: document.querySelector('#btnRetrocederCita'),
            intro: "ESTE BOTÓN TE DEVUELVE A LA VISTA ANTERIOR"
          },
        {  
        element: document.querySelector('#tabla'),
          intro: "AQUÍ SE ENCUENTRAN TODAS LOS SERVICIOS MÉDICOS REGISTRADOS"
        },
        {  
        element: document.querySelector('#btnEditarServicioMedico'),
          intro: "ESTE BOTÓN TE PERMITE EDITAR EL SERVICIO MÉDICO "
        },
        {  
        element: document.querySelector('#btnEliminarServicioMedico'),
          intro: "ESTE BOTÓN TE PERMITE ELIMINAR EL SERVICIO MÉDICO"
        },
        {  
          element: document.querySelector('#DMdoctores'),
            intro: "EN ESTA SECCION SE ENCUENTRAN TODOS LOS DOCTORES REGISTRADOS "
          },
        {  
          element: document.querySelector('#DMserviciosExtras'),
            intro: "LOS SERVICIOS EXTRAS QUE OFRECE EL CENTRO MÉDICO SE ENCUENTRAN EN ESTA SECCIÓN"
          },
        {
          element: document.querySelector('#desplegablefactura'),
            intro: "PARA DESPLEGAR LA LISTA TIENES QUE PASAR EL MOUSE POR ESTE ÍCONO, EN LA LISTA ECONTRARAS UN BOTÓN PARA IR AL PERFIL, EL BOTÓN PARA ACCEDER A LA AYUDA Y EL BOTÓN PARA SALIR DEL SISTEMA"
          },
        {
          intro: "FIN DEL RECORRIDO POR EL MÓDULO DEL DIRECTORIO MÉDICO EN LA SECCIÓN DE SERVICIOS MÉDICOS, ESPERO HABERTE AYUDADO"
        }
      ], 

      nextLabel: "Siguiente",
          prevLabel: "Anterior",
          doneLabel: "Finalizar",
    }).start();
  });


