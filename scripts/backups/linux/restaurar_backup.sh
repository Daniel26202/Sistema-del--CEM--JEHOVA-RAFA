#!/usr/bin/env bash
set -Eeuo pipefail
source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/backup_common.sh"

full_file="$(find "$BACKUP_DIR" -maxdepth 1 -type f -name 'full_bd_*.sql' -printf '%f\n' | sort -r | head -n 1)"
if [[ -z "$full_file" || ! "$full_file" =~ ^full_bd_([0-9]{4}-[0-9]{2}-[0-9]{2}_[0-9]{2}-[0-9]{2}-[0-9]{2})\.sql$ ]]; then
    echo "ERROR: No se encontro un respaldo completo valido." >&2
    exit 1
fi
full_stamp="${BASH_REMATCH[1]}"
security_file="$BACKUP_DIR/full_bdseguri_${full_stamp}.sql"
full_path="$BACKUP_DIR/$full_file"
if [[ ! -f "$security_file" ]]; then
    echo "ERROR: Falta el respaldo de seguridad: $security_file" >&2
    exit 1
fi

echo "Se restaurara:"
echo "$security_file"
echo "$full_path"
echo "y todos los diferenciales posteriores a $full_stamp"
read -r -p 'ATENCION: este proceso sobrescribira las bases. Continuar? [s/N] ' answer
[[ "$answer" =~ ^[sS]$ ]] || exit 0

restore_log="$BACKUP_DIR/restore_${full_stamp}.log"
{
    echo "Inicio de restauracion: $(date '+%Y-%m-%d %H:%M:%S')"
    echo "Respaldo completo: $full_stamp"
} >"$restore_log"

echo "Restaurando $DB_NAME_SEGURITY..."
"$MYSQL_EXE" "${MYSQL_ARGS[@]}" "$DB_NAME_SEGURITY" <"$security_file" >>"$restore_log" 2>&1
echo "Restaurando $DB_NAME..."
"$MYSQL_EXE" "${MYSQL_ARGS[@]}" "$DB_NAME" <"$full_path" >>"$restore_log" 2>&1

mapfile -t incremental_files < <(find "$BACKUP_DIR" -maxdepth 1 -type f \( -name 'diff_binlog_*.sql' -o -name 'diferencial_binlog_*.sql' -o -name 'inc_binlog_*.sql' -o -name 'incremental_binlog_*.sql' \) -printf '%f\n' | sort)
for file in "${incremental_files[@]}"; do
    if [[ "$file" =~ _([0-9]{4}-[0-9]{2}-[0-9]{2}_[0-9]{2}-[0-9]{2}-[0-9]{2})\.sql$ ]]; then
        file_stamp="${BASH_REMATCH[1]}"
        [[ "$file_stamp" > "$full_stamp" ]] || continue
    else
        continue
    fi
    path="$BACKUP_DIR/$file"
    echo "Aplicando $file..."
    echo "Aplicando $file" >>"$restore_log"
    temporary="$(mktemp)"
    grep -v 'check_constraint_checks' "$path" >"$temporary"
    "$MYSQL_EXE" "${MYSQL_ARGS[@]}" <"$temporary" >>"$restore_log" 2>&1
    rm -f "$temporary"
done

echo "Restauracion completada correctamente. Registro: $restore_log"
