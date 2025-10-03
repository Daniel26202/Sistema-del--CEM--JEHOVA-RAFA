<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class CitaConsultarTest extends TestCase
{
    private $pdo;
    /* private $id = 51; // lo puse directamente abajo, algo me daba error y no llegaba el numero xd */

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    public function testConsultaCitaExistente()
    {
        $id_cita = 62; // hay q asegurarse q este id exista en la bd
        $sql = $this->pdo->prepare("SELECT * FROM cita WHERE id_cita = :id_cita");
        $sql->bindParam(":id_cita", $id_cita);
        $sql->execute();
        $resultado = $sql->fetchAll();
        echo "EXISTE (" . $id_cita . "): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que el insumo siexista
        $this->assertNotEmpty($resultado, "La cita con ID (" . $id_cita . ") debería existir en la BD");
    }

    public function testConsultaCitaInexistente()
    {
        $id_cita = 999999; // Caso borde, no debería existir
        $sql = $this->pdo->prepare("SELECT * FROM cita WHERE id_cita = :id_cita");
        $sql->bindParam(":id_cita", $id_cita);
        $sql->execute();
        $resultado = $sql->fetchAll();

        // Verificamos que esté vacío
        $this->assertEmpty($resultado, "La cita con ID (" . $id_cita . ") no debería existir en la BD");
    }
}
