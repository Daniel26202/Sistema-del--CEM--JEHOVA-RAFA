<?php

namespace App\modelos;

use App\modelos\Db;


class ModeloInicio extends Db
{

	private $conexion;
	public function __construct()
	{
		// Llama al constructor de la clase padre para establecer la conexión
		parent::__construct();

		// Aquí puedes usar $this para acceder a la conexión

		$this->conexion = $this; // Guarda la instancia de la conexión
	}



	public function servicios()
	{
		$consulta = $this->conexion->prepare("SELECT c.nombre AS categoria, s.precio FROM serviciomedico s INNER JOIN categoria_servicio c ON s.id_categoria = c.id_categoria");
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}

	public function especialidades_solicitadas()
	{
		$consulta = $this->conexion->prepare("SELECT   cs.nombre AS especialidad,
  												COUNT(c.id_cita) AS total_solicitudes
												FROM cita c
												INNER JOIN serviciomedico sm 
												ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico
												INNER JOIN categoria_servicio cs 
												ON sm.id_categoria = cs.id_categoria
												GROUP BY cs.nombre
												ORDER BY total_solicitudes DESC;
												");
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}
}
