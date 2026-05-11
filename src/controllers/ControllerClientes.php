<?php

use App\modelos\ModeloCliente;
use App\modelos\ModeloBitacora;
use App\config\RateLimiter;
// use App\

function Clientes($parametro)
{
    $modeloBitacora = new ModeloBitacora();
    $modeloCliente = new ModeloCliente();

    $ayuda = "btnayudaPaciente";
    $vistaActiva = 'clientes';
    require_once __DIR__ . "/../../src/vistas/vistaCliente/vistaCliente.php";
}


function clientesAjax()
{
    $modeloCliente = new ModeloCliente();

    echo json_encode($modeloCliente->index());
}


function papelera($parametro)
{
    $vistaActiva = 'papelera';
    require_once __DIR__ . "/../../src/vistas/vistaCliente/vistaCliente.php";
}

function papeleraAjax()
{
    $modeloCliente = new ModeloCliente();

    echo json_encode($modeloCliente->indexPapelera());
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
    try {
        $idUsuario = $_SESSION['id_usuario'];
        $modeloCliente = new ModeloCliente();
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

        // Verifica si es un array con clave "exito"
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
    try {
        $idUsuario = $_SESSION['id_usuario'];
        $id_cliente = $datos[0];
        $modeloCliente = new ModeloCliente();
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
    try {
        $idUsuario = $_SESSION['id_usuario'];
        $id_cliente = $datos[0];
        $modeloCliente = new ModeloCliente();
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
