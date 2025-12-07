<div id="modal-info-doctores" uk-modal>
    <div class="uk-modal-dialog uk-modal-body tamaño-modal">
        <form class="" method="POST" action="?c=ControladorDoctores/borrarDoctor">

            <!-- Botón que cierra el modal -->
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
                </div>
                <div>
                    <h5 id="titulo">

                    </h5>
                </div>
            </div>
            <hr>
            <h5>Servicios Ofrecidos:</h5>
            <p id="servicios"></p>


            <div class="modal-body " id="cajaDeInfo">

            </div>





            <div class="mt-3 uk-text-right">

                <button class="uk-button fw-bold uk-button-default uk-modal-close btn-cerrar-modal" type="button"
                    data-bs-dismiss="modal">Cerrar</button>

            </div>
        </form>
    </div>
</div>