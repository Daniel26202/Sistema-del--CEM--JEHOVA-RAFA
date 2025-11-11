<?php require_once './src/vistas/head/head.php'; ?>


<!-- Contenido  -->

<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">
  <h5 style="width: 95%; " class="m-auto mb-3">Patologias<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bandaid-fill ms-2" viewBox="0 0 16 16">
      <path d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z"></path>
    </svg></h5>

  <input type="hidden" name="id_usuario" id="id_usuario_session" value="<?= $_SESSION['id_usuario'] ?>">



  <?php require_once "./src/vistas/alerts.php" ?>
  <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto" style="width: 95%; ">

    <div class="me-2 ps-3 col-10 caja-boton d-flex justify-content-between align-items-center row ">


      <a href="/Sistema-del--CEM--JEHOVA-RAFA/Patologias/patologias" class="btn-guardar-responsive btnRegistrarPatologia btn btn-primary btn-agregar-doctores col-8 text-decoration-none">
        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-bandaid-fill me-1" viewBox="0 0 16 16">
          <path d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z"></path>
        </svg>Patologias
      </a>



    </div>

    <div class="table table-responsive">
      <table class="exampleTable table table-striped">
        <thead>
          <tr>
            <th class="text-dark text-center">#</th>
            <th class="text-dark text-center">Nombre</th>
            <th class="text-dark text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>

          <!-- js -->

        </tbody>
      </table>
    </div>
  </div>
</div>

<script type="module" src="<?= $urlBase; ?>../src/assets/ajax/patologia.js"></script>

<?php require_once './src/vistas/head/footer.php'; ?>