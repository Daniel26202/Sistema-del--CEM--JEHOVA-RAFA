<?php require_once './src/vistas/head/head.php'; ?>

<div class="d-flex align-items-center justify-content-between mt-4 mb-4">
	<div class="ms-5 d-flex align-items-center" id="inicioFactura">
		<h1 class="fw-bold">FACTURACIÓN</h1>

		<svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" fill="currentColor"
			class="bi bi-file-earmark-text ms-2" viewBox="0 0 16 16">
			<path
				d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z" />
			<path
				d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
		</svg>
	</div>

	<!--  si factura no muestra el btn -->


	<?php //if ($parametro[0] !="" && $parametro[1] !="" || $parametro[0] !="" && $parametro[1] ==""): ?>
<!-- para volver a la parte donde se factura -->
<!-- <div class="mt-2 w-25 d-flex justify-content-center">
	<a href="?c=controladorFactura/facturaInicio" class="text-decoration-none" uk-tooltip="Volver para facturar más" title=""
		aria-describedby="uk-tooltip-17">
		<button class="btnRetroceder" id="btnRetrocederFactura"><svg xmlns="http://www.w3.org/2000/svg" width="36"
				height="36" fill="currentColor" class="bi bi-reply-fill azul" viewBox="0 0 16 16">
				<path
					d="M5.921 11.9 1.353 8.62a.719.719 0 0 1 0-1.238L5.921 4.1A.716.716 0 0 1 7 4.719V6c1.5 0 6 0 7 8-2.5-4.5-7-4-7-4v1.281c0 .56-.606.898-1.079.62z">
				</path>
			</svg>
		</button>
	</a>
</div> -->
		<!-- si no se ha facturado que muestre el btn -->
	<?php// else: ?>

		<div class="me-4" id="desplegarAyudafactura">

			<a><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
					class="bi bi-wrench-adjustable-circle azul" viewBox="0 0 16 16" id="desplegablefactura">
					<path d="M12.496 8a4.491 4.491 0 0 1-1.703 3.526L9.497 8.5l2.959-1.11c.027.2.04.403.04.61Z" />
					<path
						d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0Zm-1 0a7 7 0 1 0-13.202 3.249l1.988-1.657a4.5 4.5 0 0 1 7.537-4.623L7.497 6.5l1 2.5 1.333 3.11c-.56.251-1.18.39-1.833.39a4.49 4.49 0 0 1-1.592-.29L4.747 14.2A7 7 0 0 0 15 8Zm-8.295.139a.25.25 0 0 0-.288-.376l-1.5.5.159.474.808-.27-.595.894a.25.25 0 0 0 .287.376l.808-.27-.595.894a.25.25 0 0 0 .287.376l1.5-.5-.159-.474-.808.27.596-.894a.25.25 0 0 0-.288-.376l-.808.27.596-.894Z" />
				</svg></a>
			<div class="uk-nav uk-dropdown-nav" uk-dropdown="pos: top-right" id="desplegable2">
				<ul>
					<li id="perfilPaciente"><a href="?c=ControladorPerfil/perfil" class="uk-animation-toggle">
							<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
								class="bi bi-person-fill azul uk-animation-scale-up" viewBox="0 0 16 16">
								<path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
							</svg>PERFIL
						</a></li>
					<li class="uk-nav-divider"></li>
					<li><a href="#" id="btnayudaFactura"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26"
								fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
								<path
									d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
							</svg>AYUDA</a></li>
					<li class="uk-nav-divider"></li>
					<li><a href="?c=ControladorBitacora/bitacora" ><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
          <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z"/>
      </svg> CONFIGURACIÓN</a></li>
        <li class="uk-nav-divider"></li>

					<li><a href="#" data-bs-toggle="modal" data-bs-target="#eliminar">
							<img src="./src/assets/img/icono-cerrar-sesion.svg" width="34" height="34" uk-svg class="azul"
								style="margin-left: -4px;">
							</svg>SALIR</a></li>
				</ul>
			</div>
		</div>
	<?php //endif ?>








	<div class="me-4 d-none" id="desplegarAyudafacturaIDCita">

		<a><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
				class="bi bi-wrench-adjustable-circle azul" viewBox="0 0 16 16" id="desplegablefactura2">
				<path d="M12.496 8a4.491 4.491 0 0 1-1.703 3.526L9.497 8.5l2.959-1.11c.027.2.04.403.04.61Z" />
				<path
					d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0Zm-1 0a7 7 0 1 0-13.202 3.249l1.988-1.657a4.5 4.5 0 0 1 7.537-4.623L7.497 6.5l1 2.5 1.333 3.11c-.56.251-1.18.39-1.833.39a4.49 4.49 0 0 1-1.592-.29L4.747 14.2A7 7 0 0 0 15 8Zm-8.295.139a.25.25 0 0 0-.288-.376l-1.5.5.159.474.808-.27-.595.894a.25.25 0 0 0 .287.376l.808-.27-.595.894a.25.25 0 0 0 .287.376l1.5-.5-.159-.474-.808.27.596-.894a.25.25 0 0 0-.288-.376l-.808.27.596-.894Z" />
			</svg>
		</a>
		<div class="uk-nav uk-dropdown-nav" uk-dropdown="pos: top-right" id="desplegable2">
			<ul>
				<li id="perfilPaciente"><a href="?c=ControladorPerfil/perfil" class="uk-animation-toggle">
						<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
							class="bi bi-person-fill azul uk-animation-scale-up" viewBox="0 0 16 16">
							<path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
						</svg>PERFIL
					</a></li>
				<li class="uk-nav-divider"></li>
				<li><a href="#" id="btnayudaFacturaIDCita"><svg xmlns="http://www.w3.org/2000/svg" width="26"
							height="26" fill="currentColor" class="bi bi-question-octagon-fill azul me-1"
							viewBox="0 0 16 16">
							<path
								d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
						</svg>AYUDA</a></li>
				<li class="uk-nav-divider"></li>
				<li><a href="?c=ControladorBitacora/bitacora" ><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
          <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z"/>
      </svg> CONFIGURACIÓN</a></li>
        <li class="uk-nav-divider"></li>

				<li><a href="#" data-bs-toggle="modal" data-bs-target="#eliminar">
						<img src="./src/assets/img/icono-cerrar-sesion.svg" width="34" height="34" uk-svg class="azul"
							style="margin-left: -4px;">
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
				<a href="?c=ControladorInicio/inicio&cerrar" class="btn btn-primary text-decoration-none">Salir</a>
			</div>
		</div>
	</div>
</div>





<!-- paginacion de la tabla -->
<div class="me-4">
	<div class="mt-3 mb-5">
<?php if($parametro != ""):?>

		<?php if ($parametro[0] != ""): ?>

			<?php //print_r($_GET);
			
				echo $parametro[0];
				$datosFactura = $this->modelo->consultarFactura($parametro[0]);


				//echo "Pagos"."<br><br>";
				$datosPago = $this->modelo->consultarPagoFactura($parametro[0]);

				$datosServiciosExtras = $this->modelo->consultarServiciosExtras($parametro[0]);

				$datosInsumos = $this->modelo->consultarFacturaInsumo($parametro[0]);

				?>

			<div class="pb-3">
				<div class="uk-card uk-card-default uk-width-1-2@m m-auto" style="background: #F8FCFF;">
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
							<?php foreach ($datosFactura as $datoFactura): ?>
								<p>Numero Lote:
									<?php echo $datoFactura['id_factura'] ?>
								</p>
								<p>Fecha:
									<?php echo $datoFactura['fecha'] ?>
								</p>
								<p>Total:
									<?php echo $datoFactura['total'] . " BS" ?>
								</p>
								<p>Paciente:
									<?php echo $datoFactura['nombre_p'] . "  " . $datoFactura['apellido_p'] ?>
								</p>
								<p>Cedula Paciente:
									<?php echo $datoFactura['nacionalidad'] . "-" . $datoFactura['cedula_p'] ?>
								</p>

							<?php endforeach ?>
						</div>
						<div style="width:55%;">
							<h5 class="text-center">Métodos de pago</h5>
							<?php foreach ($datosPago as $datoPago): ?>
								<p class="text-center">
									<?php echo $datoPago["nombre"] ?>
									<?php echo $datoPago["monto"] . " BS" ?>
								</p>
							<?php endforeach ?>

							<h5 class="text-center">Servicios</h5>
							<?php foreach ($datosFactura as $datoFactura): ?>
								<div class="d-flex">
									<div class="w-50">
										<p class="text-center">
											<?php echo $datoFactura["categoria_servicio"] ?>
										</p>
									</div>

									<div class="w-50">
										<p class="text-center">
											Doctor:
											<?php echo $datoFactura["nombre_d"] ?>
											<?php echo $datoFactura["apellido_d"] ?>
											<?php echo $datoFactura["precio_servicio"] . " BS" ?>
										</p>
									</div>

								</div>
							<?php endforeach; ?>


							<?php foreach ($datosServiciosExtras as $d): ?>
								<div class="d-flex">
									<div class="w-50">
										<p class="text-center">
											<?php echo $d["categoria_servicio"] ?>
										</p>
									</div>

									<div class="w-50">
										<p class="text-center">
											Doctor:
											<?php echo $d["nombre_d"] ?>
											<?php echo $d["apellido_d"] ?>
											<?php echo $d["precio"] . " BS" ?>
										</p>
									</div>

								</div>

							<?php endforeach ?>

							<h5 class="text-center">Insumos</h5>
							<div class="d-flex">
								<div class="w-50">
									<p class="text-center">
										Insumo:
									</p>
								</div>
								<div class="w-50">
									<p class="text-center">
										Cantidad:
									</p>
								</div>

								<div class="w-50">
									<p class="text-center">
										Precio:
									</p>
								</div>

							</div>
							<?php foreach ($datosInsumos as $d): ?>
								<div class="d-flex">
									<div class="w-50">
										<p class="text-center">
											<?php echo $d["nombre"] ?>
										</p>
									</div>
									<div class="w-50">
										<p class="text-center">
											<?php echo $d["cantidad"] ?>
										</p>
									</div>

									<div class="w-50">
										<p class="text-center">
											<?php echo $d["precio"] . " BS" ?>
										</p>
									</div>

								</div>

							<?php endforeach ?>
						</div>
					</div>
					<?php $id_factura = $parametro[0]; ?>
					<div class="d-flex justify-content-end">
						<div class="uk-card-footer">
							<a href="?c=controladorFactura/mostrarPDF2&id_factura=<?php echo $id_factura; ?>"
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
					</div>
				</div>
			</div>


			<!-- hospitalizacion -->
		<?php elseif (isset($_GET["id_factura"]) && isset($_GET["idH"])): ?>

			<?php //print_r($_GET);
			

				$datosFactura = $this->modelo->consultarFacturaHosp($_GET["id_factura"]);


				//echo "Pagos"."<br><br>";
				$datosPago = $this->modelo->consultarPagoFactura($_GET["id_factura"]);



				$datosInsumos = $this->modelo->consultarFacturaInsumo($_GET["id_factura"]);

				$datosServiciosExtras = $this->modelo->consultarServiciosExtras($_GET["id_factura"]);

				?>

			<div class="pb-3">
				<div class="uk-card uk-card-default uk-width-1-2@m m-auto" style="background: #F8FCFF;">
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
							<?php foreach ($datosFactura as $datoFactura): ?>
								<p>Numero Lote:
									<?php echo $datoFactura['id_factura'] ?>
								</p>
								<p>Fecha:
									<?php echo $datoFactura['fecha'] ?>
								</p>
								<p>Total:
									<?php echo $datoFactura['total'] . " BS" ?>
								</p>
								<p>Paciente:
									<?php echo $datoFactura['nombre_paciente'] . "  " . $datoFactura['apellido_paciente'] ?>
								</p>
								<p>Cedula Paciente:
									<?php echo $datoFactura['nacionalidad'] . "-" . $datoFactura['cedula_paciente'] ?>
								</p>

							<?php endforeach ?>
						</div>
						<div style="width:55%;">
							<h5 class="text-center">Métodos De Pago</h5>
							<?php $nombres_mostrados = array(); ?>
							<?php foreach ($datosPago as $datoPago): ?>
								<?php if(!isset($nombres_mostrados[$datoPago["nombre"]])): ?>

								<p class="text-center">
									<?php echo $datoPago["nombre"] ?>
									<?php echo $datoPago["monto"] . " BS" ?>
								</p> 

								<?php $nombres_mostrados[$datoPago["nombre"]] = true; ?>
								<?php endif;  ?>
							<?php endforeach ?>

							<h5 class="text-center">Servicios</h5>
							<?php foreach ($datosFactura as $datoFactura): ?>
								<div class="d-flex">
									<div class="w-50">
										<p class="text-center">
											Hospitalización
											<?php //echo $datoFactura["categoria_servicio"] ?>
										</p>
									</div>

									<div class="w-50">
										<p class="text-center">
											Doctor:
											<?php echo $datoFactura["nombre_d"] ?>
											<?php echo $datoFactura["apellido_d"] ?>
											<?php echo $datoFactura["precio_horas"] * $datoFactura["duracion"] . " BS" ?>
										</p>
									</div>

								</div>
							<?php endforeach; ?>


							<?php foreach ($datosServiciosExtras as $d): ?>
								<div class="d-flex">
									<div class="w-50">
										<p class="text-center">
											<?php echo $d["categoria_servicio"] ?>
										</p>
									</div>

									<div class="w-50">
										<p class="text-center">
											Doctor:
											<?php echo $d["nombre_d"] ?>
											<?php echo $d["apellido_d"] ?>
											<?php echo $d["precio"] . " BS" ?>
										</p>
									</div>

								</div>

							<?php endforeach ?>

							<h5 class="text-center">Insumos</h5>
							<div class="d-flex">
								<div class="w-50">
									<p class="text-center">
										Insumo:
									</p>
								</div>
								<div class="w-50">
									<p class="text-center">
										Cantidad:
									</p>
								</div>

								<div class="w-50">
									<p class="text-center">
										Precio:
									</p>
								</div>

							</div>
							<?php foreach ($datosInsumos as $d): ?>
								<div class="d-flex">
									<div class="w-50">
										<p class="text-center">
											<?php echo $d["nombre"] ?>
										</p>
									</div>
									<div class="w-50">
										<p class="text-center">
											<?php echo $d["cantidad"] ?>
										</p>
									</div>

									<div class="w-50">
										<p class="text-center">
											<?php echo $d["precio"] . " BS" ?>
										</p>
									</div>

								</div>

							<?php endforeach ?>
						</div>
					</div>
					<?php $id_factura = $_GET["id_factura"]; ?>
					<div class="d-flex justify-content-end">
						<div class="uk-card-footer">
							<a href="?c=controladorFactura/mostrarPDF3&id_factura=<?php echo $id_factura; ?>"
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
					</div>
				</div>
			</div>
		<?php elseif (isset($_GET["id_factura"])): ?>
			<?php //print_r($_GET);
			

				$datosFactura = $this->modelo->consultarFacturaSinCita($_GET["id_factura"]);


				//echo "Pagos"."<br><br>";
				$datosPago = $this->modelo->consultarPagoFactura($_GET["id_factura"]);

				$datosServiciosExtras = $this->modelo->consultarServiciosExtras($_GET["id_factura"]);

				$datosInsumos = $this->modelo->consultarFacturaInsumo($_GET["id_factura"]);

				?>

			<div class="pb-3">
				<div class="uk-card uk-card-default uk-width-1-2@m m-auto" style="background: #F8FCFF;">
					<div clzass="uk-card-header">
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
							<?php foreach ($datosFactura as $datoFactura): ?>
								<p>Código:
									<?php echo $datoFactura['id_factura'] ?>
								</p>
								<p>Fecha:
									<?php echo $datoFactura['fecha'] ?>
								</p>
								<p>Sub-Total:
									<?php echo $datoFactura['total'] . " BS" ?>
								</p>
								<!-- <p> Iva:

								</p> -->
								<p>Total:
									<?php echo $datoFactura['total'] . " BS" ?>
								</p>
								<p>Paciente:
									<?php echo $datoFactura['nombre_p'] . "  " . $datoFactura['apellido_p'] ?>
								</p>
								<p>Cédula Paciente:
									<?php echo $datoFactura['nacionalidad'] . "-" . $datoFactura['cedula_p'] ?>
								</p>

							<?php endforeach ?>
						</div>
						<div style="width:55%;">
							<h5 class="text-center">Métodos De Pago</h5>
							<?php foreach ($datosPago as $datoPago): ?>
								<p class="text-center">
									<?php echo $datoPago["nombre"] ?>
									<?php echo $datoPago["monto"] . " BS" ?>
								</p>
							<?php endforeach ?>

							<h5 class="text-center">Servicios</h5>
							<?php foreach ($datosServiciosExtras as $d): ?>
								<div class="d-flex">
									<div class="w-50">
										<p class="text-center">
											<?php echo $d["categoria_servicio"] ?>
										</p>
									</div>

									<div class="w-50">
										<p class="text-center">
											DR:
											<?php echo $d["nombre_d"] ?>
											<?php echo $d["apellido_d"] ?>
											<?php echo $d["precio"] . " BS" ?>
										</p>
									</div>

								</div>

							<?php endforeach ?>

							<h5 class="text-center">Insumos</h5>
							<div class="d-flex">
								<div class="w-50">
									<p class="text-center">
										Insumo:
									</p>
								</div>
								<div class="w-50">
									<p class="text-center">
										Cantidad:
									</p>
								</div>

								<div class="w-50">
									<p class="text-center">
										Precio:
									</p>
								</div>

							</div>
							<?php foreach ($datosInsumos as $d): ?>
								<div class="d-flex">
									<div class="w-50">
										<p class="text-center">
											<?php echo $d["nombre"] ?>
										</p>
									</div>
									<div class="w-50">
										<p class="text-center">
											<?php echo $d["cantidad"] ?>
										</p>
									</div>

									<div class="w-50">
										<p class="text-center">
											<?php echo $d["precio"] . " BS" ?>
										</p>
									</div>

								</div>

							<?php endforeach ?>
						</div>


					</div>
					<?php $id_factura = $_GET["id_factura"]; ?>

					<div class="d-flex justify-content-end">
						<div class="uk-card-footer">
							<a href="?c=controladorFactura/mostrarPDF&id_factura=<?php echo $id_factura; ?>"
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
					</div>
				</div>
			</div>

		<?php elseif (isset($_GET["id_cita"])): ?>

			<?php $citaFacturar = $this->modelo->mostrarCitaFactura($_GET["id_cita"]);

			?>
			<div class="mt-5 ms-2" style="background: #F8FCFF; border-radius:20px; overflow-y: auto;">
				<div class="">
					<div style="height: 70px;" class=" d-flex justify-content-around">

						<button id="botonAgregar" class="btn btn-primary btn-agregar-doctores ms-4 mt-4 btn-agregar-ins-ser"
							data-bs-toggle="modal" data-bs-target="#modal-agregar">
							<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
								class="bi bi-plus-circle" viewBox="0 0 16 16">
								<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
								<path
									d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
							</svg>
							Agregar Servicio
						</button>

						<button class="btn btn-primary btn-agregar-doctores ms-4 btn-agregar-ins-ser mt-4"
							data-bs-toggle="modal" data-bs-target="#modal-agregar-insumos" id="btnInsumos">
							<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
								class="bi bi-capsule" viewBox="0 0 16 16">
								<path
									d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
							</svg>
							Agregar Insumos
						</button>
						<!-- <div class="d-flex align-items-center">
	<h5 id="datosPaciente"></h5>
</div> -->
						<div class="mt-4 w-25 d-flex justify-content-center">
							<a href="?c=controladorFactura/facturaInicio" class="text-decoration-none"
								uk-tooltip="Retroceder">
								<button class="btnRetroceder" id="btnRetrocederFactura"><svg
										xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
										class="bi bi-reply-fill azul" viewBox="0 0 16 16">
										<path
											d="M5.921 11.9 1.353 8.62a.719.719 0 0 1 0-1.238L5.921 4.1A.716.716 0 0 1 7 4.719V6c1.5 0 6 0 7 8-2.5-4.5-7-4-7-4v1.281c0 .56-.606.898-1.079.62z" />
									</svg>
								</button>
							</a>
						</div>
					</div>
				</div>


				<div class="d-flex justify-content-center">

					<div class="tamaño-tabla mt-5">
						<?php foreach ($citaFacturar as $datoCita): ?>
							<table class="table table-striped" id="tablaDB">
								<thead>
									<tr>
										<th class="fw-bolder mb-0 mt-2">SERVICIO
										</th>
									</tr>
								</thead>
								<tbody id="tablaBODYDB">


									<tr>
										<td class="border-top">
											<div class="fw-bolder">CI:</div>
											<?= $datoCita["nacionalidad"] . "-" . $datoCita["cedula_p"]; ?>
										</td>
										<td class="border-top">
											<div class="fw-bolder">PACIENTE:</div>
											<?= $datoCita["nombre_p"]; ?>
											<?= $datoCita["apellido_p"]; ?>
										</td>

										<td class="border-top">
											<div class="fw-bolder">DOCTOR:</div>
											<?= $datoCita["nombre_d"]; ?>
											<?= $datoCita["apellido_d"]; ?>
										</td>

										<td class="border-top">
											<div class="fw-bolder">S/M:</div>
											<?= $datoCita["especialidad"]; ?>
										</td>
										<td class="border-top">
											<div class="fw-bolder">FECHA:</div>
											<?= $datoCita["fecha"]; ?>
										</td>



									</tr>


								</tbody>

							</table>
							<table class="table table-striped" id="tablaSE">

								<tbody id="tbody">

								</tbody>
							</table>
							<table class="table table-striped" id="tablaIM">
								<thead>
									<tr>
										<th class="fw-bolder mb-0 mt-3 border-bottom">INSUMOS</th>
									</tr>
								</thead>
								<tbody id="tbody-insumos">

								</tbody>
							</table>
							<!-- caja de los botones de vaciar , siguiente, total -->
							<!-- recoradatorio acomodar esto del color -->
							<div class="d-flex justify-content-between align-items-center mt-5">

								<div class="d-flex" id="cajaVaciarTotalSiguiente">
									<button class="btn btn-agregarConsulta ms-3 me-4 " id="vaciarTabla">VACIAR</button>
									<button id="siguienteFact" class="btn btn-agregarConsulta " data-bs-toggle="modal"
										data-bs-target="#modal-pago">SIGUIENTE</button>
								</div>

								<div class=" " id="totalFac">
									<label class="fw-bolder">TOTAL: </label>
									<label>BS</label>
									<?php foreach ($citaFacturar as $datoCita): ?>
										<input type="number" style="margin-left: -1px; padding-left: 6px;"
											class=" w-25 input-buscar text-center" id="totalFactura" disabled>
										<input type="hidden" id="inputTotalCita" value="<?= $datoCita['precio'] ?>">
									<?php endforeach; ?>


								</div>
							</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>






			<!-- condicional de la hospitalizacion -->


		<?php elseif (isset($_GET["idH"])): ?>

			<?php $hospitalizacionFacturar = $this->modelo->selectsFacturaHosp($_GET["idH"]); ?>
			<?php $hospitalizacionInsumos = $this->modelo->selectInsumosHosp($_GET["idH"]);?>
			
			<div class="mt-5 ms-2" style="background: #F8FCFF; border-radius:20px; overflow-y: auto;">
				<div class="">
					<div style="height: 70px;" class=" d-flex justify-content-around">

						<button id="botonAgregar" class="btn btn-primary btn-agregar-doctores ms-4 mt-4 btn-agregar-ins-ser"
							data-bs-toggle="modal" data-bs-target="#modal-agregar">
							<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
								class="bi bi-plus-circle" viewBox="0 0 16 16">
								<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
								<path
									d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
							</svg>
							Agregar Servicio
						</button>

						<!-- <button class="btn btn-primary btn-agregar-doctores ms-4 btn-agregar-ins-ser mt-4" data-bs-toggle="modal" data-bs-target="#modal-agregar-insumos" id="btnInsumos">
							<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-capsule" viewBox="0 0 16 16">
								<path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
							</svg>
							Agregar Insumos
						</button> -->
						<!-- <div class="d-flex align-items-center">
<h5 id="datosPaciente"></h5>
</div> -->
						<div class="mt-4 w-25 d-flex justify-content-center">
							<a href="?c=ControladorHospitalizacion/hospitalizacion" class="text-decoration-none"
								uk-tooltip="Retroceder">
								<button class="btnRetroceder" id="btnRetrocederFactura"><svg
										xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
										class="bi bi-reply-fill azul" viewBox="0 0 16 16">
										<path
											d="M5.921 11.9 1.353 8.62a.719.719 0 0 1 0-1.238L5.921 4.1A.716.716 0 0 1 7 4.719V6c1.5 0 6 0 7 8-2.5-4.5-7-4-7-4v1.281c0 .56-.606.898-1.079.62z" />
									</svg>
								</button>
							</a>
						</div>
					</div>
				</div>


				<div class="d-flex justify-content-center">

					<div class="tamaño-tabla mt-5">
					
						<?php foreach ($hospitalizacionFacturar as $hos): ?>
							<table class="table table-striped" id="tablaDB">
								<thead>
									<tr>
										<th class="fw-bolder mb-0 mt-2">SERVICIO
										</th>
									</tr>
								</thead>
								<tbody id="tablaBODYDB">


									<tr>
										<td class="border-top">
											<div class="fw-bolder">CI:</div>
											<?= $hos["nacionalidad"] . "-" . $hos["cedula"]; ?>
										</td>
										<td class="border-top">
											<div class="fw-bolder">PACIENTE:</div>
											<?= $hos["nombre"]; ?>
											<?= $hos["apellido"]; ?>
										</td>

										<td class="border-top">
											<div class="fw-bolder">DOCTOR:</div>
											<?= $hos["nombredoc"]; ?>
											<?= $hos["apellidodoc"]; ?>
										</td>

										<td class="border-top">
											<div class="fw-bolder">DIAGNOSTICO:</div>
											<?= $hos["diagnostico"]; ?>
										</td>
										<td class="border-top">
											<div class="fw-bolder">HORAS:</div>
											<?= $hos["duracion"]; ?>
										</td>

										<td class="border-top">
											<div class="fw-bolder">PRECIO TOTAL DE LAS HORAS:</div>
											<?= $hos["precio_horas"] * $hos["duracion"] . " BS"; ?>
										</td>



									</tr>


								</tbody>

							</table>
							<table class="table table-striped" id="tablaSE">

								<tbody id="tbody">

								</tbody>
							</table>
							<table class="table table-striped" id="tablaIM">
								<thead>
									<tr>
										<th class="fw-bolder mb-0 mt-3 border-bottom">INSUMOS</th>
									</tr>
								</thead>
								<tbody id="tbody-insumos">
									<?php foreach ($hospitalizacionInsumos as $ins): ?>
										<tr class="border-top tr">
											<th class="id_insumo_escondido d-none">
												<?= $ins["id_insumo"] ?>
											</th>
											<td class="border-top nombre">
												<div class="fw-bolder">INSUMO:</div>
												<?= $ins["nombre"] ?>
											</td>
											<td class="border-top">
												<div class="fw-bolder">CANTIDAD:</div>
												<?= $ins["cantidad_insumo_hospit"] ?>
											</td>
											<td class="border-top">
												<div class="fw-bolder">PRECIO:</div>
												<?= $ins["precio"] ?> BS
											</td>
											<td class="border-top">
												<div class="fw-bolder">SUB-TOTAL:</div>
												<?= $ins["precio"] * $ins["cantidad_insumo_hospit"] ?> BS
											</td>
											<td class="border-top"></td>


										<tr>
										<?php endforeach; ?>
								</tbody>
							</table>
							<!-- caja de los botones de vaciar , siguiente, total -->
							<!-- recoradatorio acomodar esto del color -->
							<div class="d-flex justify-content-between align-items-center mt-5">

								<div class="d-flex" id="cajaVaciarTotalSiguiente">
									<button class="btn btn-agregarConsulta ms-3 me-4 " id="vaciarTabla">VACIAR</button>
									<button id="siguienteFact" class="btn btn-agregarConsulta " data-bs-toggle="modal"
										data-bs-target="#modal-pago">SIGUIENTE</button>
								</div>

								<div class=" " id="totalFac">
									<label class="fw-bolder">TOTAL: </label>
									<label>BS</label>
									<?php foreach ($hospitalizacionFacturar as $hos): ?>
										<input type="number" style="margin-left: -1px; padding-left: 6px;"
											class=" w-25 input-buscar text-center" id="totalFactura" disabled>
										<input type="hidden" id="inputTotalCita" value="<?= $hos['total'] ?>">
									<?php endforeach; ?>


								</div>
							</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>




	<?php endif; ?>




<?php else: ?>
	<?php $citaFacturar = array(); ?>

</div>
</div>

<div> <!-- contenedor de la tabla -->

<div class="div-tablaFactura p-3 ">


	<div class="d-flex justify-content-between pb-4">






		<div class="d-flex justify-content-end">

			<!-- d-flex justify-content-end -->


			<!-- Aqui va el nombre del paciente con la perticion ajax -->

			<!-- input para buscar -->


		</div>
	</div>
	<div class=""
		style="background: #F8FCFF; border-radius:20px; height: 75vh; margin-top:-30px; overflow-y: auto;">

		<div style="height: 70px;" id="cajaBotones" class="d-flex justify-content-end">

			<button id="botonAgregar"
				class="d-none btn btn-primary btn-agregar-doctores ms-4 mt-4 btn-agregar-ins-ser btn-factura"
				data-bs-toggle="modal" data-bs-target="#modal-agregar">
				<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
					class="bi bi-plus-circle" viewBox="0 0 16 16">
					<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
					<path
						d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
				</svg>
				Agregar Servicio
			</button>

			<button class="d-none btn ms-4 mt-4  btn-agregar-ins-ser btn-primary btn-agregar-doctores btn-factura"
				data-bs-toggle="modal" data-bs-target="#modal-agregar-insumos" id="btnInsumos">
				<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
					class="bi bi-capsule" viewBox="0 0 16 16">
					<path
						d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
				</svg>
				Agregar Insumos
			</button>

			<!-- <div class="d-flex mt-3">
			<form id="form-buscador-factura"  autocomplete="off" >

				<input class="form-control w-75 input-buscar" type="number" name="cedula" placeholder="Ingrese Cedula">

				<button class="btn btn-buscar" title="Buscar">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
						<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
					</svg>
				</button>

			</form>
			</div> -->

			<div class="d-flex">
				<div class="mt-4">
					<h5 id="datosPaciente" class="mt-3 text-uppercase" style="margin-left: -25px;"></h5>
					<div class="toast-container position-fixed top-0 end-5 p-3">
						<div class="toast" role="alert" aria-live="assertive" aria-atomic="true" autohide: false
							id="myToastfactura">
							<div class="toast-body">
								<h5 class="fw-bold text-dark text-center">Haz Click en Registrar para Guardar un
									Nuevo Paciente</h5>
								<div class="mt-2 pt-2 border-top">
									<a href="?c=controladorPacientes/getPacientes">
										<button type="button" class="btn btn-agregarcita-modal"> Registrar </button>
									</a>

									<button type="button" class="uk-button me-3 uk-button-default btn-cerrar-modal"
										data-bs-dismiss="toast">Cancelar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="mt-4 validar" id="form-buscador">
					<form id="form-buscador-factura" class="d-flex justify-content-end" autocomplete="off">
						<input class="form-control input-buscar tamaño-input-buscar" type="text" name="cedula"
							placeholder="Ingrese Cedula" required maxlength="8" minlength="6"
							oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
							id="inputBusPaCi">

						<button class="btn btn-buscar " title="Buscar">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
								class="bi bi-search" viewBox="0 0 16 16">
								<path
									d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
							</svg>
						</button>
					</form>
				</div>
			</div>
		</div>
		<div class="mt-5">
			<!-- <div class="d-flex justify-content-end me-3">
						
					</div> -->
			<table class="table table-striped" id="ayudaTabla1">
				<thead>
					<tr>
						<th>SERVICIO MÉDICO</th>

					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>

			<table class="table table-striped" id="ayudaTabla2">

				<tbody id="tbody">

				</tbody>
			</table>
			<table class="table table-striped" id="ayudaTabla3">
				<thead>
					<tr>
						<th>INSUMOS</th>

					</tr>
				</thead>
				<tbody id="tbody-insumos">

				</tbody>
			</table>

			<!-- caja de los botones de vaciar , siguiente, total -->
			<!-- recoradatorio acomodar esto del color -->
			<div class="d-flex justify-content-between align-items-center mt-5">
				<div id="btnVaciar-Siguiente">
					<div class="d-flex" id="cajaVaciarTotalSiguiente">
						<button class="btn btn-agregarConsulta ms-3 me-4 btn-escondidos"
							id="vaciarTabla">VACIAR</button>
						<button id="btnSiguiente" class="btn btn-agregarConsulta btn-escondidos"
							data-bs-toggle="modal" data-bs-target="#modal-pago">SIGUIENTE</button>
					</div>
				</div>
				<div id="totalFac">

					<label class="fw-bolder">TOTAL: </label>
					<label>BS</label>
					<input type="number" style="margin-left: -1px; padding-left: 6px;"
						class=" w-25 input-buscar text-center" id="totalFactura" disabled>
					<input type="hidden" id="inputTotalCita" value="0">
				</div>
			</div>

		</div>

	</div>
</div>


<?php endif; ?>






</div>
</div>


<?php require_once 'modalAgregarFactura.php'; ?>




<?php require_once './src/vistas/head/footer.php'; ?>

<?php if($parametro !=  ""):?>
	<?php $concatenarRuta = "";?>
	<?php foreach($parametro as $p):?>
		<?php $concatenarRuta .= "../";?>

		<script type="text/javascript" src="<?= $concatenarRuta?>../src/assets/factura.js"></script>
		<script type="text/javascript" src="<?= $concatenarRuta?>../src/assets/js/ayudaFactura.js"></script>

	<?php endforeach;?>
<?php else :?>
		<script type="text/javascript" src="../src/assets/factura.js"></script>
		<script type="text/javascript" src="../src/assets/js/ayudaFactura.js"></script>
<?php endif;?>