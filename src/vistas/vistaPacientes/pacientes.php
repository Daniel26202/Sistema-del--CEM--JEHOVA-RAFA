<?php require_once './src/vistas/head/head.php'; ?>



























<div class="container-fluid px-4">
  <div class="p-0 m-0 pb-3 d-flex justify-content-between">
    <h1 class="mt-4 mb-0">Pacientes <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
        class="bi bi-people-fill" viewBox="0 0 16 16">
        <path
          d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
      </svg></thead>
    </h1>



    <div class=" d-flex align-items-end">
      <div class="me-4 mt-0">

        <a><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-wrench-adjustable-circle azul" viewBox="0 0 16 16" id="desplegablePaciente">
            <path d="M12.496 8a4.491 4.491 0 0 1-1.703 3.526L9.497 8.5l2.959-1.11c.027.2.04.403.04.61Z" />
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0Zm-1 0a7 7 0 1 0-13.202 3.249l1.988-1.657a4.5 4.5 0 0 1 7.537-4.623L7.497 6.5l1 2.5 1.333 3.11c-.56.251-1.18.39-1.833.39a4.49 4.49 0 0 1-1.592-.29L4.747 14.2A7 7 0 0 0 15 8Zm-8.295.139a.25.25 0 0 0-.288-.376l-1.5.5.159.474.808-.27-.595.894a.25.25 0 0 0 .287.376l.808-.27-.595.894a.25.25 0 0 0 .287.376l1.5-.5-.159-.474-.808.27.596-.894a.25.25 0 0 0-.288-.376l-.808.27.596-.894Z" />
          </svg></a>
        <div class="uk-nav uk-dropdown-nav" uk-dropdown="pos: top-right" id="desplegable2">
          <ul>
            <li id="perfilPaciente"><a href="/Sistema-del--CEM--JEHOVA-RAFA/Perfil/perfil" class="uk-animation-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-fill azul uk-animation-scale-up" viewBox="0 0 16 16">
                  <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                </svg>PERFIL
              </a></li>
            <li class="uk-nav-divider"></li>
            <li><a href="#" id="btnayudaPaciente"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
                  <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM5.496 6.033a.237.237 0 0 1-.24-.247C5.35 4.091 6.737 3.5 8.005 3.5c1.396 0 2.672.73 2.672 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.105a.25.25 0 0 1-.25.25h-.81a.25.25 0 0 1-.25-.246l-.004-.217c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.803 0-1.253.478-1.342 1.134-.018.137-.128.25-.266.25h-.825zm2.325 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                </svg>AYUDA</a></li>
            <li class="uk-nav-divider"></li>
            <li><a href="?c=ControladorBitacora/bitacora"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-question-octagon-fill azul me-1" viewBox="0 0 16 16">
                  <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z" />
                </svg> CONFIGURACIÓN</a></li>
            <li class="uk-nav-divider"></li>

            <li><a href="#" data-bs-toggle="modal" data-bs-target="#eliminar">
                <img src="./src/assets/img/icono-cerrar-sesion.svg" width="34" height="34" uk-svg class="azul" style="margin-left: -4px;">
                </svg>SALIR</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 caja-boton">

  <button class="btn-guardar-responsive  btn btn-primary btn-agregar-doctores col-8" uk-toggle="target: #modal-examplePaciente" id="">
        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-bandaid-fill me-1" viewBox="0 0 16 16">
          <path d="m2.68 7.676 6.49-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Zm5.71-2.858a.5.5 0 1 0-.708.707.5.5 0 0 0 .707-.707ZM6.974 6.939a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707ZM5.56 8.354a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm2.828 2.828a.5.5 0 1 0-.707-.707.5.5 0 0 0 .707.707Zm1.414-2.121a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.706-.708.5.5 0 0 0 .707.708Zm-4.242.707a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707Zm1.414-.707a.5.5 0 1 0-.707-.708.5.5 0 0 0 .707.708Zm1.414-2.122a.5.5 0 1 0-.707.707.5.5 0 0 0 .707-.707ZM8.646 3.354l4 4 .708-.708-4-4-.708.708Zm-1.292 9.292-4-4-.708.708 4 4 .708-.708Z"></path>
        </svg>Registrar Patologia
      </button>
    
  </div>


  <table class="example table-clinic">
    <thead>
      <tr>
        <th>First name</th>
        <th>Last name</th>
        <th>Position</th>
        <th>Office</th>
        <th>Salary</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Olivia</td>
        <td>Liang</td>
        <td>Support Engineer</td>
        <td>Singapore</td>
        <td>234500</td>
      </tr>
      <tr>
        <td>Bruno</td>
        <td>Nash</td>
        <td>Software Engineer</td>
        <td>London</td>
        <td>163500</td>
      </tr>
      <tr>
        <td>Sakura</td>
        <td>Yamamoto</td>
        <td>Support Engineer</td>
        <td>Tokyo</td>
        <td>139575</td>
      </tr>
      <tr>
        <td>Thor</td>
        <td>Walton</td>
        <td>Developer</td>
        <td>New York</td>
        <td>98540</td>
      </tr>
      <tr>
        <td>Finn</td>
        <td>Camacho</td>
        <td>Support Engineer</td>
        <td>San Francisco</td>
        <td>87500</td>
      </tr>
      <tr>
        <td>Serge</td>
        <td>Baldwin</td>
        <td>Data Coordinator</td>
        <td>Singapore</td>
        <td>138575</td>
      </tr>
      <tr>
        <td>Zenaida</td>
        <td>Frank</td>
        <td>Software Engineer</td>
        <td>New York</td>
        <td>125250</td>
      </tr>
      <tr>
        <td>Zorita</td>
        <td>Serrano</td>
        <td>Software Engineer</td>
        <td>San Francisco</td>
        <td>115000</td>
      </tr>
      <tr>
        <td>Jennifer</td>
        <td>Acosta</td>
        <td>Junior Javascript Developer</td>
        <td>Edinburgh</td>
        <td>75650</td>
      </tr>
      <tr>
        <td>Cara</td>
        <td>Stevens</td>
        <td>Sales Assistant</td>
        <td>New York</td>
        <td>145600</td>
      </tr>
      <tr>
        <td>Hermione</td>
        <td>Butler</td>
        <td>Regional Director</td>
        <td>London</td>
        <td>356250</td>
      </tr>
      <tr>
        <td>Lael</td>
        <td>Greer</td>
        <td>Systems Administrator</td>
        <td>London</td>
        <td>103500</td>
      </tr>
      <tr>
        <td>Jonas</td>
        <td>Alexander</td>
        <td>Developer</td>
        <td>San Francisco</td>
        <td>86500</td>
      </tr>
      <tr>
        <td>Shad</td>
        <td>Decker</td>
        <td>Regional Director</td>
        <td>Edinburgh</td>
        <td>183000</td>
      </tr>
      <tr>
        <td>Michael</td>
        <td>Bruce</td>
        <td>Javascript Developer</td>
        <td>Singapore</td>
        <td>183000</td>
      </tr>
      <tr>
        <td>Donna</td>
        <td>Snider</td>
        <td>Customer Support</td>
        <td>New York</td>
        <td>112000</td>
      </tr>
    </tbody>
  </table>
</div>

<?php require_once 'modalPaciente.php'; ?>


<script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/validacionesPacientesRegistrar.js"></script>
<script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/buscadorPaciente.js"></script>
<script type="text/javascript" src="<?= $urlBase; ?>../src/assets/js/ayudaPaciente.js"></script>




<?php require_once './src/vistas/head/footer.php'; ?>

<script>
  $(document).ready(function() {
    $('#example').DataTable({
      "pagingType": "full_numbers",
      "language": {
        "search": "Buscar:",
        "paginate": {
          "first": "Primero",
          "last": "Último",
          "next": "Siguiente",
          "previous": "Anterior"
        },
        "info": "",
        "infoEmpty": "",
        "lengthMenu": "Mostrar _MENU_ entradas",
        "zeroRecords": "No se encontraron resultados",
        "infoFiltered": "(filtrado de _MAX_ registros totales)"
      }
    });
  });
</script>