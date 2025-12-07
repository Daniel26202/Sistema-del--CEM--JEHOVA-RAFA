addEventListener("DOMContentLoaded", function () {
  console.log(document.querySelector(".formAgregarAdmin"));
  const alerta = document.getElementById("alertaAdmin");

  const expresiones = {
    cedula: /^([1-9]{1})([0-9]{5,7})$/,
    nombre: /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/,
    apellido: /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/,
    telefono: /^(0?)(412|414|416|424|426|212|24[1-9]|25[1-9])\d{7}$/,
    email: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
    usuario: /^[a-zA-Z0-9._-]{3,16}$/,
    password: /^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/,
  };

  const campos = {
    cedula: false,
    nombre: false,
    apellido: false,
    telefono: false,
    email: false,
    usuario: false,
    password: false,
  };

  function validarFormulario(e) {
    switch (e.target.name) {
      case "cedula":
        validarCampos(expresiones.cedula, e.target, "cedula");
        break;

      case "nombre":
        validarCampos(expresiones.nombre, e.target, "nombre");

        break;
      case "apellido":
        validarCampos(expresiones.apellido, e.target, "apellido");

        break;

      case "telefono":
        validarCampos(expresiones.telefono, e.target, "telefono");

        break;
      case "Correo":
        validarCampos(expresiones.email, e.target, "Correo");
        break;
      case "usuario":
        validarCampos(expresiones.usuario, e.target, "usuario");
        break;
      case "password":
        validarCampos(expresiones.password, e.target, "password");
        break;
    }
  }

  const validarCampos = (expresiones, input, campo) => {
    if (expresiones.test(input.value)) {
      input.parentElement.classList.remove("grpFormInCorrect");
      input.parentElement.classList.add("grpFormCorrect");
      campos[campo] = true;
    } else {
      input.parentElement.classList.remove("grpFormCorrect");
      input.parentElement.classList.add("grpFormInCorrect");
      campos[campo] = false;
    }
  };

  document.querySelectorAll(".input-u").forEach((ele) => {
    ele.addEventListener("input", validarFormulario);
  });

  document
    .querySelector(".formAgregarAdmin")
    .addEventListener("submit", function (e) {
      e.preventDefault();
      console.log(e);

      if (
        campos.nombre &&
        campos.apellido &&
        campos.cedula &&
        campos.telefono &&
        campos.usuario &&
        campos.password
      ) {
        this.submit();
      } else {
        e.preventDefault();
        console.log(alerta)
        alerta.classList.remove("d-none");
        // setTimeout(function () {
        //   alerta.classList.add("d-none");
        // }, 10000);
      }
    });
});
