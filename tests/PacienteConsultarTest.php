<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class PacienteConsultarTest extends TestCase
{
    private $pdo;
    /* private $id = 51; // lo puse directamente abajo, algo me daba error y no llegaba el numero xd */

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    public function testConsultaPacienteExistente()
    {
        $id_paciente = 51; // hay q asegurarse q este id exista en la bd
        $sql = $this->pdo->prepare("SELECT * FROM paciente WHERE id_paciente = :id_paciente");
        $sql->bindParam(":id_paciente", $id_paciente);
        $sql->execute();
        $resultado = $sql->fetchAll();
        echo "EXISTE (51): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que el insumo siexista
        $this->assertNotEmpty($resultado, "El paciente con ID 51 debería existir en la BD");
    }

    public function testConsultaPacienteInexistente()
    {
        $id_paciente = 999999; // Caso borde, no debería existir
        $sql = $this->pdo->prepare("SELECT * FROM paciente WHERE id_paciente = :id_paciente");
        $sql->bindParam(":id_paciente", $id_paciente);
        $sql->execute();
        $resultado = $sql->fetchAll();

        // Verificamos que esté vacío
        $this->assertEmpty($resultado, "El paciente con ID 999999 no debería existir en la BD");
    }
}
