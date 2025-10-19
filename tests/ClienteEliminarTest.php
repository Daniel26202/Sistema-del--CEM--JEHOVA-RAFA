<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloCliente;

class ClienteEliminarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloCliente();
    }

    public function testEliminarCliente()
    {
        $resultado = $this->modelo->delete(
            2000003,
        );
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
