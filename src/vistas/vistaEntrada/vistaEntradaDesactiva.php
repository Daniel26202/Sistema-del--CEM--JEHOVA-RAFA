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

      <a><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-wrench-adjustable-circle azul" viewBox="0 0 16 16" id="desplegablefactura">
          <path d="M12.496 8a4.491 4.491 0 0 1-1.703 3.526L9.497 8.5l2.959-1.11c.027.2.04.403.04.61Z" />
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0Zm-1 0a7 7 0 1 0-13.202 3.249l1.988-1.657a4.5 4.5 0 0 1 7.537-4.623L7.497 6.5l1 2.5 1.333 3.11c-.56.251-1.18.39-1.833.39a4.49 4.49 0 0 1-1.592-.29L4.747 14.2A7 7 0 0 0 15 8Zm-8.295.139a.25.25 0 0 0-.288-.376l-1.5.5.159.474.808-.27-.595.894a.25.25 0 0 0 .287.376l.808-.27-.595.894a.25.25 0 0 0 .287.376l1.5-.5-.159-.474-.808.27.596-.894a.25.25 0 0 0-.288-.376l-.808.27.596-.894Z" />
        </svg></a>
      <div class="uk-nav uk-dropdown-nav" uk-dropdown="pos: top-right" id="desplegable2">
        <ul>
          <li id="perfilPaciente"><a href="/Sistema-del--CEM--JEHOVA-RAFA/Perfil/perfil" class="uk-animation-toggle">
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-fill azul uk-animation-scale-up" viewBox="0 0 16 16">
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
              </svg>PERFIL
            </a></li>
          <li class="uk-nav-divider"></li>
          <li><a href="#" id="btnayudaServicioMedico"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
                <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
              </svg>AYUDA</a></li>
          <li class="uk-nav-divider"></li>
          <li><a href="/Sistema-del--CEM--JEHOVA-RAFA/Bitacora/bitacora"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
                <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z" />
              </svg> CONFIGURACIÓN</a></li>
          <li class="uk-nav-divider"></li>



          <li><a href="#" data-bs-toggle="modal" data-bs-target="#eliminar">
              <img src="./src/assets/img/icono-cerrar-sesion.svg" width="34" height="34" uk-svg class="azul" style="margin-left: -4px;">
              </svg>SALIR</a></li>
        </ul>
      </div>
    </div>
  </div>

  <!-- modal de cerrar sesión -->
  <?php require_once './src/vistas/modalCierreS/modalCierreS.php'; ?>

</div>

<!-- paginación servicio medico -->
<div class="d-flex">

  <div class="w-75 ms-5">
    <h3 class="fw-bold" id="inicioServicio">ENTRADAS

      <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-inboxes mb-2" viewBox="0 0 16 16">
        <path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562A.5.5 0 0 0 1.884 9h12.234a.5.5 0 0 0 .496-.438L14.933 6zM3.809.563A1.5 1.5 0 0 1 4.981 0h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393zm.941.83.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438l.32-2.562H10.45a2.5 2.5 0 0 1-4.9 0H1.066z" />
      </svg>
    </h3>

  </div>

  <div class=" me-3 mb-4  d-flex justify-content-end w-100">


    <ul class="sin-circulos d-flex justify-content-end">

      <li class="li">
        <div class="borde-de-menu  mb-1"></div>
        <div class="hover-grande">
          <a href="/Sistema-del--CEM--JEHOVA-RAFA/Insumos/insumos" class="text-decoration-none text-black me-3" id="DMservicioMedico">
            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-capsule me-1" viewBox="0 0 16 16">
              <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
            </svg>Insumos</a>
        </div>
      </li>
      <li class="li">
        <div class="borde-de-menu mb-1  activo-border"></div>
        <div class="hover-grande">
          <a href="/Sistema-del--CEM--JEHOVA-RAFA/Entrada/entrada" class="text-decoration-none text-black me-3 iconoDoctor" id="DMdoctores">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-inboxes-fill me-1 mb-1 azul" viewBox="0 0 16 16">
              <path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zM3.81.563A1.5 1.5 0 0 1 4.98 0h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393z" />
            </svg>Entradas de Insumo</a>
        </div>

      </li>
      <li class="li">
        <div class="borde-de-menu mb-1 color-linea "></div>
        <div class="hover-grande">

          <a href="/Sistema-del--CEM--JEHOVA-RAFA/Proveedores/proveedores" class="text-decoration-none text-black me-3" id="DMserviciosExtras">
            <img src="./src/assets/img/proveedor (3).png" width="20" height="20" uk-svg class="me-1">Proveedores</a>
        </div>

      </li>

      <li class="li">
        <div class="borde-de-menu mb-1 "></div>
        <div class="hover-grande">
          <a href="/Sistema-del--CEM--JEHOVA-RAFA/Insumos/InsumosVencidos" class="text-decoration-none text-black me-3 iconoDoctor" id="DMdoctores">
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
          <a href="/Sistema-del--CEM--JEHOVA-RAFA/Entrada/papelera" class="text-decoration-none text-black me-3 iconoDoctor" id="DMdoctores">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="azul  bi bi-recycle me-1 mb-1" viewBox="0 0 16 16">
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
            <th class="text-center text-dark">Nombre</th>
            <th class="text-center text-dark">Proveedor</th>
            <th class="text-center text-dark">Fecha De Ingreso</th>
            <th class="text-center text-dark">Fecha De Vencimiento</th>
            <th class="text-center text-dark">Cantidad</th>
            <th class="text-center text-dark">Precio</th>
            <th class="text-center text-dark">Numero De Lote</th>
            <th class="text-center text-dark">Acciones</th>
          </tr>
        </thead>
        <tbody>


          <?php foreach ($desactivos as $e) : ?>
            <tr>
              <td class="text-center"><?= $e["nombre"]; ?></td>
              <td class="text-center"><?= $e["proveedor"]; ?></td>
              <td class="text-center"><?= $e["fechaDeIngreso"]; ?></td>
              <td class="text-center"><?= $e["fechaDeVencimiento"]; ?></td>
              <td class="text-center"><?= $e["cantidad"]; ?></td>
              <td class="text-center"><?= $e["precio"]; ?></td>
              <td class="text-center"><?= $e["numero_de_lote"]; ?></td>

              <td class="d-flex justify-content-center">


                <button class="btn btn-tabla mb-1" uk-toggle="target: #eliminarEntrada<?= $e["id_entrada"]; ?>"
                  id="btnEliminarEspecialidad">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                    <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                  </svg></button>
              </td>



              <!-- Eliminar Entrada -->
              <div id="eliminarEntrada<?= $e["id_entrada"]; ?>" uk-modal>
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
                          ¿Desea restablecer la Entrada del Insumo?
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

                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Entrada/restablecerEntrada/<?= $e["id_entrada"]; ?>/<?= $_SESSION['id_usuario']; ?>">
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


























<!-- agregar Entrada -->






<?php require_once './src/vistas/head/footer.php'; ?>

<script type="text/javascript" src="<?= $urlBase ?>../src/assets/entradas.js"></script>