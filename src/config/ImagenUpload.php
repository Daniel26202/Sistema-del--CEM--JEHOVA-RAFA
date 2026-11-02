<?php

namespace App\config;

final class ImagenUpload
{
    private const TAMANO_MAXIMO = 5 * 1024 * 1024;
    private const PIXELES_MAXIMOS = 12000000;

    public static function validar(array $archivo): string
    {
        if (($archivo['error'] ?? null) !== UPLOAD_ERR_OK) {
            throw new \InvalidArgumentException('Error al subir la imagen.');
        }

        $rutaTemporal = $archivo['tmp_name'] ?? '';
        if (!is_string($rutaTemporal) || $rutaTemporal === '' || !is_uploaded_file($rutaTemporal)) {
            throw new \InvalidArgumentException('El archivo recibido no es una carga válida.');
        }

        $tamano = filesize($rutaTemporal);
        if ($tamano === false || $tamano === 0) {
            throw new \InvalidArgumentException('El archivo de imagen está vacío.');
        }
        if ($tamano > self::TAMANO_MAXIMO) {
            throw new \InvalidArgumentException('La imagen no debe superar los 5 MB.');
        }

        $contenido = file_get_contents($rutaTemporal);
        if ($contenido === false) {
            throw new \InvalidArgumentException('No se pudo leer el archivo de imagen.');
        }

        return self::validarContenido(
            $contenido,
            strtolower(pathinfo((string)($archivo['name'] ?? ''), PATHINFO_EXTENSION))
        );
    }

    public static function validarContenido(string $contenido, string $extension): string
    {
        $tamano = strlen($contenido);
        if ($tamano === 0) {
            throw new \InvalidArgumentException('El archivo de imagen está vacío.');
        }
        if ($tamano > self::TAMANO_MAXIMO) {
            throw new \InvalidArgumentException('La imagen no debe superar los 5 MB.');
        }

        $extension = strtolower($extension);
        if (!in_array($extension, ['jpg', 'jpeg', 'png'], true)) {
            throw new \InvalidArgumentException('Solo se permiten imágenes JPG o PNG.');
        }

        $mimesPorExtension = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
        ];
        $mimeDetectado = (new \finfo(FILEINFO_MIME_TYPE))->buffer($contenido);
        $infoImagen = @getimagesizefromstring($contenido);

        if (
            $mimeDetectado !== $mimesPorExtension[$extension]
            || $infoImagen === false
            || ($infoImagen['mime'] ?? null) !== $mimeDetectado
            || empty($infoImagen[0])
            || empty($infoImagen[1])
            || $infoImagen[0] * $infoImagen[1] > self::PIXELES_MAXIMOS
        ) {
            throw new \InvalidArgumentException('El archivo no es una imagen JPG o PNG válida.');
        }

        $imagenDecodificada = @imagecreatefromstring($contenido);
        if ($imagenDecodificada === false) {
            throw new \InvalidArgumentException('No se pudo verificar el contenido de la imagen.');
        }

        return $extension;
    }
}
