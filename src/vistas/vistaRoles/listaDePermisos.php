<div class="d-flex justify-content-between flex-wrap ">

    <?php $permisosDelRol = ($this->modelo->mostrarPermisos($rol["id_rol"], $modulo) == false) ? array() : $this->modelo->mostrarPermisos($rol["id_rol"], $modulo)["permisos"] ?>



    <div class="form-check form-switch d-flex align-items-center">
        <div>
            <input class="form-check-input form-check-js checkboxPermiso" data-index="<?= $modulo ?>" type="checkbox" role="switch"
                value="consultar" name="<?= $permisosPorModulo ?>" <?php if ($permisosDelRol != array()) {
                                                                        $permisosSeparados = explode(",", $permisosDelRol);
                                                                        $x = (in_array("consultar", $permisosSeparados)) ? "checked" : "";
                                                                    } else $x = "";
                                                                    echo $x ?>>
        </div>
        <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">

                Consultar
            </label></div>

    </div>


    <div class="form-check form-switch d-flex align-items-center">
        <div>
            <input class="form-check-input form-check-js checkboxPermiso" type="checkbox" role="switch" data-index="<?= $modulo ?>"
                value="guardar" name="  <?= $permisosPorModulo ?>" <?php if ($permisosDelRol != array()) {
                                                                        $permisosSeparados = explode(",", $permisosDelRol);
                                                                        $x = (in_array("guardar", $permisosSeparados)) ? "checked" : "";
                                                                    } else $x = "";
                                                                    echo $x ?>>
        </div>
        <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">

                Guardar
            </label></div>

    </div>


    <div class="form-check form-switch d-flex align-items-center">
        <div>
            <input class="form-check-input form-check-js checkboxPermiso" type="checkbox" role="switch"
                value="editar" name="  <?= $permisosPorModulo ?>" data-index="<?= $modulo ?>" <?php if ($permisosDelRol != array()) {
                                                                                                    $permisosSeparados = explode(",", $permisosDelRol);
                                                                                                    $x = (in_array("editar", $permisosSeparados)) ? "checked" : "";
                                                                                                } else $x = "";
                                                                                                echo $x ?>>
        </div>
        <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">

                Editar
            </label></div>

    </div>

    <div class="form-check form-switch d-flex align-items-center">
        <div>
            <input class="form-check-input form-check-js checkboxPermiso" type="checkbox" role="switch"
                value="eliminar" name="  <?= $permisosPorModulo ?>" data-index="<?= $modulo ?>" <?php if ($permisosDelRol != array()) {
                                                                                                    $permisosSeparados = explode(",", $permisosDelRol);
                                                                                                    $x = (in_array("eliminar", $permisosSeparados)) ? "checked" : "";
                                                                                                } else $x = "";
                                                                                                echo $x ?>>
        </div>
        <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">

                Eliminar
            </label></div>

    </div>
</div>






