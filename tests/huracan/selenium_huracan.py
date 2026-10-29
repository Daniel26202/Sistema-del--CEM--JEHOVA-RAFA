#!/usr/bin/env python3
"""Selenium: ciclos repetidos de alta y baja lógica de proveedores.

Uso desde la raíz del proyecto:
  $env:HURACAN_TEST_USER='cuenta de pruebas'
  $env:HURACAN_TEST_PASSWORD='contraseña de pruebas'
  $env:HURACAN_CONFIRMAR_ESCRITURAS='SI'
  python tests/huracan/selenium_huracan.py

Solo permite DB_HOST local y DB_NAME=bd. Los proveedores creados llevan RIF
aleatorio y se purgan al finalizar; sus eventos de bitácora se conservan.
"""

from __future__ import annotations

import csv
import os
import random
import re
import subprocess
import time
from datetime import datetime
from pathlib import Path

from selenium import webdriver
from selenium.common.exceptions import TimeoutException, WebDriverException
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import WebDriverWait


ROOT = Path(__file__).resolve().parents[2]
ENV_FILE = ROOT / ".env"
RESULTS_DIR = Path(__file__).resolve().parent / "resultados"
BASE_URL = os.environ.get(
    "HURACAN_BASE_URL", "http://localhost/Sistema-del--CEM--JEHOVA-RAFA/"
).rstrip("/") + "/"
PROVIDERS_URL = BASE_URL + "Proveedores/proveedores"
TRASH_URL = BASE_URL + "Proveedores/papelera"


def load_env(path: Path) -> dict[str, str]:
    values: dict[str, str] = {}
    for raw in path.read_text(encoding="utf-8-sig").splitlines():
        line = raw.strip()
        if not line or line.startswith("#") or "=" not in line:
            continue
        key, value = line.split("=", 1)
        value = value.strip()
        if len(value) >= 2 and value[0] == value[-1] and value[0] in "\"'":
            value = value[1:-1]
        values[key.strip()] = value
    return values


def mysql_executable(env: dict[str, str]) -> str:
    configured = env.get("MYSQL_EXE", "").strip().strip('"')
    if configured:
        return configured.replace("/", "\\")
    binary_dir = env.get("XAMPP_MYSQL_BIN", r"C:\xampp\mysql\bin").strip('"')
    return str(Path(binary_dir.replace("/", "\\")) / "mysql.exe")


def mysql_query(env: dict[str, str], sql: str) -> subprocess.CompletedProcess:
    args = [
        mysql_executable(env),
        "-h", env["DB_HOST"],
        "-u", env["DB_USER"],
        env["DB_NAME"],
        "--batch", "--skip-column-names", "-e", sql,
    ]
    process_env = os.environ.copy()
    process_env["MYSQL_PWD"] = env.get("DB_PASS", "")
    return subprocess.run(args, capture_output=True, text=True, env=process_env, timeout=30)


def check_write_safety(env: dict[str, str]) -> None:
    if os.environ.get("HURACAN_CONFIRMAR_ESCRITURAS") != "SI":
        raise RuntimeError("Define HURACAN_CONFIRMAR_ESCRITURAS=SI para autorizar el flujo de escritura.")
    if env.get("DB_HOST", "").lower() not in {"localhost", "127.0.0.1", "::1"}:
        raise RuntimeError("Bloqueado: este runner solo permite DB_HOST local; no ejecuta contra producción.")
    if env.get("DB_NAME") != "bd":
        raise RuntimeError("Bloqueado: se esperaba DB_NAME=bd en el entorno local de pruebas.")
    ping = mysql_query(env, "SELECT DATABASE();")
    if ping.returncode != 0 or ping.stdout.strip() != "bd":
        raise RuntimeError("No se pudo confirmar la conexión local a bd; no se iniciaron escrituras.")


def wait_ready(driver, timeout: int = 20) -> None:
    WebDriverWait(driver, timeout).until(
        lambda browser: browser.execute_script("return document.readyState") == "complete"
    )


def close_swal(driver, timeout: int = 15) -> str:
    WebDriverWait(driver, timeout).until(
        EC.visibility_of_element_located((By.CSS_SELECTOR, ".swal2-popup"))
    )
    message = driver.find_element(By.CSS_SELECTOR, ".swal2-popup").text
    buttons = driver.find_elements(By.CSS_SELECTOR, ".swal2-confirm")
    if buttons:
        buttons[0].click()
        try:
            WebDriverWait(driver, timeout).until(
                EC.invisibility_of_element_located((By.CSS_SELECTOR, ".swal2-popup"))
            )
        except TimeoutException:
            pass
    return message


def login(driver, username: str, password: str) -> None:
    driver.get(BASE_URL)
    wait_ready(driver)
    driver.find_element(By.NAME, "username").send_keys(username)
    driver.find_element(By.NAME, "password").send_keys(password)
    driver.find_element(By.ID, "btnLoginEnviar").click()
    wait = WebDriverWait(driver, 20)
    wait.until(
        lambda browser: "/Inicio/inicio" in browser.current_url
        or bool(browser.find_elements(By.CSS_SELECTOR, ".swal2-popup"))
    )

    if "/Inicio/inicio" in driver.current_url:
        return

    popup_text = close_swal(driver)
    if "sesión activa" not in popup_text.lower() and "sesion activa" not in popup_text.lower():
        raise RuntimeError("Login rechazado; revisa cuenta, permiso o mensaje de la aplicación.")

    # El cierre de la sesión anterior puede abrir una segunda alerta de éxito.
    try:
        WebDriverWait(driver, 5).until(
            EC.visibility_of_element_located((By.CSS_SELECTOR, ".swal2-popup"))
        )
        close_swal(driver, timeout=5)
    except TimeoutException:
        pass

    # Si el test dejó una sesión activa, la aplicación pregunta si debe cerrarla.
    driver.find_element(By.NAME, "username").clear()
    driver.find_element(By.NAME, "username").send_keys(username)
    driver.find_element(By.NAME, "password").clear()
    driver.find_element(By.NAME, "password").send_keys(password)
    driver.find_element(By.ID, "btnLoginEnviar").click()
    wait.until(lambda browser: "/Inicio/inicio" in browser.current_url)


def wait_table(driver) -> None:
    WebDriverWait(driver, 20).until(
        EC.presence_of_element_located((By.CSS_SELECTOR, "table.exampleTable tbody"))
    )
    time.sleep(0.3)


def search_table(driver, rif: str) -> None:
    candidates = [
        ".dataTables_filter input[type='search']",
        ".dt-search input[type='search']",
        "input[type='search']",
    ]
    search = None
    for selector in candidates:
        visible = [element for element in driver.find_elements(By.CSS_SELECTOR, selector) if element.is_displayed()]
        if visible:
            search = visible[0]
            break
    if search is None:
        raise RuntimeError("No se encontró el buscador de la tabla.")
    search.clear()
    search.send_keys(rif)


def find_row(driver, rif: str, exists: bool, timeout: int = 15) -> bool:
    def condition(browser):
        rows = browser.find_elements(By.CSS_SELECTOR, "table.exampleTable tbody tr")
        found = any(rif in row.text for row in rows)
        return found if exists else not found
    WebDriverWait(driver, timeout).until(condition)
    return True


def create_provider(driver, rif: str, email: str) -> None:
    driver.find_element(By.ID, "btnOpenModalProveedor").click()
    WebDriverWait(driver, 10).until(
        EC.visibility_of_element_located((By.ID, "exampleModalProveedor"))
    )
    fields = {
        "nombre": "Huracan",
        "rif": rif,
        "telefono": "04121338909",
        "correo": email,
        "direccion": "Direccion prueba HUR",
    }
    for name, value in fields.items():
        field = driver.find_element(By.CSS_SELECTOR, f"#formProveedor [name='{name}']")
        field.clear()
        field.send_keys(value)
    driver.find_element(By.ID, "botonModalProveedor").click()
    message = close_swal(driver)
    if "éxito" not in message.lower() and "exito" not in message.lower():
        raise RuntimeError("El formulario no confirmó el registro: " + message[:240])


def unique_test_rif(env: dict[str, str]) -> str:
    for _ in range(50):
        rif = f"V-{random.randint(10_000_000, 99_999_999)}"
        check = mysql_query(env, f"SELECT COUNT(*) FROM proveedor WHERE rif='{rif}'")
        if check.returncode != 0:
            raise RuntimeError("No se pudo comprobar la unicidad del RIF sintético.")
        if check.stdout.strip() == "0":
            return rif
    raise RuntimeError("No se encontró un RIF disponible tras 50 intentos.")


def delete_provider_logically(driver, rif: str) -> None:
    rows = driver.find_elements(By.CSS_SELECTOR, "table.exampleTable tbody tr")
    target = next((row for row in rows if rif in row.text), None)
    if target is None:
        raise RuntimeError("No apareció el proveedor recién creado en el listado activo.")
    target.find_element(By.CSS_SELECTOR, ".btn-eliminar").click()
    confirmation = close_swal(driver)
    if "seguro" not in confirmation.lower():
        raise RuntimeError("No se mostró la confirmación de eliminación lógica.")
    result = close_swal(driver)
    if "éxito" not in result.lower() and "exito" not in result.lower():
        raise RuntimeError("La baja lógica no confirmó éxito: " + result[:240])
    search_table(driver, rif)
    find_row(driver, rif, exists=False)


def verify_trash(driver, rif: str) -> None:
    driver.get(TRASH_URL)
    wait_ready(driver)
    wait_table(driver)
    search_table(driver, rif)
    find_row(driver, rif, exists=True)


def clean_test_providers(env: dict[str, str], rifs: list[str]) -> tuple[bool, str]:
    if not rifs:
        return True, "Sin proveedores creados."
    # RIFs se generan internamente con caracteres V- y dígitos solamente.
    rif_sql = ",".join("'" + value + "'" for value in rifs)
    sql = f"DELETE FROM proveedor WHERE rif IN ({rif_sql}); SELECT COUNT(*) FROM proveedor WHERE rif IN ({rif_sql});"
    result = mysql_query(env, sql)
    if result.returncode != 0:
        return False, (result.stderr or result.stdout).strip()[:400]
    lines = [line.strip() for line in result.stdout.splitlines() if line.strip()]
    remaining = lines[-1] if lines else "?"
    if remaining != "0":
        return False, f"Quedaron {remaining} filas proveedor de prueba."
    return True, f"Se eliminaron físicamente {len(rifs)} proveedores HUR creados por el runner."


def run_cycles(driver, writer, output_file, env: dict[str, str], run_id: str, case_id: str, cycles: int, delay: float, all_rifs: list[str]) -> tuple[int, int]:
    passed = 0
    failed = 0
    for cycle in range(1, cycles + 1):
        rif = unique_test_rif(env)
        email = f"h{run_id[-6:]}{case_id[-2:]}{cycle:02d}@e.co"
        all_rifs.append(rif)
        started = time.perf_counter()
        result = "PASÓ"
        detail = "Registro visible, baja lógica completada y registro hallado en papelera."
        try:
            driver.get(PROVIDERS_URL)
            wait_ready(driver)
            wait_table(driver)
            create_provider(driver, rif, email)
            search_table(driver, rif)
            find_row(driver, rif, exists=True)
            delete_provider_logically(driver, rif)
            verify_trash(driver, rif)
            passed += 1
        except Exception as error:
            result = "FALLÓ"
            detail = f"{type(error).__name__}: {str(error)[:350]}"
            failed += 1
            try:
                driver.save_screenshot(str(RESULTS_DIR / f"{run_id}_{case_id.lower()}_{cycle:03d}_error.png"))
            except WebDriverException:
                pass

        elapsed = round((time.perf_counter() - started) * 1000, 2)
        writer.writerow([run_id, case_id, cycle, rif, result, elapsed, detail])
        output_file.flush()
        time.sleep(delay)
    return passed, failed


def main() -> int:
    if not ENV_FILE.is_file():
        raise SystemExit(f"No existe .env en {ROOT}")
    env = load_env(ENV_FILE)
    try:
        check_write_safety(env)
    except RuntimeError as error:
        raise SystemExit(str(error)) from error

    username = os.environ.get("HURACAN_TEST_USER", "")
    password = os.environ.get("HURACAN_TEST_PASSWORD", "")
    if not username or not password:
        raise SystemExit("Define HURACAN_TEST_USER y HURACAN_TEST_PASSWORD (no se guardan ni imprimen).")

    normal_cycles = int(os.environ.get("HURACAN_CICLOS_NORMAL", "10"))
    extended_cycles = int(os.environ.get("HURACAN_CICLOS_EXTENDIDO", "20"))
    if normal_cycles < 1 or extended_cycles < 1:
        raise SystemExit("Los ciclos deben ser al menos 1.")

    RESULTS_DIR.mkdir(parents=True, exist_ok=True)
    run_id = datetime.now().strftime("%Y%m%d_%H%M%S")
    csv_path = RESULTS_DIR / f"HUR_{run_id}.csv"
    summary_path = RESULTS_DIR / f"HUR_{run_id}.txt"
    generated_rifs: list[str] = []
    results = {}

    options = Options()
    options.add_argument("--headless=new")
    options.add_argument("--window-size=1366,900")
    options.add_argument("--disable-gpu")
    driver = webdriver.Chrome(options=options)
    driver.set_page_load_timeout(30)
    cleanup_status = (False, "No se realizó limpieza todavía.")
    try:
        login(driver, username, password)
        with csv_path.open("w", newline="", encoding="utf-8-sig") as output:
            writer = csv.writer(output)
            writer.writerow(["ejecucion", "caso", "ciclo", "rif_sintetico", "resultado", "duracion_ms", "detalle"])
            results["HUR-01"] = run_cycles(driver, writer, output, env, run_id, "HUR-01", normal_cycles, 0.8, generated_rifs)
            results["HUR-02"] = run_cycles(driver, writer, output, env, run_id, "HUR-02", extended_cycles, 0.2, generated_rifs)
    finally:
        # Se cierra la sesión automatizada sin dejarla activa en el sistema.
        try:
            driver.get(BASE_URL + "Inicio/cerrarSession?huracan=1")
            time.sleep(0.2)
        except WebDriverException:
            pass
        driver.quit()
        cleanup_status = clean_test_providers(env, generated_rifs)

    with summary_path.open("w", encoding="utf-8") as summary:
        summary.write(f"Ejecución HUR: {run_id}\n")
        summary.write(f"Entorno: {BASE_URL}\n")
        summary.write(f"Base configurada: localhost/{env['DB_NAME']}\n")
        summary.write("Operación: alta, consulta y baja lógica repetidas de proveedores sintéticos.\n")
        for case_id, (passed, failed) in results.items():
            summary.write(f"{case_id}: {passed} ciclos pasaron; {failed} fallaron.\n")
        summary.write(f"Limpieza de proveedores: {'OK' if cleanup_status[0] else 'PENDIENTE'} — {cleanup_status[1]}\n")
        summary.write("Los eventos de bitácora de la aplicación se conservan como auditoría.\n")
        summary.write(f"CSV detallado: {csv_path}\n")

    print(f"CSV: {csv_path}")
    print(f"Resumen: {summary_path}")
    print(f"Limpieza proveedores: {'OK' if cleanup_status[0] else 'PENDIENTE'}")
    for case_id, (passed, failed) in results.items():
        print(f"{case_id}: {passed} pasaron; {failed} fallaron")
    return 0 if cleanup_status[0] and all(failed == 0 for _, failed in results.values()) else 1


if __name__ == "__main__":
    raise SystemExit(main())
