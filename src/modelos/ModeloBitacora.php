<?php

namespace App\modelos;

use App\modelos\ModelBase;

date_default_timezone_set("America/Caracas");

class ModeloBitacora extends ModelBase
{
    private $id_usuario, $tabla, $actividad;
    private $columnasPermitidas = ['nombre', 'usuario', 'tabla', 'actividad', 'fecha', 'hora'];
    private $ordenesPermitidos = ['ASC', 'DESC'];

    public function __construct($dbSystem = false)
    {
        parent::__construct($dbSystem);
    }

    public function consultarBitacora($id_usuario, $inicio = 0, $limite = 10, $buscar = '', $ordenColumna = 'fecha_hora', $ordenDir = 'DESC')
    {
        $sql = '';
        $data = [];
        if ($id_usuario) {
            $data['id_usuario'] = $id_usuario;
            $sql = "SELECT p.nombre, p.apellido, u.usuario,b.tabla, b.actividad, b.fecha_hora FROM segurity.bitacora b INNER JOIN segurity.usuario u ON u.id_usuario = b.id_usuario INNER JOIN bd.personal p ON p.usuario = u.id_usuario WHERE u.id_usuario =:id_usuario";
        } else {
            $sql = "SELECT p.nombre, p.apellido, u.usuario,b.tabla, b.actividad, b.fecha_hora FROM segurity.bitacora b INNER JOIN segurity.usuario u ON u.id_usuario = b.id_usuario INNER JOIN bd.personal p ON p.usuario = u.id_usuario WHERE u.id_usuario is not null";
        }

        if (!empty($buscar)) {
            $sql .= " AND (p.nombre LIKE :buscar OR p.apellido LIKE :buscar OR b.tabla LIKE :buscar OR u.usuario LIKE :buscar OR b.actividad LIKE :buscar OR b.fecha_hora LIKE :buscar)";
            $data['buscar'] = "%$buscar%";
        }

        $ordenColumna = in_array($ordenColumna, $this->columnasPermitidas) ? $ordenColumna : 'id_bitacora';
        $ordenDir = in_array(strtoupper($ordenDir), $this->ordenesPermitidos) ? $ordenDir : 'DESC';

        $sql .= " ORDER BY {$ordenColumna} {$ordenDir} LIMIT :inicio, :limite";

        $this->setSQL($sql);

        $data['inicio'] = (int)$inicio;
        $data['limite'] = (int)$limite;
        return $this->search($data);
    }

    public function contarTotalBitacora($id_usuario, $buscar = '')
    {
        $sql ='';
        $data = [];
        if ($id_usuario) {
            $data['id_usuario'] = $id_usuario;
            $sql = "SELECT COUNT(*) as total FROM segurity.bitacora b INNER JOIN segurity.usuario u ON u.id_usuario = b.id_usuario INNER JOIN bd.personal p ON p.usuario = u.id_usuario WHERE b.id_usuario =:id_usuario";
        } else {
            $sql = "SELECT COUNT(*) as total FROM segurity.bitacora b INNER JOIN segurity.usuario u ON u.id_usuario = b.id_usuario INNER JOIN bd.personal p ON p.usuario = u.id_usuario WHERE u.id_usuario is not null";
        }
        if (!empty($buscar)) {
            $sql .= " AND (p.nombre LIKE :buscar OR p.apellido LIKE :buscar OR b.tabla LIKE :buscar OR u.usuario LIKE :buscar OR b.actividad LIKE :buscar OR b.fecha_hora LIKE :buscar)";
            $data['buscar'] = "%$buscar%";
        }

        $this->setSQL($sql);
        $resultado = $this->search($data, false);

        return $resultado['total'] ?? 0;
    }


    private function insertarBitacoraPrivada()
    {
        try {
            $data = [
                'id_usuario' => $this->getId_usuario(),
                'tabla' => $this->getTabla(),
                'actividad' => $this->getActividad(),
                'fecha_hora' => date('Y-m-d H:i:s')
            ];

            $sql  = "INSERT INTO segurity.bitacora (id_usuario, tabla, actividad, fecha_hora) VALUES (:id_usuario, :tabla, :actividad, :fecha_hora)";
            $this->setSQL($sql);

            $this->create($data);

            return ["exito", $data];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function insertarBitacora($idUsuario = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Usa el parámetro si viene, si no busca en sesión
        $id = $idUsuario ?? $_SESSION['id_usuario'] ?? null;

        if (!$id) {
            throw new \Exception('No hay sesión activa o usuario no autenticado.');
        }

        // Validación de campos obligatorios
        if (empty($this->tabla) || empty($this->actividad)) {
            throw new \Exception('No se permiten campos vacíos en la bitácora (tabla o actividad).');
        }

        // Asegura que el modelo tenga el id correcto
        $this->id_usuario = $id;

        return $this->insertarBitacoraPrivada();
    }

    public function setId_usuario($id_usuario)
    {
        if (!preg_match('/^[0-9]+$/', $id_usuario)) {
            throw new \InvalidArgumentException('El ID no es válido.');
        }
        if ((int)$id_usuario <= 0) {
            throw new \InvalidArgumentException('El ID debe ser mayor que cero.');
        }
        $this->id_usuario = $id_usuario;
    }

    public function setActividad($actividad)
    {
        $this->actividad = $actividad;
    }

    public function setTabla($tabla)
    {
        $this->tabla = $tabla;
    }

    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    public function getTabla()
    {
        return $this->tabla;
    }

    public function getActividad()
    {
        return $this->actividad;
    }
}
