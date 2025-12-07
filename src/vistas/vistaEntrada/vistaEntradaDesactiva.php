<?php require_once './src/vistas/head/head.php';  ?>

<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">
  <h5 style="width: 95%; " class="m-auto mb-3">Entradas Papelera<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-capsule ms-2" viewBox="0 0 16 16">
      <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
    </svg></h5>

  <!-- alertas -->
  <input type="hidden" name="id_usuario" id="id_usuario_session" value="<?= $_SESSION['id_usuario'] ?>">

  <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto table-responsive" style="width: 95%; ">

    <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">

      <?php require_once "./src/vistas/vistaInsumos/paginationInsumos.php" ?>

    </div>


    <div class="table table-responsive">
      <table class="exampleTable table table-striped">
        <thead>
          <tr>
            <th class="text-dark">Nombre</th>
            <th class="text-dark">Proveedor</th>
            <th class="text-dark">Fecha De Ingreso</th>
            <th class="text-dark">Fecha De Vencimiento</th>
            <th class="text-dark">Cantidad</th>
            <th class="text-dark">Precio</th>
            <th class="text-dark">Numero De Lote</th>
            <th class="text-dark">Acciones</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
    </div>

  </div>



</div>






<!-- agregar Entrada -->
<script type="module" src="<?= $urlBase; ?>../src/assets/ajax/entradas.js"></script>


<?php require_once './src/vistas/head/footer.php';  ?>