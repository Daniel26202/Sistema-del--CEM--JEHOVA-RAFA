<?php

namespace App\config;

class Validations
{
    public static function patientRules($nombre, $apellido, $cedula, $telefono, $direccion, $fn, $genero)
    {
        return [
            ['valor' => $nombre, 'regex' => '/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/', 'mensaje' => "El Nombre debe contener solo letras, iniciar con mayúscula y tener al menos 3 caracteres."],
            ['valor' => $apellido, 'regex' => '/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/', 'mensaje' => "El Apellido debe contener solo letras, iniciar con mayúscula y tener al menos 3 caracteres."],
            ['valor' => $cedula, 'regex' => '/^([1-9]{1})([0-9]{5,7})$/', 'mensaje' => "La cédula debe contener solo números y tener entre 6 y 7 caracteres."],
            ['valor' => $telefono, 'regex' => '/^(0?)(412|414|416|424|426|212|24[1-9]|25[1-9])\d{7}$/', 'mensaje' => 'El teléfono debe comenzar con un código válido y contener solo números.'],
            ['valor' => $direccion, 'regex' => '/^([A-Za-z0-9\s\.,#-]{8,})$/', 'mensaje' => "La dirección debe estar completa y detallada."],
            ['valor' => $fn, 'regex' => '/^\d{4}-\d{2}-\d{2}$/', 'mensaje' => "Fecha de nacimiento inválida: debe estar en formato YYYY-MM-DD."],
            ['valor' => $genero, 'regex' => '/^(Masculino|Femenino)$/i', 'mensaje' => "Género inválido: debe ser 'Masculino' o 'Femenino'."]
        ];
    }

    public static function pathologyRules($patologia)
    {
        return [
            [
                'valor' => $patologia,
                'regex' => '/^([A-ZÁÉÍÓÚÑa-záéíóúñ0-9]+(\s[A-ZÁÉÍÓÚÑa-záéíóúñ0-9]+)*)$/',
                'mensaje' => "La especialidad debe contener solo letras, números y espacios, sin símbolos especiales."
            ]
        ];
    }

    public static function priceRules($precio){
        return [
            [
                'valor' => $precio,
                'regex' => '/^(\d{1,3}\.\d{3}.\d{2}|\d{1,3}.\d{2})$/',
                'mensaje' => "El formato del precio es incorrecto, Ejemplo 0,00 - 00,00 - 000,00 - 0.000,00."
            ]
        ];
    }



    public static function supplyRules($imagen = null, $nombre, $descripcion, $cantidad = null, $precio = null, $fechaDeVencimiento = null, $stockMinimo, $lote = null, $marca, $medida)
    {
        $rules = [
           
            [
                'valor' => $nombre,
                'regex' => '/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/',
                'mensaje' => 'El nombre debe comenzar con mayúscula y tener al menos 3 letras.'
            ],
            [
                'valor' => $descripcion,
                'regex' => '/^([a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,;:!?\'-]{5,})$/',
                'mensaje' => 'La descripción debe tener al menos 5 caracteres y puede incluir puntuación básica.'
            ],
            [
                'valor' => $stockMinimo,
                'regex' => '/^([1-9]{1})([0-9]{1})?$/',
                'mensaje' => 'El stock mínimo debe ser un número mayor a 0.'
            ],
            [
                'valor' => $marca,
                'regex' => '/^[A-ZÁÉÍÓÚÑ\s][a-záéíóúñ\s\d]{4,16}$/',
                'mensaje' => 'La marca debe comenzar con mayúscula y tener entre 5 y 17 caracteres.'
            ],
            [
                'valor' => $medida,
                'regex' => '/^\d+\s?(ml|L|g|kg|m|cm|mm)$/',
                'mensaje' => 'La medida debe incluir una cantidad seguida de una unidad válida (ml, L, g, etc.).'
            ]
        ];

        // Campos opcionales
        if (!empty($imagen)) {
            $rules[] = [
                'valor' => $imagen,
                'regex' => '/^.*\.(jpg|jpeg|png|gif)$/i',
                'mensaje' => 'El archivo de imagen debe ser una imagen válida (jpg, jpeg, png, gif).'
            ];
        }

        if (!empty($cantidad)) {
            $rules[] = [
                'valor' => $cantidad,
                'regex' => '/^([1-9]{1})([0-9]{1,4})?$/',
                'mensaje' => 'La cantidad debe ser un número entre 1 y 99999.'
            ];
        }

        if (!empty($precio)) {
            $rules[] = [
                'valor' => $precio,
                'regex' => '/^(\d{1,3}\.\d{3}\.\d{2}|\d{1,3}\.\d{2})$/',
                'mensaje' => 'El precio debe tener formato válido, como 123.456.78 o 123.45.'
            ];
        }

        if (!empty($fechaDeVencimiento)) {
            $rules[] = [
                'valor' => $fechaDeVencimiento,
                'regex' => '/^\d{4}\-\d{2}\-\d{2}$/',
                'mensaje' => 'La fecha debe estar en formato YYYY-MM-DD.'
            ];
        }

        if (!empty($lote)) {
            $rules[] = [
                'valor' => $lote,
                'regex' => '/^[0-9-_]{4,10}$/',
                'mensaje' => 'El lote debe tener entre 4 y 10 caracteres, solo números, guiones o guiones bajos.'
            ];
        }

        return $rules;
    }
    

}
