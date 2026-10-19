<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloSintomas;
use App\modelos\Db;

class SintomasEliminarTest extends TestCase
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

    public function testEliminarSintomas()
    {
        // Se crea un síntoma propio para eliminarlo sin afectar datos reales
        $this->modelo->setNombre("SintomaPrueba");
        $this->modelo->insertar();
        $this->idCreado = $this->ultimoIdGenerado('bd', 'sintomas', 'id_sintomas');

        // Ahora se elimina lógicamente el síntoma recién creado
        $this->modelo = new ModeloSintomas();
        $this->modelo->setIdSintomas($this->idCreado);
        $resultado = $this->modelo->eliminarL();

        $this->assertEquals("exito", $resultado[0]);
    }
}
