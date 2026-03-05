<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloHospitalizacion;

class HospitalizacionInsertarTest extends TestCase
{
    private $modelo;

    protected function setUp(): void
    {
        $this->modelo = new ModeloHospitalizacion();
    }

    public function testInsertarHospitalizacion()
    {
        $this->modelo->setId_paciente(1);
        $this->modelo->setId_doctor(1);
        $this->modelo->setTipo_hospitalizacion("historial");
        $this->modelo->setFecha_ingreso("2025-10-03 19:08:57");
        $this->modelo->setFecha_egreso("2025-10-31 19:08:57");
        $resultado = $this->modelo->insertarH(
            34,
            "2025-10-03 19:08:57",
            [0 => 36],
            [0 => 1],
            "historial"
        );
        // Esperamos que devuelva exito, si no, algo falló, hay que revisar (antes era 1 y ahora es "exito", hay q tener cuidado con los datos de entrada)
        $this->assertEquals("exito", $resultado[0]);
    }
}
