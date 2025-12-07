<?php require_once './src/vistas/head/head.php';  ?>

<!-- Contenido  -->

<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">


  <h5 style="width: 95%; " class="m-auto mb-3">Papelera Pacientes<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
      class="bi bi-bandaid-fill ms-2" viewBox="0 0 16 16">
      <path
        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
    </svg></h5>
  <input type="hidden" name="id_usuario" id="id_usuario_session" value="<?= $_SESSION['id_usuario'] ?>">

  <!-- alertas -->

  <?php require_once "./src/vistas/alerts.php" ?>

  <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto" style="width: 95%; ">
    <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">





      <a href="/Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes" class="btn-guardar-responsive  btn btn-primary btn-agregar-doctores col-8 btnRegistrarPaciente text-decoration-none">
        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
          class="bi bi-bandaid-fill mx-2" viewBox="0 0 16 16">
          <path
            d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
        </svg>Pacientes
      </a>

    </div>

    <div class="table table-responsive">
      <table class="exampleTable table table-striped">
        <thead>
          <tr>
            <th class="text-dark">Cédula</th>
            <th class="text-dark">Nombre</th>
            <th class="text-dark">Apellido</th>
            <th class="text-dark">Teléfono</th>
            <th class="text-dark">Dirección</th>
            <th class="text-dark">Fecha de Nacimiento</th>
            <th class="text-dark">Genero</th>
            <th class="text-dark">Estado Salud</th>
            <th class="text-dark">Acciones</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>

    </div>


  </div>
</div>
</div>

<script type="module" src="<?= $urlBase; ?>../src/assets/ajax/pacientes.js"></script>
<?php require_once './src/vistas/head/footer.php'; ?>