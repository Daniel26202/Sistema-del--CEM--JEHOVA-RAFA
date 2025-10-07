<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class ReporteEstadisticoSintomasTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    // entradas

    public function testConsultarSintomas()
    {
        $desdeFecha = "2025-04-10";
        $fechaHasta = "2025-12-10";

        $consulta = $this->pdo->prepare("SELECT c.fecha_control, s.nombre AS sintoma, COUNT(sc.id_sintomas_control) AS total
											FROM sintomas_control sc
											INNER JOIN sintomas s ON sc.id_sintomas = s.id_sintomas INNER JOIN control c ON c.id_control = sc.id_control WHERE c.fecha_control BETWEEN :fechaInicio AND :fechaFinal
											GROUP BY s.nombre
											ORDER BY total DESC lIMIT 5");
        $consulta->bindParam(":fechaInicio", $desdeFecha);
        $consulta->bindParam(":fechaFinal", $fechaHasta);
        $consulta->execute();
        $resultado =  $consulta->fetchAll();
        echo "EXISTEN DATOS DE LOS SINTOMAS MAS SOLICITADAS DESDE (" . $desdeFecha . " A " . $fechaHasta . "): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que la cira si exista
        $this->assertNotEmpty($resultado, "Los datos de los sintomas mas solicitadas desde (" . $desdeFecha . " A " . $fechaHasta . ")  existen en la BD");
    }

    public function testConsultarSintomasInexistente()
    {
        $desdeFecha = "2024-04-10";
        $fechaHasta = "2024-12-10";

        $consulta = $this->pdo->prepare("SELECT c.fecha_control, s.nombre AS sintoma, COUNT(sc.id_sintomas_control) AS total
											FROM sintomas_control sc
											INNER JOIN sintomas s ON sc.id_sintomas = s.id_sintomas INNER JOIN control c ON c.id_control = sc.id_control WHERE c.fecha_control BETWEEN :fechaInicio AND :fechaFinal
											GROUP BY s.nombre
											ORDER BY total DESC lIMIT 5");
        $consulta->bindParam(":fechaInicio", $desdeFecha);
        $consulta->bindParam(":fechaFinal", $fechaHasta);
        $consulta->execute();
        $resultado =  $consulta->fetchAll();

        // Verificamos que la cira si exista
        $this->assertNotEmpty($resultado, "Los datos de los sintomas mas solicitadas desde  (" . $desdeFecha . " A " . $fechaHasta . ")  no existen en la BD");
    }
}
