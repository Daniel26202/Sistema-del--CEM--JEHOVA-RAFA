document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("modalAgregar");
  const inputs = document.querySelectorAll("#modalAgregar input");

  const expresiones = {
    precio: /^(\d{1,3}\.\d{3}.\d{2}|\d{1,3}.\d{2})$/,
  };


  const campos = {
    precio: true,
  };

  function validarFormulario(e) {
    switch (e.target.name) {
      case "precio":
        validarCampos(expresiones.precio, e.target, "precio");
        break;
    }
  }

  const validarCampos = (expresiones, input, campo) => {
    if (expresiones.test(input.value)) {
      document
        .getElementById(`grp_${campo}`)
        .classList.remove("grpFormInCorrect");
      document.getElementById(`grp_${campo}`).classList.add("grpFormCorrect");
      campos[campo] = true;
    } else {
      document
        .getElementById(`grp_${campo}`)
        .classList.remove("grpFormCorrect");
      document.getElementById(`grp_${campo}`).classList.add("grpFormInCorrect");
      campos[campo] = false;
    }
    if (campos.precio === true) {
      document.getElementById("leyenda").classList.add("d-none");
    }
    if (campos.precio === false) {
      document.getElementById("leyenda").classList.remove("d-none");
    }
  };

  inputs.forEach((input) => {
    input.addEventListener("keyup", validarFormulario);
    input.addEventListener("input", validarFormulario);
  });

  let alerta = document.getElementById("alerta");

  form.addEventListener("submit", (e) => {
    e.preventDefault();
    if (campos.precio) {
      form.submit();
    } else {
      alerta.classList.remove("d-none");
      setTimeout(function () {
        alerta.classList.add("d-none");
      }, 10000);
    }
  });

  const comentario = document.querySelector(".comentario");
  if (comentario) {
    comentario.style.display = "block";
    setTimeout(function () {
      comentario.style.display = "none";
    }, 8000);
  }
});
