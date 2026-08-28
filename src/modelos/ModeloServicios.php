<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\modelos\ModeloDoctores;
use App\modelos\ModeloCategoria;

class ModeloServicios extends ModelBase
{

    private $id_servicioMedico, $precio, $tipo, $id_doctor, $idCategoria;
    private $columnasPermitidasServicios = ['categoria', 'precio_bolivar', 'precio_dolar', 'tipo', 'id_servicioMedico'];
    private $ordenesPermitidosServicios = ['ASC', 'DESC'];

    public function __construct($dbSystem = true)
    {
        parent::__construct($dbSystem);
    }

    // ── READ ────────────────────────────────────────────────

    public function mostrarDoctores()
    {
        try {
            $sql =  "SELECT doctor.nombre, doctor.apellido, doctor.id_personal FROM segurity.usuario u INNER JOIN bd.personal doctor on u.id_usuario = doctor.usuario INNER JOIN segurity.rol r ON r.id_rol = u.id_rol WHERE u.estado = 'ACT' AND doctor.id_especialidad IS NOT null";

            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function mostrarServicios($inicio = 0, $limite = 10, $buscar = '', $ordenColumna = 'id_cita', $ordenDir = 'DESC')
    {
        try {

            $sql = "SELECT sm.id_servicioMedico,sm.id_categoria,sm.precio,sm.tipo,cs.nombre as categoria 
                FROM serviciomedico sm 
                INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria 
                WHERE cs.estado = 'ACT' AND sm.estado = 'ACT'";

            $data = [];
            if (!empty($buscar)) {
                $sql .= " AND ( cs.nombre LIKE :buscar OR sm.precio LIKE :buscar OR sm.tipo LIKE :buscar)";
                $data['buscar'] = "%$buscar%";
            }

            $ordenColumna = in_array($ordenColumna, $this->columnasPermitidasServicios) ? $ordenColumna : 'id_servicioMedico';
            $ordenDir = in_array(strtoupper($ordenDir), $this->ordenesPermitidosServicios) ? $ordenDir : 'DESC';
            
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

    public function contarTotalServicios($estado, $buscar = '')
    {
        try {
            $data = ['estado' => $estado];
            $sql = "SELECT COUNT(*) as total  FROM serviciomedico sm INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE cs.estado = 'ACT' AND sm.estado =:estado ";

            if (!empty($buscar)) {
                $sql .= " AND (p.cedula LIKE :buscar OR categoria LIKE :buscar OR sm.precio LIKE :buscar OR sm.estado LIKE :buscar)";
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

    public function mostrarServiciosDoctor()
    {
        try {


            $sql = "SELECT categoria_nombre.nombre as categoria, serviciomedico.id_servicioMedico, p.nombre AS nombre_personal, p.apellido AS apellido_personal, p.id_personal AS id_personal, serviciomedico.precio, e.nombre AS nombre_especialidad, serviciomedico.id_servicioMedico, categoria_nombre.nombre AS nombre_categoria FROM bd.personal p INNER JOIN bd.personal_has_serviciomedico ps ON ps.personal_id_personal = p.id_personal INNER JOIN
            bd.serviciomedico ON ps.serviciomedico_id_servicioMedico = serviciomedico.id_servicioMedico INNER JOIN bd.especialidad e ON e.id_especialidad = p.id_especialidad INNER JOIN bd.categoria_servicio categoria_nombre ON categoria_nombre.id_categoria = serviciomedico.id_categoria  WHERE serviciomedico.estado = 'ACT' AND categoria_nombre.estado = 'ACT' AND serviciomedico.estado = 'ACT' ";
            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function mostrarServiciosDes($inicio = 0, $limite = 10, $buscar = '', $ordenColumna = 'id_cita', $ordenDir = 'DESC')
    {
        try {
            $sql =  "SELECT sm.id_servicioMedico,sm.id_categoria,sm.precio,sm.tipo,cs.nombre as categoria FROM serviciomedico sm INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE cs.estado = 'ACT' AND sm.estado = 'DES'";

            $data = [];
            if (!empty($buscar)) {
                $sql .= " AND ( cs.nombre LIKE :buscar OR sm.precio LIKE :buscar OR sm.tipo LIKE :buscar)";
                $data['buscar'] = "%$buscar%";
            }

            $ordenColumna = in_array($ordenColumna, $this->columnasPermitidasServicios) ? $ordenColumna : 'id_servicioMedico';
            $ordenDir = in_array(strtoupper($ordenDir), $this->ordenesPermitidosServicios) ? $ordenDir : 'DESC';
            
            $sql .= " ORDER BY {$ordenColumna} {$ordenDir} LIMIT :inicio, :limite";
            $this->setSQL($sql);

            $data['inicio'] = (int)$inicio;
            $data['limite'] = (int)$limite;

            $resultado = $this->search($data);
            return is_array($resultado) ? $resultado : [];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //traer datos del doctor
    public function especialidadDoctor()
    {
        try {
            $data = [
                'id_doctor' => $this->getIdDoctor()
            ];

            $sql = "SELECT e.nombre FROM personal d INNER JOIN especialidad e ON e.id_especialidad = d.id_especialidad WHERE d.id_personal = :id_doctor ";
            $this->setSQL($sql);

            return $this->search($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function nombreServicio()
    {
        try {

            $data = [
                'id_categoria' => $this->getIdCategoria(),
                'tipo' => $this->getTipo(),
                'estado' => 'ACT'
            ];

            $sql = "SELECT sm.id_servicioMedico,sm.id_categoria,sm.precio,sm.tipo,cs.nombre as categoria  FROM serviciomedico sm INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE cs.id_categoria = :id_categoria AND sm.estado =:estado AND sm.tipo = :tipo";
            $this->setSQL($sql);
            $listData = $this->search($data, false);
            return !empty($listData) ? 1 : 0;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //Validdar que un doctor no tenga el mismo servicio
    public function validarServicioDoctor($data)
    {
        try {
            $sql = "SELECT sm.id_servicioMedico,sm.id_categoria,sm.precio,sm.tipo,cs.nombre as categoria  FROM serviciomedico sm INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria INNER JOIN  personal_has_serviciomedico ps ON ps.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN personal p ON p.id_personal = ps.personal_id_personal WHERE sm.id_servicioMedico =:id_servicioMedico AND p.id_personal = :id_doctor";
            $this->setSQL($sql);
            $listData = $this->search($data, false);

            return !empty($listData) ? 1 : 0;
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

    private function insertarSevicio()
    {
        try {

            $sql = "SELECT id_categoria,nombre FROM  categoria_servicio where id_categoria=:id_categoria";
            $this->setSQL($sql);
            $data = ['id_categoria' => $this->getIdCategoria()];

            $validar = $this->search($data);

            if ($validar == []) {
                throw new \Exception("El id de la categoria no existe");
            }

            if ($this->nombreServicio()) {
                throw new \Exception("El Servicio Medico  ya  existe");
            }


            $sql = "INSERT INTO serviciomedico (id_categoria, precio, estado, tipo) VALUES (:id_categoria, :precio, :estado, :tipo)";

            $this->setSQL($sql);
            $data = [
                'id_categoria' => $this->getIdCategoria(),
                'precio' => $this->getPrecio(),
                'estado' => 'ACT',
                'tipo' => $this->getTipo()
            ];
            $this->create($data);

            return ["exito", $data];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function insertarDoctorServicio()
    {
        try {
            $data1 = ['id_categoria' => $this->getIdCategoria()];

            $data2 = ['id_personal' => $this->getIdDoctor()];

            $sql = "SELECT id_categoria,id_servicioMedico FROM serviciomedico where id_categoria =:id_categoria";
            $this->setSQL($sql);
            $dataSer =  $this->search($data1, false);

            $data3 = [
                'id_doctor' => $this->getIdDoctor(),
                'id_servicioMedico' => $dataSer['id_servicioMedico'],
            ];

            $sql = "SELECT id_categoria from categoria_servicio where id_categoria=:id_categoria";
            $this->setSQL($sql);

            $validar  = $this->search($data1, false);

            if (empty($validar)) {
                throw new \Exception("El id del servicio no existe");
            }

            $sql = "SELECT id_personal from personal where id_personal=:id_personal";
            $this->setSQL($sql);

            $validar  = $this->search($data2, false);

            if (empty($validar)) {
                throw new \Exception("El id del doctor no existe");
            }
            if ($this->validarServicioDoctor($data3)) {
                throw new \Exception("EL Servicio ya esta asignado a este doctor");
            }

            $sql = "INSERT INTO personal_has_serviciomedico (personal_id_personal, serviciomedico_id_servicioMedico) VALUES (:id_doctor, :id_servicioMedico)";

            $this->setSQL($sql);
            $this->create($data3);

            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function eliminar()
    {
        try {
            $data = [
                'id_servicioMedico' => $this->getIdServicioMedico()
            ];

            $sql = "SELECT id_servicioMedico from serviciomedico where id_servicioMedico=:id_servicioMedico";
            $this->setSQL($sql);

            $validar  = $this->search($data, false);

            if ($validar == []) {
                throw new \Exception("El id del paciente no existe");
            }

            $sql = "UPDATE serviciomedico SET estado = 'DES' WHERE id_servicioMedico =:id";
            $this->setSQL($sql);

            $this->update_logic($data['id_servicioMedico']);
            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    private function restablecerServ()
    {
        try {
            $data = [
                'id_servicioMedico' => $this->getIdServicioMedico()
            ];

            $sql = "SELECT id_servicioMedico from serviciomedico where id_servicioMedico=:id_servicioMedico";
            $this->setSQL($sql);

            $validar  = $this->search($data, false);

            if ($validar == []) {
                throw new \Exception("El id del paciente no existe");
            }

            $sql = "UPDATE serviciomedico SET estado = 'ACT' WHERE id_servicioMedico =:id";
            $this->setSQL($sql);

            $this->update_logic($data['id_servicioMedico']);
            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function editar()
    {
        try {


            $sql = "SELECT id_servicioMedico from serviciomedico where id_servicioMedico=:id_servicioMedico";
            $this->setSQL($sql);

            $data2 = [
                'id_servicioMedico' => $this->getIdServicioMedico()
            ];
            $validar  = $this->search($data2, false);

            if ($validar == []) {
                throw new \Exception("El id del servicio no existe");
            }
            if ($this->nombreServicio()) {
                throw new \Exception("El tipo de servicio, ya existe");
            }

            $sql = "UPDATE serviciomedico SET precio = :precio, tipo= :tipo WHERE id_servicioMedico = :id";
            $this->setSQL($sql);

            $data1 = [
                'precio' => $this->getPrecio(),
                'tipo' => $this->getTipo(),
            ];
            $this->update($data1, $this->getIdServicioMedico());
            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    // publicas que llama a las privadas

    public function guardarServicio($idUsuario = null)
    {
        $this->validarSesion($idUsuario);
        $this->validarCamposObligatorios([
            $this->idCategoria,
            $this->precio,
            $this->tipo,
        ], ' al registrar un servicio');
        return $this->insertarSevicio();
    }


    public function asignarServicioDoctor($idUsuario = null)
    {
        $this->validarSesion($idUsuario);
        $this->validarCamposObligatorios([
            $this->idCategoria,
            $this->id_doctor,
        ], ' al asignar un servicio');
        return $this->insertarDoctorServicio();
    }

    public function eliminarServicio($idUsuario = null)
    {
        $this->validarSesion($idUsuario);
        $this->validarCamposObligatorios([
            $this->id_servicioMedico
        ], ' al eliminar un servicio');
        return $this->eliminar();
    }

    public function restablecerServicio($idUsuario = null)
    {
        $this->validarSesion($idUsuario);
        $this->validarCamposObligatorios([
            $this->id_servicioMedico
        ], ' al restablecer un servicio');
        return $this->restablecerServ();
    }

    public function editarServicio($idUsuario = null)
    {
        $this->validarSesion($idUsuario);
        $this->validarCamposObligatorios([
            $this->id_servicioMedico,
            $this->precio,
            $this->tipo,
        ], ' al editar un servicio');
        return $this->editar();
    }


    //// GETTERS AND SETTERS
    public function getIdServicioMedico()
    {

        return $this->id_servicioMedico;
    }
    public function getPrecio()
    {
        return $this->precio;
    }
    public function getTipo()
    {
        return $this->tipo;
    }

    public function getIdDoctor()
    {
        return $this->id_doctor;
    }

    public function getIdCategoria()
    {
        return $this->idCategoria;
    }




    public function setIdCategoria($idCategoria)
    {
        if (!preg_match("/^[0-9]+$/", $idCategoria)) {
            throw new \InvalidArgumentException("El ID del doctor debe ser un número entero positivo.");
        }

        if ((int)$idCategoria <= 0) {
            throw new \InvalidArgumentException("El ID del doctor debe ser mayor que cero.");
        }
        $this->idCategoria = $idCategoria;
    }

    public function setIdDoctor($id_doctor)
    {
        if (!preg_match("/^[0-9]+$/", $id_doctor)) {
            throw new \InvalidArgumentException("El ID del doctor debe ser un número entero positivo.");
        }

        if ((int)$id_doctor <= 0) {
            throw new \InvalidArgumentException("El ID del doctor debe ser mayor que cero.");
        }
        $this->id_doctor = $id_doctor;
    }

    public function setIdServicioMedico($id_servicioMedico)
    {
        if (!preg_match("/^[0-9]+$/", $id_servicioMedico)) {
            throw new \InvalidArgumentException("El ID del servicio debe ser un número entero positivo.");
        }

        if ((int)$id_servicioMedico <= 0) {
            throw new \InvalidArgumentException("El ID del servicio debe ser mayor que cero.");
        }

        $this->id_servicioMedico = $id_servicioMedico;
    }
    public function setPrecio($precio)
    {
        if (!preg_match("/^(?!0$)(?!1$)\d+([.,]\d+)?$/", $precio)) {
            throw new \InvalidArgumentException("El precio esta mal." . $precio);
        }

        $this->precio  = $precio;
    }
    public function setTipo($tipo)
    {
        if (!preg_match('/^Examenes|Cita$/', $tipo)) {
            throw new \InvalidArgumentException("El tipo esta mal.");
        }

        $this->tipo = $tipo;
    }
}
