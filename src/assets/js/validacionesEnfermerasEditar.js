document.addEventListener('DOMContentLoaded', function () {

  const validarNombre = document.querySelectorAll('.validar input');

  for (let i = 0; i < validarNombre.length; i++) {
    validarNombre[i].addEventListener('input', () => {
      if (!validarNombre[i].checkValidity()) {
        validarNombre[i].classList.add('grpFormInCorrectEditar');
        validarNombre[i].classList.remove('grpFormCorrectEditar');

      } else {
        validarNombre[i].classList.remove('grpFormInCorrectEditar');
        validarNombre[i].classList.add('grpFormCorrectEditar');
      }
    });
  }


});