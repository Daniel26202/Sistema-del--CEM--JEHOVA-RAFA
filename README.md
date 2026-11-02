# Sistema de gestión — Centro de Especialidades Médicas Jehová Rafa

Aplicación web para administrar operaciones clínicas y administrativas del Centro de Especialidades Médicas Jehová Rafa. Incluye módulos de pacientes, citas, consultas, hospitalización, facturación, inventario, usuarios, permisos y reportes.


## Funcionalidades

- Registro y seguimiento de pacientes, citas, controles e internamientos.
- Gestión de doctores, especialidades, servicios y clientes.
- Inventario de insumos, proveedores y entradas.
- Facturación, métodos de pago, comprobantes y reportes.
- Usuarios, roles, permisos y bitácora.
- Inicio de sesión web, recuperación de contraseña y endpoints para la aplicación móvil.

## Tecnologías

- PHP y Composer.
- MySQL/MariaDB.
- Apache.
- JavaScript, HTML y CSS.
- PHPUnit para pruebas automatizadas.
- Ratchet para la función WebSocket de citas próximas.

Las versiones instaladas en desarrollo y las requeridas por el servidor pueden diferir. Verifica compatibilidad de PHP, MariaDB y extensiones antes del despliegue. El proyecto no incluye Docker ni un instalador automático de base de datos.

## Estructura del repositorio

| Ruta | Contenido |
|---|---|
| `src/controllers/` | Controladores y acciones HTTP |
| `src/modelos/` | Acceso a datos y reglas del sistema |
| `src/vistas/` | Vistas PHP |
| `src/config/` | Configuración, rutas y utilidades |
| `src/assets/` | Recursos del frontend |
| `database/bd.sql` | Esquema y datos de ejemplo de la base principal `bd` |
| `database/segurity.sql` | Esquema y datos de ejemplo de la base `segurity` |
| `database/migraciones/` | Cambios incrementales para la base existente |
| `scripts/backups/` | Scripts de respaldo y restauración |
| `tests/` | Pruebas automatizadas y de integración |
| `webSocket.php` | Proceso Ratchet para notificaciones de citas |

## Requisitos

- PHP compatible con las versiones declaradas en `composer.json` y `composer.lock`.
- Composer.
- Apache y soporte de `.htaccess` (`AllowOverride` habilitado).
- MySQL/MariaDB con soporte para procedimientos, vistas y las funciones incluidas en los volcados.
- Extensiones PHP requeridas por Composer; entre ellas PDO MySQL, cURL, OpenSSL, GD y ZIP.
- Una copia local de los secretos y valores de configuración requeridos por el proyecto.

Comprueba los requisitos de las dependencias con:

```bash
composer check-platform-reqs
```

## Instalación local con XAMPP

1. Inicia Apache y MySQL desde XAMPP.
2. Clona o copia el proyecto dentro de `htdocs`, por ejemplo:

   ```text
   C:\xampp\htdocs\Sistema-del--CEM--JEHOVA-RAFA
   ```

3. Instala las dependencias desde la raíz:

   ```bash
   composer install
   ```

4. Crea un archivo `.env` local en la raíz. **No lo subas a Git ni compartas sus valores.** Ejemplo de nombres de configuración (sustituye los marcadores por valores apropiados):

   ```dotenv
   DB_HOST=localhost
   DB_USER=usuario_local
   DB_PASS=contraseña_local
   DB_NAME=bd
   DB_NAME_SEGURITY=segurity
   PASSWORD_RESP=valor_local
   JWT_SECRET=secreto_aleatorio_largo
   RECAPTCHA_SECRET=secreto_de_recaptcha
   API_KEY_IA=clave_del_servicio
   IA_API_URL=https://api.example.invalid
   IVA_TASA=0.16
   ```

   El proyecto también puede usar variables para WebSocket y scripts de respaldo. Configúralas solo si habilitas esas funciones. Revisa las variables que consume el código y los scripts antes de preparar cada ambiente. Genera secretos distintos por ambiente; no uses valores de ejemplo ni claves vacías para producción.

5. Crea las bases de datos `bd` y `segurity` en una instancia local vacía. Para probar con datos sintéticos, importa los volcados:

   ```bash
   mysql -u usuario_local -p -e "CREATE DATABASE bd CHARACTER SET utf8mb4;"
   mysql -u usuario_local -p -e "CREATE DATABASE segurity CHARACTER SET utf8mb4;"
   mysql -u usuario_local -p bd < database/bd.sql
   mysql -u usuario_local -p segurity < database/segurity.sql
   ```

   En Windows puedes ejecutar los comandos con `C:\xampp\mysql\bin\mysql.exe` desde PowerShell o usar phpMyAdmin. La cuenta de base de datos debe tener únicamente los privilegios necesarios. Los volcados crean tablas y contienen datos; úsalos solo en bases locales descartables.

6. Abre:

   ```text
   http://localhost/Sistema-del--CEM--JEHOVA-RAFA/
   ```

   La instalación depende de las reglas de reescritura de Apache y de la ruta del proyecto. Si cambias el nombre de la carpeta o el dominio, revisa las rutas base y recursos que usan el nombre `Sistema-del--CEM--JEHOVA-RAFA`.

## Migraciones

Para una base ya existente, no importes los volcados completos: pueden borrar/recrear datos. Revisa cada migración y el estado de la base; realiza un respaldo verificado antes de aplicarla. Los archivos actuales son:

- `database/migraciones/002_factura_integridad.sql`
- `database/migraciones/003_factura_tipo_cambio.sql`

Ambas están dirigidas a la base principal `bd` y se aplican una sola vez, en orden. Ejemplo en Linux:

```bash
mysql -u usuario -p bd < database/migraciones/002_factura_integridad.sql
mysql -u usuario -p bd < database/migraciones/003_factura_tipo_cambio.sql
```

En Windows, sustituye `mysql` por la ruta de `mysql.exe` de XAMPP. Confirma los requisitos y el impacto sobre facturas existentes leyendo los comentarios de cada migración. No ejecutes estas instrucciones contra producción sin una copia de seguridad y un plan de reversión probado.

## Pruebas

Pruebas PHPUnit que no requieren ejecutar la suite completa:

```bash
vendor/bin/phpunit --no-configuration --bootstrap tests/bootstrap.php --do-not-cache-result tests/ImagenUploadTest.php
vendor/bin/phpunit --no-configuration --bootstrap tests/bootstrap.php --do-not-cache-result tests/DashboardInicioTest.php
vendor/bin/phpunit --no-configuration --bootstrap tests/bootstrap.php --do-not-cache-result tests/PerfilOwnershipTest.php tests/ControllerInicioSecurityTest.php
```

En Windows, puedes invocar `vendor\bin\phpunit.bat` con los mismos argumentos.

La suite completa contiene pruebas de integración/CRUD que se conectan a las bases de datos y pueden insertar, actualizar o eliminar registros. Ejecútala únicamente con una base de pruebas aislada y desechable, nunca con datos reales.

## Respaldos

Hay scripts para Windows y Linux en [`scripts/backups/`](scripts/backups/). Lee [`scripts/backups/README.md`](scripts/backups/README.md) y configura rutas, binarios y credenciales antes de programarlos. Verifica periódicamente los respaldos mediante una restauración en un ambiente aislado; que el script termine sin errores no demuestra por sí solo que la restauración funcione.

## WebSocket

El proyecto incluye un servicio Ratchet para notificaciones de citas. La configuración actual del frontend usa `ws://localhost:8080`, apropiada para desarrollo local, no para usuarios remotos ni páginas HTTPS. Para producción se requiere configurar el endpoint para el dominio real, usar `wss://` detrás de un proxy TLS y restringir la exposición de red. El servicio también debe contar con controles de autenticación y autorización antes de distribuir información de citas.

## Seguridad y despliegue

- Mantén `.env`, respaldos, volcados SQL, logs y datos clínicos fuera del acceso público; utiliza secretos nuevos y únicos por ambiente.
- Sirve producción exclusivamente por HTTPS y verifica los headers, reglas de Apache, permisos de archivos y configuración PHP del servidor real.
- No despliegues datos de ejemplo ni el entorno de desarrollo; revisa el contenido de `database/` y los artefactos generados antes de empaquetar.
- Configura `JWT_SECRET` y los secretos de correo, CAPTCHA y servicios externos cuando esas funciones estén habilitadas.
- Prueba autenticación, permisos por rol, recuperación de cuenta, subida de imágenes, respaldos y restauración en preproducción.
- No consideres la aplicación lista para producción solo por superar pruebas locales. La aceptación, disponibilidad, privacidad y cumplimiento aplicable a datos de salud deben validarse para el entorno y la organización donde se despliegue.

## Documentación adicional

- [Migraciones de base de datos](database/migraciones/README.md)
- [Scripts de respaldo](scripts/backups/README.md)

