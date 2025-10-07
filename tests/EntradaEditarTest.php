<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloEntrada;

class EntradaEditarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloEntrada();
    }

    public function testEditarEntrada()
    {
        $resultado = $this->modelo->actualizarEntrada(
            75,
            6,                   // id_proveedor (debe existir el numero 1 seguro)
            "2025-12-29",           // fecha vencimiento
            1,                     // cantidad
            100,                    // precio
            46,          // este e numerico
        );

        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
