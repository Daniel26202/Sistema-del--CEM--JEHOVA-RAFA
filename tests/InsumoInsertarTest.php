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
            "Insumophpinit",  
            6,                      
            "descripcion prueba",
            "2025-01-01",          
            "2025-12-31",           
            100,                    
            50,                     
            10,                     
            "ACT",                  
            "123456789",         
            "MarcaX",
            "100 g",
            1                     
        );


        $this->assertEquals("exito", $resultado[0]);
    }
}
