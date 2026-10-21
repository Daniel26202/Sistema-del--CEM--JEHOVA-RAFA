<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloEntrada;
use App\modelos\Db;

class EntradaInsertarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $lote = "999000111";
    private $idEntrada = null;

    protected function setUp(): void
    {
        $this->modelo = new ModeloEntrada();
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
        $this->db->exec("DELETE ei FROM bd.entrada_insumo ei INNER JOIN bd.entrada e ON e.id_entrada = ei.id_entrada WHERE e.numero_de_lote = '{$this->lote}'");
        $this->db->exec("DELETE FROM bd.entrada WHERE numero_de_lote = '{$this->lote}'");
    }

    public function testInsertarEntrada()
    {
        $this->limpiar();

        $this->modelo->setIdProveedor(6);
        $this->modelo->setIdInsumo(49);
        $this->modelo->setFechaDeIngreso(date("Y-m-d"));
        $this->modelo->setFechaDeVencimiento("2027-12-31");
        $this->modelo->setPrecio(100);
        $this->modelo->setCantidadDisponible(5);
        $this->modelo->setLote($this->lote);

        $resultado = $this->modelo->guardarEntrada(1);

        $this->assertEquals("exito", $resultado[0]);
    }
}
