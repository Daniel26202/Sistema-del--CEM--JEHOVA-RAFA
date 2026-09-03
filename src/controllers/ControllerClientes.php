<?php

use App\modelos\ModeloCliente;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloSanetizarJSON;
// use App\

function Clientes($parametro)
{
    $modeloBitacora = new ModeloBitacora();
    $modeloCliente = new ModeloCliente();

    $ayuda = "btnayudaPaciente";
    $vistaActiva = 'clientes';
    require_once __DIR__ . "/../../src/vistas/vistaCliente/vistaCliente.php";
}


// Modifica la función clientesAjax() en ControllerClientes.php para que quede así:
function clientesAjax()
{
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error al realizar la peticion :("]);
        exit;
    }

    $draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
    $inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
    $limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
    $buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';


    $columnasMapeadas = ['cedula', 'nombre', 'apellido', 'telefono', 'genero'];

    $colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
    $ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';


    $ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_cliente';

    $modeloCliente = new ModeloCliente();
    $sanitizador = new ModeloSanetizarJSON();

    if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
        $ordenColumna = 'id_paciente';
    }

    $clientes = $modeloCliente->index($inicio, $limite, $buscar, $ordenColumna, $ordenDir);

    $totalRegistros = $modeloCliente->contarTotalClientes('ACT');
    $totalFiltrados = !empty($buscar) ? $modeloCliente->contarTotalClientes('ACT', $buscar) : $totalRegistros;

    $respuesta = [
        "draw"            => $draw,
        "recordsTotal"    => (int)$totalRegistros,
        "recordsFiltered" => (int)$totalFiltrados,
        "data"            => $clientes
    ];

    echo json_encode($respuesta);
    exit;
}

function papelera($parametro)
{
    $vistaActiva = 'papelera';
    require_once __DIR__ . "/../../src/vistas/vistaCliente/vistaCliente.php";
}

function papeleraAjax()
{
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error al realizar la peticion :("]);
        exit;
    }

    $draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
    $inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
    $limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
    $buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';


    $columnasMapeadas = ['cedula', 'nombre', 'apellido', 'telefono', 'genero'];

    $colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
    $ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';


    $ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_cliente';

    $modeloCliente = new ModeloCliente();
    $sanitizador = new ModeloSanetizarJSON();

    if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
        $ordenColumna = 'id_paciente';
    }

    $clientes = $modeloCliente->indexPapelera($inicio, $limite, $buscar, $ordenColumna, $ordenDir);

    $totalRegistros = $modeloCliente->contarTotalClientes('DES');
    $totalFiltrados = !empty($buscar) ? $modeloCliente->contarTotalClientes('DES', $buscar) : $totalRegistros;

    $respuesta = [
        "draw"            => $draw,
        "recordsTotal"    => (int)$totalRegistros,
        "recordsFiltered" => (int)$totalFiltrados,
        "data"            => $clientes
    ];

    echo json_encode($respuesta);
    exit;
}

function guardar()
{
    if (empty($_POST)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }

    try {

        $headers = getallheaders();
        $csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;

        if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
            http_response_code(403);
            echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
            exit;
        }

        $idUsuario = $_SESSION['id_usuario'];
        $modeloCliente = new ModeloCliente();
        $modeloBitacora = new ModeloBitacora();

        $modeloCliente->setNacionalidad(isset($_POST['nacionalidad']) ? $_POST['nacionalidad'] : 'V');
        $modeloCliente->setCedula($_POST['cedula']);
        $modeloCliente->setNombre($_POST['nombre']);
        $modeloCliente->setApellido($_POST['apellido']);
        $modeloCliente->setTelefono($_POST['telefono']);
        $modeloCliente->setDireccion($_POST['direccion']);
        $modeloCliente->setFn($_POST['fn']);
        $modeloCliente->setGenero($_POST['genero']);

        $insercion = $modeloCliente->guardarCliente($idUsuario);

        // Verifica si es un array con clave "exito"
        if (is_array($insercion) && $insercion[0] === "exito") {
            $modeloBitacora->setId_usuario($idUsuario);
            $modeloBitacora->setActividad("Ha Insertado un nuevo cliente");
            $modeloBitacora->setTabla("cliente");
            $modeloBitacora->insertarBitacora($idUsuario);
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
        } else {
            if (is_string($insercion)) {
                http_response_code(409);
                echo json_encode(['ok' => false, 'error' => $insercion]);
            } else {
                http_response_code(409);
                error_log("Error en guardar: " . print_r($insercion, true));
                echo json_encode(['ok' => false, 'error' => 'Error al guardar el cliente.']);
                exit;
            }
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}

function setCliente()
{
    if (empty($_POST)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error al realizar la peticion :("]);
        exit;
    }

    try {

        $headers = getallheaders();
        $csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;

        if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
            http_response_code(403);
            echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
            exit;
        }

        $idUsuario = $_SESSION['id_usuario'];
        $modeloCliente  = new ModeloCliente();
        $modeloBitacora = new ModeloBitacora();

        $modeloCliente->setIdCliente($_POST['id']);
        $modeloCliente->setNacionalidad(isset($_POST['nacionalidad']) ? $_POST['nacionalidad'] : 'V');
        $modeloCliente->setCedula($_POST['cedula']);
        $modeloCliente->setCedulaRegistrada($_POST['cedulaRegistrada']);
        $modeloCliente->setNombre($_POST['nombre']);
        $modeloCliente->setApellido($_POST['apellido']);
        $modeloCliente->setTelefono($_POST['telefono']);
        $modeloCliente->setDireccion($_POST['direccion']);
        $modeloCliente->setFn($_POST['fn']);
        $modeloCliente->setGenero($_POST['genero']);

        $edicion = $modeloCliente->editarCliente($idUsuario);

        if (is_array($edicion) && $edicion[0] === "exito") {
            $modeloBitacora->setId_usuario($idUsuario);
            $modeloBitacora->setActividad("Ha modificado un cliente");
            $modeloBitacora->setTabla("cliente");
            $modeloBitacora->insertarBitacora($idUsuario);
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            if (is_string($edicion)) {
                http_response_code(409);
                echo json_encode(['ok' => false, 'error' => $edicion]);
            } else {
                http_response_code(409);
                error_log("Error en setCliente: " . print_r($edicion, true));
                echo json_encode(['ok' => false, 'error' => 'Error al editar el cliente.']);
                exit;
            }
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}

function eliminar()
{
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error al realizar la peticion :("]);
        exit;
    }

    try {
        $headers = getallheaders();
        $csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;

        if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
            http_response_code(403);
            echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
            exit;
        }

        $idUsuario  = $_SESSION['id_usuario'];
        $input = json_decode(file_get_contents("php://input"), true);
        $id = $input["id"] ?? null;

        $estado = empty($input["estado"]) ? 'DES' : 'ACT';
        $text = empty($input["estado"]) ? 'eliminado' : 'restablecido';
        $text_error = empty($input["estado"]) ? 'eliminar' : 'restablecer';

        $modeloCliente  = new ModeloCliente();
        $modeloBitacora = new ModeloBitacora();

        $modeloCliente->setIdCliente($id);

        $eliminacion = $modeloCliente->eliminarCliente($idUsuario, $estado);

        if (is_array($eliminacion) && $eliminacion[0] === "exito") {
            $modeloBitacora->setId_usuario($idUsuario);
            $modeloBitacora->setActividad("Ha {$text} un cliente");
            $modeloBitacora->setTabla("cliente");
            $modeloBitacora->insertarBitacora($idUsuario);
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            if (is_string($eliminacion)) {
                http_response_code(409);
                echo json_encode(['ok' => false, 'error' => $eliminacion]);
            } else {
                http_response_code(409);
                error_log("Error en eliminarCliente: " . print_r($eliminacion, true));
                echo json_encode(['ok' => false, 'error' => 'Error al ' . $text_error . ' el cliente.']);
                exit;
            }
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}
