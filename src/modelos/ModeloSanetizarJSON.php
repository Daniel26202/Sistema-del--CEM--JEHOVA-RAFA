<?php

namespace App\modelos;

class ModeloSanetizarJSON
{
    //claves a exluir de la sanetizacion
    private array $skipKeys = [];

    
    public function setSkipKeys(array $keys): self
    {
        $this->skipKeys = $keys;
        return $this;
    }

    //sanitiza un string aplicando htmlspecialchars

    private function sanitizeString(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    // sanitización recursiva (para arrays anidados)
    public function sanitizeRecursive($data)
    {
        // Si es array, procesamos cada elemento
        if (is_array($data)) {
            $result = [];
            foreach ($data as $key => $value) {
                if (in_array($key, $this->skipKeys, true)) {
                    $result[$key] = $value;
                } else {
                    $result[$key] = $this->sanitizeRecursive($value);
                }
            }
            return $result;
        }

        // si es objeto, lo convertimos a array y procesamos
        if (is_object($data)) {
            $array = (array) $data;
            $result = [];
            foreach ($array as $key => $value) {
                if (in_array($key, $this->skipKeys, true)) {
                    $result[$key] = $value;
                } else {
                    $result[$key] = $this->sanitizeRecursive($value);
                }
            }
            return (object) $result;
        }

        // si es string, sanitizamos
        if (is_string($data)) {
            return $this->sanitizeString($data);
        }

        // si es numérico, convertimos
        if (is_numeric($data)) {
            return $data + 0;
        }

        // booleanos, null y otros se devuelven sin cambios
        return $data;
    }
}
