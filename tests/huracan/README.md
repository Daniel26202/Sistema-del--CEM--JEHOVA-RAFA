# Pruebas huracán con Selenium

`selenium_huracan.py` repite mediante la interfaz el flujo de alta, consulta y baja lógica de proveedores. Crea proveedores sintéticos con RIF únicos, los comprueba en la papelera y purga únicamente los RIF creados por la ejecución. Los eventos de bitácora permanecen como auditoría.

## Requisitos y ejecución en PowerShell

1. Tener Apache y MySQL locales activos y un usuario de prueba con permisos sobre Proveedores.
2. Configurar el usuario y contraseña solo en el entorno del proceso; no quedan escritos en el script ni en los resultados.
3. Confirmar expresamente que se permiten escrituras temporales en la base local `bd`.

```powershell
$env:HURACAN_TEST_USER = 'usuario de pruebas'
$env:HURACAN_TEST_PASSWORD = 'contraseña de pruebas'
$env:HURACAN_CONFIRMAR_ESCRITURAS = 'SI'
python tests/huracan/selenium_huracan.py
Remove-Item Env:HURACAN_TEST_USER, Env:HURACAN_TEST_PASSWORD, Env:HURACAN_CONFIRMAR_ESCRITURAS
```

Por defecto ejecuta 10 ciclos HUR-01 y 20 ciclos HUR-02. Se pueden ajustar con `HURACAN_CICLOS_NORMAL` y `HURACAN_CICLOS_EXTENDIDO`.

Se generan un CSV por paso y un resumen en `tests/huracan/resultados/`. HUR-01 usa una pausa normal; HUR-02 repite más ciclos con menos pausa. El runner solo admite DB_HOST local y DB_NAME `bd`, y registra limpieza pendiente si no puede eliminar los proveedores sintéticos.

## Huracán de carga con ApacheBench

`huracan_ab.bat` hace login con `curl`, guarda el `PHPSESSID` y ejecuta ciclos de carga concurrente con `ab.exe` contra endpoints de solo lectura. No crea ni borra datos.

```bat
tests\huracan\huracan_ab.bat USUARIO CONTRASENA
```

También acepta usuario y contraseña desde `HURACAN_TEST_USER` y `HURACAN_TEST_PASSWORD`. Variables opcionales:

```bat
set HURACAN_CICLOS=3
set HURACAN_PETICIONES=300
set HURACAN_CONCURRENCIA=30
set HURACAN_PAUSA=5
```

Cada corrida deja un archivo `AB_HUR_FECHA.txt` con el resumen de cada endpoint y una carpeta `AB_HUR_FECHA` con la salida completa de ApacheBench por ciclo. Los HTTP 429 corresponden al limitador de la aplicación y deben separarse de los errores 5xx al interpretar los resultados.

Antes de ejecutar `ab`, el `.bat` comprueba con `curl` que el servidor responda. Si XAMPP/Apache está apagado o la conexión se rechaza, escribe `ERROR: SERVIDOR NO DISPONIBLE` en el archivo de resultados y no continúa. Si el servidor se cae durante un ciclo, también deja una advertencia clara en lugar de mostrar solo `Non-2xx responses`.
