<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class EntradaConsultaTest extends TestCase
{
    private $pdo;
    /* private $id = 51; // lo puse directamente abajo, algo me daba error y no llegaba el numero xd */

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    public function testConsultaEntradaExistente()
    {
        $id_entrada = 38; // hay q asegurarse q este id exista en la bd
        $sql = $this->pdo->prepare("SELECT * FROM entrada WHERE id_entrada = :id_entrada");
        $sql->bindParam(":id_entrada", $id_entrada);
        $sql->execute();
        $resultado = $sql->fetchAll();
        echo "EXISTE (" . $id_entrada . "): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que el entrada siexista
        $this->assertNotEmpty($resultado, "la entrada con ID " . $id_entrada . " debería existir en la BD");
    }

    public function testConsultaEntradaInexistente()
    {
        $id_entrada = 999999; // Caso borde, no debería existir
        $sql = $this->pdo->prepare("SELECT * FROM entrada WHERE id_entrada = :id_entrada");
        $sql->bindParam(":id_entrada", $id_entrada);
        $sql->execute();
        $resultado = $sql->fetchAll();

        // Verificamos que esté vacío
        $this->assertEmpty($resultado, "la entrada con ID ".$id_entrada." no debería existir en la BD");
    }
}
