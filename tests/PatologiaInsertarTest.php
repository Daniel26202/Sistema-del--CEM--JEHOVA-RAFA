<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloPatologia;
use App\modelos\Db;

class PatologiaInsertarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $idCreado = null;

    protected function setUp(): void
    {
        $this->modelo = new ModeloPatologia();
        $this->db = (new Db())->connectionSistema();
        $this->iniciarSesionDePrueba();
    }

    protected function tearDown(): void
    {
        if ($this->idCreado !== null) {
            $this->borrarRegistro('bd', 'patologia', 'id_patologia', $this->idCreado);
        }
        $this->cerrarSesionDePrueba();
    }

    public function testInsertarPatologia()
    {
        $this->modelo->setNombrePatologia("GenericaPrueba");
        $resultado = $this->modelo->guardarPatologia(1);
        $this->idCreado = $this->ultimoIdGenerado('bd', 'patologia', 'id_patologia');

        $this->assertEquals("exito", $resultado[0]);
    }
}
