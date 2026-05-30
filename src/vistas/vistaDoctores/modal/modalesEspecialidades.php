<!-- Modal Agregar-->
<div class="modal fade" id="exampleModalAgregarEspecialidad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content tamaño-modal">
      <div class="modal-header">
        <h5 class="modal-title fs-4 fw-bold" id="exampleModalLabelEspec">Registrar Patologia</h5>
        <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#exampleModalConsultarEspecialidad"></button>
      </div>
      <form class=" form-validable" id="formEspecialidad">

        <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario'] ?>">

        <div class="modal-body">

          <label class="label-custom">Nombre de la patologia</label>
          <div class="campo-custom">
            <div class="input-custom">
              <span class="icono-izq">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                  class="bi bi-bandaid-fill azul" viewBox="0 0 16 16">
                  <path d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z" />
                </svg>
              </span>
              <input class="form-control txt-custom input-validar campo-editar" name="nombre" type="text" placeholder="Nombre del sintoma">
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
        <div class="modal-footer">
          <button type="button" class="btn btn-modals-cancelar me-2" data-bs-toggle="modal" data-bs-target="#exampleModalConsultarEspecialidad">Cancelar</button>
          <button type="submit" class="btn btn-modals" id="btnModalEspecialidad">Registrar</button>
        </div>
      </form>
    </div>
  </div>
</div>












<div class="modal fade" id="exampleModalConsultarEspecialidad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content tamaño-modal">
      <div class="modal-header">
        <h5 class="modal-title fs-4 fw-bold" id="exampleModalLabelPaciente">Gestionar Especialidades</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="table table-responsive">
        <table class="exampleTable2 table table-striped">
          <thead>
            <tr>
              <th class="text-dark text-center">#</th>
              <th class="text-dark text-center">Nombre</th>
              <th class="text-dark text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>



          </tbody>
        </table>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-modals-cancelar me-2" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-modals" data-bs-toggle="modal" data-bs-target="#exampleModalAgregarEspecialidad" id="openBtnModalEspecialidad">Nuevo</button>
      </div>

    </div>
  </div>
</div>