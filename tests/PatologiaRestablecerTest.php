<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloPatologia;
use App\modelos\Db;

class PatologiaRestablecerTest extends TestCase
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

    public function testRestablecerPatologia()
    {
        // Se crea una patología propia, se elimina y luego se restablece
        $this->modelo->setNombrePatologia("GenericaPrueba");
        $this->modelo->guardarPatologia(1);
        $this->idCreado = $this->ultimoIdGenerado('bd', 'patologia', 'id_patologia');

        $this->modelo = new ModeloPatologia();
        $this->modelo->setIdPatologia($this->idCreado);
        $this->modelo->deletePatologia(1, 'DES');

        $this->modelo = new ModeloPatologia();
        $this->modelo->setIdPatologia($this->idCreado);
        $resultado = $this->modelo->deletePatologia(1, 'ACT');

        $this->assertEquals("exito", $resultado[0]);
    }
}
