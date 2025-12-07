<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class UsuarioConsultaTest extends TestCase
{
    private $pdo;
    /* private $id = 51; // lo puse directamente abajo, algo me daba error y no llegaba el numero xd */

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSegurity();
    }

    public function testConsultaUsuarioExistente()
    {
        $id_usuario = 1; // hay q asegurarse q este id exista en la bd
        $sql = $this->pdo->prepare("SELECT * FROM usuario WHERE id_usuario = :id_usuario");
        $sql->bindParam(":id_usuario", $id_usuario);
        $sql->execute();
        $resultado = $sql->fetchAll();
        echo "EXISTE (" . $id_usuario . "): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que el insumo siexista
        $this->assertNotEmpty($resultado, "El usuario con ID (" . $id_usuario . ") debería existir en la BD");
    }

    public function testConsultaUsuarioInexistente()
    {
        $id_usuario = 999999; // Caso borde, no debería existir
        $sql = $this->pdo->prepare("SELECT * FROM usuario WHERE id_usuario = :id_usuario");
        $sql->bindParam(":id_usuario", $id_usuario);
        $sql->execute();
        $resultado = $sql->fetchAll();

        // Verificamos que esté vacío
        $this->assertEmpty($resultado, "El usuario con ID (" . $id_usuario . ") no debería existir en la BD");
    }
}
