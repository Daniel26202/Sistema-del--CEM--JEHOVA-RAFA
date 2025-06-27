<?php require_once './src/vistas/head/head.php';  ?>

<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh">


  <h5 style="width: 95%; " class="m-auto mb-3">Bitácora <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
      class="bi bi-people ms-2" viewBox="0 0 16 16">
      <path
        d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z" />
    </svg></h5>

  <!-- alertas -->

  <?php require_once "./src/vistas/alerts.php" ?>

  <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto" style="width: 95%; ">
    <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">
    </div>


    <div class="me-4">
      <div class="mt-3 mb-5">
        <ul class="sin-circulos d-flex justify-content-end ">
          <li class="borde-menu activo <?= $vistaActiva == 'Usuario' ? ' activo-borde ' : '' ?>">
            <a href="/Sistema-del--CEM--JEHOVA-RAFA/Bitacora/bitacoraUsuario"
              class="text-decoration-none me-3 color-letras">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-person-square ms-2" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path>
                <path
                  d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z">
                </path>
              </svg>Usuario</a>
          </li>

          <?php if (!$cargo): ?>
            <li class="borde-menu activo <?= $vistaActiva == 'Admin' ? ' activo-borde ' : '' ?>">
              <a href="/Sistema-del--CEM--JEHOVA-RAFA/Bitacora/bitacora" class="text-decoration-none me-3 color-letras">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                  class="bi bi-person-square ms-2" viewBox="0 0 16 16">
                  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path>
                  <path
                    d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z">
                  </path>
                </svg>Administrador</a>
            </li>
          <?php endif; ?>

        </ul>
      </div>
    </div>
    <?php $bitacora = ($vistaActiva == 'Admin') ? $this->modelo->consultarBitacora($_SESSION['id_usuario']) : $this->modelo->consultarBitacora() ?>


    <div class="table table-responsive">
      <table class="example table table-striped ">
        <thead>
          <tr>
            <th class="text-dark">Nombre Apellido</th>
            <th class="text-dark">Usuario</th>
            <th class="text-dark">Modulo</th>
            <th class="text-dark">Actividad</th>
            <th class="text-dark">Fecha</th>
            <th class="text-dark">Hora</th>
          </tr>
        </thead>
        <tbody>


          <?php foreach ($bitacora as $b): ?>
            <tr>
              <td class="text-center">
                <?= $b['nombre'] . ' ' . $b['apellido'] ?>
              </td>
              <td class="text-center">
                <?= $b['usuario'] ?>
              </td>
              <td class="text-center">
                <?= $b['tabla'] ?>
              </td>
              <td class="text-center">
                <?= $b['actividad'] ?>
              </td>
              <?php $fecha_hora_separadas = explode(" ", $b['fecha_hora']); ?>
              <td class="text-center">
                <?= $fecha_hora_separadas[0]; ?>
              </td>
              <td class="text-center">
                <?= $fecha_hora_separadas[1]; ?>
              </td>
            </tr>
          <?php endforeach; ?>

        </tbody>
      </table>
    </div>
  </div>


</div>



<?php require_once './src/vistas/head/footer.php'; ?>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/ayudaBitacora.js"></script>