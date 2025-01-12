addEventListener("DOMContentLoaded", function () {

document.getElementById('btnayudaControl').addEventListener("click", function() {



    introJs().setOptions({
      steps: [
        {
          intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DEL DIRECTORIO MÉDICO"
        },
        {  
        element: document.querySelector('#inicioControlM'),
          intro:  "DESDE AQUÍ PODRÁS GESTIONAR EL CONTROL MÉDICO DE LOS PACIENTES"
        },
        {  
        element: document.querySelector('#btnControl'),
          intro: "ESTE BOTÓN DESPLIEGA UN MODAL DONDE PODRÁS REGISTRAR EL CONTROL DE UN PACIENTE"
        },
        {  
        element: document.querySelector('#form-buscador'),
          intro: "ESTE BUSCADOR TE PERMITE BUSCAR EL CONTROL DE UN PACIENTE "
        },
        {  
        element: document.querySelector('#tablaControl'),
          intro: "AQUÍ VAS A ENCONTRAR TODA LA INFORMACIÓN DE CADA CONTROL DE LOS PACIENTES"
        },
        {  
        element: document.querySelector('#ul-pacientes'),
          intro: "DE ESTE LADO ESTAN TODOS LOS PACIENTES QUE TIENEN UN CONTROL MÉDICO "
        },
        {  
        element: document.querySelector('#descripcionControl'),
          intro: "ESTE LADO CONTIENE LA DESCRIPCIÓN DEL CONTROL, PARA DESPLEGARLA DEBES HACER CLIC EN EL PACIENTE"
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
  });


