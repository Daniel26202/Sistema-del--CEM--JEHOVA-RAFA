<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class ReportesEntradaTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    // entradas

    public function testConsultarEntrada()
    {
        $desdeFecha = "2025-04-10";
        $fechaHasta = "2025-12-10";
        $id_insumo = 36;

        $consulta = $this->pdo->prepare("SELECT p.nombre AS nombre_proveedor, p.rif, ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad_entrante AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE  e.estado = 'ACT' AND i.estado = 'ACT' AND e.fechaDeIngreso BETWEEN :desdeFecha AND :fechaHasta AND ei.id_insumo =:id_insumo AND ei.fechaDeVencimiento > CURRENT_DATE ORDER BY e.fechaDeIngreso");
        $consulta->bindParam(":id_insumo", $id_insumo);
        $consulta->bindParam(":desdeFecha", $desdeFecha);
        $consulta->bindParam(":fechaHasta", $fechaHasta);
        $consulta->execute();
        $resultado =  $consulta->fetchAll();
        echo "EXISTEN ENTRADAAS DESDE (" . $desdeFecha . " A " . $fechaHasta . "): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que la cira si exista
        $this->assertNotEmpty($resultado, "Las entradas con las fechas (" . $desdeFecha . " A " . $fechaHasta . ")  existen en la BD");
    }

    public function testConsultarEntradaInexistente()
    {
        $desdeFecha = "2020-04-10";
        $fechaHasta = "2021-12-10";

        $id_insumo = 36;

        $consulta = $this->pdo->prepare("SELECT p.nombre AS nombre_proveedor, p.rif, ei.fechaDeVencimiento,ei.id_entradaDeInsumo,i.*,i.id_insumo AS id_insumo_e,e.*,ei.cantidad_entrante AS cantidad_entrada, ei.precio AS precio_entrada ,p.nombre AS proveedor FROM entrada_insumo ei INNER JOIN insumo i ON i.id_insumo = ei.id_insumo INNER JOIN entrada e ON e.id_entrada = ei.id_entrada INNER JOIN proveedor p ON p.id_proveedor = e.id_proveedor WHERE  e.estado = 'ACT' AND i.estado = 'ACT' AND e.fechaDeIngreso BETWEEN :desdeFecha AND :fechaHasta AND ei.id_insumo =:id_insumo AND ei.fechaDeVencimiento > CURRENT_DATE ORDER BY e.fechaDeIngreso");
        $consulta->bindParam(":id_insumo", $id_insumo);
        $consulta->bindParam(":desdeFecha", $desdeFecha);
        $consulta->bindParam(":fechaHasta", $fechaHasta);
        $consulta->execute();
        $resultado =  $consulta->fetchAll();

        // Verificamos que la cira si exista
        $this->assertNotEmpty($resultado, "Las entradas con las fechas (" . $desdeFecha . " A " . $fechaHasta . ")  no existen en la BD");
    }

}