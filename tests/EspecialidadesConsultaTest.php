<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class EspecialidadesConsultaTest extends TestCase
{
    private $pdo;
    /* private $id = 51; // lo puse directamente abajo, algo me daba error y no llegaba el numero xd */

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    public function testConsultaEspecialidaExistente()
    {
        $id_especialidad = 7; // hay q asegurarse q este id exista en la bd
        $sql = $this->pdo->prepare("SELECT * FROM especialidad WHERE id_especialidad = :id_especialidad");
        $sql->bindParam(":id_especialidad", $id_especialidad);
        $sql->execute();
        $resultado = $sql->fetchAll();
        echo "EXISTE (" . $id_especialidad . "): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que el insumo siexista
        $this->assertNotEmpty($resultado, "La especilidad con ID (" . $id_especialidad . ") debería existir en la BD");
    }

    public function testConsultaEspecialidadInexistente()
    {
        $id_especialidad = 999999; // Caso borde, no debería existir
        $sql = $this->pdo->prepare("SELECT * FROM especialidad WHERE id_especialidad = :id_especialidad");
        $sql->bindParam(":id_especialidad", $id_especialidad);
        $sql->execute();
        $resultado = $sql->fetchAll();

        // Verificamos que esté vacío
        $this->assertEmpty($resultado, "La especilidad con ID (" . $id_especialidad . ") no debería existir en la BD");
    }
}
