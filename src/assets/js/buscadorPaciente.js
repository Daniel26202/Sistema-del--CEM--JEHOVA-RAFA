addEventListener("DOMContentLoaded", function () {

	const formBuscador = document.getElementById('form-buscador');
	const inputBuscador = document.querySelector('#form-buscador input').value;
	const nombrePaciente = document.getElementById('nombrePaciente');
	const lista = document.getElementById('ul');
	const mostrarCI = document.getElementById('edadb');
	const mostrarEdad = document.getElementById('cedulab');
	const mostrarTelefono = document.getElementById('telefonob');
	const mostrarDireccion = document.getElementById('direccionb');
	const mostrarNombrePatologia = document.getElementById('patologiab');
	const mostrarDescripcion = document.getElementById('descripcionb');



	//funcion ajax para buscar el paciente por la CI
	const traerDatos = async (cedula) => {
		try {
			const datosFormulario = new FormData(formBuscador)
			const contenido = {
				method: "POST",
				body: datosFormulario
			}
			let peticion = await fetch("?c=ControladorPacientes/mostrarPaciente", contenido)
			let resultado = await peticion.json();
			
			if (resultado.length > 0) {
				resultado.forEach(res => {
					nombrePaciente.textContent = `${res.nombre} ${res.apellido}`;


					const fechaActual = new Date();
					const fechaIngresada = new Date(res.fn);
					let edad = fechaActual.getFullYear() - fechaIngresada.getFullYear();
					if (fechaActual.getMonth() < fechaIngresada.getMonth()) {
						edad--;
					}
					if (fechaActual.getMonth() === fechaIngresada.getMonth() && fechaActual.getDate() <= fechaIngresada.getDate()) {
						edad--;
					}
					mostrarCI.textContent = `CI: ${res.nacionalidad}-${res.cedula}`;
					mostrarEdad.textContent = `EDAD: ${edad}`;



					mostrarTelefono.textContent = `TLF: ${res.telefono}`;
					mostrarDireccion.textContent = `${res.direccion}`;
					traerTodasLasPatologias(cedula,true);

					mostrarCI.classList.remove("d-none");
					mostrarTelefono.classList.remove("d-none");
					mostrarDireccion.classList.remove("d-none");
					mostrarEdad.classList.remove("d-none");
					mostrarNombrePatologia.classList.remove("d-none");
					mostrarDescripcion.classList.add("d-none");
					document.getElementById("modalesBuscador").classList.remove("d-none");
					lista.classList.remove('d-none');


					// Aca insertamos los datos como valores del input
					document.getElementById("id_pacienteBuscador").value = res.id_paciente;
					document.getElementById("id_pacienteEliminarBuscador").value = res.id_paciente;
					document.getElementById("cedulaEditarBuscador").value = res.cedula;
					document.getElementById("nombreEditarBuscador").value = res.nombre;
					document.getElementById("apellidoEditarBuscador").value = res.apellido;
					document.getElementById("telefonoEditarBuscador").value = res.telefono;
					document.getElementById("direccionEditarBuscador").value = res.direccion;
					document.getElementById("fnEditarBuscador").value = res.fn;
					document.getElementById("id_patologiaEditarBuscador").value = res.id_patologia;
					document.getElementById("patologiaEditarBuscador").value = res.nombre_patologia;
					document.getElementById("selectB").value = res.id_nacionalidad;
					document.getElementById("selectB").textContent = res.nacionalidad;
					
				})


			} else {

				nombrePaciente.textContent = "El Paciente No Existe";

				mostrarCI.classList.add("d-none");
				mostrarTelefono.classList.add("d-none");
				mostrarDireccion.classList.add("d-none");
				mostrarEdad.classList.add("d-none");
				mostrarNombrePatologia.classList.add("d-none");
				mostrarDescripcion.classList.add("d-none");
				document.getElementById("modalesBuscador").classList.add("d-none");
				lista.classList.add('d-none');

			}
		} catch (error) {
			//alert("lamentablemete Algo Salio Mal Por favor Intente Mas Tarde...");
		}
	}


	const traerTodasLasPatologias = async(cedula,positivo)=>{
		let peticion = await fetch("?c=ControladorPacientes/mostrarPatologias&cedula="+cedula);
		let resultado =  await peticion.json();
		console.log(resultado)
		let listaPatologias = [];
		resultado.forEach(res=>{
			listaPatologias.push(res.nombre_patologia)
		})
		console.log(listaPatologias)
		if(positivo){
			mostrarNombrePatologia.textContent = `${listaPatologias}`;
		}
	}



	//llamo a la funcion ajax cuando envio el formulario
	formBuscador.addEventListener("submit", (e) => {
		console.log(formBuscador)
		let input = document.querySelector("#form-buscador input");
		e.preventDefault();
		traerDatos(input.value);
		
	});


	let inputb = document.getElementById('inputB');
	inputb.addEventListener("focus", () => {
		if (inputb.value.trim().length === 0) {
			nombrePaciente.textContent = "el campo está vacío";

			mostrarCI.classList.add("d-none");
			mostrarTelefono.classList.add("d-none");
			mostrarDireccion.classList.add("d-none");
			mostrarEdad.classList.add("d-none");
			mostrarNombrePatologia.classList.add("d-none");
			mostrarDescripcion.classList.add("d-none");
			document.getElementById("modalesBuscador").classList.add("d-none");
			lista.classList.add('d-none');
		}
	});











	let modalElement = document.getElementById('exampleModalBuscador');
	modalElement.classList.remove('uk-modal-stack');





	let inutPaciente = document.querySelector("#inputB");



	function buscarPaciente() {
	   
	
		// selecciono todos los tr de la tabla
		const filas = document.querySelectorAll(".tbody tr");
		// recolecto el nombre del input
		let  valorInputPaciente= inutPaciente.value;
		// se convierte en minúscula
		valorInputPaciente = valorInputPaciente.toLowerCase();
		let coincidenciasEncontradas = 0;
		// recorro las filas de la tabla
		filas.forEach(fila => {
			// cuenta los síntomas que existen.
			
	
			console.log(fila.children[1]);
			let paciente = fila.children[1].innerText;
	
	
			// se convierte en minúscula
			paciente = paciente.toLowerCase();
	
			// verifico si el nombre existe 
			if (paciente.includes(valorInputPaciente)) {
				fila.classList.remove("d-none");
				coincidenciasEncontradas++;
	
			   
			}
			else {
				fila.classList.add("d-none");
			
			  
	
				// cuenta las veces que no encuentra un síntoma
			}
		   
	
			inutPaciente.addEventListener("keyup", ()=>{
				if(inutPaciente.value === ""){
					fila.classList.remove("d-none");
				}
			   }) 
	
		});
	
		if (coincidenciasEncontradas === 0) {
			document.getElementById("noresultados").classList.remove("d-none"); 
		} else {
			document.getElementById("noresultados").classList.add("d-none"); 
		}
	}
	
	inutPaciente.addEventListener("keyup", function(){
		buscarPaciente();
	   }) 
	










});