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
        // RATE LIMIT: 5 peticiones cada 1 segundos
        $limiter = new RateLimiter();
        $limiter->verificar('guardar_cliente_' . $idUsuario, 5, 1);

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
        $modeloBitacora->setId_usuario($_POST['id_usuario']);
        $modeloBitacora->setActividad("Ha Insertado un nuevo cliente");
        $modeloBitacora->setTabla("cliente");

        $insercion = $modeloCliente->insertar();

        // Verifica si es un array con clave "exito"
        if (is_array($insercion) && $insercion[0] === "exito") {
            $modeloBitacora->insertarBitacora();
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
        // RATE LIMIT: 5 peticiones cada 1 segundos
        $limiter = new RateLimiter();
        $limiter->verificar('editar_cliente_' . $idUsuario, 5, 1);

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

        $modeloBitacora->setId_usuario($_POST['id_usuario']);
        $modeloBitacora->setActividad("Ha modificado un cliente");
        $modeloBitacora->setTabla("cliente");
        $edicion = $modeloCliente->update_cliente();

        // echo json_encode($modeloCliente->getIdCliente());

        // Verifica si es un array con clave "exito"
        if (is_array($edicion) && $edicion[0] === "exito") {
            $modeloBitacora->insertarBitacora();
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
        // RATE LIMIT: 5 peticiones cada 1 segundos
        $limiter = new RateLimiter();
        $limiter->verificar('eliminar_cliente_' . $idUsuario, 5, 1);

        $id_cliente = $datos[0];
        $id_usuario = $datos[1];

        $modeloCliente = new ModeloCliente();
        $modeloBitacora = new ModeloBitacora();

        $modeloCliente->setIdCliente($id_cliente);

        $modeloBitacora->setId_usuario($id_usuario);
        $modeloBitacora->setActividad("Ha eliminado un cliente");
        $modeloBitacora->setTabla("cliente");

        $eliminacion = $modeloCliente->deleteC();

        if (is_array($eliminacion) && $eliminacion[0] === "exito") {
            $modeloBitacora->insertarBitacora();
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
        // RATE LIMIT: 5 peticiones cada 1 segundos
        $limiter = new RateLimiter();
        $limiter->verificar('restablecer_cliente_' . $idUsuario, 5, 1);

        $id_cliente = $datos[0];
        $id_usuario = $datos[1];

        $modeloCliente = new ModeloCliente();
        $modeloBitacora = new ModeloBitacora();

        $modeloCliente->setIdCliente($id_cliente);

        $modeloBitacora->setId_usuario($id_usuario);
        $modeloBitacora->setActividad("Ha restablecido un cliente");
        $modeloBitacora->setTabla("cliente");

        $restablecer = $modeloCliente->restablecer();

        if (is_array($restablecer) && $restablecer[0] === "exito") {
            $modeloBitacora->insertarBitacora();
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
