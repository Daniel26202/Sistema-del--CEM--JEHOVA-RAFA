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

        // La vista insumos_estadisticas solo se alimenta con detalles de factura de
        // tipo Insumo; actualmente no existen, por lo que la consulta debe ser válida
        // pero retornar un conjunto vacío.
        $this->assertIsArray($resultado, "La vista insumos_estadisticas debe poder consultarse");
        $this->assertEmpty($resultado, "Actualmente no existen insumos con salida registrada en la BD");
    }
    
}
