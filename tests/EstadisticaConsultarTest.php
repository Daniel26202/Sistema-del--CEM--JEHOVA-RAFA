<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloEstadisticas;

/**
 * Módulo: Estadísticas.
 * Sub-módulo: Consulta de gráficas y reportes estadísticos
 * (distribución por edad/género, insumos y tasa de morbilidad).
 */
class EstadisticaConsultarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;

    protected function setUp(): void
    {
        // Las estadísticas se leen de las vistas del sistema (bd).
        $this->modelo = new ModeloEstadisticas();
    }

    /** La distribución por edad y género devuelve datos de la vista. */
    public function testDistribucionEdadGenero()
    {
        $resultado = $this->modelo->distribucion_edad_genero();

        $this->assertIsArray($resultado, "distribucion_edad_genero debe devolver un arreglo");
        $this->assertNotEmpty($resultado, "La vista debe contener información de pacientes");
    }

    /** El listado de insumos estadísticos devuelve un arreglo (puede estar vacío). */
    public function testInsumos()
    {
        $resultado = $this->modelo->insumos();

        $this->assertIsArray($resultado, "insumos debe devolver un arreglo");
    }

    /** Sin fechas, la tasa de morbilidad devuelve el consolidado general. */
    public function testTasaMorbilidadSinFechas()
    {
        $resultado = $this->modelo->obtenerTasaMorbilidad();

        $this->assertIsArray($resultado, "Sin fechas debe devolver el consolidado");
        $this->assertNotEmpty($resultado, "La vista de morbilidad debe contener datos");
    }

    /** Con un rango de fechas válido se calcula la tasa de morbilidad. */
    public function testTasaMorbilidadConRango()
    {
        $resultado = $this->modelo->obtenerTasaMorbilidad("2020-01-01", date("Y-m-d", strtotime("-1 day")));

        $this->assertIsArray($resultado, "Con fechas debe devolver un arreglo");
    }

    /** Una fecha futura no es aceptada por el setter. */
    public function testTasaMorbilidadFechaFutura()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->modelo->setFechaInicio(date("Y-m-d", strtotime("+1 day")));
    }

    /** Una fecha con formato inválido no es aceptada por el setter. */
    public function testTasaMorbilidadFechaFormatoInvalido()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->modelo->setFechaFinal("31/12/2020");
    }
}
