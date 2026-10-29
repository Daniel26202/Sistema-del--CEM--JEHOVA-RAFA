<?php

/**
 * FPDF trabaja con las fuentes core en Latin-1 (Windows-1252), pero la
 * aplicación entrega los textos en UTF-8. Sin convertir, el comprobante
 * mostraba "HernadÃ©z" en lugar de "Hernadéz".
 *
 * Esta subclase centraliza la conversión en Cell() y MultiCell() para que las
 * vistas de los comprobantes no tengan que envolver cada llamada.
 */
if (!class_exists('FacturaPdf')) {
    class FacturaPdf extends FPDF
    {
        public function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
        {
            parent::Cell($w, $h, $this->aWin1252($txt), $border, $ln, $align, $fill, $link);
        }

        public function MultiCell($w, $h, $txt, $border = 0, $align = 'J', $fill = false)
        {
            parent::MultiCell($w, $h, $this->aWin1252($txt), $border, $align, $fill);
        }

        private function aWin1252($txt)
        {
            if (!is_string($txt) || $txt === '') {
                return $txt;
            }

            $convertido = mb_convert_encoding($txt, 'Windows-1252', 'UTF-8');

            return $convertido === '' ? $txt : $convertido;
        }
    }
}
