<?php

namespace App\modelos;

use App\modelos\Db;

class ModeloEstadisticas extends Db
{

  private $conexion;

  public function __construct()
  {
    // Llama al constructor de la clase padre para establecer la conexión
    parent::__construct();

    // Aquí puedes usar $this para acceder a la conexión

    $this->conexion = $this; // Guarda la instancia de la conexión

  }

  public function distribucion_edad_genero()
  {
    try {
      $sql = "SELECT
  rango_edad,
  SUM(CASE WHEN genero = 'masculino' THEN cantidad ELSE 0 END) AS masculino,
  SUM(CASE WHEN genero = 'femenino' THEN cantidad ELSE 0 END) AS femenino,
  SUM(cantidad) AS total,
  (SELECT COUNT(*) FROM paciente WHERE genero = 'masculino') AS total_masculino,
  (SELECT COUNT(*) FROM paciente WHERE genero = 'femenino') AS total_femenino
FROM (
  SELECT
    CASE
      WHEN TIMESTAMPDIFF(YEAR, fn, CURDATE()) BETWEEN 0 AND 12 THEN '0-12'
      WHEN TIMESTAMPDIFF(YEAR, fn, CURDATE()) BETWEEN 13 AND 19 THEN '13-19'
      WHEN TIMESTAMPDIFF(YEAR, fn, CURDATE()) BETWEEN 20 AND 35 THEN '20-35'
      WHEN TIMESTAMPDIFF(YEAR, fn, CURDATE()) BETWEEN 36 AND 50 THEN '36-50'
      WHEN TIMESTAMPDIFF(YEAR, fn, CURDATE()) BETWEEN 51 AND 65 THEN '51-65'
      ELSE '66+'
    END AS rango_edad,
    genero,
    COUNT(*) AS cantidad
  FROM paciente
  GROUP BY rango_edad, genero
) AS sub
GROUP BY rango_edad
ORDER BY rango_edad

";

      $consulta = $this->conexion->prepare($sql);

      return ($consulta->execute()) ? $consulta->fetchAll() : false;
    } catch (\Exception $e) {
      return 0;
    }
  }

  public function tasa_morbilidad($fechaInicio = "", $fechaFinal = "")
  {
    try {
      if ($fechaInicio == "" && $fechaFinal == "") {
        $sql = "SELECT
              p.nombre_patologia,
              COUNT(DISTINCT pp.id_paciente) AS casos,
              ROUND(
                COUNT(DISTINCT pp.id_paciente) 
                / (SELECT COUNT(*) FROM paciente)  -- población total
                * 1000,
                2
              ) AS tasa_por_1000
            FROM patologiadepaciente pp
            JOIN patologia p ON pp.id_patologia = p.id_patologia
            GROUP BY pp.id_patologia
            ORDER BY casos DESC;
            ";
        $consulta = $this->conexion->prepare($sql);
      } else {
        $sql = "SELECT
            p.nombre_patologia,
            COUNT(DISTINCT pp.id_paciente) AS casos,
            ROUND(
              COUNT(DISTINCT pp.id_paciente) 
              / (SELECT COUNT(*) FROM paciente)  -- población total
              * 1000,
              2
            ) AS tasa_por_1000
          FROM patologiadepaciente pp
          JOIN patologia p ON pp.id_patologia = p.id_patologia WHERE pp.fecha_registro BETWEEN :fechaInicio AND :fechaFinal
          GROUP BY pp.id_patologia
          ORDER BY casos DESC;";
        $consulta = $this->conexion->prepare($sql);
        $consulta->bindParam(":fechaInicio", $fechaInicio);
        $consulta->bindParam(":fechaFinal", $fechaFinal);
      }


      return ($consulta->execute()) ? $consulta->fetchAll() : false;
    } catch (\Exception $e) {
      return 0;
    }
  }
}
