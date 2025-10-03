<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class ServicioConsultarTest extends TestCase
{
    private $pdo;
    /* private $id = 51; // lo puse directamente abajo, algo me daba error y no llegaba el numero xd */

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    public function testConsultaServicioExistente()
    {
        $id_servicioMedico = 22; // hay q asegurarse q este id exista en la bd
        $sql = $this->pdo->prepare("SELECT * FROM serviciomedico WHERE id_servicioMedico = :id_servicioMedico");
        $sql->bindParam(":id_servicioMedico", $id_servicioMedico);
        $sql->execute();
        $resultado = $sql->fetchAll();
        echo "EXISTE (" . $id_servicioMedico . "): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que el insumo siexista
        $this->assertNotEmpty($resultado, "La servicio medio con ID (" . $id_servicioMedico . ") debería existir en la BD");
    }

    public function testConsultaServicioInexistente()
    {
        $id_servicioMedico = 999999; // Caso borde, no debería existir
        $sql = $this->pdo->prepare("SELECT * FROM serviciomedico WHERE id_servicioMedico = :id_servicioMedico");
        $sql->bindParam(":id_servicioMedico", $id_servicioMedico);
        $sql->execute();
        $resultado = $sql->fetchAll();

        // Verificamos que esté vacío
        $this->assertEmpty($resultado, "La servicio medio con ID (" . $id_servicioMedico . ") no debería existir en la BD");
    }
}
