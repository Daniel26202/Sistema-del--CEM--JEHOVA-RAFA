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

export const alertConfirm =(text, action, param ='')=>{
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
      console.log(data);
    }
  });
}

export const alertError = (title,text)=>{
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
}

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
