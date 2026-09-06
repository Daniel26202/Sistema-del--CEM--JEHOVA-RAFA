#!/usr/bin/env bash
set -Eeuo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(cd "$SCRIPT_DIR/../../.." && pwd)"
ENV_FILE="$PROJECT_ROOT/.env"

if [[ ! -f "$ENV_FILE" ]]; then
    echo "ERROR: No se encontro el archivo .env: $ENV_FILE" >&2
    exit 1
fi

# El .env del proyecto usa pares simples KEY=VALUE y puede contener DB_PASS=.
set -a
# shellcheck disable=SC1090
source "$ENV_FILE"
set +a

if [[ ! -v DB_PASS ]]; then
    echo "ERROR: Falta DB_PASS en el .env. Use DB_PASS= si no hay contrasena." >&2
    exit 1
fi

required_vars=(DB_HOST DB_USER DB_NAME DB_NAME_SEGURITY)
for variable in "${required_vars[@]}"; do
    if [[ -z "${!variable:-}" ]]; then
        echo "ERROR: Falta $variable en el .env." >&2
        exit 1
    fi
done

MYSQL_BIN_DIR="${MYSQL_BIN_DIR_LINUX:-${MYSQL_BIN_DIR:-}}"
if [[ -z "$MYSQL_BIN_DIR" ]]; then
    MYSQL_BIN_DIR="$(dirname "$(command -v mysql 2>/dev/null || true)")"
fi
if [[ -z "$MYSQL_BIN_DIR" || ! -x "$MYSQL_BIN_DIR/mysql" ]]; then
    echo "ERROR: No se encontro mysql en MYSQL_BIN_DIR_LINUX o PATH." >&2
    exit 1
fi

MYSQL_EXE="$MYSQL_BIN_DIR/mysql"
MYSQLDUMP_EXE="$MYSQL_BIN_DIR/mysqldump"
MYSQLBINLOG_EXE="$MYSQL_BIN_DIR/mysqlbinlog"
for executable in "$MYSQLDUMP_EXE" "$MYSQLBINLOG_EXE"; do
    if [[ ! -x "$executable" ]]; then
        echo "ERROR: No se encontro el ejecutable: $executable" >&2
        exit 1
    fi
done

BACKUP_DIR="${BACKUP_DIR_LINUX:-$PROJECT_ROOT/src/config/backups}"
BACKUP_DIR="${BACKUP_DIR/#\~/$HOME}"
mkdir -p "$BACKUP_DIR"

export MYSQL_PWD="${DB_PASS}"
MYSQL_ARGS=(-h "$DB_HOST" -u "$DB_USER")

mysql_query() {
    "$MYSQL_EXE" "${MYSQL_ARGS[@]}" -N -B -e "$1"
}

binlog_dir() {
    if [[ -n "${MYSQL_BINLOG_DIR_LINUX:-}" ]]; then
        printf '%s\n' "$MYSQL_BINLOG_DIR_LINUX"
        return
    fi
    local basename
    basename="$(mysql_query "SHOW VARIABLES LIKE 'log_bin_basename';" | awk 'NR==1 {print $2}')"
    if [[ -z "$basename" ]]; then
        echo "ERROR: No se pudo determinar log_bin_basename." >&2
        return 1
    fi
    dirname "$basename"
}

cleanup() {
    unset MYSQL_PWD
}
trap cleanup EXIT
