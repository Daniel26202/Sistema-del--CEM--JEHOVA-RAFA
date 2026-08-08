<?php

use App\models\ModeloPermisos;
use App\models\ModeloBitacora;
use App\models\Db;
use App\models\Validator;


// use App\config\RateLimiter;


////modulos/////
function returnModules()
{
    $db = new Db();
    $model = new ModeloPermisos($db);

    echo json_encode($model->returnModules());
}

function returnPermisionModule()  {
    $db = new Db();
    $module = new ModeloPermisos($db);

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
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }
    try {
        $db = new Db();
        $model = new ModeloPermisos($db);
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
        $db = new Db();
        $validator = new Validator();
        $validator->set_session($_SESSION);
        $validator->set_id_usuario($idUsuario);

        $modulo = new ModeloPermisos($db);
        $bitacora = new ModeloBitacora($db,$validator);

        $modulo->setModulo($_POST["nombre"]);

        $insercion = $modulo->guardar($modulo->get_all(), $validator);

        if (is_array($insercion) && $insercion[0] === "exito") {
            $bitacora->setId_usuario($_POST['id_usuario']);
            $bitacora->setActividad("Ha Insertado un nuevo  modulo");
            $bitacora->setTabla("modulo");
            $bitacora->guardar($bitacora->get_all(),$validator);
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


function eliminar_modulo(array $datos)
{
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }

    try {

        $idUsuario = $_SESSION['id_usuario'];
        $db = new Db();
        $validator = new Validator();
        $validator->set_session($_SESSION);
        $validator->set_id_usuario($idUsuario);

        $modelo  = new ModeloPermisos($db);
        $bitacora = new ModeloBitacora($db,$validator);

        $modelo->setIdModulo($datos[0]);

        $bitacora->setId_usuario($datos[1]);
        $bitacora->setActividad("Ha eliminado un  modulo del sistema");
        $bitacora->setTabla("modulo");

        $eliminacion = $modelo->actualizar(['estado'=>'DES'],['id_modulo'=>$modelo->getIdModulo()],$validator);

        //Verifica si es un array con clave "exito"
        if (is_array($eliminacion) && $eliminacion[0] === "exito") {
            $bitacora->guardar($bitacora->get_all(),$validator);
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
