<?php

namespace App\models;

use App\models\ModelBase;
use App\models\interfaces\InterfaceConnection;
use App\models\interfaces\InterfaceValidator;
use App\models\TraitCreate;
use App\models\TraitUpdate;
use App\models\TraitDelete;



class ModeloRoles extends ModelBase
{
    private $id_rol, $nombre, $descripcion, $permisos, $modulos;
    private $validator;
    use TraitCreate, TraitUpdate,TraitDelete;

    public function __construct(InterfaceConnection $conn, ?InterfaceValidator $vali = null)
    {
        parent::__construct($conn);
        $this->validator = $vali;
        $this->set_tables(['rol']);
    }

    // ── READ ────────────────────────────────────────────────

    //consultar los roles disponibles
    public function roles()
    {
        $coditions = [
            'condiciones' => ['estado' => 'ACT'],
            'conectores' => [],
            'operadores' => ['=']
        ];
        $this->set_tables(['rol']);
        $this->set_colums(['id_rol', 'nombre', 'descripcion']);
        $this->set_condicion_aditional($coditions);

        return $this->read();
    }

    //consultar los permisos por modulo de un rol


    //Consultar el permiso
    // public function mostrarPermisos()
    // {
    //     try {
    //         $data = [
    //             'id_rol' => $this->getIdRol()
    //         ];

    //         $sql = "SELECT pr.id_modulo,m.nombre AS modulo, pr.id_permiso, p.permisos FROM permisos_de_rol pr INNER JOIN permisos p ON p.id_permiso =pr.id_permiso INNER JOIN modulos m ON m.id_modulo = pr.id_modulo WHERE pr.id_rol =:id_rol";
    //         $this->setSQL($sql);

    //         // Obtenemos los datos crudos de la DB (suponiendo que search() devuelve un array de filas)
    //         $resultados = $this->search($data);



    //         // --- PROCESAMIENTO PARA JS ---
    //         $result = [];


    //         $permisos = $this->returnPermisos();

    //         foreach ($resultados as $fila) {
    //             $listPermisos = [];

    //             $permisos = $this->returnPermisosModulo(['id_rol' => $data['id_rol'], 'modulo' => $fila['modulo']]);
    //             array_push($listPermisos, $permisos);

    //             $result[$fila['modulo']] = $permisos;
    //         }

    //         return $result;
    //     } catch (\Exception $e) {
    //         // En caso de error, podrías registrar el log y retornar array vacío
    //         error_log($e->getMessage());
    //         return $e;
    //     }
    // }


    public function returnPermisos()
    {
        $this->set_tables(['permisos']);
        $this->set_colums(['id_permiso', 'permisos']);
        return $this->read();
    }

    //metodo para validar que no se registren dos roles con el mismo nombre
    public function validarRol()
    {
        $coditions = [
            'condiciones' => ['nombre' => $this->getNombre(), 'id_rol' => $this->getIdRol()],
            'conectores' => ['AND'],
            'operadores' => ['=', '!=']
        ];
        $this->set_tables(["rol"]);
        $this->set_colums(['nombre']);
        $this->set_condicion_aditional($coditions);
        $listData = $this->read(false);

        return !empty($listData) ? 1 : 0;
    }


    // ── PRIVADOS─────────────────────────────────────────

    private function returnPermisosModulo($data)
    {

        $alias = ['pr', 'p', 'm'];
        $unions = [
            'p.id_permiso =pr.id_permiso',
            'm.id_modulo = pr.id_modulo'
        ];
        $coditions = [
            'condiciones' => ['pr.id_rol' => $this->getIdRol(), 'm.nombre' => $this->getNombre()],
            'conectores' => ['AND'],
            'operadores' => ['=', '=']
        ];

        $this->set_tables(['permisos_de_rol', 'permisos', 'modulos']);
        $this->set_colums(['m.nombre AS modulo', 'pr.id_permiso', 'p.permisos']);
        $this->set_condicion_aditional($coditions);
        $this->set_union($unions);
        $this->set_alias($alias);

        $datos = $this->read();
        
        $permisos = '';
        foreach ($datos as $d) {
            $permisos .= $d['id_permiso'] . ",";
        }
        return $permisos;
    }

    private function returnIdModule(string $modulo)
    {
        $coditions = [
            'condiciones' => ['nombre' => $modulo],
            'conectores' => [],
            'operadores' => ['=']
        ];
        $this->set_tables(['modulos']);
        $this->set_colums(['id_modulo']);
        $this->set_condicion_aditional($coditions);

        $listData = $this->read(false);
        return !empty($listData) ?  $listData['id_modulo'] : 0;
    }


    //Insertar  Rol

    private function insertar()
    {
        try {
            $this->beginTransaction();

            $data = [
                'nombre' => $this->getNombre(),
                'estado' => 'ACT',
                'descripcion' => $this->getDescripcion()
            ];

            if ($this->validarRol()) {
                throw new \Exception("El nombre del rol ya se encuentra registrado");
            }

            $this->set_tables(['rol']);
            //Insertar Rol
            $id_rol = $this->guardar($data,$this->validator);
            $id_rol = $id_rol[0];

            //itertar todos lo modulos
            $listPermisoPorModulo = [];
            foreach ($this->getModulos() as $modulo) {
                if (isset($this->getPermisos()[$modulo])) {
                    $listPermisoPorModulo[] = [
                        'permisos' => $this->getPermisos()[$modulo],
                        'modulo' => $modulo
                    ];
                }
            }

            foreach ($listPermisoPorModulo as $list) {
                foreach ($list['permisos'] as $permiso) {
                    $data = [
                        'id_rol' => $id_rol,
                        'id_permiso' => $permiso,
                        'id_modulo' => $this->returnIdModule($list['modulo']),
                    ];
                    $this->set_tables(['permisos_de_rol']);

                    $this->guardar($data,$this->validator);
                }
            }
            $this->commit();
            return ["exito", $this->getModulos()];
        } catch (\Exception $e) {
            $this->rollBack();
            return $e->getMessage();
        }
    }


    //modificar Rol
    private function editar()
    {
        try {
            $this->beginTransaction();

            $coditions = [
                'condiciones' => ['id_rol' => $this->getIdRol()],
                'conectores' => [],
                'operadores' => ['=']
            ];
            $this->set_tables(['rol']);
            $this->set_colums(['id_rol']);
            $this->set_condicion_aditional($coditions);

            $validar = $this->read(false);

            if (empty($validar)) {
                throw new \Exception("El id del rol no existe");
            }

            if ($this->validarRol()) {
                throw new \Exception("El nombre del rol ya se encuentra registrado");
            }
            // 3. Actualizar datos básicos del Rol
            $data_rol = [
                'nombre' => $this->getNombre(),
                'descripcion' => $this->getDescripcion()
            ];
            $this->actualizar($data_rol,['id_rol'=>$this->getIdRol()],$this->validator);

            //limpiar permisos anteriores para evitar duplicidad
            $this->set_tables(['permisos_de_rol']);
            $this->eliminar(['id_rol'=>$this->getIdRol()],$this->validator);

            // insertar los nuevos permisos
            foreach ($this->getModulos() as $moduloNombre) {
                // verificar si este módulo tiene permisos asignados 
                if (isset($this->getPermisos()[$moduloNombre]) && is_array($this->getPermisos()[$moduloNombre])) {

                    foreach ($this->getPermisos()[$moduloNombre] as $id_permiso) {
                        $data_permiso = [
                            'id_rol' => $this->getIdRol(),
                            'id_permiso' => $id_permiso,
                            'id_modulo' => $this->returnIdModule($moduloNombre),
                        ];

                        $this->guardar($data_permiso,$this->validator);
                    }
                }
            }
            $this->commit();
            return ["exito"];
        } catch (\Exception $e) {
            $this->rollBack();
            return $e->getMessage();
        }
    }



    ///getters and setters

    public function getIdRol()
    {
        return $this->id_rol;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }


    public function getPermisos()
    {
        return $this->permisos;
    }

    public function getModulos()
    {
        return $this->modulos;
    }


    public function setIdRol($id_rol)
    {
        if (!preg_match("/^[0-9]+$/", $id_rol)) {
            throw new \InvalidArgumentException("El ID del rol debe ser un número entero positivo.");
        }

        if ((int)$id_rol <= 0) {
            throw new \InvalidArgumentException("El ID del rol debe ser mayor que cero.");
        }

        $this->id_rol = (int)$id_rol;
    }


    public function setNombre($nombre)
    {
        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/", $nombre)) {
            throw new \InvalidArgumentException("El Nombre debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres");
        }
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion)
    {
        if (!preg_match("/^([A-Za-z0-9\s\.,#-]{8,})$/", $descripcion)) {
            throw new \InvalidArgumentException("La descripcion debe estar completa y detallada.");
        }
        $this->descripcion = $descripcion;
    }


    public function setModulos($modulos)
    {
        if (!is_array($modulos)) {
            throw new \InvalidArgumentException("Los modulos no es valido.");
        }

        $this->modulos = $modulos;
    }

    public function setPermisos($permisos)
    {
        if (!is_array($permisos)) {
            throw new \InvalidArgumentException("El permisos no es valido.");
        }

        $this->permisos = $permisos;
    }
}
