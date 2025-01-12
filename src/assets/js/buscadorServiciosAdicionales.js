addEventListener("DOMContentLoaded", function () {
    const formBuscadorSE = document.getElementById('buscadorAgregarServicioMedico2');
    const tablaSE = document.getElementById('tablaOtros');
    const btnreiniciar = document.getElementById('reiniciarBusquedaServ');
    const tbody = tablaSE.getElementsByTagName('tbody')[0];
    const filas = tbody.getElementsByTagName('tr');


    const buscardorSE = async () => {
        try {
            const datosFormulario = new FormData(formBuscadorSE);
            const contenido = {
                method: "POST",
                body: datosFormulario
            };
            let peticion = await fetch("?c=ControladorConsultas/buscarOtrosServ", contenido);
            let resultado = await peticion.json();




            // Mostrar todas las filas inicialmente
            for (let fila of filas) {
                fila.style.display = '';
            }

            if (resultado.length > 0) {



                const nombresCoincidentes = resultado.map(res => res.nombre.trim());
                btnreiniciar.classList.remove('d-none');

                // Ocultar filas que no coinciden
                for (let fila of filas) {
                    const especialidadNombre = fila.cells[0].textContent.trim();
                    if (!nombresCoincidentes.includes(especialidadNombre)) {
                        fila.style.display = 'none';
                        //  document.getElementById('noResultadoSA').classList.add('d-none'); // 
                    }
                }
            } else {

                btnreiniciar.classList.remove('d-none');
                const tbody = tablaSE.getElementsByTagName('tbody')[0];
                const filas = tbody.getElementsByTagName('tr');
                for (let fila of filas) {


                    fila.style.display = 'none';
                    // document.getElementById('noResultadoSA').classList.remove('d-none');

                }


                console.log("No se encontraron coincidencias.");
            }
        } catch (error) {
            alert("Lamentablemente, algo salió mal. Por favor, intente más tarde...");
        }
    };

    formBuscadorSE.addEventListener("submit", (e) => {
        e.preventDefault();
        if (this.document.getElementById('inputBuscarOtrosServ').value === '') {
            e.preventDefault();
        } else {
            buscardorSE();
        }

    });

    btnreiniciar.addEventListener("click", () => {
        for (let fila of filas) {
            fila.style.display = '';
            btnreiniciar.classList.add("d-none");
            this.document.getElementById('inputBuscarOtrosServ').value = '';
            // document.getElementById('noResultadoSA').classList.add('d-none'); 
        }
    })


});