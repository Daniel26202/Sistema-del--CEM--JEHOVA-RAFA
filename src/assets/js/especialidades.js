addEventListener("DOMContentLoaded", function () {
    const formBuscador = document.getElementById('form-buscadorEspecialidad');
    const tabla2 = document.getElementById('tablaEspecialidad');
    const btnreiniciar = document.getElementById('reiniciarBusquedaEspecialidad');
    const tbody = tabla2.getElementsByTagName('tbody')[0];
    const filas = tbody.getElementsByTagName('tr');

    
    const traerDatosEspecialidad = async () => {
        try {
            const datosFormulario = new FormData(formBuscador);
            const contenido = {
                method: "POST",
                body: datosFormulario
            };
            let peticion = await fetch("http://localhost/Sistema-del--CEM--JEHOVA-RAFA/Doctores/buscarEspecialidad", contenido);
            let resultado = await peticion.json();
    
          
            
    
            // Mostrar todas las filas inicialmente
            for (let fila of filas) {
                fila.style.display = ''; 
            }
    
            if (resultado.length > 0) {
               
                const nombresCoincidentes = resultado.map(res => res.nombre.trim());
                btnreiniciar.classList.remove('d-none');

    
               
                for (let fila of filas) {
                    const especialidadNombre = fila.cells[1].textContent.trim(); 
                    if (!nombresCoincidentes.includes(especialidadNombre)) {
                        fila.style.display = 'none';
                        document.getElementById('noResultado').classList.add('d-none'); 
                    }
                }
            } else {

                btnreiniciar.classList.remove('d-none');
                const tbody = tabla2.getElementsByTagName('tbody')[0]; 
            const filas = tbody.getElementsByTagName('tr');
            for (let fila of filas) {
    
               
                    fila.style.display = 'none'; 
                    document.getElementById('noResultado').classList.remove('d-none');// Ocultar fila si no hay coincidencia
                   
            }
           
         
                console.log("No se encontraron coincidencias.");
            }
        } catch (error) {
            alert("Lamentablemente, algo salió mal. Por favor, intente más tarde...");
        }
    };
    
    formBuscador.addEventListener("submit", (e) => {
        e.preventDefault();
        if(this.document.getElementById('inputBuscarEspecialidad').value === ''){
			e.preventDefault();
		}else{
            traerDatosEspecialidad();

		}
    });


    btnreiniciar.addEventListener("click", () => {
		for (let fila of filas) {
			fila.style.display = '';
			btnreiniciar.classList.add("d-none");
            this.document.getElementById('inputBuscarEspecialidad').value = '';
            document.getElementById('noResultado').classList.add('d-none'); 
		}
	})


});