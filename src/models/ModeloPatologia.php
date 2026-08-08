<?php

namespace App\models;

use App\models\ModelBase;
use App\models\interfaces\InterfaceConnection;
use App\models\interfaces\InterfaceValidator;
use App\models\TraitCreate;
use App\models\TraitUpdate;

class ModeloPatologia extends ModelBase
{

    private $idPatologia, $nombrePatologia;
    private $validator;

    use TraitCreate, TraitUpdate;
    
    public function __construct(InterfaceConnection $conn, InterfaceValidator $vali)
    {
        parent::__construct($conn);
        $this->validator = $vali;
    }


    // ── READ ────────────────────────────────────────────────
    public function mostrarPatologias($estado ='ACT',$start = 0, $limit = 10, $search = '', $ordenColumn = 'id_patologia', $ordenDir = 'DESC')
    {
        $coditions = [
            'condiciones' => ['estado' => $estado],
            'conectores' => [],
            'operadores' => ['=']
        ];
        $this->set_tables(["patologia"]);
        $this->set_colums(['id_patologia', 'nombre_patologia']);

        $this->set_search($search);
        $this->set_start($start);
        $this->set_limit($limit);
        $this->set_orden_dir($ordenDir);
        $this->set_orden_column($ordenColumn);
        $this->set_condicion_aditional($coditions);
        return $this->pagination();
    }

    public function nombrePatologia()
    {
        $coditions = [
            'condiciones' => ['nombre' => $this->getNombrePatologia(), 'id_patologia' => $this->getIdPatologia()],
            'conectores' => ['AND'],
            'operadores' => ['=', '!=']
        ];
        $this->set_tables(["cliente"]);
        $this->set_colums(['id_cliente']);
        $this->set_condicion_aditional($coditions);
        $listData = $this->read(false);
        return !empty($listData) ? 1 : 0;
    }

    public function get_all() {
        return [
            'nombre_patologia' =>$this->getNombrePatologia()
        ];
    }

    public function getNombrePatologia()
    {
        return $this->nombrePatologia;
    }

    public function getIdPatologia()
    {
        return $this->idPatologia;
    }


    public function setNombrePatologia($nombrePatologia)
	{
		if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ0-9\s-]{2,70}$/", $nombrePatologia)) {
			throw new \InvalidArgumentException("El nombre de la patología debe iniciar con mayúscula, tener al menos 3 caracteres y solo puede incluir letras, números, espacios o guiones.");
		}
		$this->nombrePatologia = $nombrePatologia;
	}


    public function setIdPatologia($idPatologia)
    {
        $this->idPatologia  = $idPatologia;
    }
}
