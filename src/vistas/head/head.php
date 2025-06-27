<?php
if (isset($_SESSION['usuario'])) {
} else {
	header("location: /Sistema-del--CEM--JEHOVA-RAFA/IniciarSesion/mostrarIniciarSesion");
}

$urlBase = "";
if (!empty($parametro)) {
	foreach ($parametro as $p) {
		$urlBase .= "../";
	}
}

?>

<script>
	(function() {
		const theme = localStorage.getItem("theme");
		if (theme === "dark") {
			document.documentElement.setAttribute("data-theme", "dark");
		}
	})();
</script>


<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="<?= $urlBase ?>../src/assets/img/logotipo.jpg">
	<title>J-R</title>
	<link rel="stylesheet" href="<?= $urlBase ?>../src/assets/uikit/css/uikit.min.css">
	<link rel="stylesheet" href="<?= $urlBase ?>../src/assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= $urlBase ?>../src/assets/DataTable/datatables.css">
	<link rel="stylesheet" href="<?= $urlBase ?>../src/assets/cssVista/style.css">
	<link rel="stylesheet" type="text/css" href="<?= $urlBase ?>../src/assets/intro/introjs.min.css">
	<link rel="stylesheet" type="text/css" href="<?= $urlBase ?>../src/assets/intro/introjs-modern.css">

</head>

<body>

	<div class="loader-wrapper">
		<div id="content">
			<img class="mb-3" src="<?= $urlBase ?>../src/assets/icons/logo-loader.svg" style="width: 180px; height: 55px;">
			<div class="loading-bar">
				<div class="blue-bar"></div>
			</div>
		</div>
	</div>



	<!-- Menú lateral -->
	<div id="mySidenav" class="sidenav">

		<p style="cursor: pointer;" href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</p>

		<div class=" mx-4 cl-toggle-switch d-flex justify-content-between" style="width: 60%;">
			<label class="cl-switch">
				<input type="checkbox" id="themeToggleCheckbox">
				<span></span>
			</label>

			<p style="color: white;" id="text-modo"></p>
		</div>


		<a class="nav-link collapsed d-flex" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsuario" aria-expanded="false" aria-controls="collapseUsuario">
			<div class="sb-nav-link-icon mx-2">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
					<path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
					<path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
				</svg>
			</div>
			<?= $_SESSION["usuario"] ?>
			<div class="sb-sidenav-collapse-arrow mx-2">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
					<path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
				</svg>
			</div>
		</a>


		<div class="collapse" id="collapseUsuario" aria-labelledby="headingCitas" data-bs-parent="#sidenavAccordion d-flex">
			<nav class="sb-sidenav-menu-nested nav">
				<a class="nav-link mx-5" href="/Sistema-del--CEM--JEHOVA-RAFA/Perfil/perfil" uk-tooltip="Perfil">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
						<path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
					</svg> Perfil
				</a>
				<a class="nav-link mx-5" uk-tooltip="Ayuda" href="#" id="<?= isset($ayuda) ? $ayuda : "" ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
						fill="currentColor" class="bi bi-question-octagon-fill  me-1" viewBox="0 0 16 16">
						<path
							d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
					</svg> Ayuda</a>
				<a class="nav-link mx-5" href="/Sistema-del--CEM--JEHOVA-RAFA/Bitacora/bitacora" uk-tooltip="Bitacora"><svg xmlns="http://www.w3.org/2000/svg"
						width="16" height="16" fill="currentColor" class="bi bi-question-octagon-fill  me-1"
						viewBox="0 0 16 16">
						<path
							d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z" />
					</svg> Bitacora</a>


				<a href="#" class="mx-5" data-bs-toggle="modal" data-bs-target="#cerrar">
					<img src="<?= $urlBase ?>../src/assets/img/icono-cerrar-sesion.svg" width="16" height="16" uk-svg
						class="">
					</svg>SALIR</a>
			</nav>
		</div>

		<a class="nav-link d-flex" href="/Sistema-del--CEM--JEHOVA-RAFA/Inicio/inicio" uk-tooltip="Inicio" id="menuInicio">
			<div class="sb-nav-link-icon mx-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
					<path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"></path>
					<path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z"></path>
				</svg></div>
			Inicio
		</a>

		<?php if (!$this->permisos($_SESSION["id_rol"], "consultar", "Pacientes")): ?>
			<!-- no hay -->
		<?php else: ?>
			<a class="nav-link d-flex" href="/Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes" uk-tooltip="Pacientes" id="menuPacientes">
				<div class="sb-nav-link-icon mx-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
						class="bi bi-people-fill" viewBox="0 0 16 16">
						<path
							d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
					</svg></div>
				Pacientes
			</a>
		<?php endif; ?>

		<?php if (!$this->permisos($_SESSION["id_rol"], "consultar", "Patologias")): ?>
			<!-- no hay -->
		<?php else: ?>
			<a class="nav-link d-flex" href="/Sistema-del--CEM--JEHOVA-RAFA/Patologias/patologias" uk-tooltip="Patologias" id="menuPatologias">
				<div class="sb-nav-link-icon mx-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bandaid-fill" viewBox="0 0 16 16">
						<path d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z" />
					</svg></div>
				Patologías
			</a>
		<?php endif; ?>


		<?php if (!$this->permisos($_SESSION["id_rol"], "consultar", "Factura")): ?>
			<!-- no hay -->
		<?php else: ?>
			<a class="nav-link d-flex" href="/Sistema-del--CEM--JEHOVA-RAFA/Factura/factura" uk-tooltip="Facturacion" id="menuFacturacion">
				<div class="sb-nav-link-icon mx-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
						class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16">
						<path
							d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z" />
					</svg></div>
				Facturacíon
			</a>
		<?php endif; ?>

		<?php if (!$this->permisos($_SESSION["id_rol"], "consultar", "Citas")): ?>
			<!-- no hay -->
		<?php else: ?>
			<a class="nav-link collapsed d-flex" href="/Sistema-del--CEM--JEHOVA-RAFA/Citas/citas" uk-tooltip="Citas" id="menuCitas" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCitas" aria-expanded="false" aria-controls="collapseCitas">
				<div class="sb-nav-link-icon mx-2">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-heart-fill" viewBox="0 0 16 16">
						<path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5Zm-2 4v-1c0-.276.244-.5.545-.5h10.91c.3 0 .545.224.545.5v1c0 .276-.244.5-.546.5H2.545C2.245 5 2 4.776 2 4.5Zm6 3.493c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z" />
					</svg>
				</div>
				Citas
				<div class="sb-sidenav-collapse-arrow mx-2">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
						<path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
					</svg>
				</div>
			</a>
			<div class="collapse" id="collapseCitas" aria-labelledby="headingCitas" data-bs-parent="#sidenavAccordion d-flex">
				<nav class="sb-sidenav-menu-nested nav">
					<a class="nav-link mx-5" href="/Sistema-del--CEM--JEHOVA-RAFA/Citas/citas">Pendientes</a>
					<a class="nav-link mx-5" href="/Sistema-del--CEM--JEHOVA-RAFA/Citas/citasHoy">Hoy</a>
					<a class="nav-link mx-5" href="/Sistema-del--CEM--JEHOVA-RAFA/Citas/citasRealizadas">Realizadas</a>
				</nav>
			</div>

		<?php endif; ?>

		<?php if (!$this->permisos($_SESSION["id_rol"], "consultar", "Consultas")): ?>
			<!-- no hay -->
		<?php else: ?>
			<a class="nav-link d-flex" href="/Sistema-del--CEM--JEHOVA-RAFA/Consultas/consultas" uk-tooltip="Servicios" id="menuServicios">
				<div class="sb-nav-link-icon mx-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard2-heart-fill" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M10.058.501a.501.501 0 0 0-.5-.501h-2.98c-.276 0-.5.225-.5.501A.499.499 0 0 1 5.582 1a.497.497 0 0 0-.497.497V2a.5.5 0 0 0 .5.5h4.968a.5.5 0 0 0 .5-.5v-.503A.497.497 0 0 0 10.555 1a.499.499 0 0 1-.497-.499Z" />
						<path fill-rule="evenodd" d="M4.174 1h-.57a1.5 1.5 0 0 0-1.5 1.5v12a1.5 1.5 0 0 0 1.5 1.5h9a1.5 1.5 0 0 0 1.5-1.5v-12a1.5 1.5 0 0 0-1.5-1.5h-.642c.055.156.085.325.085.5V2c0 .828-.668 1.5-1.492 1.5H5.581A1.496 1.496 0 0 1 4.09 2v-.5c0-.175.03-.344.085-.5Zm3.894 5.482c1.656-1.673 5.795 1.254 0 5.018-5.795-3.764-1.656-6.69 0-5.018Z" />
					</svg></div>
				Servicio
			</a>
		<?php endif; ?>

		<?php if (!$this->permisos($_SESSION["id_rol"], "consultar", "Doctores")): ?>
			<!-- no hay -->
		<?php else: ?>
			<a class="nav-link d-flex" href="/Sistema-del--CEM--JEHOVA-RAFA/Doctores/doctores" uk-tooltip="Directorio Médico" id="menuDirectorioMedico">
				<div class="sb-nav-link-icon mx-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
						class="bi bi-clipboard2-pulse-fill" viewBox="0 0 16 16">
						<path
							d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5Z" />
						<path
							d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585c.055.156.085.325.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5c0-.175.03-.344.085-.5ZM9.98 5.356 11.372 10h.128a.5.5 0 0 1 0 1H11a.5.5 0 0 1-.479-.356l-.94-3.135-1.092 5.096a.5.5 0 0 1-.968.039L6.383 8.85l-.936 1.873A.5.5 0 0 1 5 11h-.5a.5.5 0 0 1 0-1h.191l1.362-2.724a.5.5 0 0 1 .926.08l.94 3.135 1.092-5.096a.5.5 0 0 1 .968-.039Z" />
					</svg></div>
				Directorío Médico
			</a>
		<?php endif; ?>

		<?php if (!$this->permisos($_SESSION["id_rol"], "consultar", "Control")): ?>
			<!-- no hay -->
		<?php else: ?>
			<a class="nav-link d-flex" href="/Sistema-del--CEM--JEHOVA-RAFA/Control/control" uk-tooltip="Control Médico" id="menuControlMedico">
				<div class="sb-nav-link-icon mx-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
						class="bi bi-person-fill-gear" viewBox="0 0 16 16">
						<path
							d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Zm9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
					</svg></div>
				Control Médico
			</a>
		<?php endif; ?>

		<?php if (!$this->permisos($_SESSION["id_rol"], "consultar", "Hospitalizacion")): ?>
			<!-- no hay -->
		<?php else: ?>
			<a class="nav-link d-flex" href="/Sistema-del--CEM--JEHOVA-RAFA/Hospitalizacion/hospitalizacion" uk-tooltip="Hospitalización"
				id="menuHospitalizacion">
				<div class="sb-nav-link-icon mx-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
						class="bi bi-heart-pulse-fill" viewBox="0 0 16 16">
						<path
							d="M1.475 9C2.702 10.84 4.779 12.871 8 15c3.221-2.129 5.298-4.16 6.525-6H12a.5.5 0 0 1-.464-.314l-1.457-3.642-1.598 5.593a.5.5 0 0 1-.945.049L5.889 6.568l-1.473 2.21A.5.5 0 0 1 4 9H1.475Z" />
						<path
							d="M.88 8C-2.427 1.68 4.41-2 7.823 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C11.59-2 18.426 1.68 15.12 8h-2.783l-1.874-4.686a.5.5 0 0 0-.945.049L7.921 8.956 6.464 5.314a.5.5 0 0 0-.88-.091L3.732 8H.88Z" />
					</svg></div>
				Hospitalizacíon
			</a>
		<?php endif; ?>

		<a class="nav-link collapsed d-flex" href="#" data-bs-toggle="collapse" data-bs-target="#collapseInsumos" aria-expanded="false" aria-controls="collapseInsumos">
			<div class="sb-nav-link-icon mx-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
					class="bi bi-capsule" viewBox="0 0 16 16">
					<path
						d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
				</svg></div>
			Insumos
			<div class="sb-sidenav-collapse-arrow mx-2">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
					<path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
				</svg>
			</div>
		</a>
		<div class="collapse" id="collapseInsumos" aria-labelledby="headingCitas" data-bs-parent="#sidenavAccordion d-flex">
			<nav class="sb-sidenav-menu-nested nav">

				<?php if (!$this->permisos($_SESSION["id_rol"], "consultar", "Insumos")): ?>
					<!-- no hay -->
				<?php else: ?>
					<a class="nav-link mx-5" href="/Sistema-del--CEM--JEHOVA-RAFA/Insumos/insumos" uk-tooltip="Insumos" id="menuInsumos">Insumos</a>
				<?php endif; ?>

				<?php if (!$this->permisos($_SESSION["id_rol"], "consultar", "Entrada")): ?>
					<!-- no hay -->
				<?php else: ?>
					<a class="nav-link mx-5" href="/Sistema-del--CEM--JEHOVA-RAFA/Entrada/entrada" uk-tooltip="Entradas">Entradas</a>
				<?php endif; ?>

				<?php if (!$this->permisos($_SESSION["id_rol"], "consultar", "Proveedores")): ?>
					<!-- no hay -->
				<?php else: ?>
					<a class="nav-link mx-5" href="/Sistema-del--CEM--JEHOVA-RAFA/Proveedores/proveedores" uk-tooltip="Poveedores">Proveedores</a>
				<?php endif; ?>

				<?php if (!$this->permisos($_SESSION["id_rol"], "consultar", "Insumos")): ?>
					<!-- no hay -->
				<?php else: ?>
					<a class="nav-link mx-5" href="/Sistema-del--CEM--JEHOVA-RAFA/Insumos/InsumosVencidos" uk-tooltip="Vencidos">Vencidos</a>
				<?php endif; ?>
			</nav>
		</div>


		<a class="nav-link collapsed d-flex" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsuarios" aria-expanded="false" aria-controls="collapseUsuarios">
			<div class="sb-nav-link-icon mx-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
					class="bi bi-gear-fill" viewBox="0 0 16 16">
					<path
						d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
				</svg></div>
			Usuarios
			<div class="sb-sidenav-collapse-arrow mx-2">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
					<path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
				</svg>
			</div>
		</a>
		<div class="collapse" id="collapseUsuarios" aria-labelledby="headingCitas" data-bs-parent="#sidenavAccordion d-flex">
			<nav class="sb-sidenav-menu-nested nav">
				<?php if (!$this->permisos($_SESSION["id_rol"], "consultar", "Usuarios")): ?>
					<!-- no hay -->
				<?php else: ?>
					<a class="nav-link mx-5" href="/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/usuarios" uk-tooltip="Usuarios">Usuarios</a>
				<?php endif; ?>

				<?php if (!$this->permisos($_SESSION["id_rol"], "consultar", "Usuarios")): ?>
					<!-- no hay -->
				<?php else: ?>
					<a class="nav-link mx-5" href="/Sistema-del--CEM--JEHOVA-RAFA/Usuarios/administradores" uk-tooltip="Administradores">Administradores</a>
				<?php endif; ?>

				<?php if (!$this->permisos($_SESSION["id_rol"], "consultar", "Roles")): ?>
					<!-- no hay -->
				<?php else: ?>
					<a class="nav-link mx-5" href="/Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar" uk-tooltip="Roles">Roles</a>
				<?php endif; ?>
			</nav>
		</div>
		<?php if (!$this->permisos($_SESSION["id_rol"], "consultar", "Reportes")): ?>
			<!-- no hay -->
		<?php else: ?>
			<a class="nav-link d-flex" href="/Sistema-del--CEM--JEHOVA-RAFA/Reportes/reportes" uk-tooltip="Reportes" id="menuReportes">
				<div class="sb-nav-link-icon mx-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
						class="bi bi-clipboard-data-fill" viewBox="0 0 16 16">
						<path
							d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z" />
						<path
							d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1ZM10 8a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0V8Zm-6 4a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0v-1Zm4-3a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z" />
					</svg></div>
				Reportes
			</a>
		<?php endif; ?>

		<?php if (!$this->permisos($_SESSION["id_rol"], "consultar", "Estadisticas")): ?>
			<!-- no hay -->
		<?php else: ?>
			<a class="nav-link d-flex" href="/Sistema-del--CEM--JEHOVA-RAFA/Estadisticas/estadisticas" uk-tooltip="Reportes Estadisticos" id="menuReportesEstadisticos">
				<div class="sb-nav-link-icon mx-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart-fill" viewBox="0 0 16 16">
						<path d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V2z" />
					</svg></div>
				Estadísticas
			</a>

		<?php endif; ?>

		<?php if (!$this->permisos($_SESSION["id_rol"], "consultar", "Mantenimiento")): ?>
			<!-- no hay -->
		<?php else: ?>
			<a class="nav-link d-flex" href="/Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/mantenimiento" uk-tooltip="Mantenimiento" id="menuReportesEstadisticos">
				<div class="sb-nav-link-icon mx-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wrench-adjustable" viewBox="0 0 16 16">
						<path d="M16 4.5a4.5 4.5 0 0 1-1.703 3.526L13 5l2.959-1.11q.04.3.041.61" />
						<path d="M11.5 9c.653 0 1.273-.139 1.833-.39L12 5.5 11 3l3.826-1.53A4.5 4.5 0 0 0 7.29 6.092l-6.116 5.096a2.583 2.583 0 1 0 3.638 3.638L9.908 8.71A4.5 4.5 0 0 0 11.5 9m-1.292-4.361-.596.893.809-.27a.25.25 0 0 1 .287.377l-.596.893.809-.27.158.475-1.5.5a.25.25 0 0 1-.287-.376l.596-.893-.809.27a.25.25 0 0 1-.287-.377l.596-.893-.809.27-.158-.475 1.5-.5a.25.25 0 0 1 .287.376M3 14a1 1 0 1 1 0-2 1 1 0 0 1 0 2" />
					</svg></div>
				Mantenimiento
			</a>

		<?php endif; ?>
	</div>


	<!-- modal de cerrar sesión -->
	<?php require_once './src/vistas/modalCierreS/modalCierreS.php'; ?>

	<!-- Contenido principal -->
	<div id="main">
		<!-- Barra de navegación -->
		<nav class="navbarHorizontal navbar navbar-expand-lg navbar-light bg-light">
			<button class="navbar-toggler" type="button" onclick="openNav()">
				<span class="navbar-toggler-icon"></span>
			</button>
			<!-- < class="navbar-brand" href="#">Mi Sitio Web</> -->
			<img class="" src="<?= $urlBase ?>../src/assets/icons/logo.png" style="width: 180px; height: 55px;">

		</nav>