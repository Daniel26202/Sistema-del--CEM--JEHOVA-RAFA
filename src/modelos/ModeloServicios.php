<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\modelos\ModeloDoctores;
use App\modelos\ModeloCategoria;

class ModeloServicios extends ModelBase
{

    private $id_servicioMedico, $precio, $tipo, $id_doctor, $idCategoria;

    public function __construct($dbSystem = true)
    {
        parent::__construct($dbSystem);
    }

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
    public function mostrarServicios()
    {
        try {
            $sql =  "SELECT *,cs.nombre as categoria FROM serviciomedico sm INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE cs.estado = 'ACT' AND sm.estado = 'ACT'";

            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function mostrarServiciosDoctor()
    {
        try {

            $data = ['id_doctor' => $this->getIdDoctor()];

            $sql = "SELECT categoria_nombre.nombre as categoria, serviciomedico.id_servicioMedico, p.nombre AS nombre_personal, p.apellido AS apellido_personal, p.id_personal AS id_personal, serviciomedico.precio, e.nombre AS nombre_especialidad, serviciomedico.id_servicioMedico, categoria_nombre.nombre AS nombre_categoria FROM bd.personal p INNER JOIN bd.personal_has_serviciomedico ps ON ps.personal_id_personal = p.id_personal INNER JOIN
            bd.serviciomedico ON ps.serviciomedico_id_servicioMedico = serviciomedico.id_servicioMedico INNER JOIN bd.especialidad e ON e.id_especialidad = p.id_especialidad INNER JOIN bd.categoria_servicio categoria_nombre ON categoria_nombre.id_categoria = serviciomedico.id_categoria  WHERE serviciomedico.estado = 'ACT' AND categoria_nombre.estado = 'ACT' AND serviciomedico.estado = 'ACT' AND ps.personal_id_personal  = :id_doctor";
            $this->setSQL($sql);
            return $this->search($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function mostrarServiciosDes()
    {
        try {
            $sql = 'SELECT *,cs.nombre as categoria FROM serviciomedico sm INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE cs.estado = "DES" OR sm.estado = "DES"';
            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function insertarSevicio()
    {
        try {

            $sql = "SELECT * FROM  categoria_servicio where id_categoria=:id_categoria";
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



    public function insertarDoctorServicio()
    {
        try {
            $data1 = ['id_servicioMedico' => $this->getIdServicioMedico()];
            $data2 = ['id_personal' => $this->getIdDoctor()];

            $data3 = [
                'id_doctor' => $this->getIdDoctor(),
                'id_servicioMedico' => $this->getIdServicioMedico()
            ];

            $sql = "SELECT * from serviciomedico where id_servicioMedico=:id_servicioMedico";
            $this->setSQL($sql);

            $validar  = $this->search($data1, false);

            if ($validar == []) {
                throw new \Exception("El id del servicio no existe");
            }

            $sql = "SELECT * from personal where id_personal=:id_personal";
            $this->setSQL($sql);

            $validar  = $this->search($data2, false);

            if ($validar == []) {
                throw new \Exception("El id del doctor no existe");
            }
            if ($this->validarServicioDoctor()) {
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

    public function eliminar()
    {
        try {
            $data = [
                'id_servicioMedico' => $this->getIdServicioMedico()
            ];

            $sql = "SELECT * from serviciomedico where id_servicioMedico=:id_servicioMedico";
            $this->setSQL($sql);

            $validar  = $this->search($data, false);

            if ($validar == []) {
                throw new \Exception("El id del paciente no existe");
            }

            $sql = "UPDATE servicioMedico SET estado = 'DES' WHERE id_servicioMedico =:id";
            $this->setSQL($sql);

            $this->update_logic($data['id_servicioMedico']);
            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function restablecerServ()
    {
        try {
            $data = [
                'id_servicioMedico' => $this->getIdServicioMedico()
            ];

            $sql = "SELECT * from serviciomedico where id_servicioMedico=:id_servicioMedico";
            $this->setSQL($sql);

            $validar  = $this->search($data, false);

            if ($validar == []) {
                throw new \Exception("El id del paciente no existe");
            }

            $sql = "UPDATE servicioMedico SET estado = 'ACT' WHERE id_servicioMedico =:id";
            $this->setSQL($sql);

            $this->update_logic($data['id_servicioMedico']);
            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function editar()
    {
        try {


            $sql = "SELECT * from serviciomedico where id_servicioMedico=:id_servicioMedico";
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


    //traer datos del doctor
    public function especialidadDoctor()
    {
        try {
            $data = [
                'id_doctor' => $this->getIdDoctor()
            ];

            $sql = "SELECT e.nombre FROM personal d INNER JOIN especialidad e ON e.id_especialidad = d.id_especialidad WHERE d.id_personal = :id_doctor ";
            $this->setSQL($sql);

            $this->read();
        } catch (\Exception $e) {
            return 0;
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

            $sql = "SELECT *,cs.nombre as categoria FROM serviciomedico sm INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE cs.id_categoria = :id_categoria AND sm.estado =:estado AND sm.tipo = :tipo";
            $this->setSQL($sql);
            $listData = $this->search($data, false);
            return !empty($listData) ? 1 : 0;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //Validdar que un doctor no tenga el mismo servicio
    public function validarServicioDoctor()
    {
        try {
            $data = [
                'id_servicioMedico' => $this->getIdServicioMedico(),
                'id_personal' => $this->getIdDoctor()
            ];

            $sql = "SELECT *,cs.nombre as categoria FROM serviciomedico sm INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria INNER JOIN  personal_has_serviciomedico ps ON ps.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN personal p ON p.id_personal = ps.personal_id_personal WHERE sm.id_servicioMedico =:id_servicioMedico AND p.id_personal = :id_doctor";
            $this->setSQL($sql);
            $listData = $this->search($data, false);

            return !empty($listData) ? 1 : 0;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

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
            throw new \InvalidArgumentException("El precio esta mal.");
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
