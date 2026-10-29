@echo off
setlocal EnableExtensions EnableDelayedExpansion

rem Prueba huracan con ApacheBench (solo lectura).
rem Uso:
rem   huracan_ab.bat USUARIO CONTRASENA
rem o define HURACAN_TEST_USER y HURACAN_TEST_PASSWORD en el entorno.
rem Opcional: HURACAN_BASE_URL, HURACAN_CICLOS, HURACAN_PETICIONES, HURACAN_CONCURRENCIA, HURACAN_PAUSA.

set "PROJECT_ROOT=%~dp0..\.."
for %%I in ("%PROJECT_ROOT%") do set "PROJECT_ROOT=%%~fI"
set "RESULT_DIR=%PROJECT_ROOT%\tests\huracan\resultados"
set "AB_EXE=C:\xampp\apache\bin\ab.exe"
set "CURL_EXE=curl.exe"

if not defined HURACAN_BASE_URL set "HURACAN_BASE_URL=http://localhost/Sistema-del--CEM--JEHOVA-RAFA"
set "BASE_URL=%HURACAN_BASE_URL%"
if "%BASE_URL:~-1%"=="/" set "BASE_URL=%BASE_URL:~0,-1%"

if "%~1" neq "" set "HURACAN_TEST_USER=%~1"
if "%~2" neq "" set "HURACAN_TEST_PASSWORD=%~2"

if not defined HURACAN_TEST_USER (
    set /p HURACAN_TEST_USER=Usuario de prueba: 
)
if not defined HURACAN_TEST_PASSWORD (
    set /p HURACAN_TEST_PASSWORD=Contrasena de prueba: 
)
if not defined HURACAN_TEST_USER goto :error_credenciales
if not defined HURACAN_TEST_PASSWORD goto :error_credenciales

if not defined HURACAN_CICLOS set "HURACAN_CICLOS=3"
if not defined HURACAN_PETICIONES set "HURACAN_PETICIONES=300"
if not defined HURACAN_CONCURRENCIA set "HURACAN_CONCURRENCIA=30"
if not defined HURACAN_PAUSA set "HURACAN_PAUSA=5"

if not exist "%AB_EXE%" goto :error_ab
if not exist "%RESULT_DIR%" mkdir "%RESULT_DIR%"

set "STAMP="
for /f "delims=" %%A in ('powershell.exe -NoProfile -Command "Get-Date -Format yyyy-MM-dd_HH-mm-ss"') do set "STAMP=%%A"
if not defined STAMP goto :error_fecha

set "COOKIE=%TEMP%\huracan_cookie_%RANDOM%_%RANDOM%.txt"
set "LOGIN_JSON=%TEMP%\huracan_login_%RANDOM%_%RANDOM%.json"
set "RESULT=%RESULT_DIR%\AB_HUR_%STAMP%.txt"
set "DETAIL_DIR=%RESULT_DIR%\AB_HUR_%STAMP%"
if not exist "%DETAIL_DIR%" mkdir "%DETAIL_DIR%"

>"%RESULT%" echo PRUEBA HURACAN - ApacheBench
>>"%RESULT%" echo Fecha: %STAMP%
>>"%RESULT%" echo URL base: %BASE_URL%
>>"%RESULT%" echo Ciclos: %HURACAN_CICLOS%
>>"%RESULT%" echo Peticiones por ciclo/endpoint: %HURACAN_PETICIONES%
>>"%RESULT%" echo Concurrencia: %HURACAN_CONCURRENCIA%
>>"%RESULT%" echo Pausa entre ciclos: %HURACAN_PAUSA%s
>>"%RESULT%" echo Flujo: solo lectura con sesion autenticada.
>>"%RESULT%" echo Nota: los HTTP 429 son rechazos del limitador de tasa, no errores 5xx.
>>"%RESULT%" echo.

echo Comprobando servidor...
"%CURL_EXE%" -sS -o NUL --max-time 5 "%BASE_URL%/" >nul 2>&1
if errorlevel 1 goto :error_servidor

echo Ejecutando inicio de sesion...
"%CURL_EXE%" -sS -c "%COOKIE%" --data-urlencode "username=%HURACAN_TEST_USER%" --data-urlencode "password=%HURACAN_TEST_PASSWORD%" "%BASE_URL%/IniciarSesion/iniciarSesion" -o "%LOGIN_JSON%"
if errorlevel 1 goto :error_login
findstr /i /c:"\"ok\":true" "%LOGIN_JSON%" >nul
if errorlevel 1 goto :error_login

set "SID="
for /f "tokens=6,7" %%A in ('findstr /i "PHPSESSID" "%COOKIE%"') do set "SID=%%B"
if not defined SID goto :error_login

set /a CICLO=1
:cycle
if %CICLO% GTR %HURACAN_CICLOS% goto :finish
echo.
echo === Ciclo %CICLO% de %HURACAN_CICLOS% ===
>>"%RESULT%" echo ============================================================
>>"%RESULT%" echo CICLO %CICLO% - %STAMP%
>>"%RESULT%" echo ============================================================

set "EP_NAME=Pacientes"
set "EP_PATH=/Pacientes/getPacientesAjax?draw=1&start=0&length=10"
call :run_endpoint
set "EP_NAME=Citas"
set "EP_PATH=/Citas/citasAjax?draw=1&start=0&length=10"
call :run_endpoint
set "EP_NAME=Doctores"
set "EP_PATH=/Doctores/DoctoresAjax?draw=1&start=0&length=10"
call :run_endpoint
set "EP_NAME=Control"
set "EP_PATH=/Control/listPacientesJS?draw=1&start=0&length=10"
call :run_endpoint

set /a CICLO+=1
if %CICLO% LEQ %HURACAN_CICLOS% timeout /t %HURACAN_PAUSA% /nobreak >nul
goto :cycle

:finish
>>"%RESULT%" echo.
>>"%RESULT%" echo FIN DE LA PRUEBA: %STAMP%
>"%RESULT_DIR%\AB_HUR_ULTIMO.txt" echo %RESULT%
echo.
echo Resultados: %RESULT%
echo Detalle:   %DETAIL_DIR%
type "%RESULT_DIR%\AB_HUR_ULTIMO.txt"
del /q "%COOKIE%" "%LOGIN_JSON%" >nul 2>&1
exit /b 0

:run_endpoint
set "EP_URL=%BASE_URL%%EP_PATH%"
set "EP_FILE=%DETAIL_DIR%\ciclo%CICLO%_%EP_NAME%.txt"
echo   - %EP_NAME%
>>"%RESULT%" echo --- %EP_NAME% ---
>>"%RESULT%" echo URL: "%EP_URL%"
"%AB_EXE%" -n %HURACAN_PETICIONES% -c %HURACAN_CONCURRENCIA% -s 20 -k -H "Cookie: PHPSESSID=%SID%" "%EP_URL%" >"%EP_FILE%" 2>&1
set "AB_CODE=!errorlevel!"
if not "!AB_CODE!"=="0" (
    >>"%RESULT%" echo ERROR: ab devolvio codigo !AB_CODE!
    findstr /i /c:"No connection" /c:"Connection refused" /c:"apr_socket_connect" /c:"timed out" /c:"No se puede establecer" /c:"rechaz" "%EP_FILE%" >>"%RESULT%"
) else (
    findstr /i /c:"Complete requests" /c:"Failed requests" /c:"Non-2xx responses" /c:"Requests per second" /c:"Time per request" /c:"Transfer rate" "%EP_FILE%" >>"%RESULT%"
)
findstr /i /c:"No connection could be made" /c:"Connection refused" /c:"apr_socket_connect" /c:"timed out" /c:"No se puede establecer" /c:"rechaz" "%EP_FILE%" >nul
if not errorlevel 1 (
    >>"%RESULT%" echo ADVERTENCIA: SERVIDOR NO DISPONIBLE o conexion rechazada durante %EP_NAME%.
    >>"%RESULT%" echo Revise que Apache/XAMPP siga activo y que %BASE_URL% responda.
)
>>"%RESULT%" echo.
exit /b 0

:error_servidor
>>"%RESULT%" echo ERROR: SERVIDOR NO DISPONIBLE.
>>"%RESULT%" echo No se pudo conectar a %BASE_URL%.
>>"%RESULT%" echo Revise que Apache/XAMPP este iniciado y escuchando en el puerto configurado.
echo ERROR: servidor no disponible. Revise si Apache/XAMPP esta encendido.
echo Resultado: %RESULT%
if exist "%COOKIE%" del /q "%COOKIE%" >nul 2>&1
if exist "%LOGIN_JSON%" del /q "%LOGIN_JSON%" >nul 2>&1
exit /b 2

:error_credenciales
echo ERROR: faltan usuario o contrasena de prueba.
echo Usa: huracan_ab.bat USUARIO CONTRASENA
exit /b 1

:error_ab
echo ERROR: no se encontro ab.exe en "%AB_EXE%".
exit /b 1

:error_fecha
echo ERROR: no se pudo obtener la fecha para nombrar el resultado.
exit /b 1

:error_login
>>"%RESULT%" echo ERROR: no se pudo iniciar sesion. Revise credenciales, permisos, servidor o limitador.
echo ERROR: no se pudo iniciar sesion. Revise credenciales, permisos o el limitador.
if exist "%LOGIN_JSON%" type "%LOGIN_JSON%"
if exist "%COOKIE%" del /q "%COOKIE%" >nul 2>&1
if exist "%LOGIN_JSON%" del /q "%LOGIN_JSON%" >nul 2>&1
exit /b 1
