<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloDoctores;

class EspecialidadEliminarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloDoctores();
    }

    public function testEliminarEspecialidad()
    {
        $resultado = $this->modelo->Especialidadeliminar(
            8
        );
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
