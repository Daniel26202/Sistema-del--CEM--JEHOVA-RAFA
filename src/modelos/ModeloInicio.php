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

	public function pacientes_hospitalizados()
	{
		$consulta = $this->conexion->prepare("SELECT COUNT(id_hospitalizacion) AS total_hospitalizados
FROM hospitalizacion
WHERE estado = 'ACT';");
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}


	public function servicios()
	{
		$consulta = $this->conexion->prepare("SELECT c.nombre AS categoria, s.precio FROM serviciomedico s INNER JOIN categoria_servicio c ON s.id_categoria = c.id_categoria  WHERE s.estado = 'ACT' ");
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}

	public function especialidades_solicitadas($fechaInicio = "", $fechaFinal = "")
	{
		if ($fechaInicio == "" && $fechaFinal == "") {
			$consulta = $this->conexion->prepare("SELECT   cs.nombre AS especialidad,
  												COUNT(c.id_cita) AS total_solicitudes
												FROM cita c
												INNER JOIN serviciomedico sm 
												ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico
												INNER JOIN categoria_servicio cs 
												ON sm.id_categoria = cs.id_categoria
												GROUP BY cs.nombre
												ORDER BY total_solicitudes DESC limit 5;
												");
		} else {
			$consulta = $this->conexion->prepare("SELECT   cs.nombre AS especialidad,
  												COUNT(c.id_cita) AS total_solicitudes
												FROM cita c
												INNER JOIN serviciomedico sm 
												ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico
												INNER JOIN categoria_servicio cs 
												ON sm.id_categoria = cs.id_categoria WHERE c.fecha BETWEEN :fechaInicio AND :fechaFinal
												GROUP BY cs.nombre 
												ORDER BY total_solicitudes DESC limit 5;
												");
			$consulta->bindParam(":fechaInicio", $fechaInicio);
			$consulta->bindParam(":fechaFinal", $fechaFinal);
		}

		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}

	public function todas_las_especialidades(){
		$consulta = $this->conexion->prepare("SELECT COUNT(c.serviciomedico_id_servicioMedico) AS total_servicios_por_cita FROM cita c INNER JOIN serviciomedico sm ON sm.id_servicioMedico = c.serviciomedico_id_servicioMedico");
		return ($consulta->execute()) ? $consulta->fetch() : false;
	}

	public function sintomas_comunes()
	{
		$consulta = $this->conexion->prepare("SELECT s.nombre AS sintoma, COUNT(sc.id_sintomas_control) AS total
											FROM sintomas_control sc
											INNER JOIN sintomas s ON sc.id_sintomas = s.id_sintomas
											GROUP BY s.nombre
											ORDER BY total DESC;
												");
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}


	public function obtenerDiasConMasCitas($id_personal = "")
	{
		$sql = "";
		if ($id_personal == "") {
			$sql = "SELECT 
            c.fecha, 
            COUNT(c.id_cita) AS total_citas,
            GROUP_CONCAT(DISTINCT CONCAT(p.nombre, ' ', p.apellido) SEPARATOR ', ') AS personal
        ,fecha as date FROM 
            cita c
        INNER JOIN 
            serviciomedico sm ON sm.id_servicioMedico = c.serviciomedico_id_servicioMedico
        INNER JOIN 
            personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico
        INNER JOIN 
            personal p ON p.id_personal = psm.personal_id_personal
        GROUP BY 
            c.fecha
        ORDER BY 
            total_citas DESC
        LIMIT 10 ";
			$consulta = $this->conexion->prepare($sql);
		} else {
			$sql = "SELECT 
            c.fecha, e.nombre as especialidad,
            COUNT(c.id_cita) AS total_citas,
            GROUP_CONCAT(DISTINCT CONCAT(p.nombre, ' ', p.apellido) SEPARATOR ', ') AS personal
        ,fecha as date FROM 
            cita c
        INNER JOIN 
            serviciomedico sm ON sm.id_servicioMedico = c.serviciomedico_id_servicioMedico
        INNER JOIN 
            personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico
        INNER JOIN 
            personal p ON p.id_personal = psm.personal_id_personal
        INNER JOIN 
        	especialidad e ON e.id_especialidad = p.id_especialidad
            WHERE p.id_personal = :id_personal
        GROUP BY 
            c.fecha
        ORDER BY 
            total_citas DESC";
			$consulta = $this->conexion->prepare($sql);
			$consulta->bindParam(":id_personal", $id_personal);
		}



		$consulta->execute();
		return $consulta->fetchAll();
	}


	//Metodo para validar si un usuario es doctor o no

	public function comprobarCargo($id_usuario)
	{

		$consulta = $this->conexion->prepare(" SELECT * FROM personal p INNER JOIN usuario u ON u.id_usuario = p.id_usuario WHERE p.id_usuario = :id_usuario AND p.id_especialidad IS NOT null");
		$consulta->bindParam(":id_usuario", $id_usuario);
		$consulta->execute();
		while ($consulta->fetch()) {
			return 1;
		}
		return 0;
	}

	//Treae los datos del doctor como los personlaes y los profesionales
	public function datos_doctor($id_usuario)
	{
		$consulta = $this->conexion->prepare("SELECT * FROM personal p INNER JOIN usuario u ON u.id_usuario = p.id_usuario WHERE p.id_usuario =:id_usuario AND p.id_especialidad IS NOT null");
		$consulta->bindParam(":id_usuario", $id_usuario);
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}
}
