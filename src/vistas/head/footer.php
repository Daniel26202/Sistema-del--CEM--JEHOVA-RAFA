	</main>



	<script type="text/javascript" src="<?= $urlBase ?>../src/assets/uikit/js/uikit.min.js"></script>
	<script type="text/javascript" src="<?= $urlBase ?>../src/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?= $urlBase ?>../src/assets/app.js"></script>
	<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/validacionesPacientesEditar.js"></script>
	<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/validacionesFactura.js"></script>
	<script type="text/javascript" src="<?= $urlBase ?>../src/assets/intro/intro.min.js"></script>
	<script type="text/javascript" src="<?= $urlBase ?>../src/assets/DataTable/datatables.js"></script>
	<script type="text/javascript" src="<?= $urlBase ?>../src/assets/DataTable/jquery-3.7.1.js"></script>
	<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/chart.js"></script>

	<script>

		console.log("dt-search")

		console.log($(".dt-input "))

		new DataTable('.example', {
			columnDefs: [{
					targets: [0],
					orderData: [0, 1]
				},
				{
					targets: [1],
					orderData: [1, 0]
				},
				{
					targets: [4],
					orderData: [4, 0]
				}
			]
		});
	</script>
	</body>

	</html>