addEventListener("DOMContentLoaded", function () {
  console.log("roles");

  // Input para buscar roles
  const buscarRol = document.getElementById("buscarRol");

  // Filtrar tarjetas según el texto ingresado en el input
  buscarRol.addEventListener("input", function () {
    const query = this.value.toLowerCase(); // Convertir a minúsculas para búsqueda insensible a mayúsculas
    document.querySelectorAll(".tarjeta").forEach((element) => {
      const nombreDelRol = element.querySelector(".card-title").innerText.toLowerCase();
      element.classList.toggle("d-none", !nombreDelRol.includes(query));
    });
  });

  // Función para manejar el evento de "Todos los Permisos"
  function manejarCheckboxTodosLosPermisos(modal, checkboxTodos) {
    const allCheckboxes = modal.querySelectorAll('input[type="checkbox"]');
    checkboxTodos.addEventListener("change", function () {
      allCheckboxes.forEach((checkbox) => {
        checkbox.checked = checkboxTodos.checked;
      });
    });

    // Validar que al menos "consultar" esté seleccionado en cada sección
    const sections = modal.querySelectorAll(".accordion-section");
    modal.querySelector("form").addEventListener("submit", function (event) {
      let isValid = true;
      sections.forEach((section) => {
        const consultarCheckbox = section.querySelector('input[value="consultar"]');
        if (!consultarCheckbox.checked) {
          isValid = false;
          section.classList.add("error"); // Agregar clase para indicar error (opcional)
        } else {
          section.classList.remove("error"); // Remover clase de error si está marcado
        }
      });

      if (!isValid) {
        event.preventDefault(); // Prevenir envío del formulario
        const alertDiv = document.createElement("div");
        alertDiv.className = "alert alert-danger";
        alertDiv.textContent = "Debe seleccionar al menos 'Consultar' en cada sección.";

        const modalBody = modal.querySelector(".modal-body"); // Seleccionar el cuerpo del modal
        modalBody.prepend(alertDiv); // Usar prepend para insertar la alerta al inicio del modal

        setTimeout(() => {
          alertDiv.remove();
        }, 8000);
      }
    });
  }

  // Función para manejar los checkboxes dentro de cada sección del acordeón
  function manejarCheckboxConsultar(section) {
    const consultarCheckbox = section.querySelector('input[value="consultar"]');
    const otherCheckboxes = section.querySelectorAll(
      'input[value="guardar"], input[value="editar"], input[value="eliminar"]'
    );

    consultarCheckbox.addEventListener("change", function () {
      const isChecked = consultarCheckbox.checked;
      otherCheckboxes.forEach((checkbox) => {
        checkbox.checked = false; // Desmarcar siempre al cambiar
        checkbox.disabled = !isChecked; // Habilitar o deshabilitar según el estado de "Consultar"
      });
    });
  }

  // Manejar eventos de los botones "Mostrar Permisos"
  document.querySelectorAll(".btn-mostrar-permisos").forEach((btn) => {
    btn.addEventListener("click", function () {
      const id_rol = this.getAttribute("data-index"); // Obtener ID del rol
      const modalMostrar = document.getElementById("modal-exampleMostrar" + id_rol); // Modal específico
      const checkboxTodosLosPermisos = modalMostrar.querySelector(".checkboxTodosLosPermisos" + id_rol);

      // Manejar el checkbox de "Todos los Permisos"
      manejarCheckboxTodosLosPermisos(modalMostrar, checkboxTodosLosPermisos);

      // Manejar cada sección del acordeón
      modalMostrar.querySelectorAll(".accordion-section").forEach(manejarCheckboxConsultar);
    });
  });

  // Manejar el modal de "Guardar"
  const modalGuardar = document.getElementById("modal-exampleGuardar");
  const checkboxTodosLosPermisosGuardar = modalGuardar.querySelector(".checkboxTodosLosPermisos");

  // Manejar el checkbox de "Todos los Permisos" en el modal de "Guardar"
  manejarCheckboxTodosLosPermisos(modalGuardar, checkboxTodosLosPermisosGuardar);

  // Manejar cada sección del acordeón en el modal de "Guardar"
  modalGuardar.querySelectorAll(".accordion-section").forEach(manejarCheckboxConsultar);
});
