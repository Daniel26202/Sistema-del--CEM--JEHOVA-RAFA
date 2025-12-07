<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class RolConsultarTest extends TestCase
{
    private $pdo;
    /* private $id = 51; // lo puse directamente abajo, algo me daba error y no llegaba el numero xd */

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSegurity();
    }

    public function testConsultaRolExistente()
    {
        $id_rol = 1; // hay q asegurarse q este id exista en la bd
        $sql = $this->pdo->prepare("SELECT * FROM rol WHERE id_rol = :id_rol");
        $sql->bindParam(":id_rol", $id_rol);
        $sql->execute();
        $resultado = $sql->fetchAll();
        echo "EXISTE (" . $id_rol . "): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que el insumo siexista
        $this->assertNotEmpty($resultado, "El Rol con ID (" . $id_rol . ") debería existir en la BD");
    }

    public function testConsultaRolInexistente()
    {
        $id_rol = 999999; // Caso borde, no debería existir
        $sql = $this->pdo->prepare("SELECT * FROM rol WHERE id_rol = :id_rol");
        $sql->bindParam(":id_rol", $id_rol);
        $sql->execute();
        $resultado = $sql->fetchAll();

        // Verificamos que esté vacío
        $this->assertEmpty($resultado, "El Rol con ID (" . $id_rol . ") no debería existir en la BD");
    }
}
