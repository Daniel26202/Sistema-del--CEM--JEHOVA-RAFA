const MIME_PERMITIDOS = new Set(["image/jpeg", "image/png"]);
const TAMANO_MAXIMO = 5 * 1024 * 1024;
const PIXELES_MAXIMOS = 12_000_000;

const resolverVistaPrevia = (input) => {
  const selector = input.dataset.imagePreview;
  const formulario = input.closest("form");
  return (
    (selector && (formulario?.querySelector(selector) || document.querySelector(selector))) ||
    formulario?.querySelector(".image-preview") ||
    null
  );
};

const mostrarMensaje = (input, mensaje) => {
  const campo = input.closest(".campo-custom") || input.parentElement;
  let salida = campo.querySelector(".image-upload-feedback");

  if (!salida) {
    salida = document.createElement("p");
    salida.className = "image-upload-feedback text-danger small mb-1";
    salida.setAttribute("role", "status");
    salida.setAttribute("aria-live", "polite");
    campo.insertAdjacentElement("afterend", salida);
  }

  salida.textContent = mensaje;
  salida.classList.toggle("d-none", mensaje === "");
};

document.querySelectorAll('input[type="file"][data-image-upload]').forEach((input) => {
  const vistaPrevia = resolverVistaPrevia(input);
  const formulario = input.closest("form");
  const vistaActual = input.dataset.imageCurrent
    ? formulario?.querySelector(input.dataset.imageCurrent)
    : null;
  let urlAnterior = null;
  let solicitudImagen = 0;

  input.dataset.imageValid = input.dataset.optionalFile === "true" ? "true" : "false";

  input.addEventListener("change", () => {
    const solicitudActual = ++solicitudImagen;
    const archivo = input.files?.[0];
    if (urlAnterior) URL.revokeObjectURL(urlAnterior);
    urlAnterior = null;

    if (!archivo) {
      input.dataset.imageValid = input.dataset.optionalFile === "true" ? "true" : "false";
      mostrarMensaje(input, "");
      vistaActual?.classList.remove("d-none");
      if (vistaPrevia && vistaPrevia !== vistaActual) vistaPrevia.classList.add("d-none");
      return;
    }

    const rechazar = (mensaje) => {
      input.value = "";
      input.dataset.imageValid = "false";
      mostrarMensaje(input, mensaje);
      vistaActual?.classList.remove("d-none");
      if (vistaPrevia && vistaPrevia !== vistaActual) vistaPrevia.classList.add("d-none");
    };

    if (!MIME_PERMITIDOS.has(archivo.type)) {
      rechazar("El archivo debe ser una imagen JPG o PNG válida.");
      return;
    }
    if (archivo.size === 0 || archivo.size > TAMANO_MAXIMO) {
      rechazar("La imagen debe pesar más de 0 y hasta 5 MB.");
      return;
    }

    const urlTemporal = URL.createObjectURL(archivo);
    const imagen = new Image();
    imagen.onload = () => {
      if (solicitudActual !== solicitudImagen) {
        URL.revokeObjectURL(urlTemporal);
        return;
      }
      if (imagen.naturalWidth * imagen.naturalHeight > PIXELES_MAXIMOS) {
        URL.revokeObjectURL(urlTemporal);
        rechazar("La imagen tiene dimensiones demasiado grandes.");
        return;
      }

      urlAnterior = urlTemporal;
      input.dataset.imageValid = "true";
      mostrarMensaje(input, "");
      if (vistaPrevia) {
        if (vistaPrevia.tagName === "IMG") {
          vistaPrevia.src = urlTemporal;
        } else {
          const vista = document.createElement("img");
          vista.src = urlTemporal;
          vista.alt = "Vista previa de la imagen seleccionada";
          vista.className = "img-fluid rounded";
          vista.style.width = "100%";
          vista.style.maxHeight = "200px";
          vista.style.objectFit = "cover";
          vistaPrevia.replaceChildren(vista);
          vistaPrevia.classList.remove("d-none");
        }
      }
      vistaActual?.classList.add("d-none");
    };
    imagen.onerror = () => {
      URL.revokeObjectURL(urlTemporal);
      if (solicitudActual !== solicitudImagen) return;
      rechazar("No se pudo leer la imagen. Seleccione un JPG o PNG válido.");
    };
    imagen.src = urlTemporal;
  });
});
