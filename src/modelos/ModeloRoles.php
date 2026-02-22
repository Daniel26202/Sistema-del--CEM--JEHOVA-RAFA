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

    private function retrunObjectModel()
    {
        return new ModeloPermisos();
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


    //Consultar el permiso
    public function mostrarPermisos()
    {
        try {
            $data = [
                'id_rol' => $this->getIdRol()
            ];

            $sql = "SELECT modulo, permisos FROM permisos WHERE id_rol = :id_rol";
            $this->setSQL($sql);

            // Obtenemos los datos crudos de la DB (suponiendo que search() devuelve un array de filas)
            $resultados = $this->search($data);

            // --- PROCESAMIENTO PARA JS ---
            $permisosParaJS = [];

            if (is_array($resultados)) {
                foreach ($resultados as $fila) {
                    // Forzamos a que sea un array si search() devuelve objetos
                    $fila = (array)$fila;

                    // Mapeamos: "NombreModulo" => "permiso1,permiso2"
                    // Si el permiso es null, guardamos cadena vacía
                    $permisosParaJS[$fila['modulo']] = $fila['permisos'] ?? "";
                }
            }

            return $permisosParaJS;
        } catch (\Exception $e) {
            // En caso de error, podrías registrar el log y retornar array vacío
            error_log($e->getMessage());
            return [];
        }
    }




    //Insertar  Rol

    public function insertar()
    {
        try {
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

            // //recorro los modulos enviados por el formulario
            // foreach ($this->getModulos() as $index => $modulo) {
            //     $grupoDelPermiso = $this->retrunObjectModel()->getPermisos()[$index];
            //     $permisos = isset($_POST[$grupoDelPermiso]) ? implode(",", $_POST[$grupoDelPermiso]) : '';

            //     $data=[
            //         'id_rol'=>$this->getIdRol(),
            //         'permisos'=>$permisos,
            //         'modulo'=> $this->retrunObjectModel()->getModulo()
            //     ];
            //     $sql = "INSERT INTO permisos (idpermisos, id_rol, permisos, modulo) VALUES (NULL, :id_rol, :permisos, :modulo)";
            //     $this->setSQL($sql);
            //     $this->create($data);
            // }


            // 2. Preparar la conexión (ejemplo PDO)
            // $pdo = new PDO(...);

            // 3. Iterar sobre TODOS los módulos
            foreach ($this->getModulos() as $moduloNombre) {

                // Verificamos si el módulo actual tiene permisos marcados
                // Si existe, los unimos con comas; si no, queda como cadena vacía
                $cadenaPermisos = "";
                if (isset($this->getPermisos()[$moduloNombre])) {
                    $cadenaPermisos = implode(',', $this->getPermisos()[$moduloNombre]);
                }
                $data = [
                    'id_rol' => $id_rol,
                    'permisos' => $cadenaPermisos,
                    'modulo' => $moduloNombre
                ];
                $sql = "INSERT INTO permisos (idpermisos, id_rol, permisos, modulo) VALUES (NULL, :id_rol, :permisos, :modulo)";
                $this->setSQL($sql);
                $this->create($data);
            }

            return ["exito", $data];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    //modificar Rol
    public function editar()
    {
        try {
            $data1 = [
                'nombre' => $this->getNombre(),
                'descripcion' => $this->getDescripcion()
            ];

            $data2 = [
                'id_rol' => $this->getIdRol(),
            ];

            $sql = "SELECT * from rol where id_rol=:id_rol";
            $this->setSQL($sql);

            $validar  = $this->search($data2, false);

            if ($validar == []) {
                throw new \Exception("El id del rol no existe");
            }

            $nombreRol = $this->validarRol(['nombre' => $this->getNombre()], true);

            //Editar Rol
            if ($this->getNombreRegistrado() == $nombreRol) {
                $sql = "UPDATE rol SET  nombre =:nombre, descripción =:descripcion WHERE id_rol = :id";
                $this->setSQL($sql);
                $this->update($data1, $this->getIdRol());
            } else {
                if ($this->validarRol(['nombre' => $this->getNombre()])) {
                    throw new \Exception("El nombre ya está registrado.");
                } else {
                    $sql = "UPDATE rol SET  nombre =:nombre, descripción =:descripcion WHERE id_rol = :id";
                    $this->setSQL($sql);
                    $this->update($data1, $this->getIdRol());
                }
            }

            //Recorro los modulos enviados por el formulario
            foreach ($this->getModulos() as $moduloNombre) {

                // Verificamos si el módulo actual tiene permisos marcados
                // Si existe, los unimos con comas; si no, queda como cadena vacía
                $cadenaPermisos = "";
                if (isset($this->getPermisos()[$moduloNombre])) {
                    $cadenaPermisos = implode(',', $this->getPermisos()[$moduloNombre]);
                }
                $data = [
                    'permisos' => $cadenaPermisos,
                    'modulo' => $moduloNombre
                ];
                $sql = "UPDATE  permisos SET  permisos =:permisos WHERE modulo =:modulo AND id_rol =:id";
                $this->setSQL($sql);
                $this->update($data, $this->getIdRol());
            }

            return ["exito"];
        } catch (\Exception $e) {

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
