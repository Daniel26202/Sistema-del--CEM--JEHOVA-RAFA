<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloCliente;

class ClienteEditarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloCliente();
    }

    public function testEditarCliente()
    {
        $resultado = $this->modelo->update(
            2,
            "V",
            2000002,
            "Editado",
            "Modificado",
            "04123454320",
            "en su casa",
            "2002-02-20",
            "Masculino"
        );
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
