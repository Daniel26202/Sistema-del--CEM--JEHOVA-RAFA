addEventListener("DOMContentLoaded", function () {

    //selecccionar la caja del titulo 
    const cajaDeTitulo = document.querySelectorAll('.container-fluid')[0].children[0]




  //funcion para manejar el responsive en js
  
  function responsiveJs() {
    //ancho de pantall
    let anchoPantalla = window.innerWidth;

    if (anchoPantalla > 341 && anchoPantalla <= 480) {
      //esto es para modificar el tamaño del input para que sea resonsive al 100%\
      document.querySelectorAll(".input-responsive").forEach((input) => input.style.width = `60%`);

      //el select de paginacion
      document.querySelectorAll("select.dt-input").forEach((select) => select.style.width = `100%`);
        
      //boton del modal de guardar
      document.querySelectorAll(".btn-guardar-responsive").forEach((btnGuardar) => btnGuardar.style.width = `100%`);

      //caja del titulo
     cajaDeTitulo.classList.add('w-75', 'm-auto')


    } else if (anchoPantalla <= 340) {
      //esto es para modificar el tamaño del input para que sea resonsive al 100%\
      document.querySelectorAll(".input-responsive").forEach((input) => input.style.width = `40%`);

      document.querySelectorAll(".btn-guardar-responsive").forEach((btnGuardar) => btnGuardar.style.width = `100%`);
    } else {
      document.querySelectorAll(".btn-guardar-responsive").forEach((btnGuardar) => btnGuardar.style.width = `25%`);

      document.querySelectorAll(".input-responsive").forEach((input) => input.style.width = ``)

      document.querySelectorAll("select.dt-input").forEach((select) => select.style.width = ``);

      cajaDeTitulo.classList.remove('w-75', 'm-auto')
    }
  }

  responsiveJs()
  //evento para obtener el ancho de la pantalla en tiempo real
  window.addEventListener("resize", () => {
    responsiveJs()
  });

  //De esta manera voy a capturar la caja padre de la tabla y de esa manera le doy scroll
  document.querySelectorAll(".example").forEach((table) => {
    table.parentElement.style.overflowX = "auto";
  });
});
