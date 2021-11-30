<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;
use RobinTheHood\PdfBuilder\Classes\Elements\Traits\ComponentTrait;
use RobinTheHood\PdfBuilder\Classes\Elements\Traits\ComponentChildTrait;
use RobinTheHood\PdfBuilder\Classes\Elements\Traits\TextTrait;

class Cell implements ComponentInterface
{
    use ComponentTrait;
    use ComponentChildTrait;
    use TextTrait;

    public function calcComponents()
    {
        foreach ($this->components as $component) {
            $component->setCalcedPositionX($this->calcedPositionX + $component->getPositionX());
            $component->setCalcedPositionY($this->calcedPositionX + $component->getPositionY());
        }

        foreach ($this->components as $component) {
            $component->calcComponents();
        }
    }

    public function render(Pdf $pdf): void
    {
        //$pdf->SetFont($this->fontFamily, $this->fontWeight, $this->fontSize);
        //$pdf->Cell($this->dimensionWidth, $this->dimensionHeight, $this->text, PDF::CELL_BORDER_ON, PDF::CELL_NEW_LINE_BELOW);
        $pdf->Rect($this->calcedPositionX, $this->calcedPositionY, $this->dimensionWidth, $this->dimensionHeight);

        foreach ($this->components as $componet) {
            $componet->render($pdf);
        }
    }
}
