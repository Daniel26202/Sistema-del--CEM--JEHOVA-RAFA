<?php require_once './src/vistas/head/head.php'; ?>


<!-- Contenido  -->

<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">
  <h5 style="width: 95%; " class="m-auto mb-3">Patologias<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bandaid-fill ms-2" viewBox="0 0 16 16">
      <path d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z"></path>
    </svg></h5>



  <?php require_once "./src/vistas/alerts.php" ?>
  <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto" style="width: 95%; ">

    <div class="me-2 ps-3 col-10 caja-boton d-flex justify-content-between align-items-center row ">


      <a href="/Sistema-del--CEM--JEHOVA-RAFA/Patologias/patologias" class="btn-guardar-responsive btnRegistrarPatologia btn btn-primary btn-agregar-doctores col-8">
        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-bandaid-fill me-1" viewBox="0 0 16 16">
          <path d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z"></path>
        </svg>Patologias
      </a>



    </div>

    <div class="table table-responsive">
      <table class="example table table-striped">
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

                <button class="btn btn-tabla mb-1" uk-toggle="target: #eliminarEspecialidad<?= $patologia["0"]; ?>"
                  id="btnEliminarEspecialidad">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                    <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                  </svg>
                </button>


                <div id="eliminarEspecialidad<?= $patologia["0"]; ?>" uk-modal>
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
                            ¿Desea restablecer la Patologia?
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

                      <a href="/Sistema-del--CEM--JEHOVA-RAFA/Patologias/restablecerPatologia/<?= $patologia["0"]; ?>/<?php echo $_SESSION['id_usuario'] ?>">
                        <button class="btn col-4 btn-agregarcita-modal btnrestablecer" id="btnEliminarEspecialidad">Restablecer</button>
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
</div>

<?php require_once './src/vistas/head/footer.php'; ?>