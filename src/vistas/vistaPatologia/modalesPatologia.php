<!-- modal agregar especialidad -->

<div id="modal-exampleAgregarPatologias" uk-modal>
  <div class="uk-modal-dialog uk-modal-body tamaño-modal">

    <div class="d-flex justify-content-between ">
      <div class="d-flex align-items-center mb-3" id="registrarEspecialidades">
        <div>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
            class="bi bi-bandaid-fill azul me-3 mb-3" viewBox="0 0 16 16">
            <path
              d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z" />
          </svg>
        </div>
        <div class="">
          <p class="uk-modal-title fs-5 ">
            Registrar Patología
          </p>
        </div>
      </div>
      <!-- Ayuda interactiva -->
      <a href="#">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
          class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
          <path
            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
        </svg>
      </a>
    </div>


    <div class="alert alert-danger d-none" role="alert" id="alerta">
      <div class="">
        <p style="font-size: 13px;" class="text-center">VERIFIQUE EL FORMULARIO ANTES DE ENVIARLO</p>
      </div>
    </div>

    <form class="form-modal form-validable form-editar form-ajax" id="modalAgregar"  autocomplete="off">

      <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario'] ?>">

      <div class="input-group flex-nowrap margin-inputs validar" id="grp_nombrePatologia">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
            class="bi bi-bandaid-fill azul" viewBox="0 0 16 16">
            <path
              d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z" />
          </svg>

        </span>

        <input class="form-control input-modal input-disabled input-paciente mayuscula input-validar input-tema" type="text"
          name="nombre" placeholder="Nombre de la Patologia" required maxlength="20"
          pattern="[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}">
      </div>

      <p class="p-error-nombre d-none">La patologia debe minimo 3 letras</p>

      <div class="mt-3 uk-text-right btn_modal_patologias">
        <button class="uk-button col-6 me-2 uk-button-default uk-modal-close btn-cerrar-modal" type="button"
          id="cancelarRegistroespecialidades">Cancelar</button>
        <button class="btn col-5 btn-agregarcita-modal btn_agregar_patologia" type="submit" name="crear"
          id="botonEnviarEspecialidad">Agregar</button>
      </div>
    </form>
  </div>
</div>


