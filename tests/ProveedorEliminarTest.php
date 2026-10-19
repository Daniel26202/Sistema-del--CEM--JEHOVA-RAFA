<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloProveedores;
use App\modelos\Db;

class ProveedorEliminarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $idCreado = null;

    protected function setUp(): void
    {
        $this->modelo = new ModeloProveedores();
        $this->db = (new Db())->connectionSistema();
        $this->iniciarSesionDePrueba();
    }

    protected function tearDown(): void
    {
        if ($this->idCreado !== null) {
            $this->borrarRegistro('bd', 'proveedor', 'id_proveedor', $this->idCreado);
        }
        $this->cerrarSesionDePrueba();
    }

    public function testProvedorEliminar()
    {
        // Se crea un proveedor propio para eliminarlo sin afectar datos reales
        $this->modelo->setNombre("Carlos");
        $this->modelo->setRif("J122306");
        $this->modelo->setTelefono("04243545561");
        $this->modelo->setEmail("CCC12345@gmail.com");
        $this->modelo->setDireccion("El Tocuyo");
        $this->modelo->guardarEntrada(1);
        $this->idCreado = $this->ultimoIdGenerado('bd', 'proveedor', 'id_proveedor');

        // Ahora se elimina lógicamente el registro recién creado
        $this->modelo = new ModeloProveedores();
        $this->modelo->setIdProveedor($this->idCreado);
        $resultado = $this->modelo->deleteEntrada(1);

        $this->assertEquals("exito", $resultado[0]);
    }
}
