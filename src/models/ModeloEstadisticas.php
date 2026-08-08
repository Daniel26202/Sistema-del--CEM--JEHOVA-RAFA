<?php

namespace App\models;

use App\models\ModelBase;
use App\models\interfaces\InterfaceConnection;
use App\models\interfaces\InterfaceValidator;
use PDO;

class ModeloEstadisticas extends ModelBase
{
  private $fechaInicio, $fechaFinal;
  private $validator;

  public function __construct(InterfaceConnection $conn, InterfaceValidator $vali)
  {
    parent::__construct($conn);
    $this->validator = $vali;
  }

  public function distribucion_edad_genero()
  {
    $this->set_tables('distribucion_edad_genero');
    $this->set_colums(['edad', 'genero', 'cantidad']);
    return $this->read();
  }

  public function insumos()
  {
    $this->set_tables('insumos_estadisticas');
    $this->set_colums(['nombre', 'cantidad']);
    return $this->read();
  }

  // Método robusto para tasa morbilidad
  public function obtenerTasaMorbilidad($fechaInicio = '', $fechaFinal = '')
  {
    // Validación centralizada
    if ($fechaInicio !== '' && $fechaFinal !== '') {
      $this->setFechaInicio($fechaInicio);
      $this->setFechaFinal($fechaFinal);
    } else {
      $this->fechaInicio = '';
      $this->fechaFinal = '';
    }
    return $this->tasa_morbilidad_privada();
  }

  // Método privado real
  private function tasa_morbilidad_privada()
  {
    try {
      $data = [
        'fechaInicio' => $this->getFechaInicio(),
        'fechaFinal' => $this->getFechaFinal()
      ];
      $this->set_tables(['tasa_morbilidad']);
      $this->set_colums(['nombre_patologia','casos','tasa_por_1000']);
      if ($this->getFechaInicio() == "" && $this->getFechaFinal() == "") {
        return $this->read();
      } else {
        $sql = "SELECT
            p.nombre_patologia,
            COUNT(DISTINCT pp.id_paciente) AS casos,
            ROUND(
              COUNT(DISTINCT pp.id_paciente) 
              / (SELECT COUNT(*) FROM paciente)  
              * 1000,/* -- población total */
              2
            ) AS tasa_por_1000
          FROM patologiadepaciente pp
          JOIN patologia p ON pp.id_patologia = p.id_patologia WHERE pp.fecha_registro BETWEEN :fechaInicio AND :fechaFinal
          GROUP BY pp.id_patologia
          ORDER BY casos DESC;";
        $query = $this->getPDO()->prepare($sql);
        $query->execute([
          'fechaInicio'=>$this->getFechaInicio(),
          'fechaFinal'=>$this->getFechaFinal()
        ]);

        return ($query->fetchAll(PDO::FETCH_ASSOC));
      }
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public function getFechaInicio()
  {
    return $this->fechaInicio;
  }

  public function getFechaFinal()
  {
    return $this->fechaFinal;
  }

  public function setFechaInicio($fechaInicio = '')
  {
    $dt = \DateTime::createFromFormat('Y-m-d', $fechaInicio);
    $fechaHoy = date("Y-m-d");

    if ($fechaInicio == '') {
      $this->fechaInicio = $fechaInicio;
      return;
    }

    if (!$dt || $dt->format('Y-m-d') !== $fechaInicio) {
      throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
    }
    if ($fechaInicio >= $fechaHoy) {
      throw new \InvalidArgumentException("La fecha no puede ser del futuro.");
    }
    $this->fechaInicio = $fechaInicio;
  }

  public function setFechaFinal($fechaFinal = '')
  {
    $dt = \DateTime::createFromFormat('Y-m-d', $fechaFinal);
    $fechaHoy = date("Y-m-d");

    if ($fechaFinal == '') {
      $this->fechaFinal = $fechaFinal;
      return;
    }

    if (!$dt || $dt->format('Y-m-d') !== $fechaFinal) {
      throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
    }
    if ($fechaFinal >= $fechaHoy) {
      throw new \InvalidArgumentException("La fecha no puede ser del futuro.");
    }
    $this->fechaFinal = $fechaFinal;
  }
}
