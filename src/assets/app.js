import { valorDolar } from "./js/generic/coversion.js";

const acomodarCamposDeModales = (contenedor = document) => {
  const etiquetas = contenedor.querySelectorAll(".modal label.label-custom");
  const gruposPorContenedor = new Map();

  etiquetas.forEach((etiqueta) => {
    const campo = etiqueta.nextElementSibling;
    if (!campo?.classList.contains("campo-custom")) return;

    const grupos = gruposPorContenedor.get(etiqueta.parentElement) ?? [];
    grupos.push({ etiqueta, campo });
    gruposPorContenedor.set(etiqueta.parentElement, grupos);
  });

  gruposPorContenedor.forEach((grupos, padre) => {
    if (grupos.length < 2 || padre.classList.contains("row")) return;

    grupos.forEach(({ etiqueta, campo }) => {
      const grupo = document.createElement("div");
      grupo.className = "modal-form-field";
      padre.insertBefore(grupo, etiqueta);
      grupo.append(etiqueta, campo);
    });

    padre.classList.add("modal-form-grid");
  });
};

document.addEventListener("DOMContentLoaded", () => {
  acomodarCamposDeModales();
  document.addEventListener("show.bs.modal", (event) => {
    if (event.target instanceof Element) acomodarCamposDeModales(event.target);
  });

  const root = document.documentElement;
  const themeToggleCheckbox = document.getElementById("themeToggleCheckbox");
  const textModo = document.getElementById("text-modo");
  let nameMode = localStorage.getItem("modo") ? localStorage.getItem("modo") : 'Claro';
  if (textModo) {
    textModo.innerText = `Modo ${nameMode}`;
  }

  // 1) Aplicar tema guardado
  if (localStorage.getItem("theme") === "dark") {
    root.setAttribute("data-theme", "dark");
    if (themeToggleCheckbox)
      themeToggleCheckbox.checked = true; /*  Sincronizando el checkbox */
  }

  if (themeToggleCheckbox) {
    themeToggleCheckbox.addEventListener("change", () => {
      const isDark = themeToggleCheckbox.checked;
      root.setAttribute("data-theme", isDark ? "dark" : "");
      localStorage.setItem("theme", isDark ? "dark" : "light");

      /* text para saber en que modo esta */
      localStorage.setItem("modo", isDark ? "Oscuro" : "Claro");
      textModo.innerText = isDark ? "Modo Oscuro" : "Modo Claro";

      // 👇 NUEVO: Avisar a los gráficos que el tema cambió
      window.dispatchEvent(new Event("themeChanged"));
    });
  }
  // El login no carga jQuery (solo el footer de las vistas internas lo hace),
  // así que aquí no se puede usar $: lanzaba "$ is not defined" en consola.
  const loader = document.querySelector(".loader-wrapper");
  if (loader) {
    if (window.jQuery) {
      window.jQuery(loader).fadeOut("slow");
    } else {
      loader.style.transition = "opacity .3s";
      loader.style.opacity = "0";
      setTimeout(() => loader.remove(), 300);
    }
  }


  //Activar la funcion para actualizar el valor del dolar
  valorDolar();
});
