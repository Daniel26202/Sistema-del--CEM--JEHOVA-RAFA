// esto es para los iconos y los input
addEventListener("DOMContentLoaded", function () {
    // buscar en la tabla
    document.getElementById("buscarBD").addEventListener("input", function () {
        const textMayuscl = this.value.toUpperCase();
        const trs = document.querySelectorAll("#datosTable tr");

        trs.forEach((tr) => {
            // nombre de la celda
            const valor = tr.cells[0].textContent.toUpperCase();
            tr.style.display = valor.includes(textMayuscl) ? "" : "none";
        });
    });

    // para el loader
    document.querySelectorAll(".seleccionar").forEach((selec) => {
        selec.addEventListener("click", function () {
            document.querySelector(".loader-wrapper").style.display = "block";
        });
    });
    
});
