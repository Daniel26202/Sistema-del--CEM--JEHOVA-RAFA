<?php

namespace App\modelos;

use App\modelos\Db;

class ModeloConsultas extends Db
{

    private $conexion;

    public function __construct()
    {
        // Llama al constructor de la clase padre para establecer la conexión
        parent::__construct();

        // Aquí puedes usar $this para acceder a la conexión

        $this->conexion = $this; // Guarda la instancia de la conexión
    }

    public function mostrarDoctores()
    {
        $consulta = $this->conexion->prepare("SELECT doctor.nombre, doctor.apellido, doctor.id_personal FROM usuario u INNER JOIN personal doctor on u.id_usuario = doctor.id_usuario INNER JOIN rol r ON r.id_rol = u.id_rol WHERE u.estado = 'ACT' AND r.nombre = 'Doctor' ");
        $consulta->execute();

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }
    public function mostrarConsultas()
    {
        $consulta = $this->conexion->prepare('SELECT *,cs.nombre as categoria FROM serviciomedico sm INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE cs.estado = "ACT" AND sm.estado = "ACT" ');
        $consulta->execute();

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    public function mostrarConsultasDoctor($id_doctor)
    {
        $consulta = $this->conexion->prepare("SELECT categoria_nombre.nombre as categoria, serviciomedico.id_servicioMedico, p.nombre AS nombre_personal, p.apellido AS apellido_personal, p.id_personal AS id_personal, serviciomedico.precio, e.nombre AS nombre_especialidad, serviciomedico.id_servicioMedico, categoria_nombre.nombre AS nombre_categoria FROM personal p INNER JOIN personal_has_serviciomedico ps ON ps.personal_id_personal = p.id_personal INNER JOIN
        serviciomedico ON ps.serviciomedico_id_servicioMedico = serviciomedico.id_servicioMedico INNER JOIN especialidad e ON e.id_especialidad = p.id_especialidad INNER JOIN categoria_servicio categoria_nombre ON categoria_nombre.id_categoria = serviciomedico.id_categoria WHERE serviciomedico.estado = 'ACT' AND categoria_nombre.estado = 'ACT' AND serviciomedico.estado = 'ACT' AND ps.personal_id_personal  = :id_doctor");
        $consulta->bindParam(":id_doctor", $id_doctor);
        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }


    public function mostrarConsultasDes()
    {
        $consulta = $this->conexion->prepare('SELECT *,cs.nombre as categoria FROM serviciomedico sm INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE cs.estado = "DES" OR sm.estado = "DES" ');
        $consulta->execute();

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    public function insertarSevicio($id_categoria, $precio)
    {

        $consulta = $this->conexion->prepare("INSERT INTO serviciomedico (id_categoria, precio, estado) VALUES (:id_categoria, :precio, 'ACT')");
        $consulta->bindParam(":id_categoria", $id_categoria);
        $consulta->bindParam(":precio", $precio);
        $consulta->execute();
    }


    public function insertarDoctorServicio($id_doctor, $id_servicioMedico)
    {
        $consulta = $this->conexion->prepare("INSERT INTO personal_has_serviciomedico (personal_id_personal, serviciomedico_id_servicioMedico) VALUES (:id_doctor, :id_servicioMedico)");
        $consulta->bindParam(":id_doctor", $id_doctor);
        $consulta->bindParam(":id_servicioMedico", $id_servicioMedico);
        return ($consulta->execute()) ? true : false;
    }

    public function eliminar($id_servicioMedico)
    {
        $consulta = $this->conexion->prepare("UPDATE servicioMedico SET estado = 'DES' WHERE id_servicioMedico =:id_servicioMedico ");
        $consulta->bindParam(":id_servicioMedico", $id_servicioMedico);
        $consulta->execute();
    }
    public function restablecerServ($id_servicioMedico)
    {
        $consulta = $this->conexion->prepare("UPDATE servicioMedico SET estado = 'ACT' WHERE id_servicioMedico =:id_servicioMedico ");
        $consulta->bindParam(":id_servicioMedico", $id_servicioMedico);
        $consulta->execute();
    }


    public function editar($id_servicioMedico, $precio)
    {
        $consulta = $this->conexion->prepare("UPDATE serviciomedico SET precio = :precio WHERE id_servicioMedico = :id_servicioMedico");
        $consulta->bindParam(":precio", $precio);
        $consulta->bindParam(":id_servicioMedico", $id_servicioMedico);
        $consulta->execute();
    }



    // public function buscar($parametro){
    //     $consulta = $this->PDO->prepare("SELECT serviciomedico.id_servicioMedico,doctor.id_doctor, u.nombre, u.apellido, serviciomedico.precio, e.nombre, serviciomedico.id_serviciomedico FROM doctor INNER JOIN serviciomedico ON doctor.id_doctor = serviciomedico.id_doctor INNER JOIN usuario u ON doctor.id_usuario = u.id_usuario INNER JOIN doctoryespecialidad dye ON dye.id_doctor = doctor.id_doctor INNER JOIN especialidad e ON dye.id_especialidad = e.id_especialidad  WHERE serviciomedico.estado ='ACT' AND u.id_rol = 2 AND e.nombre LIKE :busqueda ");
    //     $busqueda = "%$parametro%";
    //     $consulta->bindParam(":busqueda", $busqueda);
    //     return ($consulta->execute()) ? $consulta->fetchAll() : false;

    // }

    //traer datos del doctor
    public function especialidadDoctor($id_doctor)
    {
        $consulta = $this->conexion->prepare("SELECT e.nombre FROM personal d INNER JOIN especialidad e ON e.id_especialidad = d.id_especialidad WHERE d.id_personal = :id_doctor ");
        $consulta->bindParam(":id_doctor", $id_doctor);
        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    public function nombreConsulta($id_categoria)
    {
        $consulta = $this->conexion->prepare("SELECT *,cs.nombre as categoria FROM serviciomedico sm INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE cs.id_categoria = :id_categoria AND sm.estado = 'ACT'");
        $consulta->bindParam(":id_categoria", $id_categoria);
        $consulta->execute();

        while ($consulta->fetch()) {
            return "existeC";
        }

        return 0;
    }

    //Validdar que un doctor no tenga el mismo servicio
    public function validarServicioDoctor($id_servicioMedico,$id_doctor)
    {
        $consulta = $this->conexion->prepare("SELECT *,cs.nombre as categoria FROM serviciomedico sm INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria INNER JOIN  personal_has_serviciomedico ps ON ps.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN personal p ON p.id_personal = ps.personal_id_personal WHERE sm.id_servicioMedico =:id_servicioMedico AND p.id_personal = :id_doctor");
        $consulta->bindParam(":id_servicioMedico", $id_servicioMedico);
        $consulta->bindParam(":id_doctor", $id_doctor);
        $consulta->execute();

        while ($consulta->fetch()) {
            return "existeC";
        }

        return 0;
    }
}
