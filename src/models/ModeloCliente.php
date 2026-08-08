<?php

namespace App\models;

use App\models\ModelBase;
use App\models\TraitCreate;
use App\models\TraitUpdate;
use App\models\interfaces\InterfaceConnection;
use App\models\interfaces\InterfaceValidator;

class ModeloCliente extends ModelBase
{
    private $id_cliente, $nacionalidad, $cedula, $cedulaRegistrada, $nombre, $apellido, $telefono, $direccion, $fn, $genero,$estado;
    private $validator;

    use TraitCreate, TraitUpdate;
    
    public function __construct(InterfaceConnection $conn, InterfaceValidator $vali)
    {
        parent::__construct($conn);
        $this->set_tables(["cliente"]);
        $this->validator = $vali;
    }

    // ── READ ────────────────────────────────────────────────

    public function index($estado = 'ACT', $start = 0, $limit = 10, $search = '', $ordenColumn = 'id_cliente', $ordenDir = 'DESC')
    {
        $coditions = [
            'condiciones' => ['estado' => $estado],
            'conectores' => [],
            'operadores' => ['=']
        ];
        $this->set_tables(["cliente"]);
        $this->set_colums(['id_cliente', 'nacionalidad', 'cedula', 'nombre', 'apellido', 'telefono', 'direccion', 'fn', 'genero']);

        $this->set_search($search);
        $this->set_start($start);
        $this->set_limit($limit);
        $this->set_orden_dir($ordenDir);
        $this->set_orden_column($ordenColumn);
        $this->set_condicion_aditional($coditions);

        return $this->pagination();
    }


    public function validarCedula()
    {
        $coditions = [
            'condiciones' => ['cedula' => $this->getCedula(), 'id_cliente' => $this->getIdCliente()],
            'conectores' => ['AND'],
            'operadores' => ['=', '!=']
        ];
        $this->set_tables(["cliente"]);
        $this->set_colums(['id_cliente']);
        $this->set_condicion_aditional($coditions);
        $listData = $this->read(false);
        return !empty($listData) ? 1 : 0;
    }


    // ── Getters & Setters ─────────────────────────────────────────────────────


    public function get_all()
    {
        return [
            'nacionalidad' => $this->getNacionalidad(),
            'cedula' => $this->getCedula(),
            'nombre' => $this->getNombre(),
            'apellido' => $this->getApellido(),
            'telefono' => $this->getTelefono(),
            'direccion' => $this->getDireccion(),
            'fecha_de_nacimiento' => $this->getFn(),
            'genero' => $this->getGenero(),
            'estado' => $this->getEstado(),
        ];
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

    public function getEstado()
    {
        return $this->estado;
    }

    public function setIdCliente($id_cliente)
    {
        if (!preg_match("/^[0-9]+$/", $id_cliente) || (int)$id_cliente <= 0) {
            throw new \InvalidArgumentException("El ID del cliente debe ser un número entero positivo.");
        }
        $this->id_cliente = (int)$id_cliente;
    }

    public function setNacionalidad($nacionalidad)
    {
        if ($nacionalidad !== 'V' && $nacionalidad !== 'E') {
            throw new \InvalidArgumentException("La nacionalidad debe ser V o E.");
        }
        $this->nacionalidad = $nacionalidad;
    }

    public function setCedula($cedula)
    {
        if (!preg_match("/^([1-9]{1})([0-9]{6,7})$/", $cedula)) {
            throw new \InvalidArgumentException("La cédula debe contener entre 7 y 8 dígitos.");
        }
        $this->cedula = $cedula;
    }

    public function setCedulaRegistrada($cedula)
    {
        if (!preg_match("/^([1-9]{1})([0-9]{6,7})$/", $cedula)) {
            throw new \InvalidArgumentException("La cédula registrada debe contener entre 7 y 8 dígitos.");
        }
        $this->cedulaRegistrada = $cedula;
    }

    public function setNombre($nombre)
    {
        if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}(\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,})*$/", $nombre)) {
            throw new \InvalidArgumentException("El nombre debe iniciar con mayúscula, tener al menos 3 letras y puede incluir un segundo nombre separado por un espacio.");
        }
        $this->nombre = $nombre;
    }

    public function setApellido($apellido)
    {
        if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}(\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,})*$/", $apellido)) {
            throw new \InvalidArgumentException("El apellido debe iniciar con mayúscula, tener al menos 3 letras y puede incluir un segundo nombre separado por un espacio.");
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
        if (!$dt || $dt->format('Y-m-d') !== $fn) {
            throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
        }
        if ($fn >= date("Y-m-d")) {
            throw new \InvalidArgumentException("La fecha no puede ser del futuro.");
        }
        $this->fn = $fn;
    }

    public function setGenero($genero)
    {
        if (!preg_match("/^(Masculino|Femenino)$/", $genero)) {
            throw new \InvalidArgumentException("El género debe ser 'Masculino' o 'Femenino'.");
        }
        $this->genero = $genero;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
}
