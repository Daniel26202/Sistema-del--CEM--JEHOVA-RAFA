<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class InsumoConsultarTest extends TestCase
{
    private $pdo;
    /* private $id = 51; // lo puse directamente abajo, algo me daba error y no llegaba el numero xd */

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    public function testConsultaInsumoExistente()
    {
        $id_insumo = 51; // hay q asegurarse q este id exista en la bd
        $sql = $this->pdo->prepare("SELECT * FROM insumo WHERE id_insumo = :id_insumo");
        $sql->bindParam(":id_insumo", $id_insumo);
        $sql->execute();
        $resultado = $sql->fetchAll();
        echo "EXISTE (51): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que el insumo siexista
        $this->assertNotEmpty($resultado, "El insumo con ID 51 debería existir en la BD");
    }

    public function testConsultaInsumoInexistente()
    {
        $id_insumo = 999999; // Caso borde, no debería existir
        $sql = $this->pdo->prepare("SELECT * FROM insumo WHERE id_insumo = :id_insumo");
        $sql->bindParam(":id_insumo", $id_insumo);
        $sql->execute();
        $resultado = $sql->fetchAll();

        // Verificamos que esté vacío
        $this->assertEmpty($resultado, "El insumo con ID 999999 no debería existir en la BD");
    }
}
