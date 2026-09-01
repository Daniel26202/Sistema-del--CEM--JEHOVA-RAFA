<?php

namespace App\config;

class Cifrado
{

    public static function cifrarRespuesta($data)
    {
        $claveAES = random_bytes(32);
        $iv = random_bytes(16);

        $jsonData = json_encode($data);
        $datosCifrados = openssl_encrypt($jsonData, 'aes-256-cbc', $claveAES, OPENSSL_RAW_DATA, $iv);

        $clavePublica = file_get_contents(__DIR__ . '/../config/keys/encrypt_public.key');
        openssl_public_encrypt(base64_encode($claveAES), $claveAESCifrada, $clavePublica);

        return [
            'data' => base64_encode($datosCifrados),
            'key'  => base64_encode($claveAESCifrada),
            'iv'   => base64_encode($iv),
        ];
    }

    public static function descifrarPeticion($payloadCifrado)
    {
        $clavePrivada = file_get_contents(__DIR__ . '/keys/private.key');

        // Descifrar la clave AES (que llegó en base64, cifrada con RSA)
        $claveAESCifrada = base64_decode($payloadCifrado['key']);
        openssl_private_decrypt($claveAESCifrada, $claveAESBase64, $clavePrivada);
        $claveAES = base64_decode($claveAESBase64);

        // Descifrar el JSON real con esa clave AES
        $iv = base64_decode($payloadCifrado['iv']);
        $datosCifrados = base64_decode($payloadCifrado['data']);
        $jsonPlano = openssl_decrypt($datosCifrados, 'aes-256-cbc', $claveAES, OPENSSL_RAW_DATA, $iv);

        return json_decode($jsonPlano, true);
    }
}
