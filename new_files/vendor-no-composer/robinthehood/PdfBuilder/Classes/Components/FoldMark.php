<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Components;

use RobinTheHood\PdfBuilder\Classes\Pdf\Pdf;
use RobinTheHood\PdfBuilder\Classes\Elements\Interfaces\ComponentInterface;

class FoldMark implements ComponentInterface
{
    public function render(Pdf $pdf): void
    {
        $foldMark1PosY = 87; // mm
        $foldMark2PosY = 192; // mm
        $holeMarkPosY = 148.5; // mm

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Line(5, $foldMark1PosY, 8, $foldMark1PosY);
        $pdf->Line(5, $holeMarkPosY, 8, $holeMarkPosY);
        $pdf->Line(5, $foldMark2PosY, 8, $foldMark2PosY);
    }
}
