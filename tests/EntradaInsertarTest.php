<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloEntrada;

class EntradaInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloEntrada();
    }

    public function testInsertarEntrada()
    {
        $resultado = $this->modelo->insertarEntrada(
            6,                   // id_proveedor (debe existir el numero 1 seguro)
            44,
            "2025-10-03",           // fecha ingreso
            "2025-12-31",           // fecha vencimiento
            1,                     // cantidad
            100,                    // precio
            "12345679",          // este e numerico
        );

        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
