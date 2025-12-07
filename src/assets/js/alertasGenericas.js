document.addEventListener("DOMContentLoaded", function () {
  //bucle donde seleccion todas las alertas para que cuando aparezca una a los 7 segundos desaparesca  de manera amigable ademas realizando en un solo archivo se componetisa el sistema

  document.querySelectorAll(".alertaGenerica").forEach((alerta) => {
    if (alerta) {
      setTimeout(function () {
        alerta.remove();
      }, 7000);
    }
  });
  /* aproveche este archivo para hacer q los spinners aparezcan en los botones ;) */
  const form = document.getElementById("modalAgregar");
  const boton = document.getElementById("botonEnviar");
  const spinner = document.getElementById("spinner-cargando");
  const agregartext = document.getElementById("agregar");

  if (form && boton && spinner && agregartext) {
    form.addEventListener("submit", function () {
      spinner.classList.remove("d-none");
      agregartext.classList.add("d-none");
      boton.disabled = true;
    });
  }
});
