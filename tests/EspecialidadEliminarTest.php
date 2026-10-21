<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloDoctores;
use App\modelos\Db;

class EspecialidadEliminarTest extends TestCase
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

    public function testEliminarEspecialidad()
    {
        // Se crea una especialidad para eliminarla
        $this->borrarRegistro('bd', 'especialidad', 'nombre', $this->nombre);
        $m = new ModeloDoctores();
        $m->setNombreEspecialidad($this->nombre);
        $m->EspecialidadRegistrar(1);

        $fila = $this->db->query("SELECT id_especialidad FROM bd.especialidad WHERE nombre = '{$this->nombre}' ORDER BY id_especialidad DESC LIMIT 1")->fetch(\PDO::FETCH_ASSOC);

        $this->modelo->setIdEspecialidad((int)$fila['id_especialidad']);
        $resultado = $this->modelo->EspecialidadEliminar(1);

        $this->assertEquals("exito", $resultado[0]);
    }
}
