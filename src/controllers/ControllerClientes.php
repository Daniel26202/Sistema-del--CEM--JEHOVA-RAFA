<?php

use App\modelos\ModeloCliente;
use App\modelos\ModeloBitacora;
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

        $modeloBitacora->setId_usuario($idUsuario);
        $modeloBitacora->setActividad("Ha Insertado un nuevo cliente");
        $modeloBitacora->setTabla("cliente");

        $insercion = $modeloCliente->guardarCliente($idUsuario);

        // Verifica si es un array con clave "exito"
        if (is_array($insercion) && $insercion[0] === "exito") {
            $modeloBitacora->insertarBitacora($idUsuario);
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

function setCliente()
{
    if (empty($_POST)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error al realizar la peticion :("]);
        exit;
    }

    try {
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

        $modeloBitacora->setId_usuario($idUsuario);
        $modeloBitacora->setActividad("Ha modificado un cliente");
        $modeloBitacora->setTabla("cliente");

        $edicion = $modeloCliente->editarCliente($idUsuario);

        if (is_array($edicion) && $edicion[0] === "exito") {
            $modeloBitacora->insertarBitacora($idUsuario);
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
        $modeloCliente  = new ModeloCliente();
        $modeloBitacora = new ModeloBitacora();

        $modeloCliente->setIdCliente($id_cliente);

        $modeloBitacora->setId_usuario($idUsuario);
        $modeloBitacora->setActividad("Ha eliminado un cliente");
        $modeloBitacora->setTabla("cliente");

        $eliminacion = $modeloCliente->eliminarCliente($idUsuario);

        if (is_array($eliminacion) && $eliminacion[0] === "exito") {
            $modeloBitacora->insertarBitacora($idUsuario);
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
        $modeloCliente  = new ModeloCliente();
        $modeloBitacora = new ModeloBitacora();

        $modeloCliente->setIdCliente($id_cliente);

        $modeloBitacora->setId_usuario($idUsuario);
        $modeloBitacora->setActividad("Ha restablecido un cliente");
        $modeloBitacora->setTabla("cliente");

        $restablecer = $modeloCliente->restablecerCliente($idUsuario);

        if (is_array($restablecer) && $restablecer[0] === "exito") {
            $modeloBitacora->insertarBitacora($idUsuario);
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
