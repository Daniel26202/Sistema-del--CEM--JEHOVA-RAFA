<div class="d-flex justify-content-between flex-wrap ">

    <div class="form-check form-switch d-flex align-items-center">
        <div>
            <input class="form-check-input checkboxPermiso" data-index="<?= $modulo ?>" type="checkbox" role="switch" id="flexSwitchCheckDefault"
                value="consultar" name="  <?= $permisosPorModulo ?>">
        </div>
        <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">

                Consultar
            </label></div>

    </div>


    <div class="form-check form-switch d-flex align-items-center">
        <div>
            <input class="form-check-input checkboxPermiso" type="checkbox" role="switch" id="flexSwitchCheckDefault" data-index="<?= $modulo ?>"
                value="guardar" name="  <?= $permisosPorModulo ?>">
        </div>
        <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">

                Guardar
            </label></div>

    </div>


    <div class="form-check form-switch d-flex align-items-center">
        <div>
            <input class="form-check-input checkboxPermiso" type="checkbox" role="switch" id="flexSwitchCheckDefault"
                value="editar" name="  <?= $permisosPorModulo ?>" data-index="<?= $modulo ?>">
        </div>
        <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">

                Editar
            </label></div>

    </div>



    <div class="form-check form-switch d-flex align-items-center">
        <div>
            <input class="form-check-input checkboxPermiso" type="checkbox" role="switch" id="flexSwitchCheckDefault"
                value="eliminar" name="  <?= $permisosPorModulo ?>" data-index="<?= $modulo ?>">
        </div>
        <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">

                Eliminar
            </label></div>

    </div>
</div>