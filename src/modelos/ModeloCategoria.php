<?php

namespace App\modelos;

use App\modelos\ModelBase;
class ModeloCategoria extends ModelBase
{

    private $idCategoria ,$nombre;

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

    public function registrarCategoria()
    {
        try {
            $data =[
                'nombre' => $this->getNombre(),
                'estado' => 'ACT'
            ];


            $sql= "INSERT INTO categoria_servicio (nombre, estado) VALUES (null, :nombre, :estado)";
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
        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/", $nombre)) {
            throw new \InvalidArgumentException("El Nombre debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres");
        }

        $this->nombre = $nombre;
    }
}
