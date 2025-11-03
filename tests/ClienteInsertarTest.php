<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloCliente;

class ClienteInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloCliente();
    }

    public function testInsertarCliente()
    {
        $resultado = $this->modelo->insertar(
            "V",
            3722999,
            "Pedro",
            "Perez",
            "04123454327",
            "en su casa",
            "2002-02-20",
            "Masculino"
        );

        $this->assertEquals("exito", $resultado[0]);
    }
}
