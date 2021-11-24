<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Templates;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;

class Cell implements ComponentInterface
{
    private $text = '';

    private $fontFamily = 'DejaVu';

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function render(Pdf $pdf): void
    {
        $pdf->SetFont($this->fontFamily, '', 8);
        //$pdf->SetX();
        //$pdf->SetY();
        $pdf->Cell(0, 5, $this->text, PDF::CELL_BORDER_ON, PDF::CELL_NEW_LINE);
    }
}
