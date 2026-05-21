<?php

namespace App\modelos;

use App\modelos\ModelBase;

class ModeloCategoria extends ModelBase
{

    private $idCategoria, $nombre;

    public function __construct($dbSystem = true)
    {
        parent::__construct($dbSystem);
    }


    public function seleccionarCategoria()
    {
        try {
            $sql = "SELECT * FROM categoria_servicio WHERE estado = 'ACT'";
            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function seleccionarTodasLasCategoria()
    {
        try {
            $sql = "SELECT * FROM categoria_servicio WHERE estado = 'ACT'";
            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function BCategoria($data)
    {
        try {
            $sql = "SELECT * FROM categoria_servicio WHERE nombre = :nombre AND estado = 'ACT'";
            $this->setSQL($sql);
            return $this->search($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function registrarCategoria()
    {
        try {
            $data = [
                'nombre' => $this->getNombre(),
                'estado' => 'ACT'
            ];
            $listData = $this->BCategoria(['nombre' => $this->getNombre()]);
            if (!empty($listData)) {
                throw new \Exception("La categoría ya existe en el sistema.");
            }
            $sql = "INSERT INTO categoria_servicio (nombre, estado) VALUES (:nombre, :estado)";
            $this->setSQL($sql);
            $this->create($data);

            return ["exito", $data];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function eliminarCategoria()
    {
        try {
            $data = [
                'id_categoria' => $this->getIdCategoria()
            ];

            $sql = 'SELECT * from categoria_servicio where id_categoria=:id_categoria and estado="DES"';
            $this->setSQL($sql);
            $listData = $this->search($data, false);

            if ($listData != []) {
                throw new \Exception("El id de la categoria no existe o ya se encuentra eliminado.");
            }

            $sql = "UPDATE categoria_servicio SET estado = 'DES' WHERE id_categoria =:id";
            $this->setSQL($sql);
            $this->update_logic($data['id_categoria']);

            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

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
