document.addEventListener('DOMContentLoaded', function (){

    let recuperarContrasena = document.getElementById("btnayudarecuperaPassword");

    recuperarContrasena.addEventListener("click", function() {
        introJs().setOptions({
          steps: [
            {
              intro: "EN ESTA SECCIÓN PODRÁS RECUPERAR TU CONTRASEÑA"
            },
        
          {
              element: document.querySelector('#formRecPassword'),
              intro: "PARA RECUPERAR TU CONTRASEÑA DEBEMOS ASEGURARNOS QUE ERES TU, SOLO TIENES QUE COMPLETAR EL FORMULARIO"
            },
            {
              element: document.querySelector('#input-usuario-recpassword'),
              intro: "DEBES INGRESAR TU USUARIO" 
            },
            {
              element: document.querySelector('#input-ps-recpassword'),
              intro: "DEBES INGRESAR LA PREGUNTA DE SEGURIDAD QUE FUE CREADA CUANDO TU USUARIO FUE REGISTRADO"
            },
            {
              element: document.querySelector('#input-rs-recpassword'),
              intro: "AQUÍ VAS A COLOCAR TU RESPUESTA SECRETA"
            },
            {
              element: document.querySelector('#input-new-password'),
              intro: "AQUÍ VAS A INGRESAR TU NUEVA CONTRASEÑA"
            },
            {
              element: document.querySelector('#btnRecPassword'),
              intro: "AL HACER CLICK EN ESTE BOTÓN PODRÁS ACTUALIZAR TU CONTRASEÑA SI LOS DATOS QUE INGRESASTE SON CORRECTOS "
            },
            {
              element: document.querySelector('#iniciarsesionEnlace'),
              intro: "EN ESTE ENLACE PODRÁS IR NUEVAMENTE AL INICIO DE SESIÓN"
            },
            {
              element: recuperarContrasena,
              intro: "PUEDES ACCEDER A LA AYUDA HACIENDO CLICK A ESTE BOTÓN"
            },
  
            {
              intro: "FIN DEL RECORRIDO POR RECUPERAR CONTRASEÑA, ESPERO HABERTE AYUDADO"
            }
          ], 
  
          nextLabel: "Siguiente",
              prevLabel: "Anterior",
              doneLabel: "Finalizar",
        }).start();
      });
});