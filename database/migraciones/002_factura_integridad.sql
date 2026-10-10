-- ============================================================================
-- Migración 002 · Integridad del módulo de facturación
-- Ejecutar sobre la base `bd` (schema principal) y `segurity` no se ve afectada.
--
-- Motivo:
--   1. detalle_factura no guardaba qué doctor atendió cada servicio, por lo que
--      el comprobante recurrió a un JOIN que multiplicaba filas y terminaba en
--      "LIMIT 1", mostrando solo el primer servicio facturado.
--   2. Se necesita distinguir el IVA aplicado: antes no se persistía y el
--      comprobante lo recalculaba con un 30% hardcodeado, que no coincide con
--      la tasa real ni con lo que el total cobro.
--   3. precio_unitario y subtotal son float: para dinero se usa DECIMAL.
-- ============================================================================

-- ---------------------------------------------------------------------------
-- 1) Doctor que atendió el servicio + IVA aplicado
-- ---------------------------------------------------------------------------
ALTER TABLE `detalle_factura`
    ADD COLUMN `personal_id_personal` INT(11) NULL DEFAULT NULL
        COMMENT 'Doctor que atendio el servicio facturado' AFTER `serviciomedico_id_servicioMedico`,
    ADD COLUMN `iva_aplicado` TINYINT(1) NOT NULL DEFAULT 0
        COMMENT '1 = el precio_unitario ya incluye IVA' AFTER `personal_id_personal`,
    ADD COLUMN `tasa_iva` DECIMAL(6,4) NOT NULL DEFAULT 0.0000
        COMMENT 'Tasa de IVA aplicada (0.1600 = 16%)' AFTER `iva_aplicado`;

-- ---------------------------------------------------------------------------
-- 2) Precisión decimal para los importes (evita 0.1+0.2 = 0.30000000000000004)
-- ---------------------------------------------------------------------------
ALTER TABLE `detalle_factura`
    MODIFY COLUMN `precio_unitario` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    MODIFY COLUMN `subtotal` DECIMAL(12,2) NOT NULL DEFAULT 0.00;

ALTER TABLE `factura`
    MODIFY COLUMN `total` DECIMAL(12,2) NOT NULL DEFAULT 0.00;

ALTER TABLE `pagodefactura`
    MODIFY COLUMN `monto` DECIMAL(12,2) NOT NULL DEFAULT 0.00;

-- ---------------------------------------------------------------------------
-- 3) Clave foránea del doctor (el modelo ya la envía en personal_id_personal)
-- ---------------------------------------------------------------------------
SET @fk_existe := (
    SELECT COUNT(*) FROM information_schema.KEY_COLUMN_USAGE
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME   = 'detalle_factura'
      AND COLUMN_NAME  = 'personal_id_personal'
      AND REFERENCED_TABLE_NAME IS NOT NULL
);

SET @sql := IF(@fk_existe = 0,
    'ALTER TABLE `detalle_factura`
        ADD CONSTRAINT `detalle_factura_ibfk_personal`
        FOREIGN KEY (`personal_id_personal`) REFERENCES `personal` (`id_personal`)',
    'DO 0');

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- ---------------------------------------------------------------------------
-- 4) DescontarLotes: ahora falla si el stock no alcanza
--
-- Antes el procedimiento recorría los lotes y salía sin avisar, dejando la
-- factura guardada con una cantidad que jamás se descontó del inventario.
-- La versión nueva lanza SIGNAL, el modelo hace rollback y el usuario recibe
-- "no hay stock suficiente" en vez de una factura fantasma.
-- ---------------------------------------------------------------------------
DROP PROCEDURE IF EXISTS `DescontarLotes`;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DescontarLotes` (
    IN insumo_id        INT,
    IN cantidad_requerida INT
)
BEGIN
    DECLARE cantidad_restante INT DEFAULT cantidad_requerida;
    DECLARE lote_id          INT;
    DECLARE lote_cantidad    INT;
    DECLARE done             INT DEFAULT FALSE;

    DECLARE lote_cursor CURSOR FOR
        SELECT ei.id_entradaDeInsumo, ei.cantidad_disponible
        FROM entrada_insumo ei
        INNER JOIN entrada e ON e.id_entrada = ei.id_entrada
        WHERE ei.id_insumo = insumo_id
          AND ei.cantidad_disponible > 0
        ORDER BY e.fechaDeIngreso ASC;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    -- Si no alcanza, aborta: el error hace rollback de toda la transacción.
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    OPEN lote_cursor;

    lectura_lote: LOOP
        FETCH lote_cursor INTO lote_id, lote_cantidad;

        IF done THEN
            LEAVE lectura_lote;
        END IF;

        IF cantidad_restante <= lote_cantidad THEN
            UPDATE entrada_insumo
            SET cantidad_disponible = cantidad_disponible - cantidad_restante
            WHERE id_entradaDeInsumo = lote_id;

            SET cantidad_restante = 0;
            LEAVE lectura_lote;
        ELSE
            UPDATE entrada_insumo
            SET cantidad_disponible = 0
            WHERE id_entradaDeInsumo = lote_id;

            SET cantidad_restante = cantidad_restante - lote_cantidad;
        END IF;
    END LOOP;

    CLOSE lote_cursor;

    -- Punto de control: si sobra cantidad por descontar, no hay stock.
    IF cantidad_restante > 0 THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Stock insuficiente del insumo solicitado';
    END IF;
END$$

DELIMITER ;

-- ---------------------------------------------------------------------------
-- 5) Verificación
-- ---------------------------------------------------------------------------
SELECT 'Migración 002 aplicada' AS estado;