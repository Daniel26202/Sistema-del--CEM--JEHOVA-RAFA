<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloInsumo;

class InsumoInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloInsumo();

        // internet dice q asi pa q no de error por la carga d la imagen
        $_FILES['imagen'] = [
            'name' => 'prueba.jpg',
            'tmp_name' => __DIR__ . '/dummy.png'
        ];
        file_put_contents($_FILES['imagen']['tmp_name'], 'fakeimage');
    }

    public function testInsertarInsumos()
    {
        $resultado = $this->modelo->insertarInsumos(
            "Insumophpinit",  // nombre
            6,                      // id_proveedor (debe existir el numero 1 seguro)
            "descripcion prueba",
            "2025-01-01",           // fecha ingreso
            "2025-12-31",           // fecha vencimiento
            100,                    // precio
            50,                     // cantidad
            10,                     // stock mínimo
            "ACT",                  // siempre ACT
            "123456789",          // este e numerico
            "MarcaX",
            "100 g",
            1                      // iva
        );

        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
