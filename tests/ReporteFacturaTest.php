<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class ReporteFacturaTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }


    //Factura
    public function testConsultaFactura()
    {
        $id_factura = 61;

        $consulta = $this->pdo->prepare("SELECT f.*, p.nombre as nombre_p , p.apellido AS apellido_p, nacionalidad, p.cedula AS cedula_p FROM factura f INNER JOIN paciente p ON p.id_paciente = f.paciente_id_paciente WHERE f.id_factura = :id_factura AND f.estado='ACT' ORDER BY id_factura ASC");
        $consulta->bindParam(":id_factura", $id_factura);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        echo "EXISTE FACTURA CON EL ID (" . $id_factura . "): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que la cira si exista
        $this->assertNotEmpty($resultado, "La factura con ID (" . $id_factura . ") existe en la BD");
    }

    public function testConsultaFacturaInexistente()
    {
        $id_factura = 99999;

        $consulta = $this->pdo->prepare("SELECT f.*, p.nombre as nombre_p , p.apellido AS apellido_p, nacionalidad, p.cedula AS cedula_p FROM factura f INNER JOIN paciente p ON p.id_paciente = f.paciente_id_paciente WHERE f.id_factura = :id_factura AND f.estado='ACT' ORDER BY id_factura ASC");
        $consulta->bindParam(":id_factura", $id_factura);
        $consulta->execute();
        $resultado = $consulta->fetchAll();

        // Verificamos que la cira si exista
        $this->assertNotEmpty($resultado, "La factura con ID (" . $id_factura . ") no existe en la BD");
    }
}
