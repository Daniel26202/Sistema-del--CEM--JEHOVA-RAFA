#!/usr/bin/env bash
set -Eeuo pipefail
source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/backup_common.sh"

timestamp="$(date '+%Y-%m-%d_%H-%M-%S')"
sql_sistema="$BACKUP_DIR/full_bd_${timestamp}.sql"
sql_seguridad="$BACKUP_DIR/full_bdseguri_${timestamp}.sql"
error_sistema="$BACKUP_DIR/full_bd_${timestamp}.error.log"
error_seguridad="$BACKUP_DIR/full_bdseguri_${timestamp}.error.log"
state_temp="$BACKUP_DIR/master_status_${timestamp}.tmp"
state_file="$BACKUP_DIR/binlog_state.txt"

echo "Generando respaldo de $DB_NAME..."
if ! "$MYSQLDUMP_EXE" "${MYSQL_ARGS[@]}" --flush-logs --single-transaction --master-data=2 --routines --triggers --events "$DB_NAME" >"$sql_sistema" 2>"$error_sistema"; then
    echo "ERROR: Fallo mysqldump para $DB_NAME. Revise $error_sistema" >&2
    exit 1
fi

echo "Generando respaldo de $DB_NAME_SEGURITY..."
if ! "$MYSQLDUMP_EXE" "${MYSQL_ARGS[@]}" --single-transaction --routines --triggers --events "$DB_NAME_SEGURITY" >"$sql_seguridad" 2>"$error_seguridad"; then
    echo "ERROR: Fallo mysqldump para $DB_NAME_SEGURITY. Revise $error_seguridad" >&2
    exit 1
fi

if [[ ! -s "$sql_sistema" || ! -s "$sql_seguridad" ]]; then
    echo "ERROR: Se genero un SQL vacio." >&2
    exit 1
fi

if ! mysql_query 'SHOW MASTER STATUS;' >"$state_temp"; then
    echo "ERROR: El respaldo se genero, pero no se pudo guardar la posicion del binlog." >&2
    exit 1
fi
awk 'NR == 1 {print $1, $2}' "$state_temp" >"$state_file"
rm -f "$state_temp" "$error_sistema" "$error_seguridad"

echo "Respaldo completo generado correctamente:"
echo "$sql_sistema"
echo "$sql_seguridad"
