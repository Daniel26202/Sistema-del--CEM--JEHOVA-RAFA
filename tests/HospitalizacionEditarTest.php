<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloHospitalizacion;

class HospitalizacionEditarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloHospitalizacion();
    }

    public function testEditarHospitalizacion()
    {
        $this->modelo->setId_hospitalizacion(36);
        $this->modelo->setId_paciente(1);
        $this->modelo->setId_doctor(1);
        $this->modelo->setTipo_hospitalizacion("historial");    
        $this->modelo->setFecha_ingreso("2025-11-01");
        $this->modelo->setFecha_egreso("2025-11-28");   
        $resultado = $this->modelo->editarH(
            36,
            [0 => 1],
            [0 => 1],
            "historial",
            28,
            28,
            0
        );
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado);
    }
}
