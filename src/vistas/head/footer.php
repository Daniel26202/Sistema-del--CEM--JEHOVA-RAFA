	</main>

	<?php if ($parametro != ""): ?>
		<?php $concatenarRuta = ""; ?>
		<?php foreach ($parametro as $p): ?>
			<?php $concatenarRuta .= "../"; ?>
			<script type="text/javascript" src="<?= $concatenarRuta ?>../src/assets/uikit/js/uikit.min.js"></script>
			<script type="text/javascript" src="<?= $concatenarRuta ?>../src/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
			<script src="<?= $concatenarRuta ?>../src/assets/app.js"></script>
			<script type="text/javascript" src="<?= $concatenarRuta ?>../src/assets/js/validacionesPacientesEditar.js"></script>
			<script type="text/javascript" src="<?= $concatenarRuta ?>../src/assets/js/validacionesFactura.js"></script>

			<script type="text/javascript" src="<?= $concatenarRuta ?>../src/assets/intro/intro.min.js"></script>
		<?php endforeach; ?>
	<?php else: ?>
		<script type="text/javascript" src="../src/assets/uikit/js/uikit.min.js"></script>
		<script type="text/javascript" src="../src/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="../src/assets/app.js"></script>
		<script type="text/javascript" src="../src/assets/js/validacionesPacientesEditar.js"></script>
		<script type="text/javascript" src="../src/assets/js/validacionesFactura.js"></script>

		<script type="text/javascript" src="../src/assets/intro/intro.min.js"></script>
		<script type="text/javascript" src="../src/assets/js/chart.js"></script>
	<?php endif; ?>
	</body>

	</html>