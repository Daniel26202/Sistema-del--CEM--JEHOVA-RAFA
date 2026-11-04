<?php

namespace Tests;

//proporciona utilidades compartidas para las pruebas unitarias.
trait TestHelpers
{
    /** Id de un usuario real y activo en segurity.usuario. */
    protected static $idUsuarioPrueba = 1;

    /** Arranca la sesión de PHP y fija el usuario autenticado. */
    protected function iniciarSesionDePrueba($idUsuario = null): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            @session_start();
        }
        $_SESSION['id_usuario'] = $idUsuario ?? self::$idUsuarioPrueba;
    }

    /** Cierra la sesión simulada para no contaminar otras pruebas. */
    protected function cerrarSesionDePrueba(): void
    {
        unset($_SESSION['id_usuario']);
    }

    //obtiene el último ID generado para limpiar datos de prueba.
    protected function ultimoIdGenerado(string $db, string $tabla, string $columna)
    {
        $pdo = (new \App\modelos\Db())->connectionSistema();
        $sql = "SELECT MAX($columna) AS ultimo FROM $db.$tabla";
        $stmt = $pdo->query($sql);
        $fila = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $fila['ultimo'] ?? null;
    }

    /** Cambia el estado de un registro directamente en la base. */
    protected function forzarEstado(string $db, string $tabla, string $columna, $id, string $estado, string $colEstado = 'estado'): void
    {
        $pdo = (new \App\modelos\Db())->connectionSistema();
        $sql = "UPDATE $db.$tabla SET $colEstado = :estado WHERE $columna = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['estado' => $estado, 'id' => $id]);
    }

    /** Elimina físicamente un registro creado por una prueba. */
    protected function borrarRegistro(string $db, string $tabla, string $columna, $id): void
    {
        $pdo = (new \App\modelos\Db())->connectionSistema();
        $sql = "DELETE FROM $db.$tabla WHERE $columna = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    /** Returns an existing active provider ID without relying on a seeded ID. */
    protected function idProveedorActivo(): int
    {
        return $this->primerIdActivo('proveedor', 'id_proveedor');
    }

    /** Returns an existing active supply ID without relying on a seeded ID. */
    protected function idInsumoActivo(): int
    {
        return $this->primerIdActivo('insumo', 'id_insumo');
    }

    protected function crearPacienteSintetico(): int
    {
        $pdo = (new \App\modelos\Db())->connectionSistema();
        $stmt = $pdo->prepare('SELECT 1 FROM bd.paciente WHERE cedula = :cedula');

        do {
            $cedula = (string)random_int(70000000, 79999999);
            $stmt->execute(['cedula' => $cedula]);
        } while ($stmt->fetchColumn() !== false);

        $insert = $pdo->prepare(
            "INSERT INTO bd.paciente (nacionalidad, cedula, nombre, apellido, telefono, direccion, fn, genero, estado)
             VALUES ('V', :cedula, 'QA Control Automatizado', 'Sintetico', '0000000000', 'Registro de prueba', '1990-01-01', 'M', 'ACT')"
        );
        $insert->execute(['cedula' => $cedula]);

        return (int)$pdo->lastInsertId();
    }

    protected function borrarPacienteSintetico(int $idPaciente): void
    {
        $pdo = (new \App\modelos\Db())->connectionSistema();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare(
                'DELETE sc FROM bd.sintomas_control sc
                 INNER JOIN bd.control c ON c.id_control = sc.id_control
                 WHERE c.id_paciente = :id_paciente'
            );
            $stmt->execute(['id_paciente' => $idPaciente]);

            $stmt = $pdo->prepare('DELETE FROM bd.control WHERE id_paciente = :id_paciente');
            $stmt->execute(['id_paciente' => $idPaciente]);

            $stmt = $pdo->prepare('DELETE FROM bd.patologiadepaciente WHERE id_paciente = :id_paciente');
            $stmt->execute(['id_paciente' => $idPaciente]);

            $stmt = $pdo->prepare('DELETE FROM bd.paciente WHERE id_paciente = :id_paciente');
            $stmt->execute(['id_paciente' => $idPaciente]);
            $pdo->commit();
        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }

    private function primerIdActivo(string $tabla, string $columna): int
    {
        $permitidos = [
            'proveedor' => 'id_proveedor',
            'insumo' => 'id_insumo',
        ];
        if (!isset($permitidos[$tabla]) || $permitidos[$tabla] !== $columna) {
            throw new \InvalidArgumentException('Tabla o columna no permitida para fixture.');
        }

        $pdo = (new \App\modelos\Db())->connectionSistema();
        $stmt = $pdo->query("SELECT {$columna} FROM bd.{$tabla} WHERE estado = 'ACT' ORDER BY {$columna} LIMIT 1");
        $id = $stmt->fetchColumn();
        if ($id === false) {
            throw new \RuntimeException("No hay registros activos de {$tabla} para la prueba.");
        }
        return (int)$id;
    }
}
