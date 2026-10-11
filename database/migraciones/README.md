# Migraciones de base de datos

Cada migración es un archivo `.sql` numerado de forma secuencial y se aplica **una sola vez**.

## Cómo aplicarlas

```bash
/opt/lampp/bin/mysql -u root -p bd < database/migraciones/002_factura_integridad.sql
```

Ajusta el usuario y la base (`bd` es la base principal del sistema).

## Cómo revertir

Revertir una migración en producción con datos ya generados puede dejar facturas
inconsistentes. Haz un respaldo antes:

```bash
/opt/lampp/bin/mysql -u root -p bd < database/bd.sql
```

## Migraciones

| # | Archivo | Qué hace |
|---|---------|----------|
| 002 | `002_factura_integridad.sql` | Agrega `personal_id_personal`, `iva_aplicado` y `tasa_iva` a `detalle_factura`; cambia los importes de `FLOAT` a `DECIMAL(12,2)`; y reescribe `DescontarLotes` para que falle cuando el stock no alcanza en vez de dejar la factura guardada sin descontar. |

## Notas sobre la 002

- Requiere la nueva versión del modelo (`ModeloFactura.php`), que usa las columnas nuevas.
  Aplica la migración **antes** de desplegar el código.
- La tasa de IVA por defecto es `0.16` y se configura en `.env` con `IVA_TASA`.
  Debe coincidir con lo que usa el hospital; no hay que modificar la migración.
- `detalle_factura.precio_unitario` pasa a `DECIMAL(12,2)`: MySQL convierte los
  valores existentes redondeando a 2 decimales. Revisa el total de las facturas
  históricas si te importa la precisión exacta.