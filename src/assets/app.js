document.addEventListener("DOMContentLoaded", () => {
  const root = document.documentElement;
  const themeToggleCheckbox = document.getElementById("themeToggleCheckbox");
  const textModo = document.getElementById("text-modo");
  if (textModo) {
    textModo.innerText = `Modo ${localStorage.getItem("modo")}`;
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
    });
  }
  $(".loader-wrapper").fadeOut("slow");
});
