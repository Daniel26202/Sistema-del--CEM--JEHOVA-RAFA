<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloCategoria;
use Tests\TestHelpers;

/**
 * Módulo: Consultas — Sub. Módulo: Registrar Categoría
 *
 * Verifica que el modelo registre una nueva categoría de servicio y que
 * rechace duplicados. La prueba es idempotente: elimina el registro que
 * creó al terminar.
 */
class CategoriaInsertarTest extends TestCase
{
    use TestHelpers;

    private $modelo;
    private $idCreado = null;

    protected function setUp(): void
    {
        $this->modelo = new ModeloCategoria();
        $this->iniciarSesionDePrueba();
    }

    protected function tearDown(): void
    {
        if ($this->idCreado !== null) {
            $this->borrarRegistro('bd', 'categoria_servicio', 'id_categoria', $this->idCreado);
        }
        $this->cerrarSesionDePrueba();
    }

    public function testInsertarCategoria()
    {
        $this->modelo->setNombre("Categorizacion prueba");

        $resultado = $this->modelo->guardarCategoria();

        $this->assertIsArray($resultado);
        $this->assertEquals("exito", $resultado[0]);

        // Guardamos el id recién creado para limpiarlo en tearDown().
        $this->idCreado = $this->ultimoIdGenerado('bd', 'categoria_servicio', 'id_categoria');
        $this->assertNotNull($this->idCreado);
    }

    public function testNoPermiteCategoriaDuplicada()
    {
        $this->modelo->setNombre("Cardiologia");
        $resultado = $this->modelo->guardarCategoria();

        // "CARDIOLOGIA" ya existe en la base (aunque esté DES): el modelo
        // debe rechazarla en lugar de crear un duplicado.
        $this->assertIsString($resultado);
    }
}
