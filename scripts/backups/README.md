# Scripts de Respaldo

Los respaldos se ejecutan directamente con las herramientas de MySQL. No dependen de PHP.

## Windows

Ejecutar desde `scripts/backups/windows`:

```text
configurar_binlog.bat
backup_completo.bat
backup_diferencial.bat
restaurar_backup.bat
```

## Linux

Dar permisos una vez:

```bash
chmod +x scripts/backups/linux/*.sh
```

Comandos principales:

```bash
./scripts/backups/linux/configurar_binlog.sh
./scripts/backups/linux/backup_completo.sh
./scripts/backups/linux/backup_diferencial.sh
./scripts/backups/linux/restaurar_backup.sh
```

Los scripts Linux usan `MYSQL_BIN_DIR_LINUX`, `MYSQL_BINLOG_DIR_LINUX`, `BACKUP_DIR_LINUX` y `MYSQL_CONFIG_FILE_LINUX` cuando están configuradas. Si las rutas de binarios, binlogs o backups están vacías, intentan autodetectarlas.

`DB_PASS=` es válido para instalaciones sin contraseña. La variable debe existir aunque su valor esté vacío.

## Programación Linux

Ejemplo de respaldo diferencial cada 15 minutos:

```cron
*/15 * * * * /ruta/al/proyecto/scripts/backups/linux/backup_diferencial.sh >> /var/log/clinica-backup.log 2>&1
```

La restauración es interactiva y no debe programarse automáticamente.
