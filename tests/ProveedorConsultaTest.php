<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class ProveedorConsultaTest extends TestCase
{
    private $pdo;
    /* private $id = 51; // lo puse directamente abajo, algo me daba error y no llegaba el numero xd */

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    public function testConsultaProveedorExistente()
    {
        $id_proveedor = 7; // hay q asegurarse q este id exista en la bd
        $sql = $this->pdo->prepare("SELECT * FROM proveedor WHERE id_proveedor = :id_proveedor");
        $sql->bindParam(":id_proveedor", $id_proveedor);
        $sql->execute();
        $resultado = $sql->fetchAll();
        echo "EXISTE (" . $id_proveedor . "): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que el insumo siexista
        $this->assertNotEmpty($resultado, "El proveedor con ID (" . $id_proveedor . ") debería existir en la BD");
    }

    public function testConsultaProveedorInexistente()
    {
        $id_proveedor = 999999; // Caso borde, no debería existir
        $sql = $this->pdo->prepare("SELECT * FROM proveedor WHERE id_proveedor = :id_proveedor");
        $sql->bindParam(":id_proveedor", $id_proveedor);
        $sql->execute();
        $resultado = $sql->fetchAll();

        // Verificamos que esté vacío
        $this->assertEmpty($resultado, "El proveedor con ID (" . $id_proveedor . ") no debería existir en la BD");
    }
}
