<?php foreach ($datos as $dato): ?>
    <div id="modal-eliminar-doctores<?php echo $dato["id_personal"]; ?>" uk-modal>
        <div class="uk-modal-dialog uk-modal-body tamaño-modal">
            <form class="" method="POST" action="

            <?= $vistaActiva != "papelera" ? '
            /Sistema-del--CEM--JEHOVA-RAFA/Doctores/borrarDoctor
            ' : '
            /Sistema-del--CEM--JEHOVA-RAFA/Doctores/restablecer
            ' ?>
            ">

                <!-- Boton que cierra el modal -->
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                        class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                        <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                    </svg>
                </a>

                <div class="d-flex align-items-center">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-trash-fill azul me-2" viewBox="0 0 16 16">
                            <path
                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                        </svg>
                    </div>
                    <div>
                        <h5>
                            <?= $vistaActiva != "papelera" ? '
                            ¿Desea eliminar el Doctor?
                            ' : '
                            ¿Desea restablecer el Doctor?
                            ' ?>
                        </h5>
                    </div>
                </div>

                <div>
                    <input type="" name="usuario" value="<?php echo $dato["usuario"]; ?>" hidden>
                    <input type="" name="cedula" value="<?php echo $dato["cedula"]; ?>" hidden>
                    <input type="" name="id_usuario" value="<?php echo $dato["id_usuario"]; ?>" hidden>
                    <input type="" name="id_personal" value="<?php echo $dato["id_personal"]; ?>" hidden>
                    <input type="hidden" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario'] ?>">
                </div>

                <div class="mt-3 uk-text-right">

                    <button class="uk-button fw-bold uk-button-default uk-modal-close btn-cerrar-modal" type="button"
                        data-bs-dismiss="modal">Cancelar</button>
                    <input class="uk-button uk-button-primary btn-agregarcita-modal ms-2 fw-bold" type="submit"
                        name="enviar" data-bs-dismiss="modal" value="<?= $vistaActiva != "papelera" ? 'Eliminar' : 'Restablecer' ?>">

                </div>
            </form>
        </div>
    </div>
<?php endforeach ?>