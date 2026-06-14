<?php

namespace App\modelos;

use App\modelos\ModelBase;

class ModeloSintomas extends ModelBase
{

    private $id_sintoma, $nombre;

    public function __construct($dbSystem = true)
    {
        parent::__construct($dbSystem);
    }

    public function selects()
    {
        try {
            $sql = 'SELECT * FROM sintomas WHERE estado = "ACT"';
            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function selectSintomas($inicio = 0, $limite = 10, $buscar = '', $ordenColumna = 'id_paciente', $ordenDir = 'DESC')
    {
        try {
            $sql = 'SELECT id_sintomas,nombre FROM sintomas WHERE estado = "ACT"';
            $data = [];

            if (!empty($buscar)) {
                $sql .= " AND (nombre LIKE :buscar)";
                $data['buscar'] = "%$buscar%";
            }

            $sql .= " ORDER BY {$ordenColumna} {$ordenDir} LIMIT :inicio, :limite";

            $this->setSQL($sql);

            $data['inicio'] = (int)$inicio;
            $data['limite'] = (int)$limite;
            return $this->search($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function contarTotalSintomas($estado, $buscar = '')
    {
        $data = [
            'estado' => $estado
        ];
        $sql = "SELECT COUNT(*) as total FROM sintomas WHERE estado =:estado";
        if (!empty($buscar)) {
            $sql .= " AND (nombre LIKE :buscar )";
            $data['buscar'] = "%$buscar%";
        }

        $this->setSQL($sql);
        $resultado = $this->search($data, false);

        return $resultado['total'] ?? 0;
    }

    public function insertar()
    {

        try {
            $data = [
                'nombre' => $this->getNombre(),
                'estado' => 'ACT'
            ];
            $sql = 'INSERT INTO sintomas(id_sintomas, nombre, estado) VALUES (null,:nombre,:estado);';
            $this->setSQL($sql);
            $this->create($data);
            return ["exito", $data];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function eliminarL()
    {

        try {
            $data = [
                'id_sintomas' => $this->getIdSintoma()
            ];

            $sql = "SELECT * from sintomas where id_sintomas=:id_sintomas";
            $this->setSQL($sql);

            $validar  = $this->search($data, false);

            if ($validar == []) {
                throw new \Exception("El id del sintomas no existe");
            }

            $sql = "UPDATE sintomas SET estado = 'DES' WHERE id_sintomas =:id";
            $this->setSQL($sql);

            $this->update_logic($data['id_sintomas']);
            return ["exito"];
        } catch (\Exception $e) {
            return 0;
        }
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
