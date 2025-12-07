<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class PerfilConsultarTest extends TestCase
{
    private $pdo;


    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    public function testConsultaPerfilExistente()
    {
        $id_usuario = 47; // hay q asegurarse q este id exista en la bd
        $sql = $this->pdo->prepare("SELECT *,u.usuario as user FROM segurity.usuario u INNER JOIN  bd.personal p ON p.usuario = u.id_usuario  WHERE u.usuario =:usuario");
        $sql->bindParam(":usuario", $id_usuario);
        $sql->execute();
        $resultado = $sql->fetchAll();
        echo "EXISTE (" . $id_usuario . "): " . (empty($resultado) ? "FAIL" : "OK");

        $this->assertNotEmpty($resultado, "El perfil de usuario con ID (" . $id_usuario . ")  existe en la BD");
    }

    public function testConsultaPerfilInexistente()
    {
        $id_usuario = 999999; // Caso borde, no debería existir
        $sql = $this->pdo->prepare("SELECT *,u.usuario as user FROM segurity.usuario u INNER JOIN  bd.personal p ON p.usuario = u.id_usuario  WHERE u.usuario =:usuario");
        $sql->bindParam(":usuario", $id_usuario);
        $sql->execute();
        $resultado = $sql->fetchAll();

        $this->assertNotEmpty($resultado, "El perfil de usuario con ID (" . $id_usuario . ") no  existe en la BD");
    }
}
