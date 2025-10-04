<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloDoctores;

class DoctorEditarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloDoctores();
    }

    public function testEditarDoctor()
    {
        $resultado = $this->modelo->updateDoctor(
            3722990,
            "Garek",
            "Croket",
            "04123454327",
            47,
            21,
            "Garek123@mail.com",
            "V",
            [0 => 9],
            [0 => 10],
            [0 => 9],
            [0 => 10],
            [0 => 2],
            [0 => "10:00"],
            [0 => "20:00"],
        );
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
