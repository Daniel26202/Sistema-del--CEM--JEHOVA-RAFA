<?php

use PHPUnit\Framework\TestCase;
use App\modelos\Db;

class ClienteConsultarTest extends TestCase
{
    private $pdo;
    /* private $id = 51; // lo puse directamente abajo, algo me daba error y no llegaba el numero xd */

    protected function setUp(): void
    {
        // Crear conexión real a la DB
        $db = new Db();
        $this->pdo = $db->connectionSistema();
    }

    public function testConsultaClienteExistente()
    {
        $id_cliente = 1; // hay q asegurarse q este id exista en la bd
        $sql = $this->pdo->prepare("SELECT * FROM cliente WHERE id_cliente = :id_cliente");
        $sql->bindParam(":id_cliente", $id_cliente);
        $sql->execute();
        $resultado = $sql->fetchAll();
        echo "EXISTE (51): " . (empty($resultado) ? "FAIL" : "OK");

        // Verificamos que el insumo siexista
        $this->assertNotEmpty($resultado, "El cliente con ID " . $id_cliente . " debería existir en la BD");
    }

    public function testConsultaClienteInexistente()
    {
        $id_cliente = 999999; // Caso borde, no debería existir
        $sql = $this->pdo->prepare("SELECT * FROM cliente WHERE id_cliente = :id_cliente");
        $sql->bindParam(":id_cliente", $id_cliente);
        $sql->execute();
        $resultado = $sql->fetchAll();

        // Verificamos que esté vacío
        $this->assertEmpty($resultado, "El cliente con ID ". $id_cliente." no debería existir en la BD");
    }
}
