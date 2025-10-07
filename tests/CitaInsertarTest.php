<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloCita;

class CitaInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloCita();
    }

    public function testInsertarCita()
    {
        $resultado = $this->modelo->insertarCita(
            25,
            24,
            "2025-10-06",
            "20:00",
            "Pendiente",
            19
        );
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
