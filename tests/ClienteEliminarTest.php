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
        $this->modelo->setId_cliente(2000003);
        $resultado = $this->modelo->delete();
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
