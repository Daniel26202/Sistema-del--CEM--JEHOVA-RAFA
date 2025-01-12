document.getElementById('btnayudaDoctores').addEventListener("click", function() {
  introJs().setOptions({
    steps: [
      {
        intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DEL DIRECTORIO MÉDICO"
      },
      {  
      element: document.querySelector('#inicioDirectorio'),
        intro: "DESDE AQUÍ PODRÁS GESTIONAR LOS SERVICIOS MÉDICOS, LOS DOCTORES, LOS SERVICIOS ADICIONALES Y LAS ENFERMERAS"
      },
      {  
      element: document.querySelector('#DMdoctores'),
        intro: "ACTUALMENTE TE TENCUENTRAS EN LA SECCIÓN DE LOS DOCTORES"
      },
      {  
      element: document.querySelector('#inicioServicio'),
        intro: "DESDE AQUÍ PODRÁS GESTIONAR LOS DOCTORES"
      },
      {  
      element: document.querySelector('#btnagregarDoctor'),
        intro: "ESTE BOTÓN DESPLIEGA UN MODAL DONDE PODRÁS  REGISTRAR NUEVOS DOCTORES"
      },
      {  
      element: document.querySelector('#buscadorDoctores'),
        intro: "ESTE BUSCADOR TE PERMITE BUSCAR LOS DOCTORES REGISTRADOS A TRAVÉS DE LA CI"
      },
      {  
      element: document.querySelector('#tabla'),
        intro: "AQUÍ SE ENCUENTRAN TODOS LOS DOCTORES REGISTRADOS"
      },
      {  
      element: document.querySelector('#btneditarDoctor'),
        intro: "ESTE BOTÓN TE PERMITE EDITAR EL DOCTOR "
      },
      {  
      element: document.querySelector('#btnEliminarDoctor'),
        intro: "ESTE BOTÓN TE PERMITE ELIMINAR EL DOCTOR"
      },
      {  
        element: document.querySelector('#btnEspecialidades'),
          intro: "ESTE BOTÓN TE PERMITE GESTIONAR LAS ESPECIALIDADES DE LOS DOCTORES"
        },
      {  
        element: document.querySelector('#DMservicioMedico'),
          intro: "EN ESTA SECCION SE ENCUENTRAN TODOS LOS SERVICIOS MÉDICOS REGISTRADOS "
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
        intro: "FIN DEL RECORRIDO POR EL MÓDULO DEL DIRECTORIO MÉDICO EN LA SECCIÓN DE DOCTORES, ESPERO HABERTE AYUDADO"
      }
    ], 

    nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
  }).start();
});
