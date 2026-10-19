<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class PatologiaConsultarTest extends TestCase
{
    private $pdo;
    /* private $id = 51; // lo puse directamente abajo, algo me daba error y no llegaba el numero xd */

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    public function testConsultaPatologiaExistente()
    {
        $id_patologia = 2; // hay q asegurarse q este id exista en la bd
        $sql = $this->pdo->prepare("SELECT * FROM patologia WHERE id_patologia = :id_patologia");
        $sql->bindParam(":id_patologia", $id_patologia);
        $sql->execute();
        $resultado = $sql->fetchAll();
        echo "EXISTE (2): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que el insumo siexista
        $this->assertNotEmpty($resultado, "La patologia con ID 2 debería existir en la BD");
    }

    public function testConsultaPatologiaInexistente()
    {
        $id_patologia = 999999; // Caso borde, no debería existir
        $sql = $this->pdo->prepare("SELECT * FROM patologia WHERE id_patologia = :id_patologia");
        $sql->bindParam(":id_patologia", $id_patologia);
        $sql->execute();
        $resultado = $sql->fetchAll();

        // Verificamos que esté vacío
        $this->assertEmpty($resultado, "la patologia con ID 999999 no debería existir en la BD");
    }
}
