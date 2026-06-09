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




function verificarLimitePeticiones($conexionPdO, $limiteMaximo, $ventanaSegundos, $idUsuario = null) {
    // 1. Capturar la IP real del cliente detectando proxies
    $ipCliente = '';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ipCliente = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipCliente = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ipCliente = $_SERVER['REMOTE_ADDR'];
    }

    $tiempoActual = time();
    $tiempoLimiteInferior = $tiempoActual - $ventanaSegundos;

    // 2. LIMPIEZA: Eliminar registros viejos para que la tabla no crezca infinitamente
    $consultaLimpieza = $conexionPdO->prepare("
        DELETE FROM control_bloqueo_peticiones 
        WHERE marca_tiempo < :tiempo_limite
    ");
    $consultaLimpieza->execute([':tiempo_limite' => $tiempoLimiteInferior]);

    // 3. CONTEO: Buscar registros bajo la misma IP O el mismo ID de usuario
    if ($idUsuario !== null) {
        // Si el usuario ya se identificó, contamos por su IP o por su ID de cuenta
        $consultaConteo = $conexionPdO->prepare("
            SELECT COUNT(*) FROM control_bloqueo_peticiones 
            WHERE (direccion_ip = :ip OR usuario_id = :usuario_id) 
            AND marca_tiempo >= :tiempo_limite
        ");
        $consultaConteo->execute([
            ':ip' => $ipCliente,
            ':usuario_id' => $idUsuario,
            ':tiempo_limite' => $tiempoLimiteInferior
        ]);
    } else {
        // Si es un intento anónimo (antes de validar quién es), contamos solo por IP
        $consultaConteo = $conexionPdO->prepare("
            SELECT COUNT(*) FROM control_bloqueo_peticiones 
            WHERE direccion_ip = :ip 
            AND marca_tiempo >= :tiempo_limite
        ");
        $consultaConteo->execute([
            ':ip' => $ipCliente,
            ':tiempo_limite' => $tiempoLimiteInferior
        ]);
    }
    
    $totalPeticionesEncontradas = $consultaConteo->fetchColumn();

    // 4. VALIDACIÓN: ¿Superó el límite de ráfaga?
    if ($totalPeticionesEncontradas >= $limiteMaximo) {
        // Obtener el intento más antiguo para calcular cuántos segundos exactos debe esperar
        if ($idUsuario !== null) {
            $consultaAntiguo = $conexionPdO->prepare("
                SELECT MIN(marca_tiempo) FROM control_bloqueo_peticiones 
                WHERE (direccion_ip = :ip OR usuario_id = :usuario_id) 
                AND marca_tiempo >= :tiempo_limite
            ");
            $consultaAntiguo->execute([
                ':ip' => $ipCliente,
                ':usuario_id' => $idUsuario,
                ':tiempo_limite' => $tiempoLimiteInferior
            ]);
        } else {
            $consultaAntiguo = $conexionPdO->prepare("
                SELECT MIN(marca_tiempo) FROM control_bloqueo_peticiones 
                WHERE direccion_ip = :ip 
                AND marca_tiempo >= :tiempo_limite
            ");
            $consultaAntiguo->execute([
                ':ip' => $ipCliente,
                ':tiempo_limite' => $tiempoLimiteInferior
            ]);
        }
        
        $intentoMasAntiguo = $consultaAntiguo->fetchColumn();
        $segundosEspera = $ventanaSegundos - ($tiempoActual - $intentoMasAntiguo);
        
        // Bloquear de inmediato devolviendo error HTTP 429
        http_response_code(429);
        echo json_encode([
            "estatus" => "error",
            "mensaje" => "Límite de peticiones excedido. Por favor, espere $segundosEspera segundos."
        ]);
        exit(); // Detiene la ejecución del script por completo
    }

    // 5. REGISTRO: Si está dentro del límite, guardamos este nuevo impacto
    $consultaInsertar = $conexionPdO->prepare("
        INSERT INTO control_bloqueo_peticiones (direccion_ip, usuario_id, marca_tiempo) 
        VALUES (:ip, :usuario_id, :marca_tiempo)
    ");
    $consultaInsertar->execute([
        ':ip' => $ipCliente,
        ':usuario_id' => $idUsuario, // Puede ser un entero o null
        ':marca_tiempo' => $tiempoActual
    ]);
}

// CREATE TABLE control_bloqueo_peticiones (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     direccion_ip VARCHAR(45) NOT NULL,
//     usuario_id INT NULL, -- NULL si no ha iniciado sesión o falló el intento
//     marca_tiempo INT NOT NULL, -- Timestamp Unix (segundos exactos)
//     KEY idx_ip_tiempo (direccion_ip, marca_tiempo),
//     KEY idx_usuario_tiempo (usuario_id, marca_tiempo)
// );