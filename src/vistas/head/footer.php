</div>

















<script type="text/javascript" src="<?= $urlBase ?>../src/assets/library/bootstrap/js/bootstrap.bundle.min.js"></script>
<script type="module" src="<?= $urlBase ?>../src/assets/app.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/library/intro/intro.min.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/library/DataTable/jquery-3.7.1.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/library/DataTable/datatables.js"></script>
<!-- Extensión Responsive: debe ir DESPUÉS de datatables.js -->
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/library/DataTable/dataTables.responsive.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/library/DataTable/modificacion.js"></script>
<script type="module" src="<?= $urlBase ?>../src/assets/js/generic/expresionesModulares.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/library/sweetalert2/sweetalert2@11.js"></script>
<script src="<?= $urlBase ?>../src/assets/js/webSocket.js"></script>
<script type="module" src="<?= $urlBase ?>../src/assets/js/chatModal.js"></script>


<script>
	function openNav() {
		document.getElementById("mySidenav").classList.add("open-sidenav");
		document.body.classList.add("sidenav-open");
	}

	function closeNav() {
		document.getElementById("mySidenav").classList.remove("open-sidenav");
		document.body.classList.remove("sidenav-open");
	}
</script>
</body>



</html>