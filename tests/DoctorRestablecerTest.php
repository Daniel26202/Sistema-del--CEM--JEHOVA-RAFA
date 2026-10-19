<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloDoctores;
use App\modelos\Db;

class DoctorRestablecerTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $cedula = "9912345";
    private $usuario = "docprueba9";

    protected function setUp(): void
    {
        $this->modelo = new ModeloDoctores();
        $this->db = (new Db())->connectionSistema();
        $this->iniciarSesionDePrueba();
    }

    protected function tearDown(): void
    {
        $this->limpiar();
        $this->cerrarSesionDePrueba();
    }

    private function limpiar(): void
    {
        $this->db->exec("DELETE FROM bd.horarioydoctor WHERE id_personal IN (SELECT id_personal FROM bd.personal WHERE cedula = '{$this->cedula}')");
        $this->db->exec("DELETE FROM bd.personal WHERE cedula = '{$this->cedula}'");
        $this->db->exec("DELETE FROM segurity.usuario WHERE usuario = '{$this->usuario}'");
    }

    public function testRestablecerDoctor()
    {
        $this->limpiar();

        $this->modelo->setNacionalidad("V");
        $this->modelo->setCedula($this->cedula);
        $this->modelo->setNombre("Garek");
        $this->modelo->setApellido("Croket");
        $this->modelo->setTelefono("04123454327");
        $this->modelo->setUsuario($this->usuario);
        $this->modelo->setPassword("Garek123*");
        $this->modelo->setEmail("garekprueba@mail.com");
        $this->modelo->setIdRol(5);
        $this->modelo->setIdEspecialidad(4);
        $this->modelo->setHorarios([9 => ['entrada' => '10:00', 'salida' => '20:00']]);
        $this->modelo->insertarDoctor(1);

        $idUsuario = $this->db->query("SELECT id_usuario FROM segurity.usuario WHERE usuario = '{$this->usuario}'")->fetch(\PDO::FETCH_ASSOC)['id_usuario'];

        // Se elimina y luego se restablece
        $this->modelo = new ModeloDoctores();
        $this->modelo->setIdUsuario($idUsuario);
        $this->modelo->eliminacionLogica(1);

        $this->modelo = new ModeloDoctores();
        $this->modelo->setIdUsuario($idUsuario);
        $resultado = $this->modelo->restablecerDoctor(1);

        $this->assertEquals("exito", $resultado[0]);
    }
}
