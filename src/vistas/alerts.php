<div class="w-50 m-auto">
    <?php if ($parametro != ""): ?>


        <?php if ($parametro[0] == "errorCedula"): ?>
            <div class="uk-alert-danger comentario  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">La cédula ya existen, intente de nuevo.</p>
            </div>
        <?php elseif ($parametro[0] == "registro"): ?>
            <div class="uk-alert-primary comentario  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">Se registro correctamente.</p>
            </div>

        <?php elseif ($parametro[0] == "registroD"): ?>
            <div class="uk-alert-primary comentario  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">Se registro el Doctor correctamente ahora debe asignarle sus respectivos servicios medicos desde el boton 'Registrar Servicio'.</p>
            </div>
        <?php elseif ($parametro[0] == "editar"): ?>
            <div class="uk-alert-primary comentario  me-4 fw-bolder  alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">Se actualizo correctamente.</p>
            </div>
        <?php elseif ($parametro[0] == "eliminar"): ?>
            <div class="uk-alert-primary comentario  me-4 fw-bolder  alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">Se ha eliminado correctamente.</p>
            </div>
        <?php elseif ($parametro[0] == "restablecido"): ?>
            <div class="uk-alert-primary comentario  me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">Restablecido correctamente.</p>
            </div>


        <?php elseif ($parametro[0] == "errorfecha"): ?>
            <div class="uk-alert-danger comentario  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2 ">la fecha de nacimiento no concuerda, intente de nuevo.</p>
            </div>


        <?php elseif ($parametro[0] == "errorSistem"): ?>
            <div class="uk-alert-danger comentario  comentarioRed me-4 fw-bolder alertaGenerica  text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">lamentablemente ocurrio un error por favor intente mas tarde.</p>
            </div>

        <?php elseif ($parametro[0] == "error"): ?>
            <div class="uk-alert-danger comentario  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">la patología ya existe por favor intente con otra.</p>
            </div>



        <?php elseif ($parametro[0] == "errorCita"): ?>
            <div class="uk-alert-danger comentario  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">error la cita ya existe.</p>
            </div>

        <?php elseif ($parametro[0] == "fechainvalida"): ?>
            <div class="uk-alert-danger comentario  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">La fecha no es valida por favor intente nuevamente.</p>
            </div>


        <?php elseif ($parametro[0] == "errorServicio"): ?>
            <div class="uk-alert-danger comentario  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">error el servicio medico ya existe.</p>
            </div>


        <?php elseif ($parametro[0] == "errorS"): ?>

            <div class="uk-alert-danger comentario  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">El Doctor ya presta ese Servicio.</p>
            </div>

        <?php elseif ($parametro[0] == "errorD"): ?>

            <div class="uk-alert-danger comentario  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">La cédula o el usuario del doctor estan registrados.</p>
            </div>

        <?php elseif ($parametro[0] == "Usuario"): ?>

            <div class="uk-alert-danger comentario  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">EL usuario ya existe, intente de nuevo.</p>
            </div>

        <?php elseif ($parametro[0] == "errorRif"): ?>

            <div class="uk-alert-danger comentario  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">EL Rif ya existe, intente de nuevo.</p>
            </div>

        <?php elseif ($parametro[0] == "anulada"): ?>
            <div class="uk-alert-primary comentario  me-4 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">Se anulo la factura correctamente.</p>
            </div>


        <?php elseif ($parametro[0] == "permiso"): ?>
            <div class=" uk-alert-danger comentario w-100 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">No tiene permiso para hacer dicha acción por favor comuníquese con el administrador del sistema</p>
            </div>

        <?php elseif ($parametro[0] == "noExisteRespaldo"): ?>
            <div class=" uk-alert-danger comentario w-100 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">No existen respaldos guardados</p>
            </div>

        <?php elseif ($parametro[0] == "guardado"): ?>
            <div class=" uk-alert-primary comentario w-100 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">El respaldo se ha descargado correctamente</p>
            </div>
        <?php elseif ($parametro[0] == "restaurado"): ?>
            <div class=" uk-alert-primary comentario w-100 fw-bolder alertaGenerica text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p class="pe-2">Se restableció el respaldo de la base de datos correctamente</p>
            </div>


        <?php endif ?>


    <?php endif; ?>


</div>