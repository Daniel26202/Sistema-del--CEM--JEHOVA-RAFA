<?php

namespace App\modelos;

use App\modelos\Db;

class ModeloInicio extends Db
{

	private $db;

	public function __construct()
	{
		// Llama al constructor de la clase padre para establecer la conexión
		parent::__construct();

		// Aquí puedes usar $this para acceder a la conexión
		$this->db = $this; // Guarda la instancia de la conexión
	}

	public function selectsPromPacientes()
	{
		$consulta = $this->db->prepare("SELECT DISTINCT id_paciente
		FROM control
		ORDER BY (SELECT COUNT(*) 
					FROM control AS t2 
					WHERE t2.id_paciente = control.id_paciente) DESC");
		$consulta->bindParam(":nacionalidad", $nacionalidad);
		$consulta->bindParam(":cedula", $cedula);
		$consulta->execute();
		return ($consulta->execute()) ? $consulta->fetchAll() : false;

	}



}

?>