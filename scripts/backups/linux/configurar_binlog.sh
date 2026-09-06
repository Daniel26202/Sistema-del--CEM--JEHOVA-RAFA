#!/usr/bin/env bash
set -Eeuo pipefail
source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/backup_common.sh"

config_file="${MYSQL_CONFIG_FILE_LINUX:-}"
if [[ -z "$config_file" ]]; then
    for candidate in /etc/mysql/mysql.conf.d/mysqld.cnf /etc/mysql/my.cnf /etc/my.cnf; do
        if [[ -f "$candidate" ]]; then
            config_file="$candidate"
            break
        fi
    done
fi
if [[ -z "$config_file" || ! -f "$config_file" ]]; then
    echo "ERROR: No se encontro MYSQL_CONFIG_FILE_LINUX ni una configuracion MySQL conocida." >&2
    exit 1
fi

prefix="${MYSQL_BINLOG_PREFIX:-mysql-bin}"
backup_file="${config_file}.backup.$(date '+%Y%m%d_%H%M%S')"
echo "Configuracion: $config_file"
echo "Copia: $backup_file"
sudo cp "$config_file" "$backup_file"

if grep -Eiq '^[[:space:]]*log[-_]bin[[:space:]]*=' "$config_file"; then
    echo "Ya existe una configuracion log-bin. No se duplicaron parametros."
else
    printf '\n[mysqld]\nserver-id=1\nlog-bin=%s\nbinlog_format=ROW\nexpire_logs_days=14\n' "$prefix" | sudo tee -a "$config_file" >/dev/null
    echo "Configuracion de binlog agregada."
fi

echo "Reinicie MySQL para activar los cambios, por ejemplo:"
echo "sudo systemctl restart mysql"
read -r -p 'Presione ENTER para finalizar...' _
