<?php
namespace App\models;

use App\models\ModelBase;
use App\models\TraitCreate;
use App\models\TraitUpdate;
use App\models\interfaces\InterfaceConnection;
use App\models\interfaces\InterfaceValidator;

class ModeloCategoria extends ModelBase
{

    private $idCategoria, $nombre;
    private $validator;

    use TraitCreate, TraitUpdate;

    public function __construct(InterfaceConnection $conn, InterfaceValidator $vali)
    {
        parent::__construct($conn);
        $this->set_tables(["categoria_servicio"]);
        //clase para validar la session
        $this->validator = $vali;
    }


    public function seleccionarCategoria()
    {
        $this->set_tables(["categoria_servicio"]);
        $this->set_colums(['id_categoria', 'nombre']);
        return $this->read();
    }

    public function seleccionarTodasLasCategoria($start = 0, $limit = 10, $search = '', $ordenColumn = 'id_categoria', $ordenDir = 'DESC')
    {
        $this->set_tables(["categoria_servicio"]);
        $this->set_colums(['id_categoria', 'nombre']);
        $this->set_search($search);
        $this->set_start($start);
        $this->set_limit($limit);
        $this->set_orden_dir($ordenDir);
        $this->set_orden_column($ordenColumn);
        return $this->pagination();
    }

    public function BCategoria($data)
    {
        $this->set_tables(["categoria_servicio"]);
        $this->set_colums(['id_categoria', 'nombre']);
        return $this->read();
    }

    //GETTERS AND SETTERS
    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setIdCategoria($idCategoria)
    {
        $this->idCategoria = $idCategoria;
    }


    public function setNombre($nombre)
    {
        if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ\s]{2,49}$/", $nombre)) {
            throw new \InvalidArgumentException("La categoría debe iniciar con mayúscula, contener al menos 3 letras y solo puede incluir letras y espacios.");
        }

        $this->nombre = $nombre;
    }
}
