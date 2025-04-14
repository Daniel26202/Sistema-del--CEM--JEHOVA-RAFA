addEventListener("DOMContentLoaded", function () {
  console.log("roles");
  //constante del input para buscar el rol
  const buscarRol = document.getElementById("buscarRol");

  buscarRol.addEventListener("input", function () {
    document.querySelectorAll(".tarjeta").forEach((Element) => {
      let nombreDelRol = Element.querySelector(".card-title").innerText;
      if (nombreDelRol.includes(this.value)) Element.classList.remove("d-none");
      else Element.classList.add("d-none");
    });
  });

  //   //Recorrer todos los botones de mostrar
  document.querySelectorAll(".btn-mostrar-permisos").forEach((btn) => {
    //Llamo a un evento click para que cuando se presione el boton se active la funcion

    let todosLosPermisos;
    btn.addEventListener("click", function () {
      //Seleccion la caja especifica que voy a usar

      let id_rol = this.getAttribute("data-index");

      const modalMostrar = document.getElementById(
        "modal-exampleMostrar" + id_rol
      );

      todosLosPermisos = document.querySelector(
        ".checkboxTodosLosPermisos" + id_rol
      );

      todosLosPermisos.addEventListener("change", function () {
        modalMostrar.querySelectorAll(".form-check-js").forEach((ele) => {
          if (this.checked) {
            ele.checked = true;
          } else {
            ele.checked = false;
          }
        });
      });
    });
  });

  //esto checkea todos los checkbox de el modal de guardar

  document
    .querySelector(".checkboxTodosLosPermisos")
    .addEventListener("change", function () {
      document
        .getElementById("modal-exampleGuardar")
        .querySelectorAll(".form-check-js")
        .forEach((ele) => {
          if (this.checked) {
            ele.checked = true;
          } else {
            ele.checked = false;
          }
        });
    });
});
