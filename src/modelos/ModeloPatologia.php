<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\config\Validations;

class ModeloPatologia extends ModelBase
{

    private $idPatologia, $nombrePatologia, $cedulaPac;

    public function __construct($dbSystem = true)
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
                throw new \Exception("La patología ya existe en el sistema.");
            }
            
            $sql = "SELECT * FROM patologia WHERE estado = 'DES' AND nombre_patologia = :nombrePatologia";
            $this->setSQL($sql);
            $listData = $this->search(['nombrePatologia' => $this->getNombrePatologia()], false);
            if (!empty($listData)) {
                throw new \Exception("La patología ya existe en el sistema, esta en papelera.");
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

    public function buscarPatologiaPaciente()
    {
        try {
            $sql = "SELECT * FROM patologia pat INNER JOIN patologiadepaciente pdp ON pdp.id_patologia = pat.id_patologia INNER JOIN paciente pac ON pac.id_paciente = pdp.id_paciente WHERE pac.cedula =:cedula";
            $this->setSQL($sql);
            return $this->search(['cedula' => $this->getCedulaPac()]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getCedulaPac()
    {
        return $this->cedulaPac;
    }

    public function getNombrePatologia()
    {
        return $this->nombrePatologia;
    }

    public function getIdPatologia()
    {
        return $this->idPatologia;
    }


    public function setCedulaPac($cedulaPac)
    {
        if (!preg_match("/^([1-9]{1})([0-9]{7,8})$/", $cedulaPac)) {
            throw new \InvalidArgumentException("La cédula debe contener entre 7 y 8 dígitos.");
        }
        $this->cedulaPac = $cedulaPac;
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
