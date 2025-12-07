<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class DoctorConsultaTest extends TestCase
{
    private $pdo;
    /* private $id = 51; // lo puse directamente abajo, algo me daba error y no llegaba el numero xd */

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    public function testConsultaDoctorExistente()
    {
        $id_personal = 19; // hay q asegurarse q este id exista en la bd
        $sql = $this->pdo->prepare("SELECT * FROM personal WHERE id_personal = :id_personal AND id_especialidad is not null");
        $sql->bindParam(":id_personal", $id_personal);
        $sql->execute();
        $resultado = $sql->fetchAll();
        echo "EXISTE (" . $id_personal . "): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que el insumo siexista
        $this->assertNotEmpty($resultado, "El Doctor con ID (" . $id_personal . ") debería existir en la BD");
    }

    public function testConsultaDoctorInexistente()
    {
        $id_personal = 999999; // Caso borde, no debería existir
        $sql = $this->pdo->prepare("SELECT * FROM personal WHERE id_personal = :id_personal AND id_especialidad is not null");
        $sql->bindParam(":id_personal", $id_personal);
        $sql->execute();
        $resultado = $sql->fetchAll();

        // Verificamos que esté vacío
        $this->assertEmpty($resultado, "el Doctor con ID (" . $id_personal . ") no debería existir en la BD");
    }
}
