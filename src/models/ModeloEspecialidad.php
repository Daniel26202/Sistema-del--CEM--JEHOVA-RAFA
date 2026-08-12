<?php

namespace App\models;

use App\models\ModelBase;
use App\models\TraitCreate;
use App\models\TraitUpdate;
use App\models\interfaces\InterfaceConnection;
use App\models\interfaces\InterfaceValidator;

class ModeloEspecialidad extends ModelBase
{

    private $idEspecialidad, $nombre;
    private $validator;

    use TraitCreate, TraitUpdate;

    public function __construct(InterfaceConnection $conn, ?InterfaceValidator $vali = null)
    {
        parent::__construct($conn);
        $this->set_tables(["especialidad"]);
        //clase para validar la session
        $this->validator = $vali;
    }


    public function seleccionarEspecialidad()
    {
        $this->set_tables(["especialidad"]);
        $this->set_colums(['id_especialidad', 'nombre']);
        return $this->read();
    }

    public function select($start = 0, $limit = 10, $search = '', $ordenColumn = 'id_especialidad', $ordenDir = 'DESC')
    {
        $coditions = [
            'condiciones' => ['estado' => 'ACT'],
            'conectores' => [],
            'operadores' => ['=']
        ];
        $this->set_tables(["especialidad"]);
        $this->set_colums(['id_especialidad', 'nombre']);
        $this->set_search($search);
        $this->set_start($start);
        $this->set_limit($limit);
        $this->set_orden_dir($ordenDir);
        $this->set_orden_column($ordenColumn);
        $this->set_condicion_aditional($coditions);
        return $this->pagination();
    }

    public function BEspecialidad($data)
    {
        $this->set_tables(["especialidad"]);
        $this->set_colums(['id_especialidad', 'nombre']);
        return $this->read();
    }

        //GETTERS AND SETTERS
    public function get_all(){
        return [
            'nombre'=>$this->getNombre(),
            'estado'=>'ACT',
        ];
    }

    public function getIdEspecialidad()
    {
        return $this->idEspecialidad;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setidEspecialidad($idEspecialidad)
    {
        $this->idEspecialidad = $idEspecialidad;
    }


    public function setNombre($nombre)
    {
        if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ\s]{2,49}$/", $nombre)) {
            throw new \InvalidArgumentException("La categoría debe iniciar con mayúscula, contener al menos 3 letras y solo puede incluir letras y espacios.");
        }

        $this->nombre = $nombre;
    }
}
