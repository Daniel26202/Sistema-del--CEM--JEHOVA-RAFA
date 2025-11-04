<?php

namespace App\modelos;

use App\modelos\Db;

class ModeloConsultas extends Db
{

    private $conexion;

    public function __construct()
    {
        $this->conexion = $this->connectionSistema();
    }

    public function mostrarDoctores()
    {
        try {
            $consulta = $this->conexion->prepare("SELECT doctor.nombre, doctor.apellido, doctor.id_personal FROM segurity.usuario u INNER JOIN bd.personal doctor on u.id_usuario = doctor.usuario INNER JOIN segurity.rol r ON r.id_rol = u.id_rol WHERE u.estado = 'ACT' AND r.nombre = 'Doctor' ");
            $consulta->execute();

            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }
    public function mostrarConsultas()
    {
        try {
            $consulta = $this->conexion->prepare('SELECT *,cs.nombre as categoria FROM serviciomedico sm INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE cs.estado = "ACT" AND sm.estado = "ACT" ');
            $consulta->execute();
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function mostrarConsultasDoctor($id_doctor)
    {
        try {
            $consulta = $this->conexion->prepare("SELECT categoria_nombre.nombre as categoria, serviciomedico.id_servicioMedico, p.nombre AS nombre_personal, p.apellido AS apellido_personal, p.id_personal AS id_personal, serviciomedico.precio, e.nombre AS nombre_especialidad, serviciomedico.id_servicioMedico, categoria_nombre.nombre AS nombre_categoria FROM bd.personal p INNER JOIN bd.personal_has_serviciomedico ps ON ps.personal_id_personal = p.id_personal INNER JOIN
        bd.serviciomedico ON ps.serviciomedico_id_servicioMedico = serviciomedico.id_servicioMedico INNER JOIN bd.especialidad e ON e.id_especialidad = p.id_especialidad INNER JOIN bd.categoria_servicio categoria_nombre ON categoria_nombre.id_categoria = serviciomedico.id_categoria  WHERE serviciomedico.estado = 'ACT' AND categoria_nombre.estado = 'ACT' AND serviciomedico.estado = 'ACT' AND ps.personal_id_personal  = :id_doctor");
            $consulta->bindParam(":id_doctor", $id_doctor);
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }


    public function mostrarConsultasDes()
    {
        try {
            $consulta = $this->conexion->prepare('SELECT *,cs.nombre as categoria FROM serviciomedico sm INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE cs.estado = "DES" OR sm.estado = "DES" ');
            $consulta->execute();
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function insertarSevicio($id_categoria, $precio, $tipo)
    {
        try {
            $consulta = $this->conexion->prepare("INSERT INTO serviciomedico (id_categoria, precio, estado, tipo) VALUES (:id_categoria, :precio, 'ACT', :tipo)");
            $consulta->bindParam(":id_categoria", $id_categoria);
            $consulta->bindParam(":precio", $precio);
            $consulta->bindParam(":tipo", $tipo);
            $consulta->execute();

            $id_servicioMedico = $this->conexion->lastInsertId();

            $consulta = $this->conexion->prepare("SELECT * from serviciomedico where id_servicioMedico=:id_servicioMedico");
            $consulta->bindParam(":id_servicioMedico", $id_servicioMedico);
            $consulta->execute();
            $data = ($consulta->execute()) ? $consulta->fetch() : false;

            $this->conexion->commit();
            return ["exito", $data];
        } catch (\Exception $e) {
            return 0;
        }
    }


    public function insertarDoctorServicio($id_doctor, $id_servicioMedico)
    {
        try {
            $consulta = $this->conexion->prepare("INSERT INTO personal_has_serviciomedico (personal_id_personal, serviciomedico_id_servicioMedico) VALUES (:id_doctor, :id_servicioMedico)");
            $consulta->bindParam(":id_doctor", $id_doctor);
            $consulta->bindParam(":id_servicioMedico", $id_servicioMedico);
            $consulta->execute();
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function eliminar($id_servicioMedico)
    {
        try {
            $consulta = $this->conexion->prepare("UPDATE servicioMedico SET estado = 'DES' WHERE id_servicioMedico =:id_servicioMedico ");
            $consulta->bindParam(":id_servicioMedico", $id_servicioMedico);
            $consulta->execute();
            return "exito";
        } catch (\Exception $e) {
            return 0;
        }
    }
    public function restablecerServ($id_servicioMedico)
    {
        try {
            $consulta = $this->conexion->prepare("UPDATE servicioMedico SET estado = 'ACT' WHERE id_servicioMedico =:id_servicioMedico ");
            $consulta->bindParam(":id_servicioMedico", $id_servicioMedico);
            $consulta->execute();
            return "exito";
        } catch (\Exception $e) {
            return 0;
        }
    }


    public function editar($id_servicioMedico, $precio, $tipo)
    {
        try {
            $consulta = $this->conexion->prepare("UPDATE serviciomedico SET precio = :precio, tipo= :tipo WHERE id_servicioMedico = :id_servicioMedico");
            $consulta->bindParam(":precio", $precio);
            $consulta->bindParam(":id_servicioMedico", $id_servicioMedico);
            $consulta->bindParam(":tipo", $tipo);
            $consulta->execute();
            return "exito";
        } catch (\Exception $e) {
            return 0;
        }
    }


    //traer datos del doctor
    public function especialidadDoctor($id_doctor)
    {
        try {
            $consulta = $this->conexion->prepare("SELECT e.nombre FROM personal d INNER JOIN especialidad e ON e.id_especialidad = d.id_especialidad WHERE d.id_personal = :id_doctor ");
            $consulta->bindParam(":id_doctor", $id_doctor);
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function nombreConsulta($id_categoria)
    {
        try {
            $consulta = $this->conexion->prepare("SELECT *,cs.nombre as categoria FROM serviciomedico sm INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE cs.id_categoria = :id_categoria AND sm.estado = 'ACT'");
            $consulta->bindParam(":id_categoria", $id_categoria);
            $consulta->execute();
            while ($consulta->fetch()) {
                return "existeC";
            }
            return "noExiste";
        } catch (\Exception $e) {
            return 0;
        }
    }

    //Validdar que un doctor no tenga el mismo servicio
    public function validarServicioDoctor($id_servicioMedico, $id_doctor)
    {
        try {
            $consulta = $this->conexion->prepare("SELECT *,cs.nombre as categoria FROM serviciomedico sm INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria INNER JOIN  personal_has_serviciomedico ps ON ps.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN personal p ON p.id_personal = ps.personal_id_personal WHERE sm.id_servicioMedico =:id_servicioMedico AND p.id_personal = :id_doctor");
            $consulta->bindParam(":id_servicioMedico", $id_servicioMedico);
            $consulta->bindParam(":id_doctor", $id_doctor);
            $consulta->execute();
            while ($consulta->fetch()) {
                return "existeC";
            }
            return "noExiste";
        } catch (\Exception $e) {
            return 0;
        }
    }
}
