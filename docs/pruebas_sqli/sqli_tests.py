#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Batería de pruebas de INYECCIÓN SQL (OWASP WSTG-INPV-05)
Sistema de gestión — Centro de Especialidades Médicas "Jehová Rafa".

Solo ejecuta payloads NO destructivos (boolean, union, error y time-based).
Guarda el resultado en JSON para el informe y muestra un log de terminal.
"""
import json, re, sys, time, urllib.parse, urllib.request, http.cookiejar
from datetime import datetime

BASE = "http://localhost/Sistema-del--CEM--JEHOVA-RAFA"
LOGIN = BASE + "/IniciarSesion/iniciarSesion?l=1"
OUT_JSON = __import__("os").path.join(__import__("os").path.dirname(__import__("os").path.abspath(__file__)), "sqli_resultados.json")

ERROR_MARKERS = [
    "sqlstate", "syntax error", "you have an error in your sql", "pdoexception",
    "mysqli_sql_exception", "warning: mysql", "uncaught exception", "fatal error",
    "unknown column", "near \"", "check the manual that corresponds",
]
PAUSE = 0.35


class NoRedirect(urllib.request.HTTPRedirectHandler):
    def redirect_request(self, req, fp, code, msg, headers, newurl):
        return None


class Client:
    def __init__(self):
        self.cookie = None
        self.opener = urllib.request.build_opener(NoRedirect())

    def _capture(self, headers):
        for sc in headers.get_all("Set-Cookie") or []:
            m = re.match(r"PHPSESSID=([^;]+)", sc)
            if m:
                self.cookie = "PHPSESSID=" + m.group(1)

    def req(self, url, method="GET", data=None, headers=None):
        body = None
        hdrs = {"User-Agent": "QA-SQLi/1.0 (OWASP-WSTG)"}
        if self.cookie:
            hdrs["Cookie"] = self.cookie
        if headers:
            hdrs.update(headers)
        if data is not None:
            if isinstance(data, dict):
                body = urllib.parse.urlencode(data).encode()
                hdrs.setdefault("Content-Type", "application/x-www-form-urlencoded")
            else:
                body = data
        request = urllib.request.Request(url, data=body, headers=hdrs, method=method)
        t0 = time.perf_counter()
        status = 0
        text = ""
        try:
            with self.opener.open(request, timeout=25) as resp:
                status = resp.status
                self._capture(resp.headers)
                text = resp.read().decode("utf-8", "replace")
        except urllib.error.HTTPError as e:
            status = e.code
            self._capture(e.headers)
            try:
                text = e.read().decode("utf-8", "replace")
            except Exception:
                text = ""
        except Exception as e:
            text = "ERROR_CLIENTE: " + str(e)
        return status, text, time.perf_counter() - t0


def jget(txt, key, default=None):
    try:
        return json.loads(txt).get(key, default)
    except Exception:
        return default


def has_error(txt):
    low = txt.lower()
    return [m for m in ERROR_MARKERS if m in low]


def etiqueta(status, vuln):
    if vuln:
        return "VULNERABLE"
    if status == 409:
        return "bloqueado (409)"
    if status == 500:
        return "bloqueado (500)"
    if status >= 400:
        return "rechazado (%s)" % status
    return "sin inyección"


def datatable_url(path, value):
    q = urllib.parse.urlencode({
        "draw": 1, "start": 0, "length": 5,
        "search[value]": value,
        "order[0][column]": 0, "order[0][dir]": "asc",
    })
    return "%s/%s?%s" % (BASE, path, q)


def run():
    cli = Client()
    resultados = []
    inicio = datetime.now()

    print("=" * 86)
    print("  PRUEBAS DE INYECCIÓN SQL — SISTEMA CEM JEHOVA RAFA")
    print("  Fecha: %s" % inicio.strftime("%Y-%m-%d %H:%M:%S"))
    print("  Entorno: %s" % BASE)
    print("  Método: OWASP WSTG-INPV-05 · Payloads no destructivos")
    print("  Herramienta: Python 3 (urllib + cookie jar) · MariaDB/MySQL")
    print("=" * 86)
    print()

    # ------------------------------------------------------------------ login
    time.sleep(PAUSE)
    st, tx, el = cli.req(LOGIN, "POST", {"username": "WDaniel123", "password": "Sistema.30"})
    login_ok = st == 200 and jget(tx, "ok") is True
    print("[PRE] Autenticación con credenciales válidas .......... HTTP %s | ok=%s | %.2fs"
          % (st, jget(tx, "ok"), el))
    if not login_ok:
        print("  ERROR: no fue posible autenticarse; se aborta la batería autenticada.")
        print(tx[:300])
        return resultados
    print()

    # Cada entrada: id, módulo, tipo, url/base, método, campo
    search_targets = [
        ("SQL-03", "Usuarios", "Usuarios/usuariosAjax"),
        ("SQL-04", "Pacientes", "Pacientes/getPacientesAjax"),
        ("SQL-05", "Clientes", "Clientes/clientesAjax"),
        ("SQL-06", "Servicios médicos", "Servicios/serviciosAjax"),
        ("SQL-07", "Doctores", "Doctores/DoctoresAjax"),
        ("SQL-08", "Proveedores", "Proveedores/proveedoresAjax"),
        ("SQL-09", "Patologías", "Patologias/patologiasAjax"),
        ("SQL-10", "Insumos", "Insumos/insumosAjax"),
        ("SQL-11", "Bitácora", "Bitacora/bitacoraAjaxAdmin"),
    ]
    payloads = [
        ("'/**/OR/**/'1'='1", "boolean"),
        ("zzz'/**/UNION/**/SELECT/**/NULL#", "union"),
        ("zzz'/**/AND/**/updatexml(1,concat(0x7e,version()),1)#", "error"),
        ("zzz'/**/OR/**/SLEEP(0.5)#", "time-based"),
    ]

    # ------------------------------------------------------------------ login payloads
    login_payloads = [
        ("' OR '1'='1", "boolean"),
        ("admin'-- -", "comentario"),
        ("' OR 1=1#", "comentario"),
        ("x' OR SLEEP(2)-- -", "time-based"),
    ]
    print("[SQL-01] Autenticación — inyección en el campo USUARIO")
    for p, kind in login_payloads:
        time.sleep(PAUSE)
        st, tx, el = cli.req(LOGIN, "POST", {"username": p, "password": "x"})
        ok = jget(tx, "ok")
        vuln = (ok is True) or (kind == "time-based" and el >= 1.8) or bool(has_error(tx))
        print("  Payload: %-32s | HTTP %s | ok=%-5s | %.2fs | %s"
              % (p[:32], st, ok, el, etiqueta(st, vuln)))
        resultados.append({"id": "SQL-01", "modulo": "Inicio de sesión (usuario)",
                           "tipo": kind, "payload": p, "http": st, "tiempo": round(el, 3),
                           "vulnerable": bool(vuln), "respuesta": tx[:400]})
    print("  VEREDICTO: %s\n" % ("VULNERABLE" if any(r["vulnerable"] for r in resultados) else "SEGURO"))

    print("[SQL-02] Autenticación — inyección en el campo CONTRASEÑA")
    start = len(resultados)
    for p, kind in login_payloads[:3] + [("x' OR SLEEP(2)-- -", "time-based")]:
        time.sleep(PAUSE)
        st, tx, el = cli.req(LOGIN, "POST", {"username": "WDaniel123", "password": p})
        ok = jget(tx, "ok")
        vuln = (ok is True) or (kind == "time-based" and el >= 1.8) or bool(has_error(tx))
        print("  Payload: %-32s | HTTP %s | ok=%-5s | %.2fs | %s"
              % (p[:32], st, ok, el, etiqueta(st, vuln)))
        resultados.append({"id": "SQL-02", "modulo": "Inicio de sesión (contraseña)",
                           "tipo": kind, "payload": p, "http": st, "tiempo": round(el, 3),
                           "vulnerable": bool(vuln), "respuesta": tx[:400]})
    print("  VEREDICTO: %s\n" % ("VULNERABLE" if any(r["vulnerable"] for r in resultados[start:]) else "SEGURO"))

    # ------------------------------------------------------------------ búsquedas
    for sid, modulo, ruta in search_targets:
        print("[%s] %s — inyección en el filtro de búsqueda (search[value])" % (sid, modulo))
        time.sleep(PAUSE)
        bst, btx, bel = cli.req(datatable_url(ruta, "zzz_no_existe_zzz"))
        base = jget(btx, "recordsFiltered", -1)
        print("  Baseline: 'zzz_no_existe_zzz' -> HTTP %s | registros=%s | %.2fs" % (bst, base, bel))
        start = len(resultados)
        for p, kind in payloads:
            time.sleep(PAUSE)
            st, tx, el = cli.req(datatable_url(ruta, p))
            filt = jget(tx, "recordsFiltered", -1)
            err = has_error(tx)
            vuln = bool(err) or (isinstance(filt, int) and filt > 0) or el >= 1.5
            print("  Payload: %-42s | HTTP %s | reg=%-4s | %.2fs | %s"
                  % (p[:42], st, filt, el, etiqueta(st, vuln)))
            resultados.append({"id": sid, "modulo": modulo, "tipo": kind, "payload": p,
                               "http": st, "registros": filt, "tiempo": round(el, 3),
                               "vulnerable": bool(vuln), "respuesta": tx[:400]})
        print("  VEREDICTO: %s\n" % ("VULNERABLE" if any(r["vulnerable"] for r in resultados[start:]) else "SEGURO"))

    # ------------------------------------------------------------------ parámetros directos
    directos = [
        ("SQL-12", "Citas — consulta de paciente por cédula", "path",
         BASE + "/Citas/mostrarDataPaciente/V/%s", "1414141", "1414141'OR'1'='1'#"),
        ("SQL-13", "Reportes — pago de factura por ID (path)", "path",
         BASE + "/Reportes/buscarPago/%s", "61", "61'OR'1'='1'#"),
        ("SQL-14", "Reportes — cita de factura por ID (GET)", "get",
         BASE + "/Reportes/buscarCita?id_factura=%s", "61", "61'OR'1'='1'#"),
        ("SQL-15", "Estadísticas — filtro de fechas (path)", "path",
         BASE + "/Estadisticas/filtrar_tasaMorbilidad/%s/2025-12-31", "2025-01-01", "2025-01-01'OR'1'='1"),
    ]
    for sid, modulo, kind_url, tmpl, benigno, payload in directos:
        print("[%s] %s" % (sid, modulo))
        time.sleep(PAUSE)
        bst, btx, bel = cli.req(tmpl % urllib.parse.quote(benigno, safe=""))
        print("  Baseline: %-22s -> HTTP %s | %d bytes | %.2fs" % (benigno, bst, len(btx), bel))
        start = len(resultados)
        if sid == "SQL-15":
            variantes = [payload,
                         "2025-01-01'AND(SLEEP(2))AND'1'='1",
                         "2025-01-01'AND(updatexml(1,concat(0x7e,version()),1))AND'1'='1"]
        else:
            variantes = [payload, "1'AND(SLEEP(2))#",
                         "1'AND(updatexml(1,concat(0x7e,version()),1))#"]
        for p in variantes:
            time.sleep(PAUSE)
            st, tx, el = cli.req(tmpl % urllib.parse.quote(p, safe=""))
            err = has_error(tx)
            timev = el >= 1.8
            # Respuesta con datos clínicos/factura cuando el payload debería anular la consulta
            leak = ("cedula" in tx.lower() or "id_factura" in tx.lower() or "total" in tx.lower()) and len(tx) > 40
            vuln = bool(err) or timev or (p == payload and leak)
            print("  Payload: %-42s | HTTP %s | %d bytes | %.2fs | %s"
                  % (p[:42], st, len(tx), el, etiqueta(st, vuln)))
            resultados.append({"id": sid, "modulo": modulo, "tipo": kind_url, "payload": p,
                               "http": st, "tiempo": round(el, 3), "vulnerable": bool(vuln),
                               "respuesta": tx[:400]})
        print("  VEREDICTO: %s\n" % ("VULNERABLE" if any(r["vulnerable"] for r in resultados[start:]) else "SEGURO"))

    # ------------------------------------------------------------------ recuperación (CSRF)
    print("[SQL-16] Recuperación de contraseña — usuario y correo")
    time.sleep(PAUSE)
    st, tx, _ = cli.req(BASE + "/RecuperarContr/mostrarRecuperarContr")
    m = re.search(r'name="csrf-token"\s+content="([^"]+)"', tx)
    token = m.group(1) if m else ""
    print("  Token CSRF obtenido: %s" % ("sí" if token else "no"))
    if token:
        start = len(resultados)
        for p, kind in [("' OR '1'='1", "boolean"), ("admin'-- -", "comentario"),
                        ("x' OR SLEEP(2)-- -", "time-based")]:
            time.sleep(PAUSE)
            st, tx, el = cli.req(BASE + "/RecuperarContr/verificarUC?l=1", "POST",
                                 {"usuario": p, "correo": "x@x.com", "csrf_token": token},
                                 {"X-CSRF-Token": token})
            err = has_error(tx)
            timev = el >= 1.8
            vuln = bool(err) or timev or "conexionFallida" in tx or texito_ok(tx)
            print("  Payload: %-32s | HTTP %s | %.2fs | %s | resp=%s"
                  % (p[:32], st, el, etiqueta(st, vuln), tx[:40].replace("\n", " ")))
            resultados.append({"id": "SQL-16", "modulo": "Recuperación de contraseña",
                               "tipo": kind, "payload": p, "http": st, "tiempo": round(el, 3),
                               "vulnerable": bool(vuln), "respuesta": tx[:400]})
        print("  VEREDICTO: %s\n" % ("VULNERABLE" if any(r["vulnerable"] for r in resultados[start:]) else "SEGURO"))
    else:
        print("  No se pudo obtener el token CSRF; prueba no ejecutada.\n")

    # ------------------------------------------------------------------ resumen
    total = len(resultados)
    vulns = [x for x in resultados if x["vulnerable"]]
    print("=" * 86)
    print("  RESUMEN DE EJECUCIÓN")
    print("  Pruebas ejecutadas : %d" % total)
    print("  Pruebas contenidas : %d" % (total - len(vulns)))
    print("  Vulnerabilidades   : %d" % len(vulns))
    print("  Resultado global   : %s" % ("FALLO — revisar hallazgos" if vulns else "APROBADO — sin inyección SQL"))
    print("=" * 86)

    json.dump({"inicio": inicio.isoformat(), "base": BASE, "total": total,
               "vulnerabilidades": len(vulns), "resultados": resultados},
              open(OUT_JSON, "w", encoding="utf-8"), ensure_ascii=False, indent=2)
    print("\nResultados guardados en %s" % OUT_JSON)
    return resultados


def texito_ok(tx):
    try:
        v = json.loads(tx)
        return isinstance(v, dict) and v.get("ok") is True
    except Exception:
        return False


if __name__ == "__main__":
    run()
