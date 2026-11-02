<?php

//convierte textos UTF-8 a Windows-1252 al generar comprobantes PDF.
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
