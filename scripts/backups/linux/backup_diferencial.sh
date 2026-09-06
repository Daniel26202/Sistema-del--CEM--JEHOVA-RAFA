#!/usr/bin/env bash
set -Eeuo pipefail
source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/backup_common.sh"

max_days="${BACKUP_FULL_MAX_DAYS:-7}"
full_file="$(find "$BACKUP_DIR" -maxdepth 1 -type f -name 'full_bd_*.sql' -printf '%f\n' | sort -r | head -n 1)"
if [[ -z "$full_file" ]]; then
    echo "No existe un respaldo completo. Ejecutando backup_completo.sh..."
    exec "$SCRIPT_DIR/backup_completo.sh"
fi

if [[ ! "$full_file" =~ ^full_bd_([0-9]{4}-[0-9]{2}-[0-9]{2}_[0-9]{2}-[0-9]{2}-[0-9]{2})\.sql$ ]]; then
    echo "ERROR: Nombre de respaldo completo invalido: $full_file" >&2
    exit 1
fi
full_stamp="${BASH_REMATCH[1]}"
full_date="${full_stamp:0:10} ${full_stamp:11:2}:${full_stamp:14:2}:${full_stamp:17:2}"
full_epoch="$(date -d "$full_date" +%s)"
if (( $(date +%s) - full_epoch > max_days * 86400 )); then
    echo "El respaldo completo tiene mas de $max_days dias. Ejecutando backup_completo.sh..."
    exec "$SCRIPT_DIR/backup_completo.sh"
fi

start_date="$full_date"
type="diff"
last_incremental="$(find "$BACKUP_DIR" -maxdepth 1 -type f \( -name 'diff_binlog_*.sql' -o -name 'diferencial_binlog_*.sql' -o -name 'inc_binlog_*.sql' -o -name 'incremental_binlog_*.sql' \) -printf '%f\n' | sort -r | head -n 1)"
if [[ -n "$last_incremental" && "$last_incremental" =~ _([0-9]{4}-[0-9]{2}-[0-9]{2}_[0-9]{2}-[0-9]{2}-[0-9]{2})\.sql$ ]]; then
    start_stamp="${BASH_REMATCH[1]}"
    start_date="${start_stamp:0:10} ${start_stamp:11:2}:${start_stamp:14:2}:${start_stamp:17:2}"
    start_date="$(date -d "$start_date + 1 second" '+%Y-%m-%d %H:%M:%S')"
    type="incremental"
fi

now_date="$(date '+%Y-%m-%d %H:%M:%S')"
timestamp="$(date '+%Y-%m-%d_%H-%M-%S')"
output="$BACKUP_DIR/${type}_binlog_${timestamp}.sql"
log_file="$BACKUP_DIR/backup_binlog_${timestamp}.log"
binlog_list="$BACKUP_DIR/binlog_list_${timestamp}.tmp"
master_status="$BACKUP_DIR/master_status_${timestamp}.tmp"
state_file="$BACKUP_DIR/binlog_state.txt"

{
    echo "Inicio: $now_date"
    echo "Respaldo completo base: $full_date"
    echo "Inicio de transacciones: $start_date"
    echo "Tipo: $type"
    echo "Carpeta binlog: $(binlog_dir)"
    echo "Salida: $output"
} >"$log_file"

if ! mysql_query 'SHOW BINARY LOGS;' >"$binlog_list" 2>>"$log_file"; then
    echo "ERROR: No fue posible obtener la lista de binlogs. Revise $log_file" >&2
    exit 1
fi
if ! mysql_query 'SHOW MASTER STATUS;' >"$master_status" 2>>"$log_file"; then
    echo "ERROR: No fue posible obtener la posicion actual del binlog. Revise $log_file" >&2
    exit 1
fi

current_file="$(awk 'NR == 1 {print $1}' "$master_status")"
current_position="$(awk 'NR == 1 {print $2}' "$master_status")"
if [[ -s "$state_file" && "$current_file $current_position" == "$(head -n 1 "$state_file")" ]]; then
    rm -f "$binlog_list" "$master_status"
    echo "No hay cambios nuevos desde el ultimo respaldo binlog."
    exit 0
fi

start_binlog=""
start_position=""
if [[ -s "$state_file" ]]; then
    read -r start_binlog start_position <"$state_file"
fi

binlog_path="$(binlog_dir)"
started=0
found=0
{
    echo "-- Backup diferencial generado desde $full_date"
    echo "-- Generado: $now_date"
    echo "-- Fuente: binlogs locales de MySQL"
    echo
} >"$output"

while read -r binlog_name _; do
    [[ -z "$binlog_name" ]] && continue
    process=1
    position_arg=()
    if [[ -n "$start_binlog" && "$started" -eq 0 ]]; then
        if [[ "$binlog_name" == "$start_binlog" ]]; then
            started=1
            position_arg=(--start-position="$start_position")
        else
            process=0
        fi
    fi
    [[ "$process" -eq 1 ]] || continue
    [[ -f "$binlog_path/$binlog_name" ]] || continue
    found=1
    echo "Procesando $binlog_name..."
    echo "Procesando $binlog_name" >>"$log_file"
    if [[ ${#position_arg[@]} -gt 0 ]]; then
        "$MYSQLBINLOG_EXE" "${position_arg[@]}" --stop-datetime="$now_date" "$binlog_path/$binlog_name" >>"$output" 2>>"$log_file"
    elif [[ -n "$start_binlog" ]]; then
        "$MYSQLBINLOG_EXE" --stop-datetime="$now_date" "$binlog_path/$binlog_name" >>"$output" 2>>"$log_file"
    else
        "$MYSQLBINLOG_EXE" --start-datetime="$start_date" --stop-datetime="$now_date" "$binlog_path/$binlog_name" >>"$output" 2>>"$log_file"
    fi
done <"$binlog_list"

if [[ -n "$start_binlog" && "$started" -eq 0 ]]; then
    echo "ERROR: No se encontro $start_binlog en la lista de binlogs." >&2
    exit 1
fi
if [[ "$found" -eq 0 ]]; then
    echo "ERROR: No se encontraron archivos binlog utilizables en $binlog_path." >&2
    exit 1
fi

printf '%s %s\n' "$current_file" "$current_position" >"$state_file"
rm -f "$binlog_list" "$master_status"
echo "Fin: $(date '+%Y-%m-%d %H:%M:%S')" >>"$log_file"
echo "Respaldo diferencial generado:"
echo "$output"
echo "Registro:"
echo "$log_file"
