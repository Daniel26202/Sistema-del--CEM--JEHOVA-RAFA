document.getElementById('btnayudaSA').addEventListener("click", function() {
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
        element: document.querySelector('#DMserviciosExtras'),
          intro: "ACTUALMENTE TE TENCUENTRAS EN LA SECCIÓN DE LOS SERVICIOS ADICIONALES"
        },
        {  
        element: document.querySelector('#inicioServicio'),
          intro: "DESDE AQUÍ PODRÁS GESTIONAR LOS SERVICIOS ADICIONALES"
        },
        {  
        element: document.querySelector('#btnEspecialidades'),
          intro: "ESTE BOTÓN DESPLIEGA UN MODAL DONDE PODRÁS  REGISTRAR NUEVOS SERVICIOS ADICIONALES DISPONIBLES"
        },
        {  
        element: document.querySelector('#formServAdicionales'),
          intro: "ESTE BUSCADOR TE PERMITE BUSCAR LOS SERVICIOS ADICIONALES REGISTRADOS A TRAVÉS DEL SERVICIO"
        },
        {  
        element: document.querySelector('#tablaespecialidad'),
          intro: "AQUÍ SE ENCUENTRAN TODOS LOS SERVICIOS ADICIONALES REGISTRADOS"
        },
        {  
        element: document.querySelector('#btnEditarSA'),
          intro: "ESTE BOTÓN TE PERMITE EDITAR EL SERVICIO ADICIONAL "
        },
        {  
        element: document.querySelector('#btnEliminarSA'),
          intro: "ESTE BOTÓN TE PERMITE ELIMINAR EL SERVICIO ADICIONAL"
        },
        {  
          element: document.querySelector('#DMservicioMedico'),
            intro: "LOS SERVICIOS MÉDICOS QUE OFRECE EL CENTRO MÉDICO SE ENCUENTRAN EN ESTA SECCIÓN"
          },
        {  
          element: document.querySelector('#DMdoctores'),
            intro: "EN ESTA SECCION SE ENCUENTRAN TODOS LOS DOCTORES REGISTRADOS "
          },
       
        {
          element: document.querySelector('#desplegablefactura'),
            intro: "PARA DESPLEGAR LA LISTA TIENES QUE PASAR EL MOUSE POR ESTE ÍCONO, EN LA LISTA ECONTRARAS UN BOTÓN PARA IR AL PERFIL, EL BOTÓN PARA ACCEDER A LA AYUDA Y EL BOTÓN PARA SALIR DEL SISTEMA"
          },
        {
          intro: "FIN DEL RECORRIDO POR EL MÓDULO DEL DIRECTORIO MÉDICO EN LA SECCIÓN DE SERVICIOS ADICIONALES, ESPERO HABERTE AYUDADO"
        }
      ], 

      nextLabel: "Siguiente",
          prevLabel: "Anterior",
          doneLabel: "Finalizar",
    }).start();
  });


