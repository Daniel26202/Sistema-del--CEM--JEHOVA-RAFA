<?php

use App\modelos\ModeloPermisos;
use App\modelos\ModeloBitacora;

use App\config\RateLimiter;


////modulos/////
function returnModules()
{
    $model = new ModeloPermisos();

    echo json_encode($model->returnModules());
}


function hasPermision($data)
{
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }
    try {
        $model = new ModeloPermisos();
        $model->setIdRol($data[0]);
        $model->setModulo($data[1]);
        $model->setPermiso($data[2]);
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
        $idUsuario = $_SESSION['id_usuario'];
        // RATE LIMIT: 5 peticiones cada 1 segundos
        $limiter = new RateLimiter();
        $limiter->verificar('guardar_modulo_' . $idUsuario, 5, 1);

        $modulo = new ModeloPermisos();
        $bitacora = new ModeloBitacora();

        $modulo->setModulo($_POST["nombre"]);

        $insercion = $modulo->registrarModulo();

        if (is_array($insercion) && $insercion[0] === "exito") {
            $bitacora->setId_usuario($_POST['id_usuario']);
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

        $idUsuario = $_SESSION['id_usuario'];
        // RATE LIMIT: 5 peticiones cada 1 segundos
        $limiter = new RateLimiter();
        $limiter->verificar('eliminar_paciente_' . $idUsuario, 5, 1);

        $modelo  = new ModeloPermisos();
        $bitacora = new ModeloBitacora();

        $modelo->setIdModulo($datos[0]);

        $bitacora->setId_usuario($datos[1]);
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
