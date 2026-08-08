<?php

namespace App\models;

use App\models\ModelBase;
use App\models\interfaces\InterfaceConnection;
use App\models\interfaces\InterfaceValidator;
use App\models\TraitCreate;

date_default_timezone_set("America/Caracas");

class ModeloBitacora extends ModelBase
{
    private $id_usuario, $tabla, $actividad;
    private $validator;

    use TraitCreate;

    public function __construct(InterfaceConnection $conn, InterfaceValidator $vali)
    {
        parent::__construct($conn);
        $this->set_tables(["bitacora"]);
        //clase para validar la session
        $this->validator = $vali;
    }

    public function consultarBitacora($search ='', $start =0, $limit=0, $ordenDir ='DESC', $ordenColumn='id')
    {
        $this->set_tables(["segurity.bitacora","segurity.usuario","bd.personal"]);
        $this->set_colums(['p.nombre', 'p.apellido','u.usuario','b.tabla', 'b.actividad', 'b.fecha_hora']);
        $this->set_alias(['b','u','p']);
        $this->set_union(['u.id_usuario = b.id_usuario', 'p.usuario = u.id_usuario']);

        $this->set_search($search);
        $this->set_start($start);
        $this->set_limit($limit);
        $this->set_orden_dir($ordenDir);
        $this->set_orden_column($ordenColumn);

        return $this->pagination();
    }

    public function get_all(){
        return [
            'id_usuario'=>$this->getId_usuario(),
            'tabla'=>$this->getTabla(),
            'actividad'=>$this->getActividad(),
            'fecha_hora'=> '2026-07-23 16:14:01'
        ];
    }

    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    public function getTabla()
    {
        return $this->tabla;
    }

    public function getActividad()
    {
        return $this->actividad;
    }


    public function setId_usuario($id_usuario)
    {
        if (!preg_match('/^[0-9]+$/', $id_usuario)) {
            throw new \InvalidArgumentException('El ID no es válido.');
        }
        if ((int)$id_usuario <= 0) {
            throw new \InvalidArgumentException('El ID debe ser mayor que cero.');
        }
        $this->id_usuario = $id_usuario;
    }

    public function setActividad($actividad)
    {
        $this->actividad = $actividad;
    }

    public function setTabla($tabla)
    {
        $this->tabla = $tabla;
    } 
}