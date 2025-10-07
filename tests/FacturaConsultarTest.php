<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class FacturaConsultarTest extends TestCase
{
    private $pdo;
    /* private $id = 51; // lo puse directamente abajo, algo me daba error y no llegaba el numero xd */

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    public function testConsultaFacturaExistente()
    {
        $id_factura = 182; // hay q asegurarse q este id exista en la bd
        $sql = $this->pdo->prepare("SELECT * FROM factura WHERE id_factura = :id_factura");
        $sql->bindParam(":id_factura", $id_factura);
        $sql->execute();
        $resultado = $sql->fetchAll();
        echo "EXISTE (".$id_factura."): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que el insumo siexista
        $this->assertNotEmpty($resultado, "La factura con ID (" . $id_factura . ") debería existir en la BD");
    }

    public function testConsultaFacturaInexistente()
    {
        $id_factura = 999999; // Caso borde, no debería existir
        $sql = $this->pdo->prepare("SELECT * FROM factura WHERE id_factura = :id_factura");
        $sql->bindParam(":id_factura", $id_factura);
        $sql->execute();
        $resultado = $sql->fetchAll();

        // Verificamos que esté vacío
        $this->assertEmpty($resultado, "La factura con ID (" . $id_factura . ") no debería existir en la BD");
    }
}
