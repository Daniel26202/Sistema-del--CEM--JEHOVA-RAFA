<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\config\RateLimiter;
class ModeloCategoria extends ModelBase
{

    private $idCategoria, $nombre;

    public function __construct($dbSystem = true)
    {
        parent::__construct($dbSystem);
    }

    // ── READ ────────────────────────────────────────────────

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

    public function seleccionarTodasLasCategoria($inicio = 0, $limite = 10, $buscar = '', $ordenColumna = 'id_cita', $ordenDir = 'DESC')
    {
        $sql='';
        try {
            $data = ['estado'=>'ACT'];
            $sql = "SELECT * FROM categoria_servicio WHERE estado =:estado";
            if (!empty($buscar)) {
                $sql .= " AND ( nombre LIKE :buscar)";
                $data['buscar'] = "%$buscar%";
            }

            $sql .= " ORDER BY {$ordenColumna} {$ordenDir} LIMIT :inicio, :limite";
            $this->setSQL($sql);

            $data['inicio'] = (int)$inicio;
            $data['limite'] = (int)$limite;

            $resultado = $this->search($data);
            return is_array($resultado) ? $resultado : [];
        } catch (\Exception $e) {
            return [$e->getMessage(), $sql];
        }
    }
    public function contarTotalCategorias($buscar = '')
    {
        try {
            $data = [];
            $sql = "SELECT COUNT(*) as total  FROM categoria_servicio WHERE estado = 'ACT' ";

            if (!empty($buscar)) {
                $sql .= " AND (p.cedula LIKE :buscar OR nombre LIKE :buscar OR sm.precio LIKE :buscar OR sm.estado LIKE :buscar)";
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


    // ── PRIVADOS─────────────────────────────────────────


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

    private function registrarCategoria()
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

    private function eliminar()
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

    // ── PÚBLICOS QUE LLAMAN A LAS PRIVADAS ────────────────────


    public function guardarCategoria($idUsuario = null)
    {
        $this->validarSesion($idUsuario);
        $this->validarCamposObligatorios([
            $this->nombre,
        ], ' al registrar una categoria');
        (new RateLimiter())->verificar('guardar_categoria_' . $idUsuario, 5, 1);
        return $this->registrarCategoria();
    }

    public function eliminarCategoria($idUsuario = null)
    {
        $this->validarSesion($idUsuario);
        $this->validarCamposObligatorios([
            $this->idCategoria,
        ], ' al eliminar una categoria');
        (new RateLimiter())->verificar('eliminar_categoria_' . $idUsuario, 5, 1);
        return $this->eliminar();
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
