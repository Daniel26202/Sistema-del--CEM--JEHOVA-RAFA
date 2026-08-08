<?php

namespace App\models;

use App\models\ModelBase;
use App\models\interfaces\InterfaceConnection;
use App\models\interfaces\InterfaceValidator;
use App\models\TraitCreate;
use App\models\TraitUpdate;
use PDO;

class ModeloControl extends ModelBase
{
	private $historial, $id_control, $diagnostico, $sintomas, $indicaciones, $fechaRegreso, $patologias, $nota, $severidad;
	private $validator;

	use TraitCreate,TraitUpdate;

	public function __construct(InterfaceConnection $conn, InterfaceValidator $vali)
	{
		parent::__construct($conn);
		$this->validator = $vali;
	}


	public function mostrarControlPacienteA()
	{
		$alias =[
			'co','p'
		];
		$unions = [
			'co.id_paciente = p.id_paciente'
		];

		$coditions = [
			'condiciones' => ['estado' => 'ACT'],
			'conectores' => [''],
			'operadores' => ['=']
		];
		$this->set_tables(["control","paciente"]);
		$this->set_colums(['co.id_control','co.id_usuario','co.diagnostico','co.medicamentosRecetados','co.fecha_control','co.fechaRegreso','co.nota', 'co.historiaclinica','co.severidad', 'p.id_paciente', 'p.nacionalidad', 'p.cedula', 'p.nombre', 'p.apellido' , 'p.telefono', 'p.direccion', 'p.fn', 'p.genero', 'p.estado_salud']);
		$this->set_alias($alias);
		$this->set_union($unions);
		$this->set_condicion_aditional($coditions);

		return $this->read(false);
	}

	public function mostrarControlPacienteU()
	{
		$alias = [
			'co',
			'p',
			'usu'
		];
		$unions = [
			'co.id_paciente = p.id_paciente',
			'co.id_usuario = usu.id_usuario'
		];

		$coditions = [
			'condiciones' => ['p.cedula' => $this->getCedula(),'co.estado' => 'ACT','usu.id'=> $this->getIdUsuario()],
			'conectores' => ['AND','AND'],
			'operadores' => ['=','=','=']
		];
		$this->set_tables(['control','paciente','segurity.usuario']);
		$this->set_colums(['co.id_control', 'co.id_usuario', 'co.diagnostico', 'co.medicamentosRecetados', 'co.fecha_control', 'co.fechaRegreso', 'co.nota', 'co.historiaclinica', 'co.severidad', 'p.id_paciente', 'p.nacionalidad', 'p.cedula', 'p.nombre', 'p.apellido', 'p.telefono', 'p.direccion', 'p.fn', 'p.genero', 'p.estado_salud', ' usu.id_usuario']);
		$this->set_alias($alias);
		$this->set_union($unions);
		$this->set_condicion_aditional($coditions);

		return $this->read(false);
	}


	public function mostrarUltimoIdControl()
	{
		$alias = [
			'c','p'
		];
		$unions = [
			'p.id_paciente = c.id_paciente'
		];

		$coditions = [
			'condiciones' => ['p.cedula' => $this->getCedula()],
			'conectores' => [''],
			'operadores' => ['=']
		];
		$this->set_tables(['control', 'paciente']);
		$this->set_colums(['c.id_control']);
		$this->set_alias($alias);
		$this->set_union($unions);
		$this->set_condicion_aditional($coditions);

		$control = $this->read(false);
		return $control['id_control'] ?? null;
	}

	public function mostrarSintomasPaId()
	{
		$alias = [
			's',
			'sc',
			'c',
			'p'
		];
		$unions = [
			'sc.id_sintomas = s.id_sintomas',
			'sc.id_control = c.id_control',
			'c.id_paciente = p.id_paciente'
		];

		$coditions = [
			'condiciones' => ['c.id_control' => $this->getIdControl()],
			'conectores' => [''],
			'operadores' => ['=']
		];
		$this->set_tables(['sintomas', 'sintomas_control','control', 'paciente']);
		$this->set_colums(['s.id_sintomas', 's.nombre AS nombreS', 'c.id_control']);
		$this->set_alias($alias);
		$this->set_union($unions);
		$this->set_condicion_aditional($coditions);

		return $this->read();
	}

	public function mostrarPatologiaC()
	{
		$alias = [
			'p',
			'pd',
			'pat'
		];
		$unions = [
			'pd.id_paciente = p.id_paciente',
			'pd.id_patologia = pat.id_patologia'
		];

		$coditions = [
			'condiciones' => ['c.id_control' => $this->getIdControl()],
			'conectores' => [''],
			'operadores' => ['=']
		];
		$this->set_tables(['paciente', 'patologiadepaciente', 'patologia', 'paciente']);
		$this->set_colums(['pat.id_patologia', 'pat.nombre_patologia']);
		$this->set_alias($alias);
		$this->set_union($unions);
		$this->set_condicion_aditional($coditions);
		return $this->read();
	}

	//  PRIVADOS 

	public function insertControl()
	{
		$transaccionActiva = false;
		try {
			$this->beginTransaction();
			$transaccionActiva = true;
			$fechaHoy = date("Y-m-d");


			// 2. BLOQUEO PESIMISTA A NIVEL DE FILA (FOR UPDATE)
			// Congelamos el registro del paciente para que ningún otro módulo 
			// altere sus datos médicos mientras se procesa este control histórico.
			$query = $this->getPDO()->prepare("SELECT id_paciente, estado_salud FROM paciente WHERE id_paciente = :id_paciente FOR UPDATE");
			$query->execute([
				':id_paciente'=>$this->id_paciente
			]);
			$paciente = $query->fetch(PDO::FETCH_ASSOC);
			if (empty($paciente)) {
				throw new \Exception("El paciente especificado no existe.");
			}

			$coditions = [
				'condiciones' => ['id_usuario' => $this->getIdUsuario()],
				'conectores' => [],
				'operadores' => ['=']
			];
			$this->set_tables(["usuario"]);
			$this->set_colums(['id_usuario']);
			$this->set_condicion_aditional($coditions);
			$validar = $this->read(false);

			if (empty($validar)) {
				throw new \Exception("El id del usuario no existe.");
			}

			if (!empty($this->getPatologias())) {
				foreach ($this->getPatologias() as $patologia) {
					$this->set_tables(["patologiadepaciente"]);
					$data = [
						'id_paciente'    => $this->getIdPaciente(),
						'id_patologia'   => $patologia,
						'fecha_registro' => $fechaHoy
					];
					$this->guardar($data,$this->validator);
				}
			}
			$this->set_tables(['control']);

			$data = [
				'id_paciente'   => $this->getIdPaciente(),
				'id_usuario'    => $this->getIdUsuario(),
				'diagnostico'  => $this->getDiagnostico(),
				'medicamentosRecetados' => $this->getIndicaciones(),
				'fecha_control' => $fechaHoy,
				'fechaRegreso' => $this->getFechaDeRegreso(),
				'nota'         => $this->getNota(),
				'historiaclinica'    => $this->getHistorial(),
				'estado'       => 'ACT',
				'severidad'    => $this->getSeveridad()
			];
			$idControl = $this->guardar($data,$this->validator);

			foreach ($this->getSintomas() as $sintoma) {
				$this->set_tables(['sintomas_control']);
				$data = ['id_sintomas' => $sintoma, 'id_control' => $idControl[0]];
				$this->guardar($data,$this->validator);
			}
			$this->commit();
			return [$idControl];
		} catch (\Exception $e) {
			if ($transaccionActiva) {
				$this->rollBack();
			}
			return $e->getMessage();
		}
	}

	public function editarControl()
	{
		try {

			$coditions = [
				'condiciones' => ['id_control' => $this->getIdControl()],
				'conectores' => [],
				'operadores' => ['=']
			];
			$this->set_tables(["control"]);
			$this->set_colums(['id_control']);
			$this->set_condicion_aditional($coditions);
			$listData = $this->read(false);

			if (empty($listData)) {
				throw new \Exception("El id del control no existe.");
			}

			$data  = [
				'diagnostico'  => $this->getDiagnostico(),
				'medicamentosRecetados' => $this->getIndicaciones(),
				'fechaRegreso' => $this->getFechaDeRegreso(),
				'nota'         => $this->getNota(),
				'historiaclinica'    => $this->getHistorial(),
				'severidad'    => $this->getSeveridad()
			];
			$update = $this->actualizar($data,['id_control'=>$this->getIdControl()],$this->validator);

			return [$update];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	// ── Getters ───────────────────────────────────────────────────────────────

	public function getIdControl()
	{
		return $this->id_control;
	}
	public function getHistorial()
	{
		return $this->historial;
	}
	public function getDiagnostico()
	{
		return $this->diagnostico;
	}
	public function getSintomas()
	{
		return $this->sintomas;
	}
	public function getIndicaciones()
	{
		return $this->indicaciones;
	}
	public function getFechaDeRegreso()
	{
		return $this->fechaRegreso;
	}
	public function getPatologias()
	{
		return $this->patologias;
	}
	public function getNota()
	{
		return $this->nota;
	}
	public function getSeveridad()
	{
		return $this->severidad;
	}
	public function getCedula()
	{
		return $this->cedula;
	}
	public function getNacionalidad()
	{
		return $this->nacionalidad;
	}
	public function getIdUsuario()
	{
		return $this->id_usuario;
	}
	public function getIdPaciente()
	{
		return $this->id_paciente;
	}

	// ── Setters ───────────────────────────────────────────────────────────────

	public function setIdControl($id_control)
	{
		if (!preg_match("/^[0-9]+$/", $id_control)) {
			throw new \InvalidArgumentException("El ID del control debe ser un número entero positivo.");
		}
		$this->id_control = $id_control;
	}

	public function setHistorial($historial)
	{
		if (!preg_match("/^([A-Za-z0-9\s\.,#-]{8,})$/", $historial)) {
			throw new \InvalidArgumentException("El historial debe estar completo y detallado.");
		}
		$this->historial = $historial;
	}

	public function setDiagnostico($diagnostico)
	{
		if (!preg_match("/^[A-ZÁÉÍÓÚÑ][A-Za-záéíóúñ0-9\s,.\n\r]{7,}$/", $diagnostico)) {
			throw new \InvalidArgumentException("El diagnóstico debe iniciar con mayúscula y tener al menos 8 caracteres.");
		}
		$this->diagnostico = $diagnostico;
	}

	public function setSintomas($sintomas = [])
	{
		if (!is_array($sintomas)) {
			throw new \InvalidArgumentException("Síntomas no puede estar vacío.");
		}
		$this->sintomas = $sintomas;
	}

	public function setIndicaciones($indicaciones)
	{
		if (!preg_match("/^[A-ZÁÉÍÓÚÑ][A-Za-záéíóúñ0-9\s]{7,}$/", $indicaciones)) {
			throw new \InvalidArgumentException("Debe iniciar con mayúscula y tener al menos 8 caracteres.");
		}
		$this->indicaciones = $indicaciones;
	}

	public function setFechaRegreso($fechaRegreso)
	{
		$dt = \DateTime::createFromFormat('Y-m-d', $fechaRegreso);
		if (!$dt || $dt->format('Y-m-d') !== $fechaRegreso) {
			throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
		}
		if ($fechaRegreso <= date("Y-m-d")) {
			throw new \InvalidArgumentException("La fecha no puede ser del pasado.");
		}
		$this->fechaRegreso = $fechaRegreso;
	}

	public function setPatologias($patologias = [])
	{
		if (!is_array($patologias)) {
			throw new \InvalidArgumentException("La patología no puede estar vacía.");
		}
		$this->patologias = $patologias;
	}

	public function setNota($nota)
	{
		$this->nota = $nota;
	}
	public function setSeveridad($severidad)
	{
		$this->severidad = $severidad;
	}

	public function setCedula($cedula)
	{
		if (!preg_match("/^([1-9]{1})([0-9]{6,7})$/", $cedula)) {
			throw new \InvalidArgumentException("La cédula debe contener entre 7 y 8 dígitos.");
		}
		$this->cedula = $cedula;
	}

	public function setNacionalidad($nacionalidad)
	{

		if ($nacionalidad !== 'V' && $nacionalidad !== 'E') {
			throw new \InvalidArgumentException("La nacionalidad debe ser V o E.");
		}
		$this->nacionalidad = $nacionalidad;
	}

	public function setIdUsuario($id_usuario)
	{
		if (!preg_match("/^[0-9]+$/", $id_usuario) || (int)$id_usuario <= 0) {
			throw new \InvalidArgumentException("El ID del usuario debe ser un número entero positivo.");
		}
		$this->id_usuario = (int)$id_usuario;
	}

	public function setIdPaciente($id_paciente)
	{
		if (!preg_match("/^[0-9]+$/", $id_paciente) || (int)$id_paciente <= 0) {
			throw new \InvalidArgumentException("El ID del paciente debe ser un número entero positivo.");
		}
		$this->id_paciente = (int)$id_paciente;
	}
}
