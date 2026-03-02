document.addEventListener("DOMContentLoaded", function () {
  const btnAyuda = document.getElementById("btnayudaInicioSesion");

  // Si no hay botón de ayuda en la vista actual, no hacer nada.
  if (!btnAyuda || typeof introJs !== "function") {
    return;
  }

  btnAyuda.addEventListener("click", function () {
    const steps = [
      {
        intro:
          "BIENVENIDO AL INICIO DE SESIÓN DEL SISTEMA DEL CENTRO DE ESPECIALIDADES MÉDICAS JEHOVÁ RAFÁ!",
      },
      {
        element: document.querySelector("#loginForm"),
        intro: "TE PRESENTAMOS EL FORMULARIO QUE DEBES COMPLETAR PARA ENTRAR AL SISTEMA",
      },
      {
        element: document.querySelector("#username"),
        intro: "AQUÍ DEBES INGRESAR TU USUARIO",
      },
      {
        element: document.querySelector("#password"),
        intro: "Y AQUI TIENES QUE COLOCAR TU CONTRASEÑA SECRETA",
      },
      {
        element: document.querySelector('a[href*="RecuperarContr"]'),
        intro: "A TRAVÉS DE ESTE ENLACE PODRÁS RECUPERAR TU CONTRASEÑA EN CASO DE OLVIDO",
      },
      {
        element: document.querySelector('#loginForm button[type="submit"]'),
        intro:
          "AL HACER CLICK EN ESTE BOTÓN PODRÁS ACCEDER AL SISTEMA SI TU USUARIO Y CONTRASEÑA SON CORRECTOS",
      },
      {
        element: btnAyuda,
        intro: "PUEDES ACCEDER A LA AYUDA HACIENDO CLICK A ESTE BOTÓN",
      },
      {
        intro: "FIN DEL RECORRIDO POR EL INICIO DE SESIÓN, ESPERO HABERTE AYUDADO",
      },
    ].filter((step) => !step.element || step.element instanceof Element);

    introJs()
      .setOptions({
        steps: steps,
        nextLabel: "Siguiente",
        prevLabel: "Anterior",
        doneLabel: "Finalizar",
      })
      .start();
  });
});
