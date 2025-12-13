<?php

namespace App\modelos;

use App\modelos\ModelBase;

date_default_timezone_set("America/Caracas");

class ModeloBitacora extends ModelBase
{
    private $id_usuario, $tabla, $actividad;

    public function __construct($dbSystem)
    {
        parent::__construct($dbSystem);
    }

    public function consultarBitacora($data = [])
    {
        if ($data != []) {
            $sql = "SELECT p.nombre, p.apellido, u.usuario,b.tabla, b.actividad, b.fecha_hora FROM segurity.bitacora b INNER JOIN segurity.usuario u ON u.id_usuario = b.id_usuario INNER JOIN bd.personal p ON p.usuario = u.id_usuario WHERE b.id_usuario =:id_usuario";
            $this->setSQL($sql);
            return $this->search($data);
        }

        $sql = "SELECT p.nombre, p.apellido, u.usuario,b.tabla, b.actividad, b.fecha_hora FROM segurity.bitacora b INNER JOIN segurity.usuario u ON u.id_usuario = b.id_usuario INNER JOIN bd.personal p ON p.usuario = u.id_usuario ";
        $this->setSQL($sql);
        return $this->read();
    }


    public function insertarBitacora()
    {
        try {
            $data = [
                'id_usuario' => $this->getId_usuario(),
                'tabla' => $this->getTabla(),
                'actividad' => $this->getActividad(),
                'fecha_hora' => date('Y-m-d H:i:s')
            ];

            $sql  = "INSERT INTO segurity.bitacora (id_usuario, tabla, actividad, fecha_hora) VALUES (:id_usuario, :tabla, :actividad, :fecha_hora)";
            $this->setSQL($sql);

            $this->create($data);

            return ["exito", $data];
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    public function setId_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    public function getTabla()
    {
        return $this->tabla;
    }

    public function setTabla($tabla)
    {
        $this->tabla = $tabla;
    }

    public function getActividad()
    {
        return $this->actividad;
    }

    public function setActividad($actividad)
    {
        $this->actividad = $actividad;
    }
}
