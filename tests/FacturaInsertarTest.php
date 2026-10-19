<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloFactura;
use App\modelos\Db;

class FacturaInsertarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $idFactura = null;

    protected function setUp(): void
    {
        $this->modelo = new ModeloFactura();
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

    public function testInsertarFactura()
    {
        // Se fija la tasa en sesión para no depender de la API externa
        $tasa = 40.00;
        $_SESSION['dolar'] = $tasa;
        $_SESSION['dolar_fecha'] = date("Y-m-d");

        // Servicio activo 23 (categoria 100, precio 1500 div.)
        $precioServicio = 1500.00;
        $total = round($precioServicio * $tasa, 2);

        $this->modelo->setIdCliente(5);
        $this->modelo->setFecha(date("Y-m-d"));
        $this->modelo->setTipoCambio($tasa);
        $this->modelo->setServicios([23]);
        $this->modelo->setDoctores([21]);
        $this->modelo->setFormasDePago([5]); // 5 = Efectivo
        $this->modelo->setMontosPago([$total]);
        $this->modelo->setReferencia("0");
        $this->modelo->setTotal($total);

        $resultado = $this->modelo->guardarFactura(1);

        if (!empty($resultado['id_factura'])) {
            $this->idFactura = (int)$resultado['id_factura'];
        }

        $this->assertTrue($resultado['exito'], "La factura no se guardó: " . ($resultado['error'] ?? ''));
    }
}
