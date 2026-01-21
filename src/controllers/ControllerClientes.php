<?php

use App\modelos\ModeloCliente;
use App\modelos\ModeloBitacora;
// use App\

function returnObjectClass()
{
    return [
        'bitacora' => new ModeloBitacora(),
        'cliente' => new ModeloCliente()
    ];
}


function Clientes($parametro)
{
    $ayuda = "btnayudaPaciente";
    $vistaActiva = 'clientes';
    require_once __DIR__ . "/../../src/vistas/vistaCliente/vistaCliente.php";
}


function clientesAjax()
{
    echo json_encode(returnObjectClass()['cliente']->index());
}


function papelera($parametro)
{
    $vistaActiva = 'papelera';
    require_once __DIR__ . "/../../src/vistas/vistaCliente/vistaCliente.php";
}

function papeleraAjax()
{
    echo json_encode(returnObjectClass()['cliente']->indexPapelera());
}



function guardar()
{

    if (empty($_POST)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }

    try {
        $modelo = returnObjectClass()['cliente'];
        $bitacora = returnObjectClass()['bitacora'];

        $modelo->setNacionalidad(isset($_POST['nacionalidad']) ? $_POST['nacionalidad'] : 'V');
        $modelo->setCedula($_POST['cedula']);
        $modelo->setNombre($_POST['nombre']);
        $modelo->setApellido($_POST['apellido']);
        $modelo->setTelefono($_POST['telefono']);
        $modelo->setDireccion($_POST['direccion']);
        $modelo->setFn($_POST['fn']);
        $modelo->setGenero($_POST['genero']);

        $bitacora->setId_usuario($_POST['id_usuario']);
        $bitacora->setActividad("Ha Insertado un nuevo cliente");
        $bitacora->setTabla("cliente");

        $insercion = $modelo->insertar();

        // Verifica si es un array con clave "exito"
        if (is_array($insercion) && $insercion[0] === "exito") {
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

function setCliente()
{

    try {
        $modelo = returnObjectClass()['cliente'];
        $bitacora = returnObjectClass()['bitacora'];

        $modelo->setIdCliente($_POST['id']);
        $modelo->setNacionalidad(isset($_POST['nacionalidad']) ? $_POST['nacionalidad'] : 'V');
        $modelo->setCedula($_POST['cedula']);
        $modelo->setCedulaRegistrada($_POST['cedulaRegistrada']);
        $modelo->setNombre($_POST['nombre']);
        $modelo->setApellido($_POST['apellido']);
        $modelo->setTelefono($_POST['telefono']);
        $modelo->setDireccion($_POST['direccion']);
        $modelo->setFn($_POST['fn']);
        $modelo->setGenero($_POST['genero']);

        $bitacora->setId_usuario($_POST['id_usuario']);
        $bitacora->setActividad("Ha modificado un cliente");
        $bitacora->setTabla("cliente");

        $edicion = $modelo->update_cliente();

        // echo json_encode($modelo->getIdCliente());

        // Verifica si es un array con clave "exito"
        if (is_array($edicion) && $edicion[0] === "exito") {
            $bitacora->insertarBitacora();
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
        $id_cliente = $datos[0];
        $id_usuario = $datos[1];

        $modelo = returnObjectClass()['cliente'];
        $bitacora = returnObjectClass()['bitacora'];


        $modelo->setIdCliente($id_cliente);

        $bitacora->setId_usuario($id_usuario);
        $bitacora->setActividad("Ha eliminado un cliente");
        $bitacora->setTabla("cliente");

        $eliminacion = $modelo->delete();

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
function restablecer($datos)
{
    try {
        $id_cliente = $datos[0];
        $id_usuario = $datos[1];


        $modelo = returnObjectClass()['cliente'];
        $bitacora = returnObjectClass()['bitacora'];


        $modelo->setIdCliente($id_cliente);

        $bitacora->setId_usuario($id_usuario);
        $bitacora->setActividad("Ha restablecido un cliente");
        $bitacora->setTabla("cliente");

        $restablecer = $modelo->restablecer();

        if (is_array($restablecer) && $restablecer[0] === "exito") {
            $bitacora->insertarBitacora();
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
