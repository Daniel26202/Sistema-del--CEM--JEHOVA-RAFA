




<!-- Modal Agregar-->
<div class="modal fade" id="exampleModalAgregarPatologia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content tamaño-modal">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrar Patología</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form class="form-modal form-validable" id="modalAgregar" autocomplete="off">

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


        <div class="modal-footer">
          <button type="button" class="btn btn-modals-cancelar  me-2" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-modals" data-bs-dismiss="modal">Agregar</button>
        </div>
      </form>
    </div>
  </div>
</div>