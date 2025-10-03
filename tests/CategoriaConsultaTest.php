<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class CategoriaConsultaTest extends TestCase
{
    private $pdo;
    /* private $id = 51; // lo puse directamente abajo, algo me daba error y no llegaba el numero xd */

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    public function testConsultaCategoriaExistente()
    {
        $id_categoria = 100; // hay q asegurarse q este id exista en la bd
        $sql = $this->pdo->prepare("SELECT * FROM categoria_servicio WHERE id_categoria = :id_categoria");
        $sql->bindParam(":id_categoria", $id_categoria);
        $sql->execute();
        $resultado = $sql->fetchAll();
        echo "EXISTE (" . $id_categoria . "): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que el insumo siexista
        $this->assertNotEmpty($resultado, "La categoria con ID (" . $id_categoria . ") debería existir en la BD");
    }

    public function testConsultaCategoriaInexistente()
    {
        $id_categoria = 999999; // Caso borde, no debería existir
        $sql = $this->pdo->prepare("SELECT * FROM categoria_servicio WHERE id_categoria = :id_categoria");
        $sql->bindParam(":id_categoria", $id_categoria);
        $sql->execute();
        $resultado = $sql->fetchAll();

        // Verificamos que esté vacío
        $this->assertEmpty($resultado, "La categoria con ID (" . $id_categoria . ") no debería existir en la BD");
    }
}
