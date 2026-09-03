@echo off
setlocal EnableExtensions EnableDelayedExpansion

rem Respaldo completo independiente de PHP y sin compresion.
rem Genera un SQL por cada base de datos.

set "PROJECT_ROOT=%~dp0"
for %%I in ("%PROJECT_ROOT%") do set "PROJECT_ROOT=%%~fI"
set "ENV_FILE=%PROJECT_ROOT%\.env"

rem Variables requeridas: DB_HOST, DB_USER, DB_PASS, DB_NAME,
rem DB_NAME_SEGURITY, XAMPP_MYSQL_BIN y BACKUP_DIR.

if not exist "%ENV_FILE%" (
    echo ERROR: No se encontro el archivo .env
    exit /b 1
)

for /f "usebackq eol=# tokens=1,* delims==" %%A in ("%ENV_FILE%") do (
    if not "%%A"=="" set "%%A=%%B"
)

for %%V in (DB_HOST DB_USER DB_PASS DB_NAME DB_NAME_SEGURITY XAMPP_MYSQL_BIN BACKUP_DIR) do (
    if not defined %%V (
        echo ERROR: Falta %%V en el .env
        exit /b 1
    )
    for /f "delims=" %%A in ("!%%V!") do set "%%V=%%~A"
    set "%%V=!%%V:"=!"
)

echo Configuracion cargada:
echo DB_HOST=!DB_HOST!
echo DB_USER=!DB_USER!
echo DB_PASS=********
echo DB_NAME=!DB_NAME!
echo DB_NAME_SEGURITY=!DB_NAME_SEGURITY!
echo XAMPP_MYSQL_BIN=!XAMPP_MYSQL_BIN!
echo BACKUP_DIR=!BACKUP_DIR!

set "MYSQL_BIN=!XAMPP_MYSQL_BIN:/=\!"
set "MYSQL_EXE=!MYSQL_BIN!\mysql.exe"
set "MYSQLDUMP_EXE=!MYSQL_BIN!\mysqldump.exe"
set "BACKUP_DIR=!BACKUP_DIR:/=\!"

if not exist "!MYSQLDUMP_EXE!" (
    echo ERROR: No se encontro mysqldump.exe en "!MYSQLDUMP_EXE!"
    exit /b 1
)
if not exist "!MYSQL_EXE!" (
    echo ERROR: No se encontro mysql.exe en "!MYSQL_EXE!"
    exit /b 1
)
if not exist "!BACKUP_DIR!" mkdir "!BACKUP_DIR!"
if not exist "!BACKUP_DIR!" (
    echo ERROR: No se pudo crear BACKUP_DIR.
    exit /b 1
)

set "MYSQL_PWD=!DB_PASS!"
set "STAMP="
for /f "delims=" %%A in ('powershell.exe -NoProfile -Command "Get-Date -Format yyyy-MM-dd_HH-mm-ss"') do set "STAMP=%%A"
if not defined STAMP (
    echo ERROR: No se pudo obtener la fecha del respaldo.
    exit /b 1
)

set "SQL_SISTEMA=!BACKUP_DIR!\full_bd_!STAMP!.sql"
set "SQL_SEGURIDAD=!BACKUP_DIR!\full_bdseguri_!STAMP!.sql"
set "ERROR_SISTEMA=!BACKUP_DIR!\full_bd_!STAMP!.error.log"
set "ERROR_SEGURIDAD=!BACKUP_DIR!\full_bdseguri_!STAMP!.error.log"
set "STATE_TEMP=!BACKUP_DIR!\master_status_!STAMP!.tmp"
set "STATE_FILE=!BACKUP_DIR!\binlog_state.txt"

echo Generando respaldo de !DB_NAME!...
"!MYSQLDUMP_EXE!" -h"!DB_HOST!" -u"!DB_USER!" --flush-logs --single-transaction --master-data=2 --routines --triggers --events "!DB_NAME!" >"!SQL_SISTEMA!" 2>"!ERROR_SISTEMA!"
if errorlevel 1 goto :error_dump
if not exist "!SQL_SISTEMA!" goto :error_dump

echo Generando respaldo de !DB_NAME_SEGURITY!...
"!MYSQLDUMP_EXE!" -h"!DB_HOST!" -u"!DB_USER!" --single-transaction --routines --triggers --events "!DB_NAME_SEGURITY!" >"!SQL_SEGURIDAD!" 2>"!ERROR_SEGURIDAD!"
if errorlevel 1 goto :error_dump
if not exist "!SQL_SEGURIDAD!" goto :error_dump

for %%A in ("!SQL_SISTEMA!") do if %%~zA LEQ 0 goto :error_dump
for %%A in ("!SQL_SEGURIDAD!") do if %%~zA LEQ 0 goto :error_dump
del /q "!ERROR_SISTEMA!" "!ERROR_SEGURIDAD!" >nul 2>&1
"!MYSQL_EXE!" -h"!DB_HOST!" -u"!DB_USER!" -N -B -e "SHOW MASTER STATUS;" >"!STATE_TEMP!" 2>nul
if errorlevel 1 (
    echo ERROR: El respaldo se genero, pero no se pudo guardar la posicion del binlog.
    set "MYSQL_PWD="
    exit /b 1
)
for /f "usebackq tokens=1,2" %%A in ("!STATE_TEMP!") do >"!STATE_FILE!" echo %%A %%B
del /q "!STATE_TEMP!" >nul 2>&1
set "MYSQL_PWD="
echo Respaldo completo generado correctamente:
echo !SQL_SISTEMA!
echo !SQL_SEGURIDAD!
exit /b 0

:error_dump
echo ERROR: Fallo mysqldump o se genero un SQL vacio.
echo Revise:
echo !ERROR_SISTEMA!
echo !ERROR_SEGURIDAD!
set "MYSQL_PWD="
exit /b 1
