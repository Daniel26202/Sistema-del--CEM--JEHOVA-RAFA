<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloDoctores;

class EspecialidadInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloDoctores();
    }

    public function testInsertarEspecialidad()
    {
        $resultado = $this->modelo->Especialidadregistrar(
            "Especialidad"
        );
        $this->assertEquals("exito", $resultado [0]);
    }
}
