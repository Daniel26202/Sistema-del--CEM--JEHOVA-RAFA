<?php

use App\modelos\ModeloPermisos;


function hasPermision($data)
{
    $model = new ModeloPermisos();
    $model->setIdRol($data[0]);
    $model->setModulo($data[1]);
    $model->setPermiso($data[2]);

    echo json_encode($model->gestionarPermisos());
}
