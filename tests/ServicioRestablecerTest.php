<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloConsultas;

class ServicioRestablecerTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloConsultas();
    }

    public function testRestablecerServicio()
    {
        $resultado = $this->modelo->restablecerServ(
            26
        );
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
