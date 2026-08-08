<?php

namespace App\models;

use App\models\ModelBase;
use App\models\interfaces\InterfaceConnection;
use App\models\interfaces\InterfaceValidator;
use App\models\TraitCreate;
use App\models\TraitUpdate;

class ModeloPacientes extends ModelBase
{
	private $id_paciente, $nacionalidad, $cedula, $nombre, $apellido, $telefono, $direccion, $fn, $genero, $estado;
	private $validator;
	use TraitCreate, TraitUpdate;

	public function __construct(InterfaceConnection $conn, InterfaceValidator $vali)
	{
		parent::__construct($conn);
		$this->set_tables(['paciente']);
		$this->validator = $vali;
	}

	public function index($estado = 'ACT', $start = 0, $limit = 10, $search = '', $ordenColumn = 'id_paciente', $ordenDir = 'DESC')
	{
		$coditions = [
			'condiciones' => ['estado' => $estado],
			'conectores' => [],
			'operadores' => ['=']
		];
		$this->set_tables(["paciente"]);
		$this->set_colums(['id_paciente', 'nacionalidad', 'cedula', 'nombre', 'apellido', 'telefono', 'direccion', 'fn', 'genero']);

		$this->set_search($search);
		$this->set_start($start);
		$this->set_limit($limit);
		$this->set_orden_dir($ordenDir);
		$this->set_orden_column($ordenColumn);
		$this->set_condicion_aditional($coditions);

		return $this->pagination();
	}


	public function indexHistorial($start = 0, $limit = 10, $search = '', $ordenColumn = 'id_paciente', $ordenDir = 'DESC')
	{
		$alias = ['c','p'];
		$unions = ['c.id_paciente = p.id_paciente'];
		$this->set_tables(["control",'paciente']);
		$this->set_colums(['c.id_control','c.id_paciente', ' p.cedula', 'p.nacionalidad','p.nombre AS nombre_paciente','p.estado_salud',' c.diagnostico']);
		$this->set_alias($alias);
		$this->set_union($unions);
		$this->set_search($search);
		$this->set_start($start);
		$this->set_limit($limit);
		$this->set_orden_dir($ordenDir);
		$this->set_orden_column($ordenColumn);

		return $this->pagination();
	}

	public function validarCedula()
	{
		$coditions = [
			'condiciones' => ['cedula' => $this->getCedula(), 'id_paciente' => $this->getIdPaciente()],
			'conectores' => ['AND'],
			'operadores' => ['=', '!=']
		];
		$this->set_tables(["paciente"]);
		$this->set_colums(['id_paciente']);
		$this->set_condicion_aditional($coditions);
		$listData = $this->read(false);
		return !empty($listData) ? 1 : 0;
	}
	// ── Getters & Setters ────────────────────────────────────────────────────

	public function get_all()
	{
		return [
			'nacionalidad' => $this->getNacionalidad(),
			'cedula' => $this->getCedula(),
			'nombre' => $this->getNombre(),
			'apellido' => $this->getApellido(),
			'telefono' => $this->getTelefono(),
			'direccion' => $this->getDireccion(),
			'fn' => $this->getFn(),
			'genero' => $this->getGenero(),
			'estado'=>'ACT'
		];
	}

	public function getIdPaciente()
	{
		return $this->id_paciente;
	}
	public function getNacionalidad()
	{
		return $this->nacionalidad;
	}
	public function getCedula()
	{
		return $this->cedula;
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


	public function setIdPaciente($id_paciente)
	{
		if (!preg_match("/^[0-9]+$/", $id_paciente) || (int)$id_paciente <= 0) {
			throw new \InvalidArgumentException("El ID del paciente debe ser un número entero positivo.");
		}
		$this->id_paciente = (int)$id_paciente;
	}

	public function setNacionalidad($nacionalidad)
	{
		// ✅ Bug corregido: era (!$nacionalidad == 'V' || ...)
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
