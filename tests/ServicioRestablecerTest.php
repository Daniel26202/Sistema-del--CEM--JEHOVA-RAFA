<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloServicios;
use App\modelos\Db;

class ServicioRestablecerTest extends TestCase
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

    public function testRestablecerServicio()
    {
        // Se crea un servicio propio, se elimina y luego se restablece
        $this->modelo->setIdCategoria(112);
        $this->modelo->setTipo("Cita");
        $this->modelo->setPrecio(100);
        $this->modelo->guardarServicio(1);
        $this->idCreado = $this->ultimoIdGenerado('bd', 'serviciomedico', 'id_servicioMedico');

        $this->modelo = new ModeloServicios();
        $this->modelo->setIdServicioMedico($this->idCreado);
        $this->modelo->eliminarServicio(1);

        $this->modelo = new ModeloServicios();
        $this->modelo->setIdServicioMedico($this->idCreado);
        $resultado = $this->modelo->restablecerServicio(1);

        $this->assertEquals("exito", $resultado[0]);
    }
}
