
const aside = document.getElementById("aside");
const menu = document.getElementById("menu");
const cerrarMenu = document.getElementById("cerrarMenu");
const main = document.getElementById("main");

menu.addEventListener("click", () => {
	document.querySelector(".options").classList.remove("opcRes");
	aside.classList.remove("asideRespo");

	aside.classList.toggle("active");
	cerrarMenu.classList.toggle("desaparecer-icono");
	menu.classList.add("desaparecer-icono");
	main.classList.toggle("main");
	// menu.classList.toggle("desaparecer-icono")
});

cerrarMenu.addEventListener("click", () => {
	document.querySelector(".options").classList.add("opcRes");
	aside.classList.add("asideRespo");

	aside.classList.toggle("active");
	menu.classList.remove("desaparecer-icono");
	cerrarMenu.classList.add("desaparecer-icono");
	main.classList.remove("main");
})

main.addEventListener("click", () => {
	aside.classList.add("active")
	cerrarMenu.classList.add("desaparecer-icono")
	menu.classList.remove("desaparecer-icono")
	main.classList.remove("main")
})

let urlMenu = window.location.href;

if (urlMenu.includes("controladorInicio")) {
	document.getElementById('menuInicioColor').classList.add('opacidadMenu');
}
if (urlMenu.includes("ControladorInicio")) {
	document.getElementById('menuInicioColor').classList.add('opacidadMenu');
}
if (urlMenu.includes("controladorPacientes")) {
	document.getElementById('menuPacientesColor').classList.add('opacidadMenu');
}
if (urlMenu.includes("controladorFactura")) {
	document.getElementById('menuFacturacionColor').classList.add('opacidadMenu');
}
if (urlMenu.includes("controladorCitas")) {
	document.getElementById('menuCitasColor').classList.add('opacidadMenu');
}
if (urlMenu.includes("controladorDoctores")) {
	document.getElementById('menuDirectorioMedicoColor').classList.add('opacidadMenu');
}
if (urlMenu.includes("controladorPatologias")) {
	document.getElementById('menuPatologiasColor').classList.add('opacidadMenu');
}
if (urlMenu.includes("controladorControl")) {
	document.getElementById('menuControlMedicoColor').classList.add('opacidadMenu');
}
if (urlMenu.includes("ControladorHospitalizacion")) {
	document.getElementById('menuHospitalizacionColor').classList.add('opacidadMenu');
}
if (urlMenu.includes("ControladorConsultas")) {
	document.getElementById('menuServiciosColor').classList.add('opacidadMenu');
}
if (urlMenu.includes("controladorInsumos")) {
	document.getElementById('menuInsumosColor').classList.add('opacidadMenu');
}
if (urlMenu.includes("controladorEntrada")) {
	document.getElementById('menuInsumosColor').classList.add('opacidadMenu');
}
if (urlMenu.includes("controladorProveedores")) {
	document.getElementById('menuInsumosColor').classList.add('opacidadMenu');
}
if (urlMenu.includes("ControladorUsuarios")) {
	document.getElementById('menuUsuariosColor').classList.add('opacidadMenu');
}
if (urlMenu.includes("ControladorReportes")) {
	document.getElementById('menuReportesColor').classList.add('opacidadMenu');
}


const inputsMayusculas = document.querySelectorAll('.mayuscula');

inputsMayusculas.forEach(input => {
	input.addEventListener('input', function() {
		
		if (input.value.length > 0) {
			
			input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1);
		}
	});
});


// let numFilas = 0;

// function contarFilas() {
// 	// Obtener la tabla por su ID
// 	let tablaPendientes = document.getElementById('miTablaCuerpo');
// 	// Contar las filas (tr) de la tabla
// 	numFilas = tablaPendientes.getElementsByTagName('tr').length; // Restamos 1 si hay un encabezado
// 	console.log('Número de filas: '+ numFilas);
// 	let tarCitasPendientes = document.getElementById('pendientes').innerText(numFilas);
// }

// function mostrarResultado() {
//     // Esta función se llamará en el archivo donde está la tarjeta
//     return cantidadFilas; // Retorna la cantidad de filas
// }

// contarFilas();
// mostrarResultado();