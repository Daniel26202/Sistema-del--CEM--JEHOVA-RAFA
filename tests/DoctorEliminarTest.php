<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloDoctores;

class DoctorEliminarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloDoctores();
    }

    public function testEliminarDoctor()
    {
        $resultado = $this->modelo->eliminacionLogica(
            47
        );
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
