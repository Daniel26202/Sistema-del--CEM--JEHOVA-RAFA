<?php require_once './src/vistas/head/head.php'; ?>
<?php $datos = $this->modelo->seleccionarUsuario($_SESSION["usuario"]); ?>
<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">



  <h1 style="width: 95%; " class="m-auto mb-3 text-center">Perfil <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
      class="bi bi-person-fill " viewBox="0 0 16 16">
      <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
    </svg></h1>


  <!-- alertas -->

  <?php require_once "./src/vistas/alerts.php" ?>



  <!-- alertas -->

  <?php require_once "./src/vistas/alerts.php" ?>

  <div class="caja-contenedor-tabla  p-3 mb-3 m-auto" style="width: 95%; ">
    <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">

    </div>

    <div class="fondo-tabla col-7 m-auto pb-5 mb-5">
      <form class="form-modal perfil pb-5 " id="perfil">
        <div class="m-auto  w-50">
          <svg xmlns="http://www.w3.org/2000/svg" width="240" height="240" fill="currentColor"
            class="bi bi-person-fill azul" viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
          </svg>
        </div>
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
              value="<?= $d["cedula"] ?>" disabled uk-tooltip="Cedula">
        </div>

        <div class="input-group flex-nowrap">
          <span class="input-modal mt-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
              class="bi bi-person-fill azul" viewBox="0 0 16 16">
              <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
            </svg>
          </span>
          <input class="form-control input-modal input-perfil" type="text" name="nombreyapellido"
            placeholder="Nombre y Apellido" disabled uk-tooltip="Nombre" value="<?= $d["nombre"] ?>">

        </div>

        <div class="input-group flex-nowrap">
          <span class="input-modal mt-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
              class="bi bi-person-fill azul" viewBox="0 0 16 16">
              <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
            </svg>
          </span>
          <input class="form-control input-modal input-perfil" type="text" name="nombreyapellido"
            placeholder="Nombre y Apellido" disabled uk-tooltip="Apellido" value="<?= $d["apellido"] ?>">

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
            disabled uk-tooltip="Telefono" value="<?= $d["telefono"] ?>">
        </div>

        <div class="input-group flex-nowrap">
          <span class="input-modal mt-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
              class="bi bi-person-fill azul" viewBox="0 0 16 16">
              <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
            </svg>
          </span>
          <input class="form-control input-modal input-perfil" type="text" name="usuario" placeholder="Usuario"
            disabled uk-tooltip="Usuario" value="<?= $d["usuario"] ?>">
        </div>

        <div class="d-flex justify-content-end mb-5">

          <!-- Button trigger modal -->
          <button type="button" class="btn  btn-tabla mb-1 botonesEdi" data-index=1 data-bs-toggle="modal" data-bs-target="#exampleModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
              class="bi bi-pencil-fill" viewBox="0 0 16 16">
              <path
                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
            </svg>
          </button>

        </div>
      </form>


    </div>


  </div>


<?php endforeach ?>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content contenido">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar Perfil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder  text-center" uk-alert>
          <a class="uk-alert-close" uk-close></a>
          <p class="pe-2">Atención si edita su perfil tendra que iniciar session nuevamente por seguridad </p>
        </div>

        <form class="form-modal form-validable1" id="modalAgregar" action="/Sistema-del--CEM--JEHOVA-RAFA/Perfil/guardar" method="POST" autocomplete="off">
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

            <input class="form-control input-modal input-disabled input-paciente input-validar" style="width: 7vh !important;" type="number" id="cedula" value="<?= $d["cedula"] ?>" name="cedula" placeholder="Cedula" required maxlength="8" minlength="6" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
          </div>

          <p class="p-error-cedula1 d-none">La cedula debe contener únicamente números y estar entre 6 a 7 caracteres</p>

          <div class="input-group flex-nowrap margin-inputs" id="grp_nombre">
            <span class="input-modal mt-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill azul" viewBox="0 0 16 16">
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
              </svg>
            </span>

            <input class="form-control mayuscula input-modal input-disabled input-paciente input-validar" type="text" id="nombre" name="nombre" placeholder="Nombre" required maxlength="11" value="<?= $d["nombre"] ?>">
          </div>

          <p class="p-error-nombre1 d-none">El Nombre debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres</p>

          <div class="input-group flex-nowrap margin-inputs" id="grp_apellido">
            <span class="input-modal mt-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill azul" viewBox="0 0 16 16">
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
              </svg>
            </span>
            <input class="form-control input-modal mayuscula input-disabled input-paciente input-validar" type="text" id="apellido" name="apellido" placeholder="Apellido" required maxlength="11" value="<?= $d["apellido"] ?>">

          </div>

          <p class="p-error-apellido1 d-none">El Apellido debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres</p>

          <div class="input-group flex-nowrap margin-inputs" id="grp_telefono">
            <span class="input-modal mt-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-telephone-fill azul" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
              </svg>
            </span>
            <input class="form-control input-modal input-disabled input-paciente input-validar" type="number" id="telefono" name="telefono" placeholder="Telefono" value="<?= $d["telefono"] ?>" required maxlength="18">
          </div>
          <p class="p-error-telefono1 d-none">El Telefono solo debe contener y comen números, comenzando con "0412 o 0414 o 0416 o 0424 o 0426 o 0212 o 24"</p>




          <div class="input-group flex-nowrap margin-inputs" id="grp_fn">
            <span class="input-modal mt-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
                <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
              </svg>
            </span>
            <input class="form-control input-modal input-disabled input-paciente input-validar" type="text" id="Usuario" name="usuario" placeholder="Usuario" value="<?= $d["usuario"] ?>" required>
          </div>
          <p class="p-error-usuario1 d-none">El usuario esta mal</p>



          <div class="mt-3 uk-text-right">
            <button class="uk-button col-6 me-2 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>
            <button class="btn col-5 btn-agregarcita-modal" type="sumit" name="crear" id="botonEnviar">Agregar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>
</div>







<?php require_once './src/vistas/head/footer.php'; ?>