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

    const bajarBdsNube = async () => {
        try {
            let peticion = await fetch("/Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/bajarBdsNube");
            let resultado = await peticion.text();
console.log(resultado);

            // if (resultado.length > 0) {
            // } else {
            // }
        } catch (error) {
            console.log("intente Mas Tarde...");
        }
    };

    document.querySelector("#btnRD").addEventListener("click", function () {
        bajarBdsNube();
    })
});
