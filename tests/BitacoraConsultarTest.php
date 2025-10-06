<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class BitacoraConsultarTest extends TestCase
{
    private $pdo;
    /* private $id = 51; // lo puse directamente abajo, algo me daba error y no llegaba el numero xd */

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSegurity();
    }

    public function testConsultaBitacoraExistente()
    {
        $id_usuario = 47; // hay q asegurarse q este id exista en la bd
        $sql = $this->pdo->prepare("SELECT p.nombre, p.apellido, u.usuario,b.tabla, b.actividad, b.fecha_hora FROM segurity.bitacora b INNER JOIN segurity.usuario u ON u.id_usuario = b.id_usuario INNER JOIN bd.personal p ON p.usuario = u.id_usuario WHERE b.id_usuario =:id_usuario");
        $sql->bindParam(":id_usuario", $id_usuario);
        $sql->execute();
        $resultado = $sql->fetchAll();
        echo "EXISTE (" . $id_usuario . "): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que el insumo siexista
        $this->assertNotEmpty($resultado, "La bitacora  con ID del usuario  (" . $id_usuario . ") debería existir en la BD");
    }

    public function testConsultaBitacoraInexistente()
    {
        $id_usuario = 999999; // Caso borde, no debería existir
        $sql = $this->pdo->prepare("SELECT p.nombre, p.apellido, u.usuario,b.tabla, b.actividad, b.fecha_hora FROM segurity.bitacora b INNER JOIN segurity.usuario u ON u.id_usuario = b.id_usuario INNER JOIN bd.personal p ON p.usuario = u.id_usuario WHERE b.id_usuario =:id_usuario");
        $sql->bindParam(":id_usuario", $id_usuario);
        $sql->execute();
        $resultado = $sql->fetchAll();

        // Verificamos que esté vacío
        $this->assertEmpty($resultado, "La bitacora  con ID del usuario  (" . $id_usuario . ") no debería existir en la BD");
    }
}
