<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloPatologia;
use App\modelos\Db;

class PatologiaEliminarTest extends TestCase
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

    public function testEliminarPatologia()
    {
        // Se crea una patología propia para eliminarla sin afectar datos reales
        $this->modelo->setNombrePatologia("GenericaPrueba");
        $this->modelo->guardarPatologia(1);
        $this->idCreado = $this->ultimoIdGenerado('bd', 'patologia', 'id_patologia');

        // Ahora se elimina lógicamente el registro recién creado
        $this->modelo = new ModeloPatologia();
        $this->modelo->setIdPatologia($this->idCreado);
        $resultado = $this->modelo->deletePatologia(1);

        $this->assertEquals("exito", $resultado[0]);
    }
}
