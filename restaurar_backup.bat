@echo off
setlocal EnableExtensions EnableDelayedExpansion

rem Restaura el ultimo respaldo completo y los incrementales posteriores.
rem Este proceso sobrescribe datos de las bases indicadas.

set "PROJECT_ROOT=%~dp0"
for %%I in ("%PROJECT_ROOT%") do set "PROJECT_ROOT=%%~fI"
set "ENV_FILE=%PROJECT_ROOT%\.env"

rem Variables requeridas: DB_HOST, DB_USER, DB_PASS, DB_NAME,
rem DB_NAME_SEGURITY, XAMPP_MYSQL_BIN y BACKUP_DIR.

if not exist "%ENV_FILE%" (
    echo ERROR: No se encontro el archivo .env
    pause
    exit /b 1
)

for /f "usebackq eol=# tokens=1,* delims==" %%A in ("%ENV_FILE%") do (
    if not "%%A"=="" set "%%A=%%B"
)

for %%V in (DB_HOST DB_USER DB_PASS DB_NAME DB_NAME_SEGURITY XAMPP_MYSQL_BIN BACKUP_DIR) do (
    if not defined %%V (
        echo ERROR: Falta %%V en el .env
        pause
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
set "BACKUP_DIR=!BACKUP_DIR:/=\!"

if not exist "!MYSQL_EXE!" (
    echo ERROR: No se encontro mysql.exe en "!MYSQL_EXE!"
    pause
    exit /b 1
)
if not exist "!BACKUP_DIR!" (
    echo ERROR: No se encontro BACKUP_DIR en "!BACKUP_DIR!"
    pause
    exit /b 1
)

set "FULL_FILE="
for /f "delims=" %%A in ('powershell.exe -NoProfile -Command "$d=Get-ChildItem -LiteralPath '!BACKUP_DIR!' -Filter 'full_bd_*.sql' -File ^| Where-Object {$_.Name -match '^full_bd_\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2}\.sql$'} ^| Sort-Object Name -Descending ^| Select-Object -First 1; if($d){$d.FullName}"') do set "FULL_FILE=%%A"
if not defined FULL_FILE (
    echo ERROR: No se encontro un respaldo completo full_bd_*.sql
    pause
    exit /b 1
)

set "FULL_STAMP="
for /f "delims=" %%A in ('powershell.exe -NoProfile -Command "$n=[IO.Path]::GetFileNameWithoutExtension('!FULL_FILE!'); if($n -match '^full_bd_(\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2})$'){$matches[1]}"') do set "FULL_STAMP=%%A"
if not defined FULL_STAMP (
    echo ERROR: No se pudo determinar la fecha del respaldo completo.
    pause
    exit /b 1
)

set "SECURITY_FILE=!BACKUP_DIR!\full_bdseguri_!FULL_STAMP!.sql"
if not exist "!SECURITY_FILE!" (
    echo ERROR: Falta el respaldo de seguridad correspondiente:
    echo !SECURITY_FILE!
    pause
    exit /b 1
)

echo.
echo Se restaurara:
echo !SECURITY_FILE!
echo !FULL_FILE!
echo y todos los diferenciales posteriores a !FULL_STAMP!
echo.
choice /C SN /N /M "ATENCION: este proceso sobrescribira las bases. Continuar? [S/N] "
if errorlevel 2 exit /b 0

set "MYSQL_PWD=!DB_PASS!"
set "RESTORE_LOG=!BACKUP_DIR!\restore_!FULL_STAMP!.log"
>"!RESTORE_LOG!" echo Inicio de restauracion: %date% %time%
>>"!RESTORE_LOG!" echo Respaldo completo: !FULL_STAMP!

echo Restaurando !DB_NAME_SEGURITY!...
"!MYSQL_EXE!" -h"!DB_HOST!" -u"!DB_USER!" "!DB_NAME_SEGURITY!" <"!SECURITY_FILE!" >>"!RESTORE_LOG!" 2>&1
if errorlevel 1 goto :restore_error

echo Restaurando !DB_NAME!...
"!MYSQL_EXE!" -h"!DB_HOST!" -u"!DB_USER!" "!DB_NAME!" <"!FULL_FILE!" >>"!RESTORE_LOG!" 2>&1
if errorlevel 1 goto :restore_error

set "RESTORE_LIST=!BACKUP_DIR!\restore_list_!FULL_STAMP!.tmp"
rem Nunca reutilizar una lista de una restauracion anterior.
del /q "!RESTORE_LIST!" >nul 2>&1
for /f "delims=" %%A in ('powershell.exe -NoProfile -Command "$base=[datetime]::ParseExact('!FULL_STAMP!','yyyy-MM-dd_HH-mm-ss',$null); Get-ChildItem -LiteralPath '!BACKUP_DIR!' -File ^| Where-Object { if($_.Name -match '^(diff_binlog^|diferencial_binlog^|inc_binlog^|incremental_binlog)_(\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2})\.sql$'){ $d=[datetime]::ParseExact($matches[2],'yyyy-MM-dd_HH-mm-ss',$null); $d -gt $base } } ^| Sort-Object Name ^| ForEach-Object {$_.FullName}"') do echo %%A>>"!RESTORE_LIST!"

if exist "!RESTORE_LIST!" (
    for /f "usebackq delims=" %%F in ("!RESTORE_LIST!") do (
        if exist "%%F" (
            echo Aplicando %%~nxF...
            >>"!RESTORE_LOG!" echo Aplicando %%~nxF
            rem La variable check_constraint_checks puede no existir en el servidor destino.
            rem Se excluye solo su linea de sesion; el incremental original no se modifica.
            set "RESTORE_SQL=%TEMP%\restore_%%~nF_%RANDOM%.sql"
            findstr /v /c:"check_constraint_checks" "%%F" >"!RESTORE_SQL!"
            if errorlevel 1 (
                del /q "!RESTORE_SQL!" >nul 2>&1
                goto :restore_error
            )
            "!MYSQL_EXE!" -h"!DB_HOST!" -u"!DB_USER!" <"!RESTORE_SQL!" >>"!RESTORE_LOG!" 2>&1
            set "RESTORE_RESULT=!errorlevel!"
            del /q "!RESTORE_SQL!" >nul 2>&1
            if not "!RESTORE_RESULT!"=="0" goto :restore_error
        )
    )
    del /q "!RESTORE_LIST!" >nul 2>&1
) else (
    echo No hay respaldos diferenciales posteriores.
)

set "MYSQL_PWD="
>>"!RESTORE_LOG!" echo Restauracion finalizada: %date% %time%
echo.
echo Restauracion completada correctamente.
echo Registro: !RESTORE_LOG!
pause
exit /b 0

:restore_error
set "MYSQL_PWD="
>>"!RESTORE_LOG!" echo ERROR durante la restauracion: %date% %time%
echo ERROR: La restauracion fallo. Revise:
echo !RESTORE_LOG!
pause
exit /b 1
