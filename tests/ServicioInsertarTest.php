<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloServicios;
use App\modelos\Db;

class ServicioInsertarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $idCreado = null;

    protected function setUp(): void
    {
        $this->modelo = new ModeloServicios();
        $this->db = (new Db())->connectionSistema();
        $this->iniciarSesionDePrueba();
    }

    protected function tearDown(): void
    {
        if ($this->idCreado !== null) {
            $this->borrarRegistro('bd', 'serviciomedico', 'id_servicioMedico', $this->idCreado);
        }
        $this->cerrarSesionDePrueba();
    }

    public function testInsertarServicio()
    {
        // categoría 109 existe y no tiene aún un servicio de tipo "Cita"
        $this->modelo->setIdCategoria(109);
        $this->modelo->setTipo("Cita");
        $this->modelo->setPrecio(100);
        $resultado = $this->modelo->guardarServicio(1);
        $this->idCreado = $this->ultimoIdGenerado('bd', 'serviciomedico', 'id_servicioMedico');

        $this->assertEquals("exito", $resultado[0]);
    }
}
