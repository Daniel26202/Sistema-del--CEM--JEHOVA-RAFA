<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloPatologia;

class PatologiaInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloPatologia();
    }

    public function testInsertarPatologia()
    {
        $this->modelo->setNombre_patologia("Generica");
        $resultado = $this->modelo->insertarPatologia();
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado[0]);
    }
}
