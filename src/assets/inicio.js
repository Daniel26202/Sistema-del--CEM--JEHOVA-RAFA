addEventListener("DOMContentLoaded", function () {

	
	const pendiente = document.getElementById('pendientes');
	const hoy = document.getElementById('hoy');


		//funcion ajax para buscar el paciente por la CI


		const traerDatos = async () => {
			try {
				
				let peticion = await fetch("http://localhost/Sistema-del--CEM--JEHOVA-RAFA/Citas/citasP")
				let resultado = await peticion.json();
                pendiente.textContent = `${resultado.length}`;
				
			}catch (error) {
				console.log("lamentablemete Algo Salio Mal Por favor Intente Mas Tarde...");
			}
		}

        const traerHoy = async () => {
			try {
				
				let peticion = await fetch("http://localhost/Sistema-del--CEM--JEHOVA-RAFA/Citas/citasHoyP")
				let resultado = await peticion.json();
                hoy.textContent = `${resultado.length}`;
				
			}catch (error) {
				console.log("lamentablemete Algo Salio Mal Por favor Intente Mas Tarde...");
			}
		}
	
	
	//llamo a la funcion ajax cuando envio el formulario
    traerDatos();
    traerHoy();
	
	});





	






	