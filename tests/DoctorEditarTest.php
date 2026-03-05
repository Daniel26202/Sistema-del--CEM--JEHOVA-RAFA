<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloDoctores;

class DoctorEditarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloDoctores();
    }

    public function testEditarDoctor()
    {
        $this->modelo->setId_usuario(47);
        $this->modelo->setNombre("Garek");
        $this->modelo->setApellido("Croket");
        $this->modelo->setTelefono("04123454327");
        $this->modelo->setId_doctor(21);
        $this->modelo->setCorreo("Garek123@mail.com");
        $this->modelo->setTipo_identificacion("V");
        $this->modelo->setNumero_identificacion(3722990);
        $this->modelo->setId_especialidad([0 => 9]);
        $this->modelo->setId_horario([0 => 10]);
        $this->modelo->setId_dia([0 => 9]);
        $this->modelo->setId_sala([0 => 10]);
        $this->modelo->setId_estado([0 => 2]);
        $this->modelo->setHora_inicio([0 => "10:00"]);
        $this->modelo->setHora_fin([0 => "20:00"]);
        $resultado = $this->modelo->updateDoctor();
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
