<?php require_once './src/vistas/head/head.php'; ?>
<div class="container-fluid px-4">
  <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
    <div class="ms-5 d-flex align-items-center" id="inicioDirectorio">
      <h1 class="fw-bold">INSUMOS</h1>
      <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" fill="currentColor" class="bi bi-capsule ms-2" viewBox="0 0 16 16">
        <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
      </svg>
    </div>

    <div class="me-4">

      <!-- requerir los botones -->
      <?php require_once './src/vistas/btnOpciones.php'; ?>
    </div>
  </div>

  <!-- modal de cerrar sesión -->
  <?php require_once './src/vistas/modalCierreS/modalCierreS.php'; ?>

</div>

<!-- paginación servicio medico -->
<div class="d-flex">

  <div class="w-75 ms-5">
    <h3 class="fw-bold" id="inicioServicio">PAPELERA INSUMOS

      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-recycle me-1 mb-1 " viewBox="0 0 16 16">
        <path d="M9.302 1.256a1.5 1.5 0 0 0-2.604 0l-1.704 2.98a.5.5 0 0 0 .869.497l1.703-2.981a.5.5 0 0 1 .868 0l2.54 4.444-1.256-.337a.5.5 0 1 0-.26.966l2.415.647a.5.5 0 0 0 .613-.353l.647-2.415a.5.5 0 1 0-.966-.259l-.333 1.242-2.532-4.431zM2.973 7.773l-1.255.337a.5.5 0 1 1-.26-.966l2.416-.647a.5.5 0 0 1 .612.353l.647 2.415a.5.5 0 0 1-.966.259l-.333-1.242-2.545 4.454a.5.5 0 0 0 .434.748H5a.5.5 0 0 1 0 1H1.723A1.5 1.5 0 0 1 .421 12.24l2.552-4.467zm10.89 1.463a.5.5 0 1 0-.868.496l1.716 3.004a.5.5 0 0 1-.434.748h-5.57l.647-.646a.5.5 0 1 0-.708-.707l-1.5 1.5a.498.498 0 0 0 0 .707l1.5 1.5a.5.5 0 1 0 .708-.707l-.647-.647h5.57a1.5 1.5 0 0 0 1.302-2.244l-1.716-3.004z" />
      </svg>
    </h3>

  </div>

  <div class=" me-3 mb-4  d-flex justify-content-end w-100">


    <ul class="sin-circulos d-flex justify-content-end">

      <li class="li ">
        <div class="borde-de-menu  mb-1"></div>
        <div class="hover-grande">
          <a href="/Sistema-del--CEM--JEHOVA-RAFA/Insumos/insumos" class="text-decoration-none me-3 color-letras" id="DMservicioMedico">
            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-capsule azul me-1" viewBox="0 0 16 16">
              <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
            </svg>Insumos</a>
        </div>
      </li>
      <li class="li">
        <div class="borde-de-menu mb-1  activo-border"></div>
        <div class="hover-grande">
          <a href="/Sistema-del--CEM--JEHOVA-RAFA/Entrada/entrada" class="text-decoration-none me-3 color-letras iconoDoctor" id="DMdoctores">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-inboxes-fill me-1 mb-1 " viewBox="0 0 16 16">
              <path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zM3.81.563A1.5 1.5 0 0 1 4.98 0h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393z" />
            </svg>Entradas de Insumo</a>
        </div>

      </li>
      <li class="li">
        <div class="borde-de-menu mb-1 color-linea "></div>
        <div class="hover-grande">

          <a href="/Sistema-del--CEM--JEHOVA-RAFA/Proveedores/proveedores" class="text-decoration-none me-3 color-letras" id="DMserviciosExtras">
            <img src="./src/assets/img/proveedor (3).png" width="20" height="20" uk-svg class="me-1">Proveedores</a>
        </div>

      </li>

      <li class="li">
        <div class="borde-de-menu mb-1 "></div>
        <div class="hover-grande">
          <a href="/Sistema-del--CEM--JEHOVA-RAFA/Insumos/InsumosVencidos" class="text-decoration-none me-3 color-letras iconoDoctor" id="DMdoctores">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-inboxes-fill me-1 mb-1" viewBox="0 0 16 16">
              <path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zM3.81.563A1.5 1.5 0 0 1 4.98 0h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393z" />
            </svg>Entrada de Insumos Vencidas</a>
        </div>

      </li>


    </ul>

  </div>
</div>


<div style="width: 95%;">
  <div class=" me-3 mb-4  d-flex justify-content-end w-100">


    <ul class="sin-circulos d-flex justify-content-end">



      <li class="li">
        <div class="borde-de-menu mb-1 color-linea "></div>
        <div class="hover-grande">
          <a href="/Sistema-del--CEM--JEHOVA-RAFA/Entrada/papelera" class="text-decoration-none me-3 color-letras iconoDoctor " id="DMdoctores">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-recycle azul me-1 mb-1" viewBox="0 0 16 16">
              <path d="M9.302 1.256a1.5 1.5 0 0 0-2.604 0l-1.704 2.98a.5.5 0 0 0 .869.497l1.703-2.981a.5.5 0 0 1 .868 0l2.54 4.444-1.256-.337a.5.5 0 1 0-.26.966l2.415.647a.5.5 0 0 0 .613-.353l.647-2.415a.5.5 0 1 0-.966-.259l-.333 1.242-2.532-4.431zM2.973 7.773l-1.255.337a.5.5 0 1 1-.26-.966l2.416-.647a.5.5 0 0 1 .612.353l.647 2.415a.5.5 0 0 1-.966.259l-.333-1.242-2.545 4.454a.5.5 0 0 0 .434.748H5a.5.5 0 0 1 0 1H1.723A1.5 1.5 0 0 1 .421 12.24l2.552-4.467zm10.89 1.463a.5.5 0 1 0-.868.496l1.716 3.004a.5.5 0 0 1-.434.748h-5.57l.647-.646a.5.5 0 1 0-.708-.707l-1.5 1.5a.498.498 0 0 0 0 .707l1.5 1.5a.5.5 0 1 0 .708-.707l-.647-.647h5.57a1.5 1.5 0 0 0 1.302-2.244l-1.716-3.004z" />
            </svg>Papelera De Entrada</a>
        </div>

      </li>




    </ul>

  </div>
</div>

<div>

  <!-- alerta -->
  <div class="alert alert-danger d-none text-center" id="alerta-fecha"></div>

  <div class="d-flex justify-content-end">



    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 col-11 m-auto">




      <table class="example  col-12 ">
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
</div>

</div>

















<?php require_once './src/vistas/head/footer.php'; ?>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/entradas.js"></script>