<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloServicios;
use App\modelos\Db;

class ServicioEditarTest extends TestCase
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

    public function testEditarServicio()
    {
        // Se crea un servicio propio para poder editarlo sin afectar datos reales
        $this->modelo->setIdCategoria(110);
        $this->modelo->setTipo("Cita");
        $this->modelo->setPrecio(100);
        $this->modelo->guardarServicio(1);
        $this->idCreado = $this->ultimoIdGenerado('bd', 'serviciomedico', 'id_servicioMedico');

        // Ahora se edita el servicio recién creado (solo precio y tipo)
        $this->modelo = new ModeloServicios();
        $this->modelo->setIdServicioMedico($this->idCreado);
        $this->modelo->setTipo("Cita");
        $this->modelo->setPrecio(250);
        $resultado = $this->modelo->editarServicio(1);

        $this->assertEquals("exito", $resultado[0]);
    }
}
