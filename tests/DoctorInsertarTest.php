<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloDoctores;

class DoctorInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloDoctores();
    }

    public function testInsertarDoctor()
    {
        $this->modelo->setTipo_documento("V");
        $this->modelo->setNumero_documento(3722990);
        $this->modelo->setNombre("Garek");
        $this->modelo->setApellido("Croket");
        $this->modelo->setTelefono("04123454327");
        $this->modelo->setUsuario("Garek123");
        $this->modelo->setContrasena("Garek123*");
        $this->modelo->setCorreo("Garek123@mail.com");
        $this->modelo->setImagen("imagen.php");
        $this->modelo->setImagen_tmp("./imagenTMP.php");
        $this->modelo->setId_estado(3);
        $this->modelo->setId_especialidad([0 => 2]);
        $this->modelo->setHora_inicio([0 => "10:00"]);
        $this->modelo->setHora_fin([0 => "20:00"]);
        $resultado = $this->modelo->insertarDoctor();

        $this->assertEquals("exito", $resultado[0]);
    }
}
