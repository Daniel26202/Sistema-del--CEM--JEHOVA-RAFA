<?php

use PHPUnit\Framework\TestCase;
use App\modelos\ModeloEntrada;
use App\modelos\Db;

class EntradaEliminarTest extends TestCase
{
    use Tests\TestHelpers;

    private $modelo;
    private $db;
    private $lote = "999000111";

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

    private function crearEntrada(): int
    {
        $this->limpiar();
        $m = new ModeloEntrada();
        $m->setIdProveedor(6);
        $m->setIdInsumo(49);
        $m->setFechaDeIngreso(date("Y-m-d"));
        $m->setFechaDeVencimiento("2027-12-31");
        $m->setPrecio(100);
        $m->setCantidadDisponible(5);
        $m->setLote($this->lote);
        $m->guardarEntrada(1);

        $fila = $this->db->query("SELECT id_entrada FROM bd.entrada WHERE numero_de_lote = '{$this->lote}' ORDER BY id_entrada DESC LIMIT 1")->fetch(\PDO::FETCH_ASSOC);
        return (int)$fila['id_entrada'];
    }

    public function testEliminarEntrada()
    {
        $idEntrada = $this->crearEntrada();

        $this->modelo->setIdEntrada($idEntrada);
        $resultado = $this->modelo->eliminarEntrada(1);

        $this->assertEquals("exito", $resultado[0]);
    }
}
