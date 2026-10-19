<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloCategoria;
use Tests\TestHelpers;

/**
 * Módulo: Consultas — Sub. Módulo: Eliminar Categoría
 *
 * Verifica la eliminación lógica de una categoría de servicio. Para no
 * depender de datos concretos, la prueba crea su propia categoría, la
 * elimina y luego la borra físicamente.
 */
class CategoriaEliminarTest extends TestCase
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

    public function testEliminarCategoria()
    {
        // 1. Creamos una categoría propia para poder eliminarla sin tocar
        //    datos reales del sistema.
        $this->modelo->setNombre("Categoria borrar");
        $this->modelo->guardarCategoria();
        $this->idCreado = $this->ultimoIdGenerado('bd', 'categoria_servicio', 'id_categoria');
        $this->assertNotNull($this->idCreado);

        // 2. La eliminamos lógicamente.
        $this->modelo->setIdCategoria($this->idCreado);
        $resultado = $this->modelo->eliminarCategoria();

        $this->assertEquals(["exito"], $resultado);

        // 3. Comprobamos que su estado quedó en 'DES'.
        $pdo = (new \App\modelos\Db())->connectionSistema();
        $stmt = $pdo->prepare("SELECT estado FROM bd.categoria_servicio WHERE id_categoria = :id");
        $stmt->execute(['id' => $this->idCreado]);
        $this->assertEquals('DES', $stmt->fetchColumn());
    }
}
