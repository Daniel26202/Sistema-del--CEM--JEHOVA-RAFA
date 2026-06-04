<?php require_once './src/vistas/head/head.php'; ?>

<!-- Contenido  -->
<div class="col-12 m-auto pt-3 contenedor-fondo" style="height: 100vh;">



  <h1 style="width: 95%; " class="m-auto mb-3 text-center">Perfil <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
      class="bi bi-person-fill " viewBox="0 0 16 16">
      <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
    </svg></h1>



  <div class="caja-contenedor-tabla  p-3 mb-3 m-auto" style="width: 95%; ">
    <div class="me-2 ps-3 col-12 caja-boton d-flex justify-content-between align-items-center row ">

    </div>





    <div class="modal-content fondo-tabla fondo-perfil col-7 m-auto pb-5 mb-5 ">
      <?= $urlBase ?>
      <div class="m-auto">

        <img id="imgUser" src="" alt="" class="img-perfil">
      </div>


      <div class="" id="">


        <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario'] ?>">

        <input type="hidden" name="cedulaRegistrada" id="cedulaRegistrada">

        <input type="hidden" name="id" id="id_paciente">


        <div class="modal-body d-flex justify-content-between flex-wrap">

          <div class="div-input-perfil">
            <label class="label-custom">Cédula</label>
            <div class="campo-custom">
              <div class="input-custom">
                <span class="icono-izq">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-vcard-fill azul" viewBox="0 0 16 16">
                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                  </svg>
                </span>

                <select class="form-control-plaintext tamaño-select-mini inputs" aria-label="2" placeholder="Nacionalidad" name="nacionalidad">
                  <option value="V" selected>V</option>
                  <option value="E">E</option>
                </select>

                <input disabled class="form-control txt-custom input-validar inputs" id="cedulaPaciente" name="cedula" type="number" placeholder="Cédula del paciente">

                <span class="icono-der">
                  <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                  </svg>
                  <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                  </svg>
                </span>
              </div>

              <p class="error-msg d-none"></p>
            </div>
          </div>
          <div class="div-input-perfil">
            <label class="label-custom">Nombre</label>
            <div class="campo-custom">
              <div class="input-custom">
                <span class="icono-izq">
                  <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                  </svg>
                </span>
                <input disabled class="form-control txt-custom input-validar inputs" name="nombre" type="text" placeholder="Nombre del paciente">
                <span class="icono-der">
                  <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                  </svg>
                  <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                  </svg>
                </span>
              </div>
              <p class="error-msg d-none"></p>
            </div>
          </div>
          <div class="div-input-perfil">
            <label class="label-custom">Apellido</label>
            <div class="campo-custom">
              <div class="input-custom">
                <span class="icono-izq">
                  <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                  </svg>
                </span>
                <input disabled class="form-control txt-custom input-validar inputs" name="apellido" type="text" placeholder="Apellido del paciente">
                <span class="icono-der">
                  <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                  </svg>
                  <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                  </svg>
                </span>
              </div>
              <p class="error-msg d-none"></p>
            </div>
          </div>
          <div class="div-input-perfil">
            <label class="label-custom">Teléfono</label>
            <div class="campo-custom">
              <div class="input-custom">
                <span class="icono-izq">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-telephone-fill azul" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                  </svg>
                </span>
                <input disabled class="form-control txt-custom input-validar inputs" name="telefono" type="number" placeholder="Teléfono del paciente">
                <span class="icono-der">
                  <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                  </svg>
                  <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                  </svg>
                </span>
              </div>
              <p class="error-msg d-none"></p>
            </div>
          </div>

          <div class="div-input-perfil">
            <label class="label-custom">Usuario</label>
            <div class="campo-custom">

              <div class="input-custom">
                <span class="icono-izq">
                  <span class="icono-izq">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                      <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                    </svg>
                  </span>
                </span>
                <input disabled class="form-control txt-custom input-validar inputs campo-editar" name="correo" type="email" placeholder="Correo del doctor">
                <span class="icono-der">
                  <svg class="check d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"></path>
                  </svg>
                  <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                  </svg>
                </span>
              </div>
              <p class="error-msg d-none"></p>
            </div>
          </div>

          <div class="div-input-perfil">
            <label class="label-custom">Correo</label>

            <div class="campo-custom">
              <div class="input-custom">
                <span class="icono-izq">
                  <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                  </svg>
                </span>

                <input disabled class="form-control txt-custom input-validar inputs" name="usuario" type="text" placeholder="Usuario del doctor">

                <span class="icono-der d-none">
                  <svg class="check" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"></path>
                  </svg>
                  <svg class="error d-none" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                  </svg>
                </span>
              </div>
              <p class="error-msg d-none fw-bold p-error-validaciones"></p>

            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" id="btnOpenModal" class="btn btn-modals" data-bs-toggle="modal" data-bs-target="#exampleModalPerfil">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
              class="bi bi-pencil-fill" viewBox="0 0 16 16">
              <path
                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
            </svg>
          </button>
        </div>
      </div>


    </div>
  </div>






</div>






<?php require_once 'modalPerfil.php' ?>
<?php require_once './src/vistas/head/footer.php'; ?>
<script type="module" src="<?= $urlBase ?>../src/assets/js/ajax/perfil.js"></script>
<script type="text/javascript" src="<?= $urlBase ?>../src/assets/js/ayudaInteractiva/ayudaPerfil.js"></script>