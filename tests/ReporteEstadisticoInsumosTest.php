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
        echo "EXISTEN INSUMOS QUE SE LES DIO SALIDA DEL INVENTARIO " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que la cira si exista
        $this->assertNotEmpty($resultado, "Los insumoque se les dio salida del inventario   existen en la BD");
    }
    
}
