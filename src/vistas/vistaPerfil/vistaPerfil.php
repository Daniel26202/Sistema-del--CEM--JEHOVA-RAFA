<?php require_once './src/vistas/head/head.php'; ?>


<!-- <?php $datos = $this->modelo->seleccionarUsuario($_SESSION["usuario"]); ?> -->
<div class="mt-5">
  <div class="contenedor-perfil ">
    <h3 class="fw-bolder text-center pt-3">Perfil</h3>
    <div class="d-flex mt-4">
      <div class="col-6 m-auto">
        <form class="form-modal perfil " id="perfil">
          <div class="input-group flex-nowrap">
            <?php foreach ($datos as $d): ?>


              <span class="input-modal">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                  class="bi bi-person-vcard-fill azul" viewBox="0 0 16 16">
                  <path
                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                </svg>
              </span>
              <input class="form-control input-modal input-perfil" type="text" name="cedula" placeholder="Cedula"
                value="<?= $d["cedula"] ?>" disabled>
            </div>

            <div class="input-group flex-nowrap">
              <span class="input-modal mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                  class="bi bi-person-fill azul" viewBox="0 0 16 16">
                  <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                </svg>
              </span>
              <input class="form-control input-modal input-perfil" type="text" name="nombreyapellido"
                placeholder="Nombre y Apellido" disabled value="<?= $d["usuario"] ?>">

            </div>
            <div class="input-group flex-nowrap">
              <span class="input-modal mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                  class="bi bi-telephone-fill azul" viewBox="0 0 16 16">
                  <path fill-rule="evenodd"
                    d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                </svg>
              </span>
              <input class="form-control input-modal input-perfil" type="text" name="telefono" placeholder="Teléfono"
                disabled value="<?= $d["telefono"] ?>">
            </div>

            <div class="input-group flex-nowrap">
              <span class="input-modal mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                  class="bi bi-person-fill azul" viewBox="0 0 16 16">
                  <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                </svg>
              </span>
              <input class="form-control input-modal input-perfil" type="text" name="usuario" placeholder="Usuario"
                disabled value="<?= $d["usuario"] ?>">
            </div>

            <div class="input-group flex-nowrap">
              <span class="input-modal mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                  class="bi bi-eye-slash-fill azul" viewBox="0 0 16 16">
                  <path
                    d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z" />
                  <path
                    d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z" />
                </svg>
              </span>
              <input class="form-control input-modal input-perfil inputDos" type="password" name="contraseña"
                placeholder="Contraseña" disabled value="<?= $d["password"] ?>">
                <a href="#" class="text-decoration-none btnMostrarContrase">
                                <svg id="ocultarPassword" xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                    fill="currentColor" class="bi bi-eye-slash-fill azul ocultarPassword d-none"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z" />
                                    <path
                                        d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z" />
                                </svg>
                                <svg id="mostrarPassword" xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                    fill="currentColor" class="bi bi-eye-fill azul mostrarPassword" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                    <path
                                        d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                </svg>
                            </a>

            </div>
          </form>

        </div>

        <div class="m-auto">
          <svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" fill="currentColor"
            class="bi bi-person-fill azul" viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
          </svg>
        </div>
      <?php endforeach ?>

    </div>

  </div>
</div>







<script type="text/javascript" src="./src/assets/js/imgUsuarios.js"></script>

<?php require_once './src/vistas/head/footer.php'; ?>