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
        $id_control = 26; // hay q asegurarse q este id exista en la bd
        $sql = $this->pdo->prepare("SELECT * FROM control WHERE id_control = :id_control");
        $sql->bindParam(":id_control", $id_control);
        $sql->execute();
        $resultado = $sql->fetchAll();
        echo "EXISTE (" . $id_control . "): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que el insumo siexista
        $this->assertNotEmpty($resultado, "El control con ID (" . $id_control . ") debería existir en la BD");
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
