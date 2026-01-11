<?php

namespace App\modelos;

use App\modelos\ModelBase;

class ModeloCliente extends ModelBase
{

    private $id_cliente, $nacionalidad, $cedula, $cedulaRegistrada, $nombre, $apellido, $telefono, $direccion, $fn, $genero;


    public function __construct($dbSystem)
    {
        parent::__construct($dbSystem);
    }

    public function index()
    {
        try {
            $sql= "SELECT * FROM cliente WHERE estado = 'ACT' ";
            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function indexPapelera()
    {
        try {
            $sql = "SELECT * FROM cliente WHERE estado = 'DES' ";
            $this->setSQL($sql);
            return $this->read();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function insertar()
    {

        try {
            $data = [
                'nacionalidad' => $this->getNacionalidad(),
                'cedula' => $this->getCedula(),
                'nombre' => $this->getNombre(),
                'apellido' => $this->getApellido(),
                'telefono' => $this->getTelefono(),
                'direccion' => $this->getDireccion(),
                'fn' => $this->getFn(),
                'genero' => $this->getGenero(),
                'estado' => 'ACT'
            ];

            // Validación de cédula duplicada
            if ($this->validarCedula(['cedula' => $this->getCedula()])) {
                throw new \Exception("La cédula ya está registrada.");
            }

            $sql = "INSERT INTO cliente (nacionalidad, cedula, nombre, apellido, telefono, direccion, fn, genero,estado) VALUES (:nacionalidad, :cedula, :nombre, :apellido, :telefono, :direccion, :fn, :genero, :estado)";
            $this->setSQL($sql);

            $id_cliente  = $this->create($data);
            return ["exito", $id_cliente];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function update_cliente()
    {
        try {
            $data = [
                'nacionalidad' => $this->getNacionalidad(),
                'cedula' => $this->getCedula(),
                'nombre' => $this->getNombre(),
                'apellido' => $this->getApellido(),
                'telefono' => $this->getTelefono(),
                'direccion' => $this->getDireccion(),
                'fn' => $this->getFn(),
                'genero' => $this->getGenero()
            ];


            $data2 = [
                'id_cliente' => $this->getIdCliente()
            ];

            $sql = "SELECT * from cliente where id_cliente=:id_cliente";
            $this->setSQL($sql);

            $validar  = $this->search($data2, false);

            if ($validar == []) {
                throw new \Exception("El id del cliente no existe");
            }

            $cedula = $this->validarCedula(['cedula' => $this->getCedula()], true);


            if ($this->getCedulaRegistrada() == $cedula) {

                $sql = "UPDATE cliente SET nacionalidad=:nacionalidad, cedula=:cedula, nombre=:nombre, apellido=:apellido, telefono=:telefono, direccion=:direccion, fn=:fn, genero=:genero WHERE id_cliente = :id";

                $this->setSQL($sql);
                $this->update($data, $this->getIdCliente());
            } else {
                // Validación de cédula duplicada
                if ($this->validarCedula(['cedula' => $this->getCedula()])) {
                    throw new \Exception("La cédula ya está registrada.");
                } else {
                    $sql = "UPDATE cliente SET nacionalidad=:nacionalidad, cedula=:cedula, nombre=:nombre, apellido=:apellido, telefono=:telefono, direccion=:direccion, fn=:fn, genero=:genero WHERE id_cliente = :id";

                    $this->setSQL($sql);
                    $this->update($data, $this->getIdCliente());
                }
            }

            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete()
    {
        try {
            $data = [
                'id_cliente' => $this->getIdCliente()
            ];

            $sql = "SELECT * from cliente where id_cliente=:id_cliente";
            $this->setSQL($sql);

            $validar  = $this->search($data, false);

            if ($validar == []) {
                throw new \Exception("El id del cliente no existe");
            }

            $sql = "UPDATE cliente SET estado = 'DES' WHERE id_cliente =:id";
            $this->setSQL($sql);

            $this->update_logic($data['id_cliente']);
            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function restablecer($id_cliente)
    {
        try {
            $data = [
                'id_cliente' => $this->getIdCliente()
            ];

            $sql = "SELECT * from cliente where id_cliente=:id_cliente";
            $this->setSQL($sql);

            $validar  = $this->search($data, false);

            if ($validar == []) {
                throw new \Exception("El id del cliente no existe");
            }

            $sql = "UPDATE cliente SET estado = 'ACT' WHERE id_cliente =:id";
            $this->setSQL($sql);

            $this->update_logic($data['id_cliente']);
            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function buscar()
    {
        try {
            $data =  ['cedula'=>$this->getCedula()];
            $sql = "SELECT paciente.id_paciente, paciente.nacionalidad, paciente.cedula, paciente.nombre, paciente.apellido, paciente.telefono, paciente.direccion, paciente.fn, patologia.id_patologia, patologia.nombre_patologia FROM paciente JOIN patologiadepaciente ON paciente.id_paciente = patologiadepaciente.id_paciente JOIN patologia ON patologiadepaciente.id_patologia = patologia.id_patologia WHERE paciente.cedula = :cedula AND paciente.estado = 'ACT'";
            $this->setSQL($sql);

            return $this->search($data);
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function validarCedula($data, $returnCedula  =false)
    {
        try {
            $sql = "SELECT * FROM cliente WHERE cedula =:cedula";
            $this->setSQL($sql);
            $listData = $this->search($data, false);

            if ($returnCedula) {
                return !empty($listData) ? $listData['cedula'] : 0;
            } else {
                return !empty($listData) ? 1 : 0;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function getIdCliente()
    {
        return $this->id_cliente;
    }



    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }



    public function getCedula()
    {
        return $this->cedula;
    }



    public function getCedulaRegistrada()
    {
        return $this->cedulaRegistrada;
    }



    public function getNombre()
    {
        return $this->nombre;
    }


    public function getApellido()
    {
        return $this->apellido;
    }



    public function getTelefono()
    {
        return $this->telefono;
    }



    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getFn()
    {
        return $this->fn;
    }


    public function getGenero()
    {
        return $this->genero;
    }



    public function setIdPaciente($id_cliente)
    {
        if (!preg_match("/^[0-9]+$/", $id_cliente)) {
            throw new \InvalidArgumentException("El ID del paciente debe ser un número entero positivo.");
        }

        if ((int)$id_cliente <= 0) {
            throw new \InvalidArgumentException("El ID del paciente debe ser mayor que cero.");
        }

        $this->id_cliente = (int)$id_cliente;
    }


    public function setNacionalidad($nacionalidad)
    {
        if (!preg_match("/^[A-Z]{1,3}$/", $nacionalidad)) {
            throw new \InvalidArgumentException("La nacionalidad debe ser V o E.");
        }
        $this->nacionalidad = $nacionalidad;
    }

    public function setCedula($cedula)
    {
        if (!preg_match("/^([1-9]{1})([0-9]{7,8})$/", $cedula)) {
            throw new \InvalidArgumentException("La cédula debe contener entre 7 y 8 dígitos.");
        }
        $this->cedula = $cedula;
    }

    public function setCedulaRegistrada($cedula)
    {
        if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/", $cedula)) {
            throw new \InvalidArgumentException("La cédula registrada debe contener entre 7 y 8 dígitos.");
        }
        $this->cedulaRegistrada = $cedula;
    }

    public function setNombre($nombre)
    {
        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/", $nombre)) {
            throw new \InvalidArgumentException("El Nombre debe contener solo letras ademas iniciar con una letra mayúscula y tenga al menos 3 caracteres");
        }
        $this->nombre = $nombre;
    }

    public function setApellido($apellido)
    {
        if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/", $apellido)) {
            throw new \InvalidArgumentException("El Apellido debe contener solo letras, iniciar con mayúscula y tener al menos 3 caracteres.");
        }
        $this->apellido = $apellido;
    }

    public function setTelefono($telefono)
    {
        if (!preg_match("/^(0?)(412|422|414|416|424|426|212|24[1-9]|25[1-9])\d{7}$/", $telefono)) {
            throw new \InvalidArgumentException("El teléfono debe comenzar con un código válido y contener solo números.");
        }
        $this->telefono = $telefono;
    }

    public function setDireccion($direccion)
    {
        if (!preg_match("/^([A-Za-z0-9\s\.,#-]{8,})$/", $direccion)) {
            throw new \InvalidArgumentException("La dirección debe estar completa y detallada.");
        }
        $this->direccion = $direccion;
    }

    public function setFn($fn)
    {
        $dt = \DateTime::createFromFormat('Y-m-d', $fn);
        $fechaHoy = date("Y-m-d");

        if (!$dt || $dt->format('Y-m-d') !== $fn) {
            throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
        }
        if ($fn >= $fechaHoy) {
            throw new \InvalidArgumentException("La fecha no puede ser del futuro.");
        }
        $this->fn = $fn;
    }

    public function setGenero($genero)
    {
        if (!preg_match("/^(Masculino|Femenino)$/", $genero)) {
            throw new \InvalidArgumentException("El género debe ser 'Masculino'  o 'Femenino' .");
        }
        $this->genero = $genero;
    }
}
