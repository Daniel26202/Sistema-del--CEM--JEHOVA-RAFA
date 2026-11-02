<?php

namespace App\modelos;

use App\modelos\ModelBase;

//registra los consumos de insumos de una hospitalización.
class ModeloFacturaHospitalizacion extends ModelBase
{
	private $idH, $idInsumo, $cantidad;

	public function __construct($dbSystem = true)
	{
		parent::__construct($dbSystem);
	}

	//valida el stock y registra el consumo de insumos de la hospitalización.
	public function registrarConsumo($idUsuario = null)
	{
		$transaccionActiva = false;
		try {
			if (session_status() !== PHP_SESSION_ACTIVE) {
				session_start();
			}
			if (!isset($_SESSION['id_usuario']) && $idUsuario === null) {
				throw new \Exception('No hay sesión activa o usuario no autenticado.');
			}

			$this->beginTransaction();
			$transaccionActiva = true;

			// Bloquea la hospitalización y exige que siga pendiente. Antes, un
			// segundo cierre entraba, no encontraba consumos pendientes y
			// respondía "éxito" sin haber hecho nada.
			$this->setSQL("SELECT estado FROM hospitalizacion
                            WHERE id_hospitalizacion = :idH
                            FOR UPDATE");
			$hospitalizacion = $this->search(['idH' => $this->getIdH()], false);

			if (!$hospitalizacion) {
				throw new \DomainException("La hospitalización indicada no existe.");
			}
			if (($hospitalizacion['estado'] ?? '') !== 'Pendiente') {
				throw new \DomainException("La hospitalización ya fue cerrada o facturada.");
			}

			$this->setSQL("SELECT ih.id_insumo, ih.id_entradaDeInsumo, ih.cantidad
                            FROM insumodehospitalizacion ih
                            INNER JOIN hospitalizacion h ON h.id_hospitalizacion = ih.id_hospitalizacion
                            WHERE h.id_hospitalizacion = :idH AND h.estado = 'Pendiente'
                            FOR UPDATE");

			$consumos = $this->search(['idH' => $this->getIdH()]);

			foreach ($consumos as $consumo) {
				$idInsumo = (int)$consumo['id_insumo'];
				$cantidad = (int)$consumo['cantidad'];

				if ($cantidad <= 0) {
					throw new \DomainException("Cantidad de insumo inválida en la hospitalización.");
				}

				// Bloquea los lotes del insumo y comprueba que alcancen.
				$this->setSQL("SELECT ei.id_entradaDeInsumo, ei.cantidad_disponible
                                FROM entrada_insumo ei
                                INNER JOIN entrada e ON e.id_entrada = ei.id_entrada
                                WHERE ei.id_insumo = :id_insumo AND ei.cantidad_disponible > 0
                                ORDER BY e.fechaDeIngreso ASC
                                FOR UPDATE");

				$lotes = $this->search(['id_insumo' => $idInsumo]);

				$disponible = 0;
				foreach ($lotes as $lote) {
					$disponible += (int)$lote['cantidad_disponible'];
				}

				if ($disponible < $cantidad) {
					throw new \DomainException(
						"El insumo #$idInsumo no tiene stock suficiente. Disponible: $disponible, requerido: $cantidad."
					);
				}

				// Descuento FIFO sobre los lotes ya bloqueados.
				$restante = $cantidad;
				foreach ($lotes as $lote) {
					if ($restante <= 0) {
						break;
					}
					$usar = min((int)$lote['cantidad_disponible'], $restante);

					$this->setSQL("UPDATE entrada_insumo
                                    SET cantidad_disponible = cantidad_disponible - :c
                                    WHERE id_entradaDeInsumo = :id AND cantidad_disponible >= :c2");
					$this->update([
						'c' => $usar,
						'c2' => $usar
					], $lote['id_entradaDeInsumo']);

					$restante -= $usar;
				}
			}

			$this->commit();
			return ['exito' => true, 'error' => null];
		} catch (\Throwable $e) {
			if ($transaccionActiva) {
				$this->rollBack();
			}
			error_log("Error registrando consumo de hospitalizacion: " . $e->getMessage());
			return ['exito' => false, 'error' => $e->getMessage()];
		}
	}

	public function setIdH($idH)
	{
		if (!preg_match("/^[0-9]+$/", (string)$idH)) {
			throw new \InvalidArgumentException("El identificador de hospitalización no es válido.");
		}
		$this->idH = (int)$idH;
	}

	public function getIdH()
	{
		return $this->idH;
	}
	public function getIdInsumo()
	{
		return $this->idInsumo;
	}
	public function getCantidad()
	{
		return $this->cantidad;
	}
}