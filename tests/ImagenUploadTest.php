<?php

use App\config\ImagenUpload;
use PHPUnit\Framework\TestCase;

class ImagenUploadTest extends TestCase
{
    public function testAcceptsAValidPngImage(): void
    {
        $imagen = imagecreatetruecolor(1, 1);
        ob_start();
        imagepng($imagen);
        $contenido = ob_get_clean();

        $this->assertSame('png', ImagenUpload::validarContenido($contenido, 'png'));
    }

    public function testRejectsNonImageContent(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ImagenUpload::validarContenido('esto no es una imagen', 'png');
    }

    public function testRejectsAnImageWithAnIncompatibleExtension(): void
    {
        $imagen = imagecreatetruecolor(1, 1);
        ob_start();
        imagepng($imagen);
        $contenido = ob_get_clean();

        $this->expectException(InvalidArgumentException::class);

        ImagenUpload::validarContenido($contenido, 'jpg');
    }

    public function testRejectsImagesLargerThanFiveMegabytes(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ImagenUpload::validarContenido(str_repeat('x', 5 * 1024 * 1024 + 1), 'png');
    }
}
