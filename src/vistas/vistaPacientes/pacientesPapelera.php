<?php require_once './src/vistas/head/head.php';  ?>

<!-- Contenido  -->

<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">


  <h5 style="width: 95%; " class="m-auto mb-3">Papelera Pacientes<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
      class="bi bi-bandaid-fill ms-2" viewBox="0 0 16 16">
      <path
        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
    </svg></h5>

  <!-- alertas -->

  <?php require_once "./src/vistas/alerts.php" ?>

  <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto" style="width: 95%; ">
    <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">





      <a href="/Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes" class="btn-guardar-responsive  btn btn-primary btn-agregar-doctores col-8 btnRegistrarPaciente">
        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
          class="bi bi-bandaid-fill mx-2" viewBox="0 0 16 16">
          <path
            d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
        </svg>Pacientes
      </a>

    </div>

    <div class="table table-responsive">
      <table class="example table table-striped">
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


          <?php foreach ($pacientes as $paciente): ?>
            <tr>
              <td class="text-center"><?= $paciente['nacionalidad'] . "-" . $paciente['cedula'] ?></td>
              <td class="text-center"><?= $paciente['nombre'] ?></td>
              <td class="text-center"><?= $paciente['apellido'] ?></td>
              <td class="text-center"><?= $paciente['telefono'] ?></td>
              <td class="text-center"><?= $paciente['direccion'] ?></td>
              <td class="text-center"><?= $paciente['fn'] ?></td>
              <td class="text-center"><?= $paciente['genero'] ?></td>
              <td class="text-center"><?= $paciente['estado_salud'] ?></td>
              <td class="text-center">

                <?php if (!$this->permisos($_SESSION["id_rol"], "eliminar", "Pacientes")): ?>
                  <!-- no hay -->
                <?php else: ?>

                  <div class="me-2">
                    <a href="#" class="btn btn-tabla" uk-toggle="target: #eliminar<?php echo $paciente['id_paciente']; ?>" title="Restablecer Paciente" uk-tooltip id="btnModalEliminarPaciente">
                      <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-arrow-counterclockwise " viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                      </svg>
                    </a>
                  </div>

                <?php endif; ?>



                <!-- modal de restablecer -->

                <!-- Modal Eliminar -->

                <div id="eliminar<?= $paciente['id_paciente']; ?>" uk-modal>
                  <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                    <!-- Boton que cierra el modal -->
                    <a href="#">
                      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                      </svg>
                    </a>

                    <div class="d-flex align-items-center">
                      <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-arrow-counterclockwise azul me-2 mb-1 " viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                          <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                        </svg>
                      </div>
                      <div>
                        <h6>
                          ¿Desea Restablecer al Paciente <?= $paciente['nombre']; ?> <?= $paciente['apellido']; ?>?
                        </h6>
                      </div>
                    </div>

                    <div class="mt-3 uk-text-right">
                      <button class="uk-button col-4 me-3 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>

                      <a href="/Sistema-del--CEM--JEHOVA-RAFA/Pacientes/restablecer/<?php echo $paciente['id_paciente']; ?>/<?php echo $_SESSION['id_usuario'] ?>">
                        <button class="btn col-4 btn-agregarcita-modal" type="button">Restablecer</button>
                      </a>
                    </div>

                  </div>
                </div>

              </td>
            </tr>
          <?php endforeach; ?>

        </tbody>
      </table>

    </div>


  </div>
</div>
</div>


<?php require_once './src/vistas/head/footer.php'; ?>
