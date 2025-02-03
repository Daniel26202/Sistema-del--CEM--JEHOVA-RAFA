<!-- prueba -->





<!-- Modal Agregar Servicio Extra-->
<div class="modal fade" id="modal-agregar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog tamaño-modal">
    <div class="modal-content">
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



        <div class="">
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

                      <button class="btn btn-tabla mt-1 insertar_servicio" id="<?php echo $e['id_servicioMedico']; ?>"
                        data-bs-toggle="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-app"
                          viewBox="0 0 16 16">
                          <path
                            d="M11 2a3 3 0 0 1 3 3v6a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3V5a3 3 0 0 1 3-3h6zM5 1a4 4 0 0 0-4 4v6a4 4 0 0 0 4 4h6a4 4 0 0 0 4-4V5a4 4 0 0 0-4-4H5z" />
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
    <div class="modal-content">
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



          <div class="">
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
<div class="modal fade" id="modal-agregar-insumos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content tamaño-modal-Seleccionar-Insumo">
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

        <div class="">
          <table class="table table-striped " id="tablaInsumos">
            <thead>
              <tr>
                <th class="d-none">
                  Id
                </th>
                <th class=" text-center">#</th>
                <th class=" text-center border-start">Nombre</th>
                <th class=" text-center border-start">Disponible</th>
                <th class=" text-center border-start">Precio</th>
                <th class=" text-center border-start">Lote</th>
                <th class=" text-center border-start">Cantidad</th>
                <th class=" text-center border-start">Añadir</th>

              </tr>
            </thead>
            <tbody id="cuerpoTablaInsumos" class="tbodyI">

              <?php if ($insumos): ?>
                <?php $contador = 1; ?>

                <?php foreach ($insumos as $i): ?>

                  <tr class="tr-desparecer-insumo">
                    <td class="text-center fw-bold">
                      <?php echo $contador++; ?>
                    </td>



                    <td class="text-center border-start">
                      <?php echo $i['nombre']; ?>
                    </td>
                    <td class="text-center border-start">
                      <?php echo $i['cantidad_inventario']; ?>
                    </td>
                    <td class="text-center border-start">
                      <?php echo $i['precio'] ?> BS
                    </td>
                    <td class="text-center border-start">
                      <?php echo $i['numero_de_lote']; ?>
                    </td>
                    <td class="text-center border-start">
                      <input type="number" class="form-control input-buscar m-auto inputs-cantidad-insumos">
                    </td>


                    <td class="border-start text-center  caja-boton">

                      <button class="btn btn-tabla mt-1 insertar_insumo d-none btn<?= $i['id_inventario']; ?>"
                        id="<?php echo $i['id_inventario']; ?>">
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
            data-bs-dismiss="modal">Cancelar</button>
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
    <div class="modal-content">
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



          <div class="">
            <table class="table table-striped ">
              <thead>
                <tr>
                  <th class="d-none">
                    Id
                  </th>
                  <th class=" text-center">#</th>
                  <th class=" text-center border-start">Nombre</th>
                  <th class=" text-center border-start">Cantidad</th>
                  <th class=" text-center border-start">Precio</th>
                  <th class=" text-center border-start">Lote</th>
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
              data-bs-toggle="modal" data-bs-target="#modal-agregar-insumos">Volver</button>
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
    <div class="modal-content">
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
    <div class="modal-content">
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

      </div>

      <div class="modal-footer">
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
    <div class="modal-content">
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
        <form action="?c=controladorFactura/guardarFacturaHospit" method="POST" class="form-modal">
        <?php else: ?>
          <form action="?c=controladorFactura/guardarFactura" method="POST" class="form-modal">
          <?php endif; ?>
          <form action="?c=controladorFactura/guardarFactura" method="POST" class="form-modal">

            <table class="table table-striped" id="tablaConfirmaroperacion">
              <thead>
                <tr>
                  <p class="fw-bolder mb-0 mt-2 border-bottom">SERVICIOS</p>
                </tr>
              </thead>
              <tbody style="font-size: 14px;" id="cuerpoTablaConfirmaroperacion">
                <?php if (isset($_GET["id_cita"])): ?>
                  
                  <?php foreach ($citaFacturar as $datoCita): ?>
                    <tr>
                      <input type="hidden" name="servicios[]" value="<?= $datoCita['id_servicioMedico'] ?>">
                      <input type="text" class="d-none" id="inputPaciente" name="id_paciente"
                        value="<?= $datoCita['id_paciente'] ?>">
                      <input type="text" class="d-none" name="id_cita" value="<?= $datoCita['id_cita'] ?>">
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

                  <!-- condicional de la hospitalizacion  -->
                <?php elseif (isset($_GET["idH"])): ?>




                  <?php foreach ($hospitalizacionFacturar as $hos): ?>

                    <tr>

                      <input type="text" class="d-none" name="id_hospitalizacion" value="<?= $hos['id_hospitalizacion'] ?>">
                      <td>
                        <div class="fw-bolder">CI:</div>

                        <?= $hos["cedula"]; ?>
                      </td>
                      <td>
                        <div class="fw-bolder">PACIENTE:</div>
                        <?= $hos["nombre"]; ?>
                        <?= $hos["apellido"]; ?>
                      </td>
                      <td>
                        <div class="fw-bolder">DIAGNOSTICO:</div>
                        <?= $hos["diagnostico"]; ?>
                      </td>
                      <td>
                        <div class="fw-bolder">HORAS:</div>
                        <?= $hos["duracion"]; ?>
                      </td>
                      <td>
                        <div class="fw-bolder">PRECIO:</div>
                        <?= $hos["precio_horas"] * $hos["duracion"] . " BS"; ?>
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
                <?php if (isset($_GET["idH"])): ?>
                  <?php foreach ($hospitalizacionInsumos as $ins): ?>
                    <tr class="border-top tr">
                      <th class="id_insumo_escondido d-none">
                        <input type="hidden" name="insumosHospi[]" value="<?= $ins["id_insumo"] ?>">
                        <?= $ins["id_insumo"] ?>
                      </th>
                      <td class="border-top nombre">
                        <div class="fw-bolder">INSUMO:</div>
                        <?= $ins["nombre"] ?>
                      </td>
                      <td class="border-top">
                        <input type="hidden" name="cantidadInsumosHospi[]" value="<?= $ins["cantidad_insumo_hospit"] ?>">
                        <div class="fw-bolder">CANTIDAD:</div>
                        <?= $ins["cantidad_insumo_hospit"] ?>
                      </td>
                      <td class="border-top">
                        <div class="fw-bolder">PRECIO:</div>
                        <?= $ins["precio"] ?> BS
                      </td>
                      <td class="border-top">
                        <div class="fw-bolder">SUB-TOTAL:</div>
                        <?= $ins["precio"] * $ins["cantidad_insumo_hospit"] ?> BS
                      </td>
                      <td class="border-top"></td>


                    <tr>
                    <?php endforeach; ?>
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



<!-- Desde Aqui empieza los modales de emergencia -->