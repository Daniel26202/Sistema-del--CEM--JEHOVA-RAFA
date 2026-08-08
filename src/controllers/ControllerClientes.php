<?php

use App\models\Db;
use App\models\ModeloCliente;
use App\models\ModeloBitacora;
use App\models\Validator;

function Clientes($parametro)
{
    $db = new Db();
    $validator = new Validator();
    $modeloBitacora = new ModeloBitacora($db,$validator);
    $modeloCliente = new ModeloCliente($db, $validator);

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

    $db = new Db();
    $validator = new Validator();
    $modeloCliente = new ModeloCliente($db,$validator);

    $draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
    $inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
    $limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
    $buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';


    $columnasMapeadas = ['cedula', 'nombre', 'apellido', 'telefono', 'genero'];

    $colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
    $ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

    $ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_cliente';

    $data = $modeloCliente->index('ACT',$inicio, $limite, $buscar, $ordenColumna, $ordenDir);

    $respuesta = [
        "draw"            => $draw,
        "recordsTotal"    => (int)$data['total'],
        "recordsFiltered" => (int)$data['total_filtrado'],
        "data"            => $data['data']
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

    $db = new Db();
    $validator = new Validator();
    $modeloCliente = new ModeloCliente($db, $validator);

    $draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
    $inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
    $limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
    $buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';


    $columnasMapeadas = ['cedula', 'nombre', 'apellido', 'telefono', 'genero'];

    $colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
    $ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';


    $ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_cliente';

    $data = $modeloCliente->index('DES', $inicio, $limite, $buscar, $ordenColumna, $ordenDir);

    $respuesta = [
        "draw"            => $draw,
        "recordsTotal"    => (int)$data['total'],
        "recordsFiltered" => (int)$data['total_filtrado'],
        "data"            => $data['data']
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
        $idUsuario = $_SESSION['id_usuario'];
        $db = new Db();
        $validator = new Validator();
        $modeloCliente = new ModeloCliente($db, $validator);
        $modeloBitacora = new ModeloBitacora($db, $validator);

        $validator->set_session($_SESSION);
        $validator->set_id_usuario($idUsuario);

        $modeloCliente->setNacionalidad(isset($_POST['nacionalidad']) ? $_POST['nacionalidad'] : 'V');
        $modeloCliente->setCedula($_POST['cedula']);
        $modeloCliente->setNombre($_POST['nombre']);
        $modeloCliente->setApellido($_POST['apellido']);
        $modeloCliente->setTelefono($_POST['telefono']);
        $modeloCliente->setDireccion($_POST['direccion']);
        $modeloCliente->setFn($_POST['fn']);
        $modeloCliente->setGenero($_POST['genero']);

        $modeloBitacora->setId_usuario($idUsuario);
        $modeloBitacora->setActividad("Ha Insertado un nuevo cliente");
        $modeloBitacora->setTabla("cliente");

        $insercion = $modeloCliente->guardar($modeloCliente->get_all(), $validator);

        // Verifica si es un array con clave "exito"
        if (is_array($insercion)) {
            $modeloBitacora->guardar($modeloBitacora->get_all(), $validator);

            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion]);
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

function setCliente()
{
    if (empty($_POST)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error al realizar la peticion :("]);
        exit;
    }

    try {
        $idUsuario = $_SESSION['id_usuario'];
        $db = new Db();
        $validator = new Validator();
        $validator->set_session($_SESSION);
        $validator->set_id_usuario($idUsuario);
        $modeloCliente  = new ModeloCliente($db,$validator);
        $modeloBitacora = new ModeloBitacora($db, $validator);

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

        $modeloBitacora->setId_usuario($idUsuario);
        $modeloBitacora->setActividad("Ha modificado un cliente");
        $modeloBitacora->setTabla("cliente");

        $edicion = $modeloCliente->actualizar($modeloCliente->get_all(),['id_cliente'=>$modeloCliente->getIdCliente()],$validator);

        if (is_array($edicion)) {
            $modeloBitacora->guardar($modeloBitacora->get_all(), $validator);
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $edicion]);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}

function eliminar($datos)
{
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error al realizar la peticion :("]);
        exit;
    }

    try {
        $idUsuario  = $_SESSION['id_usuario'];
        $id_cliente = $datos[0];
        $db = new Db();
        $validator = new Validator();
        $validator->set_session($_SESSION);
        $validator->set_id_usuario($idUsuario);
        $modeloCliente  = new ModeloCliente($db, $validator);
        $modeloBitacora = new ModeloBitacora($db, $validator);

        $modeloCliente->setIdCliente($id_cliente);

        $modeloBitacora->setId_usuario($idUsuario);
        $modeloBitacora->setActividad("Ha eliminado un cliente");
        $modeloBitacora->setTabla("cliente");

        $eliminacion = $modeloCliente->actualizar(['estado'=>'DES'],['id_cliente'=>$modeloCliente->getIdCliente()],$validator);

        if (is_array($eliminacion)) {
            $modeloBitacora->guardar($modeloBitacora->get_all(), $validator);
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

function restablecer($datos)
{
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error al realizar la peticion :("]);
        exit;
    }

    try {
        $idUsuario  = $_SESSION['id_usuario'];
        $id_cliente = $datos[0];
        $db = new Db();
        $validator = new Validator();
        $validator->set_session($_SESSION);
        $validator->set_id_usuario($idUsuario);
        $modeloCliente  = new ModeloCliente($db, $validator);
        $modeloBitacora = new ModeloBitacora($db,$validator);

        $modeloCliente->setIdCliente($id_cliente);

        $modeloBitacora->setId_usuario($idUsuario);
        $modeloBitacora->setActividad("Ha restablecido un cliente");
        $modeloBitacora->setTabla("cliente");

        $restablecer = $modeloCliente->actualizar(['estado'=>'ACT'],['id_cliente'=>$modeloCliente->getIdCliente()], $validator);

        if (is_array($restablecer)) {
            $modeloBitacora->guardar($modeloBitacora->get_all(),$validator);
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $restablecer]);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}
