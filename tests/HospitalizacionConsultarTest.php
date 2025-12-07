<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class HospitalizacionConsultarTest extends TestCase
{
    private $pdo;
    /* private $id = 51; // lo puse directamente abajo, algo me daba error y no llegaba el numero xd */

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    public function testConsultaHospitalizacionExistente()
    {
        $id_hospitalizacion = 27; // hay q asegurarse q este id exista en la bd
        $sql = $this->pdo->prepare("SELECT * FROM hospitalizacion WHERE id_hospitalizacion = :id_hospitalizacion");
        $sql->bindParam(":id_hospitalizacion", $id_hospitalizacion);
        $sql->execute();
        $resultado = $sql->fetchAll();
        echo "EXISTE (" . $id_hospitalizacion . "): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que el insumo siexista
        $this->assertNotEmpty($resultado, "La hospitalizacion con ID (" . $id_hospitalizacion . ") debería existir en la BD");
    }

    public function testConsultaHospitalizacionInexistente()
    {
        $id_hospitalizacion = 999999; // Caso borde, no debería existir
        $sql = $this->pdo->prepare("SELECT * FROM hospitalizacion WHERE id_hospitalizacion = :id_hospitalizacion");
        $sql->bindParam(":id_hospitalizacion", $id_hospitalizacion);
        $sql->execute();
        $resultado = $sql->fetchAll();

        // Verificamos que esté vacío
        $this->assertEmpty($resultado, "La hospitalizacion con ID (" . $id_hospitalizacion . ") no debería existir en la BD");
    }
}
