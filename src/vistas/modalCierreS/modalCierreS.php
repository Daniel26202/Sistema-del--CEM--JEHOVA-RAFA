<!-- Modal Agregar-->
<div class="modal fade" id="cerrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content tamaño-modal">
            <div class="modal-header">
                <h5 class="modal-title fs-4 fw-bold" id="exampleModalLabelPaciente">Cerrar Session</h5>
                <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#exampleModalConsultarSintoma"></button>
            </div>
            <div>

                <div class="modal-body">

                    <?php

                    echo '<h5 class="modal-title" id="exampleModalLabel">
                    ¿' . $_SESSION['usuario'] . '   ' . 'Desea Cerrar 
                    la Sesion?
                    </h5>';
                    ?>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-modals-cancelar me-2" data-bs-toggle="modal">Cancelar</button>
                    <a href="/Sistema-del--CEM--JEHOVA-RAFA/Inicio/inicio/cerrar" class="btn btn-modals">Cerrar</a>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>