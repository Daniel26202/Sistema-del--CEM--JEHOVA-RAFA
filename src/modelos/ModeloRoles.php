<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\modelos\ModeloPermisos;


class ModeloRoles extends ModelBase
{
    private $id_rol, $nombre, $nombreRegistrado, $descripcion, $permisos, $modulos;

    public function __construct($dbSystem = false)
    {
        parent::__construct($dbSystem);
    }


    //consultar los roles disponibles
    public function roles()
    {
        try {
            $sql = "SELECT * FROM rol WHERE estado ='ACT'  ";
            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //consultar los permisos por modulo de un rol

    private function returnPermisosModulo($data)
    {
        try {
            $sql = "SELECT pr.modulo, pr.id_permiso, p.permisos FROM permisos_de_rol pr INNER JOIN permisos p ON p.id_permiso =pr.id_permiso WHERE pr.id_rol =:id_rol AND pr.modulo =:modulo ";
            $this->setSQL($sql);
            $datos = $this->search($data);
            $permisos = '';
            foreach ($datos as $d) {
                $permisos .= $d['id_permiso'] . ",";
            }
            return $permisos;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    //Consultar el permiso
    public function mostrarPermisos()
    {
        try {
            $data = [
                'id_rol' => $this->getIdRol()
            ];

            $sql = "SELECT pr.modulo, pr.id_permiso, p.permisos FROM permisos_de_rol pr INNER JOIN permisos p ON p.id_permiso =pr.id_permiso WHERE pr.id_rol =:id_rol";
            $this->setSQL($sql);

            // Obtenemos los datos crudos de la DB (suponiendo que search() devuelve un array de filas)
            $resultados = $this->search($data);



            // --- PROCESAMIENTO PARA JS ---
            $result = [];


            $permisos = $this->returnPermisos();

            foreach ($resultados as $fila) {
                $listPermisos = [];

                $permisos = $this->returnPermisosModulo(['id_rol' => $data['id_rol'], 'modulo' => $fila['modulo']]);
                array_push($listPermisos, $permisos);

                $result[$fila['modulo']] = $permisos;
            }

            return $result;
        } catch (\Exception $e) {
            // En caso de error, podrías registrar el log y retornar array vacío
            error_log($e->getMessage());
            return $e;
        }
    }


    public function returnPermisos()
    {
        try {
            $sql = "SELECT * FROM permisos";
            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    //Insertar  Rol

    public function insertar()
    {
        try {
            $this->beginTransaction();
            $data = [
                'nombre' => $this->getNombre(),
                'estado' => 'ACT',
                'descripcion' => $this->getDescripcion()
            ];

            if ($this->validarRol(['nombre' => $this->getNombre()])) {
                throw new \Exception("El nombre del rol ya se encuentra registrado");
            }

            //Insertar Rol
            $sql = "INSERT INTO rol (id_rol, nombre, estado, descripción) VALUES (NULL, :nombre, :estado, :descripcion)";
            $this->setSQL($sql);
            $id_rol = $this->create($data);



            // 2. Preparar la conexión (ejemplo PDO)
            // $pdo = new PDO(...);

            //3. Iterar sobre TODOS los módulos

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
                        'modulo' => $list['modulo'],
                    ];
                    $sql = "INSERT INTO permisos_de_rol(id_permisos_de_rol, id_rol, id_permiso, modulo) VALUES (null,:id_rol,:id_permiso,:modulo)";
                    $this->setSQL($sql);
                    $this->create($data);
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
    public function editar()
    {
        try {
            $this->beginTransaction();
            $id_rol = $this->getIdRol();

            // 1. Validar que el Rol existe
            $data_search = ['id_rol' => $id_rol];
            $sql_check = "SELECT id_rol FROM rol WHERE id_rol = :id_rol";
            $this->setSQL($sql_check);
            $validar = $this->search($data_search, false);

            if (empty($validar)) {
                throw new \Exception("El id del rol no existe");
            }

            // 2. Validar nombre duplicado (si el nombre cambió)
            $nombreNuevo = $this->getNombre();
            // Asumiendo que validarRol devuelve true si el nombre ya existe en OTRO registro
            if ($this->validarRol(['nombre' => $nombreNuevo], true)) {
                // Aquí deberías comparar si el nombre que existe es de este mismo ID o de otro
                // Si el método validarRol ya maneja esa lógica, perfecto.
            }

            // 3. Actualizar datos básicos del Rol
            $data_rol = [
                'nombre' => $nombreNuevo,
                'descripcion' => $this->getDescripcion()
            ];
            $sql_update_rol = "UPDATE rol SET nombre = :nombre, descripción = :descripcion WHERE id_rol = :id";
            $this->setSQL($sql_update_rol);
            $this->update($data_rol, $id_rol);

            // --- INICIO DE SINCRONIZACIÓN DE PERMISOS ---

            // 4. Limpiar permisos anteriores para evitar duplicidad o basura
            $sql_delete = "DELETE FROM permisos_de_rol WHERE id_rol = :id_rol";
            $this->setSQL($sql_delete);
            $this->create(['id_rol' => $id_rol]); // Usamos create o un método execute directo si lo tienes

            // 5. Insertar los nuevos permisos seleccionados
            foreach ($this->getModulos() as $moduloNombre) {
                // Verificamos si este módulo tiene permisos asignados en el POST/Objeto
                if (isset($this->getPermisos()[$moduloNombre]) && is_array($this->getPermisos()[$moduloNombre])) {

                    foreach ($this->getPermisos()[$moduloNombre] as $id_permiso) {
                        $data_permiso = [
                            'id_rol' => $id_rol,
                            'id_permiso' => $id_permiso,
                            'modulo' => $moduloNombre
                        ];

                        $sql_ins = "INSERT INTO permisos_de_rol (id_permisos_de_rol, id_rol, id_permiso, modulo) 
                                VALUES (NULL, :id_rol, :id_permiso, :modulo)";
                        $this->setSQL($sql_ins);
                        $this->create($data_permiso);
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

    //eliminar Rol

    public function eliminar()
    {
        try {
            $data = [
                'id_rol' => $this->getIdRol()
            ];

            $sql = "SELECT * from rol where id_rol=:id_rol";
            $this->setSQL($sql);

            $validar  = $this->search($data, false);

            if ($validar == []) {
                throw new \Exception("El id del rol no existe");
            }

            $sql = "UPDATE rol SET  estado ='DES' WHERE id_rol = :id";
            $this->setSQL($sql);

            $this->update_logic($data['id_rol']);
            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    //metodo para validar que no se registren dos roles con el mismo nombre
    public function validarRol($data, $returnNombre = false)
    {
        try {
            $sql = "SELECT * FROM rol WHERE nombre =:nombre";
            $this->setSQL($sql);
            $listData = $this->search($data, false);

            if ($returnNombre) {
                return !empty($listData) ? $listData['nombre'] : 0;
            } else {
                return !empty($listData) ? 1 : 0;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getIdRol()
    {
        return $this->id_rol;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getNombreRegistrado()
    {
        return $this->nombreRegistrado;
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

    public function setNombreRegistrado($nombreRegistrado)
    {
        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/", $nombreRegistrado)) {
            throw new \InvalidArgumentException("El Nombre Registrado debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres");
        }
        $this->nombreRegistrado = $nombreRegistrado;
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
