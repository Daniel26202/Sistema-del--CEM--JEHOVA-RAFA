<?php require_once './src/vistas/head/head.php'; ?>



<div class="container-fluid px-4">
  <div class="p-0 m-0 pb-3 d-flex justify-content-between">
    <h1 class="mt-4 mb-0">PATOLOGÍAS <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-bandaid-fill ms-2" viewBox="0 0 16 16">
        <path d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z"></path>
      </svg></thead>
    </h1>

    <?php require_once './src/vistas/tasaBCV.php'; ?>

    <div class=" d-flex align-items-end">
      <!-- requerir los botones -->
      <?php require_once './src/vistas/btnOpciones.php'; ?>
    </div>
  </div>


  <!-- modal de cerrar sesión -->
  <?php require_once './src/vistas/modalCierreS/modalCierreS.php'; ?>

  <?php if ($parametro != ""): ?>


    <?php if ($parametro[0] == "error"): ?>
      <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder h-25" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p class="pe-2">La patología ya existe, inserte una nueva.</p>
      </div>
      <div class="d-flex justify-content-center">
      <?php elseif ($parametro[0] == "registro"): ?>
        <div class="uk-alert-primary comentarioD  comentarioRed me-4 fw-bolder" uk-alert>
          <a class="uk-alert-close" uk-close></a>
          <p class="pe-2">Se registro el paciente correctamente.</p>
        </div>
      <?php elseif ($parametro[0] == "editar"): ?>
        <div class="uk-alert-primary comentarioD  me-4 fw-bolder " uk-alert>
          <a class="uk-alert-close" uk-close></a>
          <p class="pe-2">Se actualizo el paciente correctamente.</p>
        </div>
      <?php elseif ($parametro[0] == "eliminar"): ?>
        <div class="uk-alert-primary comentarioD  me-4 fw-bolder " uk-alert>
          <a class="uk-alert-close" uk-close></a>
          <p class="pe-2">Se ha eliminado el paciente correctamente.</p>
        </div>
      <?php elseif ($parametro[0] == "restablecido"): ?>
        <div class="uk-alert-primary comentarioD  me-4 fw-bolder" uk-alert>
          <a class="uk-alert-close" uk-close></a>
          <p class="pe-2">Se ha restablecido el paciente correctamente.</p>
        </div>

        <div class="d-flex justify-content-center">
        <?php elseif ($parametro[0] == "errorfecha"): ?>
          <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p class="pe-2">la fecha de nacimiento no concuerda, intente de nuevo.</p>
          </div>

        </div>
      <?php endif ?>
    <?php endif ?>

    <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 col-11 m-auto">
      <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">

        <?php if (!$this->permisos($_SESSION["id_rol"], "guardar", "Patologias")): ?>
          <!-- no hay -->
        <?php else: ?>

          <button class="btn-guardar-responsive btnRegistrarPatologia btn btn-primary btn-agregar-doctores col-8" uk-toggle="target: #modal-exampleAgregarPatologias" id="">
            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-bandaid-fill me-1" viewBox="0 0 16 16">
              <path d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z"></path>
            </svg>Registrar patologia
          </button>

        <?php endif; ?>

      </div>


      <table class="example  col-12 ">
        <thead>
          <tr>
            <th class="text-dark text-center">#</th>
            <th class="text-dark text-center">Nombre</th>
            <th class="text-dark text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>

          <?php $numeroDePatologias = 1; ?>

          <?php foreach ($datosPatologias as $patologia): ?>
            <tr>
              <td class="text-center"><?= $numeroDePatologias ?></td>
              <td class="text-center"><?= $patologia['nombre_patologia'] ?></td>
              <td class="text-center">


                <?php if (!$this->permisos($_SESSION["id_rol"], "eliminar", "Patologias")): ?>
                  <!-- no hay -->
                <?php else: ?>
                  <button class="btn btn-tabla mb-1 btnModalEliminarPatologia"
                    uk-toggle="target: #eliminarEspecialidad<?= $patologia["0"]; ?>"
                    id="btnEliminarDoctor">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-trash3-fill" viewBox="0 0 16 16">
                      <path
                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                    </svg>
                  </button>

                <?php endif; ?>


                <div id="eliminarEspecialidad<?= $patologia["0"]; ?>" uk-modal>
                  <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                    <!-- Boton que cierra el modal -->
                    <div class="d-flex justify-content-between mb-5">




                      <div class="d-flex align-items-center ajustar" id="eliminarEspecialidad">
                        <div class="svgPapeleraPatologia">
                          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                            class="bi bi-trash-fill azul me-2 mb-1" viewBox="0 0 16 16">
                            <path
                              d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                          </svg>
                        </div>
                        <div>
                          <h5>
                            ¿Desea eliminar la Patologia?
                          </h5>
                        </div>
                      </div>
                      <!-- Ayuda Interactiva -->
                      <a href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                          class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                          <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                        </svg>
                      </a>
                    </div>


                    <div class="mt-5 uk-text-right btn_modal_patologias">
                      <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button"
                        id="cancelarEliminacion">Cancelar</button>

                      <a
                        href="/Sistema-del--CEM--JEHOVA-RAFA/Patologias/eliminarPatologia/<?= $patologia["0"]; ?>/<?php echo $_SESSION['id_usuario'] ?>">
                        <button class="btn col-4 btn-agregarcita-modal btnrestablecer"
                          id="btnEliminarEspecialidad">Eliminar</button>
                      </a>

                    </div>

                  </div>
                </div>


              </td>








              </td>
            </tr>

            <?php $numeroDePatologias++; ?>
          <?php endforeach; ?>

        </tbody>
      </table>
    </div>
      </div>

      <?php require_once 'modalesPatologia.php'; ?>


      <script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/expresionesModulares.js"></script>
      <script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/ayudaPatologia.js"></script>




      <?php require_once './src/vistas/head/footer.php'; ?>