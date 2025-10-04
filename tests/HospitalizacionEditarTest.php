<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloHospitalizacion;

class HospitalizacionEditarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloHospitalizacion();
    }

    public function testEditarHospitalizacion()
    {
        $resultado = $this->modelo->editarH(
            36,
            [0 => 1],
            [0 => 1],
            "historial",
            28,
            28,
            0
        );
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
