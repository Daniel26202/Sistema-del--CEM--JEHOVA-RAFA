-- ============================================================================
-- Migración 003 · Tipo de cambio en la factura
--
-- Problema que resuelve:
--   El navegador manda los precios unitarios en DIVISA (serviciomedico.precio e
--   insumo.precio están en dólares) pero el total en BOLÍVARES. El modelo
--   calculaba subtotal = precio_unitario * cantidad en divisa y lo comparaba
--   contra el total en bolívares, así que la validación fallaba SIEMPRE.
--
-- Solución:
--   - detalle_factura guarda el precio en divisa Y en bolívares.
--   - factura guarda la tasa que se aplicó, para poder auditar el comprobante.
--
-- Ejecutar sobre la base `bd`:
--   /opt/lampp/bin/mysql -u root -p bd < database/migraciones/003_factura_tipo_cambio.sql
-- ============================================================================

-- ---------------------------------------------------------------------------
-- 1) Tasa aplicada en la venta (Bs por unidad de divisa)
-- ---------------------------------------------------------------------------
ALTER TABLE `factura`
    ADD COLUMN `tipo_cambio` DECIMAL(12,4) NOT NULL DEFAULT 0.0000
        COMMENT 'Tasa Bs/$ aplicada al cerrar la factura'
        AFTER `total`;

-- ---------------------------------------------------------------------------
-- 2) Precio unitario en divisa, antes de convertir
-- ---------------------------------------------------------------------------
ALTER TABLE `detalle_factura`
    ADD COLUMN `precio_divisa` DECIMAL(12,2) NOT NULL DEFAULT 0.00
        COMMENT 'Precio unitario en dolares (lo que manda el navegador)'
        AFTER `subtotal`;

-- ---------------------------------------------------------------------------
-- 3) Verificación
-- ---------------------------------------------------------------------------
SELECT
    COLUMN_NAME AS columna,
    COLUMN_TYPE  AS tipo,
    COLUMN_COMMENT AS descripcion
FROM information_schema.COLUMNS
WHERE TABLE_SCHEMA = DATABASE()
  AND TABLE_NAME IN ('factura', 'detalle_factura')
  AND COLUMN_NAME IN ('tipo_cambio', 'precio_divisa');

-- Nota para las facturas existentes: tipo_cambio queda en 0.00 y su total en
-- bolívares sigue siendo válido (se guardó ya convertido). Solo los registros
-- nuevos tendrán la tasa.
