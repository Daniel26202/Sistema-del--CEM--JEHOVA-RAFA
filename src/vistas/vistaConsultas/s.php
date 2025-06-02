<?php require_once './src/vistas/head/head.php';  ?>


<div class="col-12 m-auto pt-3 contenedor-fondo">

    <h5 style="width: 95%; " class="m-auto mb-3">Servicios <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
            fill="currentColor" class="bi bi-clipboard-heart mb-2 ms-2" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M5 1.5A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5v-1Zm5 0a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1Z" />
            <path
                d="M3 1.5h1v1H3a1 1 0 0 0-1 1V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3.5a1 1 0 0 0-1-1h-1v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2Z" />
            <path d="M8 6.982C9.664 5.309 13.825 8.236 8 12 2.175 8.236 6.336 5.31 8 6.982Z" />
        </svg>
    </h5>


    <!-- alertas -->
    <div class="w-50 m-auto">
        <?php if ($parametro != ""): ?>


            <?php if ($parametro[0] == "error"): ?>
                <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p class="pe-2">La cédula ya existen, intente de nuevo.</p>
                </div>
            <?php elseif ($parametro[0] == "registro"): ?>
                <div class="uk-alert-primary comentarioD  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p class="pe-2">Se registro el paciente correctamente.</p>
                </div>
            <?php elseif ($parametro[0] == "editar"): ?>
                <div class="uk-alert-primary comentarioD  me-4 fw-bolder  alertaGenerica text-center" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p class="pe-2">Se actualizo el paciente correctamente.</p>
                </div>
            <?php elseif ($parametro[0] == "eliminar"): ?>
                <div class="uk-alert-primary comentarioD  me-4 fw-bolder  alertaGenerica text-center" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p class="pe-2">Se ha eliminado el paciente correctamente.</p>
                </div>
            <?php elseif ($parametro[0] == "restablecido"): ?>
                <div class="uk-alert-primary comentarioD  me-4 fw-bolder alertaGenerica text-center" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p class="pe-2">Se ha restablecido el paciente correctamente.</p>
                </div>


            <?php elseif ($parametro[0] == "errorfecha"): ?>
                <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder alertaGenerica text-center" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p class="pe-2 ">la fecha de nacimiento no concuerda, intente de nuevo.</p>
                </div>


            <?php elseif ($parametro[0] == "errorSintem"): ?>
                <div class="uk-alert-danger comentarioD  comentarioRed me-4 fw-bolder  text-center" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p class="pe-2">lamentablemente ocurrio un error por favor intente mas tarde.</p>
                </div>


            <?php endif ?>
        <?php endif ?>


    </div>
</div>
<?php require_once './src/vistas/head/footer.php';  ?>