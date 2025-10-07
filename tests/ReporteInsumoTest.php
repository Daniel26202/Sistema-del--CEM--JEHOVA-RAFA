<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class ReporteInsumoTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    // Insumos
    public function testConsultarInsumos()
    {
        $consulta = $this->pdo->prepare("SELECT * FROM insumo WHERE estado = 'ACT'");
        $consulta->execute();
        $resultado =  $consulta->fetchAll();
        echo "EXISTEN INSUMOS REGISTRADOS " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que la cira si exista
        $this->assertNotEmpty($resultado, "Los insumos  existen en la BD");
    }


    public function testConsultarInsumosInexistente()
    {
        $consulta = $this->pdo->prepare("SELECT * FROM insumo WHERE estado = 'xxx'");
        $consulta->execute();
        $resultado =  $consulta->fetchAll();

        // Verificamos que la cira si exista
        $this->assertNotEmpty($resultado, "Los insumos  no existen en la BD");
    }
}