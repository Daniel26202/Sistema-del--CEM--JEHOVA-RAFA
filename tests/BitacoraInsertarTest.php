<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloBitacora;
use Tests\TestHelpers;

//verifica el registro de actividades en la bitácora.
class BitacoraInsertarTest extends TestCase
{
    use TestHelpers;

    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloBitacora();
        $this->iniciarSesionDePrueba();
    }

    protected function tearDown(): void
    {
        $this->cerrarSesionDePrueba();
    }

    public function testInsertarBitacora()
    {
        $pdo = (new \App\modelos\Db())->connectionSegurity();
        $antes = (int)$pdo->query("SELECT COUNT(*) FROM bitacora")->fetchColumn();

        $this->modelo->setId_usuario(1);
        $this->modelo->setActividad("se hizo una prueba unitaria");
        $this->modelo->setTabla("php unit");

        $resultado = $this->modelo->insertarBitacora();

        $this->assertIsArray($resultado);
        $this->assertEquals("exito", $resultado[0]);

        // Se comprueba que realmente se haya escrito en la bitácora.
        $despues = (int)$pdo->query("SELECT COUNT(*) FROM bitacora")->fetchColumn();
        $this->assertEquals($antes + 1, $despues);
    }
}
