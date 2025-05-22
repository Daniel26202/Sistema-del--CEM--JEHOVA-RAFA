<?php

namespace App\modelos;

use App\modelos\Db;

class ModeloControl extends Db
{
	private $conexion;

	public function __construct()
	{
		// Llama al constructor de la clase padre para establecer la conexión
		parent::__construct();

		// Aquí puedes usar $this para acceder a la conexión

		$this->conexion = $this; // Guarda la instancia de la conexión
	}

	public function consultarPacientes()
	{
		// me traigo todos los datos de los paciente, que tengan control medico, y los agrupo por cédula (con GROUP BY) para que no salgan varias veces 
		$sql = $this->conexion->prepare("SELECT p.* FROM paciente p INNER JOIN control co ON co.id_paciente = p.id_paciente WHERE co.estado = 'ACT' GROUP BY p.cedula");
		return ($sql->execute()) ? $sql->fetchAll() : false;
	}

	public function buscarPacientes($parametro)
	{
		// me traigo todos los datos de los paciente, que tengan control medico, y los agrupo por cédula (con GROUP BY) para que no salgan varias veces 
		$sql = $this->conexion->prepare("SELECT p.* FROM paciente p INNER JOIN control co ON co.id_paciente = p.id_paciente WHERE p.cedula LIKE :buscar AND co.estado = 'ACT' GROUP BY p.cedula");
		$buscar = "$parametro%";
		$sql->bindParam(":buscar", $buscar);
		return ($sql->execute()) ? $sql->fetchAll() : false;
	}

	// función para el administrador (en lo de las sesiones);
	// selecciono todos los datos de control, citas, pacientes.
	public function mostrarControlPacienteA($cedula)
	{
		$sql = $this->conexion->prepare("SELECT co.*,p.* FROM paciente p INNER JOIN control co ON co.id_paciente = p.id_paciente WHERE p.cedula = :cedula AND co.estado = 'ACT'");
		$sql->bindParam(":cedula", $cedula);
		return ($sql->execute()) ? $sql->fetchAll() : false;
	}

	// función para el usuario (en lo de las sesiones);
	// selecciono todos los datos de control, citas, pacientes, y me traigo el id del usuario(que en este caso es el doctor)
	public function mostrarControlPacienteU($cedula, $idU)
	{
		$sql = $this->conexion->prepare("SELECT co.*,p.*,usu.id_usuario FROM control co INNER JOIN paciente p ON co.id_paciente = p.id_paciente INNER JOIN usuario usu ON co.id_usuario = usu.id_usuario WHERE p.cedula = :cedula AND co.estado = 'ACT' AND usu.id_usuario = :id");
		$sql->bindParam(":id", $idU);
		$sql->bindParam(":cedula", $cedula);
		return ($sql->execute()) ? $sql->fetchAll() : false;
	}

	public function mostrarPaciente($cedula)
	{
		$sql = $this->conexion->prepare("SELECT * FROM paciente WHERE estado = 'ACT' AND cedula = :cedula");
		$sql->bindParam(":cedula", $cedula);
		return ($sql->execute()) ? $sql->fetchAll() : false;
	}
	// mostrar patología de paciente
	public function mostrarPatologiaPac($cedula)
	{
		$sql = $this->conexion->prepare("SELECT pdp.*, pat.nombre_patologia AS nombre_patologia,pac.* FROM paciente pac INNER JOIN patologiadepaciente pdp ON pac.id_paciente = pdp.id_paciente INNER JOIN patologia pat ON pat.id_patologia = pdp.id_patologia WHERE pac.estado = 'ACT' AND pac.cedula = :cedula");
		$sql->bindParam(":cedula", $cedula);
		return ($sql->execute()) ? $sql->fetchAll() : false;
	}

	//insertar control
	public function insertControl($historial, $idUsuario, $idPaciente, $diagnostico, $sintomas, $indicaciones, $fechaRegreso, $patologias, $nota, $fechaHora)
	{
		if ($patologias) {

			// primero se registra la patologia del paciente
			foreach ($patologias as $patologia) {
				$consulta2 = $this->conexion->prepare("INSERT INTO patologiadepaciente(id_paciente, id_patologia, fecha_registro) VALUES (:id_paciente, :id_patologia, :fechaHora)");
				$consulta2->bindParam(":id_paciente", $idPaciente);
				$consulta2->bindParam(":id_patologia", $patologia);
				$consulta2->bindParam(":fechaHora", $fechaHora);
				$consulta2->execute();
			}
		}

		$sqlC = $this->conexion->prepare("INSERT INTO control(id_paciente, id_usuario, diagnostico, medicamentosRecetados, fecha_control, fechaRegreso, nota, historiaclinica, estado) VALUES (:idPaciente, :idUsuario, :diagnostico, :indicaciones, :fechaHora, :fechaRegreso, :nota, :historial, 'ACT')");

		$sqlC->bindParam(":idPaciente", $idPaciente);
		$sqlC->bindParam(":idUsuario", $idUsuario);
		$sqlC->bindParam(":diagnostico", $diagnostico);
		$sqlC->bindParam(":indicaciones", $indicaciones);
		$sqlC->bindParam(":fechaHora", $fechaHora);
		$sqlC->bindParam(":fechaRegreso", $fechaRegreso);
		$sqlC->bindParam(":nota", $nota);
		$sqlC->bindParam(":historial", $historial);


		$sqlC->execute();
		//devuelve el id del control.
		$idControl = ($this->conexion->lastInsertId() == 0) ? false : $this->conexion->lastInsertId();

		// agrega el síntoma 
		foreach ($sintomas as $sintoma) {
			$sql = $this->conexion->prepare("INSERT INTO sintomas_control(id_sintomas, id_control) VALUES (:sintoma,:idControl);");
			$sql->bindParam(":sintoma", $sintoma);
			$sql->bindParam(":idControl", $idControl);
			$sql->execute();
		}
	}

	//eliminar control
	public function eliminarControl($id_control)
	{
		$sql = $this->conexion->prepare("UPDATE control SET estado ='DES' WHERE id_control=:id_control ");
		$sql->bindParam(":id_control", $id_control);
		$sql->execute();
	}

	//editar control
	public function editarControl($historial, $id_control, $indicaciones, $fechaRegreso, $nota)
	{
		$sql = $this->conexion->prepare("UPDATE control SET medicamentosRecetados=:indicaciones, fechaRegreso=:fechaRegreso, nota=:nota, historiaclinica=:historial WHERE id_control=:id_control ");
		$sql->bindParam(":id_control", $id_control);
		$sql->bindParam(":indicaciones", $indicaciones);
		$sql->bindParam(":nota", $nota);
		$sql->bindParam(":historial", $historial);

		$sql->bindParam(":fechaRegreso", $fechaRegreso);
		$sql->execute();
	}
	public function mostrarDoctor()
	{
		$sql = $this->conexion->prepare('SELECT c.id_categoria,c.nombre AS categoria,sm.id_servicioMedico, ps.personal_id_personal, u.id_usuario, p.nombre AS nombredoc, sm.precio FROM serviciomedico sm INNER JOIN  personal_has_serviciomedico ps ON ps.serviciomedico_id_servicioMedico = sm.id_servicioMedico   INNER JOIN personal p ON ps.personal_id_personal = p.id_personal INNER JOIN usuario u ON p.id_usuario = u.id_usuario INNER JOIN categoria_servicio c ON c.id_categoria = sm.id_categoria WHERE  sm.estado= "ACT" GROUP BY p.nombre ');

		return ($sql->execute()) ? $sql->fetchAll() : false;
	}
	// mostrar síntomas del control del paciente
	public function mostrarSintomasPaId($idControl)
	{
		$sql = $this->conexion->prepare('SELECT s.id_sintomas, s.nombre AS nombreS, c.id_control FROM sintomas s INNER JOIN sintomas_control sc ON sc.id_sintomas = s.id_sintomas INNER JOIN control c ON sc.id_control = c.id_control INNER JOIN paciente p ON c.id_paciente = p.id_paciente WHERE c.id_control = :idControl');
		$sql->bindParam(":idControl", $idControl);

		return ($sql->execute()) ? $sql->fetchAll() : false;
	}

	// mostrar síntomas del control del paciente
	public function mostrarSintomasPa($cedulaP)
	{
		$sql = $this->conexion->prepare('SELECT s.id_sintomas, s.nombre AS nombreS, c.id_control FROM sintomas s INNER JOIN sintomas_control sc ON sc.id_sintomas = s.id_sintomas INNER JOIN control c ON sc.id_control = c.id_control INNER JOIN paciente p ON c.id_paciente = p.id_paciente WHERE p.cedula = :cedulaP');
		$sql->bindParam(":cedulaP", $cedulaP);

		return ($sql->execute()) ? $sql->fetchAll() : false;
	}


	// mostrar patologia del paciente
	public function mostrarPatologiaP($id_control)
	{
		$sql = $this->conexion->prepare('SELECT pat.id_patologia, pat.nombre_patologia FROM control c INNER JOIN paciente p ON c.id_paciente = p.id_paciente INNER JOIN patologiadepaciente pdp ON p.id_paciente = pdp.id_paciente INNER JOIN patologia pat ON pdp.id_patologia = pat.id_patologia WHERE c.id_control = :id_control AND pdp.fecha_registro = c.fecha_control ORDER BY c.fecha_control ASC');
		$sql->bindParam(":id_control", $id_control);

		return ($sql->execute()) ? $sql->fetchAll() : false;
	}
	// mostrar patologia del ultimo control del paciente
	public function mostrarPatologiaC($idPaciente)
	{
		$sql = $this->conexion->prepare('SELECT pat.id_patologia, pat.nombre_patologia FROM control c INNER JOIN paciente p ON c.id_paciente = p.id_paciente INNER JOIN patologiadepaciente pdp ON p.id_paciente = pdp.id_paciente INNER JOIN patologia pat ON pdp.id_patologia = pat.id_patologia WHERE c.id_control = (SELECT id_control FROM control WHERE id_paciente = :id_paciente AND estado = "ACT" ORDER BY fecha_control DESC LIMIT 1) AND pdp.fecha_registro = c.fecha_control ORDER BY c.fecha_control ASC');
		$sql->bindParam(":id_paciente", $idPaciente);

		return ($sql->execute()) ? $sql->fetchAll() : false;
	}
}
