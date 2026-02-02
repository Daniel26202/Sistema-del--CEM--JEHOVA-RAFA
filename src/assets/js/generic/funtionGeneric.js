import { chulitoYX, inicializarValidacionFormulario } from "./expresionesModulares.js";

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

  if (parametros.cedulaOculta) parametros.cedulaOculta.value = parametros.data.cedula;
  if (parametros.idOculto) parametros.idOculto.value = parametros.data.id;

  parametros.inputs.forEach((input) => {
    let check = input.nextElementSibling.children[0];
    let error = input.nextElementSibling.children[1];

    input.value = parametros.data[input.getAttribute('name')];
    input.parentElement.classList.remove("invalido");
    input.parentElement.classList.add("valido");

    let campoCustom = input.closest(".campo-custom");
    let pError = campoCustom.querySelector("p");
    pError.classList.add('d-none');

    if (check && error) chulitoYX(check, error, 'valido');
  });

  // Inicializar con editar = true
  parametros.verificarFormulario = inicializarValidacionFormulario(parametros.form);


};


export const clearModalEnviar = (parametros) => {
  parametros.labelModal.textContent = parametros.textLabelModal;
  botonModal.textContent = parametros.btnTextModal;
  parametros.form.classList.remove("editar");


  parametros.inputs.forEach((input) => {
    let check = input.nextElementSibling?.children[0];
    let error = input.nextElementSibling?.children[1];

    input.value = "";
    input.parentElement.classList.remove("valido");
    let campoCustom = input.closest(".campo-custom");
    let pError = campoCustom.querySelector("p");
    pError.classList.add('d-none');

    if (check && error) {
      check.classList.add("d-none");
      error.classList.add("d-none");
    };
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
  if (isNaN(hora) || isNaN(minutos) || hora < 0 || hora > 23 || minutos < 0 || minutos > 59) {
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
