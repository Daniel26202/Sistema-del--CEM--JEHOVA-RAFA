<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloDoctores;

class DoctorInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloDoctores();
    }

    public function testInsertarDoctor()
    {
        $resultado = $this->modelo->insertarDoctor(
            3722990,
            "Garek",
            "Croket",
            "04123454327",
            "Garek123",
            "Garek123*",
            "Garek123@mail.com",
            "V",
            "imagen.php",
            "./imagenTMP.php",
            3,
            [0 => 2],
            [0 => "10:00"],
            [0 => "20:00"],
        );

        $this->assertEquals("exito", $resultado[0]);
    }
}
