<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class ReporteEstadisticoInsumosTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    // entradas

    public function testConsultarInsumo()
    {

        $consulta = $this->pdo->prepare("SELECT * from insumos_estadisticas");

        $consulta->execute();
        $resultado =  $consulta->fetchAll();
        echo "CONSULTA DE INSUMOS CON SALIDA DEL INVENTARIO " . (is_array($resultado) ? "OK" : "FAIL");

        // La vista solo se alimenta con detalles de factura de tipo Insumo.
        // No se exige que esté vacía: en una base con datos reales (o tras
        // facturar insumos) tiene filas. Lo que se verifica es que la consulta
        // funcione y devuelva las columnas de la vista.
        $this->assertIsArray($resultado, "La vista insumos_estadisticas debe poder consultarse");
        foreach ($resultado as $fila) {
            $this->assertArrayHasKey('nombre_insumo', $fila);
            $this->assertArrayHasKey('total_usado', $fila);
        }
    }
    
}
