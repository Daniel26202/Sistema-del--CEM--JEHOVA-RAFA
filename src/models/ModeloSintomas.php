<?php

namespace App\models;

use App\models\ModelBase;
use App\models\interfaces\InterfaceConnection;
use App\models\interfaces\InterfaceValidator;
use App\models\TraitCreate;
use App\models\TraitUpdate;


class ModeloSintomas extends ModelBase
{

    private $id_sintoma, $nombre;
    private $validator;
    use TraitCreate,TraitUpdate;

    public function __construct(InterfaceConnection $conn, ?InterfaceValidator $vali = null)
    {
        parent::__construct($conn);
        $this->set_tables(['sintomas']);
        $this->validator = $vali;
    }

    public function selects()
    {
        $coditions = [
            'condiciones' => ['estado' => 'ACT'],
            'conectores' => [''],
            'operadores' => ['=']
        ];
        $this->set_tables(["sintomas"]);
        $this->set_colums(['id_sintomas', 'nombre']);
        $this->set_condicion_aditional($coditions);
        return $this->read();
    }

    public function selectSintomas($start = 0, $limit = 10, $search = '', $ordenColumn = 'id_sintomas', $ordenDir = 'DESC')
    {
        $coditions = [
            'condiciones' => ['estado' => 'ACT'],
            'conectores' => [],
            'operadores' => ['=']
        ];
        $this->set_tables(["sintomas"]);
        $this->set_colums(['id_sintomas', 'nombre']);

        $this->set_search($search);
        $this->set_start($start);
        $this->set_limit($limit);
        $this->set_orden_dir($ordenDir);
        $this->set_orden_column($ordenColumn);
        $this->set_condicion_aditional($coditions);

        return $this->pagination();
    }


    public function get_all()
    {
        return [
            'nombre' => $this->getNombre(),
            'estado' => 'ACT'
        ];
    }

    public function getIdSintoma()
    {
        return $this->id_sintoma;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setIdSintomas($id_sintoma)
    {
        if (!preg_match("/^[0-9]+$/", $id_sintoma)) {
            throw new \InvalidArgumentException("El ID del paciente debe ser un número entero positivo.");
        }

        if ((int)$id_sintoma <= 0) {
            throw new \InvalidArgumentException("El ID del paciente debe ser mayor que cero.");
        }

        $this->id_sintoma = (int)$id_sintoma;
    }



    public function setNombre($nombre)
    {
        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/", $nombre)) {
            throw new \InvalidArgumentException("El Nombre debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres");
        }
        $this->nombre = $nombre;
    }
}
