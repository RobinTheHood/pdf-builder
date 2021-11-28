<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Components;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;
use RobinTheHood\PdfBuilder\Classes\Elements\TextArea;

class Infoblock implements ComponentInterface
{
    private $basePositionX = 125; // Unit: mm
    private $basePositionY = 32; // Unit: mm

    public function render(Pdf $pdf): void
    {
        $pdf->SetDrawColor(255, 0, 0);

        // Hole Component Area
        $pdf->SetXY($this->basePositionX, $this->basePositionY);
        $pdf->Cell(75, 103.46 - 32 - 8.46, '', 1);
    }
}
