# Tablas Responsive (DataTables)

Documentación de la funcionalidad responsive agregada a `initDataTable()`
(`src/assets/js/generic/funtionGeneric.js`).

---

## 1. ¿Qué problema resuelve?

Una tabla deja de "verse bien" cuando la suma del ancho de todas sus columnas es
mayor que el ancho de la pantalla (celular, tablet o una ventana pequeña).

**Antes:** la tabla se comprimía y el texto se partía en varias líneas, o
aparecía un scroll horizontal infinito.

**Ahora:** la extensión oficial **Responsive** de DataTables:

1. Mide el ancho real (mínimo) de cada columna.
2. Si no caben todas, **oculta las menos importantes** (de derecha a izquierda)
   en lugar de deformarlas.
3. Los datos ocultos **no se pierden**: se muestran en una *fila hija* que se
   abre y cierra con el botón **▶** que aparece en la primera columna.

---

## 2. Archivos que intervienen

| Archivo | Qué hace |
|---|---|
| `src/assets/js/generic/funtionGeneric.js` | `initDataTable()` configura el responsive automáticamente. También exporta `responsiveDisponible()`. |
| `src/assets/library/DataTable/dataTables.responsive.js` | **Extensión Responsive** (v3.0.3, archivo agregado). Debe cargarse **después** de `datatables.js`. |
| `src/assets/library/DataTable/responsive.dataTables.css` | **CSS de la extensión** (archivo agregado): dibuja el botón ▶ y da estilo a la fila hija. |
| `src/vistas/head/footer.php` | Incluye el JS de la extensión. |
| `src/vistas/head/head.php` | Incluye el CSS de la extensión. |
| `src/assets/cssVista/datatables-responsive.css` | **CSS del modo responsive** (fila hija, botones, buscadores). Se carga en `head.php`, así aplica en **todos** los módulos. |
| `src/assets/cssVista/sistema.css` | **Fuente general** del sistema y **botones de registrar** (chicos, sin negrita, responsive). También se carga en `head.php`. |
| `src/vistas/**` (24 archivos) | Se les quitó la clase `table-responsive` de los contenedores de las tablas (ver sección 6). |

---

## 3. Cómo se usa

### 3.1 Uso normal (no cambia nada de tu código)

```js
import { initDataTable } from "../generic/funtionGeneric.js";

initDataTable(selector, url + "/listar", columnas, callbackDatos, eventos);
```

La tabla **ya queda responsive**: no hay que pasar ningún parámetro nuevo.

### 3.2 Opciones (6.º parámetro)

```js
initDataTable(selector, url, columnas, callbackDatos, eventos, {
  responsive: true,        // true (defecto) | false | { config de la extensión }
  protegerBotones: true,   // true (defecto) | false
  detalles: { type: "inline", target: 0 },
  dataTable: { pageLength: 25 }, // opciones extra de DataTables
});
```

| Opción | Tipo | Default | Descripción |
|---|---|---|---|
| `responsive` | `boolean \| object` | `true` | Activa/desactiva el responsive. Si es un objeto se usa como configuración de la extensión (ej. `{ breakpoints: [...] }`). |
| `protegerBotones` | `boolean` | `true` | La columna de botones **nunca** se oculta (así sus eventos siguen funcionando igual que en escritorio). |
| `detalles` | `object` | `{ type: "inline", target: 0 }` |Cómo se muestra la fila hija. `type: "inline"` = dentro de la primera celda; `type: "column"` = en una fila nueva debajo. |
| `dataTable` | `object` | `{}` | Opciones extra que quieras fijar para DataTables (`pageLength`, `order`, …). |

### 3.3 Apagar el responsive en una tabla puntual

```js
initDataTable(selector, url, columnas, null, null, { responsive: false });
```

---

## 4. ¿Cómo decide qué columna ocultar?

`initDataTable()` asigna prioridades solo, **sin que tengas que hacer nada**:

1. **Columna de botones** (la última columna definida con `data: null`) →
   recibe la clase `all` = *"nunca se oculta"*. Motivo: los botones viven en el
   DOM original de la tabla y tus listeners se enlazan en `drawCallback`; si la
   columna se ocultase, los botones aparecerían en la fila hija pero sin
   eventos (no funcionarían).
2. **El resto de columnas** → prioridad de izquierda a derecha
   (`responsivePriority: 2, 3, 4…`). Las primeras son las más importantes y las
   últimas son las primeras en ocultarse.
3. **El botón ▶** lo dibuja la extensión por su cuenta en la primera columna
   que quede visible, así ninguna columna con datos se pierde en pantallas
   anchas.

> ⚠️ **No marques una columna de datos con la clase `dtr-control`.** Esa clase
> está pensada para una columna vacía dedicada al botón. Si se la pones a una
> columna con datos, la extensión la oculta cuando no hay nada más que ocultar
> y **su información desaparece** (ni siquiera se muestra en la fila hija).

### 4.1 Controlarlo a mano

Si quieres decidir tú qué se oculta primero, pon prioridades (o clases) en tus
columnas: `initDataTable()` detecta que ya configuraste todo y **no toca
nada**.

```js
const columnas = [
  { data: "cedula", responsivePriority: 1 },   // nunca se oculta
  { data: "nombre", responsivePriority: 2 },
  { data: "observaciones" },                   // se oculta primero
  { data: null, orderable: false, className: "all" }, // botones
];
```

Clases útiles de la extensión (se pueden poner en `className` o en el `<th>`):

| Clase | Efecto |
|---|---|
| `all` | La columna **siempre** se ve. |
| `none` | Nunca se ve, pero sus datos salen en la fila hija. |
| `never` | Nunca se ve **y tampoco** sale en la fila hija. |
| `desktop`, `tablet`, `mobile` | Visible sólo en ese tamaño de pantalla. |
| `not-`, `min-`, `max-` (prefijos) | Combinaciones, ej. `min-tablet-p`. |

Más detalle: <https://datatables.net/extensions/responsive/classes>

---

## 5. Detalles de implementación

- **Si la extensión no está cargada**, `initDataTable()` muestra un aviso en
  consola y crea la tabla normal (sin romper nada). Puedes comprobarlo con:

  ```js
  import { responsiveDisponible } from "../generic/funtionGeneric.js";
  if (!responsiveDisponible()) console.warn("Falta dataTables.responsive.js");
  ```

- **Las columnas no se modiﬁcan en el lugar**: `initDataTable()` trabaja sobre
  una copia, así puedes reutilizar el mismo arreglo de columnas.

- **Guardián de clics**: al pulsar un botón/enlace/input que esté dentro de la
  celda que tiene el ▶, sólo se ejecuta el botón (no se abre/cierra también la
  fila hija).

- **Re-inicialización segura**: los módulos hacen
  `$(selector).DataTable().clear().destroy()` antes de volver a crear la tabla.
  El guardián se re-enlaza con `off()` previo, así **no se duplican listeners**
  (verificado hasta 3 recargas seguidas: 1 solo clic = 1 solo evento).

---

## 6. La clase `table-responsive` y los botones de acciones

### 6.1 Se quitó `table-responsive` de los contenedores

Bootstrap define `.table-responsive` como `overflow-x: auto`, o sea: si la tabla
no cabe, el contenedor hace **scroll horizontal en lugar de dejar que la tabla
se adapte**. Eso compite con la extensión Responsive y deja doble barra de
desplazamiento, así que se retiró de los contenedores de las tablas que usa
`initDataTable` (24 archivos de `src/vistas/`, tanto el `<div class="table
table-responsive">` que envuelve la tabla como el `.caja-contenedor-tabla`
exterior).

**No se toca** donde NO es DataTables (tablas estáticas), que conservan su
scroll horizontal:

- `src/vistas/vistaFactura/*` (factura.php, facturaCita.php, facturaHospitalizacion.php, modalAgregarFactura.php)
- `src/vistas/dashboard.php` (tarjeta del calendario)
- `src/vistas/vistaMantenimiento/mantenimiento.php`
- `src/vistas/vistaHospitalizacion/hospitalizacionesRealizadas.php`

### 6.2 Los botones no se salen de la tabla

La columna de botones nunca se oculta, así que hay que asegurar que quepa.
Además, al quitar `table-responsive` ya no hay contenedor que "esconda" el
desborde con un scroll: **todo lo que pase de ancho se ve**. Verificando en
Chrome headless con viewports de móvil reales (240/280/320/360 px, usando un
`iframe` para que los `@media` y Responsive midan el ancho real) aparecieron
**dos** causas, ambas arregladas en `src/assets/cssVista/datatables-responsive.css`:

#### Causa 1: el buscador que arma DataTables (la que quedaba al final)

DataTables 2 crea el buscador con `<input class="dt-input input-responsive">` +
un botón lupa (`.btn-buscar.btn-search-datatable`). El input se queda con su
ancho por defecto (~217 px) y el botón **se salía de la pantalla**: con un
viewport de 280 px el documento se desbordaba 45 px y con 320 px, 5 px.

```css
@media (max-width: 576px) {
    .dt-container .dt-search, .dataTables_wrapper .dt-search {
        display: flex !important;
        flex-wrap: wrap;          /* el botón baja de línea si no cabe */
    }
    .dt-container .dt-search input.dt-input {
        width: auto !important;   /* anula el width: 60% de modificacion.js */
        flex: 1 1 60%;
        min-width: 0;             /* sin esto el input no se encoge */
    }
    .dt-container .dt-length select.dt-input { width: auto !important; }
    .dt-container { max-width: 100%; }
}
```

> ⚠️ **OJO con dónde se carga el CSS**: estos estilos están en
> `src/assets/cssVista/datatables-responsive.css`, incluido en
> `src/vistas/head/head.php`. `styleAdicional.css` **sólo** se carga en
> `factura.php`, por lo que cualquier arreglo puesto allí no llega a los
> demás módulos (así se nos estaba escapando este desborde).
>
> ⚠️ **OJO con el nombre del contenedor**: DataTables **2.x** usa la clase
> `.dt-container`, NO `.dataTables_wrapper`. Un CSS puesto sobre
> `.dataTables_wrapper` **no hace nada** (así se nos estaba escapando este
> desborde). Se dejan los dos selectores por compatibilidad.

#### Causa 2: los contenedores de botones no pueden bajar de línea

Los botones van en `.d-flex justify-content-center align-items-center` **sin
`flex-wrap`**, así que el ancho de la celda es la **suma** de todos los botones.

```css
table.dataTable td .d-flex,
table.dataTable td .tdTBtn {
    flex-wrap: wrap !important;   /* el ancho mínimo pasa a ser el de 1 botón */
}
table.dataTable td .d-flex > div,
table.dataTable td .tdTBtn > div {
    width: auto !important;       /* anula col-12 / col-md-6 / col-lg-3 */
    flex: 0 0 auto;
}
```

Además se conservan estos arreglos específicos:

| Regla | Para qué |
|---|---|
| `table.dataTable .tdTBtn { width: auto !important; max-width: 100% }` | Anula el `width: 24vh` fijo de `.tdTBtn` (que dependía del **alto** de la ventana: con una ventana de 1400 px de alto medía 336 px y sacaba a la tabla). |
| `table.dataTable tbody td { overflow-wrap: break-word }` | Un texto larguísimo (ej. un diagnóstico) parte dentro de la celda en vez de estirar la tabla. |
| `@media (max-width: 576px)` | Botones e iconos más pequeños en celular. |

> Si en una vista tuya los botones se ven afectados, revisa que usen las clases
> habituales (`.btn-tabla`, `.tdTBtn`, `.d-flex`); los estilos están puestos por
> `table.dataTable`, así que sólo actúan dentro de las DataTables.

---

## 7. Solución de problemas

| Síntoma | Causa / solución |
|---|---|
| La consola dice *"no se cargó la extensión Responsive"* | Falta el `<script src=".../dataTables.responsive.js">` en `src/vistas/head/footer.php` (debe ir después de `datatables.js`). |
| No aparece el botón ▶ | Significa que **ninguna columna se ocultó**: la tabla cabe en la pantalla. Prueba achicando la ventana. |
| Una columna no aparece por ningún lado | Revisa si le pusiste la clase `dtr-control` (ver la advertencia del punto 4). |
| Los botones de una columna no funcionan | Esa columna se está ocultando; añádele `className: "all"` o `responsivePriority: 1`. |
| Algo se sale en el celular | Mide qué elemento se pasa (`getBoundingClientRect().right > innerWidth`) y revisa si el CSS usa `.dataTables_wrapper` en vez de `.dt-container`. |
| La tabla se ve rara en una ventana modal | Responsive mide el ancho al abrir; si el modal se anima, llama a `tabla.columns.adjust().responsive.recalc()` cuando termine la animación. |

---

## 8. Cómo se probó

Páginas servidas por HTTP y abiertas con **Chrome headless**. Como headless no
baja de 500 px de ventana, los viewports de móvil se simularon con un
`<iframe width="320">` (así los `@media` y Responsive miden el ancho real).

### 8.1 Anchos probados (tabla de 6 columnas)

| Ancho | Columnas visibles | Resultado |
|---|---|---|
| 1400 px | 6 de 6 | Sin cambios: no hay nada que ocultar. |
| 768 px | 6 de 6 | Sin cambios. |
| 480 px | 4 de 6 | Oculta *Apellido* y *Genero*; ▶ en Cédula; fila hija con ambas. |
| 360 px | 3 de 6 | Oculta *Apellido*, *Teléfono* y *Genero*; fila hija con las tres. |

### 8.2 Que nada se salga en el celular

Medido en cada caso `scrollWidth == innerWidth` (o sea: **cero desborde**) y
`getBoundingClientRect().right` de todos los elementos:

| Viewport | Desborde antes | Después |
|---|---|---|
| 380 px | 5 px (el botón lupa del buscador) | 0 px ✓ |
| 360 px | 0 px | 0 px ✓ |
| 320 px | **5 px** | 0 px ✓ |
| 280 px | **45 px** | 0 px ✓ |
| 240 px | **85 px** | 0 px ✓ |

Y con 5 botones + un texto larguísimo en la primera columna: los botones
nunca se salen de su celda (`botonesFueraDeLaCelda: 0`).

### 8.3 Resto de comprobaciones

- Clic en ▶ abre la fila hija con el **nombre y el valor** de cada columna
  oculta, y vuelve a cerrarse.
- Clic en los botones de la columna de acciones: **1 clic = 1 evento**
  (incluso con la fila hija abierta).
- Clic en un botón que esté dentro de la celda ▶: **no** abre la fila hija.
- Con prioridades puestas a mano: se respetan tal cual.
- Con `responsive: false`: la tabla se crea normal.
- Sin cargar la extensión: aviso en consola y tabla funcionando normal.
- 3 recargas seguidas (`clear().destroy()` + crear): sin listeners duplicados y
  con la fila hija operativa.

---

## 9. Dónde quedó aplicado (todos los módulos)

Cambios globales (una sola vez, alcanzan a todos los módulos que usan
DataTables porque todos llaman a `initDataTable()` y todos cargan `head.php`):

| Qué | Archivo |
|---|---|
| Responsive automático en `initDataTable()` | `src/assets/js/generic/funtionGeneric.js` |
| Extensión Responsive (JS) | `src/assets/library/DataTable/dataTables.responsive.js` (nuevo) |
| Extensión Responsive (CSS) | `src/assets/library/DataTable/responsive.dataTables.css` (nuevo) |
| Carga del JS de la extensión | `src/vistas/head/footer.php` |
| Carga del CSS de la extensión + CSS responsive | `src/vistas/head/head.php` |
| CSS del modo responsive (fila hija, botones, buscadores) | `src/assets/cssVista/datatables-responsive.css` (nuevo) |

Módulos con DataTable (usan `initDataTable`, ya quedan responsive):

`bitacora` · `citas` · `clientes` · `control` · `doctor` (2 tablas) ·
`entradas` · `entradasVencidas` · `hospitalizacion` · `insumo` · `pacientes` ·
`patologia` · `proveedor` · `roles` · `servicios` · `categoria` ·
`blackListUser` · `reportes`

Vistas a las que se les retiró la clase `table-responsive` (23 tablas):
`bitacora.php` · `hospitalizacion.php` · `hospitalizacionesRealizadas.php` ·
`insumosPapelera.php` · `modalesCategoria.php` · `modalesEspecialidades.php` ·
`modalesRol.php` · `modalesSintomas.php` · `modalsReportes.php` ·
`pacientesPapelera.php` · `patologia.php` · `tablaHistorialSalud.php` ·
`tablaPacientes.php` · `vistaCitas.php` · `vistaCliente.php` ·
`vistaControl.php` · `vistaDoctores.php` · `vistaEntrada.php` ·
`vistaEntradaDesactiva.php` · `vistaInsumos.php` ·
`vistaInsumosVencidos.php` · `vistaListaNegra.php` · `vistaProveedores.php` ·
`vistaProveedoresPapelera.php` · `vistaServiciosMedicos.php` ·
`vistaRoles.php` · `vistaUsuarios.php` · `vistaUsuariosAdmin.php`

> Se conserva `table-responsive` sólo en tablas **estáticas** (no DataTables):
> `vistaFactura/*`, `dashboard.php` (calendario), `mantenimiento.php` y
> `hospitalizacionesRealizadas.php`.

---

## 10. Fuente general y botones de "Registrar"

Archivo nuevo: `src/assets/cssVista/sistema.css`, cargado en
`src/vistas/head/head.php` para que aplique en **todos** los módulos.

### 10.1 Fuente general

En `style.css` había `* { font-family: "Arial" }`. Como una regla universal se
aplica elemento por elemento, no alcanza con poner la fuente en el `body`, así
que se sobreescribe también con `*`:

```css
*, html, body {
    font-family: "Segoe UI", system-ui, -apple-system, Roboto, "Helvetica Neue", Arial, sans-serif;
}
body { font-size: 0.95rem; }   /* 15.2 px: chica pero no molesta */
```

Usa fuentes del sistema (sin depender de internet): Segoe UI en Windows, SF en
Mac/iOS, Roboto en Android. Los iconos del sistema son SVG, no fuentes, así que
no se rompen.

### 10.2 Botones de registrar/guardar

Clases alcanzadas: `btn-modals`, `btn-modals-cancelar`, `btn-guardar-responsive`,
`btn-agregarcita-modal`, `btn-agregar-doctores`, `btn-open-editar`,
`btnrestablecer`, `btnMostrar`.

| Qué | Cómo |
|---|---|
| Más chicos | `font-size: 0.82rem` (13 px) + `padding: .35rem 1rem` |
| Sin negrita | `font-weight: 400 !important` (gana al `.fw-bold` de Bootstrap) |
| Responsive | `@media (max-width: 768px)`: `width: 100%` (máx. 320 px) y centrados — anula `col-2`, `col-8` y el `width: 20%/80%` que ponía `modificacion.js` |
| En escritorio | se mantiene el tamaño actual, sólo más chicos y sin negrita |

Verificado con Chrome headless: escritorio → botón de 90 px; móvil/tablet →
320 px centrados; en ambos `font-weight: 400` y fuente `Segoe UI`.
