<?php require_once './src/vistas/head/head.php'; ?>

<div class="d-flex align-items-center justify-content-between mt-4 mb-4 Reportes_ayuda">
	<div class="ms-5 d-flex align-items-center">
		<h1 class="fw-bold">REPORTES</h1>
		<svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" fill="currentColor" class="bi bi-clipboard-data ms-2" viewBox="0 0 16 16">
			<path d="M4 11a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0zm6-4a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0zM7 9a1 1 0 0 1 2 0v3a1 1 0 1 1-2 0z" />
			<path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z" />
			<path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z" />
		</svg>
	</div>

	<div class="me-4">

		<a><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-wrench-adjustable-circle azul" viewBox="0 0 16 16" id="desplegablefactura">
				<path d="M12.496 8a4.491 4.491 0 0 1-1.703 3.526L9.497 8.5l2.959-1.11c.027.2.04.403.04.61Z" />
				<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0Zm-1 0a7 7 0 1 0-13.202 3.249l1.988-1.657a4.5 4.5 0 0 1 7.537-4.623L7.497 6.5l1 2.5 1.333 3.11c-.56.251-1.18.39-1.833.39a4.49 4.49 0 0 1-1.592-.29L4.747 14.2A7 7 0 0 0 15 8Zm-8.295.139a.25.25 0 0 0-.288-.376l-1.5.5.159.474.808-.27-.595.894a.25.25 0 0 0 .287.376l.808-.27-.595.894a.25.25 0 0 0 .287.376l1.5-.5-.159-.474-.808.27.596-.894a.25.25 0 0 0-.288-.376l-.808.27.596-.894Z" />
			</svg></a>
		<div class="uk-nav uk-dropdown-nav" uk-dropdown="pos: top-right" id="desplegable2">
			<ul>
				<li id="perfilPaciente"><a href="?c=ControladorPerfil/perfil" class="uk-animation-toggle">
						<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-fill azul uk-animation-scale-up" viewBox="0 0 16 16">
							<path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
						</svg>PERFIL
					</a></li>
				<li class="uk-nav-divider"></li>
				<li><a href="#" id="btnayudaServicioMedico"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
							<path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
						</svg>AYUDA</a></li>
				<li class="uk-nav-divider"></li>

				<li><a href="?c=ControladorBitacora/bitacora" ><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
          <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z"/>
      </svg> CONFIGURACIÓN</a></li>
        <li class="uk-nav-divider"></li>

				<li><a href="#" data-bs-toggle="modal"
						data-bs-target="#eliminar">
						<img src="./src/assets/img/icono-cerrar-sesion.svg" width="34" height="34" uk-svg class="azul" style="margin-left: -4px;">
						</svg>SALIR</a></li>
			</ul>
		</div>
	</div>
</div>

<!-- Modal Cerrar Sesion  -->
<div class="modal fade" id="eliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="m-3">
				<?php

				echo '<h5 class="modal-title" id="exampleModalLabel">
                    ¿' . $_SESSION['usuario'] . '   ' . 'Desea Cerrar 
                    la Sesion?
                    </h5>';
				?>
			</div>
			<div class="modal-body ">
				Una vez cerrada la sesión tendrá que iniciar sesión nuevamente.
			</div>
			<div class="m-3 me-4 d-flex justify-content-end">
				<button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancelar</button>
				<a href="?c=ControladorInicio/inicio&cerrar" class="btn btn-primary  text-decoration-none">Salir</a>
			</div>
		</div>
	</div>
</div>


<!-- Buscador de Reportes-->


<div class="repor">

	<div class="cardReporte text-white mb-3">
		<a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#exampleModalBuscador">
			<div class="card-body cartaRepor">
				<div class="ico">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
						class="bi bi-calendar2-heart-fill mb-2 t" viewBox="0 0 16 16">
						<path
							d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5Zm-2 4v-1c0-.276.244-.5.545-.5h10.91c.3 0 .545.224.545.5v1c0 .276-.244.5-.546.5H2.545C2.245 5 2 4.776 2 4.5Zm6 3.493c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z" />
					</svg>
				</div>
				<h4 class="card-title t">Citas</h4>
				<p class="card-text t text-center">Descargar Reporte de Citas</p>
			</div>
		</a>
	</div>

	<div class="cardReporte text-white mb-3">
		<a href="/Sistema-del--CEM--JEHOVA-RAFA/Reportes/pacientePDF&pdf" class="text-decoration-none">
			<div class="card-body cartaRepor">
				<div class="ico">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
						class="bi bi-people-fill mb-2 t" viewBox="0 0 16 16">
						<path
							d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
					</svg>
				</div>
				<h4 class="card-title t">Pacientes</h4>
				<p class="card-text t text-center">Descargar Reporte de Pacientes</p>
			</div>
		</a>
	</div>

	<div class="cardReporte text-white mb-3">
		<a class="text-decoration-none"  data-bs-toggle="modal" data-bs-target="#exampleModalBuscadorEntradas">
			<div class="card-body cartaRepor">
				<div class="ico">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-people-fill mb-2 t" viewBox="0 0 16 16">
                            <path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zM3.81.563A1.5 1.5 0 0 1 4.98 0h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393z" />
                        </svg>
				</div>
				<h4 class="card-title t">Entradas de Insumos</h4>
				<p class="card-text t text-center">Descargar Reporte de las Entradas de Insumos</p>
			</div>
		</a>
	</div>
</div>

<div class="reportess">
	<div class="granReporte text-white  mb-3">
		<a href="/Sistema-del--CEM--JEHOVA-RAFA/Reportes/insumosPDF&pdf" class="text-decoration-none">
			<div class="card-body granRepor">
				<div class="ico">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
						class="bi bi-capsule t" viewBox="0 0 16 16">
						<path
							d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
					</svg>
				</div>
				<h4 class="card-title t">Insumos</h4>
				<p class="card-text t text-center">Descargar Reporte de Insumos.</p>
			</div>
		</a>
	</div>

	<div class="reReporte text-white  mb-3">
		<a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#myModal">
			<div class="card-body reRepor">
				<div class="ico">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-file-earmark-text-fill mb-2 t" viewBox="0 0 16 16">
						<path
							d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z" />
					</svg>

				</div>
				<h4 class="card-title t">Facturación</h4>
				<p class="card-text t text-center">Descargar Reporte de Facturación</p>
			</div>
		</a>
	</div>

</div>


<!-- Modal Factura -->
<div class="modal fade modalCapa " id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-fullscreen-xxl-down fullscreen-modal">
		<div class="modal-content">





			<div class="modal-header height_modal_factura">
				<div class="d-flex justify-content-center align-items-center">
					<div>
						<img class="rounded-circle d-flex justify-content-center " width="75" height="75" src="./src/assets/img/logotipo.jpg">
					</div>
					<div>
						<h3 class="modal-title fw-bold text-white ms-4" id="exampleModalLabel">REPORTES DE FACTURACIÓN <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-file-earmark-text-fill mb-1" viewBox="0 0 16 16">
								<path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z" />
							</svg></h3>

					</div>
				</div>
				<div>
					<button type="button" class="btn btn-cerrar-modalFactura" data-bs-dismiss="modal" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-circle text-white" viewBox="0 0 16 16">
							<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
							<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
						</svg></button>
				</div>
			</div>
			<div class="modal-body">




				<!-- alerta -->
				<div class="alert alert-danger text-center d-none" id="alerta-fecha"></div>
				<div class="d-flex justify-content-between">

					<div class="mover-input-buscar mt-4">
						<form id="formularioDeFecha" class="d-flex" autocomplete="off" action="?c=ControladorReportes/reportesFactura" method="POST">

							<input type="date" name="fechaInicio" id="fechaInicio" class="form-control input-buscar fecha-exp" style="width: 27%;" title="fecha de Inicio">

							<input type="date" name="fechaFinal" id="fechaFinal" class="form-control input-buscar fecha-exp" style="width: 27%;" title="fecha de final">



							<a href="#" class="btn btn-buscar " id="buscarFecha" title="Buscar Entradas Por Fecha">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
									<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
								</svg>
							</a>
							<div>
								<button class="btn btn-tabla ms-5 d-none" id="btnImprimir" type="submit">

									<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
										<path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
										<path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
									</svg>
								</button>
							</div>
						</form>


					</div>



					<div class="d-flex justify-content-end mb-4 col-6 mt-3 me-5" id="form-buscador" style="margin-left: -100px;">

						<form id="form-buscadorEspecialidad"
							class="d-flex justify-content-end mt-4 me-5 mb-3" autocomplete="off">
							<input class="form-control input-busca" type="text" name="nombre" placeholder="Paciente"
								id="inputBuscarEspecialidad">
							<a href="#" class="btn boton-buscar" title="Buscar" id="especialidadBuscar">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search"
									viewBox="0 0 16 16">
									<path
										d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
								</svg>
							</a>
						</form>
					</div>

				</div>

				<div class="tamaño_tabla contenedor_tabla m-auto">

					<table class="table table-striped">

						<thead>
							<tr>
								<th class="text-center">Código Factura</th>
								<th class=" text-center border-start">CI</th>
								<th class=" text-center border-start">Paciente</th>
								<th class=" text-center border-start">Fecha</th>
								<th class=" text-center border-start">Monto</th>
								<th class=" text-center border-start">Acción</th>
							</tr>
						</thead>
						<tbody class="tbody" id="tbodyReporte">
							<?php foreach ($facturas as $factura): ?>

								<tr>
									<td class="text-center"><?php echo $factura["id_factura"] ?></td>
									<td class=" text-center border-start"><?php echo $factura["nacionalidad"] . "-" . $factura["cedula_p"] ?></td>
									<td class=" text-center border-start"><?php echo $factura["nombre_p"] . " " . $factura["apellido_p"]  ?></td>
									<td class=" text-center border-start"><?php echo $factura["fecha"] ?></td>
									<td class=" text-center border-start"><?php echo $factura["total"] . " BS" ?></td>
									<td class=" text-center border-start">

										<!-- boton informacion -->

										<button class="btn btn-tabla mb-1 infoFactura" uk-toggle="target: #modal-example<?= $factura["id_factura"] ?>" name="<?= $factura["id_factura"] ?>">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
												<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
											</svg>
										</button>



										<!-- Modal Mostrar Info  -->












									</td>
								</tr>











								<div id="modal-example<?= $factura["id_factura"] ?>" uk-modal class="modalCapa modalInterno">
									<div class="uk-modal-dialog uk-modal-body " style="border-radius: 20px;">
										<!-- Boton que cierra el modal -->
										<a href="#">
											<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
												class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
												<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
												<path
													d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
											</svg>
										</a>
										<div class="d-flex align-items-center mb-3">
											<div>
												<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-info-circle azul me-3 mb-3" viewBox="0 0 16 16">
													<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
													<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
												</svg>
											</div>
											<div class="">
												<p class="uk-modal-title fs-5 ">
													Información
												</p>

											</div>


										</div>


										<div class="pb-3">
											<div class="uk-card uk-card-default m-auto shadow " style="background: #F8FCFF; width:100%;">
												<div class="uk-card-header">
													<div class="uk-grid-small uk-flex-middle" uk-grid>
														<div class="uk-width-auto">
															<img class="uk-border-circle" width="40" height="40" src="./src/assets/img/logotipo.jpg"
																alt="Avatar">
														</div>
														<div class="uk-width-expand">
															<h3 class="uk-card-title uk-margin-remove-bottom">Factura J-R</h3>
														</div>
													</div>
												</div>
												<div class="uk-card-body d-flex">
													<div style="width:45%;">

														<p>Codigo:<?php echo $factura["id_factura"] ?>

														</p>
														<p>Fecha:<?php echo $factura["fecha"] ?>

														</p>
														<p>Total:<?php echo $factura["total"] . " BS" ?>

														</p>
														<!-- <p>Iva:
									
								</p> -->
														<!-- <p>Total: -->

														</p>
														<p>Paciente:<?php echo $factura["nombre_p"] . " " . $factura["apellido_p"]  ?>

														</p>
														<p>Cedula Paciente: <br> <?php echo $factura["nacionalidad"] . "-" . $factura["cedula_p"] ?>

														</p>
														<h5 class="text-center pago" id="pagoDefac">

														</h5>


													</div>
													<div style="width:55%;">
														<h5 class="text-center">Metodos De Pago</h5>

														<div class="pagoDefac" id="pagoDefac">

														</div>




														<h5 class="text-center">Servicios</h5>
														<div class="text-center pago" id="pago">

														</div>
														<div class="d-flex justify-content-center w-100">
															<!-- <div class="w-50 ">
																			 <p class="text-center">
																				<?php echo $factura["categoria_servicio"] ?>
																			</p> 
																		</div> -->

															<div class="w-100 masSer">
																<!--  <p class="">

																				Dr <?php echo $factura["nombre_d"] ?>

																				<?php echo $factura["apellido_d"] ?><br> <?php echo $factura["precio_servicio"] . " BS" ?>
																				 <?php echo $factura["precio_servicio"] . " BS" ?>
																			</p> -->
															</div>
															<div class="masServicios"> </div>

														</div>



														<h5 class="text-center">Insumos</h5>

														<div class="">
															<div class="w-100">
																<p class="text-center insumos">

																</p>
															</div>

														</div>


													</div>
												</div>

												<div class="d-flex justify-content-end">
													<div class="uk-card-footer">
														<!-- <a href="?c=controladorReportes/factura&id_factura=<?= $factura["id_factura"] ?>"
															class="btn btn-tabla pdf">
															<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
																class="bi bi-printer-fill" viewBox="0 0 16 16">
																<path
																	d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
																<path
																	d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
															</svg>
														</a> -->
														<a href="?c=controladorReportes/factura&id_factura=<?= $factura["id_factura"] ?>&id_cita=<?= $factura["id_cita"] ?>"
															class="btn btn-tabla pdf2">
															<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
																class="bi bi-printer-fill" viewBox="0 0 16 16">
																<path
																	d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
																<path
																	d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
															</svg>
														</a>

													</div>
												</div>
											</div>
										</div>
										<div class="mt-3 uk-text-right">
											<button class="uk-button col-6 me-2 uk-button-default uk-modal-close btn-cerrar-modal"
												type="button">Cerrar</button>
											<button class="btn col-5 btn-agregarcita-modal" type="sumit" name="guardar" uk-toggle="target:#eliminar<?= $factura["id_factura"] ?>">Anular</button>
										</div>

									</div>
								</div>


								<div id="eliminar<?= $factura["id_factura"] ?>" uk-modal class="madalAnular">
									<div class="uk-modal-dialog uk-modal-body tamaño-modal">
										<!-- Boton que cierra el modal -->
										<a href="#">
											<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
												<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
												<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
											</svg>
										</a>

										<div class="d-flex align-items-center">
											<div>
												<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill azul me-2 mb-2" viewBox="0 0 16 16">
													<path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
												</svg>
											</div>
											<div>
												<h5>
													¿Está seguro de Anular la Factura?
												</h5>
											</div>
										</div>

										<div class="mt-3 uk-text-right">
											<button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>


											<form action="?c=ControladorReportes/anularFactura" method="POST">
												<input type="hidden" value="<?= $factura["id_factura"] ?>" name="id_factura">
												<input type="hidden" value="<?= $_SESSION['id_usuario'] ?>" name="id_usuario_bitacora">

												<button class="btn col-4 btn-agregarcita-modal " type="submit">Si</button>
											</form>

										</div>

									</div>
								</div>




















							<?php endforeach ?>

						</tbody>
					</table>

					<table class="table table-striped d-none" style="margin-top: -16px;" id="noresultados">
						<thead>

						</thead>
						<tbody>
							<tr class="">
								<td colspan="9" class="text-center">NO HAY REGISTROS

								</td>
							</tr>
						</tbody>

					</table>
				</div>
			</div>


			<div class="modal-footer d-flex justify-content-between">
				<div class="">
					<a href="#" uk-tooltip="Ayuda">
						<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
							class="bi bi-question-octagon-fill azul ms-4" viewBox="0 0 16 16" id="btnayudaEspecialidades">
							<path
								d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
						</svg>
					</a>
				</div>
				<div class="me-4">
					<button type="button" class="btn uk-button-default uk-modal-close btn-cerrar-modal" data-bs-dismiss="modal">CERRAR</button>
					<button type="button" class="btn btn-agregarcita-modal" data-bs-toggle="modal" data-bs-target="#myModalAnular">Facturas Anuladas</button>
				</div>
			</div>
		</div>
	</div>
</div>






<!-- Modal -->
<div class="modal fade modalBuscadorP" id="exampleModalBuscador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">

		<div class="modal-content modalBuscador">
			<div>
				<a href="#" data-bs-dismiss="modal" aria-label="Close">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default text-white " viewBox="0 0 16 16">
						<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
						<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
					</svg>
				</a>
				<h5 class="fw-bolder mt-3 ms-3 text-uppercase text-white fecha_citas" id="exampleModalLabel">Seleccione el Rango de Fechas</h5>
			</div>

			<div class="modal-body ">
				<div id="alertaDeFecha" class="alert alert-danger text-center d-none"></div>


				<article class="uk-comment" role="comment" id="articulo">

					<div class="uk-grid-medium uk-flex-middle" uk-grid>

						<div class="uk-width-auto">

							<!-- <img src="./src/assets/img/seguro-de-salud.png" width="80" height="80" uk-svg class="iconoB pb-1">  -->



						</div>

						<div class="d-flex justify-content-center">


							<form action="/Sistema-del--CEM--JEHOVA-RAFA/Reportes/buscarPDF" method="POST" id="formularioCita">
								<ul class="  uk-subnav-divider uk-margin-remove-top margin d-flex fechas_mover" id="ul">
									<li><a href="#" class="text-decoration-none fw-bolder text-uppercase text-white me-3" id="cedulab">DESDE<input class="input-expresion form-control  input-disabled input-paciente col-10" type="date" name="desdeFecha" id="desdeFecha"></a></li>
									<li class="li_mover"><a href="#" class="text-decoration-none fw-bolder text-uppercase text-white" id="telefonob">HASTA<input class="input-expresion form-control input-disabled input-paciente col-10" name="fechaHasta" id="fechaHasta" type="date"></a></li>
								</ul>

						</div>
					</div>



				</article>
			</div>
			<div class="d-flex justify-content-end aling-items-center">
				<button class="uk-button col-4 uk-button-default uk-modal-close btn-cerrar-modal " data-bs-dismiss="modal" type="button">Cancelar</button>

				<button type="submit" class="btn me-3 " id="botonDeImprimir"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
						<path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1" />
						<path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
					</svg></button>
				</form>
			</div>


		</div>
	</div>
</div>




<!-- Modal -->
<div class="modal fade modalBuscadorP" id="exampleModalBuscadorEntradas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">

		<div class="modal-content modalBuscador">
			<div>
				<a href="#" data-bs-dismiss="modal" aria-label="Close">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default text-white " viewBox="0 0 16 16">
						<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
						<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
					</svg>
				</a>
				<h5 class="fw-bolder mt-3 ms-3 text-uppercase text-white fecha_entradas" id="exampleModalLabel">Seleccione El Insumo</h5>
			</div>

			<div class="modal-body ">
				<div id="alertaDeFechaEntradas" class="alert alert-danger text-center d-none"></div>


				<article class="uk-comment" role="comment" id="articulo">

					<div class="uk-grid-medium uk-flex-middle" uk-grid>

						<div class="uk-width-auto">

							<!-- <img src="./src/assets/img/seguro-de-salud.png" width="80" height="80" uk-svg class="iconoB pb-1">  -->



						</div>

						<div class="d-flex justify-content-center">


							<form action="/Sistema-del--CEM--JEHOVA-RAFA/Reportes/buscarEntradasInsumosPDF" method="POST" id="formularioEntradas">

								<select id="selectInsumoEntradas" name="id_insumo" class="form-control w-100">
									<option selected disabled>Seleccione un Insumo</option>

									<?php foreach ($insumos as $i): ?>
										<option value="<?= $i['id_insumo']?>"><?= $i['nombre']?></option>
									<?php endforeach ?>
								</select>


								<!-- <h5 class="fw-bolder mt-3 ms-3 text-uppercase text-white fecha_entradas"><input type="checkbox" class="form-check-input m-3 card-title t" id="fechas_entradas" >BUSQUÉ POR FECHAS LAS ENTRADAS</h5> -->

								<div id="cajaCheckboxEntrada" class="form-check mt-2 mb-2 d-none">
								  <input class="form-check-input" type="checkbox" value="" id="checkboxEntradas">
								  <label class="form-check-label fw-bolder ms-3 text-uppercase text-white fecha_entradas" for="flexCheckDefault">
								    BUSQUÉ POR FECHAS LAS ENTRADAS
								  </label>
								</div>




								<ul class="  uk-subnav-divider uk-margin-remove-top margin d-flex fechas_mover d-none " id="cajaModalEntradas">

									<li><a href="#" class="text-decoration-none fw-bolder text-uppercase text-white me-3" >DESDE<input class="input-expresion form-control  input-disabled input-paciente col-10" type="date" name="desdeFechaEntradas" id="desdeFechaEntradas"></a></li>
									<li class="li_mover"><a href="#" class="text-decoration-none fw-bolder text-uppercase text-white" >HASTA<input class="input-expresion form-control input-disabled input-paciente col-10" name="fechaHastaEntradas" id="fechaHastaEntradas" type="date"></a></li>
								</ul>

						</div>
					</div>



				</article>
			</div>
			<div class="d-flex justify-content-end aling-items-center">
				<button class="uk-button col-4 uk-button-default uk-modal-close btn-cerrar-modal " data-bs-dismiss="modal" type="button">Cancelar</button>

				<button type="submit" class="btn me-3 d-none" id="botonDeImprimirEntradas"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
						<path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1" />
						<path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
					</svg></button>
				</form>
			</div>


		</div>
	</div>
</div>




<!-- facturas Anuladas -->

<div class="modal fade modalCapa " id="myModalAnular" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-fullscreen-xxl-down fullscreen-modal">
		<div class="modal-content">
			<div class="modal-header height_modal_factura">
				<div class="d-flex justify-content-center align-items-center">
					<div>
						<img class="rounded-circle d-flex justify-content-center " width="75" height="75" src="./src/assets/img/logotipo.jpg">
					</div>
					<div>
						<h3 class="modal-title fw-bold text-white ms-4" id="exampleModalLabel">FACTURAS ANULADAS <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-file-earmark-text-fill mb-1" viewBox="0 0 16 16">
								<path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z" />
							</svg></h3>

					</div>
				</div>
				<div>
					<button type="button" class="btn btn-cerrar-modalFactura" data-bs-toggle="modal" data-bs-target="#myModal" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-circle text-white" viewBox="0 0 16 16">
							<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
							<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
						</svg></button>
				</div>
			</div>
			<div class="modal-body">

				<div class="div-tablaReportes">
					<div class="d-flex justify-content-between">

						<div class="mover-input-buscar mt-4">
							<form id="formularioDeFechaAnulada" class="d-flex" autocomplete="off" action="?c=ControladorReportes/reportesFacturasAnuladas" method="POST">

								<input type="date" name="fechaInicioAnulada" id="fechaInicioAnulada" class="form-control input-buscar fecha-exp" style="width: 27%;" title="fecha de Inicio">

								<input type="date" name="fechaFinalAnulada" id="fechaFinalAnulada" class="form-control input-buscar fecha-exp" style="width: 27%;" title="fecha de final">



								<a href="#" class="btn btn-buscar " id="buscarFechaAnulada" title="Buscar Entradas Por Fecha">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
										<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
									</svg>
								</a>
								<div>
									<button class="btn btn-tabla ms-5 d-none" id="btnImprimirAnulada" type="submit">

										<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
											<path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
											<path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
										</svg>
									</button>
								</div>
							</form>


						</div>





						<div class="d-flex justify-content-end mb-4 col-6 mt-3 me-5" id="form-buscador">

							<form id="form-buscadorEspecialidad"
								class="d-flex justify-content-end mt-4 me-5 mb-3" autocomplete="off">
								<input class="form-control input-busca" type="text" name="nombre" placeholder="Paciente" id="buscarFacturasAnuladas">
								<a href="#" class="btn boton-buscar" title="Buscar" id="especialidadBuscar">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search"
										viewBox="0 0 16 16">
										<path
											d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
									</svg>
								</a>
							</form>
						</div>
					</div>

					<div class="tamaño_tabla contenedor_tabla m-auto">

						<table class="table table-striped">

							<thead>
								<tr>
									<th class="text-center">Código Factura</th>
									<th class=" text-center border-start">CI</th>
									<th class=" text-center border-start">Paciente</th>
									<th class=" text-center border-start">Fecha</th>
									<th class=" text-center border-start">Monto</th>
									<th class=" text-center border-start">Acción</th>
								</tr>
							</thead>
							<tbody class="tbodyAnuladas" id="tbodyAnuladas">
								<?php foreach ($anuladas as $factura): ?>

									<tr>
										<td class="text-center"><?php echo $factura["id_factura"] ?></td>
										<td class=" text-center border-start"><?php echo $factura["nacionalidad"] . "-" . $factura["cedula_p"] ?></td>
										<td class=" text-center border-start"><?php echo $factura["nombre_p"] . " " . $factura["apellido_p"]  ?></td>
										<td class=" text-center border-start"><?php echo $factura["fecha"] ?></td>
										<td class=" text-center border-start"><?php echo $factura["total"] . " BS" ?></td>
										<td class=" text-center border-start">

											<!-- boton informacion -->

											<button class="btn btn-tabla mb-1 infoFactura" uk-toggle="target: #modal-example<?= $factura["id_factura"] ?>" name="<?= $factura["id_factura"] ?>">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
													<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
												</svg>
											</button>



											<!-- Modal Mostrar Info  -->












										</td>
									</tr>











									<div id="modal-example<?= $factura["id_factura"] ?>" uk-modal class="modalCapa modalInterno">
										<div class="uk-modal-dialog uk-modal-body " style="border-radius: 20px;">
											<!-- Boton que cierra el modal -->
											<a href="#">
												<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
													class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
													<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
													<path
														d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
												</svg>
											</a>

											<div class="d-flex align-items-center mb-3">
												<div>
													<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-info-circle azul me-3 mb-3" viewBox="0 0 16 16">
														<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
														<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
													</svg>
												</div>
												<div class="">
													<p class="uk-modal-title fs-5 ">
														Información
													</p>

												</div>


											</div>


											<div class="pb-3">
												<div class="uk-card uk-card-default m-auto shadow " style="background: #F8FCFF; width:100%;">
													<div class="uk-card-header">
														<div class="uk-grid-small uk-flex-middle" uk-grid>
															<div class="uk-width-auto">
																<img class="uk-border-circle" width="40" height="40" src="./src/assets/img/logotipo.jpg"
																	alt="Avatar">
															</div>
															<div class="uk-width-expand">
																<h3 class="uk-card-title uk-margin-remove-bottom">Factura J-R</h3>
															</div>
														</div>
													</div>
													<div class="uk-card-body d-flex">
														<div style="width:45%;">

															<p>Codigo:<?php echo $factura["id_factura"] ?>

															</p>
															<p>Fecha:<?php echo $factura["fecha"] ?>

															</p>
															<p>Total:<?php echo $factura["total"] . " BS" ?>

															</p>
															<!-- <p>Iva:
									
								</p> -->
															<!-- <p>Total: -->

															</p>
															<p>Paciente:<?php echo $factura["nombre_p"] . " " . $factura["apellido_p"]  ?>

															</p>
															<p>Cedula Paciente: <br> <?php echo $factura["nacionalidad"] . "-" . $factura["cedula_p"] ?>

															</p>
															<h5 class="text-center pago">

															</h5>


														</div>
														<div style="width:55%;">
															<h5 class="text-center">Metodos De Pago</h5>

															<div class="pagoDefac">

															</div>




															<h5 class="text-center">Servicios</h5>
															<div class="text-center pago" id="pago">

															</div>
															<div class="w-100">
																<!-- <div class="w-50 ">
																			 <p class="text-center">
																				<?php echo $factura["categoria_servicio"] ?>
																			</p> 
																		</div> -->

																<div class="w-100 masSer">
																	<!--  <p class="">

																				Dr <?php echo $factura["nombre_d"] ?>

																				<?php echo $factura["apellido_d"] ?><br> <?php echo $factura["precio_servicio"] . " BS" ?>
																				 <?php echo $factura["precio_servicio"] . " BS" ?>
																			</p> -->
																</div>
																<div class="masServicios"> </div>

															</div>





															<h5 class="text-center">Insumos</h5>

															<div class="">
																<div class="w-100">
																	<p class="text-center insumos">

																	</p>
																</div>

															</div>

														</div>
													</div>
												</div>

												<!-- <div class="d-flex justify-content-end">
													<div class="uk-card-footer">
														<a href="?c=controladorFactura/mostrarPDF&id_factura"
															class="btn btn-tabla">
															<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
																class="bi bi-printer-fill" viewBox="0 0 16 16">
																<path
																	d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z" />
																<path
																	d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
															</svg>
														</a>
													</div>
												</div> -->
											</div>
											<div class="mt-3 uk-text-right">
												<button class="uk-button col-6 me-2 uk-button-default uk-modal-close btn-cerrar-modal"
													type="button">Cerrar</button>
											</div>
										</div>


									</div>
					</div>


					<div id="eliminar<?= $factura["id_factura"] ?>" uk-modal class="madalAnular">
						<div class="uk-modal-dialog uk-modal-body tamaño-modal">
							<!-- Boton que cierra el modal -->
							<a href="#">
								<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
									<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
									<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
								</svg>
							</a>

							<div class="d-flex align-items-center">
								<div>
									<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill azul me-2 mb-2" viewBox="0 0 16 16">
										<path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
									</svg>
								</div>
								<div>
									<h5>
										¿Está seguro de Anular la Factura?
									</h5>
								</div>
							</div>

							<div class="mt-3 uk-text-right d-flex">
								<button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>

								<a href="#">
									<button class="btn col-4 btn-agregarcita-modal anularfactura uk-modal-close " type="button" name="<?= $factura["id_factura"] ?>">Si</button>
								</a>
							</div>

						</div>
					</div>




















				<?php endforeach ?>

				</tbody>
				</table>
				<table class="table table-striped d-none" style="margin-top: -16px;" id="noresultadosAnuladas">
					<thead>

					</thead>
					<tbody>
						<tr class="">
							<td colspan="9" class="text-center">NO HAY REGISTROS

							</td>
						</tr>
					</tbody>

				</table>
				</div>
			</div>
		</div>

		<div class="modal-footer d-flex justify-content-between">
			<div class="">
				<a href="#" uk-tooltip="Ayuda">
					<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
						class="bi bi-question-octagon-fill azul ms-4" viewBox="0 0 16 16" id="btnayudaEspecialidades">
						<path
							d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
					</svg>
				</a>
			</div>
			<div class="me-4">
				<button type="button" class="btn uk-button-default uk-modal-close btn-cerrar-modal" data-bs-toggle="modal" data-bs-target="#myModal">VOLVER</button>

			</div>
		</div>
	</div>
</div>
</div>

<script src="<?= $urlBase?>../src/assets/js/reporteCitaYEntradasDeInsumos.js"></script>
<script src="<?= $urlBase?>../src/assets/js/reportes.js"></script>

<?php require_once './src/vistas/head/footer.php'; ?>