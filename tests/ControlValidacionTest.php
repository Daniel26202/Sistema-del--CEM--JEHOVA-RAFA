<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloControl;

class ControlValidacionTest extends TestCase
{
    public function testAceptaCamposClinicosValidos(): void
    {
        $modelo = new ModeloControl();
        $modelo->setHistorial('Paciente refiere dolor leve');
        $modelo->setDiagnostico('Diagnostico clinico claro');
        $modelo->setIndicaciones('Tomar medicamento diario');

        $this->assertSame('Paciente refiere dolor leve', $modelo->getHistorial());
        $this->assertSame('Diagnostico clinico claro', $modelo->getDiagnostico());
        $this->assertSame('Tomar medicamento diario', $modelo->getIndicaciones());
    }

    public function testRechazaHistorialConCaracteresNoPermitidos(): void
    {
        $modelo = new ModeloControl();

        $this->assertInvalid(fn() => $modelo->setHistorial('Paciente refiere dolor leve ágil'));
    }

    public function testNotaOpcionalYLimiteDe40Caracteres(): void
    {
        $modelo = new ModeloControl();
        $modelo->setNota(null);
        $this->assertSame('', $modelo->getNota());

        $notaMaxima = str_repeat('n', 40);
        $modelo->setNota($notaMaxima);
        $this->assertSame($notaMaxima, $modelo->getNota());
        $this->assertInvalid(fn() => $modelo->setNota(str_repeat('n', 41)));
        $this->assertInvalid(fn() => $modelo->setNota('<script>'));
    }

    public function testSeveridadSoloAceptaValoresEnumerados(): void
    {
        $modelo = new ModeloControl();
        foreach (['LEVE', 'MODERADA', 'GRAVE'] as $severidad) {
            $modelo->setSeveridad($severidad);
            $this->assertSame($severidad, $modelo->getSeveridad());
        }

        $this->assertInvalid(fn() => $modelo->setSeveridad('URGENTE'));
    }

    public function testFechaRegresoValidaFormatoYReglaDeEdicion(): void
    {
        $modelo = new ModeloControl();
        $fechaFutura = (new DateTimeImmutable('tomorrow'))->format('Y-m-d');
        $modelo->setFechaRegreso($fechaFutura);
        $modelo->setFechaRegreso('2000-01-01', true);

        $this->assertInvalid(fn() => $modelo->setFechaRegreso('2024-02-30'));
        $this->assertInvalid(fn() => $modelo->setFechaRegreso('2000-01-01'));
    }

    public function testAceptaIdentificadoresYCedulaConFormatoValido(): void
    {
        $modelo = new ModeloControl();
        $modelo->setIdControl(123);
        $modelo->setIdPaciente(456);
        $modelo->setIdUsuario(1);
        $modelo->setNacionalidad('V');
        $modelo->setCedula('1234567');

        $this->assertSame(123, (int) $modelo->getIdControl());
        $this->assertSame(456, $modelo->getIdPaciente());
        $this->assertSame('1234567', $modelo->getCedula());
    }

    public function testRechazaCedulaYNacionalidadInvalidas(): void
    {
        $modelo = new ModeloControl();

        $this->assertInvalid(fn() => $modelo->setCedula('123'));
        $this->assertInvalid(fn() => $modelo->setNacionalidad('X'));
    }

    private function assertInvalid(callable $callback): void
    {
        try {
            $callback();
        } catch (InvalidArgumentException $exception) {
            $this->addToAssertionCount(1);
            return;
        }

        $this->fail('Se esperaba InvalidArgumentException.');
    }
}
