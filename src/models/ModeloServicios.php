<?php

namespace App\models;

use App\models\ModelBase;
use App\models\interfaces\InterfaceConnection;
use App\models\interfaces\InterfaceValidator;
use App\models\TraitCreate;
use App\models\TraitUpdate;


class ModeloServicios extends ModelBase
{

    private $id_servicioMedico, $precio, $tipo;
    private $validator;
    use TraitCreate,TraitUpdate;

    public function __construct(InterfaceConnection $conn, ?InterfaceValidator $vali=null)
    {
        parent::__construct($conn);
        $this->validator = $vali;
    }

    // ── READ ────────────────────────────────────────────────
    public function mostrarServicios($estado ='ACT',$start = 0, $limit = 10, $search = '', $ordenColumn = 'id_servicioMedico', $ordenDir = 'DESC')
    {
        $coditions = [
            'condiciones' => ['sm.estado' => $estado,'cs.estado'=>'ACT'],
            'conectores' => ['AND'],
            'operadores' => ['=','=']
        ];
        $alias =[
            'sm','cs'
        ];
        $unions =[
            'cs.id_categoria = sm.id_categoria'
        ];
        $this->set_tables(["serviciomedico","categoria_servicio"]);
        $this->set_colums(['sm.id_servicioMedico','sm.id_categoria','sm.precio','sm.tipo','cs.nombre AS categoria']);
        $this->set_alias($alias);
        $this->set_union($unions);

        $this->set_search($search);
        $this->set_start($start);
        $this->set_limit($limit);
        $this->set_orden_dir($ordenDir);
        $this->set_orden_column($ordenColumn);
        $this->set_condicion_aditional($coditions);

        return $this->pagination();
    }


    public function mostrarServiciosDoctor()
    {
        $coditions = [
            'condiciones' => ['sm.estado' => 'ACT', 'cs.estado' => 'ACT'],
            'conectores' => ['AND'],
            'operadores' => ['=', '=']
        ];
        $alias = [
            'p',
            'ps',
            'sm',
            'e',
            'cs'
        ];
        $unions = [
            'ps.personal_id_personal = p.id_personal',
            'ps.serviciomedico_id_servicioMedico = sm.id_servicioMedico',
            'e.id_especialidad = p.id_especialidad',
            'cs.id_categoria = sm.id_categoria'
        ];
        $this->set_tables(["personal", "personal_has_serviciomedico","serviciomedico", "especialidad", "categoria_servicio"]);
        $this->set_colums(['cs.nombre AS categoria', 'sm.id_servicioMedico','p.nombre AS nombre_personal', 'p.apellido AS apellido_personal', 'p.id_personal AS id_personal', 'sm.precio', 'e.nombre AS nombre_especialidad']);
        $this->set_alias($alias);
        $this->set_union($unions);
        $this->set_condicion_aditional($coditions);
        return $this->read();
    }


    public function nombreServicio()
    {
        $coditions = [
            'condiciones' => ['cs.id_categoria'=>$this->getIdCategoria(),'sm.estado' => 'ACT', 'sm.tipo' => $this->getTipo()],
            'conectores' => ['AND', 'AND'],
            'operadores' => ['=', '=','=']
        ];
        $alias = [
            'sm',
            'cs'
        ];
        $unions = [
            'cs.id_categoria = sm.id_categoria'
        ];
        $this->set_tables(["serviciomedico","categoria_servicio"]);
        $this->set_colums(['sm.id_servicioMedico','sm.id_categoria','sm.precio','sm.tipo','cs.nombre AS categoria']);
        $this->set_alias($alias);
        $this->set_union($unions);
        $this->set_condicion_aditional($coditions);
        $listData = $this->read(false);
        return !empty($listData) ? 1 : 0;
    }

    //Validdar que un doctor no tenga el mismo servicio
    public function validarServicioDoctor($data)
    {
        $coditions = [
            'condiciones' => ['m.id_servicioMedico' => $this->getIdServicioMedico(), 'p.id_personal' =>$this->getIdDoctor()],
            'conectores' => ['AND'],
            'operadores' => ['=', '=']
        ];
        $alias = [
            'sm',
            'cs',
            'ps',
            'p'
        ];
        $unions = [
            'cs.id_categoria = sm.id_categoria',
            'ps.serviciomedico_id_servicioMedico = sm.id_servicioMedico',
            'p.id_personal = ps.personal_id_personal'
        ];

        $this->set_tables(["serviciomedico", "categoria_servicio"]);
        $this->set_colums(['sm.id_servicioMedico','sm.id_categoria','sm.precio','sm.tipo','cs.nombre AS categoria']);
        $this->set_alias($alias);
        $this->set_union($unions);
        $this->set_condicion_aditional($coditions);
        $listData = $this->read(false);
        return !empty($listData) ? 1 : 0;
    }

    // ── PRIVADOS─────────────────────────────────────────


    // private function insertarSevicio()
    // {
    //     try {

    //         $sql = "SELECT id_categoria,nombre FROM  categoria_servicio where id_categoria=:id_categoria";
    //         $this->setSQL($sql);
    //         $data = ['id_categoria' => $this->getIdCategoria()];

    //         $validar = $this->search($data);

    //         if ($validar == []) {
    //             throw new \Exception("El id de la categoria no existe");
    //         }

    //         if ($this->nombreServicio()) {
    //             throw new \Exception("El Servicio Medico  ya  existe");
    //         }


    //         $sql = "INSERT INTO serviciomedico (id_categoria, precio, estado, tipo) VALUES (:id_categoria, :precio, :estado, :tipo)";

    //         $this->setSQL($sql);
    //         $data = [
    //             'id_categoria' => $this->getIdCategoria(),
    //             'precio' => $this->getPrecio(),
    //             'estado' => 'ACT',
    //             'tipo' => $this->getTipo()
    //         ];
    //         $this->create($data);

    //         return ["exito", $data];
    //     } catch (\Exception $e) {
    //         return $e->getMessage();
    //     }
    // }

    // private function insertarDoctorServicio()
    // {
    //     try {
    //         $data1 = ['id_categoria' => $this->getIdCategoria()];

    //         $data2 = ['id_personal' => $this->getIdDoctor()];

    //         $sql = "SELECT id_categoria,id_servicioMedico FROM serviciomedico where id_categoria =:id_categoria";
    //         $this->setSQL($sql);
    //         $dataSer =  $this->search($data1,false);

    //         $data3 = [
    //             'id_doctor' => $this->getIdDoctor(),
    //             'id_servicioMedico' => $dataSer['id_servicioMedico'],
    //         ];

    //         $sql = "SELECT id_categoria from categoria_servicio where id_categoria=:id_categoria";
    //         $this->setSQL($sql);

    //         $validar  = $this->search($data1, false);

    //         if ($validar == []) {
    //             throw new \Exception("El id del servicio no existe");
    //         }

    //         $sql = "SELECT id_personal from personal where id_personal=:id_personal";
    //         $this->setSQL($sql);

    //         $validar  = $this->search($data2, false);

    //         if ($validar == []) {
    //             throw new \Exception("El id del doctor no existe");
    //         }
    //         if ($this->validarServicioDoctor($data3)) {
    //             throw new \Exception("EL Servicio ya esta asignado a este doctor");
    //         }

    //         $sql = "INSERT INTO personal_has_serviciomedico (personal_id_personal, serviciomedico_id_servicioMedico) VALUES (:id_doctor, :id_servicioMedico)";

    //         $this->setSQL($sql);
    //         $this->create($data3);

    //         return ["exito"];
    //     } catch (\Exception $e) {
    //         return $e->getMessage();
    //     }
    // }


    // private function editar()
    // {
    //     try {


    //         $sql = "SELECT id_servicioMedico from serviciomedico where id_servicioMedico=:id_servicioMedico";
    //         $this->setSQL($sql);

    //         $data2 = [
    //             'id_servicioMedico' => $this->getIdServicioMedico()
    //         ];
    //         $validar  = $this->search($data2, false);

    //         if ($validar == []) {
    //             throw new \Exception("El id del servicio no existe");
    //         }
    //         if ($this->nombreServicio()) {
    //             throw new \Exception("El tipo de servicio, ya existe");
    //         }

    //         $sql = "UPDATE serviciomedico SET precio = :precio, tipo= :tipo WHERE id_servicioMedico = :id";
    //         $this->setSQL($sql);

    //         $data1 = [
    //             'precio' => $this->getPrecio(),
    //             'tipo' => $this->getTipo(),
    //         ];
    //         $this->update($data1, $this->getIdServicioMedico());
    //         return ["exito"];
    //     } catch (\Exception $e) {
    //         return $e->getMessage();
    //     }
    // }



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
            throw new \InvalidArgumentException("El precio esta mal.".$precio);
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
