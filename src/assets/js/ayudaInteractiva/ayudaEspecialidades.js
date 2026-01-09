document.getElementById('btnayudaEspecialidades').addEventListener("click", function() {
  introJs().setOptions({
    steps: [
      {
        intro: "AÚN TE ENCUENTRAS EN EL MÓDULO DEL DIRECTORIO MÉDICO"
      },
      {  
      element: document.querySelector('#EspecialidadesAyuda'),
        intro: "DESDE AQUÍ PODRÁS GESTIONAR LAS ESPECIALIDADES"
      },
      {  
      element: document.querySelector('#form-buscador'),
        intro: "ESTE BUSCADOR TE PERMITE BUSCAR LAS ESPECIALIDADES REGISTRADAS A TRAVÉS DE SU NOMBRE"
      },
      {  
      element: document.querySelector('#tablaEspecialidad'),
        intro: "AQUÍ SE ENCUENTRAN TODAS LAS ESPECIALIDADES REGISTRADAS"
      },
      {  
      element: document.querySelector('#btnEliminarEspecialidad'),
        intro: "ESTE BOTÓN TE PERMITE ELIMINAR LAS ESPECIALIDADES"
      },
      {  
      element: document.querySelector('#botonAgregarEspecialidad'),
        intro: "ESTE BOTÓN TE LLEVA A REGISTRAR NUEVAS ESPECIALIDADES"
      },
      {  
      element: document.querySelector('#cerrarModalEspecialidad'),
        intro: "ESTE BOTÓN CIERRA EL MODAL"
      },
      {
        element: document.querySelector('#btnayudaEspecialidades'),
          intro: "PARA ACCEDER A LA AYUDA PRESIONA ESTE BOTÓN "
        },
      {
        intro: "FIN DEL RECORRIDO POR LAS ESPECIALIDADES, ESPERO HABERTE AYUDADO"
      }
    ], 

    nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
  }).start();
});
document.getElementById('btnayudaEspecialidades3').addEventListener("click", function() {
  introJs().setOptions({
    steps: [
      {
        intro: "AÚN TE ENCUENTRAS EN LAS ESPECIALIDADES"
      },
      {  
      element: document.querySelector('#eliminarEspecialidad'),
        intro: "DESDE AQUÍ PODRÁS ELIMINAR LAS ESPECIALIDADES"
      },
      {  
      element: document.querySelector('#btnEliminarEspecialidad'),
        intro: "AL PRESIONAR ESTE BOTÓN SE ELIMINA LA ESPECIALIDAD"
      },
      {  
      element: document.querySelector('#cancelarEliminacion'),
        intro: "ESTE BOTÓN CANCELA LA ELIMINACION Y CIERRA EL MODAL"
      },
      
      {
        element: document.querySelector('#btnayudaEspecialidades3'),
          intro: "PARA ACCEDER A LA AYUDA PRESIONA ESTE BOTÓN "
        },
      {
        intro: "FIN DEL RECORRIDO POR LA ELIMINACIÓN DE LAS ESPECIALIDADES, ESPERO HABERTE AYUDADO"
      }
    ], 

    nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
  }).start();
});


document.getElementById('btnayudaEspecialidades2').addEventListener("click", function() {
  introJs().setOptions({
    steps: [
      {
        intro: "AÚN TE ENCUENTRAS EN LAS ESPECIALIDADES"
      },
      {  
      element: document.querySelector('#registrarEspecialidades'),
        intro: "DESDE AQUÍ PODRÁS REGISTRAR LAS ESPECIALIDADES"
      },
      {  
      element: document.querySelector('#grp_nombre'),
        intro: "ESCRIBE AQUÍ EL NOMBRE DE LA ESPECIALIDAD"
      },
      {  
      element: document.querySelector('#botonEnviarEspecialidad'),
        intro: "AL PRESIONAR ESTE BOTÓN SE REGISTRA LA NUEVA ESPECIALIDAD"
      },
      {  
      element: document.querySelector('#cancelarRegistroespecialidades'),
        intro: "ESTE BOTÓN TE DEVUELVE AL MODAL ANTERIOR"
      },
      {
        element: document.querySelector('#btnayudaEspecialidades2'),
          intro: "PARA ACCEDER A LA AYUDA PRESIONA ESTE BOTÓN "
        },
      {
        intro: "FIN DEL RECORRIDO POR EL REGISTRO DE LAS ESPECIALIDADES, ESPERO HABERTE AYUDADO"
      }
    ], 

    nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
  }).start();
});

