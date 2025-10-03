<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloConsultas;

class ServicioInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloConsultas();
    }

    public function testInsertarServicio()
    {
        $resultado = $this->modelo->insertarSevicio(
            9,
            100,
            "Cita"
        );
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
