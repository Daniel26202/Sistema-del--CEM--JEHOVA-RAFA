document.addEventListener("DOMContentLoaded", function () {
  //bucle donde seleccion todas las alertas para que cuando aparezca una a los 7 segundos desaparesca  de manera amigable ademas realizando en un solo archivo se componetisa el sistema

  document.querySelectorAll(".alertaGenerica").forEach((alerta) => {
    if (alerta) {
      setTimeout(function () {
        alerta.remove();
      }, 7000);
    }
  });
});
