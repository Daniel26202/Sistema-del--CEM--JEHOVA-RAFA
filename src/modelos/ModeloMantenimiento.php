<?php

namespace App\modelos;

use App\modelos\Db;
use DateTime;

class ModeloMantenimiento extends Db
{

	private $conexion;
	private $user;
	private $password;
	private $dbname;
	private $dbHost;

	public function __construct()
	{
		// Llama al constructor de la clase padre para establecer la conexión
		parent::__construct();

		// Aquí puedes usar $this para acceder a la conexión

		$this->conexion = $this; // Guarda la instancia de la conexión
	}

	private function infoRespaldo()
	{
		require_once __DIR__ . "/../config/config.php";
		$this->user = user_cos;
		$this->password = pass_cos;
		$this->dbname = dbname_cos;
		$this->dbHost = host_cos;
	}
	
}
