<?php

use App\modelos\ModeloPermisos;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloSanetizarJSON;

function validarCsrfPermisos()
{
    $headers = function_exists('getallheaders') ? getallheaders() : [];
    $csrfToken = $headers['X-CSRF-Token']
        ?? $headers['x-csrf-token']
        ?? $_POST['csrf_token']
        ?? null;

    if (empty($_SESSION['csrf_token']) || empty($csrfToken) || !hash_equals($_SESSION['csrf_token'], $csrfToken)) {
        http_response_code(403);
        echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
        exit;
    }
}

// use App\config\RateLimiter;


////modulos/////
function returnModules()
{
    $draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
    $inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
    $limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
    $buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

    $columnasMapeadas = ['id_patologia', 'nombre_patologia'];

    $colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
    $ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';


    $ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_modulo';

    $model = new ModeloPermisos();
    $sanitizador = new ModeloSanetizarJSON();

    if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
        $ordenColumna = 'id_modulo';
    }

    $data = $sanitizador->sanitizeRecursive($model->returnModulesPaginados($inicio, $limite, $buscar, $ordenColumna, $ordenDir));
    $totalRegistros = $model->contarTotal();
    $totalFiltrados = !empty($buscar) ? $model->contarTotal($buscar) : $totalRegistros;
    echo json_encode([
        "draw"            => $draw,
        "recordsTotal"    => (int)$totalRegistros,
        "recordsFiltered" => (int)$totalFiltrados,
        "data"            => is_array($data) ? $data : []
    ]);
    exit;
}

function returnPermisionModule()  {
    $module = new ModeloPermisos();

    $result =[];
    foreach ($module->returnModules() as $module) {
        $result[]=[
            'modulo'=>$module['nombre'],
            'permisosPorModulo'=>'permisos'. $module['nombre'],
        ];
    }
    echo json_encode($result);
}


function hasPermision($data)
{
    $idRol = $_SESSION['id_rol'] ?? null;
    $modulo = $data[1] ?? null;
    $permiso = $data[2] ?? null;

    if (empty($idRol) || empty($modulo) || empty($permiso)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }
    try {
        $model = new ModeloPermisos();
        // Nunca confiar en el rol recibido por URL para consultar permisos.
        $model->setIdRol($idRol);
        $model->setModulo($modulo);
        $model->setPermiso($permiso);
        $id_modulo = $model->returnIdModule();
        if (!$id_modulo) {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
            exit;
        }
        $model->setIdModulo($id_modulo);

        echo json_encode($model->gestionarPermisos());
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}


function registrarModulo()
{
    if (empty($_POST)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }

    try {
        validarCsrfPermisos();

        $idUsuario = $_SESSION['id_usuario'];
        // RATE LIMIT: 5 peticiones cada 1 segundos
        // $limiter = new RateLimiter();
        // $limiter->verificar('guardar_modulo_' . $idUsuario, 5, 1);

        $modulo = new ModeloPermisos();
        $bitacora = new ModeloBitacora();

        $modulo->setModulo($_POST["nombre"]);

        $insercion = $modulo->registrarModulo();

        if (is_array($insercion) && $insercion[0] === "exito") {
            $bitacora->setId_usuario($idUsuario);
            $bitacora->setActividad("Ha Insertado un nuevo  modulo");
            $bitacora->setTabla("modulo");
            $bitacora->insertarBitacora();
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $insercion]);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}


function eliminar_modulo($datos)
{
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }

    try {
        validarCsrfPermisos();

        $idUsuario = $_SESSION['id_usuario'];
        // RATE LIMIT: 5 peticiones cada 1 segundos
        // $limiter = new RateLimiter();
        // $limiter->verificar('eliminar_paciente_' . $idUsuario, 5, 1);

        $modelo  = new ModeloPermisos();
        $bitacora = new ModeloBitacora();

        $modelo->setIdModulo($datos[0]);

        $bitacora->setId_usuario($idUsuario);
        $bitacora->setActividad("Ha eliminado un  modulo del sistema");
        $bitacora->setTabla("modulo");

        $eliminacion = $modelo->delete_modulo();

        //Verifica si es un array con clave "exito"
        if (is_array($eliminacion) && $eliminacion[0] === "exito") {
            $bitacora->insertarBitacora();
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $eliminacion]);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}
