<?php require_once './src/vistas/head/head.php';  ?>

<!-- Contenido  -->

<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">


  <h5 style="width: 95%; " class="m-auto mb-3"><?= $vistaActiva == 'papelera' ? 'Papelera Clientes' : 'Clientes' ?><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
      class="bi bi-bandaid-fill ms-2" viewBox="0 0 16 16">
      <path
        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
    </svg></h5>

  <!-- alertas -->

  <?php require_once "./src/vistas/alerts.php" ?>

  <div class="caja-contenedor-tabla fondo-tabla p-3 mb-3 m-auto" style="width: 95%;">
    <div class="me-2 ps-3 col-12 d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-start">
      <div class="mb-2 mb-md-0 caja-btn-margin">
        <?php if (!$this->permisos($_SESSION["id_rol"], "guardar", "Clientes")): ?>
          <!-- no hay -->
        <?php else: ?>
          <button class="<?= $vistaActiva != 'papelera' ? '' : 'd-none' ?> caja-btn-margin btn btn-primary btn-agregar-doctores btnRegistrarPaciente" style="width: 100% !important" uk-toggle="target: #modal-examplePaciente" id="">
            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-bandaid-fill mx-2" viewBox="0 0 16 16">
              <path
                d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
            </svg>Registrar cliente
          </button>
        <?php endif; ?>
      </div>



      <div class="d-flex flex-column flex-md-row">
        <a href="/Sistema-del--CEM--JEHOVA-RAFA/Clientes/<?= $vistaActiva == 'papelera' ? 'Clientes' : 'papelera' ?>" class="btn me-md-2 lista-menu-pacientes text-decoration-none"><?= $vistaActiva == 'clientes' ? 'Papelera' : 'Clientes' ?></a>
      </div>



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
            <th class="text-dark">Acciones</th>
          </tr>
        </thead>
        <tbody>


          <?php foreach ($clientes as $cliente): ?>
            <tr>
              <td class="text-center"><?= $cliente['nacionalidad'] . "-" . $cliente['cedula'] ?></td>
              <td class="text-center"><?= $cliente['nombre'] ?></td>
              <td class="text-center"><?= $cliente['apellido'] ?></td>
              <td class="text-center"><?= $cliente['telefono'] ?></td>
              <td class="text-center"><?= $cliente['direccion'] ?></td>
              <td class="text-center"><?= $cliente['fn'] ?></td>
              <td class="text-center"><?= $cliente['genero'] ?></td>
              <td class="text-center">
                <?php if (!$this->permisos($_SESSION["id_rol"], "editar", "Clientes")): ?>
                  <!-- no hay -->
                <?php else: ?>
                  <button class="<?= $vistaActiva == 'papelera' ? 'd-none' : '' ?> btn btn-tabla mb-1 btn-js editar botonesEdi btnModalEditarcliente btn-dt-tabla"
                    uk-toggle="target: #modal-exampleclienteEditar<?= $cliente['id_cliente'] ?>"
                    data-id-tabla="modal-exampleclienteEditar<?= $cliente['id_cliente'] ?>" data-index="<?= $cliente['id_cliente'] ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-pencil-fill" viewBox="0 0 16 16">
                      <path
                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                    </svg>

                  </button>

                <?php endif; ?>

                <?php if (!$this->permisos($_SESSION["id_rol"], "eliminar", "Clientes")): ?>
                  <!-- no hay -->
                <?php else: ?>

                  <button class="btn btn-tabla mb-1 btnModalEliminarcliente btn-dt-tabla"
                    uk-toggle="target: #modal-eliminar-clientes<?php echo $cliente["id_cliente"]; ?>" data-id-tabla="modal-eliminar-clientes<?php echo $cliente["id_cliente"]; ?>"
                    id="btnEliminarDoctor">


                    <?= $vistaActiva == 'papelera'
                      ? '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>
                    <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                  </svg>'

                      : '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-trash3-fill" viewBox="0 0 16 16">
                      <path
                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                    </svg>' ?>
                  </button>

                <?php endif; ?>




                <div id="modal-eliminar-clientes<?php echo $cliente["id_cliente"]; ?>" uk-modal>
                  <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                    <form class="">

                      <!-- Boton que cierra el modal -->
                      <a href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                          class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                          <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                        </svg>
                      </a>

                      <div class="d-flex align-items-center">
                        <div>
                          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-trash-fill azul me-2" viewBox="0 0 16 16">
                            <path
                              d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                          </svg>
                        </div>
                        <div>
                          <h5>
                            ¿Desea <?= $vistaActiva == 'papelera' ? 'Restablecer' : 'Eliminar' ?> el cliente <?= $cliente['nombre'] . ' ' . $cliente['apellido'] ?>?
                          </h5>
                        </div>
                      </div>



                      <div class="mt-3 uk-text-right">

                        <button class="uk-button fw-bold uk-button-default uk-modal-close btn-cerrar-modal" type="button"
                          data-bs-dismiss="modal">Cancelar</button>
                        <a class="uk-button uk-button-primary btn-agregarcita-modal ms-2 fw-bold" href='/Sistema-del--CEM--JEHOVA-RAFA/Clientes/<?= $vistaActiva == 'papelera' ? 'restablecer' : 'eliminar' ?>/<?= $cliente['cedula'] ?>/<?= $_SESSION['id_usuario'] ?>'> <?= $vistaActiva == 'papelera' ? 'Restablecer' : 'Eliminar' ?></a>

                      </div>
                    </form>
                  </div>
                </div>







                <!-- modal editar -->

                <div id="modal-exampleclienteEditar<?= $cliente['id_cliente'] ?>" uk-modal>
                  <div class="uk-modal-dialog uk-modal-body tamaño-modal">
                    <!-- Boton que cierra el modal -->
                    <a href="#">
                      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                      </svg>
                    </a>

                    <div class="d-flex align-items-center mb-3">
                      <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-fill-add azul me-3 mb-3" viewBox="0 0 16 16">
                          <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                          <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z" />
                        </svg>
                      </div>
                      <div class="">
                        <p class="uk-modal-title fs-5 ">
                          Modificar cliente
                        </p>
                      </div>

                    </div>
                    <div class="alert alert-danger d-none alertaFormulario" role="alert">
                      <div class="">
                        <p style="font-size: 13px;" class="text-center">Por favor, corrige los errores en el formulario.</p>
                      </div>
                    </div>

                    <form class="form-modal form-validable<?= $cliente['id_cliente'] ?>" action="/Sistema-del--CEM--JEHOVA-RAFA/Clientes/setCliente/<?= $cliente['cedula'] ?>" method="POST" autocomplete="off">
                      <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario']; ?>">
                      <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente']; ?>">

                      <div class="input-group flex-nowrap margin-inputs" id="grp_cedula">
                        <span class="input-modal mt-1">
                          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-vcard-fill azul" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                          </svg>
                        </span>
                        <span class="">
                          <select class="form-control input-modal" aria-label="2" placeholder="Nacionalidad" name="nacionalidad">
                            <option value="V" selected>V</option>
                            <option value="E">E</option>
                          </select>
                        </span>

                        <input class="form-control input-modal input-disabled input-cliente input-validar" style="width: 7vh !important;" type="number" id="cedula" name="cedula" value="<?= $cliente['cedula'] ?>" placeholder="Cedula" required maxlength="8" minlength="6" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                      </div>

                      <p class="p-error-cedula<?= $cliente['id_cliente'] ?> d-none">La cedula debe contener únicamente números y estar entre 6 a 7 caracteres</p>

                      <div class="input-group flex-nowrap margin-inputs" id="grp_nombre">
                        <span class="input-modal mt-1">
                          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill azul" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                          </svg>
                        </span>

                        <input class="form-control mayuscula input-modal input-disabled input-cliente input-validar" type="text" id="nombre" name="nombre" value="<?= $cliente['nombre'] ?>" placeholder="Nombre" required maxlength="11">
                      </div>

                      <p class="p-error-nombre<?= $cliente['id_cliente'] ?> d-none">El Nombre debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres</p>

                      <div class="input-group flex-nowrap margin-inputs" id="grp_apellido">
                        <span class="input-modal mt-1">
                          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill azul" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                          </svg>
                        </span>
                        <input class="form-control input-modal mayuscula input-disabled input-cliente input-validar" type="text" id="apellido" name="apellido" value="<?= $cliente['apellido'] ?>" placeholder="Apellido" required maxlength="11">

                      </div>

                      <p class="p-error-apellido<?= $cliente['id_cliente'] ?> d-none">El Apellido debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres</p>

                      <div class="input-group flex-nowrap margin-inputs" id="grp_telefono">
                        <span class="input-modal mt-1">
                          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-telephone-fill azul" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                          </svg>
                        </span>
                        <input class="form-control input-modal input-disabled input-cliente input-validar" type="number" id="telefono" name="telefono" placeholder="Telefono" value="<?= $cliente['telefono'] ?>" required maxlength="18">
                      </div>
                      <p class="p-error-telefono<?= $cliente['id_cliente'] ?> d-none">El Telefono solo debe contener y comen números, comenzando con "0412 o 0414 o 0416 o 0424 o 0426 o 0212 o 24"</p>

                      <div class="input-group flex-nowrap margin-inputs" id="grp_direccion">
                        <span class="input-modal mt-1">
                          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-card-heading azul" viewBox="0 0 16 16">
                            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                            <path d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-1z" />
                          </svg>
                        </span>
                        <input class="form-control  mayuscula input-modal input-disabled input-cliente input-validar" type="text" id="direccion" name="direccion" value="<?= $cliente['direccion'] ?>" placeholder="Direccion" required maxlength="20">
                      </div>
                      <p class="p-error-direccion<?= $cliente['id_cliente'] ?> d-none">Debe estar completa y detallada</p>

                      <label for="" class=" fw-bold mb-1 mt-2">Fecha de nacimiento</label>
                      <div class="input-group flex-nowrap margin-inputs" id="grp_fn">
                        <span class="input-modal mt-1">
                          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
                            <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
                          </svg>
                        </span>
                        <input class="form-control input-modal input-disabled input-cliente input-validar" type="date" id="fn" name="fn" placeholder="Fn" required pattern="\d{4}-\d{2}-\d{2}" value="<?= $cliente['fn'] ?>">
                      </div>
                      <p class="p-error-fn<?= $cliente['id_cliente'] ?> d-none">No puede ser mayor que la fecha actual</p>

                      <label for="" class=" fw-bold mb-1 mt-2">Genero</label>
                      <div class="input-group flex-nowrap margin-inputs" id="grp_genero">
                        <span class="input-modal mt-1">
                          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
                            <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
                          </svg>
                        </span>
                        <select name="genero" class="form-control input-modal" required id="">
                          <option selected="<?= $cliente['genero'] ?>" disabled><?= $cliente['genero'] ?></option>
                          <option value="Masculino">Masculino</option>
                          <option value="Femenino">Femenino</option>
                        </select>
                      </div>


                      <div class="mt-3 uk-text-right">
                        <button class="uk-button col-6 me-2 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>
                        <button class="btn col-5 btn-agregarcita-modal" type="sumit" name="crear" id="botonEnviar">Modificar</button>
                      </div>
                    </form>
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


<div id="modal-examplePaciente" uk-modal>
  <div class="uk-modal-dialog uk-modal-body tamaño-modal">
    <!-- Boton que cierra el modal -->
    <a href="#">
      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
      </svg>
    </a>

    <div class="d-flex align-items-center mb-3">
      <div>
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-fill-add azul me-3 mb-3" viewBox="0 0 16 16">
          <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
          <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z" />
        </svg>
      </div>
      <div class="">
        <p class="uk-modal-title fs-5 ">
          Registrar Paciente
        </p>
      </div>

    </div>
    <div class="alert alert-danger d-none alertaFormulario" role="alert">
      <div class="">
        <p style="font-size: 13px;" class="text-center">Por favor, corrige los errores en el formulario.</p>
      </div>
    </div>

    <form class="form-modal form-validable" id="modalAgregar" action="/Sistema-del--CEM--JEHOVA-RAFA/Clientes/guardar" method="POST" autocomplete="off">
      <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario']; ?>">
      <input type="hidden" name="verificar" value="">
      <div id="divAPacienteMP">
        <!-- input oculto para verificar si se agrega desde hospitalización -->
      </div>
      <div class="input-group flex-nowrap margin-inputs" id="grp_cedula">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-vcard-fill azul" viewBox="0 0 16 16">
            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
          </svg>
        </span>
        <span class="">
          <select class="form-control input-modal" aria-label="2" placeholder="Nacionalidad" name="nacionalidad">
            <option value="V" selected>V</option>
            <option value="E">E</option>
          </select>
        </span>

        <input class="form-control input-modal input-disabled input-paciente input-validar" style="width: 7vh !important;" type="number" id="cedula" name="cedula" placeholder="Cedula" required maxlength="8" minlength="6" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
      </div>

      <p class="p-error-cedula d-none">La cedula debe contener únicamente números y estar entre 6 a 7 caracteres</p>

      <div class="input-group flex-nowrap margin-inputs" id="grp_nombre">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill azul" viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
          </svg>
        </span>

        <input class="form-control mayuscula input-modal input-disabled input-paciente input-validar" type="text" id="nombre" name="nombre" placeholder="Nombre" required maxlength="11">
      </div>

      <p class="p-error-nombre d-none">El Nombre debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres</p>

      <div class="input-group flex-nowrap margin-inputs" id="grp_apellido">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill azul" viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
          </svg>
        </span>
        <input class="form-control input-modal mayuscula input-disabled input-paciente input-validar" type="text" id="apellido" name="apellido" placeholder="Apellido" required maxlength="11">

      </div>

      <p class="p-error-apellido d-none">El Apellido debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres</p>

      <div class="input-group flex-nowrap margin-inputs" id="grp_telefono">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-telephone-fill azul" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
          </svg>
        </span>
        <input class="form-control input-modal input-disabled input-paciente input-validar" type="number" id="telefono" name="telefono" placeholder="Telefono" required maxlength="18">
      </div>
      <p class="p-error-telefono d-none">El Telefono solo debe contener y comen números, comenzando con "0412 o 0414 o 0416 o 0424 o 0426 o 0212 o 24"</p>

      <div class="input-group flex-nowrap margin-inputs" id="grp_direccion">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-card-heading azul" viewBox="0 0 16 16">
            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
            <path d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-1z" />
          </svg>
        </span>
        <input class="form-control  mayuscula input-modal input-disabled input-paciente input-validar" type="text" id="direccion" name="direccion" placeholder="Direccion" required maxlength="20">
      </div>
      <p class="p-error-direccion d-none">Debe estar completa y detallada</p>

      <label for="" class=" fw-bold mb-1 mt-2">Fecha de nacimiento</label>
      <div class="input-group flex-nowrap margin-inputs" id="grp_fn">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
            <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
          </svg>
        </span>
        <input class="form-control input-modal input-disabled input-paciente input-validar" type="date" id="fn" name="fn" placeholder="Fn" required pattern="\d{4}-\d{2}-\d{2}">
      </div>
      <p class="p-error-fn d-none">No puede ser mayor que la fecha actual</p>

      <label for="" class=" fw-bold mb-1 mt-2">Genero</label>
      <div class="input-group flex-nowrap margin-inputs" id="grp_genero">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
            <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
          </svg>
        </span>
        <select name="genero" class="form-control input-modal input-validar" required id="">
          <option selected="" disabled>Seleccionar Genero</option>
          <option value="Masculino">Masculino</option>
          <option value="Femenino">Femenino</option>
        </select>
      </div>

      <p class="p-error-genero d-none">No puede ser mayor que la fecha actual</p>




      <div class="mt-3 uk-text-right">
        <button class="uk-button col-6 me-2 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>
        <button class="btn col-5 btn-agregarcita-modal" name="crear" id="botonEnviar">
          <span id="agregar">Registrar</span>
          <span id="spinner-cargando" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
        </button>
      </div>
    </form>
  </div>
</div>


<script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/ayudaPaciente.js"></script>


<?php require_once './src/vistas/head/footer.php'; ?>