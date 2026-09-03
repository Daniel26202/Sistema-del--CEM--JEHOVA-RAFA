@echo off
setlocal EnableExtensions EnableDelayedExpansion

rem Genera un SQL con las transacciones del binlog posteriores al ultimo full.
rem No elimina binlogs ni modifica el respaldo completo.

set "PROJECT_ROOT=%~dp0"
for %%I in ("%PROJECT_ROOT%") do set "PROJECT_ROOT=%%~fI"
set "ENV_FILE=%PROJECT_ROOT%\.env"

rem Variables requeridas: DB_HOST, DB_USER, DB_PASS, XAMPP_MYSQL_BIN,
rem MYSQL_BINLOG_DIR, MYSQL_BINLOG_PREFIX, BACKUP_DIR y BACKUP_FULL_MAX_DAYS.

if not exist "%ENV_FILE%" (
    echo ERROR: No se encontro el archivo .env: "%ENV_FILE%"
    exit /b 1
)

rem El .env del proyecto usa pares sencillos CLAVE=VALOR.
for /f "usebackq eol=# tokens=1,* delims==" %%A in ("%ENV_FILE%") do (
    if not "%%A"=="" set "%%A=%%B"
)

rem Acepta valores del .env con o sin comillas externas.
for %%V in (DB_HOST DB_USER DB_PASS XAMPP_MYSQL_BIN MYSQL_BINLOG_DIR MYSQL_BINLOG_PREFIX BACKUP_DIR BACKUP_FULL_MAX_DAYS) do (
    for /f "delims=" %%A in ("!%%V!") do set "%%V=%%~A"
    set "%%V=!%%V:"=!"
)

if not defined XAMPP_MYSQL_BIN (
    echo ERROR: Falta XAMPP_MYSQL_BIN en el .env
    exit /b 1
)
if not defined MYSQL_BINLOG_DIR (
    echo ERROR: Falta MYSQL_BINLOG_DIR en el .env
    exit /b 1
)
if not defined BACKUP_DIR (
    echo ERROR: Falta BACKUP_DIR en el .env
    exit /b 1
)
if not defined DB_HOST (
    echo ERROR: Falta DB_HOST en el .env
    exit /b 1
)
if not defined DB_USER (
    echo ERROR: Falta DB_USER en el .env
    exit /b 1
)
if not defined DB_PASS (
    echo ERROR: Falta DB_PASS en el .env
    exit /b 1
)
if not defined MYSQL_BINLOG_PREFIX (
    echo ERROR: Falta MYSQL_BINLOG_PREFIX en el .env
    exit /b 1
)
if not defined BACKUP_FULL_MAX_DAYS (
    echo ERROR: Falta BACKUP_FULL_MAX_DAYS en el .env
    exit /b 1
)

echo Configuracion cargada:
echo DB_HOST=!DB_HOST!
echo DB_USER=!DB_USER!
echo DB_PASS=********
echo XAMPP_MYSQL_BIN=!XAMPP_MYSQL_BIN!
echo MYSQL_BINLOG_DIR=!MYSQL_BINLOG_DIR!
echo MYSQL_BINLOG_PREFIX=!MYSQL_BINLOG_PREFIX!
echo BACKUP_DIR=!BACKUP_DIR!
echo BACKUP_FULL_MAX_DAYS=!BACKUP_FULL_MAX_DAYS!

set "MYSQL_BIN=!XAMPP_MYSQL_BIN:/=\!"
set "BINLOG_DIR=!MYSQL_BINLOG_DIR:/=\!"
set "BACKUP_DIR=!BACKUP_DIR:/=\!"
set "MYSQL_EXE=!MYSQL_BIN!\mysql.exe"
set "MYSQLBINLOG_EXE=!MYSQL_BIN!\mysqlbinlog.exe"

if not exist "!MYSQL_EXE!" (
    echo ERROR: No se encontro mysql.exe en "!MYSQL_EXE!"
    exit /b 1
)
if not exist "!MYSQLBINLOG_EXE!" (
    echo ERROR: No se encontro mysqlbinlog.exe en "!MYSQLBINLOG_EXE!"
    exit /b 1
)
if not exist "!BINLOG_DIR!" (
    echo ERROR: No se encontro la carpeta de binlogs "!BINLOG_DIR!"
    exit /b 1
)
if not exist "!BACKUP_DIR!" mkdir "!BACKUP_DIR!"

set "MYSQL_PWD=!DB_PASS!"
set "NOW_DATE="
for /f "delims=" %%A in ('powershell.exe -NoProfile -Command "Get-Date -Format yyyy-MM-dd_HH-mm-ss"') do set "NOW_DATE=%%A"
set "NOW_DATE=!NOW_DATE:_= !"
set "STAMP="
for /f "delims=" %%A in ('powershell.exe -NoProfile -Command "Get-Date -Format yyyy-MM-dd_HH-mm-ss"') do set "STAMP=%%A"

set "FULL_FILE="
for /f "delims=" %%A in ('powershell.exe -NoProfile -Command "$d=Get-ChildItem -LiteralPath '!BACKUP_DIR!' -Filter 'full_bd_*.sql' -File ^| Sort-Object Name -Descending ^| Select-Object -First 1; if($d){$d.FullName}"') do set "FULL_FILE=%%A"

if not defined FULL_FILE (
    echo No existe un respaldo completo. Ejecutando backup_completo.bat...
    call "%PROJECT_ROOT%\backup_completo.bat"
    exit /b !errorlevel!
)

set "FULL_DATE="
for /f "delims=" %%A in ('powershell.exe -NoProfile -Command "$n=[IO.Path]::GetFileNameWithoutExtension('!FULL_FILE!'); if($n -match '^full_bd_(\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2})$'){[datetime]::ParseExact($matches[1],'yyyy-MM-dd_HH-mm-ss',$null).ToString('yyyy-MM-dd HH:mm:ss')}else{(Get-Item -LiteralPath '!FULL_FILE!').LastWriteTime.ToString('yyyy-MM-dd HH:mm:ss')}"') do set "FULL_DATE=%%A"

set "FULL_OLD=0"
for /f "delims=" %%A in ('powershell.exe -NoProfile -Command "if((Get-Date) - [datetime]::Parse('!FULL_DATE!') -gt [timespan]::FromDays(!BACKUP_FULL_MAX_DAYS!)){1}else{0}"') do set "FULL_OLD=%%A"
if "!FULL_OLD!"=="1" (
    echo El respaldo completo tiene mas de 7 dias. Ejecutando backup_completo.bat...
    call "%PROJECT_ROOT%\backup_completo.bat"
    exit /b !errorlevel!
)

set "START_DATE=!FULL_DATE!"
set "TIPO=diff"
set "LAST_INCREMENTAL="
for /f "delims=" %%A in ('powershell.exe -NoProfile -Command "$d=Get-ChildItem -LiteralPath '!BACKUP_DIR!' -File ^| Where-Object {$_.Name -match '^(diff_binlog^|diferencial_binlog^|inc_binlog^|incremental_binlog)_\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2}\.sql$'} ^| Sort-Object Name -Descending ^| Select-Object -First 1; if($d){$d.FullName}"') do set "LAST_INCREMENTAL=%%A"
if defined LAST_INCREMENTAL (
    for /f "delims=" %%A in ('powershell.exe -NoProfile -Command "$n=[IO.Path]::GetFileNameWithoutExtension('!LAST_INCREMENTAL!'); if($n -match '_(\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2})$'){[datetime]::ParseExact($matches[1],'yyyy-MM-dd_HH-mm-ss',$null).AddSeconds(1).ToString('yyyy-MM-dd HH:mm:ss')}"') do set "START_DATE=%%A"
    set "TIPO=incremental"
)

set "OUTPUT=!BACKUP_DIR!\!TIPO!_binlog_!STAMP!.sql"
set "LOG_FILE=!BACKUP_DIR!\backup_binlog_!STAMP!.log"
set "BINLOG_LIST=!BACKUP_DIR!\binlog_list_!STAMP!.tmp"
set "MASTER_STATUS=!BACKUP_DIR!\master_status_!STAMP!.tmp"
set "STATE_FILE=!BACKUP_DIR!\binlog_state.txt"
set "FOUND=0"

>"!LOG_FILE!" echo Inicio: !NOW_DATE!
>>"!LOG_FILE!" echo Respaldo completo base: !FULL_DATE!
>>"!LOG_FILE!" echo Inicio de transacciones: !START_DATE!
>>"!LOG_FILE!" echo Tipo: !TIPO!
>>"!LOG_FILE!" echo Carpeta binlog: !BINLOG_DIR!
>>"!LOG_FILE!" echo Salida: !OUTPUT!

echo Comprobando binlog activo...
"!MYSQL_EXE!" -h"!DB_HOST!" -u"!DB_USER!" -N -B -e "SHOW VARIABLES LIKE 'log_bin';" >>"!LOG_FILE!" 2>&1
if errorlevel 1 (
    echo ERROR: No fue posible consultar el estado de los binlogs. Revise las credenciales y MySQL.
    exit /b 1
)
"!MYSQL_EXE!" -h"!DB_HOST!" -u"!DB_USER!" -N -B -e "SHOW BINARY LOGS;" >"!BINLOG_LIST!" 2>>"!LOG_FILE!"
if errorlevel 1 (
    del /q "!BINLOG_LIST!" >nul 2>&1
    echo ERROR: No fue posible obtener la lista de binlogs. Revise !LOG_FILE!
    exit /b 1
)
"!MYSQL_EXE!" -h"!DB_HOST!" -u"!DB_USER!" -N -B -e "SHOW MASTER STATUS;" >"!MASTER_STATUS!" 2>>"!LOG_FILE!"
if errorlevel 1 (
    del /q "!BINLOG_LIST!" "!MASTER_STATUS!" >nul 2>&1
    echo ERROR: No fue posible obtener la posicion actual del binlog. Revise !LOG_FILE!
    exit /b 1
)

set "CURRENT_FILE="
set "CURRENT_POSITION="
for /f "usebackq tokens=1,2" %%A in ("!MASTER_STATUS!") do (
    set "CURRENT_FILE=%%A"
    set "CURRENT_POSITION=%%B"
)
if defined CURRENT_FILE if defined CURRENT_POSITION if exist "!STATE_FILE!" (
    findstr /b /l /c:"!CURRENT_FILE! !CURRENT_POSITION!" "!STATE_FILE!" >nul
    if not errorlevel 1 (
        del /q "!BINLOG_LIST!" "!MASTER_STATUS!" >nul 2>&1
        echo No hay cambios nuevos desde el ultimo respaldo binlog.
        exit /b 0
    )
)

set "START_BINLOG="
set "START_POSITION="
if exist "!STATE_FILE!" (
    for /f "usebackq tokens=1,2" %%A in ("!STATE_FILE!") do (
        set "START_BINLOG=%%A"
        set "START_POSITION=%%B"
    )
)
set "STARTED=0"
if defined START_BINLOG if not defined START_POSITION (
    echo ERROR: El estado del binlog esta incompleto. Ejecute un respaldo completo.
    del /q "!BINLOG_LIST!" "!MASTER_STATUS!" >nul 2>&1
    exit /b 1
)

>"!OUTPUT!" echo -- Backup diferencial generado desde !FULL_DATE!
>>"!OUTPUT!" echo -- Generado: !NOW_DATE!
>>"!OUTPUT!" echo -- Fuente: binlogs locales de XAMPP
>>"!OUTPUT!" echo.

rem Se usa SHOW BINARY LOGS para respetar el nombre real configurado por MySQL.
rem Esto evita depender de MYSQL_BINLOG_PREFIX y excluye automaticamente el .index.
for /f "usebackq tokens=1" %%F in ("!BINLOG_LIST!") do (
    set "PROCESS_FILE=1"
    set "POSITION_ARG="
    if defined START_BINLOG if "!STARTED!"=="0" (
        if /i "%%F"=="!START_BINLOG!" (
            set "STARTED=1"
            set "POSITION_ARG=--start-position=!START_POSITION!"
        ) else (
            set "PROCESS_FILE=0"
        )
    )
    if "!PROCESS_FILE!"=="1" if exist "!BINLOG_DIR!\%%F" (
        set "FOUND=1"
        echo Procesando %%F...
        >>"!LOG_FILE!" echo Procesando %%F
        if defined POSITION_ARG (
            "!MYSQLBINLOG_EXE!" !POSITION_ARG! --stop-datetime="!NOW_DATE!" "!BINLOG_DIR!\%%F" >>"!OUTPUT!" 2>>"!LOG_FILE!"
        ) else if defined START_BINLOG (
            "!MYSQLBINLOG_EXE!" --stop-datetime="!NOW_DATE!" "!BINLOG_DIR!\%%F" >>"!OUTPUT!" 2>>"!LOG_FILE!"
        ) else (
            "!MYSQLBINLOG_EXE!" --start-datetime="!START_DATE!" --stop-datetime="!NOW_DATE!" "!BINLOG_DIR!\%%F" >>"!OUTPUT!" 2>>"!LOG_FILE!"
        )
        if errorlevel 1 (
            echo ERROR: Fallo el procesamiento de %%F. Revise !LOG_FILE!
            exit /b 1
        )
    )
)

if defined START_BINLOG if "!STARTED!"=="0" (
    del /q "!BINLOG_LIST!" "!MASTER_STATUS!" >nul 2>&1
    echo ERROR: No se encontro !START_BINLOG! en la lista de binlogs.
    exit /b 1
)

if "!FOUND!"=="0" (
    del /q "!BINLOG_LIST!" >nul 2>&1
    echo ERROR: No se encontraron archivos binlog en "!BINLOG_DIR!"
    exit /b 1
)

del /q "!BINLOG_LIST!" >nul 2>&1
if defined CURRENT_FILE if defined CURRENT_POSITION >"!STATE_FILE!" echo !CURRENT_FILE! !CURRENT_POSITION!
del /q "!MASTER_STATUS!" >nul 2>&1
>>"!LOG_FILE!" echo Fin: !NOW_DATE!
>>"!LOG_FILE!" echo Resultado: !OUTPUT!
echo Respaldo diferencial generado:
echo !OUTPUT!
echo Registro:
echo !LOG_FILE!

set "MYSQL_PWD="
exit /b 0
