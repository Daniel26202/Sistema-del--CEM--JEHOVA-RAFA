addEventListener("DOMContentLoaded", function () {

  //funcion para manejar el responsive en js

  function responsiveJs() {
    //ancho de pantall
    let anchoPantalla = window.innerWidth;

    if (anchoPantalla > 341 && anchoPantalla <= 480 || anchoPantalla <= 340) {
      //esto es para modificar el tamaño del input para que sea resonsive al 100%\
      document
        .querySelectorAll(".input-responsive")
        .forEach((input) => (input.style.width = `60%`));

      //el select de paginacion
      document
        .querySelectorAll("select.dt-input")
        .forEach((select) => (select.style.width = `80%`));

      //boton del modal de guardar
      document
        .querySelectorAll(".btn-guardar-responsive")
        .forEach((btnGuardar) => (btnGuardar.style.width = `80%`));

      //caja del titulo
    } else {
      document
        .querySelectorAll(".btn-guardar-responsive")
        .forEach((btnGuardar) => (btnGuardar.style.width = `20%`));

      document
        .querySelectorAll(".input-responsive")
        .forEach((input) => (input.style.width = ``));

      document
        .querySelectorAll("select.dt-input")
        .forEach((select) => (select.style.width = ``));

    }
  }

  responsiveJs();
  //evento para obtener el ancho de la pantalla en tiempo real
  window.addEventListener("resize", () => {
    responsiveJs();
  });


});
