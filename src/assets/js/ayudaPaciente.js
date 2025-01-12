document.addEventListener('DOMContentLoaded', function() {

  let botonDeAyuda = document.getElementById('btnayudaPaciente');
    botonDeAyuda.addEventListener("click", function() {
      introJs().setOptions({
        steps: [
          {
            intro: "AHORA TE ENCUENTRAS EN EL MÓDULO DE PACIENTES"
          },
      
        {
            element: document.querySelector('#inicioPacientes'),
            intro: "ACÁ PODRÁS GESTIONAR LA INFORMACIÓN DE LOS PACIENTES"
          },
          {
            element: document.querySelector('#btnRegistrarPaciente'),
            intro: "AL OPRIMIR ESTE BOTÓN SE VA A DESPLEGAR UN MODAL CON UN FORMULARIO PARA REGISTRAR LA INFORMACIÓN DE LOS NUEVOS PACIENTES"
          },
          {
            element: document.querySelector('#form-buscador'),
            intro: "AQUÍ TIENES UN BUSCADOR QUE AL COLOCAR LA CI DEL PACIENTE VA A DESPLEGAR UN MODAL CON LOS RESULTADOS"
          },
          {
            element: document.querySelector('#tabla'),
            intro: "EN ESTA TABLA SE MUESTRA LA INFORMACIÓN DE TODOS LOS PACIENTES REGISTRADOS"
          },
          {
            element: document.querySelector('#btnModalEditarPaciente'),
            intro: "AL PULSAR ESTE BOTON SE VA A DESPLEGAR UN MODAL PARA MODIFICAR LA INFORMACIÓN DEL PACIENTE"
          },
          {
            element: document.querySelector('#btnModalEliminarPaciente'),
            intro: "AL PULSAR ESTE BOTON SE VA A DESPLEGAR UN MODAL PARA ELIMINAR LA INFORMACIÓN DEL PACIENTE"
          },
          {
            element: document.querySelector('#desplegablePaciente'),
            intro: "PARA DESPLEGAR LA LISTA TIENES QUE PASAR EL MOUSE POR ESTE ÍCONO, EN LA LISTA ECONTRARAS UN BOTÓN PARA IR AL PERFIL Y EL BOTÓN PARA ACCEDER A LA AYUDA"
          },
  
          {
            intro: "FIN DEL RECORRIDO POR EL MÓDULO DE PACIENTES, ESPERO HABERTE AYUDADO"
          }
        ], 

        nextLabel: "Siguiente",
            prevLabel: "Anterior",
            doneLabel: "Finalizar",
      }).start();
    });





   


    
   
});