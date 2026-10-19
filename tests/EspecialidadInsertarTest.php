<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloDoctores;
use App\modelos\Db;

class EspecialidadInsertarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $nombre = "Especialidad";

    protected function setUp(): void
    {
        $this->modelo = new ModeloDoctores();
        $this->db = (new Db())->connectionSistema();
        $this->iniciarSesionDePrueba();
    }

    protected function tearDown(): void
    {
        $this->borrarRegistro('bd', 'especialidad', 'nombre', $this->nombre);
        $this->cerrarSesionDePrueba();
    }

    public function testInsertarEspecialidad()
    {
        $this->borrarRegistro('bd', 'especialidad', 'nombre', $this->nombre);

        $this->modelo->setNombreEspecialidad($this->nombre);
        $resultado = $this->modelo->EspecialidadRegistrar(1);

        $this->assertEquals("exito", $resultado[0]);
    }
}
