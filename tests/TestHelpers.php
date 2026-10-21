<?php

namespace Tests;

/**
 * Utilidades compartidas por la suite de pruebas unitarias.
 *
 * Los modelos del sistema validan que exista una sesión autenticada
 * ($_SESSION['id_usuario']) o que se les pase el id del usuario por
 * parámetro. Estas pruebas son unitarias (sin navegador), así que se
 * simula esa sesión con un usuario real de la base de datos.
 */
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

    /**
     * Devuelve el ÚLTIMO id generado en una tabla (la unidad de trabajo
     * de la prueba). Se usa para restaurar/limpiar el dato creado y que
     * la suite sea idempotente.
     */
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
}
