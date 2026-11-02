<?php

namespace App\config;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Configuración única del envío de correo.
 *
 * Lee las credenciales desde .env y mantiene compatibilidad con las
 * variables anteriores (NameCorreoClinica / PasswordCorreoClinica),
 * de modo que el despliegue no rompe el envío mientras se migran
 * las variables en el contenedor.
 */
class Mailer
{
    public static function crear(): PHPMailer
    {
        $usuario = $_ENV['MAIL_USER'] ?? $_ENV['NameCorreoClinica'] ?? '';
        $clave   = $_ENV['MAIL_PASS'] ?? $_ENV['PasswordCorreoClinica'] ?? '';

        if ($usuario === '' || $clave === '') {
            throw new Exception('Configuración SMTP incompleta: faltan MAIL_USER y MAIL_PASS.');
        }

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = $_ENV['MAIL_HOST'] ?? 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $usuario;
        $mail->Password   = $clave;
        $mail->SMTPSecure = self::cifrado($_ENV['MAIL_ENCRYPTION'] ?? 'tls');
        $mail->Port       = (int) ($_ENV['MAIL_PORT'] ?? 587);
        $mail->CharSet    = 'UTF-8';
        $mail->Timeout    = 15;

        $mail->setFrom(
            $_ENV['MAIL_FROM'] ?? $usuario,
            $_ENV['MAIL_FROM_NAME'] ?? 'Clínica JEHOVA RAFA'
        );

        return $mail;
    }

    private static function cifrado(string $modo): string
    {
        return in_array(strtolower($modo), ['ssl', 'smtps'], true)
            ? PHPMailer::ENCRYPTION_SMTPS
            : PHPMailer::ENCRYPTION_STARTTLS;
    }
}
