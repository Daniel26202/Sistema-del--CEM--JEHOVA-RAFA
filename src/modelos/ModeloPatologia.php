<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\config\Validations;

class ModeloPatologia extends ModelBase
{

    private $idPatologia, $nombrePatologia;

    public function __construct($dbSystem)
    {
        parent::__construct($dbSystem);
    }


    public function mostrarPatologias()
    {
        try {
            $sql = "SELECT * FROM patologia WHERE estado = 'ACT' ";
            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function mostrarPatologiasEliminadas()
    {
        try {
            $sql = "SELECT * FROM patologia WHERE estado = 'DES' ";
            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function nombrePatologia($data)
    {
        try {
            $sql = "SELECT * FROM patologia WHERE estado = 'ACT' AND nombre_patologia = :nombrePatologia";
            $this->setSQL($sql);
            $listData = $this->search($data, false);

            return !empty($listData) ? 1 : 0;
        } catch (\Exception $e) {
            return 0;
        }
    }


    public function insertarPatologia()
    {
        try {

            $data = [
                'nombrePatologia' => $this->getNombrePatologia(),
                'estado' => 'ACT'
            ];


            if ($this->nombrePatologia(['nombrePatologia' => $this->getNombrePatologia()])) {
                throw new \Exception("La patologia ya existe en el sistema.");
            }

            $sql = "INSERT INTO patologia (nombre_patologia, estado) VALUES (:nombrePatologia, :estado)";
            $this->setSQL($sql);

            $this->create($data);

            return ["exito", $data];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function eliminarPatologia()
    {
        try {
            $data = [
                'id_patologia' => $this->getIdPatologia()
            ];

            $sql = "SELECT * from patologia where id_patologia=:id_patologia";
            $this->setSQL($sql);

            $validar  = $this->search($data, false);

            if ($validar == []) {
                throw new \Exception("El id de la patologia no existe");
            }

            $sql = "UPDATE patologia SET estado= 'DES' WHERE id_patologia=:id";
            $this->setSQL($sql);

            $this->update_logic($data['id_patologia']);

            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function restablecer()
    {
        try {
            $data = [
                'id_patologia' => $this->getIdPatologia()
            ];

            $sql = "SELECT * from patologia where id_patologia=:id_patologia";
            $this->setSQL($sql);

            $validar  = $this->search($data, false);

            if ($validar == []) {
                throw new \Exception("El id de la patologia no existe");
            }

            $sql = "UPDATE patologia SET estado= 'ACT' WHERE id_patologia=:id";
            $this->setSQL($sql);

            $this->update_logic($data['id_patologia']);

            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    // mostrar patologia del paciente
    public function mostrarPatologiaP()
    {
        try {

            $data = [
                'id_patologia' => $this->getIdPatologia()
            ];

            $sql = "SELECT pat.id_patologia, pat.nombre_patologia FROM patologiadepaciente pdp INNER JOIN patologia pat ON pdp.id_patologia = pat.id_patologia INNER JOIN paciente pac ON pdp.id_paciente = pac.id_paciente WHERE pac.id_paciente = :id_paciente";
            $this->setSQL($sql);

            return $this->search($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
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
        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/", $nombrePatologia)) {
            throw new \InvalidArgumentException("El Nombre debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres");
        }

        $this->nombrePatologia  = $nombrePatologia;
    }

    
    public function setIdPatologia($idPatologia)
    {
        $this->idPatologia  = $idPatologia;
    }
}
