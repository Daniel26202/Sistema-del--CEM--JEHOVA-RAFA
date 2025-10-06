<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class ReporteEstadisticoGeneroTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    public function testConsultaCitas()
    {


        $consulta = $this->pdo->prepare("SELECT * FROM distribucion_edad_genero");
        $consulta->execute();
        $resultado =  $consulta->fetchAll();
        echo "EXISTEN LA DISTRIBUCION DE PACIENTES POR GENERO Y EDAD REGISTRADOS  " . (empty($resultado) ? "FAIL" : "OK");


        // Verificamos que  si exista
        $this->assertNotEmpty($resultado, "La distribucion de pacientes  por genero y edad  fechas  existen en la BD");
    }

    
}
