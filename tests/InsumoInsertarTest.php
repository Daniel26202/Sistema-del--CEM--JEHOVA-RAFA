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
        $this->modelo->setNombre_insumo("Insumophpinit");
        $this->modelo->setId_categoria(6);
        $this->modelo->setDescripcion("descripcion prueba");
        $this->modelo->setFecha_vencimiento("2025-01-01");
        $this->modelo->setFecha_compra("2025-12-31");
        $this->modelo->setStock_minimo(100);
        $this->modelo->setStock_actual(50);
        $this->modelo->setPrecio(10);
        $this->modelo->setEstado("ACT");
        $this->modelo->setCodigo_barras("123456789");
        $this->modelo->setMarca("MarcaX");
        $this->modelo->setPeso("100 g");
        $this->modelo->setImagen($_FILES['imagen']['tmp_name']);
        
        $resultado = $this->modelo->insertarInsumos();

        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)


        $this->assertEquals("exito", $resultado[0]);
    }
}
