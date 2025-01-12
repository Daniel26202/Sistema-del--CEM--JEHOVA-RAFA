document.getElementById('btnAyudaSintomas').addEventListener("click", function() {
  introJs().setOptions({
    steps: [
      {
        intro: "AÚN TE ENCUENTRAS EN EL MÓDULO DE CONTROL MÉDICO"
      },
      {  
      element: document.querySelector('#sintomasAyuda'),
        intro: "DESDE AQUÍ PODRÁS GESTIONAR LOS SÍNTOMAS"
      },
      {  
      element: document.querySelector('#form-buscadorS'),
        intro: "ESTE BUSCADOR TE PERMITE BUSCAR LOS SÍNTOMAS REGISTRADOS A TRAVÉS DE SU NOMBRE"
      },
      {  
      element: document.querySelector('#tablaSintomas'),
        intro: "AQUÍ SE ENCUENTRAN TODOS LOS SÍNTOMAS REGISTRADOS"
      },
      {  
      element: document.querySelector('#btnEliminarSintomas'),
        intro: "ESTE BOTÓN TE PERMITE ELIMINAR LOS SÍNTOMAS"
      },
      {  
      element: document.querySelector('#botonAgregarSintomas'),
        intro: "ESTE BOTÓN TE LLEVA A REGISTRAR NUEVOS SÍNTOMAS"
      },
      {  
      element: document.querySelector('#cerrarModalSintomas'),
        intro: "ESTE BOTÓN CIERRA EL MODAL"
      },
      {
        element: document.querySelector('#btnAyudaSintomas'),
          intro: "PARA ACCEDER A LA AYUDA PRESIONA ESTE BOTÓN "
        },
      {
        intro: "FIN DEL RECORRIDO POR LOS SÍNTOMAS, ESPERO HABERTE AYUDADO"
      }
    ], 

    nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
  }).start();
});
document.getElementById('btnAyudaSintomas3').addEventListener("click", function() {
  introJs().setOptions({
    steps: [
      {
        intro: "AÚN TE ENCUENTRAS EN LOS SÍNTOMAS"
      },
      {  
      element: document.querySelector('#eliminarSintomas'),
        intro: "DESDE AQUÍ PODRÁS ELIMINAR LOS SÍNTOMAS"
      },
      {  
      element: document.querySelector('#btnEliminarSintomasM'),
        intro: "AL PRESIONAR ESTE BOTÓN SE ELIMINA EL SÍNTOMA"
      },
      {  
      element: document.querySelector('#cancelarEliminacion'),
        intro: "ESTE BOTÓN CANCELA LA ELIMINACION Y CIERRA EL MODAL"
      },
      
      {
        element: document.querySelector('#btnAyudaSintomas3'),
          intro: "PARA ACCEDER A LA AYUDA PRESIONA ESTE BOTÓN "
        },
      {
        intro: "FIN DEL RECORRIDO POR LA ELIMINACIÓN DE LOS SÍNTOMAS, ESPERO HABERTE AYUDADO"
      }
    ], 

    nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
  }).start();
});


document.getElementById('btnAyudaSintomas2').addEventListener("click", function() {
  introJs().setOptions({
    steps: [
      {
        intro: "AÚN TE ENCUENTRAS EN LAS SÍNTOMAS"
      },
      {  
      element: document.querySelector('#registrarSintomas'),
        intro: "DESDE AQUÍ PODRÁS REGISTRAR LOS SÍNTOMAS"
      },
      {  
      element: document.querySelector('#grp_nombre'),
        intro: "ESCRIBE AQUÍ EL NOMBRE DEL SÍNTOMA"
      },
      {  
      element: document.querySelector('#botonEnviarSintomas'),
        intro: "AL PRESIONAR ESTE BOTÓN SE REGISTRA EL NUEVO SÍNTOMA"
      },
      {  
      element: document.querySelector('#cancelarRegistroSintomas'),
        intro: "ESTE BOTÓN TE DEVUELVE AL MODAL ANTERIOR"
      },
      {
        element: document.querySelector('#btnAyudaSintomas2'),
          intro: "PARA ACCEDER A LA AYUDA PRESIONA ESTE BOTÓN "
        },
      {
        intro: "FIN DEL RECORRIDO POR EL REGISTRO DE LOS SÍNTOMAS, ESPERO HABERTE AYUDADO"
      }
    ], 

    nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
  }).start();
});

