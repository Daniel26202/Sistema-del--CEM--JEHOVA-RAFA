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
        $this->modelo->setNombre_especialidad("Especialidad");
        $resultado = $this->modelo->Especialidadregistrar();
        $this->assertEquals("exito", $resultado [0]);
    }
}
