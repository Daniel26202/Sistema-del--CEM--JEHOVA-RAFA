// Espera a que todo el contenido del DOM haya sido cargado antes de ejecutar el script
document.addEventListener("DOMContentLoaded", function () {
  console.log("validados");
  // Objeto con las expresiones regulares para validar cada tipo de campo
  const expresiones = {
    nombre: /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/, // Letras y espacios, pueden llevar acentos, de 1 a 40 caracteres
    apellido: /^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/, // Igual que 'nombre'
    usuario: /^[a-zA-Z0-9._-]{5,16}$/, // Letras, números, guiones y guion bajo, de 3 a 16 caracteres
    correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/, // Formato de correo electrónico
    password: /^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/, // Al menos 8 caracteres, una mayúscula, un número y un símbolo
    // Agrega más expresiones según tus necesidades
    cedula: /^([1-9]{1})([0-9]{5,7})$/,
    telefono: /^(0?)(412|414|416|424|426|212|24[1-9]|25[1-9])\d{7}$/,
    direccion: /^([A-Za-z0-9\s\.,#-]+)$/,
    fn: /^\d{4}\-\d{2}\-\d{2}$/,
  };

  // Función que inicializa la validación para un formulario específico
  function inicializarValidacionFormularioGuardar(formulario) {
    // Objeto para almacenar el estado de cada campo en este formulario
    const campos = {};

    // Seleccionamos todos los inputs que requieren validación dentro de este formulario
    const inputs = formulario.querySelectorAll(".input-validar");
    console.log(inputs);

    // Iteramos sobre los inputs para agregar los event listeners y inicializar el estado
    inputs.forEach((input) => {
      // Inicializamos el estado del campo como 'false' (no validado)
      campos[input.name] = false;

      // Agregamos los event listeners para la validación en tiempo real
      input.addEventListener("keyup", (e) =>
        validarFormulario(e, formulario, campos)
      );
      input.addEventListener("input", (e) =>
        validarFormulario(e, formulario, campos)
      );
      input.addEventListener("blur", (e) =>
        validarFormulario(e, formulario, campos)
      );
    });

    // Manejador del evento 'submit' del formulario
    formulario.addEventListener("submit", (e) => {
      e.preventDefault(); // Prevenimos el envío por defecto para validar primero

      // Verificamos si todos los campos han sido validados correctamente
      const formularioValido = Object.values(campos).every(
        (valor) => valor === true
      );
      console.log(formularioValido);

      if (formularioValido) {
        // Si el formulario es válido, ocultamos cualquier mensaje de error y procedemos
        const mensajeError = formulario.querySelector(".msjE");
        if (mensajeError) {
          mensajeError.classList.add("d-none");
        }
        formulario.submit(); // Enviamos el formulario
      } else {
        // Si hay campos inválidos, mostramos el mensaje de error correspondiente
        const mensajeError = formulario.querySelector(".msjE");
        if (mensajeError) {
          mensajeError.classList.remove("d-none");
        } else {

          document.querySelector(".alertaFormulario").classList.remove("d-none");
          setTimeout(function () {
            document.querySelector(".alertaFormulario").classList.add("d-none");
          }, 10000);
        }
      }
    });
  }


  // Función que inicializa la validación para un formulario específico
  function inicializarValidacionFormularioEditar(formulario, id) {
    // Objeto para almacenar el estado de cada campo en este formulario
    const campos = {};

    // Seleccionamos todos los inputs que requieren validación dentro de este formulario
    const inputs = formulario.querySelectorAll(".input-validar");
    console.log(inputs);

    // Iteramos sobre los inputs para agregar los event listeners y inicializar el estado
    inputs.forEach((input) => {
      // Inicializamos el estado del campo como 'false' (no gvalidado)
      campos[input.name] = true;

      // Agregamos los event listeners para la validación en tiempo real
      input.addEventListener("keyup", (e) =>
        validarFormularioEditar(e, formulario, campos, id)
      );
      input.addEventListener("input", (e) =>
        validarFormularioEditar(e, formulario, campos, id)
      );
      input.addEventListener("blur", (e) =>
        validarFormularioEditar(e, formulario, campos, id)
      );
    });

    // Manejador del evento 'submit' del formulario
    formulario.addEventListener("submit", (e) => {
      e.preventDefault(); // Prevenimos el envío por defecto para validar primero

      // Verificamos si todos los campos han sido validados correctamente
      const formularioValido = Object.values(campos).every(
        (valor) => valor === true
      );
      console.log(formularioValido);

      if (formularioValido) {
        // Si el formulario es válido, ocultamos cualquier mensaje de error y procedemos
        const mensajeError = formulario.querySelector(".msjE");
        if (mensajeError) {
          mensajeError.classList.add("d-none");
        }
        formulario.submit(); // Enviamos el formulario
      } else {
        // Si hay campos inválidos, mostramos el mensaje de error correspondiente
        const mensajeError = formulario.querySelector(".msjE");
        if (mensajeError) {
          mensajeError.classList.remove("d-none");
        } else {

          document.querySelector(".alertaFormulario").classList.remove("d-none");
          setTimeout(function () {
            document.querySelector(".alertaFormulario").classList.add("d-none");
          }, 10000);
        }
      }
    });
  }

  // Función que valida los campos cada vez que ocurre un evento en un input
  function validarFormulario(e, formulario, campos) {
    const input = e.target; // Obtenemos el input que generó el evento
    const campo = input.name; // Nombre del campo (atributo 'name' del input)
    let pErrorGuardar = document.querySelector(`.p-error-${input.name}`); // Nombre del parrafo que le dira al usuario como cumplir la expresion

    // Extraemos el tipo de campo para obtener la expresión regular adecuada
    // Asumiendo que el 'name' es igual al tipo de campo (por ejemplo, 'nombre', 'correo', etc.)
    const tipoCampo = campo;

    // Obtenemos la expresión regular correspondiente
    const expresion = expresiones[tipoCampo];

    if (expresion) {
      validarCampo(expresion, input, campo, campos, formulario, pErrorGuardar);
    }
  }
  

  // Función que valida los campos cada vez que ocurre un evento en un input
  function validarFormularioEditar(e, formulario, campos, id) {
    const input = e.target; // Obtenemos el input que generó el evento
    const campo = input.name; // Nombre del campo (atributo 'name' del input)
    let pErrorEditar = document.querySelector(`.p-error-${input.name}${id}`); // Nombre del parrafo que le dira al usuario como cumplir la expresion
    console.log(pErrorEditar)

    // Extraemos el tipo de campo para obtener la expresión regular adecuada
    // Asumiendo que el 'name' es igual al tipo de campo (por ejemplo, 'nombre', 'correo', etc.)
    const tipoCampo = campo;

    // Obtenemos la expresión regular correspondiente
    const expresion = expresiones[tipoCampo];

    if (expresion) {
      validarCampo(expresion, input, campo, campos, formulario, pErrorEditar);
    }
  }

  // Función que valida un campo individual
  function validarCampo(expresion, input, campo, campos, formulario, pError) {
    pError.classList.add("fw-bold");
    pError.style.color = "rgb(224, 3, 3)";
    console.log(document.querySelector(`.p-error-${input.name}`))
    console.log('2')
    if (expresion.test(input.value)) {
      // Si el input cumple con la expresión regular, marcamos como válido
      actualizarEstadoInput(input, "correcto", formulario);
      pError.classList.add("d-none");
      campos[campo] = true;
    } else {
      // Si no cumple, marcamos como inválido
      actualizarEstadoInput(input, "incorrecto", formulario);
      pError.classList.remove("d-none");
      campos[campo] = false;
    }
  }

  // Función que actualiza el aspecto visual del input según su estado de validación
  function actualizarEstadoInput(input, estado, formulario, pError) {
    // Cambiamos las clases del input para aplicar estilos CSS
    input.parentElement.classList.toggle(
      "grpFormCorrect",
      estado === "correcto"
    );
    input.parentElement.classList.toggle(
      "grpFormInCorrect",
      estado === "incorrecto"
    );

    // Buscamos el elemento donde mostraremos el mensaje de error para este campo
    const grupoInput = input.parentElement; // Suponiendo que el input está dentro de un 'div' contenedor
    const mensajeError = grupoInput.querySelector(".mensaje-error");

    if (estado === "incorrecto") {
      // Si es incorrecto, mostramos el mensaje de error
      if (mensajeError) {
        mensajeError.classList.remove("d-none");
      }
    } else {
      // Si es correcto, ocultamos el mensaje de error
      if (mensajeError) {
        mensajeError.classList.add("d-none");
      }
    }
  }

  // Inicializamos la validación para todos los formularios con la clase 'form-validable'
  const formularios = document.querySelectorAll(".form-validable");
  console.log(formularios);
  formularios.forEach((formulario) => {
    inicializarValidacionFormularioGuardar(formulario);
  });
  

  //Hay que seleccionar el id por medio del boton para poder comparar y saber que ormulario de edicion le voy a cambiar imagenes
  document.querySelectorAll('.botonesEdi').forEach(btn=>{
    btn.addEventListener('click', ()=>{
        let id = btn.getAttribute('data-index');
        let formularioEditar = document.querySelector('.form-validable'+id)

        inicializarValidacionFormularioEditar(formularioEditar, id);
        console.log(formularioEditar)
    })
  })


});
