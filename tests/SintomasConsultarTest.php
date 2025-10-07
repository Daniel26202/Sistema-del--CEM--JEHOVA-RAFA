<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class SintomasConsultarTest extends TestCase
{
    private $pdo;
    /* private $id = 51; // lo puse directamente abajo, algo me daba error y no llegaba el numero xd */

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    public function testConsultaSintomaExistente()
    {
        $id_sintomas = 16; // hay q asegurarse q este id exista en la bd
        $sql = $this->pdo->prepare("SELECT * FROM sintomas WHERE id_sintomas = :id_sintomas");
        $sql->bindParam(":id_sintomas", $id_sintomas);
        $sql->execute();
        $resultado = $sql->fetchAll();
        echo "EXISTE (" . $id_sintomas . "): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que el insumo siexista
        $this->assertNotEmpty($resultado, "El sintomas con ID (" . $id_sintomas . ") debería existir en la BD");
    }

    public function testConsultaSintomalInexistente()
    {
        $id_sintomas = 999999; // Caso borde, no debería existir
        $sql = $this->pdo->prepare("SELECT * FROM sintomas WHERE id_sintomas = :id_sintomas");
        $sql->bindParam(":id_sintomas", $id_sintomas);
        $sql->execute();
        $resultado = $sql->fetchAll();

        // Verificamos que esté vacío
        $this->assertEmpty($resultado, "El sintomas con ID (" . $id_sintomas . ") no debería existir en la BD");
    }
}
