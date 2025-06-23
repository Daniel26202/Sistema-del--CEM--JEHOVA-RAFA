<div class="w-50 m-auto">
    <?php if ($parametro != ""): ?>


        <?php if ($parametro[0] == "errorCedula"): ?>
            <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">La cédula ya existen, intente de nuevo.</p>
            </div>
        <?php elseif ($parametro[0] == "registro"): ?>
            <div class="uk-alert-primary comentarioD  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">Se registro correctamente.</p>
            </div>
        <?php elseif ($parametro[0] == "editar"): ?>
            <div class="uk-alert-primary comentarioD  me-4 fw-bolder  alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">Se actualizo correctamente.</p>
            </div>
        <?php elseif ($parametro[0] == "eliminar"): ?>
            <div class="uk-alert-primary comentarioD  me-4 fw-bolder  alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">Se ha eliminado correctamente.</p>
            </div>
        <?php elseif ($parametro[0] == "restablecido"): ?>
            <div class="uk-alert-primary comentarioD  me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">Restablecido correctamente.</p>
            </div>


        <?php elseif ($parametro[0] == "errorfecha"): ?>
            <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2 ">la fecha de nacimiento no concuerda, intente de nuevo.</p>
            </div>


        <?php elseif ($parametro[0] == "errorSistem"): ?>
            <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder alertaGenerica  text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">lamentablemente ocurrio un error por favor intente mas tarde.</p>
            </div>

        <?php elseif ($parametro[0] == "error"): ?>
            <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">la patologia ya existe por favor intente con otra.</p>
            </div>



        <?php elseif ($parametro[0] == "errorCita"): ?>
            <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">error la cita ya existe.</p>
            </div>

        <?php elseif ($parametro[0] == "fechainvalida"): ?>
            <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">La fecha no es valida por favor intente nuevamente.</p>
            </div>


        <?php elseif ($parametro[0] == "errorServicio"): ?>
            <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">error el servicio medico ya existe.</p>
            </div>


        <?php elseif ($parametro[0] == "errorS"): ?>

            <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">El Doctor ya presta ese Servicio.</p>
            </div>

        <?php elseif ($parametro[0] == "errorD"): ?>

            <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">La cédula o el usuario ya existen, intente de nuevo.</p>
            </div>

        <?php elseif ($parametro[0] == "Usuario"): ?>

            <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">EL usuario ya existe, intente de nuevo.</p>
            </div>

        <?php elseif ($parametro[0] == "errorRif"): ?>

            <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">EL Rif ya existe, intente de nuevo.</p>
            </div>

        <?php elseif ($parametro[0] == "anulada"): ?>
            <div class="uk-alert-primary comentarioD  me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">Se anulo la factura correctamente.</p>
            </div>




        <?php endif ?>


    <?php endif; ?>


</div>