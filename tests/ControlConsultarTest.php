<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class ControlConsultarTest extends TestCase
{
    private $pdo;
    /* private $id = 51; // lo puse directamente abajo, algo me daba error y no llegaba el numero xd */

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    public function testConsultaControlExistente()
    {
        $resultado = $this->pdo
            ->query("SELECT * FROM bd.control ORDER BY id_control DESC LIMIT 1")
            ->fetchAll();
        echo "EXISTE CONTROL: " . (empty($resultado) ? "FAIL" : "OK");

        $this->assertNotEmpty($resultado, "Debería existir al menos un control en la BD.");
    }

    public function testConsultaControlInexistente()
    {
        $id_control = 999999; // Caso borde, no debería existir
        $sql = $this->pdo->prepare("SELECT * FROM control WHERE id_control = :id_control");
        $sql->bindParam(":id_control", $id_control);
        $sql->execute();
        $resultado = $sql->fetchAll();

        // Verificamos que esté vacío
        $this->assertEmpty($resultado, "El control con ID (" . $id_control . ") no debería existir en la BD");
    }
}
