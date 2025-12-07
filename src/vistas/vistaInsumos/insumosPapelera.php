<?php require_once './src/vistas/head/head.php';  ?>

<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">


  <h5 style="width: 95%; " class="m-auto mb-3">Insumos Papelera <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-recycle me-1 mb-1 " viewBox="0 0 16 16">
      <path d="M9.302 1.256a1.5 1.5 0 0 0-2.604 0l-1.704 2.98a.5.5 0 0 0 .869.497l1.703-2.981a.5.5 0 0 1 .868 0l2.54 4.444-1.256-.337a.5.5 0 1 0-.26.966l2.415.647a.5.5 0 0 0 .613-.353l.647-2.415a.5.5 0 1 0-.966-.259l-.333 1.242-2.532-4.431zM2.973 7.773l-1.255.337a.5.5 0 1 1-.26-.966l2.416-.647a.5.5 0 0 1 .612.353l.647 2.415a.5.5 0 0 1-.966.259l-.333-1.242-2.545 4.454a.5.5 0 0 0 .434.748H5a.5.5 0 0 1 0 1H1.723A1.5 1.5 0 0 1 .421 12.24l2.552-4.467zm10.89 1.463a.5.5 0 1 0-.868.496l1.716 3.004a.5.5 0 0 1-.434.748h-5.57l.647-.646a.5.5 0 1 0-.708-.707l-1.5 1.5a.498.498 0 0 0 0 .707l1.5 1.5a.5.5 0 1 0 .708-.707l-.647-.647h5.57a1.5 1.5 0 0 0 1.302-2.244l-1.716-3.004z" />
    </svg></h5>

  <input type="hidden" name="urlBase" id="urlBase" value="<?= $urlBase ?>">
  <input type="hidden" id="id_usuario_session" value="<?= $_SESSION['id_usuario'] ?>">


  <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto table-responsive" style="width: 95%; ">
    <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">
      <?php require_once "./src/vistas/vistaInsumos/paginationInsumos.php" ?>
    </div>

    <div class="table table-responsive">
      <table class="exampleTable table table-striped ">
        <thead>
          <tr>
            <th class="text-dark">Nombre</th>
            <th class="text-dark">Descripción</th>
            <th class="text-dark">Precio</th>
            <th class="text-dark">Cantidad</th>
            <th class="text-dark">Stock Mínimo</th>
            <th class="text-dark">Acciones</th>
          </tr>
        </thead>
        <tbody id="div-papelera">


        </tbody>
      </table>
    </div>
  </div>

  <script type="module" src="<?= $urlBase ?>../src/assets/insumo.js"></script>

  <?php require_once './src/vistas/head/footer.php';  ?>

</div>