addEventListener("DOMContentLoaded", function () {
    const formBuscadorDoctor = document.getElementById('buscadorDoctores');
    const tablaD = document.getElementById('tabla'); 
    const btnreiniciar = document.getElementById('reiniciarBusqueda');
    const tbody = tablaD.getElementsByTagName('tbody')[0];
    const filas = tbody.getElementsByTagName('tr');

    const extraerNumeros = (cadena) => {
        return cadena.replace(/\D/g, ''); // Extrae solo los números
    };

    const traerDatosEspecialidad = async () => {
        try {
            console.log("f")
            const datosFormulario = new FormData(formBuscadorDoctor);
            const contenido = {
                method: "POST",
                body: datosFormulario
            };
            let peticion = await fetch("http://localhost/Sistema-del--CEM--JEHOVA-RAFA/Doctores/buscarDoctor", contenido);
            let resultado = await peticion.json();

            // Mostrar todas las filas inicialmente
            for (let fila of filas) {
                fila.style.display = ''; 
            }

            if (resultado.length > 0) {
                const nombresCoincidentes = resultado.map(res => extraerNumeros(res.cedula.trim())); // Extraer solo números

                btnreiniciar.classList.remove('d-none');

                for (let fila of filas) {
                    const especialidadNombre = extraerNumeros(fila.cells[0].textContent.trim()); // Extraer solo números de la celda

                    if (!nombresCoincidentes.includes(especialidadNombre)) {
                        fila.style.display = 'none';
                        document.getElementById('noResultadoDoc').classList.add('d-none'); 
                    }
                }
            } else {
                btnreiniciar.classList.remove('d-none');
                for (let fila of filas) {
                    fila.style.display = 'none'; 
                    document.getElementById('noResultadoDoc').classList.remove('d-none');
                }
                console.log("No se encontraron coincidencias.");
            }
        } catch (error) {
            alert("Lamentablemente, algo salió mal. Por favor, intente más tarde...");
        }
    };

    formBuscadorDoctor.addEventListener("submit", (e) => {
        e.preventDefault();
        if (document.getElementById('inputBuscadorDoctor').value === '') {
            e.preventDefault();
        } else {
            traerDatosEspecialidad();
        }
    });

    btnreiniciar.addEventListener("click", () => {
        for (let fila of filas) {
            fila.style.display = '';
            btnreiniciar.classList.add("d-none");
            document.getElementById('inputBuscadorDoctor').value = '';
            document.getElementById('noResultadoDoc').classList.add('d-none');
        }
    });
});