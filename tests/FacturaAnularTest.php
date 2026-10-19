<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloReporte;
use App\modelos\ModeloFactura;
use App\modelos\Db;

class FacturaAnularTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $idFactura = null;

    protected function setUp(): void
    {
        $this->modelo = new ModeloReporte();
        $this->db = (new Db())->connectionSistema();
        $this->iniciarSesionDePrueba();
    }

    protected function tearDown(): void
    {
        if ($this->idFactura !== null) {
            $this->db->exec("DELETE FROM bd.pagodefactura WHERE id_factura = " . (int)$this->idFactura);
            $this->db->exec("DELETE FROM bd.detalle_factura WHERE id_factura = " . (int)$this->idFactura);
            $this->borrarRegistro('bd', 'factura', 'id_factura', $this->idFactura);
        }
        $this->cerrarSesionDePrueba();
    }

    public function testAnularFactura()
    {
        // Se crea una factura propia para poder anularla sin alterar datos reales
        $_SESSION['dolar'] = 40.00;
        $_SESSION['dolar_fecha'] = date("Y-m-d");
        $tasa = 40.00;
        $total = round(1500.00 * $tasa, 2);

        $factura = new ModeloFactura();
        $factura->setIdCliente(5);
        $factura->setFecha(date("Y-m-d"));
        $factura->setTipoCambio($tasa);
        $factura->setServicios([23]);
        $factura->setDoctores([21]);
        $factura->setFormasDePago([5]);
        $factura->setMontosPago([$total]);
        $factura->setReferencia("0");
        $factura->setTotal($total);
        $res = $factura->guardarFactura(1);

        $this->assertTrue($res['exito'], "No se pudo preparar la factura: " . ($res['error'] ?? ''));
        $this->idFactura = (int)$res['id_factura'];

        $this->modelo->setIdFactura($this->idFactura);
        $resultado = $this->modelo->anularFac();

        $this->assertEquals("exito", $resultado[0]);
    }
}
