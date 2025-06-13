<?php require_once './src/vistas/head/head.php';  ?>

<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">


  <h5 style="width: 95%; " class="m-auto mb-3">Insumos Papelera <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-recycle me-1 mb-1 " viewBox="0 0 16 16">
      <path d="M9.302 1.256a1.5 1.5 0 0 0-2.604 0l-1.704 2.98a.5.5 0 0 0 .869.497l1.703-2.981a.5.5 0 0 1 .868 0l2.54 4.444-1.256-.337a.5.5 0 1 0-.26.966l2.415.647a.5.5 0 0 0 .613-.353l.647-2.415a.5.5 0 1 0-.966-.259l-.333 1.242-2.532-4.431zM2.973 7.773l-1.255.337a.5.5 0 1 1-.26-.966l2.416-.647a.5.5 0 0 1 .612.353l.647 2.415a.5.5 0 0 1-.966.259l-.333-1.242-2.545 4.454a.5.5 0 0 0 .434.748H5a.5.5 0 0 1 0 1H1.723A1.5 1.5 0 0 1 .421 12.24l2.552-4.467zm10.89 1.463a.5.5 0 1 0-.868.496l1.716 3.004a.5.5 0 0 1-.434.748h-5.57l.647-.646a.5.5 0 1 0-.708-.707l-1.5 1.5a.498.498 0 0 0 0 .707l1.5 1.5a.5.5 0 1 0 .708-.707l-.647-.647h5.57a1.5 1.5 0 0 0 1.302-2.244l-1.716-3.004z" />
    </svg></h5>

  <!-- alertas -->

  <?php require_once "./src/vistas/alerts.php" ?>

  <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto table-responsive" style="width: 95%; ">
    <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">
      <?php require_once "./src/vistas/vistaInsumos/paginationInsumos.php" ?>
    </div>

    <div class="table table-responsive">
      <table class="example table table-striped ">
        <thead>
          <tr>
            <th class="text-dark">Nombre</th>
            <th class="text-dark">Descripcion</th>
            <th class="text-dark">Precio</th>
            <th class="text-dark">Cantidad</th>
            <th class="text-dark">Stock Minimo</th>
            <th class="text-dark">Acciones</th>
          </tr>
        </thead>
        <tbody>


          <?php foreach ($desactivos as $e) : ?>
            <tr>
              <td class="text-center"><?= $e["nombre"]; ?></td>
              <td class="text-center"><?= $e["descripcion"]; ?></td>
              <td class="text-center"><?= $e["precio"]; ?> BSs</td>
              <td class="text-center"><?= $e["cantidad_inventario"]; ?></td>
              <td class="text-center"><?= $e["stockMinimo"]; ?></td>

              <td class="d-flex justify-content-center">


                <button class="btn btn-tabla mb-1" uk-toggle="target: #eliminarEntrada<?= $e["id_insumo"]; ?>"
                  id="btnEliminarEspecialidad">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                    <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                  </svg></button>
              </td>



              <!-- Eliminar Entrada -->
              <div id="eliminarEntrada<?= $e["id_insumo"]; ?>" uk-modal>
                <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                  <!-- Boton que cierra el modal -->
                  <div class="d-flex justify-content-between mb-5">




                    <div class="d-flex align-items-center ajustar" id="eliminarEspecialidad">
                      <div class="svgPapeleraPatologia">

                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-arrow-counterclockwise azul me-2 mb-1 " viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                          <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                        </svg>
                      </div>
                      <div>
                        <h5>
                          ¿Desea restablecer el Insumo <?= $e["nombre"] ?>?
                        </h5>
                      </div>
                    </div>
                    <!-- Ayuda Interactiva -->
                    <a href="#">
                      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                      </svg>
                    </a>
                  </div>


                  <div class="mt-5 uk-text-right btn_modal_patologias">
                    <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button"
                      id="cancelarEliminacion">Cancelar</button>

                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Insumos/restablecerInsumo/<?= $e["id_insumo"]; ?>/<?= $_SESSION['id_usuario'] ?>">
                      <button class="btn col-4 btn-agregarcita-modal btnrestablecer" id="btnEliminarEspecialidad">Restablecer</button>
                    </a>

                  </div>

                </div>
              </div>






            </tr>

          <?php endforeach; ?>

        </tbody>
      </table>
    </div>
  </div>


  <?php require_once './src/vistas/head/footer.php';  ?>

</div>