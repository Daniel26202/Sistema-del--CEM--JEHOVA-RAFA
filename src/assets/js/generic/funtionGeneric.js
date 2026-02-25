import {
  chulitoYX,
  inicializarValidacionFormulario,
} from "./expresionesModulares.js";

//function generica for execute petiticon ajax
export const executePetition = async (url, method, data = null) => {
  try {
    const options = { method: method };

    if (data instanceof FormData) {
      options.body = data;
    } else if (data && typeof data === "object") {
      options.headers = {
        "Content-Type": "application/json",
      };
      options.body = JSON.stringify(data);
    }

    let response = await fetch(url, options);
    return response.json();
  } catch (error) {
    return error;
  }
};

//mostrar datos a editat

export const showDataModal = (parametros) => {
  parametros.labelModal.textContent = parametros.textLabelModal;
  parametros.btnModal.textContent = parametros.btnTextModal;
  parametros.form.classList.add("editar");

  if (parametros.cedulaOculta)
    parametros.cedulaOculta.value = parametros.data.cedula;

  if (parametros.idOculto) parametros.idOculto.value = parametros.data.id;

  if (parametros.rifOculto) parametros.rifOculto.value = parametros.data.rif;

  parametros.inputs.forEach((input) => {
    let campoCustom = input.closest(".campo-custom");
    let check = input.nextElementSibling.children[0];
    let error = input.nextElementSibling.children[1];

    input.value = parametros.data[input.getAttribute("name")];
    input.parentElement.classList.remove("invalido");
    input.parentElement.classList.add("valido");

    let pError = campoCustom.querySelector("p");
    pError.classList.add("d-none");

    if (check && error) chulitoYX(check, error, "valido");
  });

  // Inicializar con editar = true
  parametros.verificarFormulario = inicializarValidacionFormulario(
    parametros.form,
  );
};

export const clearModalEnviar = (parametros) => {
  parametros.labelModal.textContent = parametros.textLabelModal;
  parametros.btnModal.textContent = parametros.btnTextModal;
  parametros.form.classList.remove("editar");

  parametros.btnModal.textContent = parametros.btnTextModal;
  parametros.form.classList.remove("editar");

  parametros.inputs.forEach((input) => {
    let campoCustom = input.closest(".campo-custom");
    let spamP = campoCustom.querySelector(".icono-der");
    let check = spamP.children[0];
    let error = spamP.children[1];

    input.value = "";
    input.parentElement.classList.remove("valido");
    input.parentElement.classList.remove("invalido");
    let pError = campoCustom.querySelector("p");
    pError.classList.add("d-none");

    if (check && error) {
      check.classList.add("d-none");
      error.classList.add("d-none");
    }
  });
};

export const alertConfirm = (text, action, param = "") => {
  Swal.fire({
    icon: "question",
    title: "Confirmacion",
    text: text,
    showCancelButton: true,
    confirmButtonText: "Aceptar",
    cancelButtonText: "Cancelar",
    customClass: {
      popup: "switAlert",
      confirmButton: "btn-agregarcita-modal",
      cancelButton: "btn-agregarcita-modal-cancelar",
    },
  }).then((result) => {
    if (result.isConfirmed) {
      action(param);
    }
  });
};

export const alertError = (title, text) => {
  Swal.fire({
    icon: "error",
    title: title,
    text: text,
    customClass: {
      popup: "switAlert",
      confirmButton: "btn-agregarcita-modal",
      cancelButton: "btn-agregarcita-modal-cancelar",
    },
  });
};

export const alertSuccess = (text) => {
  Swal.fire({
    icon: "success",
    title: "Exito",
    text: text,
    customClass: {
      popup: "switAlert",
      confirmButton: "btn-agregarcita-modal",
      cancelButton: "btn-agregarcita-modal-cancelar",
    },
  });
};

export const initDataTable = (selector) => {
  $(selector).DataTable({
    language: {
      language: {
        decimal: ",",
        thousands: ".",
        lengthMenu: "Mostrar por página _MENU_ ",
        zeroRecords: "No se encontraron resultados",
        info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
        infoEmpty: "No hay registros disponibles",
        infoFiltered: "(filtrado de _MAX_ registros en total)",
        search: "Buscar:",
      },
    },
  });
};

//funcion para convertir la hora militar en cita
export const convertirHora = (horaMilitar) => {
  // Separamos hora y minutos
  let [horaStr, minutoStr] = horaMilitar.split(":");

  let hora = parseInt(horaStr, 10);
  let minutos = parseInt(minutoStr, 10);

  // Validamos rango
  if (
    isNaN(hora) ||
    isNaN(minutos) ||
    hora < 0 ||
    hora > 23 ||
    minutos < 0 ||
    minutos > 59
  ) {
    return "Hora inválida";
  }

  // Determinamos AM o PM
  let sufijo = hora >= 12 ? "PM" : "AM";

  // Convertimos a formato 12 horas
  let hora12 = hora % 12;
  if (hora12 === 0) {
    hora12 = 12;
  }

  // Aseguramos que los minutos siempre tengan dos dígitos
  let minutosFormateados = minutos.toString().padStart(2, "0");

  return `${hora12}:${minutosFormateados} ${sufijo}`;
};

export const searchElements = (
  text,
  className,
  elements,
  pMensaje = null,
  parentSelector = "",
) => {
  const searchTerm = text.trim().toLowerCase();
  let coincidenciasTotales = 0;

  elements.forEach((ele) => {
    // Definimos el objetivo (el padre o el elemento mismo)
    const target = parentSelector !== "" ? ele.closest(parentSelector) : ele;
    if (!target) return;

    // Caso: Buscador vacío
    if (searchTerm === "") {
      target.classList.remove(className);
      return;
    }

    // Lógica de búsqueda
    const content = (
      ele.innerText +
      ele.textContent +
      (ele.value || "")
    ).toLowerCase();
    const matches = content.includes(searchTerm);

    if (matches) {
      target.classList.remove(className);
      coincidenciasTotales++;
    } else {
      target.classList.add(className);
    }
  });

  // --- Lógica del mensaje de "No resultados" ---
  if (pMensaje) {
    console.log("Total coincidencias:", coincidenciasTotales);
    if (searchTerm !== "" && coincidenciasTotales === 0) {
      console.log(`No se encontraron resultados para "${text}"`);
      pMensaje.innerText = `No se encontraron resultados para "${text}"`;
    } else {
      console.log(
        `Resultados encontrados para "${text}": ${coincidenciasTotales}`,
      );
      pMensaje.innerText = "";
    }
    console.log("Mensaje actualizado en el DOM:", pMensaje.innerText);
  }
};



//funvion generica para cargar imagenes en js
export const cargarImg = (archivo, imgHtml, contenedorImg) => {
  for (var i = 0; i < archivo.length; i++) {
    const reader = new FileReader();
    reader.readAsDataURL(archivo[i]);
    reader.addEventListener("load", function (e) {
      let newImg = imgHtml;
      contenedorImg.innerHTML = newImg;
      contenedorImg.querySelector("img").src = e.currentTarget.result;
    });
  }
};

//retorna los permisos del sistema con su respetivo modulo
export const returnModulos = () => {
  // Array de módulos, cada uno con su nombre y el permiso asociado.
  const modulos = [
    { modulo: "Pacientes", permisosPorModulo: "permisosPacientes" },
    { modulo: "Patologias", permisosPorModulo: "permisosPatologias" },
    { modulo: "Factura", permisosPorModulo: "permisosFacturas" },
    { modulo: "Citas", permisosPorModulo: "permisosCitas" },
    { modulo: "Servicios", permisosPorModulo: "permisosServicios" },
    { modulo: "Doctores", permisosPorModulo: "permisosDoctores" },
    { modulo: "Control", permisosPorModulo: "permisosControles" },
    {
      modulo: "Hospitalizacion",
      permisosPorModulo: "permisosHospitalizaciones",
    },
    { modulo: "Insumos", permisosPorModulo: "permisosInsumos" },
    { modulo: "Entrada", permisosPorModulo: "permisosEntradas" },
    { modulo: "Proveedores", permisosPorModulo: "permisosProveedores" },
    { modulo: "Usuarios", permisosPorModulo: "permisosUsuarios" },
    { modulo: "Roles", permisosPorModulo: "permisosRoles" },
    { modulo: "Reportes", permisosPorModulo: "permisosReportes" },
    { modulo: "Estadisticas", permisosPorModulo: "permisosEstadisticas" },
    { modulo: "Mantenimiento", permisosPorModulo: "permisosMantenimiento" },
  ];

  // Clasificación de módulos en categorías.
  const clasificacion = {
    Administración: ["Usuarios", "Roles", "Mantenimiento"],
    "Gestión Médica": [
      "Pacientes",
      "Patologias",
      "Citas",
      "Servicios",
      "Hospitalizacion",
      "Doctores",
      "Control",
    ],
    Inventario: ["Insumos", "Entrada", "Proveedores"],
    Reportes: ["Factura", "Reportes", "Estadisticas"],
  };

  // Inicializamos un objeto para almacenar los módulos clasificados por categoría.
  const categorias = Object.keys(clasificacion).reduce((acc, categoria) => {
    acc[categoria] = []; // Inicializa cada categoría como un array vacío.
    return acc;
  }, {});

  // Clasificamos los módulos en las categorías correspondientes.
  modulos.forEach((modulo) => {
    for (const [categoria, modulosCategoria] of Object.entries(clasificacion)) {
      // Si el módulo pertenece a la categoría actual, lo añadimos a esa categoría.
      if (modulosCategoria.includes(modulo.modulo)) {
        categorias[categoria].push(modulo);
        break; // Salimos del bucle interno una vez clasificado.
      }
    }
  });

  return categorias;
};
