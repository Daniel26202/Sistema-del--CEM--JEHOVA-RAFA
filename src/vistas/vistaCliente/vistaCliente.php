<?php require_once './src/vistas/head/head.php';  ?>

<!-- Contenido  -->

<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">


  <h5 style="width: 95%; " class="m-auto mb-3">Clientes<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
      class="bi bi-bandaid-fill ms-2" viewBox="0 0 16 16">
      <path
        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
    </svg></h5>

  <!-- alertas -->

  <?php require_once "./src/vistas/alerts.php" ?>

  <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto" style="width: 95%;">
    <div class="me-2 ps-3 col-12 d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-start">
      <div class="mb-2 mb-md-0 caja-btn-margin">
        <?php if (!$this->permisos($_SESSION["id_rol"], "guardar", "Pacientes")): ?>
          <!-- no hay -->
        <?php else: ?>
          <button class="caja-btn-margin btn btn-primary btn-agregar-doctores btnRegistrarPaciente" style="width: 100% !important" uk-toggle="target: #modal-examplePaciente" id="">
            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-bandaid-fill mx-2" viewBox="0 0 16 16">
              <path
                d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
            </svg>Registrar paciente
          </button>
        <?php endif; ?>
      </div>


      <div class="d-flex flex-column flex-md-row">
        <a href="/Sistema-del--CEM--JEHOVA-RAFA/Pacientes/papeleraPaciente" class="btn me-md-2 lista-menu-pacientes text-decoration-none">Papelera</a>
        <a href="/Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes" class="text-decoration-none btn me-md-2 lista-menu-pacientes <?= $vistaActiva == 'pacientes' ? 'active' : '' ?>">Pacientes</a>
        <a href="/Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getHistorialSalud" class="text-decoration-none btn me-md-2 lista-menu-pacientes <?= $vistaActiva == 'historial' ? 'active' : '' ?>">Historial de Salud</a>
      </div>

    </div>

    <?php
    /* Aquí se cambian las tablas, depende d la vista actia  */
    if ($vistaActiva == 'historial') {
      include 'tablaHistorialSalud.php';
    } else {
      include 'tablaPacientes.php';
    }
    ?>




  </div>
</div>
</div>


<?php require_once 'modalPaciente.php'; ?>
<?php require_once 'modalAgregarPaciente.php'; ?>

<script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/ayudaPaciente.js"></script>


<?php require_once './src/vistas/head/footer.php'; ?>