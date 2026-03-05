<?php

namespace App\config;

class RateLimiter
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function verificar($identificador,  $limite,  $ventanaEnSegundos)
    {
        $clave = 'rate_limit_' . md5($identificador);
        $ahora = time();

        // Obtener historial
        $intentos = isset($_SESSION[$clave]) ? $_SESSION[$clave] : [];

        // FILTRADO: Esto es lo que desbloquea al usuario. 
        // Solo conserva los intentos realizados dentro del rango de tiempo actual.
        $intentos = array_filter($intentos, function ($timestamp) use ($ahora, $ventanaEnSegundos) {
            return ($ahora - $timestamp) < $ventanaEnSegundos;
        });

        // Verificar si excedió el límite dinámico
        if (count($intentos) >= $limite) {
            $masAntiguo = min($intentos);
            $espera = $ventanaEnSegundos - ($ahora - $masAntiguo);
            throw new \InvalidArgumentException("Límite de peticiones alcanzado. Intente de nuevo en $espera segundos.");
        }

        // Registrar nuevo intento y guardar
        $intentos[] = $ahora;
        $_SESSION[$clave] = $intentos;
    }
}
