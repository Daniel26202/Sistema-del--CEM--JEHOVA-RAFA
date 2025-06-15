<!-- prueba -->





<!-- Modal Agregar Servicio Extra-->
<div class="modal fade" id="modal-agregar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog tamaño-modal">
    <div class="modal-content agregar">
      <div class="modal-header">
        <div class="fw-bolder d-flex" id="staticBackdropLabel">
          <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor"
            class="bi bi-clipboard2-plus-fill azul me-3" viewBox="0 0 16 16">
            <path
              d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5Z" />
            <path
              d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585c.055.156.085.325.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5c0-.175.03-.344.085-.5ZM8.5 6.5V8H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V9H6a.5.5 0 0 1 0-1h1.5V6.5a.5.5 0 0 1 1 0Z" />
          </svg>
          <div>SELECCIONAR SERVICIOS</div>
        </div>
        <a type="button" data-bs-dismiss="modal" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
              d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
          </svg>
        </a>
      </div>



      <div class=" mt-2">



        <!-- Buscador -->
        <div class="d-flex justify-content-end">




          <div class="d-flex justify-content-end mb-4 col-10">


            <div class="d-flex justify-content-end" autocomplete="off" id="form-buscador">

              <input type="text" class="form-control input-buscar tamaño-input-buscar" id="selectBuscarCategoria"
                placeholder="Ingrese la Categoria">


              <button class="btn boton-buscar" title="Buscar">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search"
                  viewBox="0 0 16 16">
                  <path
                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                </svg>
              </button>
            </div>

          </div>
        </div>



        <div class="table-responsive">
          <table class="table table-striped " id="tablaPatologia">
            <thead>
              <tr>
                <th class="d-none">
                  Id
                </th>
                <th class=" text-center">#</th>
                <th class=" text-center border-start">Servicio</th>
                <th class=" text-center border-start">Doctor</th>
                <th class=" text-center border-start">Precio</th>
                <th class=" text-center border-start">Añadir</th>

              </tr>
            </thead>
            <tbody id="cuerpoTablaServicios">

              <?php if ($extras): ?>
                <?php $contador = 1; ?>

                <?php foreach ($extras as $e): ?>

                  <tr class="tr-desparecer tr">

                    <td class="text-center fw-bold">
                      <?php echo $contador++; ?>
                    </td>

                    <td class="text-center border-start">
                      <?php echo $e['1']; ?>
                    </td>
                    <td class="text-center border-start">
                      <?php echo $e['nombre_d'] . " " . $e["apellido_d"]; ?>
                    </td>
                    <td class="text-center border-start">
                      <?php echo $e['precio'] . " " . "BS"; ?>
                    </td>


                    <td class="border-start text-center">

                      <button class="btn mt-1 insertar_servicio" id="<?php echo $e['id_servicioMedico']; ?>"
                        data-bs-toggle="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor"
                          class="bi bi-clipboard2-plus-fill azul me-3" viewBox="0 0 16 16">
                          <path
                            d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5Z" />
                          <path
                            d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585c.055.156.085.325.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5c0-.175.03-.344.085-.5ZM8.5 6.5V8H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V9H6a.5.5 0 0 1 0-1h1.5V6.5a.5.5 0 0 1 1 0Z" />
                        </svg>
                      </button>

                    </td>

                  </tr>
                <?php endforeach ?>






              <?php else: ?>


                <tr>
                  <td colspan="9" class="text-center">NO HAY REGISTROS

                  </td>
                </tr>
              <?php endif ?>

              <tr id="noEncontrados" class="d-none">
                <td colspan="5" class="text-center">NO HAY REGISTROS

                </td>
              </tr>

            </tbody>
          </table>

          <table class="table table-striped " style="margin-top: -16px;">
            <thead>

            </thead>
            <tbody>
              <tr class="d-none" id="noResultado">
                <td colspan="9" class="text-center">NO HAY REGISTROS

                </td>
              </tr>
            </tbody>

          </table>



        </div>



        <div class="modal-footer">
          <button type="button" class="uk-button col-4 me-4 uk-button-default uk-modal-close btn-cerrar-modal"
            data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn col-3 btn-agregarcita-modal x d-none" id="siguiente" data-bs-toggle="modal"
            data-bs-target="#modal-agregar-servicio">Siguente</button>
        </div>

      </div>


    </div>

  </div>
</div>
</div>


<!-- modal par confirmar la insercion de los servicios medicos -->
<!-- Modal Agregar Servicio Extra-->
<div class="modal fade" id="modal-agregar-servicio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog tamaño-modal">
    <div class="modal-content agregar">
      <div class="modal-header">
        <div class="fw-bolder d-flex" id="staticBackdropLabel">
          <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor"
            class="bi bi-clipboard2-plus-fill azul me-3" viewBox="0 0 16 16">
            <path
              d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5Z" />
            <path
              d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585c.055.156.085.325.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5c0-.175.03-.344.085-.5ZM8.5 6.5V8H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V9H6a.5.5 0 0 1 0-1h1.5V6.5a.5.5 0 0 1 1 0Z" />
          </svg>
          <div>INSERTAR SERVICIOS</div>
        </div>
        <a type="button" aria-label="Close" data-bs-toggle="modal" data-bs-target="#modal-agregar">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
              d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
          </svg>
        </a>
      </div>

      <form class="formularios">

        <div class="form-modal mt-2">



          <!-- Buscador -->
          <div class="d-flex justify-content-end">




            <!-- <div class="d-flex justify-content-end mb-4 col-6" id="form-buscador">

              <a class="btn boton-buscar d-none" title="Buscar" id="reiniciarBusquedaPatologia" uk-tooltip="Restablecer">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                  <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                  <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                </svg>
              </a>
              <form action="?c=ControladorDoctores/buscarEspecialidad" method="POST" id="form-buscadorPatologias" class="d-flex justify-content-end" autocomplete="off">
                <input class="form-control input-busca" type="text" name="nombre" id="inputBuscarPatologia">
                <button class="btn boton-buscar" title="Buscar" id="especialidadBuscar">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                  </svg>
                </button>
              </form>
            </div> -->
          </div>



          <div class="table-responsive">
            <table class="table table-striped " id="tablaPatologia">
              <thead>
                <tr>
                  <th class="d-none">
                    Id
                  </th>
                  <th class=" text-center">#</th>
                  <th class=" text-center border-start">Servicio</th>
                  <th class=" text-center border-start">Doctor</th>
                  <th class=" text-center border-start">Precio</th>
                  <th class=" text-center border-start">Eliminar</th>

                </tr>
              </thead>
              <tbody id="tbody_servicios">





              </tbody>
            </table>





          </div>



          <div class="modal-footer">
            <button type="button" class="uk-button col-4 me-4 uk-button-default uk-modal-close btn-cerrar-modal"
              data-bs-toggle="modal" data-bs-target="#modal-agregar">Volver</button>
            <button type="submit" class="btn col-3 btn-agregarcita-modal x" data-bs-dismiss="modal"
              id="insertarServicio">Insertar</button>
          </div>

        </div>
      </form>

    </div>

  </div>
</div>
</div>






















































































<!-- Modal Agregar Insumo-->

<div class="modal fade" id="" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content agregar ">
      <div class="modal-header">
        <div class="fw-bolder d-flex" id="staticBackdropLabel">
          <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor"
            class="bi bi-capsule azul me-3" viewBox="0 0 16 16">
            <path
              d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
          </svg>
          <div>SELECCIONAR INSUMOS</div>
        </div>
        <a type="button" data-bs-dismiss="modal" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
              d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
          </svg>
        </a>
      </div>



      <div class="form-modal  mt-2">




        <!-- Buscador -->
        <div class="d-flex justify-content-end mt-1 mb-1">
          <div class="d-flex justify-content-end mb-4 col-6" id="">

            <a class="btn d-none" title="Buscar" id="restablecerTodosLosInsumos" uk-tooltip="Restablecer">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                <path
                  d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                <path fill-rule="evenodd"
                  d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
              </svg>
            </a>

            <input class="form-control input-busca" type="text" name="nombre" placeholder="Ingrese el nombre del insumo"
              id="buscadorDeTodosLosInsumos">
            <a class="btn boton-buscar" title="Buscar" id="">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search"
                viewBox="0 0 16 16">
                <path
                  d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
              </svg>
            </a>

          </div>
        </div>

        <div class="">


          <div class="caja_insumos_a_seleccionar">
            <?php foreach ($todosLosInsumos as $key): ?>
              <div data-index="<?= $key['nombre'] ?>" class="d-inline-block m-2 p-2 fw-bold insumo_no_seleccionado"><?= $key['nombre'] . "  Cantidad: " . $key['cantidad'] ?></div>
            <?php endforeach; ?>
          </div>


        </div>

        <div class="modal-footer">
          <button type="button" class="uk-button col-4 me-4 uk-button-default uk-modal-close btn-cerrar-modal"
            data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn col-3 btn-agregarcita-modal x d-none" id="btnModalInsumos1" data-bs-toggle="modal"
            data-bs-target="#modal-agregar-insumos-2">Siguiente</button>
        </div>
      </div>
    </div>




  </div>
</div>
</div>




<div class="modal fade" id="modal-agregar-insumos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content agregar ">
      <div class="modal-header">
        <div class="fw-bolder d-flex" id="staticBackdropLabel">
          <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor"
            class="bi bi-capsule azul me-3" viewBox="0 0 16 16">
            <path
              d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
          </svg>
          <div>SELECCIONAR INSUMOS</div>
        </div>
        <a type="button" data-bs-dismiss="modal" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
              d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
          </svg>
        </a>
      </div>



      <div class="form-modal  mt-2">




        <!-- Buscador -->
        <div class="d-flex justify-content-end mt-1 mb-1">
          <div class="d-flex justify-content-end mb-4 col-6" id="">

            <a class="btn d-none" title="Buscar" id="" uk-tooltip="Restablecer">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                <path
                  d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                <path fill-rule="evenodd"
                  d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
              </svg>
            </a>

            <input class="form-control input-busca" type="text" name="nombre" placeholder="Ingrese el nombre del insumo"
              id="inputBuscarI">
            <a class="btn boton-buscar" title="Buscar" id="">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search"
                viewBox="0 0 16 16">
                <path
                  d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
              </svg>
            </a>

          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-striped " id="tablaInsumos">
            <thead>
              <tr>
                <th class="d-none">
                  Id
                </th>
                <th class=" text-center">#</th>
                <th class=" text-center border-start">Nombre</th>
                <th class=" text-center border-start">Medida</th>
                <th class=" text-center border-start">Disponible</th>
                <th class=" text-center border-start">Precio</th>
                <!-- <th class=" text-center border-start">Lote</th> -->
                <th class=" text-center border-start">Cantidad</th>
                <th class=" text-center border-start">Añadir</th>

              </tr>
            </thead>
            <tbody id="cuerpoTablaInsumos" class="tbodyI">

              <?php if ($insumos): ?>
                <?php $contador = 1; ?>

                <?php foreach ($insumos as $i): ?>

                  <tr class="tr-desparecer-insumo ">
                    <td class="text-center fw-bold">
                      <?php echo $contador++; ?>
                    </td>
                    <td class="text-center border-start">
                      <?php echo $i['nombre']; ?>
                    </td>

                    <td class="text-center border-start">
                      <?php echo $i['medida']; ?>
                    </td>
                    <td class="text-center border-start cantidad_tabla_disponible<?= $i["nombre"] ?>">
                      <?php echo $i['cantidad_disponible']; ?>
                    </td>
                    <td class="text-center border-start">
                      <?php echo $i['precio'] ?> BS
                    </td>
                    <!-- <td class="text-center border-start">
                      <?php //echo $i['numero_de_lote']; 
                      ?>
                    </td> -->
                    <td class="text-center border-start">
                      <input type="number" class="form-control input-buscar m-auto inputs-cantidad-insumos">
                    </td>


                    <td class="border-start text-center  caja-boton">

                      <button class="btn btn-tabla mt-1 insertar_insumo d-none btn<?= $i['id_insumo']; ?>"
                        id="<?php echo $i['id_insumo']; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                          class="bi bi-check-square-fill" viewBox="0 0 16 16">
                          <path
                            d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z" />
                        </svg>
                      </button>

                    </td>

                    <td class="text-center border-start d-none">
                      <?php echo $i['cantidad']; ?>
                    </td>

                  </tr>
                <?php endforeach ?>






              <?php else: ?>


                <tr>
                  <td colspan="9" class="text-center">NO HAY REGISTROS

                  </td>
                </tr>
              <?php endif ?>



            </tbody>
          </table>

          <table class="table table-striped " style="margin-top: -16px;">
            <thead>

            </thead>
            <tbody>
              <tr class="d-none" id="noResultado">
                <td colspan="9" class="text-center">NO HAY REGISTROS

                </td>
              </tr>
            </tbody>

          </table>

          <div class="notifiI d-none">
            <p class="text-center mb-3">NO HAY REGISTROS</p>
          </div>


        </div>

        <div class="modal-footer">
          <button type="button" class="uk-button col-4 me-4 uk-button-default uk-modal-close btn-cerrar-modal"
            data-bs-toggle="modal" data-bs-target="#modal-agregar-insumos">Anterior</button>
          <button type="button" class="btn col-3 btn-agregarcita-modal x d-none" data-bs-toggle="modal"
            data-bs-target="#modal-agregar-insumos-confirmar" id="siguienteInsumo">Siguiente</button>
        </div>
      </div>
    </div>




  </div>
</div>
</div>




<div class="modal fade" id="modal-agregar-insumos-confirmar" data-bs-backdrop="static" data-bs-keyboard="false"
  tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content agregar" >
      <div class="modal-header">
        <div class="fw-bolder d-flex" id="staticBackdropLabel">
          <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor"
            class="bi bi-capsule azul me-3" viewBox="0 0 16 16">
            <path
              d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429l4.243 4.242Z" />
          </svg>
          <div>AÑADIR INSUMOS</div>
        </div>
        <a type="button" data-bs-dismiss="modal" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
              d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
          </svg>
        </a>
      </div>


      <form class="formularios-insumos">
        <div class="form-modal  mt-2">


          <div class="d-flex justify-content-end">





          </div>



          <div class="table-responsive">
            <table class="table table-striped ">
              <thead>
                <tr>
                  <th class="d-none">
                    Id
                  </th>
                  <th class=" text-center">#</th>
                  <th class=" text-center border-start">Nombre</th>
                  <th class=" text-center border-start">Medida</th>
                  <th class=" text-center border-start">Cantidad</th>
                  <th class=" text-center border-start">Precio</th>
                  <th class=" text-center border-start">Sub-total</th>
                  <th class=" text-center border-start">Acción</th>

                </tr>
              </thead>
              <tbody id="tbody_insumos">

                <!-- js -->



              </tbody>


            </table>



          </div>

          <div class="modal-footer">
            <button type="button" class="uk-button col-4 me-4 uk-button-default uk-modal-close btn-cerrar-modal"
              data-bs-toggle="modal" data-bs-target="#modal-agregar-insumos-2">Anterior</button>
            <button type="submit" class="btn col-3 btn-agregarcita-modal x" id="insertarInsumo"
              data-bs-dismiss="modal">Insertar</button>
          </div>
        </div>

      </form>
    </div>




  </div>
</div>
</div>









<!-- modal de tipo de pago -->


<div class="modal fade" id="modal-pago" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog tamaño-modal">
    <div class="modal-content agregar">
      <div class="modal-header">
        <div class="fw-bolder d-flex" id="staticBackdropLabel">
          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
            class="bi bi-cash-coin azul me-3 " viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z" />
            <path
              d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z" />
            <path
              d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z" />
            <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z" />
          </svg>
          <div>TIPOS DE PAGO</div>
        </div>
        <a type="button" data-bs-dismiss="modal" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
              d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
          </svg>
        </a>
      </div>


      <div class="form-modal">



        <?php foreach ($tiposDePagos as $pago): ?>
          <div class="form-check form-switch d-flex align-items-center">
            <div>
              <input class="form-check-input tiposDePago" type="checkbox" role="switch" id="flexSwitchCheckDefault"
                value="<?php echo $pago['0'] ?>">
            </div>
            <div><label class="form-check-label mt-2" for="flexSwitchCheckDefault">
                <?php echo $pago['1'] ?>
              </label></div>

          </div>
        <?php endforeach ?>



      </div>

      <div class="modal-footer">
        <button type="button" class="uk-button col-4 me-4 uk-button-default uk-modal-close btn-cerrar-modal"
          data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn col-3 btn-agregarcita-modal d-none" data-bs-dismiss="modal"
          id="btnTipoDePago">Siguiente</button>
      </div>

    </div>
  </div>
</div>






<!-- modal de validacion -->

<div class="modal fade" id="modal-validacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog tamaño-modal">
    <div class="modal-content agregar">
      <div class="modal-header">
        <div class="fw-bolder d-flex" id="staticBackdropLabel">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-check-all azul me-2 " viewBox="0 0 16 16">
            <path
              d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992a.252.252 0 0 1 .02-.022zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486-.943 1.179z" />
          </svg>
          <div class="mt-1"> VERIFICAR</div>
        </div>
        <a type="button" data-bs-dismiss="modal" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
              d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
          </svg>
        </a>
      </div>

      <div class="alert alert-primary p-1 text-center m-auto alerta-varios-metodos d-none" style="width: 96%;">La cantidad total de todos los campos tiene que ser equivalente al total y si alguno de los metodos de pago requiere referencia tambien es obligatoria</div>


      <div class="form-modal mt-2" id="inputCom">



        <label id="forma1"></label>
        <input type="number" class="form-control input-modal inputsDeValidacion" id="input1">

        <label id="forma2"></label>
        <input type="number" class="form-control input-modal inputsDeValidacion" id="input2">


        <label id="forma3"></label>
        <input type="number" class="form-control input-modal inputsDeValidacion d-none">

        <input type="text" class="form-control input-modal d-none" id="equivalenteDivisas"
          placeholder="Equivalente en Divisas">

        <input type="number" class="form-control input-modal d-none"
          uk-tooltip="Ingrese los 4 ultimos digitos de la referencia" id="referencia" placeholder="Referencia"
          maxlength="4" minlength="4"
          oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">


        <div>
          <p id="total-modal-validacion"></p>
          <input type="hidden" id="input-validacion-pago">
        </div>

      </div>





      <div class="modal-footer ">
        <button type="button" class="uk-button col-4 me-4 uk-button-default uk-modal-close btn-cerrar-modal"
          data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn col-3 btn-agregarcita-modal d-none suguiente" data-bs-toggle="modal"
          data-bs-target="#modal-confirmacion" id="btnValidacion">Siguiente</button>
      </div>

    </div>
  </div>
</div>





<!-- modal de confirmacion -->

<div class="modal fade" id="modal-confirmacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog tamaño-modal">
    <div class="modal-content agregar table-responsive">
      <div class="modal-header">
        <div class="fw-bolder d-flex" id="staticBackdropLabel">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
            class="bi bi-check-circle-fill azul me-2" viewBox="0 0 16 16">
            <path
              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
          </svg>CONFIRMAR OPERACIÓN
        </div>
        <a type="button" data-bs-dismiss="modal" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
              d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
          </svg>
        </a>
      </div>

      <?php if (isset($_GET["idH"])): ?>
        <form action="/Sistema-del--CEM--JEHOVA-RAFA/Factura/guardarFacturaHospit" method="POST" class="form-modal">
          <!-- este input va a guardar el id del usuario que inicie sesion para la bitacora -->
          <input type="hidden" id="id_usuario_bitacora" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario']; ?>">
        <?php else: ?>
          <form action="/Sistema-del--CEM--JEHOVA-RAFA/Factura/guardarFactura" method="POST" class="form-modal">
            <!-- este input va a guardar el id del usuario que inicie sesion para la bitacora -->
            <input type="hidden" id="id_usuario_bitacora" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario']; ?>">
          <?php endif; ?>
          <form action="/Sistema-del--CEM--JEHOVA-RAFA/Factura/guardarFactura" method="POST" class="form-modal">
            <!-- este input va a guardar el id del usuario que inicie sesion para la bitacora -->
            <input type="hidden" id="id_usuario_bitacora" name="id_usuario_bitacora" value="<?= $_SESSION['id_usuario']; ?>">

            <table class="table table-striped" id="tablaConfirmaroperacion">
              <thead>
                <tr>
                  <p class="fw-bolder mb-0 mt-2 border-bottom">SERVICIOS</p>
                </tr>
              </thead>
              <tbody style="font-size: 14px;" id="cuerpoTablaConfirmaroperacion">

                <!-- Código si contiene una 'h' -->
                <?php if (isset($parametro[0]) && stripos($parametro[0], 'c') !== false): ?>
                  <?php foreach ($citaFacturar as $datoCita): ?>
                    <tr>
                      <input type="hidden" name="servicios[]" value="<?= $datoCita['id_servicioMedico'] ?>">
                      <input type="text" class="d-none" id="inputPaciente" name="id_paciente"
                        value="<?= $datoCita['id_paciente'] ?>">
                      <input type="text" class="d-none"  name="id_paciente" value="<?= $datoCita['id_paciente'] ?>">
                      <input type="text" class="d-none"  name="id_cita" value="<?= $datoCita['id_cita'] ?>">
                      <td>
                        <div class="fw-bolder">CI:</div>
                        <?= $datoCita["cedula_p"]; ?>
                      </td>
                      <td>
                        <div class="fw-bolder">PACIENTE:</div>
                        <?= $datoCita["nombre_p"]; ?>
                        <?= $datoCita["apellido_p"]; ?>
                      </td>
                      <td>
                        <div class="fw-bolder">S/M:</div>
                        <?= $datoCita["especialidad"]; ?>
                      </td>
                      <td>
                        <div class="fw-bolder">FECHA:</div>
                        <?= $datoCita["fecha"]; ?>
                      </td>
                    </tr>
                  <?php endforeach ?>
                  
                <?php
                // Validar si el parámetro existe y si contiene una "h" (no distingue mayúsculas/minúsculas)
                elseif (isset($parametro[0]) && stripos($parametro[0], 'h') !== false) :
                ?>

                  <?php foreach ($hostalizacionFacturar as $hos): ?>

                    <tr>

                      <input type="hidden" class="d-none" name="id_hospitalizacion" value="<?= $hos['id_hospitalizacion'] ?>">
                      <input type="hidden" class="d-none" name="id_paciente" value="<?= $hos['id_paciente'] ?>">
                      <td>
                        <div class="fw-bolder">CI:</div>

                        <?= $hos["cedula"]; ?>
                      </td>
                      <td>
                        <div class="fw-bolder">PACIENTE:</div>
                        <?= $hos["nombre"]; ?>
                        <?= $hos["apellido"]; ?>
                      </td>
                    </tr>
                  <?php endforeach ?>
                  
                <?php else: ?>

                  <input type="hidden" class="" id="inputPaciente" name="id_paciente" value="">
                  <td class="no-cita"></td>
                  <td class="no-cita"> </td>
                <?php endif ?>
              </tbody>
            </table>
            <table class="table table-striped">
              <thead>

              </thead>
              <tbody id="tbodyDelModal" style="font-size: 14px;">

              </tbody>
            </table>
            <table class="table table-striped">
              <thead>
                <tr>
                  <p class="fw-bolder mb-0 mt-3 border-bottom">INSUMOS</p>
                </tr>
              </thead>
              <tbody style="font-size: 14px;" id="tbodyInsumos">
                <?php if (isset($parametro[0]) && stripos($parametro[0], 'h') !== false): ?>

                  <tr class="border-top tr">

                    <td class="border-top nombre">
                      <div class="fw-bolder">INSUMO:</div>
                      <?= $insumosHospitalizacion ?>
                    </td>


                    <td class="border-top"></td>


                  <tr>

                  <?php endif; ?>
              </tbody>
            </table>

            <div>
              <p class="fw-bolder mb-0 mt-2">TIPOS DE PAGO</p>
              <p id="pagosDeConfirmacion"></p>
              <p id="valorInput"></p>
              <p id="pagosDeConfirmacion2"></p>
              <p id="valorInput2"></p>
              <p id="pagosDeConfirmacion3"></p>
              <p id="valorInput3"></p>
              <p id="p_divisas"></p>
              <p id="p_referencia"></p>


              <p class="fw-bolder mb-0 mt-2">TOTAL</p>

              <div id="totalDeConfirmacion"></div>



              <input type="text" class="d-none" id="inputTotalDeConfirmacion" name="total">

              <div id="divInputPago">
                <input type="hidden" name="formasDePago[]">
                <input type="hidden">
                <input type="hidden">
              </div>

              <div id="divMontosPago">
                <input type="hidden" name="montosDePago[]">
                <input type="hidden">
                <input type="hidden">
              </div>

              <input type="hidden" id="referencia_confirmar" name="referencia">

            </div>




            <div class="modal-footer">
              <button type="button" class="uk-button col-4 me-4 uk-button-default uk-modal-close btn-cerrar-modal"
                data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn col-3 btn-agregarcita-modal">Confirmar</button>
            </div>

          </form>

    </div>
  </div>
</div>





</div>






<!-- registrar paciente desde la cita -->

<div id="modal-examplePaciente" uk-modal>
  <div class="uk-modal-dialog uk-modal-body tamaño-modal">
    <!-- Boton que cierra el modal -->
    <a href="#">
      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle uk-modal-close-default azul " viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
      </svg>
    </a>

    <div class="d-flex align-items-center mb-3">
      <div>
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-fill-add azul me-3 mb-3" viewBox="0 0 16 16">
          <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
          <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z" />
        </svg>
      </div>
      <div class="">
        <p class="uk-modal-title fs-5 ">
          Registrar Paciente
        </p>
      </div>

    </div>
    <div class="alert alert-danger d-none alertaFormulario" role="alert">
      <div class="">
        <p style="font-size: 13px;" class="text-center">Por favor, corrige los errores en el formulario.</p>
      </div>
    </div>

    <div class="alert alert-danger d-none alertaErrorCedula" role="alert">
      <div class="">
        <p style="font-size: 13px;" class="text-center">La cedula que intenta insertar ya esta registrada por favor inserte otra</p>
      </div>
    </div>

    <form class="form-modal form-validable form-ajax" id="modalAgregar" action="/Sistema-del--CEM--JEHOVA-RAFA/Pacientes/guardar" method="POST" autocomplete="off">
      <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario']; ?>">

      <div class="input-group flex-nowrap margin-inputs" id="grp_cedula">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-vcard-fill azul" viewBox="0 0 16 16">
            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
          </svg>
        </span>
        <span class="">
          <select class="form-control input-modal" aria-label="2" placeholder="Nacionalidad" name="nacionalidad">
            <option value="V" selected>V</option>
            <option value="E">E</option>
          </select>
        </span>

        <input class="form-control input-modal input-disabled input-paciente input-validar cedula-paciente" style="width: 7vh !important;" type="number" id="cedula" name="cedula" placeholder="Cedula" required maxlength="8" minlength="6" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
      </div>

      <p class="p-error-cedula d-none">La cedula debe contener únicamente números y estar entre 6 a 7 caracteres</p>

      <div class="input-group flex-nowrap margin-inputs" id="grp_nombre">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill azul" viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
          </svg>
        </span>

        <input class="form-control mayuscula input-modal input-disabled input-paciente input-validar" type="text" id="nombre" name="nombre" placeholder="Nombre" required maxlength="11">
      </div>

      <p class="p-error-nombre d-none">

        El Nombre debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres</p>

      <div class="input-group flex-nowrap margin-inputs" id="grp_apellido">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill azul" viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
          </svg>
        </span>
        <input class="form-control input-modal mayuscula input-disabled input-paciente input-validar" type="text" id="apellido" name="apellido" placeholder="Apellido" required maxlength="11">

      </div>

      <p class="p-error-apellido d-none">El Apellido debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres</p>

      <div class="input-group flex-nowrap margin-inputs" id="grp_telefono">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-telephone-fill azul" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
          </svg>
        </span>
        <input class="form-control input-modal input-disabled input-paciente input-validar" type="number" id="telefono" name="telefono" placeholder="Telefono" required maxlength="18">
      </div>
      <p class="p-error-telefono d-none">El Telefono solo debe contener y comen números, comenzando con "0412 o 0414 o 0416 o 0424 o 0426 o 0212 o 24"</p>

      <div class="input-group flex-nowrap margin-inputs" id="grp_direccion">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-card-heading azul" viewBox="0 0 16 16">
            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
            <path d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-1z" />
          </svg>
        </span>
        <input class="form-control  mayuscula input-modal input-disabled input-paciente input-validar" type="text" id="direccion" name="direccion" placeholder="Direccion" required maxlength="20">
      </div>
      <p class="p-error-direccion d-none">Debe estar completa y detallada</p>

      <label for="" class=" fw-bold mb-1 mt-2">Fecha de nacimiento</label>
      <div class="input-group flex-nowrap margin-inputs" id="grp_fn">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
            <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
          </svg>
        </span>
        <input class="form-control input-modal input-disabled input-paciente input-validar" type="date" id="fn" name="fn" placeholder="Fn" required pattern="\d{4}-\d{2}-\d{2}">
      </div>
      <p class="p-error-fn d-none">fecha no valida</p>


      <label for="" class=" fw-bold mb-1 mt-2">Genero</label>
      <div class="input-group flex-nowrap margin-inputs" id="grp_genero">
        <span class="input-modal mt-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-date-fill azul" viewBox="0 0 16 16">
            <path d="M9.402 10.246c.625 0 1.184-.484 1.184-1.18 0-.832-.527-1.23-1.16-1.23-.586 0-1.168.387-1.168 1.21 0 .817.543 1.2 1.144 1.2z" />
            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zm-4.118 9.79c1.258 0 2-1.067 2-2.872 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684c.047.64.594 1.406 1.703 1.406zm-2.89-5.435h-.633A12.6 12.6 0 0 0 4.5 8.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675V7.354z" />
          </svg>
        </span>
        <select name="genero" class="form-control input-modal input-validar" required id="">
          <option selected="" disabled>Seleccionar Genero</option>
          <option value="Masculino">Masculino</option>
          <option value="Femenino">Femenino</option>
        </select>
      </div>

      <div class="mt-3 uk-text-right">
        <button class="uk-button col-6 me-2 uk-button-default uk-modal-close btn-cerrar-modal" type="button">Cancelar</button>
        <button class="btn col-5 btn-agregarcita-modal" type="sumit" name="crear" id="botonEnviar">Agregar</button>
      </div>
    </form>
  </div>
</div>


<!-- Desde Aqui empieza los modales de emergencia -->