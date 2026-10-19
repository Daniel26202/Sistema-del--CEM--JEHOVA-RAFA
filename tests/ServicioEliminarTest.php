<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloServicios;
use App\modelos\Db;

class ServicioEliminarTest extends TestCase
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

    public function testEliminarServicio()
    {
        // Se crea un servicio propio para eliminarlo sin afectar datos reales
        $this->modelo->setIdCategoria(111);
        $this->modelo->setTipo("Cita");
        $this->modelo->setPrecio(100);
        $this->modelo->guardarServicio(1);
        $this->idCreado = $this->ultimoIdGenerado('bd', 'serviciomedico', 'id_servicioMedico');

        // Ahora se elimina lógicamente el servicio recién creado
        $this->modelo = new ModeloServicios();
        $this->modelo->setIdServicioMedico($this->idCreado);
        $resultado = $this->modelo->eliminarServicio(1);

        $this->assertEquals("exito", $resultado[0]);
    }
}
