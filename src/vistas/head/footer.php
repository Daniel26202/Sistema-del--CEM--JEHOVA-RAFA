</div>
















<script type="text/javascript" src="<?= $urlBase ?>../src/assets/uikit/js/uikit.min.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= $urlBase ?>../src/assets/app.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/alertasGenericas.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/intro/intro.min.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/DataTable/jquery-3.7.1.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/DataTable/datatables.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/DataTable/modificacion.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/chart.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/precios.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/expresionesModulares.js"></script>
<script>
	new DataTable('.example', {
		language: {
			decimal: ",",
			thousands: ".",
			lengthMenu: "Mostrar por página _MENU_ ",
			zeroRecords: "No se encontraron resultados",
			info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
			infoEmpty: "No hay registros disponibles",
			infoFiltered: "(filtrado de _MAX_ registros en total)",
			search: "Buscar:"
		}
	});
</script>

<script>
	function openNav() {
		document.getElementById("mySidenav").classList.add("open-sidenav");
	}

	function closeNav() {
		document.getElementById("mySidenav").classList.remove("open-sidenav");
	}
</script>
</body>



</html>