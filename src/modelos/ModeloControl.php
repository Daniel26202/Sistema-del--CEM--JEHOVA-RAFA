<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\modelos\ModeloUsuarios;
use App\modelos\ModeloPacientes;

class ModeloControl extends ModelBase
{
	private $historial, $id_control, $diagnostico, $sintomas, $indicaciones, $fechaRegreso, $patologias, $nota, $severidad;

	public function __construct($dbSystem= true)
	{
		parent::__construct($dbSystem);
	}

	private function returnObjectModel()
	{
		return [
			'modeloPacientes'=>new ModeloPacientes(),
			'modeloUsuarios'=> new ModeloUsuarios(),
			];
	}

	public function buscarPacientes()
	{
		// me traigo todos los datos de los paciente, que tengan control medico, y los agrupo por cédula (con GROUP BY) para que no salgan varias veces 
		$sql = "SELECT p.* FROM paciente p INNER JOIN control co ON co.id_paciente = p.id_paciente WHERE p.cedula LIKE :cedula AND co.estado = 'ACT' GROUP BY p.cedula";
		$this->setSQL($sql);
		return  $this->search(['cedula' => '%'. $this->returnObjectModel()['modeloPacientes']->getCedula().'%']);
	}

	public function consultarPacientes()
	{
		// me traigo todos los datos de los paciente, que tengan control medico, y los agrupo por cédula (con GROUP BY) para que no salgan varias veces 
		$sql = "SELECT p.* FROM paciente p INNER JOIN control co ON co.id_paciente = p.id_paciente WHERE co.estado = 'ACT' GROUP BY p.cedula";
		$this->setSQL($sql);
		return  $this->read();
	}


	// función para el administrador (en lo de las sesiones);
	// selecciono todos los datos de control, citas, pacientes.
	public function mostrarControlPacienteA()
	{
		$data = [
			'cedula' => $this->returnObjectModel()['modeloPacientes']->getCedula(),
			'estado' => 'ACT'
		];
		$sql = "SELECT co.*,p.* FROM paciente p INNER JOIN control co ON co.id_paciente = p.id_paciente WHERE p.cedula = :cedula AND co.estado =:estado";
		$this->setSQL($sql);
		return  $this->search($data);
	}

	// función para el usuario (en lo de las sesiones);
	// selecciono todos los datos de control, citas, pacientes, y me traigo el id del usuario(que en este caso es el doctor)
	public function mostrarControlPacienteU()
	{
		$data = [
			'cedula' => $this->returnObjectModel()['modeloPacientes']->getCedula(),
			'estado' => 'ACT',
			'id' => $this->returnObjectModel()['modeloUsuarios']->getIdUsuario()
		];

		$sql = "SELECT co.*,p.*,usu.id_usuario FROM control co INNER JOIN paciente p ON co.id_paciente = p.id_paciente INNER JOIN usuario usu ON co.id_usuario = usu.id_usuario WHERE p.cedula = :cedula AND co.estado =:estado AND usu.id_usuario = :id";
		$this->setSQL($sql);
		return  $this->search($data);
	}

	public function mostrarPaciente()
	{
		$data = [
			'cedula' => $this->returnObjectModel()['modeloPacientes']->getCedula(),
			'estado' => 'ACT',
		];

		$sql = "SELECT * FROM paciente WHERE estado =:estado AND cedula = :cedula";
		$this->setSQL($sql);
		return  $this->search($data);
	}


	//insertar control
	public function insertControl()
	{
		try {
			$fechaHoy = date("Y-m-d");

			$data = [
				'id_usuario' => $this->returnObjectModel()['modeloUsuarios']->getIdUsuario(),
			];

			$sql = "SELECT * from segurity.usuario where id_usuario=:id_usuario";
			$this->setSQL($sql);
			$listData = $this->search($data, false);
			$listData = !empty($listData) ? 1 : 0;


			if (!$listData) {
				throw new \Exception("El id del usuario no existe");
			}

			if ($this->getPatologias() != []) {

				// primero se registra la patologia del paciente
				foreach ($this->getPatologias() as $patologia) {

					$data = [
						'id_paciente' => $this->returnObjectModel()['modeloPacientes']->getIdPaciente(),
						'id_patologia' => $patologia,
						'fecha_registro' => $fechaHoy
					];

					$sql = "INSERT INTO patologiadepaciente(id_paciente, id_patologia, fecha_registro) VALUES (:id_paciente, :id_patologia, :fecha_registro)";

					$this->setSQL($sql);
					$this->create($data);
				}
			}

			$data=[
				'idPaciente'=>$this->returnObjectModel()['modeloPacientes']->getIdPaciente(),
				'idUsuario' => $this->returnObjectModel()['modeloUsuarios']->getIdUsuario(),
				'diagnostico' => $this->getDiagnostico(),
				'indicaciones' => $this->getIndicaciones(),
				'fecha_control' => $fechaHoy,
				'fechaRegreso'=>$this->getFechaDeRegreso(),
				'nota' => $this->getNota(),
				'historial' => $this->getHistorial(),
				'estado' => 'ACT',
				'severidad'=>$this->getSeveridad()
			];

			$sql = "INSERT INTO control(id_paciente, id_usuario, diagnostico, medicamentosRecetados, fecha_control, fechaRegreso, nota, historiaclinica, estado, severidad) VALUES (:idPaciente, :idUsuario, :diagnostico, :indicaciones, :fecha_control, :fechaRegreso, :nota, :historial, :estado, :severidad)";

			$this->setSQL($sql);
			$idControl = $this->create($data);

			// agrega el síntoma 
			foreach ($this->getSintomas() as $sintoma) {
				$data=[
					'sintoma'=>$sintoma,
					'idControl'=> $idControl
				];
				$sql = "INSERT INTO sintomas_control(id_sintomas, id_control) VALUES (:sintoma,:idControl)";
				$this->setSQL($sql);
				$this->create($data);
			}
			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	//editar control
	public function editarControl()
	{
		try {
			$data = [
				'indicaciones' => $this->getIndicaciones(),
				'fechaRegreso' => $this->getFechaDeRegreso(),
				'nota' => $this->getNota(),
				'historial' => $this->getHistorial()
			];

			$data2 = [
				'id_control' => $this->getIdControl()
			];

			$sql = "SELECT * from control where id_control=:id_control";
			$this->setSQL($sql);

			$validar  = $this->search($data2, false);

			if ($validar == []) {
				throw new \Exception("El id del control no existe");
			}

			$sql = "UPDATE control SET medicamentosRecetados=:indicaciones, fechaRegreso=:fechaRegreso, nota=:nota, historiaclinica=:historial WHERE id_control=:id ";
			$this->setSQL($sql);
			$this->update($data, $this->getIdControl());
			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function mostrarDoctor()
	{
		$sql = 'SELECT c.id_categoria,c.nombre AS categoria,sm.id_servicioMedico, ps.personal_id_personal, u.id_usuario, p.nombre AS nombredoc, p.apellido as apellidodoc, sm.precio FROM serviciomedico sm INNER JOIN  personal_has_serviciomedico ps ON ps.serviciomedico_id_servicioMedico = sm.id_servicioMedico   INNER JOIN personal p ON ps.personal_id_personal = p.id_personal INNER JOIN segurity.usuario u ON p.usuario = u.id_usuario INNER JOIN categoria_servicio c ON c.id_categoria = sm.id_categoria WHERE  sm.estado= "ACT" GROUP BY p.nombre';
		$this->setSQL($sql);
		return $this->read();
	}
	// mostrar síntomas del control del paciente
	public function mostrarSintomasPaId()
	{
		$data=['idControl'=>$this->getIdControl()];
		$sql = "SELECT s.id_sintomas, s.nombre AS nombreS, c.id_control FROM sintomas s INNER JOIN sintomas_control sc ON sc.id_sintomas = s.id_sintomas INNER JOIN control c ON sc.id_control = c.id_control INNER JOIN paciente p ON c.id_paciente = p.id_paciente WHERE c.id_control = :idControl";
		$this->setSQL($sql);
		return $this->search($data);
	}


	// mostrar patologia del paciente
	public function mostrarPatologiaP()
	{

		$data = ['idControl' => $this->getIdControl()];
		$sql = "SELECT pat.id_patologia, pat.nombre_patologia FROM control c INNER JOIN paciente p ON c.id_paciente = p.id_paciente INNER JOIN patologiadepaciente pdp ON p.id_paciente = pdp.id_paciente INNER JOIN patologia pat ON pdp.id_patologia = pat.id_patologia WHERE c.id_control = :idControl AND pdp.fecha_registro = c.fecha_control ORDER BY c.fecha_control ASC";
		$this->setSQL($sql);
		return $this->search($data);
	}
	// mostrar patologia del ultimo control del paciente
	public function mostrarPatologiaC()
	{
		$data = ['id_paciente' => $this->returnObjectModel()['modeloPacientes']->getIdPaciente()];
		$sql = 'SELECT pat.id_patologia, pat.nombre_patologia FROM control c INNER JOIN paciente p ON c.id_paciente = p.id_paciente INNER JOIN patologiadepaciente pdp ON p.id_paciente = pdp.id_paciente INNER JOIN patologia pat ON pdp.id_patologia = pat.id_patologia WHERE c.id_control = (SELECT id_control FROM control WHERE id_paciente = :id_paciente AND estado = "ACT" ORDER BY fecha_control DESC LIMIT 1) AND pdp.fecha_registro = c.fecha_control ORDER BY c.fecha_control ASC';
		$this->setSQL($sql);
		return $this->search($data);
	}



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

	public function setIdControl($id_control)
	{
		if (!preg_match("/^[0-9]+$/", $id_control)) {
			throw new \InvalidArgumentException("El ID del control debe ser un número entero positivo.");
		}

		if ((int)$id_control <= 0) {
			throw new \InvalidArgumentException("El ID del control debe ser mayor que cero.");
		}

		$this->id_control = $id_control;
	}


	public function setHistorial($historial)
	{
		if (!preg_match("/^([A-Za-z0-9\s\.,#-]{8,})$/", $historial)) {
			throw new \InvalidArgumentException("El historial debe estar completa y detallada.");
		}

		$this->historial = $historial;
	}

	public function setDiagnostico($diagnostico)
	{
		if (!preg_match("/^([A-Za-z0-9\s\.,#-]{8,})$/", $diagnostico)) {
			throw new \InvalidArgumentException("el diagnostico debe estar completa y detallada.");
		}

		$this->diagnostico = $diagnostico;
	}

	public function setSintomas($sintomas = [])
	{
		if ($sintomas !=  []) {
			throw new \InvalidArgumentException("sintomas no puede estar vacio.");
		}
		$this->sintomas = $sintomas;
	}

	public function setIndicaciones($indicaciones)
	{

		if (!preg_match("/^([A-Za-z0-9\s\.,#-]{8,})$/", $indicaciones)) {
			throw new \InvalidArgumentException("lasindicaciones debe estar completa y detallada.");
		}
		$this->indicaciones  = $indicaciones;
	}

	public function setFechaRegreso($fechaRegreso)
	{
		$dt = \DateTime::createFromFormat('Y-m-d', $fechaRegreso);
		$fechaHoy = date("Y-m-d");

		if (!$dt || $dt->format('Y-m-d') !== $fechaRegreso) {
			throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
		}
		if ($fechaRegreso <= $fechaHoy) {
			throw new \InvalidArgumentException("La fecha no puede ser del pasado.");
		}

		$this->fechaRegreso = $fechaRegreso;
	}

	public function setPatologias($patologias = [])
	{
		if ($patologias != []) {
			throw new \InvalidArgumentException("La patologia no puede estar vacio.");
		}
		$this->patologias = $patologias;
	}

	public function setNota($nota)
	{
		if (!preg_match("/^([A-Za-z0-9\s\.,#-]{8,})$/", $nota)) {
			throw new \InvalidArgumentException("la nota debe estar completa y detallada.");
		}

		$this->nota = $nota;
	}

	public function setSeveridad($severidad)
	{
		$this->severidad = $severidad;
	}
}
