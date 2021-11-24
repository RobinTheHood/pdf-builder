<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Templates;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;

class Footer implements FooterInterface
{
    private $fontFamily = 'DejaVu';
    private $leftMargin = 20;
    private $posY = -35;

    private $components = [];

    public function addComponent(ComponentInterface $component): void
    {
        $this->components[] = $component;
    }

    public function render(Pdf $pdf): void
    {
        $pdf->SetY($this->posY);
        foreach ($this->components as $component) {
            $component->render($pdf);
        }
    }


    // public function render(Pdf $pdf)
    // {
    //     $pdf->SetFont($this->fontFamily, '', 8);
    //     $left = $this->renderInfoBlock($pdf, 0, 'Footer1', $this->posY);
    //     $left = $this->renderInfoBlock($pdf, $left, 'Footer2', $this->posY);
    //     $left = $this->renderInfoBlock($pdf, $left, 'Footer3', $this->posY);
    //     $left = $this->renderInfoBlock($pdf, $left, 'Footer4', $this->posY);
    // }

    private function renderInfoBlock(Pdf $pdf, $left, $body, $y)
    {
        $pdf->SetFont($this->fontFamily, '', 8);
        $pdf->SetY($y);
        $body_arr = explode("\n", $body);
        $maxlen = $this->maxlen($pdf, $body_arr);
        $pdf->SetX($left + $this->leftMargin);
        $pdf->MultiCell($maxlen, 4, $body, 0);
        return $left + $maxlen;
    }

    private function maxlen($pdf, $strings)
    {
        $max = 0;
        for ($i = 0; $i < count($strings); $i++) {
            if ($pdf->GetStringWidth($strings[$i]) > $max) {
                $max = $pdf->GetStringWidth($strings[$i]);
            }
        }
        return $max + 6;
    }
}
