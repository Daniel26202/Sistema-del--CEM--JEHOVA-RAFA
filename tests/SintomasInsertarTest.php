<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloSintomas;
use App\modelos\Db;

class SintomasInsertarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $idCreado = null;

    protected function setUp(): void
    {
        $this->modelo = new ModeloSintomas();
        $this->db = (new Db())->connectionSistema();
        $this->iniciarSesionDePrueba();
    }

    protected function tearDown(): void
    {
        if ($this->idCreado !== null) {
            $this->borrarRegistro('bd', 'sintomas', 'id_sintomas', $this->idCreado);
        }
        $this->cerrarSesionDePrueba();
    }

    public function testInsertarSintomas()
    {
        $this->modelo->setNombre("SintomaPrueba");
        $resultado = $this->modelo->insertar();
        $this->idCreado = $this->ultimoIdGenerado('bd', 'sintomas', 'id_sintomas');

        $this->assertEquals("exito", $resultado[0]);
    }
}
