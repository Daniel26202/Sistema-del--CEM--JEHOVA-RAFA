# 📄 Guía de Flujo de Pago y Visualización Multimoneda (Facturación)

## 🎯 Objetivo
Definir las directrices para el procesamiento de pagos y la presentación dual de montos (Bolívares `BS` / Dólares `USD`) en el módulo de facturación de la clínica. El flujo ya está implementado y debe mantenerse **amigable, estandarizado y claro** para los usuarios administrativos/cajeros.

---

## 🔄 1. Flujo del Pago en Facturación

El procesamiento de cobro debe seguir esta secuencia obligatoria:

1. **Selección/Carga de Conceptos Médicos:**
   - Cada servicio, consulta o procedimiento tiene un valor base fijado en USD (o moneda de referencia principal).
   - Se obtiene la **tasa de cambio vigente (BCV)** del día para realizar el cálculo en Bolívares (`VEF/VES`).

2. **Cálculo del Total:**
   - **Monto Subtotal / Total USD:** Suma de ítems en USD.
   - **Monto Subtotal / Total BS:** `Total USD * Tasa del Día`.

3. **Selección del Método de Pago (Pago Mixto o Único):**
   - El usuario puede registrar el pago dividiendo montos entre distintas formas de pago:
     - **Bolívares:** Punto de Venta, Pago Móvil, Transferencia BS, Efectivo BS.
     - **Dólares:** Efectivo USD, Zelle, Transferencia / Plataforma Internacional.

4. **Verificación y Saldo Restante:**
   - El sistema calcula en tiempo real lo abonado y muestra el **Saldo Pendiente** o **Vuelto/Cambio** reflejado simultáneamente en ambas monedas (`USD` y `BS`).

5. **Confirmación y Emisión:**
   - Registro de la transacción y generación del comprobante/factura final.

---

## 🎨 2. Estándar de Interfaz y UX (Doble Moneda)

Para mantener la pantalla **limpia, amigable y estándar**, se deben aplicar las siguientes reglas visuales:

### 2.1 Principio de Jerarquía Visual (Formato Dual)
* **Formato Estándar de Visualización:**
  - Moneda Principal (USD): `$ 50.00` (Texto resaltado/negrita).
  - Moneda Nacional (BS): `Bs. 1.825,00` (Texto secundario, agrupado o entre paréntesis/subtexto).
  - *Ejemplo de celda/etiqueta:* **$ 50.00** `<span class="text-muted">(Bs. 1.825,00)</span>`

### 2.2 Reglas de Formato Numérico y Simbología
* **Dólares (USD):**
  - Símbolo: `$`
  - Separador de miles: `,` (coma)
  - Separador decimal: `.` (punto)
  - Ejemplo: `$ 1,250.50`
* **Bolívares (BS):**
  - Símbolo: `Bs.` o `Bs.D`
  - Separador de miles: `.` (punto)
  - Separador decimal: `,` (coma)
  - Ejemplo: `Bs. 45.643,25`

### 2.3 Desglose Visual en la Tabla de Detalle
| Concepto | Cant. | P. Unitario (USD / BS) | Total (USD / BS) |
| :--- | :---: | :---: | :---: |
| Consulta Médica General | 1 | $ 30.00 <br><small>Bs. 1.095,00</small> | **$ 30.00** <br><small class="text-muted">Bs. 1.095,00</small> |
| Examen de Laboratorio | 2 | $ 10.00 <br><small>Bs. 365,00</small> | **$ 20.00** <br><small class="text-muted">Bs. 730,00</small> |

---

## 💡 3. Resumen y Bloque de Cobro (Sección Inferior)

En la sección final de cobro/checkout, las métricas principales se muestran en **Tarjetas / Badges informativos**:

* **Tasa del Día:** `1 USD = 36.50 BS` *(Destacado en encabezado)*
* **Total a Pagar:**
  - Grande/Principal: **$ 50.00**
  - Equivalente: **Bs. 1.825,00**
* **Monto Ingresado por el Cajero:**
  - En BS: `Bs. 1.000,00`
  - En USD: `$ 22.60`
* **Restante / Cambio (Vuelto):**
  - Muestra claramente si falta dinero por ingresar o el vuelto a entregar en ambas monedas.

---

## 🛠 Directiva para el Agente (OpenCode)
> **Instrucción:** Al generar o modificar vistas, controladores o componentes relacionados con la facturación:
> 1. Respeta este flujo de cálculo sin alterar las fórmulas multimoneda existentes en el backend.
> 2. Garantiza que en la UI siempre se muestren los precios en ambas monedas de forma clara y sin recargar la pantalla (usa jerarquía de colores/tamaños).
> 3. Utiliza los helpers de formateo de moneda estándar del proyecto (`formatUSD()` / `formatBS()`).

### 3.1 Captura de precios y conversiones

- Los formularios con importes en ambas monedas deben enlazar sus campos usando `initConversion(form)` de `src/assets/js/generic/coversion.js`.
- Identifica los campos con las clases `.precioDolares` y `.precioBolivares`; conserva sus `name`, IDs y validaciones para no cambiar el contrato con el backend.
- La conversión usa la tasa compartida del sistema. El formulario informa la tasa aplicada y normaliza el importe al salir del campo; acepta separadores decimales locales e internacionales.
- USD sigue siendo la referencia para los precios de servicios e insumos. El campo equivalente en Bs. facilita la captura y no debe cambiar la moneda ni la semántica que cada endpoint ya guarda.
- Evita agregar cálculos de conversión duplicados por módulo; reutiliza la función compartida para nuevos campos de precio.