@echo off
setlocal EnableExtensions EnableDelayedExpansion

rem Configura binlog para MySQL/MariaDB de XAMPP. Requiere reiniciar MySQL.
set "PROJECT_ROOT=%~dp0"
for %%I in ("%PROJECT_ROOT%") do set "PROJECT_ROOT=%%~fI"
set "ENV_FILE=%PROJECT_ROOT%\.env"

rem Variables requeridas: XAMPP_MYSQL_BIN, MYSQL_BINLOG_DIR,
rem MYSQL_BINLOG_PREFIX, BACKUP_DIR y BACKUP_FULL_MAX_DAYS.

if not exist "%ENV_FILE%" (
    echo ERROR: No se encontro el archivo .env
    exit /b 1
)
for /f "usebackq eol=# tokens=1,* delims==" %%A in ("%ENV_FILE%") do (
    if not "%%A"=="" set "%%A=%%B"
)

rem Acepta valores del .env con o sin comillas externas.
for %%V in (XAMPP_MYSQL_BIN MYSQL_BINLOG_DIR MYSQL_BINLOG_PREFIX BACKUP_DIR BACKUP_FULL_MAX_DAYS) do (
    for /f "delims=" %%A in ("!%%V!") do set "%%V=%%~A"
    set "%%V=!%%V:"=!"
)

for %%V in (XAMPP_MYSQL_BIN MYSQL_BINLOG_DIR MYSQL_BINLOG_PREFIX BACKUP_DIR BACKUP_FULL_MAX_DAYS) do (
    if not defined %%V (
        echo ERROR: Falta %%V en el .env
        exit /b 1
    )
)

echo Configuracion cargada:
echo XAMPP_MYSQL_BIN=!XAMPP_MYSQL_BIN!
echo MYSQL_BINLOG_DIR=!MYSQL_BINLOG_DIR!
echo MYSQL_BINLOG_PREFIX=!MYSQL_BINLOG_PREFIX!
echo BACKUP_DIR=!BACKUP_DIR!
echo BACKUP_FULL_MAX_DAYS=!BACKUP_FULL_MAX_DAYS!

set "MYSQL_BIN=!XAMPP_MYSQL_BIN:/=\!"
set "BACKUP_DIR=!BACKUP_DIR:/=\!"
set "MYSQL_INI=!MYSQL_BIN!\my.ini"
if not exist "!MYSQL_INI!" (
    echo ERROR: No se encontro my.ini en "!MYSQL_INI!"
    exit /b 1
)
if not exist "!BACKUP_DIR!" mkdir "!BACKUP_DIR!" >nul 2>&1
if not exist "!BACKUP_DIR!" (
    echo ERROR: No se pudo crear BACKUP_DIR en "!BACKUP_DIR!"
    exit /b 1
)

set "BACKUP_INI=!MYSQL_INI!.backup_%RANDOM%"
copy /y "!MYSQL_INI!" "!BACKUP_INI!" >nul
if errorlevel 1 (
    echo ERROR: No se pudo crear una copia de seguridad de my.ini
    exit /b 1
)

findstr /i /r /c:"^[ ]*log[-_]bin[ ]*=" "!MYSQL_INI!" >nul
if errorlevel 1 (
    >>"!MYSQL_INI!" echo.
    >>"!MYSQL_INI!" echo [mysqld]
    >>"!MYSQL_INI!" echo server-id=1
    >>"!MYSQL_INI!" echo log-bin=!MYSQL_BINLOG_PREFIX!
    >>"!MYSQL_INI!" echo binlog_format=ROW
    >>"!MYSQL_INI!" echo expire_logs_days=14
    echo Configuracion de binlog agregada a my.ini.
) else (
    echo Ya existe una configuracion log-bin. No se duplicaron parametros.
)

echo.
echo Copia de seguridad de configuracion: !BACKUP_INI!
echo Reinicie MySQL desde el panel de XAMPP para activar el binlog.
echo Luego verifique con:
echo "!MYSQL_BIN!\mysql.exe" -uUSUARIO -p -e "SHOW VARIABLES LIKE 'log_bin'; SHOW BINARY LOGS;"
echo.
pause
exit /b 0
