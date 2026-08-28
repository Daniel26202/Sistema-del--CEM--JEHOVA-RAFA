<?php

namespace App\modelos;

use App\modelos\ModelBase;

class ModeloPatologia extends ModelBase
{

    private $idPatologia, $nombrePatologia, $cedulaPac;
    private $columnasPermitidas = ['id_patologia', 'nombre_patologia'];
    private $ordenesPermitidos = ['ASC', 'DESC'];

    public function __construct($dbSystem = true)
    {
        parent::__construct($dbSystem);
    }


    // ── READ ────────────────────────────────────────────────
    public function mostrarPatologias($inicio = 0, $limite = 10, $buscar = '', $ordenColumna = 'id_patologia', $ordenDir = 'DESC')
    {
        try {
            $sql = "SELECT id_patologia, nombre_patologia FROM patologia WHERE estado = 'ACT'";
            $data = [];

            if (!empty($buscar)) {
                $sql .= " AND (nombre_patologia LIKE :buscar)";
                $data['buscar'] = "%$buscar%";
            }

            if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
                $ordenColumna = 'id_paciente';
            }

            $ordenColumna = in_array($ordenColumna, $this->columnasPermitidas) ? $ordenColumna : 'id_paciente';
            $ordenDir = in_array(strtoupper($ordenDir), $this->ordenesPermitidos) ? $ordenDir : 'DESC';

            // Concatenamos las variables validadas de orden y añadimos los marcadores de límite
            $sql .= " ORDER BY {$ordenColumna} {$ordenDir} LIMIT :inicio, :limite";
            $this->setSQL($sql);

            // Insertamos los límites protegiendo el array de parámetros
            $data['inicio'] = (int)$inicio;
            $data['limite'] = (int)$limite;

            $resultado = $this->search($data);
            return is_array($resultado) ? $resultado : [];
        } catch (\Exception $e) {
            return [];
        }
    }



    public function mostrarPatologiasEliminadas($inicio = 0, $limite = 10, $buscar = '', $ordenColumna = 'id_patologia', $ordenDir = 'DESC')
    {
        try {
            $sql = "SELECT id_patologia, nombre_patologia FROM patologia WHERE estado = 'DES'";
            $data = [];

            if (!empty($buscar)) {
                $sql .= " AND (nombre_patologia LIKE :buscar)";
                $data['buscar'] = "%$buscar%";
            }
            if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
                $ordenColumna = 'id_paciente';
            }

            $ordenColumna = in_array($ordenColumna, $this->columnasPermitidas) ? $ordenColumna : 'id_paciente';
            $ordenDir = in_array(strtoupper($ordenDir), $this->ordenesPermitidos) ? $ordenDir : 'DESC';

            $sql .= " ORDER BY {$ordenColumna} {$ordenDir} LIMIT :inicio, :limite";
            $this->setSQL($sql);

            $data['inicio'] = (int)$inicio;
            $data['limite'] = (int)$limite;

            $resultado = $this->search($data);
            return is_array($resultado) ? $resultado : [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function contarTotalPatologias($estado, $buscar = '')
    {
        try {
            $data = ['estado' => $estado];
            $sql = "SELECT COUNT(*) as total FROM patologia WHERE estado = :estado";

            if (!empty($buscar)) {
                $sql .= " AND (nombre_patologia LIKE :buscar)";
                $data['buscar'] = "%$buscar%";
            }

            $this->setSQL($sql);
            $resultado = $this->search($data, false);

            if (is_array($resultado) && isset($resultado['total'])) {
                return (int)$resultado['total'];
            }
            return 0;
        } catch (\Exception $e) {
            return 0;
        }
    }
    
    public function nombrePatologia($data)
    {
        try {
            $sql = "SELECT nombre_patologia FROM patologia WHERE estado = 'ACT' AND nombre_patologia = :nombrePatologia";
            $this->setSQL($sql);
            $listData = $this->search($data, false);

            return !empty($listData) ? 1 : 0;
        } catch (\Exception $e) {
            return 0;
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

    // ── PRIVADOS─────────────────────────────────────────
    private function insertarPatologia()
    {
        try {

            $data = [
                'nombrePatologia' => $this->getNombrePatologia(),
                'estado' => 'ACT'
            ];


            if ($this->nombrePatologia(['nombrePatologia' => $this->getNombrePatologia()])) {
                throw new \Exception("La patología ya existe en el sistema.");
            }
            
            $sql = "SELECT id_patologia FROM patologia WHERE estado = 'DES' AND nombre_patologia = :nombrePatologia";
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

    private function eliminarPatologia($estado = 'DES')
    {
        try {
            $data = [
                'id_patologia' => $this->getIdPatologia()
            ];

            $sql = "SELECT id_patologia from patologia where id_patologia=:id_patologia";
            $this->setSQL($sql);

            $validar  = $this->search($data, false);

            if ($validar == []) {
                throw new \Exception("El id de la patologia no existe");
            }

            $sql = "UPDATE patologia SET estado= :estado WHERE id_patologia=:id";
            $this->setSQL($sql);
            $this->update(['estado'=>$estado],$data['id_patologia']);

            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    private function validarSesion($idUsuario): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['id_usuario']) && $idUsuario === null) {
            throw new \Exception('No hay sesión activa o usuario no autenticado.');
        }
    }

    private function validarCamposObligatorios(array $campos, string $contexto = ''): void
    {
        foreach ($campos as $campo) {
            if (empty($campo)) {
                throw new \Exception("No se permiten campos vacíos{$contexto}.");
            }
        }
    }

    // ── PÚBLICOS  QUE LLAMAN A LAS PRIVADAS ────────────────────

    public function guardarPatologia($idUsuario = null){
        $this->validarSesion($idUsuario);
        $this->validarCamposObligatorios([
            $this->nombrePatologia
        ], 'al registrar la patologia');
        return $this->insertarPatologia();
    }

    public function deletePatologia($idUsuario = null,$estado = 'DES')
    {
        $this->validarSesion($idUsuario);
        $this->validarCamposObligatorios([
            $this->idPatologia
        ], 'al eliminar la patologia');
        return $this->eliminarPatologia($estado);
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
