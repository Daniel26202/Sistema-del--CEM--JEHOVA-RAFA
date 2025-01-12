
document.addEventListener('DOMContentLoaded', function() {

    document.getElementById("btnayudaInicioSesion").addEventListener("click", function() {
      introJs().setOptions({
        steps: [
          {
            intro: "BIENVENIDO AL INICIO DE SESIÓN DEL SISTEMA DEL CENTRO DE ESPECIALIDADES MÉDICAS JEHOVÁ RAFÁ! "
          },
      
        {
            element: document.querySelector('#formiIniciarSesion'),
            intro: "TE PRESENTAMOS EL FORMULARIO QUE DEBES COMPLETAR PARA ENTRAR AL SISTEMA"
          },
          {
            element: document.querySelector('#ingresar-usuario'),
            intro: "AQUÍ DEBES INGRESAR TU USUARIO"
          },
          {
            element: document.querySelector('#input-password'),
            intro: "Y AQUI TIENES QUE COLOCAR TU CONTRASEÑA SECRETA"
          },
          {
            element: document.querySelector('#recPassword'),
            intro: "A TRAVÉS DE ESTE ENLACE PODRÁS RECUPERAR TU CONTRASEÑA EN CASO DE OLVIDO"
          },
          {
            element: document.querySelector('#btnInicioSesion'),
            intro: "AL HACER CLICK EN ESTE BOTÓN PODRÁS ACCEDER AL SISTEMA SI TU USUARIO Y CONTRASEÑA SON CORRECTOS"
          },
          {
            element: document.querySelector('#btnayudaInicioSesion'),
            intro: "PUEDES ACCEDER A LA AYUDA HACIENDO CLICK A ESTE BOTÓN"
          },

          {
            intro: "FIN DEL RECORRIDO POR EL INICIO DE SESIÓN, ESPERO HABERTE AYUDADO"
          }
        ], 

        nextLabel: "Siguiente",
            prevLabel: "Anterior",
            doneLabel: "Finalizar",
      }).start();
    });


});